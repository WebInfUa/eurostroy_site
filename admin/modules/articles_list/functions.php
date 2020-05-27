<?
// Module functions

function rce_articles_get_cattitle($cat){
	$r=mysql_query("SELECT * FROM `rce_articles_cats` WHERE `trans`='".$cat."'");
	$f=mysql_fetch_array($r);
	return $f['title'];
}

// Check and create dir for images in catalog (full and mini images)
function rce_news_dir_checkcreate($dir){
	$create='../../../uploads/blog/'.$dir.'/';
	if(!file_exists($create)){
		mkdir($create);
	}
	$create='../../../uploads/blog/'.$dir.'/mini/';
	if(!file_exists($create)){
		mkdir($create);
	}
}

?>