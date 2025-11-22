<?php

namespace App\Filament\Panitia\Resources;

use App\Filament\Panitia\Resources\VerifikasiPembayaranResource\Pages;
use App\Models\Pembayaran;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Illuminate\Database\Eloquent\Builder;
use Filament\Notifications\Notification;

class VerifikasiPembayaranResource extends Resource
{
    protected static ?string $model = Pembayaran::class;

    protected static ?string $navigationIcon = 'heroicon-o-credit-card';

    protected static ?string $navigationGroup = 'Verifikasi';

    protected static ?int $navigationSort = 2;

    protected static ?string $navigationLabel = 'Verifikasi Pembayaran';

    protected static ?string $modelLabel = 'Verifikasi Pembayaran';

    protected static ?string $pluralModelLabel = 'Verifikasi Pembayaran';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('status', 'pending')->count();
    }

    public static function getNavigationBadgeColor(): ?string
    {
        return 'danger';
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('no_invoice')
                    ->label('No. Invoice')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->copyable(),

                Tables\Columns\TextColumn::make('pendaftaran.no_pendaftaran')
                    ->label('No. Pendaftaran')
                    ->searchable()
                    ->sortable()
                    ->copyable(),

                Tables\Columns\TextColumn::make('pendaftaran.nama_lengkap')
                    ->label('Nama')
                    ->searchable()
                    ->sortable()
                    ->limit(30)
                    ->wrap(),

                Tables\Columns\TextColumn::make('jumlah')
                    ->label('Jumlah')
                    ->money('IDR')
                    ->sortable(),

                Tables\Columns\TextColumn::make('metode_pembayaran')
                    ->label('Metode')
                    ->badge()
                    ->color('info')
                    ->formatStateUsing(fn (string $state): string => 
                        str($state)->replace('_', ' ')->title()
                    ),

                Tables\Columns\ImageColumn::make('bukti_pembayaran')
                    ->label('Bukti')
                    ->size(60)
                    ->defaultImageUrl(url('/images/no-image.png')),

                Tables\Columns\TextColumn::make('tanggal_bayar')
                    ->label('Tanggal Bayar')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'verified' => 'success',
                        'rejected' => 'danger',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'pending' => 'Pending',
                        'verified' => 'Lunas',
                        'rejected' => 'Ditolak',
                        default => $state,
                    })
                    ->sortable(),

                Tables\Columns\TextColumn::make('verifiedBy.name')
                    ->label('Diverifikasi Oleh')
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('verified_at')
                    ->label('Tanggal Verifikasi')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'pending' => 'Pending',
                        'verified' => 'Lunas',
                        'rejected' => 'Ditolak',
                    ])
                    ->default('pending'),

                Tables\Filters\SelectFilter::make('metode_pembayaran')
                    ->label('Metode')
                    ->options([
                        'transfer_bank' => 'Transfer Bank',
                        'virtual_account' => 'Virtual Account',
                        'ewallet' => 'E-Wallet',
                        'cash' => 'Cash',
                    ]),

                Tables\Filters\Filter::make('tanggal_bayar')
                    ->form([
                        Forms\Components\DatePicker::make('tanggal_from')
                            ->label('Dari Tanggal')
                            ->native(false),
                        Forms\Components\DatePicker::make('tanggal_until')
                            ->label('Sampai Tanggal')
                            ->native(false),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['tanggal_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('tanggal_bayar', '>=', $date),
                            )
                            ->when(
                                $data['tanggal_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('tanggal_bayar', '<=', $date),
                            );
                    }),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->label('Detail'),

                Tables\Actions\Action::make('preview')
                    ->label('Lihat Bukti')
                    ->icon('heroicon-o-photo')
                    ->color('info')
                    ->modalContent(fn ($record) => view('filament.panitia.modals.bukti-preview', [
                        'record' => $record
                    ]))
                    ->modalWidth('3xl')
                    ->slideOver()
                    ->visible(fn ($record) => $record->bukti_pembayaran),

                Tables\Actions\Action::make('verify')
                    ->label('Verifikasi')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->form([
                        Forms\Components\Select::make('status')
                            ->label('Status')
                            ->options([
                                'verified' => 'Disetujui - Lunas',
                                'rejected' => 'Ditolak',
                            ])
                            ->required()
                            ->native(false)
                            ->live(),

                        Forms\Components\Textarea::make('catatan')
                            ->label('Catatan')
                            ->rows(4)
                            ->required(fn (Forms\Get $get) => $get('status') === 'rejected')
                            ->placeholder('Berikan catatan verifikasi...'),
                    ])
                    ->action(function (Pembayaran $record, array $data): void {
                        $record->update([
                            'status' => $data['status'],
                            'catatan' => $data['catatan'] ?? null,
                            'verified_by' => auth()->id(),
                            'verified_at' => now(),
                        ]);

                        // Update status pendaftaran jika pembayaran diverifikasi
                        if ($data['status'] === 'verified') {
                            $record->pendaftaran->update([
                                'status_pendaftaran' => 'verified',
                            ]);
                        }

                        Notification::make()
                            ->title('Verifikasi Pembayaran Berhasil')
                            ->body("Pembayaran {$record->no_invoice} telah diverifikasi")
                            ->success()
                            ->send();
                    })
                    ->visible(fn (Pembayaran $record): bool => $record->status === 'pending'),

                Tables\Actions\Action::make('edit_verification')
                    ->label('Edit Verifikasi')
                    ->icon('heroicon-o-pencil')
                    ->color('warning')
                    ->fillForm(fn ($record): array => [
                        'status' => $record->status,
                        'catatan' => $record->catatan,
                    ])
                    ->form([
                        Forms\Components\Select::make('status')
                            ->label('Status')
                            ->options([
                                'verified' => 'Disetujui - Lunas',
                                'rejected' => 'Ditolak',
                            ])
                            ->required()
                            ->native(false),

                        Forms\Components\Textarea::make('catatan')
                            ->label('Catatan')
                            ->rows(4),
                    ])
                    ->action(function (Pembayaran $record, array $data): void {
                        $record->update([
                            'status' => $data['status'],
                            'catatan' => $data['catatan'] ?? null,
                            'verified_by' => auth()->id(),
                            'verified_at' => now(),
                        ]);

                        Notification::make()
                            ->title('Update Verifikasi Berhasil')
                            ->success()
                            ->send();
                    })
                    ->visible(fn (Pembayaran $record): bool => $record->status !== 'pending'),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\BulkAction::make('verify_bulk')
                        ->label('Verifikasi Terpilih')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->requiresConfirmation()
                        ->form([
                            Forms\Components\Textarea::make('catatan')
                                ->label('Catatan (Opsional)')
                                ->rows(3),
                        ])
                        ->action(function ($records, array $data): void {
                            foreach ($records as $record) {
                                $record->update([
                                    'status' => 'verified',
                                    'catatan' => $data['catatan'] ?? null,
                                    'verified_by' => auth()->id(),
                                    'verified_at' => now(),
                                ]);

                                $record->pendaftaran->update([
                                    'status_pendaftaran' => 'verified',
                                ]);
                            }

                            Notification::make()
                                ->title('Verifikasi Massal Berhasil')
                                ->body(count($records) . ' pembayaran telah diverifikasi')
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
                Infolists\Components\Section::make('Informasi Pembayaran')
                    ->schema([
                        Infolists\Components\Grid::make(3)
                            ->schema([
                                Infolists\Components\TextEntry::make('no_invoice')
                                    ->label('No. Invoice')
                                    ->weight('bold')
                                    ->copyable()
                                    ->icon('heroicon-o-document-text'),

                                Infolists\Components\TextEntry::make('status')
                                    ->label('Status')
                                    ->badge()
                                    ->color(fn (string $state): string => match ($state) {
                                        'pending' => 'warning',
                                        'verified' => 'success',
                                        'rejected' => 'danger',
                                        default => 'gray',
                                    })
                                    ->formatStateUsing(fn (string $state): string => match ($state) {
                                        'pending' => 'Pending',
                                        'verified' => 'Lunas',
                                        'rejected' => 'Ditolak',
                                        default => $state,
                                    }),

                                Infolists\Components\TextEntry::make('jumlah')
                                    ->label('Jumlah')
                                    ->money('IDR')
                                    ->size('lg')
                                    ->weight('bold')
                                    ->color('success'),
                            ]),

                        Infolists\Components\Grid::make(2)
                            ->schema([
                                Infolists\Components\TextEntry::make('metode_pembayaran')
                                    ->label('Metode Pembayaran')
                                    ->badge()
                                    ->formatStateUsing(fn (string $state): string => 
                                        str($state)->replace('_', ' ')->title()
                                    ),

                                Infolists\Components\TextEntry::make('tanggal_bayar')
                                    ->label('Tanggal Pembayaran')
                                    ->dateTime('d F Y H:i')
                                    ->icon('heroicon-o-calendar'),
                            ]),

                        Infolists\Components\TextEntry::make('catatan')
                            ->label('Catatan Verifikasi')
                            ->color('danger')
                            ->icon('heroicon-o-exclamation-circle')
                            ->visible(fn ($record) => $record->catatan)
                            ->columnSpanFull(),
                    ]),

                Infolists\Components\Section::make('Detail Transfer')
                    ->schema([
                        Infolists\Components\Grid::make(3)
                            ->schema([
                                Infolists\Components\TextEntry::make('bank_tujuan')
                                    ->label('Bank Tujuan'),

                                Infolists\Components\TextEntry::make('no_rekening')
                                    ->label('No. Rekening')
                                    ->copyable(),

                                Infolists\Components\TextEntry::make('atas_nama')
                                    ->label('Atas Nama'),
                            ]),
                    ])
                    ->visible(fn ($record) => in_array($record->metode_pembayaran, ['transfer_bank', 'virtual_account']))
                    ->collapsible(),

                Infolists\Components\Section::make('Bukti Pembayaran')
                    ->schema([
                        Infolists\Components\ImageEntry::make('bukti_pembayaran')
                            ->label('')
                            ->size('lg')
                            ->columnSpanFull(),
                    ])
                    ->visible(fn ($record) => $record->bukti_pembayaran)
                    ->collapsible(),

                Infolists\Components\Section::make('Data Pendaftaran')
                    ->schema([
                        Infolists\Components\Grid::make(2)
                            ->schema([
                                Infolists\Components\TextEntry::make('pendaftaran.no_pendaftaran')
                                    ->label('No. Pendaftaran')
                                    ->copyable(),

                                Infolists\Components\TextEntry::make('pendaftaran.nama_lengkap')
                                    ->label('Nama Lengkap')
                                    ->weight('bold'),

                                Infolists\Components\TextEntry::make('pendaftaran.nisn')
                                    ->label('NISN'),

                                Infolists\Components\TextEntry::make('pendaftaran.no_hp_siswa')
                                    ->label('No. HP')
                                    ->copyable()
                                    ->icon('heroicon-o-phone'),
                            ]),
                    ])
                    ->collapsible(),

                Infolists\Components\Section::make('Informasi Verifikasi')
                    ->schema([
                        Infolists\Components\Grid::make(2)
                            ->schema([
                                Infolists\Components\TextEntry::make('verifiedBy.name')
                                    ->label('Diverifikasi Oleh')
                                    ->icon('heroicon-o-user'),

                                Infolists\Components\TextEntry::make('verified_at')
                                    ->label('Tanggal Verifikasi')
                                    ->dateTime('d F Y H:i')
                                    ->icon('heroicon-o-clock'),
                            ]),
                    ])
                    ->visible(fn ($record) => $record->verified_at)
                    ->collapsible(),
]);
}
public static function getPages(): array
{
    return [
        'index' => Pages\ListVerifikasiPembayarans::route('/'),
       // 'view' => Pages\ViewVerifikasiPembayaran::route('/{record}'),
    ];
}
}