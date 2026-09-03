<?php

namespace App\Services\Admin;

use App\Models\Tag;
use App\Models\Brand;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;
use App\Models\ProductAttribute;
use App\Models\ProductInventory;
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

    public function create(): array
    {
        return [
            'categories' => $this->getCategories(),
            'brands' => $this->getBrands(),
            'attributes' => $this->getAttributes(),
        ];
    }

    public function edit(Product $product): array
    {
        return [
            'product' => $product->load([
                'category',
                'brand',
                'tags',
                'images',
                'attributeAssignments.attribute',
                'variants.values.attribute',
                'variants.values.attributeValue',
            ]),
            'categories' => $this->getCategories(),
            'brands' => $this->getBrands(),
            'attributes' => $this->getAttributes(),
        ];
    }

    public function getCategories()
    {
        return Category::query()
            ->where('status', true)
            ->orderBy('name')
            ->get();
    }

    public function getBrands()
    {
        return Brand::query()
            ->where('status', true)
            ->orderBy('name')
            ->get();
    }

    public function getAttributes(): Collection
    {
        return ProductAttribute::query()
            ->where('status', true)
            ->with([
                'values' => function ($query) {
                    $query
                        ->where('status', true)
                        ->orderBy('sort_order')
                        ->orderBy('value');
                },
            ])
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();
    }

    public function getProduct(Product $product): Product
    {
        return $product->load([
            'category',
            'brand',
            'tags',
            'seo',
            'images',
            'attributeAssignments.attribute',
            'variants.values.attribute',
            'variants.values.attributeValue',
        ]);
    }

    public function getTags(): Collection
    {
        return Tag::query()
            ->orderBy('name')
            ->get();
    }

    public function store(array $data): Product
    {
        return DB::transaction(function () use ($data) {
            $tags = $data['tags'] ?? [];
            $attributes = $data['attributes'] ?? [];
            $variants = $data['variants'] ?? [];
            $images = $data['images'] ?? [];

            $seo = [
                'meta_title' => $data['meta_title'] ?? null,
                'meta_description' => $data['meta_description'] ?? null,
                'meta_keywords' => $data['meta_keywords'] ?? null,
                'canonical_url' => $data['canonical_url'] ?? null,
            ];

            unset(
                $data['tags'],
                $data['attributes'],
                $data['variants'],
                $data['images'],
                $data['meta_title'],
                $data['meta_description'],
                $data['meta_keywords'],
                $data['canonical_url']
            );

            $data['slug'] = $this->generateUniqueSlug(
                $data['name']
            );

            $data['is_featured'] = $data['is_featured'] ?? false;
            $data['status'] = $data['status'] ?? false;

            if (!empty($data['thumbnail'])) {
                $data['thumbnail'] = $data['thumbnail']
                    ->store('products', 'public');
            }

            $product = Product::create($data);

            $product->seo()->create($seo);

            $product->tags()->sync(
                $this->prepareTags($tags)
            );

            $this->syncAttributes(
                $product,
                $attributes
            );

            $this->syncVariants(
                $product,
                $variants
            );

            $this->syncProductImages(
                $product,
                $images
            );

            $this->syncInventory($product);

            return $product->load([
                'category',
                'brand',
                'tags',
                'seo',
                'images',
                'attributeAssignments.attribute',
                'variants.values.attribute',
                'variants.values.attributeValue',
            ]);
        });
    }

    public function update(Product $product, array $data): Product
    {
        return DB::transaction(function () use (
            $product,
            $data
        ) {
            $tags = $data['tags'] ?? [];
            $attributes = $data['attributes'] ?? [];
            $variants = $data['variants'] ?? [];

            $images = $data['images'] ?? [];
            $removedImageIds = $data['removed_image_ids'] ?? [];
            $imageOrder = $data['image_order'] ?? [];
            $existingImages = $data['existing_images'] ?? [];

            $seo = [
                'meta_title' => $data['meta_title'] ?? null,
                'meta_description' => $data['meta_description'] ?? null,
                'meta_keywords' => $data['meta_keywords'] ?? null,
                'canonical_url' => $data['canonical_url'] ?? null,
            ];

            $structureChanged = $this->hasAttributeStructureChanged(
                $product,
                $attributes
            );

            unset(
                $data['tags'],
                $data['attributes'],
                $data['variants'],
                $data['images'],
                $data['removed_image_ids'],
                $data['existing_images'],
                $data['image_order'],
                $data['removed_variant_ids'],
                $data['meta_title'],
                $data['meta_description'],
                $data['meta_keywords'],
                $data['canonical_url']
            );

            $data['slug'] = $this->generateUniqueSlug(
                $data['name'],
                $product->id
            );

            $data['is_featured'] = $data['is_featured'] ?? false;
            $data['status'] = $data['status'] ?? false;

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

            $product->seo()->updateOrCreate(
                ['product_id' => $product->id],
                $seo
            );

            $product->tags()->sync(
                $this->prepareTags($tags)
            );

            if ($structureChanged) {
                $this->rebuildVariants(
                    $product,
                    $attributes,
                    $variants
                );
            } else {
                $this->syncAttributes(
                    $product,
                    $attributes
                );

                $this->syncVariants(
                    $product,
                    $variants
                );
            }

            $this->syncProductImages(
                $product,
                $images,
                $removedImageIds,
                $imageOrder,
                $existingImages
            );

            $this->syncInventory($product);

            return $product->refresh()->load([
                'category',
                'brand',
                'tags',
                'seo',
                'images',
                'attributeAssignments.attribute',
                'variants.values.attribute',
                'variants.values.attributeValue',
            ]);
        });
    }

    public function delete(Product $product): bool
    {
        return DB::transaction(function () use ($product) {
            $product->tags()->detach();

            $product->variants()
                ->each(function ($variant) {
                    if ($variant->image) {
                        Storage::disk('public')
                            ->delete($variant->image);
                    }
                });

            $product->images()
                ->each(function ($image) {
                    if ($image->image) {
                        Storage::disk('public')
                            ->delete($image->image);
                    }
                });

            $product->attributeAssignments()->delete();
            $product->variants()->delete();
            $product->images()->delete();

            if ($product->thumbnail) {
                Storage::disk('public')
                    ->delete($product->thumbnail);
            }

            return $product->delete();
        });
    }

    protected function hasAttributeStructureChanged(
        Product $product,
        array $attributes
    ): bool {
        $oldAttributes = $product->attributeAssignments()
            ->pluck('attribute_id')
            ->map(fn ($id) => (int) $id)
            ->sort()
            ->values()
            ->all();

        $newAttributes = collect($attributes)
            ->map(fn ($id) => (int) $id)
            ->filter()
            ->unique()
            ->sort()
            ->values()
            ->all();

        return $oldAttributes !== $newAttributes;
    }

    protected function rebuildVariants(
        Product $product,
        array $attributes,
        array $variants
    ): void {
        $product->inventory()->delete();

        $product->variants()
            ->with('inventory')
            ->each(function ($variant) {
                if ($variant->image) {
                    Storage::disk('public')
                        ->delete($variant->image);
                }

                $variant->delete();
            });

        $this->syncAttributes(
            $product,
            $attributes
        );

        $this->createVariants(
            $product,
            $variants
        );
    }

    protected function createVariants(
        Product $product,
        array $variants
    ): void {
        foreach ($variants as $index => $variantData) {
            $variantAttributes = $variantData['values'] ?? [];
            $image = $variantData['image'] ?? null;

            $variantData = collect($variantData)
                ->except([
                    'id',
                    'values',
                    'image',
                    'remove_image',
                ])
                ->toArray();

            $variantData['status'] =
                $variantData['status'] ?? true;

            $variantData['sort_order'] =
                $variantData['sort_order'] ?? $index;

            if ($image) {
                $variantData['image'] = $image
                    ->store(
                        'products/variants',
                        'public'
                    );
            }

            $variant = $product->variants()
                ->create($variantData);

            $this->syncVariantValues(
                $variant,
                $variantAttributes
            );
        }
    }

    protected function syncInventory(Product $product): void
    {
        $variants = $product->variants()
            ->get();

        if ($variants->isEmpty()) {
            $product->inventory()->firstOrCreate(
                [],
                [
                    'stock' => 0,
                    'reserved_stock' => 0,
                    'low_stock_alert' => 5,
                ]
            );

            return;
        }

        $product->inventory()->delete();

        foreach ($variants as $variant) {
            $variant->inventory()->firstOrCreate(
                [],
                [
                    'product_id' => $product->id,
                    'stock' => 0,
                    'reserved_stock' => 0,
                    'low_stock_alert' => 5,
                ]
            );
        }
    }

    protected function syncAttributes(
        Product $product,
        array $attributes
    ): void {
        $attributeIds = collect($attributes)
            ->map(fn ($attribute) => (int) $attribute)
            ->filter()
            ->unique()
            ->values();

        $product->attributeAssignments()->delete();

        foreach ($attributeIds as $attributeId) {
            $product->attributeAssignments()->create([
                'attribute_id' => $attributeId,
            ]);
        }
    }

    protected function syncVariants(
        Product $product,
        array $variants
    ): void {
        $existingVariantIds = $product->variants()
            ->pluck('id')
            ->all();

        $submittedVariantIds = [];

        foreach ($variants as $index => $variantData) {
            $variantId = $variantData['id'] ?? null;
            $variantAttributes = $variantData['values'] ?? [];
            $image = $variantData['image'] ?? null;

            $removeImage = !empty(
                $variantData['remove_image']
            ) && $variantData['remove_image'] == 1;

            $variantData = collect($variantData)
                ->except([
                    'id',
                    'values',
                    'image',
                    'remove_image',
                ])
                ->toArray();

            $variantData['status'] =
                $variantData['status'] ?? true;

            $variantData['sort_order'] =
                $variantData['sort_order'] ?? $index;

            if ($variantId) {
                $variant = $product->variants()
                    ->whereKey($variantId)
                    ->first();

                if (!$variant) {
                    continue;
                }

                if ($removeImage && $variant->image) {
                    Storage::disk('public')
                        ->delete($variant->image);

                    $variantData['image'] = null;
                }

                if ($image) {
                    if ($variant->image) {
                        Storage::disk('public')
                            ->delete($variant->image);
                    }

                    $variantData['image'] = $image
                        ->store(
                            'products/variants',
                            'public'
                        );
                }

                $variant->update($variantData);
            } else {
                if ($image) {
                    $variantData['image'] = $image
                        ->store(
                            'products/variants',
                            'public'
                        );
                }

                $variant = $product->variants()
                    ->create($variantData);
            }

            $submittedVariantIds[] = $variant->id;

            $this->syncVariantValues(
                $variant,
                $variantAttributes
            );
        }

        $variantsToDelete = array_diff(
            $existingVariantIds,
            $submittedVariantIds
        );

        if (!empty($variantsToDelete)) {
            $product->variants()
                ->whereIn('id', $variantsToDelete)
                ->each(function ($variant) {
                    if ($variant->image) {
                        Storage::disk('public')
                            ->delete($variant->image);
                    }

                    $variant->delete();
                });
        }
    }

    protected function syncVariantValues(
        $variant,
        array $values
    ): void {
        $variant->values()->delete();

        foreach ($values as $value) {
            if (
                empty($value['attribute_id']) ||
                empty($value['attribute_value_id'])
            ) {
                continue;
            }

            $variant->values()->create([
                'attribute_id' => $value['attribute_id'],
                'attribute_value_id' => $value['attribute_value_id'],
            ]);
        }
    }

    protected function syncProductImages(
        Product $product,
        array $images = [],
        array $removedImageIds = [],
        array $imageOrder = [],
        array $existingImages = []
    ): void {
        if (!empty($removedImageIds)) {
            $product->images()
                ->whereIn('id', $removedImageIds)
                ->each(function ($image) {
                    if ($image->image) {
                        Storage::disk('public')
                            ->delete($image->image);
                    }

                    $image->delete();
                });
        }

        if (!empty($existingImages)) {
            foreach ($existingImages as $imageId => $imageData) {
                $product->images()
                    ->whereKey($imageId)
                    ->update([
                        'alt' => $imageData['alt'] ?? null,
                    ]);
            }
        }

        foreach ($images as $index => $imageData) {
            if (empty($imageData['image'])) {
                continue;
            }

            $imagePath = $imageData['image']
                ->store(
                    'products/gallery',
                    'public'
                );

            $product->images()->create([
                'image' => $imagePath,
                'alt' => $imageData['alt'] ?? null,
                'sort_order' => $index,
            ]);
        }

        if (!empty($imageOrder)) {
            foreach ($imageOrder as $sortOrder => $imageId) {
                $product->images()
                    ->whereKey($imageId)
                    ->update([
                        'sort_order' => $sortOrder,
                    ]);
            }
        }
    }

    private function prepareTags(array $tags): array
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

                return Tag::firstOrCreate(
                    [
                        'slug' => Str::slug($name),
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