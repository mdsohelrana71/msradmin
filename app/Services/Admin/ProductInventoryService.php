<?php

namespace App\Services\Admin;

use App\Models\ProductInventory;
use Illuminate\Support\Facades\DB;

class ProductInventoryService
{
    public function getInventories(array $filters = [])
    {
        $search = $filters['search'] ?? null;
        $sort = $filters['sort'] ?? null;

        return [
            'inventories' => ProductInventory::query()
                ->with([
                    'product:id,name,sku,thumbnail',
                    'variant:id,product_id',
                    'variant.values.attribute:id,name',
                    'variant.values.attributeValue:id,value',
                ])
                ->when($search, function ($query) use ($search) {
                    $query->where(function ($query) use ($search) {
                        $query
                            ->whereHas('product', function ($query) use ($search) {
                                $query
                                    ->where('name', 'like', "%{$search}%")
                                    ->orWhere('sku', 'like', "%{$search}%");
                            })
                            ->orWhereHas('variant.values.attributeValue', function ($query) use ($search) {
                                $query->where('value', 'like', "%{$search}%");
                            })
                            ->orWhereHas('variant.values.attribute', function ($query) use ($search) {
                                $query->where('name', 'like', "%{$search}%");
                            });
                    });
                })
                ->when($sort, function ($query) use ($sort) {
                    match ($sort) {
                        'a_z' => $query->orderBy(
                            ProductInventory::query()
                                ->select('name')
                                ->from('products')
                                ->whereColumn(
                                    'products.id',
                                    'product_inventory.product_id'
                                )
                                ->limit(1)
                        ),
                        'z_a' => $query->orderByDesc(
                            ProductInventory::query()
                                ->select('name')
                                ->from('products')
                                ->whereColumn(
                                    'products.id',
                                    'product_inventory.product_id'
                                )
                                ->limit(1)
                        ),
                        'latest' => $query->latest('product_inventory.created_at'),
                        'oldest' => $query->oldest('product_inventory.created_at'),
                        'in_stock' => $query
                            ->whereRaw(
                                '(stock - reserved_stock) > low_stock_alert'
                            )
                            ->orderByDesc('stock'),
                        'low_stock' => $query
                            ->whereRaw(
                                '(stock - reserved_stock) > 0'
                            )
                            ->whereRaw(
                                '(stock - reserved_stock) <= low_stock_alert'
                            )
                            ->orderBy('stock'),
                        'out_of_stock' => $query
                            ->whereRaw(
                                '(stock - reserved_stock) <= 0'
                            )
                            ->orderBy('stock'),
                        default => $query->latest('product_inventory.created_at'),
                    };
                }, function ($query) {
                    $query->latest('product_inventory.created_at');
                })
                ->paginate(20)
                ->withQueryString(),
        ];
    }

    public function getInventory(
        ProductInventory $inventory
    ): array {
        return [
            'inventory' => $inventory->load([
                'product',
                'variant',
                'variant.values.attribute',
                'variant.values.attributeValue',
            ]),
        ];
    }

    public function update(
        ProductInventory $inventory,
        array $data
    ): ProductInventory {
        return DB::transaction(function () use (
            $inventory,
            $data
        ) {
            $inventory = ProductInventory::query()
                ->lockForUpdate()
                ->findOrFail($inventory->id);

            $inventory->update([
                'stock' => $data['stock'],
                'low_stock_alert' => $data['low_stock_alert'],
            ]);

            return $inventory->fresh([
                'product',
                'variant',
                'variant.values.attribute',
                'variant.values.attributeValue',
            ]);
        });
    }

    public function adjustStock(
        ProductInventory $inventory,
        int $quantity
    ): ProductInventory {
        return DB::transaction(function () use (
            $inventory,
            $quantity
        ) {
            $inventory = ProductInventory::query()
                ->lockForUpdate()
                ->findOrFail($inventory->id);

            $newStock = $inventory->stock + $quantity;

            if ($newStock < 0) {
                throw new \RuntimeException(
                    'Stock cannot be negative.'
                );
            }

            $inventory->update([
                'stock' => $newStock,
            ]);

            return $inventory->fresh([
                'product',
                'variant',
                'variant.values.attribute',
                'variant.values.attributeValue',
            ]);
        });
    }
}