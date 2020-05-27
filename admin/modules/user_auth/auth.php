<?
// Auth handler
session_start();
// Data connect
include('../connector.php');

// Query for user data
$r=mysql_query(sprintf("
	SELECT * FROM `rce_users` 
	WHERE `email`='%s'
	AND `pass`='%s' 
	AND `group`>'5'
",
	mysql_real_escape_string($_POST['email']),
	mysql_real_escape_string($_POST['pass'])
));

// Check user
if(mysql_num_rows($r)==0){ // Data error
	rce_log($_POST['email'],'login','Пытался войти в систему ('.$_POST['pass'].'), ошибка!');
	rce_error('hacking_attempt');
	header("Location: /admin/?status=auth_err");
} else { // Sessing session
	$f=mysql_fetch_array($r);
	// Checking user access to admin
	if(rce_access_auth('user_auth','login',$f['group'])){
		$_SESSION['id']=session_id();
		$_SESSION['auth']=$f['hash'];
		$_SESSION['user']=$f;
		// Cookie
		if(isset($_POST['remember']) && $_POST['remember'] == 'yes'){
			// Setting auth cookie for 24 hours
			setcookie("auth",$f['hash'],time()+3600*24,"/",RCE_HOST); 
		}
		// Log
		rce_log($_POST['email'],'login','Вошел в систему');
		// Login redirect
		header("Location: ".$_POST['redirect']."");
	} else {
		rce_log($_POST['email'],'login','Пытался войти в систему ('.$_POST['pass'].'), ошибка!');
		rce_error('hacking_attempt');
		header("Location: /admin/?status=auth_err");
	}
	
}

?>