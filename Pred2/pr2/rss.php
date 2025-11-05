<?php 
/*RSS primjer*/ 
//Pošalji zaglavlje
header('Content-type: text/xml'); 

//Početni RSS kod
echo '<?xml version="1.0" encoding="utf-8"?>
<rss version="2.0">
<channel>
<title>Primjer jednostavnog RSS-a</title>
<description>Ovdje postaviti opis stranice ili sadržaja</description>
<link>www.ferit.hr</link>
';

//Napravi podatke
$data = array(
	0 => array('title' => 'Diplomski studij', 'description' => 'Opis diplomskog studija', 'link' => 'http://www.etfos.unios.hr/studiji/sveucilisni-diplomski-studij/', 'pubDate' => '1487833804'),
	1 => array('title' => 'Preddiplomski studij', 'description' => 'Opis studija', 'link' => 'http://www.etfos.unios.hr/studiji/sveucilisni-preddiplomski-studij/', 'pubDate' => '1487833715'),
	2 => array('title' => 'Stručni studija', 'description' => 'Stručni studij je...', 'link' => 'http://www.etfos.unios.hr/studiji/strucni-studij/', 'pubDate' => '1487833622')
);

//Prolaz kroz podatke
foreach ($data as $item) {

	//Svaki zapis
	echo '<item>
	<title>' . htmlentities($item['title']) . '</title>
	<description>' . htmlentities($item['description']) . '...</description>
	<link>' . $item['link'] . '</link>
	<guid>' . $item['link'] . '</guid>
	<pubDate>' . date('r', $item['pubDate']) . '</pubDate>
	</item>
	';	
}

//Zatvori oznake
echo '</channel>
</rss>
';