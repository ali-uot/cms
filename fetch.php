<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Origin,  Access-Control-Allow-Headers, Authorization, X-Requested-With");

include("db/config.php");
include("db/fetch_json.php");

function _secure($var){
	global $connect;
	return mysqli_real_escape_string($connect, $var);
}

date_default_timezone_set("Asia/Baghdad");
$current_time = date('Y/m/d&h:i:s_A');

$data = Array();
$i = 0;
$data[$i] = array();

$table = "website";
//$columns = array("*");
$columns = array("id", "A_site_title", "site_link");
$where = "active=1";

$obj_fetch = new fetch_json($connect);
$d = $obj_fetch->fetch($table, $columns, $where);
$data = json_decode($d);

$out = array_values($data);
echo json_encode($out, JSON_UNESCAPED_UNICODE);
?>