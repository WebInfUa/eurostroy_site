<h1 style="visibility: hidden; width: 0; height: 0; margin: 0; padding: 0;display:none;">Evrostroy Еврострой Єврострой</h1>
<!-- Start Feature Product -->
<section class="categories-slider-area bg__white">
  <div class="container">
    <div class="row">
      <!-- Start Left Feature -->
      <div class="col-md-9 col-lg-9 col-sm-8 col-xs-12 float-left-style">
          <!-- Start Slider Area -->
          <div class="slider__container slider--one">
              <div class="slider__activation__wrap owl-carousel owl-theme">
                {sliderMain}
              </div>
          </div>
          <div class="slider__containers slider--one">
              <div class="slider__activation__wrap slider__two--left owl-carousel owl-theme">
                {sliderMain2}
              </div>
              <div class="slider__activation__wrap slider__two--rigth owl-carousel owl-theme">
                {sliderMain3}
              </div>
          </div>
          <!-- Start Slider Area -->
      </div>
      <div class="col-md-3 col-lg-3 col-sm-4 col-xs-12 float-right-style">
          <div class="categories-menu mrg-xs">
            <div class="category-heading">
            <h3><a href="/catalog">Категории товаров</a></h3>
            </div>
            <div class="category-menu-list">
              <ul>
                {catList}
            </ul>
          </div>
        </div>
      </div>
      <!-- End Left Feature -->
    </div>
  </div>
</section>

<!-- End Feature Product -->
<div class="only-banner ptb--10 bg__white">
  <div class="container">
    <div class="only-banner-img">
      {banner_top}
    </div>
  </div>
</div>
<!-- Start Our Product Area -->
<section class="htc__product__area bg__white">
  <div class="container">
    <div class="row">
      <div class="col-md-3">
        <div class="product-categories-all">
          <div class="product-categories-title">
            <h3><a href="/catalog">Категории товаров</a></h3>
          </div>
          <div class="product-categories-menu">
            <ul>
              {cats}
            </ul>
          </div>
        </div>
      </div>
      <div class="col-md-9">
        <div class="product-style-tab">
          <div class="product-tab-list">
            <!-- Nav tabs -->
            <ul class="tab-style" role="tablist">
              <li class="active">
                <a href="#home1" data-toggle="tab">
                  <div class="tab-menu-text">
                    <h4>Акции</h4>
                  </div>
                </a>
              </li>
              <li>
                <a href="#home2" data-toggle="tab">
                  <div class="tab-menu-text">
                    <h4>Специальные предложения</h4>
                  </div>
                </a>
              </li>
              <li>
                <a href="#home3" data-toggle="tab">
                  <div class="tab-menu-text">
                    <h4>Топ продаж</h4>
                  </div>
                </a>
              </li>
              <li>
                <a href="#home4" data-toggle="tab">
                  <div class="tab-menu-text">
                    <h4>Распродажа</h4>
                  </div>
                </a>
              </li>
            </ul>
          </div>
          <div class="tab-content another-product-style jump">
            <div class="tab-pane active" id="home1">
              <div class="row">
                <div class="product-slider-active owl-carousel">
                  {stock}
                </div>
              </div>
            </div>
            <div class="tab-pane" id="home2">
              <div class="row">
                <div class="product-slider-active owl-carousel">
                  {spec}
                </div>
              </div>
            </div>
            <div class="tab-pane" id="home3">
              <div class="row">
                <div class="product-slider-active owl-carousel">
                  {top_sell}
                </div>
              </div>
            </div>
            <div class="tab-pane" id="home4">
              <div class="row">
                <div class="product-slider-active owl-carousel">
                  {out_sell}
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- End Our Product Area -->
<div class="only-banner ptb--20 bg__white">
  <div class="container">
    <div class="only-banner-img">
      {banner_med}
    </div>
  </div>
</div>
<!-- Start Our Product Area -->
<section class="htc__product__area pb--20 bg__white">
  <div class="container">
    <div class="row">
      <div class="col-md-3">
        <div class="product-categories-all">
          <div class="product-categories-title">
            <h3>Калькуляторы</h3>
          </div>
          <div class="product-categories-menu">
            <ul>
              {calcMenu}
            </ul>
          </div>
        </div>
      </div>
      <div class="col-md-9">
        <div class="product-style-tab">
          <div class="product-tab-list">
          <!-- Nav tabs -->
            <ul class="tab-style" role="tablist">
              <li class="active">
                <a href="#home5" data-toggle="tab">
                  <div class="tab-menu-text">
                    <h4>Стены</h4>
                  </div>
                </a>
              </li>
              <li>
                <a href="#home6" data-toggle="tab">
                  <div class="tab-menu-text">
                    <h4>Потолок</h4>
                  </div>
                </a>
              </li>
              <li>
                <a href="#home7" data-toggle="tab">
                  <div class="tab-menu-text">
                    <h4>Утепление</h4>
                  </div>
                </a>
              </li>
              <li>
                <a href="#home8" data-toggle="tab">
                  <div class="tab-menu-text">
                    <h4>Крыша</h4>
                  </div>
                </a>
              </li>
            </ul>
          </div>
          <div class="tab-content another-product-style jump">
            <div class="tab-pane active" id="home5">
              <div class="row">
                <div class="product-slider-active owl-carousel">
                  {calcWall}
                </div>
              </div>
            </div>
            <div class="tab-pane" id="home6">
              <div class="row">
                <div class="product-slider-active owl-carousel">
                  {calcCeiling}
                </div>
              </div>
            </div>
            <div class="tab-pane" id="home7">
              <div class="row">
                <div class="product-slider-active owl-carousel">
                  {calcTerm}
                </div>
              </div>
            </div>
            <div class="tab-pane" id="home8">
              <div class="row">
                <div class="product-slider-active owl-carousel">
                  {calcRoof}
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- End Our Product Area -->
<div class="only-banner bg__white">
  <div class="container">
    <div class="only-banner-img">
      {banner_down}
    </div>
  </div>
</div>
<!-- Start Blog Area -->
<section class="htc__blog__area bg__white pb--130">
  <div class="container">
    <div class="row">
      <div class="col-xs-12">
        <div class="section__title section__title--2 text-center">
          <h2 class="title__line"><a href="/news/">Последние новости</a></h2>
          <p>Следите за нашими новостями и узнавайте о новинках в мире строительства и ремонта.</p>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="blog__wrap clearfix mt--60 xmt-30">
        {home_news}
      </div>
    </div>
  </div>
</section>
