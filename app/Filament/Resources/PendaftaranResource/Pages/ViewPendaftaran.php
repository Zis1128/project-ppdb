<?php

namespace App\Filament\Resources\PendaftaranResource\Pages;

use App\Filament\Resources\PendaftaranResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewPendaftaran extends ViewRecord
{
    protected static string $resource = PendaftaranResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('back')
                ->label('Kembali')
                ->url(fn (): string => PendaftaranResource::getUrl('index'))
                ->color('gray'),
        ];
    }
}