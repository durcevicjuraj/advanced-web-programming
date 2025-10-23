<?php
require('DiplomskiRadovi.php');
require('simple_html_dom.php');

function fetchPage($url) {
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0');
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    
    $html = curl_exec($ch);
    curl_close($ch);
    return $html;
}

function fetchThesisText($url) {
    $html_content = fetchPage($url);
    
    if (!$html_content) {
        return 'Greška pri dohvaćanju stranice';
    }
    
    $html = str_get_html($html_content);
    
    if ($html) {
        
        $selectors = [
            'div.entry-content',
            'div.post-content',
            'article .content',
            'div.fusion-post-content',
            '.post-content-container'
        ];
        
        foreach ($selectors as $selector) {
            $content = $html->find($selector, 0);
            if ($content) {
                $text = trim(strip_tags($content->innertext));
                if (strlen($text) > 100) { 
                    $html->clear();
                    return $text;
                }
            }
        }
        
        $html->clear();
    }
    return 'Tekst nije pronađen';
}

$ukupno_radova = 0;

for ($page = 2; $page <= 6; $page++) {
    $url = "https://stup.ferit.hr/index.php/zavrsni-radovi/page/{$page}";
    echo "<h2>Stranica {$page}</h2>\n";
    
    $html_content = fetchPage($url);
    
    if (!$html_content) {
        echo "<p style='color: red;'>Greška: Ne mogu dohvatiti stranicu!</p>\n";
        continue;
    }
    
    $html = str_get_html($html_content);
    
    if (!$html) {
        echo "<p style='color: red;'>Greška: Ne mogu parsirati HTML!</p>\n";
        continue;
    }
    
    $articles = $html->find('article');
    echo "<p>Pronađeno radova: " . count($articles) . "</p>\n";
    
    foreach ($articles as $article) {
        // Dohvati OIB
        $img = $article->find('img', 0);
        $oib = 'N/A';
        if ($img && $img->src) {
            if (preg_match('/logos\/(\d+)\.(png|jpg)/i', $img->src, $matches)) {
                $oib = $matches[1];
            }
        }
        
        // Dohvati link
        $link_element = $article->find('a', 0);
        
        if ($link_element && $link_element->href) {
            $link = $link_element->href;
            
            // Dohvati naslov
            $title_link = $article->find('a', 3);
            $naziv = 'N/A';
            
            if ($title_link && trim($title_link->plaintext) != '') {
                $naziv = trim($title_link->plaintext);
            } else {
                $naziv = trim($link_element->plaintext);
            }
            
            echo "\n<div style='border: 1px solid #0a0a0aff; padding: 15px; margin: 15px;'>\n";
            echo "<h3>{$naziv}</h3>\n";
            echo "<p><strong>Link:</strong> <a href='{$link}' target='_blank'>{$link}</a></p>\n";
            echo "<p><strong>OIB tvrtke:</strong> {$oib}</p>\n";
            
            // Dohvati tekst
            $tekst = fetchThesisText($link);
            
            // Objekt
            $rad = new DiplomskiRadovi();
            $rad->create(array(
                'naziv_rada' => $naziv,
                'tekst_rada' => $tekst,
                'link_rada' => $link,
                'oib_tvrtke' => $oib
            ));
        
            $podaci = $rad->read();
            
            if ($podaci['tekst_rada'] != 'Tekst nije pronađen') {
                echo "<p><strong>Tekst:</strong></p>\n";
                echo "<div>" . htmlspecialchars(substr($podaci['tekst_rada'], 0, 1500)) . "</div>\n";
            } else {
                echo "<p style='color: red;'>Tekst nije pronađen</p>\n";
            }
            
            echo "</div>\n";
            
            $ukupno_radova++;
        }
    }
    
    $html->clear();
    unset($html);
}

?>