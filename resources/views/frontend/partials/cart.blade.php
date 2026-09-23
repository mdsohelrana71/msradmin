<div class="offcanvas offcanvas-end cart-offcanvas" tabindex="-1" id="cartModal">
    <div class="offcanvas-header border-bottom">
        <h4 class="offcanvas-title fw-bold">Your Shopping Cart</h4>
        <button type="button" class="btn-close btn-close-white fw-bold"
            data-bs-dismiss="offcanvas"></button>
    </div>

    <div class="offcanvas-body p-0">
        <div class="cart-items">
            @forelse ($cartItems as $item)
                @php
                    $product = $item->product;
                    $price = $item->variant?->price ?? $product->discount_price ?? $product->selling_price;
                @endphp

                <div class="cart-item" data-cart-item="{{ $item->id }}">
                    <button
                        type="button"
                        class="delete-btn cart-remove-btn"
                        data-url="{{ route('cart.remove', $item->id) }}"
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
                            >
                                <i class="fas fa-minus"></i>
                            </button>

                            <input
                                type="text"
                                value="{{ $item->quantity }}"
                                readonly
                            >

                            <button
                                type="button"
                                class="cart-quantity-btn"
                                data-url="{{ route('cart.update', $item->id) }}"
                                data-action="increase"
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
        </div>
    </div>

    <div class="cart-footer p-3 border-top">
        <div class="cart-total">
            <div class="total-row">
                <span class="total-label">Total:</span>
                <strong class="total-price">
                    {{ $settings->price_symbol }}{{ number_format($cartTotal, 2) }}
                </strong>
            </div>

            <div class="total-row">
                <span class="total-label">Discount:</span>
                <strong class="total-price">
                    {{ $settings->price_symbol }}{{ number_format($cartDiscount, 2) }}
                </strong>
            </div>

            <div class="total-row">
                <span class="total-label">Subtotal:</span>
                <strong class="total-price">
                    {{ $settings->price_symbol }}{{ number_format($cartSubtotal, 2) }}
                </strong>
            </div>
        </div>

        <div class="cart-buttons pt-2">
            <a href="" class="btn btn-checkout">
                Order
            </a>
        </div>
    </div>
</div>