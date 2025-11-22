<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PendaftaranResource\Pages;
use App\Filament\Resources\PendaftaranResource\RelationManagers;
use App\Models\Pendaftaran;
use App\Models\TahunAjaran;
use App\Models\Gelombang;
use App\Models\JalurMasuk;
use App\Models\Jurusan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Illuminate\Database\Eloquent\Builder;

class PendaftaranResource extends Resource
{
    protected static ?string $model = Pendaftaran::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';

    protected static ?string $navigationGroup = 'Pendaftaran';

    protected static ?int $navigationSort = 1;

    protected static ?string $navigationLabel = 'Data Pendaftaran';

    protected static ?string $recordTitleAttribute = 'no_pendaftaran';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Wizard::make([
                    Forms\Components\Wizard\Step::make('Informasi Dasar')
                        ->schema([
                            Forms\Components\Section::make()
                                ->schema([
                                    Forms\Components\TextInput::make('no_pendaftaran')
                                        ->label('No. Pendaftaran')
                                        ->disabled()
                                        ->dehydrated(false)
                                        ->placeholder('Auto Generate'),

                                    Forms\Components\Grid::make(3)
                                        ->schema([
                                            Forms\Components\Select::make('tahun_ajaran_id')
                                                ->label('Tahun Ajaran')
                                                ->options(TahunAjaran::active()->pluck('nama', 'id'))
                                                ->required()
                                                ->searchable()
                                                ->preload()
                                                ->live(),

                                            Forms\Components\Select::make('gelombang_id')
                                                ->label('Gelombang')
                                                ->options(fn (Forms\Get $get) => 
                                                    Gelombang::where('tahun_ajaran_id', $get('tahun_ajaran_id'))
                                                        ->pluck('nama', 'id')
                                                )
                                                ->required()
                                                ->searchable()
                                                ->preload(),

                                            Forms\Components\Select::make('jalur_masuk_id')
                                                ->label('Jalur Masuk')
                                                ->options(JalurMasuk::active()->pluck('nama', 'id'))
                                                ->required()
                                                ->searchable()
                                                ->preload(),
                                        ]),
                                ]),
                        ]),

                    Forms\Components\Wizard\Step::make('Data Pribadi')
                        ->schema([
                            Forms\Components\Section::make('Identitas')
                                ->schema([
                                    Forms\Components\Grid::make(2)
                                        ->schema([
                                            Forms\Components\TextInput::make('nisn')
                                                ->label('NISN')
                                                ->required()
                                                ->maxLength(10)
                                                ->unique(ignoreRecord: true),

                                            Forms\Components\TextInput::make('nik')
                                                ->label('NIK')
                                                ->required()
                                                ->maxLength(16)
                                                ->unique(ignoreRecord: true),
                                        ]),

                                    Forms\Components\TextInput::make('nama_lengkap')
                                        ->label('Nama Lengkap')
                                        ->required()
                                        ->maxLength(255),

                                    Forms\Components\Grid::make(3)
                                        ->schema([
                                            Forms\Components\TextInput::make('tempat_lahir')
                                                ->label('Tempat Lahir')
                                                ->required()
                                                ->maxLength(255),

                                            Forms\Components\DatePicker::make('tanggal_lahir')
                                                ->label('Tanggal Lahir')
                                                ->required()
                                                ->native(false)
                                                ->displayFormat('d/m/Y')
                                                ->maxDate(now()),

                                            Forms\Components\Select::make('jenis_kelamin')
                                                ->label('Jenis Kelamin')
                                                ->required()
                                                ->options([
                                                    'L' => 'Laki-laki',
                                                    'P' => 'Perempuan',
                                                ])
                                                ->native(false),
                                        ]),

                                    Forms\Components\Select::make('agama')
                                        ->label('Agama')
                                        ->required()
                                        ->options([
                                            'Islam' => 'Islam',
                                            'Kristen' => 'Kristen',
                                            'Katolik' => 'Katolik',
                                            'Hindu' => 'Hindu',
                                            'Buddha' => 'Buddha',
                                            'Konghucu' => 'Konghucu',
                                        ])
                                        ->native(false),
                                ]),

                            Forms\Components\Section::make('Alamat')
                                ->schema([
                                    Forms\Components\Textarea::make('alamat')
                                        ->label('Alamat Lengkap')
                                        ->required()
                                        ->rows(3),

                                    Forms\Components\Grid::make(4)
                                        ->schema([
                                            Forms\Components\TextInput::make('rt')
                                                ->label('RT')
                                                ->maxLength(3),

                                            Forms\Components\TextInput::make('rw')
                                                ->label('RW')
                                                ->maxLength(3),

                                            Forms\Components\TextInput::make('kode_pos')
                                                ->label('Kode Pos')
                                                ->maxLength(5),

                                            Forms\Components\TextInput::make('kelurahan')
                                                ->label('Kelurahan/Desa')
                                                ->required()
                                                ->maxLength(255),
                                        ]),

                                    Forms\Components\Grid::make(3)
                                        ->schema([
                                            Forms\Components\TextInput::make('kecamatan')
                                                ->label('Kecamatan')
                                                ->required()
                                                ->maxLength(255),

                                            Forms\Components\TextInput::make('kota')
                                                ->label('Kota/Kabupaten')
                                                ->required()
                                                ->maxLength(255),

                                            Forms\Components\TextInput::make('provinsi')
                                                ->label('Provinsi')
                                                ->required()
                                                ->maxLength(255),
                                        ]),
                                ]),

                            Forms\Components\Section::make('Kontak')
                                ->schema([
                                    Forms\Components\Grid::make(2)
                                        ->schema([
                                            Forms\Components\TextInput::make('no_hp_siswa')
                                                ->label('No. HP Siswa')
                                                ->required()
                                                ->tel()
                                                ->maxLength(15),

                                            Forms\Components\TextInput::make('email_siswa')
                                                ->label('Email Siswa')
                                                ->required()
                                                ->email()
                                                ->maxLength(255),
                                        ]),
                                ]),
                        ]),

                    Forms\Components\Wizard\Step::make('Data Orang Tua')
                        ->schema([
                            Forms\Components\Section::make('Data Ayah')
                                ->schema([
                                    Forms\Components\Grid::make(2)
                                        ->schema([
                                            Forms\Components\TextInput::make('nama_ayah')
                                                ->label('Nama Ayah')
                                                ->required()
                                                ->maxLength(255),

                                            Forms\Components\TextInput::make('pekerjaan_ayah')
                                                ->label('Pekerjaan Ayah')
                                                ->maxLength(255),

                                            Forms\Components\TextInput::make('no_hp_ayah')
                                                ->label('No. HP Ayah')
                                                ->tel()
                                                ->maxLength(15),
                                        ]),
                                ]),

                            Forms\Components\Section::make('Data Ibu')
                                ->schema([
                                    Forms\Components\Grid::make(2)
                                        ->schema([
                                            Forms\Components\TextInput::make('nama_ibu')
                                                ->label('Nama Ibu')
                                                ->required()
                                                ->maxLength(255),

                                            Forms\Components\TextInput::make('pekerjaan_ibu')
                                                ->label('Pekerjaan Ibu')
                                                ->maxLength(255),

                                            Forms\Components\TextInput::make('no_hp_ibu')
                                                ->label('No. HP Ibu')
                                                ->tel()
                                                ->maxLength(15),
                                        ]),
                                ]),

                            Forms\Components\Section::make('Data Wali (Opsional)')
                                ->schema([
                                    Forms\Components\Grid::make(2)
                                        ->schema([
                                            Forms\Components\TextInput::make('nama_wali')
                                                ->label('Nama Wali')
                                                ->maxLength(255),

                                            Forms\Components\TextInput::make('pekerjaan_wali')
                                                ->label('Pekerjaan Wali')
                                                ->maxLength(255),

                                            Forms\Components\TextInput::make('no_hp_wali')
                                                ->label('No. HP Wali')
                                                ->tel()
                                                ->maxLength(15),
                                        ]),
                                ])
                                ->collapsible(),

                            Forms\Components\Section::make('Penghasilan')
                                ->schema([
                                    Forms\Components\TextInput::make('penghasilan_ortu')
                                        ->label('Penghasilan Orang Tua/Wali')
                                        ->numeric()
                                        ->prefix('Rp')
                                        ->placeholder('5000000'),
                                ]),
                        ]),

                    Forms\Components\Wizard\Step::make('Sekolah Asal')
                        ->schema([
                            Forms\Components\Section::make()
                                ->schema([
                                    Forms\Components\TextInput::make('asal_sekolah')
                                        ->label('Nama Sekolah')
                                        ->required()
                                        ->maxLength(255),

                                    Forms\Components\TextInput::make('npsn_sekolah')
                                        ->label('NPSN Sekolah')
                                        ->maxLength(8),

                                    Forms\Components\Textarea::make('alamat_sekolah')
                                        ->label('Alamat Sekolah')
                                        ->rows(3),

                                    Forms\Components\Grid::make(2)
                                        ->schema([
                                            Forms\Components\TextInput::make('tahun_lulus')
                                                ->label('Tahun Lulus')
                                                ->required()
                                                ->numeric()
                                                ->minValue(2010)
                                                ->maxValue(now()->year),

                                            Forms\Components\TextInput::make('nilai_un')
                                                ->label('Nilai UN/Rata-rata Ijazah')
                                                ->numeric()
                                                ->minValue(0)
                                                ->maxValue(100)
                                                ->step(0.01)
                                                ->suffix('poin'),
                                        ]),
                                ]),
                        ]),

                    Forms\Components\Wizard\Step::make('Pilihan Jurusan')
                        ->schema([
                            Forms\Components\Section::make()
                                ->schema([
                                    Forms\Components\Select::make('jurusan_pilihan_1')
                                        ->label('Pilihan Jurusan 1')
                                        ->options(Jurusan::active()->pluck('nama', 'id'))
                                        ->required()
                                        ->searchable()
                                        ->preload()
                                        ->live(),

                                    Forms\Components\Select::make('jurusan_pilihan_2')
                                    ->label('Pilihan Jurusan 2 (Opsional)')
->options(fn (Forms\Get $get) =>
Jurusan::active()
->where('id', '!=', $get('jurusan_pilihan_1'))
->pluck('nama', 'id')
)
->searchable()
->preload(),
]),
]),
                Forms\Components\Wizard\Step::make('Status & Verifikasi')
                    ->schema([
                        Forms\Components\Section::make('Status Pendaftaran')
                            ->schema([
                                Forms\Components\Select::make('status_pendaftaran')
                                    ->label('Status Pendaftaran')
                                    ->options([
                                        'draft' => 'Draft',
                                        'submitted' => 'Submitted',
                                        'verified' => 'Verified',
                                        'rejected' => 'Rejected',
                                        'accepted' => 'Accepted',
                                        'confirmed' => 'Confirmed',
                                    ])
                                    ->required()
                                    ->native(false)
                                    ->default('draft'),

                                Forms\Components\Select::make('status_verifikasi')
                                    ->label('Status Verifikasi')
                                    ->options([
                                        'pending' => 'Pending',
                                        'approved' => 'Approved',
                                        'rejected' => 'Rejected',
                                    ])
                                    ->required()
                                    ->native(false)
                                    ->default('pending'),

                                Forms\Components\Textarea::make('catatan_verifikasi')
                                    ->label('Catatan Verifikasi')
                                    ->rows(3)
                                    ->placeholder('Catatan untuk calon siswa'),
                            ]),

                        Forms\Components\Section::make('Hasil Seleksi')
                            ->schema([
                                Forms\Components\TextInput::make('nilai_akhir')
                                    ->label('Nilai Akhir')
                                    ->numeric()
                                    ->minValue(0)
                                    ->maxValue(100)
                                    ->step(0.01),

                                Forms\Components\Select::make('jurusan_diterima')
                                    ->label('Jurusan Diterima')
                                    ->options(Jurusan::active()->pluck('nama', 'id'))
                                    ->searchable()
                                    ->preload(),

                                Forms\Components\Textarea::make('catatan_seleksi')
                                    ->label('Catatan Seleksi')
                                    ->rows(3),
                            ])
                            ->collapsible(),
                    ]),
            ])
            ->columnSpanFull()
            ->persistStepInQueryString()
            ->submitAction(new \Filament\Support\HtmlString('<button type="submit">Submit</button>')),
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
                ->copyable()
                ->copyMessage('Disalin!')
                ->copyMessageDuration(1500),

            Tables\Columns\TextColumn::make('nama_lengkap')
                ->label('Nama Lengkap')
                ->searchable()
                ->sortable()
                ->weight('medium'),

            Tables\Columns\TextColumn::make('nisn')
                ->label('NISN')
                ->searchable()
                ->toggleable(),

            Tables\Columns\TextColumn::make('asal_sekolah')
                ->label('Asal Sekolah')
                ->searchable()
                ->limit(30)
                ->toggleable(),

            Tables\Columns\TextColumn::make('jurusanPilihan1.nama')
                ->label('Pilihan 1')
                ->badge()
                ->color('success')
                ->searchable(),

            Tables\Columns\TextColumn::make('jurusanPilihan2.nama')
                ->label('Pilihan 2')
                ->badge()
                ->color('info')
                ->searchable()
                ->toggleable(),

            Tables\Columns\TextColumn::make('jalurMasuk.nama')
                ->label('Jalur')
                ->badge()
                ->color('warning')
                ->toggleable(),

            Tables\Columns\TextColumn::make('status_pendaftaran')
                ->label('Status')
                ->badge()
                ->color(fn (string $state): string => match ($state) {
                    'draft' => 'gray',
                    'submitted' => 'info',
                    'verified' => 'primary',
                    'rejected' => 'danger',
                    'accepted' => 'success',
                    'confirmed' => 'success',
                    default => 'gray',
                })
                ->formatStateUsing(fn (string $state): string => str($state)->title())
                ->sortable(),

            Tables\Columns\TextColumn::make('status_verifikasi')
                ->label('Verifikasi')
                ->badge()
                ->color(fn (string $state): string => match ($state) {
                    'pending' => 'warning',
                    'approved' => 'success',
                    'rejected' => 'danger',
                    default => 'gray',
                })
                ->formatStateUsing(fn (string $state): string => str($state)->title())
                ->sortable(),

            Tables\Columns\TextColumn::make('nilai_akhir')
                ->label('Nilai')
                ->numeric(decimalPlaces: 2)
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),

            Tables\Columns\TextColumn::make('jurusanDiterima.nama')
                ->label('Diterima Di')
                ->badge()
                ->color('success')
                ->toggleable(isToggledHiddenByDefault: true),

            Tables\Columns\TextColumn::make('created_at')
                ->label('Tanggal Daftar')
                ->dateTime('d M Y H:i')
                ->sortable()
                ->toggleable(),
        ])
        ->filters([
            Tables\Filters\SelectFilter::make('tahun_ajaran_id')
                ->label('Tahun Ajaran')
                ->options(TahunAjaran::pluck('nama', 'id'))
                ->searchable(),

            Tables\Filters\SelectFilter::make('gelombang_id')
                ->label('Gelombang')
                ->options(Gelombang::pluck('nama', 'id'))
                ->searchable(),

            Tables\Filters\SelectFilter::make('jalur_masuk_id')
                ->label('Jalur Masuk')
                ->options(JalurMasuk::pluck('nama', 'id')),

            Tables\Filters\SelectFilter::make('jurusan_pilihan_1')
                ->label('Jurusan Pilihan 1')
                ->options(Jurusan::pluck('nama', 'id'))
                ->searchable(),

            Tables\Filters\SelectFilter::make('status_pendaftaran')
                ->label('Status Pendaftaran')
                ->options([
                    'draft' => 'Draft',
                    'submitted' => 'Submitted',
                    'verified' => 'Verified',
                    'rejected' => 'Rejected',
                    'accepted' => 'Accepted',
                    'confirmed' => 'Confirmed',
                ])
                ->multiple(),

            Tables\Filters\SelectFilter::make('status_verifikasi')
                ->label('Status Verifikasi')
                ->options([
                    'pending' => 'Pending',
                    'approved' => 'Approved',
                    'rejected' => 'Rejected',
                ])
                ->multiple(),

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
            Tables\Actions\ViewAction::make(),
            Tables\Actions\EditAction::make(),
            
            Tables\Actions\Action::make('verify')
                ->label('Verifikasi')
                ->icon('heroicon-o-check-circle')
                ->color('success')
                ->requiresConfirmation()
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
                        ->rows(3),
                ])
                ->action(function (Pendaftaran $record, array $data): void {
                    $record->update([
                        'status_verifikasi' => $data['status_verifikasi'],
                        'catatan_verifikasi' => $data['catatan_verifikasi'],
                        'verified_by' => auth()->id(),
                        'verified_at' => now(),
                    ]);
                    
                    \Filament\Notifications\Notification::make()
                        ->title('Verifikasi Berhasil')
                        ->success()
                        ->send();
                })
                ->visible(fn (Pendaftaran $record): bool => $record->status_verifikasi === 'pending'),

            Tables\Actions\Action::make('accept')
                ->label('Terima')
                ->icon('heroicon-o-check-badge')
                ->color('success')
                ->requiresConfirmation()
                ->form([
                    Forms\Components\Select::make('jurusan_diterima')
                        ->label('Diterima di Jurusan')
                        ->options(Jurusan::active()->pluck('nama', 'id'))
                        ->required()
                        ->searchable(),
                    
                    Forms\Components\TextInput::make('nilai_akhir')
                        ->label('Nilai Akhir')
                        ->numeric()
                        ->required()
                        ->minValue(0)
                        ->maxValue(100),
                    
                    Forms\Components\Textarea::make('catatan_seleksi')
                        ->label('Catatan')
                        ->rows(3),
                ])
                ->action(function (Pendaftaran $record, array $data): void {
                    $record->update([
                        'status_pendaftaran' => 'accepted',
                        'jurusan_diterima' => $data['jurusan_diterima'],
                        'nilai_akhir' => $data['nilai_akhir'],
                        'catatan_seleksi' => $data['catatan_seleksi'],
                    ]);
                    
                    \Filament\Notifications\Notification::make()
                        ->title('Siswa Diterima')
                        ->success()
                        ->send();
                })
                ->visible(fn (Pendaftaran $record): bool => 
                    $record->status_verifikasi === 'approved' && 
                    $record->status_pendaftaran !== 'accepted'
                ),

            Tables\Actions\DeleteAction::make(),
        ])
        ->bulkActions([
            Tables\Actions\BulkActionGroup::make([
                Tables\Actions\DeleteBulkAction::make(),
                
                Tables\Actions\BulkAction::make('export')
                    ->label('Export Excel')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->action(function () {
                        \Filament\Notifications\Notification::make()
                            ->title('Export dalam proses...')
                            ->info()
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
            Infolists\Components\Section::make('Informasi Pendaftaran')
                ->schema([
                    Infolists\Components\Grid::make(3)
                        ->schema([
                            Infolists\Components\TextEntry::make('no_pendaftaran')
                                ->label('No. Pendaftaran')
                                ->weight('bold')
                                ->copyable(),
                            
                            Infolists\Components\TextEntry::make('tahunAjaran.nama')
                                ->label('Tahun Ajaran')
                                ->badge()
                                ->color('primary'),
                            
                            Infolists\Components\TextEntry::make('gelombang.nama')
                                ->label('Gelombang')
                                ->badge()
                                ->color('info'),
                        ]),
                    
                    Infolists\Components\Grid::make(3)
                        ->schema([
                            Infolists\Components\TextEntry::make('jalurMasuk.nama')
                                ->label('Jalur Masuk')
                                ->badge()
                                ->color('warning'),
                            
                            Infolists\Components\TextEntry::make('status_pendaftaran')
                                ->label('Status Pendaftaran')
                                ->badge()
                                ->formatStateUsing(fn (string $state): string => str($state)->title()),
                            
                            Infolists\Components\TextEntry::make('status_verifikasi')
                                ->label('Status Verifikasi')
                                ->badge()
                                ->formatStateUsing(fn (string $state): string => str($state)->title()),
                        ]),
                ])
                ->columns(1),

            Infolists\Components\Section::make('Data Pribadi')
                ->schema([
                    Infolists\Components\Grid::make(3)
                        ->schema([
                            Infolists\Components\TextEntry::make('nisn')
                                ->label('NISN'),
                            
                            Infolists\Components\TextEntry::make('nik')
                                ->label('NIK'),
                            
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
                                ->copyable(),
                        ]),
                ])
                ->columns(1)
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
                ->columns(1)
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
                                ->copyable(),
                            
                            Infolists\Components\TextEntry::make('no_hp_ibu')
                                ->label('No. HP Ibu')
                                ->copyable(),
                        ]),
                    
                    Infolists\Components\TextEntry::make('penghasilan_ortu')
                        ->label('Penghasilan Orang Tua')
                        ->money('IDR'),
                ])
                ->columns(1)
                ->collapsible(),

            Infolists\Components\Section::make('Sekolah Asal')
                ->schema([
                    Infolists\Components\Grid::make(2)
                        ->schema([
                            Infolists\Components\TextEntry::make('asal_sekolah')
                                ->label('Nama Sekolah'),
                            
                            Infolists\Components\TextEntry::make('npsn_sekolah')
                                ->label('NPSN'),
                            
                            Infolists\Components\TextEntry::make('tahun_lulus')
                                ->label('Tahun Lulus'),
                            
                            Infolists\Components\TextEntry::make('nilai_un')
                                ->label('Nilai UN/Ijazah')
                                ->numeric(decimalPlaces: 2),
                        ]),
                ])
                ->columns(1)
                ->collapsible(),

            Infolists\Components\Section::make('Pilihan Jurusan')
                ->schema([
                    Infolists\Components\Grid::make(2)
                        ->schema([
                            Infolists\Components\TextEntry::make('jurusanPilihan1.nama')
                                ->label('Pilihan 1')
                                ->badge()
                                ->color('success'),
                            
                            Infolists\Components\TextEntry::make('jurusanPilihan2.nama')
                                ->label('Pilihan 2')
                                ->badge()
                                ->color('info'),
                        ]),
                ])
                ->columns(1),

            Infolists\Components\Section::make('Hasil Seleksi')
                ->schema([
                    Infolists\Components\Grid::make(3)
                        ->schema([
                            Infolists\Components\TextEntry::make('nilai_akhir')
                                ->label('Nilai Akhir')
                                ->numeric(decimalPlaces: 2)
                                ->badge()
                                ->color('success'),
                            
                            Infolists\Components\TextEntry::make('jurusanDiterima.nama')
                                ->label('Diterima Di')
                                ->badge()
                                ->color('success'),
                            
                            Infolists\Components\TextEntry::make('verifiedBy.name')
                                ->label('Diverifikasi Oleh'),
                        ]),
                    
                    Infolists\Components\TextEntry::make('catatan_verifikasi')
                        ->label('Catatan Verifikasi')
                        ->columnSpanFull(),
                    
                    Infolists\Components\TextEntry::make('catatan_seleksi')
                        ->label('Catatan Seleksi')
                        ->columnSpanFull(),
                ])
                ->columns(1)
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
        'index' => Pages\ListPendaftarans::route('/'),
        'create' => Pages\CreatePendaftaran::route('/create'),
        //'view' => Pages\ViewPendaftaran::route('/{record}'),
        'edit' => Pages\EditPendaftaran::route('/{record}/edit'),
    ];
}
}