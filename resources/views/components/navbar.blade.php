<nav class="navbar" id="navbar">
    <div class="container">
        <div class="nav-wrapper">
            <a href="{{ route('home') }}" class="logo">
                <span class="logo-text">Naskah<span class="logo-highlight">Prima</span></span>
            </a>

            <button class="mobile-menu-toggle" id="mobileMenuToggle" aria-label="Toggle menu">
                <span></span>
                <span></span>
                <span></span>
            </button>

            <ul class="nav-menu" id="navMenu">
                <li><a href="{{ route('home') }}#home" class="nav-link">Beranda</a></li>
                <li><a href="{{ route('home') }}#keunggulan" class="nav-link">Keunggulan</a></li>
                <li><a href="{{ route('home') }}#paket" class="nav-link">Paket</a></li>
                <li><a href="{{ route('home') }}#testimonial" class="nav-link">Testimonial</a></li>
                <li><a href="{{ route('home') }}#faq" class="nav-link">FAQ</a></li>
                <li><a href="{{ route('blog.index') }}" class="nav-link">Blog</a></li>
                <li>
                    <a href="{{ $whatsappUrl }}" class="nav-link nav-cta-mobile">Konsultasi Gratis</a>
                </li>
            </ul>

            <a href="{{ $whatsappUrl }}" class="btn btn-primary nav-cta" target="_blank" rel="noopener">
                <i class="fab fa-whatsapp"></i> Konsultasi Gratis
            </a>
        </div>
    </div>
</nav>
