document.addEventListener('DOMContentLoaded', function () {
    /*
    |--------------------------------------------------------------------------
    | Product Search
    |--------------------------------------------------------------------------
    */

    const productSearchInput = document.getElementById('productSearchInput');
    const productSearchResults = document.getElementById('productSearchResults');
    let searchTimeout;

    function escapeHtml(value) {
        const div = document.createElement('div');
        div.textContent = value ?? '';
        return div.innerHTML;
    }

    if (productSearchInput && productSearchResults) {
        productSearchInput.addEventListener('input', function () {
            const query = this.value.trim();

            clearTimeout(searchTimeout);

            if (query.length < 2) {
                productSearchResults.innerHTML = '';
                productSearchResults.classList.remove('active');
                return;
            }

            searchTimeout = setTimeout(async function () {
                try {
                    const response = await fetch(
                        `{{ route('products.search') }}?q=${encodeURIComponent(query)}`,
                        {
                            method: 'GET',
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'Accept': 'application/json'
                            }
                        }
                    );

                    if (!response.ok) {
                        throw new Error(`HTTP ${response.status}`);
                    }

                    const products = await response.json();

                    productSearchResults.innerHTML = '';

                    if (!Array.isArray(products) || products.length === 0) {
                        productSearchResults.innerHTML = `
                            <div class="product-search-empty">
                                No products found
                            </div>
                        `;

                        productSearchResults.classList.add('active');
                        return;
                    }

                    products.forEach(function (product) {
                        const item = document.createElement('a');

                        item.href = product.url;
                        item.className = 'product-search-item';

                        item.innerHTML = `
                            <div class="product-search-image">
                                ${
                                    product.thumbnail
                                        ? `<img src="${product.thumbnail}" alt="${escapeHtml(product.name)}">`
                                        : '<div class="product-search-no-image"></div>'
                                }
                            </div>

                            <div class="product-search-info">
                                <div class="product-search-name">
                                    ${escapeHtml(product.name)}
                                </div>

                                <div class="product-search-sku">
                                    SKU: ${escapeHtml(product.sku || 'N/A')}
                                </div>
                            </div>
                        `;

                        productSearchResults.appendChild(item);
                    });

                    productSearchResults.classList.add('active');
                } catch (error) {
                    console.error('Product Search Error:', error);

                    productSearchResults.innerHTML = `
                        <div class="product-search-empty">
                            Search failed. Please try again.
                        </div>
                    `;

                    productSearchResults.classList.add('active');
                }
            }, 300);
        });

        document.addEventListener('click', function (event) {
            if (
                !productSearchInput.contains(event.target) &&
                !productSearchResults.contains(event.target)
            ) {
                productSearchResults.classList.remove('active');
            }
        });
    }


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
});
