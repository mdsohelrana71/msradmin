<?php

namespace App\Services\Frontend\Global;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\ProductInventory;
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

            $currentQuantity = $cartItem?->quantity ?? 0;
            $newQuantity = $currentQuantity + $quantity;

            $this->validateStock($product->id, null, $newQuantity);

            if ($cartItem) {
                $cartItem->update([
                    'quantity' => $newQuantity,
                ]);
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

        $quantity = $cartItem->quantity;

        if ($action === 'decrease') {
            if ($quantity <= 1) {
                $cartItem->delete();

                return;
            }

            $quantity--;
        }

        if ($action === 'increase') {
            $quantity++;
        }

        if (!in_array($action, ['increase', 'decrease'], true)) {
            return;
        }

        $this->validateStock(
            $cartItem->product_id,
            $cartItem->product_variant_id,
            $quantity
        );

        $cartItem->update([
            'quantity' => $quantity,
        ]);
    }

    public function updateQuantityDirectly(CartItem $cartItem, int $quantity): void
    {
        $this->validateOwnership($cartItem);

        $quantity = max(1, $quantity);

        $this->validateStock(
            $cartItem->product_id,
            $cartItem->product_variant_id,
            $quantity
        );

        $cartItem->update([
            'quantity' => $quantity,
        ]);
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

    public function availableStock(CartItem $cartItem): int
    {
        $inventory = ProductInventory::query()
            ->where('product_id', $cartItem->product_id)
            ->when(
                $cartItem->product_variant_id,
                fn ($query) => $query->where(
                    'product_variant_id',
                    $cartItem->product_variant_id
                ),
                fn ($query) => $query->whereNull('product_variant_id')
            )
            ->first();

        return $inventory?->available_stock ?? 0;
    }

    private function validateStock(
        int $productId,
        ?int $variantId,
        int $quantity
    ): void {
        $inventory = ProductInventory::query()
            ->where('product_id', $productId)
            ->when(
                $variantId,
                fn ($query) => $query->where('product_variant_id', $variantId),
                fn ($query) => $query->whereNull('product_variant_id')
            )
            ->first();

        $availableStock = $inventory?->available_stock ?? 0;

        if ($availableStock <= 0) {
            abort(
                422,
                'This product is currently out of stock.'
            );
        }

        if ($quantity > $availableStock) {
            abort(
                422,
                "Only {$availableStock} item(s) available in stock."
            );
        }
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