<?php

namespace App\Filament\Widgets;

use App\Models\Naskah;  
use App\Models\Client;
use App\Models\MitraJurnal;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;


class PerformanceStats extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        // Hitung total pendapatan
        $totalRevenue = Naskah::whereNotNull('biaya_dibayar')->sum('biaya_dibayar');
        $revenueThisMonth = Naskah::whereNotNull('biaya_dibayar')
            ->whereMonth('tanggal_masuk', now()->month)
            ->whereYear('tanggal_masuk', now()->year)
            ->sum('biaya_dibayar');
        
        // Hitung success rate
        $totalNaskah = Naskah::count();
        $publishedNaskah = Naskah::where('status', 'Published')->count();
        $successRate = $totalNaskah > 0 ? round(($publishedNaskah / $totalNaskah) * 100, 1) : 0;
        
        // Hitung rata-rata waktu proses
        $avgProcessTime = Naskah::where('status', 'Published')
            ->whereNotNull('tanggal_published')
            ->get()
            ->map(function ($naskah) {
                return $naskah->tanggal_masuk->diffInDays($naskah->tanggal_published);
            })
            ->avg();
        
        $avgProcessTime = $avgProcessTime ? round($avgProcessTime) : 0;

        return [
            Stat::make('💵 Total Pendapatan', 'Rp ' . number_format($totalRevenue, 0, ',', '.'))
                ->description('Pendapatan bulan ini: Rp ' . number_format($revenueThisMonth, 0, ',', '.'))
                ->descriptionIcon('heroicon-o-arrow-trending-up')
                ->color('success')
                ->chart($this->getRevenueChart()),
            
            Stat::make('✅ Success Rate', $successRate . '%')
                ->description($publishedNaskah . ' dari ' . $totalNaskah . ' naskah berhasil published')
                ->descriptionIcon('heroicon-o-check-badge')
                ->color($successRate >= 80 ? 'success' : ($successRate >= 50 ? 'warning' : 'danger')),
            
            Stat::make('⏱️ Rata-rata Waktu Proses', $avgProcessTime . ' hari')
                ->description('Dari submit sampai published')
                ->descriptionIcon('heroicon-o-clock')
                ->color('info'),
            
            Stat::make('⚠️ Naskah Butuh Perhatian', $this->getNeedAttention())
                ->description('Under review > 30 hari atau deadline dekat')
                ->descriptionIcon('heroicon-o-exclamation-triangle')
                ->color('warning'),

            Stat::make('📊 Status Mitra', MitraJurnal::where('status_kerjasama', 'Aktif')->count() . ' Aktif')
                ->description(
                    'Prospek: ' . MitraJurnal::where('status_kerjasama', 'Prospek')->count() . ' | ' .
                    'Menunggu: ' . MitraJurnal::where('status_kerjasama', 'Menunggu Respons')->count()
                )
                ->descriptionIcon('heroicon-o-building-library')
                ->color('info'),
        ];
    }

    private function getRevenueChart(): array
    {
        // Mini chart untuk 7 hari terakhir
        $data = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $revenue = Naskah::whereDate('tanggal_masuk', $date)
                ->sum('biaya_dibayar');
            $data[] = $revenue;
        }
        return $data;
    }

    private function getNeedAttention(): int
    {
        $underReviewLong = Naskah::where('status', 'Under Review')
            ->where('tanggal_masuk', '<=', now()->subDays(30))
            ->count();
        
        $nearDeadline = Naskah::whereNotIn('status', ['Published', 'Rejected'])
            ->where(function($query) {
                $query->whereRaw("STR_TO_DATE(CONCAT('01 ', target_bulan_publish), '%d %M %Y') <= ?", [now()->addMonth()])
                      ->orWhereNull('target_bulan_publish');
            })
            ->count();
        
        return $underReviewLong + $nearDeadline;
    }
}