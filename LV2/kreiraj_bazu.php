<?php
$dbc = mysqli_connect('127.0.0.1', 'root', '', '');

// Kreiraj bazu
mysqli_query($dbc, "CREATE DATABASE IF NOT EXISTS backup_test");
mysqli_select_db($dbc, 'backup_test');

// Kreiraj tablicu
$sql = "CREATE TABLE IF NOT EXISTS studenti (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ime VARCHAR(50),
    prezime VARCHAR(50),
    email VARCHAR(100)
)";
mysqli_query($dbc, $sql);

// Umetni podatke
$sql = "INSERT INTO studenti (ime, prezime, email) VALUES
    ('Marko', 'Marić', 'marko@test.com'),
    ('Ana', 'Anić', 'ana@test.com'),
    ('Petar', 'Petrović', 'petar@test.com')";
mysqli_query($dbc, $sql);

echo "✓ Baza i tablica kreirani!<br>";
echo "<a href='backup_database.php'>Napravi backup</a>";
?>