<?
// Module functions

function rce_news_get_cattitle($cat){
	$r=mysql_query("SELECT * FROM `rce_news_cats` WHERE `trans`='".$cat."'");
	$f=mysql_fetch_array($r);
	return $f['title'];
}

?>