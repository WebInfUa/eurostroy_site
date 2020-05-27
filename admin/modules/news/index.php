<?
// News

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
		SELECT * FROM `rce_news` WHERE `lang`='ru' ORDER BY `ID` ASC
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
		SELECT * FROM `rce_news` WHERE `lang`='ru' ORDER BY `ID` ASC
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
				<a class="btn btn-xs btn-info btn-margin-bot" href="https://'.RCE_HOST.'/?content=news&trans='.$f['trans'].'" target="_blank">Просмотр</a><br />
			';
			// List
			$list.='
				<tr>
					<td>'.$f['ID'].'</td>
					<td>'.$f['title'].'</td>
					<td>'.$user['email'].'</td>
					<td>'.$f['date'].'</td>
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
				Добавить новость
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
							Список добавленных новостей
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
									<td><input name="'.$f['lang'].'_title" class="form-control" placeholder="Название страницы" /></td>
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
									<td>МЕТА заголовок</td>
									<td><input name="'.$f['lang'].'_meta_title" class="form-control" placeholder="Мета заголовок страницы" /></td>
								</tr>
								<tr>
									<td>МЕТА ключи</td>
									<td><input name="'.$f['lang'].'_meta_keys" class="form-control" placeholder="Ключевые слова, до 20 слов или фраз через запятую" /></td>
								</tr>
								<tr>
									<td>МЕТА описание</td>
									<td><input name="'.$f['lang'].'_meta_desc" class="form-control" placeholder="Описание страницы, опишите вкратце о чем страница" /></td>
								</tr>
								<tr>
									<td></td>
									<td>
										<input type="submit" value="Добавить новость" class="btn btn-primary btn-success" />
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
								Форма добавления новости
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
										<input type="hidden" name="langs" value="'.$langs.'" />
										<div class="panel-body">
											<!-- Nav tabs -->
											<ul class="nav nav-tabs">
												'.$tabs.'
											</ul>
											<!-- Tab panels -->
											<div class="tab-content"><br />
												'.$panels.'
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
		$mod=$db->select('SELECT * FROM `rce_pages` WHERE `ID`='.$_GET['id'],'','','');
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
				$count=$db->count("SELECT * FROM `rce_news` WHERE `pageID`='".$mod['ID']."' AND `lang`='".$f['lang']."'");
				if($count=='1'){ // Got this page with current lang
					$page=$db->select("SELECT * FROM `rce_news` WHERE `pageID`='".$mod['ID']."' AND `lang`='".$f['lang']."'",'','','');
				} else { // No page on this lang, creating localisation
					$data=array(
						'author'=>$_SESSION['user']['ID'],
						'pageID'=>$mod['ID'],
						'lang'=>$f['lang']
					);
					$db->insert('rce_pages',$data);
					$page=$db->select("SELECT * FROM `rce_news` WHERE `pageID`='".$mod['ID']."' AND `lang`='".$f['lang']."'",'','','');
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
									<td><input name="'.$f['lang'].'_title" class="form-control" value="'.$page['title'].'" placeholder="Название страницы" /></td>
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
								Форма редактирования новости
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
										<input type="hidden" name="langs" value="'.$langs.'" />
										<div class="panel-body">
											<!-- Nav tabs -->
											<ul class="nav nav-tabs">
												'.$tabs.'
											</ul>
											<!-- Tab panels -->
											<div class="tab-content"><br />
												'.$panels.'
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
		$lang=$db->select('SELECT * FROM `rce_pages` WHERE `ID`='.$_GET['id'],'','','');
		$title='Удалить новость '.$lang['title'].' - '.$module['title'];
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
														Вы уверены, что хотите <b>удалить</b> новость: '.$lang['title'].'?
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