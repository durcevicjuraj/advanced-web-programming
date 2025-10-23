<?php 
//IP Geolocation request
function show_ip_info($ip) { 
    
    //Besplatna registracija za vlastiti api key
    $api_key = 'at_P0Eei4pKMjqB66SS1dtCI01Sttcty';
    //URL na koji se spajamo
    $api_url = 'https://geo.ipify.org/api/v1'; 
    $url = "{$api_url}?apiKey={$api_key}&ipAddress={$ip}";   
    //Otvori konekciju
    $fp = fopen($url, 'r');
    //dohvati podatke
    $read = fgetcsv($fp);     
    //var_dump($read); 
    //Zatvori konekciju
    fclose($fp);

    //Ispis podatka
    echo "<p>IP Adresa: $ip<br>
    Zemlja: $read[1]<br>
    Grad: $read[3], $read[2]<br>
    Zemljopisna širina: $read[4]<br>
    Zemljopisna dužina: $read[5]</p>";

} 

//Klijentova IP adresa
echo '<h2>Informacije o Vama</h2>';
show_ip_info($_SERVER['REMOTE_ADDR']);

//Informacije o nekoj stranici
$url = 'www.ferit.unios.hr';
echo "<h2>Informacije o $url</h2>";
show_ip_info(gethostbyname($url));

//Informacije o nekoj stranici
$url = 'www.google.com';
echo "<h2>Informacije o $url</h2>";
show_ip_info(gethostbyname($url));

?>
