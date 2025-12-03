<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TestimonialResource\Pages;
use App\Models\Testimonial;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class TestimonialResource extends Resource
{
    protected static ?string $model = Testimonial::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-right';
    
    protected static ?string $navigationLabel = 'Testimonial';
    
    protected static ?string $navigationGroup = 'Landing Page';
    
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Klien')
                    ->schema([
                        Forms\Components\TextInput::make('client_name')
                            ->label('Nama Klien')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Ahmad R.'),
                        
                        Forms\Components\TextInput::make('client_role')
                            ->label('Role/Jabatan')
                            ->maxLength(255)
                            ->placeholder('Mahasiswa S1 Informatika'),
                        
                        Forms\Components\TextInput::make('university')
                            ->label('Universitas')
                            ->maxLength(255)
                            ->placeholder('Universitas Indonesia'),
                        
                        Forms\Components\FileUpload::make('photo')
                            ->label('Foto Klien')
                            ->image()
                            ->imageResizeMode('cover')
                            ->imageCropAspectRatio('1:1')
                            ->imageResizeTargetWidth('120')
                            ->imageResizeTargetHeight('120')
                            ->directory('testimonials')
                            ->helperText('Foto akan di-resize ke 120x120px'),
                    ])
                    ->columns(2),
                
                Forms\Components\Section::make('Testimonial')
                    ->schema([
                        Forms\Components\Textarea::make('quote')
                            ->label('Isi Testimonial')
                            ->required()
                            ->rows(4)
                            ->placeholder('Awalnya skeptis karena zero DP, tapi ternyata legit! LOA keluar dalam 11 hari, baru bayar...'),
                        
                        Forms\Components\Select::make('rating')
                            ->label('Rating')
                            ->options([
                                5 => '⭐⭐⭐⭐⭐ (5)',
                                4 => '⭐⭐⭐⭐ (4)',
                                3 => '⭐⭐⭐ (3)',
                                2 => '⭐⭐ (2)',
                                1 => '⭐ (1)',
                            ])
                            ->default(5)
                            ->native(false),
                        
                        Forms\Components\TextInput::make('sinta_level')
                            ->label('SINTA Level')
                            ->placeholder('SINTA 5'),
                        
                        Forms\Components\TextInput::make('processing_days')
                            ->label('Jumlah Hari Proses')
                            ->numeric()
                            ->placeholder('11'),
                    ])
                    ->columns(2),
                
                Forms\Components\Section::make('Pengaturan')
                    ->schema([
                        Forms\Components\Toggle::make('is_featured')
                            ->label('Tampilkan di Homepage')
                            ->default(true),
                        
                        Forms\Components\Toggle::make('is_active')
                            ->label('Aktif')
                            ->default(true),
                        
                        Forms\Components\TextInput::make('order')
                            ->label('Urutan')
                            ->numeric()
                            ->default(0),
                    ])
                    ->columns(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('photo')
                    ->label('Foto')
                    ->circular()
                    ->defaultImageUrl(fn ($record) => $record->photo_url),
                
                Tables\Columns\TextColumn::make('client_name')
                    ->label('Nama')
                    ->searchable()
                    ->description(fn (Testimonial $record): string => $record->client_role ?? ''),
                
                Tables\Columns\TextColumn::make('quote')
                    ->label('Testimonial')
                    ->limit(50)
                    ->searchable(),
                
                Tables\Columns\TextColumn::make('sinta_level')
                    ->label('SINTA')
                    ->badge()
                    ->color('success'),
                
                Tables\Columns\TextColumn::make('processing_days')
                    ->label('Hari')
                    ->suffix(' hari')
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('rating')
                    ->label('Rating')
                    ->formatStateUsing(fn ($state) => str_repeat('⭐', $state)),
                
                Tables\Columns\IconColumn::make('is_featured')
                    ->label('Featured')
                    ->boolean(),
                
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean(),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_featured')
                    ->label('Featured'),
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
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTestimonials::route('/'),
            'create' => Pages\CreateTestimonial::route('/create'),
            'edit' => Pages\EditTestimonial::route('/{record}/edit'),
        ];
    }
}
