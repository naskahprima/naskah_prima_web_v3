<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Blog categories untuk organize posts
     */
    public function up(): void
    {
        Schema::create('blog_categories', function (Blueprint $table) {
            $table->id();
            
            // Nama kategori
            $table->string('name'); // "Tips Publikasi"
            
            // Slug untuk URL
            $table->string('slug')->unique(); // "tips-publikasi"
            
            // Deskripsi kategori (untuk SEO)
            $table->text('description')->nullable();
            
            // Warna badge (optional)
            $table->string('color')->nullable(); // "#554D89"
            
            // Aktif/non-aktif
            $table->boolean('is_active')->default(true);
            
            // Urutan tampil
            $table->integer('order')->default(0);
            
            $table->timestamps();
        });

        // Seed default categories
        $this->seedDefaultCategories();
    }

    private function seedDefaultCategories(): void
    {
        $categories = [
            ['name' => 'Tips Publikasi', 'slug' => 'tips-publikasi', 'description' => 'Tips dan trik untuk sukses publikasi jurnal ilmiah', 'order' => 1],
            ['name' => 'Panduan', 'slug' => 'panduan', 'description' => 'Panduan lengkap seputar publikasi jurnal', 'order' => 2],
            ['name' => 'Case Study', 'slug' => 'case-study', 'description' => 'Studi kasus dan success story dari klien kami', 'order' => 3],
            ['name' => 'Berita Jurnal', 'slug' => 'berita-jurnal', 'description' => 'Update terbaru seputar dunia jurnal ilmiah', 'order' => 4],
            ['name' => 'Informatika', 'slug' => 'informatika', 'description' => 'Topik khusus bidang informatika dan teknologi', 'order' => 5],
        ];

        foreach ($categories as $category) {
            \DB::table('blog_categories')->insert(array_merge($category, [
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('blog_categories');
    }
};
