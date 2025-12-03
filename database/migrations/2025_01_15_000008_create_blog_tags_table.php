<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Blog tags untuk cross-reference posts
     */
    public function up(): void
    {
        Schema::create('blog_tags', function (Blueprint $table) {
            $table->id();
            
            // Nama tag
            $table->string('name'); // "SINTA"
            
            // Slug untuk URL
            $table->string('slug')->unique(); // "sinta"
            
            $table->timestamps();
        });

        // Seed default tags
        $this->seedDefaultTags();
    }

    private function seedDefaultTags(): void
    {
        $tags = [
            'SINTA',
            'Jurnal Predator',
            'Informatika',
            'Machine Learning',
            'Sistem Pakar',
            'Skripsi',
            'Mahasiswa',
            'LOA',
            'Peer Review',
            'Open Access',
            'SCOPUS',
            'Publikasi Ilmiah',
        ];

        foreach ($tags as $tag) {
            \DB::table('blog_tags')->insert([
                'name' => $tag,
                'slug' => \Str::slug($tag),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('blog_tags');
    }
};
