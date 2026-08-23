<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    protected $fillable = [
        'category_id',
        'brand_id',
        'name',
        'slug',
        'sku',
        'barcode',
        'thumbnail',
        'short_description',
        'description',
        'cost_price',
        'selling_price',
        'discount_price',
        'stock',
        'weight',
        'unit',
        'is_featured',
        'status',
    ];

    protected $casts = [
        'cost_price' => 'decimal:2',
        'selling_price' => 'decimal:2',
        'discount_price' => 'decimal:2',
        'weight' => 'decimal:2',
        'stock' => 'integer',
        'is_featured' => 'boolean',
        'status' => 'boolean',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(
            Category::class,
            'category_id'
        );
    }

    public function brand(): BelongsTo
    {
        return $this->belongsTo(
            Brand::class,
            'brand_id'
        );
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(
            Tag::class,
            'product_tag',
            'product_id',
            'tag_id'
        );
    }

    public function variants(): HasMany
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function attributeAssignments(): HasMany
    {
        return $this->hasMany(
            ProductAttributeAssignment::class,
            'product_id'
        );
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class)
            ->orderBy('sort_order');
    }

    public function faqs()
    {
        return $this->belongsToMany(
            ProductFaq::class,
            'product_faq_product'
        );
    }

    public function seo(): HasOne
    {
        return $this->hasOne(ProductSeo::class);
    }

}