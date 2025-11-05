<?php
/*
Setup za zadatak 2 - kriptiranje dokumenata
*/

echo "<h2>Setup za Zadatak 2</h2>";

// Kreiraj direktorije
$dirs = [
    'uploads_encrypted' => 'Za kriptirane dokumente',
    'temp_decrypted' => 'Za privremeno dekriptirane dokumente'
];

foreach ($dirs as $dir => $description) {
    if (!is_dir($dir)) {
        if (mkdir($dir, 0777, true)) {
            echo "<p>✓ Kreiran direktorij: <strong>$dir/</strong> - $description</p>";
        } else {
            echo "<p>✗ Greška pri kreiranju: $dir/</p>";
        }
    } else {
        echo "<p>✓ Direktorij <strong>$dir/</strong> već postoji</p>";
    }
}

// Provjeri OpenSSL
if (extension_loaded('openssl')) {
    echo "<p>✓ OpenSSL ekstenzija je omogućena</p>";
    
    // Prikaži dostupne cipher metode
    $ciphers = openssl_get_cipher_methods();
    echo "<p>✓ Dostupno " . count($ciphers) . " cipher metoda</p>";
    
    // Provjeri ima li AES-128-CTR (koristimo u zadatku)
    if (in_array('AES-128-CTR', $ciphers)) {
        echo "<p>✓ AES-128-CTR cipher je dostupan</p>";
    }
} else {
    echo "<p>✗ OpenSSL ekstenzija NIJE omogućena!</p>";
}

echo "<hr>";
echo "<h3>✅ Setup završen!</h3>";
echo "<p>Možete nastaviti sa izradom upload forme.</p>";
?>