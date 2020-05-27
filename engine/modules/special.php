<?
// News
if($URL[1]!=''){ // Selected news article
	// Get news data
	$r=mysql_query("
		SELECT * FROM `rce_articles_list`
		WHERE `trans`='".$URL[1]."'
	");
	$f=mysql_fetch_array($r);

	$title='<a href="/">Главная</a> <b>/</b> <a href="/special/">Спецпредложения</a> <b>/</b> '.$f['title'];
	$date=rce_sep_date($f['date']);
	$content.='
		<a class="action-item fancybox" href="/uploads/blog/'.$date[2].'-'.$date[3].'/'.$f['image'].'" title="'.$f['title'].'" rel="gallery">
			<img src="/uploads/blog/'.$date[2].'-'.$date[3].'/mini/'.$f['image'].'" alt="'.$f['title'].'" />
		</a>
	';
	$content.=$f['text'];

	$meta_title=$f['meta_title'].' :: Акции';
	$meta_keys=$f['meta_keys'];
	$meta_desc=$f['meta_desc'];

} else { // All news list

	// ПЕДЖИНАТОР_БЕТА_3.0
	$page_id=$_GET['page_id'];
	if(!isset($page_id)) {$page_id=1;}
	// Выставляем лимит на страницу
	$limit=1000;

	$start_limit = ($page_id * $limit)-$limit;
	$end_limit = $start_limit+$limit;

	// Формируем лимитную приставку
	$LIMITS="LIMIT ".$start_limit.", ".$limit;

	$test_result=mysql_query("
		SELECT * FROM `rce_news_list`
		WHERE `lang`='ru'
		ORDER BY `ID` DESC
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
			$pagelist.='<a class="btn btn-info btn-outline btn-sm btn-pagin" href="'.RCE_ADMIN.'?module='.$_GET['module'].'&root='.$_GET['root'].'&page_id='.$i.'">'.$i.'</a>';
		}
	}
	$paginator.='
		<div class="pagination" style="'.$pagin_show.'">
			'.$pagelist.'
		</div>
	';
	// Конец педжинатора, $paginator готов к использованию

	// Get news list

	$title='<a href="/">Главная</a> <b>/</b> <a href="/special/">Спецпредложения</a>';
	$meta_title='Акции';

	$r=mysql_query("
		SELECT * FROM `rce_articles_list`
		WHERE `cat`='special' AND `lang`='ru'
		ORDER BY `ID` DESC ".$LIMITS."
	");
	for($i=0;$i<mysql_num_rows($r);$i++){
		$f=mysql_fetch_array($r);
			$date=rce_sep_date($f['date']);
			$content.='
				<div class="news-list-item">
					<span class="date">'.$date[4].'.'.$date[3].'.'.$date[2].'</span>
					<h5><a href="/special/'.$f['trans'].'">'.$f['title'].'</a></h5>
					<p>'.strip_tags(mb_substr($f['text'],0,220)).'...</p>
				</div>
			';
	}
}

?>