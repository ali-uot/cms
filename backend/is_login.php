<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

require_once('../jwt/token/vendor/autoload.php');
use \Firebase\JWT\JWT;

include("../db/config.php");
include("../db/cryptography.php");
require_once("../jwt/token/TokenLogin.php");
include('class.php');

function _secure($var){
	global $connect;
	return mysqli_real_escape_string($connect, $var);
}

if(isset($_POST['token'])){
	$token = _secure($_POST['token']);
	$obj = new class_admin($connect);
	$a = $obj->basic($token);
	echo $a;
}
?>