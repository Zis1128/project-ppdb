<?php

namespace App\Filament\Panitia\Resources\VerifikasiPembayaranResource\Pages;

use App\Filament\Panitia\Resources\VerifikasiPembayaranResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Filament\Forms;
use Filament\Notifications\Notification;

class ViewVerifikasiPembayaran extends ViewRecord
{
    protected static string $resource = VerifikasiPembayaranResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // ACTION: VERIFIKASI
            Actions\Action::make('verify')
                ->label('Verifikasi Pembayaran')
                ->icon('heroicon-o-check-circle')
                ->color('success')
                ->requiresConfirmation()
                ->modalHeading('Verifikasi Pembayaran')
                ->modalDescription('Apakah bukti pembayaran valid dan sesuai dengan jumlah yang harus dibayar?')
                ->modalSubmitActionLabel('Ya, Verifikasi')
                ->visible(fn () => $this->record->status === 'pending')
                ->action(function () {
                    $this->record->update([
                        'status' => 'verified',
                        'verified_by' => auth()->id(),
                        'verified_at' => now(),
                    ]);

                    Notification::make()
                        ->title('Pembayaran Diverifikasi')
                        ->success()
                        ->body("Pembayaran dari {$this->record->pendaftaran->nama_lengkap} telah diverifikasi.")
                        ->send();

                    return redirect()->route('filament.panitia.resources.verifikasi-pembayarans.index');
                }),

            // ACTION: TOLAK
            Actions\Action::make('reject')
                ->label('Tolak Pembayaran')
                ->icon('heroicon-o-x-circle')
                ->color('danger')
                ->requiresConfirmation()
                ->modalHeading('Tolak Pembayaran')
                ->modalDescription('Berikan alasan penolakan')
                ->form([
                    Forms\Components\Textarea::make('catatan')
                        ->label('Alasan Penolakan')
                        ->required()
                        ->rows(4)
                        ->placeholder('Contoh: Bukti pembayaran tidak jelas, nominal tidak sesuai, transfer dari rekening orang lain, dll'),
                ])
                ->visible(fn () => $this->record->status === 'pending')
                ->action(function (array $data) {
                    $this->record->update([
                        'status' => 'rejected',
                        'catatan' => $data['catatan'],
                        'verified_by' => auth()->id(),
                        'verified_at' => now(),
                    ]);

                    Notification::make()
                        ->title('Pembayaran Ditolak')
                        ->danger()
                        ->body("Pembayaran dari {$this->record->pendaftaran->nama_lengkap} telah ditolak.")
                        ->send();

                    return redirect()->route('filament.panitia.resources.verifikasi-pembayarans.index');
                }),

            // ACTION: RESET STATUS
            Actions\Action::make('reset')
                ->label('Reset Status')
                ->icon('heroicon-o-arrow-path')
                ->color('warning')
                ->requiresConfirmation()
                ->modalHeading('Reset Status Pembayaran')
                ->modalDescription('Status pembayaran akan dikembalikan ke pending')
                ->visible(fn () => in_array($this->record->status, ['verified', 'rejected']))
                ->action(function () {
                    $this->record->update([
                        'status' => 'pending',
                        'catatan' => null,
                        'verified_by' => null,
                        'verified_at' => null,
                    ]);

                    Notification::make()
                        ->title('Status Direset')
                        ->warning()
                        ->send();
                }),

            Actions\Action::make('back')
                ->label('Kembali')
                ->url(fn (): string => VerifikasiPembayaranResource::getUrl('index'))
                ->color('gray'),
        ];
    }
}