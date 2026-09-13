@php
    $hasDiscount = $product->discount_price !== null && $product->discount_price < $product->selling_price;
    $currentPrice = $hasDiscount ? $product->discount_price : $product->selling_price;
    $discountPercentage =
        $hasDiscount && $product->selling_price > 0
            ? round((($product->selling_price - $product->discount_price) / $product->selling_price) * 100)
            : 0;
@endphp

<div class="col-5-cards">
    <div class="product-card position-relative">
        <!-- Heart Icon -->
        <button class="wishlist-btn position-absolute top-0 end-0 m-2">
            <i class="fa-regular fa-heart"></i>
        </button>

        <a href="pages/details.html" class="product-image-container">
            @if ($product->thumbnail)
                <img src="{{ asset('storage/' . ltrim($product->thumbnail, '/')) }}" alt="{{ $product->name }}">
            @else
                <span>
                    <i class="fas fa-image"></i>
                </span>
            @endif
        </a>

        <!-- Quick View Button -->
        <button
            type="button"
            class="quick-view-btn"
            data-bs-toggle="offcanvas"
            data-bs-target="#quickViewModal"
            data-product-id="{{ $product->id }}"
            data-product-name="{{ $product->name }}"
            data-product-code="{{ $product->sku }}"
            data-product-price="{{ number_format($currentPrice, 2) }}"
            data-product-image="{{ $product->thumbnail ? asset('storage/' . ltrim($product->thumbnail, '/')) : '' }}"
            data-product-url="{{ route('products.show', $product->slug) }}">
            <i class="fa-regular fa-eye"></i>
            Quick View
        </button>

        <div class="product-info">
            <div>
                <a href="{{ route('products.show', $product->slug) }}"
                    class="product-name d-block text-decoration-none">
                    {{ $product->name }}
                </a>

                <div class="product-price-container">
                    <span class="product-price">
                        <span class="currency">{{ $settings->price_symbol }}</span>
                        {{ number_format($currentPrice, 2) }}
                    </span>
                    <span class="product-vat">+ VAT</span>
                </div>
            </div>
        </div>
    </div>
</div>