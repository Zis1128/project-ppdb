<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SettingResource\Pages;
use App\Models\Setting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class SettingResource extends Resource
{
    protected static ?string $model = Setting::class;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';
    
    protected static ?string $navigationLabel = 'Pengaturan';
    
    protected static ?string $navigationGroup = 'Sistem';
    
    protected static ?int $navigationSort = 99;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('key')
                    ->label('Key')
                    ->required()
                    ->unique(ignoreRecord: true)
                    ->maxLength(255),
                    
                Forms\Components\Textarea::make('value')
                    ->label('Value')
                    ->rows(3),
                    
                Forms\Components\Select::make('type')
                    ->label('Type')
                    ->options([
                        'text' => 'Text',
                        'textarea' => 'Textarea',
                        'number' => 'Number',
                        'boolean' => 'Boolean',
                        'password' => 'Password',
                    ])
                    ->required(),
                    
                Forms\Components\TextInput::make('group')
                    ->label('Group')
                    ->maxLength(255),
                    
                Forms\Components\TextInput::make('label')
                    ->label('Label')
                    ->maxLength(255),
                    
                Forms\Components\Textarea::make('description')
                    ->label('Description')
                    ->rows(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('key')
                    ->label('Key')
                    ->searchable()
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('value')
                    ->label('Value')
                    ->limit(50)
                    ->searchable(),
                    
                Tables\Columns\TextColumn::make('type')
                    ->label('Type')
                    ->badge()
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('group')
                    ->label('Group')
                    ->badge()
                    ->color('success')
                    ->sortable(),
                    
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Updated')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('group')
                    ->options([
                        'payment' => 'Payment',
                        'general' => 'General',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSettings::route('/'),
            'create' => Pages\CreateSetting::route('/create'),
            'edit' => Pages\EditSetting::route('/{record}/edit'),
            'settings' => Pages\Settings::route('/payment'), // Custom page untuk Payment Settings
        ];
    }
}