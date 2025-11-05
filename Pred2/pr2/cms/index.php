<?php 
require('includes/utilities.inc.php');

//Uključi zaglavlje
$pageTitle = 'Dobro došli!';
include('includes/header.inc.php');

//Dohvati zadnje tri stranice to jest objave
try {
    
    $q = 'SELECT id, title, content, DATE_FORMAT(dateAdded, "%e %M %Y") AS dateAdded FROM pages ORDER BY dateAdded LIMIT 3'; 
    $r = $pdo->query($q);
    
    //Ima li redova
    if ($r && $r->rowCount() > 0) {

        //Dohvat
        $r->setFetchMode(PDO::FETCH_CLASS, 'Page');

        //Ubaci ih u pogled
        include('views/index.html');

    } else { // Problem!
        throw new Exception('No content is available to be viewed at this time.');
    }
        
} catch (Exception $e) { //Dohvat iznimki
    include('views/error.html');
}

// uključi podnožje
include('includes/footer.inc.php');
?>