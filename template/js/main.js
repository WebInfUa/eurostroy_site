/*-----------------------------------------------------------------------------------

  Version: 1.0

-----------------------------------------------------------------------------------*/

/*-------------------------------
[  Table of contents  ]
---------------------------------
  01. jQuery MeanMenu
  02. wow js active
  03. Portfolio  Masonry (width)
  04. Sticky Header
  05. ScrollUp
  06. Tooltip
  07. ScrollReveal Js Init
  08. Fixed Footer bottom script ( Newsletter )
  09. Search Bar
  10. Toogle Menu
  11. Shopping Cart Area
  12. Filter Area
  13. User Menu
  14. Overlay Close
  15. Home Slider
  16. Popular Product Wrap
  17. Testimonial Wrap
  18. Magnific Popup
  19. Price Slider Active
  20. Plus Minus Button
  21. Buy product add to card
  22. jQuery scroll Nav
  23. Cart modiffication
  24. Sorting




/*--------------------------------
[ End table content ]
-----------------------------------*/


(function($) {
    'use strict';


/*-------------------------------------------
  01. jQuery MeanMenu
--------------------------------------------- */

$('.mobile-menu nav').meanmenu({
    meanMenuContainer: '.mobile-menu-area',
    meanScreenWidth: "991",
    meanRevealPosition: "right",
});

/*-------------------------------------------
  02. wow js active
--------------------------------------------- */
  new WOW().init();


/*-------------------------------------------
  03. Product  Masonry (width)
--------------------------------------------- */
$('.htc__product__container').imagesLoaded( function() {

    // filter items on button click
    $('.product__menu').on( 'click', 'button', function() {
      var filterValue = $(this).attr('data-filter');
      $grid.isotope({ filter: filterValue });
    });
    // init Isotope
    var $grid = $('.product__list').isotope({
      itemSelector: '.single__pro',
      percentPosition: true,
      transitionDuration: '0.7s',
      masonry: {
        // use outer width of grid-sizer for columnWidth
        columnWidth: '.single__pro',
      }
    });

});

$('.product__menu button').on('click', function(event) {
    $(this).siblings('.is-checked').removeClass('is-checked');
    $(this).addClass('is-checked');
    event.preventDefault();
});



/*-------------------------------------------
  04. Sticky Header
--------------------------------------------- */
  var win = $(window);
  var sticky_id = $("#sticky-header-with-topbar");
  win.on('scroll',function() {
    var scroll = win.scrollTop();
    if (scroll < 245) {
      sticky_id.removeClass("scroll-header");
    }else{
      sticky_id.addClass("scroll-header");
    }
  });


/*--------------------------
  05. ScrollUp
---------------------------- */
$.scrollUp({
    scrollText: '<i class="zmdi zmdi-chevron-up"></i>',
    easingType: 'linear',
    scrollSpeed: 900,
    animation: 'fade'
});


/*---------------------------
  06. Tooltip
------------------------------*/
$('[data-toggle="tooltip"]').tooltip({
    animated: 'fade',
    placement: 'top',
    container: 'body'
});


/*-----------------------------------
  07. ScrollReveal Js Init
-------------------------------------- */
    window.sr = ScrollReveal({ duration: 800 , reset: true });
    sr.reveal('.foo');
    sr.reveal('.bar');


/*-------------------------------------------------------
  08. Fixed Footer bottom script ( Newsletter )
--------------------------------------------------------*/

var $newsletter_height = $(".htc__foooter__area");
$('.fixed__footer').css({'margin-bottom': $newsletter_height.height() + 'px'});


/*------------------------------------
  09. Search Bar
--------------------------------------*/

  $( '.search__open' ).on( 'click', function () {
    $( 'body' ).toggleClass( 'search__box__show__hide' );
    return false;
  });

  $( '.search__close__btn .search__close__btn_icon' ).on( 'click', function () {
    $( 'body' ).toggleClass( 'search__box__show__hide' );
    return false;
  });


/*------------------------------------
  10. Toogle Menu
--------------------------------------*/
  $('.toggle__menu').on('click', function() {
    $('.offsetmenu').addClass('offsetmenu__on');
    $('.body__overlay').addClass('is-visible');

  });

  $('.offsetmenu__close__btn').on('click', function() {
      $('.offsetmenu').removeClass('offsetmenu__on');
      $('.body__overlay').removeClass('is-visible');
  });

/*------------------------------------
  11. Shopping Cart Area
--------------------------------------*/

  $('.cart__menu').on('click', function() {
    $('.shopping__cart').addClass('shopping__cart__on');
    $('.body__overlay').addClass('is-visible');

  });

  $('.offsetmenu__close__btn').on('click', function() {
      $('.shopping__cart').removeClass('shopping__cart__on');
      $('.body__overlay').removeClass('is-visible');
  });


/*------------------------------------
  12. Filter Area
--------------------------------------*/

  $('.filter__menu').on('click', function() {
    $('.filter__wrap').addClass('filter__menu__on');
    $('.body__overlay').addClass('is-visible');

  });

  $('.filter__menu__close__btn').on('click', function() {
      $('.filter__wrap').removeClass('filter__menu__on');
      $('.body__overlay').removeClass('is-visible');
  });


/*------------------------------------
  13. User Menu
--------------------------------------*/

  $('.user__menu').on('click', function() {
    $('.user__meta').addClass('user__meta__on');
    $('.body__overlay').addClass('is-visible');

  });

  $('.offsetmenu__close__btn').on('click', function() {
      $('.user__meta').removeClass('user__meta__on');
      $('.body__overlay').removeClass('is-visible');
  });



/*------------------------------------
  14. Overlay Close
--------------------------------------*/
  $('.body__overlay').on('click', function() {
    $(this).removeClass('is-visible');
    $('.offsetmenu').removeClass('offsetmenu__on');
    $('.shopping__cart').removeClass('shopping__cart__on');
    $('.filter__wrap').removeClass('filter__menu__on');
    $('.user__meta').removeClass('user__meta__on');
  });


/*-----------------------------------------------
  15. Home Slider
-------------------------------------------------*/
  if ($('.slider__activation__wrap').length) {
    $('.slider__activation__wrap').owlCarousel({
      loop: true,
      margin:0,
      nav:true,
      autoplay: true,
      navText: [ '<i class="zmdi zmdi-chevron-left"></i>', '<i class="zmdi zmdi-chevron-right"></i>' ],
      autoplayTimeout: 10000,
      items:1,
      dots: true,
      lazyLoad: true,
      responsive:{
        0:{
          items:1
        },
        600:{
          items:1
        },
        800:{
          items:1
        },
        1024:{
          items:1
        },
        1200:{
          items:1
        },
        1400:{
          items:1
        },
        1920:{
          items:1
        }
      }
    });
  }

/*-----------------------------------------------
  16. Popular Product Wrap
-------------------------------------------------*/
  $('.popular__product__wrap').owlCarousel({
      loop: true,
      margin:0,
      nav:true,
      autoplay: true,
      navText: [ '<i class="zmdi zmdi-chevron-left"></i>', '<i class="zmdi zmdi-chevron-right"></i>' ],
      autoplayTimeout: 10000,
      items:3,
      dots: true,
      lazyLoad: true,
      responsive:{
        0:{
          items:1
        },
        600:{
          items:2
        },
        800:{
          items:2
        },
        1024:{
          items:3
        },
        1200:{
          items:3
        },
        1400:{
          items:3
        },
        1920:{
          items:3
        }
      }
    });


/*-----------------------------------------------
  17.  product-slider-active
-------------------------------------------------*/
  $('.single-portfolio-slider').owlCarousel({
      loop: true,
      autoplay: true,
      nav:true,
      navText: [ '<i class="zmdi zmdi-chevron-left"></i>', '<i class="zmdi zmdi-chevron-right"></i>' ],
      items:1,
      nav: true,
      dots: true,
      responsive:{
        0:{
          items:1
        },
        600:{
          items:1
        },
        800:{
          items:1
        },
        1024:{
          items:1
        },
        1200:{
          items:1
        },
        1400:{
          items:1
        },
        1920:{
          items:1
        }
      }
    });


/*-----------------------------------------------
  17.  product-slider-active
-------------------------------------------------*/


  $('.product-slider-active').owlCarousel({
      loop: true,
      margin:0,
      autoplay: true,
      smartSpeed: 200,
      nav:true,
      dots: true,
      navText: [ '<i class="zmdi zmdi-chevron-left"></i>', '<i class="zmdi zmdi-chevron-right"></i>' ],
      items:3,
      responsive:{
        0:{
          items:1
        },
        600:{
          items:2
        },
        800:{
          items:2
        },
        1024:{
          items:3
        },
        1200:{
          items:3
        },
        1400:{
          items:3
        },
        1920:{
          items:3
        }
      }
    });


/*-----------------------------------------------
  17.  product-details-slider
-------------------------------------------------*/


  $('.product-details-slider').owlCarousel({
      loop: true,
      margin:20,
      nav:true,
      dots: true,
      navText: [ '<i class="zmdi zmdi-chevron-left"></i>', '<i class="zmdi zmdi-chevron-right"></i>' ],
      items:3,
      responsive:{
        0:{
          items:1
        },
        600:{
          items:2
        },
        800:{
          items:2
        },
        1024:{
          items:3
        },
        1200:{
          items:3
        },
        1400:{
          items:3
        },
        1920:{
          items:3
        }
      }
    });


/*-----------------------------------------------
  18.  portfolio-slider-active
-------------------------------------------------*/


  $('.portfolio-slider-active').owlCarousel({
      loop: true,
      dotsEach: 1,
      nav:true,
      dots: true,
      items:3,
      responsive:{
        0:{
          items:1
        },
        600:{
          items:2
        },
        800:{
          items:2
        },
        1024:{
          items:3
        },
        1200:{
          items:3
        },
        1400:{
          items:3
        },
        1920:{
          items:3
        }
      }
    });

/*-----------------------------------------------
 18. About us comments slider testimonial__wrap
------------------------------------------------*/  
  $('.testimonial__wrap').owlCarousel({
      loop: true,
      dotsEach: 1,
      nav:false,
      dots: true,
      autoplay: true,
      items:1,
      responsive:{
        0:{
          items:1
        },
        600:{
          items:1
        },
        800:{
          items:1
        },
        1024:{
          items:1
        },
        1200:{
          items:1
        },
        1400:{
          items:1
        },
        1920:{
          items:1
        }
      }
    });



/*-----------------------------------------------
  17. Testimonial Wrap
-------------------------------------------------*/


  $('.testimonial__wrap').owlCarousel({
      loop: true,
      margin:0,
      nav:false,
      autoplay: false,
      navText: false,
      autoplayTimeout: 10000,
      items:1,
      dots: false,
      lazyLoad: true,
      responsive:{
        0:{
          items:1
        },
        600:{
          items:1
        },
        800:{
          items:1
        },
        1024:{
          items:1
        },
        1200:{
          items:1
        },
        1400:{
          items:1
        },
        1920:{
          items:1
        }
      }
    });




/*--------------------------------
  18. Magnific Popup
----------------------------------*/

$('.video-popup').magnificPopup({
  type: 'iframe',
  mainClass: 'mfp-fade',
  removalDelay: 160,
  preloader: false,
  zoom: {
      enabled: true,
  }
});

$('.image-popup').magnificPopup({
  type: 'image',
  mainClass: 'mfp-fade',
  removalDelay: 100,
  gallery:{
      enabled:true,
  }
});


/*-------------------------------
  19. Price Slider Active
--------------------------------*/
  $("#slider-range").slider({
      range: true,
      min: 1,
      max: 3000,
      values: [1, 3000],
      slide: function(event, ui) {
          $("#amountMin").val(ui.values[0]);
          $("#amountMax").val(ui.values[1]);
      }
  });
  
  $("#amountMin").val($("#slider-range").slider("values", 0));
  $("#amountMax").val($("#slider-range").slider("values", 1));


/*-------------------------------
  20.  Plus Minus Button
--------------------------------*/

    $(".cart-plus-minus").append('<div class="dec qtybutton">&mdash;</i></div><div class="inc qtybutton">+</div>');

    $(".qtybutton").on("click", function () {
        var $button = $(this);
        var oldValue = $button.parent().find("input").val();
        if ($button.text() == "+") {
            var newVal = parseFloat(oldValue) + 1;
        } else {
            // Don't allow decrementing below zero
            if (oldValue > 1) {
                var newVal = parseFloat(oldValue) - 1;
            } else {
                newVal = 1;
            }
        }
        $button.parent().find("input").val(newVal);
    });
  
  
/*--------------------------
  21. Buy product add to card
---------------------------- */
  // Отправляем товар в корзину

    $(".to-cart").on('click', function(e){
        e.preventDefault();
        let itemID = $(this).attr("data-item-id");
        $.ajax({
            type: "POST",
            url: "/engine/handlers/to-cart.php",
            data: {
              'itemID': itemID
            },
            cache: false,
            responseType: "json"
        });
      setTimeout(function(){location.reload();},500);
    });
  

  
    $(".buy__now__btn").on('click', function(){
        let quantity = $("#coun").val();
        let itemID = $(this).attr("data-item-id");
        if (quantity < 1) {
          quantity = 1
        }
        $.ajax({
            type: "POST",
            url: "/engine/handlers/to-cart.php",
            data: {
                'quantity': quantity,
                'itemID': itemID,
            },
            cache: false,
            responseType: "json"
        });
      setTimeout(function(){location.reload();},500);
    });
  
    $("#coun").keyup(function(e){
      if (e.which === 13) {
        let quantity = $("#coun").val();
        let itemID = $(this).attr("data-item-id");
        if (quantity < 1) {
          quantity = 1
        }
        $.ajax({
          type: "POST",
          url: "/engine/handlers/to-cart.php",
          data: {
            'quantity': quantity,
            'itemID': itemID,
          },
          cache: false,
          responseType: "json"
        });
        setTimeout(function(){location.reload();},500);
      }
    });
  


/*--------------------------
  22. jQuery scroll Nav
---------------------------- */
    $('.onepage--menu').onePageNav({
        scrollOffset: 0
    });



/*---------------------
    countdown
  --------------------- */
    $('[data-countdown]').each(function() {
		var $this = $(this), finalDate = $(this).data('countdown');
		$this.countdown(finalDate, function(event) {
		$this.html(event.strftime('<span class="cdown day">%-D <p>Days</p></span> <span class="cdown hour">%-H <p>Hour</p></span> <span class="cdown minutes">%M <p>Min</p></span class="cdown second"> <span>%S <p>Sec</p></span>'));
		});
    });


/* isotop active */
    var $grid = $('.grid');
    var $gridJustified = $('.grid-justified');
    var $gridItems = '.grid-item';
    // filter items on button click
    $grid.imagesLoaded(function() {

        $('.portfolio-menu-active').on('click', 'button', function() {
            $(this).siblings('.active').removeClass('active');
            $(this).addClass('active');
            var filterValue = $(this).attr('data-filter');
            $grid.isotope({
                filter: filterValue
            });
        });

        // init Isotope
        $grid.isotope({
            itemSelector: $gridItems,
            percentPosition: true,
            masonry: {
                // use outer width of grid-sizer for columnWidth
                columnWidth: $gridItems,
            }
        });

        // init Isotope
        $gridJustified.isotope({
            itemSelector: $gridItems,
            percentPosition: true,
            layoutMode: 'fitRows',
            masonry: {
                // use outer width of grid-sizer for columnWidth
                columnWidth: 1,
            }
        });
    });


    /*--
    Magnific Popup
    ------------------------*/
    $('.img-poppu').magnificPopup({
        type: 'image',
        gallery:{
            enabled:true
        }
    });


    $('.sidebar-active').stickySidebar({
        topSpacing: 80,
        bottomSpacing: 30,
        minWidth: 767,
    });
    
    /*--
    23. Cart modiffication
    ------------------------*/
      
    $(".prod_qty_cart").change(function(){
      let itemID = $(this).attr("data-item-id");
      let recountValueId = '#recount_cart_value_'+itemID;
      let quantity = $(this).val();
      $.ajax({
          type: "POST",
          url: "/engine/handlers/reCount.php",
          data: {
              'quantity': quantity,
              'itemID': itemID,
          },
          cache: false,
          responseType: "json"
      });
      setTimeout(function(){location.reload();},2000);
    });

    $(".prod_qty_cart").on('keypress', function(e){
      if (e.code===13) {
        let itemID = $(this).attr("data-item-id");
        let recountValueId = '#recount_cart_value_'+itemID;
        let quantity = $(this).val();
        $.ajax({
            type: "POST",
            url: "/engine/handlers/reCount.php",
            data: {
                'quantity': quantity,
                'itemID': itemID,
            },
            cache: false,
            responseType: "json"
        });
      setTimeout(function(){location.reload();},1000);
      }
    });
  
  
  
    $('#self_ship').on('click', function () {
      $("#shiping_status").addClass('d-none');
      $("#shiping_status").removeClass('d-block');
      $("#shiping_address").addClass('d-none');
      $("#shiping_address").removeClass('d-block');
      $.ajax({
          type: "POST",
          url: "/engine/handlers/delivery.php",
          data: {
            'delivery': 'Самовывоз (г. Черкассы, ул. Хоменка, 17)'
          },
          cache: false,
          responseType: "json"
      });
    });
  
    $('#nova_poshta').on('click', function () {
      $("#shiping_status").removeClass('d-none');
      $("#shiping_status").addClass('d-block');
      $("#shiping_address").removeClass('d-none');
      $("#shiping_address").addClass('d-block');
      $.ajax({
          type: "POST",
          url: "/engine/handlers/delivery.php",
          data: {
            'delivery': 'Компания "Новая почта" (уточнять у перевозчика)'
          },
          cache: false,
          responseType: "json"
      });
    });
    
    $('#company_ship').on('click', function () {
      $("#shiping_status").removeClass('d-none');
      $("#shiping_status").addClass('d-block');
      $("#shiping_address").removeClass('d-none');
      $("#shiping_address").addClass('d-block');
      
      $.ajax({
          type: "POST",
          url: "/engine/handlers/delivery.php",
          data: {
            'delivery': 'Доставка транспортом компании (срок и стоимость доставки уточняет менеджер магазина)'
          },
          cache: false,
          responseType: "json"
      });
    });   
  
    $('#form-send').on('click', function () {
      let city = $("#city_ship").val();
      let street = $("#region_ship").val();
      let home = $("#build_ship").val();
      let appartment = $("#apart_ship").val();
      
      $.ajax({
          type: "POST",
          url: "/engine/handlers/delivAddress.php",
          data: {
            'city': city,
            'street': street,
            'home': home,
            'appartment': appartment
          },
          cache: false,
          responseType: "json"
      });
    });
  
    function dataCheck(field) {
      let check=$("#"+field).val();
      if (check==""){
        $("#"+field).css("border","2px solid #ff4136");
        window.location.href="#titleForm";
        return false;
      } else {
        $("#"+field).css("border","2px solid #28a745;");
        return true;
      }
    }
  

  
    $("#paysType").click(function () {
      if ($("#paysType option:selected").val() === 'cashless_pay') {
        $("#payment-details").removeClass("d-none");
        $("#payment-details").addClass("d-block");
      } else {
        $("#payment-details").removeClass("d-block");
        $("#payment-details").addClass("d-none");
      }
    }); 

  
  
    $("#orderForm").click(function () {
      let name = $("#firstName").val();
      let secondName = $("#secondName").val();
      let email = $("#email").val();
      let phone = $("#phone").val();
      let text = $("#text").val();
      let paysType = $("#paysType option:selected").text(); 
      let itemTitle = $(".itemTitle").text();
      let prodQTY = $(".quantity").text();
      let totalSum = $("#sum2").text();
      let totalQTY = $("#col2").text();
      let formMessages = $('.form-messege');
        
      if (!dataCheck("name")) return false;
      if (!dataCheck("phone")) return false;
            
      $.ajax({
        type: "POST",
        url: "/engine/handlers/order.php",
        data: {
          'name': name,
          'secondName': secondName,
          'email': email,
          'phone': phone,
          'text': text,
          'paysType': paysType,
          'itemTitle': itemTitle,
          'quantity': prodQTY,
          'sum2': totalSum,
          'col2': totalQTY
        },
        cache: false,
        responseType: "json"
      }).done((data) => {
        let successText = 'Ваше сообщение отправлено! Спасибо за Ваш заказ. Ожидайте звонка от менеджера!'
        if (data === successText) {
          $(formMessages).removeClass('error');
          $(formMessages).addClass('success');
          $(formMessages).text(data);
          document.cookie = 'PHPSESSID=; Path=/; Expires=Thu, 01 Jan 1970 00:00:01 GMT;';
          setTimeout(() => {
            window.location.href = '/';
          }, 5000)
        } else {
          $(formMessages).removeClass('success');
          $(formMessages).addClass('error');
          $(formMessages).text(data);
//          console.error('Data Error Message: '+ data)
        }
      });
  });
  
  
  
    /*--
    24. Sorting (Price, date, favorite, rating)
    ------------------------*/
  $('#sorted').change(function () {          
    let items = $('#grid-view .product-sort');
    let itemsDesc = $('#list-view .single__list__content ');
    let arItems = jQuery.makeArray(items);
    let arItemsDesc = jQuery.makeArray(itemsDesc);
    
    if ($(this).val() === 'incr') {
      arItems.sort((a, b) => $(a).data('price') - $(b).data('price'));
      arItemsDesc.sort((a, b) => $(a).data('price') - $(b).data('price'));
    }
    
    if ($(this).val() === 'decr') {
      arItems.sort((a, b) => $(b).data('price') - $(a).data('price'));
      arItemsDesc.sort((a, b) => $(b).data('price') - $(a).data('price'));
    }
    
    if ($(this).val() === 'date') {
      arItems.sort((a, b) => $(b).data('date') - $(a).data('date'));
      arItemsDesc.sort((a, b) => $(b).data('date') - $(a).data('date'));
    }
    
    if ($(this).val() === 'fav') {      
      arItems.sort((a, b) => $(b).data('fav') - $(a).data('fav'));
      arItemsDesc.sort((a, b) => $(b).data('fav') - $(a).data('fav'));
    }
    
    if ($(this).val() === 'rating') {      
      arItems.sort((a, b) => $(b).data('rating') - $(a).data('rating'));
      arItemsDesc.sort((a, b) => $(b).data('rating') - $(a).data('rating'));
    }
    
    $(arItems).appendTo('#grid-view');
    $(arItemsDesc).appendTo('#list-view');
  })
  .change();

  
 
  
})(jQuery);

function copyText(copyEl, showMes) {
  var $temp = $("<input>");
  $("body").append($temp);
  $temp.val($(copyEl).text()).select();
  document.execCommand("copy");
  $temp.remove();
  $(showMes).removeClass('d-none');
  $(showMes).addClass('d-inline');
  setTimeout(function(){
    $(showMes).removeClass('d-inline');
    $(showMes).addClass('d-none');    
  },3000);
}