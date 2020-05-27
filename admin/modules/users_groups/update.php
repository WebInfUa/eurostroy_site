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

if($action=='add'){
	// Check for same level in DB
	$r=mysql_query("SELECT * FROM `rce_users_groups` WHERE `level`='".$_POST['level']."'");
	if(mysql_num_rows($r)>'0'){
		// Redirect
		rce_log($_SESSION['user']['email'],'error','Пытался добавить группу с уже существующим уровнем доступа ('.$_POST['level'].')');
		header("Location: /admin/?module=users_groups&status=".$action."_errsamelevel");
	} else {
		// Data
		$data=array(
			'title'=>$_POST['title'],
			'level'=>$_POST['level'],
			'style'=>$_POST['style']
		);
		$db=new db();
		$update=$db->insert('rce_users_groups',$data);
		// Creating null access rights
		$r=mysql_query("SELECT * FROM `rce_users_access` WHERE `group`='10' ORDER BY `ID` ASC");
		for($i=0;$i<mysql_num_rows($r);$i++){
			$f=mysql_fetch_array($r);
				$rn=mysql_query("
					INSERT INTO `rce_users_access`
					(`group`,`module`,`action`,`allow`,`title`,`style`) VALUES 
					('".$_POST['level']."','".$f['module']."','".$f['action']."','0','".$f['title']."','".$f['style']."')
				");
		}
		// Redirect
		rce_log($_SESSION['user']['email'],'add','Добавил новую группу ('.$_POST['title'].') с уровнем доступа: '.$_POST['level']);
		header("Location: /admin/?module=".rce_get_currentdir()."&status=".$action."_ok");
	}
	
} elseif($action=='edit'){
	// Check for same level in DB
	$r=mysql_query("SELECT * FROM `rce_users_groups` WHERE `ID`<>'".$_POST['id']."' AND `level`='".$_POST['level']."'");
	if(mysql_num_rows($r)>'0'){
		// Redirect
		rce_log($_SESSION['user']['email'],'error','Пытался присвоить группе уже существующий уровень доступа ('.$_POST['level'].')');
		header("Location: /admin/?module=users_groups&status=".$action."_errsamelevel");
	} else {
		// Post data
		$id=$_POST['id'];
		$data=array(
			'title'=>$_POST['title'],
			'level'=>$_POST['level'],
			'style'=>$_POST['style']
		);
		$db=new db();
		$update=$db->update('rce_users_groups',$data,'`ID`=\''.$id.'\' ');
		// Redirect
		rce_log($_SESSION['user']['email'],'edit','Изменил данные группы пользователей ('.$_POST['title'].')');
		header("Location: /admin/?module=".rce_get_currentdir()."&status=".$action."_ok");
	}
	
} elseif($action=='delete'){
	// Post data
	$id=$_POST['id'];
	$level=$_POST['level'];
	$db=new db();
	// Deleting access rights
	$delete=$db->delete('rce_users_access',"`group`='$level'");
	// Deleting user group
	$delete=$db->delete('rce_users_groups',"`ID`='$id'");
	rce_log($_SESSION['user']['email'],'delete','Удалил группу пользователей с ID: '.$id);
	header("Location: /admin/?module=".rce_get_currentdir()."&status=".$action."_ok");
	
}

?>