var dialog_title = document.getElementById('dialog_title');
var dialog_content = document.getElementById('dialog_content');
var delete_dialog_title = document.getElementById('delete_dialog_title');
var delete_dialog_content = document.getElementById('delete_dialog_content');
var id_design_deleted;
function delete_video(id_design, id){
	id_design_deleted = id_design;
	var formdata = new FormData();
	formdata.append("id", id);
	var ajax = new XMLHttpRequest();
	ajax.addEventListener("load", ResponseDeleteStu, false);
	ajax.open("POST", "delete_video.php");
	ajax.send(formdata);
}
function ResponseDeleteStu(event){
	var s = event.target.responseText;
	var res = JSON.parse(s);
	$('#delete').modal('hide');
	if(res[0].error == 0){
		field_verify('modal_head', 1);
		$( "#"+id_design_deleted ).hide();
	}else{
		field_verify('modal_head', 0);
	}
	dialog_title.innerHTML = res[0].message_title;
	dialog_content.innerHTML = res[0].error_message;
	$('#warning').modal('show');
}