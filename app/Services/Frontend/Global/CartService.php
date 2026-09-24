<?php

namespace App\Services\Frontend\Global;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartService
{
    public function getCart(): ?Cart
    {
        return Auth::check()
            ? Cart::with('items.product', 'items.variant')
                ->where('user_id', Auth::id())
                ->first()
            : Cart::with('items.product', 'items.variant')
                ->where('session_id', session()->getId())
                ->first();
    }

    public function add(Product $product, int $quantity = 1): CartItem
    {
        return DB::transaction(function () use ($product, $quantity) {
            $cart = $this->getOrCreateCart();

            $cartItem = $cart->items()
                ->where('product_id', $product->id)
                ->whereNull('product_variant_id')
                ->first();

            if ($cartItem) {
                $cartItem->increment('quantity', $quantity);
            } else {
                $cartItem = $cart->items()->create([
                    'product_id' => $product->id,
                    'product_variant_id' => null,
                    'quantity' => $quantity,
                ]);
            }

            return $cartItem->fresh(['product', 'variant']);
        });
    }

    public function updateQuantity(CartItem $cartItem, string $action): void
    {
        $this->validateOwnership($cartItem);

        if ($action === 'increase') {
            $cartItem->increment('quantity');

            return;
        }

        if ($action === 'decrease') {
            if ($cartItem->quantity <= 1) {
                $cartItem->delete();

                return;
            }

            $cartItem->decrement('quantity');
        }
    }

    public function remove(CartItem $cartItem): void
    {
        $this->validateOwnership($cartItem);

        $cartItem->delete();
    }

    public function count(): int
    {
        $cart = $this->getCart();

        return $cart?->items->sum('quantity') ?? 0;
    }

    public function totals(): array
    {
        $cart = $this->getCart();

        if (!$cart) {
            return [
                'total' => 0,
                'discount' => 0,
                'subtotal' => 0,
            ];
        }

        $total = 0;
        $discount = 0;

        foreach ($cart->items as $item) {
            $product = $item->product;

            $sellingPrice = $product->selling_price;

            $currentPrice = $product->discount_price !== null
                && $product->discount_price < $product->selling_price
                    ? $product->discount_price
                    : $product->selling_price;

            $total += $sellingPrice * $item->quantity;
            $discount += ($sellingPrice - $currentPrice) * $item->quantity;
        }

        return [
            'total' => $total,
            'discount' => $discount,
            'subtotal' => $total - $discount,
        ];
    }

    private function getOrCreateCart(): Cart
    {
        return Auth::check()
            ? Cart::firstOrCreate([
                'user_id' => Auth::id(),
            ])
            : Cart::firstOrCreate([
                'session_id' => session()->getId(),
            ]);
    }

    private function validateOwnership(CartItem $cartItem): void
    {
        $cart = $this->getCart();

        abort_unless(
            $cart && $cart->id === $cartItem->cart_id,
            403
        );
    }
}