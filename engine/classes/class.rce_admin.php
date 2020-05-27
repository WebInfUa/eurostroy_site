<?
class rce_admin{

	// Render method
	function render($title,$menu,$content,$css,$js){
		$file='admin/template/main.tpl';
		$r=fopen(RCE_ROOT.$file,'r');
		$file=fread($r,filesize(RCE_ROOT.$file));
		fclose($r);
		// Array with tags values
		$tags=array(
			'{template}'=>'//'.RCE_HOST.'/admin/template/',
			'{title}'=>$title.' || Eurostroy',
			'{menu}'=>$menu,
			'{content}'=>$content,
			'{css}'=>$css,
			'{js}'=>$js
		);
		// Replacing tags
		$content=$file;
		foreach($tags as $key=>$value){
			$content=str_replace($key,$value,$content);
		}
		return $content;
	}
	// 404 error page
	function page404(){
		// Logging error
		rce_error('err_404');
		// Render for out
		require("modules/menu.php");
		$title='Ошибка 404';
		$content='
			<div id="page-wrapper">
				<br />
				<div class="row">
					<div class="col-lg-4">
						<div class="panel panel-warning">
							<div class="panel-heading">
								На сайте возникла ошибка 404
							</div>
							<div class="panel-body">
								Вероятно, данный модуль или страница не активны либо удалены!
							</div>
							<!-- /.panel-body -->
						</div>
						<!-- /.panel -->
					</div>
				</div>
				<!-- /.row -->
			</div>
			<!-- /#page-wrapper -->
		';
		$rce=new rce_admin();
		$out=$rce->render($title,$menu,$content,$css,$js);
		return $out;
	}
	
}

?>