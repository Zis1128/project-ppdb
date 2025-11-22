<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PembayaranResource\Pages;
use App\Models\Pembayaran;
use App\Models\Pendaftaran;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PembayaranResource extends Resource
{
    protected static ?string $model = Pembayaran::class;

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';

    protected static ?string $navigationGroup = 'Pendaftaran';

    protected static ?int $navigationSort = 2;

    protected static ?string $navigationLabel = 'Pembayaran';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Pembayaran')
                    ->schema([
                        Forms\Components\TextInput::make('no_invoice')
                            ->label('No. Invoice')
                            ->disabled()
                            ->dehydrated(false)
                            ->placeholder('Auto Generate'),

                        Forms\Components\Select::make('pendaftaran_id')
                            ->label('Pendaftaran')
                            ->options(Pendaftaran::with('user')
                                ->get()
                                ->mapWithKeys(fn ($item) => [
                                    $item->id => "{$item->no_pendaftaran} - {$item->nama_lengkap}"
                                ])
                            )
                            ->required()
                            ->searchable()
                            ->preload(),

                        Forms\Components\TextInput::make('jumlah')
                            ->label('Jumlah Pembayaran')
                            ->required()
                            ->numeric()
                            ->prefix('Rp')
                            ->default(250000),

                        Forms\Components\Select::make('metode_pembayaran')
                            ->label('Metode Pembayaran')
                            ->options([
                                'transfer_bank' => 'Transfer Bank',
                                'virtual_account' => 'Virtual Account',
                                'ewallet' => 'E-Wallet',
                                'cash' => 'Cash',
                            ])
                            ->required()
                            ->native(false)
                            ->live(),

                        Forms\Components\Grid::make(3)
                            ->schema([
                                Forms\Components\TextInput::make('bank_tujuan')
                                    ->label('Bank Tujuan')
                                    ->maxLength(255)
                                    ->visible(fn (Forms\Get $get) =>in_array($get('metode_pembayaran'), ['transfer_bank', 'virtual_account'])
),
                            Forms\Components\TextInput::make('no_rekening')
                                ->label('No. Rekening')
                                ->maxLength(255)
                                ->visible(fn (Forms\Get $get) => 
                                    in_array($get('metode_pembayaran'), ['transfer_bank', 'virtual_account'])
                                ),

                            Forms\Components\TextInput::make('atas_nama')
                                ->label('Atas Nama')
                                ->maxLength(255)
                                ->visible(fn (Forms\Get $get) => 
                                    in_array($get('metode_pembayaran'), ['transfer_bank', 'virtual_account'])
                                ),
                        ]),

                    Forms\Components\FileUpload::make('bukti_pembayaran')
                        ->label('Bukti Pembayaran')
                        ->image()
                        ->directory('bukti-pembayaran')
                        ->maxSize(2048)
                        ->imageEditor()
                        ->downloadable()
                        ->openable(),

                    Forms\Components\DateTimePicker::make('tanggal_bayar')
                        ->label('Tanggal Pembayaran')
                        ->native(false)
                        ->displayFormat('d/m/Y H:i'),

                    Forms\Components\Select::make('status')
                        ->label('Status')
                        ->options([
                            'pending' => 'Pending',
                            'verified' => 'Verified',
                            'rejected' => 'Rejected',
                        ])
                        ->required()
                        ->native(false)
                        ->default('pending'),

                    Forms\Components\Textarea::make('catatan')
                        ->label('Catatan')
                        ->rows(3)
                        ->columnSpanFull(),
                ])
        ]);
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
                ->sortable(),

            Tables\Columns\TextColumn::make('pendaftaran.nama_lengkap')
                ->label('Nama')
                ->searchable()
                ->sortable()
                ->limit(30),

            Tables\Columns\TextColumn::make('jumlah')
                ->label('Jumlah')
                ->money('IDR')
                ->sortable(),

            Tables\Columns\TextColumn::make('metode_pembayaran')
                ->label('Metode')
                ->badge()
                ->color('info')
                ->formatStateUsing(fn (string $state): string => str($state)->replace('_', ' ')->title()),

            Tables\Columns\ImageColumn::make('bukti_pembayaran')
                ->label('Bukti')
                ->size(50)
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
                ->formatStateUsing(fn (string $state): string => str($state)->title())
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
        ->filters([
            Tables\Filters\SelectFilter::make('metode_pembayaran')
                ->label('Metode')
                ->options([
                    'transfer_bank' => 'Transfer Bank',
                    'virtual_account' => 'Virtual Account',
                    'ewallet' => 'E-Wallet',
                    'cash' => 'Cash',
                ]),

            Tables\Filters\SelectFilter::make('status')
                ->label('Status')
                ->options([
                    'pending' => 'Pending',
                    'verified' => 'Verified',
                    'rejected' => 'Rejected',
                ])
                ->multiple(),

            Tables\Filters\Filter::make('tanggal_bayar')
                ->form([
                    Forms\Components\DatePicker::make('tanggal_from')
                        ->label('Dari Tanggal')
                        ->native(false),
                    Forms\Components\DatePicker::make('tanggal_until')
                        ->label('Sampai Tanggal')
                        ->native(false),
                ])
                ->query(function ($query, array $data) {
                    return $query
                        ->when(
                            $data['tanggal_from'],
                            fn ($query, $date) => $query->whereDate('tanggal_bayar', '>=', $date),
                        )
                        ->when(
                            $data['tanggal_until'],
                            fn ($query, $date) => $query->whereDate('tanggal_bayar', '<=', $date),
                        );
                }),
        ])
        ->actions([
            Tables\Actions\ViewAction::make(),
            
            Tables\Actions\Action::make('verify')
                ->label('Verifikasi')
                ->icon('heroicon-o-check-circle')
                ->color('success')
                ->requiresConfirmation()
                ->form([
                    Forms\Components\Select::make('status')
                        ->label('Status')
                        ->options([
                            'verified' => 'Disetujui',
                            'rejected' => 'Ditolak',
                        ])
                        ->required()
                        ->native(false),
                    
                    Forms\Components\Textarea::make('catatan')
                        ->label('Catatan')
                        ->rows(3),
                ])
                ->action(function (Pembayaran $record, array $data): void {
                    $record->update([
                        'status' => $data['status'],
                        'catatan' => $data['catatan'],
                        'verified_by' => auth()->id(),
                        'verified_at' => now(),
                    ]);
                    
                    // Update status pendaftaran jika pembayaran diverifikasi
                    if ($data['status'] === 'verified') {
                        $record->pendaftaran->update([
                            'status_pendaftaran' => 'verified',
                        ]);
                    }
                    
                    \Filament\Notifications\Notification::make()
                        ->title('Verifikasi Pembayaran Berhasil')
                        ->success()
                        ->send();
                })
                ->visible(fn (Pembayaran $record): bool => $record->status === 'pending'),

            Tables\Actions\EditAction::make(),
            Tables\Actions\DeleteAction::make(),
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
        'index' => Pages\ListPembayarans::route('/'),
        'create' => Pages\CreatePembayaran::route('/create'),
        //'view' => Pages\ViewPembayaran::route('/{record}'),
        'edit' => Pages\EditPembayaran::route('/{record}/edit'),
    ];
}
}