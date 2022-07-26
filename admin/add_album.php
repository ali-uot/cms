<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Origin,  Access-Control-Allow-Headers, Authorization, X-Requested-With");

include("../db/config.php");
include("../db/cryptography.php");
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
		if(isset($_POST['A_site_title']) && isset($_POST['site_link'])){
			$A_site_title = _secure($_POST['A_site_title']);
			$site_link = _secure($_POST['site_link']);
			$id_admin = $result[0]['id_admin'];
			$in = "insert into website values('', '$A_site_title', '$site_link', '1', '$id_admin', '1', '$current_time')";
			$q = mysqli_query($connect, $in);
			if($q === true){
				$data[$i]['error'] = 0;
				$data[$i]['message_title'] = "تم";
				$data[$i]['error_message'] = " تم اضافة الموقع ";
			}else{
				$data[$i]['error'] = 1;
				$data[$i]['message_title'] = "تنبيه !";
				$data[$i]['error_message'] = " لم تتم الاضافة ";
			}
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
}else{
	$data[$i]['error'] = 1;
	$data[$i]['message_title'] = "تنبيه !";
	$data[$i]['error_message'] = " يجب تسجيل الدخول اولاً";
}
$out = array_values($data);
echo json_encode($out, JSON_UNESCAPED_UNICODE);
?>