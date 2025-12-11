// JavaScript Document
$(document).ready(function () {
    $(window).on("scroll", function () {
        if ($(this).scrollTop() > 20.99) {
            $("body").addClass("sticky_white_header");
        } else {
            $("body").removeClass("sticky_white_header");
        }
    });

    $(".mobile.dropdown").hover(
        function () {
            $(this).addClass("open");
        },
        function () {
            $(this).removeClass("open");
        }
    );

    $(".option-select").chosen({ disable_search_threshold: 10 });
    $(".same-height").responsiveEqualHeightGrid();


    





    $(function () {
        if (navigator.userAgent.indexOf("Mac OS X") != -1) {
            $(".abc").css("line-height", "40px");
        }

        if (
            navigator.userAgent.indexOf("Mac") > 0 &&
            navigator.userAgent.indexOf("Firefox") > 0
        ) {
            $(".abc").css("line-height", "38px");
        }

        if (
            navigator.userAgent.indexOf("Mac") > 0 &&
            navigator.userAgent.indexOf("Chrome") > 0
        ) {
            $(".abc").css("line-height", "40px");
        }
    });



    $("#menu__opener").click(function () {
        $("body").addClass("menu_active");
    });

    $("#sidebar_hide").click(function () {
        $("body").removeClass("menu_active");
    });

    $(".header_signUP a").click(function () {
        $("body").removeClass("menu_active");
    });


    $(".grid-sc-view").click(function () {
        $(".course-listing-row").addClass("course-list-view");
    });
    $(".list-sc-view").click(function () {
        $(".course-listing-row").removeClass("course-list-view");
    });






    


    jQuery("#banner_slider").owlCarousel({
        loop: true,
        margin: 0,
        responsiveClass: true,
        autoplay: true,
        nav: false,
        dots: true,
        responsive: {
            0: {
                items: 1,
                margin: 0,
            },
            480: {
                items: 1,
                margin: 0,
            },
            640: {
                items: 1,
                margin: 0,
            },
            768: {
                items: 1,
                margin: 0,
            },
            992: {
                items: 1,
                margin: 0,
            },
            1200: {
                items: 1,
                margin: 0,
            },
            1492: {
                items: 1,
                margin: 0,
            },
        },
    });

    jQuery(".service-slider").owlCarousel({
        loop: true,
        margin: 0,
        responsiveClass: true,
        autoplay: true,
        nav: false,
        dots: true,
        responsive: {
            0: {
                items: 1,
                margin: 0,
            },
            480: {
                items: 1,
                margin: 0,
            },
            640: {
                items: 1,
                margin: 0,
            },
            768: {
                items: 2,
                margin: 30,
            },
            992: {
                items: 2,
                margin: 30,
            },
            1200: {
                items: 2,
                margin: 30,
            },
            1492: {
                items: 2,
                margin: 30,
            },
        },
    });

    jQuery(".testimonial_slider").owlCarousel({
        loop: true,
        margin: 0,
        responsiveClass: true,
        autoplay: true,
        nav: false,
        dots: true,
        responsive: {
            0: {
                items: 1,
                margin: 0,
            },
            480: {
                items: 1,
                margin: 0,
            },
            640: {
                items: 1,
                margin: 0,
            },
            768: {
                items: 1,
                margin: 0,
            },
            992: {
                items: 1,
                margin: 0,
            },
            1200: {
                items: 1,
                margin: 0,
            },
            1492: {
                items: 1,
                margin: 0,
            },
        },
    });

    

    


    



    horizontalScroll();

    function horizontalScroll(){
        var windowWidth = jQuery(window).outerWidth();

        if(windowWidth < 768){
            $(".mcs-horizontal-example").mCustomScrollbar({
                axis:"x",
                theme:"dark-3",
                documentTouchScroll:true
            });
        }else{
            //$(".mcs-horizontal-example").mCustomScrollbar('destroy');
        }
    }

    jQuery(window).on('resize', horizontalScroll);


    






    function centerModals($element) {
          var $modals;
          if ($element.length) {
            $modals = $element;
          } else {
            $modals = jQuery('.modal-vcenter:visible');
          }
          $modals.each( function(i) {
            var $clone = jQuery(this).clone().css('display', 'block').appendTo('body');
            var top = Math.round(($clone.height() - $clone.find('.modal-content').height()) / 2);
            top = top > 0 ? top : 0;
            $clone.remove();
            jQuery(this).find('.modal-content').css("margin-top", top);
          });
    }

    jQuery('.modal-vcenter').on('show.bs.modal', function(e) {
      centerModals($(this));
    });
    jQuery(window).on('resize', centerModals);






});
