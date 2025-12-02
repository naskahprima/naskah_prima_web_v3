<?php

namespace App\Filament\Widgets;

use App\Models\Naskah;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class RecentActivity extends BaseWidget
{
    protected static ?string $heading = '📋 Aktivitas Terbaru';
    protected static ?int $sort = 4;
    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Naskah::query()
                    ->latest('updated_at')
                    ->limit(10)
            )
            ->columns([
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Waktu')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('judul_naskah')
                    ->label('Naskah')
                    ->limit(40)
                    ->searchable()
                    ->weight('bold'),
                
                Tables\Columns\TextColumn::make('client.nama_lengkap')
                    ->label('Client')
                    ->searchable(),
                
                Tables\Columns\BadgeColumn::make('status')
                    ->label('Status')
                    ->colors([
                        'secondary' => 'Draft',
                        'primary' => 'Submitted',
                        'warning' => 'Under Review',
                        'info' => 'Revision',
                        'success' => fn ($state) => in_array($state, ['Accepted', 'Published']),
                        'danger' => 'Rejected',
                    ]),
                
                Tables\Columns\TextColumn::make('mitraJurnal.nama_jurnal')
                    ->label('Jurnal')
                    ->limit(30)
                    ->toggleable(),
            ])
            ->actions([
                Tables\Actions\Action::make('view')
                    ->label('Lihat')
                    ->icon('heroicon-o-eye')
                    ->url(fn (Naskah $record): string => route('filament.admin.resources.naskahs.edit', $record)),
            ]);
    }
}