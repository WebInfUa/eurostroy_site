<?
// Lang settings

$db=new db();
$module=$db->select('SELECT * FROM `rce_modules` WHERE `codename`="'.$_GET['module'].'"','','','');

if(!isset($_GET['action'])){ // NO ACTIONS
	// Language list
	$r=mysql_query("SELECT * FROM `rce_config_lang` ORDER BY `default` DESC");
	for($i=0;$i<mysql_num_rows($r);$i++){
		$f=mysql_fetch_array($r);
			if($f['default']=='1'){
				$lang='
					<b>
						'.$f['lang'].' <i class="fw fa fa-star"></i> 
					</b>
				';
				$default='';
				$turnoff='';
				$delete='';
			} else {
				if($f['active']=='1'){
					$lang=$f['lang'];
					if(rce_access($_GET['module'],'turnoff')){
						$turn='
							<a class="btn btn-xs btn-warning btn-margin-bot" href="'.RCE_ADMIN.'?module='.$_GET['module'].'&action=turnoff&id='.$f['ID'].'">Выключить</a><br />
						';
					} else {$turn='';}
					if(rce_access($_GET['module'],'default')){
						$default='
							<a class="btn btn-xs btn-success btn-margin-bot" href="'.RCE_ADMIN.'?module='.$_GET['module'].'&action=default&id='.$f['ID'].'">По-умолчанию</a><br />
						';
					} else {$default=='';}
				} else {
					$lang=$f['lang'].' <i class="fw fa fa-lock"></i>';
					if(rce_access($_GET['module'],'turnon')){
						$turn='
							<a class="btn btn-xs btn-success btn-margin-bot" href="'.RCE_ADMIN.'?module='.$_GET['module'].'&action=turnon&id='.$f['ID'].'">Включить</a><br />
						';
					} else {$turn='';}
					$default='';
				}
				if(rce_access($_GET['module'],'delete')){
					$delete='
						<a class="btn btn-xs btn-danger" href="'.RCE_ADMIN.'?module='.$_GET['module'].'&action=delete&id='.$f['ID'].'">Удалить</a><br />
					';
				} else {$delete='';}
			}
			// Edit allow
			if(rce_access($_GET['module'],'edit')){
				$edit='
					<a class="btn btn-xs btn-warning btn-margin-bot" href="'.RCE_ADMIN.'?module='.$_GET['module'].'&action=edit&id='.$f['ID'].'">Редактировать</a><br />
				';
			} else {$edit='';}
			// List out
			$list.='
				<tr>
					<td><span class="flag flag-'.$f['lang'].'"></span> '.$lang.'</td>
					<td>'.$f['lang_title'].'</td>
					<td>'.$f['site_title'].'</td>
					<td>'.$f['meta_title'].'</td>
					<td>'.$f['meta_keys'].'</td>
					<td>'.$f['meta_desc'].'</td>
					<td>
						'.$default.'
						'.$edit.'
						'.$turn.'
						'.$delete.'
					</td>
				</tr>
			';
	}
	// Lang add
	if(rce_access($_GET['module'],'add')){
		$add='
			<a class="btn btn-xs btn-success" style="float:right;" href="'.RCE_ADMIN.'?module='.$_GET['module'].'&action=add">
				<i class="fa fa-plus fa-fw"></i>
				Добавить язык
			</a>
		';
	} else {$add='';}
	
	// Status data
	require('status.php');
	$status=rce_get_status($_GET['status'],$statusdata);

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
							Доступные языки и метаданные 
							'.$add.'
							<div style="clear:both;"></div>
						</div>
						<div class="panel-body">
							<div class="table-responsive">
								<table class="table table-striped table-bordered table-hover title-mid" id="table">
									<thead>
										<tr>
											<th>Код языка</th>
											<th>Название языка</th>
											<th>Название сайта</th>
											<th>Мета заголовок</th>
											<th>Мета ключи</th>
											<th>Мета описание</th>
											<th>Действия</th>
										</tr>
									</thead>
									<tbody>
										'.$list.'
									</tbody>
								</table>
							</div>
							<!-- /.table-responsive -->
							<i class="fw fa fa-star" style="width:15px;"></i> - язык по-умолчанию <br />
							<i class="fw fa fa-lock" style="width:15px;"></i> - не активный язык
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
		$title='Добавить язык - '.$module['title'];
		$content='
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
								Форма добавления языка
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
										<table class="table no-border">
											<tbody>
												<tr>
													<td width="150">Код языка</td>
													<td><input name="lang" class="form-control" placeholder="К примеру: ru" maxlength="2" /></td>
												</tr>
												<tr>
													<td>Название языка</td>
													<td><input name="lang_title" class="form-control" placeholder="К примеру: Русский" /></td>
												</tr>
												<tr>
													<td>Название сайта</td>
													<td><input name="site_title" class="form-control" placeholder="Будет показываться в названии вкладки, к примеру: Мой сайт" /></td>
												</tr>
												<tr>
													<td>Мета заголовок</td>
													<td><input name="meta_title" class="form-control" placeholder="Будет выводиться в результатах поиска, к примеру: Мойсайт.ру" /></td>
												</tr>
												<tr>
													<td>Мета ключи</td>
													<td><input name="meta_keys" class="form-control" placeholder="Ключевые слова или фразы, до 20 шт, через запятую" /></td>
												</tr>
												<tr>
													<td>Мета описание</td>
													<td><input name="meta_desc" class="form-control" placeholder="Одно или два предложения, кратко о сайте" /></td>
												</tr>
												<tr>
													<td></td>
													<td>
														<input type="submit" value="Добавить язык" class="btn btn-primary btn-success" />
													</td>
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
	} elseif($action=='edit'){
		$lang=$db->select('SELECT * FROM `rce_config_lang` WHERE `ID`='.$_GET['id'],'','','');
		$title='Редактировать язык '.$lang['lang_title'].' - '.$module['title'];
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
								Форма редактирования языка
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
													<td width="150">Код языка</td>
													<td><input name="lang" class="form-control" placeholder="К примеру: ru" maxlength="2" value="'.$lang['lang'].'" /></td>
												</tr>
												<tr>
													<td>Название языка</td>
													<td><input name="lang_title" class="form-control" placeholder="К примеру: Русский" value="'.$lang['lang_title'].'" /></td>
												</tr>
												<tr>
													<td>Название сайта</td>
													<td><input name="site_title" class="form-control" placeholder="Будет показываться в названии вкладки, к примеру: Мой сайт" value="'.$lang['site_title'].'" /></td>
												</tr>
												<tr>
													<td>Мета заголовок</td>
													<td><input name="meta_title" class="form-control" placeholder="Будет выводиться в результатах поиска, к примеру: Мойсайт.ру" value="'.$lang['meta_title'].'" /></td>
												</tr>
												<tr>
													<td>Мета ключи</td>
													<td><input name="meta_keys" class="form-control" placeholder="Ключевые слова или фразы, до 20 шт, через запятую" value="'.$lang['meta_keys'].'" /></td>
												</tr>
												<tr>
													<td>Мета описание</td>
													<td><input name="meta_desc" class="form-control" placeholder="Одно или два предложения, кратко о сайте" value="'.$lang['meta_desc'].'" /></td>
												</tr>
												<tr>
													<td></td>
													<td>
														<input type="submit" value="Сохранить настройки" class="btn btn-primary btn-success" />
													</td>
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
	} elseif($action=='turnoff'){
		$lang=$db->select('SELECT * FROM `rce_config_lang` WHERE `ID`='.$_GET['id'],'','','');
		$title='Отключить язык '.$lang['lang_title'].' - '.$module['title'];
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
										<input type="hidden" name="title" value="'.$lang['lang_title'].'" />
										<table class="table no-border">
											<tbody>
												<tr>
													<td>
														Вы уверены, что хотите <b>отключить</b> язык '.$lang['lang_title'].'?
													</td>
													<td> </td>
												</tr>
												<tr>
													<td>
														<input type="submit" value="Подтвердить отключение" class="btn btn-primary btn-danger" /> 
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
	} elseif($action=='turnon'){
		$lang=$db->select('SELECT * FROM `rce_config_lang` WHERE `ID`='.$_GET['id'],'','','');
		$title='Включить язык '.$lang['lang_title'].' - '.$module['title'];
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
										<input type="hidden" name="title" value="'.$lang['lang_title'].'" />
										<table class="table no-border">
											<tbody>
												<tr>
													<td>
														Вы уверены, что хотите <b>включить</b> язык '.$lang['lang_title'].'?
													</td>
													<td> </td>
												</tr>
												<tr>
													<td>
														<input type="submit" value="Подтвердить включение" class="btn btn-primary btn-success" /> 
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
	} elseif($action=='delete'){
		$lang=$db->select('SELECT * FROM `rce_config_lang` WHERE `ID`='.$_GET['id'],'','','');
		$title='Удалить язык '.$lang['lang_title'].' - '.$module['title'];
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
										<input type="hidden" name="title" value="'.$lang['lang_title'].'" />
										<table class="table no-border">
											<tbody>
												<tr>
													<td>
														Вы уверены, что хотите <b>удалить</b> язык '.$lang['lang_title'].'?
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
	} elseif($action=='default'){
		$lang=$db->select('SELECT * FROM `rce_config_lang` WHERE `ID`='.$_GET['id'],'','','');
		$title='Язык по-умолчанию '.$lang['lang_title'].' - '.$module['title'];
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
										<input type="hidden" name="title" value="'.$lang['lang_title'].'" />
										<table class="table no-border">
											<tbody>
												<tr>
													<td>
														Вы уверены, что хотите установить <b>язык по-умолчанию</b> '.$lang['lang_title'].'?
													</td>
													<td> </td>
												</tr>
												<tr>
													<td>
														<input type="submit" value="Подтвердить установку" class="btn btn-primary btn-success" /> 
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