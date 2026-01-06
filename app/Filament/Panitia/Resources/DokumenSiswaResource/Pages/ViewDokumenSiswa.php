<?php

namespace App\Filament\Panitia\Resources\DokumenSiswaResource\Pages;

use App\Filament\Panitia\Resources\DokumenSiswaResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Filament\Forms;
use Filament\Notifications\Notification;

class ViewDokumenSiswa extends ViewRecord
{
    protected static string $resource = DokumenSiswaResource::class;

    protected function getHeaderActions(): array
{
    return [
        // ACTION: APPROVE
        Actions\Action::make('approve')
            ->label('Approve Dokumen')
            ->icon('heroicon-o-check-circle')
            ->color('success')
            ->requiresConfirmation()
            ->modalHeading('Approve Dokumen')
            ->modalDescription('Apakah dokumen ini valid dan sesuai?')
            ->visible(fn () => $this->record->status_verifikasi === 'pending')  // ← UBAH
            ->action(function () {
                $this->record->update([
                    'status_verifikasi' => 'approved',  // ← UBAH
                    'verified_by' => auth()->id(),
                    'verified_at' => now(),
                    'catatan' => null,
                ]);

                Notification::make()
                    ->title('Dokumen Diapprove')
                    ->success()
                    ->send();

                return redirect()->route('filament.panitia.resources.dokumen-siswas.index');
            }),

        // ACTION: REJECT
        Actions\Action::make('reject')
            ->label('Reject Dokumen')
            ->icon('heroicon-o-x-circle')
            ->color('danger')
            ->requiresConfirmation()
            ->modalHeading('Reject Dokumen')
            ->modalDescription('Berikan alasan penolakan')
            ->form([
                Forms\Components\Textarea::make('catatan')
                    ->label('Alasan Penolakan')
                    ->required()
                    ->rows(4)
                    ->placeholder('Contoh: Foto tidak jelas, dokumen tidak sesuai, format salah'),
            ])
            ->visible(fn () => $this->record->status_verifikasi === 'pending')  // ← UBAH
            ->action(function (array $data) {
                $this->record->update([
                    'status_verifikasi' => 'rejected',  // ← UBAH
                    'catatan' => $data['catatan'],
                    'verified_by' => auth()->id(),
                    'verified_at' => now(),
                ]);

                Notification::make()
                    ->title('Dokumen Ditolak')
                    ->danger()
                    ->send();

                return redirect()->route('filament.panitia.resources.dokumen-siswas.index');
            }),

        Actions\Action::make('back')
            ->label('Kembali')
            ->url(fn (): string => DokumenSiswaResource::getUrl('index'))
            ->color('gray'),
        ];
    }
}