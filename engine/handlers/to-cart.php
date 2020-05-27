<?php
/**
 * Created by PhpStorm.
 * User: krch_Vova
 * Date: 13.01.2016
 * Time: 16:05
 */
session_start();
define('RCE','V5');
$_SESSION['RCE']=RCE;

// Importing required files
include("../../engine/inc/config.php"); // Main configuration file import
include("../../engine/inc/db.php"); // Database config
include("../../engine/classes/class.rce.php"); // Main engine class
include("../../engine/classes/class.db.php"); // Database class
include("../../engine/functions/rce.functions.php"); // Database class
header("Content-type: text/html; charset=windows-1251");

$itemID = $_POST['itemID'];
$q=mysql_query("SELECT * FROM `rce_catalog_items` WHERE `ID` ='$itemID'");
$f=mysql_fetch_assoc($q);
if($_POST['quantity']==''){
    $quantity='1';
} else {
    $quantity=$_POST['quantity'];
}

$title = $f['title'];
$price = $f['price'];
echo $itemID;

mysql_query("
    INSERT INTO `rce_cart` (`title`, `trans`, `price`, `color`, `quantity`, `sess`)
    VALUES ('(арт.".$f['artno'].") ".$f['title']."', '".$f['trans']."', '".$f['price']."','".$f['image']."', '".$quantity."', '".$_SESSION['sess']."')
");

?>
