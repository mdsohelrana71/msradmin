<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'order_number',
        'status',
        'payment_status',
        'subtotal',
        'discount',
        'shipping_charge',
        'tax',
        'total',
        'currency',
        'customer_note',
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'discount' => 'decimal:2',
        'shipping_charge' => 'decimal:2',
        'tax' => 'decimal:2',
        'total' => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function addresses(): HasMany
    {
        return $this->hasMany(OrderAddress::class);
    }

    public function billingAddress()
    {
        return $this->hasOne(OrderAddress::class)
            ->where('type', 'billing');
    }

    public function shippingAddress()
    {
        return $this->hasOne(OrderAddress::class)
            ->where('type', 'shipping');
    }

    public function statusHistories(): HasMany
    {
        return $this->hasMany(OrderStatusHistory::class)
            ->latest('created_at');
    }
}