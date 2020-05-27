<?
// Admin index page

session_start();
DEFINE('RCE','V5');

// Connecting required
require("../engine/inc/db.php"); // DB config
require("../engine/inc/config.php"); // RCE config
require("../engine/classes/class.db.php"); // DB engine class
require("../engine/classes/class.rce_admin.php"); // Main adminpanel class
require("../engine/functions/rce.functions.php"); // Main engine functions

// Logout, session break
if($_GET['do']=='logout'){
	rce_log($_SESSION['user']['email'],'logout','Вышел из системы');
	setcookie("auth",$_SESSION['auth'],time()-3600,"/",RCE_HOST);
	session_destroy();
	header("Location: /admin/");
}
// Cookie check
if(isset($_COOKIE['auth'])){
	$_SESSION['auth']==$_COOKIE['auth'];
}
if(!isset($_SESSION['auth'])){ // No auth, show login form
	require("modules/user_auth/index.php");
} else { // Auth OK
	require("modules/menu.php"); // Menu addon
	if(!isset($_GET['module'])){
		require("modules/home.php"); // Homepage module
	} else {
		// Requesting and connecting module list
		$db=new db();
		$q="SELECT * FROM `rce_modules` WHERE `active`='1' AND `codename`='".$_GET['module']."'";
		$count=$db->count($q);
		// On case this module is connected
		if($count=='1'){
			if(rce_access($_GET['module'],'open')){
				$query=$db->select($q,'','','');
				include('modules/'.$query['codename'].'/index.php');
			} else {
				rce_error('access_deny');
				rce_log($_SESSION['user']['email'],'open','Пытался обойти ограничение прав доступа для модуля '.$_GET['module'].'!');
				$rce=new rce_admin();
				$out=$rce->page404();
			}
		} else {
			// No module, sending to 404
			$rce=new rce_admin();
			$out=$rce->page404();
		}
	}
}

echo $out;

?>
