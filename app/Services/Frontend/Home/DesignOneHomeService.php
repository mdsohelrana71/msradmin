<?php

namespace App\Services\Frontend\Home;

use App\Models\Category;
use App\Models\Option;
use App\Models\Product;
use App\Models\Slider;
use App\Services\Frontend\DesignManager;
use App\Services\Frontend\Global\CategoryService;
use Illuminate\Support\Facades\DB;

class DesignOneHomeService
{
    protected DesignManager $designManager;
    protected CategoryService $categoryService;

    public function __construct(
        DesignManager $designManager,
        CategoryService $categoryService
    ) {
        $this->designManager = $designManager;
        $this->categoryService = $categoryService;
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

        $baseQuery = Product::query()
            ->where('status', true);

        $this->applyStockFilter($baseQuery);

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

    private function applyStockFilter($query): void
    {
        $showOutOfStock = Option::getOption('show_out_of_stock_products', true);

        if ((bool) $showOutOfStock) {
            return;
        }

        $query->where(function ($query) {
            $query->whereExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('product_inventory')
                    ->whereColumn('product_inventory.product_id', 'products.id')
                    ->whereNull('product_inventory.product_variant_id')
                    ->whereRaw('product_inventory.stock > product_inventory.reserved_stock');
            })->orWhereExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('product_inventory')
                    ->whereColumn('product_inventory.product_id', 'products.id')
                    ->whereNotNull('product_inventory.product_variant_id')
                    ->whereRaw('product_inventory.stock > product_inventory.reserved_stock');
            });
        });
    }
}