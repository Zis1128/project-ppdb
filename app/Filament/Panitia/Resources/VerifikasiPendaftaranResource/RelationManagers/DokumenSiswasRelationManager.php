<?php

namespace App\Filament\Panitia\Resources\VerifikasiPendaftaranResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Notifications\Notification;

class DokumenSiswasRelationManager extends RelationManager
{
    protected static string $relationship = 'dokumenSiswas';

    protected static ?string $title = 'Dokumen Upload';

    protected static ?string $label = 'dokumen';

    protected static ?string $pluralLabel = 'Dokumen';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Placeholder::make('persyaratan_nama')
                    ->label('Jenis Dokumen')
                    ->content(fn ($record) => $record->persyaratan->nama),

                Forms\Components\Placeholder::make('file_info')
                    ->label('Informasi File')
                    ->content(fn ($record) => 
                        "Nama: {$record->file_name}\n" .
                        "Ukuran: " . number_format($record->file_size / 1024, 2) . " MB"
                    ),

                Forms\Components\Select::make('status_verifikasi')
                    ->label('Status Verifikasi')
                    ->options([
                        'pending' => 'Pending',
                        'approved' => 'Disetujui',
                        'rejected' => 'Ditolak',
                    ])
                    ->required()
                    ->native(false)
                    ->live(),            Forms\Components\Textarea::make('catatan')
                ->label('Catatan')
                ->rows(4)
                ->placeholder('Berikan catatan untuk dokumen ini...')
                ->required(fn (Forms\Get $get) => $get('status_verifikasi') === 'rejected')
                ->helperText('Wajib diisi jika dokumen ditolak'),
        ]);
}public function table(Table $table): Table
{
    return $table
        ->recordTitleAttribute('persyaratan.nama')
        ->columns([
            Tables\Columns\TextColumn::make('persyaratan.nama')
                ->label('Jenis Dokumen')
                ->weight('bold')
                ->icon('heroicon-o-document'),            Tables\Columns\TextColumn::make('persyaratan.is_wajib')
                ->label('Wajib')
                ->badge()
                ->formatStateUsing(fn (bool $state): string => $state ? 'Wajib' : 'Opsional')
                ->color(fn (bool $state): string => $state ? 'danger' : 'gray'),            Tables\Columns\ImageColumn::make('file_path')
                ->label('Preview')
                ->size(60)
                ->defaultImageUrl(url('/images/pdf-icon.png'))
                ->extraAttributes(['class' => 'cursor-pointer']),            Tables\Columns\TextColumn::make('file_name')
                ->label('Nama File')
                ->limit(30)
                ->searchable()
                ->copyable(),            Tables\Columns\TextColumn::make('file_size')
                ->label('Ukuran')
                ->formatStateUsing(fn ($state) => number_format($state / 1024, 2) . ' MB')
                ->sortable(),            Tables\Columns\TextColumn::make('status_verifikasi')
                ->label('Status')
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
                ->sortable(),            Tables\Columns\TextColumn::make('verifiedBy.name')
                ->label('Diverifikasi Oleh')
                ->toggleable(isToggledHiddenByDefault: true),            Tables\Columns\TextColumn::make('verified_at')
                ->label('Tanggal Verifikasi')
                ->dateTime('d M Y H:i')
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),            Tables\Columns\TextColumn::make('created_at')
                ->label('Diupload')
                ->dateTime('d M Y H:i')
                ->sortable(),
        ])
        ->filters([
            Tables\Filters\SelectFilter::make('status_verifikasi')
                ->label('Status')
                ->options([
                    'pending' => 'Pending',
                    'approved' => 'Disetujui',
                    'rejected' => 'Ditolak',
                ]),            Tables\Filters\SelectFilter::make('persyaratan_id')
                ->label('Jenis Dokumen')
                ->relationship('persyaratan', 'nama'),
        ])
        ->headerActions([
            // Tidak perlu create karena dokumen diupload oleh user
        ])
        ->actions([
            Tables\Actions\Action::make('preview')
                ->label('Preview')
                ->icon('heroicon-o-eye')
                ->color('info')
                ->modalContent(fn ($record) => view('filament.panitia.modals.dokumen-preview', [
                    'record' => $record
                ]))
                ->modalWidth('4xl')
                ->slideOver(),            Tables\Actions\Action::make('download')
                ->label('Download')
                ->icon('heroicon-o-arrow-down-tray')
                ->color('success')
                ->url(fn ($record) => asset('storage/' . $record->file_path))
                ->openUrlInNewTab(),            Tables\Actions\Action::make('verify')
                ->label('Verifikasi')
                ->icon('heroicon-o-check-circle')
                ->color('warning')
                ->form([
                    Forms\Components\Select::make('status_verifikasi')
                        ->label('Status')
                        ->options([
                            'approved' => 'Disetujui',
                            'rejected' => 'Ditolak',
                        ])
                        ->required()
                        ->native(false)
                        ->live(),                    Forms\Components\Textarea::make('catatan')
                        ->label('Catatan')
                        ->rows(4)
                        ->required(fn (Forms\Get $get) => $get('status_verifikasi') === 'rejected')
                        ->placeholder('Berikan catatan untuk dokumen ini...'),
                ])
                ->action(function ($record, array $data): void {
                    $record->update([
                        'status_verifikasi' => $data['status_verifikasi'],
                        'catatan' => $data['catatan'] ?? null,
                        'verified_by' => auth()->id(),
                        'verified_at' => now(),
                    ]);                    // Cek apakah semua dokumen wajib sudah diverifikasi
                    $pendaftaran = $record->pendaftaran;
                    $allVerified = $pendaftaran->dokumenSiswas()
                        ->whereHas('persyaratan', fn($q) => $q->where('is_wajib', true))
                        ->where('status_verifikasi', '!=', 'approved')
                        ->count() === 0;                    // Update status jika semua dokumen sudah diverifikasi
                    if ($allVerified && $data['status_verifikasi'] === 'approved') {
                        Notification::make()
                            ->title('Semua Dokumen Wajib Terverifikasi')
                            ->body('Anda dapat melanjutkan verifikasi pendaftaran')
                            ->success()
                            ->send();
                    }                    Notification::make()
                        ->title('Verifikasi Dokumen Berhasil')
                        ->success()
                        ->send();
                }),            Tables\Actions\Action::make('edit_verification')
                ->label('Edit')
                ->icon('heroicon-o-pencil')
                ->color('warning')
                ->fillForm(fn ($record): array => [
                    'status_verifikasi' => $record->status_verifikasi,
                    'catatan' => $record->catatan,
                ])
                ->form([
                    Forms\Components\Select::make('status_verifikasi')
                        ->label('Status')
                        ->options([
                            'approved' => 'Disetujui',
                            'rejected' => 'Ditolak',
                        ])
                        ->required()
                        ->native(false),                    Forms\Components\Textarea::make('catatan')
                        ->label('Catatan')
                        ->rows(4),
                ])
                ->action(function ($record, array $data): void {
                    $record->update([
                        'status_verifikasi' => $data['status_verifikasi'],
                        'catatan' => $data['catatan'] ?? null,
                        'verified_by' => auth()->id(),
                        'verified_at' => now(),
                    ]);                    Notification::make()
                        ->title('Update Verifikasi Berhasil')
                        ->success()
                        ->send();
                })
                ->visible(fn ($record) => $record->status_verifikasi !== 'pending'),
        ])
        ->bulkActions([
            Tables\Actions\BulkActionGroup::make([
                Tables\Actions\BulkAction::make('approve_all')
                    ->label('Setujui Semua')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->action(function ($records): void {
                        foreach ($records as $record) {
                            $record->update([
                                'status_verifikasi' => 'approved',
                                'verified_by' => auth()->id(),
                                'verified_at' => now(),
                            ]);
                        }                        Notification::make()
                            ->title('Verifikasi Massal Berhasil')
                            ->body(count($records) . ' dokumen telah disetujui')
                            ->success()
                            ->send();
                    }),
            ]),
        ])
        ->emptyStateHeading('Belum Ada Dokumen')
        ->emptyStateDescription('Calon siswa belum mengupload dokumen apapun')
        ->emptyStateIcon('heroicon-o-document');
}
}