<?
// Login form

$title='Вход в админпанель';
$menu='';
// Status
require("status.php");
$status=rce_get_status($_GET['status'],$statusdata);

$content='<!--User authorization module. ../admin/modules/user_auth/-->
  <div class="auth">
    <object class="auth__logo" type="image/svg+xml" data="/template/images/design/logo_head.svg">
      <img class="auth__logo" src="/template/images/design/logo_head.png" alt="Eurostroy bla bla bla">
    </object>
    <div class="auth__headers">
      <h2 class="auth__headers--main">Пожалуйста<br />авторизируйтесь!</h2>
      <h3 class="auth__headers--status">'.$status.'</h3>
    </div>

    <div class="auth__form">
      <form class="auth__form--box" role="form" action="/admin/modules/user_auth/auth.php" method="post">
        <input type="hidden" name="redirect" value="'.$_SERVER['REQUEST_URI'].'"/>
        <fieldset>
          <div class="auth__form--block">
            <label class="auth__form--label" for="email">Ваш E-mail:</label>
            <input class="auth__form--input" id="email" placeholder="Введите e-mail доступа" name="email" type="email" autofocus>
          </div>
          <div class="auth__form--block">
            <label class="auth__form--label" for="pass">Ваш пароль:</label>
            <input class="auth__form--input" id="pass" name="pass" type="password" placeholder="Введите свой пароль" value="">
          </div>
          <div>
            <label class="auth__form--label" for="remember">Запомнить меня:</label>
            <input class="auth__form--input" id="remember" name="remember" type="checkbox" value="yes">
          </div>
          <button class="auth__form--submit" type="submit">Войти</button>
        </fieldset>
      </form>
    </div>
  </div>
<!--User authorization module END-->';

$css='<link rel="stylesheet" href="'.RCE_ADMIN.'template/css/user_auth.css">';
$js='';


// Template output
$rce=new rce_admin();
$out=$rce->render($title,$menu,$content,$css,$js);

?>