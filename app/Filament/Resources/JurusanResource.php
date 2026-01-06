<?php

namespace App\Filament\Resources;

use App\Filament\Resources\JurusanResource\Pages;
use App\Models\Jurusan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Storage;  // ← FIX INI

class JurusanResource extends Resource
{
    protected static ?string $model = Jurusan::class;

    protected static ?string $navigationIcon = 'heroicon-o-academic-cap';

    protected static ?string $navigationGroup = 'Master Data';

    protected static ?int $navigationSort = 3;

    protected static ?string $navigationLabel = 'Jurusan';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Jurusan')
                    ->schema([
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('kode')
                                    ->label('Kode Jurusan')
                                    ->required()
                                    ->maxLength(255)
                                    ->unique(ignoreRecord: true)
                                    ->placeholder('TKJ, RPL, MM')
                                    ->alphaDash(),

                                Forms\Components\TextInput::make('nama')
                                    ->label('Nama Jurusan')
                                    ->required()
                                    ->maxLength(255)
                                    ->placeholder('Teknik Komputer dan Jaringan'),
                            ]),

                        Forms\Components\Textarea::make('deskripsi')
                            ->label('Deskripsi Jurusan')
                            ->rows(4)
                            ->columnSpanFull()
                            ->helperText('Penjelasan singkat tentang jurusan'),

                        Forms\Components\FileUpload::make('logo')
                            ->label('Icon/Logo Jurusan')
                            ->image()
                            ->disk('public')
                            ->directory('images')
                            ->visibility('public')
                            ->preserveFilenames(false)
                            ->maxSize(2048)
                            ->acceptedFileTypes(['image/png', 'image/jpeg', 'image/jpg', 'image/svg+xml'])
                            ->imagePreviewHeight('250')
                            ->helperText('Upload icon/logo jurusan. Format: PNG, JPG, SVG. Maksimal 2MB.')
                            ->columnSpanFull()
                            // TAMBAHKAN INI untuk delete old file
                            ->deleteUploadedFileUsing(function ($file) {
                                if ($file && Storage::disk('public')->exists($file)) {
                                    Storage::disk('public')->delete($file);
                                }
                            }),

                        Forms\Components\Textarea::make('kompetensi')
                            ->label('Kompetensi Keahlian')
                            ->placeholder('Pisahkan dengan koma. Contoh: Pemrograman Web, Database, Networking')
                            ->rows(3)
                            ->columnSpanFull(),

                        Forms\Components\Textarea::make('prospek_kerja')
                            ->label('Prospek Kerja')
                            ->placeholder('Contoh: Web Developer, System Analyst, IT Support, dll')
                            ->rows(3)
                            ->columnSpanFull(),    

                        Forms\Components\Grid::make(3)
                            ->schema([
                                Forms\Components\TextInput::make('kuota')
                                    ->label('Kuota Siswa')
                                    ->required()
                                    ->numeric()
                                    ->minValue(0)
                                    ->default(0)
                                    ->suffix('siswa'),

                                Forms\Components\TextInput::make('kuota_terpakai')
                                    ->label('Kuota Terpakai')
                                    ->numeric()
                                    ->default(0)
                                    ->disabled()
                                    ->dehydrated(false)
                                    ->helperText('Jumlah siswa yang sudah diterima')
                                    ->visible(fn (string $context) => $context === 'edit'),

                                Forms\Components\Placeholder::make('kuota_tersisa')
                                    ->label('Sisa Kuota')
                                    ->content(fn ($record) => $record ? max(0, $record->kuota - $record->kuota_terpakai) : '-')
                                    ->visible(fn (string $context) => $context === 'edit'),

                                Forms\Components\TextInput::make('passing_grade')
                                    ->label('Passing Grade')
                                    ->required()
                                    ->numeric()
                                    ->minValue(0)
                                    ->maxValue(100)
                                    ->default(0)
                                    ->step(0.01)
                                    ->suffix('poin'),

                                Forms\Components\TextInput::make('urutan')
                                    ->label('Urutan Tampil')
                                    ->required()
                                    ->numeric()
                                    ->default(0)
                                    ->helperText('Untuk sorting tampilan'),
                            ]),

                        Forms\Components\Toggle::make('is_active')
                            ->label('Status Aktif')
                            ->default(true)
                            ->helperText('Jurusan tersedia untuk pendaftaran'),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('kode')
                    ->label('Kode')
                    ->searchable()
                    ->sortable()
                    ->badge()
                    ->color('primary'),

                // ← FIX INI: Ganti 'icon' jadi 'logo'
                Tables\Columns\ImageColumn::make('logo')  // ✅ BENAR
                    ->label('Icon')
                    ->disk('public')
                    ->height(50)
                    ->width(50)
                    ->circular()
                    ->defaultImageUrl(function ($record) {
                        // Fallback ke UI Avatars jika logo kosong
                        $initial = strtoupper(substr($record->kode, 0, 2));
                        return "https://ui-avatars.com/api/?name={$initial}&background=3b82f6&color=fff&size=100&font-size=0.4&bold=true";
                    })
                    ->extraImgAttributes(['loading' => 'lazy']),

                Tables\Columns\TextColumn::make('nama')
                    ->label('Nama Jurusan')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->wrap(),

                Tables\Columns\TextColumn::make('kuota')
                    ->label('Kuota')
                    ->numeric()
                    ->sortable()
                    ->suffix(' siswa'),

                Tables\Columns\TextColumn::make('kuota_terpakai')
                    ->label('Terpakai')
                    ->sortable()
                    ->alignCenter()
                    ->badge()
                    ->color(fn (Jurusan $record): string => 
                        $record->kuota_terpakai >= $record->kuota ? 'danger' : 
                        ($record->kuota_terpakai >= ($record->kuota * 0.8) ? 'warning' : 'success')
                    ),

                Tables\Columns\TextColumn::make('kuota_tersisa')
                    ->label('Sisa Kuota')
                    ->getStateUsing(fn (Jurusan $record): int => max(0, $record->kuota - $record->kuota_terpakai))
                    ->alignCenter()
                    ->badge()
                    ->color(fn ($state): string => 
                        $state === 0 ? 'danger' : 
                        ($state <= 5 ? 'warning' : 'success')
                    ),

                Tables\Columns\TextColumn::make('passing_grade')
                    ->label('Passing Grade')
                    ->numeric()
                    ->sortable()
                    ->suffix(' poin'),

                Tables\Columns\TextColumn::make('pendaftaranPilihan1_count')
                    ->label('Peminat P1')
                    ->counts('pendaftaranPilihan1')
                    ->badge()
                    ->color('success')
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('pendaftaranPilihan2_count')
                    ->label('Peminat P2')
                    ->counts('pendaftaranPilihan2')
                    ->badge()
                    ->color('info')
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('urutan')
                    ->label('Urutan')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('Status')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger'),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Status')
                    ->placeholder('Semua')
                    ->trueLabel('Aktif')
                    ->falseLabel('Tidak Aktif'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make()
                    ->before(function (Jurusan $record) {
                        // Delete logo when deleting jurusan
                        if ($record->logo && Storage::disk('public')->exists($record->logo)) {
                            Storage::disk('public')->delete($record->logo);
                        }
                    }),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('urutan', 'asc');
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListJurusans::route('/'),
            'create' => Pages\CreateJurusan::route('/create'),
            'edit' => Pages\EditJurusan::route('/{record}/edit'),
        ];
    }
}