{{-- <!-- Page Preloder
<div id="preloder">
    <div class="loader"></div>
</div> --}}

<!-- Humberger Begin -->
<div class="humberger__menu__overlay"></div>
<div class="humberger__menu__wrapper">
    <div class="humberger__menu__logo logo">
        <a href="{{ route('home') }}">
            <img src="{{ asset($settings->site_logo) }}" alt="{{ $settings->site_name }}">
        </a>
    </div>

    <div class="humberger__menu__cart">
        <ul>
            <li>
                <a href="#">
                    <i class="fa fa-heart"></i>
                    <span>0</span>
                </a>
            </li>
            <li>
                <a href="#">
                    <i class="fa fa-shopping-bag"></i>
                    <span>0</span>
                </a>
            </li>
        </ul>
        <div class="header__cart__price">
            item: <span>$0.00</span>
        </div>
    </div>

    <div class="humberger__menu__widget">
        <div class="header__top__right__language">
            <img src="{{ asset('frontend/images/language.png') }}" alt="Language">
            <div>English</div>
            <span class="arrow_carrot-down"></span>
            <ul>
                <li><a href="#">বাংলা</a></li>
                <li><a href="#">English</a></li>
            </ul>
        </div>

        <div class="header__top__right__auth">
            @auth
                @if (Auth::user()->role_id === null)
                    <a href="{{ route('customer.account') }}">
                        <i class="fa fa-user"></i> My Account
                    </a>
                @else
                    <a href="{{ route('admin.dashboard') }}">
                        <i class="fa fa-user"></i> Admin Panel
                    </a>
                @endif
            @else
                <a href="{{ route('customer.login') }}">
                    <i class="fa fa-user"></i> Login
                </a>
            @endauth
        </div>
    </div>

    <nav class="humberger__menu__nav mobile-menu">
        <ul>
            <li class="{{ request()->routeIs('home') ? 'active' : '' }}">
                <a href="{{ route('home') }}">Home</a>
            </li>
            <li class="{{ request()->routeIs('products.*') ? 'active' : '' }}">
                <a href="{{ route('products.index') }}">Shop</a>
            </li>
            <li>
                <a href="#">Pages</a>
                <ul class="header__menu__dropdown">
                    <li>
                        <a href="{{ route('products.index') }}">Shop</a>
                    </li>
                    <li>
                        <a href="{{ route('blog.index') }}">Blog</a>
                    </li>
                    @auth
                        @if (Auth::user()->role_id === null)
                            <li>
                                <a href="{{ route('customer.account') }}">My Account</a>
                            </li>
                        @endif
                    @else
                        <li>
                            <a href="{{ route('customer.login') }}">Login</a>
                        </li>
                    @endauth
                </ul>
            </li>
            <li class="{{ request()->routeIs('blog.*') ? 'active' : '' }}">
                <a href="{{ route('blog.index') }}">Blog</a>
            </li>
            <li>
                <a href="#">Contact</a>
            </li>
        </ul>
    </nav>

    <div id="mobile-menu-wrap"></div>

    <div class="header__top__right__social">
        @if (!empty($settings->facebook_url))
            <a href="{{ $settings->facebook_url }}" target="_blank" rel="noopener noreferrer">
                <i class="fab fa-facebook-f"></i>
            </a>
        @endif

        @if (!empty($settings->twitter_url))
            <a href="{{ $settings->twitter_url }}" target="_blank" rel="noopener noreferrer">
                <i class="fa-brands fa-x-twitter"></i>
            </a>
        @endif

        @if (!empty($settings->instagram_url))
            <a href="{{ $settings->instagram_url }}" target="_blank" rel="noopener noreferrer">
                <i class="fab fa-instagram"></i>
            </a>
        @endif

        @if (!empty($settings->linkedin))
            <a href="{{ $settings->linkedin }}" target="_blank" rel="noopener noreferrer">
                <i class="fab fa-linkedin"></i>
            </a>
        @endif
    </div>

    <div class="humberger__menu__contact">
        <ul>
            <li>
                <i class="fa fa-envelope"></i> {{ $settings->site_email }}
            </li>
            @if ($promo)
                <li>
                    {{ $promo->title }} 
                    @foreach ($promo->buttons as $button)
                        <a class="text-primary" href="{{ $button->url }}">{{ $button->label }}</a>
                    @endforeach
                    @if ($promo->description)
                        &nbsp;&nbsp; * {{ $promo->description }}
                    @endif
                </li>
            @endif
        </ul>
    </div>
</div>
<!-- Humberger End -->

<!-- Header Section Begin -->
<header class="header">
    <div class="header__top">
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6">
                    <div class="header__top__left">
                        <ul>
                            <li>
                                <i class="fa fa-envelope"></i> {{ $settings->site_email }}
                            </li>
                            @if ($promo)
                                <li>
                                    {{ $promo->title }}
                                    @foreach ($promo->buttons as $button)
                                        <a class="text-primary" href="{{ $button->url }}">{{ $button->label }}</a>
                                    @endforeach
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>

                <div class="col-lg-6 col-md-6">
                    <div class="header__top__right">
                        <div class="header__top__right__social">
                            @if (!empty($settings->facebook_url))
                                <a href="{{ $settings->facebook_url }}" target="_blank" rel="noopener noreferrer">
                                    <i class="fab fa-facebook-f"></i>
                                </a>
                            @endif

                            @if (!empty($settings->twitter_url))
                                <a href="{{ $settings->twitter_url }}" target="_blank" rel="noopener noreferrer">
                                    <i class="fa-brands fa-x-twitter"></i>
                                </a>
                            @endif

                            @if (!empty($settings->instagram_url))
                                <a href="{{ $settings->instagram_url }}" target="_blank" rel="noopener noreferrer">
                                    <i class="fab fa-instagram"></i>
                                </a>
                            @endif

                            @if (!empty($settings->linkedin))
                                <a href="{{ $settings->linkedin }}" target="_blank" rel="noopener noreferrer">
                                    <i class="fab fa-linkedin"></i>
                                </a>
                            @endif
                        </div>

                        <div class="header__top__right__language">
                            <span class="flag-icon us-flag desktop-flag"></span>
                            <div>English</div>
                            <span class="arrow_carrot-down"></span>
                            <ul>
                                <li><a href="#">বাংলা</a></li>
                                <li><a href="#">English</a></li>
                            </ul>
                        </div>

                        <div class="header__top__right__auth">
                            @auth
                                @if (Auth::user()->role_id === null)
                                    <a href="{{ route('customer.account') }}">
                                        <i class="fa fa-user"></i> My Account
                                    </a>
                                @else
                                    <a href="{{ route('admin.dashboard') }}">
                                        <i class="fa fa-user"></i> Admin Panel
                                    </a>
                                @endif
                            @else
                                <a href="{{ route('customer.login') }}">
                                    <i class="fa fa-user"></i> Login
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <div class="header__logo logo">
                    <a href="{{ route('home') }}">
                        <img src="{{ asset($settings->site_logo) }}" alt="{{ $settings->site_name }}">
                    </a>
                </div>
            </div>

            <div class="col-lg-6">
                <nav class="header__menu">
                    <ul>
                        <li class="{{ request()->routeIs('home') ? 'active' : '' }}">
                            <a href="{{ route('home') }}">Home</a>
                        </li>

                        <li class="{{ request()->routeIs('products.*') ? 'active' : '' }}">
                            <a href="{{ route('products.index') }}">Shop</a>
                        </li>

                        <li>
                            <a href="#">Pages</a>
                            <ul class="header__menu__dropdown">
                                <li>
                                    <a href="{{ route('products.index') }}">Shop</a>
                                </li>
                                <li>
                                    <a href="{{ route('blog.index') }}">Blog</a>
                                </li>
                                @auth
                                    @if (Auth::user()->role_id === null)
                                        <li>
                                            <a href="{{ route('customer.account') }}">My Account</a>
                                        </li>
                                    @endif
                                @else
                                    <li>
                                        <a href="{{ route('customer.login') }}">Login</a>
                                    </li>
                                @endauth
                            </ul>
                        </li>

                        <li class="{{ request()->routeIs('blog.*') ? 'active' : '' }}">
                            <a href="{{ route('blog.index') }}">Blog</a>
                        </li>

                        <li>
                            <a href="#">Contact</a>
                        </li>
                    </ul>
                </nav>
            </div>

            <div class="col-lg-3">
                <div class="header__cart">
                    <ul>
                        <li>
                            <a href="#">
                                <i class="fa fa-heart"></i>
                                <span>0</span>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <i class="fa fa-shopping-bag"></i>
                                <span>0</span>
                            </a>
                        </li>
                    </ul>

                    <div class="header__cart__price">
                        item: <span>$0.00</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="humberger__open">
            <i class="fa fa-bars"></i>
        </div>
    </div>
</header>
<!-- Header Section End -->

<script src="{{ asset('frontend/js/templates/design-2/main.js') }}"></script>
