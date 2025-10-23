<?php
set_time_limit (0);
$host = 'localhost'; //host
$port = '9000'; //port
$null = NULL; //null var

//Stvoramo TCP/IP stream socket
$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
//Sljedeća naredba omogućuje da se isti port upotrijebi novim pokretanjem socketa
socket_set_option($socket, SOL_SOCKET, SO_REUSEADDR, 1);

//Pveži socket sa hostom i portom
socket_bind($socket, 0, $port);

//Slušamo na portu
socket_listen($socket);

//Stvaramo i dodajemo socket koji slušamo
$clients = array($socket);

//Beskonačna petlja tako da se skripta ne zaustavi
while (true) {
	//Upravljanje sa višesturkim konekcijama
	$changed = $clients;
	//Dodajemo socket u niz $changed
	socket_select($changed, $null, $null, 0, 10);
	
	//Provjeri ima li novih socketa
	if (in_array($socket, $changed)) {
    //Prihvati novi socket
		$socket_new = socket_accept($socket);
    //Dodajemo novi socket u niz client 
		$clients[] = $socket_new; 
		
    //Čitamo podatke koje je poslao socket
		$header = socket_read($socket_new, 1024);
    //Websocket handshake 
		perform_handshaking($header, $socket_new, $host, $port); 
		
    //IP adresa spojenog socketa
		socket_getpeername($socket_new, $ip);
    //Pretvori u json podatke 
		$response = mask(json_encode(array('type'=>'system', 'message'=>$ip.' je spojen')));
		//Obavijesti sve korisnike o novoj konekciji
    send_message($response); 
		
		//Napravi mjesta za novi socket
		$found_socket = array_search($socket, $changed);
		unset($changed[$found_socket]);
	}
	
	//Petlja kroz sve spojene sockete
	foreach ($changed as $changed_socket) {	
		
		//Provjeri ima li dolaznih podataka
		while(socket_recv($changed_socket, $buf, 1024, 0) >= 1)
		{
			$received_text = unmask($buf); 
			$tst_msg = json_decode($received_text); //json dekodiranje 
			$user_name = $tst_msg->name; //ime pošiljatelja
			$user_message = $tst_msg->message; //poruka koju je poslao
			$user_color = $tst_msg->color; //boja
			
			//Pripremi podatke za slanje korisniku
			$response_text = mask(json_encode(array('type'=>'usermsg', 'name'=>$user_name, 'message'=>$user_message, 'color'=>$user_color)));
			send_message($response_text); //Slanje podataka
			break 2; //Izađi iz petlje
		}
		
		$buf = @socket_read($changed_socket, 1024, PHP_NORMAL_READ);
		if ($buf === false) { //Provjeri odspojene korisnike
			//ukloni korisnika iz niza $clients
			$found_socket = array_search($changed_socket, $clients);
			socket_getpeername($changed_socket, $ip);
			unset($clients[$found_socket]);
			
			//Obavijesti korisnike o odspajanju korisnika
			$response = mask(json_encode(array('type'=>'system', 'message'=>$ip.' odspojeni')));
			send_message($response);
		}
	}
}
//Zatvori socket
socket_close($socket);

function send_message($msg)
{
  //Globalna varijablja postaje vidljiva unutar funkcije
	global $clients;
  //Šaljemo poruku svim klijentima
	foreach($clients as $changed_socket)
	{
		@socket_write($changed_socket,$msg,strlen($msg));
	}
	return true;
}


//Dekodiranje dolazne poruke
function unmask($text) {
	$length = ord($text[1]) & 127;
	if($length == 126) {
		$masks = substr($text, 4, 4);
		$data = substr($text, 8);
	}
	elseif($length == 127) {
		$masks = substr($text, 10, 4);
		$data = substr($text, 14);
	}
	else {
		$masks = substr($text, 2, 4);
		$data = substr($text, 6);
	}
	$text = "";
	for ($i = 0; $i < strlen($data); ++$i) {
		$text .= $data[$i] ^ $masks[$i%4];
	}
	return $text;
}

//Kodiranje poruke za slanje korisniku
function mask($text)
{
	$b1 = 0x80 | (0x1 & 0x0f);
	$length = strlen($text);
	
	if($length <= 125)
		$header = pack('CC', $b1, $length);
	elseif($length > 125 && $length < 65536)
		$header = pack('CCn', $b1, 126, $length);
	elseif($length >= 65536)
		$header = pack('CCNN', $b1, 127, $length);
	return $header.$text;
}

//handshake novog korisnika
function perform_handshaking($receved_header,$client_conn, $host, $port)
{
	$headers = array();
	$lines = preg_split("/\r\n/", $receved_header);
	foreach($lines as $line)
	{
		$line = chop($line);
		if(preg_match('/\A(\S+): (.*)\z/', $line, $matches))
		{
			$headers[$matches[1]] = $matches[2];
		}
	}

	$secKey = $headers['Sec-WebSocket-Key'];
	$secAccept = base64_encode(pack('H*', sha1($secKey . '258EAFA5-E914-47DA-95CA-C5AB0DC85B11')));
	//hand shaking header
	$upgrade  = "HTTP/1.1 101 Web Socket Protocol Handshake\r\n" .
	"Upgrade: websocket\r\n" .
	"Connection: Upgrade\r\n" .
	"WebSocket-Origin: $host\r\n" .
	"WebSocket-Location: ws://$host:$port/demo/shout.php\r\n".
	"Sec-WebSocket-Accept:$secAccept\r\n\r\n";
	socket_write($client_conn,$upgrade,strlen($upgrade));
}
