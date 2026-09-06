<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
class Discount extends Model
{
    protected $fillable = [
        'name',
        'type',
        'value',
        'minimum_order_amount',
        'maximum_discount',
        'starts_at',
        'ends_at',
        'priority',
        'allow_coupon',
        'status',
    ];
    protected $casts = [
        'value' => 'decimal:2',
        'minimum_order_amount' => 'decimal:2',
        'maximum_discount' => 'decimal:2',
        'starts_at' => 'datetime',
        'ends_at' => 'datetime',
        'allow_coupon' => 'boolean',
        'status' => 'boolean',
    ];
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'discount_products');
    }
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'discount_categories');
    }
}