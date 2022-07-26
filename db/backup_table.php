<?php
class backup_table{
	public $connection_string = "";
	public function __construct($c){
		$this->connection_string = $c;
	}
	public function _secure($var){
		$connection_string = $this->connection_string;
		return mysqli_real_escape_string($connection_string, $var);
	}
	public function backup($table, $where, $admin_type, $id_admin, $operation){
		$connection_string = $this->connection_string;
		
		date_default_timezone_set("Asia/Baghdad");
		$delete_date = date('Y/m/d&h:i:s_A');
		
		$data = Array();
		$i = 0;
		$data[$i] = array();
		
		$where = " where 1=1 and ".$where;
		$s = "select * from $table $where";
		$q = mysqli_query($connection_string, $s);
		$n = mysqli_num_rows($q);
		if($n > 0){
			$data[$i]['error'] = 0;
			$row_tb = mysqli_fetch_array($q);
			
			$s = "SHOW COLUMNS from $table";
			$q = mysqli_query($connection_string, $s);

			while($r = mysqli_fetch_array($q)){
				$row_tb[$r[0]];
				$data[$i][$r[0]] = $row_tb[$r[0]];
			}
		}else{
			$data[$i]['error'] = 1;
			$data[$i]['error_message'] = "القيد غير متوفر";
		}
		$out = array_values($data);
		$out = json_encode($out, JSON_UNESCAPED_UNICODE);
		$in = "insert into backup_table values('', '$table', '$where', '$out', '$admin_type', '$id_admin', '$operation', '$delete_date')";
		$q = mysqli_query($connection_string, $in);
		if($q === true){
			$data[$i]['error'] = 0;
		}else{
			$data[$i]['error'] = 1;
			$data[$i]['error_message'] = "لم تتم عملية الاحتفاظ بالنسخة";
		}
		$out = array_values($data);
		$out = json_encode($out, JSON_UNESCAPED_UNICODE);
		return $out;
	}
}
?>