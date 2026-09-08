@extends('frontend.layouts.app')

@section('title', 'Products')

@push('styles')
    <link rel="stylesheet" href="{{ asset('frontend/css/design-1/products.css') }}">
@endpush

@section('content')
    <div class="container-fluid px-4 px-md-5 pb-5 py-4">
        <div class="filter-header">
            <!-- Breadcrumb -->
            <nav aria-label="breadcrumb" class="breadcrumb-wrapper">
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item">
                        <a href="{{ route('home') }}" class="text-muted text-decoration-none">Home</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Products</li>
                </ol>
            </nav>

            <!-- Filter Row -->
            <div class="filter-toolbar">
                <div class="filter-buttons">
                    <strong>Filters:</strong>

                    <!-- Main Filter Button -->
                    <button class="filter-btn btn border" type="button" data-bs-toggle="offcanvas"
                        data-bs-target="#filterOffcanvas" data-filter="all">
                        <i class="fa-solid fa-sliders"></i>
                    </button>

                    <!-- Mobile Filter Buttons -->
                    <button class="filter-btn filter-btn-mobile btn border" type="button" data-bs-toggle="offcanvas"
                        data-bs-target="#filterOffcanvas" data-filter="category">
                        Category
                    </button>

                    <button class="filter-btn filter-btn-mobile btn border" type="button" data-bs-toggle="offcanvas"
                        data-bs-target="#filterOffcanvas" data-filter="price">
                        Price
                    </button>

                    @foreach ($attributes as $attribute)
                        <button class="filter-btn filter-btn-mobile btn border" type="button" data-bs-toggle="offcanvas"
                            data-bs-target="#filterOffcanvas" data-filter="{{ $attribute->slug }}">
                            {{ $attribute->name }}
                        </button>
                    @endforeach
                </div>

                <div class="product-sort-by d-flex align-items-center">
                    <label for="sortSelect" class="me-2 mb-0">Sort By:</label>
                    <select id="sortSelect" class="form-select" onchange="sortProducts(this.value)">
                        <option value="newest" {{ request('sort') === 'newest' || !request('sort') ? 'selected' : '' }}>
                            Newest Arrivals
                        </option>
                        <option value="priceLowHigh" {{ request('sort') === 'priceLowHigh' ? 'selected' : '' }}>
                            Price: Low to High
                        </option>
                        <option value="priceHighLow" {{ request('sort') === 'priceHighLow' ? 'selected' : '' }}>
                            Price: High to Low
                        </option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Products -->
       <div id="products-container">
            @include('frontend.components.product.listing.design-1', ['products' => $products])
        </div>
    </div>

    <!-- Filter Offcanvas -->
    <div class="offcanvas offcanvas-end custom-offcanvas" tabindex="-1" id="filterOffcanvas">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title">Filter</h5>
            <button class="offcanvas-close-btn" data-bs-dismiss="offcanvas">Close</button>
        </div>

        <div class="offcanvas-body">
            <form method="GET" action="{{ route('products.index') }}" id="productFilterForm">
                <input type="hidden" name="sort" value="{{ request('sort', 'newest') }}">

                <div class="filter-column" id="filterColumn">
                    <div class="sidebar-filter bg-white p-2">

                        <!-- Category -->
                        <div class="filter-section" data-filter-section="category">
                            <div class="d-flex justify-content-between align-items-center section-header"
                                onclick="toggleSection(this)">
                                <h6 class="fw-medium mb-0">Category</h6>
                                <span class="toggle-icon fs-4 fw-bold text-dark">+</span>
                            </div>

                            <div class="filter-content">
                                @foreach ($categories as $category)
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" name="category[]"
                                            value="{{ $category->slug }}" id="category-{{ $category->id }}"
                                            {{ in_array($category->slug, (array) request('category', [])) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="category-{{ $category->id }}">
                                            {{ $category->name }}
                                        </label>
                                    </div>

                                    @foreach ($category->children as $subcategory)
                                        <div class="form-check mb-2 ms-3">
                                            <input class="form-check-input" type="checkbox" name="category[]"
                                                value="{{ $subcategory->slug }}" id="category-{{ $subcategory->id }}"
                                                {{ in_array($subcategory->slug, (array) request('category', [])) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="category-{{ $subcategory->id }}">
                                                {{ $subcategory->name }}
                                            </label>
                                        </div>
                                    @endforeach
                                @endforeach
                            </div>
                        </div>

                        <!-- Price -->
                        <div class="filter-section" data-filter-section="price">
                            <div class="d-flex justify-content-between align-items-center section-header"
                                onclick="toggleSection(this)">
                                <h6 class="fw-medium mb-0">Price</h6>
                                <span class="toggle-icon fs-4 fw-bold text-dark">+</span>
                            </div>

                            <div class="filter-content">
                                @php
                                    $priceRanges = [
                                        '0-1000' => '0 - 1000',
                                        '1001-2000' => '1001 - 2000',
                                        '2001-3000' => '2001 - 3000',
                                        '3001-4000' => '3001 - 4000',
                                        '4001-5000' => '4001 - 5000',
                                        '5001-6000' => '5001 - 6000',
                                        '6001-7000' => '6001 - 7000',
                                        '7001+' => '7001+',
                                    ];
                                @endphp

                                @foreach ($priceRanges as $value => $label)
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" name="price[]"
                                            value="{{ $value }}"
                                            id="price-{{ str_replace(['+', '-'], ['', '_'], $value) }}"
                                            {{ in_array($value, (array) request('price', [])) ? 'checked' : '' }}>
                                        <label class="form-check-label"
                                            for="price-{{ str_replace(['+', '-'], ['', '_'], $value) }}">
                                            {{ $label }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Dynamic Product Attributes -->
                        @foreach ($attributes as $attribute)
                            @php
                                $selectedValues = (array) request($attribute->slug, []);
                            @endphp

                            <div class="filter-section" data-filter-section="{{ $attribute->slug }}">
                                <div class="d-flex justify-content-between align-items-center section-header"
                                    onclick="toggleSection(this)">
                                    <h6 class="fw-medium mb-0">{{ $attribute->name }}</h6>
                                    <span class="toggle-icon fs-4 fw-bold text-dark">+</span>
                                </div>

                                <div class="filter-content">
                                    @forelse ($attribute->values as $value)
                                        <div class="form-check mb-2">
                                            <input class="form-check-input" type="checkbox"
                                                name="{{ $attribute->slug }}[]" value="{{ $value->slug }}"
                                                id="attribute-{{ $attribute->id }}-value-{{ $value->id }}"
                                                {{ in_array($value->slug, $selectedValues) ? 'checked' : '' }}>

                                            <label class="form-check-label"
                                                for="attribute-{{ $attribute->id }}-value-{{ $value->id }}">
                                                {{ $value->value }}
                                            </label>
                                        </div>
                                    @empty
                                        <small class="text-muted">No values available.</small>
                                    @endforelse
                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>

                <!-- Filter Actions -->
                <div class="d-flex gap-2 mt-3 filter-actions">
                    <button type="submit" class="btn btn-primary grow">
                        Apply Filters
                    </button>
                    <a href="{{ route('products.index') }}" class="btn btn-outline-secondary">
                        Clear
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const filterForm = document.getElementById('productFilterForm');
            const productsContainer = document.getElementById('products-container');
            const sortSelect = document.getElementById('sortSelect');
            const filterOffcanvas = document.getElementById('filterOffcanvas');

            function loadProducts(url = null, closeOffcanvas = true, updateHistory = true) {
                let requestUrl = url || new URL(filterForm.action, window.location.origin);
                requestUrl = new URL(requestUrl, window.location.origin);

                if (!url) {
                    const formData = new FormData(filterForm);
                    requestUrl.search = new URLSearchParams(formData).toString();
                }

                productsContainer.classList.add('products-loading');

                fetch(requestUrl.toString(), {
                    method: 'GET',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Failed to load products.');
                    }
                    return response.json();
                })
                .then(data => {
                    productsContainer.innerHTML = data.html;

                    if (updateHistory) {
                        window.history.pushState({}, '', requestUrl.toString());
                    }

                    bindPagination();

                    if (closeOffcanvas && filterOffcanvas) {
                        const offcanvas = bootstrap.Offcanvas.getInstance(filterOffcanvas);
                        if (offcanvas) {
                            offcanvas.hide();
                        }
                    }

                    window.scrollTo({
                        top: productsContainer.offsetTop - 100,
                        behavior: 'smooth'
                    });
                })
                .catch(error => {
                    console.error(error);
                })
                .finally(() => {
                    productsContainer.classList.remove('products-loading');
                });
            }

            function sortProducts(value) {
                const sortInput = filterForm.querySelector('input[name="sort"]');

                if (sortInput) {
                    sortInput.value = value;
                }

                loadProducts();
            }

            function bindPagination() {
                productsContainer.querySelectorAll('.pagination a').forEach(link => {
                    link.addEventListener('click', function (event) {
                        event.preventDefault();
                        loadProducts(this.href, false);
                    });
                });
            }

            window.sortProducts = sortProducts;

            filterForm.addEventListener('submit', function (event) {
                event.preventDefault();
                loadProducts();
            });

            document.querySelectorAll('[data-filter]').forEach(button => {
                button.addEventListener('click', function () {
                    const filter = this.dataset.filter;

                    if (filter === 'all') {
                        return;
                    }

                    const section = document.querySelector(
                        `[data-filter-section="${filter}"]`
                    );

                    if (!section) {
                        return;
                    }

                    const header = section.querySelector('.section-header');

                    if (header) {
                        toggleSection(header);
                    }
                });
            });

            document.getElementById('clearFilters')?.addEventListener('click', function (event) {
                event.preventDefault();

                filterForm.querySelectorAll('input[type="checkbox"]').forEach(input => {
                    input.checked = false;
                });

                const sortInput = filterForm.querySelector('input[name="sort"]');

                if (sortInput) {
                    sortInput.value = 'newest';
                }

                if (sortSelect) {
                    sortSelect.value = 'newest';
                }

                const clearUrl = new URL(filterForm.action, window.location.origin);

                loadProducts(clearUrl.toString(), true);
            });

            bindPagination();

            window.addEventListener('popstate', function () {
                loadProducts(window.location.href, false, false);
            });
        });

        function toggleSection(header) {
            const content = header.nextElementSibling;
            const icon = header.querySelector('.section-toggle-icon');

            if (!content) {
                return;
            }

            content.classList.toggle('show');

            if (icon) {
                icon.textContent = content.classList.contains('show') ? '−' : '+';
            }
        }
        </script>
@endpush
