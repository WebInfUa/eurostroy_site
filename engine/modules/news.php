<?

// News

if($URL[1] != ''){
	$r=mysql_query("SELECT * FROM `rce_news_list` WHERE `trans`='".$URL[1]."'");
	$f=mysql_fetch_array($r);

  $breadcrumb = '
  <a class="breadcrumb-item" href="/">Главная</a>
  <span class="brd-separetor">/</span>
  <a class="breadcrumb-item" href="/news">Новости</a>
';
  
	$title=$f['title'];
	$date=rce_sep_date($f['date']);
	$content='
<div class="col-md-8 col-lg-8 col-sm-12 col-xs-12">
  <div class="blog-details-left-sidebar mrg-blog">
    <div class="blog-details-top">
      <div class="blog-details-thumb-wrap">
        <div class="blog-details-thumb">
          <img src="/uploads/news/'.$f['image'].'" alt="'.$f['title'].'">
        </div>
        <div class="upcoming-date">
          '.$date[4].'<span class="upc-mth">'.$date[8].','.$date[2].'</span>
        </div>
      </div>
      <h2>'.$f['title'].'</h2>
      <div class="blog-admin-and-comment">
        <p>ТЕГ : <a href="#">'.$f['tag'].'</a></p>
        <p class="separator">|</p>
        <p>Просмотров: '.$f['views'].'</p>
      </div>
      <div class="blog-details-pra">
        '.$f['text'].'
      </div>
      <div>
        <ul class="tag-menu mt-40">
         <li><a href="/news" title="Читайте больше новостей о ремонте и стройке на сайте Еврострой">К Новостям</a></li>
         <li><a href="/catalog" title="Актуальные цены, бесплатная доставка и суппер акции в каталоге товаров Еврострой">В каталог</a></li>
         <li><a href="/shop" title="Добро пожаловать в интернет магазин строительных материалов Еврострой">В магазин</a></li>
         <li><a href="/" title="На главную страницу компании">На главную</a></li>
        </ul>
      </div>
    </div>
  </div>
</div>';
	
	$meta_title=$f['meta_title'];
	$meta_keys=$f['meta_keys'];
	$meta_desc=$f['meta_desc'];

	$views=$f['views']+1;
	$r=mysql_query("UPDATE `rce_news_list` SET `views`='".$views."' WHERE `ID`='".$f['ID']."'");
  

  $r=mysql_query("SELECT DISTINCT `tag` FROM `rce_news_list` ORDER BY `ID`");
	for($i=0;$i<mysql_num_rows($r);$i++){
  $f=mysql_fetch_array($r);
  $newsTags.='<li><a href="#">'.$f['tag'].'</a></li>';
  }
	
} else {
	$title='Новости';
  $breadcrumb='
  <a class="breadcrumb-item" href="/">Главная</a>
  <span class="brd-separetor">/</span>
  <span class="breadcrumb-item active">Новости</span>';
	$meta_title='Новости Еврострой. Стройка и ремонт - это просто!';
	$meta_keys = 'акционные предложения, свежие поступления стройматериалов';
	$meta_desc = 'Акционные предложения по продаже и свежим поступлениям стройматериалов г. Черкассы';
	
	$r=mysql_query("SELECT * FROM `rce_news_list` ORDER BY `date` DESC");
	for($i=0;$i<mysql_num_rows($r);$i++){
		$f=mysql_fetch_array($r);
    $date = rce_sep_date($f['date']);
    $month = rce_get_shortmonth($date[8]);
			$text=mb_substr(strip_tags($f['text']),0,50);
			$content.='
<div class="col-md-6 col-lg-6 col-sm-6 col-xs-12">
  <div class="blog foo">
    <div class="blog__inner">
      <div class="blog__thumb">
        <a href="/news/'.$f['trans'].'">
          <img src="/uploads/news/'.$f['image'].'" alt="'.$f['title'].'">
        </a>
        <div class="blog__post__time">
          <div class="post__time--inner">
            <span class="date">'.$date[4].'</span>
            <span class="month">'.$month.'</span>
          </div>
        </div>
      </div>
      <div class="blog__hover__info">
        <div class="blog__hover__action">
          <h3 class="blog__title"><a href="/news/'.$f['trans'].'">'.$f['title'].'</a></h3>
          <p class="blog__des">
            <a href="/news/'.$f['trans'].'">
              '.$text.'...
            </a>
          </p>
          <ul class="bl__meta">
            <li>Автор :<a href="#">Admin</a></li>
            <li></li>
          </ul>
          <div class="blog__btn">
            <a class="read__more__btn" href="/news/'.$f['trans'].'">Подробнее...</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>';
	}
  $r=mysql_query("SELECT DISTINCT `tag` FROM `rce_news_list` ORDER BY `ID`");
	for($i=0;$i<mysql_num_rows($r);$i++){
  $f=mysql_fetch_array($r);
  $newsTags.='<li><a href="#">'.$f['tag'].'</a></li>';
  }
} 
?>