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
        Schema::create('naskahs', function (Blueprint $table) {
            $table->id();
            $table->string('judul_naskah');
            $table->foreignId('client_id')->constrained()->onDelete('cascade');
            $table->foreignId('mitra_jurnal_id')->nullable()->constrained()->onDelete('set null');
            $table->string('bidang_topik')->nullable();
            $table->date('tanggal_masuk');
            $table->string('target_bulan_publish')->nullable(); // "Mei 2025"
            $table->enum('status', [
                'Draft',
                'Submitted',
                'Under Review',
                'Revision',
                'Accepted',
                'Published',
                'Rejected'
            ])->default('Draft');
            $table->date('tanggal_published')->nullable();
            $table->decimal('biaya_dibayar', 10, 2)->nullable();
            $table->string('file_naskah')->nullable();
            $table->text('catatan_progress')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('naskahs');
    }
};
