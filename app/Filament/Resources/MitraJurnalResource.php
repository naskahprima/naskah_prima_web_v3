<?php

namespace App\Filament\Resources;

use App\Filament\Resources\MitraJurnalResource\Pages;
use App\Models\MitraJurnal;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\SelectColumn;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use App\Models\MessageTemplate;
use Filament\Notifications\Notification;
use Filament\Forms\Components\View;
use Illuminate\Support\Facades\Log;

class MitraJurnalResource extends Resource
{
    protected static ?string $model = MitraJurnal::class;
    protected static ?string $navigationIcon = 'heroicon-o-building-library';
    protected static ?string $navigationLabel = 'Mitra Jurnal';
    protected static ?string $pluralLabel = 'Mitra Jurnal';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
            Forms\Components\Section::make('Informasi Jurnal')
                ->schema([
                    Forms\Components\TextInput::make('nama_jurnal')
                        ->required()
                        ->maxLength(255)
                        ->label('Nama Jurnal')
                        ->placeholder('Contoh: Jurnal Teknologi Informasi'),
                    
                    Forms\Components\Select::make('kategori_sinta')
                        ->required()
                        ->options([
                            'Sinta 4' => 'Sinta 4',
                            'Sinta 5' => 'Sinta 5',
                            'Sinta 6' => 'Sinta 6',
                        ])
                        ->searchable()
                        ->label('Kategori Sinta'),
                    
                    Forms\Components\TextInput::make('jenis_bidang')
                        ->required()
                        ->label('Jenis Bidang')
                        ->placeholder('Teknologi, Sains, Sosial, Kesehatan, dll')
                        ->datalist([
                            'Teknologi',
                            'Sains',
                            'Sosial',
                            'Kesehatan',
                            'Ekonomi',
                            'Pendidikan',
                            'Hukum',
                            'Pertanian',
                        ]),
                    
                    Forms\Components\TextInput::make('link_jurnal')
                        ->url()
                        ->label('Link Website Jurnal')
                        ->placeholder('https://jurnal.example.com')
                        ->columnSpan(2),
                ])->columns(2),

            Forms\Components\Section::make('Contact Person')
                ->schema([
                    Forms\Components\TextInput::make('contact_person')
                        ->label('Nama Contact Person')
                        ->placeholder('Nama editor atau PIC'),
                    
                    Forms\Components\TextInput::make('no_contact')
                        ->tel()
                        ->label('No. WhatsApp/HP')
                        ->placeholder('08xxxxxxxxxx'),
                ])->columns(2),

            Forms\Components\Section::make('Informasi Publikasi')
                ->schema([
                    Forms\Components\TextInput::make('biaya_publikasi')
                        ->numeric()
                        ->prefix('Rp')
                        ->label('Biaya Publikasi')
                        ->placeholder('0'),
                    
                    Forms\Components\TextInput::make('estimasi_proses_bulan')
                        ->numeric()
                        ->suffix('bulan')
                        ->label('Estimasi Proses')
                        ->placeholder('3')
                        ->helperText('Estimasi waktu dari submit sampai terbit'),
                    
                    Forms\Components\Select::make('frekuensi_terbit')
                        ->required()
                        ->options([
                            'Bulanan' => 'Bulanan',
                            'Triwulan' => 'Triwulan (3 bulan)',
                            'Semesteran' => 'Semesteran (6 bulan)',
                            'Tahunan' => 'Tahunan',
                        ])
                        ->label('Frekuensi Terbit'),
                    
                   Forms\Components\Select::make('status_kerjasama')
                    ->required()
                    ->options([
                        'Prospek' => '🔵 Prospek (Belum Dihubungi)',
                        'Menunggu Respons' => '🟡 Menunggu Respons',
                        'Aktif' => '🟢 Aktif (Siap Kerja)',
                        'Tidak Aktif' => '🔴 Tidak Aktif',
                    ])
                    ->default('Prospek')
                    ->label('Status Kerjasama')
                    ->helperText('Status komunikasi dengan jurnal ini'),
                ])->columns(2),

            Forms\Components\Section::make('Jadwal Terbit')
            ->schema([
                Forms\Components\Repeater::make('jadwalTerbits')
                    ->relationship()
                    ->schema([
                        Forms\Components\Select::make('bulan')
                            ->required()
                            ->options([
                                'Januari' => 'Januari',
                                'Februari' => 'Februari',
                                'Maret' => 'Maret',
                                'April' => 'April',
                                'Mei' => 'Mei',
                                'Juni' => 'Juni',
                                'Juli' => 'Juli',
                                'Agustus' => 'Agustus',
                                'September' => 'September',
                                'Oktober' => 'Oktober',
                                'November' => 'November',
                                'Desember' => 'Desember',
                            ])
                            ->label('Bulan Terbit')
                            ->searchable(),
                        
                        Forms\Components\TextInput::make('volume_issue')
                            ->label('Volume/Issue')
                            ->placeholder('Contoh: Vol 5 No 1')
                            ->helperText('Opsional: Info volume dan nomor'),
                        
                        Forms\Components\Textarea::make('catatan')
                            ->label('Catatan')
                            ->placeholder('Catatan khusus untuk jadwal ini...')
                            ->rows(2),
                    ])
                    ->columns(3)
                    ->defaultItems(0)
                    ->addActionLabel('Tambah Jadwal Terbit')
                    ->reorderable()
                    ->collapsible()
                    ->itemLabel(fn (array $state): ?string => $state['bulan'] ?? null)
                    ->helperText('Tambahkan semua bulan terbit jurnal dalam setahun'),
            ]),

            Forms\Components\Section::make('Catatan')
                ->schema([
                    Forms\Components\Textarea::make('notes')
                        ->label('Notes/Catatan Tambahan')
                        ->placeholder('Informasi tambahan tentang jurnal ini...')
                        ->rows(4)
                        ->columnSpanFull(),
                ]),
        ]);
    }

    protected static function normalizePhoneNumber(?string $phone): ?string
    {
        if (empty($phone)) {
            return null;
        }

        $phone = preg_replace('/[^0-9]/', '', $phone);

        if (substr($phone, 0, 1) === '0') {
            $phone = '62' . substr($phone, 1);
        } elseif (substr($phone, 0, 2) !== '62') {
            $phone = '62' . $phone;
        }

        return $phone;
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('nama_jurnal')
                    ->searchable()
                    ->sortable()
                    ->label('Nama Jurnal')
                    ->weight('bold'),
                
                Tables\Columns\BadgeColumn::make('kategori_sinta')
                    ->colors([
                        'success' => 'Sinta 4',
                        'warning' => 'Sinta 5',
                        'danger' => 'Sinta 6',
                    ])
                    ->label('Sinta'),
                
                Tables\Columns\TextColumn::make('jenis_bidang')
                    ->searchable()
                    ->label('Bidang')
                    ->badge()
                    ->color('info'),

                Tables\Columns\TextColumn::make('jadwalTerbits.bulan')
                    ->label('Jadwal Terbit')
                    ->badge()
                    ->separator(',')
                    ->color('success')
                    ->searchable()
                    ->toggleable(),
                            
                Tables\Columns\TextColumn::make('estimasi_proses_bulan')
                    ->suffix(' bulan')
                    ->label('Estimasi')
                    ->alignCenter(),
                
                Tables\Columns\TextColumn::make('biaya_publikasi')
                    ->money('IDR')
                    ->label('Biaya'),
                
                // ⭐ QUICK EDIT STATUS - FITUR BARU
                SelectColumn::make('status_kerjasama')
                    ->label('Status')
                    ->options([
                        'Prospek' => '🔵 Prospek',
                        'Menunggu Respons' => '🟡 Menunggu Respons',
                        'Aktif' => '🟢 Aktif',
                        'Tidak Aktif' => '🔴 Tidak Aktif',
                    ])
                    ->selectablePlaceholder(false)
                    ->extraAttributes(function ($state) {
                        $colors = [
                            'Prospek' => 'text-blue-600 dark:text-blue-400 font-semibold',
                            'Menunggu Respons' => 'text-yellow-600 dark:text-yellow-400 font-semibold',
                            'Aktif' => 'text-green-600 dark:text-green-400 font-semibold',
                            'Tidak Aktif' => 'text-red-600 dark:text-red-400 font-semibold',
                        ];
                        
                        return [
                            'class' => $colors[$state] ?? '',
                        ];
                    })
                    ->beforeStateUpdated(function ($record, $state) {
                        // Log perubahan (optional)
                        Log::info("Status {$record->nama_jurnal} diubah jadi: {$state}");
                    })
                    ->afterStateUpdated(function ($record, $state) {
                        // Notifikasi setelah berhasil update
                        Notification::make()
                            ->title('✅ Status Diperbarui!')
                            ->body("Status \"{$record->nama_jurnal}\" berhasil diubah menjadi: {$state}")
                            ->success()
                            ->duration(4000)
                            ->send();
                    }),
                
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime('d M Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->label('Dibuat'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('kategori_sinta')
                    ->options([
                        'Sinta 4' => 'Sinta 4',
                        'Sinta 5' => 'Sinta 5',
                        'Sinta 6' => 'Sinta 6',
                    ])
                    ->label('Filter Sinta'),
                
                Tables\Filters\SelectFilter::make('jenis_bidang')
                    ->label('Filter Bidang'),
                
                Tables\Filters\SelectFilter::make('jadwal_terbit')
                    ->label('Filter Bulan Terbit')
                    ->options([
                        'Januari' => 'Januari',
                        'Februari' => 'Februari',
                        'Maret' => 'Maret',
                        'April' => 'April',
                        'Mei' => 'Mei',
                        'Juni' => 'Juni',
                        'Juli' => 'Juli',
                        'Agustus' => 'Agustus',
                        'September' => 'September',
                        'Oktober' => 'Oktober',
                        'November' => 'November',
                        'Desember' => 'Desember',
                    ])
                    ->query(function ($query, $state) {
                        if ($state['value']) {
                            $query->whereHas('jadwalTerbits', function ($q) use ($state) {
                                $q->where('bulan', $state['value']);
                            });
                        }
                    }),
                
                Tables\Filters\SelectFilter::make('status_kerjasama')
                ->options([
                    'Prospek' => 'Prospek',
                    'Menunggu Respons' => 'Menunggu Respons',
                    'Aktif' => 'Aktif',
                    'Tidak Aktif' => 'Tidak Aktif',
                ])
                ->label('Filter Status'),
            ])
            ->actions([
                Action::make('chat')
                    ->label('Chat')
                    ->icon('heroicon-o-chat-bubble-left-right')
                    ->color('success')
                    ->modalHeading(fn ($record) => 'Pesan untuk ' . $record->nama_jurnal)
                    ->modalSubmitAction(false)
                    ->modalCancelActionLabel('Tutup')
                    ->modalWidth('lg')
                    ->closeModalByClickingAway(false)
                    ->form(function ($record) {
                        $templates = MessageTemplate::where('category', 'jurnal')->get();
                        $defaultTemplate = MessageTemplate::default('jurnal');
                        $hasWhatsapp = !empty($record->no_contact);
                        $normalizedPhone = self::normalizePhoneNumber($record->no_contact);
                        
                        return [
                            Select::make('template_id')
                                ->label('Pilih Template')
                                ->options($templates->pluck('name', 'id'))
                                ->default($defaultTemplate?->id)
                                ->required()
                                ->reactive()
                                ->afterStateUpdated(function ($state, callable $set) use ($record) {
                                    $template = MessageTemplate::find($state);
                                    if ($template) {
                                        $rendered = $template->render([
                                            'nama_jurnal' => $record->nama_jurnal,
                                            'nama_contact' => $record->contact_person ?? 'Bapak/Ibu',
                                        ]);
                                        $set('message_text', $rendered);
                                    }
                                }),
                            
                            Textarea::make('message_text')
                                ->label('Pesan')
                                ->rows(12)
                                ->default(function () use ($record, $defaultTemplate) {
                                    if ($defaultTemplate) {
                                        return $defaultTemplate->render([
                                            'nama_jurnal' => $record->nama_jurnal,
                                            'nama_contact' => $record->contact_person ?? 'Bapak/Ibu',
                                        ]);
                                    }
                                    return '';
                                })
                                ->helperText(function () use ($record, $hasWhatsapp) {
                                    $info = [];
                                    
                                    if ($hasWhatsapp) {
                                        $info[] = '📱 WhatsApp: ' . $record->no_contact;
                                    } else {
                                        $info[] = '⚠️ Nomor WhatsApp belum tersedia';
                                    }
                                    
                                    if (!empty($record->contact_person)) {
                                        $info[] = '👤 Contact: ' . $record->contact_person;
                                    }
                                    
                                    return implode(' | ', $info);
                                }),
                            
                            View::make('filament.forms.components.chat-action-buttons')
                                ->viewData([
                                    'hasWhatsapp' => $hasWhatsapp,
                                    'phone' => $normalizedPhone,
                                ]),
                        ];
                    }),
                
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
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMitraJurnals::route('/'),
            'create' => Pages\CreateMitraJurnal::route('/create'),
            'edit' => Pages\EditMitraJurnal::route('/{record}/edit'),
        ];
    }
}