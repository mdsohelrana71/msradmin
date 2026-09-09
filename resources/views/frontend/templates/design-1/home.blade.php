@extends('frontend.layouts.app')

@section('title', config('app.name'))
@push('styles')
    <link rel="stylesheet" href="{{ app(\App\Services\Frontend\DesignManager::class)->getTemplateCss('home') }}">
    <link rel="stylesheet" href="{{ app(\App\Services\Frontend\DesignManager::class)->getSectionCss('product_card') }}">
    <link rel="stylesheet" href="{{ app(\App\Services\Frontend\DesignManager::class)->getSectionCss('blog_card') }}">
@endpush
@section('content')
    <!-- Categories Section -->
    <div class="category-section">
        <div class="categories-container container">
            <a href="{{ route('products.index') }}" class="category-item">
                <div class="hamburger-menu">
                    <i class="fas fa-bars"></i>
                </div>
                <div class="category-name">Categories</div>
            </a>

            @foreach ($categories as $category)
                <a href="{{ route('products.index', ['category' => $category->slug]) }}" class="category-item">
                    <div class="category-circle">
                        @if ($category->image)
                            <img src="{{ asset('storage/' . $category->image) }}"
                                alt="{{ $category->name }}">
                        @endif
                    </div>
                    <div class="category-name">{{ $category->name }}</div>
                </a>
            @endforeach
        </div>
    </div>

    <!-- Mobile Menu -->
    <div class="mobile-menu" id="mobileMenu">
        <div class="mobile-menu-content">
            <a href="#" class="mobile-category-item category-bars">
                <div class="mobile-category-icon mt-1">
                    <i class="fas fa-bars"></i>
                </div>
                <span>Categories</span>
            </a>

            @foreach ($categories as $category)
                <a href="{{ route('products.index', ['category' => $category->slug]) }}"
                    class="mobile-category-item">
                    <div class="mobile-category-icon">
                        @if ($category->image)
                            <img src="{{ asset('storage/' . $category->image) }}"
                                alt="{{ $category->name }}">
                        @endif
                    </div>
                    <span>{{ $category->name }}</span>
                </a>
            @endforeach
        </div>
    </div>

    {{-- Hero Slider --}}
    <section class="hero-slider">
        @forelse ($sliders as $slider)
            <div class="slider-item" style="background-image: url('{{ asset('storage/' . $slider->image) }}');">
                <div class="slider-overlay"></div>
                <div class="slider-content">
                    @if ($slider->title)
                        <h1 class="slider-title">{{ $slider->title }}</h1>
                    @endif

                    @if ($slider->subtitle)
                        <p class="slider-subtitle">{{ $slider->subtitle }}</p>
                    @endif

                    @if ($slider->button_text && $slider->button_url)
                        <a href="{{ $slider->button_url }}" class="slider-btn">
                            {{ $slider->button_text }}
                        </a>
                    @endif
                </div>
            </div>
        @empty
            <div class="slider-item" style="background-image: url('{{ asset('frontend/images/slider-1.jpg') }}');">
                <div class="slider-overlay"></div>
                <div class="slider-content">
                    <h1 class="slider-title">Discover Your Style</h1>
                    <p class="slider-subtitle">Explore our latest collection and find something perfect for you.</p>
                    <a href="{{ route('products.index') }}" class="slider-btn">Shop Now</a>
                </div>
            </div>
        @endforelse
    </section>

    {{-- Trust Features --}}
    <section class="py-4">
        <div class="container">
            <div class="row text-center g-4">
                <div class="col-6 col-lg-3">
                    <i class="fas fa-shield-alt fa-2x mb-2"></i>
                    <h6 class="mb-1">Secure Payment</h6>
                    <small class="text-muted">100% secure payment</small>
                </div>
                <div class="col-6 col-lg-3">
                    <i class="fas fa-truck fa-2x mb-2"></i>
                    <h6 class="mb-1">Free Shipping</h6>
                    <small class="text-muted">On selected orders</small>
                </div>
                <div class="col-6 col-lg-3">
                    <i class="fas fa-award fa-2x mb-2"></i>
                    <h6 class="mb-1">Premium Quality</h6>
                    <small class="text-muted">Quality products</small>
                </div>
                <div class="col-6 col-lg-3">
                    <i class="fas fa-headset fa-2x mb-2"></i>
                    <h6 class="mb-1">24/7 Support</h6>
                    <small class="text-muted">We're here to help</small>
                </div>
            </div>
        </div>
    </section>

   {{-- Top 10 Products --}}
    @if ($topTenProducts->isNotEmpty())
        <section class="products-section">
            <div class="container">
                <h2 class="products-section-title">Top 10 Products</h2>
                <div class="top-ten-products">
                    @foreach ($topTenProducts as $product)
                        @include($productCardView, ['product' => $product])
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <!-- Trending Looks Section -->
    @if ($trendingProducts->isNotEmpty())
        @php
            $featuredProduct = $trendingProducts->first();
            $topPicks = $trendingProducts->slice(1);
            $featuredHasDiscount =
                $featuredProduct->discount_price !== null &&
                $featuredProduct->discount_price < $featuredProduct->selling_price;
            $featuredPrice = $featuredHasDiscount ? $featuredProduct->discount_price : $featuredProduct->selling_price;
        @endphp

        <section class="trending-section py-5">
            <div class="container">
                <div class="text-center mb-5">
                    <p class="trending-badge mb-2">🔥 Super Sale</p>
                    <h2 class="trending-heading">TRENDING LOOKS</h2>
                    <p class="trending-subheading">
                        Starting from only
                        <span class="trending-price-highlight">${{ number_format($featuredPrice, 2) }}</span>
                    </p>
                </div>

                <div class="row g-4">
                    <!-- Featured -->
                    <div class="col-12 col-lg-5">
                        <div class="trending-featured h-100">
                            <div class="trending-featured-image position-relative overflow-hidden">
                                <a href="{{ route('products.show', $featuredProduct->slug) }}">
                                    @if ($featuredProduct->thumbnail)
                                        <img src="{{ asset('storage/' . ltrim($featuredProduct->thumbnail, '/')) }}"
                                            alt="{{ $featuredProduct->name }}" class="img-fluid w-100 rounded">
                                    @else
                                        <img src="{{ asset('frontend/images/p-1.jpg') }}"
                                            alt="{{ $featuredProduct->name }}" class="img-fluid w-100 rounded">
                                    @endif
                                </a>

                                <div class="position-absolute top-0 start-0 p-3">
                                    <span class="badge bg-dark px-3 py-2">NEW ARRIVAL</span>
                                </div>
                            </div>

                            <div class="trending-featured-info p-4 bg-white shadow-sm rounded-bottom">
                                <h3 class="h4 mb-2">{{ $featuredProduct->name }}</h3>
                                <p class="text-muted mb-3">
                                    {{ $featuredProduct->category?->name ?? 'Trending product collection' }}</p>

                                <a href="{{ route('products.show', $featuredProduct->slug) }}"
                                    class="btn trending-shop-btn">
                                    Shop This Look
                                    <i class="fas fa-arrow-right ms-2"></i>
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Product List -->
                    <div class="col-12 col-lg-7">
                        <div class="bg-white shadow-sm rounded p-4 h-100">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h3 class="h5 mb-0">Top Picks for You</h3>

                                <a href="{{ route('products.index') }}" class="text-decoration-none view-all-link">
                                    View All <i class="fas fa-chevron-right ms-1"></i>
                                </a>
                            </div>

                            <ul class="list-unstyled mb-0 trending-product-list">
                                @foreach ($topPicks as $product)
                                    @php
                                        $hasDiscount =
                                            $product->discount_price !== null &&
                                            $product->discount_price < $product->selling_price;
                                        $currentPrice = $hasDiscount
                                            ? $product->discount_price
                                            : $product->selling_price;
                                    @endphp

                                    <li
                                        class="d-flex justify-content-between align-items-center py-3 {{ !$loop->last ? 'border-bottom' : '' }}">
                                        <div class="d-flex align-items-center gap-3">
                                            <a href="{{ route('products.show', $product->slug) }}">
                                                @if ($product->thumbnail)
                                                    <img src="{{ asset('storage/' . ltrim($product->thumbnail, '/')) }}"
                                                        class="product-icon" alt="{{ $product->name }}">
                                                @else
                                                    <img src="{{ asset('frontend/images/p-1.jpg') }}"
                                                        class="product-icon" alt="{{ $product->name }}">
                                                @endif
                                            </a>

                                            <div class="product-name">
                                                <a
                                                    href="{{ route('products.show', $product->slug) }}">{{ $product->name }}</a>

                                                @if ($hasDiscount)
                                                    <small
                                                        class="d-block text-decoration-line-through text-muted">${{ number_format($product->selling_price, 2) }}</small>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="d-flex align-items-center gap-3">
                                            <strong>${{ number_format($currentPrice, 2) }}</strong>

                                            <a href="#" class="btn trending-add-cart-btn">
                                                <i class="fas fa-shopping-cart"></i>
                                            </a>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif

    {{-- Sale Products Section --}}
    @if ($saleProducts->isNotEmpty())
        <section class="products-section">
            <div class="container">
                <h2 class="products-section-title">Sale Products</h2>
                <div class="sale-products">
                    @foreach ($saleProducts as $product)
                        @include($productCardView, ['product' => $product])
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- Big Sale Banner --}}
    @if($promo)
        <section class="big-sale-banner-section">
            <div class="container">
                <div class="big-sale-banner">
                    <div class="banner-content">
                        <div class="banner-text">
                            <span class="big-sale-badge">BIG SALE</span>
                            <div>
                                <div class="banner-main-text">
                                    {{ $promo->title }}
                                </div>
                                @if($promo->description)
                                    <div class="banner-subtitle">
                                        {{ $promo->description }}
                                    </div>
                                @endif
                            </div>
                        </div>
                        @php
                            $button = $promo->buttons->first();
                        @endphp
                        @if($button)
                            <a href="{{ $button->url }}" class="view-sale-btn">
                                {{ $button->label }}
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </section>
    @endif

    {{-- New Arrivals Section --}}
    @if ($newArrivalsProducts->isNotEmpty())
        <section class="products-section">
            <div class="container">
                <h2 class="products-section-title">New Arrivals</h2>
                <div class="new-arrivals-products">
                    @foreach ($newArrivalsProducts as $product)
                        @include($productCardView, ['product' => $product])
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <button id="backToTop" class="back-to-top" type="button">
        <i class="fas fa-arrow-up"></i>
    </button>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('.top-ten-products').slick({
                dots: false,
                arrows: true,
                infinite: true,
                speed: 400,
                slidesToShow: 4,
                slidesToScroll: 4,
                autoplay: false,
                prevArrow: '<button type="button" class="slick-prev"><i class="fas fa-chevron-left"></i></button>',
                nextArrow: '<button type="button" class="slick-next"><i class="fas fa-chevron-right"></i></button>',
                responsive: [{
                        breakpoint: 1200,
                        settings: {
                            slidesToShow: 4,
                            slidesToScroll: 4
                        }
                    },
                    {
                        breakpoint: 1024,
                        settings: {
                            slidesToShow: 3,
                            slidesToScroll: 3
                        }
                    },
                    {
                        breakpoint: 768,
                        settings: {
                            slidesToShow: 2,
                            slidesToScroll: 2
                        }
                    }
                ]
            });

            $('.hero-slider').slick({
                dots: true,
                arrows: true,
                infinite: true,
                speed: 600,
                autoplay: true,
                autoplaySpeed: 4000,
                fade: true,
                cssEase: 'linear',
                prevArrow: '<button type="button" class="slick-prev"><i class="fas fa-chevron-left"></i></button>',
                nextArrow: '<button type="button" class="slick-next"><i class="fas fa-chevron-right"></i></button>'
            });
        });

        const backToTop = document.getElementById("backToTop");

        if (backToTop) {
            window.addEventListener("scroll", () => {
                if (window.scrollY > 300) {
                    backToTop.classList.add("show");
                } else {
                    backToTop.classList.remove("show");
                }
            });

            backToTop.addEventListener("click", () => {
                window.scrollTo({
                    top: 0,
                    behavior: "smooth"
                });
            });
        }
    </script>
@endpush
