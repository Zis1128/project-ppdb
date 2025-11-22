<?php

namespace App\Filament\Resources\JalurMasukResource\Pages;

use App\Filament\Resources\JalurMasukResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditJalurMasuk extends EditRecord
{
    protected static string $resource = JalurMasukResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
