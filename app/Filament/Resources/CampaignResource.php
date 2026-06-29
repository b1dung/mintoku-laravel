<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CampaignResource\Pages;
use App\Models\Campaign;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Support\Str;

class CampaignResource extends Resource
{
    protected static ?string $model = Campaign::class;

    protected static ?string $navigationGroup = 'Attributes';

    // Icon loa thông báo phù hợp cho các Chiến dịch (Campaign)
    protected static ?string $navigationIcon = 'heroicon-o-speakerphone';

    protected static ?int $navigationSort = 10;

    protected static ?string $navigationLabel = 'Campaigns';
    protected static ?string $pluralModelLabel = 'Campaigns';
    protected static ?string $modelLabel = 'Campaign';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make()->schema([
                    Forms\Components\Grid::make(2)->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Campaign Name')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->reactive()
                            ->afterStateUpdated(fn($state, callable $set) => $set('slug', Str::slug($state)))
                            ->placeholder('e.g. Spring Recruitment 2026')
                            ->maxLength(255),
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
                // Cho phép ưu tiên chiến dịch nào hiện lên trước
                Tables\Columns\TextInputColumn::make('ord')
                    ->label('Order')
                    ->rules(['numeric'])
                    ->sortable(),

                Tables\Columns\TextColumn::make('name')
                    ->label('Campaign Name')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),


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
            'index' => Pages\ListCampaigns::route('/'),
            'create' => Pages\CreateCampaign::route('/create'),
            'edit' => Pages\EditCampaign::route('/{record}/edit'),
        ];
    }
}
