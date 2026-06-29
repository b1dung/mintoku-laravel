<?php

namespace App\Filament\Resources;

use App\Filament\Resources\IncorporationResource\Pages;
use App\Models\Incorporation;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Support\Str;

class IncorporationResource extends Resource
{
    protected static ?string $model = Incorporation::class;

    protected static ?string $navigationGroup = 'Attributes';

    // Icon tòa nhà đại diện cho Pháp nhân/Công ty
    protected static ?string $navigationIcon = 'heroicon-o-office-building';

    protected static ?int $navigationSort = 9;

    protected static ?string $navigationLabel = 'Incorporations';
    protected static ?string $pluralModelLabel = 'Incorporations';
    protected static ?string $modelLabel = 'Incorporation';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make()->schema([
                    Forms\Components\Grid::make(2)->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Incorporation Name')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->reactive()
                            ->afterStateUpdated(fn($state, callable $set) => $set('slug', Str::slug($state)))
                            ->placeholder('e.g. Kabushiki Gaisha Mintoku')
                            ->maxLength(255),

                        Forms\Components\TextInput::make('slug')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->disabled()
                            ->dehydrated(),
                    ]),

                    Forms\Components\Grid::make(2)->schema([
                        Forms\Components\TextInput::make('ord')
                            ->numeric()
                            ->default(0)
                            ->label('Sort Order'),

                        Forms\Components\Toggle::make('active')
                            ->default(true)
                            ->label('Status (Active)')
                            ->inline(false),
                    ]),
                ])
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
                    ->label('Company Name')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('slug')
                    ->label('Slug')
                    ->color('gray')
                    ->fontFamily('mono'),

                Tables\Columns\ToggleColumn::make('active')
                    ->label('Active'),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created At')
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
            'index' => Pages\ListIncorporations::route('/'),
            'create' => Pages\CreateIncorporation::route('/create'),
            'edit' => Pages\EditIncorporation::route('/{record}/edit'),
        ];
    }
}
