<?php
$dbc = mysqli_connect('127.0.0.1', 'root', '', 'backup_test');

// Kreiraj backup direktorij
if (!is_dir('backup')) mkdir('backup');

// Dohvati podatke
$result = mysqli_query($dbc, "SELECT * FROM studenti");

// Ime datoteke
$filename = "backup/studenti_" . date('Y-m-d_H-i-s') . ".txt";

// Otvori .txt datoteku
$file = fopen($filename, 'w');

// Zapiši INSERT naredbe
while ($row = mysqli_fetch_assoc($result)) {
    $sql = "INSERT INTO studenti (id, ime, prezime, email)\n";
    $sql .= "VALUES ('{$row['id']}', '{$row['ime']}', '{$row['prezime']}', '{$row['email']}');\n\n";
    fwrite($file, $sql);
}

fclose($file);

echo "✓ .txt datoteka kreirana: $filename<br>";

// Komprimiraj u .gz
$gz = gzopen("$filename.gz", 'w9');
gzwrite($gz, file_get_contents($filename));
gzclose($gz);

$txt_size = filesize($filename);
$gz_size = filesize("$filename.gz");

echo "✓ .gz datoteka kreirana: $filename.gz<br>";
echo "Originalna veličina: $txt_size bytes<br>";
echo "Komprimirana veličina: $gz_size bytes<br>";
echo "Kompresija: " . round((1 - $gz_size/$txt_size)*100, 2) . "%";
?>