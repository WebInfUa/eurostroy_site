<?
// Update handler
session_start();
// Data connect
include('../connector.php');
include('functions.php');

// Get action
$action=$_POST['action'];

if(rce_access(rce_get_currentdir(),$action)=='0'){
	rce_error('access_deny');
	rce_log($_SESSION['user']['email'],$action,'Пытался обойти ограничение прав доступа!');
	die('Попытка обойти защиту! Администратор уведомлен о вашем нарушении!<br />Переадресация... <meta http-equiv="refresh" content="3;url=/admin/?module='.rce_get_currentdir().'&status=access_deny">');
}

// Set root to upload dirs
$dir_cat='../../../uploads/catalog/cats/';
$dir_item='../../../uploads/catalog/'.$_POST['root'].'/';
$dir_item_mini='../../../uploads/catalog/'.$_POST['root'].'/mini/';
// Check and create folders
$eroot=explode('/',$_POST['root']);
$echeck=strpos($_POST['root'],'/');
if($echeck===false){ // No slash, its a 2nd level category
	rce_catalog_dir_checkcreate('/'.$_POST['root']);
} else { // Have slash, 3+ category level
	$ec=count($eroot);
	$j=0;
	foreach($eroot as $ekey=>$evalue){
		if($j==$ec){
			$dirplus.=$evalue;
		} else {
			$dirplus.='/'.$evalue;
		}
		$j++;
		rce_catalog_dir_checkcreate($dirplus);
	}
}

if($action=='add_cat'){
	// Add new category
	$db=new db();
	$nextitem=$db->getnext('rce_catalog_cats');
	// Post data
	$langs=$_POST['langs'];
	// Fetching lang list
	$lang=explode(',',$langs);
	foreach($lang as $val){
		// For logs
		if($val=='ru'){$cat_title=$_POST[$val.'_title'];}
		// Regenerate trans URL
		$trans=rce_translit($_POST[$val.'_trans']);
		// Root
		if($_POST['root']!=''){
			$root=$_POST['root'].'/'.$trans;
			$check=strpos($_POST['root'],'/');
			if($check===false){ // No slash, 2nd level category
				$parent=$_POST['root'];
			} else {
				$ex=explode('/',$_POST['root']);
				$c=count($ex);
				$i=1;
				foreach($ex as $key1=>$val1){
					if($i==$c){
						$parent=$val1;
					} else {
						//
					}
					$i++;
				}
			}
		} else {
			$root=$trans;
			$parent='';
		}
		// Data
		$data=array(
			'author'=>$_SESSION['user']['ID'],
			'catID'=>$nextitem,
			'lang'=>$val,
			'title'=>$_POST[$val.'_title'],
			'trans'=>strtolower($trans),
			'root'=>strtolower($root),
			'parent'=>$parent,
			'text'=>$_POST[$val.'_text'],
			'order'=>$_POST[$val.'_order'],
			'meta_title'=>$_POST[$val.'_meta_title'],
			'meta_keys'=>$_POST[$val.'_meta_keys'],
			'meta_desc'=>$_POST[$val.'_meta_desc']
		);
		// Working image
		if($val=='ru'){
			$file=$_FILES['file'];
			$file_extension=pathinfo($file['name'], PATHINFO_EXTENSION);
			if($file_extension!=''){ // If file selected
				$allowed=array('jpg','jpeg','gif','png','JPG','JPEG','GIF','PNG');
				if(in_array($file_extension,$allowed)){ // Extesion allowed
					// Generating title
					$basename=$nextitem.$trans.'.'.$file_extension;
					// Copying image
					$resize=img_resize($file['tmp_name'],$dir_cat.$basename, 250, 250, 90, 0xFFFFF0, 0);
					// Add value to array
					$data['image']=$basename;
				}
			}
		} else {
			// Nothing to do here
		}
		$db=new db();
		$update=$db->insert('rce_catalog_cats',$data);
	}
	rce_log($_SESSION['user']['email'],'edit','Добавил категорию товаров '.$cat_title);
	header("Location: /admin/?module=".rce_get_currentdir()."&status=".$action."_ok&root=".$_POST['root']);
	
} elseif($action=='edit_cat'){
	// Post data
	$id=$_POST['id'];
	$langs=$_POST['langs'];
	// Fetching lang list
	$lang=explode(',',$langs);
	foreach($lang as $val){
		// For logs
		if($val=='ru'){$cat_title=$_POST[$val.'_title'];}
		// Regenerate trans URL
		if(rce_get_config('catalog_cats_regenerate_url')){ 
			$trans=rce_translit($_POST[$val.'_title']);
		} else {
			$trans=$_POST[$val.'_trans'];
		}
		// Update prods
		//$r=mysql_query("UPDATE `rce_catalog_items` SET `cat`='".$trans."' WHERE `cat`='".$_POST[$val.'_trans']."'");
		// Data array
		$data=array(
			'author'=>$_SESSION['user']['ID'],
			'title'=>$_POST[$val.'_title'],
			'trans'=>strtolower($trans),
			'text'=>$_POST[$val.'_text'],
			'order'=>$_POST[$val.'_order'],
			'meta_title'=>$_POST[$val.'_meta_title'],
			'meta_keys'=>$_POST[$val.'_meta_keys'],
			'meta_desc'=>$_POST[$val.'_meta_desc']
		);
		// Working image
		if($val=='ru'){
			$file=$_FILES['file'];
			$file_extension=pathinfo($file['name'], PATHINFO_EXTENSION);
			if($file_extension!=''){ // If file selected
				$allowed=array('jpg','jpeg','gif','png','JPG','JPEG','GIF','PNG');
				if(in_array($file_extension,$allowed)){ // Extesion allowed
					// Erasing current image
					@unlink($dir_cat.$id.$_POST[$val.'_trans'].'.jpg');
					// Generating title
					$basename=$id.$trans.'.'.$file_extension;
					// Copying image
					$resize=img_resize($file['tmp_name'],$dir_cat.$basename, 250, 250, 90, 0xFFFFF0, 0);
					// Add value to array
					$data['image']=$basename;
				}
			}
			// Root
			if($_POST['root']!=''){
				$data['root']=$_POST['root'].'/'.$trans;
			} else {
				$data['root']=$trans;
			}
		}
		// Query
		$db=new db();
		$update=$db->update('rce_catalog_cats',$data,'`catID`=\''.$id.'\' AND `lang`=\''.$val.'\'');
	}
	rce_log($_SESSION['user']['email'],'edit','Изменил категорию товаров '.$cat_title);
	header("Location: /admin/?module=".rce_get_currentdir()."&status=".$action."_ok&root=".$_POST['root']);
	
} elseif($action=='delete_cat'){
	// Post data
	$id=$_POST['id'];
	$db=new db();
	// Get category info
	$r=mysql_query("SELECT * FROM `rce_catalog_cats` WHERE `ID`='".$id."'");
	$f=mysql_fetch_array($r);
	@unlink($dir_cat.$f['image']);
	// Deleteng products from this category
	$r2=mysql_query("SELECT * FROM `rce_catalog_items` WHERE `cat`='".$f['trans']."'");
	for($i=0;$i<mysql_num_rows($r2);$i++){
		$f2=mysql_fetch_array($r2);
		@unlink('../../../uploads/catalog/'.$f['root'].'/'.$f2['image']);
		@unlink('../../../uploads/catalog/'.$f['root'].'/mini/'.$f2['image']);
		// Deleting item
		$delete=$db->delete('rce_catalog_items',"`itemID`='".$f2['ID']."'");
	}
	// Deleting category
	$delete=$db->delete('rce_catalog_cats',"`catID`='$id'");
	// Redirect
	rce_log($_SESSION['user']['email'],'delete','Удалил категорию товаров с ID: '.$id);
	header("Location: /admin/?module=".rce_get_currentdir()."&status=".$action."_ok&root=".$_POST['root']);
	
} elseif($action=='add_item'){
	// Add new category
	$db=new db();
	$nextitem=$db->getnext('rce_catalog_items');
	// Post data
	$langs=$_POST['langs'];
	// Fetching lang list
	$lang=explode(',',$langs);
	foreach($lang as $val){
		// For logs
		if($val=='ru'){$item_title=$_POST[$val.'_title'];}
		$trans=rce_translit($_POST[$val.'_trans']);
		// Cat
		if($_POST['root']!=''){
			$check=strpos($_POST['root'],'/');
			if($check===false){ // No slash, 2nd level category
				$cat=$_POST['root'];
			} else {
				$ex=explode('/',$_POST['root']);
				$c=count($ex);
				$i=1;
				foreach($ex as $key1=>$val1){
					if($i==$c){
						$cat=$val1;
					} else {
						//
					}
					$i++;
				}
			}
		} else {
			$cat='';
		}
		// Data
		$data=array(
			'author'=>$_SESSION['user']['ID'],
			'itemID'=>$nextitem,
			'lang'=>$val,
			'title'=>$_POST[$val.'_title'],
			'trans'=>strtolower($trans),
			'text'=>$_POST[$val.'_text'],
			'meta_title'=>$_POST[$val.'_meta_title'],
			'meta_keys'=>$_POST[$val.'_meta_keys'],
			'meta_desc'=>$_POST[$val.'_meta_desc']
		);
		// Working image
		if($val=='ru'){
			$file=$_FILES['file'];
			$file_extension=pathinfo($file['name'], PATHINFO_EXTENSION);
			if($file_extension!=''){ // If file selected
				$allowed=array('jpg','jpeg','gif','png','JPG','JPEG','GIF','PNG');
				if(in_array($file_extension,$allowed)){ // Extesion allowed
					// Generating title
					$basename=$nextitem.$trans.'.'.$file_extension;
					// Copying image
					$resize=img_resize($file['tmp_name'],$dir_item.$basename, 800, 800, 95, 0xFFFFF0, 0);
					$resize=img_resize($file['tmp_name'],$dir_item_mini.$basename, 250, 250, 95, 0xFFFFF0, 0);
					// Add value to array
					$data['image']=$basename;
				}
			}
			// Additional params
			$data['cat']=$cat;
			$data['artno']=$_POST['artno'];
			$data['price']=$_POST['price'];
			$data['price_old']=$_POST['price_old'];
			$data['order']=$_POST['order'];
		} else {
			// Nothing to do here
		}
		$db=new db();
		$update=$db->insert('rce_catalog_items',$data);
	}
	rce_log($_SESSION['user']['email'],'edit','Добавил товар в каталог: '.$item_title);
	header("Location: /admin/?module=".rce_get_currentdir()."&status=".$action."_ok&root=".$_POST['root']);
	
} elseif($action=='edit_item'){
	// Post data
	$id=$_POST['id'];
	$langs=$_POST['langs'];
	// Fetching lang list
	$lang=explode(',',$langs);
	foreach($lang as $val){
		// For logs
		if($val=='ru'){$item_title=$_POST[$val.'_title'];}
		// Regenerate trans URL
		if(rce_get_config('catalog_items_regenerate_url')){ 
			$trans=rce_translit($_POST[$val.'_title']);
		} else {
			$trans=$_POST[$val.'_trans'];
		}
		$data=array(
			'author'=>$_SESSION['user']['ID'],
			'title'=>$_POST[$val.'_title'],
			'trans'=>strtolower($trans),
			'text'=>$_POST[$val.'_text'],
			'order'=>$_POST[$val.'_order'],
			'meta_title'=>$_POST[$val.'_meta_title'],
			'meta_keys'=>$_POST[$val.'_meta_keys'],
			'meta_desc'=>$_POST[$val.'_meta_desc']
		);
		// Working image
		if($val=='ru'){
			$file=$_FILES['file'];
			$file_extension=pathinfo($file['name'], PATHINFO_EXTENSION);
			if($file_extension!=''){ // If file selected
				$allowed=array('jpg','jpeg','gif','png','JPG','JPEG','GIF','PNG');
				if(in_array($file_extension,$allowed)){ // Extesion allowed
					// Erasing current image
					@unlink($dir_item.$id.$_POST[$val.'_trans'].'.jpg');
					// Generating title
					$basename=$id.$trans.'.'.$file_extension;
					// Copying image
					$resize=img_resize($file['tmp_name'],$dir_item.$basename, 800, 800, 95, 0xFFFFF0, 0);
					$resize=img_resize($file['tmp_name'],$dir_item_mini.$basename, 250, 250, 95, 0xFFFFF0, 0);
					// Add value to array
					$data['image']=$basename;
				}
			}
			// Additional params
			$data['cat']=$_POST['cat'];
			$data['artno']=$_POST['artno'];
			$data['price']=$_POST['price'];
			$data['price_old']=$_POST['price_old'];
			$data['pcs']=$_POST['pcs'];
			$data['order']=$_POST['order'];
			$data['archive']=$_POST['archive'];
			$data['fav']=$_POST['fav'];
		}
		$db=new db();
		$update=$db->update('rce_catalog_items',$data,'`itemID`=\''.$id.'\' AND `lang`=\''.$val.'\'');
		// TRANSFER ITEM
		if($_POST['catid']!=''){
			// Cat data
			$rc=mysql_query("SELECT * FROM `rce_catalog_cats` WHERE `ID`='".$_POST['catid']."'");
			$fc=mysql_fetch_array($rc);
			// Prod data
			$rp=mysql_query("SELECT * FROM `rce_catalog_items` WHERE `itemID`='".$id."'");
			$fp=mysql_fetch_array($rp);
			// Transfer prod
			$ru=mysql_query("
				UPDATE `rce_catalog_items` SET
				`cat`='".$fc['trans']."' 
				WHERE `itemID`='".$id."'
			");
			// Copy images
			$copy=copy($dir_item.$fp['image'],'../../../uploads/catalog/'.$fc['root'].'/'.$fp['image']);
			$copy=copy($dir_item_mini.$fp['image'],'../../../uploads/catalog/'.$fc['root'].'/mini/'.$fp['image']);
			// End
		} else {
			// Nothing
		}
	}
	rce_log($_SESSION['user']['email'],'edit','Изменил товар '.$item_title);
	header("Location: /admin/?module=".rce_get_currentdir()."&status=".$action."_ok&root=".$_POST['root']);
	
} elseif($action=='copy_item'){
	// Post data
	$id=$_POST['id'];
	$langs=$_POST['langs'];
	// Fetching lang list
	$lang=explode(',',$langs);
	foreach($lang as $val){
		// For logs
		if($val=='ru'){$item_title=$_POST[$val.'_title'];}
		// Regenerate trans URL
		if(rce_get_config('catalog_items_regenerate_url')){ 
			$trans=rce_translit($_POST[$val.'_title']);
		} else {
			$trans=$_POST[$val.'_trans'];
		}
		$data=array(
			'author'=>$_SESSION['user']['ID'],
			'title'=>$_POST[$val.'_title'],
			'trans'=>strtolower($trans),
			'text'=>$_POST[$val.'_text'],
			'order'=>$_POST[$val.'_order'],
			'meta_title'=>$_POST[$val.'_meta_title'],
			'meta_keys'=>$_POST[$val.'_meta_keys'],
			'meta_desc'=>$_POST[$val.'_meta_desc']
		);
		// Working image
		if($val=='ru'){
			$file=$_FILES['file'];
			$file_extension=pathinfo($file['name'], PATHINFO_EXTENSION);
			if($file_extension!=''){ // If file selected
				$allowed=array('jpg','jpeg','gif','png','JPG','JPEG','GIF','PNG');
				if(in_array($file_extension,$allowed)){ // Extesion allowed
					// Erasing current image
					@unlink($dir_item.$id.$_POST[$val.'_trans'].'.jpg');
					// Generating title
					$basename=$id.$trans.'.'.$file_extension;
					// Copying image
					$resize=img_resize($file['tmp_name'],$dir_item.$basename, 800, 800, 95, 0xFFFFF0, 0);
					$resize=img_resize($file['tmp_name'],$dir_item_mini.$basename, 250, 250, 95, 0xFFFFF0, 0);
					// Add value to array
					$data['image']=$basename;
				}
			}
			// Additional params
			$data['cat']=$_POST['cat'];
			$data['artno']=$_POST['artno'];
			$data['price']=$_POST['price'];
			$data['price_old']=$_POST['price_old'];
			$data['order']=$_POST['order'];
		}
		$db=new db();
		$update=$db->update('rce_catalog_items',$data,'`itemID`=\''.$id.'\' AND `lang`=\''.$val.'\'');
	}
	rce_log($_SESSION['user']['email'],'edit','Изменил товар '.$item_title);
	header("Location: /admin/?module=".rce_get_currentdir()."&status=".$action."_ok&root=".$_POST['root']);
	
} elseif($action=='delete_item'){
	// Post data
	$id=$_POST['id'];
	$db=new db();
	// Get item info
	$r=mysql_query("SELECT * FROM `rce_catalog_items` WHERE `ID`='".$id."'");
	$f=mysql_fetch_array($r);
	@unlink($dir_item.$f['image']);
	@unlink($dir_item_mini.$f['image']);
	// Deleting items
	$delete=$db->delete('rce_catalog_items',"`itemID`='$id'");
	// Redirect
	rce_log($_SESSION['user']['email'],'delete','Удалил товар '.$f['title'].' с ID: '.$id);
	header("Location: /admin/?module=".rce_get_currentdir()."&status=".$action."_ok&root=".$_POST['root']);
	
}

?>