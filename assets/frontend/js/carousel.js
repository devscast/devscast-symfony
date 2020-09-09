import '@splidejs/splide/dist/css/splide.min.css'
import Splide from '@splidejs/splide'

document.addEventListener('DOMContentLoaded', function () {
    new Splide('#blog', {
        perPage: 4,
        perMove: 2,
        autoHeight: true,
        pagination: true,
        gap: 16,
        arrows: false,
        classes: {
            pagination: 'blog-control',
            page: 'dot',
        },
        breakpoints: {
            640: {
                perPage: 1,
            },
            768: {
                perPage: 2,
            },
            1024: {
                perPage: 3,
                gap: 6,
            },
        }
    }).mount();

    new Splide('#team', {
        type: 'loop',
        autoplay: true,
        perPage: 3,
        perMove: 1,
        autoHeight: true,
        pagination: false,
        gap: 16,
        arrows: true,
        breakpoints: {
            640: {
                perPage: 1,
                autoplay: true,
            },
            768: {
                perPage: 2,
                gap: 10,
                autoplay: true,
            },
            1024: {
                perPage: 2,
                gap: 6,
                autoplay: true,
            },
        }
    }).mount();
});
