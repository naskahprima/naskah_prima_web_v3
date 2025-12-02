<?php

namespace App\Filament\Widgets;

use App\Models\MitraJurnal;
use App\Models\Naskah;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class TopJurnals extends BaseWidget
{
    protected static ?string $heading = '🏆 Top 5 Jurnal Paling Produktif';
    protected static ?int $sort = 3;
    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                MitraJurnal::query()
                    ->withCount('naskahs')
                    ->withCount(['naskahs as published_count' => function ($query) {
                        $query->where('status', 'Published');
                    }])
                    ->withSum('naskahs', 'biaya_dibayar')
                    ->having('naskahs_count', '>', 0)
                    ->orderByDesc('naskahs_count')
                    ->limit(5)
            )
            ->columns([
                Tables\Columns\TextColumn::make('nama_jurnal')
                    ->label('Nama Jurnal')
                    ->weight('bold')
                    ->searchable(),
                
                Tables\Columns\BadgeColumn::make('kategori_sinta')
                    ->label('Sinta')
                    ->colors([
                        'success' => 'Sinta 4',
                        'warning' => 'Sinta 5',
                        'danger' => 'Sinta 6',
                    ]),
                
                Tables\Columns\TextColumn::make('naskahs_count')
                    ->label('Total Naskah')
                    ->alignCenter()
                    ->badge()
                    ->color('primary'),
                
                Tables\Columns\TextColumn::make('published_count')
                    ->label('Published')
                    ->alignCenter()
                    ->badge()
                    ->color('success'),
                
                Tables\Columns\TextColumn::make('success_rate')
                    ->label('Success Rate')
                    ->state(function (MitraJurnal $record): string {
                        if ($record->naskahs_count == 0) return '0%';
                        $rate = round(($record->published_count / $record->naskahs_count) * 100, 1);
                        return $rate . '%';
                    })
                    ->badge()
                    ->color(fn (string $state): string => match (true) {
                        floatval($state) >= 80 => 'success',
                        floatval($state) >= 50 => 'warning',
                        default => 'danger',
                    }),
                
                Tables\Columns\TextColumn::make('naskahs_sum_biaya_dibayar')
                    ->label('Total Revenue')
                    ->money('IDR')
                    ->color('success')
                    ->weight('bold'),
            ]);
    }
}