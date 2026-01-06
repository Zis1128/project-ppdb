<?php

namespace App\Filament\Panitia\Resources;

use App\Filament\Panitia\Resources\DokumenSiswaResource\Pages;
use App\Models\DokumenSiswa;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Infolists\Infolist;
use Filament\Infolists\Components;
use Filament\Notifications\Notification;

class DokumenSiswaResource extends Resource
{
    protected static ?string $model = DokumenSiswa::class;
    protected static ?string $navigationIcon = 'heroicon-o-document-check';
    protected static ?string $navigationLabel = 'Verifikasi Dokumen';
    protected static ?string $navigationGroup = 'Verifikasi';
    protected static ?int $navigationSort = 3;
    protected static ?string $pluralModelLabel = 'Dokumen Siswa';
    protected static ?string $modelLabel = 'Dokumen';

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('pendaftaran.no_pendaftaran')
                    ->label('No. Pendaftaran')
                    ->searchable()
                    ->sortable()
                    ->copyable(),

                Tables\Columns\TextColumn::make('pendaftaran.nama_lengkap')
                    ->label('Nama Siswa')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('persyaratan.nama')
                    ->label('Jenis Dokumen')
                    ->badge()
                    ->color('info'),

                Tables\Columns\ImageColumn::make('file_path')
                    ->label('Preview')
                    ->disk('public')
                    ->height(50)
                    ->defaultImageUrl(url('/images/no-document.png')),

                Tables\Columns\BadgeColumn::make('status_verifikasi')  // ← UBAH
                    ->label('Status')
                    ->colors([
                        'warning' => 'pending',
                        'success' => 'approved',
                        'danger' => 'rejected',
                    ])
                    ->icons([
                        'heroicon-o-clock' => 'pending',
                        'heroicon-o-check-circle' => 'approved',
                        'heroicon-o-x-circle' => 'rejected',
                    ]),

                Tables\Columns\TextColumn::make('verified_at')
                    ->label('Diverifikasi')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Diupload')
                    ->dateTime('d M Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status_verifikasi')  // ← UBAH
                    ->label('Status')
                    ->options([
                        'pending' => 'Pending',
                        'approved' => 'Approved',
                        'rejected' => 'Rejected',
                    ]),

                Tables\Filters\SelectFilter::make('persyaratan_id')
                    ->label('Jenis Dokumen')
                    ->relationship('persyaratan', 'nama'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->label('Detail'),

                // ACTION: APPROVE DOKUMEN
                Tables\Actions\Action::make('approve')
                    ->label('Approve')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->modalHeading('Approve Dokumen')
                    ->modalDescription('Apakah dokumen ini valid dan sesuai?')
                    ->modalSubmitActionLabel('Ya, Approve')
                    ->hidden(fn (DokumenSiswa $record) => $record->status_verifikasi !== 'pending')  // ← UBAH
                    ->action(function (DokumenSiswa $record) {
                        $record->update([
                            'status_verifikasi' => 'approved',  // ← UBAH
                            'verified_by' => auth()->id(),
                            'verified_at' => now(),
                            'catatan' => null,
                        ]);
                    })
                    ->after(function () {
                        Notification::make()
                            ->title('Dokumen Diapprove')
                            ->success()
                            ->send();
                    }),

                // ACTION: REJECT DOKUMEN
                Tables\Actions\Action::make('reject')
                    ->label('Reject')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->modalHeading('Reject Dokumen')
                    ->modalDescription('Berikan alasan penolakan')
                    ->form([
                        Forms\Components\Textarea::make('catatan')
                            ->label('Alasan Penolakan')
                            ->required()
                            ->rows(3)
                            ->placeholder('Contoh: Foto tidak jelas, dokumen tidak sesuai, dll'),
                    ])
                    ->hidden(fn (DokumenSiswa $record) => $record->status_verifikasi !== 'pending')  // ← UBAH
                    ->action(function (DokumenSiswa $record, array $data) {
                        $record->update([
                            'status_verifikasi' => 'rejected',  // ← UBAH
                            'catatan' => $data['catatan'],
                            'verified_by' => auth()->id(),
                            'verified_at' => now(),
                        ]);
                    })
                    ->after(function () {
                        Notification::make()
                            ->title('Dokumen Ditolak')
                            ->danger()
                            ->send();
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\BulkAction::make('approveMultiple')
                        ->label('Approve Terpilih')
                        ->icon('heroicon-o-check-circle')
                        ->color('success')
                        ->requiresConfirmation()
                        ->action(function ($records) {
                            $count = 0;
                            foreach ($records as $record) {
                                if ($record->status_verifikasi === 'pending') {  // ← UBAH
                                    $record->update([
                                        'status_verifikasi' => 'approved',  // ← UBAH
                                        'verified_by' => auth()->id(),
                                        'verified_at' => now(),
                                    ]);
                                    $count++;
                                }
                            }

                            Notification::make()
                                ->title("Berhasil Approve {$count} Dokumen")
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
                Components\Section::make('Informasi Dokumen')
                    ->schema([
                        Components\TextEntry::make('persyaratan.nama')
                            ->label('Jenis Dokumen')
                            ->badge()
                            ->color('info'),
                        Components\TextEntry::make('status_verifikasi')  // ← UBAH
                            ->label('Status')
                            ->badge()
                            ->color(fn (string $state): string => match ($state) {
                                'pending' => 'warning',
                                'approved' => 'success',
                                'rejected' => 'danger',
                                default => 'gray',
                            }),
                        Components\TextEntry::make('created_at')
                            ->label('Diupload')
                            ->dateTime('d F Y H:i'),
                    ])
                    ->columns(3),

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
                    ])
                    ->columns(2),

                Components\Section::make('File Dokumen')
                    ->schema([
                        Components\ImageEntry::make('file_path')
                            ->label('')
                            ->disk('public')
                            ->height(500)
                            ->extraImgAttributes(['class' => 'rounded-lg shadow-lg'])
                            ->visible(fn ($record) => !empty($record->file_path)),
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
                    ->visible(fn ($record) => in_array($record->status_verifikasi, ['approved', 'rejected'])),  // ← UBAH
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDokumenSiswas::route('/'),
            'view' => Pages\ViewDokumenSiswa::route('/{record}'),
        ];
    }

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::where('status_verifikasi', 'pending')->count();  // ← UBAH
    }

    public static function getNavigationBadgeColor(): ?string
    {
        $count = static::getModel()::where('status_verifikasi', 'pending')->count();  // ← UBAH
        return $count > 0 ? 'warning' : 'success';
    }
}