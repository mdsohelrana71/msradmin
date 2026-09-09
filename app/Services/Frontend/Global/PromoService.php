<?php

namespace App\Services\Frontend\Global;

use App\Models\Promo;
use Illuminate\Support\Facades\Cache;

class PromoService
{
    public function getActivePromo(): ?Promo
    {
        $promoId = Cache::remember('frontend.active_promo_id', 300, function () {
            return Promo::query()
                ->where('status', true)
                ->where(function ($query) {
                    $query->whereNull('start_date')
                        ->orWhere('start_date', '<=', now());
                })
                ->where(function ($query) {
                    $query->whereNull('end_date')
                        ->orWhere('end_date', '>=', now());
                })
                ->orderBy('sort_order')
                ->value('id');
        });

        if (!$promoId) {
            return null;
        }

        return Promo::with(['buttons' => function ($query) {
            $query->where('status', true)->orderBy('sort_order');
        }])->find($promoId);
    }
}