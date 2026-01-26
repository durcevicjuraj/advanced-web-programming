var express = require('express');
var router = express.Router();
var mongoose = require('mongoose');
var bcrypt = require('bcrypt');

// GET register page
router.get('/register', function(req, res) {
  res.render('auth/register', { title: 'Register' });
});

// POST register
router.post('/register', async function(req, res) {
  try {
    var hashedPassword = await bcrypt.hash(req.body.password, 10);
    await mongoose.model('User').create({
      username: req.body.username,
      password: hashedPassword,
      email: req.body.email
    });
    res.redirect('/auth/login');
  } catch (err) {
    res.render('auth/register', {
      title: 'Register',
      error: 'Registration failed: ' + err.message
    });
  }
});

// GET login page
router.get('/login', function(req, res) {
  res.render('auth/login', { title: 'Login' });
});

// POST login
router.post('/login', async function(req, res) {
  try {
    var user = await mongoose.model('User').findOne({ username: req.body.username });
    if (!user) {
      return res.render('auth/login', { title: 'Login', error: 'User not found' });
    }
    var validPassword = await bcrypt.compare(req.body.password, user.password);
    if (!validPassword) {
      return res.render('auth/login', { title: 'Login', error: 'Invalid password' });
    }
    req.session.userId = user._id;
    req.session.username = user.username;
    res.redirect('/projects');
  } catch (err) {
    res.render('auth/login', { title: 'Login', error: 'Login failed: ' + err.message });
  }
});

// GET logout
router.get('/logout', function(req, res) {
  req.session.destroy();
  res.redirect('/auth/login');
});

module.exports = router;
