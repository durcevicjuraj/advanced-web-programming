<?php 
/*Kriptiranje podataka i spremanje u session varijable*/
session_start(); ?>
<?php
//Ključ za enkripciju
$encryption_key = md5('jed4n j4k0 v3l1k1 kljuc');

//Podaci za enkripciju
$data = 'Ovo su podaci koje želimo kriptirati i korisnik je dodao...';

//Odaber cipher metodu AES
$cipher = "AES-128-CTR";

//Stvori IV sa ispravnom dužinom
$iv_length = openssl_cipher_iv_length($cipher); 
$options = 0; 
  
// Non-NULL inicijalizacijski vektor za enkripciju 
//Random dužine 16 byte
$encryption_iv = random_bytes($iv_length);  
  
// Kriptiraj podatke sa openssl 
$data = openssl_encrypt($data, $cipher, 
            $encryption_key, $options, $encryption_iv); 

//Spremi podatke
$_SESSION['podaci'] = base64_encode($data);
$_SESSION['iv'] = $encryption_iv;

//Ispiši kriptirane podatke
echo '<p>Kriptirani podaci su: ' . base64_encode($data) . '.</p>';

?>