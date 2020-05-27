<?
// Update handler
session_start();
// Data connect
include('../connector.php');

// Get action
$action=$_POST['action'];

if(rce_access(rce_get_currentdir(),$action)=='0'){
	rce_error('access_deny');
	rce_log($_SESSION['user']['email'],$action,'Пытался обойти ограничение прав доступа!');
	die('Попытка обойти защиту! Администратор уведомлен о вашем нарушении!<br />Переадресация... <meta http-equiv="refresh" content="3;url=/admin/?module='.rce_get_currentdir().'&status=access_deny">');
}

if($action=='edit'){
	// Post data
	$id=$_POST['id'];
	$data=array(
		'group'=>$_POST['group'],
		'email'=>$_POST['email'],
		'pass'=>$_POST['pass']
	);
	$db=new db();
	$update=$db->update('rce_users',$data,'`ID`=\''.$id.'\' ');
	// Redirect
	rce_log($_SESSION['user']['email'],'edit','Изменил данные пользователя '.$_POST['email']);
	header("Location: /admin/?module=".rce_get_currentdir()."&status=".$action."_ok");
	
} elseif($action=='delete'){
	// Post data
	$id=$_POST['id'];
	$db=new db();
	$delete=$db->delete('rce_users',"`ID`='$id'");
	rce_log($_SESSION['user']['email'],'delete','Удалил пользователя с ID: '.$id);
	header("Location: /admin/?module=".rce_get_currentdir()."&status=".$action."_ok");
	
} elseif($action=='deleteold'){
	// Post data
	$d=0;
	$r=mysql_query("SELECT * FROM `rce_users` ORDER BY `ID` ASC");
	for($i=0;$i<mysql_num_rows($r);$i++){
		$f=mysql_fetch_array($r);
			$check=date_diff(new DateTime(), new DateTime($f['date_visit']))->days;
			if($check>200){
				$rd=mysql_query("DELETE FROM `rce_users` WHERE `ID`='".$f['ID']."'");
				$d++;
			}
	}
	rce_log($_SESSION['user']['email'],'delete','Удалил неактивных пользователей');
	header("Location: /admin/?module=".rce_get_currentdir()."&status=".$action."_ok&d=".$d);
}

?>