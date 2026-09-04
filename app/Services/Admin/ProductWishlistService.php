<?php

namespace App\Services\Admin;

use App\Models\ProductWishlist;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ProductWishlistService
{
    public function getWishlists(
        ?string $search = null,
        ?string $sort = null,
        int $perPage = 20
    ): LengthAwarePaginator {
        return ProductWishlist::query()
            ->with([
                'product:id,name,sku,thumbnail',
                'user:id,name,email',
            ])
            ->when($search, function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query
                        ->whereHas('product', function ($query) use ($search) {
                            $query
                                ->where('name', 'like', "%{$search}%")
                                ->orWhere('sku', 'like', "%{$search}%");
                        })
                        ->orWhereHas('user', function ($query) use ($search) {
                            $query
                                ->where('name', 'like', "%{$search}%")
                                ->orWhere('email', 'like', "%{$search}%");
                        });
                });
            })
            ->when($sort, function ($query) use ($sort) {
                match ($sort) {
                    'latest' => $query->latest('created_at'),
                    'oldest' => $query->oldest('created_at'),
                    default => $query->latest('created_at'),
                };
            }, function ($query) {
                $query->latest('created_at');
            })
            ->paginate($perPage)
            ->withQueryString();
    }

    public function getWishlist(ProductWishlist $wishlist): ProductWishlist
    {
        return $wishlist->load([
            'product',
            'user',
        ]);
    }

    public function delete(ProductWishlist $wishlist): bool
    {
        return $wishlist->delete();
    }
}