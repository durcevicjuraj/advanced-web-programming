<?php 
try { 
    //Stvori PDO objekt
    $pdo = new PDO('mysql:dbname=test;host=localhost', 'root', '');    
    echo '<form action="dodaj_zadatak.php" method="post">
    <fieldset>
        <legend>Dodaj zadatak</legend>
        <p>Zadatak: <input name="zadatak" type="text" size="60" maxlength="100"></p>
        <p>Roditeljski zadatak: <select name="roditelj_id"><option value="0">Nema</option>';
    
    // Upit
    $q = 'SELECT * FROM zadaci WHERE datum_zavrsetka="0000-00-00 00:00:00" ORDER BY datum_dodavanja ASC'; 
    $r = $pdo->query($q);     
    // Psotavi u mod dohvata
    $r->setFetchMode(PDO::FETCH_NUM);    
    // Ispis rezultata
    while ($row = $r->fetch()) {
       echo "<option value=\"$row[0]\">$row[2]</option>\n";
    }        
    echo '</select></p>  
    <input name="submit" type="submit" value="Dodaj zadatak">
    </fieldset>
    </form>';  
       
    // Obriši objekt
    unset($pdo);

} catch (PDOException $e) { 
    //Hvatanje iznimke
    echo '<p>Dogodila se iznimka: ' . $e->getMessage() . '</p>';
}
?>

