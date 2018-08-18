(function ($) {

    "use strict";
    $(".carousel-inner .item:first-child").addClass("active");
    /* Mobile menu click then remove
    ==========================*/
    $(".mainmenu-area #mainmenu li a").on("click", function () {
        $(".navbar-collapse").removeClass("in");
    });
    /*WoW js Active
    =================*/
    new WOW().init({
        mobile: true,
    });
    // :: 4.0 ScrollUp Active Code
        if ($.fn.scrollUp) {
            $.scrollUp({
                scrollSpeed: 1500,
                scrollText: '<i class="fa fa-angle-up"></i>'
            });
        }
    /* testimonials Slider Active
    =============================*/
    $('.testimonials').owlCarousel({
        loop: true,
        margin: 0,
        responsiveClass: true,
        nav: true,
        autoplay: true,
        autoplayTimeout: 4000,
        smartSpeed: 1000,
        navText: ['<i class="ti-arrow-left"></i>', '<i class="ti-arrow-right" ></i>'],
        items: 1
    });
    /* testimonials Slider Active
    =============================*/
    $('.screen-slider').owlCarousel({
        loop: true,
        margin: 0,
        responsiveClass: true,
        nav: true,
        autoplay: true,
        autoplayTimeout: 4000,
        smartSpeed: 1000,
        navText: ['<i class="ti-arrow-left"></i>', '<i class="ti-arrow-right" ></i>'],
        items: 1,
        animateIn: 'fadeIn',
        animateOut: 'fadeOut',
        center: true,
    });
    /* testimonials Slider Active
    =============================*/
    $('.clients').owlCarousel({
        loop: true,
        margin: 30,
        responsiveClass: true,
        nav: true,
        autoplay: true,
        autoplayTimeout: 4000,
        smartSpeed: 1000,
        navText: ['<i class="ti-arrow-left"></i>', '<i class="ti-arrow-right" ></i>'],
        responsive: {
            0: {
                items: 3,
            },
            600: {
                items: 4
            },
            1000: {
                items: 6
            }
        }
    });
    /*--------------------
       MAGNIFIC POPUP JS
       ----------------------*/
    var magnifPopup = function () {
        $('.work-popup').magnificPopup({
            type: 'image',
            removalDelay: 300,
            mainClass: 'mfp-with-zoom',
            gallery: {
                enabled: true
            },
            zoom: {
                enabled: true, // By default it's false, so don't forget to enable it

                duration: 300, // duration of the effect, in milliseconds
                easing: 'ease-in-out', // CSS transition easing function

                // The "opener" function should return the element from which popup will be zoomed in
                // and to which popup will be scaled down
                // By defailt it looks for an image tag:
                opener: function (openerElement) {
                    // openerElement is the element on which popup was initialized, in this case its <a> tag
                    // you don't need to add "opener" option if this code matches your needs, it's defailt one.
                    return openerElement.is('img') ? openerElement : openerElement.find('img');
                }
            }
        });
    };
    // Call the functions 
    magnifPopup();

    //Background Parallax
    $('.header-area').parallax("50%", -0.6);
    $('#section-observation').parallax("50%", -0.4);
    $('.header-area-register').parallax("50%", -0.6);
    $('.header-area-checkEmail').parallax("50%", -0.6);
    $('.header-area-login').parallax("50%", -0.6);
    $('.header-area-profile').parallax("50%", -0.6);
    $('.header-area-blog').parallax("50%", -0.6);
    $('.header-area-contact').parallax("50%", -0.6);
    $('.header-area-map').parallax("50%", -0.6);
    $('.header-area-observation').parallax("50%", -0.6);
    $('.header-area-observationWaiting').parallax("50%", -0.6);
    $('.header-area-observationValidate').parallax("50%", -0.6);
    $('.header-area-observationDraft').parallax("50%", -0.6);
    $('.header-area-fiches').parallax("50%", -0.6);
    $('.header-area-ficheNew').parallax("50%", -0.6);
    $('.header-area-ficheWaiting').parallax("50%", -0.6);
    $('.header-area-ficheValidate').parallax("50%", -0.6);
    $('.header-area-ficheDraft').parallax("50%", -0.6);
    $('.header-area-game').parallax("50%", -0.6);
    $('.price-area').parallax("50%", -0.5);
    $('.testimonial-area').parallax("10%", -0.2);


    $('#accordion .panel-title a').prepend('<span></span>');












    // Select all links with hashes
    $('.mainmenu-area a[href*="#"]')
        // Remove links that don't actually link to anything
        .not('[href="#"]')
        .not('[href="#0"]')
        .click(function (event) {
            // On-page links
            if (
                location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') &&
                location.hostname == this.hostname
            ) {
                // Figure out element to scroll to
                var target = $(this.hash);
                target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
                // Does a scroll target exist?
                if (target.length) {
                    // Only prevent default if animation is actually gonna happen
                    event.preventDefault();
                    $('html, body').animate({
                        scrollTop: target.offset().top
                    }, 1000, function () {
                        // Callback after animation
                        // Must change focus!
                        var $target = $(target);
                        $target.focus();
                        if ($target.is(":focus")) { // Checking if the target was focused
                            return false;
                        } else {
                            $target.attr('tabindex', '-1'); // Adding tabindex for elements not focusable
                            $target.focus(); // Set focus again
                        };
                    });
                }
            }
        });






    /* Preloader Js
    ===================*/
    $(window).on("load", function () {
        $('.preloader').fadeOut(500);
    });
})(jQuery);