<?php

namespace App\Filament\Resources;

use App\Filament\Resources\JalurMasukResource\Pages;
use App\Models\JalurMasuk;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class JalurMasukResource extends Resource
{
    protected static ?string $model = JalurMasuk::class;

    protected static ?string $navigationIcon = 'heroicon-o-arrow-path';

    protected static ?string $navigationGroup = 'Master Data';

    protected static ?int $navigationSort = 4;

    protected static ?string $navigationLabel = 'Jalur Masuk';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Jalur Masuk')
                    ->schema([
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('nama')
                                    ->label('Nama Jalur')
                                    ->required()
                                    ->maxLength(255)
                                    ->placeholder('Reguler, Prestasi, Afirmasi'),

                                Forms\Components\TextInput::make('kode')
                                    ->label('Kode Jalur')
                                    ->required()
                                    ->maxLength(255)
                                    ->unique(ignoreRecord: true)
                                    ->placeholder('REG, PRES, AFI')
                                    ->alphaDash(),
                            ]),

                        Forms\Components\Textarea::make('deskripsi')
                            ->label('Deskripsi')
                            ->rows(3)
                            ->columnSpanFull(),

                        Forms\Components\Repeater::make('persyaratan')
                            ->label('Persyaratan Khusus')
                            ->schema([
                                Forms\Components\TextInput::make('item')
                                    ->label('Persyaratan')
                                    ->required()
                                    ->placeholder('Misal: Sertifikat Juara 1-3 tingkat Nasional'),
                            ])
                            ->columnSpanFull()
                            ->collapsible()
                            ->defaultItems(0)
                            ->addActionLabel('Tambah Persyaratan'),

                        Forms\Components\TextInput::make('kuota_persen')
                            ->label('Persentase Kuota')
                            ->required()
                            ->numeric()
                            ->minValue(0)
                            ->maxValue(100)
                            ->default(0)
                            ->suffix('%')
                            ->helperText('Persentase dari kuota jurusan'),

                        Forms\Components\Toggle::make('is_active')
                            ->label('Status Aktif')
                            ->default(true),
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
                    ->color('warning'),

                Tables\Columns\TextColumn::make('nama')
                    ->label('Nama Jalur')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('deskripsi')
                    ->label('Deskripsi')
                    ->limit(50)
                    ->wrap(),

                Tables\Columns\TextColumn::make('kuota_persen')
                    ->label('Kuota')
                    ->suffix('%')
                    ->sortable(),

                Tables\Columns\TextColumn::make('pendaftarans_count')
                    ->label('Pendaftar')
                    ->counts('pendaftarans')
                    ->badge()
                    ->color('info'),

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
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
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
            'index' => Pages\ListJalurMasuks::route('/'),
            'create' => Pages\CreateJalurMasuk::route('/create'),
            'edit' => Pages\EditJalurMasuk::route('/{record}/edit'),
        ];
    }
}