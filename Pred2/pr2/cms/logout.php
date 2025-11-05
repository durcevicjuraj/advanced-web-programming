<?php 
require('includes/utilities.inc.php');

//Ako ima korisnika
if ($user) {
    
    //Obriši varijablu
    $user = null;
    
    //Obriši sesiju
    $_SESSION = array();
    
    //Obriši cookie
    setcookie(session_name(), false, time()-3600);
    
    //uništi sesiju
    session_destroy();
    
} 


$pageTitle = 'Logout';
include('includes/header.inc.php');

//Uključi pogled
include('views/logout.html');


include('includes/footer.inc.php');
?>