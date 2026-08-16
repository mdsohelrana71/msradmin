<?php

namespace App\Services\Admin;

use App\Models\ProductAttribute;
use App\Models\ProductAttributeValue;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Str;

class ProductAttributeService
{
    public function getAttributes(
        ?string $search = null,
        ?string $sort = null,
        int $perPage = 20
    ): LengthAwarePaginator {
        return ProductAttribute::query()
            ->with('values')
            ->when($search, function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->where('name', 'like', "%{$search}%")
                        ->orWhere('slug', 'like', "%{$search}%");
                });
            })
            ->when($sort, function ($query) use ($sort) {
                match ($sort) {
                    'a_z' => $query->orderBy('name'),
                    'z_a' => $query->orderByDesc('name'),
                    'latest' => $query->latest('created_at'),
                    'oldest' => $query->oldest('created_at'),
                    'active' => $query->where('status', true)
                        ->orderBy('name'),
                    'inactive' => $query->where('status', false)
                        ->orderBy('name'),
                    default => $query->orderBy('sort_order')
                        ->orderBy('name'),
                };
            }, function ($query) {
                $query->orderBy('sort_order')
                    ->orderBy('name');
            })
            ->paginate($perPage)
            ->withQueryString();
    }

    public function create(array $data): ProductAttribute
    {
        $data['slug'] = Str::slug($data['name']);
        $data['sort_order'] ??= 0;

        return ProductAttribute::create($data);
    }

    public function update(
        ProductAttribute $attribute,
        array $data
    ): ProductAttribute {
        $data['slug'] = Str::slug($data['name']);
        $data['sort_order'] ??= 0;

        $attribute->update($data);

        return $attribute->refresh();
    }

    public function delete(ProductAttribute $attribute): void
    {
        $attribute->delete();
    }

    public function getValues(
        ProductAttribute $attribute,
        ?string $search = null,
        int $perPage = 20
    ): LengthAwarePaginator {
        return $attribute->values()
            ->when($search, function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query->where('value', 'like', "%{$search}%")
                        ->orWhere('slug', 'like', "%{$search}%");
                });
            })
            ->orderBy('sort_order')
            ->latest('id')
            ->paginate($perPage)
            ->withQueryString();
    }

    public function createValue(
        ProductAttribute $attribute,
        array $data
    ): ProductAttributeValue {
        $data['attribute_id'] = $attribute->id;
        $data['slug'] = $data['slug'] ?: Str::slug($data['value']);
        $data['sort_order'] ??= 0;

        return $attribute->values()->create($data);
    }

    public function updateValue(
        ProductAttributeValue $value,
        array $data
    ): ProductAttributeValue {
        $data['slug'] = $data['slug'] ?: Str::slug($data['value']);
        $data['sort_order'] ??= 0;

        $value->update($data);

        return $value->refresh();
    }

    public function deleteValue(ProductAttributeValue $value): void
    {
        $value->delete();
    }
}