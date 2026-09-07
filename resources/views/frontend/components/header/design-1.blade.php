<!-- Promo Banner -->
<div class="promo-banner">
    <div class="promo-banner-content">
        Get Up to 40% OFF New-Season Styles &nbsp;&nbsp;
        <a href="#">MEN</a>
        <a href="#">WOMEN</a>
        &nbsp;&nbsp; * Limited time only.
    </div>
    <button class="promo-close"><i class="fas fa-times"></i></button>
</div>

<!-- Mobile Top Bar -->
<div class="mobile-top-bar">
    <div class="container">
        <div class="mobile-top-bar-inner">
            <div class="top-bar-selects">
                <div class="hover-dropdown">
                    <button type="button" class="hover-dropdown-trigger">
                        <span class="dropdown-value">USD</span>
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <ul class="hover-dropdown-menu">
                        <li><a href="#" data-value="USD">USD</a></li>
                        <li><a href="#" data-value="EUR">EUR</a></li>
                        <li><a href="#" data-value="GBP">GBP</a></li>
                    </ul>
                </div>
                <div class="hover-dropdown lang-dropdown">
                    <span class="flag-icon us-flag mobile-flag"></span>
                    <button type="button" class="hover-dropdown-trigger">
                        <span class="dropdown-value">Eng</span>
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <ul class="hover-dropdown-menu">
                        <li><a href="#" data-value="Eng">Eng</a></li>
                        <li><a href="#" data-value="Esp">Esp</a></li>
                    </ul>
                </div>
            </div>
            <div class="mobile-top-icons">
                <a href="#" class="facebook"><i class="fab fa-facebook-f"></i></a>
                <a href="#" class="x"><i class="fa-brands fa-x-twitter"></i></a>
                <a href="#" class="instagram"><i class="fab fa-instagram"></i></a>
            </div>
        </div>
    </div>
</div>

<!-- Info Bar (Desktop only) -->
<div class="info-bar">
    <div class="container">
        <div class="info-bar-content">
            <div class="shipping-info">
                <i class="fas fa-truck shipping-icon"></i>
                <span>FREE Express Shipping On Orders $99+</span>
            </div>
            <div class="right-section">
                <div class="hover-dropdown">
                    <button type="button" class="hover-dropdown-trigger">
                        <span class="dropdown-value">USD</span>
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <ul class="hover-dropdown-menu">
                        <li><a href="#" data-value="USD">USD</a></li>
                        <li><a href="#" data-value="EUR">EUR</a></li>
                        <li><a href="#" data-value="GBP">GBP</a></li>
                    </ul>
                </div>
                <div class="hover-dropdown lang-dropdown">
                    <span class="flag-icon us-flag desktop-flag"></span>
                    <button type="button" class="hover-dropdown-trigger">
                        <span class="dropdown-value">Eng</span>
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <ul class="hover-dropdown-menu">
                        <li><a href="#" data-value="Eng">Eng</a></li>
                        <li><a href="#" data-value="Esp">Esp</a></li>
                        <li><a href="#" data-value="Fra">Fra</a></li>
                    </ul>
                </div>
                <div class="info-links">
                    <a href="#">Contact Us</a>
                    <a href="#">Cart</a>
                    <a href="#">Log In</a>
                </div>
                <div class="social-icons">
                    <a href="#" class="facebook"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="x"><i class="fa-brands fa-x-twitter"></i></a>
                    <a href="#" class="instagram"><i class="fab fa-instagram"></i></a>
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