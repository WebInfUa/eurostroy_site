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

$dir_date=date(Y).'-'.date(m);
rce_news_dir_checkcreate($dir_date);
$dir='../../../uploads/blog/'.date(Y).'-'.date(m).'/';
$dir_mini='../../../uploads/blog/'.date(Y).'-'.date(m).'/mini/';

if($action=='add'){
	// Add new page
	$db=new db();
	$nextpage=$db->getnext('rce_articles_list');
	// Post data
	$langs=$_POST['langs'];
	// Fetching lang list
	$lang=explode(',',$langs);
	foreach($lang as $val){
		// For logs
		if($val=='ru'){$page_title=$_POST[$val.'_title'];}
		$trans=rce_translit($_POST[$val.'_title']);
		$data=array(
			'author'=>$_SESSION['user']['ID'],
			'pageID'=>$nextpage,
			'lang'=>$val,
			'title'=>$_POST[$val.'_title'],
			'slider_title'=>$_POST[$val.'_slider_title'],
			'slider_short'=>$_POST[$val.'_slider_short'],
			'trans'=>strtolower($trans.'-'.$nextpage),
			'text'=>$_POST[$val.'_text'],
			'meta_title'=>$_POST[$val.'_meta_title'],
			'meta_keys'=>$_POST[$val.'_meta_keys'],
			'meta_desc'=>$_POST[$val.'_meta_desc']
		);
		if($val=='ru'){
			$data['cat']=$_POST['cat'];
			$data['archive']=$_POST['archive'];
			$data['source']=$_POST['source'];
			$data['slider']=$_POST['slider'];
			// Image
			$file=$_FILES['file'];
			$file_extension=pathinfo($file['name'], PATHINFO_EXTENSION);
			if($file_extension!=''){ // If file selected
				$allowed=array('jpg','jpeg','gif','png','JPG','JPEG','GIF','PNG');
				if(in_array($file_extension,$allowed)){ // Extesion allowed
					// Generating title
					$basename=$nextpage.'.'.$trans.'.'.$file_extension;
					// Copying image
					$resize=img_resize($file['tmp_name'],$dir.$basename, 1920, 1080, 98, 0xFFFFF0, 0);
					$resize=img_resize($file['tmp_name'],$dir_mini.$basename, 300, 180, 95, 0xFFFFF0, 0);
					// Add value to array
					$data['image']=$basename;
				}
			}
		}
		$db=new db();
		$update=$db->insert('rce_articles_list',$data);
	}
	rce_log($_SESSION['user']['email'],'edit','Создал статью '.$page_title);
	header("Location: /admin/?module=".rce_get_currentdir()."&status=".$action."_ok");
	
} elseif($action=='edit'){
	// Post data
	$id=$_POST['id'];
	$langs=$_POST['langs'];
	// Fetching lang list
	$lang=explode(',',$langs);
	foreach($lang as $val){
		// For logs
		if($val=='ru'){$page_title=$_POST[$val.'_title'];}
		// Regenerate trans URL
		if(rce_get_config('articles_regenerate_url')){ 
			$trans=rce_translit($id.'-'.$_POST[$val.'_title']);
		} else {
			$trans=$_POST[$val.'_trans'];
		}
		$data=array(
			'author'=>$_SESSION['user']['ID'],
			'title'=>$_POST[$val.'_title'],
			'trans'=>strtolower($trans),
			'text'=>$_POST[$val.'_text'],
			'slider_title'=>$_POST[$val.'_slider_title'],
			'slider_short'=>$_POST[$val.'_slider_short'],
			'meta_title'=>$_POST[$val.'_meta_title'],
			'meta_keys'=>$_POST[$val.'_meta_keys'],
			'meta_desc'=>$_POST[$val.'_meta_desc']
		);
		if($val=='ru'){
			$data['cat']=$_POST['cat'];
			$data['source']=$_POST['source'];
			$data['archive']=$_POST['archive'];
			$data['slider']=$_POST['slider'];
			// Image
			$file=$_FILES['file'];
			$file_extension=pathinfo($file['name'], PATHINFO_EXTENSION);
			if($file_extension!=''){ // If file selected
				$allowed=array('jpg','jpeg','gif','png','JPG','JPEG','GIF','PNG');
				if(in_array($file_extension,$allowed)){ // Extesion allowed
					// Generating title
					$basename=$id.'.'.$trans.'.'.$file_extension;
					// Copying image
					$resize=img_resize($file['tmp_name'],$dir.$basename, 1920, 1080, 98, 0xFFFFF0, 0);
					$resize=img_resize($file['tmp_name'],$dir_mini.$basename, 300, 180, 95, 0xFFFFF0, 0);
					// Add value to array
					$data['image']=$basename;
				}
			}
		}
		$db=new db();
		$update=$db->update('rce_articles_list',$data,'`pageID`=\''.$id.'\' AND `lang`=\''.$val.'\'');
	}
	rce_log($_SESSION['user']['email'],'edit','Изменил статью '.$page_title);
	header("Location: /admin/?module=".rce_get_currentdir()."&status=".$action."_ok");
	
} elseif($action=='delete'){
	// Post data
	$id=$_POST['id'];
	$db=new db();
	$delete=$db->delete('rce_articles_list',"`pageID`='$id'");
	rce_log($_SESSION['user']['email'],'delete','Удалил статью с ID: '.$id);
	header("Location: /admin/?module=".rce_get_currentdir()."&status=".$action."_ok");
}

?>