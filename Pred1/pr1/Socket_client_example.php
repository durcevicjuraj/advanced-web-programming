<?php
// U C:\xampp\php\php.ini otkomentirati (obrisati ;) ;extension=php_sockets.dll
if(!($sock = socket_create(AF_INET, SOCK_STREAM, 0)))
{
    $errorcode = socket_last_error();
    $errormsg = socket_strerror($errorcode);
     
    die("Ne možemo stvoriti socket: [$errorcode] $errormsg \n");
}
 
echo "Socket je uspješno stvoren \n";
 
//Spoj na udaljeni server
$url="www.ferit.unios.hr";
$ip_address = gethostbyname($url);
if(!socket_connect($sock , $ip_address , 80))
{
    $errorcode = socket_last_error();
    $errormsg = socket_strerror($errorcode);
     
    die("Ne možemo se spojiti: [$errorcode] $errormsg \n");
}
 
echo "Spojili smo se \n";
 
//$message = "GET / HTTP/1.1\r\n\r\n";
$message = "GET / HTTP/1.1\r\nHOST: $url\r\nConnection: Close\r\n\r\n";


//Slanje poruke serveru
if( ! socket_send ( $sock , $message , strlen($message) , 0))
{
    $errorcode = socket_last_error();
    $errormsg = socket_strerror($errorcode);
     
    die("Ne možemo poslati podatke [$errorcode] $errormsg \n");
}
 
echo "Uspješno smo poslali podatke \n"; 

//Primanje odgovora sa servera
if(socket_recv ( $sock , $buf , 200045 , MSG_WAITALL ) === FALSE)
{
    $errorcode = socket_last_error();
    $errormsg = socket_strerror($errorcode);
     
    die("Nismo primili podatke: [$errorcode] $errormsg \n");
}
 
//Ispis primljenih podataka
echo $buf;
//echo htmlspecialchars($buf);
?>

