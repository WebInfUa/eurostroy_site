<?
// Async
define('RCE','V5');
session_start();

// Data connect
include('../connector.php');

// Update param
$r=mysql_query("
	UPDATE `rce_catalog_items` SET `price`='".$_POST['price']."', `archive`='".$_POST['archive']."', `fav`='".$_POST['fav']."' WHERE `ID`='".$_POST['id']."'
");

?>