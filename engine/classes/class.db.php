<?
// Anti-hack
if(!defined('RCE')){
	die('Hacking attempt!');
}

class db {
	// Single query function
	// Ex: $db->select("SELECT...",['title'],['desc'],['0,12']);
	// Params with [brackets] not important to set, may be empty
	function select($query,$order_by,$order_is,$limits){
		// Checking order data
		if($order_by==''){
			$ord='';
		} else {
			if($order_is==''){
				$ord_is='ASC';
			} else {
				if($order_is=='asc'){
					$ord_is='ASC';
				} elseif($order_is=='desc') {
					$ord_is='DESC';
				} else {
					$ord_is='ASC';
				}
			}
			$ord=' ORDER BY `'.$order_by.'` '.$ord_is.'';
		}
		// Checking limits data
		if($limits==''){
			$lim='';
		} else {
			$lim=' LIMIT '.$limits;
		}
		// Checking query type
		$r=mysql_query($query.$ord.$lim);
		$f=mysql_fetch_array($r);
		return $f;
	}
	// Multiple row query function
	// Ex: $db->select_list('SELECT...query here',['title'],['desc'],['0,12']);
	// Params with [brackets] not important to set, may be empty
	function select_list($query,$order_by,$order_is,$limits){
		// Checking order data
		if($order_by==''){
			$ord='';
		} else {
			if($order_is==''){
				$ord_is='ASC';
			} else {
				if($order_is=='asc'){
					$ord_is='ASC';
				} elseif($order_is=='desc') {
					$ord_is='DESC';
				} else {
					$ord_is='ASC';
				}
			}
			$ord=' ORDER BY `'.$order_by.'` '.$ord_is.'';
		}
		// Checking limits data
		if($limits==''){
			$lim='';
		} else {
			$lim=' LIMIT '.$limits;
		}
		// Running query
		$r=mysql_query($query.$ord.$lim);
		$arr=array();
		for($i=0;$i<mysql_num_rows($r);$i++){
			$f=mysql_fetch_array($r);
				$arr[$i]=$f;
		}
		return $arr;
	}
	// Insert query function
	// Ex: $db->insert('table_name','param_array');
	function insert($table,$data){
		$j=0;
		$c=count($data);
		foreach($data as $key=>$value){
			$j++;
			if($c==$j){
				$line_1.='`'.$key.'`';
				$line_2.="'".rce_remove_quotes(mysql_real_escape_string($value))."'";
			} else {
				$line_1.='`'.$key.'`, ';
				$line_2.="'".rce_remove_quotes(mysql_real_escape_string($value))."', ";
			}
		}
		$r=mysql_query("
			INSERT INTO `$table`
			(".$line_1.") VALUES
			(".$line_2.")
		");
		return $r;
	}
	// Update values in table
	// Ex: $db->update('table_name','data_array','id_where');
	function update($table,$data,$where){
		$j=0;
		$c=count($data);
		foreach($data as $key=>$value){
			$j++;
			if($c==$j){
				$list.="`$key`='".$value."'";
			} else {
				$list.="`$key`='".$value."', ";
			}
		}
		$r=mysql_query("
			UPDATE `$table` SET
			$list 
			WHERE $where
			LIMIT 1
		");
		return $r;
	}
	// Count rows function
	// Ex: $db->count('SELECT...');
	function count($query){
		$r=mysql_query($query);
		$count=mysql_num_rows($r);
		return $count;
	}
	// Delete row
	// Ex: $db->delete('table','where');
	function delete($table,$where){
		$r=mysql_query("DELETE FROM `$table` WHERE $where");
	}
	// Clear table!
	// Ex: $db->clear('table');
	function clear($table){
		$r=mysql_query("TRUNCATE `$table`");
	}
	// Get next Auto increment
	// Ex: $db->get_next('table');
	function getnext($table){
		$r=mysql_query("SHOW TABLE STATUS LIKE '$table'");
		$f=mysql_fetch_array($r);
		return $f['Auto_increment'];
	}
}

?>