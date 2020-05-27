<?
// Modules settings

$db=new db();
$module=$db->select('SELECT * FROM `rce_modules` WHERE `codename`="'.$_GET['module'].'"','','','');

if(!isset($_GET['action'])){ // NO ACTIONS
	// Language list
	$r=mysql_query("
		SELECT * FROM `rce_modules` ORDER BY `core` ASC
	");
	for($i=0;$i<mysql_num_rows($r);$i++){
		$f=mysql_fetch_array($r);
			if($f['core']=='1'){
				$icons='<i class="fw fa fa-lock" style="width:15px;"></i>';
				$delete='';
				if(rce_access($_GET['module'],'edit')){
					$edit='
						<a class="btn btn-xs btn-warning btn-margin-bot" href="'.RCE_ADMIN.'?module='.$_GET['module'].'&action=edit&id='.$f['ID'].'">Редактировать</a><br />
					';
				} else {$edit='';}
				$turnoff='';
				$turnon='';
			} else {
				$icons='';
				if(rce_access($_GET['module'],'delete')){
					$delete='
						<a class="btn btn-xs btn-danger disabled" href="'.RCE_ADMIN.'?module='.$_GET['module'].'&action=delete&id='.$f['ID'].'">Удалить</a><br />
					';
				} else {$delete='';}
				if(rce_access($_GET['module'],'edit')){
					$edit='
						<a class="btn btn-xs btn-warning btn-margin-bot" href="'.RCE_ADMIN.'?module='.$_GET['module'].'&action=edit&id='.$f['ID'].'">Редактировать</a><br />
					';
				} else {$edit='';}
				if($f['active']=='0'){ // If not active, button to turn ON
					if(rce_access($_GET['module'],'turnon')){
						$turnon='
							<a class="btn btn-xs btn-success btn-margin-bot" href="'.RCE_ADMIN.'?module='.$_GET['module'].'&action=turnon&id='.$f['ID'].'">
								Включить
							</a>
						';
					} else {$turnon='';}
					$turnoff='';
				} elseif($f['active']=='1'){ // If active, button to turn OFF
					if(rce_access($_GET['module'],'turnoff')){
						$turnoff='
							<a class="btn btn-xs btn-warning btn-margin-bot" href="'.RCE_ADMIN.'?module='.$_GET['module'].'&action=turnoff&id='.$f['ID'].'">
								Выключить
							</a>
						';
					} else {$turnoff='';}
					$turnon='';
				}
			}
			if($f['core']=='1'){
				if(rce_get_config('modules_show_core')=='0'){
					$list.='';
				} else {
					$list.='
						<tr>
							<td>'.$icons.' '.$f['codename'].'</td>
							<td>'.$f['title'].'</td>
							<td>'.$f['update'].'</td>
							<td>
								'.$turnoff.'
								'.$turnon.'
								'.$edit.'
								'.$delete.'
							</td>
						</tr>
					';
				}
			} else {
				$list.='
					<tr>
						<td>'.$icons.' '.$f['codename'].'</td>
						<td>'.$f['title'].'</td>
						<td>'.$f['update'].'</td>
						<td>
							'.$turnoff.'
							'.$turnon.'
							'.$edit.'
							'.$delete.'
						</td>
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
			<a class="btn btn-xs btn-success disabled" style="float:right;" href="'.RCE_ADMIN.'?module='.$_GET['module'].'&action=add">
				<i class="fa fa-plus fa-fw"></i>
				Добавить модуль
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
							Доступные языки и метаданные 
							'.$add.'
							<div style="clear:both;"></div>
						</div>
						<div class="panel-body">
							<div class="table-responsive">
								<table class="table table-striped table-bordered table-hover title-mid" id="table">
									<thead>
										<tr>
											<th>Код</th>
											<th>Название</th>
											<th>Обновление</th>
											<th>Действия</th>
										</tr>
									</thead>
									<tbody>
										'.$list.'
									</tbody>
								</table>
							</div>
							<!-- /.table-responsive -->
							<i class="fw fa fa-lock" style="width:15px;"></i> - Системный модуль, недоступен для любых изменений
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
	if($action=='edit'){
		$mod=$db->select('SELECT * FROM `rce_modules` WHERE `ID`='.$_GET['id'],'','','');
		$title='Редактировать модуль '.$mod['title'].' - '.$module['title'];
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
								Форма редактирования модуля
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
										<input type="hidden" name="codename" value="'.$mod['title'].'" />
										<table class="table no-border">
											<tbody>
												<tr>
													<td width="150">Код модуля</td>
													<td><input name="codename" class="form-control" placeholder="К примеру: pages" maxlength="36" value="'.$mod['codename'].'" /></td>
												</tr>
												<tr>
													<td>Название модуля</td>
													<td><input name="title" class="form-control" placeholder="К примеру: Страницы" value="'.$mod['title'].'" /></td>
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
		$mod=$db->select('SELECT * FROM `rce_modules` WHERE `ID`='.$_GET['id'],'','','');
		$title='Выключить модуль '.$mod['title'].' - '.$module['title'];
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
										<input type="hidden" name="codename" value="'.$mod['codename'].'" />
										<table class="table no-border">
											<tbody>
												<tr>
													<td>
														Вы уверены, что хотите <b>выключить</b> модуль '.$mod['title'].'?
													</td>
													<td> </td>
												</tr>
												<tr>
													<td>
														<input type="submit" value="Подтвердить выключение" class="btn btn-primary btn-danger" /> 
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
		$mod=$db->select('SELECT * FROM `rce_modules` WHERE `ID`='.$_GET['id'],'','','');
		$title='Включить модуль '.$mod['title'].' - '.$module['title'];
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
										<input type="hidden" name="codename" value="'.$mod['codename'].'" />
										<table class="table no-border">
											<tbody>
												<tr>
													<td>
														Вы уверены, что хотите <b>включить</b> модуль '.$mod['title'].'?
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
	}
}

$css='<link href="'.RCE_ADMIN.'template/css/plugins/dataTables/dataTables.bootstrap.css" rel="stylesheet">';
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