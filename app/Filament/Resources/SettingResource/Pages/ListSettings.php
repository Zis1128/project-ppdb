<?php

namespace App\Filament\Resources\SettingResource\Pages;

use App\Filament\Resources\SettingResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSettings extends ListRecords
{
    protected static string $resource = SettingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('payment_settings')
                ->label('Pengaturan Pembayaran')
                ->icon('heroicon-o-credit-card')
                ->color('success')
                ->url(route('filament.admin.resources.settings.settings')),
                
            Actions\CreateAction::make(),
        ];
    }
}