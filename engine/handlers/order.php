<?php
/**
 * Created by PhpStorm.
 * User: krch_Vova
 * Date: 19.01.2016
 * Time: 15:18
 */
// Feedback form
session_start();
define('RCE','V5');
require_once("../inc/db.php");
require_once("../classes/class.phpmailer.php");

$r=mysql_query("
    SELECT * FROM `rce_cart`
    WHERE `sess`='".$_SESSION['sess']."'
    ORDER BY `ID` ASC
");
if(mysql_num_rows($r)>'0') {
    // If have something in the cart
    $sum = 0;
    $sum_count = 0;
    for ($i = 0; $i < mysql_num_rows($r); $i++) {
        $f = mysql_fetch_array($r);
        $l .= '<li>Товар: ' . $f['title'] . ' - Колл.: ' . $f['quantity'] . ' - Цена: ' . $f['price'] . '</li> ';
        $sum = $sum + $f['quantity'] * $f['price'];
        $count = $count + $f['quantity'];
        $deliveryType = $f['delivery'];
        $cityDeliv = $f['city'];
        $streetDeliv = $f['street'];
        $homeDeliv = $f['home'];
        $appartmentDeliv = $f['appartment'];
    }

}

if ($cityDeliv != '') {
  $city = 'Населенный пункт: '.$cityDeliv.'<br/>';
} else {
  $city = '';
}

if ($streetDeliv != '') {
  $street = 'Улица или № отделения доставки: '.$streetDeliv.'<br/>';
} else {
  $street = '';
}

if ($homeDeliv != '') {
  $home = 'Номер дома: '.$homeDeliv.'<br/>';
} else {
  $home = '';
}

if ($appartmentDeliv != '') {
  $appartment = 'Номер квартиры или офиса: '.$appartmentDeliv.'<br/>';
} else {
  $appartment = '';
}

$orderNum = date("mdY H:i");

// GET DATA
$name=$_POST['name'];
$secondName=$_POST['secondName'];
$email=$_POST['email'];
$phone=$_POST['phone'];
$text=$_POST['text'];
$paysType=$_POST['paysType'];
$itemTitle=$_POST['itemTitle'];
$quantity=$_POST['quantity'];
$sum2=$_POST['sum2'];
$col2=$_POST['col2'];

// Send mail Admin
$forAdmin='
 <div style="width: 95%; max-width: 750px; background-color: rgba(0, 0, 0, 0.1); padding: 10px; border-radius: 20px; margin: 0 auto">
    <div style="display: flex; flex-direction: row; margin: 0 auto; flex-wrap: wrap; justify-content: center; align-items: center;">
        <div style="max-width: 250px; margin: 0 auto">
          <a href="https://bud-komplekt.com.ua/" title="Сайт Еврострой" target="_blank">
            <img src="https://bud-komplekt.com.ua/template/images/logo/logo.png" width="100%" align="left">
          </a>    
        </div>
        <div style="margin: 0 auto;">
          <h3 style="text-align: left; text-transform: uppercase;">
            Заказ с сайта! №'.$orderNum.'<br />
            на суму: '.$sum2.'; <br />
            от: '.$name.'
          </h3>
        </div>
    </div>
    <hr color="#000">
    <div>
      <h4 style="text-transform: uppercase; text-align: center" >Контактная информация</h4>
      <ul style="font-size: 14px;">
        <li><b>Имя заказчика: </b>'.$name.'</li>
        <li><b>E-mail: </b>'.$email.'</li>
        <li><b>Контактный телефон: </b>'.$phone.'</li>
        <li><b>Комментарий к заказу: </b>'.$text.'</li>
      </ul>
    </div>
    <hr color="#e41b41" size="4px">
    <div>
      <h3 style="text-align: center; text-transform: uppercase; color: #e41b41; box-shadow: 2px 2px 4px 4px rgba(0, 0, 0, 0.5); background-color:#303030; padding: 10px;">Список товаров и сумма заказа:</h3>
      <p style="text-align: left; font-size: 14px;">
        <b>Список товаров:</b>
        <ul>
          '.$l.'
        <ul>
      </p>
      <p style="text-align: left; font-size: 14px; font-weight: bold; color: rgba(0, 0, 0, 0.8);">
        Тип оплаты: '.$paysType.'<br/>
      </p>
      <p style="text-align: left; font-size: 14px; font-weight: bold; color: rgba(0, 0, 0, 0.8);">
        Тип доставки: '.$deliveryType.'<br/>
      </p>
      <p style="text-align: left; font-size: 14px; font-weight: bold; color: rgba(0, 0, 0, 0.8);">
        Подробности доставки: <br/>'.$city.''.$street.''.$home.''.$appartment.'
      </p>
      <p style="text-align: left; font-size: 14px; font-weight: bold; color: rgba(0, 0, 0, 0.8);">
        Общее количество товара в заказе: '.$col2.'<br/>
      </p>
      <p style="text-align: left; text-transform: uppercase; font-size: 18px; font-weight: bold; color: #e41b41;">
        Сумма заказа: '.$sum2.'
      </p>
    </div>
    <hr color="#e41b41" size="4px">
      <div style="font-size: 10px; width: 90%; margin: auto; ">
        <div style="margin: 0 auto; text-align: center;">
          <div style="display: inline-block; margin: 10px auto; max-width: 250px; text-align: center">
            <a href="https://bud-komplekt.com.ua" target="_blank">
              <img src="https://bud-komplekt.com.ua/template/images/logo/logo.png" title="Сайт Еврострой" width="90%">
            </a>
          </div>
          <div style="display: inline-block; margin: 10px auto; text-align: center;">
           <p style="margin: 5px;">
            Тел:
            <a href="tel:+380939099915" title="Отдел интернет продаж Еврострой">+38 (093) 90-99-915</a>
           </p>
           <p style="margin: 5px;">
            г. Черкассы, ул. Хоменка 17
           </p>
           <p style="margin: 5px;">
            <a href="mailto:evrostroy.ukraine@gmail.com" title="Отправить письмо на evrostroy.ukraine@gmail.com">Отправить e-mail</a>
           </p>           
          </div>

          <div style="display: inline-block; margin: 10px auto;">
            <ul style="margin: 5px; padding: 10px; text-align: left">
                <span style="font-size: 12px; font-weight: bold;">График работы</span>
                <li>Пн-Пт: <span style="font-weight: bold">8:00-18:00</span></li>
                <li>Сб: <span style="font-weight: bold">8:00-15:00</span></li>
                <li>Вс: <span style="font-weight: bold">выходной</span></li>
            </ul>
          </div>
        </div>
      </div>
  </div>

';

// Send mail Customer
$forBuyer='

  <div style="width: 95%; max-width: 750px; background-color: rgba(0, 0, 0, 0.1); padding: 10px; border-radius: 20px; margin: 0 auto">
    <div style="display: flex; flex-direction: row; margin: 0 auto; flex-wrap: wrap; justify-content: center; align-items: center;">
        <div style="max-width: 250px; margin: 0 auto">
          <a href="https://bud-komplekt.com.ua/" title="Сайт Еврострой" target="_blank">
            <img src="https://bud-komplekt.com.ua/template/images/logo/logo.png" width="100%" align="left">
          </a>    
        </div>
        <div style="margin: 0 auto;">
          <h3 style="text-align: center; text-transform: uppercase;">
            Ваш заказ на сайте ЕВРОСТРОЙ! <br />
            №'.$orderNum.'
          </h3>
        </div>
    </div>
    <hr color="#000">
    <div>
      <h4 style="text-align: center" >Еврострой приветствует Вас <br />
        <span style="font-weight: bold; text-transform: uppercase;">'.$name.'</span></h4>
      <p style="text-align: justify;"> Уважаемый(-ая)&nbsp;'.$name.'!  Вы оформили заказа в интернет магазине Еврострой на суму:&nbsp;'.$sum2.'. Наши менеджеры обработают Вашу заявку и свяжутся с Вами в кротчайшие сроки.
        <br />Только у нас Вы можете получить большую персональную скидку, лучшие цены и акции на самые популярные товары с доставкой по всей территории Украины.</p>
      <br />
      <p style="font-size: 14px"><b><i>
        P.S. Если Вы сделали заказ и с Вами не связались наши менеджеры в течении трёх рабочих дней, пожалуйста позвоните нам на <a href="tel:+380939099915" title="Время работы call-center Евросвет пн-пт: 8:00-18:00">+38 (093) 90-99-915</a>
        <br />
        <span><b>Способы оплаты</b></span>
      </i></b></p>
      <ul style="font-size: 14px">
        <li>Оплата наличными в магазине г. Черкассы, ул. Хоменка 17. Пн-пт с 8:00 до 18:00</li>
        <li>Оплата по безналичному расчету на счет компании</li>
        <li>Оплата на карточку</li>
      </ul>
    </div>
    <hr color="#e41b41" size="4px">
    <div style="background-color: rgba(80, 50, 50, 0.2); box-shadow: 2px 2px 4px 4px rgba(0, 0, 0, 0.5); border-radius: 20px; padding-bottom: 10px; width: 97%; margin: 0 auto;">
      <h3 style="text-align: center; text-transform: uppercase; color: #e41b41; border-radius: 20px 20px 0px 0px; background-color:#303030; padding: 10px; box-shadow: 0 2px 4px 4px rgba(0, 0, 0, 0.5);">Информация о заказе:</h3>
      <div style="padding: 10px">
        <p style="text-align: left; font-size: 14px;">
          <b>Список товаров:</b>
          <ul>
            '.$l.'
          </ul>
        </p>
        <p style="text-align: center; text-transform: uppercase; font-size: 18px; font-weight: bold; color: #af1115;">
          Сумма заказа: '.$sum2.'
        </p>
        <p style="font-size: 12px; text-align: justify; width: 95%; margin: 0 auto;">Тип оплаты: <i>'.$paysType.'</i></p>
        <p style="font-size: 12px; text-align: justify; width: 95%; margin: 0 auto;">Тип доставки: <i>'.$deliveryType.'</i></p>
        <p style="font-size: 12px; text-align: justify; width: 95%; margin: 0 auto;">Подробности доставки: <i>'.$city.''.$street.''.$home.''.$appartment.'</i></p>
        <p style="font-size: 12px; text-align: justify; width: 95%; margin: 0 auto;">Комментарий к заказу: <i>'.$text.'</i></p>

      </div>
    </div>
    <hr color="#e41b41" size="4px">
      <div style="font-size: 10px; width: 90%; margin: auto; ">
        <div style="margin: 0 auto; text-align: center;">
          <div style="display: inline-block; margin: 10px auto; max-width: 250px; text-align: center">
            <a href="https://bud-komplekt.com.ua" target="_blank">
              <img src="https://bud-komplekt.com.ua/template/images/logo/logo.png" title="Сайт Еврострой" width="90%">
            </a>
          </div>
          <div style="display: inline-block; margin: 10px auto; text-align: center;">
           <p style="margin: 5px;">
            Тел: <a href="tel:+380939099915" title="Отдел интернет продаж Еврострой">+38 (093) 90-99-915</a>
           </p>
           <p style="margin: 5px;">
            г. Черкассы, ул. Хоменка 17
           </p>
           <p style="margin: 5px;">
            <a href="mailto:evrostroy.ukraine@gmail.com" title="Отправить письмо на evrostroy.ukraine@gmail.com">Отправить e-mail</a>
           </p>           
          </div>

          <div style="display: inline-block; margin: 10px auto;">
            <ul style="margin: 5px; padding: 10px; text-align: left">
                <span style="font-size: 12px; font-weight: bold;">График работы</span>
                <li>Пн-Пт: <span style="font-weight: bold">8:00-18:00</span></li>
                <li>Сб: <span style="font-weight: bold">8:00-15:00</span></li>
                <li>Вс: <span style="font-weight: bold">выходной</span></li>
            </ul>
          </div>
        </div>
      </div>
  </div>
';

$theMailer = new PHPMailer();
$theMailer->SetFrom('sales@bud-komplekt.com.ua', 'Заказ на сайте Eurostroy №'.$orderNum);
$theMailer->Subject = "Eurostroy";
$theMailer->Body = $reason;
$theMailer->AddAddress('ceo@bud-komplekt.com.ua', 'Order, Eurostroy');
$theMailer->AddAddress('sales@bud-komplekt.com.ua', 'Order, Eurostroy');
$theMailer->MsgHTML($forAdmin);
$theMailer->Send();

$theMailer = new PHPMailer();
$theMailer->SetFrom('sales@bud-komplekt.com.ua', 'Заказ на Eurostroy №'.$orderNum);
$theMailer->Subject = "Eurostroy";
$theMailer->Body = $reason;
$theMailer->AddAddress($email);
$theMailer->MsgHTML($forBuyer);
if(!$theMailer->send()) {
  echo '';
  echo 'Ошибка: '.$theMailer->ErrorInfo.'';
} else {
  echo 'Ваше сообщение отправлено! Спасибо за Ваш заказ. Ожидайте звонка от менеджера!';
}
//if(!$theMailer->send()){
//  echo "Ваше сообщение отправлено! Еврострой ценит Вас";
//} else {
//  echo "Ой йой! Что-то пошло не так. Вам стоит повторить попытку или позвонить по телефону: <a href="tel:0968870055">+096 88 700 55 </a>";
//};
//
?>