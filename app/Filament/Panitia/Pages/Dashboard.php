<?php

namespace App\Filament\Panitia\Pages;

use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    protected static string $routePath = '/';
    
    protected static ?string $title = 'Dashboard Panitia';
    
    protected static ?string $navigationLabel = 'Dashboard';

    public function getWidgets(): array
    {
        return [
            \App\Filament\Panitia\Widgets\PanitiaStatsWidget::class,
            \App\Filament\Panitia\Widgets\PanitiaChartWidget::class,
            \App\Filament\Panitia\Widgets\PanitiaTasksWidget::class,
        ];
    }

    public function getColumns(): int | array
    {
        return 2;
    }
}