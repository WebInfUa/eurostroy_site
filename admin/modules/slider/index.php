<?
// Slider

$db=new db();
$module=$db->select('SELECT * FROM `rce_modules` WHERE `codename`="'.$_GET['module'].'"','','','');

if(!isset($_GET['action'])){ // NO ACTIONS
	
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
		SELECT * FROM `rce_pages` WHERE `lang`='ru' ORDER BY `ID` ASC
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
  
  // Logs list
	$r=mysql_query("
		SELECT * FROM `rce_slider` ORDER BY `ID` ASC
	");
	for($i=0;$i<mysql_num_rows($r);$i++){
		$f=mysql_fetch_array($r);
			// Get user
			$user=rce_get_userdata($f['author']);

      // Delete access
			if(rce_access($_GET['module'],'delete')){
				$delete='
        <a class="button button__cancel" href="'.RCE_ADMIN.'?module='.$_GET['module'].'&action=delete&id='.$f['ID'].'">Удалить</a>
				';
			} else {$delete='';}
			// Info link
			$info='
      <a class="button button__access" href="https://'.RCE_HOST.'/'.$f['trans'].'" target="_blank">Просмотр</a>
			';
    

			// List
			$list.='
				<tr>
          <td class="table-info__param--id">'.$f['ID'].'</td>
          <td class="table-info__param--title">'.$f['title'].' 
            <br /><img src="/uploads/slider/'.$f['image'].'" height="auto" width="100%" />
          </td>
          <td class="table-info__param--user">'.$user['email'].'</td>
          <td class="table-info__param--date">'.$f['date'].'</td>
					<td class="table-info__param--link">'.$f['slider_link'].'</td>
					<td class="table-info__param--alt">'.$f['alt_text'].'</td>
          <td class="table-info__param--action">'.$info.' '.$delete.'</td>
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
    <span class="fa fa-plus"></span>&nbsp;Добавить слайд
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
      <p class="info-headers">Список созданных страниц</p>
		
    '.$add.'

    </section>
    
    <table class="table-info" id="table">
      <thead>
      <tr class="table-info__headers">
        <th class="table-info__headers--id">#</th>
        <th class="table-info__headers--title">Заголовок</th>
        <th class="table-info__headers--user">Автор</th>
        <th class="table-info__headers--date">Дата</th>
        <th class="table-info__headers--link">Ссылка</th>
        <th class="table-info__headers--alt">Альтернативный текст</th>
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
		$title='Добавить слайд';
    
    $panels.='
    <section class="wrapper-main '.$panel_active.'" id="'.$f['lang'].'">
      <div class="data-page__panel--color">
        <label class="" for="title">Название слайда:</label>
        <input class="data-page__panel--widinput" id="title" name="title" type="text" required placeholder="Заголовок слайда."/>
      </div>
      <div class="data-page__panel">
        <label for="slider_link">Ссылка на страницу:</label>
        <input class="data-page__panel--widinput" id="slider_link" type="text" name="slider_link" required placeholder="Ссылка на слайде."/>
      </div>
      <div class="data-page__panel--color">
        <label for="alt_text">Альтернативный текст <br /> для слайда:</label>
        <textarea class="data-page__panel--area" id="alt_text" name="alt_text" placeholder="Описание слайда, опишите содержание слайда. Не больше 150 символов"></textarea>
      </div>
      <div class="data-page__panel">
        <label for="file">Изображение слайда:</label>
        <div>
          <input class="button" id="file" name="file" type="file"/>
          <p class=txt-error>Размер изображения для слайда должно быть <b>1920*596px</b>!</p>
        </div>
      </div>
    </section>
    ';

		$content.='
			
<main class="wrapper-main">
  <section class="section-header">
    <h1 class="page-header">'.$module['title'].'</h1>
  </section>
  
  <section class="wrapper-main">
    <section class="section-header">
      <p class="info-headers">Форма добавления нового слайда</p>
      <div>
        <input form="slideCreateForm" class="button button__access" type="submit" value="Добавить слайд"/>
        <a class="button button__cancel" href="'.RCE_ADMIN.'?module='.$_GET['module'].'">Отменить</a>
      </div>
    </section>

    <form id="slideCreateForm" action="'.RCE_ADMIN.'modules/'.$_GET['module'].'/update.php" method="post" enctype="multipart/form-data">
      <input type="hidden" name="action" value="'.$_GET['action'].'" />
      <input type="hidden" name="langs" value="'.$langs.'" />
      <section class="panel-body">
        
        '.$panels.'
                
      </section>
    </form>
  </section>
</main>  
';
    
	} elseif($action=='delete'){
		$lang=$db->select('SELECT * FROM `rce_slider` WHERE `ID`='.$_GET['id'],'','','');
		$title='Удалить слайд '.$lang['title'].' - '.$module['title'];
		$content.='
<main class="wrapper-main">
  <section class="section-header">
    <h1 class="page-header">'.$module['title'].'</h1>
  </section>

  <section class="wrapper-main">
    <section class="section-header">
      <p class="info-headers">Подтверждение для удаления страницы</p>
      <div>
        <input form="pageDeleteForm" class="button button__edit" type="submit" value="Удалить Слайд!"/>
        <a class="button button__cancel" href="'.RCE_ADMIN.'?module='.$_GET['module'].'">Отменить</a>
      </div>
    </section>

    <form id="pageDeleteForm" action="'.RCE_ADMIN.'modules/'.$_GET['module'].'/update.php" method="post">
      <input type="hidden" name="action" value="'.$_GET['action'].'" />
      <input type="hidden" name="id" value="'.$_GET['id'].'" />
      <section class="panel-body">
        <p class="txt-error page-header"><strong>Вы уверены, что хотите удалить слайд:</strong><br /><br /> '.$lang['title'].'?</p>
      </section>
    </form>

  </section>
</main>
		';
	}
}

$css='
	<link href="'.RCE_ADMIN.'template/css/plugins/dataTables/dataTables.bootstrap.css" rel="stylesheet">
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