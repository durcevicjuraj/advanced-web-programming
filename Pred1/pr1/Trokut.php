<!doctype html>
<html>
<body>
<?php 
require('class_Oblik.php');
require('class_Trokut.php');

$stranica1 = 5;   $stranica2 = 10;   $stranica3 = 13; 
   
// Stvaramo novi trokut
$t = new Trokut($stranica1, $stranica2, $stranica3);

echo '<p>Površina je ' . $t->Povrsina() . '</p>';    
echo '<p>Opseg je ' . $t->Opseg() . '</p>';

//Brišemo objekt
unset($t);
?>
</body>
