<?php

namespace App\Services\Frontend\Home;

use App\Models\Slider;
use App\Services\Frontend\Blog\BlogService;
use App\Services\Frontend\DesignManager;
use App\Services\Frontend\Global\CategoryService;
use App\Services\Frontend\Global\ProductQuery;

class DesignTwoHomeService
{
    protected DesignManager $designManager;
    protected CategoryService $categoryService;
    protected ProductQuery $productQuery;
    protected BlogService $blogService;

    public function __construct(
        DesignManager $designManager,
        CategoryService $categoryService,
        ProductQuery $productQuery,
        BlogService $blogService
    ) {
        $this->designManager = $designManager;
        $this->categoryService = $categoryService;
        $this->productQuery = $productQuery;
        $this->blogService = $blogService;
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
            ->with(['images', 'category'])
            ->latest('created_at')
            ->take(10)
            ->get();

        $saleProducts = (clone $baseQuery)
            ->whereNotNull('discount_price')
            ->whereColumn('discount_price', '<', 'selling_price')
            ->with(['images', 'category'])
            ->latest('created_at')
            ->take(3)
            ->get();
        

        $newArrivalsProducts = (clone $baseQuery)
            ->with(['images', 'category'])
            ->latest('created_at')
            ->take(3)
            ->get();

        $blogs = $this->blogService->getLatestBlogs(3);

        return [
            'sliders' => $sliders,
            'categories' => $categories,
            'topTenProducts' => $topTenProducts,
            'saleProducts' => $saleProducts,
            'newArrivalsProducts' => $newArrivalsProducts,
            'productCardView' => $this->designManager->getSectionView('product_card'),
            'blogCardView' => $this->designManager->getSectionView('blog_card'),
            'blogs' => $blogs,
        ];
    }
}