<?php

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => "https://api.sendgrid.com/v3/mail/send",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => "{\n    \"personalizations\": [\n        {\n            \"to\": [\n                {\n                    \"email\": \"".$haomaiEmail."\"\n                }\n            ]\n        }\n    ],\n    \"from\": {\n        \"email\": \"info@haomai.com.ar\"\n    },\n    \"subject\": \"Nuevo Usuario Registrado \",\n    \"content\": [\n        {\n            \"type\": \"text/plain\",\n            \"value\": \"Nuevo usuario registrado en Haomai Market ".$fullName." / ".$email."\"\n        }\n    ]\n}",
  CURLOPT_HTTPHEADER => array(
    "Authorization: Bearer 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",
    "Content-Type: application/json",
    "cache-control: no-cache"
  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else {
  echo $response;
}

/*
$url = 'https://api.sendgrid.com/v3/mail/send';

//create a new cURL resource
$ch = curl_init($url);

//setup request to send json via POST

$data = '{"personalizations": [{"to": [{"email": "andres.wei@hotmail.com"}]}],"from": {"email": "info@haomai.com.ar"},"subject": "Sending with SendGrid is Fun","content": [{"type": "text/plain", "value": "and easy to do anywhere, even with cURL"}]}';

$data = array ( 'personalizations' => array ( 
									'o' => array ('email' => 'andres.wei@hotmail.com') ),
				'from' => array ('email' => 'info@haomai.com.ar'),
				'subject' => 'Nuevo Pedido', 
				'content' => array ( 
							'type' => 'text/plain', 
							'value' => 'Pedido Pedido' ));
							
$command = json_encode($data);

//attach encoded JSON string to the POST fields
curl_setopt($ch, CURLOPT_POSTFIELDS, $command);
//set the content type to application/json
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer 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'));
//return response instead of outputting
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//set method
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");

//execute the POST request
$exec = curl_exec($ch);
$err = curl_error($ch);

if ($err) {
  echo "cURL Error #:" . $err;
} else {
	$result = json_decode($exec);
	
	if (isset($result->message))
	{
		echo $result->message; 
	}
	
		echo $data;
	}



//close cURL resource
curl_close($ch);
*/


?>