<?
// Home

$r=mysql_query("SELECT * FROM `rce_pages` WHERE `trans`='shop'");
$f=mysql_fetch_array($r);

$title=$f['title'];

$meta_title=$f['meta_title'];
$meta_keys=$f['meta_keys'];
$meta_desc=$f['meta_desc'];

  
// mainSlider 840x570
$r = mysql_query("
	SELECT * FROM `rce_slider`
  WHERE `position`='1'
	ORDER BY `ID` DESC
	LIMIT 10
");
while($f=mysql_fetch_array($r)){
	$sliderMain .= '
<div class="slide">
  <a href="'.$f['slider_link'].'" style="display: block">
    <img class="sliders--one" src="/template/images/slider/bg/'.$f['image'].'" alt="'.$f['title'].'"/>
  </a>
</div>';
}

$r = mysql_query("
	SELECT * FROM `rce_slider`
  WHERE `position`='2'
	ORDER BY `ID` DESC
	LIMIT 10
");
while($f=mysql_fetch_array($r)){
	$sliderMain2 .= '
<div class="slide" style="margin-right: 10px">
  <a href="'.$f['slider_link'].'" style="display: block">
    <img class="sliders--two" src="/template/images/slider/bg/'.$f['image'].'" alt="'.$f['title'].'"/>
  </a>
</div>';
}

$r = mysql_query("
	SELECT * FROM `rce_slider`
  WHERE `position`='3'
	ORDER BY `ID` DESC
	LIMIT 10
");
while($f=mysql_fetch_array($r)){
	$sliderMain3 .= '
<div class="slide" style="margin-left: 10px">
  <a href="'.$f['slider_link'].'" style="display: block">
    <img class="sliders--two" src="/template/images/slider/bg/'.$f['image'].'" alt="'.$f['title'].'"/>
  </a>
</div>';
}


// Banner 1-3 1170*300
$r = mysql_query("
	SELECT * FROM `rce_slider`
  WHERE `position`>'4'
	ORDER BY `ID` DESC
	LIMIT 10
");
while($f=mysql_fetch_array($r)){
  if ($f['position']=='5') {
    $banner_top.= '<a href="'.$f['slider_link'].'" title="'.$f['title'].'"><img src="/template/images/slider/bg/'.$f['image'].'" alt="'.$f['title'].'"></a>';  
  }
  if ($f['position']=='6') {
    $banner_med.= '<a href="'.$f['slider_link'].'" title="'.$f['title'].'"><img src="/template/images/slider/bg/'.$f['image'].'" alt="'.$f['title'].'"></a>';  
  }
  if ($f['position']=='7') {
    $banner_down.= '<a href="'.$f['slider_link'].'" title="'.$f['title'].'"><img src="/template/images/slider/bg/'.$f['image'].'" alt="'.$f['title'].'"></a>';  
  }
}

// Stock, Spec, Top Sale, Out Sell,
$r=mysql_query("SELECT * FROM `rce_catalog_items` WHERE `fav`!='' AND `image`!='' AND `price`>'0' ORDER BY RAND() ASC");
for($i=0;$i<mysql_num_rows($r);$i++){
	$f=mysql_fetch_array($r);
	$c=mysql_query("SELECT * FROM `rce_catalog_cats` WHERE `trans`='".$f['cat']."'");
	$cat=mysql_fetch_array($c);
  
  if ($f['price'] <= 0) {
    $price='
    <ul class="product__price">
      <li>Нет в наличии</li>
    </ul>';
  } else if ($f['price_old'] > $f['price']) {
    $price='
    <ul class="product__price">
      <li class="old__price">'.$f['price_old'].' грн. </li>
      <li>'.$f['price'].' грн. / '.$f['pcs'].'</li>
    </ul>
    <button class="to-cart buy__now" data-item-id="'.$f['ID'].'" title="Добавить в корзину">Купить</button>';
  } else {
    $price='
    <ul class="product__price">
      <li>'.$f['price'].' грн. / '.$f['pcs'].'</li>
    </ul>
    <button class="to-cart buy__now" data-item-id="'.$f['ID'].'" title="Добавить в корзину">Купить</button>';
  };
  
  if ($f['fav']=='1') {
		$stock.='
  <div class="col-md-4 single__pro col-lg-4 cat--1 col-sm-4 col-xs-12">
    <div class="product">
      <div class="product__inner">
        <div class="pro__thumb">
          <a href="/catalog/item/'.$cat['root'].'/'.$f['trans'].'">
            <img src="/uploads/catalog/mini/'.$f['image'].'" alt="'.$f['title'].'" style="width:auto; max-width:200px; height:200px; margin: 0 auto;">
          </a>
        </div>
        <div class="product__hover__info">
          <ul class="product__action">
            <li><a data-toggle="modal" data-target="#productModal" title="Посмотреть товар" class="quick-view modal-view detail-link" href="/catalog/item/'.$cat['root'].'/'.$f['trans'].'"><span class="ti-plus"></span></a></li>
            <li><a class="to-cart" title="Добавить в корзину" data-item-id="'.$f['ID'].'" href="#"><span class="ti-shopping-cart"></span></a></li>
          </ul>
        </div>
      </div>
      <div class="product__details">
        <h2><a href="/catalog/item/'.$cat['root'].'/'.$f['trans'].'">'.$f['title'].'</a></h2>
        '.$price.'
      </div>
    </div>
  </div>';
  };
  if ($f['fav']=='2') {
    $spec.='
  <div class="col-md-4 single__pro col-lg-4 cat--1 col-sm-4 col-xs-12">
    <div class="product">
      <div class="product__inner">
        <div class="pro__thumb">
          <a href="/catalog/item/'.$cat['root'].'/'.$f['trans'].'">
            <img src="/uploads/catalog/mini/'.$f['image'].'" alt="'.$f['title'].'" style="width:auto; max-width:200px; height:200px; margin: 0 auto;">
          </a>
        </div>
        <div class="product__hover__info">
          <ul class="product__action">
            <li><a data-toggle="modal" data-target="#productModal" title="Посмотреть товар" class="quick-view modal-view detail-link" href="#"><span class="ti-plus"></span></a></li>
            <li><a title="Добавить в корзину" data-item-id="'.$f['ID'].'" href="#"><span class="ti-shopping-cart"></span></a></li>
          </ul>
        </div>
      </div>
      <div class="product__details">
        <h2><a href="/catalog/item/'.$cat['root'].'/'.$f['trans'].'">'.$f['title'].'</a></h2>
        '.$price.'
      </div>
    </div>
  </div>';
  };
  if ($f['fav']=='3') {
$top_sell.='
  <div class="col-md-4 single__pro col-lg-4 cat--1 col-sm-4 col-xs-12">
    <div class="product">
      <div class="product__inner">
        <div class="pro__thumb">
          <a href="/catalog/item/'.$cat['root'].'/'.$f['trans'].'">
            <img src="/uploads/catalog/mini/'.$f['image'].'" alt="'.$f['title'].'" style="width:auto; max-width:200px; height:200px; margin: 0 auto;">
          </a>
        </div>
        <div class="product__hover__info">
          <ul class="product__action">
            <li><a data-toggle="modal" data-target="#productModal" title="Посмотреть товар" class="quick-view modal-view detail-link" href="#"><span class="ti-plus"></span></a></li>
            <li><a title="Добавить в корзину" data-item-id="'.$f['ID'].'" href="#"><span class="ti-shopping-cart"></span></a></li>
          </ul>
        </div>
      </div>
      <div class="product__details">
        <h2><a href="/catalog/item/'.$cat['root'].'/'.$f['trans'].'">'.$f['title'].'</a></h2>
        '.$price.'
      </div>
    </div>
  </div>';
  };
  if ($f['fav']=='4') { 
    $out_sell.='
  <div class="col-md-4 single__pro col-lg-4 cat--1 col-sm-4 col-xs-12">
    <div class="product">
      <div class="product__inner">
        <div class="pro__thumb">
          <a href="/catalog/item/'.$cat['root'].'/'.$f['trans'].'">
            <img src="/uploads/catalog/mini/'.$f['image'].'" alt="'.$f['title'].'" style="width:auto; max-width:200px; height:200px; margin: 0 auto;">
          </a>
        </div>
        <div class="product__hover__info">
          <ul class="product__action">
            <li><a data-toggle="modal" data-target="#productModal" title="Посмотреть товар" class="quick-view modal-view detail-link" href="#"><span class="ti-plus"></span></a></li>
            <li><a title="Добавить в корзину" data-item-id="'.$f['ID'].'" href="#"><span class="ti-shopping-cart"></span></a></li>
          </ul>
        </div>
      </div>
      <div class="product__details">
        <h2><a href="/catalog/item/'.$cat['root'].'/'.$f['trans'].'">'.$f['title'].'</a></h2>
        '.$price.'
      </div>
    </div>
  </div>';
  };
}



//Calc items in main page
$r=mysql_query("SELECT * FROM `rce_pages` WHERE `type`!='' AND `pageHide`<5 ORDER BY `pageID` ASC");
for($i=0;$i<mysql_num_rows($r);$i++){
	$f=mysql_fetch_array($r);
  if ($f['type']=='calc_wall') {
  $calcWall.='
  <div class="col-md-4 single__pro col-lg-4 cat--1 col-sm-4 col-xs-12">
    <div class="product">
      <div class="product__inner">
        <div class="pro__thumb">
          <a href="/'.$f['trans'].'">
            <img src="/template/images/pages/'.$f['image'].'" alt="'.$f['title'].'" style="max-width:270px; width:auto; height:270px; margin: 0 auto;">
          </a>
        </div>
      </div>
      <div class="product__details">
        <h2><a href="/'.$f['trans'].'">'.$f['title'].'</a></h2>
      </div>
    </div>
  </div>';  
  };
  if ($f['type']=='calc_ceiling') {
  $calcCeiling.='
  <div class="col-md-4 single__pro col-lg-4 cat--1 col-sm-4 col-xs-12">
    <div class="product">
      <div class="product__inner">
        <div class="pro__thumb">
          <a href="/'.$f['trans'].'">
            <img src="/template/images/pages/'.$f['image'].'" alt="'.$f['title'].'" style="max-width:270px; width:auto; height:270px; margin: 0 auto;">
          </a>
        </div>
      </div>
      <div class="product__details">
        <h2><a href="/'.$f['trans'].'">'.$f['title'].'</a></h2>
      </div>
    </div>
  </div>';  
  };
  if ($f['type']=='calc_term') {
  $calcTerm.='
  <div class="col-md-4 single__pro col-lg-4 cat--1 col-sm-4 col-xs-12">
    <div class="product">
      <div class="product__inner">
        <div class="pro__thumb">
          <a href="/'.$f['trans'].'">
            <img src="/template/images/pages/'.$f['image'].'" alt="'.$f['title'].'" style="max-width:270px; width:auto; height:270px; margin: 0 auto;">
          </a>
        </div>
      </div>
      <div class="product__details">
        <h2><a href="/'.$f['trans'].'">'.$f['title'].'</a></h2>
      </div>
    </div>
  </div>';  
  };
  if ($f['type']=='calc_roof') {
  $calcRoof.='
  <div class="col-md-4 single__pro col-lg-4 cat--1 col-sm-4 col-xs-12">
    <div class="product">
      <div class="product__inner">
        <div class="pro__thumb">
          <a href="/'.$f['trans'].'">
            <img src="/template/images/pages/'.$f['image'].'" alt="'.$f['title'].'" style="max-width:270px; width:auto; height:270px; margin: 0 auto;">
          </a>
        </div>
      </div>
      <div class="product__details">
        <h2><a href="/'.$f['trans'].'">'.$f['title'].'</a></h2>
      </div>
    </div>
  </div>';  
  }
}


//News list
$r=mysql_query("
	SELECT * FROM rce_news_list
	ORDER BY `date` DESC
	LIMIT 9
");
for($i = 0; $i < mysql_num_rows($r); $i++) {
    $f=mysql_fetch_array($r);

    $date = rce_sep_date($f['date']);
    $month = rce_get_shortmonth($date[8]);

$homeNews.='
<div class="col-md-4 col-lg-4 col-sm-6 col-xs-12">
  <div class="blog foo">
    <div class="blog__inner">
      <div class="blog__thumb">
        <a href="/news/'.$f['trans'].'">
          <img src="/uploads/news/'.$f['image'].'" alt="'.$f['title'].'" style="max-width:370px; width:auto; height:350px; display: block; margin: 0 auto;">
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
              '.strip_tags(mb_substr($f['text'],0, 150)).'...
            </a>
          </p>
          <div class="blog__btn">
            <a class="read__more__btn" href="/news/'.$f['trans'].'">Подробнее</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>';
}
