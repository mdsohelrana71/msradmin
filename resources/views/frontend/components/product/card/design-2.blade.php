@php
    $hasDiscount = $product->discount_price !== null && $product->discount_price < $product->selling_price;
    $currentPrice = $hasDiscount ? $product->discount_price : $product->selling_price;
    $discountPercentage = $hasDiscount && $product->selling_price > 0
        ? round((($product->selling_price - $product->discount_price) / $product->selling_price) * 100)
        : 0;

     $isWishlisted = auth()->check()
        ? \App\Models\ProductWishlist::where('user_id', \Illuminate\Support\Facades\Auth::id())
            ->where('product_id', $product->id)
            ->exists()
        : false;
@endphp

<div class="col-5-cards">
    <div class="product-card position-relative">

        <button
            type="button"
            class="wishlist-btn position-absolute top-0 end-0 m-2 {{ $isWishlisted ? 'active' : '' }}"
            data-product-id="{{ $product->id }}"
            aria-label="{{ $isWishlisted ? 'Remove from wishlist' : 'Add to wishlist' }}"
        >
            <i class="{{ $isWishlisted ? 'fa-solid' : 'fa-regular' }} fa-heart"></i>
        </button>

        <a href="{{ route('products.show', $product->slug) }}" class="product-image-container">
            @if ($product->thumbnail)
                <img src="{{ asset('storage/' . ltrim($product->thumbnail, '/')) }}" alt="{{ $product->name }}">
            @else
                <span>
                    <i class="fas fa-image"></i>
                </span>
            @endif
        </a>

        @include('frontend.partials.quick-view-button')

        <div class="product-info">
            <div>
                <a href="{{ route('products.show', $product->slug) }}"
                    class="product-name d-block text-decoration-none">
                    {{ $product->name }}
                </a>

                <div class="product-price-container">
                    @if ($hasDiscount)
                        <span class="product-price-old">
                            {{ $settings->price_symbol }}{{ number_format($product->selling_price, 0) }}
                        </span>
                    @endif

                    <span class="product-price">
                        <span class="currency">{{ $settings->price_symbol }}{{ number_format($currentPrice, 0) }}</span>
                    </span>
                    <span class="product-vat">+ VAT</span>
                </div>
            </div>
        </div>
    </div>
</div>