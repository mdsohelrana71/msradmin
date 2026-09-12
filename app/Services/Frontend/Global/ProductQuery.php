<?php
namespace App\Services\Frontend\Global;

use App\Models\Option;
use App\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class ProductQuery
{
    public function frontend(): Builder
    {
        $query = Product::query()
            ->where('status', true);

        $this->applyStockVisibility($query);

        return $query;
    }

    private function applyStockVisibility(Builder $query): void
    {
        $showOutOfStock = Option::getOption('show_out_of_stock_products', true);

        if ((bool) $showOutOfStock) {
            return;
        }

        $query->where(function (Builder $query) {
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