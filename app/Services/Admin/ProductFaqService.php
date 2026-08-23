<?php

namespace App\Services\Admin;

use App\Models\Product;
use App\Models\ProductFaq;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class ProductFaqService
{
    public function getFaqs(
        ?string $search = null,
        ?string $sort = null,
        int $perPage = 20
    ): LengthAwarePaginator {
        return ProductFaq::query()
            ->with('products:id,name,sku')

            ->when($search, function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query
                        ->where(
                            'question',
                            'like',
                            "%{$search}%"
                        )
                        ->orWhere(
                            'answer',
                            'like',
                            "%{$search}%"
                        )
                        ->orWhereHas(
                            'products',
                            function ($query) use ($search) {
                                $query
                                    ->where(
                                        'name',
                                        'like',
                                        "%{$search}%"
                                    )
                                    ->orWhere(
                                        'sku',
                                        'like',
                                        "%{$search}%"
                                    );
                            }
                        );
                });
            })

            ->when($sort, function ($query) use ($sort) {
                match ($sort) {
                    'a_z' => $query->orderBy('question'),

                    'z_a' => $query->orderByDesc('question'),

                    'latest' => $query->latest('created_at'),

                    'oldest' => $query->oldest('created_at'),

                    'active' => $query
                        ->where('status', true)
                        ->orderBy('question'),

                    'inactive' => $query
                        ->where('status', false)
                        ->orderBy('question'),

                    default => $query
                        ->orderBy('sort_order')
                        ->orderBy('question'),
                };
            }, function ($query) {
                $query
                    ->orderBy('sort_order')
                    ->orderBy('question');
            })

            ->paginate($perPage)
            ->withQueryString();
    }

    public function find(int $id): ProductFaq
    {
        return ProductFaq::query()
            ->with('products:id,name,sku')
            ->findOrFail($id);
    }

    public function create(array $data): ProductFaq
    {
        $productIds = $data['product_ids'] ?? [];

        unset($data['product_ids']);

        $data['sort_order'] ??= 0;

        $faq = ProductFaq::create($data);

        $faq->products()->sync($productIds);

        return $faq->load('products');
    }

    public function update(
        ProductFaq $faq,
        array $data
    ): ProductFaq {
        $productIds = $data['product_ids'] ?? [];

        unset($data['product_ids']);

        $data['sort_order'] ??= 0;

        $faq->update($data);

        $faq->products()->sync($productIds);

        return $faq->refresh()->load('products');
    }

    public function delete(ProductFaq $faq): void
    {
        $faq->products()->detach();

        $faq->delete();
    }

    /**
     * Search products for Select2.
     */
    public function searchProducts(
        ?string $search = null,
        int $limit = 20
    ): Collection {
        return Product::query()
            ->select([
                'id',
                'name',
                'sku',
            ])
            ->when($search, function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query
                        ->where(
                            'name',
                            'like',
                            "%{$search}%"
                        )
                        ->orWhere(
                            'sku',
                            'like',
                            "%{$search}%"
                        );
                });
            })
            ->where('status', true)
            ->orderBy('name')
            ->limit($limit)
            ->get();
    }
}