<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductInventory extends Model
{
    use HasFactory;

    protected $table = 'product_inventory';

    protected $fillable = [
        'product_id',
        'product_variant_id',
        'stock',
        'reserved_stock',
        'low_stock_alert',
    ];

    protected $casts = [
        'stock' => 'integer',
        'reserved_stock' => 'integer',
        'low_stock_alert' => 'integer',
    ];

    protected $appends = [
        'available_stock',
        'stock_status',
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function variant(): BelongsTo
    {
        return $this->belongsTo(ProductVariant::class, 'product_variant_id');
    }

    public function getAvailableStockAttribute(): int
    {
        return max(0, $this->stock - $this->reserved_stock);
    }

    public function getStockStatusAttribute(): string
    {
        if ($this->available_stock <= 0) {
            return 'out_of_stock';
        }

        if ($this->available_stock <= $this->low_stock_alert) {
            return 'low_stock';
        }

        return 'in_stock';
    }
}