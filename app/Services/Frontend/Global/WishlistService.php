<?php

namespace App\Services\Frontend\Global;

use App\Models\ProductWishlist;
use Illuminate\Support\Facades\Auth;

class WishlistService
{
    public function toggle(int $productId): bool
    {
        $wishlist = ProductWishlist::where('user_id', Auth::id())
            ->where('product_id', $productId)
            ->first();

        if ($wishlist) {
            $wishlist->delete();

            return false;
        }

        ProductWishlist::create([
            'user_id' => Auth::id(),
            'product_id' => $productId,
        ]);

        return true;
    }

    public function exists(int $productId): bool
    {
        return ProductWishlist::where('user_id', Auth::id())
            ->where('product_id', $productId)
            ->exists();
    }

    public function count(): int
    {
        if (!Auth::check()) {
            return 0;
        }

        return ProductWishlist::where('user_id', Auth::id())->count();
    }
}