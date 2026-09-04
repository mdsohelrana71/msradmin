<?php

namespace App\Services\Admin;

use App\Models\ProductCompare;
use Illuminate\Pagination\LengthAwarePaginator;

class ProductCompareService
{
    public function getCompares(
        ?string $search = null,
        ?string $sort = null,
        int $perPage = 20
    ): LengthAwarePaginator {
        $query = ProductCompare::query()
            ->with([
                'product:id,name,sku,thumbnail',
                'user:id,name,email',
            ])
            ->when($search, function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query
                        ->whereHas('product', function ($query) use ($search) {
                            $query
                                ->where('name', 'like', "%{$search}%")
                                ->orWhere('sku', 'like', "%{$search}%");
                        })
                        ->orWhereHas('user', function ($query) use ($search) {
                            $query
                                ->where('name', 'like', "%{$search}%")
                                ->orWhere('email', 'like', "%{$search}%");
                        });
                });
            });

        $compareRecords = $query
            ->get()
            ->groupBy('user_id')
            ->map(function ($compares) {
                return [
                    'user' => $compares->first()->user,
                    'products' => $compares->pluck('product')->filter()->values(),
                    'compare_ids' => $compares->pluck('id')->values(),
                    'created_at' => $compares->min('created_at'),
                ];
            })
            ->values();

        if ($sort === 'oldest') {
            $compareRecords = $compareRecords
                ->sortBy('created_at')
                ->values();
        } else {
            $compareRecords = $compareRecords
                ->sortByDesc('created_at')
                ->values();
        }

        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $total = $compareRecords->count();

        $items = $compareRecords
            ->slice(($currentPage - 1) * $perPage, $perPage)
            ->values();

        return new LengthAwarePaginator(
            $items,
            $total,
            $perPage,
            $currentPage,
            [
                'path' => LengthAwarePaginator::resolveCurrentPath(),
                'query' => request()->query(),
            ]
        );
    }

    public function getCompare(ProductCompare $compare): array
    {
        $compares = ProductCompare::query()
            ->with([
                'product',
                'user',
            ])
            ->where('user_id', $compare->user_id)
            ->latest('created_at')
            ->get();

        return [
            'user' => $compares->first()?->user,
            'products' => $compares->pluck('product')->filter()->values(),
            'compares' => $compares,
        ];
    }

    public function delete(ProductCompare $compare): bool
    {
        return ProductCompare::query()
            ->where('user_id', $compare->user_id)
            ->delete() > 0;
    }
}