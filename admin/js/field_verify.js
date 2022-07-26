function field_verify(id, v){
	var sign = _(id);
	if(v == 1){
		sign.classList.remove("bg-danger");
		sign.classList.add("bg-success");
	}else{
		sign.classList.remove("bg-success");
		sign.classList.add("bg-danger");
	}
}