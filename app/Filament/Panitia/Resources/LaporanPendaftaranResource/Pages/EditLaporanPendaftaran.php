<?php

namespace App\Filament\Panitia\Resources\LaporanPendaftaranResource\Pages;

use App\Filament\Panitia\Resources\LaporanPendaftaranResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditLaporanPendaftaran extends EditRecord
{
    protected static string $resource = LaporanPendaftaranResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
