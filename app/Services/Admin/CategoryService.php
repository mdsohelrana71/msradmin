<?php

namespace App\Services\Admin;

use App\Enums\CategoryType;
use App\Models\Category;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;

class CategoryService
{
    public function getCategories(
        CategoryType $type,
        int $perPage = 20
    ): LengthAwarePaginator {
        return Category::query()
            ->ofType($type->value)
            ->with('parent')
            ->orderBy('sort_order')
            ->latest()
            ->paginate($perPage)
            ->withQueryString();
    }

    public function getParents(
        CategoryType $type,
        ?int $exceptId = null
    ): Collection {
        return Category::query()
            ->ofType($type->value)
            ->active()
            ->when(
                $exceptId,
                fn ($query) => $query->whereKeyNot($exceptId)
            )
            ->orderBy('name')
            ->get();
    }

    public function create(array $data): Category
    {
        $data = $this->prepareData($data);

        return Category::create($data);
    }

    public function update(
        Category $category,
        array $data
    ): Category {
        $data = $this->prepareData($data);

        $category->update($data);

        return $category->fresh();
    }

    public function delete(Category $category): bool
    {
        return $category->delete();
    }

    private function prepareData(array $data): array
    {
        $data['slug'] = $data['slug']
            ?? Str::slug($data['name']);

        $data['status'] ??= true;
        $data['sort_order'] ??= 0;

        return $data;
    }
}