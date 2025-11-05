<?php
/*
Skripta za pregled sadržaja backup datoteka
*/

$backup_dir = 'backup/lv2_backup_test';

echo "<h2>Pregled backup datoteka</h2>";

// Provjeri postoji li direktorij
if (!is_dir($backup_dir)) {
    die("<p>✗ Direktorij '$backup_dir' ne postoji!</p>");
}

// Dohvati sve .txt datoteke
$txt_files = glob("$backup_dir/*.txt");

if (count($txt_files) == 0) {
    echo "<p>⚠ Nema .txt datoteka u direktoriju</p>";
} else {
    echo "<p>✓ Pronađeno " . count($txt_files) . " .txt datoteka</p><hr>";
    
    foreach ($txt_files as $file) {
        $filename = basename($file);
        $filesize = filesize($file);
        
        echo "<div style='margin: 20px 0; padding: 15px; border: 2px solid #4CAF50; background: #f9f9f9;'>";
        echo "<h3>📄 $filename</h3>";
        echo "<p><strong>Veličina:</strong> $filesize bytes</p>";
        
        // Pročitaj sadržaj
        $content = file_get_contents($file);
        
        echo "<h4>Sadržaj:</h4>";
        echo "<pre style='background: #fff; padding: 10px; border: 1px solid #ddd; overflow-x: auto;'>";
        echo htmlspecialchars($content);
        echo "</pre>";
        
        echo "</div>";
    }
}

echo "<hr>";

// Dohvati sve .gz datoteke
$gz_files = glob("$backup_dir/*.gz");

if (count($gz_files) == 0) {
    echo "<p>⚠ Nema .gz datoteka u direktoriju</p>";
} else {
    echo "<p>✓ Pronađeno " . count($gz_files) . " .gz (komprimiranih) datoteka:</p>";
    echo "<ul>";
    foreach ($gz_files as $file) {
        $filename = basename($file);
        $filesize = filesize($file);
        echo "<li><strong>$filename</strong> - $filesize bytes</li>";
    }
    echo "</ul>";
}

echo "<hr>";
echo "<h3>📝 Objašnjenje formata:</h3>";
echo "<p>Svaka .txt datoteka sadrži SQL INSERT naredbe u formatu koji je tražen u zadatku:</p>";
echo "<pre style='background: #ffffcc; padding: 10px;'>";
echo "INSERT INTO nazivTablice (atribut1, atribut2, atribut3)\n";
echo "VALUES ('vrijednost1', 'vrijednost2', 'vrijednost3');\n";
echo "</pre>";
echo "<p>Ovaj format omogućuje jednostavno vraćanje podataka u bazu pokretanjem tih SQL naredbi.</p>";
?>