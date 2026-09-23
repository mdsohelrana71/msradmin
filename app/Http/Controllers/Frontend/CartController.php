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

        return response()->json([
            'success' => true,
            'message' => 'Product added to cart.',
            'cart_count' => $this->cartService->count(),
        ]);
    }

    public function update(Request $request, CartItem $cartItem): JsonResponse
    {
        $this->cartService->updateQuantity(
            $cartItem,
            $request->input('action')
        );

        return $this->cartResponse();
    }

    public function remove(CartItem $cartItem): JsonResponse
    {
        $this->cartService->remove($cartItem);

        return $this->cartResponse();
    }

    private function cartResponse(): JsonResponse
    {
        $totals = $this->cartService->totals();

        return response()->json([
            'success' => true,
            'cart_count' => $this->cartService->count(),
            'totals' => $totals,
        ]);
    }
}