<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Pricing features: Fitur-fitur yang ada di setiap package
     * Contoh: "100% bayar setelah LOA", "Editing unlimited", etc.
     */
    public function up(): void
    {
        Schema::create('pricing_features', function (Blueprint $table) {
            $table->id();
            
            // Foreign key ke packages
            $table->foreignId('pricing_package_id')
                  ->constrained('pricing_packages')
                  ->onDelete('cascade');
            
            // Nama fitur
            $table->string('feature'); // "100% bayar setelah LOA"
            
            // Apakah fitur ini available di package ini?
            // true = centang hijau, false = silang merah
            $table->boolean('is_included')->default(true);
            
            // Highlight (bold) fitur ini?
            $table->boolean('is_highlighted')->default(false);
            
            // Urutan tampil
            $table->integer('order')->default(0);
            
            $table->timestamps();
        });

        // Seed default features
        $this->seedDefaultFeatures();
    }

    private function seedDefaultFeatures(): void
    {
        $basicId = \DB::table('pricing_packages')->where('slug', 'basic')->value('id');
        $premiumId = \DB::table('pricing_packages')->where('slug', 'premium')->value('id');
        $vipId = \DB::table('pricing_packages')->where('slug', 'vip-fast-track')->value('id');

        $features = [
            // Basic Package Features
            ['pricing_package_id' => $basicId, 'feature' => '100% bayar setelah LOA', 'is_included' => true, 'order' => 1],
            ['pricing_package_id' => $basicId, 'feature' => 'Editing unlimited', 'is_included' => true, 'order' => 2],
            ['pricing_package_id' => $basicId, 'feature' => 'Submit ke 1 jurnal', 'is_included' => true, 'order' => 3],
            ['pricing_package_id' => $basicId, 'feature' => 'Anti-predator guarantee', 'is_included' => true, 'order' => 4],
            ['pricing_package_id' => $basicId, 'feature' => 'Konsultasi via WhatsApp', 'is_included' => true, 'order' => 5],
            ['pricing_package_id' => $basicId, 'feature' => 'Plagiarism check', 'is_included' => false, 'order' => 6],
            ['pricing_package_id' => $basicId, 'feature' => 'Dashboard tracking', 'is_included' => false, 'order' => 7],
            
            // Premium Package Features
            ['pricing_package_id' => $premiumId, 'feature' => '100% bayar setelah LOA', 'is_included' => true, 'order' => 1],
            ['pricing_package_id' => $premiumId, 'feature' => 'Editing unlimited', 'is_included' => true, 'order' => 2],
            ['pricing_package_id' => $premiumId, 'feature' => 'Submit ke 2 jurnal', 'is_included' => true, 'order' => 3],
            ['pricing_package_id' => $premiumId, 'feature' => 'Anti-predator guarantee', 'is_included' => true, 'order' => 4],
            ['pricing_package_id' => $premiumId, 'feature' => 'Konsultasi unlimited', 'is_included' => true, 'order' => 5],
            ['pricing_package_id' => $premiumId, 'feature' => 'Plagiarism check GRATIS', 'is_included' => true, 'is_highlighted' => true, 'order' => 6],
            ['pricing_package_id' => $premiumId, 'feature' => 'Dashboard tracking', 'is_included' => true, 'order' => 7],
            
            // VIP Fast Track Features
            ['pricing_package_id' => $vipId, 'feature' => '100% bayar setelah LOA', 'is_included' => true, 'order' => 1],
            ['pricing_package_id' => $vipId, 'feature' => 'Editing unlimited', 'is_included' => true, 'order' => 2],
            ['pricing_package_id' => $vipId, 'feature' => 'Submit ke 3 jurnal', 'is_included' => true, 'order' => 3],
            ['pricing_package_id' => $vipId, 'feature' => 'Anti-predator guarantee', 'is_included' => true, 'order' => 4],
            ['pricing_package_id' => $vipId, 'feature' => 'Fast track 2-3 minggu', 'is_included' => true, 'is_highlighted' => true, 'order' => 5],
            ['pricing_package_id' => $vipId, 'feature' => 'Plagiarism check GRATIS', 'is_included' => true, 'order' => 6],
            ['pricing_package_id' => $vipId, 'feature' => 'Dashboard tracking', 'is_included' => true, 'order' => 7],
            ['pricing_package_id' => $vipId, 'feature' => 'Prioritas support 24/7', 'is_included' => true, 'order' => 8],
        ];

        foreach ($features as $feature) {
            \DB::table('pricing_features')->insert(array_merge([
                'is_highlighted' => false,
            ], $feature, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('pricing_features');
    }
};
