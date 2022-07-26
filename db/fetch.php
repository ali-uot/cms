<?php
class fetch_dept{
	public $connect = "";
	public function __construct($c){
		$this->connect = $c;
	}
	public function _secure($data){
		$connect = $this->connect;
		$val = mysqli_real_escape_string($connect, $data);
		return $val;
	}
	
	public function get_dept_name_by_id($id, $l){
		$res = "";
		if($l == "ar"){
			$res = "كلية آشور الجامعة";
			$field = "A_dept_name";
		}else{
			$res = "Ashur University";
			$field = "E_dept_name";
		}
		if($id != 1){
			global $connect;
			$s = "select $field from departments where id_dept='$id'";
			$q = mysqli_query($connect, $s);
			$row = mysqli_fetch_array($q);
			$res = $row[$field];
		}
		return $res;
	}
	public function fetch_all_in_table($tb_name, $columns, $coditions){
		$connect = $this->connect;
		$str = implode (", ", $columns);
		$s = "select $str from $tb_name $coditions";
		$q = mysqli_query($connect, $s);
		$n = mysqli_num_rows($q);
		$dept_arr = array();
		if($n > 0){
			$i = 1;
			$l = count($columns);
			while($row = mysqli_fetch_array($q)){
				$dept_arr[$i] = array();
				for($j = 0;$j<$l;$j++){
					$var_name = $columns[$j];
					$dept_arr[$i][$var_name] = $row[$var_name];
				}
				$dept_arr[$i]['error'] = "0";
				$i++;
			}
			
		}else{
			$dept_arr[0]['error'] = "1";
		}
		$res = json_encode($dept_arr);
		return $res;
	}
	
}
?>