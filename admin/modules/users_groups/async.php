<?
// Async
define('RCE','V5');
session_start();
// Data connect
include('../connector.php');

// Hack prevent
if(!isset($_POST['allow'])){
	die('Go away!');
}
// Update param
$r=mysql_query("
	UPDATE `rce_users_access` SET
	`allow`='".$_POST['allow']."'
	WHERE
	`group`='".$_POST['group']."' AND
	`module`='".$_POST['module']."' AND
	`action`='".$_POST['action']."'
");

?>