<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PromoButton extends Model
{
    protected $fillable = [
        'promo_id',
        'label',
        'url',
        'sort_order',
        'status',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    public function promo(): BelongsTo
    {
        return $this->belongsTo(Promo::class);
    }
}