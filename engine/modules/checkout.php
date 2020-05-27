<?
// Cart
$title='Оформление заказа';
$breadcrumb = '
<a class="breadcrumb-item" href="/">Главная</a>
<span class="brd-separetor">/</span>
<a class="breadcrumb-item" href="/cart/">Корзина</a>
<span class="brd-separetor">/</span>
<span class="breadcrumb-item active">Заказ</span>
';
$meta_title='Форма заказа товаров Еврострой';
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

  $l.='Товар: '.$f['title'].' - Колл.: '.$f['quantity'].' - Цена: '.$f['price'].'<br/> ';
  $sum=$sum+$f['quantity']*$f['price'];
  $count=$count+$f['quantity'];
  $list.='
  <li class="itemTitle">'.$f['title'].'</li>
  <li class="quantity">'.$f['quantity'].'</li>
';

}
  
$out_sell='
<ul>
  '.$list.'
</ul>
<p id="sum2">'.$sum.'</p>
<p id="col2">'.$count.'</p>
';
    $content='
      <div class="col-md-8 col-lg-8">
        <div id="orderConfirm" class="ckeckout-left-sidebar">
          <!-- Start Checkbox Area -->
          <div id="titleForm" class="checkout-form">
            <h2 class="section-title-3">Форма для заказа</h2>
            <div class="checkout-form-inner">
              <div class="single-checkout-box">
                <input id="firstName" type="text" placeholder="Имя*" required/>
                <input id="secondName" type="text" placeholder="Фамилия"/>
              </div>
              <div class="single-checkout-box">
                <input id="email" type="email" placeholder="E-mail"/>
                <input id="phone" type="tel" placeholder="Телефон*" required/>
              </div>
              <div class="single-checkout-box">
                <textarea id="text" name="message" placeholder="Ваш коментарий к заказу"></textarea>
              </div>
            </div>
            
            <div class="d-none">
              '.$out_sell.'
            </div>
            
          </div>
          <!-- End Checkbox Area -->
          <!-- Start Payment Box -->
          <div class="payment-form">
            <p class="section-title-3">Сумма заказа: '.$sum.' грн.</p>
          </div>
          <div class="payment-form">
            <h2 class="section-title-3">Форма оплаты</h2>
            <p>База строительных материалов Еврострой, принимает всевозможные формы оплаты. </p>
            <div class="payment-form-inner">
              <div class="single-checkout-box select-option">
                <select id="paysType">
                  <option value="cash_pay">Наличными (в магазине Еврострой)</option>
                  <option value="cod_pay">Наложеный платеж</option>
                  <option value="cashless_pay">Безналичный рассчет</option>
                  <option value="other_pay">Другая форма оплаты (уточнить у менеджера)</option>
                </select>
              </div>
              <div id="payment-details" class="payment-form d-none">
                <h2 class="section-title-3">Реквизиты и детали для оплаты</h2>
                <h5 class="copy__title">Для оплаты по безналичному рассчету Вам необходимо оплатить заказ на указаные реквизиты Еврострой.</h5>
                <h5 class="copy__title">В назначении платежа укажите: <strong>ОПЛАТА ИНТЕРНЕТ ЗАКАЗА</strong></h5>
                <h5 class="copy__title">Вы можете осуществить оплату через платежный терминал, мобильный банкинг или в любом отделении банка, зарегистрированного на территории Украины</h5>
                <p class="copy__text">
                  ЕГРПОУ: <strong id="edrpou">2874007087</strong> 
                  <button class="copy__btn" onclick="copyText(`#edrpou`, `#copy-mes1`)">Копировать ЕГРПОУ</button>
                  <span id="copy-mes1" class="copy__message d-none">Вы скопировали ЕГРПОУ</span>
                </p>
                <p class="copy__text">
                  № счета: <strong id="invoic">26004060191172</strong> 
                  <button class="copy__btn" onclick="copyText(`#invoic`, `#copy-mes2`)">Копировать счет</button>
                  <span id="copy-mes2" class="copy__message d-none">Вы скопировали № счёта</span>
                </p>
                <p class="copy__text">
                  МФО: <strong id="mfo">354347</strong>
                  <button class="copy__btn" onclick="copyText(`#mfo`, `#copy-mes3`)">Копировать МФО</button>
                  <span id="copy-mes3" class="copy__message d-none">Вы скопировали МФО</span>
                </p>
                <p class="copy__message">Обратите внимание, что клиент берет на себя все расходы (комисии, проценты и т.д.) по переводу денежных средств. Также Вам нужно сохранять чек до момента получения товара. В некоторых случаях администрация интернет магазина может запросить копию плетежного документа.</p>
              </div>
            </div>
          </div>
          <!-- End Payment Box -->
          <!-- Start ORDER BTN -->
          <div class="our-payment-sestem">
            <div class="wc-proceed-to-checkout">
              <button id="orderForm" type="button">Подтвердить и оформить заказ</button>
            </div>
          </div>
          
          <div class="form-output">
              <p class="form-messege"></p>
          </div>
            <!-- End ORDER BTN -->
        </div>
      </div>
      <div class="col-md-4 col-lg-4">
        <div class="checkout-right-sidebar">
          <div class="our-important-note">
            <h2 class="section-title-3">Инфо:</h2>
            <p class="note-desc">Еврострой - это компания с многолетним опытом готова помочь вам решить все вопросы касательно ремонта и строительства любой сложности.</p>
            <ul class="important-note">
              {topMenu}
            </ul>
          </div>
          <div class="puick-contact-area mt--60">
            <h2 class="section-title-3">Звоните нам</h2>
            <p><a href="callto:+380939099915">+38 (093) 909 99 15</a></p>
          </div>
        </div>
      </div>
    ';
  
} else {
    $content='
    <p class="product-info__search">Похоже, что нечего оформлять. Сначала нужно добавить товары в корзину!</p>
    <p class="product-info__search"><span>Рекомендуем вам:</span></p>
    <div>
      {randProd}
    </div>
    ';
}

?>