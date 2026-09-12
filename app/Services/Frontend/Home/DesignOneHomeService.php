<?php
namespace App\Services\Frontend\Home;

use App\Models\Slider;
use App\Services\Frontend\DesignManager;
use App\Services\Frontend\Global\CategoryService;
use App\Services\Frontend\Global\ProductQuery;

class DesignOneHomeService
{
    protected DesignManager $designManager;
    protected CategoryService $categoryService;
    protected ProductQuery $productQuery;

    public function __construct(
        DesignManager $designManager,
        CategoryService $categoryService,
        ProductQuery $productQuery
    ) {
        $this->designManager = $designManager;
        $this->categoryService = $categoryService;
        $this->productQuery = $productQuery;
    }

    public function getData(): array
    {
        $sliders = Slider::query()
            ->where('status', true)
            ->where(function ($query) {
                $query->whereNull('start_at')
                    ->orWhere('start_at', '<=', now());
            })
            ->where(function ($query) {
                $query->whereNull('end_at')
                    ->orWhere('end_at', '>=', now());
            })
            ->orderBy('sort_order')
            ->latest('id')
            ->get();

        $categories = $this->categoryService->getHomeCategories();

        $baseQuery = $this->productQuery->frontend();

        $topTenProducts = (clone $baseQuery)
            ->where('is_featured', true)
            ->latest('created_at')
            ->take(10)
            ->get();

        $trendingProducts = (clone $baseQuery)
            ->latest('created_at')
            ->take(6)
            ->get();

        $saleProducts = (clone $baseQuery)
            ->whereNotNull('discount_price')
            ->whereColumn('discount_price', '<', 'selling_price')
            ->latest('created_at')
            ->take(5)
            ->get();

        $newArrivalsProducts = (clone $baseQuery)
            ->latest('created_at')
            ->take(5)
            ->get();

        return [
            'sliders' => $sliders,
            'categories' => $categories,
            'topTenProducts' => $topTenProducts,
            'trendingProducts' => $trendingProducts,
            'saleProducts' => $saleProducts,
            'newArrivalsProducts' => $newArrivalsProducts,
            'productCardView' => $this->designManager->getSectionView('product_card'),
        ];
    }
}