<?php
require('includes/utilities.inc.php');

try {
    
    // Validacija
    if (!isset($_GET['id']) || !filter_var($_GET['id'], FILTER_VALIDATE_INT, array('min_range' => 1))) {
        throw new Exception('Ne postoji stranica s ovim ID-em.');
    }
    
    //Dohvati stranicu iz baze podataka
    $q = 'SELECT id, creatorId, title, content, DATE_FORMAT(dateAdded, "%e %M %Y") AS dateAdded FROM pages WHERE id=:id'; 
    $stmt = $pdo->prepare($q);
    $r = $stmt->execute(array(':id' => $_GET['id']));

    //Dohvati i spremi u objekt
    if ($r) {
        $stmt->setFetchMode(PDO::FETCH_CLASS, 'Page');
        $page = $stmt->fetch();
        
        //Ako postoji stranica
        if ($page) {
   
            //Postavi naslov u pregledniku
            $pageTitle = $page->getTitle();
   
            //Stvori stranicu
            include('includes/header.inc.php');
            include('views/page.html');
            
        } else {
            throw new Exception('Pogrešan ID za stranicu.');
        }
    
    } else {
        throw new Exception('Pogrešan ID za stranicu.');       
    }

} catch (Exception $e) { //Iznimke

    $pageTitle = 'Pogreška!';
    include('includes/header.inc.php');
    include('views/error.html');

}

//Uključi podnožje
include('includes/footer.inc.php');
?>