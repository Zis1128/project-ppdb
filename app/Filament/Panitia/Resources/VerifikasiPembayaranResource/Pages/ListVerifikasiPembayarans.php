<?php

namespace App\Filament\Panitia\Resources\VerifikasiPembayaranResource\Pages;

use App\Filament\Panitia\Resources\VerifikasiPembayaranResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Components\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListVerifikasiPembayarans extends ListRecords
{
    protected static string $resource = VerifikasiPembayaranResource::class;

    public function getTabs(): array
    {
        return [
            'all' => Tab::make('Semua')
                ->icon('heroicon-o-queue-list')
                ->badge(fn () => \App\Models\Pembayaran::count()),

            'pending' => Tab::make('Menunggu Verifikasi')
                ->icon('heroicon-o-clock')
                ->badge(fn () => \App\Models\Pembayaran::where('status', 'pending')->count())
                ->badgeColor('warning')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'pending')),

            'verified' => Tab::make('Terverifikasi')
                ->icon('heroicon-o-check-circle')
                ->badge(fn () => \App\Models\Pembayaran::where('status', 'verified')->count())
                ->badgeColor('success')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'verified')),

            'rejected' => Tab::make('Ditolak')
                ->icon('heroicon-o-x-circle')
                ->badge(fn () => \App\Models\Pembayaran::where('status', 'rejected')->count())
                ->badgeColor('danger')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', 'rejected')),
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('refresh')
                ->label('Refresh')
                ->icon('heroicon-o-arrow-path')
                ->action(fn () => $this->redirect(request()->url())),
        ];
    }
}