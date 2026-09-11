<?php
namespace App\Services\Frontend\Product;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductAttribute;
class DesignOneProductService
{
    public function getProducts(): array
    {
        $query = Product::query()
            ->where('status', true)
            ->with(['images', 'category']);
        $this->applyCategoryFilter($query);
        $this->applyPriceFilter($query);
        $this->applyAttributeFilters($query);
        $this->applySorting($query);
        $products = $query->paginate(12)->withQueryString();
        $categories = Category::query()
            ->active()
            ->ofType('product')
            ->whereNull('parent_id')
            ->with('children')
            ->orderBy('sort_order')
            ->latest('id')
            ->get();
        $attributes = ProductAttribute::query()
            ->where('status', true)
            ->with([
                'values' => fn ($query) => $query
                    ->where('status', true)
                    ->orderBy('sort_order')
                    ->latest('id')
            ])
            ->orderBy('sort_order')
            ->latest('id')
            ->get();
        return [
            'products' => $products,
            'categories' => $categories,
            'attributes' => $attributes,
        ];
    }

    public function getProduct(Product $product): array
    {
        abort_unless($product->status, 404);

        $product->load([
            'images',
            'category',
        ]);

        $similarProducts = Product::query()
            ->where('status', true)
            ->where('category_id', $product->category_id)
            ->whereKeyNot($product->id)
            ->with([
                'images',
                'category',
            ])
            ->latest('created_at')
            ->take(6)
            ->get();

        return [
            'product' => $product,
            'similarProducts' => $similarProducts,
        ];
    }

    private function applyCategoryFilter($query): void
    {
        $categories = array_filter((array) request('category', []));
        if (!$categories) return;
        $query->whereHas('category', function ($query) use ($categories) {
            $query->whereIn('slug', $categories);
        });
    }

    private function applyPriceFilter($query): void
    {
        $prices = array_filter((array) request('price', []));
        if (!$prices) return;
        $query->where(function ($query) use ($prices) {
            foreach ($prices as $price) {
                match ($price) {
                    '0-1000' => $query->orWhereBetween('selling_price', [0, 1000]),
                    '1001-2000' => $query->orWhereBetween('selling_price', [1001, 2000]),
                    '2001-3000' => $query->orWhereBetween('selling_price', [2001, 3000]),
                    '3001-4000' => $query->orWhereBetween('selling_price', [3001, 4000]),
                    '4001-5000' => $query->orWhereBetween('selling_price', [4001, 5000]),
                    '5001-6000' => $query->orWhereBetween('selling_price', [5001, 6000]),
                    '6001-7000' => $query->orWhereBetween('selling_price', [6001, 7000]),
                    '7001+' => $query->orWhere('selling_price', '>=', 7001),
                    default => null,
                };
            }
        });
    }

    private function applyAttributeFilters($query): void
    {
        $attributes = ProductAttribute::query()
            ->where('status', true)
            ->get(['id', 'slug']);
        foreach ($attributes as $attribute) {
            $values = array_filter((array) request($attribute->slug, []));
            if (!$values) continue;
            $query->whereHas('variants.values', function ($query) use ($attribute, $values) {
                $query->where('attribute_id', $attribute->id)
                    ->whereHas('attributeValue', function ($query) use ($values) {
                        $query->whereIn('slug', $values);
                    });
            });
        }
    }

    private function applySorting($query): void
    {
        match (request('sort', 'newest')) {
            'priceLowHigh' => $query->orderBy('selling_price'),
            'priceHighLow' => $query->orderByDesc('selling_price'),
            default => $query->latest('created_at'),
        };
    }
}