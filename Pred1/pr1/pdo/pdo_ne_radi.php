<?php
try { 
    //Stvori PDO objekt
    $pdo = new PDO('mysql:dbname=test;host=localhost', 'username', 'password');

    // Obriši objekt
    unset($pdo);

} catch (PDOException $e) { 
    //Hvatanje iznimke
    echo '<p>Dogodila se iznimka: ' . $e->getMessage() . '</p>';
}
?>
