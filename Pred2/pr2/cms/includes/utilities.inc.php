<?php 
// Autoload klasa iz direktorija classes
function class_loader($class) {
    require('classes/' . $class . '.php');
}
//Registriramo gornju funkciju za autoload
spl_autoload_register('class_loader');

// Start sesije
session_start();

//Ima li korisnik sesijsku varijablu
$user = (isset($_SESSION['user'])) ? $_SESSION['user'] : null;

//Konekcija na bazu kao PDO objekt
try { 

    //Stvori novi objekt
    $pdo = new PDO('mysql:dbname=cms;host=localhost', 'root', '');

} catch (PDOException $e) { // Ako se dogodi pogreška
    
    $pageTitle = 'Error!';
    include('includes/header.inc.php');
    include('views/error.html');
    include('includes/footer.inc.php');
    exit();
    
}