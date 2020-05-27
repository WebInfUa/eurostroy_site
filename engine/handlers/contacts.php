<?php

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = strip_tags(trim($_POST["name"]));
				$name = str_replace(array("\r","\n"),array(" "," "),$name);
        $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
        $phone = trim($_POST["phone"]);
        $message = trim($_POST["message"]);

        if ( empty($name) OR empty($phone) OR empty($message)) {
            http_response_code(400);
            echo "Пожалуйста введите все необходимые поля.";
            exit;
        }

        $recipient = "ceo@bud-komplekt.com.ua, info@bud-komplekt.com.ua";
        $subject = "Отправлена контактная форма от $name";

        $email_content = '<html>
<head>
</head>
<body><div style="width: 95%; max-width: 750px; background-color: rgba(0, 0, 0, 0.1); padding: 10px; border-radius: 20px; margin: 0 auto;">
  <div style="display: flex; flex-direction: row; margin: 0 auto; flex-wrap: wrap; justify-content: center;">
    <div style="max-width: 190px; max-height: 45px; margin: 0 auto">
      <a href="https://bud-komplekt.com.ua/" title="Сайт Еврострой" target="_blank" >
        <img src="https://bud-komplekt.com.ua/template/images/logo/logo.png" width="100%" align="left">
      </a>
    </div>
    <div style="margin: 0 auto;">
      <h2 style="text-align: center; text-transform: uppercase; color: #ff0000">
        Контактная форма
      </h2>
    </div>
  </div>

  <hr color="#e41b41" size="4px">
  
  <div>
    <h3 style="text-transform: uppercase; text-align: center" >Контактная информация</h3>
    <p>Контактная форма с сайта отправлена от:</p>
    <ul style="font-size: 14px;">
      <li style="margin-bottom: 15px;"><b>Имя заказчика: </b>'.$name.'</li>
      <li  style="margin-bottom: 15px;"><b>Контактная почта: </b>'.$email.'</li>
      <li  style="margin-bottom: 15px;"><b>Контактный телефон: </b>'.$phone.'</li>
    </ul>
    <hr color="#e41b41" size="4px">
    <p style="color: #c00c00; font-size: 16px; font-weight: bold;">Текст сообщения:</p>
    <p style="color: #c00c00; font-size: 16px; font-weight: bold;">'.$message.'</p>
    <p style="color: #c00c00; font-size: 16px; font-weight: bold;">
      Быстрый ответ '.$name.' по ссылке <a href="mailto:'.$email.'">'.$email.'</a>
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
</body>
</html>';

        $email_headers  = 'MIME-Version: 1.0' . "\r\n";
        $email_headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
        $email_headers .= 'От: '.$name.' <'.$email.'>' . "\r\n";
      

      if (mail($recipient, $subject, $email_content, $email_headers)) {
            http_response_code(200);
            echo "Ваше сообщение отправлено! Еврострой ценит Вас";
        } else {
            http_response_code(500);
            echo "Ой йой! Что-то пошло не так. Вам стоит повторить попытку или позвонить по телефону: 096 88 700 55 ";
        };

    } else {
        http_response_code(403);
        echo "Хм! Проблема отправки Вашых данных. Вам стоит заново заполнить все необходимые поля и повторить попытку!";
    };

?>

