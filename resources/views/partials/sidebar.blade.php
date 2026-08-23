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
                @canany(['products.view', 'products.create', 'product_categories.view', 'product_categories.create','brands.view','brands.create'])
                    <li class="nav-section">
                        <span class="sidebar-mini-icon">
                            <i class="fa fa-ellipsis-h"></i>
                        </span>

                        <h4 class="text-section">Product Management</h4>
                    </li>
                @endcanany

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
                                            <span class="sub-item">
                                                All Products
                                            </span>
                                        </a>
                                    </li>
                                @endcan

                                @can('products.create')
                                    <li class="{{ request()->routeIs('admin.products.create') ? 'active' : '' }}">
                                        <a href="{{ route('admin.products.create') }}">
                                            <span class="sub-item">
                                                Create Product
                                            </span>
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        </div>
                    </li>
                @endcanany

                @canany(['product_categories.view', 'product_categories.create'])
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

                        <div
                            class="collapse {{ request()->routeIs('admin.product-categories.*') ? 'show' : '' }}"
                            id="product-category">
                            <ul class="nav nav-collapse">
                                @can('product_categories.view')
                                    <li class="{{ request()->routeIs('admin.product-categories.index') ? 'active' : '' }}">
                                        <a href="{{ route('admin.product-categories.index') }}">
                                            <span class="sub-item">
                                                Product Categories
                                            </span>
                                        </a>
                                    </li>
                                @endcan

                                @can('product_categories.create')
                                    <li class="{{ request()->routeIs('admin.product-categories.create') ? 'active' : '' }}">
                                        <a href="{{ route('admin.product-categories.create') }}">
                                            <span class="sub-item">
                                                Create Category
                                            </span>
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        </div>
                    </li>
                @endcanany

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
                                            <span class="sub-item">
                                                All Brands
                                            </span>
                                        </a>
                                    </li>
                                @endcan

                                @can('brands.create')
                                    <li class="{{ request()->routeIs('admin.brands.create') ? 'active' : '' }}">
                                        <a href="{{ route('admin.brands.create') }}">
                                            <span class="sub-item">
                                                Create Brand
                                            </span>
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        </div>
                    </li>
                @endcanany

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

                        <div
                            class="collapse {{ request()->routeIs('admin.product-attributes.*') ? 'show' : '' }}"
                            id="productAttributes">
                            <ul class="nav nav-collapse">
                                @can('product-attributes.view')
                                    <li class="{{ request()->routeIs('admin.product-attributes.index') ? 'active' : '' }}">
                                        <a href="{{ route('admin.product-attributes.index') }}">
                                            <span class="sub-item">
                                                All Attributes
                                            </span>
                                        </a>
                                    </li>
                                @endcan

                                @can('product-attributes.create')
                                    <li class="{{ request()->routeIs('admin.product-attributes.create') ? 'active' : '' }}">
                                        <a href="{{ route('admin.product-attributes.create') }}">
                                            <span class="sub-item">
                                                Create Attribute
                                            </span>
                                        </a>
                                    </li>
                                @endcan
                            </ul>
                        </div>
                    </li>
                @endcanany

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

                        <div
                            class="collapse {{ request()->routeIs('admin.product-faqs.*') ? 'show' : '' }}"
                            id="productFaqs">
                            <ul class="nav nav-collapse">

                                @can('product-faqs.view')
                                    <li class="{{ request()->routeIs('admin.product-faqs.index') ? 'active' : '' }}">
                                        <a href="{{ route('admin.product-faqs.index') }}">
                                            <span class="sub-item">
                                                All FAQs
                                            </span>
                                        </a>
                                    </li>
                                @endcan

                                @can('product-faqs.create')
                                    <li class="{{ request()->routeIs('admin.product-faqs.create') ? 'active' : '' }}">
                                        <a href="{{ route('admin.product-faqs.create') }}">
                                            <span class="sub-item">
                                                Create FAQ
                                            </span>
                                        </a>
                                    </li>
                                @endcan

                            </ul>
                        </div>
                    </li>
                @endcanany

                @canany(['blogs.view', 'blogs.create', 'blog_categories.view', 'blog_categories.create'])
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
                                        <span class="sub-item">
                                            All Blogs
                                        </span>
                                    </a>
                                </li>
                                @endcan

                                @can('blogs.create')
                                <li class="{{ request()->routeIs('admin.blogs.create') ? 'active' : '' }}">
                                    <a href="{{ route('admin.blogs.create') }}">
                                        <span class="sub-item">
                                            Create Blog
                                        </span>
                                    </a>
                                </li>
                                @endcan
                            </ul>
                        </div>
                    </li>
                @endcanany

                @canany(['blog_categories.view', 'blog_categories.create'])
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

                        <div
                            class="collapse {{ request()->routeIs('admin.blog-categories.*') ? 'show' : '' }}"
                            id="blog-category">
                            <ul class="nav nav-collapse">
                                @can('blog_categories.view')
                                <li class="{{ request()->routeIs('admin.blog-categories.index') ? 'active' : '' }}">
                                    <a href="{{ route('admin.blog-categories.index') }}">
                                        <span class="sub-item">
                                            Blog Categories
                                        </span>
                                    </a>
                                </li>
                                @endcan

                                @can('blog_categories.create')
                                <li class="{{ request()->routeIs('admin.blog-categories.create') ? 'active' : '' }}">
                                    <a href="{{ route('admin.blog-categories.create') }}">
                                        <span class="sub-item">
                                            Create Category
                                        </span>
                                    </a>
                                </li>
                                @endcan
                            </ul>
                        </div>
                    </li>
                @endcanany

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

                @can(['settings.view', 'store_settings.view'])
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
                        <a
                            href="{{ route('admin.store-settings.index') }}"
                            class="{{ request()->routeIs('admin.store-settings.*') ? '' : 'collapsed' }}"
                        >
                            <i class="fas fa-store"></i>
                            <p>Store Settings</p>
                        </a>
                    </li>
                @endcan
            </ul>
        </div>
    </div>
</div>