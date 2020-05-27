<?
// Anti-hack
if(!defined('RCE')){
	die('Hacking attempt!');
}

class rce {
	// Compiling tags function
	// Ex: $newtags=array('{title}'=>$title,'content'=>$content);
	// Ex: $rce->gettags($newtags);
	function addtags($newtags){
		// Setting up default template tags
		$tags=array(
			'{RCE_HOST}',
			'{template}'
		);
		$values=array(
			RCE_HOST,
			RCE_TEMPLATE
		);
		// Joininng arrays
		$taglist=array($tags,$values);
		// Pushing new elements to arrays
		if($newtags!=''){
			foreach($newtags as $key=>$value){
				$taglist[0][]=$key;
				$taglist[1][]=$value;
			}
		}
		return $taglist;
	}
	// Header compiling function (metadata+etc)
	// Ex: $rce->metadata($title,$keys,$desc);
	function metadata($lang,$title,$keys,$desc){
		// Get site general title
		$db=new db();
		$q="SELECT * FROM `rce_config_lang` WHERE `lang`='".$lang."'";
		$query=$db->select($q,'','','');
		// Output
		$metadata='<title>Eurostroy: | '.$query['site_title'].'</title>';
		if($keys!=''){$metadata.='<meta name="keywords" content="'.$keys.'" />';}
		if($desc!=''){$metadata.='<meta name="description" content="'.$desc.'" />';}
		$metadata.='<meta name="generator" content="" />';
		return $metadata;
	}
	// Template render function
	// Ex: $rce->render('file.tpl',$data);
	function render($file,$data,$params){
		// Rendering local template
		$r=fopen(RCE_TEMPLATE_ROOT.$file,'r');
		$file=fread($r,filesize(RCE_TEMPLATE_ROOT.$file));
		fclose($r);
		$content=str_replace($data[0],$data[1],$file);
		// Rendering general template
		$rce=new rce();
		$meta=$rce->metadata($params['lang'],$params['meta_title'],$params['meta_keys'],$params['meta_desc']);
		$taglist=array(
			'{metadata}'=>$meta,
			'{content}'=>$content
		);
		// Set home.tpl as index template file
		$file='home.tpl';
		$tags=$rce->addtags($taglist);
		$r=fopen(RCE_TEMPLATE_ROOT.$file,'r');
		$file=fread($r,filesize(RCE_TEMPLATE_ROOT.$file));
		fclose($r);
		$render=str_replace($tags[0],$tags[1],$file);
		return $render;
	}
	// 404 error handling
	// Ex: $rce->page404();
	function page404(){
		// Display error data
		$rce=new rce();
		$tags=$rce->addtags('');
		$out=$rce->render('system/err_404.tpl',$tags,'');
		// Server data
		$url=$_SERVER['REQUEST_URI'];
		$ip=$_SERVER['REMOTE_ADDR'];
		// Creating error log
		$db=new db();
		$data=array(
			'type'=>'err_404',
			'url'=>$url,
			'ip'=>$ip
		);
		$query=$db->insert('rce_logs_errors',$data);
		return $out;
	}
	// Hacking attempt logger [ Currently NOT USED ]
	// Ex: $rce->hacklog();
	function hacklog(){
		// Display error data
		$rce=new rce();
		$tags=$rce->gettags('');
		$out=$rce->render('system/err_hack.tpl',$tags);
		// Server data
		$url=$_SERVER['REQUEST_URI'];
		$ip=$_SERVER['REMOTE_ADDR'];
		// Creating error log
		$db=new db();
		$query=$db->insert('rce_errorlog','`type`,`url`,`ip`',"'err_hack','".$url."','".$ip."'");
		return $out;
	}
	
}

?>