@php
    $productImage = $product->thumbnail
        ? asset('storage/' . ltrim($product->thumbnail, '/'))
        : ($product->images->first()?->image
            ? asset('storage/' . ltrim($product->images->first()->image, '/'))
            : asset('frontend/images/product-placeholder.jpg'));

    $hasDiscount = $product->discount_price !== null
        && $product->discount_price < $product->selling_price;

    $currentPrice = $hasDiscount
        ? $product->discount_price
        : $product->selling_price;
@endphp

<a href="{{ route('products.show', ['product' => $product->slug]) }}" class="latest-product__item">
    <div class="latest-product__item__pic">
        <img src="{{ $productImage }}" alt="{{ $product->name }}">
    </div>

    <div class="latest-product__item__text">
        <h6>{{ $product->name }}</h6>

        @if ($hasDiscount)
            <span class="product-price-old">
                {{ $settings->price_symbol }}{{ number_format($product->selling_price, 0) }}
            </span>
        @endif

        <span class="product-price">
            {{ $settings->price_symbol }}{{ number_format($currentPrice, 0) }}
        </span>
        <span class="product-vat">+ VAT</span>
    </div>
</a>