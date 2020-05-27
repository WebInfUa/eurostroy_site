<?
// Catalog

function prodList($item, $cat){
    if ($item['price'] == 0) {
    $price='
    <ul class="product__price">
      <li>Товар не доступен</li>
    </ul>
    <button class="to-cart buy__now" data-item-id="'.$item['ID'].'" title="Заказать товар">Заказать</button>
    ';
  } else if ($item['qty'] == 0) {
    $price='
    <ul class="product__price">
      <li>Под заказ</li><br />
      <li>'.$item['price'].' грн. / '.$item['pcs'].'</li>
    </ul>
    <button class="to-cart buy__now" data-item-id="'.$item['ID'].'" title="Заказать товар">Заказать</button>
    ';
  } else if ($item['price_old'] > $item['price']) {
    $price='
    <ul class="product__price">
      <li class="old__price">'.$item['price_old'].' грн. </li>
      <li>'.$item['price'].' грн. / '.$item['pcs'].'</li>
    </ul>
    <button class="to-cart buy__now" data-item-id="'.$item['ID'].'" title="Добавить в корзину">Купить</button>';
  } else {
    $price='
    <ul class="product__price">
      <li>'.$item['price'].' грн. / '.$item['pcs'].'</li>
    </ul>
    <button class="to-cart buy__now" data-item-id="'.$item['ID'].'" title="Добавить в корзину">Купить</button>';
  };
  
  $replaceCharts = array(" ", ".", "?", ",", ":", "!", "$", ";", "&" ,"+" ,"-" ,"/");
  
  $manufClass = 'f_'.str_replace($replaceCharts, "_", $item['manuf']);
  if ($item['filter_param1'] !== "!") { 
    $filter1 = 'f_'.str_replace($replaceCharts, "_", $item['filter_param1']);
  } else {
    $filter1 ="";
  };
  if ($item['filter_param2'] !== "!") { 
    $filter2 = 'f_'.str_replace($replaceCharts, "_", $item['filter_param2']);
  } else {
    $filter2 ="";
  };
  if ($item['filter_param3'] !== "!") { 
    $filter3 = 'f_'.str_replace($replaceCharts, "_", $item['filter_param3']);
  } else {
    $filter3 ="";
  };
  if ($item['filter_param4'] !== "!") { 
    $filter4 = 'f_'.str_replace($replaceCharts, "_", $item['filter_param4']);
  } else {
    $filter4 ="";
  };
  if ($item['filter_param5'] !== "!") { 
    $filter5 = 'f_'.str_replace($replaceCharts, "_", $item['filter_param5']);
  } else {
    $filter5 ="";
  };
    
  if ($item['qty'] < 1) {
    $dataRating = 1;
  } else {
      $dataRating = $item['rating'];
  }

  
$out = '
<!-- Start Single Product -->
<div class="product-sort col-md-3 col-lg-3 col-sm-3 col-xs-6 tab mix
  f_'.$item['fav'].' 
  '.$manufClass.'
  '.$filter1.' 
  '.$filter2.' 
  '.$filter3.' 
  '.$filter4.' 
  '.$filter5.'
" 
data-price="'.$item['price'].'"  
data-fav="'.$item['fav'].'" 
data-date="'.mb_strimwidth(strtotime($item['date']), 3, 5).'" 
data-rating="'.$dataRating.'"
>
  <div class="product">
    <div class="product__inner">
      <div class="pro__thumb">
        <a href="/catalog/item/'.$cat['root'].'/'.$item['trans'].'">
          <img src="/uploads/catalog/mini/'.$item['image'].'" alt="'.$item['title'].'">
        </a>
      </div>
      <div class="product__hover__info">
        <ul class="product__action">
          <li><a class="quick-view modal-view detail-link" title="'.$item['title'].'"  href="/catalog/item/'.$cat['root'].'/'.$item['trans'].'"><span class="ti-eye"></span></a></li>
          <li><a class="to-cart" data-item-id="'.$item['ID'].'" title="Добавить в корзину" href="#"><span class="ti-shopping-cart"></span></a></li>
        </ul>
      </div>
    </div>
    <div class="product__details">
      <h2>        
        <a href="/catalog/item/'.$cat['root'].'/'.$item['trans'].'">
        '.$item['title'].' (арт.&nbsp;'.$item['artno'].')
        </a>
      </h2>
       '.$price.'
    </div>
  </div>
</div>
<!-- End Single Product -->
';
    return $out;
}

function prodListDescr($item, $cat){
    if ($item['price'] <= 0) {
    $price='
      <span class="product__price">НЕТ В НАЛИЧИИ</span>
';
  } else if ($item['price_old'] > $item['price']) {
    $price='
    <span class="product__price--old">'.$item['price_old'].' грн. </span>
    <span class="product__price">'.$item['price'].' грн. / '.$item['pcs'].'</span>';
  } else {
    $price='
    <span class="product__price">'.$item['price'].' грн. / '.$item['pcs'].'</span>';
  };
  
  $shoertDescr=mb_substr(strip_tags($item['short_descr']),0,150);
  
  $replaceCharts = array(" ", ".", "?", ",", ":", "!", "$", ";", "&" ,"+" ,"-" ,"/");
  
  $manufClass = 'f_'.str_replace($replaceCharts, "_", $item['manuf']);
  if ($item['filter_param1'] !== "!") { 
    $filter1 = 'f_'.str_replace($replaceCharts, "_", $item['filter_param1']);
  } else {
    $filter1 ="";
  };
  if ($item['filter_param2'] !== "!") { 
    $filter2 = 'f_'.str_replace($replaceCharts, "_", $item['filter_param2']);
  } else {
    $filter2 ="";
  };
  if ($item['filter_param3'] !== "!") { 
    $filter3 = 'f_'.str_replace($replaceCharts, "_", $item['filter_param3']);
  } else {
    $filter3 ="";
  };
  if ($item['filter_param4'] !== "!") { 
    $filter4 = 'f_'.str_replace($replaceCharts, "_", $item['filter_param4']);
  } else {
    $filter4 ="";
  };
  if ($item['filter_param5'] !== "!") { 
    $filter5 = 'f_'.str_replace($replaceCharts, "_", $item['filter_param5']);
  } else {
    $filter5 ="";
  };
  
$out = '
<!-- Start List Content-->
<div class="single__list__content clearfix tab mix 
  f_'.$item['fav'].' 
  '.$manufClass.' 
  '.$filter1.' 
  '.$filter2.' 
  '.$filter3.' 
  '.$filter4.' 
  '.$filter5.'
" 
data-price="'.$item['price'].'" 
data-fav="'.$item['fav'].'" 
data-date="'.mb_strimwidth(strtotime($item['date']), 3, 5).'" 
data-rating="'.$item['rating'].'" 
>
  <div class="col-md-3 col-lg-3 col-sm-4 col-xs-12">
    <div class="list__thumb">
      <a href="/catalog/item/'.$cat['root'].'/'.$item['trans'].'">
        <img src="/uploads/catalog/mini/'.$item['image'].'" alt="'.$item['title'].'">
      </a>
    </div>
  </div>
  <div class="col-md-9 col-lg-9 col-sm-8 col-xs-12">
    <div class="list__details__inner">
      <h2>        
        <a href="/catalog/item/'.$cat['root'].'/'.$item['trans'].'">
          '.$item['title'].'
        </a>
      </h2>
      <p>'.$shoertDescr.'...</p>
         '.$price.'
      <div class="shop__btn">
        <a class="htc__btn" href="/catalog/item/'.$cat['root'].'/'.$item['trans'].'"><span class=" ti-eye"></span>Перейти к товару</a>
      </div>
        </div>
    </div>
</div>
<!-- End List Content-->
';
    return $out;
}

function filterBlock($url, $param, $name){
  $replaceCharts = array(" ", ".", "?", ",", ":", "!", "$", ";", "&" ,"+" ,"-" ,"/");

  $rf=mysql_query("SELECT DISTINCT `".$param."` FROM `rce_catalog_items`  WHERE `cat`='".$url."' AND `".$param."`!='!' AND `".$param."`!='0'  ORDER BY `".$param."`");
  for($i=0;$i<mysql_num_rows($rf);$i++){
    $ff=mysql_fetch_array($rf);
    $nf=mysql_query("SELECT COUNT(".$param.") FROM `rce_catalog_items` WHERE `".$param."`='".$ff[$param]."' AND  `cat`='".$url."'");
    $ns=mysql_fetch_array($nf);
    $filterClass = 'f_'.str_replace($replaceCharts, "_", $ff[$param]);
    
    if ($param == 'fav') {
      if ($ff[$param] == 1) {
        $filterList.='<li><button type="button" data-toggle=".'.$filterClass.'">Акции</button><span>'.$ns[0].'</span></li>';
      };
      if ($ff[$param] == 2) {
        $filterList.='<li><button type="button" data-toggle=".'.$filterClass.'">Спецпредложения</button><span>'.$ns[0].'</span></li>';
      };
      if ($ff[$param] == 3) {
        $filterList.='<li><button type="button" data-toggle=".'.$filterClass.'">Топ продаж</button><span>'.$ns[0].'</span></li>';
      };
      if ($ff[$param] == 4) {
        $filterList.='<li><button type="button" data-toggle=".'.$filterClass.'">Распродажи</button><span>'.$ns[0].'</span></li>';
      };
    } else {
      $filterList.='<li><button type="button" data-toggle=".'.$filterClass.'">'.$ff[$param].'</button><span>'.$ns[0].'</span></li>';
    };
  }
  
  $out = '
<!-- Start filter block to '.$param.' -->
<div class="htc__shop__cat">
  <h4 class="section-title-4">'.$name.':</h4>
  <ul class="sidebar__list">
    <fieldset data-filter-group>
      '.$filterList.'
    </fieldset>
  </ul>
</div>
<!-- End filter block to '.$param.' -->';
  

  if ($name == "" || $filterList == "") {
    $out = '';
  };
  
  return $out;
}

function catList($data) {
    $out = '
<div class="single__pro cat--1 col-lg-3 col-md-3 col-sm-4 col-xs-12">
  <div class="product foo">
    <div class="product__inner">
      <div class="pro__thumb">
        <a href="/catalog/cat/'.$data['root'].'">
          <img src="/uploads/catalog/cats/'.$data['image'].'" alt="'.$data['title'].'">
        </a>
      </div>
      <div class="product__hover__info">
        <ul class="product__action">
          <li><a title="'.$data['title'].'" class="quick-view modal-view detail-link" href="/catalog/cat/'.$data['root'].'"><span class=" ti-eye"></span></a></li>
        </ul>
      </div>
    </div>
    <div class="product__details">
      <h2><a href="/catalog/cat/'.$data['root'].'">'.$data['title'].'</a></h2>
    </div>
  </div>
</div>
';
    return $out;
}


if ($URL[1] == ''){
	// Headers
  
  
$breadcrumb = '
<a class="breadcrumb-item" href="/">Главная</a>
<span class="brd-separetor">/</span>
<span class="breadcrumb-item active">Каталог</span>
';

	$rm = mysql_query("
		SELECT * FROM `rce_pages` 
		WHERE `ID` = '29'
	");
	$fm = mysql_fetch_array($rm);
    $meta_title=$fm['meta_title'];
   //Commit metadescription $meta_keys=$fm['meta_keys'];
    $meta_desc=$fm['meta_desc'];
    $title = $fm['title'];
	// Data
    $r=mysql_query("
		SELECT * FROM `rce_catalog_cats` 
		WHERE `lang` = 'ru' 
		AND `parent` = ''
		ORDER BY `order` ASC
	");
    for($i=0;$i<mysql_num_rows($r);$i++) {
        $f = mysql_fetch_array($r);
            $content .= catList($f);
    }
	$pageDescr = '<div>'.$f3['text'].'</div>';
} elseif($URL[1]=='cat'){
  
    // Show catalog data
    // Fetch current cat data
    $rc=mysql_query("
        SELECT * FROM `rce_catalog_cats`
        WHERE `trans`='".$URL[2]."'
    ");
    $fc=mysql_fetch_array($rc);
    $breadcrumb = '
<a class="breadcrumb-item" href="/">Главная</a>
<span class="brd-separetor">/</span>
<a class="breadcrumb-item" href="/catalog/">Каталог</a>    
<span class="brd-separetor">/</span>
<a class="breadcrumb-item" href="/catalog/cat/'.$fc['trans'].'">'.$fc['title'].'</a>';
  
    $meta_title = $fc['title'].' : Каталог';
    $title = $fc['title'];
    // Check for sub-cats
    // If have 3 level
    // Get list
    $r=mysql_query("
        SELECT * FROM `rce_catalog_cats`
        WHERE `parent`='".$URL[2]."'
        ORDER BY `order` ASC
    ");
    if(mysql_num_rows($r)>'0'){

        if($URL[3] != ''){
            // Get cat info
            $r3=mysql_query("
                SELECT * FROM `rce_catalog_cats`
                WHERE `trans`='".$URL[3]."'
            ");
            $f3 = mysql_fetch_array($r3);
            $breadcrumb.='
<span class="brd-separetor">/</span>
<a class="breadcrumb-item" href="/catalog/cat/'.$f3['root'].'">'.$f3['title'].'</a>';
            $title = $f3['title'];
            // Check for one more cat level
            $r4 = mysql_query("
                SELECT * FROM `rce_catalog_cats`
                WHERE `parent` = '".$URL[3]."'
            ");
            if(mysql_num_rows($r4)>0){ // Got some cats
                for($i4=0;$i4<mysql_num_rows($r4);$i4++){
                    $f4=mysql_fetch_array($r4);
                        $content .= catList($f4);
                }
            } else { // No cats, lets show products
                // Items
                $r=mysql_query("
                    SELECT * FROM `rce_catalog_items`
                    WHERE `cat`='".$URL[3]."' 
                    AND `archive` ='0'
                    ORDER BY `order` ASC
                ");
              
                if(mysql_num_rows($r)>'0'){
                    // Have sub-cats
                  // QTY product in category

                  // Show list
                  for($i=0;$i<mysql_num_rows($r);$i++){
                    $f=mysql_fetch_array($r);
                    // Category info
                    $rc = mysql_query("SELECT * FROM `rce_catalog_cats` WHERE `trans` = '".$f['cat']."'");
                    $fc = mysql_fetch_array($rc);
                    // Out
                    $productList.= prodList($f, $fc);
                    $productListDescr.= prodListDescr($f, $fc);

                    $prodQTY = $i + 1;
                  }
                  
                  $minPrice=mysql_fetch_array(mysql_query("SELECT MIN(price) FROM `rce_catalog_items`  WHERE `cat`='".$URL[3]."'"));
                  $maxPrice=mysql_fetch_array(mysql_query("SELECT MAX(price) FROM `rce_catalog_items`  WHERE `cat`='".$URL[3]."'"));
                  
                  $favoritFilter = filterBlock($URL[3], "fav", "Рекомендации Еврострой");
                  $manufacturerFilter = filterBlock($URL[3], "manuf", "Производители");
                  
                  $filterName1 = mysql_fetch_array(mysql_query("SELECT DISTINCT `filter_name1` 
                                                                FROM `rce_catalog_items`  
                                                                WHERE `cat`='".$URL[3]."' AND `filter_name1`!='!' 
                                                                ORDER BY `ID`"));
                  $blockFilter1 = filterBlock($URL[3], "filter_param1", $filterName1[0]);                                    
      
                  
                  $filterName2 = mysql_fetch_array(mysql_query("SELECT DISTINCT `filter_name2` 
                                                                FROM `rce_catalog_items`  
                                                                WHERE `cat`='".$URL[3]."' AND `filter_name2`!='!' 
                                                                ORDER BY `ID`"));
                  $blockFilter2 = filterBlock($URL[3], "filter_param2", $filterName2[0]);                                    
      
                  
                  $filterName3 = mysql_fetch_array(mysql_query("SELECT DISTINCT `filter_name3` 
                                                                FROM `rce_catalog_items`  
                                                                WHERE `cat`='".$URL[3]."' AND `filter_name3`!='!' 
                                                                ORDER BY `ID`"));
                  $blockFilter3 = filterBlock($URL[3], "filter_param3", $filterName3[0]);                                    
      
                  
                  $filterName4 = mysql_fetch_array(mysql_query("SELECT DISTINCT `filter_name4` 
                                                                FROM `rce_catalog_items`  
                                                                WHERE `cat`='".$URL[3]."' AND `filter_name4`!='!' 
                                                                ORDER BY `ID`"));
                  $blockFilter4 = filterBlock($URL[3], "filter_param4", $filterName4[0]);                                    
      
                  
                  $filterName5 = mysql_fetch_array(mysql_query("SELECT DISTINCT `filter_name5` 
                                                                FROM `rce_catalog_items`  
                                                                WHERE `cat`='".$URL[3]."' AND `filter_name5`!='!' 
                                                                ORDER BY `ID`"));
                  $blockFilter5 = filterBlock($URL[3], "filter_param5", $filterName5[0]);                                    
      
                        $content= '
<div class="col-md-3 col-lg-3 col-sm-12 col-xs-12">
  <div class="htc__shop__left__sidebar">
    <!-- Start Range -->
    <div class="htc-grid-range">
      <h2><button class="filter__button" type="button" onClick="window.location.reload();" data-filter="all">Сбросить фильтр</button></h2>
      <h4 class="section-title-4">Фильтр по цене</h4>
      <div class="content-shopby">
        <div class="price_filter s-filter clear">
          <div class="slider__range--output">
            <div class="price__output--wrap">
              <div class="price--output">
                  <fieldset data-filter-group>
                    <div>
                      <span>Цена от:</span>
                      <input id="amountMinim" type="text" value="'.$minPrice[0].'">
                      <span>грн.</span>
                    </div>
                    <div>
                      <span>Цена до:</span>
                      <input id="amountMaxim" type="text" value="'.$maxPrice[0].'">
                      <span>грн.</span>
                    </div>
                  </fieldset>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- End Range -->

'.$favoritFilter.'

'.$manufacturerFilter.'

'.$blockFilter1.'

'.$blockFilter2.'

'.$blockFilter3.'

'.$blockFilter4.'

'.$blockFilter5.'

<!-- Prepear code block to color filter -->
<!-- Start Color Cat -->   
<!--
<div class="htc__shop__cat">
  <h4 class="section-title-4">Цвет</h4>

  <ul class="sidebar__list">
    <li class="black"><a href="#"><i class="zmdi zmdi-circle"></i>Черный</a></li>
    <li class="white"><a href="#"><i class="zmdi zmdi-circle"></i>Белый</a></li>
    <li class="blue"><a href="#"><i class="zmdi zmdi-circle"></i>Синий</a></li>
    <li class="brown"><a href="#"><i class="zmdi zmdi-circle"></i>Коричневый</a></li>
    <li class="red"><a href="#"><i class="zmdi zmdi-circle"></i>Красный</a></li>
    <li class="orange"><a href="#"><i class="zmdi zmdi-circle"></i>Оранжевый</a></li>
    <li class="yellow"><a href="#"><i class="zmdi zmdi-circle"></i>Желтый</a></li>
    <li class="green"><a href="#"><i class="zmdi zmdi-circle"></i>Зеленый</a></li>
  </ul>
</div>
-->
<!-- End Color Cat -->


    <!-- Start Tag Area -->
    <div class="htc__shop__cat">
      <h4 class="section-title-4">Теги</h4>
      <ul class="htc__tags">
        <li><a href="/catalog">Каталог товаров</a></li>
        <li><a href="/">Еврострой</a></li>
        <li><a href="/catalog/cat/chemistry">Строительная химия</a></li>
        <li><a href="/catalog/cat/paintwork/water-paint">Краски</a></li>
        <li><a href="/catalog/cat/build-mixes/cement">Цемент</a></li>
        <li><a href="/catalog/cat/build-mixes/htukaturka">Штукатурки</a></li>
        <li><a href="/catalog/cat/build-mixes/kley-plitka">Клея для плитки</a></li>
        <li><a href="/catalog/cat/chemistry/silicon">Герметики</a></li>
        <li><a href="/catalog/cat/consumables">Расходники</a></li>
      </ul>
    </div>
    <!-- End Tag Area -->
  </div>
</div>
<div class="col-md-9 col-lg-9 col-sm-12 col-xs-12 smt-30">
<div class="row">
  <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
    <div class="producy__view__container">
      <!-- Start Short Form -->
      <div class="product__list__option">
        <div class="order-single-btn">
        <span>Сортировка:&nbsp;</span>
          <select id="sorted" class="select-color selectpicker">
            <option value="rating"> Популярные</option>
            <option value="incr"> Подешевле</option>
            <option value="decr"> Подороже</option>
            <option value="date"> Новые</option>
            <option value="fav"> Акции</option>
          </select>
        </div>
      <div class="shp__pro__show">
        <span>Найдено '.$prodQTY.' позиции</span>
      </div>
      </div>
      <!-- End Short Form -->
      <!-- Start List And Grid View -->
      <ul class="view__mode" role="tablist">
        <li role="presentation" class="grid-view active"><a href="#" onClick="window.location.reload();" title="Product grid list"><i class="zmdi zmdi-grid"></i></a></li>
        <li role="presentation" class="list-view"><a href="#list-view" role="tab" data-toggle="tab" title="Product list"><i class="zmdi zmdi-view-list"></i></a></li>
        <li class="filter__box"><a class="filter__menu" href="#" title="Filters"><i class="zmdi zmdi-filter-list"></i></a></li>
      </ul>
        <!-- End List And Grid View -->
    </div>
  </div>
</div>            
<!-- End Product MEnu -->
<!-- Start Filter Menu -->
<div class="filter__wrap">
  <div class="filter__cart">
    <div class="filter__cart__inner">
      <div class="filter__menu__close__btn">
          <a href="#"><i class="zmdi zmdi-close"></i></a>
      </div>
      <div class="filter__content">
      <h2><button class="filter__button" type="button" onClick="window.location.reload();" data-filter="all">Сбросить фильтр</button></h2>

      <!-- Start Filter Content -->
        
      '.$favoritFilter.'

      '.$manufacturerFilter.'

      '.$blockFilter1.'

      '.$blockFilter2.'

      '.$blockFilter3.'

      '.$blockFilter4.'

      '.$blockFilter5.'

      <!-- End Filter Content -->
      </div>
    </div>
  </div>
</div>
<!-- End Filter Menu -->


<div class="row">
  <div class="shop__grid__view__wrap another-product-style">
  <!-- Start Single View -->
    <div role="tabpanel" id="grid-view" class="single-grid-view tab-pane fade in active clearfix">
        '.$productList.'
    </div>
    <div role="tabpanel" id="list-view" class="single-grid-view tab-pane fade clearfix">
        '.$productListDescr.'
    </div>
  </div>
</div>

</div>

<script src="/template/js/mixitup.min.js"></script>
<script src="/template/js/mixitup-multifilter.js"></script>

<script>
  var containerEl = document.querySelector("#grid-view");
  var mixer = mixitup(containerEl, {
                multifilter: {
                  enable: true
                },
                animation: {
                  "nudge": true,
                  "reverseOut": true,
                }
            });
            
            var minSizeRangeInput = document.querySelector(`#amountMinim`);
            var maxSizeRangeInput = document.querySelector(`#amountMaxim`);

            function getRange() {
                var min = Number(minSizeRangeInput.value);
                var max = Number(maxSizeRangeInput.value);

                return {
                    min: min,
                    max: max
                };
            }

            function handleRangeInputChange() {
                mixer.filter(mixer.getState().activeFilter);
            }

            function filterTestResult(testResult, target) {
                var size = Number(target.dom.el.getAttribute(`data-price`));
                var range = getRange();

                if (size < range.min || size > range.max) {
                    testResult = false;
                }

                return testResult;
            }

            mixitup.Mixer.registerFilter(`testResultEvaluateHideShow`, `range`, filterTestResult);

            minSizeRangeInput.addEventListener(`change`, handleRangeInputChange);
            maxSizeRangeInput.addEventListener(`change`, handleRangeInputChange);
</script>
';

                } else {
                    // No sub-cats, check for products
                    // Prod list
                  $content='
            <p class="product-info__search">Извините, в данной категории товары отсутсвуют!</span></p>
            <div>
              <p class="product-info__search">Другие товары!</p>
              {randProd}
            </div>';
                }
            }
            $meta_title = $f3['meta_title'];
            // commit metakeywords     $meta_keys = $f3['meta_keys'];
            $meta_desc = $f3['meta_desc'];
            $pageDescr = '<div>'.$f3['text'].'</div>';
            // 4
            if($URL[4] != ''){

                // Category info
                $r4 = mysql_query("
                    SELECT * FROM rce_catalog_cats 
                    WHERE trans = '".$URL[4]."'
                ");
                $f4cat = mysql_fetch_assoc($r4);

                $content='';
                // Items
                $r=mysql_query("
                    SELECT * FROM `rce_catalog_items`
                    WHERE `cat`='".$URL[4]."' 
                    AND `lang` = 'ru'
                    AND `archive` ='0'
                    ORDER BY `order` ASC
                ");
                if(mysql_num_rows($r)>'0'){
                    // Have sub-cats
                    // Show list
                    for($i=0;$i<mysql_num_rows($r);$i++){
                        $f=mysql_fetch_array($r);
                        // Category info
                        $rc = mysql_query("
                            SELECT * FROM `rce_catalog_cats`
                            WHERE `trans` = '".$f['cat']."'
                        ");
                        $fc = mysql_fetch_array($rc);
                        $content .= prodList($f, $fc);
                    }

                } else {
                    // No sub-cats, check for products
                    // Prod list
                    $content.='
<p class="product-info__search">Извините, в данной категории товары отсутсвуют!</span></p>
<div>
  <p class="product-info__search">Другие товары!</p>
  {randProd}
</div>';
                }

                $meta_title = $f4cat['meta_title'];
                // commit metakeywords     $meta_keys = $f4cat['meta_keys'];
                $meta_desc = $f4cat['meta_desc'];
              	$pageDescr = '<div>'.$f4cat['text'].'</div>';
            }

        } else {

            // Show list
            for($i=0;$i<mysql_num_rows($r);$i++){
                $f=mysql_fetch_array($r);
                $content .= catList($f);
            }

          
          
            // Модуль каталога 3.0 WHAT IS THIT
            $catUri=substr($_SERVER['REQUEST_URI'],1); // Delete first slash
            $catURL=explode('/',$catUri); // Parsing url
            $content.='<div>';
            $lastURL = array_pop($catURL);


            $ri=mysql_query("
                SELECT * FROM `rce_catalog_items`                 
                WHERE `cat` = '".$lastURL."'
                AND `archive` ='0'
            ");
            if (mysql_num_rows($ri)> 0) {
                $content .= '<div style="background: #F46F16;color: white;padding: 7px;font-size: 18px;">Список товаров</div>';
                while ($fi = mysql_fetch_array($ri)) {
                    $rc = mysql_query("
                    SELECT * FROM `rce_catalog_cats`
                    WHERE `trans` = '".$fi['cat']."'
                ");
                    $fc = mysql_fetch_array($rc);
                    $content .= prodList($fi, $fc);
                }
            }
            $content.='</div>';

            $meta_title = $fc['meta_title'];
            // commit metakeywords     $meta_keys = $fc['meta_keys'];
            $meta_desc = $fc['meta_desc'];
          	$pageDescr = '<div>'.$fc['text'].'</div>';
        }


    } else {
        // Do not have 3 level
        $rcat2 = mysql_query("
            SELECT * FROM rce_catalog_cats
            WHERE trans = '".$URL[2]."'
        ");
        $fcat2 = mysql_fetch_assoc($rcat2);

        // Get list
        $meta_title=$fcat2['meta_title'];
        // commit metakeywords     $meta_keys=$fcat2['meta_keys'];
        $meta_desc=$fcat2['meta_desc'];
        $r=mysql_query("
            SELECT * FROM `rce_catalog_items`
            WHERE `cat`='".$URL[2]."' 
            AND `lang` = 'ru'
            AND `archive` ='0'
            ORDER BY `order` ASC
        ");
        if(mysql_num_rows($r)>'0'){
            // Have sub-cats
            // Show list
            for($i=0;$i<mysql_num_rows($r);$i++){
                $f=mysql_fetch_array($r);
                // Category info
                $rc = mysql_query("
                    SELECT * FROM `rce_catalog_cats`
                    WHERE `trans` = '".$f['cat']."'
                ");
                $fc = mysql_fetch_array($rc);
                $content .= prodList($f, $fc);
            }

        } else {
            // No sub-cats, check for products
            // Prod list
            $content.='
<p class="product-info__search">Извините, в данной категории товары отсутсвуют!</span></p>
<div>
  <p class="product-info__search">Другие товары!</p>
  {randProd}
</div>';
        }
      	$pageDescr = '<div>'.$fcat2['text'].'</div>';
    }

} elseif($URL[1]=='item'){
    if($URL[2]!=''){ // If in subcat
	
        if($URL[4]!=''){

            // Show product
            $r=mysql_query("
                SELECT * FROM `rce_catalog_items`
                WHERE `trans`='".$URL[4]."'
                AND `archive` ='0'
            ");
            $f=mysql_fetch_array($r);

            //
            $rcc = mysql_query("
                SELECT * FROM `rce_catalog_cats`
                WHERE `trans` = '".$URL[2]."'
            ");
            $fcc = mysql_fetch_array($rcc);

            $rc=mysql_query("
                SELECT * FROM `rce_catalog_cats`
                WHERE `trans`='".$f['cat']."'
            ");
            $fc=mysql_fetch_array($rc);
            // Fetch current cat data
              $breadcrumb = '
<a class="breadcrumb-item" href="/">Главная</a>
<span class="brd-separetor">/</span>
<a class="breadcrumb-item" href="/catalog/">Каталог</a>    
<span class="brd-separetor">/</span>
<a class="breadcrumb-item" href="/catalog/cat/'.$fcc['trans'].'">'.$fcc['title'].'</a>
<span class="brd-separetor">/</span>
<a class="breadcrumb-item" href="/catalog/cat/'.$fc['root'].'">'.$fc['title'].'</a>';
            $title = "";
          
          
            $meta_title=$f['meta_title'].' : '.$fc['meta_title'];
            // commit metakeywords     $meta_keys=$f['meta_keys'];
            $meta_desc=$f['meta_desc'];
            // Addon images
            $ri=mysql_query("
                SELECT * FROM `rce_catalog_images`
                WHERE `item`='".$f['ID']."'
                ORDER BY `ID` ASC
            ");
            for($i=0;$i<mysql_num_rows($ri);$i++){
                $fi=mysql_fetch_array($ri);
                $addon_images.='
					<a class="fancybox images-add" rel="group" href="/uploads/catalog/'.$fi['image'].'" title="'.$f['title'].'">
						<img class="addon" src="/uploads/catalog/mini/'.$fi['image'].'" alt="image" />
					</a>
				';
            }
          
    // Price
  if ($f['price'] <= 0) {
    $price='<li>Нет в наличии</li>';
  } else if ($f['price_old'] > $f['price']) {
    $price='
    <li class="old__prize">'.$f['price_old'].' грн.</li>
    <li>'.$f['price'].' грн. / '.$f['pcs'].'</li>';
  } else {
    $price='<li>'.$f['price'].' грн. / '.$f['pcs'].'</li>';
  };
          
//    Rating block
    if ($f['rating'] < 10) {
      $prodRating = '
        <li><i class="zmdi zmdi-star"></i></li>
        <li><i class="zmdi zmdi-star"></i></li>
        <li><i class="zmdi zmdi-star"></i></li>
        <li><i class="zmdi zmdi-star-outline"></i></li>
        <li><i class="zmdi zmdi-star-outline"></i></li>
      ';
    } elseif ($f['rating'] > 10 && $f['rating'] < 70) {
      $prodRating = '
        <li><i class="zmdi zmdi-star"></i></li>
        <li><i class="zmdi zmdi-star"></i></li>
        <li><i class="zmdi zmdi-star"></i></li>
        <li><i class="zmdi zmdi-star"></i></li>
        <li><i class="zmdi zmdi-star-outline"></i></li>
      ';
    } else {
      $prodRating = '
        <li><i class="zmdi zmdi-star"></i></li>
        <li><i class="zmdi zmdi-star"></i></li>
        <li><i class="zmdi zmdi-star"></i></li>
        <li><i class="zmdi zmdi-star"></i></li>
        <li><i class="zmdi zmdi-star"></i></li>';  
    }

//    Rating block
    if ($f['qty'] > 0) {
      $qtyStatus = '<b style="color: green;">На складе</b>';
    } else {
      $qtyStatus = '<b style="color: red;">Под заказ</b>';
    }
          
//    Image block
  if ($f['image'] != '' && $f['image2'] != '' && $f['image3'] != '') {
    $images='
    <div class="scroll-single-product mb--30">
      <img src="/uploads/catalog/'.$f['image'].'" alt="'.$f['title'].'">
    </div>   
    <div class="scroll-single-product mb--30">
      <img src="/uploads/catalog/'.$f['image2'].'" alt="'.$f['title'].' фото">
    </div>    
    <div class="scroll-single-product mb--30">
      <img src="/uploads/catalog/'.$f['image3'].'" alt="'.$f['title'].' картинка">
    </div>';
  } else if ($f['image'] != '' && $f['image2'] != '') {
    $images='
    <div class="scroll-single-product mb--30">
      <img src="/uploads/catalog/'.$f['image'].'" alt="'.$f['title'].'">
    </div>    
    <div class="scroll-single-product mb--30">
      <img src="/uploads/catalog/'.$f['image2'].'" alt="'.$f['title'].' картинка">
    </div>';
  } else if ($f['image'] != '') {
    $images='    
    <div class="scroll-single-product mb--30">
      <img src="/uploads/catalog/'.$f['image'].'" alt="'.$f['title'].'">
    </div>';
  } else {
    $images='
    <div class="scroll-single-product mb--30">
      <img src="/template/images/logo/logo.png" alt="'.$f['title'].'">
    </div>';
  };
          
    // Out
    $content='
<div class="col-md-4 col-lg-4 col-sm-5 col-xs-12">
  <div class="product__details__container product-details-5">
  '.$images.'
  </div>
</div>
<div class="sidebar-active col-md-8 col-lg-8 col-sm-7 col-xs-12 xmt-30">
  <div class="htc__product__details__inner ">
    <div class="pro__detl__title">
      <h2>'.$f['title'].' (арт.&nbsp;'.$f['artno'].')</h2>
    </div>
    <div class="pro__dtl__rating">
      <ul class="pro__rating">
        '.$prodRating.'
      </ul>
    </div>
  <p class="rat__qun">Артикул товара: <b>'.$f['artno'].'</b></p>
  <p class="rat__qun">Наличие товара: '.$qtyStatus.'</p>
    <div class="pro__details">
      <p>
      '.$f['short_descr'].'
      <p>
    </div>
    <ul class="pro__dtl__prize">
      '.$price.'
    </ul>
    <div class="product-action-wrap">
      <div class="prodict-statas"><span>Кол-во :</span></div>
      <div class="product-quantity">
        <form action="" method="post">
          <div class="product-quantity">
            <div class="cart-plus-minus">
              <label for="coun" hidden></label>
              <input class="cart-plus-minus-box" type="text" id="coun" data-item-id="'.$f['ID'].'" name="coun" value="1">
            </div>
          </div>
        </form>
      </div>
    </div>
    <ul class="pro__dtl__btn">
      <li class="buy__now__btn" data-item-id="'.$f['ID'].'">
        <a href="#">Купить</a>
      </li>
      <li><a href="#"><span class="ti-email"></span></a></li>
    </ul>
    <div class="pro__social__share">
      <h2>Заходи к нам:</h2>
      <ul class="pro__soaial__link">
        <li><a href="https://www.instagram.com/_eurostroy_/" target="_blank"><i class="zmdi zmdi-instagram"></i></a></li>
        <li><a href="https://www.facebook.com/eurostroy.ck/" target="_blank"><i class="zmdi zmdi-facebook"></i></a></li>
        <li><a href="viber://chat?number=+380939099915" title="Viber"><i class="zmdi zmdi-vimeo"></i></a></li>
      </ul>
    </div>
  </div>
</div>
';
        
  $pageDescr='
<section class="htc__product__details__tab bg__white pb--120">
  <div class="container">
    <div class="row">
      <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
        <ul class="product__deatils__tab mb--60" role="tablist">
          <li role="presentation" class="active">
            <a href="#description" role="tab" data-toggle="tab">Описание</a>
          </li>
          <li role="presentation">
            <a href="#sheet" role="tab" data-toggle="tab">Другие товары</a>
          </li>
          <li role="presentation">
            <a href="#reviews" role="tab" data-toggle="tab">Отзывы (в разработке)</a>
          </li>
        </ul>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="product__details__tab__content">
          <div role="tabpanel" id="description" class="product__tab__content fade in active">
            <div class="product__description__wrap">
              <div class="product__desc">
                <h2 class="title__6">Описание</h2>
                <p>
                  '.$f['text'].'
                </p>
              </div>
            </div>
          </div>
          <div role="tabpanel" id="sheet" class="product__tab__content fade">
            <div class="pro__feature">
              <h2 class="title__6">Популярные товары</h2>
                {randProd}
            </div>
          </div>
          
          <div role="tabpanel" id="reviews" class="product__tab__content fade">
            <div class="review__address__inner">
              <div class="pro__review">
                <div class="review__thumb">
                  <img src="/template/images/review/1.jpg" alt="review images">
                </div>
                <div class="review__details">
                  <div class="review__info">
                      <h4><a href="#">Customer (TEST INFO)</a></h4>
                      <ul class="rating">
                          <li><i class="zmdi zmdi-star"></i></li>
                          <li><i class="zmdi zmdi-star"></i></li>
                          <li><i class="zmdi zmdi-star"></i></li>
                          <li><i class="zmdi zmdi-star-half"></i></li>
                          <li><i class="zmdi zmdi-star-outline"></i></li>
                      </ul>
                      <div class="rating__send">
                          <a href="#"><i class="zmdi zmdi-mail-reply"></i></a>
                          <a href="#"><i class="zmdi zmdi-close"></i></a>
                      </div>
                  </div>
                  <div class="review__date">
                      <span>25 Dec, 2019</span>
                  </div>
                  <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer accumsan egestas elese ifend. Phasellus a felis at estei to bibendum feugiat ut eget eni Praesent et messages in con sectetur posuere dolor non.</p>
              </div>
            </div>
            <!-- Start Single Review ADMIN ANSWER -->
                <div class="pro__review ans">
                  <div class="review__thumb">
                    <img src="/template/images/review/1.jpg" alt="review images">
                  </div>
                <div class="review__details">
                  <div class="review__info">
                    <h4><a href="#">Administrator</a></h4>
                      <ul class="rating">
                        <li><i class="zmdi zmdi-star"></i></li>
                        <li><i class="zmdi zmdi-star"></i></li>
                        <li><i class="zmdi zmdi-star"></i></li>
                        <li><i class="zmdi zmdi-star-half"></i></li>
                        <li><i class="zmdi zmdi-star-outline"></i></li>
                      </ul>
                    <div class="rating__send">
                      <a href="#"><i class="zmdi zmdi-mail-reply"></i></a>
                      <a href="#"><i class="zmdi zmdi-close"></i></a>
                    </div>
                  </div>
                  <div class="review__date">
                    <span>27 Dec, 2019</span>
                  </div>
                  <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer accumsan egestas elese ifend. Phasellus a felis at estei to bibendum feugiat ut eget eni Praesent et messages in con sectetur posuere dolor non.</p>
                </div>
              </div>
              <!-- End Single Review ADMIN ANSWER -->
          </div>
        <div class="rating__wrap">
          <h2 class="rating-title">Оставить отзыв</h2>
          <h4 class="rating-title-2">Ваша оценка</h4>
          <div class="rating__list">
            <ul class="rating">
              <li><i class="zmdi zmdi-star"></i></li>
            </ul>
            <ul class="rating">
              <li><i class="zmdi zmdi-star"></i></li>
              <li><i class="zmdi zmdi-star-half"></i></li>
            </ul>
            <ul class="rating">
              <li><i class="zmdi zmdi-star"></i></li>
              <li><i class="zmdi zmdi-star"></i></li>
              <li><i class="zmdi zmdi-star-half"></i></li>
            </ul>
            <ul class="rating">
              <li><i class="zmdi zmdi-star"></i></li>
              <li><i class="zmdi zmdi-star"></i></li>
              <li><i class="zmdi zmdi-star"></i></li>
              <li><i class="zmdi zmdi-star-half"></i></li>
            </ul>
            <ul class="rating">
              <li><i class="zmdi zmdi-star"></i></li>
              <li><i class="zmdi zmdi-star"></i></li>
              <li><i class="zmdi zmdi-star"></i></li>
              <li><i class="zmdi zmdi-star"></i></li>
              <li><i class="zmdi zmdi-star-half"></i></li>
            </ul>
          </div>
        </div>
          <div class="review__box">
            <form id="review-form">
              <div class="single-review-form">
                <div class="review-box name">
                  <input type="text" placeholder="Введите Ваше имя">
                  <input type="email" placeholder="Введите Ваш e-mail">
                </div>
              </div>
              <div class="single-review-form">
                <div class="review-box message">
                    <textarea placeholder="Ваш отзыв"></textarea>
                </div>
              </div>
              <div class="review-btn">
                <a class="fv-btn" href="#">Отправить</a>
              </div>
            </form>                                
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>';
        } else {

            // Show product
            $r=mysql_query("
                SELECT * FROM `rce_catalog_items`
                WHERE `trans`='".$URL[3]."'
                AND `archive` ='0'
            ");
            $f=mysql_fetch_array($r);
            $rc=mysql_query("
                SELECT * FROM `rce_catalog_cats`
                WHERE `trans`='".$f['cat']."'
            ");
            $fc=mysql_fetch_array($rc);
            // Fetch current cat data
            $breadcrumb='
<a class="breadcrumb-item" href="/">Главная</a>
<span class="brd-separetor">/</span>
<a class="breadcrumb-item" href="/catalog/">Каталог</a>    
<span class="brd-separetor">/</span>
<a class="breadcrumb-item" href="/catalog/cat/'.$fc['root'].'">'.$fc['title'].'</a>';
            $title=$f['title'];
            $meta_title=$f['meta_title'].' : '.$fc['meta_title'];
            // commit metakeywords     $meta_keys=$f['meta_keys'];
            $meta_desc=$f['meta_desc'];
            // Addon images
            $ri=mysql_query("
                SELECT * FROM `rce_catalog_images`
                WHERE `item`='".$f['ID']."'
                ORDER BY `ID` ASC
            ");
            for($i=0;$i<mysql_num_rows($ri);$i++){
                $fi=mysql_fetch_array($ri);
                    $addon_images.='
                        <a class="fancybox images-add" rel="group" href="/uploads/catalog/'.$fi['image'].'" title="'.$f['title'].'">
                         <img class="addon" src="/uploads/catalog/mini/'.$fi['image'].'" alt="image"/>
                        </a>
                    ';
            }

// Price
  if ($f['price'] <= 0) {
    $price='<li>Нет в наличии</li>';
  } else if ($f['price_old'] > $f['price']) {
    $price='
    <li class="old__prize">'.$f['price_old'].' грн.</li>
    <li>'.$f['price'].' грн. / '.$f['pcs'].'</li>';
  } else {
    $price='<li>'.$f['price'].' грн. / '.$f['pcs'].'</li>';
  };
    
// Image block
  if ($f['image'] != '' && $f['image2'] != '' && $f['image3'] != '') {
    $images='
    <div class="scroll-single-product mb--30">
      <img src="/uploads/catalog/'.$f['image'].'" alt="'.$f['title'].'">
    </div>   
    <div class="scroll-single-product mb--30">
      <img src="/uploads/catalog/'.$f['image2'].'" alt="'.$f['title'].' фото">
    </div>    
    <div class="scroll-single-product mb--30">
      <img src="/uploads/catalog/'.$f['image3'].'" alt="'.$f['title'].' картинка">
    </div>';
  } else if ($f['image'] != '' && $f['image2'] != '') {
    $images='
    <div class="scroll-single-product mb--30">
      <img src="/uploads/catalog/'.$f['image'].'" alt="'.$f['title'].'">
    </div>    
    <div class="scroll-single-product mb--30">
      <img src="/uploads/catalog/'.$f['image2'].'" alt="'.$f['title'].' картинка">
    </div>';
  } else if ($f['image'] != '') {
    $images='    
    <div class="scroll-single-product mb--30">
      <img src="/uploads/catalog/'.$f['image'].'" alt="'.$f['title'].'">
    </div>';
  } else {
    $images='
    <div class="scroll-single-product mb--30">
      <img src="/template/images/logo/logo.png" alt="'.$f['title'].'">
    </div>';
  };

               
//    Rating block
    if ($f['rating'] < 10) {
      $prodRating = '
        <li><i class="zmdi zmdi-star"></i></li>
        <li><i class="zmdi zmdi-star"></i></li>
        <li><i class="zmdi zmdi-star"></i></li>
        <li><i class="zmdi zmdi-star-outline"></i></li>
        <li><i class="zmdi zmdi-star-outline"></i></li>
      ';
    } elseif ($f['rating'] > 10 && $f['rating'] < 70) {
      $prodRating = '
        <li><i class="zmdi zmdi-star"></i></li>
        <li><i class="zmdi zmdi-star"></i></li>
        <li><i class="zmdi zmdi-star"></i></li>
        <li><i class="zmdi zmdi-star"></i></li>
        <li><i class="zmdi zmdi-star-outline"></i></li>
      ';
    } else {
      $prodRating = '
        <li><i class="zmdi zmdi-star"></i></li>
        <li><i class="zmdi zmdi-star"></i></li>
        <li><i class="zmdi zmdi-star"></i></li>
        <li><i class="zmdi zmdi-star"></i></li>
        <li><i class="zmdi zmdi-star"></i></li>';  
    }

//    Rating block
    if ($f['qty'] > 0) {
      $qtyStatus = '<b style="color: green;">На складе</b>';
    } else {
      $qtyStatus = '<b style="color: red;">Под заказ</b>';
    }
          
 // Out
$content='
<div class="col-md-4 col-lg-4 col-sm-5 col-xs-12">
  <div class="product__details__container product-details-5">
  '.$images.'
  </div>
</div>
<div class="sidebar-active col-md-8 col-lg-8 col-sm-7 col-xs-12 xmt-30">
  <div class="htc__product__details__inner ">
    <div class="pro__detl__title">
      <h2>'.$f['title'].' (арт.&nbsp;'.$f['artno'].')</h2>
    </div>
    <div class="pro__dtl__rating">
      <ul class="pro__rating">
        '.$prodRating.'
      </ul>
    </div>
  <p class="rat__qun">Артикул товара: <b>'.$f['artno'].'</b></p>
  <p class="rat__qun">Наличие товара: '.$qtyStatus.'</p>
    </div>
    <div class="pro__details">
      <p>
      '.$f['short_descr'].'
      <p>
    </div>
    <ul class="pro__dtl__prize">
      '.$price.'
    </ul>
    <div class="product-action-wrap">
      <div class="prodict-statas"><span>Кол-во :</span></div>
      <div class="product-quantity">
        <form id="myform">
          <div class="product-quantity">
            <div class="cart-plus-minus">
              <label for="coun" hidden></label>
              <input class="cart-plus-minus-box" type="text" id="coun" data-item-id="'.$f['ID'].'" name="coun" value="1">
            </div>
          </div>
        </form>
      </div>
    </div>
    <ul class="pro__dtl__btn">
      <li class="buy__now__btn" data-item-id="'.$f['ID'].'">
        <a href="#">Купить</a>
      </li>
      <li><a href="#"><span class="ti-email"></span></a></li>
    </ul>
    <div class="pro__social__share">
      <h2>Заходи к нам:</h2>
      <ul class="pro__soaial__link">
        <li><a href="https://www.instagram.com/_eurostroy_/" target="_blank"><i class="zmdi zmdi-instagram"></i></a></li>
        <li><a href="https://www.facebook.com/eurostroy.ck/" target="_blank"><i class="zmdi zmdi-facebook"></i></a></li>
        <li><a href="viber://chat?number=+380939099915" title="Viber"><i class="zmdi zmdi-vimeo"></i></a></li>
      </ul>
    </div>
  </div>
</div>
';
        
  $pageDescr='
<section class="htc__product__details__tab bg__white pb--120">
  <div class="container">
    <div class="row">
      <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
        <ul class="product__deatils__tab mb--60" role="tablist">
          <li role="presentation" class="active">
            <a href="#description" role="tab" data-toggle="tab">Описание</a>
          </li>
          <li role="presentation">
            <a href="#sheet" role="tab" data-toggle="tab">Другие товары</a>
          </li>
          <li role="presentation">
            <a href="#reviews" role="tab" data-toggle="tab">Отзывы (в разработке)</a>
          </li>
        </ul>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="product__details__tab__content">
          <div role="tabpanel" id="description" class="product__tab__content fade in active">
            <div class="product__description__wrap">
              <div class="product__desc">
                <h2 class="title__6">Описание</h2>
                <p>
                  '.$f['text'].'
                </p>
              </div>
            </div>
          </div>
          <div role="tabpanel" id="sheet" class="product__tab__content fade">
            <div class="pro__feature">
              <h2 class="title__6">Популярные товары</h2>
                {randProd}
            </div>
          </div>
          
          <div role="tabpanel" id="reviews" class="product__tab__content fade">
            <div class="review__address__inner">
              <div class="pro__review">
                <div class="review__thumb">
                  <img src="/template/images/review/1.jpg" alt="review images">
                </div>
                <div class="review__details">
                  <div class="review__info">
                      <h4><a href="#">Customer (TEST INFO)</a></h4>
                      <ul class="rating">
                          <li><i class="zmdi zmdi-star"></i></li>
                          <li><i class="zmdi zmdi-star"></i></li>
                          <li><i class="zmdi zmdi-star"></i></li>
                          <li><i class="zmdi zmdi-star-half"></i></li>
                          <li><i class="zmdi zmdi-star-outline"></i></li>
                      </ul>
                      <div class="rating__send">
                          <a href="#"><i class="zmdi zmdi-mail-reply"></i></a>
                          <a href="#"><i class="zmdi zmdi-close"></i></a>
                      </div>
                  </div>
                  <div class="review__date">
                      <span>25 Dec, 2019</span>
                  </div>
                  <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer accumsan egestas elese ifend. Phasellus a felis at estei to bibendum feugiat ut eget eni Praesent et messages in con sectetur posuere dolor non.</p>
              </div>
            </div>
            <!-- Start Single Review ADMIN ANSWER -->
                <div class="pro__review ans">
                  <div class="review__thumb">
                    <img src="/template/images/review/1.jpg" alt="review images">
                  </div>
                <div class="review__details">
                  <div class="review__info">
                    <h4><a href="#">Administrator</a></h4>
                      <ul class="rating">
                        <li><i class="zmdi zmdi-star"></i></li>
                        <li><i class="zmdi zmdi-star"></i></li>
                        <li><i class="zmdi zmdi-star"></i></li>
                        <li><i class="zmdi zmdi-star-half"></i></li>
                        <li><i class="zmdi zmdi-star-outline"></i></li>
                      </ul>
                    <div class="rating__send">
                      <a href="#"><i class="zmdi zmdi-mail-reply"></i></a>
                      <a href="#"><i class="zmdi zmdi-close"></i></a>
                    </div>
                  </div>
                  <div class="review__date">
                    <span>27 Dec, 2019</span>
                  </div>
                  <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer accumsan egestas elese ifend. Phasellus a felis at estei to bibendum feugiat ut eget eni Praesent et messages in con sectetur posuere dolor non.</p>
                </div>
              </div>
              <!-- End Single Review ADMIN ANSWER -->
          </div>
        <div class="rating__wrap">
          <h2 class="rating-title">Оставить отзыв</h2>
          <h4 class="rating-title-2">Ваша оценка</h4>
          <div class="rating__list">
            <ul class="rating">
              <li><i class="zmdi zmdi-star"></i></li>
            </ul>
            <ul class="rating">
              <li><i class="zmdi zmdi-star"></i></li>
              <li><i class="zmdi zmdi-star-half"></i></li>
            </ul>
            <ul class="rating">
              <li><i class="zmdi zmdi-star"></i></li>
              <li><i class="zmdi zmdi-star"></i></li>
              <li><i class="zmdi zmdi-star-half"></i></li>
            </ul>
            <ul class="rating">
              <li><i class="zmdi zmdi-star"></i></li>
              <li><i class="zmdi zmdi-star"></i></li>
              <li><i class="zmdi zmdi-star"></i></li>
              <li><i class="zmdi zmdi-star-half"></i></li>
            </ul>
            <ul class="rating">
              <li><i class="zmdi zmdi-star"></i></li>
              <li><i class="zmdi zmdi-star"></i></li>
              <li><i class="zmdi zmdi-star"></i></li>
              <li><i class="zmdi zmdi-star"></i></li>
              <li><i class="zmdi zmdi-star-half"></i></li>
            </ul>
          </div>
        </div>
          <div class="review__box">
            <form id="review-form">
              <div class="single-review-form">
                <div class="review-box name">
                  <input type="text" placeholder="Введите Ваше имя">
                  <input type="email" placeholder="Введите Ваш e-mail">
                </div>
              </div>
              <div class="single-review-form">
                <div class="review-box message">
                    <textarea placeholder="Ваш отзыв"></textarea>
                </div>
              </div>
              <div class="review-btn">
                <a class="fv-btn" href="#">Отправить</a>
              </div>
            </form>                                
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>';
        }
		
		if($URL[5] != ''){
			// Show product
            $r=mysql_query("
                SELECT * FROM `rce_catalog_items`
                WHERE `trans`='".$URL[5]."'
                AND `archive` ='0'
            ");
            $f=mysql_fetch_array($r);

            // 3 level
            $rc3 = mysql_query("
                SELECT * FROM `rce_catalog_cats`
                WHERE `trans` = '".$URL[3]."'
            ");
            $fc3 = mysql_fetch_array($rc3);
			
			// 4 level
            $rc4 = mysql_query("
                SELECT * FROM `rce_catalog_cats`
                WHERE `trans` = '".$URL[4]."'
            ");
            $fc4 = mysql_fetch_array($rc4);

			// Fetch current cat data
            $rc=mysql_query("
                SELECT * FROM `rce_catalog_cats`
                WHERE `trans`='".$f['cat']."'
            ");
            $fc=mysql_fetch_array($rc);
			
            // Speedbar
            $breadcrumb = '
<a class="breadcrumb-item" href="/">Главная</a>
<span class="brd-separetor">/</span>
<a class="breadcrumb-item" href="/catalog/">Каталог</a>    
<span class="brd-separetor">/</span>
<a class="breadcrumb-item" href="/catalog/cat/'.$fc3['root'].'/">'.$fc3['title'].'</a>
<span class="brd-separetor">/</span>
<a class="breadcrumb-item" href="/catalog/cat/'.$fc['root'].'/">'.$fc['title'].'</a>';
            $title = $f['title'];
            $meta_title=$f['meta_title'].' : '.$fc['meta_title'];
            // commit metakeywords     $meta_keys=$f['meta_keys'];
            $meta_desc=$f['meta_desc'];
			
            // Addon images
            $ri=mysql_query("
                SELECT * FROM `rce_catalog_images`
                WHERE `item`='".$f['ID']."'
                ORDER BY `ID` ASC
            ");
			$addon_images = '';
            for($i=0;$i<mysql_num_rows($ri);$i++){
                $fi=mysql_fetch_array($ri);
					$addon_images.='
						<a class="fancybox images-add" rel="group" href="/uploads/catalog/'.$fc['root'].'/'.$fi['image'].'" title="'.$f['title'].'">
							<img class="addon" src="/uploads/catalog/mini/'.$fi['image'].'" alt="image" />
						</a>
					';
            }
			
 // Price
  if ($f['price'] <= 0) {
    $price='<li>Нет в наличии</li>';
  } else if ($f['price_old'] > $f['price']) {
    $price='
    <li class="old__prize">'.$f['price_old'].' грн.</li>
    <li>'.$f['price'].' грн. / '.$f['pcs'].'</li>';
  } else {
    $price='<li>'.$f['price'].' грн. / '.$f['pcs'].'</li>';
  };
    
// Image block
  if ($f['image'] != '' && $f['image2'] != '' && $f['image3'] != '') {
    $images='
    <div class="scroll-single-product mb--30">
      <img src="/uploads/catalog/'.$f['image'].'" alt="'.$f['title'].'">
    </div>   
    <div class="scroll-single-product mb--30">
      <img src="/uploads/catalog/'.$f['image2'].'" alt="'.$f['title'].' фото">
    </div>    
    <div class="scroll-single-product mb--30">
      <img src="/uploads/catalog/'.$f['image3'].'" alt="'.$f['title'].' картинка">
    </div>';
  } else if ($f['image'] != '' && $f['image2'] != '') {
    $images='
    <div class="scroll-single-product mb--30">
      <img src="/uploads/catalog/'.$f['image'].'" alt="'.$f['title'].'">
    </div>    
    <div class="scroll-single-product mb--30">
      <img src="/uploads/catalog/'.$f['image2'].'" alt="'.$f['title'].' картинка">
    </div>';
  } else if ($f['image'] != '') {
    $images='    
    <div class="scroll-single-product mb--30">
      <img src="/uploads/catalog/'.$f['image'].'" alt="'.$f['title'].'">
    </div>';
  } else {
    $images='
    <div class="scroll-single-product mb--30">
      <img src="/template/images/logo/logo.png" alt="'.$f['title'].'">
    </div>';
  };
          
// Out
$content='
<div class="col-md-4 col-lg-4 col-sm-5 col-xs-12">
  <div class="product__details__container product-details-5">
  '.$images.'
  </div>
</div>
<div class="sidebar-active col-md-8 col-lg-8 col-sm-7 col-xs-12 xmt-30">
  <div class="htc__product__details__inner ">
    <div class="pro__detl__title">
      <h2>'.$f['title'].' (арт.&nbsp;'.$f['artno'].')</h2>
    </div>
    <div class="pro__dtl__rating">
      <ul class="pro__rating">
        '.$prodRating.'
      </ul>
    </div>
  <p class="rat__qun">Артикул товара: <b>'.$f['artno'].'</b></p>
  <p class="rat__qun">Наличие товара: '.$qtyStatus.'</p>
    </div>
    <div class="pro__details">
      <p>
      '.$f['short_descr'].'
      <p>
    </div>
    <ul class="pro__dtl__prize">
      '.$price.'
    </ul>
    <div class="product-action-wrap">
      <div class="prodict-statas"><span>Кол-во :</span></div>
      <div class="product-quantity">
        <form id="myform">
          <div class="product-quantity">
            <div class="cart-plus-minus">
              <label for="coun" hidden></label>
              <input class="cart-plus-minus-box" type="text" id="coun" data-item-id="'.$f['ID'].'" name="coun" value="1">
            </div>
          </div>
        </form>
      </div>
    </div>
    <ul class="pro__dtl__btn">
      <li class="buy__now__btn" data-item-id="'.$f['ID'].'">
        <a href="#">Купить</a>
      </li>
      <li><a href="#"><span class="ti-email"></span></a></li>
    </ul>
    <div class="pro__social__share">
      <h2>Заходи к нам:</h2>
      <ul class="pro__soaial__link">
        <li><a href="https://www.instagram.com/_eurostroy_/" target="_blank"><i class="zmdi zmdi-instagram"></i></a></li>
        <li><a href="https://www.facebook.com/eurostroy.ck/" target="_blank"><i class="zmdi zmdi-facebook"></i></a></li>
        <li><a href="viber://chat?number=+380939099915" title="Viber"><i class="zmdi zmdi-vimeo"></i></a></li>
      </ul>
    </div>
  </div>
</div>
';
        
  $pageDescr='
<section class="htc__product__details__tab bg__white pb--120">
  <div class="container">
    <div class="row">
      <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
        <ul class="product__deatils__tab mb--60" role="tablist">
          <li role="presentation" class="active">
            <a href="#description" role="tab" data-toggle="tab">Описание</a>
          </li>
          <li role="presentation">
            <a href="#sheet" role="tab" data-toggle="tab">Другие товары</a>
          </li>
          <li role="presentation">
            <a href="#reviews" role="tab" data-toggle="tab">Отзывы (в разработке)</a>
          </li>
        </ul>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="product__details__tab__content">
          <div role="tabpanel" id="description" class="product__tab__content fade in active">
            <div class="product__description__wrap">
              <div class="product__desc">
                <h2 class="title__6">Описание</h2>
                <p>
                  '.$f['text'].'
                </p>
              </div>
            </div>
          </div>
          <div role="tabpanel" id="sheet" class="product__tab__content fade">
            <div class="pro__feature">
              <h2 class="title__6">Популярные товары</h2>
                {randProd}
            </div>
          </div>
          
          <div role="tabpanel" id="reviews" class="product__tab__content fade">
            <div class="review__address__inner">
              <div class="pro__review">
                <div class="review__thumb">
                  <img src="/template/images/review/1.jpg" alt="review images">
                </div>
                <div class="review__details">
                  <div class="review__info">
                      <h4><a href="#">Customer (TEST INFO)</a></h4>
                      <ul class="rating">
                          <li><i class="zmdi zmdi-star"></i></li>
                          <li><i class="zmdi zmdi-star"></i></li>
                          <li><i class="zmdi zmdi-star"></i></li>
                          <li><i class="zmdi zmdi-star-half"></i></li>
                          <li><i class="zmdi zmdi-star-outline"></i></li>
                      </ul>
                      <div class="rating__send">
                          <a href="#"><i class="zmdi zmdi-mail-reply"></i></a>
                          <a href="#"><i class="zmdi zmdi-close"></i></a>
                      </div>
                  </div>
                  <div class="review__date">
                      <span>25 Dec, 2019</span>
                  </div>
                  <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer accumsan egestas elese ifend. Phasellus a felis at estei to bibendum feugiat ut eget eni Praesent et messages in con sectetur posuere dolor non.</p>
              </div>
            </div>
            <!-- Start Single Review ADMIN ANSWER -->
                <div class="pro__review ans">
                  <div class="review__thumb">
                    <img src="/template/images/review/1.jpg" alt="review images">
                  </div>
                <div class="review__details">
                  <div class="review__info">
                    <h4><a href="#">Administrator</a></h4>
                      <ul class="rating">
                        <li><i class="zmdi zmdi-star"></i></li>
                        <li><i class="zmdi zmdi-star"></i></li>
                        <li><i class="zmdi zmdi-star"></i></li>
                        <li><i class="zmdi zmdi-star-half"></i></li>
                        <li><i class="zmdi zmdi-star-outline"></i></li>
                      </ul>
                    <div class="rating__send">
                      <a href="#"><i class="zmdi zmdi-mail-reply"></i></a>
                      <a href="#"><i class="zmdi zmdi-close"></i></a>
                    </div>
                  </div>
                  <div class="review__date">
                    <span>27 Dec, 2019</span>
                  </div>
                  <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer accumsan egestas elese ifend. Phasellus a felis at estei to bibendum feugiat ut eget eni Praesent et messages in con sectetur posuere dolor non.</p>
                </div>
              </div>
              <!-- End Single Review ADMIN ANSWER -->
          </div>
        <div class="rating__wrap">
          <h2 class="rating-title">Оставить отзыв</h2>
          <h4 class="rating-title-2">Ваша оценка</h4>
          <div class="rating__list">
            <ul class="rating">
              <li><i class="zmdi zmdi-star"></i></li>
            </ul>
            <ul class="rating">
              <li><i class="zmdi zmdi-star"></i></li>
              <li><i class="zmdi zmdi-star-half"></i></li>
            </ul>
            <ul class="rating">
              <li><i class="zmdi zmdi-star"></i></li>
              <li><i class="zmdi zmdi-star"></i></li>
              <li><i class="zmdi zmdi-star-half"></i></li>
            </ul>
            <ul class="rating">
              <li><i class="zmdi zmdi-star"></i></li>
              <li><i class="zmdi zmdi-star"></i></li>
              <li><i class="zmdi zmdi-star"></i></li>
              <li><i class="zmdi zmdi-star-half"></i></li>
            </ul>
            <ul class="rating">
              <li><i class="zmdi zmdi-star"></i></li>
              <li><i class="zmdi zmdi-star"></i></li>
              <li><i class="zmdi zmdi-star"></i></li>
              <li><i class="zmdi zmdi-star"></i></li>
              <li><i class="zmdi zmdi-star-half"></i></li>
            </ul>
          </div>
        </div>
          <div class="review__box">
            <form id="review-form">
              <div class="single-review-form">
                <div class="review-box name">
                  <input type="text" placeholder="Введите Ваше имя">
                  <input type="email" placeholder="Введите Ваш e-mail">
                </div>
              </div>
              <div class="single-review-form">
                <div class="review-box message">
                    <textarea placeholder="Ваш отзыв"></textarea>
                </div>
              </div>
              <div class="review-btn">
                <a class="fv-btn" href="#">Отправить</a>
              </div>
            </form>                                
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>';
		}


    } else { // If normal prod
        $title = 'Error code 371';
    }

} elseif($URL[1]=='search'){
    // Headers
    $search=rawurldecode($URL[2]);
    $title='Поиск по запросу: '.$search;
    $meta_title='Поиск по запросу: '.$search;
    // Show prod by brand
    $rp=mysql_query("
        SELECT * FROM `rce_catalog_items`
        WHERE `searchText` LIKE '%".$search."%' 
        OR `title` LIKE '%".$search."%' 
        OR `manuf` LIKE '%".$search."%' 
        OR `artno` LIKE '%".$search."%' 
        ORDER BY `manuf` ASC
        LIMIT 42
    ");

    if(mysql_num_rows($rp)>'0'){
        // Have items
        // List
        for($i=0;$i<mysql_num_rows($rp);$i++){
            $fp=mysql_fetch_array($rp);
            // Get parent cat
            $rc=mysql_query("
				SELECT * FROM `rce_catalog_cats`
				WHERE `trans`='".$fp['cat']."'
			");
      $fc=mysql_fetch_array($rc);
      //price format
      if ($fp['price'] <= '0') {
        $price='<li class="new__price">Нет в наличии.</li>';
      } else if ($fp['price_old'] > $fp['price']) {
        $price='
  <li class="old__price">'.$fp['price_old'].' грн.</li>
  <li class="new__price">'.$fp['price'].' грн.</li>';
      } else {
        $price='
  <li class="new__price">'.$fp['price'].' грн.</li>';
      };   
      // Content
            $content.='
            
<div class="col-md-3 col-lg-3 col-sm-3 col-xs-6">
  <div class="product">
    <div class="product__inner">
      <div class="pro__thumb">
        <a href="/catalog/item/'.$fc['root'].'/'.$fp['trans'].'">
          <img src="/uploads/catalog/'.$fp['image'].'" alt="'.$fp['title'].'">
        </a>
      </div>
      <div class="product__hover__info">
        <ul class="product__action">
          <li><a title="На страницу товара" class="quick-view modal-view detail-link" href="/catalog/item/'.$fc['root'].'/'.$fp['trans'].'"><span class=" ti-eye"></span></a></li>
          <li><a title="Добавить в корзину" href="#"><span class="ti-shopping-cart"></span></a></li>
          <!--
            <li><a title="Wishlist" href="wishlist.html"><span class="ti-heart"></span></a></li>
          -->
        </ul>
      </div>
    </div>
    <div class="product__details">
      <h2><a href="/catalog/item/'.$fc['root'].'/'.$fp['trans'].'">'.$fp['title'].'</a></h2>
      <ul class="product__price">
        '.$price.'          
      </ul>
    </div>
  </div>
</div>';
      }

    } else {
        // No items
        $content='
<p class="product-info__search">Извините, но по данному запросу: <span>'.$search.',</span> ничего не найдено</p>
<div>
  {randProd}
</div>'      
;
      
    }
}
?>