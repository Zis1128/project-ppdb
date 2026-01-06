<?php

namespace App\Filament\Panitia\Resources;

use App\Filament\Panitia\Resources\LaporanPendaftaranResource\Pages;
use App\Models\Pendaftaran;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;
use pxlrbt\FilamentExcel\Exports\ExcelExport;
use pxlrbt\FilamentExcel\Columns\Column;

class LaporanPendaftaranResource extends Resource
{
    protected static ?string $model = Pendaftaran::class;
    protected static ?string $navigationIcon = 'heroicon-o-document-chart-bar';
    protected static ?string $navigationLabel = 'Laporan Pendaftaran';
    protected static ?string $navigationGroup = 'Laporan';
    protected static ?int $navigationSort = 3;

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('no_pendaftaran')
                    ->label('No. Pendaftaran')
                    ->searchable()
                    ->sortable()
                    ->copyable(),

                Tables\Columns\TextColumn::make('nama_lengkap')
                    ->label('Nama Lengkap')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('nisn')
                    ->label('NISN')
                    ->searchable(),

                Tables\Columns\TextColumn::make('asal_sekolah')
                    ->label('Asal Sekolah')
                    ->searchable()
                    ->limit(30),

                Tables\Columns\TextColumn::make('jalurMasuk.nama')
                    ->label('Jalur Masuk')
                    ->badge()
                    ->color('info'),

                Tables\Columns\TextColumn::make('jurusanPilihan1.nama')
                    ->label('Jurusan')
                    ->badge()
                    ->color('success'),

                Tables\Columns\TextColumn::make('gelombang.nama')
                    ->label('Gelombang')
                    ->badge(),

                Tables\Columns\BadgeColumn::make('status_pendaftaran')
                    ->label('Status')
                    ->colors([
                        'warning' => 'draft',
                        'info' => 'submitted',
                        'primary' => 'verified',
                        'success' => 'accepted',
                        'danger' => 'rejected',
                    ]),

                Tables\Columns\TextColumn::make('tanggal_daftar')
                    ->label('Tanggal Daftar')
                    ->date('d M Y')
                    ->sortable(),

                Tables\Columns\TextColumn::make('nilai_un')
                    ->label('Nilai UN')
                    ->numeric(2)
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status_pendaftaran')
                    ->label('Status')
                    ->options([
                        'draft' => 'Draft',
                        'submitted' => 'Submitted',
                        'verified' => 'Verified',
                        'accepted' => 'Diterima',
                        'rejected' => 'Ditolak',
                    ])
                    ->multiple(),

                Tables\Filters\SelectFilter::make('jalur_masuk_id')
                    ->label('Jalur Masuk')
                    ->relationship('jalurMasuk', 'nama')
                    ->multiple(),

                Tables\Filters\SelectFilter::make('jurusan_pilihan_1')
                    ->label('Jurusan')
                    ->relationship('jurusanPilihan1', 'nama')
                    ->multiple(),

                Tables\Filters\SelectFilter::make('gelombang_id')
                    ->label('Gelombang')
                    ->relationship('gelombang', 'nama')
                    ->multiple(),

                Tables\Filters\SelectFilter::make('tahun_ajaran_id')
                    ->label('Tahun Ajaran')
                    ->relationship('tahunAjaran', 'nama'),

                Tables\Filters\Filter::make('tanggal_daftar')
                    ->form([
                        Forms\Components\DatePicker::make('dari_tanggal')
                            ->label('Dari Tanggal'),
                        Forms\Components\DatePicker::make('sampai_tanggal')
                            ->label('Sampai Tanggal'),
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when($data['dari_tanggal'], fn ($q) => $q->whereDate('tanggal_daftar', '>=', $data['dari_tanggal']))
                            ->when($data['sampai_tanggal'], fn ($q) => $q->whereDate('tanggal_daftar', '<=', $data['sampai_tanggal']));
                    }),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    ExportBulkAction::make()
                        ->label('Export ke Excel')
                        ->exports([
                            ExcelExport::make()
                                ->fromTable()
                                ->withFilename(fn () => 'Laporan-Pendaftaran-' . date('Y-m-d'))
                                ->withWriterType(\Maatwebsite\Excel\Excel::XLSX)
                                ->withColumns([
                                    Column::make('no_pendaftaran')->heading('No. Pendaftaran'),
                                    Column::make('nama_lengkap')->heading('Nama Lengkap'),
                                    Column::make('nisn')->heading('NISN'),
                                    Column::make('nik')->heading('NIK'),
                                    Column::make('tempat_lahir')->heading('Tempat Lahir'),
                                    Column::make('tanggal_lahir')->heading('Tanggal Lahir'),
                                    Column::make('jenis_kelamin')->heading('Jenis Kelamin'),
                                    Column::make('agama')->heading('Agama'),
                                    Column::make('alamat')->heading('Alamat'),
                                    Column::make('no_hp_siswa')->heading('No. HP'),
                                    Column::make('email_siswa')->heading('Email'),
                                    Column::make('asal_sekolah')->heading('Asal Sekolah'),
                                    Column::make('nilai_un')->heading('Nilai UN'),
                                    Column::make('jalurMasuk.nama')->heading('Jalur Masuk'),
                                    Column::make('jurusanPilihan1.nama')->heading('Jurusan Pilihan 1'),
                                    Column::make('jurusanPilihan2.nama')->heading('Jurusan Pilihan 2'),
                                    Column::make('status_pendaftaran')->heading('Status'),
                                    Column::make('tanggal_daftar')->heading('Tanggal Daftar'),
                                ])
                        ]),
                ]),
            ])
            ->defaultSort('created_at', 'desc')
            ->poll('10s'); // Auto refresh setiap 10 detik
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLaporanPendaftarans::route('/'),
        ];
    }

    // Disable create, edit, delete
    public static function canCreate(): bool
    {
        return false;
    }
}