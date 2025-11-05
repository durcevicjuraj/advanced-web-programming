<?php
/*Dekripcija podataka sa MCrypt*/
session_start(); 

//Postoje li kriptirani podaci
if (isset($_SESSION['podaci'], $_SESSION['iv'])) {
	//Stvori ključ
	$decryption_key = md5('jed4n j4k0 v3l1k1 kljuc');
	
	//Odaber cipher metodu AES
  $cipher = "AES-128-CTR";  
  $options = 0;    
	
  // Non-NULL inicijalizacijski vektor za enkripciju 
  $decryption_iv = $_SESSION['iv']; 
  $data = base64_decode($_SESSION['podaci']);
	
	// Dekriptiraj podatke:
	$data=openssl_decrypt ($data, $cipher,  
        $decryption_key, $options, $decryption_iv);
	
	//Ispiši podatke
	echo '<p>Dekriptirani podaci su "' . trim($data) . '".</p>';

} else {
	echo '<p>Nema podataka.</p>';
}
?>