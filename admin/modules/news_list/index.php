<?
// News
require("functions.php");

$db=new db();
$module=$db->select('SELECT * FROM `rce_modules` WHERE `codename`="'.$_GET['module'].'"','','','');

if(!isset($_GET['action'])){ // NO ACTIONS
	// Logs list
	
	// ПЕДЖИНАТОР_БЕТА_3.0
	$page_id=$_GET['page_id'];
	if(!isset($page_id)) {$page_id=1;}
	// Выставляем лимит на страницу
	$limit=30;

	$start_limit = ($page_id * $limit)-$limit;
	$end_limit = $start_limit+$limit;
	
	// Формируем лимитную приставку
	$LIMITS="LIMIT ".$start_limit.", ".$limit;
	
	$test_result=mysql_query("
		SELECT * FROM `rce_news_list` WHERE `lang`='ru' ORDER BY `ID` ASC
	");
	$num = mysql_num_rows($test_result);
	$pages = ceil($num/$limit);
	
	$page_before=$pages-1;
	$page_one=1;
	$page_after=2;

	if($num<=$limit){$pagin_show='display:none;';}
	// Формируем список страниц
	$pages_plus_one=$pages+1;
	for($i=1;$i<$pages_plus_one;$i++){
		if($page_id==$i){
			$pagelist.='<a class="button button__access">'.$page_id.'</a>';
		} else {
			$pagelist.='<a class="button button__edit"  href="'.RCE_ADMIN.'?module='.$_GET['module'].'&page_id='.$i.'">'.$i.'</a>';
		}
	}
	$paginator.='
		<div class="wrapper-main pagination" style="'.$pagin_show.'">
			'.$pagelist.'
		</div>
	';
	// Конец педжинатора, $paginator готов к использованию
		
	$r=mysql_query("
		SELECT * FROM `rce_news_list` WHERE `lang`='ru' ORDER BY `ID` ASC
	".$LIMITS);
	for($i=0;$i<mysql_num_rows($r);$i++){
		$f=mysql_fetch_array($r);
			// Get user
			$user=rce_get_userdata($f['author']);
			// Edit access
			if(rce_access($_GET['module'],'edit')){
				$edit='
				  <a class="button button__edit" href="'.RCE_ADMIN.'?module='.$_GET['module'].'&action=edit&id='.$f['ID'].'">Редактировать</a>
				';
			} else {$edit='';}
			// Delete access
			if(rce_access($_GET['module'],'delete')){
				$delete='
          <a class="button button__cancel" href="'.RCE_ADMIN.'?module='.$_GET['module'].'&action=delete&id='.$f['ID'].'">Удалить</a>
				';
			} else {$delete='';}
			// Info link
			$info='
        <a class="button button__access" href="https://'.RCE_HOST.'/news/'.$f['trans'].'" target="_blank">Просмотр</a>
			';
			// Params
			if($f['source']==''){
				$source='не указан';
			} else {
				$source='указан';
			}
			// List
			$list.='
  <tr class="table-info__param">
    <td class="table-info__param--id">'.$f['ID'].'</td>
    <td class="table-info__param--title">
      <h2 class="info-headers">'.$f['title'].'</h2>
      <p class="txt-error">Оригинал: '.$source.'</p>
    </td>
    <td class="table-info__param--user">'.$user['email'].'</td>
    <td class="table-info__param--date">'.$f['date'].'</td>
    <td class="table-info__param--link">
      <a class="header__alert" href="https://'.RCE_HOST.'/'.$f['cat'].'" target="_blank">'.rce_news_get_cattitle($f['cat']).'</a>
    </td>
    <td class="table-info__param--action">'.$info.''.$edit.''.$delete.'</td>
  </tr>
  ';
	}
	
	// Status data
	require('status.php');
	$status=rce_get_status($_GET['status'],$statusdata);
	
	// Module add access
	if(rce_access($_GET['module'],'add')){
		$add='
  <a class="button button__access" href="'.RCE_ADMIN.'?module='.$_GET['module'].'&action=add">
    <span class="fa fa-plus"></span>&nbsp;Добавить новость
  </a>
		';
	} else {$add='';}

	// Set title and content
	$title=$module['title'];
	$content='
<main class="wrapper-main">
 <section class="section-header">
    <h1 class="page-header">'.$module['title'].'</h1>
  </section>
  
  '.$status.'
  
  <section class="wrapper-main">
    <section class="section-header">
      <p class="info-headers">Список созданных новостей</p>
		
      '.$add.'

    </section>
    
    <table class="table-info" id="table">
      <thead>
      <tr class="table-info__headers">
        <th class="table-info__headers--id">#</th>
        <th class="table-info__headers--title">Заголовок</th>
        <th class="table-info__headers--user">Автор</th>
        <th class="table-info__headers--date">Дата</th>
        <th class="table-info__headers--link">Рубрика</th>
        <th class="table-info__headers--action">Действия</th>
      </tr>
      </thead>
      <tbody>
      
        '.$list.'
      
      </tbody>
    </table>

    '.$paginator.'
    
  </section>
</main>
';
} else { // HAVE ACTIONS
	// Set action
	$action=$_GET['action'];
	// Cases
	if($action=='add'){
		// General info
		$title='Добавить новость';
		// Lang list
		$r=mysql_query("SELECT * FROM `rce_config_lang` WHERE `active` ORDER BY `ID` ASC");
		for($i=0;$i<mysql_num_rows($r);$i++){
			$f=mysql_fetch_array($r);
				// Creating lang list
				$c=$i+1;
				if($c>=mysql_num_rows($r)){$lang_end='';}else{$lang_end=',';}
				$langs.=$f['lang'].$lang_end;
				// Tab button add
        if($i=='0'){$tab_active='button__access';}else{$tab_active='button__edit';}
				$tabs.='
          <a class="button '.$tab_active.'" href="#'.$f['lang'].'" data-toggle="tab"><span class="flag flag-'.$f['lang'].'"></span> '.$f['lang_title'].'</a>
				';
        // Cats list
        $r=mysql_query("SELECT * FROM `rce_news_cats` ORDER BY `ID` ASC");
        for($i=0;$i<mysql_num_rows($r);$i++){
          $f=mysql_fetch_array($r);
            $cats.='<option value="'.$f['trans'].'">'.$f['title'].'</option>';
        }
				$panels.='
        <section class="wrapper-main data-page" id="'.$f['lang'].'">
          <div class="data-page__panel--color">
            <div class="data-page__panel--title">
              <label for="'.$f['lang'].'_title">Заголовок:</label>
              <input class="data-page__panel--input" id="'.$f['lang'].'_title" type="text" name="'.$f['lang'].'_title" required placeholder="Заголовок новостей."/>
            </div>
            <div class="data-page__panel--title">
              <label for="'.$f['lang'].'_trans">URL адресс:</label>
              <input class="data-page__panel--input" id="'.$f['lang'].'_trans" type="text" name="'.$f['lang'].'_trans" required placeholder="Введите url страницы"/>
            </div>
          </div>
          <div class="data-page__panel">
            <label for="'.$f['lang'].'_meta_title">МЕТА заголовок:</label>
            <input class="data-page__panel--widinput" id="'.$f['lang'].'_meta_title" type="text" name="'.$f['lang'].'_meta_title" required placeholder="Мета заголовок страницы."/>
          </div>
          <div class="data-page__panel--color">
            <label for="'.$f['lang'].'_meta_keys">МЕТА ключи:</label>
              <input class="data-page__panel--widinput" id="'.$f['lang'].'_meta_keys" type="text" name="'.$f['lang'].'_meta_keys" placeholder="Ключевые слова, до 20 слов или фраз через запятую" />
          </div>
          <div class="data-page__panel">
            <label for="'.$f['lang'].'_meta_desc">МЕТА описание:</label>
            <textarea class="data-page__panel--area" id="'.$f['lang'].'_meta_desc" name="'.$f['lang'].'_meta_desc" placeholder="Описание страницы, опишите содержание страницы. Не больше 150 символов"></textarea>
          </div>
          <div class="data-page__panel--color">
            <label for="'.$f['lang'].'_textArea">Содержание</label>
            <textarea class="data-page__panel--area" id="'.$f['lang'].'_textArea" name="'.$f['lang'].'_text"></textarea>
          </div>
          <div class="data-page__panel">
            <label for="file">Фото к новости:</label>
            <div>
              <input class="button" id="file" name="file" type="file"/>
              <p class=txt-error>Выберите картинку для новости</p>
            </div>
          </div>
          <div class="data-page__panel--color">
            <div class="data-page__panel--title">
              <label for="cat">Рубрика:</label>
              <select class="data-page__panel--input" id="cat" name="cat" class="form-control">
                <option value="none">Выберите рубрику</option>
                '.$cats.'
						  </select>
            </div>
            <div class="data-page__panel--title">
              <label for="sourcer">Источник:</label>
              <input class="data-page__panel--input" id="source" type="url" name="source" placeholder="Укажите ссылку"/>
            </div>
          </div>

          <script>
            var editor = CKEDITOR.replace("'.$f['lang'].'_text");
            CKFinder.setupCKEditor( editor, "/admin/template/ckfinder/" );
          </script>
        </section>
        ';
		}

		// Out
		$content.='
<main class="wrapper-main">
  <section class="section-header">
    <h1 class="page-header">'.$module['title'].'</h1>
  </section>
  
  <section class="wrapper-main">
    <section class="section-header">
      <p class="info-headers">Форма добавления рубрики</p>
      <div>
        <input form="newsCreateForm" class="button button__access" type="submit" value="Добавить новость"/>
        <a class="button button__cancel" href="'.RCE_ADMIN.'?module='.$_GET['module'].'">Отменить</a>
      </div>
    </section>

    <form id="newsCreateForm" action="'.RCE_ADMIN.'modules/'.$_GET['module'].'/update.php" method="post" enctype="multipart/form-data">
      <input type="hidden" name="action" value="'.$_GET['action'].'" />
      <input type="hidden" name="langs" value="'.$langs.'" />
      <section class="panel-body">

        <div>
          '.$tabs.'
        </div>
        
        '.$panels.'
        
        
      </section>
    </form>
  </section>
</main>  
';
	} elseif($action=='edit'){
		// General info
		$mod=$db->select('SELECT * FROM `rce_news_list` WHERE `ID`='.$_GET['id'],'','','');
		$title='Редактировать новость '.$mod['title'].' - '.$module['title'];
		// Lang list
		$r=mysql_query("SELECT * FROM `rce_config_lang` WHERE `active` ORDER BY `ID` ASC");
		for($i=0;$i<mysql_num_rows($r);$i++){
			$f=mysql_fetch_array($r);
				// Creating lang list
				$c=$i+1;
				if($c>=mysql_num_rows($r)){$lang_end='';}else{$lang_end=',';}
				$langs.=$f['lang'].$lang_end;
				// Checking page lang
				$count=$db->count("SELECT * FROM `rce_news_list` WHERE `pageID`='".$mod['ID']."' AND `lang`='".$f['lang']."'");
				if($count=='1'){ // Got this page with current lang
					$page=$db->select("SELECT * FROM `rce_news_list` WHERE `pageID`='".$mod['ID']."' AND `lang`='".$f['lang']."'",'','','');
				} else { // No page on this lang, creating localisation
					$data=array(
						'author'=>$_SESSION['user']['ID'],
						'pageID'=>$mod['ID'],
						'lang'=>$f['lang']
					);
					$db->insert('rce_news_list',$data);
					$page=$db->select("SELECT * FROM `rce_news_list` WHERE `pageID`='".$mod['ID']."' AND `lang`='".$f['lang']."'",'','','');
				}
				// Tab button add
				if($i=='0'){$tab_active='button__access';}else{$tab_active='button__edit';}
				$tabs.='
          <a class="button '.$tab_active.'" href="#'.$f['lang'].'" data-toggle="tab"><span class="flag flag-'.$f['lang'].'"></span> '.$f['lang_title'].'</a>
				';
        // Cats list
        $r=mysql_query("SELECT * FROM `rce_news_cats` ORDER BY `ID` ASC");
        for($i=0;$i<mysql_num_rows($r);$i++){
          $f=mysql_fetch_array($r);
            if($mod['cat']==$f['trans']){
              $cat_sel='selected="selected"';
            } else {$cat_sel='';}
            $cats.='<option value="'.$f['trans'].'" '.$cat_sel.'>'.$f['title'].'</option>';
        }
				// Panes
				if($i=='0'){$panel_active='data-page';}else{$panel_active='';}
				$panels.='
        <section class="wrapper-main data-page" id="'.$f['lang'].'">
          <div class="data-page__panel--color">
            <div class="data-page__panel--title">
              <label for="'.$f['lang'].'_title">Заголовок:</label>
              <input class="data-page__panel--input" id="'.$f['lang'].'_title" type="text" name="'.$f['lang'].'_title" required placeholder="Заголовок новостей." value="'.$page['title'].'"/>
            </div>
            <div class="data-page__panel--title">
              <label for="'.$f['lang'].'_trans">URL адресс:</label>
              <input class="data-page__panel--input" id="'.$f['lang'].'_trans" type="text" name="'.$f['lang'].'_trans" required placeholder="Введите url страницы" value="'.$page['trans'].'"/>
            </div>
          </div>
          <div class="data-page__panel">
            <label for="'.$f['lang'].'_meta_title">МЕТА заголовок:</label>
            <input class="data-page__panel--widinput" id="'.$f['lang'].'_meta_title" type="text" name="'.$f['lang'].'_meta_title" required placeholder="Мета заголовок страницы." value="'.$page['meta_title'].'"/>
          </div>
          <div class="data-page__panel--color">
            <label for="'.$f['lang'].'_meta_keys">МЕТА ключи:</label>
              <input class="data-page__panel--widinput" id="'.$f['lang'].'_meta_keys" type="text" name="'.$f['lang'].'_meta_keys" placeholder="Ключевые слова, до 20 слов или фраз через запятую" value="'.$page['meta_keys'].'"/>
          </div>
          <div class="data-page__panel">
            <label for="'.$f['lang'].'_meta_desc">МЕТА описание:</label>
            <textarea class="data-page__panel--area" id="'.$f['lang'].'_meta_desc" name="'.$f['lang'].'_meta_desc" placeholder="Описание страницы, опишите содержание страницы. Не больше 150 символов">'.$page['meta_desc'].'</textarea>
          </div>
          <div class="data-page__panel--color">
            <label for="'.$f['lang'].'_textArea">Содержание</label>
            <textarea class="data-page__panel--area" id="'.$f['lang'].'_textArea" name="'.$f['lang'].'_text">'.$page['text'].'</textarea>
          </div>
          <div class="data-page__panel">
            <label for="file">Фото к новости:</label>
            <div>
              <input class="button" id="file" name="file" type="file"/>
              <p class=txt-error>Выберите картинку для новости</p>
            </div>
          </div>
          <div class="data-page__panel--color">
            <div class="data-page__panel--title">
              <label for="cat">Рубрика:</label>
              <select class="data-page__panel--input" id="cat" name="cat" class="form-control">
                <option value="none">Выберите рубрику</option>
                '.$cats.'
              </select>
            </div>
            <div class="data-page__panel--title">
              <label for="sourcer">Источник:</label>
              <input class="data-page__panel--input" id="source" type="url" name="source" placeholder="Укажите ссылку" value="'.$mod['source'].'"/>
            </div>
          </div>
          

          <script>
            var editor = CKEDITOR.replace("'.$f['lang'].'_text");
            CKFinder.setupCKEditor( editor, "/admin/template/ckfinder/" );
          </script>
        </section>
        ';
    }

    // Out
    $content.='
<main class="wrapper-main">
  <section class="section-header">
    <h1 class="page-header">'.$module['title'].'</h1>
  </section>

  <section class="wrapper-main">
    <section class="section-header">
      <p class="info-headers">Форма редактирования новости</p>
      <div>
        <input form="newsEditForm" class="button button__access" type="submit" value="Сохранить настройки"/>
        <a class="button button__cancel" href="'.RCE_ADMIN.'?module='.$_GET['module'].'">Отменить</a>
      </div>
    </section>
    
    <form id="newsEditForm" action="'.RCE_ADMIN.'modules/'.$_GET['module'].'/update.php" method="post"  enctype="multipart/form-data">
      <input type="hidden" name="action" value="'.$_GET['action'].'" />
      <input type="hidden" name="id" value="'.$_GET['id'].'" />
      <input type="hidden" name="langs" value="'.$langs.'" />
      <section class="panel-body">

        <div>
          '.$tabs.'
        </div>    

        '.$panels.'

      </section>
    </form>
  </section>
</main>
';
  } elseif($action=='delete'){
    $lang=$db->select('SELECT * FROM `rce_news_list` WHERE `ID`='.$_GET['id'],'','','');
    $title='Удалить новость '.$lang['title'].' - '.$module['title'];
    $content.='
<main class="wrapper-main">
  <section class="section-header">
    <h1 class="page-header">'.$module['title'].'</h1>
  </section>

  <section class="wrapper-main">
    <section class="section-header">
      <p class="info-headers">Подтверждение для удаления страницы новости</p>
      <div>
        <input form="newsDeleteForm" class="button button__edit" type="submit" value="Удалить новость!"/>
        <a class="button button__cancel" href="'.RCE_ADMIN.'?module='.$_GET['module'].'">Отменить</a>
      </div>
    </section>

    <form id="newsDeleteForm" action="'.RCE_ADMIN.'modules/'.$_GET['module'].'/update.php" method="post">
      <input type="hidden" name="action" value="'.$_GET['action'].'" />
      <input type="hidden" name="id" value="'.$_GET['id'].'" />
      <section class="panel-body">
        <p class="txt-error page-header"><strong>Вы уверены, что хотите удалить новость:</strong><br /><br /> '.$lang['title'].'?</p>
      </section>
    </form>

  </section>
</main>

';
  }
}

$css='
  <link href="'.RCE_ADMIN.'template/css/flags.css" rel="stylesheet">
';
$js='
  <script src="'.RCE_ADMIN.'template/js/plugins/dataTables/jquery.dataTables.js"></script>
    <script src="'.RCE_ADMIN.'template/js/plugins/dataTables/dataTables.bootstrap.js"></script>
  <script>
    $(document).ready(function(){
      $("#table").dataTable({
        "oLanguage":{
          "sUrl": "'.RCE_ADMIN.'template/js/config/tables_ru_RU.txt"
        },
        "paging":false,
        "search":false
      });
    });
    </script>
';


// Template output
$rce=new rce_admin();
$out=$rce->render($title,$menu,$content,$css,$js);
//$out=$rce->page404();

?>