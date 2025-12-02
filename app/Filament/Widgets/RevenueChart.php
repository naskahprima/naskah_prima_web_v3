<?php

namespace App\Filament\Widgets;

use App\Models\Naskah;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class RevenueChart extends ChartWidget
{
    protected static ?string $heading = '💰 Pendapatan Per Bulan';
    protected static ?int $sort = 2;

    protected function getData(): array
    {
        // Ambil data 6 bulan terakhir
        $data = Naskah::selectRaw('MONTH(tanggal_masuk) as bulan, YEAR(tanggal_masuk) as tahun, SUM(biaya_dibayar) as total')
            ->whereNotNull('biaya_dibayar')
            ->where('tanggal_masuk', '>=', now()->subMonths(6))
            ->groupBy('tahun', 'bulan')
            ->orderBy('tahun', 'asc')
            ->orderBy('bulan', 'asc')
            ->get();

        $labels = [];
        $revenues = [];

        $months = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agt', 'Sep', 'Oct', 'Nov', 'Des'];

        foreach ($data as $item) {
            $labels[] = $months[$item->bulan - 1] . ' ' . $item->tahun;
            $revenues[] = $item->total;
        }

        // Kalau tidak ada data, buat dummy
        if (empty($labels)) {
            $currentMonth = now()->format('M Y');
            $labels = [$currentMonth];
            $revenues = [0];
        }

        return [
            'datasets' => [
                [
                    'label' => 'Pendapatan (Rp)',
                    'data' => $revenues,
                    'backgroundColor' => 'rgba(59, 130, 246, 0.1)',
                    'borderColor' => 'rgb(59, 130, 246)',
                    'fill' => true,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}