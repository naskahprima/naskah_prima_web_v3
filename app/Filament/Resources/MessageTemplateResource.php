<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MessageTemplateResource\Pages;
use App\Models\MessageTemplate;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class MessageTemplateResource extends Resource
{
    protected static ?string $model = MessageTemplate::class;
    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-bottom-center-text';
    protected static ?string $navigationLabel = 'Template Pesan';
    protected static ?string $pluralLabel = 'Template Pesan';
    protected static ?int $navigationSort = 20;
    protected static ?string $navigationGroup = 'Settings';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Nama Template')
                    ->required()
                    ->maxLength(255),
                
                Forms\Components\Select::make('category')
                    ->label('Kategori')
                    ->options([
                        'jurnal' => 'Untuk Jurnal',
                        'client' => 'Untuk Client',
                        'marketing' => 'Untuk Marketing',
                    ])
                    ->required(),
                
                Forms\Components\Toggle::make('is_default')
                    ->label('Template Default')
                    ->helperText('Hanya bisa 1 template default per kategori'),
                
                Forms\Components\Textarea::make('description')
                    ->label('Deskripsi')
                    ->rows(2),
                
                Forms\Components\Textarea::make('template_text')
                    ->label('Isi Template')
                    ->required()
                    ->rows(15)
                    ->helperText('Gunakan [nama_jurnal], [nama_contact] untuk variable'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama')
                    ->searchable()
                    ->weight('bold'),
                
                Tables\Columns\BadgeColumn::make('category')
                    ->label('Kategori')
                    ->colors([
                        'primary' => 'jurnal',
                        'success' => 'client',
                        'warning' => 'marketing',
                    ]),
                
                Tables\Columns\IconColumn::make('is_default')
                    ->label('Default')
                    ->boolean(),
                
                Tables\Columns\TextColumn::make('description')
                    ->label('Deskripsi')
                    ->limit(50)
                    ->toggleable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('category')
                    ->options([
                        'jurnal' => 'Jurnal',
                        'client' => 'Client',
                        'marketing' => 'Marketing',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMessageTemplates::route('/'),
            'create' => Pages\CreateMessageTemplate::route('/create'),
            'edit' => Pages\EditMessageTemplate::route('/{record}/edit'),
        ];
    }
}