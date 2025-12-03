<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Settings table untuk menyimpan konten landing page
     * Struktur key-value yang flexible
     */
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            
            // Group untuk kategorisasi settings (contact, hero, social, branding)
            $table->string('group')->default('general');
            
            // Key unik untuk setiap setting
            $table->string('key')->unique();
            
            // Value bisa text panjang (untuk description, dll)
            $table->text('value')->nullable();
            
            // Type untuk validasi di frontend (text, textarea, image, url, email, phone)
            $table->string('type')->default('text');
            
            // Label yang ditampilkan di admin panel
            $table->string('label')->nullable();
            
            // Urutan tampil di admin
            $table->integer('order')->default(0);
            
            $table->timestamps();
            
            // Index untuk query cepat berdasarkan group
            $table->index('group');
        });

        // Insert default settings
        $this->seedDefaultSettings();
    }

    /**
     * Seed default settings untuk landing page
     */
    private function seedDefaultSettings(): void
    {
        $settings = [
            // === CONTACT INFO ===
            [
                'group' => 'contact',
                'key' => 'whatsapp_number',
                'value' => '6281234567890',
                'type' => 'phone',
                'label' => 'Nomor WhatsApp',
                'order' => 1,
            ],
            [
                'group' => 'contact',
                'key' => 'email',
                'value' => 'hello@naskahprima.com',
                'type' => 'email',
                'label' => 'Email',
                'order' => 2,
            ],
            [
                'group' => 'contact',
                'key' => 'instagram_url',
                'value' => 'https://instagram.com/naskahprima',
                'type' => 'url',
                'label' => 'Instagram URL',
                'order' => 3,
            ],
            [
                'group' => 'contact',
                'key' => 'linkedin_url',
                'value' => 'https://linkedin.com/company/naskahprima',
                'type' => 'url',
                'label' => 'LinkedIn URL',
                'order' => 4,
            ],
            
            // === HERO SECTION ===
            [
                'group' => 'hero',
                'key' => 'hero_title',
                'value' => 'Publikasi Jurnal SINTA Informatika',
                'type' => 'text',
                'label' => 'Hero Title',
                'order' => 1,
            ],
            [
                'group' => 'hero',
                'key' => 'hero_title_highlight',
                'value' => 'Tanpa Risiko Penipuan',
                'type' => 'text',
                'label' => 'Hero Title (Highlight/Gradient)',
                'order' => 2,
            ],
            [
                'group' => 'hero',
                'key' => 'hero_description',
                'value' => '100% bayar SETELAH LOA keluar. Harga 50-90% lebih murah dari kompetitor. Editor spesialis informatika yang paham teknis penelitian Anda. Anti-predator guarantee.',
                'type' => 'textarea',
                'label' => 'Hero Description',
                'order' => 3,
            ],
            [
                'group' => 'hero',
                'key' => 'hero_badge_text',
                'value' => '95% Success Rate | 18 Hari Rata-rata',
                'type' => 'text',
                'label' => 'Hero Badge Text',
                'order' => 4,
            ],
            [
                'group' => 'hero',
                'key' => 'hero_cta_text',
                'value' => 'Konsultasi Gratis Sekarang',
                'type' => 'text',
                'label' => 'Hero CTA Button Text',
                'order' => 5,
            ],
            
            // === BRANDING ===
            [
                'group' => 'branding',
                'key' => 'site_name',
                'value' => 'Naskah Prima',
                'type' => 'text',
                'label' => 'Nama Website',
                'order' => 1,
            ],
            [
                'group' => 'branding',
                'key' => 'tagline',
                'value' => 'Zero Risk Payment - 100% Bayar Setelah LOA Keluar',
                'type' => 'text',
                'label' => 'Tagline',
                'order' => 2,
            ],
            [
                'group' => 'branding',
                'key' => 'meta_description',
                'value' => 'Jasa publikasi jurnal SINTA untuk mahasiswa informatika. 100% bayar SETELAH LOA keluar. Harga 50-90% lebih murah. Editor spesialis informatika. Mulai dari Rp 300rb.',
                'type' => 'textarea',
                'label' => 'Meta Description (SEO)',
                'order' => 3,
            ],
        ];

        foreach ($settings as $setting) {
            \DB::table('settings')->insert(array_merge($setting, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
