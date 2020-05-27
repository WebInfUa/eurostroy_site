<?php

session_start();
define('RCE','V5');
require_once("../inc/db.php");
require_once("../classes/class.phpmailer.php");

$reason='
<div style="width: 95%; max-width: 750px; background-color: rgba(0, 0, 0, 0.1); padding: 10px; border-radius: 20px; margin: 0 auto;">
  <div style="display: flex; flex-direction: row; margin: 0 auto; flex-wrap: wrap; justify-content: center;">
    <div style="max-width: 190px; max-height: 45px; margin: 0 auto">
      <a href="https://bud-komplekt.com.ua/" title="Сайт Еврострой" target="_blank" >
        <img src="https://bud-komplekt.com.ua/template/images/logo/logo.png" width="100%" align="left">
      </a>
    </div>
    <div style="margin: 0 auto;">
      <h2 style="text-align: center; text-transform: uppercase; color: #ff0000">
        запрос на связь по почте
      </h2>
    </div>
  </div>

  <hr color="#e41b41" size="4px">
  
  <div>
    <h3 style="text-transform: uppercase; text-align: center" >Контактная информация</h3>
    <p>Поступил новый запрос на обратную связь по почте с сайта!</p>
    <ul style="font-size: 14px;">
      <li style="margin-bottom: 15px;"><b>Имя заказчика: </b>'.$_POST['name'].'</li>
      <li  style="margin-bottom: 15px;"><b>Контактная почта: </b>'.$_POST['email'].'</li>
    </ul>
    <p style="color: #c00c00; font-size: 16px; font-weight: bold;">
      Быстрый ответ '.$_POST['name'].' по ссылке <a href="mailto:'.$_POST['email'].'">'.$_POST['email'].'</a>
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
$theMailer->SetFrom('info@bud-komplekt.com.ua', 'Обратная связь по E-mail Eurostroy');
$theMailer->Subject = "Eurostroy";
$theMailer->Body = $reason;
$theMailer->AddAddress('ceo@bud-komplekt.com.ua', 'Copy recall letter to Admin');
$theMailer->AddAddress('info@bud-komplekt.com.ua', 'Recall, letter to manager');
$theMailer->MsgHTML($reason);
$theMailer->Send();

header("Location: /");