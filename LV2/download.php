<?php
$encryption_key = hash('sha256', 'moj_tajni_kljuc_2024');
$cipher = 'AES-256-CBC';

// Dohvati encrypted filename iz URL-a
$encrypted_file = $_GET['file'] ?? '';

if (empty($encrypted_file)) {
    die("Greška: Nema datoteke");
}

$encrypted_path = "uploads_encrypted/$encrypted_file";

if (!file_exists($encrypted_path)) {
    die("Greška: Datoteka ne postoji");
}

// Dohvati metadata
$meta_file = str_replace('doc_', 'meta_', $encrypted_file);
$meta_file = str_replace('.enc', '.json', $meta_file);
$meta_path = "uploads_encrypted/$meta_file";

if (!file_exists($meta_path)) {
    die("Greška: Metadata ne postoji");
}

$meta = json_decode(file_get_contents($meta_path), true);

// Učitaj kriptirane podatke
$encrypted_data = file_get_contents($encrypted_path);

// Odvoji IV od podataka (IV je na početku)
$iv_length = $meta['iv_length'];
$iv = substr($encrypted_data, 0, $iv_length);
$encrypted_content = substr($encrypted_data, $iv_length);

// Dekriptiraj
$decrypted = openssl_decrypt($encrypted_content, $cipher, $encryption_key, OPENSSL_RAW_DATA, $iv);

if ($decrypted === false) {
    die("Greška pri dekriptiranju");
}

// Postavi headers za download
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename="' . $meta['original_name'] . '"');
header('Content-Length: ' . strlen($decrypted));

// Šalji dekriptirane podatke
echo $decrypted;
?>