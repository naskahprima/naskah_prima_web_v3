<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SettingResource\Pages;
use App\Models\Setting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class SettingResource extends Resource
{
    protected static ?string $model = Setting::class;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';
    
    protected static ?string $navigationLabel = 'Pengaturan Website';
    
    protected static ?string $navigationGroup = 'Settings';
    
    protected static ?int $navigationSort = 100;

    protected static ?string $modelLabel = 'Pengaturan';
    
    protected static ?string $pluralModelLabel = 'Pengaturan Website';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Setting Detail')
                    ->schema([
                        Forms\Components\Select::make('group')
                            ->label('Grup')
                            ->options([
                                'contact' => 'Kontak',
                                'hero' => 'Hero Section',
                                'branding' => 'Branding & SEO',
                                'general' => 'Umum',
                            ])
                            ->required()
                            ->native(false),
                        
                        Forms\Components\TextInput::make('key')
                            ->label('Key (Unique ID)')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255)
                            ->helperText('Contoh: whatsapp_number, hero_title'),
                        
                        Forms\Components\TextInput::make('label')
                            ->label('Label (Nama Tampilan)')
                            ->maxLength(255),
                        
                        Forms\Components\Select::make('type')
                            ->label('Tipe Input')
                            ->options([
                                'text' => 'Text (1 baris)',
                                'textarea' => 'Textarea (multi baris)',
                                'email' => 'Email',
                                'phone' => 'Nomor Telepon',
                                'url' => 'URL',
                                'image' => 'Gambar',
                            ])
                            ->default('text')
                            ->native(false)
                            ->reactive(),
                        
                        Forms\Components\Textarea::make('value')
                            ->label('Nilai')
                            ->rows(3)
                            ->columnSpanFull()
                            ->visible(fn ($get) => in_array($get('type'), ['text', 'textarea', 'email', 'phone', 'url', null])),
                        
                        Forms\Components\FileUpload::make('value')
                            ->label('Gambar')
                            ->image()
                            ->directory('settings')
                            ->columnSpanFull()
                            ->visible(fn ($get) => $get('type') === 'image'),
                        
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
                Tables\Columns\TextColumn::make('group')
                    ->label('Grup')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'contact' => 'info',
                        'hero' => 'success',
                        'branding' => 'warning',
                        default => 'gray',
                    })
                    ->sortable(),
                
                Tables\Columns\TextColumn::make('label')
                    ->label('Nama')
                    ->searchable()
                    ->description(fn (Setting $record): string => $record->key),
                
                Tables\Columns\TextColumn::make('value')
                    ->label('Nilai')
                    ->limit(50)
                    ->searchable(),
                
                Tables\Columns\TextColumn::make('type')
                    ->label('Tipe')
                    ->badge()
                    ->color('gray'),
                
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Diupdate')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('group')
                    ->label('Grup')
                    ->options([
                        'contact' => 'Kontak',
                        'hero' => 'Hero Section',
                        'branding' => 'Branding & SEO',
                        'general' => 'Umum',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('group')
            ->defaultGroup('group');
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSettings::route('/'),
            'create' => Pages\CreateSetting::route('/create'),
            'edit' => Pages\EditSetting::route('/{record}/edit'),
        ];
    }
}
