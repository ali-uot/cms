<?php
include("../../../db/config.php");
include("../../../db/cryptography.php");
require_once("../../jwt/token/TokenLogin.php");
include("../../classes/cookies.php");
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
	$key = $result[0]['create_date'];
	if($error == 0){
		$id_student = $result[0]['id'];
		if(!empty($_POST['p_password']) && !empty($_POST['n_password']) && !empty($_POST['r_password'])){
			$p_password = _secure($_POST['p_password']);
			$n_password = _secure($_POST['n_password']);
			$r_password = _secure($_POST['r_password']);
			$s = "select password from students where id='$id_student'";
			$q = mysqli_query($connect_learning, $s);
			$r = mysqli_fetch_array($q);
			$password = $r['password'];
			$cryptography_obj = new cryptography($key);
			$dc = $cryptography_obj->decryptIt($password);
			if($dc == $p_password){
				if(strlen($n_password) > 5 or strlen($r_password) > 5){
					if($n_password == $r_password){
						$c = $cryptography_obj->encryptIt($n_password);
						$up = "update students set password='$c' where id='$id_student'";
						$q = mysqli_query($connect_learning, $up);
						if($q === false){
							$data[$i]['error'] = 1;
							$data[$i]['message_title'] = "تنبيه !";
							$data[$i]['error_message'] = "لم تتم عملية تغيير كلمة المرور";
						}else{
							$obj_cookie = new cookies(360);
							$obj_cookie->destroy_cookie("StudentToken");
							$data[$i]['error'] = 0;
							$data[$i]['message_title'] = "تم";
							$data[$i]['error_message'] = "تم تغيير كلمة";
						}
					}else{
						$data[$i]['error'] = 1;
						$data[$i]['message_title'] = "تنبيه !";
						$data[$i]['error_message'] = "كلمة المرور الجديدة غير متطابقة";
					}
				}else{
					$data[$i]['error'] = 1;
					$data[$i]['message_title'] = "تنبيه !";
					$data[$i]['error_message'] = "كلمة المرور قصيرة";
				}
			}else{
				$data[$i]['error'] = 1;
				$data[$i]['message_title'] = "تنبيه !";
				$data[$i]['error_message'] = "كلمة المرور الحالية خاطئة";
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