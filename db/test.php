<?php
include("cryptography.php");
$key = "2022/07/22&09:28:42_PM";
$data = "123456";
$cryptography_obj = new cryptography($key);
$password = $cryptography_obj->encryptIt($data);
echo $password;
?>