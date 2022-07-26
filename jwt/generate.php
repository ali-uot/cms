<?php
require_once("token/TokenLogin.php");
$secret = "test_app";
$otl = new TokenLogin($secret);
$user_id = 32487;
$user_type = "student";
$token = $otl->create_token($user_id, $user_type, 360);
echo $token;
?>