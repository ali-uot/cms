<?php
ob_start();

include("db/config.php");
?>
<!DOCTYPE html>
<html>
    <head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="shortcut icon" href="images/cms.png" />
        <!-- Title -->
        <title>CMS</title>

		<link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css" />
		<link rel="stylesheet" type="text/css" href="bootstrap-rtl-master/dist/css/bootstrap-rtl.min.css" />
	
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
	font-size:10px;
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

		<button id="logout" onclick="window.location.href='login.php'">
			<i title="تسجيل الخروج" class="glyphicon glyphicon-lock"></i>
			لوحة الادارة
		</button>
		
			<div class="row" style="margin-top:30px;">
				<div class="col-md-10 col-md-offset-1">
					 روابط المواقع الالكترونية
				</div>
			</div>
			<div class="row" style="margin-top:30px;">
				<div class="col-md-10 col-md-offset-1" id="disp_res">
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
function fetch_album(){
	var formdata = new FormData();
	var ajax = new XMLHttpRequest();
	ajax.addEventListener("load", completeFetch, false);
	ajax.open("POST", "fetch.php");
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


<script src="bootstrap/jquery-3.6.0.min.js" type="text/javascript"></script>
<script src="bootstrap/js/bootstrap.min.js" type="text/javascript"></script>

</body>
</html>