@forelse ($cartItems as $item)
    @php
        $product = $item->product;

        $price = $product->discount_price !== null
            && $product->discount_price < $product->selling_price
                ? $product->discount_price
                : $product->selling_price;

        $availableStock = app(\App\Services\Frontend\Global\CartService::class)
            ->availableStock($item);
    @endphp

    <div
        class="cart-item"
        data-cart-item="{{ $item->id }}"
        data-max-stock="{{ $availableStock }}"
    >
        <button
            type="button"
            class="delete-btn remove-cart-item"
            data-url="{{ route('cart.remove', $item->id) }}"
            title="Remove"
        >
            <i class="fas fa-trash"></i>
        </button>

        @if ($product->thumbnail)
            <img
                src="{{ asset('storage/' . ltrim($product->thumbnail, '/')) }}"
                alt="{{ $product->name }}"
            >
        @else
            <div class="cart-item-image-placeholder">
                <i class="fas fa-image"></i>
            </div>
        @endif

        <div class="cart-content">
            <p class="cart-item-name">{{ $product->name }}</p>

            @if ($item->variant)
                <div class="cart-meta">
                    @if ($item->variant->color)
                        <span class="cart-size">
                            Color: {{ $item->variant->color }}
                        </span>
                    @endif

                    @if ($item->variant->size)
                        <span class="cart-size">
                            Size: {{ $item->variant->size }}
                        </span>
                    @endif
                </div>
            @endif

            <div class="price">
                {{ $settings->price_symbol }}{{ number_format($price, 2) }}
            </div>

            <div class="cart-actions">
                <button
                    type="button"
                    class="cart-quantity-btn"
                    data-url="{{ route('cart.update', $item->id) }}"
                    data-action="decrease"
                    @disabled($item->quantity <= 1)
                >
                    <i class="fas fa-minus"></i>
                </button>

                <input
                    type="number"
                    class="cart-quantity-input"
                    value="{{ $item->quantity }}"
                    min="1"
                    max="{{ $availableStock }}"
                    data-url="{{ route('cart.update', $item->id) }}"
                >

                <button
                    type="button"
                    class="cart-quantity-btn"
                    data-url="{{ route('cart.update', $item->id) }}"
                    data-action="increase"
                    @disabled($item->quantity >= $availableStock)
                >
                    <i class="fas fa-plus"></i>
                </button>
            </div>
        </div>
    </div>
@empty
    <div class="text-center py-5 cart-empty">
        <i class="fas fa-shopping-cart fs-1 text-muted mb-3"></i>
        <p class="mb-0">Your cart is empty</p>
    </div>
@endforelse