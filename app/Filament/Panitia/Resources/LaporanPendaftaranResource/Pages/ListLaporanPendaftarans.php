<?php

namespace App\Filament\Panitia\Resources\LaporanPendaftaranResource\Pages;

use App\Filament\Panitia\Resources\LaporanPendaftaranResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Components\Tab;
use Illuminate\Database\Eloquent\Builder;
use pxlrbt\FilamentExcel\Actions\Pages\ExportAction;
use pxlrbt\FilamentExcel\Exports\ExcelExport;

class ListLaporanPendaftarans extends ListRecords
{
    protected static string $resource = LaporanPendaftaranResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ExportAction::make()
                ->label('Export Semua ke Excel')
                ->color('success')
                ->exports([
                    ExcelExport::make()
                        ->fromTable()
                        ->withFilename(fn () => 'Laporan-Lengkap-Pendaftaran-' . date('Y-m-d-His'))
                        ->withWriterType(\Maatwebsite\Excel\Excel::XLSX),
                ]),

            Actions\Action::make('statistik')
                ->label('Statistik')
                ->icon('heroicon-o-chart-bar')
                ->color('info')
                ->modalHeading('Statistik Pendaftaran')
                ->modalContent(function () {
                    $stats = [
                        'total' => \App\Models\Pendaftaran::count(),
                        'draft' => \App\Models\Pendaftaran::where('status_pendaftaran', 'draft')->count(),
                        'submitted' => \App\Models\Pendaftaran::where('status_pendaftaran', 'submitted')->count(),
                        'verified' => \App\Models\Pendaftaran::where('status_pendaftaran', 'verified')->count(),
                        'accepted' => \App\Models\Pendaftaran::where('status_pendaftaran', 'accepted')->count(),
                        'rejected' => \App\Models\Pendaftaran::where('status_pendaftaran', 'rejected')->count(),
                    ];

                    return view('filament.panitia.pages.statistik-modal', compact('stats'));
                }),
        ];
    }

    public function getTabs(): array
    {
        return [
            'all' => Tab::make('Semua')
                ->badge(fn () => \App\Models\Pendaftaran::count()),

            'accepted' => Tab::make('Diterima')
                ->badge(fn () => \App\Models\Pendaftaran::where('status_pendaftaran', 'accepted')->count())
                ->badgeColor('success')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status_pendaftaran', 'accepted')),

            'rejected' => Tab::make('Ditolak')
                ->badge(fn () => \App\Models\Pendaftaran::where('status_pendaftaran', 'rejected')->count())
                ->badgeColor('danger')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status_pendaftaran', 'rejected')),

            'verified' => Tab::make('Verified')
                ->badge(fn () => \App\Models\Pendaftaran::where('status_pendaftaran', 'verified')->count())
                ->badgeColor('primary')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status_pendaftaran', 'verified')),

            'submitted' => Tab::make('Submitted')
                ->badge(fn () => \App\Models\Pendaftaran::where('status_pendaftaran', 'submitted')->count())
                ->badgeColor('info')
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status_pendaftaran', 'submitted')),
        ];
    }
}