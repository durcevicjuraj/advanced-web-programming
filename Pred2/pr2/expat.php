<?php 
/*Expat parser*/

//Funkcija koja upravlja oznakom za početak
function handle_open_element($p, $element, $attributes) {

    //Ovisno o oznaci radi sljedeće
    switch ($element) {    
        //Oznake su address: book, title, author, year, chapter, and pages!    
        case 'BOOK': //Za knjigu stvori div
            echo '<div>';
            break;
            
        case 'CHAPTER': //Za poglavlje stvori p
            echo "<p>Poglavlje {$attributes['NUMBER']}: ";
            break;
        
        case 'COVER': //Pokaži sliku  
            //Informacije o slici
            $image = @getimagesize($attributes['FILENAME']);
    
            //Prikaži sliku u HTML-u
            echo "<img src=\"{$attributes['FILENAME']}\" $image[3] border=\"0\"><br>";
            break;
            
        case 'TITLE': //Naslovi su h2
            echo '<h2>';
            break;
            
        //Ostalo samo ispiši
        case 'YEAR':
        case 'AUTHOR':
        case 'PAGES':
            echo '<span class="label">' . $element . '</span>: ';
            break;
            
    } //Kraj switch
    
}

//Funkcija za rukovanje oznakom za kraj
function handle_close_element($p, $element) {

    //Ovisno o oznaci radi sljedeće
    switch ($element) {         
        //Zatvori HTML oznake        
        case 'BOOK': 
            echo '</div>';
            break;
            
        case 'CHAPTER':
            echo '</p>';
            break;
        
        case 'TITLE':
            echo '</h2>';
            break;
        
        //Dodaj novi red za ostalo
        case 'YEAR':
        case 'AUTHOR':
        case 'PAGES':
            echo '<br>';
            break;

    } //Kraj switch
    
}

//Ispiši sadržaj
function handle_character_data($p, $cdata) {
    echo $cdata;
}


//Stvori parser   korak 1.
$p = xml_parser_create();

//Postavi funkcije za rukovanje korak 2.
//Funkcije koje se pokreću na početak i kraj XML oznake
xml_set_element_handler($p, 'handle_open_element', 'handle_close_element');
xml_set_character_data_handler($p, 'handle_character_data');

//Pročitaj datoteku korak 3.
$file = 'books.xml';
$fp = @fopen($file, 'r') or die("<p>Ne možemo otvoriti datoteku '$file'.</p></body></html>");
while ($data = fread($fp, 4096)) {
    xml_parse($p, $data, feof($fp));
}

//Zatvori parser korak 4.
xml_parser_free($p);
?>
