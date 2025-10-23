<?php 
//Provjeri post upit
if (isset($_POST['format'])) {
    
    // Switch the content type based upon the format:
    switch ($_POST['format']) {
        case 'csv':
            $type = 'text/csv';
            break;
        case 'json':
            $type = 'application/json';
            break;
        case 'xml':
            $type = 'text/xml';
            break;
        default:
            $type = 'text/plain';
            break;
    }
    
    //Stvori odgovor
    $data = array();
    $data['timestamp'] = time();
    
    //Vrati primljene podatke
    foreach ($_POST as $k => $v) {
        $data[$k] = $v;
    }
    
    //Prebaci podatke u json format
    if ($type == 'application/json') {
        $output = json_encode($data);
        
    } elseif ($type == 'text/csv') {
    
        //Prebaci u string
        $output = '';
        foreach ($data as $v) {
            $output .= '"' . $v . '",';
        }
    
        //Odreži zarez na kraju podataka
        $output = substr($output, 0, -1); 

    } elseif ($type == 'text/plain') {
        $output = print_r($data, 1);
    }
    else { //Pogrešna upotreba
    $type = 'text/plain';
    $output = 'Servis ne koristite ispravno.';
  }
}

//Postavi zaglavlje
header("Content-Type: $type");
echo $output;