<?php

namespace App\Filament\Panitia\Resources\VerifikasiPendaftaranResource\Pages;

use App\Filament\Panitia\Resources\VerifikasiPendaftaranResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListVerifikasiPendaftarans extends ListRecords
{
    protected static string $resource = VerifikasiPendaftaranResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
