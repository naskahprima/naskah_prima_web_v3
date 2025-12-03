<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Testimonials dari klien yang sudah publikasi
     */
    public function up(): void
    {
        Schema::create('testimonials', function (Blueprint $table) {
            $table->id();
            
            // Nama klien
            $table->string('client_name'); // "Ahmad R."
            
            // Role/jabatan
            $table->string('client_role')->nullable(); // "Mahasiswa S1 Informatika"
            
            // Universitas (optional)
            $table->string('university')->nullable();
            
            // Isi testimonial
            $table->text('quote'); // "Awalnya skeptis karena zero DP..."
            
            // SINTA level yang berhasil publish
            $table->string('sinta_level')->nullable(); // "SINTA 5"
            
            // Jumlah hari proses
            $table->integer('processing_days')->nullable(); // 11
            
            // Rating 1-5
            $table->tinyInteger('rating')->default(5);
            
            // Foto klien (path ke storage)
            $table->string('photo')->nullable();
            
            // Tampilkan di homepage?
            $table->boolean('is_featured')->default(true);
            
            // Aktif/non-aktif
            $table->boolean('is_active')->default(true);
            
            // Urutan tampil
            $table->integer('order')->default(0);
            
            $table->timestamps();
        });

        // Seed sample testimonials
        $this->seedSampleTestimonials();
    }

    private function seedSampleTestimonials(): void
    {
        $testimonials = [
            [
                'client_name' => 'Ahmad R.',
                'client_role' => 'Mahasiswa S1 Informatika',
                'university' => null,
                'quote' => 'Awalnya skeptis karena zero DP, tapi ternyata legit! LOA keluar dalam 11 hari, baru bayar. Sangat membantu mahasiswa yang budget pas-pasan.',
                'sinta_level' => 'SINTA 5',
                'processing_days' => 11,
                'rating' => 5,
                'is_featured' => true,
                'order' => 1,
            ],
            [
                'client_name' => 'Siti N.',
                'client_role' => 'Mahasiswa S1 Teknik Komputer',
                'university' => null,
                'quote' => 'Editor paham banget tentang machine learning! Saran revisinya sangat membantu improve kualitas naskah. Jarang ada jasa publikasi yang sekompeten ini.',
                'sinta_level' => 'SINTA 4',
                'processing_days' => 21,
                'rating' => 5,
                'is_featured' => true,
                'order' => 2,
            ],
            [
                'client_name' => 'Budi S.',
                'client_role' => 'Mahasiswa S1 Sistem Informasi',
                'university' => null,
                'quote' => 'Harganya benar-benar murah dibanding kompetitor yang minta Rp 1-2 juta. Dashboard tracking juga memudahkan monitor progress. Recommended!',
                'sinta_level' => 'SINTA 6',
                'processing_days' => 22,
                'rating' => 5,
                'is_featured' => true,
                'order' => 3,
            ],
        ];

        foreach ($testimonials as $testimonial) {
            \DB::table('testimonials')->insert(array_merge($testimonial, [
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('testimonials');
    }
};
