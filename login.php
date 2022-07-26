<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="viewport" content="width=1,initial-scale=1,user-scalable=1" />
<title>Login</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="shortcut icon" href="images/loginIcon.png" />
<!-- Title -->
<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css" />
<link rel="stylesheet" type="text/css" href="bootstrap-rtl-master/dist/css/bootstrap-rtl.min.css" />

<style>
.droid_me{
	font-family: 'Droid Arabic Kufi', sans-serif;
}
body {
	font-family: 'Droid Arabic Kufi', sans-serif;
	background: #e2e2e9;
}
.container{
	margin-top:30px;
	margin-bottom:30px;
	padding:15px;
	padding-bottom:50px;
	border-radius:5px;
	background:#f2f2f2;
	font-size:18px;
	text-align:center;
	color:#000;
	font-weight:700;
}
#btn{
	font-size:22px;
	text-align:center;
	color:#0f0;
	font-weight:700;
}
h4{
	font-weight:700;
	font-size:32px;
}
.top_space{
	margin-top:3px;
}
.banner{
	background:#e2e2e9;
	color:#000;
	padding:8px 0px 8px 0px;
	border-top-left-radius:5px;
	border-top-right-radius:5px;
}
#e, #p{
	height:42px;
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
		min-width:130px;
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
		min-width:140px;
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
		min-width:140px;
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
		font-size:16px;
		text-align:center;
		background:#ccc;
	}
	td{
		font-size:14px;
	}
	.input-group-addon{
		min-width:140px;
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
	<section class="container">
		<h1><img src="images/loginIcon.png" class="logo"></h1>
		<div class="row" >
			<div class="col-md-6 col-md-offset-3 banner">
				لوحة تسجيل الدخول
			</div>
		</div>
		<div class="row" style="margin-top:3px;">
			<div class="col-md-6 col-md-offset-3">
				<div class="input-group">
					<span class="input-group-addon droid_me">
					اسم الحساب
					</span>
					<input type="email" placeholder="اكتب اسم الحساب" class="form-control form-control-lg" id="e" dir="rtl">
					</select>
				</div>
			</div>
		</div>
		
		<div class="row top_space">
			<div class="col-md-6 col-md-offset-3">
				<div class="input-group">
					<span class="input-group-addon droid_me">كلمة المرور</span>
					<input type="password" placeholder="اكتب كلمة المرور" class="form-control form-control-lg" id="p" dir="rtl">
					</select>
				</div>
			</div>
		</div>
		<div class="row top_space">
			<div class="col-md-6 col-md-offset-3">
				<button class="btn btn-success btn-block droid_me" onclick="login();"> تسجيل الدخول </button>
			</div>
		</div>
	</section>
	




	<div class="modal fade mod_marg"  id="warning" role="dialog" dir="rtl">
			<div class="modal-dialog">
					<div class="modal-content">
							<div class="modal-header bg-danger">
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
	
<script>
function login(){
	var e = document.getElementById('e').value;
	var p = document.getElementById('p').value;
	var formdata = new FormData();
	formdata.append("e", e);
	formdata.append("p", p);
	var ajax = new XMLHttpRequest();
	ajax.addEventListener("load", completeLogin, false);
	ajax.open("POST", "backend/login.php");
	ajax.send(formdata);
}

function completeLogin(event){
	var s = event.target.responseText;
	var dialog_title = document.getElementById('dialog_title');
	var dialog_content = document.getElementById('dialog_content');
	var res = JSON.parse(s);
	var error = res[0].error;
	if(error == 0){
		window.location.href = 'admin/index.php';
	}else{
		dialog_title.innerHTML = res[0].message_title;
		dialog_content.innerHTML = res[0].error_message;
		$('#warning').modal('show');
	}
	
}
</script>
<script src="bootstrap/jquery-3.6.0.min.js" type="text/javascript"></script>
<script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
</body>