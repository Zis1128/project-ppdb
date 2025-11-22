<?php

namespace App\Filament\Panitia\Resources;

use App\Filament\Panitia\Resources\LaporanPendaftaranResource\Pages;
use App\Models\Pendaftaran;
use App\Models\Jurusan;
use App\Models\JalurMasuk;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Filament\Notifications\Notification;

class LaporanPendaftaranResource extends Resource
{
    protected static ?string $model = Pendaftaran::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-chart-bar';

    protected static ?string $navigationGroup = 'Laporan';

    protected static ?int $navigationSort = 1;

    protected static ?string $navigationLabel = 'Laporan Pendaftaran';

    protected static ?string $modelLabel = 'Laporan';

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('no_pendaftaran')
                    ->label('No. Pendaftaran')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('nama_lengkap')
                    ->label('Nama')
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

                Tables\Columns\TextColumn::make('jurusanPilihan1.nama')
                    ->label('Jurusan')
                    ->badge()
                    ->color('success'),

                Tables\Columns\TextColumn::make('jalurMasuk.nama')
                    ->label('Jalur')
                    ->badge()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('nilai_un')
                    ->label('Nilai UN')
                    ->numeric(decimalPlaces: 2)
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('status_verifikasi')
                    ->label('Verifikasi')
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

                Tables\Columns\TextColumn::make('status_pendaftaran')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => str($state)->title())
                    ->sortable(),

                Tables\Columns\TextColumn::make('pembayaran.status')
                    ->label('Pembayaran')
                    ->badge()
                    ->formatStateUsing(fn ($state): string => $state ? match ($state) {
                        'pending' => 'Pending',
                        'verified' => 'Lunas',
                        'rejected' => 'Ditolak',
                        default => '-'
                    } : 'Belum Bayar')
                    ->toggleable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tanggal Daftar')
                    ->dateTime('d M Y')
                    ->sortable(),
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
                    ->multiple(),

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

                Tables\Filters\SelectFilter::make('jalur_masuk_id')
                    ->label('Jalur Masuk')
                    ->relationship('jalurMasuk', 'nama')
                    ->multiple(),

                Tables\Filters\SelectFilter::make('jurusan_pilihan_1')
                    ->label('Jurusan')
                    ->options(Jurusan::pluck('nama', 'id'))
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
                Tables\Actions\ViewAction::make()
                    ->url(fn (Pendaftaran $record): string => 
                        route('filament.panitia.resources.verifikasi-pendaftarans.view', ['record' => $record])
                    ),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\BulkAction::make('export_excel')
                        ->label('Export Excel')
                        ->icon('heroicon-o-arrow-down-tray')
                        ->color('success')
                        ->action(function ($records) {
                            Notification::make()
                                ->title('Export dalam proses')
                                ->body('Laporan akan didownload segera')
                                ->info()
                                ->send();
                        }),

                    Tables\Actions\BulkAction::make('export_pdf')
                        ->label('Export PDF')
                        ->icon('heroicon-o-document-arrow-down')
                        ->color('danger')
                        ->action(function ($records) {
                            Notification::make()
                                ->title('Export dalam proses')
                                ->body('Laporan akan didownload segera')
                                ->info()
                                ->send();
                        }),
                ]),
            ])
            ->headerActions([
                Tables\Actions\Action::make('rekap')
                    ->label('Lihat Rekap')
                    ->icon('heroicon-o-chart-bar')
                    ->color('primary')
                    ->url(route('filament.panitia.pages.rekap-pendaftaran')),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLaporanPendaftarans::route('/'),
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }
}