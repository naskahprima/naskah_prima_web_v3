<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Setting;
use App\Models\PricingPackage;
use App\Models\Testimonial;
use App\Models\Faq;
use App\Models\Client;
use App\Models\MitraJurnal;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LandingPageTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Create default settings
        Setting::create(['key' => 'site_name', 'value' => 'Naskah Prima', 'group' => 'general', 'type' => 'text']);
        Setting::create(['key' => 'whatsapp_number', 'value' => '6281234567890', 'group' => 'contact', 'type' => 'text']);
        Setting::create(['key' => 'hero_title', 'value' => 'Publikasi Jurnal SINTA', 'group' => 'hero', 'type' => 'text']);
    }

    /** @test */
    public function landing_page_returns_200()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    /** @test */
    public function landing_page_shows_hero_title()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('Publikasi Jurnal SINTA');
    }

    /** @test */
    public function landing_page_shows_pricing_packages()
    {
        $package = PricingPackage::create([
            'name' => 'Basic',
            'slug' => 'basic',
            'description' => 'Paket dasar',
            'is_popular' => false,
            'is_active' => true,
            'order' => 1,
        ]);

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('Basic');
    }

    /** @test */
    public function landing_page_shows_testimonials()
    {
        $testimonial = Testimonial::create([
            'client_name' => 'Ahmad Rizky',
            'client_role' => 'Mahasiswa S2',
            'university' => 'Universitas Indonesia',
            'quote' => 'Pelayanan sangat profesional!',
            'rating' => 5,
            'is_featured' => true,
            'order' => 1,
        ]);

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('Ahmad Rizky');
        $response->assertSee('Pelayanan sangat profesional!');
    }

    /** @test */
    public function landing_page_shows_faqs()
    {
        $faq = Faq::create([
            'question' => 'Bagaimana sistem pembayaran?',
            'answer' => 'Pembayaran dilakukan setelah LOA keluar.',
            'category' => 'Pembayaran',
            'is_active' => true,
            'order' => 1,
        ]);

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('Bagaimana sistem pembayaran?');
    }

    /** @test */
    public function landing_page_shows_dynamic_client_count()
    {
        // Create 5 clients
        for ($i = 1; $i <= 5; $i++) {
            Client::create([
                'nama_lengkap' => "Client $i",
                'email' => "client$i@example.com",
                'no_whatsapp' => "0812345678$i",
            ]);
        }

        $response = $this->get('/');

        $response->assertStatus(200);
        // Should show 25+ (20 legacy + 5 new)
        $response->assertSee('25');
    }

    /** @test */
    public function landing_page_shows_dynamic_journal_count()
    {
        // Create active journals
        for ($i = 1; $i <= 10; $i++) {
            MitraJurnal::create([
                'nama_jurnal' => "Jurnal $i",
                'peringkat_sinta' => 'SINTA 5',
                'status_kerjasama' => 'aktif',
            ]);
        }

        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('10');
    }

    /** @test */
    public function landing_page_has_whatsapp_button()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('wa.me');
    }

    /** @test */
    public function landing_page_has_navigation()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
        $response->assertSee('Beranda');
        $response->assertSee('Blog');
        $response->assertSee('FAQ');
    }
}
