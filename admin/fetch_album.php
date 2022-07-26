<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Origin,  Access-Control-Allow-Headers, Authorization, X-Requested-With");

ob_start();
require_once('../jwt/token/vendor/autoload.php');
use \Firebase\JWT\JWT;

include("../db/config.php");
include("../db/cryptography.php");
include("../db/fetch_json.php");
require_once("../jwt/token/TokenLogin.php");
include('../backend/class.php');

function _secure($var){
	global $connect;
	return mysqli_real_escape_string($connect, $var);
}

date_default_timezone_set("Asia/Baghdad");
$current_time = date('Y/m/d&h:i:s_A');

$data = Array();
$i = 0;
$data[$i] = array();



if(!empty($_POST['token']) or !empty($_COOKIE['AdminToken'])){
	if(!empty($_POST['token'])){
		$token = _secure($_POST['token']);
	}else{
		$token = _secure($_COOKIE['AdminToken']);
	}
	$obj = new class_admin($connect);
	$a = $obj->basic($token);
	$result = json_decode($a, true);
	$error = $result[0]['error'];
	
	if($error == 0){
	
		$id_admin = $result[0]['id_admin'];
		
		$table = "website";
		//$columns = array("*");
		$columns = array("id", "A_site_title", "site_link");
		$where = "active=1";
		
		$obj_fetch = new fetch_json($connect);
		$d = $obj_fetch->fetch($table, $columns, $where);
		$data = json_decode($d);
	}else{
		$data[$i]['error'] = 1;
		$data[$i]['message_title'] = "تنبيه !";
		$data[$i]['error_message'] = " يجب ملء جميع الحقول";
	}
}else{
	$data[$i]['error'] = 1;
	$data[$i]['message_title'] = "تنبيه !";
	$data[$i]['error_message'] = " يجب تسجيل الدخول اولاً";
}
$out = array_values($data);
echo json_encode($out, JSON_UNESCAPED_UNICODE);
?>