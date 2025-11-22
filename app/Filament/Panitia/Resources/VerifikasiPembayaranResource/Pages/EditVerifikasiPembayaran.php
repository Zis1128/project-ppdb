<?php

namespace App\Filament\Panitia\Resources\VerifikasiPembayaranResource\Pages;

use App\Filament\Panitia\Resources\VerifikasiPembayaranResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditVerifikasiPembayaran extends EditRecord
{
    protected static string $resource = VerifikasiPembayaranResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
