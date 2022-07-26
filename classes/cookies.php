<?php
class cookies{
	public $days;
	public function __construct($days){
		$this->days = $days;
	}
	public function create_cookie($name, $token){
		$days = $this->days;
		$now = time();
		setcookie($name, $token, $now + 24 * (60 * 60 * $days), '/');
	}
	public function destroy_cookie($name){
		$days = $this->days;
		$now = time();
		setcookie($name, "", $now - 24 * (60 * 60 * $days), '/');
	}
}
?>