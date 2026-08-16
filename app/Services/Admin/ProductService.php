<?php

namespace App\Services\Admin;

use App\Models\Tag;
use App\Models\Brand;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ProductService
{
    public function getProducts(
        ?string $search = null,
        ?string $sort = null,
        int $perPage = 20
    ): LengthAwarePaginator {
        return Product::query()
            ->with([
                'category:id,name',
                'brand:id,name',
                'tags:id,name',
            ])
            ->when($search, function ($query) use ($search) {
                $query->where(function ($query) use ($search) {
                    $query
                        ->where('name', 'like', "%{$search}%")
                        ->orWhere('sku', 'like', "%{$search}%")
                        ->orWhere('barcode', 'like', "%{$search}%");
                });
            })
            ->when($sort, function ($query) use ($sort) {
                match ($sort) {
                    'a_z' => $query->orderBy('name'),

                    'z_a' => $query->orderByDesc('name'),

                    'latest' => $query->latest('created_at'),

                    'oldest' => $query->oldest('created_at'),

                    'price_low' => $query->orderBy('selling_price'),

                    'price_high' => $query->orderByDesc('selling_price'),

                    'stock_low' => $query->orderBy('stock'),

                    'stock_high' => $query->orderByDesc('stock'),

                    'featured' => $query
                        ->where('is_featured', true)
                        ->orderBy('name'),

                    'active' => $query
                        ->where('status', true)
                        ->orderBy('name'),

                    'inactive' => $query
                        ->where('status', false)
                        ->orderBy('name'),

                    default => $query->latest('created_at'),
                };
            }, function ($query) {
                $query->latest('created_at');
            })
            ->paginate($perPage)
            ->withQueryString();
    }

    public function getProduct(Product $product): Product
    {
        return $product->load([
            'category',
            'brand',
            'tags',
        ]);
    }

    public function getCategories(): Collection
    {
        return Category::query()
            ->ofType('product')
            ->active()
            ->orderBy('name')
            ->get();
    }

    public function getBrands(): Collection
    {
        return Brand::query()
            ->where('status', true)
            ->orderBy('name')
            ->get();
    }

    public function getTags(): Collection
    {
        return Tag::query()
            ->orderBy('name')
            ->get();
    }

    public function create(): array
    {
        return [
            'categories' => $this->getCategories(),
            'brands' => $this->getBrands(),
            'tags' => $this->getTags(),
        ];
    }

    public function store(array $data): Product
    {
        return DB::transaction(function () use ($data) {
            $tagIds = $this->prepareTags(
                $data['tags'] ?? []
            );

            unset($data['tags']);

            $data['slug'] = $this->generateUniqueSlug(
                $data['name']
            );

            if (!empty($data['thumbnail'])) {
                $data['thumbnail'] = $data['thumbnail']
                    ->store('products', 'public');
            }

            $product = Product::create($data);

            $product->tags()->sync($tagIds);

            return $product->load([
                'category',
                'brand',
                'tags',
            ]);
        });
    }

    public function edit(Product $product): array
    {
        return [
            'product' => $product->load([
                'category',
                'brand',
                'tags',
            ]),
            'categories' => $this->getCategories(),
            'brands' => $this->getBrands(),
            'tags' => $this->getTags(),
        ];
    }

    public function update(
        Product $product,
        array $data
    ): Product {
        return DB::transaction(function () use (
            $product,
            $data
        ) {
            $tagIds = $this->prepareTags(
                $data['tags'] ?? []
            );

            unset($data['tags']);

            $data['slug'] = $this->generateUniqueSlug(
                $data['name'],
                $product->id
            );

            if (!empty($data['thumbnail'])) {
                if ($product->thumbnail) {
                    Storage::disk('public')->delete(
                        $product->thumbnail
                    );
                }

                $data['thumbnail'] = $data['thumbnail']
                    ->store('products', 'public');
            } else {
                unset($data['thumbnail']);
            }

            $product->update($data);

            $product->tags()->sync($tagIds);

            return $product->fresh([
                'category',
                'brand',
                'tags',
            ]);
        });
    }

    public function delete(Product $product): bool
    {
        return DB::transaction(function () use ($product) {
            $product->tags()->detach();

            if ($product->thumbnail) {
                Storage::disk('public')->delete(
                    $product->thumbnail
                );
            }

            return $product->delete();
        });
    }

    protected function prepareTags(array $tags): array
    {
        return collect($tags)
            ->map(function ($tag) {
                if (is_numeric($tag)) {
                    return (int) $tag;
                }

                $name = trim($tag);

                if ($name === '') {
                    return null;
                }

                $slug = Str::slug($name);

                if ($slug === '') {
                    return null;
                }

                return Tag::firstOrCreate(
                    [
                        'slug' => $slug,
                    ],
                    [
                        'name' => $name,
                        'status' => true,
                    ]
                )->id;
            })
            ->filter()
            ->unique()
            ->values()
            ->all();
    }

    protected function generateUniqueSlug(
        string $name,
        ?int $ignoreId = null
    ): string {
        $slug = Str::slug($name);

        if ($slug === '') {
            $slug = 'product';
        }

        $originalSlug = $slug;
        $counter = 1;

        while (
            Product::query()
                ->where('slug', $slug)
                ->when(
                    $ignoreId,
                    fn ($query) => $query->where(
                        'id',
                        '!=',
                        $ignoreId
                    )
                )
                ->exists()
        ) {
            $slug = "{$originalSlug}-{$counter}";
            $counter++;
        }

        return $slug;
    }
}