@extends('layouts.app')

@section('title', 'Blog - ' . ($settings['site_name'] ?? 'Naskah Prima'))

@section('meta_description', 'Tips, panduan, dan informasi seputar publikasi jurnal ilmiah SINTA untuk mahasiswa informatika.')

@section('content')
<!-- Blog Header -->
<section class="blog-header">
    <div class="container">
        <div class="section-header text-center">
            <h1 class="section-title">
                Blog <span class="gradient-text">Naskah Prima</span>
            </h1>
            <p class="section-description">
                Tips, panduan, dan informasi seputar publikasi jurnal ilmiah untuk mahasiswa informatika.
            </p>
        </div>
    </div>
</section>

<!-- Blog Content -->
<section class="blog-section">
    <div class="container">
        <div class="blog-layout">
            <!-- Main Content -->
            <div class="blog-main">
                @if($posts->count() > 0)
                <div class="blog-grid">
                    @foreach($posts as $post)
                    <article class="blog-card">
                        @if($post->featured_image)
                        <a href="{{ route('blog.show', $post->slug) }}" class="blog-card-image">
                            <img src="{{ $post->featured_image_url }}" alt="{{ $post->featured_image_alt ?? $post->title }}" loading="lazy">
                        </a>
                        @endif
                        
                        <div class="blog-card-content">
                            @if($post->category)
                            <a href="{{ route('blog.category', $post->category->slug) }}" class="blog-card-category">
                                {{ $post->category->name }}
                            </a>
                            @endif
                            
                            <h2 class="blog-card-title">
                                <a href="{{ route('blog.show', $post->slug) }}">{{ $post->title }}</a>
                            </h2>
                            
                            <p class="blog-card-excerpt">
                                {{ $post->excerpt ?? Str::limit(strip_tags($post->content), 150) }}
                            </p>
                            
                            <div class="blog-card-meta">
                                <span class="blog-card-date">
                                    <i class="far fa-calendar"></i> {{ $post->formatted_date }}
                                </span>
                                <span class="blog-card-reading">
                                    <i class="far fa-clock"></i> {{ $post->reading_time }} menit baca
                                </span>
                            </div>
                        </div>
                    </article>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="blog-pagination">
                    {{ $posts->links() }}
                </div>
                @else
                <div class="blog-empty">
                    <i class="fas fa-file-alt"></i>
                    <h3>Belum Ada Artikel</h3>
                    <p>Artikel blog akan segera hadir. Stay tuned!</p>
                </div>
                @endif
            </div>

            <!-- Sidebar -->
            <aside class="blog-sidebar">
                <!-- Categories -->
                <div class="sidebar-widget">
                    <h3 class="widget-title">Kategori</h3>
                    <ul class="category-list">
                        @foreach($categories as $category)
                        <li>
                            <a href="{{ route('blog.category', $category->slug) }}">
                                {{ $category->name }}
                                <span class="count">{{ $category->published_posts_count }}</span>
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div>

                <!-- Popular Tags -->
                @if($popularTags->count() > 0)
                <div class="sidebar-widget">
                    <h3 class="widget-title">Tags Populer</h3>
                    <div class="tag-cloud">
                        @foreach($popularTags as $tag)
                        <a href="{{ route('blog.tag', $tag->slug) }}" class="tag-item">
                            {{ $tag->name }}
                        </a>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- CTA Widget -->
                <div class="sidebar-widget cta-widget">
                    <h3>Butuh Bantuan Publikasi?</h3>
                    <p>Konsultasi gratis dengan tim kami sekarang!</p>
                    <a href="{{ $whatsappUrl }}" class="btn btn-primary btn-sm" target="_blank" rel="noopener">
                        <i class="fab fa-whatsapp"></i> Hubungi Kami
                    </a>
                </div>
            </aside>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
.blog-header {
    padding: calc(80px + var(--space-2xl)) 0 var(--space-xl);
    background: linear-gradient(135deg, #F8F9FA 0%, #E8E5F4 100%);
}

.blog-section {
    padding: var(--space-2xl) 0 var(--space-3xl);
}

.blog-layout {
    display: grid;
    grid-template-columns: 1fr;
    gap: var(--space-xl);
}

@media (min-width: 992px) {
    .blog-layout {
        grid-template-columns: 2fr 1fr;
    }
}

.blog-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: var(--space-lg);
}

@media (min-width: 768px) {
    .blog-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

.blog-card {
    background: var(--white);
    border-radius: var(--radius-lg);
    overflow: hidden;
    box-shadow: var(--shadow-md);
    transition: all var(--transition-base);
}

.blog-card:hover {
    transform: translateY(-5px);
    box-shadow: var(--shadow-xl);
}

.blog-card-image {
    display: block;
    aspect-ratio: 16/9;
    overflow: hidden;
}

.blog-card-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform var(--transition-base);
}

.blog-card:hover .blog-card-image img {
    transform: scale(1.05);
}

.blog-card-content {
    padding: var(--space-md);
}

.blog-card-category {
    display: inline-block;
    padding: 0.25rem 0.75rem;
    background: rgba(85, 77, 137, 0.1);
    color: var(--primary-purple);
    border-radius: var(--radius-full);
    font-size: 0.75rem;
    font-weight: var(--font-weight-semibold);
    margin-bottom: var(--space-sm);
}

.blog-card-title {
    font-size: 1.25rem;
    margin-bottom: var(--space-sm);
    line-height: 1.3;
}

.blog-card-title a {
    color: var(--black);
}

.blog-card-title a:hover {
    color: var(--primary-purple);
}

.blog-card-excerpt {
    color: var(--gray-600);
    font-size: 0.9375rem;
    margin-bottom: var(--space-sm);
}

.blog-card-meta {
    display: flex;
    gap: var(--space-md);
    font-size: 0.875rem;
    color: var(--gray-600);
}

.blog-card-meta i {
    margin-right: 0.25rem;
}

/* Sidebar */
.sidebar-widget {
    background: var(--white);
    border-radius: var(--radius-lg);
    padding: var(--space-md);
    margin-bottom: var(--space-lg);
    box-shadow: var(--shadow-sm);
}

.widget-title {
    font-size: 1.125rem;
    margin-bottom: var(--space-md);
    padding-bottom: var(--space-sm);
    border-bottom: 2px solid var(--primary-purple);
}

.category-list {
    list-style: none;
}

.category-list li {
    margin-bottom: 0.5rem;
}

.category-list a {
    display: flex;
    justify-content: space-between;
    align-items: center;
    color: var(--gray-800);
    padding: 0.5rem 0;
    border-bottom: 1px solid var(--gray-100);
}

.category-list a:hover {
    color: var(--primary-purple);
}

.category-list .count {
    background: var(--gray-100);
    padding: 0.125rem 0.5rem;
    border-radius: var(--radius-full);
    font-size: 0.75rem;
}

.tag-cloud {
    display: flex;
    flex-wrap: wrap;
    gap: 0.5rem;
}

.tag-item {
    display: inline-block;
    padding: 0.25rem 0.75rem;
    background: var(--gray-100);
    color: var(--gray-800);
    border-radius: var(--radius-full);
    font-size: 0.875rem;
    transition: all var(--transition-fast);
}

.tag-item:hover {
    background: var(--primary-purple);
    color: var(--white);
}

.cta-widget {
    background: var(--gradient-primary);
    color: var(--white);
    text-align: center;
}

.cta-widget h3 {
    color: var(--white);
    margin-bottom: var(--space-sm);
}

.cta-widget p {
    opacity: 0.9;
    margin-bottom: var(--space-md);
}

.blog-empty {
    text-align: center;
    padding: var(--space-3xl);
    color: var(--gray-600);
}

.blog-empty i {
    font-size: 4rem;
    margin-bottom: var(--space-md);
    opacity: 0.3;
}

.blog-pagination {
    margin-top: var(--space-xl);
}
</style>
@endpush
