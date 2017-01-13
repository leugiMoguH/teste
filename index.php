<?php
// parameters
$hubVerifyToken = 'Testetoken';
$accessToken = "EAAF2PYHIl0UBAJVPPnZAtTGO3bYTdLhozAsCVdlKzucq7lnUwLga2nGzvYfUNg98oxeN4oDd3jlVIFI5IIL3EwD9qqRxo5VVptZAUyDjsTyxocZCBDAKb3PHBOtOuxj7RV6fSYl3XbTgpobZBOKiYztKO05id8cKqIwimntXBQZDZD";

// check token at setup
if ($_REQUEST['hub_verify_token'] === $hubVerifyToken) {
  echo $_REQUEST['hub_challenge'];
  exit;
}

// handle bot's anwser
$input = json_decode(file_get_contents('php://input'), true);

$senderId = $input['entry'][0]['messaging'][0]['sender']['id'];
$messageText = $input['entry'][0]['messaging'][0]['message']['text'];

if(!empty($messageText))
{
	$answer = "I don't understand. Ask me 'hi'.";
	if($messageText == "hi") {
	    $answer = "Hello";
	}

	$response = array(
	    'recipient' => $senderId ,
	    'message'  => $answer 
	);
	$ch = curl_init('https://graph.facebook.com/v2.6/me/messages?access_token='.$accessToken);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($response));
	curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
	curl_exec($ch);
	curl_close($ch);
}