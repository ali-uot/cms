<?php
include("../../../db/config.php");
include("../../../db/cryptography.php");
require_once("../../jwt/token/TokenLogin.php");

require_once('../../jwt/token/vendor/autoload.php');
use \Firebase\JWT\JWT;
include('class.php');

function _secure($var){
	global $connect_learning;
	return mysqli_real_escape_string($connect_learning, $var);
}

$data = Array();
$i = 0;
$data[$i] = array();

if(!empty($_POST['token']) or !empty($_COOKIE['StudentToken'])){
	if(!empty($_POST['token'])){
		$token = _secure($_POST['token']);
	}else{
		$token = _secure($_COOKIE['StudentToken']);
	}
	$obj = new students($connect_learning);
	$a = $obj->basic($token);
	$result = json_decode($a, true);
	$error = $result[0]['error'];
	if($error == 0){
		$id_student = $result[0]['id'];
		$data[$i]['basic_info'] = $result[0]['basic_info'];
		if(!empty($_POST['username']) && !empty($_POST['E_name']) && !empty($_POST['gender']) && !empty($_POST['id_city']) && !empty($_POST['birth_date'])){
			
			$username = _secure($_POST['username']);
			$s = "select username from students where username='$username' and id!='$id_student'";
			$q = mysqli_query($connect_learning, $s);
			$n = mysqli_num_rows($q);
			if($n == 0){
				if(strlen($username)>2){
					$E_name = _secure($_POST['E_name']);
					$gender = _secure($_POST['gender']);
					$id_city = _secure($_POST['id_city']);
					$birth_date = _secure($_POST['birth_date']);
					
					$up = "update students set username='$username', E_name='$E_name', gender='$gender', id_city='$id_city', birth_date='$birth_date' where id='$id_student'";
					$q = mysqli_query($connect_learning, $up);
					if($q === false){
						$data[$i]['error'] = 1;
						$data[$i]['message_title'] = "تنبيه !";
						$data[$i]['error_message'] = "لم تتم عملية تحديث البيانات";
					}else{
						$image = $result[0]['image'];
						$basic_info = $result[0]['basic_info'];
						if(strlen($image)>5 && $basic_info == 0){
							$up = "update students set basic_info=1 where id='$id_student'";
							$q = mysqli_query($connect_learning, $up);
							if($q === true){
								$data[$i]['basic_info'] = 1;
							}
						}
						$data[$i]['error'] = 0;
						$data[$i]['message_title'] = "تم";
						$data[$i]['error_message'] = "تم تحديث المعلومات الاساسية";
					}
				}else{
					$data[$i]['error'] = 1;
					$data[$i]['message_title'] = "تنبيه !";
					$data[$i]['error_message'] = "اسم الحساب قصير";
				}
			}else{
				$data[$i]['error'] = 1;
				$data[$i]['message_title'] = "تنبيه !";
				$data[$i]['error_message'] = "اسم الحساب (اسم المستخدم) مستخدم في حساب آخر يرجى كتابة اسم حساب جديد";
			}
		}else{
			$data[$i]['error'] = 1;
			$data[$i]['message_title'] = "تنبيه !";
			$data[$i]['error_message'] = "يجب ملء جميع الحقول";
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