<?php

namespace App\Services\Frontend\Global;

class FrontendService
{
    public function __construct(
        protected PromoService $promoService,
        protected CategoryService $categoryService
    ) {}

    public function getHeaderData(): array
    {
        return [
            'promo' => $this->promoService->getActivePromo(),
            'categories' => $this->categoryService->getHeaderCategories(),
        ];
    }

    public function getFooterData(): array
    {
        return [];
    }

    public function getHomeData(): array
    {
        return [
            'promo' => $this->promoService->getActivePromo(),
        ];
    }
}