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
                        data-bs-target="#filterOffcanvas">
                        <i class="fa-solid fa-sliders"></i>
                    </button>

                    <!-- Specific Filter Buttons -->
                    <button class="filter-btn filter-btn-mobile btn border" type="button" data-bs-toggle="offcanvas"
                        data-bs-target="#filterOffcanvas" data-filter="color">
                        Color
                    </button>

                    <button class="filter-btn filter-btn-mobile btn border" type="button" data-bs-toggle="offcanvas"
                        data-bs-target="#filterOffcanvas" data-filter="fabric">
                        Fabric
                    </button>

                    <button class="filter-btn filter-btn-mobile btn border" type="button" data-bs-toggle="offcanvas"
                        data-bs-target="#filterOffcanvas" data-filter="price">
                        Price
                    </button>

                    <button class="filter-btn filter-btn-mobile btn border" type="button" data-bs-toggle="offcanvas"
                        data-bs-target="#filterOffcanvas" data-filter="size">
                        Size
                    </button>

                    <button class="filter-btn filter-btn-mobile btn border" type="button" data-bs-toggle="offcanvas"
                        data-bs-target="#filterOffcanvas" data-filter="fit">
                        Cut / Fit
                    </button>
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

        <div class="row g-3 g-lg-4">
            @forelse($products as $product)
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
                            <a href="{{ route('products.show', $product->slug) }}" class="quick-view-btn text-decoration-none">
                                <i class="fa-regular fa-eye"></i>Quick View
                            </a>
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
            <div class="filter-column" id="filterColumn">
                <div class="sidebar-filter bg-white p-2">
                    <!-- Color -->
                    <div class="filter-section">
                        <div class="d-flex justify-content-between align-items-center section-header"
                            onclick="toggleSection(this)">
                            <h6 class="fw-medium mb-0">Color</h6>
                            <span class="toggle-icon fs-4 fw-bold text-dark">+</span>
                        </div>
                        <div class="filter-content">
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox">
                                <label class="form-check-label">Black</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox">
                                <label class="form-check-label">Brown</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox">
                                <label class="form-check-label">Green</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox">
                                <label class="form-check-label">Maroon</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox">
                                <label class="form-check-label">Navy Blue</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox">
                                <label class="form-check-label">White</label>
                            </div>
                        </div>
                    </div>

                    <!-- Fabric -->
                    <div class="filter-section">
                        <div class="d-flex justify-content-between align-items-center section-header"
                            onclick="toggleSection(this)">
                            <h6 class="fw-medium mb-0">Fabric</h6>
                            <span class="toggle-icon fs-4 fw-bold text-dark">+</span>
                        </div>
                        <div class="filter-content">
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox">
                                <label class="form-check-label">Viscose</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox">
                                <label class="form-check-label">Cotton</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox">
                                <label class="form-check-label">Mixed Viscose</label>
                            </div>
                        </div>
                    </div>

                    <!-- Price -->
                    <div class="filter-section">
                        <div class="d-flex justify-content-between align-items-center section-header"
                            onclick="toggleSection(this)">
                            <h6 class="fw-medium mb-0">Price</h6>
                            <span class="toggle-icon fs-4 fw-bold text-dark">+</span>
                        </div>
                        <div class="filter-content">
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox">
                                <label class="form-check-label">0-1000</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox">
                                <label class="form-check-label">1001-2000</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox">
                                <label class="form-check-label">2001-3000</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox">
                                <label class="form-check-label">3001-4000</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox">
                                <label class="form-check-label">5001-6000</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox">
                                <label class="form-check-label">7001+</label>
                            </div>
                        </div>
                    </div>

                    <!-- Size -->
                    <div class="filter-section">
                        <div class="d-flex justify-content-between align-items-center section-header"
                            onclick="toggleSection(this)">
                            <h6 class="fw-medium mb-0">Size</h6>
                            <span class="toggle-icon fs-4 fw-bold text-dark">+</span>
                        </div>
                        <div class="filter-content">
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox">
                                <label class="form-check-label">S</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox">
                                <label class="form-check-label">M</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox">
                                <label class="form-check-label">L</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox">
                                <label class="form-check-label">XL</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox">
                                <label class="form-check-label">XXL</label>
                            </div>
                        </div>
                    </div>

                    <!-- Cut / Fit -->
                    <div class="filter-section">
                        <div class="d-flex justify-content-between align-items-center section-header"
                            onclick="toggleSection(this)">
                            <h6 class="fw-medium mb-0">Cut / Fit</h6>
                            <span class="toggle-icon fs-4 fw-bold text-dark">+</span>
                        </div>
                        <div class="filter-content">
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox">
                                <label class="form-check-label">A-Line (7)</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox">
                                <label class="form-check-label">Flared (10)</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox">
                                <label class="form-check-label">Trail Tunic (2)</label>
                            </div>
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox">
                                <label class="form-check-label">Front Open (4)</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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
    </script>
@endpush
