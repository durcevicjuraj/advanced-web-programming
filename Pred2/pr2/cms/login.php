<?php 
require('includes/utilities.inc.php');


set_include_path(get_include_path() . PATH_SEPARATOR . '/usr/local/pear/share/pear/');
require('HTML/QuickForm2.php');
$form = new HTML_QuickForm2('loginForm');

//Polje email
$email = $form->addElement('text', 'email');
$email->setLabel('Email adresa');
$email->addFilter('trim');
$email->addRule('required', 'Molimo unesite email adresu.');
$email->addRule('email', 'Molimo unesite email adresu.');


$password = $form->addElement('password', 'pass');
$password->setLabel('Lozinka');
$password->addFilter('trim');
$password->addRule('required', 'Molimo unesite lozinku.');


$form->addElement('submit', 'submit', array('value'=>'Login'));

//Slanje forme
if ($_SERVER['REQUEST_METHOD'] == 'POST') { // Handle the form submission
    
    // Validacija
    if ($form->validate()) {
        
        //Provjera u bazi
        $q = 'SELECT id, userType, username, email FROM users WHERE email=:email AND pass=SHA1(:pass)';
        $stmt = $pdo->prepare($q);
        $r = $stmt->execute(array(':email' => $email->getValue(), ':pass' => $password->getValue()));

        //Dohvat rezultata
        if ($r) {
            $stmt->setFetchMode(PDO::FETCH_CLASS, 'User');
            $user = $stmt->fetch();
        }
        
        // Spremi u sesiju i preusmjeri
        if ($user) {
    
            $_SESSION['user'] = $user;
    
            header("Location:index.php");
            exit;
    
        }
        
    } 
    
} 

//Prikaz login stranice
$pageTitle = 'Login';
include('includes/header.inc.php');
include('views/login.html');
include('includes/footer.inc.php');
?>