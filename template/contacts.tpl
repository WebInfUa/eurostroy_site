<div class="ht__bradcaump__area" style="background: rgba(0, 0, 0, 0) url({template}/images/bg/2.jpg) no-repeat scroll center center / cover ;">
  <div class="ht__bradcaump__wrap">
    <div class="container">
      <div class="row">
        <div class="col-xs-12">
          <div class="bradcaump__inner text-center">
            <h2 class="bradcaump-title">Контакты</h2>
            <nav class="bradcaump-inner">
              <a class="breadcrumb-item" href="/">Главная</a>
              <span class="brd-separetor">/</span>
              <span class="breadcrumb-item active">Контакты</span>
            </nav>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


<!-- Start Contact Area -->
<section class="htc__contact__area ptb--20 bg__white">
  <div class="container">
    <div class="row">
      <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
        <div class="htc__choose__wrap bg__cat--4">
          <h2 class="choose__title">Время работы:</h2>
          <div class="choose__container">
            <div class="single__chooose">
              <div class="choose__us">
                <div class="choose__icon">
                  <span class="ti-time"></span>
                </div>
                <div class="choose__details">
                  <h4>Точки выдачи товара:</h4>
                  <p>Понедельник: 8:00-18:00</p>
                  <p>Вторник: 8:00-18:00</p>
                  <p>Среда: 8:00-18:00</p>
                  <p>Четверг: 8:00-18:00</p>
                  <p>Пятница: 8:00-18:00</p>
                  <p>Суббота: 8:00-16:00</p>
                  <p class="text-warning">Воскресенье: выходной</p>
                </div>
              </div>
            </div>
            <div class="single__chooose">
              <div class="choose__us">
                <div class="choose__icon">
                  <span class="ti-time"></span>
                </div>
                <div class="choose__details">
                  <h4>Операторов интернет магазина:</h4>
                  <p>Понедельник: 9:00-18:00</p>
                  <p>Вторник: 9:00-18:00</p>
                  <p>Среда: 9:00-18:00</p>
                  <p>Четверг: 9:00-18:00</p>
                  <p>Пятница: 9:00-18:00</p>
                  <p>Суббота: 9:00-15:00</p>
                  <p class="text-warning">Воскресенье: выходной</p>
                </div>
              </div>
            </div>
            <div class="single__chooose">
              <div class="choose__us">
                <div class="choose__icon">
                  <span class="ti-shopping-cart-full"></span>
                </div>
                <div class="choose__details">
                  <h4>Каталог товаров:</h4>
                  <ul>
                    {cats}
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row ptb--20">
      <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12">
        <div class="htc__contact__container">
          <div class="htc__contact__address">
              <h2 class="contact__title">Контактная информация</h2>
              <div class="contact__address__inner">
                <!-- Start Single Adress -->
                <div class="single__contact__address">
                  <div class="contact__icon">
                    <span class="ti-location-pin"></span>
                  </div>
                  <div class="contact__details">
                    <p>Адресс : <br> 18008 г.Черкассы, ул. Хоменко, 17</p>
                  </div>
                </div>
                  <!-- End Single Adress -->
              </div>
              <div class="contact__address__inner">
                <!-- Start Single Adress -->
                <div class="single__contact__address">
                  <div class="contact__icon">
                    <span class="ti-mobile"></span>
                  </div>
                  <div class="contact__details">
                    <p> Телефон: <br><a href="tel:+380939099915">+093 909 99 15 </a></p>
                  </div>
                </div>
                <!-- End Single Adress -->             
              </div>
              <div class="contact__address__inner">
                <!-- Start Single Adress -->
                <div class="single__contact__address">
                    <div class="contact__icon">
                        <span class="ti-email"></span>
                    </div>
                    <div class="contact__details">
                        <p>Коммерческий отдел:<br><a href="mailto:sales@bud-komplekt.com.ua">sales@bud-komplekt.com.ua</a></p>
                    </div>
                </div>
                <!-- End Single Adress -->                
              </div>
              <div class="contact__address__inner">
                <!-- Start Single Adress -->
                  <div class="single__contact__address">
                      <div class="contact__icon">
                          <span class="ti-email"></span>
                      </div>
                      <div class="contact__details">
                          <p>Информационный отдел:<br><a href="mailto:info@bud-komplekt.com.ua">info@bud-komplekt.com.ua</a></p>
                      </div>
                  </div>
                  <!-- End Single Adress -->
              </div>
              <div class="contact__address__inner">
                <!-- Start Single Adress -->
                  <div class="single__contact__address">
                      <div class="contact__icon">
                          <span class="ti-email"></span>
                      </div>
                      <div class="contact__details">
                          <p>Главный менеджер:<br><a href="mailto:ceo@bud-komplekt.com.ua">ceo@bud-komplekt.com.ua</a></p>
                      </div>
                  </div>
                  <!-- End Single Adress -->
              </div>
          </div>
          <div class="contact-form-wrap">
            <div class="contact-title">
                <h2 class="contact__title"></h2>
            </div>
            <form id="contact-form" action="/engine/handlers/contacts.php" method="post">
                <div class="single-contact-form">
                    <div class="contact-box name">
                      <label for="name" hidden>Name</label>
                      <input id="name" type="text" name="name" placeholder="Ваше имя*" required>
                        
                      <label for="phone" hidden>Phone</label>
                      <input id="phone" type="tel" name="phone" placeholder="Телефон*" required>
                    </div>
                </div>
                <div class="single-contact-form">
                    <div class="contact-box subject">
                      <label for="email" hidden>Mail</label>
                      <input id="email" type="email" name="email" placeholder="Почта">
                    </div>
                </div>
                <div class="single-contact-form">
                    <div class="contact-box message">
                      <label for="message" hidden>Message text</label>
                      <textarea id="message" name="message"  placeholder="Сообщение*"></textarea>
                    </div>
                </div>
                <div class="contact-btn">
                    <button type="submit" class="fv-btn">Отправить</button>
                </div>
            </form>
          </div> 
          <div class="form-output">
              <p class="form-messege"></p>
          </div>
        </div>
      </div>
      <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12 smt-30 xmt-30">
        <div class="map-contacts">
          <div id="googleMap">
            <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d10379.575555321908!2d32.028487799176226!3d49.42982008862374!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x175bd2022d5340c7!2z0JHQsNC30LAg0JHRg9C00ZbQstC10LvRjNC90LjRhSDQnNCw0YLQtdGA0ZbQsNC70ZbQsiAi0ITQktCg0J7QkdCj0JQi!5e0!3m2!1suk!2sua!4v1580120560168!5m2!1suk!2sua" width="100%" height="600" frameborder="0" style="border:0;" allowfullscreen=""></iframe>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- End Contact Area -->
