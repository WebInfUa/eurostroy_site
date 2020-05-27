<?
session_start();

$uid=$_SESSION['uid'];
$_SESSION['uri']=$_SERVER['REQUEST_URI'];
header("Location: /hackwarn/".$uid."/");

?>