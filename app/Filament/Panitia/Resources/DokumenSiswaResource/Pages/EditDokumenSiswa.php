<?php

namespace App\Filament\Panitia\Resources\DokumenSiswaResource\Pages;

use App\Filament\Panitia\Resources\DokumenSiswaResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditDokumenSiswa extends EditRecord
{
    protected static string $resource = DokumenSiswaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
