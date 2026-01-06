<?php

namespace App\Filament\Panitia\Resources;

use App\Filament\Panitia\Resources\VerifikasiPendaftaranResource\Pages;
use App\Models\Pendaftaran;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components;
use Illuminate\Database\Eloquent\Builder;
use Filament\Notifications\Notification;

class VerifikasiPendaftaranResource extends Resource
{
    protected static ?string $model = Pendaftaran::class;
    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-check';
    protected static ?string $navigationLabel = 'Verifikasi Pendaftaran';
    protected static ?string $navigationGroup = 'Verifikasi';
    protected static ?int $navigationSort = 1;

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('no_pendaftaran')
                    ->label('No. Pendaftaran')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('nama_lengkap')
                    ->label('Nama Lengkap')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('nisn')
                    ->label('NISN')
                    ->searchable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('asal_sekolah')
                    ->label('Asal Sekolah')
                    ->searchable()
                    ->limit(30)
                    ->toggleable(),

                Tables\Columns\TextColumn::make('jalurMasuk.nama')
                    ->label('Jalur Masuk')
                    ->badge()
                    ->color('info'),

                Tables\Columns\TextColumn::make('jurusanPilihan1.nama')
                    ->label('Jurusan Pilihan 1')
                    ->badge()
                    ->color('success'),

                Tables\Columns\BadgeColumn::make('status_pendaftaran')
                    ->label('Status Pendaftaran')
                    ->colors([
                        'warning' => 'draft',
                        'info' => 'submitted',
                        'primary' => 'verified',
                        'success' => 'accepted',
                        'danger' => 'rejected',
                    ])
                    ->icons([
                        'heroicon-o-clock' => 'draft',
                        'heroicon-o-paper-airplane' => 'submitted',
                        'heroicon-o-check-circle' => 'verified',
                        'heroicon-o-check-badge' => 'accepted',
                        'heroicon-o-x-circle' => 'rejected',
                    ]),

                Tables\Columns\BadgeColumn::make('status_verifikasi')
                    ->label('Status Verifikasi')
                    ->colors([
                        'warning' => 'pending',
                        'success' => 'approved',
                        'danger' => 'rejected',
                    ]),

                Tables\Columns\TextColumn::make('tanggal_daftar')
                    ->label('Tanggal Daftar')
                    ->date('d M Y')
                    ->sortable()
                    ->toggleable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status_pendaftaran')
                    ->label('Status Pendaftaran')
                    ->options([
                        'draft' => 'Draft',
                        'submitted' => 'Submitted',
                        'verified' => 'Verified',
                        'accepted' => 'Diterima',
                        'rejected' => 'Ditolak',
                    ]),

                Tables\Filters\SelectFilter::make('status_verifikasi')
                    ->label('Status Verifikasi')
                    ->options([
                        'pending' => 'Pending',
                        'approved' => 'Approved',
                        'rejected' => 'Rejected',
                    ]),

                Tables\Filters\SelectFilter::make('jalur_masuk_id')
                    ->label('Jalur Masuk')
                    ->relationship('jalurMasuk', 'nama'),

                Tables\Filters\SelectFilter::make('jurusan_pilihan_1')
                    ->label('Jurusan Pilihan 1')
                    ->relationship('jurusanPilihan1', 'nama'),

                Tables\Filters\SelectFilter::make('gelombang_id')
                    ->label('Gelombang')
                    ->relationship('gelombang', 'nama'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->label('Detail'),

                // ACTION: TERIMA PENDAFTARAN
                Tables\Actions\Action::make('accept')
                    ->label('Terima')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->modalHeading('Terima Pendaftaran')
                    ->modalDescription('Apakah Anda yakin ingin menerima pendaftaran ini?')
                    ->modalSubmitActionLabel('Ya, Terima')
                    ->visible(fn (Pendaftaran $record) => 
                        in_array($record->status_pendaftaran, ['submitted', 'verified'])
                    )
                    ->action(function (Pendaftaran $record) {
                        $record->update([
                            'status_pendaftaran' => 'accepted',
                            'status_verifikasi' => 'approved',
                        ]);

                        Notification::make()
                            ->title('Pendaftaran Diterima')
                            ->success()
                            ->body("Pendaftaran {$record->nama_lengkap} telah diterima.")
                            ->send();
                    }),

                // ACTION: TOLAK PENDAFTARAN
                Tables\Actions\Action::make('reject')
                    ->label('Tolak')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->modalHeading('Tolak Pendaftaran')
                    ->modalDescription('Berikan alasan penolakan')
                    ->form([
                        Forms\Components\Textarea::make('catatan')
                            ->label('Alasan Penolakan')
                            ->required()
                            ->rows(3)
                            ->placeholder('Tuliskan alasan penolakan...'),
                    ])
                    ->visible(fn (Pendaftaran $record) => 
                        in_array($record->status_pendaftaran, ['submitted', 'verified'])
                    )
                    ->action(function (Pendaftaran $record, array $data) {
                        $record->update([
                            'status_pendaftaran' => 'rejected',
                            'status_verifikasi' => 'rejected',
                            'catatan_verifikasi' => $data['catatan'],
                        ]);

                        Notification::make()
                            ->title('Pendaftaran Ditolak')
                            ->danger()
                            ->body("Pendaftaran {$record->nama_lengkap} telah ditolak.")
                            ->send();
                    }),

                // ACTION: KEMBALIKAN KE REVIEW
                Tables\Actions\Action::make('review')
                    ->label('Review')
                    ->icon('heroicon-o-arrow-path')
                    ->color('warning')
                    ->requiresConfirmation()
                    ->modalHeading('Kembalikan untuk Review')
                    ->modalDescription('Pendaftaran akan dikembalikan ke status verified untuk ditinjau ulang')
                    ->visible(fn (Pendaftaran $record) => 
                        in_array($record->status_pendaftaran, ['accepted', 'rejected'])
                    )
                    ->action(function (Pendaftaran $record) {
                        $record->update([
                            'status_pendaftaran' => 'verified',
                            'status_verifikasi' => 'pending',
                            'catatan_verifikasi' => null,
                        ]);

                        Notification::make()
                            ->title('Dikembalikan untuk Review')
                            ->warning()
                            ->send();
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    // BULK ACTION: TERIMA BANYAK
                    Tables\Actions\BulkAction::make('acceptMultiple')
                        ->label('Terima Terpilih')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->requiresConfirmation()
                        ->modalHeading('Terima Pendaftaran Terpilih')
                        ->modalDescription('Apakah Anda yakin ingin menerima semua pendaftaran yang dipilih?')
                        ->action(function ($records) {
                            $count = 0;
                            foreach ($records as $record) {
                                if (in_array($record->status_pendaftaran, ['submitted', 'verified'])) {
                                    $record->update([
                                        'status_pendaftaran' => 'accepted',
                                        'status_verifikasi' => 'approved',
                                    ]);
                                    $count++;
                                }
                            }

                            Notification::make()
                                ->title("Berhasil Menerima {$count} Pendaftaran")
                                ->success()
                                ->send();
                        }),

                    // BULK ACTION: TOLAK BANYAK
                    Tables\Actions\BulkAction::make('rejectMultiple')
                        ->label('Tolak Terpilih')
                        ->icon('heroicon-o-x-circle')
                        ->color('danger')
                        ->requiresConfirmation()
                        ->modalHeading('Tolak Pendaftaran Terpilih')
                        ->form([
                            Forms\Components\Textarea::make('catatan')
                                ->label('Alasan Penolakan')
                                ->required()
                                ->rows(3),
                        ])
                        ->action(function ($records, array $data) {
                            $count = 0;
                            foreach ($records as $record) {
                                if (in_array($record->status_pendaftaran, ['submitted', 'verified'])) {
                                    $record->update([
                                        'status_pendaftaran' => 'rejected',
                                        'status_verifikasi' => 'rejected',
                                        'catatan_verifikasi' => $data['catatan'],
                                    ]);
                                    $count++;
                                }
                            }

                            Notification::make()
                                ->title("Berhasil Menolak {$count} Pendaftaran")
                                ->danger()
                                ->send();
                        }),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Components\Section::make('Status Pendaftaran')
                    ->schema([
                        Components\TextEntry::make('no_pendaftaran')
                            ->label('No. Pendaftaran')
                            ->size('lg')
                            ->weight('bold')
                            ->copyable(),
                        Components\TextEntry::make('status_pendaftaran')
                            ->label('Status')
                            ->badge()
                            ->color(fn (string $state): string => match ($state) {
                                'draft' => 'warning',
                                'submitted' => 'info',
                                'verified' => 'primary',
                                'accepted' => 'success',
                                'rejected' => 'danger',
                                default => 'gray',
                            }),
                        Components\TextEntry::make('tanggal_daftar')
                            ->label('Tanggal Daftar')
                            ->date('d F Y'),
                        Components\TextEntry::make('catatan_verifikasi')
                            ->label('Catatan Verifikasi')
                            ->visible(fn ($record) => !empty($record->catatan_verifikasi))
                            ->color('danger'),
                    ])
                    ->columns(2),

                Components\Section::make('Data Pribadi')
                    ->schema([
                        Components\TextEntry::make('nama_lengkap')
                            ->label('Nama Lengkap'),
                        Components\TextEntry::make('nisn')
                            ->label('NISN'),
                        Components\TextEntry::make('nik')
                            ->label('NIK'),
                        Components\TextEntry::make('tempat_lahir')
                            ->label('Tempat Lahir'),
                        Components\TextEntry::make('tanggal_lahir')
                            ->label('Tanggal Lahir')
                            ->date('d F Y'),
                        Components\TextEntry::make('jenis_kelamin')
                            ->label('Jenis Kelamin')
                            ->formatStateUsing(fn (string $state): string => $state === 'L' ? 'Laki-laki' : 'Perempuan'),
                        Components\TextEntry::make('agama')
                            ->label('Agama'),
                        Components\TextEntry::make('no_hp_siswa')
                            ->label('No. HP'),
                        Components\TextEntry::make('email_siswa')
                            ->label('Email'),
                    ])
                    ->columns(3),

                Components\Section::make('Alamat')
                    ->schema([
                        Components\TextEntry::make('alamat')
                            ->label('Alamat Lengkap')
                            ->columnSpanFull(),
                        Components\TextEntry::make('kelurahan')
                            ->label('Kelurahan'),
                        Components\TextEntry::make('kecamatan')
                            ->label('Kecamatan'),
                        Components\TextEntry::make('kota')
                            ->label('Kota'),
                        Components\TextEntry::make('provinsi')
                            ->label('Provinsi'),
                    ])
                    ->columns(4),

                Components\Section::make('Data Orang Tua')
                    ->schema([
                        Components\TextEntry::make('nama_ayah')
                            ->label('Nama Ayah'),
                        Components\TextEntry::make('pekerjaan_ayah')
                            ->label('Pekerjaan Ayah'),
                        Components\TextEntry::make('no_hp_ayah')
                            ->label('No. HP Ayah'),
                        Components\TextEntry::make('nama_ibu')
                            ->label('Nama Ibu'),
                        Components\TextEntry::make('pekerjaan_ibu')
                            ->label('Pekerjaan Ibu'),
                        Components\TextEntry::make('no_hp_ibu')
                            ->label('No. HP Ibu'),
                    ])
                    ->columns(3),

                Components\Section::make('Data Sekolah Asal')
                    ->schema([
                        Components\TextEntry::make('asal_sekolah')
                            ->label('Nama Sekolah'),
                        Components\TextEntry::make('npsn_sekolah')
                            ->label('NPSN'),
                        Components\TextEntry::make('tahun_lulus')
                            ->label('Tahun Lulus'),
                        Components\TextEntry::make('nilai_un')
                            ->label('Nilai UN'),
                    ])
                    ->columns(4),

                Components\Section::make('Pilihan Jurusan')
                    ->schema([
                        Components\TextEntry::make('jalurMasuk.nama')
                            ->label('Jalur Masuk')
                            ->badge()
                            ->color('info'),
                        Components\TextEntry::make('jurusanPilihan1.nama')
                            ->label('Jurusan Pilihan 1')
                            ->badge()
                            ->color('success'),
                        Components\TextEntry::make('jurusanPilihan2.nama')
                            ->label('Jurusan Pilihan 2')
                            ->badge()
                            ->color('warning')
                            ->default('-'),
                    ])
                    ->columns(3),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListVerifikasiPendaftarans::route('/'),
            'view' => Pages\ViewVerifikasiPendaftaran::route('/{record}'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        // Hanya tampilkan yang sudah submit
        return parent::getEloquentQuery()
            ->whereIn('status_pendaftaran', ['submitted', 'verified', 'accepted', 'rejected']);
    }
}