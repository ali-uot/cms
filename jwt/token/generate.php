<?php

require_once("TokenLogin.php");
$secret = "kawaz_app";
$otl = new TokenLogin($secret);

$uid = 20;
$utype = 'admin';
$token = $otl->create_token($uid, $utype);

// $url = "http://www.example.com/tl.php?t=$token";
//$url = "http://maj-daniel.majanit.com/projects/php-jwt-login/tl.php?t=$token";
$url = "$token";

echo $url;
exit;
