<div class="sidebar" data-background-color="{{ $settings->sidebar_color ?? 'dark' }}">
    <div class="sidebar-logo">
        <div class="logo-header" data-background-color="{{ $settings->logo_header_color ?? 'dark' }}">
            <a href="{{ route('admin.dashboard') }}" class="logo">
                <img src="{{ asset($settings->site_logo) }}" alt="navbar brand" class="navbar-brand" height="20" />
            </a>
            <div class="nav-toggle">
                <button class="btn btn-toggle toggle-sidebar">
                    <i class="gg-menu-right"></i>
                </button>
                <button class="btn btn-toggle sidenav-toggler">
                    <i class="gg-menu-left"></i>
                </button>
            </div>
            <button class="topbar-toggler more">
                <i class="gg-more-vertical-alt"></i>
            </button>
        </div>
    </div>
    <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
            <ul class="nav nav-secondary">
                <li class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <a href="{{ route('admin.dashboard') }}">
                        <i class="fas fa-home"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                {{-- ==================== PRODUCT MANAGEMENT ==================== --}}
                @canany([
                    'products.view', 'products.create',
                    'product-categories.view', 'product-categories.create',
                    'brands.view', 'brands.create',
                    'product-attributes.view', 'product-attributes.create',
                    'product-faqs.view', 'product-faqs.create',
                ])
                    <li class="nav-section">
                        <span class="sidebar-mini-icon">
                            <i class="fa fa-ellipsis-h"></i>
                        </span>
                        <h4 class="text-section">Product Management</h4>
                    </li>
                @endcanany

                {{-- Products --}}
                @canany(['products.view', 'products.create'])
                    <li class="nav-item {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                        <a
                            data-bs-toggle="collapse"
                            href="#products"
                            class="{{ request()->routeIs('admin.products.*') ? '' : 'collapsed' }}"
                            aria-expanded="{{ request()->routeIs('admin.products.*') ? 'true' : 'false' }}">
                            <i class="fas fa-box"></i>
                            <p>Product</p>
                            <span class="caret"></span>
                        </a>
                        <div class="collapse {{ request()->routeIs('admin.products.*') ? 'show' : '' }}" id="products">
                            <ul class="nav nav-collapse">
                                @can('products.view')
                                    <li class="{{ request()->routeIs('admin.products.index') ? 'active' : '' }}">
                                        <a href="{{ route('admin.products.index') }}">
                                            <span class="sub-item">All Products</span>
                                        </a>
                                    </li>
                                @endcan
                                @can('products.create')
                                    <li class="{{ request()->routeIs('admin.products.create') ? 'active' : '' }}">
                                        <a href="{{ route('admin.products.create') }}">
                                            <span class="sub-item">Create Product</span>
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        </div>
                    </li>
                @endcanany

                {{-- Categories --}}
                @canany(['product-categories.view', 'product-categories.create'])
                    <li class="nav-item {{ request()->routeIs('admin.product-categories.*') ? 'active' : '' }}">
                        <a
                            data-bs-toggle="collapse"
                            href="#product-category"
                            class="{{ request()->routeIs('admin.product-categories.*') ? '' : 'collapsed' }}"
                            aria-expanded="{{ request()->routeIs('admin.product-categories.*') ? 'true' : 'false' }}">
                            <i class="fas fa-folder"></i>
                            <p>Product Category</p>
                            <span class="caret"></span>
                        </a>
                        <div class="collapse {{ request()->routeIs('admin.product-categories.*') ? 'show' : '' }}" id="product-category">
                            <ul class="nav nav-collapse">
                                @can('product-categories.view')
                                    <li class="{{ request()->routeIs('admin.product-categories.index') ? 'active' : '' }}">
                                        <a href="{{ route('admin.product-categories.index') }}">
                                            <span class="sub-item">Product Categories</span>
                                        </a>
                                    </li>
                                @endcan
                                @can('product-categories.create')
                                    <li class="{{ request()->routeIs('admin.product-categories.create') ? 'active' : '' }}">
                                        <a href="{{ route('admin.product-categories.create') }}">
                                            <span class="sub-item">Create Category</span>
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        </div>
                    </li>
                @endcanany

                {{-- Brands --}}
                @canany(['brands.view', 'brands.create'])
                    <li class="nav-item {{ request()->routeIs('admin.brands.*') ? 'active' : '' }}">
                        <a
                            data-bs-toggle="collapse"
                            href="#brands"
                            class="{{ request()->routeIs('admin.brands.*') ? '' : 'collapsed' }}"
                            aria-expanded="{{ request()->routeIs('admin.brands.*') ? 'true' : 'false' }}">
                            <i class="fas fa-tags"></i>
                            <p>Product Brand</p>
                            <span class="caret"></span>
                        </a>
                        <div class="collapse {{ request()->routeIs('admin.brands.*') ? 'show' : '' }}" id="brands">
                            <ul class="nav nav-collapse">
                                @can('brands.view')
                                    <li class="{{ request()->routeIs('admin.brands.index') ? 'active' : '' }}">
                                        <a href="{{ route('admin.brands.index') }}">
                                            <span class="sub-item">All Brands</span>
                                        </a>
                                    </li>
                                @endcan
                                @can('brands.create')
                                    <li class="{{ request()->routeIs('admin.brands.create') ? 'active' : '' }}">
                                        <a href="{{ route('admin.brands.create') }}">
                                            <span class="sub-item">Create Brand</span>
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        </div>
                    </li>
                @endcanany

                {{-- Attributes --}}
                @canany(['product-attributes.view', 'product-attributes.create'])
                    <li class="nav-item {{ request()->routeIs('admin.product-attributes.*') ? 'active' : '' }}">
                        <a
                            data-bs-toggle="collapse"
                            href="#productAttributes"
                            class="{{ request()->routeIs('admin.product-attributes.*') ? '' : 'collapsed' }}"
                            aria-expanded="{{ request()->routeIs('admin.product-attributes.*') ? 'true' : 'false' }}">
                            <i class="fas fa-sliders-h"></i>
                            <p>Product Attributes</p>
                            <span class="caret"></span>
                        </a>
                        <div class="collapse {{ request()->routeIs('admin.product-attributes.*') ? 'show' : '' }}" id="productAttributes">
                            <ul class="nav nav-collapse">
                                @can('product-attributes.view')
                                    <li class="{{ request()->routeIs('admin.product-attributes.index') ? 'active' : '' }}">
                                        <a href="{{ route('admin.product-attributes.index') }}">
                                            <span class="sub-item">All Attributes</span>
                                        </a>
                                    </li>
                                @endcan
                                @can('product-attributes.create')
                                    <li class="{{ request()->routeIs('admin.product-attributes.create') ? 'active' : '' }}">
                                        <a href="{{ route('admin.product-attributes.create') }}">
                                            <span class="sub-item">Create Attribute</span>
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        </div>
                    </li>
                @endcanany

                {{-- Product FAQs --}}
                @canany(['product-faqs.view', 'product-faqs.create'])
                    <li class="nav-item {{ request()->routeIs('admin.product-faqs.*') ? 'active' : '' }}">
                        <a
                            data-bs-toggle="collapse"
                            href="#productFaqs"
                            class="{{ request()->routeIs('admin.product-faqs.*') ? '' : 'collapsed' }}"
                            aria-expanded="{{ request()->routeIs('admin.product-faqs.*') ? 'true' : 'false' }}">
                            <i class="fas fa-question-circle"></i>
                            <p>Product FAQs</p>
                            <span class="caret"></span>
                        </a>
                        <div class="collapse {{ request()->routeIs('admin.product-faqs.*') ? 'show' : '' }}" id="productFaqs">
                            <ul class="nav nav-collapse">
                                @can('product-faqs.view')
                                    <li class="{{ request()->routeIs('admin.product-faqs.index') ? 'active' : '' }}">
                                        <a href="{{ route('admin.product-faqs.index') }}">
                                            <span class="sub-item">All FAQs</span>
                                        </a>
                                    </li>
                                @endcan
                                @can('product-faqs.create')
                                    <li class="{{ request()->routeIs('admin.product-faqs.create') ? 'active' : '' }}">
                                        <a href="{{ route('admin.product-faqs.create') }}">
                                            <span class="sub-item">Create FAQ</span>
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        </div>
                    </li>
                @endcanany

                {{-- ==================== E-COMMERCE ==================== --}}
                @canany([
                    'orders.view', 'orders.edit',
                    'product-inventory.view', 'product-inventory.create',
                    'product-reviews.view', 'product-reviews.edit',
                    'product-wishlists.view', 'product-wishlists.delete',
                    'product-compares.view', 'product-compares.delete',
                ])
                    <li class="nav-section">
                        <span class="sidebar-mini-icon">
                            <i class="fa fa-ellipsis-h"></i>
                        </span>
                        <h4 class="text-section">E-commerce</h4>
                    </li>
                @endcanany

                {{-- Orders --}}
                @canany(['orders.view', 'orders.edit'])
                    <li class="nav-item {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                        <a
                            data-bs-toggle="collapse"
                            href="#orders"
                            class="{{ request()->routeIs('admin.orders.*') ? '' : 'collapsed' }}"
                            aria-expanded="{{ request()->routeIs('admin.orders.*') ? 'true' : 'false' }}">
                            <i class="fas fa-shopping-cart"></i>
                            <p>Orders</p>
                            <span class="caret"></span>
                        </a>
                        <div class="collapse {{ request()->routeIs('admin.orders.*') ? 'show' : '' }}" id="orders">
                            <ul class="nav nav-collapse">
                                @can('orders.view')
                                    <li class="{{ request()->routeIs('admin.orders.index') ? 'active' : '' }}">
                                        <a href="{{ route('admin.orders.index') }}">
                                            <span class="sub-item">All Orders</span>
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        </div>
                    </li>
                @endcanany

                {{-- Product Inventory --}}
                @canany(['product-inventory.view', 'product-inventory.create'])
                    <li class="nav-item {{ request()->routeIs('admin.product-inventory.*') ? 'active' : '' }}">
                        <a
                            data-bs-toggle="collapse"
                            href="#productInventory"
                            class="{{ request()->routeIs('admin.product-inventory.*') ? '' : 'collapsed' }}"
                            aria-expanded="{{ request()->routeIs('admin.product-inventory.*') ? 'true' : 'false' }}">
                            <i class="fas fa-boxes"></i>
                            <p>Product Inventory</p>
                            <span class="caret"></span>
                        </a>
                        <div class="collapse {{ request()->routeIs('admin.product-inventory.*') ? 'show' : '' }}" id="productInventory">
                            <ul class="nav nav-collapse">
                                @can('product-inventory.view')
                                    <li class="{{ request()->routeIs('admin.product-inventory.index') ? 'active' : '' }}">
                                        <a href="{{ route('admin.product-inventory.index') }}">
                                            <span class="sub-item">All Inventory</span>
                                        </a>
                                    </li>
                                @endcan
                                @can('product-inventory.create')
                                    <li class="{{ request()->routeIs('admin.product-inventory.create') ? 'active' : '' }}">
                                        <a href="{{ route('admin.product-inventory.create') }}">
                                            <span class="sub-item">Add Inventory</span>
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        </div>
                    </li>
                @endcanany

                {{-- Product Reviews --}}
                @canany(['product-reviews.view', 'product-reviews.edit'])
                    <li class="nav-item {{ request()->routeIs('admin.product-reviews.*') ? 'active' : '' }}">
                        <a
                            data-bs-toggle="collapse"
                            href="#productReviews"
                            class="{{ request()->routeIs('admin.product-reviews.*') ? '' : 'collapsed' }}"
                            aria-expanded="{{ request()->routeIs('admin.product-reviews.*') ? 'true' : 'false' }}">
                            <i class="fas fa-star"></i>
                            <p>Product Reviews</p>
                            <span class="caret"></span>
                        </a>
                        <div class="collapse {{ request()->routeIs('admin.product-reviews.*') ? 'show' : '' }}" id="productReviews">
                            <ul class="nav nav-collapse">
                                @can('product-reviews.view')
                                    <li class="{{ request()->routeIs('admin.product-reviews.index') ? 'active' : '' }}">
                                        <a href="{{ route('admin.product-reviews.index') }}">
                                            <span class="sub-item">All Reviews</span>
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        </div>
                    </li>
                @endcanany

                {{-- Product Wishlists --}}
                @canany(['product-wishlists.view', 'product-wishlists.delete'])
                    <li class="nav-item {{ request()->routeIs('admin.product-wishlists.*') ? 'active' : '' }}">
                        <a
                            data-bs-toggle="collapse"
                            href="#productWishlists"
                            class="{{ request()->routeIs('admin.product-wishlists.*') ? '' : 'collapsed' }}"
                            aria-expanded="{{ request()->routeIs('admin.product-wishlists.*') ? 'true' : 'false' }}">
                            <i class="fas fa-heart"></i>
                            <p>Product Wishlists</p>
                            <span class="caret"></span>
                        </a>
                        <div class="collapse {{ request()->routeIs('admin.product-wishlists.*') ? 'show' : '' }}" id="productWishlists">
                            <ul class="nav nav-collapse">
                                @can('product-wishlists.view')
                                    <li class="{{ request()->routeIs('admin.product-wishlists.index') ? 'active' : '' }}">
                                        <a href="{{ route('admin.product-wishlists.index') }}">
                                            <span class="sub-item">All Wishlists</span>
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        </div>
                    </li>
                @endcanany

                {{-- Product Compares --}}
                @canany(['product-compares.view', 'product-compares.delete'])
                    <li class="nav-item {{ request()->routeIs('admin.product-compares.*') ? 'active' : '' }}">
                        <a
                            data-bs-toggle="collapse"
                            href="#productCompares"
                            class="{{ request()->routeIs('admin.product-compares.*') ? '' : 'collapsed' }}"
                            aria-expanded="{{ request()->routeIs('admin.product-compares.*') ? 'true' : 'false' }}">
                            <i class="fas fa-exchange-alt"></i>
                            <p>Product Compares</p>
                            <span class="caret"></span>
                        </a>
                        <div class="collapse {{ request()->routeIs('admin.product-compares.*') ? 'show' : '' }}" id="productCompares">
                            <ul class="nav nav-collapse">
                                @can('product-compares.view')
                                    <li class="{{ request()->routeIs('admin.product-compares.index') ? 'active' : '' }}">
                                        <a href="{{ route('admin.product-compares.index') }}">
                                            <span class="sub-item">All Compares</span>
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        </div>
                    </li>
                @endcanany

                {{-- ==================== Marketing ==================== --}}
                @canany(['discounts.view'])
                    <li class="nav-section">
                        <span class="sidebar-mini-icon">
                            <i class="fa fa-ellipsis-h"></i>
                        </span>
                        <h4 class="text-section">Marketing</h4>
                    </li>
                @endcanany
                
                @canany(['discounts.view', 'discounts.create'])
                    <li class="nav-item {{ request()->routeIs('admin.discounts.*') ? 'active' : '' }}">
                        <a
                            data-bs-toggle="collapse"
                            href="#discountsMenu"
                            class="{{ request()->routeIs('admin.discounts.*') ? '' : 'collapsed' }}"
                            aria-expanded="{{ request()->routeIs('admin.discounts.*') ? 'true' : 'false' }}"
                        >
                            <i class="fa fa-percent"></i>
                            <p>Discounts</p>
                            <span class="caret"></span>
                        </a>
                        <div class="collapse {{ request()->routeIs('admin.discounts.*') ? 'show' : '' }}" id="discountsMenu">
                            <ul class="nav nav-collapse">
                                @can('discounts.view')
                                    <li class="{{ request()->routeIs('admin.discounts.index') || request()->routeIs('admin.discounts.show') ? 'active' : '' }}">
                                        <a href="{{ route('admin.discounts.index') }}">
                                            <span class="sub-item">All Discounts</span>
                                        </a>
                                    </li>
                                @endcan
                                @can('discounts.create')
                                    <li class="{{ request()->routeIs('admin.discounts.create') ? 'active' : '' }}">
                                        <a href="{{ route('admin.discounts.create') }}">
                                            <span class="sub-item">Create Discount</span>
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        </div>
                    </li>
                @endcanany
                
                @canany(['coupons.view', 'coupons.create'])
                    <li class="nav-item {{ request()->routeIs('admin.coupons.*') ? 'active' : '' }}">
                        <a
                            data-bs-toggle="collapse"
                            href="#couponsMenu"
                            class="{{ request()->routeIs('admin.coupons.*') ? '' : 'collapsed' }}"
                            aria-expanded="{{ request()->routeIs('admin.coupons.*') ? 'true' : 'false' }}"
                        >
                            <i class="fa fa-ticket-alt"></i>
                            <p>Coupons</p>
                            <span class="caret"></span>
                        </a>
                        <div class="collapse {{ request()->routeIs('admin.coupons.*') ? 'show' : '' }}" id="couponsMenu">
                            <ul class="nav nav-collapse">
                                @can('coupons.view')
                                    <li class="{{ request()->routeIs('admin.coupons.index') || request()->routeIs('admin.coupons.show') ? 'active' : '' }}">
                                        <a href="{{ route('admin.coupons.index') }}">
                                            <span class="sub-item">All Coupons</span>
                                        </a>
                                    </li>
                                @endcan
                                @can('coupons.create')
                                    <li class="{{ request()->routeIs('admin.coupons.create') ? 'active' : '' }}">
                                        <a href="{{ route('admin.coupons.create') }}">
                                            <span class="sub-item">Create Coupon</span>
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        </div>
                    </li>
                @endcanany
                
                {{-- ==================== BLOG MANAGEMENT ==================== --}}
                @canany(['blogs.view', 'blogs.create', 'blog-categories.view', 'blog-categories.create'])
                    <li class="nav-section">
                        <span class="sidebar-mini-icon">
                            <i class="fa fa-ellipsis-h"></i>
                        </span>
                        <h4 class="text-section">Blog Management</h4>
                    </li>
                @endcanany

                @canany(['blogs.view', 'blogs.create'])
                    <li class="nav-item {{ request()->routeIs('admin.blogs.*') ? 'active' : '' }}">
                        <a
                            data-bs-toggle="collapse"
                            href="#blogs"
                            class="{{ request()->routeIs('admin.blogs.*') ? '' : 'collapsed' }}"
                            aria-expanded="{{ request()->routeIs('admin.blogs.*') ? 'true' : 'false' }}">
                            <i class="fas fa-newspaper"></i>
                            <p>Blog</p>
                            <span class="caret"></span>
                        </a>
                        <div class="collapse {{ request()->routeIs('admin.blogs.*') ? 'show' : '' }}" id="blogs">
                            <ul class="nav nav-collapse">
                                @can('blogs.view')
                                    <li class="{{ request()->routeIs('admin.blogs.index') ? 'active' : '' }}">
                                        <a href="{{ route('admin.blogs.index') }}">
                                            <span class="sub-item">All Blogs</span>
                                        </a>
                                    </li>
                                @endcan
                                @can('blogs.create')
                                    <li class="{{ request()->routeIs('admin.blogs.create') ? 'active' : '' }}">
                                        <a href="{{ route('admin.blogs.create') }}">
                                            <span class="sub-item">Create Blog</span>
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        </div>
                    </li>
                @endcanany

                @canany(['blog-categories.view', 'blog-categories.create'])
                    <li class="nav-item {{ request()->routeIs('admin.blog-categories.*') ? 'active' : '' }}">
                        <a
                            data-bs-toggle="collapse"
                            href="#blog-category"
                            class="{{ request()->routeIs('admin.blog-categories.*') ? '' : 'collapsed' }}"
                            aria-expanded="{{ request()->routeIs('admin.blog-categories.*') ? 'true' : 'false' }}">
                            <i class="fas fa-folder"></i>
                            <p>Blog Category</p>
                            <span class="caret"></span>
                        </a>
                        <div class="collapse {{ request()->routeIs('admin.blog-categories.*') ? 'show' : '' }}" id="blog-category">
                            <ul class="nav nav-collapse">
                                @can('blog-categories.view')
                                    <li class="{{ request()->routeIs('admin.blog-categories.index') ? 'active' : '' }}">
                                        <a href="{{ route('admin.blog-categories.index') }}">
                                            <span class="sub-item">Blog Categories</span>
                                        </a>
                                    </li>
                                @endcan
                                @can('blog-categories.create')
                                    <li class="{{ request()->routeIs('admin.blog-categories.create') ? 'active' : '' }}">
                                        <a href="{{ route('admin.blog-categories.create') }}">
                                            <span class="sub-item">Create Category</span>
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        </div>
                    </li>
                @endcanany

                {{-- ==================== USER MANAGEMENT ==================== --}}
                @canany(['users.view', 'users.create', 'roles.view', 'roles.create'])
                    <li class="nav-section">
                        <span class="sidebar-mini-icon">
                            <i class="fa fa-ellipsis-h"></i>
                        </span>
                        <h4 class="text-section">User Management</h4>
                    </li>
                @endcanany

                @canany(['users.view', 'users.create'])
                    <li class="nav-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                        <a data-bs-toggle="collapse" href="#users" class="{{ request()->routeIs('admin.users.*') ? '' : 'collapsed' }}" aria-expanded="{{ request()->routeIs('admin.users.*') ? 'true' : 'false' }}">
                            <i class="fas fa-users"></i>
                            <p>Users</p>
                            <span class="caret"></span>
                        </a>
                        <div class="collapse {{ request()->routeIs('admin.users.*') ? 'show' : '' }}" id="users">
                            <ul class="nav nav-collapse">
                                @can('users.view')
                                    <li class="{{ request()->routeIs('admin.users.index') ? 'active' : '' }}">
                                        <a href="{{ route('admin.users.index') }}">
                                            <span class="sub-item">All User</span>
                                        </a>
                                    </li>
                                @endcan
                                @can('users.create')
                                    <li class="{{ request()->routeIs('admin.users.create') ? 'active' : '' }}">
                                        <a href="{{ route('admin.users.create') }}">
                                            <span class="sub-item">Create User</span>
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        </div>
                    </li>
                @endcanany

                @canany(['customers.view', 'customers.edit'])
                    <li class="nav-item {{ request()->routeIs('admin.customers.*') ? 'active' : '' }}">
                        <a
                            data-bs-toggle="collapse"
                            href="#customers"
                            class="{{ request()->routeIs('admin.customers.*') ? '' : 'collapsed' }}"
                            aria-expanded="{{ request()->routeIs('admin.customers.*') ? 'true' : 'false' }}"
                        >
                            <i class="fas fa-users"></i>
                            <p>Customers</p>
                            <span class="caret"></span>
                        </a>

                        <div
                            class="collapse {{ request()->routeIs('admin.customers.*') ? 'show' : '' }}"
                            id="customers"
                        >
                            <ul class="nav nav-collapse">
                                @can('customers.view')
                                    <li class="{{ request()->routeIs('admin.customers.index') ? 'active' : '' }}">
                                        <a href="{{ route('admin.customers.index') }}">
                                            <span class="sub-item">
                                                All Customers
                                            </span>
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        </div>
                    </li>
                @endcanany

                @canany(['roles.view', 'roles.create'])
                    <li class="nav-item {{ request()->routeIs('admin.roles.*') ? 'active' : '' }}">
                        <a data-bs-toggle="collapse" href="#roles" class="{{ request()->routeIs('admin.roles.*') ? '' : 'collapsed' }}" aria-expanded="{{ request()->routeIs('admin.roles.*') ? 'true' : 'false' }}">
                            <i class="fas fa-user-tag"></i>
                            <p>Roles & Permissions</p>
                            <span class="caret"></span>
                        </a>
                        <div class="collapse {{ request()->routeIs('admin.roles.*') ? 'show' : '' }}" id="roles">
                            <ul class="nav nav-collapse">
                                @can('roles.view')
                                    <li class="{{ request()->routeIs('admin.roles.index') ? 'active' : '' }}">
                                        <a href="{{ route('admin.roles.index') }}">
                                            <span class="sub-item">All Roles</span>
                                        </a>
                                    </li>
                                @endcan
                                @can('roles.create')
                                    <li class="{{ request()->routeIs('admin.roles.create') ? 'active' : '' }}">
                                        <a href="{{ route('admin.roles.create') }}">
                                            <span class="sub-item">Create Role</span>
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        </div>
                    </li>
                @endcanany

                {{-- ==================== SETTINGS ==================== --}}
                @can(['settings.view', 'store-settings.view'])
                    <li class="nav-section">
                        <span class="sidebar-mini-icon">
                            <i class="fa fa-ellipsis-h"></i>
                        </span>
                        <h4 class="text-section">Settings Management</h4>
                    </li>

                    <li class="nav-item {{ request()->routeIs('admin.settings.index') ? 'active' : '' }}">
                        <a href="{{ route('admin.settings.index') }}" class="{{ request()->routeIs('admin.settings.index') ? '' : 'collapsed' }}">
                            <i class="fas fa-cog"></i>
                            <p>Settings</p>
                        </a>
                    </li>
                    <li class="nav-item {{ request()->routeIs('admin.store-settings.*') ? 'active' : '' }}">
                        <a href="{{ route('admin.store-settings.index') }}" class="{{ request()->routeIs('admin.store-settings.*') ? '' : 'collapsed' }}">
                            <i class="fas fa-store"></i>
                            <p>Store Settings</p>
                        </a>
                    </li>
                @endcan
            </ul>
        </div>
    </div>
</div>