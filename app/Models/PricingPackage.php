<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PricingPackage extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'is_popular',
        'is_active',
        'order',
        'badge_color',
    ];

    protected $casts = [
        'is_popular' => 'boolean',
        'is_active' => 'boolean',
    ];

    /**
     * Relasi ke pricing items (harga per SINTA level)
     */
    public function items(): HasMany
    {
        return $this->hasMany(PricingItem::class)->orderBy('order');
    }

    /**
     * Relasi ke features
     */
    public function features(): HasMany
    {
        return $this->hasMany(PricingFeature::class)->orderBy('order');
    }

    /**
     * Scope untuk package aktif
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope untuk sorting
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }

    /**
     * Get all packages dengan items dan features (untuk landing page)
     */
    public static function getForLandingPage()
    {
        return static::active()
            ->ordered()
            ->with(['items' => function ($q) {
                $q->where('is_active', true)->orderBy('order');
            }, 'features' => function ($q) {
                $q->orderBy('order');
            }])
            ->get();
    }

    /**
     * Format harga terendah untuk display
     */
    public function getLowestPriceAttribute()
    {
        $lowestItem = $this->items()->where('is_active', true)->orderBy('price')->first();
        return $lowestItem ? $lowestItem->price : 0;
    }

    /**
     * Format harga untuk display (Rp 300rb, Rp 1.1jt, dll)
     */
    public static function formatPrice(int $price): string
    {
        if ($price >= 1000000) {
            $formatted = $price / 1000000;
            return 'Rp ' . number_format($formatted, 1, ',', '.') . 'jt';
        }
        
        $formatted = $price / 1000;
        return 'Rp ' . number_format($formatted, 0, ',', '.') . 'rb';
    }
}
