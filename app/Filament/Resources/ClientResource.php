<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ClientResource\Pages;
use App\Filament\Resources\ClientResource\RelationManagers;
use App\Models\Client;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ClientResource extends Resource
{
    protected static ?string $model = Client::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $navigationLabel = 'Client';
    protected static ?string $pluralLabel = 'Client';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Data Client')
                    ->schema([
                        Forms\Components\TextInput::make('nama_lengkap')
                            ->required()
                            ->maxLength(255)
                            ->label('Nama Lengkap')
                            ->placeholder('Nama lengkap client'),
                        
                        Forms\Components\TextInput::make('email')
                            ->email()
                            ->required()
                            ->maxLength(255)
                            ->label('Email')
                            ->placeholder('email@example.com'),
                        
                        Forms\Components\TextInput::make('no_whatsapp')
                            ->tel()
                            ->required()
                            ->maxLength(255)
                            ->label('No. WhatsApp')
                            ->placeholder('08xxxxxxxxxx'),
                        
                        Forms\Components\TextInput::make('institusi')
                            ->maxLength(255)
                            ->label('Institusi/Universitas')
                            ->placeholder('Nama universitas atau institusi'),
                    ])->columns(2),

                Forms\Components\Section::make('Catatan')
                    ->schema([
                        Forms\Components\Textarea::make('catatan_khusus')
                            ->label('Catatan Khusus')
                            ->placeholder('Catatan tambahan tentang client...')
                            ->rows(3)
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama_lengkap')
                    ->searchable()
                    ->sortable()
                    ->label('Nama Lengkap')
                    ->weight('bold'),
                
                Tables\Columns\TextColumn::make('email')
                    ->searchable()
                    ->copyable()
                    ->label('Email')
                    ->icon('heroicon-o-envelope'),
                
                Tables\Columns\TextColumn::make('no_whatsapp')
                    ->searchable()
                    ->copyable()
                    ->label('WhatsApp')
                    ->icon('heroicon-o-phone'),
                
                Tables\Columns\TextColumn::make('institusi')
                    ->searchable()
                    ->label('Institusi')
                    ->toggleable(),
                
                Tables\Columns\TextColumn::make('naskah.judul_naskah')
                    ->label('Naskah')
                    ->limit(30)
                    ->toggleable(),
                
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->label('Terdaftar')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListClients::route('/'),
            'create' => Pages\CreateClient::route('/create'),
            'edit' => Pages\EditClient::route('/{record}/edit'),
        ];
    }
}
