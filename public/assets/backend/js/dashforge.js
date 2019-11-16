$(function () {
    'use strict';
    feather.replace();

    ////////// NAVBAR //////////
    if (window.matchMedia('(max-width: 991px)').matches) {
        if ($('#navbarMenu').length) {
            const psNavbar = new PerfectScrollbar('#navbarMenu', {
                suppressScrollX: true
            });
        }
    }

    // Showing sub-menu of active menu on navbar when mobile
    function showNavbarActiveSub() {
        if (window.matchMedia('(max-width: 991px)').matches) {
            $('#navbarMenu .active').addClass('show');
        } else {
            $('#navbarMenu .active').removeClass('show');
        }
    }

    showNavbarActiveSub();
    $(window).resize(function () {
        showNavbarActiveSub()
    });

    // Initialize backdrop for overlay purpose
    $('body').append('<div class="backdrop"></div>');

    // Showing sub menu of navbar menu while hiding other siblings
    $('.navbar-menu .with-sub .nav-link').on('click', function (e) {
        e.preventDefault();
        $(this).parent().toggleClass('show');
        $(this).parent().siblings().removeClass('show');
        if (window.matchMedia('(max-width: 991px)').matches) {
            psNavbar.update();
        }
    });

    $(document).on('click touchstart', function (e) {
        e.stopPropagation();
        if (window.matchMedia('(min-width: 992px)').matches) {
            const navTarg = $(e.target).closest('.navbar-menu .nav-item').length;
            if (!navTarg) {
                $('.navbar-header .show').removeClass('show');
            }
        }
    });

    $('#mainMenuClose').on('click', function (e) {
        e.preventDefault();
        $('body').removeClass('navbar-nav-show');
    });

    $('#sidebarMenuOpen').on('click', function (e) {
        e.preventDefault();
        $('body').addClass('sidebar-show');
    });

    $('#navbarSearch').on('click', function (e) {
        e.preventDefault();
        $('.navbar-search').addClass('visible');
        $('.backdrop').addClass('show');
    });

    $('#navbarSearchClose').on('click', function (e) {
        e.preventDefault();
        $('.navbar-search').removeClass('visible');
        $('.backdrop').removeClass('show');
    });


    ////////// SIDEBAR //////////
    if ($('#sidebarMenu').length) {
        const psSidebar = new PerfectScrollbar('#sidebarMenu', {
            suppressScrollX: true
        });

        $('.sidebar-nav .with-sub').on('click', function (e) {
            e.preventDefault();
            $(this).parent().toggleClass('show');
            psSidebar.update();
        });
    }

    $('#mainMenuOpen').on('click touchstart', function (e) {
        e.preventDefault();
        $('body').addClass('navbar-nav-show');
    });

    $('#sidebarMenuClose').on('click', function (e) {
        e.preventDefault();
        $('body').removeClass('sidebar-show');
    });

    $(document).on('click touchstart', function (e) {
        e.stopPropagation();
        if (!$(e.target).closest('.burger-menu').length) {
            const sb = $(e.target).closest('.sidebar').length;
            const nb = $(e.target).closest('.navbar-menu-wrapper').length;
            if (!sb && !nb) {
                if ($('body').hasClass('navbar-nav-show')) {
                    $('body').removeClass('navbar-nav-show');
                } else {
                    $('body').removeClass('sidebar-show');
                }
            }
        }
    });
});
