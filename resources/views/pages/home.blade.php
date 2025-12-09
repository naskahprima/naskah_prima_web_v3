@extends('layouts.app')

@section('title', $settings['site_name'] ?? 'Naskah Prima')

@section('schema')
<script type="application/ld+json">
{
    "@context": "https://schema.org",
    "@type": "ProfessionalService",
    "name": "{{ $settings['site_name'] ?? 'Naskah Prima' }}",
    "description": "{{ $settings['meta_description'] ?? 'Jasa publikasi jurnal SINTA untuk mahasiswa informatika' }}",
    "url": "{{ url('/') }}",
    "priceRange": "Rp 300.000 - Rp 1.400.000",
    "address": {
        "@type": "PostalAddress",
        "addressCountry": "ID"
    },
    "aggregateRating": {
        "@type": "AggregateRating",
        "ratingValue": "4.9",
        "reviewCount": "{{ $stats['total_clients'] ?? 3 }}"
    }
}
</script>
@endsection

@section('content')
<!-- Hero Section -->
<section class="hero" id="home">
    <div class="container">
        <div class="hero-content">
            <div class="hero-text">
                <div class="hero-badge">
                    <i class="fas fa-shield-alt"></i>
                    <span>{{ $settings['hero_badge_text'] ?? '95% Success Rate | 18 Hari Rata-rata' }}</span>
                </div>
                <h1 class="hero-title">
                    {{ $settings['hero_title'] ?? 'Publikasi Jurnal SINTA Informatika' }}
                    <span class="gradient-text">{{ $settings['hero_title_highlight'] ?? 'Tanpa Risiko Penipuan' }}</span>
                </h1>
                <p class="hero-description">
                    <strong>100% bayar SETELAH LOA keluar.</strong> {{ $settings['hero_description'] ?? 'Harga 50-90% lebih murah dari kompetitor. Editor spesialis informatika yang paham teknis penelitian Anda. Anti-predator guarantee.' }}
                </p>

                <div class="hero-features">
                    <div class="hero-feature">
                        <i class="fas fa-check-circle"></i>
                        <span>Zero DP - Bayar Setelah LOA</span>
                    </div>
                    <div class="hero-feature">
                        <i class="fas fa-check-circle"></i>
                        <span>Mulai Rp 300rb (50-90% Lebih Murah)</span>
                    </div>
                    <div class="hero-feature">
                        <i class="fas fa-check-circle"></i>
                        <span>Editor Spesialis Informatika</span>
                    </div>
                </div>

                <div class="hero-cta">
                    <a href="{{ $whatsappUrl }}" class="btn btn-primary btn-lg pulse-animation" target="_blank" rel="noopener">
                        <i class="fab fa-whatsapp"></i> {{ $settings['hero_cta_text'] ?? 'Konsultasi Gratis Sekarang' }}
                    </a>
                    <a href="#paket" class="btn btn-secondary btn-lg">
                        <i class="fas fa-tag"></i> Lihat Paket & Harga
                    </a>
                </div>

                <div class="hero-trust">
                    <div class="trust-item">
                        <strong>{{ $stats['total_clients'] ?? '3' }}+</strong>
                        <span>Klien Sukses</span>
                    </div>
                    <div class="trust-item">
                        <strong>{{ $stats['success_rate'] ?? '95' }}%</strong>
                        <span>Success Rate</span>
                    </div>
                    <div class="trust-item">
                        <strong>{{ $stats['active_journals'] ?? '17' }}</strong>
                        <span>Mitra Jurnal</span>
                    </div>
                </div>
            </div>

            <div class="hero-image">
                <img src="{{ asset('assets/hero-illustration.png') }}" alt="Ilustrasi publikasi jurnal ilmiah"  width="600" height="500" loading="lazy" >
            </div>
        </div>
    </div>

    <div class="scroll-indicator">
        <a href="#problem" aria-label="Scroll to next section">
            <i class="fas fa-chevron-down"></i>
        </a>
    </div>
</section>

<!-- Problem Section -->
<section class="problem-section" id="problem">
    <div class="container">
        <div class="section-header text-center">
            <h2 class="section-title">
                Takut Kena <span class="gradient-text">Scam atau Jurnal Predator?</span>
            </h2>
            <p class="section-description">
                Kami paham kekhawatiran Anda. Banyak jasa publikasi yang tidak transparan dan berisiko.
            </p>
        </div>

        <div class="problem-grid">
            <div class="problem-card">
                <div class="problem-icon red"><i class="fas fa-exclamation-triangle"></i></div>
                <h3>Harus Bayar DP 50%</h3>
                <p>Kompetitor meminta DP 50% tanpa jaminan. Jika gagal, uang tidak kembali.</p>
            </div>
            <div class="problem-card">
                <div class="problem-icon red"><i class="fas fa-user-secret"></i></div>
                <h3>Takut Scam & Penipuan</h3>
                <p>Banyak jasa yang hilang setelah terima uang, atau tidak ada portfolio jelas.</p>
            </div>
            <div class="problem-card">
                <div class="problem-icon red"><i class="fas fa-skull-crossbones"></i></div>
                <h3>Jurnal Predator</h3>
                <p>Khawatir naskah disubmit ke jurnal abal-abal yang tidak kredibel.</p>
            </div>
            <div class="problem-card">
                <div class="problem-icon red"><i class="fas fa-money-bill-wave"></i></div>
                <h3>Harga Mahal</h3>
                <p>Kompetitor charge Rp 500rb - 7 juta. Terlalu mahal untuk mahasiswa.</p>
            </div>
            <div class="problem-card">
                <div class="problem-icon red"><i class="fas fa-clock"></i></div>
                <h3>Timeline Tidak Jelas</h3>
                <p>Proses berlarut-larut tanpa update progress yang transparan.</p>
            </div>
            <div class="problem-card">
                <div class="problem-icon red"><i class="fas fa-user-slash"></i></div>
                <h3>Editor Tidak Paham Teknis</h3>
                <p>Editor generalist yang tidak mengerti algoritma, ML, atau sistem pakar.</p>
            </div>
        </div>
    </div>
</section>

<!-- Solution Section -->
<section class="solution-section" id="keunggulan">
    <div class="container">
        <div class="section-header text-center">
            <h2 class="section-title">
                Kenapa <span class="gradient-text">Naskah Prima</span> Berbeda?
            </h2>
            <p class="section-description">
                Kami adalah satu-satunya jasa publikasi dengan sistem zero risk payment dan editor spesialis informatika.
            </p>
        </div>

        <div class="solution-grid">
            <div class="solution-card highlight">
                <div class="solution-icon purple"><i class="fas fa-shield-alt"></i></div>
                <h3>Zero Risk Payment</h3>
                <p><strong>100% bayar SETELAH LOA keluar.</strong> Tidak ada DP, tidak ada risiko.</p>
                <div class="solution-badge">Keunggulan Utama</div>
            </div>
            <div class="solution-card highlight">
                <div class="solution-icon purple"><i class="fas fa-tags"></i></div>
                <h3>50-90% Lebih Murah</h3>
                <p>Mulai dari <strong>Rp 300rb</strong> (SINTA 6). Kompetitor charge Rp 500rb-7jt.</p>
                <div class="solution-badge">Best Value</div>
            </div>
            <div class="solution-card">
                <div class="solution-icon purple"><i class="fas fa-laptop-code"></i></div>
                <h3>Editor Spesialis Informatika</h3>
                <p>Tim kami dari background informatika. Paham algoritma, machine learning, sistem pakar.</p>
            </div>
            <div class="solution-card">
                <div class="solution-icon purple"><i class="fas fa-eye"></i></div>
                <h3>Transparan & Anti-Predator</h3>
                <p>Full disclosure jurnal yang akan disubmit. Semua jurnal terindeks SINTA.</p>
            </div>
            <div class="solution-card">
                <div class="solution-icon purple"><i class="fas fa-search"></i></div>
                <h3>Plagiarism Check GRATIS</h3>
                <p>Kompetitor charge Rp 50-100rb terpisah. Kami include gratis di Premium & VIP.</p>
            </div>
            <div class="solution-card">
                <div class="solution-icon purple"><i class="fas fa-tachometer-alt"></i></div>
                <h3>Dashboard Tracking Real-Time</h3>
                <p>Akses dashboard untuk monitor progress publikasi Anda kapan saja.</p>
            </div>
        </div>
    </div>
</section>

<!-- Stats Section - REAL TIME DATA -->
<section class="stats-section">
    <div class="container">
        <div class="stats-grid">
            <div class="stat-card">
                <i class="fas fa-users"></i>
                <div class="stat-number">{{ $stats['total_clients'] ?? '3' }}+</div>
                <div class="stat-label">Klien Selesai</div>
            </div>
            <div class="stat-card">
                <i class="fas fa-percentage"></i>
                <div class="stat-number">{{ $stats['success_rate'] ?? '95' }}%</div>
                <div class="stat-label">Success Rate</div>
            </div>
            <div class="stat-card">
                <i class="fas fa-calendar-check"></i>
                <div class="stat-number">{{ $stats['avg_days'] ?? '18' }} Hari</div>
                <div class="stat-label">Rata-rata Proses</div>
            </div>
            <div class="stat-card">
                <i class="fas fa-book"></i>
                <div class="stat-number">{{ $stats['active_journals'] ?? '17' }}</div>
                <div class="stat-label">Mitra Jurnal Aktif</div>
            </div>
        </div>
    </div>
</section>

<!-- Pricing Section - FROM DATABASE -->
<section class="pricing-section" id="paket">
    <div class="container">
        <div class="section-header text-center">
            <h2 class="section-title">
                Paket & <span class="gradient-text">Harga Transparan</span>
            </h2>
            <p class="section-description">
                Pilih paket sesuai kebutuhan Anda. Semua paket 100% bayar setelah LOA keluar.
            </p>
        </div>

        <div class="pricing-grid">
            @foreach($packages as $package)
            <div class="pricing-card {{ $package->is_popular ? 'popular' : '' }}">
                @if($package->is_popular)
                <div class="popular-badge">PALING POPULER</div>
                @endif
                
                <div class="pricing-header">
                    <h3>{{ $package->name }}</h3>
                    <p>{{ $package->description }}</p>
                </div>
                
                <div class="pricing-body">
                    <div class="pricing-options">
                        @foreach($package->items as $item)
                        <div class="pricing-option">
                            <div class="pricing-level">{{ $item->sinta_level }}</div>
                            <div class="pricing-price">{{ $item->formatted_price }}</div>
                        </div>
                        @endforeach
                    </div>
                    
                    <ul class="pricing-features">
                        @foreach($package->features as $feature)
                        <li class="{{ !$feature->is_included ? 'disabled' : '' }}">
                            <i class="fas fa-{{ $feature->is_included ? 'check' : 'times' }}"></i>
                            @if($feature->is_highlighted)
                            <strong>{{ $feature->feature }}</strong>
                            @else
                            {{ $feature->feature }}
                            @endif
                        </li>
                        @endforeach
                    </ul>
                </div>
                
                <div class="pricing-footer">
                    <a href="{{ $whatsappUrl }}?text=Halo,%20saya%20tertarik%20dengan%20Paket%20{{ urlencode($package->name) }}" 
                       class="btn {{ $package->is_popular ? 'btn-primary' : 'btn-outline' }}" 
                       target="_blank" rel="noopener">
                        Pilih Paket
                    </a>
                </div>
            </div>
            @endforeach
        </div>

        <div class="pricing-note">
            <p><i class="fas fa-info-circle"></i> <strong>Catatan:</strong> Semua paket sudah termasuk author fee ke jurnal. Tidak ada biaya tersembunyi.</p>
        </div>
    </div>
</section>

<!-- Testimonial Section - FROM DATABASE -->
<section class="testimonial-section" id="testimonial">
    <div class="container">
        <div class="section-header text-center">
            <h2 class="section-title">
                Apa Kata <span class="gradient-text">Klien Kami?</span>
            </h2>
            <p class="section-description">
                Testimoni dari mahasiswa informatika yang sudah berhasil publikasi bersama Naskah Prima.
            </p>
        </div>

        <div class="testimonial-grid">
            @foreach($testimonials as $testimonial)
            <div class="testimonial-card">
                <div class="testimonial-rating">
                    @for($i = 1; $i <= 5; $i++)
                    <i class="fas fa-star{{ $i <= $testimonial->rating ? '' : '-o' }}"></i>
                    @endfor
                </div>
                <p class="testimonial-text">"{{ $testimonial->quote }}"</p>
                <div class="testimonial-author">
                    <div class="author-avatar">
                        <img src="{{ $testimonial->photo_url }}" alt="{{ $testimonial->client_name }}" loading="lazy" width="60" height="60">
                    </div>
                    <div class="author-info">
                        <h4>{{ $testimonial->client_name }}</h4>
                        <p>{{ $testimonial->client_role }}</p>
                        <span class="author-meta">{{ $testimonial->meta_info }}</span>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="testimonial-cta text-center">
            <p>Ingin hasil yang sama? <a href="{{ $whatsappUrl }}" target="_blank" rel="noopener">Konsultasi gratis sekarang <i class="fas fa-arrow-right"></i></a></p>
        </div>
    </div>
</section>

<!-- Process Section -->
<section class="process-section">
    <div class="container">
        <div class="section-header text-center">
            <h2 class="section-title">
                Bagaimana <span class="gradient-text">Prosesnya?</span>
            </h2>
            <p class="section-description">4 langkah mudah untuk publikasi jurnal Anda</p>
        </div>

        <div class="process-grid">
            <div class="process-card">
                <div class="process-number">1</div>
                <div class="process-icon"><i class="fab fa-whatsapp"></i></div>
                <h3>Konsultasi Gratis</h3>
                <p>Hubungi kami via WhatsApp. Ceritakan topik penelitian dan deadline Anda.</p>
            </div>
            <div class="process-card">
                <div class="process-number">2</div>
                <div class="process-icon"><i class="fas fa-file-upload"></i></div>
                <h3>Kirim Naskah</h3>
                <p>Kirim draft naskah Anda. Kami akan review dan memberikan rekomendasi jurnal.</p>
            </div>
            <div class="process-card">
                <div class="process-number">3</div>
                <div class="process-icon"><i class="fas fa-edit"></i></div>
                <h3>Editing & Submit</h3>
                <p>Tim kami akan edit naskah dan submit ke jurnal. Monitor progress via dashboard.</p>
            </div>
            <div class="process-card">
                <div class="process-number">4</div>
                <div class="process-icon"><i class="fas fa-check-circle"></i></div>
                <h3>LOA Keluar, Baru Bayar</h3>
                <p>Setelah LOA keluar, baru lakukan pembayaran. Zero risk, zero DP!</p>
            </div>
        </div>
    </div>
</section>

<!-- FAQ Section - FROM DATABASE -->
<section class="faq-section" id="faq">
    <div class="container">
        <div class="section-header text-center">
            <h2 class="section-title">
                Pertanyaan <span class="gradient-text">yang Sering Ditanya</span>
            </h2>
            <p class="section-description">Temukan jawaban untuk pertanyaan Anda</p>
        </div>

        <div class="faq-container">
            @foreach($faqs as $faq)
            <div class="faq-item">
                <button class="faq-question" type="button">
                    <span>{{ $faq->question }}</span>
                    <i class="fas fa-chevron-down"></i>
                </button>
                <div class="faq-answer">
                    <p>{!! $faq->answer !!}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="cta-section">
    <div class="container">
        <div class="cta-content">
            <h2>Siap Publikasi Jurnal <span class="gradient-text">Tanpa Risiko?</span></h2>
            <p>Bergabung dengan {{ $stats['total_clients'] ?? '3' }}+ mahasiswa informatika yang sudah berhasil publikasi bersama Naskah Prima.</p>
            <a href="{{ $whatsappUrl }}" class="btn btn-primary btn-lg pulse-animation" target="_blank" rel="noopener">
                <i class="fab fa-whatsapp"></i> Mulai Konsultasi Gratis
            </a>
            <p class="cta-subtext">Atau lihat <a href="#paket">paket & harga</a> terlebih dahulu</p>
        </div>
    </div>
</section>


<!-- Blog Section -->
<section class="blog-home-section" id="blog">
    <div class="container">
        <div class="section-header text-center">
            <h2 class="section-title">
                Artikel <span class="gradient-text">Terbaru</span>
            </h2>
            <p class="section-description">
                Tips dan panduan seputar publikasi jurnal ilmiah untuk mahasiswa informatika
            </p>
        </div>
        
        @if($latestPosts->count() > 0)
        <div class="blog-home-grid">
            @foreach($latestPosts as $post)
            <article class="blog-home-card">
                <a href="{{ route('blog.show', $post->slug) }}" class="blog-home-image">
                    @if($post->featured_image)
                    <img src="{{ Storage::url($post->featured_image) }}" 
                         alt="{{ $post->title }}" 
                         loading="lazy">
                    @else
                    <div class="blog-home-placeholder">
                        <i class="fas fa-newspaper"></i>
                    </div>
                    @endif
                </a>
                
                <div class="blog-home-content">
                    @if($post->category)
                    <a href="{{ route('blog.category', $post->category->slug) }}" class="blog-home-category">
                        {{ $post->category->name }}
                    </a>
                    @endif
                    
                    <h3 class="blog-home-title">
                        <a href="{{ route('blog.show', $post->slug) }}">{{ $post->title }}</a>
                    </h3>
                    
                    <p class="blog-home-excerpt">
                        {{ $post->excerpt ?? Str::limit(strip_tags($post->content), 100) }}
                    </p>
                    
                    <div class="blog-home-meta">
                        <span><i class="far fa-calendar"></i> {{ $post->published_at->format('d M Y') }}</span>
                        <span><i class="far fa-clock"></i> {{ $post->reading_time ?? '5' }} min</span>
                    </div>
                </div>
            </article>
            @endforeach
        </div>
        
        <div class="blog-home-cta">
            <a href="{{ route('blog.index') }}" class="btn btn-outline">
                Lihat Semua Artikel <i class="fas fa-arrow-right"></i>
            </a>
        </div>
        @else
        <div class="blog-home-empty">
            <i class="fas fa-file-alt"></i>
            <p>Artikel blog akan segera hadir. Stay tuned!</p>
        </div>
        @endif
    </div>
</section>
@endsection
