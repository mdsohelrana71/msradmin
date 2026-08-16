<?php

namespace App\Services\Admin;

use App\Models\ProductAttribute;
use App\Models\ProductAttributeValue;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Str;

class ProductAttributeValueService
{
    public function getValues(
        ProductAttribute $attribute,
        ?string $search = null,
        ?string $sort = null,
        int $perPage = 20
    ): LengthAwarePaginator {
        return $attribute->values()
            ->when($search, function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->where(
                        'value',
                        'like',
                        "%{$search}%"
                    );
                });
            })
            ->when($sort, function ($query) use ($sort) {
                match ($sort) {
                    'a_z' => $query->orderBy('value'),

                    'z_a' => $query->orderByDesc('value'),

                    'latest' => $query->latest('created_at'),

                    'oldest' => $query->oldest('created_at'),

                    'active' => $query
                        ->where('status', true)
                        ->orderBy('value'),

                    'inactive' => $query
                        ->where('status', false)
                        ->orderBy('value'),

                    default => $query
                        ->orderBy('sort_order')
                        ->orderBy('value'),
                };
            }, function ($query) {
                $query
                    ->orderBy('sort_order')
                    ->orderBy('value');
            })
            ->paginate($perPage)
            ->withQueryString();
    }

    public function create(
        ProductAttribute $attribute,
        array $data
    ): ProductAttributeValue {
        $data['attribute_id'] = $attribute->id;
        $data['slug'] = Str::slug($data['value']);
        $data['sort_order'] ??= 0;

        return ProductAttributeValue::create($data);
    }

    public function update(
        ProductAttributeValue $value,
        array $data
    ): ProductAttributeValue {
        $data['slug'] = Str::slug($data['value']);
        $data['sort_order'] ??= 0;

        $value->update($data);

        return $value->refresh();
    }

    public function delete(
        ProductAttributeValue $value
    ): bool {
        return $value->delete();
    }
}