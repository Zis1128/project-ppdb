<?php

namespace App\Filament\Resources;

use App\Filament\Resources\JurusanResource\Pages;
use App\Models\Jurusan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

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

                        Forms\Components\FileUpload::make('icon')
                            ->label('Icon/Logo Jurusan')
                            ->image()
                            ->directory('jurusan-icons')
                            ->maxSize(1024)
                            ->imageEditor()
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

                Tables\Columns\ImageColumn::make('icon')
                    ->label('Icon')
                    ->circular()
                    ->defaultImageUrl(url('/images/default-jurusan.png')),

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

                Tables\Columns\TextColumn::make('passing_grade')
                    ->label('Passing Grade')
                    ->numeric()
                    ->sortable()
                    ->suffix(' poin'),

                Tables\Columns\TextColumn::make('pendaftaransPilihan1_count')
                    ->label('Peminat P1')
                    ->counts('pendaftaransPilihan1')
                    ->badge()
                    ->color('success'),

                Tables\Columns\TextColumn::make('pendaftaransPilihan2_count')
                    ->label('Peminat P2')
                    ->counts('pendaftaransPilihan2')
                    ->badge()
                    ->color('info'),

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
                Tables\Actions\DeleteAction::make(),
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