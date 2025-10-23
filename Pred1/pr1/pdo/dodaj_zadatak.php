<?php
$pdo = new PDO('mysql:dbname=test;host=localhost', 'root', '');
//var_dump($_SERVER);
 if (($_SERVER['REQUEST_METHOD'] == 'POST') && !empty($_POST['zadatak'])) {
        if (isset($_POST['roditelj_id']) && 
        filter_var($_POST['roditelj_id'], FILTER_VALIDATE_INT, array('min_range' => 1)) ) {
           $roditelj_id = $_POST['roditelj_id'];
        } else {
           $roditelj_id = 0;
        }
        
        // Unos u bazu podatala
        $q = 'INSERT INTO zadaci (roditelj_id, zadatak) VALUES (:roditelj_id, :zadatak)';
        $stmt = $pdo->prepare($q);

        //Izvrši upit
        if ($stmt->execute(array(':roditelj_id' => $roditelj_id, ':zadatak' => $_POST['zadatak']))) {
            echo '<p>Zadatak je dodan!</p>';
        } else {
            echo '<p>Zadatak nije dodan!</p>';
        }

    }
?>
