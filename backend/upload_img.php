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

function upload_img($image, $id_student){
	global $connect_learning;
	$res_img = 0;
	date_default_timezone_set("Asia/Baghdad");
	$image_current_time = date('Y_m_d!h_i_s');
	
	$image = _secure($_POST['image']);
	$img_data = $_POST['image'];
	$image_array_1 = explode(";", $img_data);
	$image_array_2 = explode(",", $image_array_1[1]);
	$img_data = base64_decode($image_array_2[1]);
	$image_name = 'pics/students/'.$id_student.'_'.$image_current_time.'.png';
	$image_path = '../../pics/students/'.$id_student.'_'.$image_current_time.'.png';
	if(file_put_contents($image_path, $img_data)){
		$up = "update students set image='$image_name' where id='$id_student'";
		$q = mysqli_query($connect_learning, $up);
		if($q === false){
			$res_img = 1;
		}
	}else{
		$res_img = 1;
	}
	return $res_img;
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
		$res_img = 0;
		if(!empty($_POST['image'])){
			$res_img = upload_img($_POST['image'], $id_student);
			if($res_img == 1){
				$data[$i]['error'] = 1;
				$data[$i]['message_title'] = "تنبيه !";
				$data[$i]['error_message'] = "لم تتم عملية تحميل الصورة";
			}else{
				$username = $result[0]['username'];
				$basic_info = $result[0]['basic_info'];
				$E_name = $result[0]['E_name'];
				$gender = $result[0]['gender'];
				$birth_date = $result[0]['birth_date'];
				if($basic_info == 0 && strlen($E_name)>3 && strlen($username)>3 && strlen($birth_date)>5 && ($gender == "m" or $gender == "f")){
					$up = "update students set basic_info=1 where id='$id_student'";
					$q = mysqli_query($connect_learning, $up);
					if($q === true){
						$data[$i]['basic_info'] = 1;
					}
				}
				$data[$i]['error'] = 0;
				$data[$i]['message_title'] = "تم";
				$data[$i]['error_message'] = "تم تحديث الصورة الشخصية";
			}
		}else{
			$data[$i]['error'] = 1;
			$data[$i]['message_title'] = "تنبيه !";
			$data[$i]['error_message'] = "يجب اختيار و قص الصورة اولاً";
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