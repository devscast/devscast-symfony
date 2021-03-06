import $ from 'jquery'
import 'bootstrap/js/dist/tooltip'
import feather from 'feather-icons'
import PerfectScrollbar from 'perfect-scrollbar'

export default class Layout {
    constructor() {
        feather.replace();
        $('[data-toggle="tooltip"]').tooltip();

        // search bar
        $('#navbarSearch').on('click', e => {
            e.preventDefault();
            $('.navbar-search').addClass('visible');
            $('.backdrop').addClass('show');
        });

        $('#navbarSearchClose').on('click', e => {
            e.preventDefault();
            $('.navbar-search').removeClass('visible');
            $('.backdrop').removeClass('show');
        });

        // Initialize PerfectScrollbar of navbar menu for mobile only
        if (window.matchMedia('(max-width: 991px)').matches && $('#navbarMenu').length) {
            new PerfectScrollbar('#navbarMenu', {suppressScrollX: true});
        }

        // Showing sub-menu of active menu on navbar when mobile
        const showNavbarActiveSub = () => {
            if (window.matchMedia('(max-width: 991px)').matches) {
                $('#navbarMenu .active').addClass('show');
            } else {
                $('#navbarMenu .active').removeClass('show');
            }
        };

        showNavbarActiveSub();
        $(window).resize(function () {
            showNavbarActiveSub()
        });

        // Initialize a backdrop for overlay purpose
        $('body').append('<div class="backdrop"></div>');

        // Showing sub menu of navbar menu while hiding other siblings
        $('.navbar-menu .with-sub .nav-link').on('click', e => {
            e.preventDefault();
            $(this).parent().toggleClass('show');
            $(this).parent().siblings().removeClass('show');

            if (window.matchMedia('(max-width: 991px)').matches) {
                psNavbar.update();
            }
        });

        // Closing dropdown menu of navbar menu
        $(document).on('click touchstart', e => {
            e.stopPropagation();

            // closing nav sub menu of header when clicking outside of it
            if (window.matchMedia('(min-width: 992px)').matches) {
                const navTarg = $(e.target).closest('.navbar-menu .nav-item').length;
                if (!navTarg) {
                    $('.navbar-header .show').removeClass('show');
                }
            }
        });

        $('#mainMenuClose').on('click', e => {
            e.preventDefault();
            $('body').removeClass('navbar-nav-show');
        });

        $('#sidebarMenuOpen').on('click', e => {
            e.preventDefault();
            $('body').addClass('sidebar-show');
        });

        // Initialize PerfectScrollbar for sidebar menu
        if ($('#sidebarMenu').length) {
            const psSidebar = new PerfectScrollbar('#sidebarMenu', {suppressScrollX: true});

            // Showing sub menu in sidebar
            $('.sidebar-nav .with-sub').on('click', e => {
                e.preventDefault();
                $(this).parent().toggleClass('show');
                psSidebar.update();
            })
        }

        $('#mainMenuOpen').on('click touchstart', e => {
            e.preventDefault();
            $('body').addClass('navbar-nav-show');
        });

        $('#sidebarMenuClose').on('click', e => {
            e.preventDefault();
            $('body').removeClass('sidebar-show');
        });

        // hide sidebar when clicking outside of it
        $(document).on('click touchstart', e => {
            e.stopPropagation();
            const body = $('body');

            // closing of sidebar menu when clicking outside of it
            if (!$(e.target).closest('.burger-menu').length) {
                const sb = $(e.target).closest('.sidebar').length;
                const nb = $(e.target).closest('.navbar-menu-wrapper').length;
                if (!sb && !nb) {
                    if (body.hasClass('navbar-nav-show')) {
                        body.removeClass('navbar-nav-show');
                    } else {
                        body.removeClass('sidebar-show');
                    }
                }
            }
        });
    }
}
