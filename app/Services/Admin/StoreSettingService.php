<?php

namespace App\Services\Admin;

use App\Models\Option;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class StoreSettingService
{
    public function getSettings(): array
    {
        return [
            'storeSettings' => [
                'delivery_charge' => Option::getOption('delivery_charge', 0),
                'free_delivery_amount' => Option::getOption('free_delivery_amount', null),
                'product_review_enabled' => Option::getOption('product_review_enabled', true),
                'review_requires_approval' => Option::getOption('review_requires_approval', true),
                'tax_enabled' => Option::getOption('tax_enabled', false),
                'tax_type' => Option::getOption('tax_type', 'percentage'),
                'tax_value' => Option::getOption('tax_value', 0),
                'show_out_of_stock_products' => Option::getOption('show_out_of_stock_products', true),
                'price_symbol' => Option::getOption('price_symbol', '৳'),
                'back_to_top_enabled' => Option::getOption('back_to_top_enabled', true),
                'floating_cart_enabled' => Option::getOption('floating_cart_enabled', true),
            ],
        ];
    }

    public function update(array $data): void
    {
        DB::transaction(function () use ($data) {
            foreach ($data as $key => $value) {
                Option::setOption($key, $value);
            }
        });

        Cache::forget('global_settings');
    }
}