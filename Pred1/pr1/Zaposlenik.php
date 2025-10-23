<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>OOP in PHP</title>
        <?php include("class_zaposlenik.php"); ?>
    </head>
    <body>
        <?php  
          $Djuro = new zaposlenik("Nepoznato"); 
          //$Djuro->postavi_ime("Djuro S. Zlikovski"); 
          
          echo "Ime zaposlenika je: " . $Djuro->dohvati_ime();        
        ?>
    </body>
</html> 
