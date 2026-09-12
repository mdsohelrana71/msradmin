
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

            <!-- Quick View Button -->
            <button class="quick-view-btn">
                <i class="fa-regular fa-eye"></i>Quick View
            </button>
        </a>

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