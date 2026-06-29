<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LanguageResource\Pages;
use App\Models\Language;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Support\Str;

class LanguageResource extends Resource
{
    protected static ?string $model = Language::class;

    protected static ?string $navigationGroup = 'Attributes';
    protected static ?int $navigationSort = 4;

    protected static ?string $navigationLabel = 'Languages';
    protected static ?string $pluralModelLabel = 'Languages';
    protected static ?string $modelLabel = 'Language';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make()->schema([
                    Forms\Components\TextInput::make('name')
                        ->required()
                        ->unique(ignoreRecord: true)
                        ->placeholder('e.g. Japanese, English, N2, IELTS...')
                        ->maxLength(255),

                    Forms\Components\TextInput::make('ord')
                        ->numeric()
                        ->default(0)
                        ->label('Sort Order'),

                    Forms\Components\Toggle::make('active')
                        ->default(true)
                        ->label('Status (Active)'),
                ])->columns(1)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextInputColumn::make('ord')
                    ->label('Order')
                    ->rules(['numeric'])
                    ->sortable(),

                Tables\Columns\TextColumn::make('name')
                    ->label('Language Name')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\ToggleColumn::make('active')
                    ->label('Active'),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created At')
                    ->dateTime('Y-m-d H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true), // Ẩn mặc định cho bảng đỡ rối
            ])
            ->defaultSort('ord', 'asc')
            ->filters([
                Tables\Filters\TernaryFilter::make('active')
                    ->label('Active Status'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListLanguages::route('/'),
            'create' => Pages\CreateLanguage::route('/create'),
            'edit' => Pages\EditLanguage::route('/{record}/edit'),
        ];
    }
}
