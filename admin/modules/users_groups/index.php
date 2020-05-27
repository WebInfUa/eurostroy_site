<?
// Users groups

$db=new db();
$module=$db->select('SELECT * FROM `rce_modules` WHERE `codename`="'.$_GET['module'].'"','','','');

if(!isset($_GET['action'])){ // NO ACTIONS
	// Users list
	$r=mysql_query("
		SELECT * FROM `rce_users_groups` ORDER BY `level` DESC
	");
	for($i=0;$i<mysql_num_rows($r);$i++){
		$f=mysql_fetch_array($r);
			// Access
			if(rce_access($_GET['module'],'access')){
				$access='
					<a class="btn btn-xs btn-success btn-margin-bot" href="'.RCE_ADMIN.'?module='.$_GET['module'].'&action=access&id='.$f['level'].'">Настроить доступ</a><br />
				';
			} else {$access='';}
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
			// List
			if($f['ID']=='1'){
				if(rce_get_config('users_show_god')=='0'){
					$list.='';
				} else {
					$list.='
						<tr>
							<td>'.$f['ID'].'</td>
							<td><span style="'.$f['style'].'">'.$f['title'].'</span></td>
							<td>'.$f['level'].'</td>
							<td>'.$access.''.$edit.''.$delete.'</td>
						</tr>
					';
				}
			} else {
				$list.='
					<tr>
						<td>'.$f['ID'].'</td>
						<td><span style="'.$f['style'].'">'.$f['title'].'</span></td>
						<td>'.$f['level'].'</td>
						<td>'.$access.''.$edit.''.$delete.'</td>
					</tr>
				';
			}
	}
	
	// Status data
	require('status.php');
	$status=rce_get_status($_GET['status'],$statusdata);
	
	// Module add access
	if(rce_access($_GET['module'],'add')){
		$add='
			<a class="btn btn-xs btn-success" style="float:right;" href="'.RCE_ADMIN.'?module='.$_GET['module'].'&action=add">
				<i class="fa fa-plus fa-fw"></i>
				Добавить группу
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
							Список групп пользователей
							'.$add.'
							<div style="clear:both;"></div>
						</div>
						<div class="panel-body">
							<div class="table-responsive">
								<table class="table table-striped table-bordered table-hover title-mid" id="table">
									<thead>
										<tr>
											<th>#</th>
											<th>Название</th>
											<th>Уровень доступа</th>
											<th>Действия</th>
										</tr>
									</thead>
									<tbody>
										'.$list.'
									</tbody>
								</table>
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
	if($action=='access'){
		// General info
		$title='Настроить права доступа группы';
		// Get access rights
		$group=$_GET['id'];
		$r=mysql_query("SELECT * FROM `rce_users_access` WHERE `group`='".$group."' ORDER BY `module` ASC");
		for($i=0;$i<mysql_num_rows($r);$i++){
			$f=mysql_fetch_array($r);
				if($f['allow']=='1'){
					$allow='checked="checked"';
				} else {$allow='';}
				$list.='
					<tr>
						<td width="50%"><b>'.$f['module'].'</b>:'.$f['action'].'<br /><span style="font:italic 12px Arial;'.$f['style'].'">'.$f['title'].'</span></td>
						<td>
							<div>
								<input type="checkbox" class="check" group="'.$f['group'].'" module="'.$f['module'].'" action="'.$f['action'].'" value="yes" '.$allow.' /> 
								<span class="result" style="display:none;font:italic 12px Arial;color:green;margin-left:5px;">Сохранено!</span>
							</div>
						</td>
					</tr>
				';
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
								Форма настройки прав доступа группы
								<a class="btn btn-outline btn-warning btn-xs" style="float:right;" href="'.RCE_ADMIN.'?module='.$_GET['module'].'">
									<i class="fa fa-caret-left fa-fw"></i>
									Вернуться
								</a>
								<div style="clear:both;"></div>
							</div>
							<div class="panel-body">
								<div class="table-responsive table">
									<form action="'.RCE_ADMIN.'modules/'.$_GET['module'].'/update.php" method="post">
										<input type="hidden" name="action" value="'.$_GET['action'].'" />
										<div class="panel-body">
											<table class="table table-striped table-bordered table-hover title-mid">
												<tbody>
													<tr>
														<th>Модуль : действие<br /><span style="font:italic 12px Arial;">Описание</span></th>
														<th>Текущее значение</th>
													</tr>
													'.$list.'
												</tbody>
											</table>
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
	} elseif($action=='add'){
		// General info
		$title='Добавить группу';
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
								Форма добавления новой группы пользователей
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
										<div class="panel-body">
											<table class="table no-border">
												<tbody>
													<tr>
														<td width="150">Название</td>
														<td><input name="title" class="form-control" placeholder="Название группы, например: Редактор" /></td>
													</tr>
													<tr>
														<td>Уровень доступа</td>
														<td><input name="level" class="form-control" placeholder="Уровень доступа, от 0 до 9 из не занятых, например: 5" /></td>
													</tr>
													<tr>
														<td>Стили</td>
														<td><input name="style" class="form-control" placeholder="Стиль оформления названия группы, только свойства CSS" /></td>
													</tr>
													<tr>
														<td></td>
														<td>
															<input type="submit" value="Добавить группу" class="btn btn-primary btn-success" />
														</td>
													</tr>
												</tbody>
											</table>
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
		$mod=$db->select('SELECT * FROM `rce_users_groups` WHERE `ID`='.$_GET['id'],'','','');
		$title='Редактировать группу пользователей '.$mod['title'].' - '.$module['title'];
		
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
								Форма редактирования группы пользователей
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
										<div class="panel-body">
											<div class="tab-pane fade in '.$panel_active.'" id="'.$f['lang'].'">
												<table class="table no-border">
													<tbody>
														<tr>
															<td width="150">Название</td>
															<td><input name="title" class="form-control" placeholder="Название группы, например: Редактор" value="'.$mod['title'].'" /></td>
														</tr>
														<tr>
															<td>Уровень доступа</td>
															<td><input name="level" class="form-control" placeholder="Уровень доступа, от 0 до 9 из не занятых, например: 5" value="'.$mod['level'].'" /></td>
														</tr>
														<tr>
															<td>Стили</td>
															<td><input name="style" class="form-control" placeholder="Стиль оформления названия группы, только свойства CSS" value="'.$mod['style'].'" /></td>
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
		$lang=$db->select('SELECT * FROM `rce_users_groups` WHERE `ID`='.$_GET['id'],'','','');
		$title='Удалить группу пользователей '.$lang['title'].' - '.$module['title'];
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
										<input type="hidden" name="level" value="'.$lang['level'].'" />
										<table class="table no-border">
											<tbody>
												<tr>
													<td>
														Вы уверены, что хотите <b>удалить</b> группу пользователей: '.$lang['title'].'?
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
	<script src="'.RCE_ADMIN.'modules/'.$_GET['module'].'/script.js"></script>
';


// Template output
$rce=new rce_admin();
$out=$rce->render($title,$menu,$content,$css,$js);
//$out=$rce->page404();

?>