<?php

namespace App\Filament\Panitia\Resources\VerifikasiPendaftaranResource\Pages;

use App\Filament\Panitia\Resources\VerifikasiPendaftaranResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditVerifikasiPendaftaran extends EditRecord
{
    protected static string $resource = VerifikasiPendaftaranResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
