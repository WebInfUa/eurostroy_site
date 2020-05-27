<?
// Cart
$title='Корзина товаров';
$breadcrumb = '
<a class="breadcrumb-item" href="/">Главная</a>
<span class="brd-separetor">/</span>
<span class="breadcrumb-item active">Корзина</span>
';
$meta_title='Корзина интернет заказов Еврострой';
// Get cart list
$r=mysql_query("
    SELECT * FROM `rce_cart`
    WHERE `sess`='".$_SESSION['sess']."'
    ORDER BY `ID` ASC
");

if(mysql_num_rows($r)>'0'){
    // If have something in the cart
    $sum=0;
    $sum_count=0;
    for($i=0;$i<mysql_num_rows($r);$i++){
        $f=mysql_fetch_array($r);
        $cart=mysql_query("SELECT * FROM `rce_catalog_items` WHERE `trans`='".$f['trans']."'");
        $cartList=mysql_fetch_array($cart);
        $c1=mysql_query("SELECT * FROM `rce_catalog_cats` WHERE `trans`='".$cartList['cat']."'");
        $cat=mysql_fetch_array($c1);
        $qw="DELETE FROM `rce_cart` WHERE `ID`='".$f['ID']."' AND `sess`='".$_SESSION['sess']."'";
            $c=$i+1;
            $summ=$f['quantity'] * $f['price'];
            $cart_list.= '
<tr>
  <td class="product-thumbnail">
    <a href="/catalog/item/'.$cat['root'].'/'.$f['trans'].'">
      <img src="/uploads/catalog/mini/'.$cartList['image'].'" alt="'.$f['title'].'" />
    </a>
  </td>
  <td class="product-name">
    <a href="/catalog/item/'.$cat['root'].'/'.$f['trans'].'" data-item-id="'.$f['ID'].'">
      '.$f['title'].'
    </a>
  </td>
  <td class="product-price">
    <span class="amount">₴'.$f['price'].'</span>
  </td>
  <td class="product-quantity">
    <input class="prod_qty_cart" data-item-id="'.$f['ID'].'" type="number" value="'.$f['quantity'].'" min="0" max="999"/>
  </td>
  <td class="product-subtotal">₴'.$summ.'</td>
  <td class="product-remove">
    <form class="product__form" action="" method="post">
      <input type="hidden" name="IDitem" value="'.$f['ID'].'">
      <input type="submit" name="delete" value="X" />
    </form>
  </td>
</tr>
';
      
  $l.='Товар: '.$f['title'].' - Колл.: '.$f['quantity'].' - Цена: '.$f['price'].'<br/> ';
  $sum=$sum+$f['quantity']*$f['price'];
  $count=$count+$f['quantity'];
    
    }
    $content='
<div class="table-content table-responsive">
  <table>
    <thead>
      <tr>
        <th class="product-thumbnail">Фото</th>
        <th class="product-name">Продукт</th>
        <th class="product-price">Цена</th>
        <th class="product-quantity">Количество</th>
        <th class="product-subtotal">Сумма</th>
        <th class="product-remove">Удалить</th>
      </tr>
    </thead>
    <tbody>
      '.$cart_list.'
    </tbody>
  </table>
</div>
<div class="row">
  <div class="col-md-8 col-sm-7 col-xs-12">
      <div class="buttons-cart">
        <form action="#" method="post">
          <input type="submit" name="deleteAll" value="Очистить корзину" />
        </form>
        <a href="/catalog/">Продолжить покупки</a>
      </div>
    <div class="coupon">
      <h3>Купон на скидку</h3>
      <p>Введите свой купон на скидку.</p>
      <input type="text" placeholder="Код купона" />
      <input  type="submit" value="Добавить купон" />
    </div>
  </div>
  <div class="col-md-4 col-sm-5 col-xs-12">
    <div class="cart_totals">
      <h2>Ваш Заказ:</h2>
        <table>
          <tbody>
          <form action"" method="post">
            <tr class="cart-subtotal">
              <th>Сумма заказа</th>
              <td><span class="amount">'.$sum.' грн.</span></td>
            </tr>
            <tr class="cart-subtotal">
              <th>Товаров в корзине</th>
              <td><span class="amount">'.$count.' шт.</span></td>
            </tr>
            <tr class="shipping">
              <th>Доставка</th>
              <td>
                <ul id="shipping_method">
                  <li>
                    <label for="self_ship">Самовывоз: <span class="amount">(бесплатно)</span></label>
                    <input id="self_ship" name="shiping_type" value="self_ship" type="radio" checked/> 
                  </li>
                  <li>
                    <label for="nova_poshta">Новой почтой:<span class="amount">*</span></label>
                    <input id="nova_poshta" name="shiping_type" value="nova_poshta" type="radio"/> 
                  </li>
                  <li>
                    <label for="company_ship">Транспорт компании:<span class="amount">*</span></label>
                    <input id="company_ship" name="shiping_type" value="company_ship" type="radio"/> 
                  </li>
                </ul>
                <p><a class="shipping-calculator-button" href="/33-Oplata_i_dostavka/">Доставка и оплата</a></p>
              </td>
            </tr>
            <tr class="order-total">
              <th>Сумма заказа</th>
              <td>
                <strong><span class="amount">'.$sum.'  грн. <span id="shiping_status" class="d-none">+ доставка</span></span></strong>
              </td>
            </tr>
          </form>
          </tbody>
        </table>
        <div id="shiping_address" class="d-none shipping__address">
          <h3>Введите адрес доставки</h3>
          <ul>
            <li>
              <label for="city_ship" hidden>Населенный пункт:</label>
              <input id="city_ship" name="shiping_city" placeholder="Введите область и населенный пункт" type="text"/> 
            </li>
            <li>
              <label for="region_ship"hidden>Улица или номер отделения:</label>
              <input id="region_ship" name="shiping_region" placeholder="Введите улицу или № отделения доставки" type="text"/> 
            </li>
            <li>
              <label for="build_ship" hidden>Введите номер и корпус дома:</label>
              <input id="build_ship" name="shiping_build" placeholder="Введите номер дома" type="text"/> 
            </li>
            <li>
              <label for="apart_ship" hidden>Введите номер квартиры:</label>
              <input id="apart_ship" name="shiping_apart" placeholder="Введите номер квартиры" type="text"/> 
            </li>
          </ul>
        </div>
      <p>* - Сумма заказа может увеличится на сумму доставки.</p>
        <div class="wc-proceed-to-checkout">
          <a id="form-send" href="/checkout/">Оформить заказ</a>
        </div>
      </div>
    </div>
  </div>
    ';
  
  
    if(isset($_POST['delete'])) {
        mysql_query("DELETE FROM `rce_cart` WHERE `ID`='".$_POST['IDitem']."' AND `sess`='".$_SESSION['sess']."'");
        header("Location: /cart/");
    }
    if(isset($_POST['recount_cart'])) {
        mysql_query("UPDATE `rce_cart` SET quantity='".$f['quantity']."' WHERE `ID`='".$_POST['IDitem']."' AND `sess`='".$_SESSION['sess']."'");
        header("Location: /cart/");
    }
    if(isset($_POST['deleteAll'])) {
        mysql_query("DELETE FROM `rce_cart` WHERE `sess`='".$_SESSION['sess']."'");
        header("Location: /cart/");
    }

} else {
  $content='
    <p class="product-info__search">Похоже, что ваша корзина пуста. </p>
    <p class="product-info__search">Добавьте товары в корзину!</p>
    <p class="product-info__search"><span>Рекомендуем вам:</span></p>
    <div>
      {randProd}
    </div>';
  }

?>