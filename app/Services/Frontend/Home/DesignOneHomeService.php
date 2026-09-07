<?php

namespace App\Services\Frontend\Home;

use App\Models\Product;

class DesignOneHomeService
{
    public function getData(): array
    {
        $baseQuery = Product::query()
            ->where('status', true)
            ->with('category:id,name');

        $topTenProducts = (clone $baseQuery)
            ->where('is_featured', true)
            ->latest('created_at')
            ->take(10)
            ->get();

        $trendingProducts = (clone $baseQuery)
            ->latest('created_at')
            ->take(5)
            ->get();

        $saleProducts = (clone $baseQuery)
            ->whereNotNull('discount_price')
            ->whereColumn('discount_price', '<', 'selling_price')
            ->latest('created_at')
            ->take(5)
            ->get();

        $newArrivalsProducts = (clone $baseQuery)
            ->latest('created_at')
            ->take(6)
            ->get();

        return [
            'topTenProducts' => $topTenProducts,
            'trendingProducts' => $trendingProducts,
            'saleProducts' => $saleProducts,
            'newArrivalsProducts' => $newArrivalsProducts,
        ];
    }
}