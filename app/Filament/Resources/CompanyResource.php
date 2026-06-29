<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CompanyResource\Pages;
use App\Models\Company;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Support\Str;

class CompanyResource extends Resource
{
    protected static ?string $model = Company::class;

    protected static ?string $navigationGroup = 'Recruitment';
    protected static ?string $navigationIcon = 'heroicon-o-office-building';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make()->schema([
                    Forms\Components\Grid::make(2)->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255)
                            ->lazy()
                            ->afterStateUpdated(fn($set, $state) => $set('slug', Str::slug($state))),

                        Forms\Components\TextInput::make('slug')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255),
                    ]),

                    Forms\Components\FileUpload::make('logo')
                        ->image()
                        ->directory('companies')
                        ->columnSpan('full'),

                    Forms\Components\Grid::make(2)->schema([
                        Forms\Components\TextInput::make('address')
                            ->maxLength(500),

                        Forms\Components\TextInput::make('website')
                            ->url() // Tự động validate định dạng URL
                            ->maxLength(255),
                    ]),

                    Forms\Components\RichEditor::make('description')
                        ->columnSpan('full'),

                    Forms\Components\Grid::make(2)->schema([
                        Forms\Components\TextInput::make('ord')
                            ->numeric()
                            ->default(0)
                            ->label('Sort Order'),

                        Forms\Components\Toggle::make('active')
                            ->default(true)
                            ->label('Status (Active)'),
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
                    ->sortable(),

                Tables\Columns\ImageColumn::make('logo')
                    ->circular(),

                Tables\Columns\TextColumn::make('name')
                    ->label('Company Name')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('website')
                    ->label('Website')
                    ->limit(20)
                    ->url(fn($record) => $record->website, true), // Click vào link sẽ mở tab mới

                Tables\Columns\ToggleColumn::make('active')
                    ->label('Active'),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created At')
                    ->dateTime('Y-m-d')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('ord', 'asc')
            ->filters([
                Tables\Filters\TernaryFilter::make('active'),
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
            'index' => Pages\ListCompanies::route('/'),
            'create' => Pages\CreateCompany::route('/create'),
            'edit' => Pages\EditCompany::route('/{record}/edit'),
        ];
    }
}
