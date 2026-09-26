@php
    $productImages = $product->images
        ->map(fn ($image) => asset('storage/' . ltrim($image->image, '/')))
        ->values()
        ->toArray();

    $productVariants = $product->variants
        ->filter(function ($variant) {
            return $variant->status
                && $variant->inventory
                && $variant->inventory->stock > $variant->inventory->reserved_stock;
        })
        ->map(function ($variant) {
            return [
                'id' => $variant->id,
                'sku' => $variant->sku,
                'price' => $variant->price,
                'discount_price' => $variant->discount_price,
                'values' => $variant->values
                    ->map(function ($value) {
                        return [
                            'attribute_id' => $value->attribute_id,
                            'attribute_name' => $value->attribute?->name,
                            'attribute_value_id' => $value->attribute_value_id,
                            'value' => $value->attributeValue?->value,
                        ];
                    })
                    ->values()
                    ->toArray(),
            ];
        })
        ->values()
        ->toArray();
@endphp

<button
    type="button"
    class="quick-view-btn"
    data-bs-toggle="offcanvas"
    data-bs-target="#quickViewModal"
    data-product-id="{{ $product->id }}"
    data-product-name="{{ $product->name }}"
    data-product-code="{{ $product->sku }}"
    data-product-price="{{ $settings->price_symbol }}{{ number_format($currentPrice, 0) }}"
    data-product-image="{{ $product->thumbnail ? asset('storage/' . ltrim($product->thumbnail, '/')) : '' }}"
    data-product-url="{{ route('products.show', $product->slug) }}"
    data-cart-url="{{ route('cart.add', $product->id) }}"
    data-product-images='@json($productImages)'
    data-product-variants='@json($productVariants)'
>
    <i class="fa-solid fa-eye"></i>
    Quick View
</button>