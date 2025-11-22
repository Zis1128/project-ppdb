<?php

namespace App\Filament\Panitia\Widgets;

use App\Models\Pendaftaran;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class PanitiaTasksWidget extends BaseWidget
{
    protected static ?int $sort = 3;

    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Pendaftaran::query()
                    ->where('status_verifikasi', 'pending')
                    ->latest()
                    ->limit(10)
            )
            ->columns([
                Tables\Columns\TextColumn::make('no_pendaftaran')
                    ->label('No. Pendaftaran')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('nama_lengkap')
                    ->label('Nama')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('jurusanPilihan1.nama')
                    ->label('Jurusan')
                    ->badge()
                    ->color('success'),

                Tables\Columns\TextColumn::make('pembayaran.status')
                    ->label('Pembayaran')
                    ->badge()
                    ->formatStateUsing(fn ($state) => $state ? match($state) {
                        'pending' => 'Pending',
                        'verified' => 'Lunas',
                        'rejected' => 'Ditolak',
                        default => '-'
                    } : 'Belum Bayar')
                    ->color(fn ($state) => $state ? match($state) {
                        'pending' => 'warning',
                        'verified' => 'success',
                        'rejected' => 'danger',
                        default => 'gray'
                    } : 'gray'),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tanggal Daftar')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
            ])
            ->actions([
                Tables\Actions\Action::make('verify')
                    ->label('Verifikasi')
                    ->icon('heroicon-m-check-circle')
                    ->url(fn (Pendaftaran $record): string => 
                        route('filament.panitia.resources.verifikasi-pendaftarans.view', ['record' => $record])
                    ),
            ]);
    }

    protected function getTableHeading(): string
    {
        return 'Tugas Verifikasi Pending';
    }
}