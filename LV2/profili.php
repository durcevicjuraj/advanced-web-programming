<?php
// Učitaj kao tekst
$xml_content = file_get_contents('LV2.xml');

// Zamijeni SVE & sa &amp; (osim ako već nije &amp;)
$xml_content = str_replace('&', '&amp;', $xml_content);
$xml_content = str_replace('&amp;amp;', '&amp;', $xml_content); // ako je već bio &amp;

// Parsiraj ispravljeni XML
$xml = simplexml_load_string($xml_content);

if (!$xml) {
    echo "Još uvijek greška. Problemi sa XML-om:<br>";
    $errors = libxml_get_errors();
    foreach ($errors as $error) {
        echo "- " . $error->message . "<br>";
    }
    die();
}

echo "<h1>Profili (" . count($xml->record) . " osoba)</h1>";

foreach ($xml->record as $osoba) {
    echo "<div style='border: 1px solid #ccc; padding: 15px; margin: 10px 0;'>";
    echo "<img src='{$osoba->slika}' width='50' style='float: left; margin-right: 15px;'>";
    echo "<h3>{$osoba->ime} {$osoba->prezime}</h3>";
    echo "<p><strong>Email:</strong> {$osoba->email}</p>";
    echo "<p>{$osoba->zivotopis}</p>";
    echo "<div style='clear: both;'></div>";
    echo "</div>";
}
?>