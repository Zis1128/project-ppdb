<?php

namespace App\Filament\Panitia\Resources\DokumenSiswaResource\Pages;

use App\Filament\Panitia\Resources\DokumenSiswaResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Components\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListDokumenSiswas extends ListRecords
{
    protected static string $resource = DokumenSiswaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('refresh')
                ->label('Refresh')
                ->icon('heroicon-o-arrow-path')
                ->action(fn () => $this->redirect(request()->url())),
        ];
    }

    public function getTabs(): array
{
    return [
        'all' => Tab::make('Semua')
            ->icon('heroicon-o-queue-list')
            ->badge(fn () => \App\Models\DokumenSiswa::count()),

        'pending' => Tab::make('Menunggu Verifikasi')
            ->icon('heroicon-o-clock')
            ->badge(fn () => \App\Models\DokumenSiswa::where('status_verifikasi', 'pending')->count())  // ← UBAH
            ->badgeColor('warning')
            ->modifyQueryUsing(fn (Builder $query) => $query->where('status_verifikasi', 'pending')),  // ← UBAH

        'approved' => Tab::make('Approved')
            ->icon('heroicon-o-check-circle')
            ->badge(fn () => \App\Models\DokumenSiswa::where('status_verifikasi', 'approved')->count())  // ← UBAH
            ->badgeColor('success')
            ->modifyQueryUsing(fn (Builder $query) => $query->where('status_verifikasi', 'approved')),  // ← UBAH

        'rejected' => Tab::make('Rejected')
            ->icon('heroicon-o-x-circle')
            ->badge(fn () => \App\Models\DokumenSiswa::where('status_verifikasi', 'rejected')->count())  // ← UBAH
            ->badgeColor('danger')
            ->modifyQueryUsing(fn (Builder $query) => $query->where('status_verifikasi', 'rejected')),  // ← UBAH
        ];
    }
}