<?
// Anti-hack
if(!defined('RCE')){
	die('Hacking attempt!');
}

//date_default_timezone_set('Europe/Kiev');

// Define block
define('RCE_HOST',$_SERVER['SERVER_NAME']);
define('RCE_ENGINE','/engine/');
define('RCE_MODULES','/engine/modules/');
define('RCE_ADMIN','//'.RCE_HOST.'/admin/');
define('RCE_TEMPLATE','//'.RCE_HOST.'/template/');
define('RCE_ROOT',$_SERVER['DOCUMENT_ROOT'].'/');
define('RCE_TEMPLATE_ROOT',$_SERVER['DOCUMENT_ROOT'].'/template/');

mb_internal_encoding("UTF-8");

$site_root='//'.$_SERVER['HTTP_HOST'].'/';
$site_current='//'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
$TEMPLATE='//'.$_SERVER['HTTP_HOST'].'/template/';
$UPLOADS='//'.$_SERVER['HTTP_HOST'].'/uploads/';
$ENGINE='//'.$_SERVER['HTTP_HOST'].'/engine/';
$ADMIN='//'.$_SERVER['HTTP_HOST'].'/admin/';

?>