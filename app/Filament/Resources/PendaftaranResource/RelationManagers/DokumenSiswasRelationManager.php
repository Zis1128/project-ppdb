<?php

namespace App\Filament\Resources\PendaftaranResource\RelationManagers;

use App\Models\Persyaratan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class DokumenSiswasRelationManager extends RelationManager
{
    protected static string $relationship = 'dokumenSiswas';

    protected static ?string $title = 'Dokumen Upload';

    protected static ?string $label = 'dokumen';

    protected static ?string $pluralLabel = 'Dokumen';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('persyaratan_id')
                    ->label('Jenis Dokumen')
                    ->options(Persyaratan::active()->pluck('nama', 'id'))
                    ->required()
                    ->searchable(),

                Forms\Components\FileUpload::make('file_path')
                    ->label('Upload File')
                    ->required()
                    ->directory('dokumen-siswa')
                    ->maxSize(2048)
                    ->acceptedFileTypes(['image/*', 'application/pdf'])
                    ->imageEditor(),

                Forms\Components\Select::make('status_verifikasi')
                    ->label('Status Verifikasi')
                    ->options([
                        'pending' => 'Pending',
                        'approved' => 'Approved',
                        'rejected' => 'Rejected',
                    ])
                    ->required()
                    ->native(false)
                    ->default('pending'),

                Forms\Components\Textarea::make('catatan')
                    ->label('Catatan')
                    ->rows(3),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('persyaratan.nama')
            ->columns([
                Tables\Columns\TextColumn::make('persyaratan.nama')
                    ->label('Jenis Dokumen')
                    ->weight('bold'),

                Tables\Columns\ImageColumn::make('file_path')
                    ->label('Preview')
                    ->size(60)
                    ->defaultImageUrl(url('/images/pdf-icon.png')),

                Tables\Columns\TextColumn::make('file_name')
                    ->label('Nama File')
                    ->limit(30)
                    ->searchable(),

                Tables\Columns\TextColumn::make('file_size')
                    ->label('Ukuran')
                    ->formatStateUsing(fn ($state) => number_format($state / 1024, 2) . ' MB'),

                Tables\Columns\TextColumn::make('status_verifikasi')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'approved' => 'success',
                        'rejected' => 'danger',
                        default => 'gray',
                    })
                    ->formatStateUsing(fn (string $state): string => str($state)->title()),

                Tables\Columns\TextColumn::make('verifiedBy.name')
                    ->label('Diverifikasi Oleh')
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('verified_at')
                    ->label('Tanggal Verifikasi')
                    ->dateTime('d M Y H:i')
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Diupload')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status_verifikasi')
                    ->options([
                        'pending' => 'Pending',
                        'approved' => 'Approved',
                        'rejected' => 'Rejected',
                    ]),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\Action::make('download')
                    ->label('Download')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->url(fn ($record) => asset('storage/' . $record->file_path))
                    ->openUrlInNewTab(),

                Tables\Actions\Action::make('verify')
                    ->label('Verifikasi')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->form([
                        Forms\Components\Select::make('status_verifikasi')
                            ->label('Status')
                            ->options([
                                'approved' => 'Disetujui',
                                'rejected' => 'Ditolak',
                            ])
                            ->required()
                            ->native(false),

                        Forms\Components\Textarea::make('catatan')
                            ->label('Catatan')
                            ->rows(3),
                    ])
                    ->action(function ($record, array $data): void {
                        $record->update([
                            'status_verifikasi' => $data['status_verifikasi'],
                            'catatan' => $data['catatan'],
                            'verified_by' => auth()->id(),
                            'verified_at' => now(),
                        ]);

                        \Filament\Notifications\Notification::make()
                            ->title('Verifikasi Berhasil')
                            ->success()
                            ->send();
                    }),

                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}