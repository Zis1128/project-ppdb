<?php

namespace App\Filament\Panitia\Pages;

use App\Models\Pendaftaran;
use App\Models\Pembayaran;
use App\Models\Jurusan;
use App\Models\JalurMasuk;
use Filament\Pages\Page;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;

class RekapPendaftaran extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-chart-pie';

    protected static string $view = 'filament.panitia.pages.rekap-pendaftaran';

    protected static ?string $navigationGroup = 'Laporan';

    protected static ?int $navigationSort = 2;

    protected static ?string $title = 'Rekap & Statistik';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                DatePicker::make('date_from')
                    ->label('Dari Tanggal')
                    ->native(false),
                
                DatePicker::make('date_to')
                    ->label('Sampai Tanggal')
                    ->native(false),
                
                Select::make('jurusan_id')
                    ->label('Filter Jurusan')
                    ->options(Jurusan::pluck('nama', 'id'))
                    ->searchable(),
            ])
            ->statePath('data')
            ->columns(3);
    }

    public function getStats(): array
    {
        $query = Pendaftaran::query();

        if ($this->data['date_from'] ?? null) {
            $query->whereDate('created_at', '>=', $this->data['date_from']);
        }

        if ($this->data['date_to'] ?? null) {
            $query->whereDate('created_at', '<=', $this->data['date_to']);
        }

        if ($this->data['jurusan_id'] ?? null) {
            $query->where('jurusan_pilihan_1', $this->data['jurusan_id']);
        }

        return [
            'total' => $query->count(),
            'pending' => (clone $query)->where('status_verifikasi', 'pending')->count(),
            'approved' => (clone $query)->where('status_verifikasi', 'approved')->count(),
            'rejected' => (clone $query)->where('status_verifikasi', 'rejected')->count(),
            'accepted' => (clone $query)->where('status_pendaftaran', 'accepted')->count(),
        ];
    }

    public function getRekapPerJurusan(): array
    {
        return Jurusan::withCount([
            'pendaftaransPilihan1',
            'pendaftaransDiterima'
        ])->get()->map(function ($jurusan) {
            return [
                'nama' => $jurusan->nama,
                'kuota' => $jurusan->kuota,
                'peminat' => $jurusan->pendaftarans_pilihan1_count,
                'diterima' => $jurusan->pendaftarans_diterima_count,
                'sisa' => $jurusan->kuota - $jurusan->pendaftarans_diterima_count,
                'persentase' => $jurusan->kuota > 0 ? 
                    round(($jurusan->pendaftarans_diterima_count / $jurusan->kuota) * 100, 2) : 0,
            ];
        })->toArray();
    }

    public function getRekapPerJalur(): array
    {
        return JalurMasuk::withCount('pendaftarans')->get()->map(function ($jalur) {
            return [
                'nama' => $jalur->nama,
                'total' => $jalur->pendaftarans_count,
                'approved' => Pendaftaran::where('jalur_masuk_id', $jalur->id)
                    ->where('status_verifikasi', 'approved')->count(),
                'rejected' => Pendaftaran::where('jalur_masuk_id', $jalur->id)
                    ->where('status_verifikasi', 'rejected')->count(),
            ];
        })->toArray();
    }

    public function getRekapPembayaran(): array
    {
        return [
            'total' => Pembayaran::sum('jumlah'),
            'verified' => Pembayaran::where('status', 'verified')->sum('jumlah'),
            'pending' => Pembayaran::where('status', 'pending')->sum('jumlah'),
            'rejected' => Pembayaran::where('status', 'rejected')->sum('jumlah'),
            'count_verified' => Pembayaran::where('status', 'verified')->count(),
            'count_pending' => Pembayaran::where('status', 'pending')->count(),
        ];
    }
}