@extends('frontend.layouts.app')

@section('title', 'Products')

@push('styles')
    <link rel="stylesheet" href="{{ app(\App\Services\Frontend\DesignManager::class)->getTemplateCss('product-listing') }}">
    <link rel="stylesheet" href="{{ app(\App\Services\Frontend\DesignManager::class)->getSectionCss('product_card') }}">
@endpush

@section('content')
    <div class="container-fluid px-4 px-md-5 pb-5 py-4">
        <div class="row g-3 g-lg-4">
            <div class="col-12 d-flex justify-content-end">
                <button class="d-lg-none mobile-filter-btn" id="mobileFilterBtn">
                    <i class="fas fa-filter"></i>
                    <span>Filter</span>
                </button>
                <div class="product-sort-by d-flex">
                    <label for="sortSelect" class="me-2">Sort By:</label>
                    <select id="sortSelect" class="form-select">
                        <option value="default">Default</option>
                        <option value="priceLowHigh">Price: Low to High</option>
                        <option value="priceHighLow">Price: High to Low</option>
                        <option value="newest">Newest Arrivals</option>
                    </select>
                </div>
            </div>

            <!-- ==================== SIDEBAR FILTER ==================== -->
            <div class="col-lg-2 col-12 filter-column" id="filterColumn">
                <div class="sidebar-filter bg-white p-2">
                    <!-- Category -->
                    <div class="filter-section">
                        <div class="d-flex justify-content-between align-items-center section-header"
                            onclick="toggleSection(this)">
                            <h6 class="fw-medium mb-0">Category</h6>
                            <span class="toggle-icon fs-4 fw-bold text-dark">+</span>
                        </div>
                        <div class="filter-content mt-3">
                            <div class="form-check mb-2"><input class="form-check-input" type="checkbox"><label
                                    class="form-check-label">Salwar Kameez</label></div>
                            <div class="form-check mb-2"><input class="form-check-input" type="checkbox"><label
                                    class="form-check-label">Kurta Pajama</label></div>
                            <div class="form-check mb-2"><input class="form-check-input" type="checkbox"><label
                                    class="form-check-label">Pathani Suit</label></div>
                            <div class="form-check mb-2"><input class="form-check-input" type="checkbox"><label
                                    class="form-check-label">Sherwani</label></div>
                            <div class="form-check mb-2"><input class="form-check-input" type="checkbox"><label
                                    class="form-check-label">Salwar Kameez</label></div>
                        </div>
                    </div>

                    <!-- Size -->
                    <div class="filter-section">
                        <div class="d-flex justify-content-between align-items-center section-header"
                            onclick="toggleSection(this)">
                            <h6 class="fw-medium mb-0">Size</h6>
                            <span class="toggle-icon fs-4 fw-bold text-dark">+</span>
                        </div>
                        <div class="filter-content mt-2">
                            <div class="form-check mb-2"><input class="form-check-input" type="checkbox"><label
                                    class="form-check-label">S</label></div>
                            <div class="form-check mb-2"><input class="form-check-input" type="checkbox"><label
                                    class="form-check-label">M</label></div>
                            <div class="form-check mb-2"><input class="form-check-input" type="checkbox"><label
                                    class="form-check-label">L</label></div>
                            <div class="form-check mb-2"><input class="form-check-input" type="checkbox"><label
                                    class="form-check-label">XL</label></div>
                            <div class="form-check mb-2"><input class="form-check-input" type="checkbox"><label
                                    class="form-check-label">XXL</label></div>
                        </div>
                    </div>

                    <!-- Color -->
                    <div class="filter-section">
                        <div class="d-flex justify-content-between align-items-center section-header"
                            onclick="toggleSection(this)">
                            <h6 class="fw-medium mb-0">Color</h6>
                            <span class="toggle-icon fs-4 fw-bold text-dark">+</span>
                        </div>
                        <div class="filter-content mt-2">
                            <div class="form-check mb-2"><input class="form-check-input" type="checkbox"><label
                                    class="form-check-label">Black</label></div>
                            <div class="form-check mb-2"><input class="form-check-input" type="checkbox"><label
                                    class="form-check-label">Brown</label></div>
                            <div class="form-check mb-2"><input class="form-check-input" type="checkbox"><label
                                    class="form-check-label">Green</label></div>
                            <div class="form-check mb-2"><input class="form-check-input" type="checkbox"><label
                                    class="form-check-label">Maroon</label></div>
                            <div class="form-check mb-2"><input class="form-check-input" type="checkbox"><label
                                    class="form-check-label">Navy Blue</label></div>
                            <div class="form-check mb-2"><input class="form-check-input" type="checkbox"><label
                                    class="form-check-label">White</label></div>
                        </div>
                    </div>

                    <!-- Brand -->
                    <div class="filter-section">
                        <div class="d-flex justify-content-between align-items-center section-header"
                            onclick="toggleSection(this)">
                            <h6 class="fw-medium mb-0">Brand</h6>
                            <span class="toggle-icon fs-4 fw-bold text-dark">+</span>
                        </div>
                        <div class="filter-content mt-2">
                            <div class="form-check mb-2"><input class="form-check-input" type="checkbox"><label
                                    class="form-check-label">Manyavar</label></div>
                            <div class="form-check mb-2"><input class="form-check-input" type="checkbox"><label
                                    class="form-check-label">Raymond</label></div>
                            <div class="form-check mb-2"><input class="form-check-input" type="checkbox"><label
                                    class="form-check-label">Sailor</label></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ==================== PRODUCT GRID ==================== -->
            <div class="col-lg-10 col-12 product-card-section">

                @include($productListingView, [
                    'products' => $products,
                    'productCardView' => $productCardView,
                ])
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function toggleSection(header) {
            const content = header.nextElementSibling;
            const icon = header.querySelector('.toggle-icon');

            if (content.style.display === "none" || content.style.display === "") {
                content.style.display = "block";
                icon.textContent = "−";
            } else {
                content.style.display = "none";
                icon.textContent = "+";
            }
        }


        document.addEventListener("DOMContentLoaded", function() {

            const filterBtn = document.getElementById('mobileFilterBtn');
            const filterColumn = document.getElementById('filterColumn');

            filterBtn.addEventListener('click', () => {
                filterColumn.classList.toggle('show');
            });

            // Optional: First 1 sections open by default
            const contents = document.querySelectorAll('.filter-content');
            contents.forEach((content, index) => {
                if (index < 1) {
                    content.style.display = "block";
                    content.previousElementSibling.querySelector('.toggle-icon').textContent = "−";
                } else {
                    content.style.display = "none";
                }
            });
        });
    </script>
@endpush
