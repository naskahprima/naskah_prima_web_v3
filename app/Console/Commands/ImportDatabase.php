<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class ImportDatabase extends Command
{
    protected $signature = 'db:import';
    protected $description = 'Import SQL file (fixed BOM handling)';

    public function handle()
    {
        $this->info('🚀 Mulai import database...');
        
        $sqlFile = base_path('naskah_prima.sql');
        
        if (!file_exists($sqlFile)) {
            $this->error('❌ File tidak ditemukan!');
            return 1;
        }
        
        $this->info('📄 File ditemukan');
        
        // Baca file dengan UTF-8 BOM handling
        $sql = file_get_contents($sqlFile);
        
        // Hapus BOM jika ada
        $sql = preg_replace('/^\x{FEFF}/u', '', $sql);
        
        // Hapus command MySQL yang tidak perlu
        $sql = preg_replace('/^\/\*!.*?\*\/;?$/m', '', $sql);
        $sql = preg_replace('/^--.*$/m', '', $sql);
        
        // Split by LOCK/UNLOCK TABLES (lebih reliable)
        $this->info('📖 Memproses file...');
        
        try {
            // Disable foreign key checks
            DB::statement('SET FOREIGN_KEY_CHECKS=0');
            
            // Execute the whole SQL
            DB::unprepared($sql);
            
            // Enable foreign key checks
            DB::statement('SET FOREIGN_KEY_CHECKS=1');
            
            $this->info('✅ Import berhasil!');
            
        } catch (\Exception $e) {
            $this->error('❌ Error: ' . $e->getMessage());
            return 1;
        }
        
        // Show counts
        $this->newLine();
        $this->info('📊 Jumlah Data:');
        $this->showCount('users', 'Users');
        $this->showCount('clients', 'Clients');
        $this->showCount('mitra_jurnals', 'Mitra Jurnal');
        $this->showCount('jadwal_terbits', 'Jadwal Terbit');
        $this->showCount('message_templates', 'Templates');
        $this->showCount('naskahs', 'Naskah');
        
        return 0;
    }
    
    private function showCount($table, $label)
    {
        try {
            $count = DB::table($table)->count();
            $this->line("   {$label}: {$count}");
        } catch (\Exception $e) {
            $this->line("   {$label}: -");
        }
    }
}