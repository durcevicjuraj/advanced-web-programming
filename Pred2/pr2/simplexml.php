<?php 
/*SimpleXML parser*/
 
 //Učitaj datoteku
$xml = simplexml_load_file('books.xml');

//Iteracija kroz XML
foreach ($xml->book as $book) { 
    //Ispiši naslov
    echo "<div><h2>$book->title";
    
    //Provjeri izdanje
	if (isset($book->title['edition'])) {
	    echo " (Izdanje {$book->title['edition']})";
	}

	echo '</h2>';
    
    //Ispiši autora
	foreach ($book->author as $author) {
	    echo "<span class=\"label\">Autor</span>: $author<br>";
	}
    
    //Godina izdanja
	echo "<span class=\"label\">Godina izdanja:</span> $book->year<br>";

	if (isset($book->pages)) {
	    echo "<span class=\"label\">Stranice:</span> $book->pages<br>";
	} 
    
    //Ispiši poglavlja
	if (isset($book->chapter)) {
	    echo 'Sadržaj<ul>';
	    foreach ($book->chapter as $chapter) {
        
			echo '<li>';

			if (isset($chapter['number'])) {
			    echo "Poglavlje {$chapter['number']}: ";
			}

			echo $chapter;

			if (isset($chapter['pages'])) {
			    echo " ({$chapter['pages']} stranica)";
			}

			echo '</li>';
            
        }
        echo '</ul>';
    }
    
    //Naslovnica
	if (isset($book->cover)) {

	    //Dohvati sliku
	    $image = @getimagesize ($book->cover['filename']);
    
	    //Prikaži sliku u HTML-u
	    echo "<img src=\"{$book->cover['filename']}\" $image[3] border=\"0\" /><br>";
    
	}
    
    //Zatvori div
    echo '</div>';
    
}
?>
