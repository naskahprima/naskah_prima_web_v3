<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\BlogPost;
use App\Models\BlogCategory;
use App\Models\BlogTag;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    /**
     * Blog index - list all published posts
     */
    public function index()
    {
        $settings = Setting::getAllCached();
        $whatsappUrl = $this->generateWhatsAppUrl($settings['whatsapp_number'] ?? '6281234567890');
        
        $posts = BlogPost::published()
            ->recent()
            ->with(['category', 'author'])
            ->paginate(9);
        
        $categories = BlogCategory::active()
            ->ordered()
            ->withCount(['posts' => function ($query) {
                $query->published();
            }])
            ->get();
        
        $popularTags = BlogTag::getPopular(10);
        
        return view('blog.index', compact(
            'settings',
            'posts',
            'categories',
            'popularTags',
            'whatsappUrl'
        ));
    }

    /**
     * Show single blog post
     */
    public function show(string $slug)
    {
        $settings = Setting::getAllCached();
        $whatsappUrl = $this->generateWhatsAppUrl($settings['whatsapp_number'] ?? '6281234567890');
        
        $post = BlogPost::where('slug', $slug)
            ->published()
            ->with(['category', 'author', 'tags'])
            ->firstOrFail();
        
        // Increment view count
        $post->incrementViewCount();
        
        // Get related posts
        $relatedPosts = $post->getRelatedPosts(3);
        
        return view('blog.show', compact(
            'settings',
            'post',
            'relatedPosts',
            'whatsappUrl'
        ));
    }

    /**
     * Show posts by category
     */
    public function category(string $slug)
    {
        $settings = Setting::getAllCached();
        $whatsappUrl = $this->generateWhatsAppUrl($settings['whatsapp_number'] ?? '6281234567890');
        
        $category = BlogCategory::where('slug', $slug)
            ->active()
            ->firstOrFail();
        
        $posts = BlogPost::published()
            ->where('blog_category_id', $category->id)
            ->recent()
            ->with(['category', 'author'])
            ->paginate(9);
        
        $categories = BlogCategory::active()
            ->ordered()
            ->withCount(['posts' => function ($query) {
                $query->published();
            }])
            ->get();
        
        $popularTags = BlogTag::getPopular(10);
        
        return view('blog.index', compact(
            'settings',
            'posts',
            'categories',
            'popularTags',
            'whatsappUrl',
            'category'
        ));
    }

    /**
     * Show posts by tag
     */
    public function tag(string $slug)
    {
        $settings = Setting::getAllCached();
        $whatsappUrl = $this->generateWhatsAppUrl($settings['whatsapp_number'] ?? '6281234567890');
        
        $tag = BlogTag::where('slug', $slug)->firstOrFail();
        
        $posts = $tag->posts()
            ->published()
            ->recent()
            ->with(['category', 'author'])
            ->paginate(9);
        
        $categories = BlogCategory::active()
            ->ordered()
            ->withCount(['posts' => function ($query) {
                $query->published();
            }])
            ->get();
        
        $popularTags = BlogTag::getPopular(10);
        
        return view('blog.index', compact(
            'settings',
            'posts',
            'categories',
            'popularTags',
            'whatsappUrl',
            'tag'
        ));
    }

    /**
     * Generate WhatsApp URL
     */
    private function generateWhatsAppUrl(string $number, string $message = null): string
    {
        $number = preg_replace('/[^0-9]/', '', $number);
        
        if (empty($message)) {
            $message = 'Halo Naskah Prima, saya ingin konsultasi tentang publikasi jurnal';
        }
        
        return 'https://wa.me/' . $number . '?text=' . urlencode($message);
    }
}
