<?
// Update handler
session_start();
// Data connect
include('../connector.php');

// Get action
$action=$_POST['action'];

if(rce_access(rce_get_currentdir(),$action)=='0'){
	rce_error('access_deny');
	rce_log($_SESSION['user']['email'],$action,'Пытался обойти ограничение прав доступа!');
	die('Попытка обойти защиту! Администратор уведомлен о вашем нарушении!<br />Переадресация... <meta http-equiv="refresh" content="3;url=/admin/?module='.rce_get_currentdir().'&status=access_deny">');
}

$dir='../../../uploads/slider/';

if($action=='add'){
	// Add new slide
	
	$file=$_FILES['file'];
	$file_extension=pathinfo($file['name'], PATHINFO_EXTENSION);
	if($file_extension!=''){ // If file selected
		$allowed=array('jpg','jpeg','gif','png','JPG','JPEG','GIF','PNG');
		if(in_array($file_extension,$allowed)){ // Extesion allowed
			// Generating title
			$rand=rand(1000,9999);
			$image=rce_translit($rand.'-'.$_POST['title']);
			$image.='.'.$file_extension;
			// Copying image
			$resize=copy($file['tmp_name'],$dir.$image);
			// Add value to array
			$data=array(
				'author'=>$_SESSION['user']['ID'],
				'title'=>$_POST['title'],
				'slider_link'=>$_POST['slider_link'],
				'alt_text'=>$_POST['alt_text'],
				'image'=>$image
			);
			$db=new db();
			$update=$db->insert('rce_slider',$data);
		}
	}

	rce_log($_SESSION['user']['email'],'edit','Загрузил слайд '.$_POST['title']);
	header("Location: /admin/?module=".rce_get_currentdir()."&status=".$action."_ok");
	
} elseif($action=='delete'){
	// Post data
	$id=$_POST['id'];
	$db=new db();
	$delete=$db->delete('rce_slider',"`ID`='$id'");
	rce_log($_SESSION['user']['email'],'delete','Удалил слайд с ID: '.$id);
	header("Location: /admin/?module=".rce_get_currentdir()."&status=".$action."_ok");
}

?>