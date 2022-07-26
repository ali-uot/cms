<?php
header('Content-Type: application/json; charset=utf-8');
require_once("TokenLogin.php");
require_once("../models/errors.php");

$secret = "Mnkfp3DtpYR9yRn";
$otl = new TokenLogin($secret);


$payload = $otl->validate_token($_GET["t"]);
$arr = array();
if ($payload) {
   //echo "<pre>Valid token! You are user #{$payload->uid}";
	
	$arr[uid] = $payload->uid ;
	$arr[utype] = $payload->utype ;
	HTTPStatus(200);


	//$result = json_encode($arr);

	echo str_replace('\\/', '/', json_encode($arr, JSON_UNESCAPED_UNICODE));
   
  
   // redirect
} else {
	$arr[error] = '401';
	echo str_replace('\\/', '/', json_encode($arr, JSON_UNESCAPED_UNICODE));
	HTTPStatus(401);
   
   //echo "<pre>Invalid token";
}
exit;
