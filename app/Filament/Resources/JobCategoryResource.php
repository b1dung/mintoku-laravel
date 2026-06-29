<?php

namespace App\Filament\Resources;

use App\Filament\Resources\JobCategoryResource\Pages;
use App\Models\JobCategory;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;

class JobCategoryResource extends Resource
{
    protected static ?string $model = JobCategory::class;

    protected static ?string $navigationGroup = 'Attributes'; // Gom vào nhóm Attributes
    protected static ?int $navigationSort = 1;

    protected static ?string $navigationLabel = 'Job Categories';
    protected static ?string $pluralModelLabel = 'Job Categories';
    protected static ?string $modelLabel = 'Job Category';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make()->schema([
                    Forms\Components\Select::make('parent_id')
                        ->label('Parent Category')
                        ->relationship('parent', 'name')
                        ->searchable()
                        ->preload()
                        ->helperText('Leave empty if this is a top-level category'),

                    Forms\Components\TextInput::make('name')
                        ->required()
                        ->maxLength(255)
                        ->placeholder('e.g. Information Technology, Marketing...'),

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
                    ->rules(['numeric'])
                    ->sortable(),

                Tables\Columns\TextColumn::make('name')
                    ->label('Category Name')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('parent.name')
                    ->label('Parent')
                    ->default('Root') // Sửa lỗi placeholder bằng default
                    ->sortable(),

                Tables\Columns\ToggleColumn::make('active')
                    ->label('Active'),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created At')
                    ->dateTime('Y-m-d')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('ord', 'asc')
            ->filters([
                Tables\Filters\SelectFilter::make('parent_id')
                    ->label('Filter by Parent')
                    ->relationship('parent', 'name'),

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
            'index' => Pages\ListJobCategories::route('/'),
            'create' => Pages\CreateJobCategory::route('/create'),
            'edit' => Pages\EditJobCategory::route('/{record}/edit'),
        ];
    }
}
