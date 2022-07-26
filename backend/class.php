<?php
class class_admin extends TokenLogin{
	public $connect_learning;
	public function __construct($connect_learning){
		$this->connect_learning = $connect_learning;
	}
	public function id_by_token($token){
		$secret = "gF4TLndtS2L2zr6Y";
		$otl = new TokenLogin($secret);
		$token_arr = $otl->validate_token($token);
		$user_id = $token_arr -> uid;
		$user_type = $token_arr -> utype;
		return $user_id;
	}
	public function basic($token){
		$connect_learning = $this->connect_learning;
		$id_admin = $this->id_by_token($token);
		$data = Array();
		$i = 0;
		$data[$i] = array();
		if($id_admin >0){
			date_default_timezone_set("Asia/Baghdad");
			$current_time = date('Y/m/d&h:i:s_A');
			
			$s = "select * from admin where id='$id_admin' limit 1";
			$q = mysqli_query($this->connect_learning, $s);
			$n = mysqli_num_rows($q);
			if($n > 0){
				
				$s = "update admin set last_login='$current_time' where id='$id_admin'";
				mysqli_query($connect_learning, $s);
				
				
				$row_user = mysqli_fetch_array($q);
				
				$data[$i]['error'] = 0;
				$data[$i]['id_admin'] = $id_admin;
				$data[$i]['error_message'] = "تم تسجيل الدخول";
				
				$s = "SHOW COLUMNS from admin";
				$q = mysqli_query($connect_learning, $s);

				while($r = mysqli_fetch_array($q)){
					if($r[0] != "password"){
						$row_user[$r[0]];
						$data[$i][$r[0]] = $row_user[$r[0]];
					}
				}
			}else{
				$data[$i]['error'] = 1;
				$data[$i]['error_message'] = "1 يجب تسجيل الدخول اولاً";
			}
		}else{
			$data[$i]['error'] = 1;
			$data[$i]['error_message'] = "2 يجب تسجيل الدخول اولاً";
		}
		$out = array_values($data);
		return json_encode($out, JSON_UNESCAPED_UNICODE);
	}
}
?>