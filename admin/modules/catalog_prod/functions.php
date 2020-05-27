<?
// Catalog functions

// Get category title by trans
function rce_catalog_getcattitle($trans) {
	$r=mysql_query("SELECT * FROM `rce_catalog_cats` WHERE `trans`='".$trans."'");
	$f=mysql_fetch_array($r);
	return $f['title'];
}

// Check and create dir for images in catalog (full and mini images)
function rce_catalog_dir_checkcreate($dir) {
	$create='../../../uploads/catalog'.$dir.'/';
	if(!file_exists($create)){
		mkdir($create);
	}
	$create='../../../uploads/catalog'.$dir.'/mini/';
	if(!file_exists($create)){
		mkdir($create);
	}
}

?>