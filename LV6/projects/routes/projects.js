var express = require('express');
var router = express.Router();
var mongoose = require('mongoose');
var bodyParser = require('body-parser');
var methodOverride = require('method-override');

router.use(bodyParser.urlencoded({ extended: true }));
router.use(methodOverride(function(req, res){
  if (req.body && typeof req.body === 'object' && '_method' in req.body) {
    var method = req.body._method;
    delete req.body._method;
    return method;
  }
}));

// GET all projects
router.route('/')
  .get(async function(req, res, next) {
    try {
      const projects = await mongoose.model('Project').find({});
      res.format({
        html: function(){
          res.render('projects/index', {
            title: 'All Projects',
            "projects" : projects
          });
        },
        json: function(){
          res.json(projects);
        }
      });
    } catch (err) {
      console.error(err);
      next(err);
    }
  })
  // POST new project
  .post(async function(req, res) {
    try {
      const project = await mongoose.model('Project').create({
        name : req.body.name,
        description : req.body.description,
        price : req.body.price,
        completedTasks : req.body.completedTasks,
        startDate : req.body.startDate,
        endDate : req.body.endDate,
        teamMembers : []
      });
      console.log('POST creating new project: ' + project);
      res.format({
        html: function(){
          res.location("projects");
          res.redirect("/projects");
        },
        json: function(){
          res.json(project);
        }
      });
    } catch (err) {
      res.send("There was a problem adding the information to the database: " + err);
    }
  });

// GET new project form (must be before /:id routes)
router.get('/new', function(req, res) {
  res.render('projects/new', { title: 'Add New Project' });
});

// Validate :id parameter
router.param('id', async function(req, res, next, id) {
  try {
    const project = await mongoose.model('Project').findById(id);
    if (!project) {
      console.log(id + ' was not found');
      res.status(404);
      var err = new Error('Not Found');
      err.status = 404;
      res.format({
        html: function(){
          next(err);
        },
        json: function(){
          res.json({message : err.status  + ' ' + err});
        }
      });
    } else {
      req.id = id;
      next();
    }
  } catch (err) {
    console.log(id + ' was not found');
    res.status(404);
    var error = new Error('Not Found');
    error.status = 404;
    res.format({
      html: function(){
        next(error);
      },
      json: function(){
        res.json({message : error.status  + ' ' + error});
      }
    });
  }
});

// GET form to add team member (must be before /:id routes)
router.get('/:id/addmember', async function(req, res) {
  try {
    const project = await mongoose.model('Project').findById(req.id);
    res.render('projects/addmember', {
      title: 'Add Team Member',
      "project" : project
    });
  } catch (err) {
    console.log('GET Error: There was a problem retrieving: ' + err);
    res.status(500).send('Error retrieving project');
  }
});

// POST add team member
router.post('/:id/addmember', async function(req, res) {
  try {
    const project = await mongoose.model('Project').findById(req.id);
    project.teamMembers.push(req.body.memberName);
    await project.save();
    res.redirect("/projects/" + project._id);
  } catch (err) {
    res.send("There was a problem adding the team member: " + err);
  }
});

// GET edit form and PUT update (must be before /:id route)
router.route('/:id/edit')
  .get(async function(req, res) {
    try {
      const project = await mongoose.model('Project').findById(req.id);
      console.log('GET Retrieving ID: ' + project._id);
      var startDate = project.startDate ? project.startDate.toISOString().substring(0, 10) : '';
      var endDate = project.endDate ? project.endDate.toISOString().substring(0, 10) : '';
      res.format({
        html: function(){
          res.render('projects/edit', {
            title: 'Project ' + project._id,
            "startDate" : startDate,
            "endDate" : endDate,
            "project" : project
          });
        },
        json: function(){
          res.json(project);
        }
      });
    } catch (err) {
      console.log('GET Error: There was a problem retrieving: ' + err);
      res.status(500).send('Error retrieving project');
    }
  })
  // PUT update project
  .put(async function(req, res) {
    try {
      const project = await mongoose.model('Project').findByIdAndUpdate(req.id, {
        name : req.body.name,
        description : req.body.description,
        price : req.body.price,
        completedTasks : req.body.completedTasks,
        startDate : req.body.startDate,
        endDate : req.body.endDate
      }, { new: true });
      res.format({
        html: function(){
          res.redirect("/projects/" + project._id);
        },
        json: function(){
          res.json(project);
        }
      });
    } catch (err) {
      res.send("There was a problem updating the information to the database: " + err);
    }
  });

// GET single project and DELETE (these come LAST)
router.route('/:id')
  .get(async function(req, res) {
    try {
      const project = await mongoose.model('Project').findById(req.id);
      console.log('GET Retrieving ID: ' + project._id);
      var startDate = project.startDate ? project.startDate.toISOString().substring(0, 10) : '';
      var endDate = project.endDate ? project.endDate.toISOString().substring(0, 10) : '';
      res.format({
        html: function(){
          res.render('projects/show', {
            "startDate" : startDate,
            "endDate" : endDate,
            "project" : project
          });
        },
        json: function(){
          res.json(project);
        }
      });
    } catch (err) {
      console.log('GET Error: There was a problem retrieving: ' + err);
      res.status(500).send('Error retrieving project');
    }
  })
  // DELETE project
  .delete(async function (req, res){
    try {
      const project = await mongoose.model('Project').findByIdAndDelete(req.id);
      console.log('DELETE removing ID: ' + project._id);
      res.format({
        html: function(){
          res.redirect("/projects");
        },
        json: function(){
          res.json({message : 'deleted', item : project});
        }
      });
    } catch (err) {
      console.error(err);
      res.status(500).send('Error deleting project');
    }
  });

module.exports = router;
