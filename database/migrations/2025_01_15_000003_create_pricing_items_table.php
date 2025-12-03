<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Pricing items: Harga per SINTA level untuk setiap package
     */
    public function up(): void
    {
        Schema::create('pricing_items', function (Blueprint $table) {
            $table->id();
            
            // Foreign key ke packages
            $table->foreignId('pricing_package_id')
                  ->constrained('pricing_packages')
                  ->onDelete('cascade');
            
            // SINTA level (6, 5, 4, 3, 2, 1)
            $table->string('sinta_level'); // "SINTA 6", "SINTA 5", etc.
            
            // Harga dalam Rupiah (integer, bukan decimal)
            $table->integer('price'); // 300000, 400000, etc.
            
            // Urutan tampil
            $table->integer('order')->default(0);
            
            // Aktif/non-aktif
            $table->boolean('is_active')->default(true);
            
            $table->timestamps();
            
            // Index untuk query cepat
            $table->index(['pricing_package_id', 'sinta_level']);
        });

        // Seed default items
        $this->seedDefaultItems();
    }

    private function seedDefaultItems(): void
    {
        // Get package IDs
        $basicId = \DB::table('pricing_packages')->where('slug', 'basic')->value('id');
        $premiumId = \DB::table('pricing_packages')->where('slug', 'premium')->value('id');
        $vipId = \DB::table('pricing_packages')->where('slug', 'vip-fast-track')->value('id');

        $items = [
            // Basic Package
            ['pricing_package_id' => $basicId, 'sinta_level' => 'SINTA 6', 'price' => 300000, 'order' => 1],
            ['pricing_package_id' => $basicId, 'sinta_level' => 'SINTA 5', 'price' => 400000, 'order' => 2],
            ['pricing_package_id' => $basicId, 'sinta_level' => 'SINTA 4', 'price' => 500000, 'order' => 3],
            
            // Premium Package
            ['pricing_package_id' => $premiumId, 'sinta_level' => 'SINTA 6', 'price' => 500000, 'order' => 1],
            ['pricing_package_id' => $premiumId, 'sinta_level' => 'SINTA 5', 'price' => 600000, 'order' => 2],
            ['pricing_package_id' => $premiumId, 'sinta_level' => 'SINTA 4', 'price' => 700000, 'order' => 3],
            
            // VIP Fast Track Package
            ['pricing_package_id' => $vipId, 'sinta_level' => 'SINTA 6', 'price' => 900000, 'order' => 1],
            ['pricing_package_id' => $vipId, 'sinta_level' => 'SINTA 5', 'price' => 1100000, 'order' => 2],
            ['pricing_package_id' => $vipId, 'sinta_level' => 'SINTA 4', 'price' => 1400000, 'order' => 3],
        ];

        foreach ($items as $item) {
            \DB::table('pricing_items')->insert(array_merge($item, [
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('pricing_items');
    }
};
