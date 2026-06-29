<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SettingResource\Pages;
use App\Models\Setting;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;

class SettingResource extends Resource
{
    protected static ?string $model = Setting::class;

    protected static ?string $navigationGroup = 'Management';
    protected static ?string $navigationIcon = 'heroicon-o-cog';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make()
                    ->schema([
                        Forms\Components\TextInput::make('key')
                            ->required()
                            ->unique(table: 'settings', column: 'key', ignorable: fn($record) => $record)
                            ->disabled(fn($record) => $record !== null)
                            ->placeholder('technical_key_name'),

                        Forms\Components\TextInput::make('label')
                            ->required()
                            ->placeholder('Human readable name'),

                        Forms\Components\Textarea::make('value')
                            ->required()
                            ->rows(5)
                            ->placeholder('Enter value here'),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('key')
                    ->sortable()
                    ->searchable()
                    ->copyable(),

                Tables\Columns\TextColumn::make('label')
                    ->searchable(),

                Tables\Columns\TextColumn::make('value')
                    ->limit(50),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageSettings::route('/'),
        ];
    }
}
