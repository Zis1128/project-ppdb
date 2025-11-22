<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PersyaratanResource\Pages;
use App\Models\Persyaratan;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PersyaratanResource extends Resource
{
    protected static ?string $model = Persyaratan::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-check';

    protected static ?string $navigationGroup = 'Master Data';

    protected static ?int $navigationSort = 5;

    protected static ?string $navigationLabel = 'Persyaratan Dokumen';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Persyaratan')
                    ->schema([
                        Forms\Components\TextInput::make('nama')
                            ->label('Nama Dokumen')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Foto 3x4, Ijazah, Kartu Keluarga'),

                        Forms\Components\Textarea::make('deskripsi')
                            ->label('Deskripsi/Ketentuan')
                            ->rows(3)
                            ->placeholder('Contoh: Foto ukuran 3x4, background merah, format JPG/PNG')
                            ->columnSpanFull(),

                        Forms\Components\Grid::make(3)
                            ->schema([
                                Forms\Components\Select::make('jenis_file')
                                    ->label('Jenis File')
                                    ->required()
                                    ->options([
                                        'image' => 'Gambar (JPG, PNG)',
                                        'pdf' => 'PDF',
                                        'document' => 'Dokumen (DOC, DOCX)',
                                    ])
                                    ->default('image')
                                    ->native(false),

                                Forms\Components\TextInput::make('max_size')
                                    ->label('Maksimal Ukuran')
                                    ->required()
                                    ->numeric()
                                    ->minValue(100)
                                    ->default(2048)
                                    ->suffix('KB'),

                                Forms\Components\TextInput::make('urutan')
                                    ->label('Urutan Tampil')
                                    ->required()
                                    ->numeric()
                                    ->default(0),
                            ]),

                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\Toggle::make('is_wajib')
                                    ->label('Dokumen Wajib')
                                    ->default(true)
                                    ->helperText('Harus diupload saat pendaftaran'),

                                Forms\Components\Toggle::make('is_active')
                                    ->label('Status Aktif')
                                    ->default(true),
                            ]),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('urutan')
                    ->label('No')
                    ->sortable(),

                Tables\Columns\TextColumn::make('nama')
                    ->label('Nama Dokumen')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('deskripsi')
                    ->label('Deskripsi')
                    ->limit(50)
                    ->wrap()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('jenis_file')
                    ->label('Jenis File')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'image' => 'success',
                        'pdf' => 'danger',
                        'document' => 'info',
                    }),

                Tables\Columns\TextColumn::make('max_size')
                    ->label('Max Size')
                    ->suffix(' KB'),

                Tables\Columns\IconColumn::make('is_wajib')
                    ->label('Wajib')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('gray'),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('Status')
                    ->boolean()
                    ->trueIcon('heroicon-o-check-circle')
                    ->falseIcon('heroicon-o-x-circle')
                    ->trueColor('success')
                    ->falseColor('danger'),

                Tables\Columns\TextColumn::make('dokumenSiswas_count')
                    ->label('Uploaded')
                    ->counts('dokumenSiswas')
                    ->badge()
                    ->color('info'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('jenis_file')
                    ->label('Jenis File')
                    ->options([
                        'image' => 'Gambar',
                        'pdf' => 'PDF',
                        'document' => 'Dokumen',
                    ]),

                Tables\Filters\TernaryFilter::make('is_wajib')
                    ->label('Wajib')
                    ->placeholder('Semua')
                    ->trueLabel('Wajib')
                    ->falseLabel('Opsional'),

                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Status')
                    ->placeholder('Semua')
                    ->trueLabel('Aktif')
                    ->falseLabel('Tidak Aktif'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('urutan', 'asc')
            ->reorderable('urutan');
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
            'index' => Pages\ListPersyaratans::route('/'),
            'create' => Pages\CreatePersyaratan::route('/create'),
            'edit' => Pages\EditPersyaratan::route('/{record}/edit'),
        ];
    }
}