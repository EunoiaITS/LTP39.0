
(function($) {

  "use strict";

  /*--========================================
  Loader fadeout
  ======================================--*/
  
  $('#svgLoader').delay(2500).fadeOut('fade');

	/*=======================================================
    // Vertical Center Welcome
    ======================================================*/
    setInterval(function () {
        var widnowHeight = $(window).height();
        var introHeight = $(".parking-kori-login").height();
        var paddingTop = widnowHeight - introHeight;
        $(".parking-kori-login").css({
            'padding-top': Math.round(paddingTop / 2) + 'px',
            'padding-bottom': Math.round(paddingTop / 2) + 'px'
        });
    }, 10);

    /*--========================
    // nice scroll
    =========================-*/

    $("body").niceScroll({
	   cursorwidth:"6px"
	 });

   // *page scroll to id

    $(" #navbar a, .navbar-brand").mPageScroll2id({
       highlightClass: "active-home"
    });

    /* ********************************************
    STICKY sticky-header
    ******************************************** */

    var hth = $('.navbar-default.navbar-fixed-top').height();
    $(window).on('scroll', function() {
        if ($(this).scrollTop() > hth){  
            $('.navbar-default.navbar-fixed-top').addClass("sticky");
        }
        else{
            $('.navbar-default.navbar-fixed-top').removeClass("sticky");
        }
    });


    /* ********************************************
    slicl slider
    ******************************************** */
    $('.item-slick-carosel').slick({
      infinite: true,
      slidesToShow: 3,
      slidesToScroll: 3,
      dots: true,
      responsive: [
            {
              breakpoint: 1024,
              settings: {
                slidesToShow: 2,
                slidesToScroll: 2,
                infinite: true,
                dots: true
              }
            },
            {
              breakpoint: 767,
              settings: {
                slidesToShow: 2,
                slidesToScroll: 2
              }
            },
            {
              breakpoint: 600,
              settings: {
                slidesToShow: 1,
                slidesToScroll: 1
              }
            }
          ]
    });


})(window.jQuery);
