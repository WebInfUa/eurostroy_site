<?
// Update handler
session_start();
// Data connect
include('../connector.php');

// Get action
$action=$_POST['action'];

if(rce_access('pages',$action)=='0'){
	rce_error('access_deny');
	rce_log($_SESSION['user']['email'],$action,'Пытался обойти ограничение прав доступа!');
	die('Попытка обойти защиту! Администратор уведомлен о вашем нарушении!<br />Переадресация... <meta http-equiv="refresh" content="3;url=/admin/?module=pages&status=access_deny">');
}

if($action=='add'){
	// Add new page
	$db=new db();
	$nextpage=$db->getnext('rce_news');
	// Post data
	$langs=$_POST['langs'];
	// Fetching lang list
	$lang=explode(',',$langs);
	foreach($lang as $val){
		// For logs
		if($val=='ru'){$page_title=$_POST[$val.'_title'];}
		$trans=rce_translit($id.'-'.$_POST[$val.'_title']);
		$data=array(
			'author'=>$_SESSION['user']['ID'],
			'pageID'=>$nextpage,
			'lang'=>$val,
			'title'=>$_POST[$val.'_title'],
			'trans'=>$nextpage.$trans,
			'text'=>$_POST[$val.'_text'],
			'meta_title'=>$_POST[$val.'_meta_title'],
			'meta_keys'=>$_POST[$val.'_meta_keys'],
			'meta_desc'=>$_POST[$val.'_meta_desc']
		);
		$db=new db();
		$update=$db->insert('rce_news',$data);
	}
	rce_log($_SESSION['user']['email'],'edit','Создал новость '.$page_title);
	header("Location: /admin/?module=news&status=".$action."_ok");
	
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
		if(rce_get_config('news_regenerate_url')){ 
			$trans=rce_translit($id.'-'.$_POST[$val.'_title']);
		} else {
			$trans=$_POST[$val.'_trans'];
		}
		$data=array(
			'author'=>$_SESSION['user']['ID'],
			'title'=>$_POST[$val.'_title'],
			'trans'=>$trans,
			'text'=>$_POST[$val.'_text'],
			'meta_title'=>$_POST[$val.'_meta_title'],
			'meta_keys'=>$_POST[$val.'_meta_keys'],
			'meta_desc'=>$_POST[$val.'_meta_desc']
		);
		$db=new db();
		$update=$db->update('rce_news',$data,'`pageID`=\''.$id.'\' AND `lang`=\''.$val.'\'');
	}
	rce_log($_SESSION['user']['email'],'edit','Изменил новость '.$page_title);
	header("Location: /admin/?module=news&status=".$action."_ok");
} elseif($action=='delete'){
	// Post data
	$id=$_POST['id'];
	$db=new db();
	$delete=$db->delete('rce_news',"`pageID`='$id'");
	rce_log($_SESSION['user']['email'],'delete','Удалил новость с ID: '.$id);
	header("Location: /admin/?module=news&status=".$action."_ok");
}

?>