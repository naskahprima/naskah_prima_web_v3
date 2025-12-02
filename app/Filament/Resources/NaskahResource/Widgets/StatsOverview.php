<?php

namespace App\Filament\Resources\NaskahResource\Widgets;

use App\Models\Naskah;
use App\Models\Client;
use App\Models\MitraJurnal;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Naskah', Naskah::count())
                ->description('Total semua naskah')
                ->descriptionIcon('heroicon-o-document-text')
                ->color('primary'),
            
            Stat::make('Naskah Published', Naskah::where('status', 'Published')->count())
                ->description('Naskah yang sudah terbit')
                ->descriptionIcon('heroicon-o-check-circle')
                ->color('success'),
            
            Stat::make('Dalam Proses', Naskah::whereIn('status', ['Submitted', 'Under Review', 'Revision'])->count())
                ->description('Sedang diproses')
                ->descriptionIcon('heroicon-o-clock')
                ->color('warning'),
            
            Stat::make('Total Client', Client::count())
                ->description('Jumlah client terdaftar')
                ->descriptionIcon('heroicon-o-user-group')
                ->color('info'),
        ];
    }
}