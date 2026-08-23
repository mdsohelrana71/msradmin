<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductFaq extends Model
{
    protected $fillable = [
        'product_id',
        'question',
        'answer',
        'sort_order',
        'status',
    ];

    protected $casts = [
        'sort_order' => 'integer',
        'status' => 'boolean',
    ];

    public function products()
    {
        return $this->belongsToMany(
            Product::class,
            'product_faq_product'
        );
    }
}