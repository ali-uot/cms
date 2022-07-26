<?php
ob_start();
require_once('../jwt/token/vendor/autoload.php');
use \Firebase\JWT\JWT;

include("../db/config.php");
include("../db/cryptography.php");
require_once("../jwt/token/TokenLogin.php");
include('../backend/class.php');
function _secure($var){
	global $connect;
	return mysqli_real_escape_string($connect, $var);
}
if(!empty($_POST['token']) or !empty($_COOKIE['AdminToken'])){
	if(!empty($_POST['token'])){
		$token = _secure($_POST['token']);
	}else{
		$token = _secure($_COOKIE['AdminToken']);
	}
	$obj = new class_admin($connect);
	$a = $obj->basic($token);
	$result = json_decode($a, true);
	$error = $result[0]['error'];
	if($error != 0){
		header("location: ../backend/logout.php");
	}
	
}else{
	header("location: ../login.php");
}
?>
<!DOCTYPE html>
<html>
    <head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="shortcut icon" href="../images/cms.png" />
        <!-- Title -->
        <title>CMS</title>

		<link rel="stylesheet" type="text/css" href="../bootstrap/css/bootstrap.min.css" />
		<link rel="stylesheet" type="text/css" href="../bootstrap-rtl-master/dist/css/bootstrap-rtl.min.css" />
	
<style>
body{
	font-family: 'Droid Arabic Kufi', sans-serif;
	background: #e2e2e9;
}
.container{
	margin-top:30px;
	margin-bottom:30px;
	padding-top:55px;
	padding-bottom:55px;
	border-radius:5px;
	background:#f2f2f2;
	font-size:18px;
	text-align:center;
	color:#000;
	font-weight:700;
}

#logout{
	float:right;
	cursor: pointer;
}
#settings{
	float:left;
	cursor: pointer;
}
.pointer{
	font-size:20px;
	cursor: pointer;
}
.my_box{
	font-family: 'Droid Arabic Kufi', sans-serif;
	padding-top: 30px;
	padding-bottom: 30px;
	border:2px #09086f solid;
	cursor:pointer;
	background:#fff;
	color:#000;
}
.my_box:hover{
	background:#09086f;
	color:#000;
	color:#fff;
}
.logo{
	margin-bottom:30px;
}
</style>
<style>
@media only screen and (min-width:100px){
	.logo{
		width:100px;
	}
	th{
		font-size:9px;
		text-align:center;
		background:#ccc;
	}
	td{
		font-size:9px;
	}
	.input-group-addon{
		min-width:120px;
		font-size:13px;
		font-weight:bold;
	}
	option{
		font-size:9px;
	}
	.loader{
		width: 70px;
		height: 70px;
	}
	.logo_img{
		height:90px;
		width:90px;
		border-radius:100%;
	}
	#header_txt{
		font-size:14px;
	}
}

@media only screen and (min-width:500px){
	.logo{
		width:100px;
	}
	th{
		font-size:9px;
		text-align:center;
		background:#ccc;
	}
	td{
		font-size:9px;
	}
	.input-group-addon{
		min-width:120px;
		font-size:13px;
		font-weight:bold;
	}
	option{
		font-size:12px;
	}
	.loader{
		width: 80px;
		height: 80px;
	}
	.logo_img{
		height:70px;
		width:70px;
		border-radius:100%;
	}
	#header_txt{
		font-size:16px;
	}
}

@media only screen and (min-width:700px){
	.logo{
		width:150px;
	}
	th{
		font-size:14px;
		text-align:center;
		background:#ccc;
	}
	td{
		font-size:12px;
	}
	.input-group-addon{
		min-width:120px;
		font-size:14px;
		font-weight:bold;
	}
	option{
		font-size:14px;
		font-weight:bold;
	}
	.loader{
		width: 110px;
		height: 110px;
	}
	.logo_img{
		height:150px;
		width:150px;
		border-radius:100%;
	}
	#header_txt{
		font-size:18px;
	}
}

@media only screen and (min-width:900px){
	.logo{
		width:150px;
	}
	th{
		font-size:18px;
		text-align:center;
		background:#ccc;
	}
	td{
		font-size:16px;
	}
	.input-group-addon{
		min-width:120px;
		font-size:14px;
		font-weight:bold;
	}
	option{
		font-size:16px;
		font-weight:bold;
	}
	.loader{
		width: 120px;
		height: 120px;
	}
	.logo_img{
		height:150px;
		width:150px;
		border-radius:100%;
	}
	#header_txt{
		font-size:20px;
	}
}

</style>
	</head>
	<body>
		<div class="container">
		<i title="تسجيل الخروج" class="glyphicon glyphicon-log-out" id="logout" onclick="window.location.href='../backend/logout.php'"></i>

			<div class="row">
					<div class="col-md-4 col-md-offset-4" >
						<img src="../images/cms.png" class="logo">
					</div>
					<div class="col-md-12" >
					</div>
			</div>
			
			<div class="row">
				<div class="col-md-2 col-xs-4 ">
					<button class="form-control" onclick="new_album();"> اضافة موقع <span class="glyphicon glyphicon-plus"></span></button>
				</div>
				<div class="col-md-2 col-xs-4 col-md-offset-8 col-xs-offset-4 ">
					<button class="form-control" onclick="window.open('../index.php')"> معاينة <span class="glyphicon glyphicon-eye-open"></span></button>
				</div>
			</div>
			
			
			<div class="row" style="margin-top:30px;">
					<div class="col-md-10 col-md-offset-1" id="disp_res">
					
					
					</div>
			</div>
		</div>
		
		
	<div class="modal fade mod_marg" id="new_album" role="dialog" dir="rtl">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
						<h4 class="modal-title">اضافة موقع جديد</h4>
				</div>
				<div class="modal-body" style="text-align:right;">
				
					<div class="row">
						<div class="col-md-10 col-md-offset-1">
							<div class="input-group">
								<span class="input-group-addon">عنوان الموقع</span>
								<input type="text" class="form-control" id="A_site_title" placeholder="اكتب عنوان الموقع">
							</div>
						</div>
						<div class="col-md-10 col-md-offset-1">
							<div class="input-group">
								<span class="input-group-addon">رابط الموقع</span>
								<input type="text" class="form-control" id="site_link" placeholder="اكتب رابط الموقع">
							</div>
						</div>
					</div>
					<br>
					<div class="row">
						<div class="col-md-10 col-md-offset-1">
							<button class="form-control btn btn-primary" onclick="add_album();">اضافة الموقع</button>
						</div>
					</div>
					
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-primary pull-right" data-dismiss="modal">اغلاق</button>
				</div>
			</div>
		</div>
	</div>
		
	<div class="modal fade mod_marg" id="delete" tabindex="-1" role="dialog" aria-labelledby="basicModalLabel3">
		<div class="modal-dialog modal-dialog-centered" role="document">
			<div class="modal-content">
				<div class="modal-header bg-danger white">
				<span class="modal-title mf_sub_title" id="delete_dialog_title"></span>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">×</span>
					</button>
				</div>
				<div class="modal-body">
					<p id="delete_dialog_content"></p>
				</div>
				<div class="modal-footer">
					<button type="button" id="close_delete_dialog" class="btn grey btn-secondary bule pull-right" data-dismiss="modal">اغلاق</button>
					<button type="button" id="yes_delete" class="btn btn-danger pull-left">حذف</button>
				</div>
			</div>
		</div>
	</div>

		

	<div class="modal fade mod_marg" id="warning" role="dialog" dir="rtl">
			<div class="modal-dialog">
					<div class="modal-content">
							<div class="modal-header bg-danger" id="modal_head">
									<h5 class="modal-title" id="dialog_title"></h5>
							</div>
							<div class="modal-body" style="text-align:right;">
								<p id="dialog_content"></p>

							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-primary pull-right" data-dismiss="modal">اغلاق</button>
							</div>
					</div>
			</div>
	</div>
		

		
	<div class="modal fade mod_marg"  id="Edit_album" role="dialog" dir="rtl">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
						<h4 class="modal-title">تعديل على الموقع</h4>
				</div>
				<div class="modal-body" style="text-align:right;">
					<input type="hidden" id="Edit_id_album">
					<div class="row">
						<div class="col-md-10 col-md-offset-1">
							<div class="input-group">
								<span class="input-group-addon">عنوان الموقع</span>
								<input type="text" class="form-control" id="Edit_A_site_title" placeholder="اكتب عنوان الموقع">
							</div>
						</div>
						<div class="col-md-10 col-md-offset-1">
							<div class="input-group">
								<span class="input-group-addon">Album Title</span>
								<input type="text" class="form-control" id="Edit_site_link" placeholder="Enter album title">
							</div>
						</div>
					</div>
					<br>
					<div class="row">
						<div class="col-md-10 col-md-offset-1">
							<button class="form-control btn btn-primary" onclick="edit_album();">تعديل الموقع</button>
						</div>
					</div>
					
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-primary pull-right" data-dismiss="modal">اغلاق</button>
				</div>
			</div>
		</div>
	</div>
<script>
function _(el){
	return document.getElementById(el);
}
var dialog_title = _('dialog_title');
var dialog_content = _('dialog_content');
</script>
		
<script>
function new_video(){
	$('#new_video').modal('show');
}
function new_album(){
	$('#new_album').modal('show');
}
</script>

<script>
function add_album(){
	var A_site_title = _('A_site_title').value;
	var site_link = _('site_link').value;
	if(A_site_title.length>3 && site_link.length>3){
		var formdata = new FormData();
		formdata.append("A_site_title", A_site_title);
		formdata.append("site_link", site_link);
		var ajax = new XMLHttpRequest();
		ajax.addEventListener("load", completeAlbum, false);
		ajax.open("POST", "add_album.php");
		ajax.send(formdata);
	}else{
		field_verify('modal_head', 0);
		dialog_title.innerHTML = "تنبيه !";
		dialog_content.innerHTML = "يجب كتابة عنوان الموقع بالعربية و الانكليزية";
		$('#warning').modal('show');
	}
}

function completeAlbum(event){
	var s = event.target.responseText;
	var res = JSON.parse(s);
	var error = Number(res[0].error);
	if(error == 0){
		field_verify('modal_head', 1);
		dialog_title.innerHTML = res[0].message_title;
		dialog_content.innerHTML = res[0].error_message;
		$('#warning').modal('show');
		fetch_album();
		//_('video_title').value = "";
	}else{
		field_verify('modal_head', 0);
		dialog_title.innerHTML = res[0].message_title;
		dialog_content.innerHTML = res[0].error_message;
		$('#warning').modal('show');
	}
}


</script>
<script>
function fetch_album(){
	var formdata = new FormData();
	var ajax = new XMLHttpRequest();
	ajax.addEventListener("load", completeFetch, false);
	ajax.open("POST", "fetch_album.php");
	ajax.send(formdata);
}

function completeFetch(event){
	var s = event.target.responseText;
	var res = JSON.parse(s);
	var error = Number(res[0].error);
	if(error == 0){
		var num_content = Number(res[0].num_content);
		if(num_content > 0){
			var A_site_title;
			var site_link;
			var id_album;
			var delete_type = "video_album";
			var output = '';
			output = output+'<table class="table">'+
			'<thead class="thead-dark">'+
			'<thead class="thead-dark">'+
				'<tr>'+
					  '<th scope="col">#</th>'+
					  '<th scope="col">عنوان الموقع</th>'+
					  '<th scope="col">رابط الموقع</th>'+
					  '<th scope="col"><span class="glyphicon glyphicon-cog"></span></th>'+
				'</tr>'+
			'</thead>'+
			'<tbody>';
			
			var counter = 1;
			for(var i = 0 ;i<num_content;i++){
				id_album = res[i].id;
				A_site_title = res[i].A_site_title;
				site_link = res[i].site_link;
				
				output = output+'<tr>'+
					  '<td scope="col">'+counter+'</td>'+
					  '<td scope="col">'+A_site_title+'</td>'+
					  '<td scope="col"><span class="glyphicon glyphicon-link text-warning pointer"'+
							' onclick="window.open(\''+site_link+'\')"></span></td>'+
					  '<td scope="col">'+
							'<span class="glyphicon glyphicon-edit text-warning pointer"'+
							' onclick="this_album('+id_album+');"></span>'+
							'&nbsp;&nbsp;&nbsp;'+
							'<span class="glyphicon glyphicon-trash text-danger pointer"'+
								' onclick="delete_manager('+id_album+', \''+delete_type+'\', '+id_album+');" style="margin-right:20px;">'+
							'</span>'+
					  '</td>'+
				'</tr>';
				counter++;
			}
			output = output+'</tbody>'+
			'</table>';
			_('disp_res').innerHTML = output;
		}
	}
}
fetch_album();

</script>

<script>
function this_album(id){
	var formdata = new FormData();
	formdata.append("id", id);
	var ajax = new XMLHttpRequest();
	ajax.addEventListener("load", completeThisAlbum, false);
	ajax.open("POST", "this_album.php");
	ajax.send(formdata);
}
function completeThisAlbum(event){
	var s = event.target.responseText;
	var res = JSON.parse(s);
	var error = Number(res[0].error);
	if(error == 0){
		var num_content = Number(res[0].num_content);
		if(num_content > 0){
			var A_site_title;
			var site_link;
			var id_album;
			var delete_type = "video_album";
			
			var counter = 1;
			for(var i = 0 ;i<num_content;i++){
				id_album = res[i].id;
				A_site_title = res[i].A_site_title;
				site_link = res[i].site_link;
				_('Edit_A_site_title').value = A_site_title;
				_('Edit_site_link').value = site_link;
				_('Edit_id_album').value = id_album;
				$('#Edit_album').modal('show');
			}
		}
	}
}
</script>


<script>
function edit_album(){
	var id_album = _('Edit_id_album').value;
	var A_site_title = _('Edit_A_site_title').value;
	var site_link = _('Edit_site_link').value;
	if(A_site_title.length>3 && site_link.length>3){
		var formdata = new FormData();
		formdata.append("id_album", id_album);
		formdata.append("A_site_title", A_site_title);
		formdata.append("site_link", site_link);
		var ajax = new XMLHttpRequest();
		ajax.addEventListener("load", completeEditAlbum, false);
		ajax.open("POST", "edit_album.php");
		ajax.send(formdata);
	}else{
		field_verify('modal_head', 0);
		dialog_title.innerHTML = "تنبيه !";
		dialog_content.innerHTML = "يجب كتابة عنوان الموقع بالعربية و الانكليزية";
		$('#warning').modal('show');
	}
}

function completeEditAlbum(event){
	var s = event.target.responseText;
	var res = JSON.parse(s);
	var error = Number(res[0].error);
	if(error == 0){
		field_verify('modal_head', 1);
		dialog_title.innerHTML = res[0].message_title;
		dialog_content.innerHTML = res[0].error_message;
		$('#warning').modal('show');
		fetch_album();
		//_('video_title').value = "";
	}else{
		field_verify('modal_head', 0);
		dialog_title.innerHTML = res[0].message_title;
		dialog_content.innerHTML = res[0].error_message;
		$('#warning').modal('show');
	}
}


</script>

<script src="../bootstrap/jquery-3.6.0.min.js" type="text/javascript"></script>
<script>
// this for z-index multi modal
$(document).on('show.bs.modal', '.modal', function() {
	const zIndex = 1040 + 10 * $('.modal:visible').length;
	$(this).css('z-index', zIndex);
	setTimeout(() => $('.modal-backdrop').not('.modal-stack').css('z-index', zIndex - 1).addClass('modal-stack'));
});
</script>

<script src="js/field_verify.js"></script>
<script src="js/delete_manager.js"></script>
<script src="js/delete_video_album.js"></script>
<script src="../bootstrap/js/bootstrap.min.js" type="text/javascript"></script>

</body>
</html>