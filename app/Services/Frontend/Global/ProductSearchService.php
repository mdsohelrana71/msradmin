<?php
namespace App\Services\Frontend\Global;

class ProductSearchService
{
    protected ProductQuery $productQuery;

    public function __construct(ProductQuery $productQuery)
    {
        $this->productQuery = $productQuery;
    }

    public function search(string $search)
    {
        return $this->productQuery->frontend()
            ->where(function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('sku', 'like', "%{$search}%")
                    ->orWhere('barcode', 'like', "%{$search}%");
            })
            ->latest('created_at')
            ->take(8)
            ->get(['id', 'name', 'sku', 'thumbnail', 'slug']);
    }
}