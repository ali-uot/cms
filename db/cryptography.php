<?php
class cryptography{
	public $key = "";
	public function __construct($k){
		$this->key = $k;
	}
	public function randomPassword($length){
		$alphabet = 'abcdefghjkmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
		$pass = array(); //remember to declare $pass as an array
		$alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
		for ($i = 0; $i < $length; $i++) {
			$n = rand(0, $alphaLength);
			$pass[] = $alphabet[$n];
		}
		$pass = implode($pass); //convert the array into a string
		$pass = str_replace("I","a", $pass);
		$pass = str_replace("i","b", $pass);
		$pass = str_replace("L","c", $pass);
		return ($pass);
	}
	public function encryptIt($plaintext){
		$key = $this->key;
		$ivlen = openssl_cipher_iv_length($cipher="AES-128-CBC");
		$iv = openssl_random_pseudo_bytes($ivlen);
		$ciphertext_raw = openssl_encrypt($plaintext, $cipher, $key, $options=OPENSSL_RAW_DATA, $iv);
		$hmac = hash_hmac('sha256', $ciphertext_raw, $key, $as_binary=true);
		$ciphertext = base64_encode( $iv.$hmac.$ciphertext_raw );
		return $ciphertext;
	}
	public function decryptIt($ciphertext){
		$key = $this->key;
		$c = base64_decode($ciphertext);
		$ivlen = openssl_cipher_iv_length($cipher="AES-128-CBC");
		$iv = substr($c, 0, $ivlen);
		$hmac = substr($c, $ivlen, $sha2len=32);
		$ciphertext_raw = substr($c, $ivlen+$sha2len);
		$original_plaintext = openssl_decrypt($ciphertext_raw, $cipher, $key, $options=OPENSSL_RAW_DATA, $iv);
		$calcmac = hash_hmac('sha256', $ciphertext_raw, $key, $as_binary=true);
		if(hash_equals($hmac, $calcmac)){
			return $original_plaintext;
		}else{
			return "nothing";
		}
	}
}
/*
$key = "2019/07/13&05:42:31_PM";
$p = "123456";

$cryptography_obj = new cryptography($key);
$c = $cryptography_obj->encryptIt($p);
echo $c.'<br>';
$p2 = $cryptography_obj->decryptIt($c);
echo $p2.'<br>';
*/
?>