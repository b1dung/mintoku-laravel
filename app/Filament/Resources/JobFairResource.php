<?php

namespace App\Filament\Resources;

use App\Filament\Resources\JobFairResource\Pages;
use App\Models\JobFair;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Support\Str;

class JobFairResource extends Resource
{
    protected static ?string $model = JobFair::class;

    protected static ?string $navigationGroup = 'Attributes';

    // Icon đại diện cho sự kiện/hội thảo
    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?int $navigationSort = 8;

    protected static ?string $navigationLabel = 'Job Fairs';
    protected static ?string $pluralModelLabel = 'Job Fairs';
    protected static ?string $modelLabel = 'Job Fair';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make()->schema([
                    Forms\Components\Grid::make(2)->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Fair Name')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->reactive()
                            ->afterStateUpdated(fn($state, callable $set) => $set('slug', Str::slug($state)))
                            ->maxLength(255),

                        Forms\Components\TextInput::make('slug')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->disabled()
                            ->dehydrated(),
                    ]),

                    // Thêm trường địa điểm nếu Job Fair tổ chức offline
                    Forms\Components\TextInput::make('location')
                        ->label('Event Location')
                        ->placeholder('e.g. Tokyo Big Sight / Online')
                        ->maxLength(255),

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
                    ->label('Event Name')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('location')
                    ->label('Location')
                    ->limit(30)
                    ->placeholder('N/A'),

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
            'index' => Pages\ListJobFairs::route('/'),
            'create' => Pages\CreateJobFair::route('/create'),
            'edit' => Pages\EditJobFair::route('/{record}/edit'),
        ];
    }
}
