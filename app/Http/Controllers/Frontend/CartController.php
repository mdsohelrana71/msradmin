<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\CartItem;
use App\Models\Product;
use App\Services\Frontend\Global\CartService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function __construct(
        private CartService $cartService
    ) {}

    public function add(Request $request, Product $product): JsonResponse
    {
        $quantity = max((int) $request->input('quantity', 1), 1);

        $this->cartService->add($product, $quantity);

        return $this->cartResponse('Product added to cart.');
    }

    public function update(Request $request, CartItem $cartItem): JsonResponse
    {
        if ($request->filled('quantity')) {
            $this->cartService->updateQuantityDirectly(
                $cartItem,
                (int) $request->input('quantity')
            );
        } else {
            $this->cartService->updateQuantity(
                $cartItem,
                $request->input('action')
            );
        }

        return $this->cartResponse();
    }

    public function remove(CartItem $cartItem): JsonResponse
    {
        $this->cartService->remove($cartItem);

        return $this->cartResponse('Product removed from cart.');
    }

    private function cartResponse(?string $message = null): JsonResponse
    {
        $cart = $this->cartService->getCart();
        $totals = $this->cartService->totals();

        $cartItems = $cart?->items ?? collect();

        $cartHtml = view('frontend.partials.cart-items', [
            'cartItems' => $cartItems,
        ])->render();

        return response()->json([
            'success' => true,
            'message' => $message,
            'cart_count' => $this->cartService->count(),
            'cart_html' => $cartHtml,
            'totals' => $totals,
        ]);
    }
}