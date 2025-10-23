<?php 
//Skripta prima cijene dionica sa Yahoo
if (isset($_GET['symbol']) && !empty($_GET['symbol'])) { 

    //URL
    $url = sprintf('http://quote.yahoo.com/d/quotes.csv?s=%s&f=nl1', $_GET['symbol']);

    //Konekcija na URL
    $fp = fopen($url, 'r');
        
    //Dohvat podataka
    $read = fgetcsv($fp);
    
    //Zatvaramo konekciju to jest datoteku
    fclose($fp);
    
    //Provjeri simbole
    if (strcasecmp($read[0], $_GET['symbol']) !== 0) {

        //Ispis rezultata
        echo '<div>Zadnja vrijednost za <span>' . $read[0] . '</span> (<span class="quote">' . $_GET['symbol'] . '</span>) je $<span>' . $read[1] . '</span>.</div>';
        
    } else {
        echo '<div class="error">Invalid symbol!</div>';
    }

} // End of form submission IF.

// Show the form:
?><form action="Curl_stock.php" method="get">
    <fieldset>
        <legend>Unesi NYSE stock simbol kako bi dobili zadnju cijenu:</legend>
        <p><label for="symbol">Simbol</label>: <input type="text" name="symbol" size="5" maxlength="5"></p>
        <p><input type="submit" name="submit" value="Dohvati!" /></p>
    </fieldset>
</form>
