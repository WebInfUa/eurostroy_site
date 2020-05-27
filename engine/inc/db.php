<?
// Anti-hack
if(!defined('RCE')){
	die('Hacking attempt!');
}

define('HOST', 'localhost');
if($_SERVER['HTTP_HOST'] == 'bud-komplekt.com.ua'){ // Config on web server
  define('LOGIN', '');
	define('PASSWORD', '');
	define('NAME', '');
} elseif($_SERVER['HTTP_HOST'] == 'bud'){ // Config on local server
  define('HOST', 'localhost');
	define('NAME', 'bud');
	define('LOGIN', 'root');
	define('PASSWORD', '');
}

$db=mysql_connect(HOST,LOGIN,PASSWORD)or die(mysql_error());
mysql_select_db(NAME,$db)or die(mysql_error()); 

mysql_query('SET time_zone := "+03:00"');
mysql_query('SET NAMES utf8',$db);          
mysql_query('SET CHARACTER SET utf8',$db);  
mysql_query('SET COLLATION_CONNECTION="utf8_general_ci"',$db);

