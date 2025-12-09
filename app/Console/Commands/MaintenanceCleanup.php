<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\BlogPost;

class MaintenanceCleanup extends Command
{
    protected $signature = 'maintenance:cleanup {--dry-run : Show what would be deleted without actually deleting}';
    
    protected $description = 'Cleanup orphan files, optimize database, and perform maintenance tasks';

    public function handle()
    {
        $isDryRun = $this->option('dry-run');
        
        $this->info('🔧 Starting maintenance cleanup...');
        $this->newLine();

        // 1. Cleanup orphan blog images
        $this->cleanupOrphanBlogImages($isDryRun);

        // 2. Cleanup orphan naskah files
        $this->cleanupOrphanNaskahFiles($isDryRun);

        // 3. Cleanup old log files
        $this->cleanupOldLogs($isDryRun);

        // 4. Clear expired cache
        $this->clearExpiredCache($isDryRun);

        // 5. Optimize database tables
        $this->optimizeDatabase($isDryRun);

        // 6. Regenerate sitemap
        $this->regenerateSitemap($isDryRun);

        $this->newLine();
        $this->info('✅ Maintenance cleanup completed!');
        
        // Log maintenance
        Log::info('Maintenance cleanup completed', [
            'dry_run' => $isDryRun,
            'timestamp' => now()->toDateTimeString(),
        ]);

        return Command::SUCCESS;
    }

    /**
     * Cleanup orphan blog images (images not linked to any post)
     */
    private function cleanupOrphanBlogImages(bool $isDryRun): void
    {
        $this->info('📷 Checking orphan blog images...');
        
        $disk = Storage::disk('public');
        $directory = 'blog-images';
        
        if (!$disk->exists($directory)) {
            $this->line('   No blog-images directory found.');
            return;
        }

        $files = $disk->files($directory);
        $usedImages = BlogPost::whereNotNull('featured_image')->pluck('featured_image')->toArray();
        
        $orphanCount = 0;
        $totalSize = 0;

        foreach ($files as $file) {
            if (!in_array($file, $usedImages)) {
                $size = $disk->size($file);
                $totalSize += $size;
                $orphanCount++;
                
                if ($isDryRun) {
                    $this->line("   [DRY-RUN] Would delete: {$file} (" . $this->formatBytes($size) . ")");
                } else {
                    $disk->delete($file);
                    $this->line("   Deleted: {$file}");
                }
            }
        }

        if ($orphanCount > 0) {
            $this->info("   Found {$orphanCount} orphan files (" . $this->formatBytes($totalSize) . ")");
        } else {
            $this->line('   No orphan images found.');
        }
    }

    /**
     * Cleanup orphan naskah files
     */
    private function cleanupOrphanNaskahFiles(bool $isDryRun): void
    {
        $this->info('📄 Checking orphan naskah files...');
        
        $disk = Storage::disk('public');
        $directory = 'naskah-files';
        
        if (!$disk->exists($directory)) {
            $this->line('   No naskah-files directory found.');
            return;
        }

        $files = $disk->files($directory);
        $usedFiles = \App\Models\Naskah::whereNotNull('file_naskah')->pluck('file_naskah')->toArray();
        
        $orphanCount = 0;
        $totalSize = 0;

        foreach ($files as $file) {
            if (!in_array($file, $usedFiles)) {
                $size = $disk->size($file);
                $totalSize += $size;
                $orphanCount++;
                
                if ($isDryRun) {
                    $this->line("   [DRY-RUN] Would delete: {$file} (" . $this->formatBytes($size) . ")");
                } else {
                    $disk->delete($file);
                    $this->line("   Deleted: {$file}");
                }
            }
        }

        if ($orphanCount > 0) {
            $this->info("   Found {$orphanCount} orphan files (" . $this->formatBytes($totalSize) . ")");
        } else {
            $this->line('   No orphan naskah files found.');
        }
    }

    /**
     * Cleanup old log files (older than 30 days)
     */
    private function cleanupOldLogs(bool $isDryRun): void
    {
        $this->info('📋 Checking old log files...');
        
        $logPath = storage_path('logs');
        $files = glob($logPath . '/laravel-*.log');
        $deletedCount = 0;
        $totalSize = 0;
        $thirtyDaysAgo = now()->subDays(30)->timestamp;

        foreach ($files as $file) {
            if (filemtime($file) < $thirtyDaysAgo) {
                $size = filesize($file);
                $totalSize += $size;
                $deletedCount++;
                
                if ($isDryRun) {
                    $this->line("   [DRY-RUN] Would delete: " . basename($file));
                } else {
                    unlink($file);
                    $this->line("   Deleted: " . basename($file));
                }
            }
        }

        if ($deletedCount > 0) {
            $this->info("   Cleaned {$deletedCount} old log files (" . $this->formatBytes($totalSize) . ")");
        } else {
            $this->line('   No old log files found.');
        }
    }

    /**
     * Clear expired cache
     */
    private function clearExpiredCache(bool $isDryRun): void
    {
        $this->info('🗑️  Clearing expired cache...');
        
        if ($isDryRun) {
            $this->line('   [DRY-RUN] Would clear cache');
        } else {
            \Illuminate\Support\Facades\Artisan::call('cache:clear');
            $this->line('   Cache cleared.');
        }
    }

    /**
     * Optimize database tables
     */
    private function optimizeDatabase(bool $isDryRun): void
    {
        $this->info('🗄️  Optimizing database...');
        
        $tables = [
            'blog_posts',
            'blog_categories', 
            'blog_tags',
            'clients',
            'naskahs',
            'mitra_jurnals',
            'settings',
        ];

        foreach ($tables as $table) {
            try {
                if ($isDryRun) {
                    $this->line("   [DRY-RUN] Would optimize: {$table}");
                } else {
                    DB::statement("OPTIMIZE TABLE {$table}");
                    $this->line("   Optimized: {$table}");
                }
            } catch (\Exception $e) {
                $this->warn("   Could not optimize {$table}: " . $e->getMessage());
            }
        }
    }

    /**
     * Regenerate sitemap
     */
    private function regenerateSitemap(bool $isDryRun): void
    {
        $this->info('🗺️  Regenerating sitemap...');
        
        if ($isDryRun) {
            $this->line('   [DRY-RUN] Would regenerate sitemap');
        } else {
            try {
                \Illuminate\Support\Facades\Artisan::call('sitemap:generate');
                $this->line('   Sitemap regenerated.');
            } catch (\Exception $e) {
                $this->warn('   Could not regenerate sitemap: ' . $e->getMessage());
            }
        }
    }

    /**
     * Format bytes to human readable
     */
    private function formatBytes(int $bytes): string
    {
        $units = ['B', 'KB', 'MB', 'GB'];
        $i = 0;
        while ($bytes >= 1024 && $i < count($units) - 1) {
            $bytes /= 1024;
            $i++;
        }
        return round($bytes, 2) . ' ' . $units[$i];
    }
}