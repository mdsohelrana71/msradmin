
@if ($promo)
    <div class="promo-banner">
        <div class="promo-banner-content">
            {{ $promo->title }}
            @foreach ($promo->buttons as $button)
                <a href="{{ $button->url }}">{{ $button->label }}</a>
            @endforeach
            @if ($promo->description)
                &nbsp;&nbsp; * {{ $promo->description }}
            @endif
        </div>
        <button class="promo-close" type="button">
            <i class="fas fa-times"></i>
        </button>
    </div>
@endif

<!-- Info Bar -->
<div class="info-bar">
    <div class="container">
        <div class="info-bar-content">
            <div class="left-section">
                <div class="info-links">
                    <a href="{{ route('products.index') }}">
                        <i class="fas fa-box"></i>
                        Products
                    </a>
                    <a href="{{ route('blog.index') }}">
                        <i class="fas fa-blog"></i>
                        Blogs
                    </a>
                    <a href="#">
                        <i class="fas fa-envelope"></i>
                        Contact Us
                    </a>
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
                        <a href="{{ $settings->facebook_url }}" class="facebook" target="_blank"
                            rel="noopener noreferrer" title="Facebook">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                    @endif
                    @if (!empty($settings->twitter_url))
                        <a href="{{ $settings->twitter_url }}" class="x" target="_blank"
                            rel="noopener noreferrer" title="X">
                            <i class="fa-brands fa-x-twitter"></i>
                        </a>
                    @endif
                    @if (!empty($settings->instagram_url))
                        <a href="{{ $settings->instagram_url }}" class="instagram" target="_blank"
                            rel="noopener noreferrer" title="Instagram">
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
                    <img src="{{ asset($settings->site_logo) }}" alt="{{ $settings->site_name }}">
                </a>
            </div>

            <div class="search-container">
                <input type="text" class="search-box" id="productSearchInput"
                    placeholder="Search..." autocomplete="off">
                <button type="button" class="search-btn">
                    <i class="fas fa-search"></i>
                </button>
                <div class="product-search-results" id="productSearchResults"></div>
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
                        <div class="account-text">
                            @auth
                                @if (Auth::user()->role_id === null)
                                    <a href="{{ route('customer.account') }}">My Account</a>
                                @else
                                    <a href="{{ route('admin.dashboard') }}">Admin Panel</a>
                                @endif
                            @else
                                <a href="{{ route('customer.login') }}">Sign In / Register</a>
                            @endauth
                        </div>
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

<!-- Mobile Menu -->
<div class="mobile-menu" id="mobileMenu">
    <div class="mobile-menu-content">
        <div class="mobile-category-item category-bars" id="mobileCategoryClose">
            <div class="mobile-category-icon mt-1">
                <i class="fas fa-bars"></i>
            </div>
            <span>Categories</span>
            <button type="button" id="mobileMenuClose" aria-label="Close menu"
                style="border:0;background:none;padding:0;margin-left:auto;">
                <i class="fas fa-times"></i>
            </button>
        </div>

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

<!-- Mobile Menu Overlay -->
<div class="mobile-menu-overlay" id="mobileMenuOverlay"></div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const promoClose = document.querySelector('.promo-close');
        const mobileMenuToggle = document.getElementById('mobileMenuToggle');
        const mobileMenu = document.getElementById('mobileMenu');
        const mobileCategoryClose = document.getElementById('mobileCategoryClose');
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
            if (mobileMenu) mobileMenu.classList.add('active');
            if (mobileMenuOverlay) mobileMenuOverlay.classList.add('active');
            document.body.classList.add('menu-open');
        }

        function closeMobileMenu() {
            if (mobileMenu) mobileMenu.classList.remove('active');
            if (mobileMenuOverlay) mobileMenuOverlay.classList.remove('active');
            document.body.classList.remove('menu-open');
        }

        if (mobileMenuToggle) {
            mobileMenuToggle.addEventListener('click', openMobileMenu);
        }

        if (mobileCategoryClose) {
            mobileCategoryClose.addEventListener('click', closeMobileMenu);
        }

        if (mobileMenuOverlay) {
            mobileMenuOverlay.addEventListener('click', closeMobileMenu);
        }

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
                            const errorText = await response.text();
                            console.error('Search HTTP Error:', response.status);
                            console.error(errorText);
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