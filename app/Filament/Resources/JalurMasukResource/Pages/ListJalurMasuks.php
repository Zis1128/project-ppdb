<?php

namespace App\Filament\Resources\JalurMasukResource\Pages;

use App\Filament\Resources\JalurMasukResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListJalurMasuks extends ListRecords
{
    protected static string $resource = JalurMasukResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
