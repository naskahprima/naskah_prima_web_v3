<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\BlogPost;
use App\Models\BlogCategory;
use App\Models\BlogTag;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $settings = Setting::getAllCached();
        $whatsappUrl = $this->generateWhatsAppUrl($settings['whatsapp_number'] ?? '6281234567890');
        
        // Ambil search query dari URL
        $search = $request->query('q');
        
        // Build query
        $query = BlogPost::where('status', 'published')
            ->where('published_at', '<=', now())
            ->orderBy('published_at', 'desc')
            ->with(['category', 'author']);
        
        // Filter jika ada search
        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                  ->orWhere('content', 'like', '%' . $search . '%')
                  ->orWhere('excerpt', 'like', '%' . $search . '%');
            });
        }
        
        $posts = $query->paginate(9);
        
        $categories = BlogCategory::active()
            ->ordered()
            ->withCount(['posts' => function ($q) {
                $q->where('status', 'published');
            }])
            ->get();
        
        $popularTags = BlogTag::getPopular(10);
        
        return view('blog.index', compact(
            'settings',
            'posts',
            'categories',
            'popularTags',
            'whatsappUrl',
            'search'
        ));
    }

    public function show(string $slug)
    {
        $settings = Setting::getAllCached();
        $whatsappUrl = $this->generateWhatsAppUrl($settings['whatsapp_number'] ?? '6281234567890');
        
        $post = BlogPost::where('slug', $slug)
            ->where('status', 'published')
            ->with(['category', 'author', 'tags'])
            ->firstOrFail();
        
        $post->incrementViewCount();
        
        $relatedPosts = $post->getRelatedPosts(3);
        
        return view('blog.show', compact(
            'settings',
            'post',
            'relatedPosts',
            'whatsappUrl'
        ));
    }

    public function category(string $slug)
    {
        $settings = Setting::getAllCached();
        $whatsappUrl = $this->generateWhatsAppUrl($settings['whatsapp_number'] ?? '6281234567890');
        
        $category = BlogCategory::where('slug', $slug)->firstOrFail();
        
        $posts = BlogPost::where('status', 'published')
            ->where('blog_category_id', $category->id)
            ->orderBy('published_at', 'desc')
            ->with(['category', 'author'])
            ->paginate(9);
        
        $categories = BlogCategory::active()
            ->ordered()
            ->withCount(['posts' => function ($q) {
                $q->where('status', 'published');
            }])
            ->get();
        
        $popularTags = BlogTag::getPopular(10);
        $search = null;
        
        return view('blog.index', compact(
            'settings',
            'posts',
            'categories',
            'popularTags',
            'whatsappUrl',
            'category',
            'search'
        ));
    }

    public function tag(string $slug)
    {
        $settings = Setting::getAllCached();
        $whatsappUrl = $this->generateWhatsAppUrl($settings['whatsapp_number'] ?? '6281234567890');
        
        $tag = BlogTag::where('slug', $slug)->firstOrFail();
        
        $posts = $tag->posts()
            ->where('status', 'published')
            ->orderBy('published_at', 'desc')
            ->with(['category', 'author'])
            ->paginate(9);
        
        $categories = BlogCategory::active()
            ->ordered()
            ->withCount(['posts' => function ($q) {
                $q->where('status', 'published');
            }])
            ->get();
        
        $popularTags = BlogTag::getPopular(10);
        $search = null;
        
        return view('blog.index', compact(
            'settings',
            'posts',
            'categories',
            'popularTags',
            'whatsappUrl',
            'tag',
            'search'
        ));
    }

    private function generateWhatsAppUrl(string $number, string $message = null): string
    {
        $number = preg_replace('/[^0-9]/', '', $number);
        
        if (empty($message)) {
            $message = 'Halo Naskah Prima, saya ingin konsultasi tentang publikasi jurnal';
        }
        
        return 'https://wa.me/' . $number . '?text=' . urlencode($message);
    }
}