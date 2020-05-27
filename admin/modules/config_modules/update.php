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
	$data=array(
		'codename'=>$_POST['codename'],
		'title'=>$_POST['title']
	);
	$db=new db();
	$query=$db->update('rce_modules',$data,'`ID`='.$_POST['id']);
	if($query=='1'){ // Success
		rce_log($_SESSION['user']['email'],'edit','Изменил модуль ('.$_POST['codename'].')');
		header("Location: /admin/?module=".rce_get_currentdir()."&status=".$action."_ok");
	} else {
		rce_log($_SESSION['user']['email'],'edit','Пытался изменить модуль ('.$_POST['codename'].'), ошибка!');
		header("Location: /admin/?module=".rce_get_currentdir()."&status=".$action."_err");
	}
	
} elseif($action=='turnoff'){
	$data=array(
		'active'=>'0'
	);
	$db=new db();
	$query=$db->update('rce_modules',$data,'`ID`='.$_POST['id']);
	if($query=='1'){ // Success
		rce_log($_SESSION['user']['email'],'off','Выключил модуль ('.$_POST['codename'].')');
		header("Location: /admin/?module=".rce_get_currentdir()."&status=".$action."_ok");
	} else {
		rce_log($_SESSION['user']['email'],'off','Пытался выключилть модуль ('.$_POST['codename'].')');
		header("Location: /admin/?module=".rce_get_currentdir()."&status=".$action."_err");
	}
	
} elseif($action=='turnon'){
	$data=array(
		'active'=>'1'
	);
	$db=new db();
	$query=$db->update('rce_modules',$data,'`ID`='.$_POST['id']);
	if($query=='1'){ // Success
		rce_log($_SESSION['user']['email'],'on','Включил модуль ('.$_POST['codename'].')');
		header("Location: /admin/?module=".rce_get_currentdir()."&status=".$action."_ok");
	} else {
		rce_log($_SESSION['user']['email'],'on','Пытался включилть модуль ('.$_POST['codename'].')');
		header("Location: /admin/?module=".rce_get_currentdir()."&status=".$action."_err");
	}
}

?>