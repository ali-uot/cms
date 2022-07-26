<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");


include("../db/config.php");
include("../db/cryptography.php");
include("../classes/cookies.php");
require_once("../jwt/token/TokenLogin.php");

require_once('../jwt/token/vendor/autoload.php');
use \Firebase\JWT\JWT;

function _secure($var){
	global $connect;
	return mysqli_real_escape_string($connect, $var);
}

$data = Array();
$i = 0;
$data[$i] = array();


if(isset($_POST['e']) && isset($_POST['p'])){
	$e = _secure($_POST['e']);
	$p = _secure($_POST['p']);
	$s = "select * from admin where username='$e' and active=1 limit 1";
	$q = mysqli_query($connect, $s);
	$n = mysqli_num_rows($q);
	if($n == 1){
		$r = mysqli_fetch_array($q);
		$cryptography_obj = new cryptography($r['create_date']);
		$password = $cryptography_obj->decryptIt($r['password']);
		if($password == $p){
			$secret = "gF4TLndtS2L2zr6Y";
			$otl = new TokenLogin($secret);
			$user_id = $r['id'];
			$user_type = "AdminToken";
			date_default_timezone_set("Asia/Baghdad");
			$current_time = date('Y/m/d&h:i:s_A');
			$s = "update admin set last_login='$current_time' where id='$user_id'";
			$q = mysqli_query($connect, $s);
			
			
			$token = $otl->create_token($user_id, $user_type, 360);
			$obj_cookie = new cookies(360);
			$obj_cookie->create_cookie("AdminToken", $token, 360);
			$data[$i]['error'] = 0;
			$data[$i]['message_title'] = "تم";
			$data[$i]['error_message'] = "تم تسجيل الدخول";
			$data[$i]['id_stu'] = $user_id;
			$data[$i]['token'] = $token;
		}else{
			$data[$i]['error'] = 1;
			$data[$i]['message_title'] = "تنبيه !";
			$data[$i]['error_message'] = "خطأ في اسم الحساب او كلمة المرور";
		}
	}else{
		$data[$i]['error'] = 1;
		$data[$i]['message_title'] = "تنبيه !";
		$data[$i]['error_message'] = "خطأ في اسم الحساب او كلمة المرور";
	}
}else{
	$data[$i]['error'] = 1;
	$data[$i]['message_title'] = "تنبيه !";
	$data[$i]['error_message'] = "يجب ادخال اسم الحساب و كلمة المرور";
}
$out = array_values($data);
echo json_encode($out, JSON_UNESCAPED_UNICODE);
?>