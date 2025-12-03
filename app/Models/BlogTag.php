<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class BlogTag extends Model
{
    protected $fillable = [
        'name',
        'slug',
    ];

    /**
     * Relasi many-to-many ke posts
     */
    public function posts(): BelongsToMany
    {
        return $this->belongsToMany(BlogPost::class, 'blog_post_tag');
    }

    /**
     * Get published posts count
     */
    public function getPublishedPostsCountAttribute(): int
    {
        return $this->posts()->published()->count();
    }

    /**
     * Get route URL
     */
    public function getUrlAttribute(): string
    {
        return route('blog.tag', $this->slug);
    }

    /**
     * Get popular tags (by post count)
     */
    public static function getPopular(int $limit = 10)
    {
        return static::withCount(['posts' => function ($q) {
            $q->published();
        }])
        ->orderByDesc('posts_count')
        ->limit($limit)
        ->get();
    }
}
