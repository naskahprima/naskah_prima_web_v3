<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Pricing packages: Basic, Premium, VIP Fast Track
     */
    public function up(): void
    {
        Schema::create('pricing_packages', function (Blueprint $table) {
            $table->id();
            
            // Nama paket
            $table->string('name'); // Basic, Premium, VIP Fast Track
            
            // Slug untuk URL/identifier
            $table->string('slug')->unique();
            
            // Deskripsi singkat
            $table->string('description')->nullable(); // "Cocok untuk yang budget terbatas"
            
            // Badge "PALING POPULER"
            $table->boolean('is_popular')->default(false);
            
            // Aktif/non-aktif
            $table->boolean('is_active')->default(true);
            
            // Urutan tampil
            $table->integer('order')->default(0);
            
            // Warna badge (optional, untuk customization)
            $table->string('badge_color')->nullable();
            
            $table->timestamps();
        });

        // Seed default packages
        $this->seedDefaultPackages();
    }

    private function seedDefaultPackages(): void
    {
        $packages = [
            [
                'name' => 'Basic',
                'slug' => 'basic',
                'description' => 'Cocok untuk yang budget terbatas',
                'is_popular' => false,
                'is_active' => true,
                'order' => 1,
            ],
            [
                'name' => 'Premium',
                'slug' => 'premium',
                'description' => 'Rekomendasi untuk hasil terbaik',
                'is_popular' => true,
                'is_active' => true,
                'order' => 2,
            ],
            [
                'name' => 'VIP Fast Track',
                'slug' => 'vip-fast-track',
                'description' => 'Untuk yang butuh cepat & prioritas',
                'is_popular' => false,
                'is_active' => true,
                'order' => 3,
            ],
        ];

        foreach ($packages as $package) {
            \DB::table('pricing_packages')->insert(array_merge($package, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('pricing_packages');
    }
};
