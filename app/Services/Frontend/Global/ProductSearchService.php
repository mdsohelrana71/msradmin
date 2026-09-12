<?php

namespace App\Services\Frontend\Global;

use App\Models\Option;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class ProductSearchService
{
    public function search(string $search)
    {
        $query = Product::query()
            ->where('status', true)
            ->where(function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('sku', 'like', "%{$search}%")
                    ->orWhere('barcode', 'like', "%{$search}%");
            });

        $showOutOfStock = Option::getOption('show_out_of_stock_products', true);

        if (! (bool) $showOutOfStock) {
            $query->where(function ($query) {
                $query->where(function ($query) {
                    $query->whereNotExists(function ($query) {
                        $query->select(DB::raw(1))
                            ->from('product_variants')
                            ->whereColumn('product_variants.product_id', 'products.id')
                            ->where('product_variants.status', true);
                    })->whereExists(function ($query) {
                        $query->select(DB::raw(1))
                            ->from('product_inventory')
                            ->whereColumn('product_inventory.product_id', 'products.id')
                            ->whereNull('product_inventory.product_variant_id')
                            ->whereRaw('product_inventory.stock > product_inventory.reserved_stock');
                    });
                })->orWhere(function ($query) {
                    $query->whereExists(function ($query) {
                        $query->select(DB::raw(1))
                            ->from('product_variants')
                            ->whereColumn('product_variants.product_id', 'products.id')
                            ->where('product_variants.status', true);
                    })->whereExists(function ($query) {
                        $query->select(DB::raw(1))
                            ->from('product_inventory')
                            ->whereColumn('product_inventory.product_id', 'products.id')
                            ->whereNotNull('product_inventory.product_variant_id')
                            ->whereRaw('product_inventory.stock > product_inventory.reserved_stock');
                    });
                });
            });
        }

        return $query
            ->latest('created_at')
            ->take(8)
            ->get(['id', 'name', 'sku', 'thumbnail', 'slug']);
    }
}