<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Origin,  Access-Control-Allow-Headers, Authorization, X-Requested-With");

include("../db/config.php");
include("../db/cryptography.php");
include("../db/backup_table.php");
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
		if(isset($_POST['id'])){
			$id_admin = $result[0]['id_admin'];
			$id_to_delete = _secure($_POST['id']);
			
			//***** backup before deletion *****
			$obj = new backup_table($connect);
			$table = "website";
			$where = "id = $id_to_delete";
			$operation = "delete";
			$backup = $obj->backup($table, $where, "web_admin", $id_admin, $operation);
			$backup = json_decode($backup);
			$backup_error = $backup[0]->error;
			//***** backup before deletion *****
			
			if($backup_error == 0){
				$up = "update website set active=0 where id = $id_to_delete";
				$q = mysqli_query($connect, $up);
				$data[$i]['error'] = 0;
				$data[$i]['message_title'] = "تم";
				$data[$i]['error_message'] = " تمت عملية الحذف ";
			}else{
				$data[$i]['error'] = 1;
				$data[$i]['message_title'] = "تنبيه !";
				$data[$i]['error_message'] = " لم تتم عملية حفظ النسخة ولا الحذف ";
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