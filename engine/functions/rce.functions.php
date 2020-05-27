<?
// Functions
/*
	get_id_from_page() - Get the trans of the page and pageID for out.
	get_current_lang() - Setting up current language, or default (ru) if not set.

*/

// Addon functions
include("img_resize.php");

// Get ID from trans page
// Ex (param): $trans == 1-Test_page
function rce_get_pageid($trans){
	$r=mysql_query("SELECT * FROM `rce_pages` WHERE `trans`='".$trans."'");
	$f=mysql_fetch_array($r);
	return $f['pageID'];
}
// Get current lang
// Ex (param): $get == ru
function rce_get_lang($get){
	if(!isset($get)){
		$lang='ru';
	} else {
		$lang=$get;
	}
	return $lang;
}
// Get pages list
// Ex (param): $lang == ru
function rce_get_pagelist($lang){
	$db=new db();
	$q=mysql_query("SELECT * FROM `rce_pages` WHERE `lang`='".$lang."'");
	for($i=0;$i<mysql_num_rows($q);$i++){
		$f=mysql_fetch_array($q);
			$result.='
				<div class="page_list_item">
					ID: '.$f['ID'].' | Title: '.$f['title'].' | Trans: '.$f['trans'].'
				</div>
			';
	}
	if(mysql_num_rows($q)=='0'){
		$result='Извините, страниц для данного языка нет!';
	}
	return $result;
}
// Remove quotes
// Ex (param): $line == test'"`test2
function rce_remove_quotes($line){
	$replace=array(
		'"'=>'',
		"'"=>'',
		'`'=>''
	);
	$result=strtr($line,$replace);
	return $result;
}
// Set status
// Ex (param): $get = auth_err || $statusdata = array (statusdata)
function rce_get_status($get,$statusdata){
	foreach($statusdata as $key=>$value){
		if($get==$key){
			$status=$value;
		}
	}
	return $status;
}
// Add user log
// Ex (param): $user == test@rce.com || $type == add || $action == user added a page
function rce_log($user,$type,$action){
	$db=new db();
	$ip=$_SERVER['REMOTE_ADDR'];
	$data=array(
		'user'=>$user,
		'type'=>$type,
		'action'=>$action,
		'ip'=>$ip
	);
	$query=$db->insert('rce_logs_users',$data);
}
// Add error log
// Ex (param): $type == err_404
function rce_error($type){
	$db=new db();
	$url=$_SERVER['REQUEST_URI'];
	$ip=$_SERVER['REMOTE_ADDR'];
	$data=array(
		'type'=>$type,
		'url'=>$url,
		'ip'=>$ip
	);
	$query=$db->insert('rce_logs_errors',$data);
	$err_push='
		Ошибка на сайте
		Тип: '.$type.'
		URL: '.$url.'
	';
	rce_push($err_push);
}
// Check access rights
// Ex (param): $module == pages || $action == add
function rce_access($module,$action){
	$db=new db();
	$query=$db->select("SELECT * FROM `rce_users_access` WHERE `group`='".$_SESSION['user']['group']."' AND `module`='$module' AND `action`='$action'",'','','');
	return $query['allow'];
}
// Check sccess rights for SYSTEM LOGIN
// Ex (param): $module == pages || $action == add
function rce_access_auth($module,$action,$group){
	$db=new db();
	$query=$db->select("SELECT * FROM `rce_users_access` WHERE `group`='$group' AND `module`='$module' AND `action`='$action'",'','','');
	return $query['allow'];
}
// Convert string to translit
// Ex (param): $string == Строка
function rce_translit($string){
	$converter = array(
	'а' => 'a', 'б' => 'b', 'в' => 'v',
	'г' => 'g', 'д' => 'd', 'е' => 'e',
	'ё' => 'e', 'ж' => 'zh', 'з' => 'z',
	'и' => 'i', 'й' => 'y', 'к' => 'k',
	'л' => 'l', 'м' => 'm', 'н' => 'n',
	'о' => 'o', 'п' => 'p', 'р' => 'r',
	'с' => 's', 'т' => 't', 'у' => 'u',
	'ф' => 'f', 'х' => 'h', 'ц' => 'c',
	'ч' => 'ch', 'ш' => 'sh', 'щ' => 'sch',
	'ь' => '', 'ы' => 'y', 'ъ' => '',
	'э' => 'e', 'ю' => 'yu', 'я' => 'ya',

	'А' => 'A', 'Б' => 'B', 'В' => 'V',
	'Г' => 'G', 'Д' => 'D', 'Е' => 'E',
	'Ё' => 'E', 'Ж' => 'Zh', 'З' => 'Z',
	'И' => 'I', 'Й' => 'Y', 'К' => 'K',
	'Л' => 'L', 'М' => 'M', 'Н' => 'N',
	'О' => 'O', 'П' => 'P', 'Р' => 'R',
	'С' => 'S', 'Т' => 'T', 'У' => 'U',
	'Ф' => 'F', 'Х' => 'H', 'Ц' => 'C',
	'Ч' => 'Ch', 'Ш' => 'Sh', 'Щ' => 'Sch',
	'Ь' => '', 'Ы' => 'Y', 'Ъ' => '',
	'Э' => 'E', 'Ю' => 'Yu', 'Я' => 'Ya',
	' ' => '_', '(' => '_', ')' => '_', 
	'і' => 'i',  'ї' => 'i', 
	
	'?' => '', '@' => '', '#' => '', '$' => '','«' => '','»' => '',
	'%' => '', '^' => '', '&' => '', '*' => '', 
	'~' => '', '+' => '', '`' => '', ';' => '', 
	'/' => '', "'" => '_', '"' => '_', ',' => '_', '№' => ''
	);
	return strtr($string, $converter);
}
// Get engine option
// Ex (param): $param == test_param
function rce_get_config($param){
	$db=new db();
	$query=$db->select("SELECT * FROM `rce_config_general` WHERE `param`='$param'",'','','');
	return $query['value'];
}
// Get userdata by ID
// Ex (param): $userid == 1
function rce_get_userdata($userid){
	$db=new db();
	$query=$db->select("SELECT * FROM `rce_users` WHERE `ID`='$userid'",'','','');
	return $query;
}
// Get group title ID
// Ex (param): $group == 1
function rce_get_usergroup($group){
	$db=new db();
	$query=$db->select("SELECT * FROM `rce_users_groups` WHERE `level`='$group'",'','','');
	return $query;
}
// Get news cat title from trans
// Ex (param): $trans == cats_trans
function rce_get_news_cattitle($trans){
	$db=new db();
	$query=$db->select("SELECT * FROM `rce_news_cats` WHERE `trans`='$trans'",'','','');
	return $query['title'];
}
// Get articles cat title from trans
// Ex (param): $trans == cats_trans
function rce_get_articles_cattitle($trans){
	$db=new db();
	$query=$db->select("SELECT * FROM `rce_articles_cats` WHERE `trans`='$trans'",'','','');
	return $query['title'];
}
// Get news cat title from trans
// Ex (param): $id == 6
function rce_get_page_data($id){
	$db=new db();
	$query=$db->select("SELECT * FROM `rce_pages` WHERE `ID`='$id'",'','','');
	return $query;
}
// DB select query
function rce_db_select($q){
	$r=mysql_query($q);
	$result=mysql_fetch_array($r);
	return $result;
}
// DB update views counter query
function rce_views_add($module,$trans){
	if($module=='blog'){
		$r=mysql_query("SELECT * FROM `rce_articles_list` WHERE `trans`='".$trans."'");
		$f=mysql_fetch_array($r);
		$plus=$f['views']+1;
		$r=mysql_query("UPDATE `rce_articles_list` SET `views`='".$plus."' WHERE `trans`='".$trans."'");
	}
}
// Error 404
function rce_404(){
	$error='
		404 ошибка! Такой страницы не существует!<br />
		Сейчас мы перенаправим вас на главную страницу сайта, ожидайте...
		<meta http-equiv="refresh" content="3;url=https://'.$_SERVER['HTTP_HOST'].'/">
    
  Error page (inengine/function/rce.function)
	';
	global $title,$meta_title,$meta_keys,$meta_desc;
	$title='Ошибочка вышла';
	$meta_title='Ошибка 404';
	$meta_keys='здесь, нет, такой, страницы, :)';
	$meta_desc='';
	return $error;
}
// Date separate
function rce_sep_date($date) {
	// Have $date, ex: 2013-04-20 00:20:54
	$sep1=explode(" ",$date); // Exploding, than have: 2013-04-20 and 00:20:54
	$date1=explode("-",$sep1[0]); // One more explode, result:  2013 and 04 and 20
	$time1=explode(":",$sep1[1]); // And one more explode, result: 00 and 20 and 54
	// Month int value to string
	if($date1[1]=='01'){$mon='января';}
	elseif($date1[1]=='02'){$mon='февраля';}
	elseif($date1[1]=='03'){$mon='марта';}
	elseif($date1[1]=='04'){$mon='апреля';}
	elseif($date1[1]=='05'){$mon='мая';}
	elseif($date1[1]=='06'){$mon='июня';}
	elseif($date1[1]=='07'){$mon='июля';}
	elseif($date1[1]=='08'){$mon='августа';}
	elseif($date1[1]=='09'){$mon='сентября';}
	elseif($date1[1]=='10'){$mon='октября';}
	elseif($date1[1]=='11'){$mon='ноября';}
	elseif($date1[1]=='12'){$mon='декабря';}
	// Date (today, yesterday, etc.)
	$today=date(j);
	$yesterday=$today-1;
	if($date1[2]==$today){
		$last='Сегодня в '.$time1[0].':'.$time1[1];
	} elseif($date1[2]==$yesterday){
		$last='Вчера в '.$time1[0].':'.$time1[1];
	} else {
		$last=$date1[2].' '.$mon.' '.$date1[0].' в '.$time1[0].':'.$time1[1];
	}
	// Date, to minutes
	$to_min=$date1[2].' '.$mon.' '.$date1[0].' '.$time1[0].':'.$time1[1];
	$to_date=$date1[2].' '.$mon.' '.$date1[0];
	
	/*
		USE:
		0  - 2013-04-20				// Day-month-year
		1  - 00:20:54				// Hours:minutes:seconds
		2  - 2013					// Year
		3  - 04						// Month
		4  - 20						// Day
		5  - 00						// Hours
		6  - 20						// Minutes
		7  - 54						// Seconds
		8  - апр					// Month string
		9  - Сег/вчера в [время]	// Day (today, yesterday, etc.)
		10 - 11 дек 2013 20:46		// Date with string to minutes
		11 - 11 дек 2013			// Date, month, year
	*/
	$result=array($sep1[0],$sep1[1],$date1[0],$date1[1],$date1[2],$time1[0],$time1[1],$time1[2],$mon,$last,$to_min,$to_date);
	return $result;
}
// Функция вернет TRUE либо FALSE
function isEven($value)
{
	return ($value%2 == 0);
}
// Get month string from int
function rce_get_month($month){
	if($month=='01'){$mon='января';}
	elseif($month=='02'){$mon='февраля';}
	elseif($month=='03'){$mon='марта';}
	elseif($month=='04'){$mon='апреля';}
	elseif($month=='05'){$mon='мая';}
	elseif($month=='06'){$mon='июня';}
	elseif($month=='07'){$mon='июля';}
	elseif($month=='08'){$mon='августа';}
	elseif($month=='09'){$mon='сентября';}
	elseif($month=='10'){$mon='октября';}
	elseif($month=='11'){$mon='ноября';}
	elseif($month=='12'){$mon='декабря';}
	return $mon;
}
// Shortened month name
function rce_get_shortmonth($month){
	if($month=='января'){$mon='янв';}
	elseif($month=='февраля'){$mon='фев';}
	elseif($month=='марта'){$mon='мар';}
	elseif($month=='апреля'){$mon='апр';}
	elseif($month=='мая'){$mon='мая';}
	elseif($month=='июня'){$mon='июн';}
	elseif($month=='июля'){$mon='июл';}
	elseif($month=='августа'){$mon='авг';}
	elseif($month=='сентября'){$mon='сен';}
	elseif($month=='октября'){$mon='окт';}
	elseif($month=='ноября'){$mon='ноя';}
	elseif($month=='декабря'){$mon='дек';}
	return $mon;
}
// Check if menu item is active
function rce_menu_active_single($module){
	if($_GET['module']==$module){
		$active='style="background:#d6e9fd;"';
	} else {
		$active='';
	}
	return $active;
}
// Check if menu item is active (multimenu)
function rce_menu_active_multi($group){
	$modules=array();
	$r=mysql_query("SELECT * FROM `rce_modules` WHERE `group`='".$group."'");
	for($i=0;$i<mysql_num_rows($r);$i++){
		$f=mysql_fetch_array($r);
			$modules[]=$f['codename'];
	}
	if(in_array($_GET['module'],$modules)){
		$active=array(
			'li'=>'class="active"',
			'ul'=>'collapse in'
		);
	}
	return $active;
}
// RCE Push messages to admin
function rce_push($message){
	if(rce_get_config('push_msg')=='1'){ // If allowed in config
		// Fsocket method
		$data="token=487e1c4c358811e491ad00163e00103d&title=".$_SERVER['HTTP_HOST']."&message=".$message;
		$fp = fsockopen("api.jeapie.com", 80, $errno, $errstr, 10);
		$out = "POST /v2/personal/send/message.json HTTPS/1.1\n";
		$out .= "Host: api.jeapie.com\n";
		$out .= "Referer: ".$_SERVER['HTTP_HOST']."/\n";
		$out .= "User-Agent: Opera\n";
		$out .= "Content-Type: application/x-www-form-urlencoded\n";
		$out .= "Content-Length: ".strlen($data)."\n\n";
		$out .= $data."\n\n";
		fputs($fp, $out);
		fclose($fp);
	} else {
		// Nothing
	}
}
// Get current dir of the script
function rce_get_currentdir(){
	$dirname=dirname($_SERVER['PHP_SELF']);
	$check=strpos($dirname,'/');
	if($check===false){ // No slash, single dir, return result
		$dir=$dirname;
	} else {
		$e=explode('/',$dirname);
		$c=count($e);
		$i=1;
		foreach($e as $key=>$val){
			if($i==$c){
				$dir=$val;
			} else {
				//
			}
			$i++;
		}
	}
	return $dir;
}
// Get status description by code
function rce_status($get){
	$db=new db();
	$query=$db->select("SELECT * FROM `rce_config_status` WHERE `get`='$get'",'','','');
	return $query['status'];
}
// Mail function
function rce_mail($subject,$text,$email){
	$theMailer = new PHPMailer();
	$theMailer->SetFrom('evrostroy.ukraine@gmail.com', 'SystemMessage');
	$theMailer->Subject = $subject;
	$theMailer->Body = $text;
	$theMailer->AddAddress($email);
	$theMailer->MsgHTML($text);
	$theMailer->Send();
}
function rce_mail2($subject,$text,$email){
	//открываем сокет к http://www.example.loc на 80-й порт с таймаутом в 30 секунд
	$socket = fsockopen('www.s1.mybike.pro', 80, $errno, $errstr, 30);
	//если fsockopen вернула false, то завершаем работу скрипта и выводим текст и номер ошибки
	if(!$socket)die("$errstr($errno)");
	//собираем данные
	$data="action=".urlencode("send")."&title=".urlencode($subject)."&text=".urlencode($text)."&email=".urlencode($email);
	//пишем в сокет метод, URI и протокол 
	fwrite($socket, "POST /mail.php HTTP/1.0\r\n");
	//а также имя хоста
	fwrite($socket, "Host: www.s1.mybike.pro\r\n");
	//теперь отправляем заголовки
	//Content-type должен быть applicaion/x-www-form-urlencoded
	fwrite($socket,"Content-type: application/x-www-form-urlencoded\r\n");
	//размер передаваемых данных передаем в заголовке Content-length
	fwrite($socket,"Content-length:".strlen($data)."\r\n");
	//типы принимаемых данных. */* означает, что принимаем все типы данных
	fwrite($socket,"Accept:*/*\r\n");
	//представимся оперой
	fwrite($socket,"User-agent:Opera 10.00\r\n");
	fwrite($socket,"Connection:Close\r\n");
	fwrite($socket,"\r\n");
	//теперь передаем данные
	fwrite($socket,"$data\r\n");
	fwrite($socket,"\r\n");
	//теперь читаем и выводим ответ
	$answer = '';
	while(!feof($socket)){
		$answer.= fgets($socket, 4096);
	}
	//echo $answer;
	//закрываем сокет
	fclose($socket);
}
// Pass encryption
function rce_pass($pass){
	$salt='$2a$10$'.substr(str_replace('+', '.', base64_encode(pack('N4', mt_rand(), mt_rand(), mt_rand(),mt_rand()))), 0, 22).'$';
	$result=crypt($pass,$salt);
	return $result;
}
function rce_pass_check($hash,$pass){
	$full=substr($hash,0,29);
	$new_hash=crypt($pass,$full);
	return ($hash==$new_hash);
}
function rce_pass_check2($hash,$pass){
	$full=substr($hash,0,29);
	$new_hash=crypt($pass,$full);
	return $new_hash;
}
// Users update online time
function rce_update_online(){
	$online=date("Y-m-d H:i:s");
	$r=mysql_query("
		UPDATE `rce_users` SET
		`date_visit`='$online'
		WHERE `ID`='".$_SESSION['user']['ID']."'
	");
}
// Portfolio cetegories list
function rce_portfolio_categories($url){
	$out='<span>Категории:</span> <a class="hvr-outline-in" href="/portfolio/">Показать все</a>';
	$r=mysql_query("
		SELECT * FROM `rce_portfolio_cats` ORDER BY `order` ASC
	");
	for($i=0;$i<mysql_num_rows($r);$i++){
		$f=mysql_fetch_array($r);
		$rt=mysql_query("
				SELECT * FROM `rce_portfolio` WHERE `cat`='".$f['trans']."'
			");
		if(mysql_num_rows($rt)>0){
			if($url==$f['trans']){
				$out.='<a class="active" href="/portfolio/cat/'.$f['trans'].'/">'.$f['title'].' ('.mysql_num_rows($rt).')</a>';
			} else {
				$out.='<a class="hvr-outline-in" href="/portfolio/cat/'.$f['trans'].'/">'.$f['title'].' ('.mysql_num_rows($rt).')</a>';
			}
		} else {
			$out.='';
		}
	}
	$out.='<div class="c"></div>';
	return $out;
}
// Get module info [Portfolio]
function rce_get_modulename($module){
	$r=mysql_query("
		SELECT * FROM `rce_portfolio_modules_list` WHERE `module`='".$module."'
	");
	$f=mysql_fetch_array($r);
	return $f['title'];
}
// Share page buttons
function rce_social_share($title,$desc,$image){
	// Insert special meta tags
	global $meta_special, $meta_spec;
	$meta_special='1';
	$meta_spec='
	<meta property="og:title" content="'.$title.'" />
	<meta property="og:description" content="'.strip_tags(mb_substr($desc,0,700)).'" />
	<meta property="og:image" content="'.$image.'" />';
	// Insert social share script
	$data='
		<script type="text/javascript">(function() {
		  if (window.pluso)if (typeof window.pluso.start == "function") return;
		  if (window.ifpluso==undefined) { window.ifpluso = 1;
			var d = document, s = d.createElement(\'script\'), g = \'getElementsByTagName\';
			s.type = \'text/javascript\'; s.charset=\'UTF-8\'; s.async = true;
			s.src = (\'https:\' == window.location.protocol ? \'https\' : \'http\')  + \'://share.pluso.ru/pluso-like.js\';
			var h=d[g](\'body\')[0];
			h.appendChild(s);
		  }})();</script>
		<div class="pluso" data-background="transparent" data-options="big,square,line,horizontal,nocounter,theme=04" data-services="vkontakte,facebook,twitter,odnoklassniki,google,moimir"></div>
	';
	return $data;
}
// Kurs
function rce_get_kurs(){
	// Формируем сегодняшнюю дату
	$date = date("d/m/Y");
	// Формируем ссылку
	$link = "http://www.cbr.ru/scripts/XML_daily.asp?date_req=$date";
	// Загружаем HTML-страницу
	$fd = fopen($link, "r");
	$text="";
	if (!$fd) echo "Запрашиваемая страница не найдена";
	else
	{
		// Чтение содержимого файла в переменную $text
		while (!feof ($fd)) $text .= fgets($fd, 4096);
	}
	// Закрыть открытый файловый дескриптор
	fclose ($fd);
	return $text;
}

function rce_kurs(){
	$kurs = '25.32';
	return $kurs;
}

?>