<?
// Catalog
require("functions.php");

$db=new db();
$module=$db->select('SELECT * FROM `rce_modules` WHERE `codename`="'.$_GET['module'].'"','','','');

if(!isset($_GET['action'])){ // NO ACTIONS
	// Catalog
	
	// Root
	if(isset($_GET['root'])){ // If not parent dir
		// Search for slash
		$check=strpos($_GET['root'],'/');
		if($check===false){ // No slash, 2nd level category
			$root='> <span class="txt-error">'.rce_catalog_getcattitle($_GET['root']).'</span>';
			$root_arr=array('parent',$_GET['root']);
		} else { // 3+ level category
			$ex=explode('/',$_GET['root']);
			$c=count($ex);
			$i=1;
			foreach($ex as $key=>$val){
				if($i==$c){
					$root_arr=array('parent',$val);
					$root_set.='/'.$val;
					$last='yes';
				} else {
					if($i=='1'){
						$root_set.=$val;
					} else {
						$root_set.='/'.$val;
					}
				}
				if($last=='yes'){
					$root.=' > <span class="txt-error">'.rce_catalog_getcattitle($val).'</span>';
				} else {
					$root.=' > <a class="menu__nav--link" href="/admin/?module='.$_GET['module'].'&root='.$root_set.'">'.rce_catalog_getcattitle($val).'</a>';
				}
				$i++;
			}
		}
	} else {
		$root='';
		$root_arr=array('parent','');
	}
	// Cats query	
	$r=mysql_query("
		SELECT * FROM `rce_catalog_cats` WHERE `".$root_arr[0]."`='".$root_arr[1]."' AND `lang`='ru' ORDER BY `order` ASC
	");
	for($i=0;$i<mysql_num_rows($r);$i++){
		$f=mysql_fetch_array($r);
			// Get user
			$user=rce_get_userdata($f['author']);
			// Edit cat access
			if(rce_access($_GET['module'],'edit_cat')){
				$edit='
          <a class="button button__edit" href="'.RCE_ADMIN.'?module='.$_GET['module'].'&action=edit_cat&id='.$f['ID'].'&root='.$_GET['root'].'">Редактировать</a>
				';
			} else {$edit='';}
			// Delete cat access
			if(rce_access($_GET['module'],'delete_cat')){
				$delete='
          <a class="button button__cancel" href="'.RCE_ADMIN.'?module='.$_GET['module'].'&action=delete_cat&id='.$f['ID'].'&root='.$_GET['root'].'">Удалить</a>
				';
			} else {$delete='';}
			// Info link
			$info='
        <a class="button button__access" href="https://'.RCE_HOST.'/#" target="_blank">Просмотр</a>
			';
			// Image
			if($f['image']==''){
        $image='<p class="txt-error page-header">нет изображения<p>';
			} else {
				$image='<a href="/admin/?module='.$_GET['module'].'&root='.$f['root'].'"><img src="/uploads/catalog/cats/'.$f['image'].'" alt="'.$f['title'].'" style="float:left;" width="15%" height="auto" /></a>';
			}
			// List
			$list_cats.='
  <tr class="table-info__param">
    <td class="table-info__param--id">'.$f['ID'].'</td>
    <td class="table-info__param--title">
      '.$image.'
      <span class="fa fa-fw fa-folder-open "></span> 
      <a class="menu__nav--link page-header" href="/admin/?module='.$_GET['module'].'&root='.$f['root'].'">'.$f['title'].'</a>
      <p class="txt-error">Порядок категории:'.$f['order'].'</p>
    </td>
    <td class="table-info__param--user">'.$user['email'].'</td>
    <td class="table-info__param--date">'.$f['date'].'</td>
    <td class="table-info__param--action">'.$info.''.$edit.''.$delete.'</td>
  </tr>
  ';
	}
	// On case on null cats
	if(mysql_num_rows($r)=='0'){
		$null_cats=' style="display:none;"';
	}
	// $paginator Start
	$page_id=$_GET['page_id'];
	if(!isset($page_id)) {$page_id=1;}
	// Выставляем лимит на страницу
	$limit=20;

	$start_limit = ($page_id * $limit)-$limit;
	$end_limit = $start_limit+$limit;
	
	// Формируем лимитную приставку
	$LIMITS="LIMIT ".$start_limit.", ".$limit;
	
	$test_result=mysql_query("
		SELECT * FROM `rce_catalog_items` WHERE `cat`='".$root_arr[1]."' AND `lang`='ru' ORDER BY `order` ASC
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
      $pagelist.='<a class="button button__edit" href="'.RCE_ADMIN.'?module='.$_GET['module'].'&root='.$_GET['root'].'&page_id='.$i.'">'.$i.'</a>';
		}
	}
	$paginator.='
    <div class="wrapper-main pagination" style="'.$pagin_show.'">
			'.$pagelist.'
		</div>
	';
	// $paginator end!
	// Items query	
	$r=mysql_query("
		SELECT * FROM `rce_catalog_items` WHERE `cat`='".$root_arr[1]."' AND `lang`='ru' ORDER BY `order` ASC $LIMITS
	");
	for($i=0;$i<mysql_num_rows($r);$i++){
		$f=mysql_fetch_array($r);
			// Get user
			$user=rce_get_userdata($f['author']);
			// Edit item access
			if(rce_access($_GET['module'],'edit_item')){
				$edit='
          <a class="button button__edit" href="'.RCE_ADMIN.'?module='.$_GET['module'].'&action=edit_item&id='.$f['ID'].'&root='.$_GET['root'].'">Редактировать</a>
				';
			} else {$edit='';}
			// Copy item access
			if(rce_access($_GET['module'],'copy_item')){
				$copy='
          <a class="button button__edit"  href="'.RCE_ADMIN.'?module='.$_GET['module'].'&action=copy_item&id='.$f['ID'].'&root='.$_GET['root'].'">Копировать</a>
				';
			} else {$copy='';}
			// Delete item access
			if(rce_access($_GET['module'],'delete_item')){
				$delete='
					<a class="button button__cancel" href="'.RCE_ADMIN.'?module='.$_GET['module'].'&action=delete_item&id='.$f['ID'].'&root='.$_GET['root'].'">Удалить</a>
				';
			} else {$delete='';}
			// Info link
			$info='
				<a class="button button__access" href="https://'.RCE_HOST.'/#" target="_blank">Просмотр</a>
			';
			// Image
      if($f['image']==''){
				$image='<p class="txt-error page-header">нет изображения<p>';
			} else {
				$image='<a href="'.RCE_ADMIN.'?module='.$_GET['module'].'&action=edit_item&id='.$f['ID'].'&root='.$_GET['root'].'"><img src="/uploads/catalog/'.$_GET['root'].'/'.$f['image'].'" alt="'.$f['title'].'" style="float:left; " width="15%" height="auto"/></a>';
			}
			// Archive
			if($f['archive']=='1'){
				$archive='<span class="txt-error">Товар снят с публикации!</span> ';
			} else {
				$archive='';
			}
			// List
			$list_items.='
  <tr class="table-info__param">
    <td class="table-info__param--id">'.$f['ID'].'</td>
    <td class="table-info__param--title">
		  '.$image.'
      <span class="fa fa-fw fa-folder-open "></span> 
      <a class="menu__nav--link" href="'.RCE_ADMIN.'?module='.$_GET['module'].'&action=edit_item&id='.$f['ID'].'&root='.$_GET['root'].'">'.$archive.''.$f['title'].'</a>
      <p class="txt-error">Порядок категории:'.$f['order'].'</p>
		  <p class="txt-error">Цена: '.$f['price'].' грн.</p>
    </td>
    <td class="table-info__param--user">'.$user['email'].'</td>
    <td class="table-info__param--date">'.$f['date'].'</td>
    <td class="table-info__param--action">'.$info.''.$edit.''.$copy.''.$delete.'</td>
  </tr>
  ';
	}

	// On case empty dir
	if(mysql_num_rows($r)=='0'){
		$null_items='
			<div>
        <p class="page-header txt-error">В данной категории еще нет товаров.</p>
      </div>
		';
	}
	
	// Status data
	require('status.php');
	$status=rce_get_status($_GET['status'],$statusdata);
	
	// Module add cat access
	if(rce_access($_GET['module'],'add_cat')){
		$add_cat='
			<a class="button button__access" href="'.RCE_ADMIN.'?module='.$_GET['module'].'&action=add_cat&root='.$_GET['root'].'">
				<i class="fa fa-plus fa-fw"></i>
				<i class="fa fa-folder-open fa-fw"></i>
				Добавить категорию
			</a>
		';
	} else {$add_cat='';}
	// Cant add products to base folder
	if(!isset($_GET['root'])){
		$add_item='';
	} else {
		// Module add item access
		if(rce_access($_GET['module'],'add_item')){
			$add_item='
				<a class="button button__access" href="'.RCE_ADMIN.'?module='.$_GET['module'].'&action=add_item&root='.$_GET['root'].'">
					<i class="fa fa-plus fa-fw"></i>
					<i class="fa fa-tag fa-fw"></i>
					Добавить товар
				</a>
			';
		} else {$add_item='';}
	}
	// Price
	if(rce_access($_GET['module'],'edit_price')){
		$edit_price='
			<a class="button button__edit" href="'.RCE_ADMIN.'?module='.$_GET['module'].'&action=edit_price">
				<i class="fa fa-tasks fa-fw"></i>
				Управление прайсом
			</a>
		';
	} else {$edit_price='';}
  
  
  $regen_price='
  <a class="button button__edit" href="'.RCE_ADMIN.'?module='.$_GET['module'].'&action=regen">
    <i class="fa fa-refresh fa-fw"></i>
    Регенерация
  </a>';

	// Set title and content
	$title=$module['title'];
	// Out
	$content='
<main class="wrapper-main">
 <section class="section-header">
    <h1 class="page-header">'.$module['title'].'</h1>
  </section>
  
  '.$status.'
  
  <section class="wrapper-main">
    <section class="section-header">
      <p class="info-headers">Список созданных страниц</p>
		
    '.$add_item.'
    '.$add_cat.'
    '.$edit_price.'
    '.$regen_price.'

    </section>
        
    <div class="wrapper-main">
      <a class="menu__nav--link" href="/admin/?module='.$_GET['module'].'">Каталог товаров</a> '.$root.'
    </div>

    <table class="table-info" id="table">
      <thead '.$null_cats.'>
      <tr class="table-info__headers">
        <th class="table-info__headers--id">#</th>
        <th class="table-info__headers--title">Название</th>
        <th class="table-info__headers--user">Автор</th>
        <th class="table-info__headers--date">Дата</th>
        <th class="table-info__headers--action">Действия</th>
      </tr>
      </thead>
      <tbody '.$null_cats.'>
      
        '.$list_cats.'
      
      </tbody>
      <thead>
        <tr class="table-info__headers">
          <th class="table-info__headers--id">#</th>
          <th class="table-info__headers--title">Название</th>
          <th class="table-info__headers--user">Автор</th>
          <th class="table-info__headers--date">Дата</th>
          <th class="table-info__headers--action">Действия</th>
        </tr>
      </thead>
      <tbody>
        '.$list_items.'
      </tbody>
    </table>

    '.$null_items.'
    '.$paginator.'

  </section>
</main>
	';
} else { // HAVE ACTIONS
	// Set action
	$action=$_GET['action'];
	// Cases
	if($action=='regen'){ // Re-generate trans for products
		
		$r=mysql_query("SELECT * FROM `rce_catalog_items` ORDER BY `ID` ASC");
		for($i=0;$i<mysql_num_rows($r);$i++){
			$f=mysql_fetch_array($r);
				$trans=$f['ID'].'-'.rce_translit($f['title']);
				$ru=mysql_query("
					UPDATE `rce_catalog_items` SET
					`trans`='".$trans."' 
					WHERE `ID`='".$f['ID']."'
				");
		}
		header("Location: /admin/?module=catalog_prod&status=regenerate_ok");
	
	} elseif($action=='edit_price'){ // Pricelist
		
		$title='Изменение прайса';
		$r=mysql_query("SELECT * FROM `rce_catalog_items` ORDER BY `cat` ASC");
		for($i=0;$i<mysql_num_rows($r);$i++){
			$f=mysql_fetch_array($r);
				$list_items.='
  <tr class="table-info__param">
    <td class="table-info__param--id">'.$f['ID'].'</td>
    <td class="table-info__param--title">'.$f['title'].'</td>
    <td class="table-info__param--user">'.rce_catalog_getcattitle($f['cat']).'</td>
    <td class="table-info__param--date">								
      <input type="text" class="form-control price" id="'.$f['ID'].'" value="'.$f['price'].'" />
      <div class="st" id="st-'.$f['ID'].'" style="display:none; font:italic 10px Arial; color:green; padding:2px 0px;">Сохранено!</div>
    </td>
    
  </tr>
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
      <p class="info-headers">Список товаров</p>
    </section>
    
    <table class="table-info" id="table">
      <thead>
      <tr class="table-info__headers">
        <th class="table-info__headers--id">#</th>
        <th class="table-info__headers--title">Название</th>
        <th class="table-info__headers--user">Категория</th>
        <th class="table-info__headers--date">Стоимость</th>
      </tr>
      </thead>
      <tbody>
      
        '.$list_items.'
      
      </tbody>
    </table>
  </section>
</main>
  ';
	
	} elseif($action=='add_cat'){
		// General info
		$title='Добавить категорию товаров';
		// Lang list
		$r=mysql_query("SELECT * FROM `rce_config_lang` WHERE `active` ORDER BY `ID` ASC");
		for($i=0;$i<mysql_num_rows($r);$i++){
			$f=mysql_fetch_array($r);
				// Creating lang list
				$c=$i+1;
				if($c>=mysql_num_rows($r)){$lang_end='';}else{$lang_end=',';}
				$langs.=$f['lang'].$lang_end;
				// Tab button add
				if($i=='0'){$tab_active='class="active"';}else{$tab_active='';}
				$tabs.='
					<li '.$tab_active.'>
						<a href="#'.$f['lang'].'" data-toggle="tab"><span class="flag flag-'.$f['lang'].'"></span> '.$f['lang_title'].'</a>
					</li>
				';
				// Panes
				if($i=='0'){$panel_active='active';}else{$panel_active='';}
				$panels.='
					<div class="tab-pane fade in '.$panel_active.'" id="'.$f['lang'].'">
						<table class="table no-border">
							<tbody>
								<tr>
									<td width="150">Заголовок</td>
									<td><input name="'.$f['lang'].'_title" class="form-control" placeholder="Название категории" /></td>
								</tr>
								<tr>
									<td>Описание</td>
									<td><textarea name="'.$f['lang'].'_text" class="ckeditor form-control"></textarea></td>
								</tr>
								<tr>
									<td>Порядок</td>
									<td><input name="'.$f['lang'].'_order" class="form-control" placeholder="Порядок вывода категории, 0 и выше" /></td>
								</tr>
								<tr>
									<td>МЕТА заголовок</td>
									<td><input name="'.$f['lang'].'_meta_title" class="form-control" placeholder="Мета заголовок категории" /></td>
								</tr>
								<tr>
									<td>МЕТА ключи</td>
									<td><input name="'.$f['lang'].'_meta_keys" class="form-control" placeholder="Ключевые слова, до 20 слов или фраз через запятую" /></td>
								</tr>
								<tr>
									<td>МЕТА описание</td>
									<td><input name="'.$f['lang'].'_meta_desc" class="form-control" placeholder="Описание категории, опишите вкратце о чем страница" /></td>
								</tr>
								<tr>
									<td></td>
									<td>
										<input type="submit" value="Добавить категорию" class="btn btn-primary btn-success" />
									</td>
								</tr>
							</tbody>
						</table>
						<script>
							var editor = CKEDITOR.replace("'.$f['lang'].'_text");
							CKFinder.setupCKEditor( editor, "/admin/template/ckfinder/" );
						</script>
					</div>
				';
		}
		$content.='
			<div id="page-wrapper">
			 <div class="row">
					<div class="col-lg-12">
						<h1 class="page-header">'.$module['title'].'</h1>
					</div>
					<!-- /.col-lg-12 -->
				</div>
				<!-- /.row -->
				<div class="row">
					<div class="col-lg-12">
						<div class="panel panel-default">
							<div class="panel-heading">
								Форма добавления новой категории товаров
								<a class="btn btn-outline btn-warning btn-xs" style="float:right;" href="'.RCE_ADMIN.'?module='.$_GET['module'].'&root='.$_GET['root'].'">
									<i class="fa fa-caret-left fa-fw"></i>
									Отменить
								</a>
								<div style="clear:both;"></div>
							</div>
							<div class="panel-body">
								<div class="table-responsive table">
									<form action="'.RCE_ADMIN.'modules/'.$_GET['module'].'/update.php" method="post" enctype="multipart/form-data">
										<input type="hidden" name="action" value="'.$_GET['action'].'" />
										<input type="hidden" name="root" value="'.$_GET['root'].'" />
										<input type="hidden" name="langs" value="'.$langs.'" />
										<div class="panel-body">
											<!-- Nav tabs -->
											<ul class="nav nav-tabs">
												'.$tabs.'
												<li>
													<a href="#images" data-toggle="tab"><span class="fa fa-fw fa-photo"></span> Изображения</a>
												</li>
											</ul>
											<!-- Tab panels -->
											<div class="tab-content"><br />
												'.$panels.'
												<div class="tab-pane fade in" id="images">
													<table class="table no-border">
														<tbody>
															<tr>
																<td width="150">Выберите файл<br /><span class="infoblock">Главное фото категории</span></td>
																<td><input type="file" name="file" /></td>
															</tr>
															<tr>
																<td></td>
																<td>
																	<input type="submit" value="Добавить категорию" class="btn btn-primary btn-success" />
																</td>
															</tr>
														</tbody>
													</table>
												</div>
											</div>
										</div>
										<!-- /.panel-body -->
									</form>
								</div>
								<!-- /.table-responsive -->
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- /#page-wrapper -->
		';
	} elseif($action=='edit_cat'){
		// General info
		$mod=$db->select('SELECT * FROM `rce_catalog_cats` WHERE `ID`='.$_GET['id'],'','','');
		$title='Редактировать категорию товаров '.$mod['title'].' - '.$module['title'];
		// Lang list
		$r=mysql_query("SELECT * FROM `rce_config_lang` WHERE `active` ORDER BY `ID` ASC");
		for($i=0;$i<mysql_num_rows($r);$i++){
			$f=mysql_fetch_array($r);
				// Creating lang list
				$c=$i+1;
				if($c>=mysql_num_rows($r)){$lang_end='';}else{$lang_end=',';}
				$langs.=$f['lang'].$lang_end;
				// Checking page lang
				$count=$db->count("SELECT * FROM `rce_catalog_cats` WHERE `catID`='".$mod['ID']."' AND `lang`='".$f['lang']."'");
				if($count=='1'){ // Got this page with current lang
					$page=$db->select("SELECT * FROM `rce_catalog_cats` WHERE `catID`='".$mod['ID']."' AND `lang`='".$f['lang']."'",'','','');
				} else { // No page on this lang, creating localisation
					$data=array(
						'author'=>$_SESSION['user']['ID'],
						'catID'=>$mod['ID'],
						'lang'=>$f['lang']
					);
					$db->insert('rce_catalog_cats',$data);
					$page=$db->select("SELECT * FROM `rce_catalog_cats` WHERE `catID`='".$mod['ID']."' AND `lang`='".$f['lang']."'",'','','');
				}
				// Tab button add
				if($i=='0'){$tab_active='class="active"';}else{$tab_active='';}
				$tabs.='
					<li '.$tab_active.'>
						<a href="#'.$f['lang'].'" data-toggle="tab"><span class="flag flag-'.$f['lang'].'"></span> '.$f['lang_title'].'</a>
					</li>
				';
				// Panes
				if($i=='0'){$panel_active='active';}else{$panel_active='';}
				$panels.='
					<div class="tab-pane fade in '.$panel_active.'" id="'.$f['lang'].'">
						<table class="table no-border">
							<tbody>
								<tr>
									<td width="150">Заголовок</td>
									<td><input name="'.$f['lang'].'_title" class="form-control" value="'.$page['title'].'" placeholder="Название категории" /></td>
								</tr>
								<tr style="display:none;">
									<td>ЧПУ</td>
									<td><input name="'.$f['lang'].'_trans" class="form-control" value="'.$page['trans'].'" placeholder="ЧПУ адрес категории" /></td>
								</tr>
								<tr>
									<td>Описание</td>
									<td><textarea name="'.$f['lang'].'_text" class="ckeditor form-control">'.$page['text'].'</textarea></td>
								</tr>
								<tr>
									<td>Порядок</td>
									<td><input name="'.$f['lang'].'_order" class="form-control" value="'.$page['order'].'" placeholder="Порядок вывода категории, 0 и выше" /></td>
								</tr>
								<tr>
									<td>МЕТА заголовок</td>
									<td><input name="'.$f['lang'].'_meta_title" class="form-control" value="'.$page['meta_title'].'" placeholder="Мета заголовок страницы" /></td>
								</tr>
								<tr>
									<td>МЕТА ключи</td>
									<td><input name="'.$f['lang'].'_meta_keys" class="form-control" value="'.$page['meta_keys'].'" placeholder="Ключевые слова, до 20 слов или фраз через запятую" /></td>
								</tr>
								<tr>
									<td>МЕТА описание</td>
									<td><input name="'.$f['lang'].'_meta_desc" class="form-control" value="'.$page['meta_desc'].'" placeholder="Описание страницы, опишите вкратце о чем страница" /></td>
								</tr>
								<tr>
									<td></td>
									<td>
										<input type="submit" value="Сохранить настройки" class="btn btn-primary btn-success" />
									</td>
								</tr>
							</tbody>
						</table>
						<script>
							var editor = CKEDITOR.replace("'.$f['lang'].'_text");
							CKFinder.setupCKEditor( editor, "/admin/template/ckfinder/" );
						</script>
					</div>
				';
				// Current category image
				if($f['lang']=='ru'){
					// Image
					if($page['image']==''){
						$image='нет изображения';
					} else {
						$image='<img src="/uploads/catalog/cats/'.$page['image'].'" alt="'.$page['title'].'" />';
					}
				}
		}
		// Out
		$content.='
			<div id="page-wrapper">
			 <div class="row">
					<div class="col-lg-12">
						<h1 class="page-header">'.$module['title'].'</h1>
					</div>
					<!-- /.col-lg-12 -->
				</div>
				<!-- /.row -->
				<div class="row">
					<div class="col-lg-12">
						<div class="panel panel-default">
							<div class="panel-heading">
								Форма редактирования категории товаров
								<a class="btn btn-outline btn-warning btn-xs" style="float:right;" href="'.RCE_ADMIN.'?module='.$_GET['module'].'&root='.$_GET['root'].'">
									<i class="fa fa-caret-left fa-fw"></i>
									Отменить
								</a>
								<div style="clear:both;"></div>
							</div>
							<div class="panel-body">
								<div class="table-responsive table">
									<form action="'.RCE_ADMIN.'modules/'.$_GET['module'].'/update.php" method="post" enctype="multipart/form-data">
										<input type="hidden" name="action" value="'.$_GET['action'].'" />
										<input type="hidden" name="root" value="'.$_GET['root'].'" />
										<input type="hidden" name="id" value="'.$_GET['id'].'" />
										<input type="hidden" name="langs" value="'.$langs.'" />
										<div class="panel-body">
											<!-- Nav tabs -->
											<ul class="nav nav-tabs">
												'.$tabs.'
												<li>
													<a href="#images" data-toggle="tab"><span class="fa fa-fw fa-photo"></span> Изображения</a>
												</li>
											</ul>
											<!-- Tab panels -->
											<div class="tab-content"><br />
												'.$panels.'
												<div class="tab-pane fade in" id="images">
													<table class="table no-border">
														<tbody>
															<tr>
																<td width="150">Текущее изображение<br /><span class="infoblock">Главное фото категории</span></td>
																<td>'.$image.'</td>
															</tr>
															<tr>
																<td>Выберите файл<br /><span class="infoblock">Если хотите заменить текущее фото категории на новое</span></td>
																<td><input type="file" name="file" /></td>
															</tr>
															<tr>
																<td></td>
																<td>
																	<input type="submit" value="Сохранить изменения" class="btn btn-primary btn-success" />
																</td>
															</tr>
														</tbody>
													</table>
												</div>
											</div>
										</div>
										<!-- /.panel-body -->
									</form>
								</div>
								<!-- /.table-responsive -->
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- /#page-wrapper -->
		';
	} elseif($action=='delete_cat'){
		$lang=$db->select('SELECT * FROM `rce_catalog_cats` WHERE `ID`='.$_GET['id'],'','','');
		$title='Удалить категорию товаров '.$lang['title'].' - '.$module['title'];
		$content.='
			<div id="page-wrapper">
			 <div class="row">
					<div class="col-lg-12">
						<h1 class="page-header">'.$module['title'].'</h1>
					</div>
					<!-- /.col-lg-12 -->
				</div>
				<!-- /.row -->
				<div class="row">
					<div class="col-lg-12">
						<div class="panel panel-default">
							<div class="panel-heading">
								Подтверждение действия
								<a class="btn btn-outline btn-warning btn-xs" style="float:right;" href="'.RCE_ADMIN.'?module='.$_GET['module'].'&root='.$_GET['root'].'">
									<i class="fa fa-caret-left fa-fw"></i>
									Отменить
								</a>
								<div style="clear:both;"></div>
							</div>
							<div class="panel-body">
								<div class="table-responsive table">
									<form action="'.RCE_ADMIN.'modules/'.$_GET['module'].'/update.php" method="post">
										<input type="hidden" name="action" value="'.$_GET['action'].'" />
										<input type="hidden" name="root" value="'.$_GET['root'].'" />
										<input type="hidden" name="id" value="'.$_GET['id'].'" />
										<table class="table no-border">
											<tbody>
												<tr>
													<td>
														Вы уверены, что хотите <b>удалить</b> категорию товаров "'.$lang['title'].'" <b>и все товары</b>, находящиеся в ней?
													</td>
													<td> </td>
												</tr>
												<tr>
													<td>
														<input type="submit" value="Подтвердить удаление" class="btn btn-primary btn-danger" /> 
														<a class="btn btn-warning btn-outline btn-xs" href="'.RCE_ADMIN.'?module='.$_GET['module'].'&root='.$_GET['root'].'">отменить действие</a>
													</td>
													<td></td>
												</tr>
											</tbody>
										</table>
									</form>
								</div>
								<!-- /.table-responsive -->
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- /#page-wrapper -->
		';
	} elseif($action=='add_item'){
		// General info
		$title='Добавить новый товар';
		// Lang list
		$r=mysql_query("SELECT * FROM `rce_config_lang` WHERE `active` ORDER BY `ID` ASC");
		for($i=0;$i<mysql_num_rows($r);$i++){
			$f=mysql_fetch_array($r);
				// Creating lang list
				$c=$i+1;
				if($c>=mysql_num_rows($r)){$lang_end='';}else{$lang_end=',';}
				$langs.=$f['lang'].$lang_end;
				// Tab button add
				if($i=='0'){$tab_active='class="active"';}else{$tab_active='';}
				$tabs.='
					<li '.$tab_active.'>
						<a href="#'.$f['lang'].'" data-toggle="tab"><span class="flag flag-'.$f['lang'].'"></span> '.$f['lang_title'].'</a>
					</li>
				';
				// Panes
				if($i=='0'){$panel_active='active';}else{$panel_active='';}
				$panels.='
					<div class="tab-pane fade in '.$panel_active.'" id="'.$f['lang'].'">
						<table class="table no-border">
							<tbody>
								<tr>
									<td width="150">Название</td>
									<td><input name="'.$f['lang'].'_title" class="form-control" placeholder="Наименование товара" /></td>
								</tr>
								<tr>
									<td>Описание</td>
									<td><textarea name="'.$f['lang'].'_text" class="ckeditor form-control"></textarea></td>
								</tr>
								<tr>
									<td>МЕТА заголовок</td>
									<td><input name="'.$f['lang'].'_meta_title" class="form-control" placeholder="Мета заголовок товара" /></td>
								</tr>
								<tr>
									<td>МЕТА ключи</td>
									<td><input name="'.$f['lang'].'_meta_keys" class="form-control" placeholder="Ключевые слова, до 20 слов или фраз через запятую" /></td>
								</tr>
								<tr>
									<td>МЕТА описание</td>
									<td><input name="'.$f['lang'].'_meta_desc" class="form-control" placeholder="Описание товара, опишите вкратце о чем страница" /></td>
								</tr>
								<tr>
									<td></td>
									<td>
										<input type="submit" value="Добавить товар" class="btn btn-primary btn-success" />
									</td>
								</tr>
							</tbody>
						</table>
						<script>
							var editor = CKEDITOR.replace("'.$f['lang'].'_text");
							CKFinder.setupCKEditor( editor, "/admin/template/ckfinder/" );
						</script>
					</div>
				';
		}
		$content.='
			<div id="page-wrapper">
			 <div class="row">
					<div class="col-lg-12">
						<h1 class="page-header">'.$module['title'].'</h1>
					</div>
					<!-- /.col-lg-12 -->
				</div>
				<!-- /.row -->
				<div class="row">
					<div class="col-lg-12">
						<div class="panel panel-default">
							<div class="panel-heading">
								Форма добавления нового товара
								<a class="btn btn-outline btn-warning btn-xs" style="float:right;" href="'.RCE_ADMIN.'?module='.$_GET['module'].'&root='.$_GET['root'].'">
									<i class="fa fa-caret-left fa-fw"></i>
									Отменить
								</a>
								<div style="clear:both;"></div>
							</div>
							<div class="panel-body">
								<div class="table-responsive table">
									<form action="'.RCE_ADMIN.'modules/'.$_GET['module'].'/update.php" method="post" enctype="multipart/form-data">
										<input type="hidden" name="action" value="'.$_GET['action'].'" />
										<input type="hidden" name="root" value="'.$_GET['root'].'" />
										<input type="hidden" name="langs" value="'.$langs.'" />
										<div class="panel-body">
											<!-- Nav tabs -->
											<ul class="nav nav-tabs">
												'.$tabs.'
												<li>
													<a href="#params" data-toggle="tab"><span class="fa fa-fw fa-cogs"></span> Параметры товара</a>
												</li>
												<li>
													<a href="#images" data-toggle="tab"><span class="fa fa-fw fa-photo"></span> Изображения</a>
												</li>
											</ul>
											<!-- Tab panels -->
											<div class="tab-content"><br />
												'.$panels.'
												<div class="tab-pane fade in" id="params">
													<table class="table no-border">
														<tbody>
															<tr>
																<td width="150">Артикул</td>
																<td><input name="artno" class="form-control" placeholder="Артикул, код товара" /></td>
															</tr>
															<tr>
																<td>Цена</td>
																<td><input name="price" class="form-control" placeholder="Стоимость товара, за единицу" /></td>
															</tr>
															<tr>
																<td>Старая цена</td>
																<td><input name="price_old" class="form-control" placeholder="Старая цена, если 0 - выводиться не будет" /></td>
															</tr>
															<tr>
																<td>Порядок</td>
																<td><input name="order" class="form-control" placeholder="Порядок вывода товара, от 1 и выше" /></td>
															</tr>
															<tr>
																<td></td>
																<td>
																	<input type="submit" value="Добавить товар" class="btn btn-primary btn-success" />
																</td>
															</tr>
														</tbody>
													</table>
												</div>
												<div class="tab-pane fade in" id="images">
													<table class="table no-border">
														<tbody>
															<tr>
																<td width="150">Выберите файл<br /><span class="infoblock">Главное фото товара</span></td>
																<td><input type="file" name="file" /></td>
															</tr>
															<tr>
																<td></td>
																<td>
																	<input type="submit" value="Добавить товар" class="btn btn-primary btn-success" />
																</td>
															</tr>
														</tbody>
													</table>
												</div>
											</div>
										</div>
										<!-- /.panel-body -->
									</form>
								</div>
								<!-- /.table-responsive -->
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- /#page-wrapper -->
		';
	} elseif($action=='edit_item'){
		// General info
		$mod=$db->select('SELECT * FROM `rce_catalog_items` WHERE `ID`='.$_GET['id'],'','','');
		$title='Редактировать товар '.$mod['title'].' - '.$module['title'];
		// Lang list
		$r=mysql_query("SELECT * FROM `rce_config_lang` WHERE `active` ORDER BY `ID` ASC");
		for($i=0;$i<mysql_num_rows($r);$i++){
			$f=mysql_fetch_array($r);
				// Creating lang list
				$c=$i+1;
				if($c>=mysql_num_rows($r)){$lang_end='';}else{$lang_end=',';}
				$langs.=$f['lang'].$lang_end;
				// Checking page lang
				$count=$db->count("SELECT * FROM `rce_catalog_items` WHERE `itemID`='".$mod['ID']."' AND `lang`='".$f['lang']."'");
				if($count=='1'){ // Got this page with current lang
					$page=$db->select("SELECT * FROM `rce_catalog_items` WHERE `itemID`='".$mod['ID']."' AND `lang`='".$f['lang']."'",'','','');
				} else { // No page on this lang, creating localisation
					$data=array(
						'author'=>$_SESSION['user']['ID'],
						'itemID'=>$mod['ID'],
						'lang'=>$f['lang']
					);
					$db->insert('rce_catalog_items',$data);
					$page=$db->select("SELECT * FROM `rce_catalog_items` WHERE `itemID`='".$mod['ID']."' AND `lang`='".$f['lang']."'",'','','');
				}
				// Tab button add
				if($i=='0'){$tab_active='class="active"';}else{$tab_active='';}
				$tabs.='
					<li '.$tab_active.'>
						<a href="#'.$f['lang'].'" data-toggle="tab"><span class="flag flag-'.$f['lang'].'"></span> '.$f['lang_title'].'</a>
					</li>
				';
				// Panes
				if($i=='0'){$panel_active='active';}else{$panel_active='';}
				$panels.='
					<div class="tab-pane fade in '.$panel_active.'" id="'.$f['lang'].'">
						<table class="table no-border">
							<tbody>
								<tr>
									<td width="150">Заголовок</td>
									<td><input name="'.$f['lang'].'_title" class="form-control" value="'.$page['title'].'" placeholder="Название товара" /></td>
								</tr>
								<tr style="display:none;">
									<td>ЧПУ</td>
									<td><input name="'.$f['lang'].'_trans" class="form-control" value="'.$page['trans'].'" placeholder="ЧПУ адрес товара" /></td>
								</tr>
								<tr>
									<td>Описание</td>
									<td><textarea name="'.$f['lang'].'_text" class="ckeditor form-control">'.$page['text'].'</textarea></td>
								</tr>
								<tr>
									<td>Порядок</td>
									<td><input name="'.$f['lang'].'_order" class="form-control" value="'.$page['order'].'" placeholder="Порядок вывода товара, от 1 и выше" /></td>
								</tr>
								<tr>
									<td>МЕТА заголовок</td>
									<td><input name="'.$f['lang'].'_meta_title" class="form-control" value="'.$page['meta_title'].'" placeholder="Мета заголовок товара" /></td>
								</tr>
								<tr>
									<td>МЕТА ключи</td>
									<td><input name="'.$f['lang'].'_meta_keys" class="form-control" value="'.$page['meta_keys'].'" placeholder="Ключевые слова, до 20 слов или фраз через запятую" /></td>
								</tr>
								<tr>
									<td>МЕТА описание</td>
									<td><input name="'.$f['lang'].'_meta_desc" class="form-control" value="'.$page['meta_desc'].'" placeholder="Описание товара, опишите вкратце о чем страница" /></td>
								</tr>
								<tr>
									<td></td>
									<td>
										<input type="submit" value="Сохранить изменения" class="btn btn-primary btn-success" />
									</td>
								</tr>
							</tbody>
						</table>
						<script>
							var editor = CKEDITOR.replace("'.$f['lang'].'_text");
							CKFinder.setupCKEditor( editor, "/admin/template/ckfinder/" );
						</script>
					</div>
				';
				// Main product image
				if($f['lang']=='ru'){
					// Image
					if($page['image']==''){
						$image='нет изображения';
					} else {
						$image='<img src="/uploads/catalog/'.$_GET['root'].'/mini/'.$page['image'].'" alt="'.$page['title'].'" />';
					}
				}
		}
		// Out
		$content.='
			<div id="page-wrapper">
			 <div class="row">
					<div class="col-lg-12">
						<h1 class="page-header">'.$module['title'].'</h1>
					</div>
					<!-- /.col-lg-12 -->
				</div>
				<!-- /.row -->
				<div class="row">
					<div class="col-lg-12">
						<div class="panel panel-default">
							<div class="panel-heading">
								Форма редактирования товара
								<a class="btn btn-outline btn-warning btn-xs" style="float:right;" href="'.RCE_ADMIN.'?module='.$_GET['module'].'&root='.$_GET['root'].'">
									<i class="fa fa-caret-left fa-fw"></i>
									Отменить
								</a>
								<div style="clear:both;"></div>
							</div>
							<div class="panel-body">
								<div class="table-responsive table">
									<form action="'.RCE_ADMIN.'modules/'.$_GET['module'].'/update.php" method="post" enctype="multipart/form-data">
										<input type="hidden" name="action" value="'.$_GET['action'].'" />
										<input type="hidden" name="root" value="'.$_GET['root'].'" />
										<input type="hidden" name="cat" value="'.$mod['cat'].'" />
										<input type="hidden" name="id" value="'.$_GET['id'].'" />
										<input type="hidden" name="langs" value="'.$langs.'" />
										<div class="panel-body">
											<!-- Nav tabs -->
											<ul class="nav nav-tabs">
												'.$tabs.'
												<li>
													<a href="#params" data-toggle="tab"><span class="fa fa-fw fa-cogs"></span> Параметры товара</a>
												</li>
												<li>
													<a href="#images" data-toggle="tab"><span class="fa fa-fw fa-photo"></span> Изображения</a>
												</li>
											</ul>
											<!-- Tab panels -->
											<div class="tab-content"><br />
												'.$panels.'
												<div class="tab-pane fade in" id="params">
													<table class="table no-border">
														<tbody>
															<tr>
																<td width="150">Артикул</td>
																<td><input name="artno" class="form-control" placeholder="Артикул, код товара" value="'.$mod['artno'].'" /></td>
															</tr>
															<tr>
																<td>Цена</td>
																<td><input name="price" class="form-control" placeholder="Стоимость товара, за единицу" value="'.$mod['price'].'" /></td>
															</tr>
															<tr>
																<td>Старая цена</td>
																<td><input name="price_old" class="form-control" placeholder="Старая цена, если 0 - выводиться не будет" value="'.$mod['price_old'].'" /></td>
															</tr>
															<tr>
																<td>Единицы</td>
																<td><input name="pcs" class="form-control" placeholder="Форма измерения: шт., ящиков и т.д." value="'.$mod['pcs'].'" /></td>
															</tr>
															<tr>
																<td>Порядок</td>
																<td><input name="order" class="form-control" placeholder="Порядок вывода товара, от 1 и выше" value="'.$mod['order'].'" /></td>
															</tr>
															<tr>
																<td><span style="color:red;">Категория</span></td>
																<td><input name="catid" class="form-control" placeholder="Введите ID категории, в которую необходимо перенести товар" /></td>
															</tr>
															<tr>
																<td><span style="color:green;">На главной</span></td>
																<td><input name="fav" class="form-control" placeholder="Если 0 - товар скрыть, 1 - показать на главной" value="'.$mod['fav'].'" /></td>
															</tr>
															<tr>
																<td><span style="color:red;">Архивный</span></td>
																<td><input name="archive" class="form-control" placeholder="Если 0 - товар доступен, 1 - архивный" value="'.$mod['archive'].'" /></td>
															</tr>
															<tr>
																<td></td>
																<td>
																	<input type="submit" value="Сохранить изменения" class="btn btn-primary btn-success" />
																</td>
															</tr>
														</tbody>
													</table>
												</div>
												<div class="tab-pane fade in" id="images">
													<table class="table no-border">
														<tbody>
															<tr>
																<td width="150">Главное фото<br /><span class="infoblock">Главное фото товара</span></td>
																<td>'.$image.'</td>
															</tr>
															<tr>
																<td>Выберите файл<br /><span class="infoblock">Главное фото товара</span></td>
																<td><input type="file" name="file" /></td>
															</tr>
															<tr>
																<td></td>
																<td>
																	<input type="submit" value="Сохранить изменения" class="btn btn-primary btn-success" />
																</td>
															</tr>
														</tbody>
													</table>
												</div>
											</div>
										</div>
										<!-- /.panel-body -->
									</form>
								</div>
								<!-- /.table-responsive -->
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- /#page-wrapper -->
		';
	} elseif($action=='copy_item'){
		// General info
		$prod=$db->select('SELECT * FROM `rce_catalog_items` WHERE `ID`='.$_GET['id'],'','','');
		$title='Копировать товар '.$mod['title'].' - '.$module['title'];
		// Creating copy
		$nextitem=$db->getnext('rce_catalog_items');
		$data=array(
			'author'=>$_SESSION['user']['ID'],
			'itemID'=>$nextitem,
			'lang'=>'ru',
			'cat'=>$prod['cat'],
			'title'=>$prod['title'],
			'artno'=>$prod['artno'],
			'price'=>$prod['price'],
			'price_old'=>$prod['price_old'],
			'trans'=>'new_'.$prod['trans'],
			'text'=>$prod['text'],
			'meta_title'=>$prod['meta_title'],
			'meta_keys'=>$prod['meta_keys'],
			'meta_desc'=>$prod['meta_desc'],
			'image'=>'new_'.$prod['image']
		);
		$update=$db->insert('rce_catalog_items',$data);
		// Copying image
		$dir='../uploads/catalog/'.$_GET['root'].'/';
		$dir_mini='../uploads/catalog/'.$_GET['root'].'/mini/';
		if($prod['image']!=''){
			$copy=copy($dir.$prod['image'],$dir.'new_'.$prod['image']);
			$copy=copy($dir_mini.$prod['image'],$dir_mini.'new_'.$prod['image']);
		}
		// Get new page data
		$mod=$db->select('SELECT * FROM `rce_catalog_items` WHERE `ID`='.$nextitem,'','','');
		// Lang list
		$r=mysql_query("SELECT * FROM `rce_config_lang` WHERE `active` ORDER BY `ID` ASC");
		for($i=0;$i<mysql_num_rows($r);$i++){
			$f=mysql_fetch_array($r);
				// Creating lang list
				$c=$i+1;
				if($c>=mysql_num_rows($r)){$lang_end='';}else{$lang_end=',';}
				$langs.=$f['lang'].$lang_end;
				// Checking page lang
				$count=$db->count("SELECT * FROM `rce_catalog_items` WHERE `itemID`='".$mod['ID']."' AND `lang`='".$f['lang']."'");
				if($count=='1'){ // Got this page with current lang
					$page=$db->select("SELECT * FROM `rce_catalog_items` WHERE `itemID`='".$mod['ID']."' AND `lang`='".$f['lang']."'",'','','');
				} else { // No page on this lang, creating localisation
					$data=array(
						'author'=>$_SESSION['user']['ID'],
						'itemID'=>$mod['ID'],
						'lang'=>$f['lang']
					);
					$db->insert('rce_catalog_items',$data);
					$page=$db->select("SELECT * FROM `rce_catalog_items` WHERE `itemID`='".$mod['ID']."' AND `lang`='".$f['lang']."'",'','','');
				}
				// Tab button add
				if($i=='0'){$tab_active='class="active"';}else{$tab_active='';}
				$tabs.='
					<li '.$tab_active.'>
						<a href="#'.$f['lang'].'" data-toggle="tab"><span class="flag flag-'.$f['lang'].'"></span> '.$f['lang_title'].'</a>
					</li>
				';
				// Panes
				if($i=='0'){$panel_active='active';}else{$panel_active='';}
				$panels.='
					<div class="tab-pane fade in '.$panel_active.'" id="'.$f['lang'].'">
						<table class="table no-border">
							<tbody>
								<tr>
									<td width="150">Заголовок</td>
									<td><input name="'.$f['lang'].'_title" class="form-control" value="Копия '.$page['title'].'" placeholder="Название товара" /></td>
								</tr>
								<tr style="display:none;">
									<td>ЧПУ</td>
									<td><input name="'.$f['lang'].'_trans" class="form-control" value="'.$page['trans'].'" placeholder="ЧПУ адрес товара" /></td>
								</tr>
								<tr>
									<td>Описание</td>
									<td><textarea name="'.$f['lang'].'_text" class="ckeditor form-control">'.$page['text'].'</textarea></td>
								</tr>
								<tr>
									<td>Порядок</td>
									<td><input name="'.$f['lang'].'_order" class="form-control" value="'.$page['order'].'" placeholder="Порядок вывода товара, от 1 и выше" /></td>
								</tr>
								<tr>
									<td>МЕТА заголовок</td>
									<td><input name="'.$f['lang'].'_meta_title" class="form-control" value="'.$page['meta_title'].'" placeholder="Мета заголовок товара" /></td>
								</tr>
								<tr>
									<td>МЕТА ключи</td>
									<td><input name="'.$f['lang'].'_meta_keys" class="form-control" value="'.$page['meta_keys'].'" placeholder="Ключевые слова, до 20 слов или фраз через запятую" /></td>
								</tr>
								<tr>
									<td>МЕТА описание</td>
									<td><input name="'.$f['lang'].'_meta_desc" class="form-control" value="'.$page['meta_desc'].'" placeholder="Описание товара, опишите вкратце о чем страница" /></td>
								</tr>
								<tr>
									<td></td>
									<td>
										<input type="submit" value="Сохранить изменения" class="btn btn-primary btn-success" />
									</td>
								</tr>
							</tbody>
						</table>
						<script>
							var editor = CKEDITOR.replace("'.$f['lang'].'_text");
							CKFinder.setupCKEditor( editor, "/admin/template/ckfinder/" );
						</script>
					</div>
				';
				// Main product image
				if($f['lang']=='ru'){
					// Image
					if($page['image']==''){
						$image='нет изображения';
					} else {
						$image='<img src="/uploads/catalog/'.$_GET['root'].'/mini/'.$page['image'].'" alt="'.$page['title'].'" />';
					}
				}
		}
		// Out
		$content.='
			<div id="page-wrapper">
			 <div class="row">
					<div class="col-lg-12">
						<h1 class="page-header">'.$module['title'].'</h1>
					</div>
					<!-- /.col-lg-12 -->
				</div>
				<!-- /.row -->
				<div class="row">
					<div class="col-lg-12">
						<div class="panel panel-default">
							<div class="panel-heading">
								Форма редактирования товара
								<a class="btn btn-outline btn-warning btn-xs" style="float:right;" href="'.RCE_ADMIN.'?module='.$_GET['module'].'&root='.$_GET['root'].'">
									<i class="fa fa-caret-left fa-fw"></i>
									Отменить
								</a>
								<div style="clear:both;"></div>
							</div>
							<div class="panel-body">
								<div class="table-responsive table">
									<form action="'.RCE_ADMIN.'modules/'.$_GET['module'].'/update.php" method="post" enctype="multipart/form-data">
										<input type="hidden" name="action" value="'.$_GET['action'].'" />
										<input type="hidden" name="root" value="'.$_GET['root'].'" />
										<input type="hidden" name="cat" value="'.$mod['cat'].'" />
										<input type="hidden" name="id" value="'.$_GET['id'].'" />
										<input type="hidden" name="langs" value="'.$langs.'" />
										<div class="panel-body">
											<!-- Nav tabs -->
											<ul class="nav nav-tabs">
												'.$tabs.'
												<li>
													<a href="#params" data-toggle="tab"><span class="fa fa-fw fa-cogs"></span> Параметры товара</a>
												</li>
												<li>
													<a href="#images" data-toggle="tab"><span class="fa fa-fw fa-photo"></span> Изображения</a>
												</li>
											</ul>
											<!-- Tab panels -->
											<div class="tab-content"><br />
												'.$panels.'
												<div class="tab-pane fade in" id="params">
													<table class="table no-border">
														<tbody>
															<tr>
																<td width="150">Артикул</td>
																<td><input name="artno" class="form-control" placeholder="Артикул, код товара" value="'.$mod['artno'].'" /></td>
															</tr>
															<tr>
																<td>Цена</td>
																<td><input name="price" class="form-control" placeholder="Стоимость товара, за единицу" value="'.$mod['price'].'" /></td>
															</tr>
															<tr>
																<td>Старая цена</td>
																<td><input name="price_old" class="form-control" placeholder="Старая цена, если 0 - выводиться не будет" value="'.$mod['price_old'].'" /></td>
															</tr>
															<tr>
																<td>Порядок</td>
																<td><input name="order" class="form-control" placeholder="Порядок вывода товара, от 1 и выше" value="'.$mod['order'].'" /></td>
															</tr>
															<tr>
																<td></td>
																<td>
																	<input type="submit" value="Сохранить изменения" class="btn btn-primary btn-success" />
																</td>
															</tr>
														</tbody>
													</table>
												</div>
												<div class="tab-pane fade in" id="images">
													<table class="table no-border">
														<tbody>
															<tr>
																<td width="150">Главное фото<br /><span class="infoblock">Главное фото товара</span></td>
																<td>'.$image.'</td>
															</tr>
															<tr>
																<td>Выберите файл<br /><span class="infoblock">Главное фото товара</span></td>
																<td><input type="file" name="file" /></td>
															</tr>
															<tr>
																<td></td>
																<td>
																	<input type="submit" value="Сохранить изменения" class="btn btn-primary btn-success" />
																</td>
															</tr>
														</tbody>
													</table>
												</div>
											</div>
										</div>
										<!-- /.panel-body -->
									</form>
								</div>
								<!-- /.table-responsive -->
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- /#page-wrapper -->
		';
	} elseif($action=='delete_item'){
		$lang=$db->select('SELECT * FROM `rce_catalog_items` WHERE `ID`='.$_GET['id'],'','','');
		$title='Удалить товар '.$lang['title'].' - '.$module['title'];
		$content.='
			<div id="page-wrapper">
			 <div class="row">
					<div class="col-lg-12">
						<h1 class="page-header">'.$module['title'].'</h1>
					</div>
					<!-- /.col-lg-12 -->
				</div>
				<!-- /.row -->
				<div class="row">
					<div class="col-lg-12">
						<div class="panel panel-default">
							<div class="panel-heading">
								Подтверждение действия
								<a class="btn btn-outline btn-warning btn-xs" style="float:right;" href="'.RCE_ADMIN.'?module='.$_GET['module'].'&root='.$_GET['root'].'">
									<i class="fa fa-caret-left fa-fw"></i>
									Отменить
								</a>
								<div style="clear:both;"></div>
							</div>
							<div class="panel-body">
								<div class="table-responsive table">
									<form action="'.RCE_ADMIN.'modules/'.$_GET['module'].'/update.php" method="post">
										<input type="hidden" name="action" value="'.$_GET['action'].'" />
										<input type="hidden" name="root" value="'.$_GET['root'].'" />
										<input type="hidden" name="id" value="'.$_GET['id'].'" />
										<table class="table no-border">
											<tbody>
												<tr>
													<td>
														Вы уверены, что хотите <b>удалить</b> товар "'.$lang['title'].'"?
													</td>
													<td> </td>
												</tr>
												<tr>
													<td>
														<input type="submit" value="Подтвердить удаление" class="btn btn-primary btn-danger" /> 
														<a class="btn btn-warning btn-outline btn-xs" href="'.RCE_ADMIN.'?module='.$_GET['module'].'&root='.$_GET['root'].'">отменить действие</a>
													</td>
													<td></td>
												</tr>
											</tbody>
										</table>
									</form>
								</div>
								<!-- /.table-responsive -->
							</div>
						</div>
					</div>
				</div>
			</div>
			<!-- /#page-wrapper -->
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
	<script src="'.RCE_ADMIN.'modules/catalog_prod/scripts.js"></script>
';


// Template output
$rce=new rce_admin();
$out=$rce->render($title,$menu,$content,$css,$js);
//$out=$rce->page404();

?>