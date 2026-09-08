<div class="product-card">
    @php
        $hasDiscount = $product->discount_price !== null && $product->discount_price < $product->selling_price;
        $currentPrice = $hasDiscount ? $product->discount_price : $product->selling_price;
        $discountPercentage = $hasDiscount && $product->selling_price > 0
            ? round((($product->selling_price - $product->discount_price) / $product->selling_price) * 100)
            : 0;
    @endphp

    @if ($hasDiscount)
        <div class="product-badge product-badge-sale">
            -{{ $discountPercentage }}%
        </div>
    @endif

    <a href="{{ route('products.show', $product->slug) }}" class="product-image-link">
        <div class="product-image">
            @if ($product->thumbnail)
                <img src="{{ asset('storage/' . ltrim($product->thumbnail, '/')) }}"
                    alt="{{ $product->name }}">
            @else
                <span>
                    <i class="fas fa-image"></i>
                </span>
            @endif
        </div>
    </a>

    <div class="product-info pt-2">
        <a href="{{ route('products.show', $product->slug) }}" class="product-name-link">
            <h3 class="product-name">{{ $product->name }}</h3>
        </a>

        <div class="product-price">
            @if ($hasDiscount)
                <span class="product-price-old">
                    ${{ number_format($product->selling_price, 2) }}
                </span>
            @endif

            <span class="product-price-current">
                ${{ number_format($currentPrice, 2) }}
            </span>
        </div>

        <div class="product-actions">
            <a href="#" class="product-action-btn">
                <i class="fas fa-heart"></i>
            </a>

            <a href="#" class="product-action-btn">
                <i class="fas fa-shopping-cart"></i>
            </a>

            <a href="{{ route('products.show', $product->slug) }}" class="product-action-btn">
                <i class="fas fa-eye"></i>
            </a>
        </div>
    </div>
</div>