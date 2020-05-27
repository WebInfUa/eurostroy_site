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
	$data=array(
		'lang'=>$_POST['lang'],
		'lang_title'=>$_POST['lang_title'],
		'site_title'=>$_POST['site_title'],
		'meta_title'=>$_POST['meta_title'],
		'meta_keys'=>$_POST['meta_keys'],
		'meta_desc'=>$_POST['meta_desc']
	);
	$db=new db();
	$query=$db->insert('rce_config_lang',$data);
	if($query=='1'){ // Success
		rce_log($_SESSION['user']['email'],'add','Добавил новый язык ('.$_POST['lang_title'].')');
		header("Location: /admin/?module=".rce_get_currentdir()."&status=".$action."_ok");
	} else {
		rce_log($_SESSION['user']['email'],'add','Пытался добавить язык ('.$_POST['lang_title'].'), ошибка!');
		header("Location: /admin/?module=".rce_get_currentdir()."&status=".$action."_err");
	}
	
} elseif($action=='edit'){
	$data=array(
		'lang'=>$_POST['lang'],
		'lang_title'=>$_POST['lang_title'],
		'site_title'=>$_POST['site_title'],
		'meta_title'=>$_POST['meta_title'],
		'meta_keys'=>$_POST['meta_keys'],
		'meta_desc'=>$_POST['meta_desc']
	);
	$db=new db();
	$query=$db->update('rce_config_lang',$data,'`ID`='.$_POST['id']);
	if($query=='1'){ // Success
		rce_log($_SESSION['user']['email'],'edit','Внес изменения в язык ('.$_POST['lang_title'].')');
		header("Location: /admin/?module=".rce_get_currentdir()."&status=".$action."_ok");
	} else {
		rce_log($_SESSION['user']['email'],'edit','Пытался внести изменения в язык ('.$_POST['lang_title'].'), ошибка!');
		header("Location: /admin/?module=".rce_get_currentdir()."&status=".$action."_err");
	}
	
} elseif($action=='turnoff'){
	$data=array(
		'active'=>'0'
	);
	$db=new db();
	$query=$db->update('rce_config_lang',$data,'`ID`='.$_POST['id']);
	if($query=='1'){ // Success
		rce_log($_SESSION['user']['email'],'off','Выключил язык '.$_POST['title'].'');
		header("Location: /admin/?module=".rce_get_currentdir()."&status=".$action."_ok");
	} else {
		rce_log($_SESSION['user']['email'],'off','Пытался выключить язык '.$_POST['title'].', ошибка!');
		header("Location: /admin/?module=".rce_get_currentdir()."&status=".$action."_err");
	}
	
} elseif($action=='turnon'){
	$data=array(
		'active'=>'1'
	);
	$db=new db();
	$query=$db->update('rce_config_lang',$data,'`ID`='.$_POST['id']);
	if($query=='1'){ // Success
		rce_log($_SESSION['user']['email'],'on','Включил язык '.$_POST['title'].'');
		header("Location: /admin/?module=".rce_get_currentdir()."&status=".$action."_ok");
	} else {
		rce_log($_SESSION['user']['email'],'on','Пытался включить язык '.$_POST['title'].', ошибка!');
		header("Location: /admin/?module=".rce_get_currentdir()."&status=".$action."_err");
	}
	
} elseif($action=='delete'){
	$db=new db();
	$query=$db->delete('rce_config_lang','`ID`='.$_POST['id']);
	rce_log($_SESSION['user']['email'],'delete','Удалил язык '.$_POST['title'].'');
	header("Location: /admin/?module=".rce_get_currentdir()."&status=".$action."_ok");
	
} elseif($action=='default'){
	$r=mysql_query("UPDATE `rce_config_lang` SET `default`='0'");
	$db=new db();
	$data=array(
		'default'=>'1'
	);
	$query=$db->update('rce_config_lang',$data,'`ID`='.$_POST['id']);
	if($query=='1'){ // Success
		rce_log($_SESSION['user']['email'],'edit','Установил язык по-умолчанию '.$_POST['title'].'');
		header("Location: /admin/?module=".rce_get_currentdir()."&status=".$action."_ok");
	} else {
		rce_log($_SESSION['user']['email'],'edit','Пытался установить язык по-умолчанию '.$_POST['title'].', ошибка!');
		header("Location: /admin/?module=".rce_get_currentdir()."&status=".$action."_err");
	}
}

?>