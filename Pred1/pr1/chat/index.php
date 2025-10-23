<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<style type="text/css">

.panel{

	
margin-right: 3px;
}

.button {
    background-color: #4CAF50;
    border: none;
    color: white;
	margin-right: 30%;   
	margin-left: 30%;
    text-decoration: none;
    display: block;
    font-size: 16px;
    cursor: pointer;
	width:30%;
    height:40px;
	margin-top: 5px;
	 
}
input[type=text]{
		width:100%;
		margin-top:5px;
		
	}


.chat_wrapper {
	width: 70%;
	height:472px;
	margin-right: auto;
	margin-left: auto;
	background: #3B5998;
	border: 1px solid #999999;
	padding: 10px;
	font: 14px 'lucida grande',tahoma,verdana,arial,sans-serif;
}
.chat_wrapper .message_box {
	background: #F7F7F7;
	height:350px;
		overflow: auto;
	padding: 10px 10px 20px 10px;
	border: 1px solid #999999;
}
.chat_wrapper  input{
	//padding: 2px 2px 2px 5px;
}
.system_msg{color: #BDBDBD;font-style: italic;}
.user_name{font-weight:bold;}
.user_message{color: #88B6E0;}

@media only screen and (max-width: 720px) {
    /* For mobile phones: */
    .chat_wrapper {
        width: 95%;
	height: 40%;
	}
    

	.button{ width:100%;
	margin-right:auto;   
	margin-left:auto;
	height:40px;}
	
	
	
	
	
				
}

</style>
</head>
<body>	
<?php 
$colours = array('007AFF','FF7000','FF7000','15E25F','CFC700','CFC700','CF1100','CF00BE','F00');
$user_colour = array_rand($colours);
?>


<script src="jquery-3.1.1.js"></script>


<script language="javascript" type="text/javascript">  
$(document).ready(function(){
	//Stvori novi WebSocket objekt.
	var wsUri = "ws://localhost:9000/server.php"; 	
	websocket = new WebSocket(wsUri); 
	
	websocket.onopen = function(ev) { // Veza je otvorena
		$('#message_box').append("<div class=\"system_msg\">Spojeni smo!</div>"); //Obavijesti korisnika
	}

	$('#send-btn').click(function(){ //Slanje klikom na gumb
		var mymessage = $('#message').val(); //Tekst poruke
		var myname = $('#name').val(); //Korisničko ime
		
		if(myname == ""){ //Prazno ime?
			alert("Molimo  Vas unesite ime!");
			return;
		}
		if(mymessage == ""){ //Prazna poruka?
			alert("Molimo  Vas unesite poruku!");
			return;
		}
		document.getElementById("name").style.visibility = "hidden";
		
		var objDiv = document.getElementById("message_box");
		objDiv.scrollTop = objDiv.scrollHeight;
		//json podaci
		var msg = {
		message: mymessage,
		name: myname,
		color : '<?php echo $colours[$user_colour]; ?>'
		};
		//Pretvori i pošalji podatke serveru
		websocket.send(JSON.stringify(msg));
	});
	
	//Primljena poruka od servera
	websocket.onmessage = function(ev) {
		var msg = JSON.parse(ev.data); //PHP šalje Json podake
		var type = msg.type; //Tip poruke
		var umsg = msg.message; //Tekst poruke
		var uname = msg.name; //Ime korisnika
		var ucolor = msg.color; //Boja

		if(type == 'usermsg') 
		{
			$('#message_box').append("<div><span class=\"user_name\" style=\"color:#"+ucolor+"\">"+uname+"</span> : <span class=\"user_message\">"+umsg+"</span></div>");
		}
		if(type == 'system')
		{
			$('#message_box').append("<div class=\"system_msg\">"+umsg+"</div>");
		}
		
		$('#message').val(''); //Očisti tekst
		
		var objDiv = document.getElementById("message_box");
		objDiv.scrollTop = objDiv.scrollHeight;
	};
	
	websocket.onerror	= function(ev){$('#message_box').append("<div class=\"system_error\">Dogodila se pogreška - "+ev.data+"</div>");}; 
	websocket.onclose 	= function(ev){$('#message_box').append("<div class=\"system_msg\">Veza je zatvorena</div>");}; 
});




</script>
<div class="chat_wrapper">
<div class="message_box" id="message_box"></div>
<div class="panel">
<input type="text" name="name" id="name" placeholder="Your Name" maxlength="15" />

<input type="text" name="message" id="message" placeholder="Message" maxlength="80" 
onkeydown = "if (event.keyCode == 13)document.getElementById('send-btn').click()"  />





</div>

<button id="send-btn" class=button>Pošalji</button>

</div>

</body>
</html>