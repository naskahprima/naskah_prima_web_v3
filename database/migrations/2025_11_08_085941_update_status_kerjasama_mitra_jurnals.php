<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Step 1: Ubah kolom jadi VARCHAR dulu (temporary)
        DB::statement("ALTER TABLE `mitra_jurnals` MODIFY `status_kerjasama` VARCHAR(50) NOT NULL DEFAULT 'Prospek'");
        
        // Step 2: Update data yang ada
        // 'Tidak Aktif' jadi 'Prospek'
        DB::table('mitra_jurnals')
            ->where('status_kerjasama', 'Tidak Aktif')
            ->update(['status_kerjasama' => 'Prospek']);
        
        // 'Aktif' tetap 'Aktif' (tidak perlu update)
        
        // Step 3: Ubah jadi ENUM dengan nilai baru
        DB::statement("ALTER TABLE `mitra_jurnals` MODIFY `status_kerjasama` ENUM('Prospek', 'Menunggu Respons', 'Aktif', 'Tidak Aktif') NOT NULL DEFAULT 'Prospek'");
    }

    public function down(): void
    {
        // Rollback ke status lama
        DB::statement("ALTER TABLE `mitra_jurnals` MODIFY `status_kerjasama` VARCHAR(50) NOT NULL");
        
        DB::table('mitra_jurnals')
            ->where('status_kerjasama', 'Prospek')
            ->update(['status_kerjasama' => 'Tidak Aktif']);
        
        DB::table('mitra_jurnals')
            ->where('status_kerjasama', 'Menunggu Respons')
            ->update(['status_kerjasama' => 'Tidak Aktif']);
        
        DB::statement("ALTER TABLE `mitra_jurnals` MODIFY `status_kerjasama` ENUM('Aktif', 'Tidak Aktif') NOT NULL DEFAULT 'Aktif'");
    }
};