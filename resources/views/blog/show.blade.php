@extends('layouts.app')

@section('title', $post->seo_title)
@section('meta_title', $post->seo_title)
@section('meta_description', $post->seo_description)
@section('meta_keywords', $post->meta_keywords)

@section('og_type', 'article')
@section('og_title', $post->seo_title)
@section('og_description', $post->seo_description)
@section('og_image', $post->og_image_url ?? $post->featured_image_url)

@section('schema')
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "BlogPosting",
    "headline": "{{ $post->title }}",
    "description": "{{ $post->seo_description }}",
    "image": "{{ $post->featured_image_url }}",
    "author": {
        "@type": "Person",
        "name": "{{ $post->author->name }}"
    },
    "publisher": {
        "@type": "Organization",
        "name": "{{ $settings['site_name'] ?? 'Naskah Prima' }}"
    },
    "datePublished": "{{ $post->published_at->toIso8601String() }}",
    "dateModified": "{{ $post->updated_at->toIso8601String() }}"
}
</script>
@endsection

@section('content')
<article class="blog-post">
    <!-- Post Header -->
    <header class="post-header">
        <div class="container">
            <div class="post-header-content">
                @if($post->category)
                <a href="{{ route('blog.category', $post->category->slug) }}" class="post-category">
                    {{ $post->category->name }}
                </a>
                @endif
                
                <h1 class="post-title">{{ $post->title }}</h1>
                
                <div class="post-meta">
                    <div class="post-author">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($post->author->name) }}&background=554D89&color=fff" alt="{{ $post->author->name }}">
                        <span>{{ $post->author->name }}</span>
                    </div>
                    <span class="post-date">
                        <i class="far fa-calendar"></i> {{ $post->formatted_date }}
                    </span>
                    <span class="post-reading">
                        <i class="far fa-clock"></i> {{ $post->reading_time }} menit baca
                    </span>
                    <span class="post-views">
                        <i class="far fa-eye"></i> {{ number_format($post->view_count) }} views
                    </span>
                </div>
            </div>
        </div>
    </header>

    @if($post->featured_image)
    <div class="post-featured-image">
        <div class="container">
            <img src="{{ $post->featured_image_url }}" alt="{{ $post->featured_image_alt ?? $post->title }}">
        </div>
    </div>
    @endif

    <!-- Post Content -->
    <div class="post-content-wrapper">
        <div class="container">
            <div class="post-layout">
                <div class="post-main">
                    <div class="post-content prose">
                        {!! $post->content !!}
                    </div>

                    <!-- Tags -->
                    @if($post->tags->count() > 0)
                    <div class="post-tags">
                        <span class="tags-label">Tags:</span>
                        @foreach($post->tags as $tag)
                        <a href="{{ route('blog.tag', $tag->slug) }}" class="tag-item">{{ $tag->name }}</a>
                        @endforeach
                    </div>
                    @endif

                    <!-- Share -->
                    <div class="post-share">
                        <span class="share-label">Share:</span>
                        <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($post->title) }}" target="_blank" rel="noopener" class="share-btn twitter">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank" rel="noopener" class="share-btn facebook">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode(url()->current()) }}&title={{ urlencode($post->title) }}" target="_blank" rel="noopener" class="share-btn linkedin">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                        <a href="https://wa.me/?text={{ urlencode($post->title . ' ' . url()->current()) }}" target="_blank" rel="noopener" class="share-btn whatsapp">
                            <i class="fab fa-whatsapp"></i>
                        </a>
                    </div>

                    <!-- Author Box -->
                    <div class="author-box">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($post->author->name) }}&background=554D89&color=fff&size=80" alt="{{ $post->author->name }}">
                        <div class="author-info">
                            <h4>{{ $post->author->name }}</h4>
                            <p>Editor di Naskah Prima dengan spesialisasi di bidang informatika dan publikasi jurnal ilmiah.</p>
                        </div>
                    </div>

                    <!-- Related Posts -->
                    @if($relatedPosts->count() > 0)
                    <div class="related-posts">
                        <h3>Artikel Terkait</h3>
                        <div class="related-grid">
                            @foreach($relatedPosts as $related)
                            <a href="{{ route('blog.show', $related->slug) }}" class="related-card">
                                @if($related->featured_image)
                                <img src="{{ $related->featured_image_url }}" alt="{{ $related->title }}">
                                @endif
                                <h4>{{ $related->title }}</h4>
                            </a>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Sidebar -->
                <aside class="post-sidebar">
                    <!-- TOC (Table of Contents) - Optional -->
                    <div class="sidebar-widget sticky-widget">
                        <h3 class="widget-title">Butuh Bantuan?</h3>
                        <p>Konsultasi gratis dengan tim Naskah Prima untuk publikasi jurnal Anda.</p>
                        <a href="{{ $whatsappUrl }}" class="btn btn-primary btn-block" target="_blank" rel="noopener">
                            <i class="fab fa-whatsapp"></i> Hubungi Kami
                        </a>
                    </div>
                </aside>
            </div>
        </div>
    </div>
</article>
@endsection

@push('styles')
<style>
.post-header {
    padding: calc(80px + var(--space-2xl)) 0 var(--space-xl);
    background: linear-gradient(135deg, #F8F9FA 0%, #E8E5F4 100%);
}

.post-header-content {
    max-width: 800px;
    margin: 0 auto;
    text-align: center;
}

.post-category {
    display: inline-block;
    padding: 0.5rem 1rem;
    background: var(--primary-purple);
    color: var(--white);
    border-radius: var(--radius-full);
    font-size: 0.875rem;
    font-weight: var(--font-weight-semibold);
    margin-bottom: var(--space-md);
}

.post-title {
    font-size: clamp(1.75rem, 4vw, 2.5rem);
    line-height: 1.2;
    margin-bottom: var(--space-lg);
}

.post-meta {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: var(--space-md);
    color: var(--gray-600);
    font-size: 0.9375rem;
}

.post-author {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.post-author img {
    width: 32px;
    height: 32px;
    border-radius: var(--radius-full);
}

.post-featured-image {
    margin: var(--space-xl) 0;
}

.post-featured-image img {
    width: 100%;
    max-width: 1000px;
    margin: 0 auto;
    border-radius: var(--radius-xl);
    box-shadow: var(--shadow-lg);
}

.post-content-wrapper {
    padding: var(--space-xl) 0 var(--space-3xl);
}

.post-layout {
    display: grid;
    grid-template-columns: 1fr;
    gap: var(--space-xl);
}

@media (min-width: 992px) {
    .post-layout {
        grid-template-columns: 2fr 1fr;
    }
}

.post-content.prose {
    max-width: none;
    font-size: 1.0625rem;
    line-height: 1.8;
    color: var(--gray-800);
}

.post-content.prose h2,
.post-content.prose h3,
.post-content.prose h4 {
    margin-top: var(--space-xl);
    margin-bottom: var(--space-md);
}

.post-content.prose p {
    margin-bottom: var(--space-md);
}

.post-content.prose img {
    border-radius: var(--radius-lg);
    margin: var(--space-lg) 0;
}

.post-content.prose a {
    color: var(--primary-purple);
    text-decoration: underline;
}

.post-content.prose ul,
.post-content.prose ol {
    margin-bottom: var(--space-md);
    padding-left: var(--space-lg);
}

.post-content.prose li {
    margin-bottom: 0.5rem;
}

.post-content.prose blockquote {
    border-left: 4px solid var(--primary-purple);
    padding-left: var(--space-md);
    margin: var(--space-lg) 0;
    font-style: italic;
    color: var(--gray-600);
}

.post-tags {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    gap: 0.5rem;
    margin-top: var(--space-xl);
    padding-top: var(--space-lg);
    border-top: 1px solid var(--gray-200);
}

.tags-label {
    font-weight: var(--font-weight-semibold);
}

.post-share {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    margin-top: var(--space-lg);
}

.share-label {
    font-weight: var(--font-weight-semibold);
}

.share-btn {
    width: 40px;
    height: 40px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: var(--radius-full);
    color: var(--white);
    transition: all var(--transition-base);
}

.share-btn.twitter { background: #1DA1F2; }
.share-btn.facebook { background: #4267B2; }
.share-btn.linkedin { background: #0077B5; }
.share-btn.whatsapp { background: #25D366; }

.share-btn:hover {
    transform: translateY(-3px);
    box-shadow: var(--shadow-md);
}

.author-box {
    display: flex;
    gap: var(--space-md);
    padding: var(--space-lg);
    background: var(--light-bg);
    border-radius: var(--radius-lg);
    margin-top: var(--space-xl);
}

.author-box img {
    width: 80px;
    height: 80px;
    border-radius: var(--radius-full);
}

.author-box h4 {
    margin-bottom: 0.5rem;
}

.author-box p {
    color: var(--gray-600);
    margin: 0;
}

.related-posts {
    margin-top: var(--space-xl);
}

.related-posts h3 {
    margin-bottom: var(--space-md);
}

.related-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: var(--space-md);
}

@media (max-width: 767px) {
    .related-grid {
        grid-template-columns: 1fr;
    }
}

.related-card {
    display: block;
    background: var(--white);
    border-radius: var(--radius-lg);
    overflow: hidden;
    box-shadow: var(--shadow-sm);
    transition: all var(--transition-base);
}

.related-card:hover {
    transform: translateY(-3px);
    box-shadow: var(--shadow-md);
}

.related-card img {
    width: 100%;
    height: 120px;
    object-fit: cover;
}

.related-card h4 {
    padding: var(--space-sm);
    font-size: 0.9375rem;
    color: var(--black);
}

.sticky-widget {
    position: sticky;
    top: 100px;
}

.btn-block {
    display: block;
    width: 100%;
    text-align: center;
}
</style>
@endpush
