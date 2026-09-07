<?php

namespace App\Services\Frontend\Product;

use App\Models\Product;

class DesignOneProductService
{
    public function getProducts()
    {
        $query = Product::query()
            ->where('status', true)
            ->with(['images']);

        $sort = request('sort', 'newest');

        match ($sort) {
            'priceLowHigh' => $query->orderBy('selling_price'),
            'priceHighLow' => $query->orderByDesc('selling_price'),
            default => $query->latest('created_at'),
        };

        return $query->paginate(12)->withQueryString();
    }

    public function getProduct(Product $product): Product
    {
        abort_unless($product->status, 404);

        return $product;
    }
}