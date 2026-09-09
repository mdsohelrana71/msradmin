@if($promo)
    <div class="promo-banner">
        <div class="promo-banner-content">
            {{ $promo->title }}
            @foreach($promo->buttons as $button)
                <a href="{{ $button->url }}">{{ $button->label }}</a>
            @endforeach
            @if($promo->description)
                &nbsp;&nbsp; * {{ $promo->description }}
            @endif
        </div>
        <button class="promo-close">
            <i class="fas fa-times"></i>
        </button>
    </div>
@endif

<!-- Info Bar (Desktop only) --> 
<div class="info-bar">
    <div class="container">
        <div class="info-bar-content">
            <div class="left-section">
                <div class="info-links">
                    <a href="{{ route('products.index') }}">Products</a>
                    <a href="{{ route('blog.index') }}">Blogs</a>
                    <a href="#">Contact Us</a>
                </div>
            </div>
            <div class="right-section">
                <div class="hover-dropdown lang-dropdown">
                    <span class="flag-icon us-flag desktop-flag"></span>
                    <button type="button" class="hover-dropdown-trigger">
                        <span class="dropdown-value">Eng</span>
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <ul class="hover-dropdown-menu">
                        <li><a href="#" data-value="Eng">Eng</a></li>
                        <li><a href="#" data-value="Esp">বাংলা</a></li>
                    </ul>
                </div>
                
                <div class="social-icons">
                    @if (!empty($settings->facebook_url))
                        <a href="{{ $settings->facebook_url }}" class="facebook" target="_blank" rel="noopener">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                    @endif
                    @if (!empty($settings->twitter_url))
                        <a href="{{ $settings->twitter_url }}" class="x" target="_blank" rel="noopener">
                            <i class="fa-brands fa-x-twitter"></i>
                        </a>
                    @endif
                    @if (!empty($settings->instagram_url))
                        <a href="{{ $settings->instagram_url }}" class="instagram" target="_blank" rel="noopener">
                            <i class="fab fa-instagram"></i>
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Main Header -->
<div class="main-header">
    <div class="container">
        <div class="header-content">
            <div class="header-left">
                <div class="mobile-menu-toggle" id="mobileMenuToggle">
                    <i class="fas fa-bars"></i>
                </div>
                <a href="{{ route('home') }}" class="logo d-block text-decoration-none">
                    <img src="{{ asset('frontend/images/logo.png') }}" alt="Logo">
                </a>
            </div>
            <div class="search-container">
                <input type="text" class="search-box" placeholder="Search...">
                <button type="submit" class="search-btn"><i class="fas fa-search"></i></button>
            </div>
            <div class="right-actions">
                <div class="account-section">
                    <div class="account-icon">
                        <a href="#" class="action-icon text-decoration-none">
                            <i class="fa-regular fa-user"></i>
                        </a>
                    </div>
                    <div class="auth-section">
                        <div class="account-label">Welcome</div>
                        <div class="account-text"><a href="#">Sign In / Register</a></div>
                    </div>
                </div>
                <a href="#" class="action-icon wishlist-icon text-decoration-none" title="Wishlist">
                    <i class="fa-regular fa-heart"></i>
                </a>
                <div class="action-icon cart-icon">
                    <i class="fas fa-shopping-cart"></i>
                    <span class="cart-badge">0</span>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="mobile-menu-overlay" id="mobileMenuOverlay"></div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const promoClose = document.querySelector('.promo-close');
    const mobileMenuToggle = document.getElementById('mobileMenuToggle');
    const mobileMenu = document.getElementById('mobileMenu');
    const mobileMenuClose = document.getElementById('mobileMenuClose');
    const mobileMenuOverlay = document.getElementById('mobileMenuOverlay');

    if (promoClose) {
        promoClose.addEventListener('click', function() {
            const banner = document.querySelector('.promo-banner');
            if (banner) {
                banner.style.display = 'none';
            }
        });
    }

    function openMobileMenu() {
        if (mobileMenu) {
            mobileMenu.classList.add('active');
        }
        if (mobileMenuOverlay) {
            mobileMenuOverlay.classList.add('active');
        }
        document.body.classList.add('menu-open');
    }

    function closeMobileMenu() {
        if (mobileMenu) {
            mobileMenu.classList.remove('active');
        }
        document.body.classList.remove('menu-open');
    }

    if (mobileMenuToggle) {
        mobileMenuToggle.addEventListener('click', openMobileMenu);
    }

    if (mobileMenuClose) {
        mobileMenuClose.addEventListener('click', closeMobileMenu);
    }

});
</script>
@endpush