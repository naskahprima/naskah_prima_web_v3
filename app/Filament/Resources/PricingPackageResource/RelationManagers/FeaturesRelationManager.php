<?php

namespace App\Filament\Resources\PricingPackageResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class FeaturesRelationManager extends RelationManager
{
    protected static string $relationship = 'features';

    protected static ?string $title = 'Fitur Paket';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('feature')
                    ->label('Nama Fitur')
                    ->required()
                    ->maxLength(255)
                    ->placeholder('100% bayar setelah LOA'),
                
                Forms\Components\Toggle::make('is_included')
                    ->label('Tersedia di Paket Ini')
                    ->default(true)
                    ->helperText('Jika tidak dicentang, akan tampil dengan icon silang'),
                
                Forms\Components\Toggle::make('is_highlighted')
                    ->label('Highlight (Bold)')
                    ->helperText('Tampilkan dengan teks tebal'),
                
                Forms\Components\TextInput::make('order')
                    ->label('Urutan')
                    ->numeric()
                    ->default(0),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('feature')
            ->columns([
                Tables\Columns\TextColumn::make('feature')
                    ->label('Fitur')
                    ->searchable()
                    ->weight(fn ($record) => $record->is_highlighted ? 'bold' : 'normal'),
                
                Tables\Columns\IconColumn::make('is_included')
                    ->label('Tersedia')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger'),
                
                Tables\Columns\IconColumn::make('is_highlighted')
                    ->label('Highlight')
                    ->boolean(),
            ])
            ->filters([])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->reorderable('order')
            ->defaultSort('order');
    }
}
