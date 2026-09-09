<?php
namespace App\Services\Frontend\Global;
use App\Models\Product;
class ProductSearchService
{
    public function search(string $search)
    {
        return Product::query()
            ->where('status', true)
            ->where(function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('sku', 'like', "%{$search}%")
                    ->orWhere('barcode', 'like', "%{$search}%");
            })
            ->latest('created_at')
            ->take(8)
            ->get(['id', 'name', 'sku', 'thumbnail']);
    }
}