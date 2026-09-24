<div class="offcanvas offcanvas-end cart-offcanvas" tabindex="-1" id="cartModal">
    <div class="offcanvas-header border-bottom">
        <h4 class="offcanvas-title fw-bold">Your Shopping Cart</h4>

        <button
            type="button"
            class="btn-close btn-close-white fw-bold"
            data-bs-dismiss="offcanvas"
        ></button>
    </div>

    <div class="offcanvas-body p-0">
        <div class="cart-items">
            @include('frontend.partials.cart-items')
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