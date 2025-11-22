<?php

namespace App\Filament\Panitia\Widgets;

use App\Models\Pendaftaran;
use Filament\Widgets\ChartWidget;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class PanitiaChartWidget extends ChartWidget
{
    protected static ?string $heading = 'Verifikasi 7 Hari Terakhir';

    protected static ?int $sort = 2;

    protected function getData(): array
    {
        $verified = Trend::model(Pendaftaran::class)
            ->between(
                start: now()->subDays(7),
                end: now(),
            )
            ->perDay()
            ->count();

        $approved = Trend::query(
            Pendaftaran::where('status_verifikasi', 'approved')
        )
            ->between(
                start: now()->subDays(7),
                end: now(),
            )
            ->perDay()
            ->count();

        $rejected = Trend::query(
            Pendaftaran::where('status_verifikasi', 'rejected')
        )
            ->between(
                start: now()->subDays(7),
                end: now(),
            )
            ->perDay()
            ->count();

        return [
            'datasets' => [
                [
                    'label' => 'Total Pendaftar',
                    'data' => $verified->map(fn (TrendValue $value) => $value->aggregate),
                    'backgroundColor' => 'rgba(59, 130, 246, 0.1)',
                    'borderColor' => 'rgb(59, 130, 246)',
                ],
                [
                    'label' => 'Disetujui',
                    'data' => $approved->map(fn (TrendValue $value) => $value->aggregate),
                    'backgroundColor' => 'rgba(34, 197, 94, 0.1)',
                    'borderColor' => 'rgb(34, 197, 94)',
                ],
                [
                    'label' => 'Ditolak',
                    'data' => $rejected->map(fn (TrendValue $value) => $value->aggregate),
                    'backgroundColor' => 'rgba(239, 68, 68, 0.1)',
                    'borderColor' => 'rgb(239, 68, 68)',
                ],
            ],
            'labels' => $verified->map(fn (TrendValue $value) => date('d M', strtotime($value->date))),
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }
}