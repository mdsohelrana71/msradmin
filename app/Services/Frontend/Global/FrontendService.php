<?php

namespace App\Services\Frontend\Global;

class FrontendService
{
    public function __construct(
        protected PromoService $promoService
    ) {}

    public function getHeaderData(): array
    {
        return [
            'promo' => $this->promoService->getActivePromo(),
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