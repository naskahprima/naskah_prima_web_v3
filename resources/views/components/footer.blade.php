<footer class="footer">
    <div class="container">
        <div class="footer-content">
            <div class="footer-column">
                <h3 class="footer-logo">Naskah<span class="logo-highlight">Prima</span></h3>
                <p>Jasa publikasi jurnal SINTA untuk mahasiswa informatika dengan sistem zero risk payment. 100% bayar setelah LOA keluar.</p>
                <div class="footer-social">
                    @if(!empty($settings['instagram_url']))
                    <a href="{{ $settings['instagram_url'] }}" aria-label="Instagram" target="_blank" rel="noopener">
                        <i class="fab fa-instagram"></i>
                    </a>
                    @endif
                    @if(!empty($settings['linkedin_url']))
                    <a href="{{ $settings['linkedin_url'] }}" aria-label="LinkedIn" target="_blank" rel="noopener">
                        <i class="fab fa-linkedin"></i>
                    </a>
                    @endif
                    <a href="{{ $whatsappUrl }}" aria-label="WhatsApp" target="_blank" rel="noopener">
                        <i class="fab fa-whatsapp"></i>
                    </a>
                </div>
            </div>

            <div class="footer-column">
                <h4>Layanan</h4>
                <ul>
                    <li><a href="{{ route('home') }}#keunggulan">Keunggulan</a></li>
                    <li><a href="{{ route('home') }}#paket">Paket & Harga</a></li>
                    <li><a href="{{ route('home') }}#testimonial">Testimonial</a></li>
                    <li><a href="{{ route('home') }}#faq">FAQ</a></li>
                    <li><a href="{{ route('blog.index') }}">Blog</a></li>
                </ul>
            </div>

            <div class="footer-column">
                <h4>Kontak</h4>
                <ul>
                    @if(!empty($settings['whatsapp_number']))
                    <li>
                        <i class="fab fa-whatsapp"></i> 
                        +{{ substr($settings['whatsapp_number'], 0, 2) }} {{ substr($settings['whatsapp_number'], 2, 3) }}-{{ substr($settings['whatsapp_number'], 5, 4) }}-{{ substr($settings['whatsapp_number'], 9) }}
                    </li>
                    @endif
                    @if(!empty($settings['email']))
                    <li><i class="fas fa-envelope"></i> {{ $settings['email'] }}</li>
                    @endif
                    <li><i class="fas fa-map-marker-alt"></i> Indonesia</li>
                </ul>
            </div>

            <div class="footer-column">
                <h4>Trust & Security</h4>
                <div class="footer-badges">
                    <div class="trust-badge">
                        <i class="fas fa-shield-alt"></i>
                        <span>{{ $stats['success_rate'] ?? '95' }}% Success Rate</span>
                    </div>
                    <div class="trust-badge">
                        <i class="fas fa-lock"></i>
                        <span>Zero Risk Payment</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="footer-bottom">
            <p>&copy; {{ date('Y') }} {{ $settings['site_name'] ?? 'Naskah Prima' }}. All rights reserved.</p>
            <div class="footer-links">
                <a href="#">Privacy Policy</a>
                <a href="#">Terms of Service</a>
            </div>
        </div>
    </div>
</footer>
