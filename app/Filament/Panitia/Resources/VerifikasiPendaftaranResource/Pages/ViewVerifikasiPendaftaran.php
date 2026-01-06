<?php

namespace App\Filament\Panitia\Resources\VerifikasiPendaftaranResource\Pages;

use App\Filament\Panitia\Resources\VerifikasiPendaftaranResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Filament\Forms;
use Filament\Notifications\Notification;

class ViewVerifikasiPendaftaran extends ViewRecord
{
    protected static string $resource = VerifikasiPendaftaranResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // ACTION: TERIMA
            Actions\Action::make('accept')
                ->label('Terima Pendaftaran')
                ->icon('heroicon-o-check-circle')
                ->color('success')
                ->requiresConfirmation()
                ->modalHeading('Terima Pendaftaran')
                ->modalDescription('Apakah Anda yakin ingin menerima pendaftaran ini?')
                ->modalSubmitActionLabel('Ya, Terima')
                ->visible(fn () => in_array($this->record->status_pendaftaran, ['submitted', 'verified']))
                ->action(function () {
                    $this->record->update([
                        'status_pendaftaran' => 'accepted',
                        'status_verifikasi' => 'approved',
                    ]);

                    Notification::make()
                        ->title('Pendaftaran Diterima')
                        ->success()
                        ->body("Pendaftaran {$this->record->nama_lengkap} telah diterima.")
                        ->send();

                    return redirect()->route('filament.panitia.resources.verifikasi-pendaftarans.index');
                }),

            // ACTION: TOLAK
            Actions\Action::make('reject')
                ->label('Tolak Pendaftaran')
                ->icon('heroicon-o-x-circle')
                ->color('danger')
                ->requiresConfirmation()
                ->modalHeading('Tolak Pendaftaran')
                ->modalDescription('Berikan alasan penolakan')
                ->form([
                    Forms\Components\Textarea::make('catatan')
                        ->label('Alasan Penolakan')
                        ->required()
                        ->rows(4)
                        ->placeholder('Tuliskan alasan penolakan pendaftaran...'),
                ])
                ->visible(fn () => in_array($this->record->status_pendaftaran, ['submitted', 'verified']))
                ->action(function (array $data) {
                    $this->record->update([
                        'status_pendaftaran' => 'rejected',
                        'status_verifikasi' => 'rejected',
                        'catatan_verifikasi' => $data['catatan'],
                    ]);

                    Notification::make()
                        ->title('Pendaftaran Ditolak')
                        ->danger()
                        ->body("Pendaftaran {$this->record->nama_lengkap} telah ditolak.")
                        ->send();

                    return redirect()->route('filament.panitia.resources.verifikasi-pendaftarans.index');
                }),

            // ACTION: REVIEW
            Actions\Action::make('review')
                ->label('Kembalikan untuk Review')
                ->icon('heroicon-o-arrow-path')
                ->color('warning')
                ->requiresConfirmation()
                ->visible(fn () => in_array($this->record->status_pendaftaran, ['accepted', 'rejected']))
                ->action(function () {
                    $this->record->update([
                        'status_pendaftaran' => 'verified',
                        'status_verifikasi' => 'pending',
                        'catatan_verifikasi' => null,
                    ]);

                    Notification::make()
                        ->title('Dikembalikan untuk Review')
                        ->warning()
                        ->send();
                }),

            Actions\Action::make('back')
                ->label('Kembali')
                ->url(fn (): string => VerifikasiPendaftaranResource::getUrl('index'))
                ->color('gray'),
        ];
    }
}