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
        <div class="row g-3 g-lg-4">
            @forelse ($products as $product)
                @php
                    $hasDiscount =
                        $product->discount_price !== null && $product->discount_price < $product->selling_price;
                    $currentPrice = $hasDiscount ? $product->discount_price : $product->selling_price;
                    $productImage = $product->thumbnail;
                @endphp

                <div class="col-5-cards">
                    <div class="product-card position-relative">
                        <!-- Heart Icon -->
                        <button class="wishlist-btn position-absolute top-0 end-0 m-2">
                            <i class="fa-regular fa-heart"></i>
                        </button>

                        <a href="{{ route('products.show', $product->slug) }}" class="product-image-container">
                            @if ($productImage)
                                <img src="{{ asset('storage/' . ltrim($product->thumbnail, '/')) }}"
                                    alt="{{ $product->name }}">
                            @else
                                <img class="border" src="{{ asset('frontend/images/no-image.jpg') }}"
                                    alt="{{ $product->name }}">
                            @endif

                            <!-- Quick View Button -->
                            <span class="quick-view-btn text-decoration-none">
                                <i class="fa-regular fa-eye"></i>Quick View
                            </span>
                        </a>

                        <div class="product-info">
                            <div>
                                <a href="{{ route('products.show', $product->slug) }}"
                                    class="product-name d-block text-decoration-none">
                                    {{ $product->name }}
                                </a>

                                <div class="product-price-container">
                                    <span class="currency">৳</span>
                                    <span class="product-price">{{ number_format($currentPrice, 0) }}</span>
                                    <span class="product-vat">+ VAT</span>

                                    @if ($hasDiscount)
                                        <span class="text-muted text-decoration-line-through ms-2">
                                            ৳ {{ number_format($product->selling_price, 0) }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="text-center py-5">
                        <i class="fa-solid fa-box-open fs-1 text-muted mb-3"></i>
                        <h5 class="mb-2">No Products Found</h5>
                        <p class="text-muted mb-0">There are no products available at the moment.</p>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if ($products->hasPages())
            <div class="d-flex justify-content-center mt-5">
                {{ $products->withQueryString()->links() }}
            </div>
        @endif
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
        function toggleSection(header) {
            const content = header.nextElementSibling;
            const icon = header.querySelector('.toggle-icon');

            content.classList.toggle('show');

            if (icon) {
                icon.textContent = content.classList.contains('show') ? '−' : '+';
            }
        }

        function sortProducts(value) {
            const url = new URL(window.location.href);

            url.searchParams.set('sort', value);
            url.searchParams.delete('page');

            window.location.href = url.toString();
        }

        document.addEventListener('DOMContentLoaded', function() {
            const filterButtons = document.querySelectorAll('[data-filter]');
            const filterSections = document.querySelectorAll('[data-filter-section]');

            filterButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const filter = this.dataset.filter;

                    filterSections.forEach(section => {
                        const content = section.querySelector('.filter-content');
                        const icon = section.querySelector('.toggle-icon');

                        if (!content) {
                            return;
                        }

                        if (filter === 'all') {
                            content.classList.remove('show');

                            if (icon) {
                                icon.textContent = '+';
                            }

                            return;
                        }

                        if (section.dataset.filterSection === filter) {
                            content.classList.add('show');

                            if (icon) {
                                icon.textContent = '−';
                            }
                        } else {
                            content.classList.remove('show');

                            if (icon) {
                                icon.textContent = '+';
                            }
                        }
                    });
                });
            });
        });
    </script>
@endpush
