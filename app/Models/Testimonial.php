<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    protected $fillable = [
        'client_name',
        'client_role',
        'university',
        'quote',
        'sinta_level',
        'processing_days',
        'rating',
        'photo',
        'is_featured',
        'is_active',
        'order',
    ];

    protected $casts = [
        'rating' => 'integer',
        'processing_days' => 'integer',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
    ];

    /**
     * Scope untuk testimonial aktif
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope untuk featured testimonials
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Scope untuk sorting
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }

    /**
     * Get testimonials untuk landing page
     */
    public static function getForLandingPage(int $limit = 6)
    {
        return static::active()
            ->featured()
            ->ordered()
            ->limit($limit)
            ->get();
    }

    /**
     * Get photo URL (dengan fallback ke default avatar)
     */
    public function getPhotoUrlAttribute(): string
    {
        if ($this->photo) {
            return asset('storage/' . $this->photo);
        }
        
        // Default avatar dengan inisial
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->client_name) . '&background=554D89&color=fff&size=120';
    }

    /**
     * Get meta info (SINTA level • XX hari)
     */
    public function getMetaInfoAttribute(): string
    {
        $parts = [];
        
        if ($this->sinta_level) {
            $parts[] = $this->sinta_level;
        }
        
        if ($this->processing_days) {
            $parts[] = $this->processing_days . ' hari';
        }
        
        return implode(' • ', $parts);
    }
}
