<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Pivot table untuk relasi many-to-many antara posts dan tags
     */
    public function up(): void
    {
        Schema::create('blog_post_tag', function (Blueprint $table) {
            $table->id();
            
            $table->foreignId('blog_post_id')
                  ->constrained('blog_posts')
                  ->onDelete('cascade');
            
            $table->foreignId('blog_tag_id')
                  ->constrained('blog_tags')
                  ->onDelete('cascade');
            
            $table->timestamps();
            
            // Unique constraint untuk mencegah duplikat
            $table->unique(['blog_post_id', 'blog_tag_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('blog_post_tag');
    }
};
