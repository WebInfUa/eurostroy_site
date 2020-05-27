<!doctype html>
<html class="no-js" lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    {meta_data}

    <meta name="viewport" content="width=device-width, initial-scale=1">
  
    <!-- Embed Font-->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700&display=swap&subset=cyrillic" rel="stylesheet">
    <!-- Place favicon.ico in the root directory -->
    <link rel="shortcut icon" href="{site_root}favicon.png"/>
    <!-- All css files are included here. -->
    <!-- Bootstrap fremwork main css -->
    <link rel="stylesheet" href="{template}css/bootstrap.min.css">
    <!-- Owl Carousel main css -->
    <link rel="stylesheet" href="{template}css/owl.carousel.min.css">
    <link rel="stylesheet" href="{template}css/owl.theme.default.min.css">
    <!-- This core.css file contents all plugings css file. -->
    <link rel="stylesheet" href="{template}css/core.css">
    <!-- Theme shortcodes/elements style -->
    <link rel="stylesheet" href="{template}css/shortcode/shortcodes.css">
    <!-- Theme main style -->
    <link rel="stylesheet" href="{template}css/style.css">
    <!-- Responsive css -->
    <link rel="stylesheet" href="{template}css/responsive.css">
    <!-- User style -->
    <link rel="stylesheet" href="{template}css/custom.css">

  
<!--  INDEX PAGE STYLE  -->
    <link rel='stylesheet' href='{template}index/css/jquery.fancybox.css' type='text/css' media='all' />
    <link rel='stylesheet' href='{template}index/css/js_composer_front_custom.css' type='text/css' media='all' />
    <link rel='stylesheet' href='{template}index/css/layerslider.css' type='text/css' media='all' />
    <link rel='stylesheet' href='{template}index/css/media.css' type='text/css' media='all' />
    <link rel='stylesheet' href='{template}index/css/owl.carousel.css' type='text/css' media='all' />
    <link rel='stylesheet' href='{template}index/css/owl.transitions.css' type='text/css' media='all' />
    <link rel='stylesheet' href='{template}index/css/Pe-icon-7-stroke.css' type='text/css' media='all' />
    <link rel='stylesheet' href='{template}index/css/style.css' type='text/css' media='all' />
  
    <!-- Modernizr JS -->
    <script src="js/vendor/modernizr-2.8.3.min.js"></script>

    <!--  Yandex verification  -->
    <meta name="yandex-verification" content="b07717b5421c5fb8" />

    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
        new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
      j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
      'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-MTG5HS8');</script>
    <!-- End Google Tag Manager -->

  <meta name="google-site-verification" content="l2W8mtRY4Qi99NgDKA1-bRNFNuTXEzSxBlMxlvoq2kk" />
  
</head>
<body>
<!--[if lt IE 8]>
    <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
<![endif]-->

  <!-- Body main wrapper start -->
  <div class="wrapper fixed__footer">
    <!-- Start Header Style -->
    <header id="header" class="htc-header header--3 bg__white">
      <!-- Start Mainmenu Area -->
      <div id="sticky-header-with-topbar" class="mainmenu__area sticky__header">
        <div class="container">
          <div class="row">
            <div class="col-md-2 col-lg-2 col-sm-3 col-xs-3">
              <div class="logo">
                <a href="/">
                  {logo}
                  <h1 style="font-size: 0; margin: 0; padding: 0; width: 0; height: 0">{title}</h1>
                </a>
              </div>
            </div>
        <!-- Start MAinmenu Ares -->
            <div class="col-md-8 col-lg-8 col-sm-6 col-xs-6">
              <nav class="mainmenu__nav hidden-xs hidden-sm">
                <ul class="main__menu">
                  <li class="drop"><a href="/">Главная</a></li>
                  <li class="drop"><a href="/shop/">Магазин</a>
                    <ul class="dropdown mega_dropdown">
                      <!-- Start Single Mega MEnu -->
                      <li><a class="mega__title" href="/catalog/">Категории товаров</a>
                        <ul class="mega__item">
                          {cats}
                        </ul>
                      </li>
                      <!-- End Single Mega MEnu -->
                      <!-- Start Single Mega MEnu -->
                      <li>
                        <ul class="mega__item">
                          <li>
                            <div class="mega-item-img">
                              <a href="/catalog/">
                                <img class="mega-item__img" src="/template/images/feature-img/catImgTopMenu.png" alt="Евростройчик, талисман компании Еврострой">
                              </a>
                            </div>
                          </li>
                        </ul>
                      </li>
                      <!-- End Single Mega MEnu -->
                    </ul>
                  </li>
                  <li class="drop"><a href="#">Калькулятор</a>
                    <ul class="dropdown">
                      {calcMenu}
                    </ul>
                  </li>
                  {topMenu}
                </ul>
              </nav>

              <div class="mobile-menu clearfix visible-xs visible-sm">
                <nav id="mobile_dropdown">
                  <ul>
                    <li><a href="/">Главная</a></li>
                    <li><a href="/shop">Магазин</a></li>
                    <li><a href="/catalog">Каталог товаров</a></li>
                    <li><a href="#">Страницы</a>
                      <ul class="dropdown">
                        {topMenu}
                      </ul>
                    </li>
                    <li><a href="#">Калькуляторы</a>
                      <ul>
                        {calcMenu}
                      </ul>
                    </li>
                  </ul>
                </nav>
              </div>
            </div>
            <!-- End MAinmenu Ares -->
            <div class="col-md-2 col-sm-4 col-xs-3">
              <ul class="menu-extra">
                <li class="search search__open"><span class="ti-search"></span></li>
                <!--<li><a href="login-register.html"><span class="ti-user"></span></a></li>-->
                {cart_icon}
                <li class="toggle__menu hidden-xs hidden-sm"><span class="ti-menu"></span></li>
              </ul>
            </div>
          </div>
          <div class="mobile-menu-area"></div>
        </div>
      </div>
      <!-- End Mainmenu Area -->
    </header>
    <!-- End Header Style -->
  <div class="body__overlay"></div>
  <!-- Start Offset Wrapper -->
  <div class="offset__wrapper">
    <!-- Start Search Popap -->
    <div class="search__area">
      <div class="container" >
        <div class="row" >
          <div class="col-md-12" >
            <div class="search__inner">
              <!--SETUP SEARCH FORM-->
              <form action="/search.php" method="post">
                <label for="search" hidden></label>
                <input id="search" name="search" alt="Упс! Что-то пошло не так" placeholder="Введите ваш запрос... " type="text">
                <button type="submit"></button>
              </form>
              <div class="search__close__btn">
                <span class="search__close__btn_icon"><i class="zmdi zmdi-close"></i></span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
      <!-- End Search Popap -->
    <!-- Start Offset MEnu -->
    <div class="offsetmenu">
      <div class="offsetmenu__inner">
        <div class="offsetmenu__close__btn">
          <a href="#"><i class="zmdi zmdi-close"></i></a>
        </div>
        <div class="off__contact">
          <div class="logo">
            <a href="index.html">
              {logo}
            </a>
          </div>
            <p>База строительных материалов Еврострой - приветсвует Вас!</p>
            <p>Компания Еврострой занимается продажей строительных материалов, консультацие и поддержкой своих клиентов уже больше 10 лет. Заходите на наши социальные сети, YouTube канал, Instagram блог и страницу в FaceBook - там вы найдете еще больше новостей, скидок и акций.</p>
            <p>Хочешь получить скидку первым? Присоединяйся к нам в:</p>
            <ul>
              <li>
                <a href="viber://add?number=120345678910" title="Viber Еврострой на мобильном">Viber Mobile (Viber на мобильном)</a>
              </li>
              <li>
                <a href="viber://chat?number=+120345678910" title="Viber Еврострой на ПК">Viber PC (Viber на компютере)</a>
              </li>
              <li>
                <a href="whatsapp://send?phone=+120345678910" title="WhatsApp Еврострой">WhatsApp</a>
              </li>
              <li>
                <a title="Telegram" href="tg://resolve?domain=nikname">Telegram</a>  
              </li>
            </ul>
        </div>
        <div class="offset__widget">
          <div class="offset__single">
            <h4 class="offset__title">Язык</h4>
            <ul>
              <li><a href="#">Русский</a></li>
              <li><a href="#">Украинский (в разработке)</a></li>
            </ul>
          </div>
  <div class="offset__single">
      <h4 class="offset__title">Быстрые ссылки</h4>
      <ul>
          <li><a href="/shop/"> Магазин </a></li>
          <li><a href="https://budcentr.ck.ua/"> Объектный отдел </a></li>
          <li><a href="/contacts/"> Контакты </a></li>
          <li><a href="/catalog/"> Каталог </a></li>
      </ul>
  </div>
        </div>
        <div class="offset__sosial__share">
          <h4 class="offset__title">Наши социальные сети</h4>
          <ul class="off__soaial__link">
            <li><a class="bg--twitter" href="#"  title="Twitter"><i class="zmdi zmdi-twitter"></i></a></li>
            <li><a class="bg--instagram" href="#" title="Instagram"><i class="zmdi zmdi-instagram"></i></a></li>
            <li><a class="bg--facebook" href="#" title="Facebook"><i class="zmdi zmdi-facebook"></i></a></li>
            <li><a class="bg--youtube" href="#" title="Facebook"><i class="zmdi zmdi-youtube"></i></a></li>
          </ul>
        </div>
      </div>
    </div>
    <!-- End Offset MEnu -->
    <!-- Start Cart Panel -->
    <div class="shopping__cart">
      <div class="shopping__cart__inner">
        <div class="offsetmenu__close__btn">
          <a href="#"><i class="zmdi zmdi-close"></i></a>
        </div>
          <div class="shp__cart__wrap">
              
              {cartTopItem}          
              
          </div>
          <ul class="shoping__total">
              <!--{price in cart} - create new block-->
              <li class="subtotal">Сумма к оплате:</li>
              <li class="total__price">{sum2}</li>
          </ul>          
          <ul class="shoping__total">
              <!--{price in cart} - create new block-->
              <li class="subtotal">Товаров в корзине:</li>
              <li class="total__price">{count}</li>
          </ul>
          <ul class="shopping__btn">
              <li><a href="/cart/">Перейти в корзину</a></li>
              <li class="shp__checkout"><a href="/checkout/">Быстрый заказ</a></li>
          </ul>
      </div>
    </div>
    <!-- End Cart Panel -->
  </div>
  <!-- End Offset Wrapper -->