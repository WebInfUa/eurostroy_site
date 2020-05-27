<?
// Articles
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
		SELECT * FROM `rce_articles_list` WHERE `lang`='ru' ORDER BY `ID` DESC
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
			$pagelist.='<a class="btn btn-default btn-outline btn-sm btn-pagin disabled">'.$page_id.'</a></li>';
		} else {
			$pagelist.='<a class="btn btn-info btn-outline btn-sm btn-pagin" href="'.RCE_ADMIN.'?module='.$_GET['module'].'&page_id='.$i.'">'.$i.'</a>';
		}
	}
	$paginator.='
		<div class="pagination" style="'.$pagin_show.'">
			'.$pagelist.'
		</div>
	';
	// Конец педжинатора, $paginator готов к использованию
		
	$r=mysql_query("
		SELECT * FROM `rce_articles_list` WHERE `lang`='ru' ORDER BY `ID` DESC
	".$LIMITS);
	for($i=0;$i<mysql_num_rows($r);$i++){
		$f=mysql_fetch_array($r);
			// Get user
			$user=rce_get_userdata($f['author']);
			// Edit access
			if(rce_access($_GET['module'],'edit')){
				$edit='
					<a class="btn btn-xs btn-warning btn-margin-bot" href="'.RCE_ADMIN.'?module='.$_GET['module'].'&action=edit&id='.$f['ID'].'">Редактировать</a><br />
				';
			} else {$edit='';}
			// Delete access
			if(rce_access($_GET['module'],'delete')){
				$delete='
					<a class="btn btn-xs btn-danger" href="'.RCE_ADMIN.'?module='.$_GET['module'].'&action=delete&id='.$f['ID'].'">Удалить</a><br />
				';
			} else {$delete='';}
			// Info link
			$info='
				<a class="btn btn-xs btn-info btn-margin-bot" href="https://'.RCE_HOST.'/blog/'.$f['cat'].'/'.$f['trans'].'/" target="_blank">Просмотр</a><br />
			';
			// Params
			if($f['source']==''){
				$source='не указан';
			} else {
				$source='указан';
			}
			// Image
			$date=rce_sep_date($f['date']);
			if($f['image']!=''){
				$img='<br /><img src="/uploads/blog/'.$date[2].'-'.$date[3].'/mini/'.$f['image'].'" alt="'.$f['title'].'" width="80" height="auto" />';
			} else {
				$img='нет фото';
			}
			// List
			if($f['archive']=='1' AND $f['cat']=='nashi_obekty'){
				$statusObject='Выполнен';
			} elseif($f['archive']=='0' AND $f['cat']=='nashi_obekty') {
				$statusObject='В процессе';
			} else {
				$statusObject='';
			}
			$list.='
				<tr>
					<td class="td-center">'.$f['ID'].'</td>
					<td>
						'.$f['title'].'
						<div class="infoblock">Оригинал: '.$source.'</div>
						<div class="infoblock">Изображение: '.$img.'</div>
					</td>
					<td class="td-center"><a href="/articles/'.$f['cat'].'/" target="_blank">'.rce_articles_get_cattitle($f['cat']).'</a></td>
					<td class="td-center">'.$statusObject.'</td>
					<td class="td-center">'.$user['email'].'</td>
					<td class="td-center">'.$f['date'].'</td>
					<td>'.$info.''.$edit.''.$delete.'</td>
				</tr>
			';
	}
	
	// Status data
	require('status.php');
	$status=rce_get_status($_GET['status'],$statusdata);
	
	// Module add access
	if(rce_access($_GET['module'],'add')){
		$add='
			<a class="btn btn-xs btn-success" style="float:right;" href="'.RCE_ADMIN.'?module='.$_GET['module'].'&action=add">
				<i class="fa fa-plus fa-fw"></i>
				Добавить статью
			</a>
		';
	} else {$add='';}

	// Set title and content
	$title=$module['title'];
	$content='
		<div id="page-wrapper">
		 <div class="row">
				<div class="col-lg-12">
					<h1 class="page-header">'.$module['title'].'</h1>
				</div>
				<!-- /.col-lg-12 -->
			</div>
			'.$status.'
			<!-- /.row -->
			<div class="row">
				<div class="col-lg-12">
					<div class="panel panel-default">
						<div class="panel-heading">
							Список добавленных статей
							'.$add.'
							<div style="clear:both;"></div>
						</div>
						<div class="panel-body">
							<div class="table-responsive">
								<table class="table table-striped table-bordered table-hover title-mid" id="table">
									<thead>
										<tr>
											<th>#</th>
											<th>Заголовок</th>
											<th>Рубрика</th>
											<th>Статус</th>
											<th>Автор</th>
											<th>Дата</th>
											<th>Действия</th>
										</tr>
									</thead>
									<tbody>
										'.$list.'
									</tbody>
								</table>
								'.$paginator.'
							</div>
							<!-- /.table-responsive -->
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- /#page-wrapper -->
	';
} else { // HAVE ACTIONS
	// Set action
	$action=$_GET['action'];
	// Cases
	if($action=='add'){
		// General info
		$title='Добавить статью';
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
									<td><input name="'.$f['lang'].'_title" class="form-control" placeholder="Заголовок статьи" /></td>
								</tr>
								<tr style="display:none;">
									<td width="150">ЧПУ адрес</td>
									<td><input name="'.$f['lang'].'_trans" class="form-control" /></td>
								</tr>
								<tr>
									<td>Содержание</td>
									<td><textarea name="'.$f['lang'].'_text" class="ckeditor form-control"></textarea></td>
								</tr>
								<tr>
									<td>Загол. слайдера</td>
									<td><input name="'.$f['lang'].'_slider_title" class="form-control" placeholder="Заголовок предложения на слайдере" /></td>
								</tr>
								<tr>
									<td>Слайдер, кратко</td>
									<td><input name="'.$f['lang'].'_slider_short" class="form-control" placeholder="Кратко о предложении, для слайдера" /></td>
								</tr>
								<tr>
									<td>МЕТА заголовок</td>
									<td><input name="'.$f['lang'].'_meta_title" class="form-control" placeholder="Мета заголовок статьи" /></td>
								</tr>
								<tr>
									<td>МЕТА ключи</td>
									<td><input name="'.$f['lang'].'_meta_keys" class="form-control" placeholder="Ключевые слова, до 20 слов или фраз через запятую" /></td>
								</tr>
								<tr>
									<td>МЕТА описание</td>
									<td><input name="'.$f['lang'].'_meta_desc" class="form-control" placeholder="Описание статьи, опишите вкратце о чем страница" /></td>
								</tr>
								<tr>
									<td></td>
									<td>
										<input type="submit" value="Добавить статью" class="btn btn-primary btn-success" />
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
		// Cats list
		$r=mysql_query("SELECT * FROM `rce_articles_cats` ORDER BY `ID` ASC");
		for($i=0;$i<mysql_num_rows($r);$i++){
			$f=mysql_fetch_array($r);
				$cats.='<option value="'.$f['trans'].'">'.$f['title'].'</option>';
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
								Форма добавления статьи
								<a class="btn btn-outline btn-warning btn-xs" style="float:right;" href="'.RCE_ADMIN.'?module='.$_GET['module'].'">
									<i class="fa fa-caret-left fa-fw"></i>
									Отменить
								</a>
								<div style="clear:both;"></div>
							</div>
							<div class="panel-body">
								<div class="table-responsive table">
									<form action="'.RCE_ADMIN.'modules/'.$_GET['module'].'/update.php" method="post" enctype="multipart/form-data">
										<input type="hidden" name="action" value="'.$_GET['action'].'" />
										<input type="hidden" name="langs" value="'.$langs.'" />
										<div class="panel-body">
											<!-- Nav tabs -->
											<ul class="nav nav-tabs">
												'.$tabs.'
												<li>
													<a href="#params" data-toggle="tab"><span class="fa fa-fw fa-cogs"></span> Параметры</a>
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
																<td width="150">Рубрика</td>
																<td>
																	<select name="cat" class="form-control">
																		'.$cats.'
																	</select>
																</td>
															</tr>
															<tr>
																<td>Статус проекта</td>
																<td>
																	<select name="archive" class="form-control">
																		<option value="0">В процессе</option>
																		<option value="1">Выполнен</option>
																	</select>
																</td>
															</tr>
															<tr>
																<td>В слайдере</td>
																<td>
																	<select name="slider" class="form-control">
																		<option value="0">Не показывать на слайдере</option>
																		<option value="1">ДА, включить показ на слайдере</option>
																	</select>
																</td>
															</tr>
															<tr>
																<td>Источник</td>
																<td><input name="source" class="form-control" placeholder="Ссылка на источник, если есть" /></td>
															</tr>
															<tr>
																<td></td>
																<td>
																	<input type="submit" value="Добавить статью" class="btn btn-primary btn-success" />
																</td>
															</tr>
														</tbody>
													</table>
												</div>
												<div class="tab-pane fade in" id="images">
													<table class="table no-border">
														<tbody>
															<tr>
																<td width="150">Выберите файл<br /><span class="infoblock">Заглавное изображение статьи</span></td>
																<td><input type="file" name="file" /></td>
															</tr>
															<tr>
																<td></td>
																<td>
																	<input type="submit" value="Добавить статью" class="btn btn-primary btn-success" />
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
	} elseif($action=='edit'){
		// General info
		$mod=$db->select('SELECT * FROM `rce_articles_list` WHERE `ID`='.$_GET['id'],'','','');
		$title='Редактировать статью '.$mod['title'].' - '.$module['title'];
		// Lang list
		$r=mysql_query("SELECT * FROM `rce_config_lang` WHERE `active` ORDER BY `ID` ASC");
		for($i=0;$i<mysql_num_rows($r);$i++){
			$f=mysql_fetch_array($r);
				// Creating lang list
				$c=$i+1;
				if($c>=mysql_num_rows($r)){$lang_end='';}else{$lang_end=',';}
				$langs.=$f['lang'].$lang_end;
				// Checking page lang
				$count=$db->count("SELECT * FROM `rce_articles_list` WHERE `pageID`='".$mod['ID']."' AND `lang`='".$f['lang']."'");
				if($count=='1'){ // Got this page with current lang
					$page=$db->select("SELECT * FROM `rce_articles_list` WHERE `pageID`='".$mod['ID']."' AND `lang`='".$f['lang']."'",'','','');
				} else { // No page on this lang, creating localisation
					$data=array(
						'author'=>$_SESSION['user']['ID'],
						'pageID'=>$mod['ID'],
						'lang'=>$f['lang']
					);
					$db->insert('rce_articles_list',$data);
					$page=$db->select("SELECT * FROM `rce_articles_list` WHERE `pageID`='".$mod['ID']."' AND `lang`='".$f['lang']."'",'','','');
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
									<td><input name="'.$f['lang'].'_title" class="form-control" value="'.$page['title'].'" placeholder="Название статьи" /></td>
								</tr>
								<tr style="display:none;">
									<td width="150">ЧПУ адрес</td>
									<td><input name="'.$f['lang'].'_trans" class="form-control" value="'.$page['trans'].'" /></td>
								</tr>
								<tr>
									<td>Содержание</td>
									<td><textarea name="'.$f['lang'].'_text" class="ckeditor form-control">'.$page['text'].'</textarea></td>
								</tr>
								<tr>
									<td>Загол. слайдера</td>
									<td><input name="'.$f['lang'].'_slider_title" class="form-control" value="'.$page['slider_title'].'" placeholder="Заголовок предложения на слайдере" /></td>
								</tr>
								<tr>
									<td>Слайдер, кратко</td>
									<td><input name="'.$f['lang'].'_slider_short" class="form-control" value="'.$page['slider_short'].'" placeholder="Кратко о предложении, для слайдера" /></td>
								</tr>
								<tr>
									<td>МЕТА заголовок</td>
									<td><input name="'.$f['lang'].'_meta_title" class="form-control" value="'.$page['meta_title'].'" placeholder="Мета заголовок статьи" /></td>
								</tr>
								<tr>
									<td>МЕТА ключи</td>
									<td><input name="'.$f['lang'].'_meta_keys" class="form-control" value="'.$page['meta_keys'].'" placeholder="Ключевые слова, до 20 слов или фраз через запятую" /></td>
								</tr>
								<tr>
									<td>МЕТА описание</td>
									<td><input name="'.$f['lang'].'_meta_desc" class="form-control" value="'.$page['meta_desc'].'" placeholder="Описание статьи, опишите вкратце о чем страница" /></td>
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
			// Current category image
			if($f['lang']=='ru'){
				// Image
				if($page['image']==''){
					$image='нет изображения';
				} else {
					$image='<img src="/uploads/blog/'.date(Y).'-'.date(m).'/mini/'.$page['image'].'" alt="'.$page['title'].'" />';
				}
			}
		}
		// Cats list
		$r=mysql_query("SELECT * FROM `rce_articles_cats` ORDER BY `ID` ASC");
		for($i=0;$i<mysql_num_rows($r);$i++){
			$f=mysql_fetch_array($r);
				if($mod['cat']==$f['trans']){
					$cat_sel='selected="selected"';
				} else {$cat_sel='';}
				$cats.='<option value="'.$f['trans'].'" '.$cat_sel.'>'.$f['title'].'</option>';
		}
		// Slider
		if($mod['slider']=='0'){
			$slider_n='selected="selected"';
		} elseif($mod['slider']=='1'){
			$slider_y='selected="selected"';
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
								Форма редактирования статьи
								<a class="btn btn-outline btn-warning btn-xs" style="float:right;" href="'.RCE_ADMIN.'?module='.$_GET['module'].'">
									<i class="fa fa-caret-left fa-fw"></i>
									Отменить
								</a>
								<div style="clear:both;"></div>
							</div>
							<div class="panel-body">
								<div class="table-responsive table">
									<form action="'.RCE_ADMIN.'modules/'.$_GET['module'].'/update.php" method="post" enctype="multipart/form-data">
										<input type="hidden" name="action" value="'.$_GET['action'].'" />
										<input type="hidden" name="id" value="'.$_GET['id'].'" />
										<input type="hidden" name="langs" value="'.$langs.'" />
										<div class="panel-body">
											<!-- Nav tabs -->
											<ul class="nav nav-tabs">
												'.$tabs.'
												<li>
													<a href="#params" data-toggle="tab"><span class="fa fa-fw fa-cogs"></span> Параметры</a>
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
																<td width="150">Рубрика</td>
																<td>
																	<select name="cat" class="form-control">
																		<option value="none">Выберите рубрику</option>
																		'.$cats.'
																	</select>
																</td>
															</tr>
															<tr>
																<td>Статус проекта</td>
																<td>
																	<select name="archive" class="form-control">
																		<option value="0">В процессе</option>
																		<option value="1">Выполнен</option>
																	</select>
																</td>
															</tr>
															<tr>
																<td>В слайдере</td>
																<td>
																	<select name="slider" class="form-control">
																		<option value="0" '.$slider_n.'>Не показывать на слайдере</option>
																		<option value="1" '.$slider_y.'>ДА, включить показ на слайдере</option>
																	</select>
																</td>
															</tr>
															<tr>
																<td>Источник</td>
																<td><input name="source" class="form-control" placeholder="Ссылка на источник, если есть" value="'.$mod['source'].'" /></td>
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
																<td width="150">Текущее изображение<br /><span class="infoblock">Заглавное изображение статьи</span></td>
																<td>'.$image.'</td>
															</tr>
															<tr>
																<td>Выберите файл<br /><span class="infoblock">Если хотите заменить текущее фото на новое</span></td>
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
	} elseif($action=='delete'){
		$lang=$db->select('SELECT * FROM `rce_articles_list` WHERE `ID`='.$_GET['id'],'','','');
		$title='Удалить статью '.$lang['title'].' - '.$module['title'];
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
								<a class="btn btn-outline btn-warning btn-xs" style="float:right;" href="'.RCE_ADMIN.'?module='.$_GET['module'].'">
									<i class="fa fa-caret-left fa-fw"></i>
									Отменить
								</a>
								<div style="clear:both;"></div>
							</div>
							<div class="panel-body">
								<div class="table-responsive table">
									<form action="'.RCE_ADMIN.'modules/'.$_GET['module'].'/update.php" method="post">
										<input type="hidden" name="action" value="'.$_GET['action'].'" />
										<input type="hidden" name="id" value="'.$_GET['id'].'" />
										<table class="table no-border">
											<tbody>
												<tr>
													<td>
														Вы уверены, что хотите <b>удалить</b> статью: '.$lang['title'].'?
													</td>
													<td> </td>
												</tr>
												<tr>
													<td>
														<input type="submit" value="Подтвердить удаление" class="btn btn-primary btn-danger" /> 
														<a class="btn btn-warning btn-outline btn-xs" href="'.RCE_ADMIN.'?module='.$_GET['module'].'">отменить действие</a>
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