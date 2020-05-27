<?
session_start();
define('RCE','V5');
$_SESSION['RCE']=RCE;
$_SESSION['sess']=session_id();

// Importing required files
include("engine/inc/config.php"); // Main configuration file import
include("engine/inc/db.php"); // Database config
include("engine/classes/class.rce.php"); // Main engine class
include("engine/classes/class.db.php"); // Database class
include("engine/functions/rce.functions.php"); // Database class

// Cookie check
if(isset($_COOKIE['auth'])){
	$_SESSION['auth']==$_COOKIE['auth'];
	$r=mysql_query(sprintf("
		SELECT * FROM `rce_users` WHERE `hash`='%s'
	",
		mysql_real_escape_string($_COOKIE['auth'])
	));
	if(mysql_num_rows($r)>'0'){
		$f=mysql_fetch_array($r);
		$_SESSION['id']=session_id();
		$_SESSION['auth']=$f['hash'];
		$_SESSION['user']=$f;
		// Update last online
		$online=date("Y-m-d H:i:s");
		$r=mysql_query("UPDATE `rce_users` SET `date_visit`='".$online."' WHERE `ID`='".$f['ID']."'");
	}
}

// Connecting modules
if($_SERVER['REQUEST_URI']=='/'){ // Is homepage
	include("engine/modules/homepage.php");
	$tpl_file='home';
	$header_inner='';
} else { // Some module
	// Router: Parsing URL
	$header_inner=' header-inner';
	$uri=substr($_SERVER['REQUEST_URI'],1); // Delete first slash
	$URL=explode('/',$uri); // Parsing url
	// Check for added module
	$r=mysql_query("SELECT * FROM `rce_config_router` WHERE `word`='".$URL[0]."'");
	if(mysql_num_rows($r)=='1'){ // Have this module
		@include("engine/modules/".$URL[0].".php");
		$tpl_file=$URL[0];
	} else { // Have not this module, try to get page
		include("engine/modules/pages.php");
		$tpl_file='pages';
	}
}
include("engine/modules/menus.php");
// Template render script
include("template/template.php");

?>