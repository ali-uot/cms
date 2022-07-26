<?php
include("../classes/cookies.php");
$obj_cookie = new cookies(360);
$obj_cookie->destroy_cookie("AdminToken");
header("location:../login.php");
?>