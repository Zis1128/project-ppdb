<?php

namespace App\Filament\Panitia\Resources;

use App\Filament\Panitia\Resources\VerifikasiPendaftaranResource\Pages;
use App\Filament\Panitia\Resources\VerifikasiPendaftaranResource\RelationManagers;
use App\Models\Pendaftaran;
use App\Models\Jurusan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Illuminate\Database\Eloquent\Builder;
use Filament\Notifications\Notification;

class VerifikasiPendaftaranResource extends Resource
{
    protected static ?string $model = Pendaftaran::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-check';

    protected static ?string $navigationGroup = 'Verifikasi';

    protected static ?int $navigationSort = 1;

    protected static ?string $navigationLabel = 'Verifikasi Pendaftaran';

    protected static ?string $modelLabel = 'Verifikasi Pendaftaran';

    protected static ?string $pluralModelLabel = 'Verifikasi Pendaftaran';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('status_verifikasi', 'pending')->count();
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'warning';
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Verifikasi Data')
                    ->schema([
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\Placeholder::make('no_pendaftaran')
                                    ->label('No. Pendaftaran')
                                    ->content(fn ($record) => $record->no_pendaftaran),

                                Forms\Components\Placeholder::make('nama_lengkap')
                                    ->label('Nama Lengkap')
                                    ->content(fn ($record) => $record->nama_lengkap),

                                Forms\Components\Placeholder::make('nisn')
                                    ->label('NISN')
                                    ->content(fn ($record) => $record->nisn),

                                Forms\Components\Placeholder::make('asal_sekolah')
                                    ->label('Asal Sekolah')
                                    ->content(fn ($record) => $record->asal_sekolah),
                            ]),

                        Forms\Components\Select::make('status_verifikasi')
                            ->label('Status Verifikasi')
                            ->options([
                                'pending' => 'Pending',
                                'approved' => 'Disetujui',
                                'rejected' => 'Ditolak',
                            ])
                            ->required()
                            ->native(false)
                            ->live(),

                        Forms\Components\Textarea::make('catatan_verifikasi')
                            ->label('Catatan Verifikasi')
                            ->rows(4)
                            ->placeholder('Berikan catatan untuk calon siswa...')
                            ->required(fn (Forms\Get $get) => $get('status_verifikasi') === 'rejected')
                            ->columnSpanFull(),

                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\Placeholder::make('verified_info')
                                    ->label('Informasi Verifikasi')
                                    ->content(function ($record) {
                                        if ($record->verified_at) {
                                            return "Diverifikasi oleh: {$record->verifiedBy?->name}\nTanggal: {$record->verified_at->format('d M Y H:i')}";
                                        }
                                        return 'Belum diverifikasi';
                                    })
                                    ->visible(fn ($record) => $record->verified_at),
                            ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('no_pendaftaran')
                    ->label('No. Pendaftaran')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->copyable(),

                Tables\Columns\TextColumn::make('nama_lengkap')
                    ->label('Nama Lengkap')
                    ->searchable()
                    ->sortable()
                    ->description(fn (Pendaftaran $record): string => $record->nisn)
                    ->wrap(),

                Tables\Columns\TextColumn::make('asal_sekolah')
                    ->label('Asal Sekolah')
                    ->searchable()
                    ->limit(30)
                    ->wrap()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('jurusanPilihan1.nama')
                    ->label('Pilihan 1')
                    ->badge()
                    ->color('success'),

                Tables\Columns\TextColumn::make('jalurMasuk.nama')
                    ->label('Jalur')
                    ->badge()
                    ->color('warning')
                    ->toggleable(),

                Tables\Columns\TextColumn::make('status_verifikasi')
                    ->label('Status Verifikasi')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'approved' => 'success',
                        'rejected' => 'danger',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'pending' => 'Pending',
                        'approved' => 'Disetujui',
                        'rejected' => 'Ditolak',
                        default => $state,
                    })
                    ->sortable(),

                Tables\Columns\TextColumn::make('pembayaran.status')
                    ->label('Status Bayar')
                    ->badge()
                    ->color(fn ($state): string => match ($state) {
                        'pending' => 'warning',
                        'verified' => 'success',
                        'rejected' => 'danger',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn ($state): string => $state ? match ($state) {
                        'pending' => 'Pending',
                        'verified' => 'Lunas',
                        'rejected' => 'Ditolak',
                        default => '-',
                    } : '-')
                    ->default('-')
                    ->toggleable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tanggal Daftar')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('verifiedBy.name')
                    ->label('Diverifikasi Oleh')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('status_verifikasi')
                    ->label('Status Verifikasi')
                    ->options([
                        'pending' => 'Pending',
                        'approved' => 'Disetujui',
                        'rejected' => 'Ditolak',
                    ])
                    ->default('pending'),

                Tables\Filters\SelectFilter::make('jalur_masuk_id')
                    ->label('Jalur Masuk')
                    ->relationship('jalurMasuk', 'nama'),

                Tables\Filters\SelectFilter::make('jurusan_pilihan_1')
                    ->label('Jurusan Pilihan 1')
                    ->relationship('jurusanPilihan1', 'nama'),

                Tables\Filters\Filter::make('created_at')
                    ->form([
                        Forms\Components\DatePicker::make('created_from')
                            ->label('Dari Tanggal')
                            ->native(false),
                        Forms\Components\DatePicker::make('created_until')
                            ->label('Sampai Tanggal')
                            ->native(false),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    }),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->label('Detail'),

                Tables\Actions\Action::make('verify')
                    ->label('Verifikasi')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->form([
                        Forms\Components\Select::make('status_verifikasi')
                            ->label('Status Verifikasi')
                            ->options([
                                'approved' => 'Disetujui',
                                'rejected' => 'Ditolak',
                            ])
                            ->required()
                            ->native(false)
                            ->live(),

                        Forms\Components\Textarea::make('catatan_verifikasi')
                            ->label('Catatan')
                            ->rows(4)
                            ->required(fn (Forms\Get $get) => $get('status_verifikasi') === 'rejected')
                            ->placeholder('Berikan catatan untuk calon siswa...'),
                    ])
                    ->action(function (Pendaftaran $record, array $data): void {
                        $record->update([
                            'status_verifikasi' => $data['status_verifikasi'],
                            'catatan_verifikasi' => $data['catatan_verifikasi'] ?? null,
                            'verified_by' => auth()->id(),
                            'verified_at' => now(),
                        ]);

                        // Update status pendaftaran jika disetujui
                        if ($data['status_verifikasi'] === 'approved') {
                            $record->update(['status_pendaftaran' => 'verified']);
                        }

                        Notification::make()
                            ->title('Verifikasi Berhasil')
                            ->body("Pendaftaran {$record->no_pendaftaran} telah diverifikasi")
                            ->success()
                            ->send();
                    })
                    ->visible(fn (Pendaftaran $record): bool => $record->status_verifikasi === 'pending'),

                Tables\Actions\Action::make('edit_verification')
                    ->label('Edit Verifikasi')
                    ->icon('heroicon-o-pencil')
                    ->color('warning')
                    ->form([
                        Forms\Components\Select::make('status_verifikasi')
                            ->label('Status Verifikasi')
                            ->options([
                                'approved' => 'Disetujui',
                                'rejected' => 'Ditolak',
                            ])
                            ->required()
                            ->native(false),

                        Forms\Components\Textarea::make('catatan_verifikasi')
                            ->label('Catatan')
                            ->rows(4),
                    ])
                    ->fillForm(fn (Pendaftaran $record): array => [
                        'status_verifikasi' => $record->status_verifikasi,
                        'catatan_verifikasi' => $record->catatan_verifikasi,
                    ])
                    ->action(function (Pendaftaran $record, array $data): void {
                        $record->update([
                            'status_verifikasi' => $data['status_verifikasi'],
                            'catatan_verifikasi' => $data['catatan_verifikasi'] ?? null,
                            'verified_by' => auth()->id(),
                            'verified_at' => now(),
                        ]);

                        Notification::make()
                            ->title('Update Verifikasi Berhasil')
                            ->success()
                            ->send();
                    })
                    ->visible(fn (Pendaftaran $record): bool => $record->status_verifikasi !== 'pending'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\BulkAction::make('approve_bulk')
                        ->label('Setujui Terpilih')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->requiresConfirmation()
                        ->form([
                            Forms\Components\Textarea::make('catatan_verifikasi')
                                ->label('Catatan (Opsional)')
                                ->rows(3),
                        ])
                        ->action(function ($records, array $data): void {
                            foreach ($records as $record) {
                                $record->update([
                                    'status_verifikasi' => 'approved',
                                    'status_pendaftaran' => 'verified',
                                    'catatan_verifikasi' => $data['catatan_verifikasi'] ?? null,
                                    'verified_by' => auth()->id(),
                                    'verified_at' => now(),
                                ]);
                            }

                            Notification::make()
                                ->title('Verifikasi Massal Berhasil')
                                ->body(count($records) . ' pendaftaran telah disetujui')
                                ->success()
                                ->send();
                        }),

                    Tables\Actions\BulkAction::make('export')
                        ->label('Export Excel')
                        ->icon('heroicon-o-arrow-down-tray')
                        ->color('info')
                        ->action(function () {
                            Notification::make()
                                ->title('Export dalam proses...')
                                ->info()
                                ->send();
                        }),
                ]),
            ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Section::make('Status Pendaftaran')
                    ->schema([
                        Infolists\Components\Grid::make(3)
                            ->schema([
                                Infolists\Components\TextEntry::make('no_pendaftaran')
                                    ->label('No. Pendaftaran')
                                    ->weight('bold')
                                    ->copyable()
                                    ->icon('heroicon-o-clipboard-document'),

                                Infolists\Components\TextEntry::make('status_verifikasi')
                                    ->label('Status Verifikasi')
                                    ->badge()
                                    ->color(fn (string $state): string => match ($state) {
                                        'pending' => 'warning',
                                        'approved' => 'success',
                                        'rejected' => 'danger',
                                        default => 'gray',
                                    })
                                    ->formatStateUsing(fn (string $state): string => match ($state) {
                                        'pending' => 'Pending',
                                        'approved' => 'Disetujui',
                                        'rejected' => 'Ditolak',
                                        default => $state,
                                    }),

                                Infolists\Components\TextEntry::make('status_pendaftaran')
                                    ->label('Status Pendaftaran')
                                    ->badge()
                                    ->formatStateUsing(fn (string $state): string => str($state)->title()),
                            ]),

                        Infolists\Components\TextEntry::make('catatan_verifikasi')
                            ->label('Catatan Verifikasi')
                            ->color('danger')
                            ->icon('heroicon-o-exclamation-circle')
                            ->visible(fn ($record) => $record->catatan_verifikasi)
                            ->columnSpanFull(),

                        Infolists\Components\Grid::make(2)
                            ->schema([
                                Infolists\Components\TextEntry::make('verifiedBy.name')
                                    ->label('Diverifikasi Oleh')
                                    ->icon('heroicon-o-user'),

                                Infolists\Components\TextEntry::make('verified_at')
                                    ->label('Tanggal Verifikasi')
                                    ->dateTime('d F Y H:i')
                                    ->icon('heroicon-o-clock'),
                            ])
                            ->visible(fn ($record) => $record->verified_at),
                    ]),

                Infolists\Components\Section::make('Data Pribadi')
                    ->schema([
                        Infolists\Components\Grid::make(3)
                            ->schema([
                                Infolists\Components\TextEntry::make('nisn')
                                    ->label('NISN')
                                    ->copyable(),

                                Infolists\Components\TextEntry::make('nik')
                                    ->label('NIK')
                                    ->copyable(),

                                Infolists\Components\TextEntry::make('nama_lengkap')
                                    ->label('Nama Lengkap')
                                    ->weight('bold'),
                            ]),

                        Infolists\Components\Grid::make(3)
                            ->schema([
                                Infolists\Components\TextEntry::make('tempat_lahir')
                                    ->label('Tempat Lahir'),

                                Infolists\Components\TextEntry::make('tanggal_lahir')
                                    ->label('Tanggal Lahir')
                                    ->date('d F Y'),

                                Infolists\Components\TextEntry::make('jenis_kelamin')
                                    ->label('Jenis Kelamin')
                                    ->formatStateUsing(fn (string $state): string =>
                                        $state === 'L' ? 'Laki-laki' : 'Perempuan'
                                    ),
                            ]),

                        Infolists\Components\Grid::make(2)
                            ->schema([
                                Infolists\Components\TextEntry::make('agama')
                                    ->label('Agama'),

                                Infolists\Components\TextEntry::make('no_hp_siswa')
                                    ->label('No. HP')
                                    ->copyable()
                                    ->icon('heroicon-o-phone'),
                            ]),
                    ])
                    ->collapsible(),

                Infolists\Components\Section::make('Alamat')
                    ->schema([
                        Infolists\Components\TextEntry::make('alamat')
                            ->label('Alamat Lengkap')
                            ->columnSpanFull(),

                        Infolists\Components\Grid::make(4)
                            ->schema([
                                Infolists\Components\TextEntry::make('kelurahan')
                                    ->label('Kelurahan'),

                                Infolists\Components\TextEntry::make('kecamatan')
                                    ->label('Kecamatan'),

                                Infolists\Components\TextEntry::make('kota')
                                    ->label('Kota'),

                                Infolists\Components\TextEntry::make('provinsi')
                                    ->label('Provinsi'),
                            ]),
                    ])
                    ->collapsible(),

                Infolists\Components\Section::make('Data Orang Tua')
                    ->schema([
                        Infolists\Components\Grid::make(2)
                            ->schema([
                                Infolists\Components\TextEntry::make('nama_ayah')
                                    ->label('Nama Ayah'),

                                Infolists\Components\TextEntry::make('nama_ibu')
                                    ->label('Nama Ibu'),

                                Infolists\Components\TextEntry::make('pekerjaan_ayah')
                                    ->label('Pekerjaan Ayah'),

                                Infolists\Components\TextEntry::make('pekerjaan_ibu')
                                    ->label('Pekerjaan Ibu'),

                                Infolists\Components\TextEntry::make('no_hp_ayah')
                                    ->label('No. HP Ayah')
                                    ->copyable()
                                    ->icon('heroicon-o-phone'),

                                Infolists\Components\TextEntry::make('no_hp_ibu')
                                    ->label('No. HP Ibu')
                                    ->copyable()
                                    ->icon('heroicon-o-phone'),
                            ]),

                        Infolists\Components\TextEntry::make('penghasilan_ortu')
                            ->label('Penghasilan Orang Tua')
                            ->money('IDR'),
                    ])
                    ->collapsible(),

                Infolists\Components\Section::make('Sekolah Asal & Prestasi')
                    ->schema([
                        Infolists\Components\Grid::make(2)
                            ->schema([
                                Infolists\Components\TextEntry::make('asal_sekolah')
                                    ->label('Nama Sekolah')
                                    ->icon('heroicon-o-academic-cap'),

                                Infolists\Components\TextEntry::make('npsn_sekolah')
                                    ->label('NPSN'),

                                Infolists\Components\TextEntry::make('tahun_lulus')
                                    ->label('Tahun Lulus'),

                                Infolists\Components\TextEntry::make('nilai_un')
                                    ->label('Nilai UN/Ijazah')
                                    ->numeric(decimalPlaces: 2)
                                    ->badge()
                                    ->color('success'),
                            ]),
                    ])
                    ->collapsible(),

                Infolists\Components\Section::make('Pilihan Jurusan')
                    ->schema([
                        Infolists\Components\Grid::make(2)
                            ->schema([
                                Infolists\Components\TextEntry::make('jurusanPilihan1.nama')
                                    ->label('Pilihan 1')
                                    ->badge()
                                    ->color('success')
                                    ->icon('heroicon-o-star'),

                                Infolists\Components\TextEntry::make('jurusanPilihan2.nama')
                                    ->label('Pilihan 2')
                                    ->badge()
                                    ->color('info')
                                    ->icon('heroicon-o-star'),
                            ]),

                        Infolists\Components\TextEntry::make('jalurMasuk.nama')
                            ->label('Jalur Masuk')
                            ->badge()
                            ->color('warning'),
                    ]),

                Infolists\Components\Section::make('Status Pembayaran')
                    ->schema([
                        Infolists\Components\Grid::make(3)
                            ->schema([
                                Infolists\Components\TextEntry::make('pembayaran.no_invoice')
                                    ->label('No. Invoice')
                                    ->copyable()
                                    ->default('-'),

                                Infolists\Components\TextEntry::make('pembayaran.jumlah')
                                    ->label('Jumlah')
                                    ->money('IDR')
                                    ->default('-'),

                                Infolists\Components\TextEntry::make('pembayaran.status')
                                    ->label('Status')
                                    ->badge()
                                    ->color(fn ($state): string => match ($state) {
                                        'pending' => 'warning',
                                        'verified' => 'success',
                                        'rejected' => 'danger',
                                        default => 'gray',
                                    })
                                    ->formatStateUsing(fn ($state): string => $state ? match ($state) {
                                        'pending' => 'Pending',
                                        'verified' => 'Lunas',
                                        'rejected' => 'Ditolak',
                                        default => '-',
                                    } : '-')
                                    ->default('-'),
                            ]),
                    ])
                    ->visible(fn ($record) => $record->pembayaran)
                    ->collapsible(),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\DokumenSiswasRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListVerifikasiPendaftarans::route('/'),
            //'view' => Pages\ViewVerifikasiPendaftaran::route('/{record}'),
        ];
    }
}