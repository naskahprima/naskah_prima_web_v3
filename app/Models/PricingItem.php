<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PricingItem extends Model
{
    protected $fillable = [
        'pricing_package_id',
        'sinta_level',
        'price',
        'order',
        'is_active',
    ];

    protected $casts = [
        'price' => 'integer',
        'is_active' => 'boolean',
    ];

    /**
     * Relasi ke package
     */
    public function package(): BelongsTo
    {
        return $this->belongsTo(PricingPackage::class, 'pricing_package_id');
    }

    /**
     * Format harga untuk display
     */
    public function getFormattedPriceAttribute(): string
    {
        return PricingPackage::formatPrice($this->price);
    }

    /**
     * Scope untuk item aktif
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
