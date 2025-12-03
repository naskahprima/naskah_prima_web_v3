<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PricingFeature extends Model
{
    protected $fillable = [
        'pricing_package_id',
        'feature',
        'is_included',
        'is_highlighted',
        'order',
    ];

    protected $casts = [
        'is_included' => 'boolean',
        'is_highlighted' => 'boolean',
    ];

    /**
     * Relasi ke package
     */
    public function package(): BelongsTo
    {
        return $this->belongsTo(PricingPackage::class, 'pricing_package_id');
    }
}
