<?php
/**
 * Created by PhpStorm.
 * User: krch_Vova
 * Date: 19.01.2016
 * Time: 14:03
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

$city=$_POST['city'];
$street=$_POST['street'];
$home=$_POST['home'];
$appartment=$_POST['appartment'];

echo $itemID;

mysql_query("UPDATE `rce_cart` SET `city`='".$_POST['city']."', `street`='".$_POST['street']."', `home`='".$_POST['home']."', `appartment`='".$_POST['appartment']."'  
            WHERE `sess`='".$_SESSION['sess']."'");
header("Location: /?content=cart");
?>
