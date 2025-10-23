<?php

//Spajamo se na URL
function check_url($url) { 
    //Razdvaja URL na dijelove
    $url_pieces = parse_url($url);
    
    //Postavljamo $path i $port
    $path = (isset($url_pieces['path'])) ? $url_pieces['path'] :  '/'; 
    $port = (isset($url_pieces['port'])) ? $url_pieces['port'] : 80; 

    //Spajanje sa fsockopen():
    if ($fp = fsockopen($url_pieces['host'], $port, $errno, $errstr, 30)) { 
        
        //Slanje zaglavlja da server ne vraća čitavu stranicu nego samo odgovor
        $send = "HEAD $path HTTP/1.1\r\n";
        $send .= "HOST: {$url_pieces['host']}\r\n";
        $send .= "CONNECTION: Close\r\n\r\n";
        fwrite($fp, $send);        
        
        //Čitanje odgovora
        $data = fgets($fp, 128); 
        //var_dump($data);
        //Zatvranje spoja
        fclose($fp); 
        
        //Vraćamo odgovor
        list($response, $code) = explode(' ', $data); 
        if ($code == 200) {
            return array($code, 'good');
        } else {
            return array($code, 'bad');
        }
    } else { // Nema spoja
        return array($errstr, 'bad');
    }     
}

//niz URL-ova
$urls = array('https://www.ferit.unios.hr/', 'https://www.unios.hr/','https://www.google.com/');
echo '<h2>Validacija URL-ova</h2>';
// Ukidamo PHP time limit
set_time_limit(0);
// Validiramo svaki URL:
foreach ($urls as $url) {
    list($code, $class) = check_url($url);
    echo "<p><a href=\"$url\" target=\"_new\">$url</a> (<span class=\"$class\">$code</span>)</p>\n";
} 
?>

