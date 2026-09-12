@extends('frontend.layouts.app')

@section('title', config('app.name'))

@push('styles')
    <link rel="stylesheet" href="{{ asset('frontend/css/owl.carousel.min.css') }}">
    <link rel="stylesheet" href="{{ app(\App\Services\Frontend\DesignManager::class)->getTemplateCss('home') }}">
    <link rel="stylesheet" href="{{ app(\App\Services\Frontend\DesignManager::class)->getSectionCss('product_card') }}">
    <link rel="stylesheet" href="{{ app(\App\Services\Frontend\DesignManager::class)->getSectionCss('blog_card') }}">
@endpush

@section('content')

    <!-- Hero Section Begin -->
    <section class="hero">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="hero__categories">
                        <div class="hero__categories__all">
                            <i class="fa fa-bars"></i>
                            <span>All departments</span>
                        </div>
                        <ul>
                            @forelse ($categories as $category)
                                <li>
                                    <a href="{{ route('products.index', ['category' => $category->slug]) }}">
                                        {{ $category->name }}
                                    </a>
                                </li>
                            @empty
                                <li><a href="#">No categories found</a></li>
                            @endforelse
                        </ul>
                    </div>
                </div>

                <div class="col-lg-9">
                    <div class="hero__search">
                        <div class="hero__search__form">
                            <form action="{{ route('products.index') }}" method="GET">
                                <div class="hero__search__categories">
                                    All Categories
                                    <span class="arrow_carrot-down"></span>
                                </div>
                                <input type="text" name="search" class="search-box" id="productSearchInput"
                                    placeholder="What do you need?" autocomplete="off">
                                <button type="submit" class="site-btn">SEARCH</button>
                                <div class="product-search-results" id="productSearchResults"></div>
                            </form>
                        </div>

                        <div class="hero__search__phone">
                            <div class="hero__search__phone__icon">
                                <i class="fa fa-phone"></i>
                            </div>
                            <div class="hero__search__phone__text">
                                <h5>{{ $settings->site_phone }}</h5>
                                <span>support 24/7 time</span>
                            </div>
                        </div>
                    </div>

                    @if ($sliders->isNotEmpty())
                        <div class="hero__slider owl-carousel">
                            @foreach ($sliders as $slider)
                                <div class="hero__item set-bg" data-setbg="{{ asset('storage/' . $slider->image) }}">
                                    <div class="hero__text">
                                        @if ($slider->subtitle)
                                            <span>{{ $slider->subtitle }}</span>
                                        @endif

                                        @if ($slider->title)
                                            <h2>{!! nl2br(e($slider->title)) !!}</h2>
                                        @endif

                                        @if ($slider->description)
                                            <p>{{ $slider->description }}</p>
                                        @endif

                                        @if ($slider->button_text && $slider->button_url)
                                            <a href="{{ $slider->button_url }}" class="primary-btn">
                                                {{ $slider->button_text }}
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="hero__item set-bg" data-setbg="{{ asset('frontend/images/default-slider.jpg') }}">
                            <div class="hero__text">
                                <span>WELCOME</span>
                                <h2>{{ $settings->site_name }}</h2>
                                <p>Shop our latest products</p>
                                <a href="{{ route('products.index') }}" class="primary-btn">
                                    SHOP NOW
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
    <!-- Hero Section End -->

    <!-- Categories Section Begin -->
    <section class="categories">
        <div class="container">
            <div class="row">
                <div class="categories__slider owl-carousel">
                    @forelse ($categories as $category)
                        <div class="col-lg-3">
                            <div class="categories__item set-bg"
                                @if ($category->image) data-setbg="{{ asset('storage/' . $category->image) }}" @endif>
                                <h5>
                                    <a href="{{ route('products.index', ['category' => $category->slug]) }}">
                                        {{ $category->name }}
                                    </a>
                                </h5>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <p class="text-center">No categories found.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </section>
    <!-- Categories Section End -->

    <!-- Featured Section Begin -->
    <section class="featured spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title">
                        <h2>Featured Product</h2>
                    </div>

                    @if ($topTenProducts->isNotEmpty())
                        <div class="featured__controls">
                            <ul>
                                <li class="active" data-filter="*">All</li>
                                @foreach ($categories as $category)
                                    <li data-filter=".category-{{ $category->id }}">
                                        {{ $category->name }}
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
            </div>

            <div class="row featured__filter">
                @forelse ($topTenProducts as $product)
                    <div class="col-lg-3 col-md-4 col-sm-6 mix category-{{ $product->category_id }}">
                        @include($productCardView, ['product' => $product])
                    </div>
                @empty
                    <div class="col-12">
                        <p class="text-center">No featured products found.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>
    <!-- Featured Section End -->

    <!-- Banner Begin -->
    <div class="banner">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="banner__pic">
                        <img src="{{ asset('frontend/images/banner/banner-1.jpg') }}" alt="">
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="banner__pic">
                        <img src="{{ asset('frontend/images/banner/banner-2.jpg') }}" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Banner End -->

    <!-- Latest Product Section Begin -->
    <section class="latest-product spad">
        <div class="container">
            <div class="row">

                <!-- New Arrivals -->
                <div class="col-lg-4 col-md-6">
                    <div class="latest-product__text">
                        <h4>New Arrivals</h4>

                        <div class="latest-product__slider owl-carousel">
                            @forelse ($newArrivalsProducts->chunk(3) as $products)
                                <div class="latest-prdouct__slider__item">
                                    @foreach ($products as $product)
                                        @php
                                            $productImage = $product->thumbnail
                                                ? asset('storage/' . $product->thumbnail)
                                                : ($product->images->first()?->image
                                                    ? asset('storage/' . $product->images->first()->image)
                                                    : asset('frontend/images/product-placeholder.jpg'));
                                        @endphp

                                        <a href="{{ route('products.show', ['product' => $product->slug]) }}"
                                            class="latest-product__item">
                                            <div class="latest-product__item__pic">
                                                <img src="{{ $productImage }}" alt="{{ $product->name }}">
                                            </div>

                                            <div class="latest-product__item__text">
                                                <h6>{{ $product->name }}</h6>
                                                <span>
                                                    {{ $settings->price_symbol }}{{ number_format($product->selling_price, 2) }}
                                                </span>
                                            </div>
                                        </a>
                                    @endforeach
                                </div>
                            @empty
                                <p>No products found.</p>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Featured Products -->
                <div class="col-lg-4 col-md-6">
                    <div class="latest-product__text">
                        <h4>Featured Products</h4>

                        <div class="latest-product__slider owl-carousel">
                            @forelse ($topTenProducts->chunk(3) as $products)
                                <div class="latest-prdouct__slider__item">
                                    @foreach ($products as $product)
                                        @php
                                            $productImage = $product->thumbnail
                                                ? asset('storage/' . $product->thumbnail)
                                                : ($product->images->first()?->image
                                                    ? asset('storage/' . $product->images->first()->image)
                                                    : asset('frontend/images/product-placeholder.jpg'));
                                        @endphp

                                        <a href="{{ route('products.show', ['product' => $product->slug]) }}"
                                            class="latest-product__item">
                                            <div class="latest-product__item__pic">
                                                <img src="{{ $productImage }}" alt="{{ $product->name }}">
                                            </div>

                                            <div class="latest-product__item__text">
                                                <h6>{{ $product->name }}</h6>
                                                <span>
                                                    {{ $settings->price_symbol }}{{ number_format($product->selling_price, 2) }}
                                                </span>
                                            </div>
                                        </a>
                                    @endforeach
                                </div>
                            @empty
                                <p>No products found.</p>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Sale Products -->
                <div class="col-lg-4 col-md-6">
                    <div class="latest-product__text">
                        <h4>Sale Products</h4>

                        <div class="latest-product__slider owl-carousel">
                            @forelse ($saleProducts->chunk(3) as $products)
                                <div class="latest-prdouct__slider__item">
                                    @foreach ($products as $product)
                                        @php
                                            $productImage = $product->thumbnail
                                                ? asset('storage/' . $product->thumbnail)
                                                : ($product->images->first()?->image
                                                    ? asset('storage/' . $product->images->first()->image)
                                                    : asset('frontend/images/product-placeholder.jpg'));
                                        @endphp

                                        <a href="{{ route('products.show', ['product' => $product->slug]) }}"
                                            class="latest-product__item">
                                            <div class="latest-product__item__pic">
                                                <img src="{{ $productImage }}" alt="{{ $product->name }}">
                                            </div>

                                            <div class="latest-product__item__text">
                                                <h6>{{ $product->name }}</h6>
                                                <span>
                                                    {{ $settings->price_symbol }}{{ number_format($product->discount_price, 2) }}
                                                </span>
                                            </div>
                                        </a>
                                    @endforeach
                                </div>
                            @empty
                                <p>No sale products found.</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Latest Product Section End -->

    <!-- Blog Section Begin -->
    <section class="from-blog spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="section-title from-blog__title">
                        <h2>From The Blog</h2>
                    </div>
                </div>
            </div>

            <div class="row">
                @forelse ($blogs as $blog)
                    <div class="col-lg-4 col-md-4 col-sm-6">
                        @include($blogCardView, ['blog' => $blog])
                    </div>
                @empty
                    <div class="col-12">
                        <p class="text-center">No blogs found.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </section>
    <!-- Blog Section End -->

@endsection

@push('scripts')
    <script src="{{ asset('frontend/js/owl.carousel.min.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const productSearchInput = document.getElementById('productSearchInput');
            const productSearchResults = document.getElementById('productSearchResults');
            let searchTimeout;

            function escapeHtml(value) {
                const div = document.createElement('div');
                div.textContent = value ?? '';
                return div.innerHTML;
            }

            if (productSearchInput && productSearchResults) {
                productSearchInput.addEventListener('input', function() {
                    const query = this.value.trim();

                    clearTimeout(searchTimeout);

                    if (query.length < 2) {
                        productSearchResults.innerHTML = '';
                        productSearchResults.classList.remove('active');
                        return;
                    }

                    searchTimeout = setTimeout(async function() {
                        try {
                            const response = await fetch(
                                `{{ route('products.search') }}?q=${encodeURIComponent(query)}`, {
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

                            products.forEach(function(product) {
                                const item = document.createElement('a');

                                item.href = product.url;
                                item.className = 'product-search-item';

                                item.innerHTML = `
                                    <div class="product-search-image">
                                        ${product.thumbnail
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

                document.addEventListener('click', function(event) {
                    if (
                        !productSearchInput.contains(event.target) &&
                        !productSearchResults.contains(event.target)
                    ) {
                        productSearchResults.classList.remove('active');
                    }
                });
            }
        });
    </script>
@endpush
