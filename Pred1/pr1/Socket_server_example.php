<?php
error_reporting(~E_NOTICE);
//Skripta se može izvršavati neograničeno dugo vremena
set_time_limit (0);
//0.0.0.0 znači da prima konekcije sa svih adresa na localhostu 
$address = "0.0.0.0";
$port = 5000;
$max_clients = 10;
 
if(!($sock = socket_create(AF_INET, SOCK_STREAM, 0)))
{
    $errorcode = socket_last_error();
    $errormsg = socket_strerror($errorcode);
     
    die("Nismo mogli stvoriti socket: [$errorcode] $errormsg \n");
}
 
echo "Socket stvoren \n";
 
//Poveži socket na adresu i port
if( !socket_bind($sock, $address , $port) )
{
    $errorcode = socket_last_error();
    $errormsg = socket_strerror($errorcode);
     
    die("Nismo mogli povezati socket : [$errorcode] $errormsg \n");
}
 
echo "Socket je uspješno povezan \n";
 
if(!socket_listen ($sock , $max_clients))
{
    $errorcode = socket_last_error();
    $errormsg = socket_strerror($errorcode);
     
    die("Socket ne može slušati: [$errorcode] $errormsg \n");
}
 
echo "Socket uspješno sluša \n";
 
echo "Očekujemo dolazne konekcije... \n";
 
//Niz u koji spremamo korisnike socketa
$client_socks = array();
 
//Niz socketa koje treba pročitati
$read = array();
 
//Petlja koja sluša dolazne konekcije i obrađuje već postojećće konekcije
while (true) 
{
    //Niz socketa koje treba pročitati
    $read = array();
     
    //Prvi socket je glavni socket
    $read[0] = $sock;
     
    //Dodaj postojeće korisničke sockete
    for ($i = 0; $i < $max_clients; $i++)
    {
        if($client_socks[$i] != null)
        {
            $read[$i+1] = $client_socks[$i];
        }
    }
     
    //PHP nema niti pa funkcijom select promatramo niz socketa na promjene
    if(socket_select($read , $write , $except , null) === false)
    {
        $errorcode = socket_last_error();
        $errormsg = socket_strerror($errorcode);
     
        die("Ne možemo slušati socket : [$errorcode] $errormsg \n");
    }
     
    //Ako postoji glavni socket tada možemo primati nove konekcije
    if (in_array($sock, $read)) 
    {
        for ($i = 0; $i < $max_clients; $i++)
        {
            if ($client_socks[$i] == null) 
            {
                $client_socks[$i] = socket_accept($sock);
                 
                //Prikaz informacija o spojenom klijentu
                if(socket_getpeername($client_socks[$i], $address, $port))
                {
                    echo "Klijent $address : $port se spojio. \n";
                }
                 
                //Pošalji poruku dobrodošlice
                $message = "Dobro dosli na php socket server\n";
                $message .= "Unesite poruku i pritisnite enter kako bi dobili odgovor \n";
                socket_write($client_socks[$i] , $message);
                break;
            }
        }
    }
 
    //Provjeri za svakog korisnika da li šalje podatke
    for ($i = 0; $i < $max_clients; $i++)
    {
        if (in_array($client_socks[$i] , $read))
        {   
            $input = socket_read($client_socks[$i] , 1024, PHP_NORMAL_READ);
             
            if ($input == null) 
            {
                //Prazan string znači da se korisnik odspojio, zatvaramo i uklanjamo socket
                socket_close($client_socks[$i]);
                unset($client_socks[$i]);
                
            }
 
            $n = trim($input);
 
            $output = "Saljemo odgovor ... $n";
             
            echo "Šaljemo odgovor klijentu \n";
             
            //Slanje odgovora klijentu
            socket_write($client_socks[$i] , $output);
        }
    }
}
?>

