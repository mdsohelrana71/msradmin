@extends('frontend.layouts.app')

@section('title', config('app.name'))

@push('styles')
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
                        <div class="hero__slider">
                            @foreach ($sliders as $slider)
                                <div class="hero__item">
                                    <img src="{{ asset('storage/' . $slider->image) }}"
                                        alt="{{ $slider->title ?? $settings->site_name }}">

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
                        <div class="hero__slider">
                            <div class="hero__item">
                                <img src="{{ asset('frontend/images/default-slider.jpg') }}"
                                    alt="{{ $settings->site_name }}">

                                <div class="hero__text">
                                    <span>WELCOME</span>
                                    <h2>{{ $settings->site_name }}</h2>
                                    <p>Shop our latest products</p>
                                    <a href="{{ route('products.index') }}" class="primary-btn">
                                        SHOP NOW
                                    </a>
                                </div>
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
                <div class="categories__slider">
                    @forelse ($categories as $category)
                        <div class="categories__slide">
                            <div class="categories__item set-bg">
                                <img src="{{ $category->image ? asset('storage/' . $category->image) : asset('frontend/images/category-placeholder.jpg') }}"
                                    alt="{{ $category->name }}">
                                <h5>
                                    <a href="{{ route('products.index', ['category' => $category->slug]) }}">
                                        {{ $category->name }}
                                    </a>
                                </h5>
                            </div>
                        </div>
                    @empty
                        <div class="categories__empty">
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
                </div>
            </div>

            <div class="row featured__filter">
                @forelse ($featuredProduct as $product)
                    <div class="col-lg-3 col-md-3 col-sm-6">
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
                            @forelse ($featuredProduct->take(3)->chunk(3) as $products)
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
    <script src="{{ asset('frontend/js/templates/design-2/main.js') }}"></script>
@endpush
