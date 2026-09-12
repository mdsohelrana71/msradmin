<?php
namespace App\Services\Frontend\Product;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductAttribute;
use App\Services\Frontend\Global\ProductQuery;
use App\Services\Frontend\Global\ProductSearchService;
use Illuminate\Support\Facades\DB;

class ProductService
{
    protected ProductQuery $productQuery;
    protected ProductSearchService $productSearchService;

    public function __construct(
        ProductQuery $productQuery,
        ProductSearchService $productSearchService
    ) {
        $this->productQuery = $productQuery;
        $this->productSearchService = $productSearchService;
    }

    public function getProducts(): array
    {
        $query = $this->productQuery->frontend()
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
            'brand',
            'variants',
        ]);

        $isVariantProduct = $product->variants->isNotEmpty();

        $productStock = $isVariantProduct
            ? 0
            : $this->getProductStock($product->id);

        $variants = $isVariantProduct
            ? $this->getProductVariants($product->id)
            : collect();

        $similarProducts = $this->productQuery->frontend()
            ->where('category_id', $product->category_id)
            ->whereKeyNot($product->id)
            ->with(['images', 'category', 'brand'])
            ->latest('created_at')
            ->take(6)
            ->get();

        return [
            'product' => $product,
            'similarProducts' => $similarProducts,
            'isVariantProduct' => $isVariantProduct,
            'productStock' => $productStock,
            'variants' => $variants,
        ];
    }

    public function searchProducts(string $search)
    {
        return $this->productSearchService->search($search);
    }

    private function getProductStock(int $productId): int
    {
        return (int) DB::table('product_inventory')
            ->where('product_id', $productId)
            ->whereNull('product_variant_id')
            ->selectRaw('GREATEST(COALESCE(SUM(stock - reserved_stock), 0), 0) as available_stock')
            ->value('available_stock');
    }

    private function getProductVariants(int $productId)
    {
        return DB::table('product_variants as variants')
            ->join(
                'product_variant_values as variant_values',
                'variant_values.variant_id',
                '=',
                'variants.id'
            )
            ->join(
                'product_attribute_values as attribute_values',
                'attribute_values.id',
                '=',
                'variant_values.attribute_value_id'
            )
            ->join(
                'product_attributes as attributes',
                'attributes.id',
                '=',
                'variant_values.attribute_id'
            )
            ->leftJoin('product_inventory as inventory', function ($join) {
                $join->on('inventory.product_variant_id', '=', 'variants.id')
                    ->whereColumn('inventory.product_id', 'variants.product_id');
            })
            ->where('variants.product_id', $productId)
            ->where('variants.status', true)
            ->where('attributes.status', true)
            ->where('attribute_values.status', true)
            ->select([
                'variants.id as variant_id',
                'variants.price',
                'variants.discount_price',
                'variants.sku as variant_sku',
                'variants.image as variant_image',
                'variant_values.id as variant_value_id',
                'attribute_values.id as attribute_value_id',
                'attribute_values.value as attribute_value',
                'attribute_values.slug as attribute_value_slug',
                'attributes.id as attribute_id',
                'attributes.name as attribute_name',
                'attributes.slug as attribute_slug',
            ])
            ->selectRaw(
                'GREATEST(COALESCE(SUM(inventory.stock - inventory.reserved_stock), 0), 0) as available_stock'
            )
            ->groupBy([
                'variants.id',
                'variants.price',
                'variants.discount_price',
                'variants.sku',
                'variants.image',
                'variant_values.id',
                'attribute_values.id',
                'attribute_values.value',
                'attribute_values.slug',
                'attributes.id',
                'attributes.name',
                'attributes.slug',
                'attributes.sort_order',
                'attribute_values.sort_order',
            ])
            ->orderBy('variants.id')
            ->orderBy('attributes.sort_order')
            ->orderBy('attribute_values.sort_order')
            ->get();
    }

    private function applyCategoryFilter($query): void
    {
        $categories = array_filter((array) request('category', []));

        if (! $categories) {
            return;
        }

        $query->whereHas('category', function ($query) use ($categories) {
            $query->whereIn('slug', $categories);
        });
    }

    private function applyPriceFilter($query): void
    {
        $prices = array_filter((array) request('price', []));

        if (! $prices) {
            return;
        }

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

            if (! $values) {
                continue;
            }

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