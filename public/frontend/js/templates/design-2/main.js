document.addEventListener('DOMContentLoaded', function () {


    /*
    |--------------------------------------------------------------------------
    | Slick Slider
    |--------------------------------------------------------------------------
    */

    if (typeof window.jQuery === 'undefined') {
        console.error('jQuery is not loaded.');
        return;
    }

    if (typeof $.fn.slick === 'undefined') {
        console.error('Slick Carousel is not loaded.');
        return;
    }


    /*
    |--------------------------------------------------------------------------
    | Hero Slider
    |--------------------------------------------------------------------------
    */

    const $heroSlider = $('.hero__slider');

    if ($heroSlider.length && $heroSlider.children().length > 0) {
        if (!$heroSlider.hasClass('slick-initialized')) {
            $heroSlider.slick({
                slidesToShow: 1,
                slidesToScroll: 1,
                infinite: true,
                arrows: true,
                dots: true,
                autoplay: true,
                autoplaySpeed: 5000,
                speed: 700,
                fade: true,
                cssEase: 'linear'
            });
        }
    }


    /*
    |--------------------------------------------------------------------------
    | Categories Slider
    |--------------------------------------------------------------------------
    */

    const $categoriesSlider = $('.categories__slider');

    if ($categoriesSlider.length && $categoriesSlider.children().length > 0) {
        if (!$categoriesSlider.hasClass('slick-initialized')) {
            $categoriesSlider.slick({
                slidesToShow: 6,
                slidesToScroll: 1,
                infinite: true,
                arrows: true,
                dots: false,
                autoplay: true,
                autoplaySpeed: 3000,
                speed: 500,

                responsive: [
                    {
                        breakpoint: 1200,
                        settings: {
                            slidesToShow: 5
                        }
                    },
                    {
                        breakpoint: 992,
                        settings: {
                            slidesToShow: 4
                        }
                    },
                    {
                        breakpoint: 768,
                        settings: {
                            slidesToShow: 3
                        }
                    },
                    {
                        breakpoint: 576,
                        settings: {
                            slidesToShow: 2
                        }
                    }
                ]
            });
        }
    }

    $('.latest-product__slider').each(function() {
        const slider = $(this);
        const parent = slider.closest('.latest-product__text');

        slider.slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows: false,
            dots: false,
            infinite: false,
            autoplay: true,
            speed: 500
        });

        parent.find('.latest-product-prev').on('click', function() {
            slider.slick('slickPrev');
        });

        parent.find('.latest-product-next').on('click', function() {
            slider.slick('slickNext');
        });
    });
});
