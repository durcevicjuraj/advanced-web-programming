<?php 
require('class_Debug.php');
require('class_Oblik.php');
require('class_Trokut.php');

// Stvori novi objekt
$r = new Trokut(4,5,7);
// Ispis podataka:
$r->dumpObject();

?>
