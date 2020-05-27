<div class="ht__bradcaump__area" style="background: rgba(0, 0, 0, 0) url({template}/images/bg/2.jpg) no-repeat scroll center center / cover ;">
  <div class="ht__bradcaump__wrap">
    <div class="container">
      <div class="row">
        <div class="col-xs-12">
          <div class="bradcaump__inner text-center">
            <h2 class="bradcaump-title">{title}</h2>
            <nav class="bradcaump-inner">
              {breadcrumbs}
            </nav>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<section class="htc__blog__area bg__white ptb--20">
  <div class="container">
    <div class="row">
      <div class="col-md-8">
        <div class="row">
          <div class="blog__wrap blog--page clearfix">
            {content}
          </div>
        </div>
<!-- Start Load More BTn -->
<!--
      <div class="row mt--60">
          <div class="col-md-12">
              <div class="htc__loadmore__btn">
                  <a href="#">load more</a>
              </div>
          </div>
      </div>
-->
<!-- End Load More BTn -->
    </div>
    <div class="col-md-4">
      <div class="blod-details-right-sidebar mrg-blog">


<!--        SEARCH IN NEWS-->
        
<!--
        <div class="category-search-area">
          <form action="/search-news.php" method="post">
            <label for="search-news" hidden></label>
            <input id="search-news" name="search-news" alt="Упс! Что-то пошло не так" placeholder="Поиск в новостях" type="text">
            <button type="submit" class="srch-btn" ><i class="zmdi zmdi-search"></i></button>    
          </form>
        </div>
-->
              <!-- Start Category Area -->
              <div class="our-category-area mt--60">
                  <h2 class="section-title-2">Категории новостей:</h2>
                  <ul class="categore-menu">
                      <li><a href="#"><i class="zmdi zmdi-caret-right"></i>Фасад (в разработке) <span>5</span></a></li>
                      <li><a href="#"><i class="zmdi zmdi-caret-right"></i>Крыша (в разработке) <span>4</span></a></li>
                      <li><a href="#"><i class="zmdi zmdi-caret-right"></i>Утепление (в разработке) <span>2</span></a></li>
                  </ul>
              </div>
              <!-- End Category Area -->
                            <!-- Start Letaest Blog Area -->
                            <div class="our-recent-post mt--60">
                              <h2 class="section-title-2"><a href="/news">Последние новости</a></h2>
                              <div class="our-recent-post-wrap">
                                {last_news}
                              </div>
                            </div>
                            <!-- End Letaest Blog Area -->
                            <!-- Start Tag -->
                            <div class="our-blog-tag">
                                <h2 class="section-title-2">ТЕГИ</h2>
                                <ul class="tag-menu mt-40">
                                  {news_tags}
                                </ul>
                            </div>
                            <!-- End Tag -->
                        </div>
                    </div>
    </div>
  </div>
</section>
