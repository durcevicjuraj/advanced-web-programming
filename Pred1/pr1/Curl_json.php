<?php
              $data=array();
              $data['title'] = "Naslov email poruke";
              $data['name'] = "Ivo Ivić";
              $data['email'] = "ivoivo123434566@gmail.com";
              $data['text'] = "Javljam Vam se zbog...";
              //print_r($data);
              $Data=json_encode($data);
              //print_r($Data);
              $url = "http://localhost/pr1/Json.php";    
              $curl = curl_init($url);
              curl_setopt($curl, CURLOPT_HEADER, false);
              curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
              curl_setopt($curl, CURLOPT_HTTPHEADER, array("Content-type: application/json"));
              curl_setopt($curl, CURLOPT_POST, true);
              curl_setopt($curl, CURLOPT_POSTFIELDS, $Data);              
              $json_response = curl_exec($curl);
              print_r($json_response);
              curl_close($curl);

?>
