var delete_dialog_title = document.getElementById('delete_dialog_title');
var delete_dialog_content = document.getElementById('delete_dialog_content');
var id_delete;
var type_delete;
var t_delete;
var id_design_public;
function delete_manager(id_design, t, id){
	id_design_public = id_design;
	t_delete = t;
	id_delete = id;
	delete_dialog_title.innerHTML = "حذف";
	delete_dialog_content.innerHTML = " هل انت متأكد من الحذف ";
	$('#delete').modal('show');
}
$('#yes_delete').click(function(){
	if(t_delete == "video"){
		delete_video(id_design_public, id_delete);
	}else if(t_delete == "video_album"){
		delete_video_album(id_design_public, id_delete);
	}else{
		someFunction2();
	}
});


function someFunction2(){
	//alert("nothing to do");
}