<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    protected $fillable = [
        'question',
        'answer',
        'category',
        'is_active',
        'order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Scope untuk FAQ aktif
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
     * Get FAQs untuk landing page
     */
    public static function getForLandingPage()
    {
        return static::active()
            ->ordered()
            ->get();
    }

    /**
     * Get FAQs grouped by category
     */
    public static function getGroupedByCategory()
    {
        return static::active()
            ->ordered()
            ->get()
            ->groupBy('category');
    }

    /**
     * Get unique categories
     */
    public static function getCategories()
    {
        return static::active()
            ->distinct('category')
            ->pluck('category');
    }
}
