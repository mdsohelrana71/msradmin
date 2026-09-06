<?php

namespace App\Services\Admin;

use App\Models\Option;
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
    }
}