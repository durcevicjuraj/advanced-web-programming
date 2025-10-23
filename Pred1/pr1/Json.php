<?php
    $podaci=json_decode(file_get_contents('php://input'),true); 
    echo 'Poštovani, '.$podaci['name']. ' hvala Vam na Vašem upitu.';
    echo "Odgovor ćemo poslati na Vaš email".$podaci['email'];         

?>
