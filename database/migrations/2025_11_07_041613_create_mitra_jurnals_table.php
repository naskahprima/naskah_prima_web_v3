<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('mitra_jurnals', function (Blueprint $table) {
            $table->id();
            $table->string('nama_jurnal');
            $table->enum('kategori_sinta', ['Sinta 4', 'Sinta 5', 'Sinta 6']);
            $table->string('jenis_bidang'); // Teknologi, Sains, dll
            $table->string('link_jurnal')->nullable();
            $table->string('contact_person')->nullable();
            $table->string('no_contact')->nullable();
            $table->decimal('biaya_publikasi', 10, 2)->nullable();
            $table->integer('estimasi_proses_bulan')->nullable(); // dalam bulan
            $table->enum('frekuensi_terbit', ['Bulanan', 'Triwulan', 'Semesteran', 'Tahunan']);
            $table->enum('status_kerjasama', ['Aktif', 'Tidak Aktif'])->default('Aktif');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mitra_jurnals');
    }
};
