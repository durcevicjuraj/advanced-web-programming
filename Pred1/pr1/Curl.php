<h2>cURL Rezultati:</h2>
<?php
$url = 'http://localhost/pr1/service.php';
//Pokrećemo cURL spoj
$curl = curl_init($url);   
//Zaustavi ako se dogodi pogreška
curl_setopt($curl, CURLOPT_FAILONERROR, 1); 
//Dozvoli preusmjeravanja
curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
//Spremi vraćene podatke u varijablu
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
//Postavi timeout
curl_setopt($curl, CURLOPT_TIMEOUT, 5);
//Koristi POST metodu
curl_setopt($curl, CURLOPT_POST, 1);
//Postavi POST podatke
curl_setopt($curl, CURLOPT_POSTFIELDS, 'name=Pero&pass=nekalozinka&format=json');

//Izvrši transakciju
$r = curl_exec($curl);

//Zatvori spoj
curl_close($curl);

//ispiši rezultate
print_r($r);

?>
