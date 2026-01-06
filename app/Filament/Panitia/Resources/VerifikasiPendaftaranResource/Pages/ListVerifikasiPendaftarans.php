<?php

namespace App\Filament\Panitia\Resources\VerifikasiPendaftaranResource\Pages;

use App\Filament\Panitia\Resources\VerifikasiPendaftaranResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Components\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListVerifikasiPendaftarans extends ListRecords
{
    protected static string $resource = VerifikasiPendaftaranResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('statistik')
                ->label('Lihat Statistik')
                ->icon('heroicon-o-chart-bar')
                ->color('info')
                ->url(fn (): string => route('filament.panitia.pages.dashboard')),
        ];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make('Semua')
                ->icon('heroicon-o-queue-list')
                ->badge(fn () => \App\Models\Pendaftaran::whereIn('status_pendaftaran', ['submitted', 'verified', 'accepted', 'rejected'])->count()),

            'submitted' => Tab::make('Menunggu Verifikasi')
                ->icon('heroicon-o-clock')
                ->badge(fn () => \App\Models\Pendaftaran::where('status_pendaftaran', 'submitted')->count())
                ->badgeColor('warning')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status_pendaftaran', 'submitted')),

            'verified' => Tab::make('Terverifikasi')
                ->icon('heroicon-o-check-circle')
                ->badge(fn () => \App\Models\Pendaftaran::where('status_pendaftaran', 'verified')->count())
                ->badgeColor('primary')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status_pendaftaran', 'verified')),

            'accepted' => Tab::make('Diterima')
                ->icon('heroicon-o-check-badge')
                ->badge(fn () => \App\Models\Pendaftaran::where('status_pendaftaran', 'accepted')->count())
                ->badgeColor('success')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status_pendaftaran', 'accepted')),

            'rejected' => Tab::make('Ditolak')
                ->icon('heroicon-o-x-circle')
                ->badge(fn () => \App\Models\Pendaftaran::where('status_pendaftaran', 'rejected')->count())
                ->badgeColor('danger')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status_pendaftaran', 'rejected')),
        ];
    }
}