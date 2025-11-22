<?php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    protected static string $routePath = '/';
    
    protected static ?string $title = 'Dashboard PPDB';
    
    protected static ?string $navigationLabel = 'Dashboard';
    
    public function getWidgets(): array
    {
        return [
            \App\Filament\Widgets\StatsOverviewWidget::class,
            \App\Filament\Widgets\PendaftaranChartWidget::class,
            \App\Filament\Widgets\LatestPendaftaranWidget::class,
        ];
    }

    public function getColumns(): int | array
    {
        return 2;
    }
}