<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PricingPackageResource\Pages;
use App\Filament\Resources\PricingPackageResource\RelationManagers;
use App\Models\PricingPackage;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PricingPackageResource extends Resource
{
    protected static ?string $model = PricingPackage::class;

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';
    
    protected static ?string $navigationLabel = 'Paket Harga';
    
    protected static ?string $navigationGroup = 'Landing Page';
    
    protected static ?int $navigationSort = 1;

    protected static ?string $modelLabel = 'Paket Harga';
    
    protected static ?string $pluralModelLabel = 'Paket Harga';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Paket')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Nama Paket')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Premium'),
                        
                        Forms\Components\TextInput::make('slug')
                            ->label('Slug (URL)')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true)
                            ->placeholder('premium'),
                        
                        Forms\Components\TextInput::make('description')
                            ->label('Deskripsi Singkat')
                            ->maxLength(255)
                            ->placeholder('Rekomendasi untuk hasil terbaik'),
                        
                        Forms\Components\Toggle::make('is_popular')
                            ->label('Tandai sebagai "PALING POPULER"')
                            ->helperText('Akan menampilkan badge "PALING POPULER"'),
                        
                        Forms\Components\Toggle::make('is_active')
                            ->label('Aktif')
                            ->default(true),
                        
                        Forms\Components\TextInput::make('order')
                            ->label('Urutan')
                            ->numeric()
                            ->default(0),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Paket')
                    ->searchable()
                    ->description(fn (PricingPackage $record): string => $record->description ?? ''),
                
                Tables\Columns\TextColumn::make('items_count')
                    ->label('Jumlah Harga')
                    ->counts('items')
                    ->badge()
                    ->color('info'),
                
                Tables\Columns\TextColumn::make('features_count')
                    ->label('Jumlah Fitur')
                    ->counts('features')
                    ->badge()
                    ->color('success'),
                
                Tables\Columns\IconColumn::make('is_popular')
                    ->label('Populer')
                    ->boolean(),
                
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean(),
                
                Tables\Columns\TextColumn::make('order')
                    ->label('Urutan')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Aktif'),
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

    public static function getRelations(): array
    {
        return [
            RelationManagers\ItemsRelationManager::class,
            RelationManagers\FeaturesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPricingPackages::route('/'),
            'create' => Pages\CreatePricingPackage::route('/create'),
            'edit' => Pages\EditPricingPackage::route('/{record}/edit'),
        ];
    }
}
