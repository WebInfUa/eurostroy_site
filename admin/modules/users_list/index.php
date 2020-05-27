<?
// Users

$db=new db();
$module=$db->select('SELECT * FROM `rce_modules` WHERE `codename`="'.$_GET['module'].'"','','','');

if(!isset($_GET['action'])){ // NO ACTIONS
	// Users list
	
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
		SELECT * FROM `rce_users` ORDER BY `ID` ASC
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
		SELECT * FROM `rce_users` ORDER BY `ID` ASC ".$LIMITS."
	");
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
			// Get group data
			$group=rce_get_usergroup($f['group']);
			// List
			if($f['ID']=='1'){
				if(rce_get_config('users_show_god')=='0'){
					$list.='';
				} else {
					$list.='
						<tr>
							<td>'.$f['ID'].'</td>
							<td>'.$f['email'].'<br /><span style="'.$group['style'].'">['.$group['title'].']</span></td>
							<td>'.$f['date_reg'].'</td>
							<td>'.$f['date_visit'].'</td>
							<td>'.$edit.''.$delete.'</td>
						</tr>
					';
				}
			} else {
				$list.='
					<tr>
						<td>'.$f['ID'].'</td>
						<td>'.$f['email'].'<br /><span style="'.$group['style'].'">['.$group['title'].']</span></td>
						<td>'.$f['date_reg'].'</td>
						<td>'.$f['date_visit'].'</td>
						<td>'.$edit.''.$delete.'</td>
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
				Добавить пользователя
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
							Список зарегистрированных пользователей
							'.$add.'
							<div style="clear:both;"></div>
						</div>
						<div class="panel-body">
							<div class="table-responsive">
								<table class="table table-striped table-bordered table-hover title-mid" id="table">
									<thead>
										<tr>
											<th>#</th>
											<th>Е-мейл</th>
											<th>Регистрация</th>
											<th>Посл. посещение</th>
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
		$title='Добавить пользователя';
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
								Форма добавления новой страницы
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
		$mod=$db->select('SELECT * FROM `rce_users` WHERE `ID`='.$_GET['id'],'','','');
		$title='Редактировать пользователя '.$mod['title'].' - '.$module['title'];
		// Groups list
		$r=mysql_query("SELECT * FROM `rce_users_groups` ORDER BY `level` DESC");
		for($i=0;$i<mysql_num_rows($r);$i++){
			$f=mysql_fetch_array($r);
				// Get selected
				if($mod['group']==$f['level']){
					$sel_option='selected="selected"';
					$sel_title='Текущая группа: ';
				} else {
					$sel_option='';
					$sel_title='';
				}
				// Show
				if($f['ID']=='1'){
					if(rce_get_config('users_show_god')=='0'){
						$groups.='';
					} else {
						$groups.='<option value="'.$f['level'].'" '.$sel_option.'>'.$sel_title.''.$f['title'].'</option>';
					}
				} else {
					$groups.='<option value="'.$f['level'].'" '.$sel_option.'>'.$sel_title.''.$f['title'].'</option>';
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
								Форма редактирования данных пользователя
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
															<td width="150">Группа</td>
															<td>
																<select name="group" class="form-control">
																	'.$groups.'
																</select>
															</td>
														</tr>
														<tr>
															<td>Е-мейл</td>
															<td><input name="email" class="form-control" value="'.$mod['email'].'" placeholder="Электронный ящик пользователя" /></td>
														</tr>
														<tr>
															<td>Пароль</td>
															<td><input name="pass" class="form-control" value="'.$mod['pass'].'" placeholder="************" type="password" /></td>
														</tr>
														<tr>
															<td></td>
															<td>
																<input type="submit" value="Сохранить настройки" class="btn btn-primary btn-success" />
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
		$lang=$db->select('SELECT * FROM `rce_users` WHERE `ID`='.$_GET['id'],'','','');
		$title='Удалить пользователя '.$lang['email'].' - '.$module['title'];
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
														Вы уверены, что хотите навсегда <b>удалить</b> пользователя: '.$lang['email'].'?
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