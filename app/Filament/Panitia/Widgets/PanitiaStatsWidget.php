<?php

namespace App\Filament\Panitia\Widgets;

use App\Models\Pendaftaran;
use App\Models\Pembayaran;
use App\Models\DokumenSiswa;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class PanitiaStatsWidget extends BaseWidget
{
    protected function getStats(): array
    {
        $pendingPendaftaran = Pendaftaran::where('status_verifikasi', 'pending')->count();
        $pendingPembayaran = Pembayaran::where('status', 'pending')->count();
        $pendingDokumen = DokumenSiswa::where('status_verifikasi', 'pending')->count();
        
        $verifiedToday = Pendaftaran::where('verified_by', auth()->id())
            ->whereDate('verified_at', today())
            ->count();

        return [
            Stat::make('Pendaftaran Perlu Verifikasi', $pendingPendaftaran)
                ->description('Menunggu verifikasi')
                ->descriptionIcon('heroicon-m-clipboard-document-check')
                ->color('warning')
                ->url(route('filament.panitia.resources.verifikasi-pendaftarans.index')),

            Stat::make('Pembayaran Pending', $pendingPembayaran)
                ->description('Menunggu konfirmasi')
                ->descriptionIcon('heroicon-m-credit-card')
                ->color('danger')
                ->url(route('filament.panitia.resources.verifikasi-pembayarans.index')),

            Stat::make('Dokumen Pending', $pendingDokumen)
                ->description('Perlu diverifikasi')
                ->descriptionIcon('heroicon-m-document-check')
                ->color('info'),

            Stat::make('Verifikasi Hari Ini', $verifiedToday)
                ->description('Anda telah verifikasi')
                ->descriptionIcon('heroicon-m-check-badge')
                ->color('success'),

            Stat::make('Total Disetujui', Pendaftaran::where('status_verifikasi', 'approved')->count())
                ->description('Pendaftaran disetujui')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success'),

            Stat::make('Total Ditolak', Pendaftaran::where('status_verifikasi', 'rejected')->count())
                ->description('Pendaftaran ditolak')
                ->descriptionIcon('heroicon-m-x-circle')
                ->color('danger'),
        ];
    }
}