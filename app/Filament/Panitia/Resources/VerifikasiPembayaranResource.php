<?php

namespace App\Filament\Panitia\Resources;

use App\Filament\Panitia\Resources\VerifikasiPembayaranResource\Pages;
use App\Models\Pembayaran;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components;
use Filament\Notifications\Notification;

class VerifikasiPembayaranResource extends Resource
{
    protected static ?string $model = Pembayaran::class;
    protected static ?string $navigationIcon = 'heroicon-o-banknotes';
    protected static ?string $navigationLabel = 'Verifikasi Pembayaran';
    protected static ?string $navigationGroup = 'Verifikasi';
    protected static ?int $navigationSort = 2;

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('no_invoice')
                    ->label('No. Invoice')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('pendaftaran.no_pendaftaran')
                    ->label('No. Pendaftaran')
                    ->searchable()
                    ->copyable(),

                Tables\Columns\TextColumn::make('pendaftaran.nama_lengkap')
                    ->label('Nama Lengkap')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('jumlah')
                    ->label('Jumlah')
                    ->money('IDR')
                    ->sortable(),

                Tables\Columns\TextColumn::make('tanggal_bayar')
                    ->label('Tanggal Transfer')
                    ->date('d M Y')
                    ->sortable(),

                Tables\Columns\TextColumn::make('metode_pembayaran')
                    ->label('Metode')
                    ->badge()
                    ->color('info'),

                Tables\Columns\ImageColumn::make('bukti_pembayaran')
                    ->label('Bukti')
                    ->disk('public')
                    ->height(50)
                    ->defaultImageUrl(url('/images/no-image.png')),

                Tables\Columns\BadgeColumn::make('status')
                    ->label('Status')
                    ->colors([
                        'warning' => 'pending',
                        'success' => 'verified',
                        'danger' => 'rejected',
                    ])
                    ->icons([
                        'heroicon-o-clock' => 'pending',
                        'heroicon-o-check-circle' => 'verified',
                        'heroicon-o-x-circle' => 'rejected',
                    ]),

                Tables\Columns\TextColumn::make('verified_at')
                    ->label('Diverifikasi')
                    ->dateTime('d M Y H:i')
                    ->toggleable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'verified' => 'Verified',
                        'rejected' => 'Rejected',
                    ]),

                Tables\Filters\Filter::make('tanggal_bayar')
                    ->form([
                        Forms\Components\DatePicker::make('dari_tanggal')
                            ->label('Dari Tanggal'),
                        Forms\Components\DatePicker::make('sampai_tanggal')
                            ->label('Sampai Tanggal'),
                    ])
                    ->query(function ($query, array $data) {
                        return $query
                            ->when($data['dari_tanggal'], fn ($q) => $q->whereDate('tanggal_bayar', '>=', $data['dari_tanggal']))
                            ->when($data['sampai_tanggal'], fn ($q) => $q->whereDate('tanggal_bayar', '<=', $data['sampai_tanggal']));
                    }),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->label('Detail'),

                // ACTION: VERIFIKASI PEMBAYARAN
                Tables\Actions\Action::make('verify')
                    ->label('Verifikasi')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->modalHeading('Verifikasi Pembayaran')
                    ->modalDescription('Apakah bukti pembayaran valid dan sesuai?')
                    ->modalSubmitActionLabel('Ya, Verifikasi')
                    ->visible(fn (Pembayaran $record) => $record->status === 'pending')
                    ->action(function (Pembayaran $record) {
                        $record->update([
                            'status' => 'verified',
                            'verified_by' => auth()->id(),
                            'verified_at' => now(),
                        ]);

                        Notification::make()
                            ->title('Pembayaran Diverifikasi')
                            ->success()
                            ->body("Pembayaran dari {$record->pendaftaran->nama_lengkap} telah diverifikasi.")
                            ->send();
                    }),

                // ACTION: TOLAK PEMBAYARAN
                Tables\Actions\Action::make('reject')
                    ->label('Tolak')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->modalHeading('Tolak Pembayaran')
                    ->modalDescription('Berikan alasan penolakan')
                    ->form([
                        Forms\Components\Textarea::make('catatan')
                            ->label('Alasan Penolakan')
                            ->required()
                            ->rows(3)
                            ->placeholder('Contoh: Bukti pembayaran tidak jelas, nominal tidak sesuai, dll'),
                    ])
                    ->visible(fn (Pembayaran $record) => $record->status === 'pending')
                    ->action(function (Pembayaran $record, array $data) {
                        $record->update([
                            'status' => 'rejected',
                            'catatan' => $data['catatan'],
                            'verified_by' => auth()->id(),
                            'verified_at' => now(),
                        ]);

                        Notification::make()
                            ->title('Pembayaran Ditolak')
                            ->danger()
                            ->body("Pembayaran dari {$record->pendaftaran->nama_lengkap} telah ditolak.")
                            ->send();
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\BulkAction::make('verifyMultiple')
                        ->label('Verifikasi Terpilih')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->requiresConfirmation()
                        ->action(function ($records) {
                            $count = 0;
                            foreach ($records as $record) {
                                if ($record->status === 'pending') {
                                    $record->update([
                                        'status' => 'verified',
                                        'verified_by' => auth()->id(),
                                        'verified_at' => now(),
                                    ]);
                                    $count++;
                                }
                            }

                            Notification::make()
                                ->title("Berhasil Verifikasi {$count} Pembayaran")
                                ->success()
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
                Components\Section::make('Informasi Pembayaran')
                    ->schema([
                        Components\TextEntry::make('no_invoice')
                            ->label('No. Invoice')
                            ->size('lg')
                            ->weight('bold')
                            ->copyable(),
                        Components\TextEntry::make('status')
                            ->badge()
                            ->color(fn (string $state): string => match ($state) {
                                'pending' => 'warning',
                                'verified' => 'success',
                                'rejected' => 'danger',
                                default => 'gray',
                            }),
                        Components\TextEntry::make('jumlah')
                            ->money('IDR')
                            ->size('lg')
                            ->weight('bold')
                            ->color('success'),
                        Components\TextEntry::make('metode_pembayaran')
                            ->label('Metode Pembayaran')
                            ->badge(),
                        Components\TextEntry::make('tanggal_bayar')
                            ->label('Tanggal Transfer')
                            ->date('d F Y'),
                    ])
                    ->columns(2),

                Components\Section::make('Data Pendaftar')
                    ->schema([
                        Components\TextEntry::make('pendaftaran.no_pendaftaran')
                            ->label('No. Pendaftaran')
                            ->copyable(),
                        Components\TextEntry::make('pendaftaran.nama_lengkap')
                            ->label('Nama Lengkap'),
                        Components\TextEntry::make('pendaftaran.nisn')
                            ->label('NISN'),
                        Components\TextEntry::make('pendaftaran.no_hp_siswa')
                            ->label('No. HP'),
                        Components\TextEntry::make('pendaftaran.email_siswa')
                            ->label('Email'),
                    ])
                    ->columns(3),

                Components\Section::make('Bukti Pembayaran')
                    ->schema([
                        Components\ImageEntry::make('bukti_pembayaran')
                            ->label('')
                            ->disk('public')
                            ->height(400)
                            ->extraImgAttributes(['class' => 'rounded-lg shadow-lg'])
                            ->visible(fn ($record) => !empty($record->bukti_pembayaran)),
                    ]),

                Components\Section::make('Informasi Verifikasi')
                    ->schema([
                        Components\TextEntry::make('verifier.name')
                            ->label('Diverifikasi Oleh')
                            ->default('-'),
                        Components\TextEntry::make('verified_at')
                            ->label('Tanggal Verifikasi')
                            ->dateTime('d F Y H:i')
                            ->default('-'),
                        Components\TextEntry::make('catatan')
                            ->label('Catatan')
                            ->color('danger')
                            ->visible(fn ($record) => !empty($record->catatan))
                            ->columnSpanFull(),
                    ])
                    ->columns(2)
                    ->visible(fn ($record) => in_array($record->status, ['verified', 'rejected'])),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListVerifikasiPembayarans::route('/'),
            'view' => Pages\ViewVerifikasiPembayaran::route('/{record}'),
        ];
    }
}