<?php

namespace App\Filament\Widgets;

use App\Models\Pendaftaran;
use App\Models\Pembayaran;
use App\Models\Jurusan;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverviewWidget extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Total Pendaftar', Pendaftaran::count())
                ->description('Total pendaftar keseluruhan')
                ->descriptionIcon('heroicon-m-user-group')
                ->color('primary')
                ->chart([7, 12, 15, 18, 22, 28, 32]),

            Stat::make('Pendaftar Baru', Pendaftaran::whereDate('created_at', today())->count())
                ->description('Pendaftar hari ini')
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->color('success'),

            Stat::make('Menunggu Verifikasi', Pendaftaran::where('status_verifikasi', 'pending')->count())
                ->description('Perlu diverifikasi')
                ->descriptionIcon('heroicon-m-clock')
                ->color('warning'),

            Stat::make('Pembayaran Pending', Pembayaran::where('status', 'pending')->count())
                ->description('Menunggu konfirmasi')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('danger'),

            Stat::make('Diterima', Pendaftaran::where('status_pendaftaran', 'accepted')->count())
                ->description('Siswa diterima')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success'),

            Stat::make('Total Jurusan', Jurusan::active()->count())
                ->description('Jurusan tersedia')
                ->descriptionIcon('heroicon-m-academic-cap')
                ->color('info'),
        ];
    }
}