<?php
class fetch_json{
	public $connection_string = "";
	public function __construct($c){
		$this->connection_string = $c;
	}
	public function _secure($var){
		$connection_string = $this->connection_string;
		return mysqli_real_escape_string($connection_string, $var);
	}
	public function fetch($table, $columns, $where){
		$connection_string = $this->connection_string;
		
		date_default_timezone_set("Asia/Baghdad");
		$current_date = date('Y/m/d&h:i:s_A');
		
		$data = Array();
		$i = 0;
		$data[$i] = array();
		
		$where = " where 1=1 and ".$where;
		$columns_list = implode(', ', $columns);
		$s = "select $columns_list from $table $where";
		$query = mysqli_query($connection_string, $s);
		$n = mysqli_num_rows($query);
		$data[$i]['num_content'] = $n;
		$data[$i]['error'] = 0;
		if($n > 0){
			$data[$i]['error'] = 0;
			while($row_tb = mysqli_fetch_array($query)){
			
				$s = "SHOW COLUMNS from $table";
				$q = mysqli_query($connection_string, $s);

				while($r = mysqli_fetch_array($q)){
					if($columns[0] == "*"){
						$row_tb[$r[0]];
						$data[$i][$r[0]] = $row_tb[$r[0]];
					}else{
						if(in_array($r[0], $columns)){
							$row_tb[$r[0]];
							$data[$i][$r[0]] = $row_tb[$r[0]];
						}
					}
				}
				$i++;
			}
		}else{
			$data[$i]['error'] = 1;
			$data[$i]['error_message'] = "القيد غير متوفر";
		}
		$out = array_values($data);
		$out = json_encode($out, JSON_UNESCAPED_UNICODE);
		return $out;
	}
}
?>