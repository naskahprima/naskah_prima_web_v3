<?php

namespace App\Filament\Resources;

use App\Filament\Resources\NaskahResource\Pages;
use App\Filament\Resources\NaskahResource\RelationManagers;
use App\Models\Naskah;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\FileUpload;
use App\Filament\Resources\NaskahResource\Widgets;

class NaskahResource extends Resource
{
    protected static ?string $model = Naskah::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationLabel = 'Naskah';
    protected static ?string $pluralLabel = 'Naskah';
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Naskah')
                    ->schema([
                        Forms\Components\TextInput::make('judul_naskah')
                            ->required()
                            ->maxLength(255)
                            ->label('Judul Naskah')
                            ->placeholder('Masukkan judul naskah')
                            ->columnSpanFull(),
                        
                        Forms\Components\Select::make('client_id')
                            ->relationship('client', 'nama_lengkap')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->createOptionForm([
                                Forms\Components\TextInput::make('nama_lengkap')
                                    ->required()
                                    ->label('Nama Lengkap'),
                                Forms\Components\TextInput::make('email')
                                    ->email()
                                    ->required()
                                    ->label('Email'),
                                Forms\Components\TextInput::make('no_whatsapp')
                                    ->tel()
                                    ->required()
                                    ->label('No. WhatsApp'),
                                Forms\Components\TextInput::make('institusi')
                                    ->label('Institusi'),
                            ])
                            ->label('Client')
                            ->helperText('Pilih client atau tambah baru'),
                        
                        Forms\Components\TextInput::make('bidang_topik')
                            ->label('Bidang/Topik')
                            ->placeholder('Contoh: Machine Learning, IoT, dll')
                            ->datalist([
                                'Machine Learning',
                                'Internet of Things',
                                'Sistem Informasi',
                                'Keamanan Siber',
                                'Blockchain',
                                'Mobile Development',
                            ]),
                    ])->columns(2),

                Forms\Components\Section::make('Target Publikasi')
                    ->schema([
                        Forms\Components\Select::make('mitra_jurnal_id')
                            ->relationship('mitraJurnal', 'nama_jurnal')
                            ->searchable()
                            ->preload()
                            ->label('Jurnal Target')
                            ->helperText('Pilih jurnal mitra sebagai target publikasi')
                            ->reactive()
                            ->afterStateUpdated(function ($state, callable $set) {
                                if ($state) {
                                    $jurnal = \App\Models\MitraJurnal::find($state);
                                    if ($jurnal) {
                                        $set('biaya_dibayar', $jurnal->biaya_publikasi);
                                    }
                                }
                            }),
                        
                        Forms\Components\TextInput::make('target_bulan_publish')
                            ->label('Target Bulan Publish')
                            ->placeholder('Contoh: Mei 2025')
                            ->helperText('Target publikasi yang diinginkan client'),
                        
                        Forms\Components\DatePicker::make('tanggal_masuk')
                            ->required()
                            ->default(now())
                            ->label('Tanggal Masuk')
                            ->helperText('Tanggal naskah masuk ke Naskah Prima'),
                    ])->columns(3),

                Forms\Components\Section::make('Status & Progress')
                    ->schema([
                        Forms\Components\Select::make('status')
                            ->required()
                            ->options([
                                'Draft' => 'Draft',
                                'Submitted' => 'Submitted',
                                'Under Review' => 'Under Review',
                                'Revision' => 'Revision',
                                'Accepted' => 'Accepted',
                                'Published' => 'Published',
                                'Rejected' => 'Rejected',
                            ])
                            ->default('Draft')
                            ->label('Status Naskah')
                            ->reactive(),
                        
                        Forms\Components\DatePicker::make('tanggal_published')
                            ->label('Tanggal Published')
                            ->visible(fn ($get) => $get('status') === 'Published')
                            ->helperText('Tanggal actual naskah terbit'),
                        
                        Forms\Components\TextInput::make('biaya_dibayar')
                            ->numeric()
                            ->prefix('Rp')
                            ->label('Biaya yang Dibayar')
                            ->placeholder('0'),
                    ])->columns(3),

                Forms\Components\Section::make('File & Catatan')
                    ->schema([
                        FileUpload::make('file_naskah')
                            ->label('Upload File Naskah')
                            ->acceptedFileTypes(['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'])
                            ->maxSize(10240) // 10MB
                            ->directory('naskah-files')
                            ->helperText('Format: PDF atau Word (Max 10MB)'),
                        
                        Forms\Components\Textarea::make('catatan_progress')
                            ->label('Catatan Progress')
                            ->placeholder('Tulis catatan atau update progress...')
                            ->rows(4),
                    ])->columns(1),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('judul_naskah')
                    ->searchable()
                    ->sortable()
                    ->label('Judul Naskah')
                    ->weight('bold')
                    ->wrap()
                    ->limit(50),
                
                Tables\Columns\TextColumn::make('client.nama_lengkap')
                    ->searchable()
                    ->sortable()
                    ->label('Client'),
                
                Tables\Columns\TextColumn::make('mitraJurnal.nama_jurnal')
                    ->searchable()
                    ->label('Jurnal Target')
                    ->limit(30)
                    ->toggleable(),
                
                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'secondary' => 'Draft',
                        'primary' => 'Submitted',
                        'warning' => 'Under Review',
                        'info' => 'Revision',
                        'success' => fn ($state) => in_array($state, ['Accepted', 'Published']),
                        'danger' => 'Rejected',
                    ])
                    ->label('Status'),
                
                Tables\Columns\TextColumn::make('target_bulan_publish')
                    ->label('Target Publish')
                    ->badge()
                    ->color('warning')
                    ->toggleable(),
                
                Tables\Columns\TextColumn::make('tanggal_published')
                    ->date('d M Y')
                    ->label('Tanggal Terbit')
                    ->toggleable()
                    ->placeholder('-'),
                
                Tables\Columns\TextColumn::make('tanggal_masuk')
                    ->date('d M Y')
                    ->sortable()
                    ->label('Tanggal Masuk')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'Draft' => 'Draft',
                        'Submitted' => 'Submitted',
                        'Under Review' => 'Under Review',
                        'Revision' => 'Revision',
                        'Accepted' => 'Accepted',
                        'Published' => 'Published',
                        'Rejected' => 'Rejected',
                    ])
                    ->label('Filter Status'),
                
                Tables\Filters\SelectFilter::make('mitra_jurnal_id')
                    ->relationship('mitraJurnal', 'nama_jurnal')
                    ->searchable()
                    ->preload()
                    ->label('Filter Jurnal'),
                
                Tables\Filters\Filter::make('tanggal_masuk')
                    ->form([
                        Forms\Components\DatePicker::make('dari_tanggal')
                            ->label('Dari Tanggal'),
                        Forms\Components\DatePicker::make('sampai_tanggal')
                            ->label('Sampai Tanggal'),
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when($data['dari_tanggal'], fn ($q) => $q->whereDate('tanggal_masuk', '>=', $data['dari_tanggal']))
                            ->when($data['sampai_tanggal'], fn ($q) => $q->whereDate('tanggal_masuk', '<=', $data['sampai_tanggal']));
                    })
                    ->label('Filter Tanggal Masuk'),
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
            ->defaultSort('tanggal_masuk', 'desc');
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
            'index' => Pages\ListNaskahs::route('/'),
            'create' => Pages\CreateNaskah::route('/create'),
            'edit' => Pages\EditNaskah::route('/{record}/edit'),
        ];
    }

    public static function getWidgets(): array
    {
        return [
            Widgets\StatsOverview::class,
        ];
    }
}
