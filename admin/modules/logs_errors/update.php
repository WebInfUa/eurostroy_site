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

if($action=='clear'){
	$db=new db();
	$query=$db->clear('rce_logs_errors');
	rce_log($_SESSION['user']['email'],'clear','Очистил логи ошибок сайта');
	header("Location: /admin/?module=".rce_get_currentdir()."&status=".$action."_ok");
}

?>