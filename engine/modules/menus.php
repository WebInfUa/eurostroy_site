<?
// Menus

// Logo
$logo = '<img class="logo__img" src="/template/images/logo/logo.png" alt="Еврострой логотип" aria-label="">';

//Categories list
$r=mysql_query("SELECT * FROM `rce_catalog_cats` WHERE `parent`='' ORDER BY `ID` ASC");
for($i=0;$i<mysql_num_rows($r);$i++){
	$f=mysql_fetch_array($r);
$cats.='<li><a href="/catalog/cat/'.$f['root'].'">'.$f['title'].'</a></li>';
}

//Top menu
$r=mysql_query("SELECT * FROM `rce_pages` ORDER BY `pageID` ASC");
for($i=0;$i<mysql_num_rows($r);$i++){
	$f=mysql_fetch_array($r);
  if ($f['type']=='' && $f['pageHide'] <= 4 ) {
  $topMenu.='<li><a href="/'.$f['trans'].'">'.$f['title'].'</a></li>';
  }
  if ($f['type']!=='') {
  $calcMenu.='<li><a href="/'.$f['trans'].'">'.$f['title'].'</a></li>';
  }
}




// SubCat List
$r=mysql_query("SELECT * FROM `rce_catalog_cats` WHERE `parent`='' ORDER BY `catID` ASC");
$c=mysql_query("SELECT * FROM `rce_catalog_cats` WHERE `parent`!='' ORDER BY `catID` ASC");
for($i=0;$i<mysql_num_rows($r);$i++){
$f=mysql_fetch_array($r);  
$g=mysql_fetch_array($c);
 $subCatList.='<li><a href="/catalog/cat/'.$g['trans'].'">'.$g['title'].'</a></li>';

$catList.='
<li>
  <a href="/catalog/cat/'.$f['trans'].'"><img alt="" src="/template/images/icons/catLogo1.png">'.$f['title'].' <i class="zmdi zmdi-chevron-right"></i>
  </a>

 <!--


https://www.youtube.com/watch?v=Ifei4zm7DBE


<div class="category-menu-dropdown">
  <div class="category-menu-dropdown-top">
    <div class="category-part-1 category-common2 mb--30">
      <h4 class="categories-subtitle"> Un cat 1</h4>
      <ul>
        '.$subCatList.'
      </ul>
    </div>
    <div class="category-part-2 category-common2 mb--30">
      <h4 class="categories-subtitle"> Un cat 2</h4>
      <ul>
        '.$subCatList.'
      </ul>
    </div>
    <div class="category-part-3 category-common2 mb--30">
      <h4 class="categories-subtitle"> Un Cat 3</h4>
      <ul>
        '.$subCatList.'
      </ul>
    </div>
  </div>
    <div class="category-menu-dropdown-bottom">
      <div class="single-category-brand">
        <a href="#"><img src="/template/images/brand/6.png" alt=""></a>
      </div>
      <div class="single-category-brand">
        <a href="#"><img src="/template/images/brand/7.png" alt=""></a>
      </div>
      <div class="single-category-brand">
        <a href="#"><img src="/template/images/brand/8.png" alt=""></a>
      </div>
      <div class="single-category-brand">
        <a href="#"><img src="/template/images/brand/9.png" alt=""></a>
      </div>
    </div>
  </div>
  
  -->

</li>
  ';
}

// Random product list
$r=mysql_query("SELECT * FROM `rce_catalog_items` WHERE `fav`!='' AND `price`>0 ORDER BY RAND() LIMIT 12");
for($i=0;$i<mysql_num_rows($r);$i++){
$f=mysql_fetch_array($r);
$r2=mysql_query("SELECT * FROM `rce_catalog_cats` WHERE `trans`='".$f['cat']."'");
$f2=mysql_fetch_array($r2);
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

$randProd.='
<div class="col-md-3 col-lg-3 col-sm-3 col-xs-12">
  <div class="product">
    <div class="product__inner">
      <div class="pro__thumb">
        <a href="/catalog/item/'.$f2['root'].'/'.$f['trans'].'">
          <img src="/uploads/catalog/mini/'.$f['image'].'" alt="'.$f['title'].'">
        </a>
      </div>
      <div class="product__hover__info">
        <ul class="product__action">
          <li><a title="На страницу товара" class="quick-view modal-view detail-link" href="/catalog/item/'.$f2['root'].'/'.$f['trans'].'"><span class=" ti-eye"></span></a></li>
          <li><a title="Добавить в корзину" href="#"><span class="ti-shopping-cart"></span></a></li>
          <!--
            <li><a title="Wishlist" href="wishlist.html"><span class="ti-heart"></span></a></li>
          -->
        </ul>
      </div>
    </div>
    <div class="product__details">
      <h2><a href="/catalog/item/'.$f2['root'].'/'.$f['trans'].'">'.$f['title'].'</a></h2>
      '.$price.'          
    </div>
  </div>
</div>';
}

//Cart count in header
$qw=mysql_query("
    SELECT * FROM `rce_cart` WHERE `sess`='".$_SESSION['sess']."'
");
$qty_prod_cart = mysql_num_rows($qw);
if ($qty_prod_cart == 0) {
  $qty_prod_cart='';
};

$cart_icon = '
<li class="cart__menu">
  <span class="ti-shopping-cart">'.$qty_prod_cart.'</span>
</li>';


 
$r=mysql_query("
    SELECT * FROM `rce_cart`
    WHERE `sess`='".$_SESSION['sess']."'
    ORDER BY `ID` ASC
");

if(mysql_num_rows($r)>'0'){
  $sum2=0;
  $count=0;
  if ($count == 0) {
    $count='';
  };
  for($i=0;$i<mysql_num_rows($r);$i++){
    $f=mysql_fetch_array($r);
    $cart=mysql_query("SELECT * FROM `rce_catalog_items` WHERE `trans`='".$f['trans']."'");
    $cartList=mysql_fetch_array($cart);
    $c1=mysql_query("SELECT * FROM `rce_catalog_cats` WHERE `trans`='".$cartList['cat']."'");
    $cat=mysql_fetch_array($c1);
    $c=$i+1;
    $sum2=$sum2+$f['price']*$f['quantity'];
    $count=$count+$f['quantity'];

  $cartTopItem.='
<div class="shp__single__product">
  <div class="shp__pro__thumb">
    <a href="/catalog/item/'.$cat['root'].'/'.$f['trans'].'">
      <img src="/uploads/catalog/mini/'.$cartList['image'].'" alt="'.$f['title'].'" alt="product images">
    </a>
  </div>
  <div class="shp__pro__details">
    <h2><a href="/catalog/item/'.$cat['root'].'/'.$f['trans'].'">'.$f['title'].'</a></h2>
    <span class="quantity">Кол-во: '.$f['quantity'].' </span>
    <span class="shp__price">'.$f['price'].' </span>
  </div>
  <!--
  <div class="remove__btn">
    <form id="delete_prod_'.$f['ID'].'" action="" method="post">
      <input type="hidden" name="IDitem" value="'.$f['ID'].'">
      <input type="submit" name="delete" value="X"/>
    </form>
  </div>
  -->
</div>
  ';
  }
  if(isset($_POST['delete'])) {
      mysql_query("DELETE FROM `rce_cart` WHERE `ID`='".$_POST['IDitem']."' AND `sess`='".$_SESSION['sess']."'");
      header("Location: /cart/");
  }
}


  $r=mysql_query("SELECT * FROM `rce_news_list` ORDER BY `date` DESC LIMIT 3");
	for($i=0;$i<mysql_num_rows($r);$i++){
  $f=mysql_fetch_array($r);
  $text=mb_substr(strip_tags($f['text']),0,70);
  $date = rce_sep_date($f['date']);

    $lastNews.='
<div class="single-recent-post">
  <div class="recent-thumb">
    <a href="/news/'.$f['trans'].'"><img src="/uploads/news/'.$f['image'].'" alt="'.$f['title'].'"></a>
  </div>
  <div class="recent-details">
    <div class="recent-post-dtl">
      <h6><a href="/news/'.$f['trans'].'">'.$text.'...</a></h6>
    </div>
    <div class="recent-post-time">
      <p>'.$date[0].'</p>
      <p class="separator">|</p>
      <p>'.$date[1].'</p>
    </div>
  </div>
</div>';
  }

?>