import $ from "jquery";

$(document).on('ready', function () {
    $('.navbar-light .navbar-nav li a').on('click', function (e) {
        let anchor = $(this);
        $('html, body').stop().animate({
            scrollTop: $(anchor.attr('href')).offset().top - 50
        }, 1500);
        e.preventDefault();
    });
    $('.navbar .navbar-nav li a').on('click', function () {
        $('.navbar-collapse').collapse('hide');
    });

    $(window).on('scroll', function () {
        if ($(this).scrollTop() > 120) {
            $('.navbar').addClass("is-sticky");
        } else {
            $('.navbar').removeClass("is-sticky");
        }
    });
});

$(window).on('load', () => {
    if ($(".wow").length) {
        const wow = new WOW({
            boxClass: 'wow',
            animateClass: 'animated',
            offset: 20,
            mobile: true,
            live: true,
        });
        wow.init();
    }
});

$(window).on('load', () => $('.preloader').addClass('preloader-deactivate'));
