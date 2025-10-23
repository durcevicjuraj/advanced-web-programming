<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>OOP in PHP</title>
        <?php include("class_osoba.php"); ?>
    </head>
    <body>
        <?php 
          $Marko = new osoba('');
          //$Djuro = new osoba(); 
          $Djuro = new osoba("Djuro S. Zlikovski"); 
          
          //Postavljanje varijabli
          $Marko->postavi_ime("Marko Marić");
          //$Djuro->postavi_ime("Djuro S. Zlikovski");
          //Dohvat Varijabli
          echo "Ime osobe Marko je: " . $Marko->dohvati_ime();
          echo "<br>Ime osoba Djuro je: " . $Djuro->dohvati_ime();        
        ?>
    </body>
</html> 
