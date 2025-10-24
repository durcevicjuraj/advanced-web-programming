<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>lv1</title>
    <style>
        
    </style>
</head>
<body>

<?php
set_time_limit(300);
require('DiplomskiRadovi.php');
require('simple_html_dom.php');

$total_scraped = 0;
$total_saved = 0;

// Loop through pages 2 to 6
for ($page = 2; $page <= 6; $page++) {
    
    $url = "https://stup.ferit.hr/index.php/zavrsni-radovi/page/$page/";
    
    echo "<div class='info'><strong>Scraping page $page:</strong> $url</div>";
    
    // Fetch HTML content
    $html_content = file_get_contents($url);
    
    if ($html_content === false) {
        echo "<p class='error'> Failed to fetch page $page</p>";
        continue;
    }
    
    // Parse HTML
    $html = str_get_html($html_content);
    
    if (!$html) {
        echo "<p class='error'> Failed to parse HTML from page $page</p>";
        continue;
    }
    
    // Find all articles
    $articles = $html->find('article');
    
    echo "<p>Found " . count($articles) . " articles on page $page</p>";
    
    foreach ($articles as $article) {
        
        // Extract title and link
        $link_element = $article->find('a', 0);
        if (!$link_element) continue;
        
        $naziv_rada = trim($link_element->plaintext);
        $link_rada = $link_element->href;
        
        // Extract OIB 
        $img_element = $article->find('img', 0);
        $oib_tvrtke = '';
        
        if ($img_element && isset($img_element->src)) {
            $img_url = $img_element->src;
            if (preg_match('/\/(\d+)\.png/', $img_url, $matches)) {
                $oib_tvrtke = $matches[1];
            }
        }
        
        // Extract text 
        $tekst_rada = '';
        $article_html = @file_get_contents($link_rada);
        
        if ($article_html !== false) {
            $article_dom = str_get_html($article_html);
            
            if ($article_dom) {
                $content = null;
                
                $selectors = [
                    'div.entry-content',
                    'div.post-content',
                    'article div',
                    'div.content',
                    '.entry-content p'
                ];
                
                foreach ($selectors as $selector) {
                    $content = $article_dom->find($selector, 0);
                    if ($content && strlen(trim($content->plaintext)) > 100) {
                        $tekst_rada = trim($content->plaintext);
                        break;
                    }
                }
                
                if (empty($tekst_rada)) {
                    $paragraphs = $article_dom->find('p');
                    if (count($paragraphs) > 0) {
                        $tekst_rada = trim($paragraphs[0]->plaintext);
                    }
                }
                
                $article_dom->clear();
            }
        }
        
        if (empty($tekst_rada)) {
            $tekst_rada = "Tekst nije pronađen na stranici.";
        }
        
        if (strlen($tekst_rada) > 5000) {
            $tekst_rada = substr($tekst_rada, 0, 5000) . "...";
        }
        
        $total_scraped++;
        
        // Create DiplomskiRadovi object and save to database
        $rad = new DiplomskiRadovi();
        $rad->create([
            'naziv_rada' => $naziv_rada,
            'tekst_rada' => $tekst_rada,
            'link_rada' => $link_rada,
            'oib_tvrtke' => $oib_tvrtke
        ]);
        
        if ($rad->save()) {
            $total_saved++;
            echo "<p class='success'> Saved: " . htmlspecialchars(substr($naziv_rada, 0, 80)) . "...</p>";
        } else {
            echo "<p class='error'> Failed to save: " . htmlspecialchars(substr($naziv_rada, 0, 80)) . "...</p>";
        }
        
        usleep(200000);
    }
    
    $html->clear();
}

echo "<hr>";
echo "<h2>Summary</h2>";
echo "<p><strong>Total articles scraped:</strong> $total_scraped</p>";
echo "<p><strong>Total articles saved to database:</strong> $total_saved</p>";

// Display all records from database
echo "<hr>";
echo "<h2>read()</h2>";

$rad = new DiplomskiRadovi();
$all_radovi = $rad->read();

if (count($all_radovi) > 0) {
    echo "<p><strong>Total records in database:</strong> " . count($all_radovi) . "</p>";
    
    echo "<table>";
    echo "<tr>
            <th>ID</th>
            <th>Naziv Rada</th>
            <th>OIB Tvrtke</th>
            <th>Link</th>
            <th>Tekst (preview)</th>
            <th>Datum Dodavanja</th>
          </tr>";
    
    foreach ($all_radovi as $row) {
        $tekst_preview = substr($row['tekst_rada'], 0, 100) . "...";
        
        echo "<tr>";
        echo "<td>" . htmlspecialchars($row['id']) . "</td>";
        echo "<td>" . htmlspecialchars($row['naziv_rada']) . "</td>";
        echo "<td>" . htmlspecialchars($row['oib_tvrtke']) . "</td>";
        echo "<td><a href='" . htmlspecialchars($row['link_rada']) . "' target='_blank'>Link</a></td>";
        echo "<td>" . htmlspecialchars($tekst_preview) . "</td>";
        echo "<td>" . htmlspecialchars($row['datum_dodavanja']) . "</td>";
        echo "</tr>";
    }
    
    echo "</table>";
} else {
    echo "<p>No records found in database.</p>";
}

?>

</body>
</html>