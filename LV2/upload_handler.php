<?php
// Postavke kriptiranja
$encryption_key = hash('sha256', 'moj_tajni_kljuc_2024');
$cipher = 'AES-256-CBC';

// Provjera uploada
if ($_SERVER['REQUEST_METHOD'] != 'POST' || !isset($_FILES['dokument'])) {
    die("Greška: Neispravan zahtjev");
}

$file = $_FILES['dokument'];

// Provjera greške
if ($file['error'] !== UPLOAD_ERR_OK) {
    die("Greška pri uploadu");
}

// Validacija tipa
$ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
if (!in_array($ext, ['pdf', 'jpg', 'jpeg', 'png'])) {
    die("Nedozvoljen tip datoteke");
}

// Validacija veličine (5MB)
if ($file['size'] > 5 * 1024 * 1024) {
    die("Datoteka prevelika (max 5MB)");
}

// Učitaj sadržaj
$content = file_get_contents($file['tmp_name']);

// Generiraj IV i kriptiraj
$iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($cipher));
$encrypted = openssl_encrypt($content, $cipher, $encryption_key, OPENSSL_RAW_DATA, $iv);

// Generiraj naziv i spremi
$timestamp = time();
$unique_id = uniqid();
$encrypted_filename = "doc_{$timestamp}_{$unique_id}.enc";

// Spremi IV + kriptirane podatke
file_put_contents("uploads_encrypted/$encrypted_filename", $iv . $encrypted);

// Spremi metadata
$metadata = [
    'original_name' => $file['name'],
    'extension' => $ext,
    'encrypted_filename' => $encrypted_filename,
    'upload_date' => date('Y-m-d H:i:s'),
    'iv_length' => strlen($iv)
];
file_put_contents("uploads_encrypted/meta_{$timestamp}_{$unique_id}.json", json_encode($metadata));

// Obriši temp
unlink($file['tmp_name']);

// Redirect
header("Location: upload_form.php?success=1&file=" . urlencode($file['name']));
?>