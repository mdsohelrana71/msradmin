<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $product = $this->route('product');

        return [
            'category_id' => [
                'required',
                'exists:categories,id',
            ],

            'brand_id' => [
                'nullable',
                'exists:brands,id',
            ],

            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'sku' => [
                'required',
                'string',
                'max:255',
                Rule::unique('products', 'sku')
                    ->ignore($product?->id),
            ],

            'barcode' => [
                'nullable',
                'string',
                'max:255',
            ],

            'thumbnail' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],

            /*
            |--------------------------------------------------------------------------
            | Product Gallery Images
            |--------------------------------------------------------------------------
            */

            'images' => [
                'nullable',
                'array',
            ],

            'images.*.image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],

            'images.*.alt' => [
                'nullable',
                'string',
                'max:255',
            ],

            'removed_image_ids' => [
                'nullable',
                'array',
            ],

            'removed_image_ids.*' => [
                'integer',
                'exists:product_images,id',
            ],

            'image_order' => [
                'nullable',
                'array',
            ],

            'image_order.*' => [
                'integer',
                'exists:product_images,id',
            ],

            'existing_images' => [
                'nullable',
                'array',
            ],

            'existing_images.*.alt' => [
                'nullable',
                'string',
                'max:255',
            ],

            'short_description' => [
                'nullable',
                'string',
            ],

            'description' => [
                'nullable',
                'string',
            ],

            'cost_price' => [
                'required',
                'numeric',
                'min:0',
            ],

            'selling_price' => [
                'required',
                'numeric',
                'min:0',
            ],

            'discount_price' => [
                'nullable',
                'numeric',
                'min:0',
                'lte:selling_price',
            ],

            'stock' => [
                'required',
                'integer',
                'min:0',
            ],

            'weight' => [
                'nullable',
                'numeric',
                'min:0',
            ],

            'unit' => [
                'required',
                'string',
                'max:50',
            ],

            'is_featured' => [
                'boolean',
            ],

            'status' => [
                'required',
                'boolean',
            ],

            /*
            |--------------------------------------------------------------------------
            | Product Attributes
            |--------------------------------------------------------------------------
            */

            'attributes' => [
                'nullable',
                'array',
            ],

            'attributes.*' => [
                'integer',
                'exists:product_attributes,id',
            ],

            /*
            |--------------------------------------------------------------------------
            | Product Tags
            |--------------------------------------------------------------------------
            */

            'tags' => [
                'nullable',
                'array',
            ],

            'tags.*' => [
                'nullable',
                'string',
                'max:255',
            ],

            /*
            |--------------------------------------------------------------------------
            | Product Variants
            |--------------------------------------------------------------------------
            */

            'variants' => [
                'nullable',
                'array',
            ],

            'variants.*.id' => [
                'nullable',
                'integer',
                'exists:product_variants,id',
            ],

            'variants.*.sku' => [
                'nullable',
                'string',
                'max:255',
            ],

            'variants.*.barcode' => [
                'nullable',
                'string',
                'max:255',
            ],

            'variants.*.price' => [
                'required',
                'numeric',
                'min:0',
            ],

            'variants.*.discount_price' => [
                'nullable',
                'numeric',
                'min:0',
                'lte:variants.*.price',
            ],

            'variants.*.stock' => [
                'required',
                'integer',
                'min:0',
            ],

            'variants.*.image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],

            'variants.*.status' => [
                'boolean',
            ],

            'variants.*.values' => [
                'required',
                'array',
                'min:1',
            ],

            'variants.*.values.*.attribute_id' => [
                'required',
                'integer',
                'exists:product_attributes,id',
            ],

            'variants.*.values.*.attribute_value_id' => [
                'required',
                'integer',
                'exists:product_attribute_values,id',
            ],

            'removed_variant_ids' => [
                'nullable',
                'array',
            ],

            'removed_variant_ids.*' => [
                'integer',
                'exists:product_variants,id',
            ],
        ];
    }
}