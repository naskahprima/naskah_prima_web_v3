<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Blog posts - artikel utama
     */
    public function up(): void
    {
        Schema::create('blog_posts', function (Blueprint $table) {
            $table->id();
            
            // Author (foreign key ke users)
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->onDelete('cascade');
            
            // Category (foreign key ke blog_categories)
            $table->foreignId('blog_category_id')
                  ->nullable()
                  ->constrained('blog_categories')
                  ->onDelete('set null');
            
            // === CONTENT ===
            $table->string('title'); // "Cara Cek Jurnal Predator dalam 30 Detik"
            $table->string('slug')->unique(); // "cara-cek-jurnal-predator-30-detik"
            $table->text('excerpt')->nullable(); // Ringkasan untuk preview
            $table->longText('content'); // Isi artikel (HTML/Markdown)
            
            // === MEDIA ===
            $table->string('featured_image')->nullable(); // Path ke gambar utama
            $table->string('featured_image_alt')->nullable(); // Alt text untuk SEO
            
            // === SEO FIELDS ===
            $table->string('meta_title')->nullable(); // Custom title untuk SEO (max 60 char)
            $table->text('meta_description')->nullable(); // Custom description (max 160 char)
            $table->string('meta_keywords')->nullable(); // Keywords dipisah koma
            $table->string('og_image')->nullable(); // Open Graph image (optional, default ke featured_image)
            
            // === PUBLISHING ===
            $table->enum('status', ['draft', 'scheduled', 'published'])->default('draft');
            $table->timestamp('published_at')->nullable(); // Waktu publish (untuk scheduling)
            
            // === STATS ===
            $table->unsignedInteger('view_count')->default(0);
            $table->unsignedInteger('reading_time')->default(0); // Estimasi menit baca
            
            // === FLAGS ===
            $table->boolean('is_featured')->default(false); // Tampil di homepage
            $table->boolean('allow_comments')->default(true);
            
            $table->timestamps();
            
            // Indexes
            $table->index('status');
            $table->index('published_at');
            $table->index(['status', 'published_at']); // Untuk query published posts
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('blog_posts');
    }
};
