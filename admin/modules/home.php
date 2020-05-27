<?
// Admin homepage

$db=new db();

$stat_langs=$db->count('SELECT * FROM `rce_config_lang`');
$stat_langs_active=$db->count('SELECT * FROM `rce_config_lang` WHERE `active`="1"');
$stat_modules=$db->count('SELECT * FROM `rce_modules`');
$stat_modules_active=$db->count('SELECT * FROM `rce_modules` WHERE `active`="1"');
$stat_logs_errors=$db->count('SELECT * FROM `rce_logs_errors`');
$stat_logs_errors_today=$db->count('SELECT * FROM `rce_logs_errors` WHERE `date`>NOW()-INTERVAL 24 HOUR');
if($stat_logs_errors_today>0){
	$errors_today=' txt-error';
}
$stat_logs_users=$db->count('SELECT * FROM `rce_logs_users`');
$stat_logs_users_today=$db->count('SELECT * FROM `rce_logs_users` WHERE `date`>NOW()-INTERVAL 24 HOUR');
$stat_pages=$db->count('SELECT * FROM `rce_pages`');
$stat_pages_today=$db->count('SELECT * FROM `rce_pages` WHERE `date`>NOW()-INTERVAL 24 HOUR');
$stat_users=$db->count('SELECT * FROM `rce_users`');
$stat_users_today=$db->count('SELECT * FROM `rce_users` WHERE `date_reg`>NOW()-INTERVAL 24 HOUR');

$title='Главная страница';
$content='
<main class="wrapper-main">
  <section class="section-header">
    <h1 class="page-header">Главная страница Eurostroy</h1>
    <p class="txt-error">Состояние сайта</p>
  </section>

  <section class="section-info">
    <div>
      <div class="section-info__block">
        <p class="section-info__block--text">Количество действий пользователей: '.$stat_logs_users.'</p>
        <p class="section-info__block--subtext">Дествия за 24 часа: '.$stat_logs_users_today.'
          <a href="/admin/?module=logs_users" class="header__alert" title="Действия на сайте">&#8658;</a></p>
      </div>
      <div class="section-info__block">
        <p class="section-info__block--text">Количество пользователей: '.$stat_users.'</p>
        <p class="section-info__block--subtext">Новые пользователи за 24 часа: '.$stat_users_today.'
          <a href="/admin/?module=users_list" class="header__alert" title="Пользователи сайта">&#8658;</a></p>
      </div>
      <div class="section-info__block">
        <p class="section-info__block--text">Ошибок в журнале: '.$stat_logs_errors.'</p>
        <p class="section-info__block--subtext">Ошибки на сайте за 24 часа: '.$stat_logs_errors_today.'
          <a href="/admin/?module=logs_errors" class="header__alert" title="Ошибки сайта">&#8658;</a></p>
      </div>
      <div class="section-info__block">
        <p class="section-info__block--text">Измененно, добавлено страниц: '.$stat_pages.'</p>
        <p class="section-info__block--subtext '.$errors_today.'">Новых страниц за 24 часа: '.$stat_pages_today.'
          <a href="/admin/?module=pages" class="header__alert" title="Страницы сайта">&#8658;</a></p>
      </div>
      <div class="section-info__block">
        <p class="section-info__block--text">Количество модулей на сайте: '.$stat_modules.'</p>
        <p class="section-info__block--subtext '.$errors_today.'">Активные модули на сайте: '.$stat_modules_active.'
          <a href="/admin/?module=config_modules" class="header__alert" title="Модули сайта">&#8658;</a></p>
      </div>
      <div class="section-info__block">
        <p class="section-info__block--text">Языков на сайте: '.$stat_langs.'</p>
        <p class="section-info__block--subtext '.$errors_today.'">Активные языки на сайте: '.$stat_langs_active.'
          <a href="/admin/?module=config_lang" class="header__alert" title="Языки сайта">&#8658;</a></p>
      </div>
    </div>

    <div class="resource">
      <p class="txt-error">Для использования сервисов у вас должен быть авторизированый аккаунт с доступом!</p>
      <ul class="resource__list">
        <li>
          <a class="resource__link" href="https://mail.google.com/mail/" target="_blank">
            <img class="resource__img" src="'.RCE_ADMIN.'template/images/google-mail-logo.png" title="Google Mail" alt="Ссылка на Google Mail - аккаунт с заказами">
          </a>
        </li>
        <li>
          <a class="resource__link" href="https://analytics.google.com/analytics/web/#/report-home/a150815711w213554342p204575210" target="_blank">
            <img class="resource__img" src="'.RCE_ADMIN.'template/images/google-analytics-logo.png" title="Google Analytics" alt="Ссылка на Google Analytics">
          </a>
        </li>
        <li>
          <a class="resource__link" href="#" target="_blank">
            <img class="resource__img" src="'.RCE_ADMIN.'template/images/google-adwords-logo.png" title="Google AdWords" alt="Ссылка на Google AdWords">
          </a>
        </li>
        <li>
          <a class="resource__link" href="https://search.google.com/u/0/search-console?resource_id=http%3A%2F%2Fbud-komplekt.com.ua%2F" target="_blank">
            <img class="resource__img" src="'.RCE_ADMIN.'template/images/google-searchconsole-logo.png" title="Google Search Console" alt="Ссылка на Google Search Console">
          </a>
        </li>
        <li>
          <a class="resource__link" href="https://contacts.google.com/" target="_blank">
            <img class="resource__img" src="'.RCE_ADMIN.'template/images/google-contacts-logo.png" title="Google Contacts" alt="Ссылка на Google Contacts">
          </a>
        </li>
        <li>
          <a class="resource__link" href="https://drive.google.com/drive/" target="_blank">
            <img class="resource__img" src="'.RCE_ADMIN.'template/images/google-drive-logo.png" title="Google Drive" alt="Ссылка на Google Drive">
          </a>
        </li>
        <li>
          <a class="resource__link" href="https://business.google.com/dashboard/l/07580054145773035156" target="_blank">
            <img class="resource__img" src="'.RCE_ADMIN.'template/images/google-mybusiness-logo.png" title="Google MyBusiness" alt="Ссылка на Google My Business">
          </a>
        </li>
        <li>
          <a class="resource__link" href="https://metrika.yandex.ru/dashboard?id=56007067" target="_blank">
            <img class="resource__img" src="'.RCE_ADMIN.'template/images/yandex-metrika-logo.png" title="Yandex Metrika" alt="Ссылка на Yandex Метрику">
          </a>
        </li>
        <li>
          <a class="resource__link" href="#" target="_blank">
            <img class="resource__img" src="'.RCE_ADMIN.'template/images/facebook-logo.png" title="Страница в FaceBook" alt="Ссылка на страницу в FaceBook">
          </a>
        </li>
        <li>
          <a class="resource__link" href="#" target="_blank">
            <img class="resource__img" src="'.RCE_ADMIN.'template/images/instagram-logo.png" title="Страница в Instagram" alt="Ссылка на страницу в Instagram">
          </a>
        </li>
        <li>
          <a class="resource__link" href="https://mbox2.i.ua/" target="_blank">
            <img class="resource__img" src="'.RCE_ADMIN.'template/images/i.ua-mail-logo.png" title="I.ua mail почта с заказами для сайта" alt="Ссылка на почту i.ua">
          </a>
        </li>
        <li>
          <a class="resource__link" href="https://app.jivosite.com/chat/inbox" target="_blank">
            <img class="resource__img" src="'.RCE_ADMIN.'template/images/jivosite-logo.png" title="Jivo Site Чат" alt="Ссылка на чат JivoSite">
          </a>
        </li>
      </ul>
    </div>
  </section>
</main>
';

$css='<link rel="stylesheet" href="'.RCE_ADMIN.'template/css/home.css">';
$js='<script>
		$(document).ready(function(){
			$("#table").dataTable({
				"oLanguage":{
					"sUrl": "'.RCE_ADMIN.'template/js/config/tables_ru_RU.txt"
				},
				"paging":false,
				"search":false
			});
		});
    </script>
';

// Template output
$rce=new rce_admin();
$out=$rce->render($title,$menu,$content,$css,$js);

?>