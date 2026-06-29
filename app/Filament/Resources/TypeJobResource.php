<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TypeJobResource\Pages;
use App\Models\TypeJob;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Support\Str;

class TypeJobResource extends Resource
{
    protected static ?string $model = TypeJob::class;

    protected static ?string $navigationGroup = 'Attributes';

    // Đổi sang icon tag để đại diện cho Loại công việc/Nhãn
    protected static ?string $navigationIcon = 'heroicon-o-tag';

    protected static ?int $navigationSort = 6;

    protected static ?string $navigationLabel = 'Job Types';
    protected static ?string $pluralModelLabel = 'Job Types';
    protected static ?string $modelLabel = 'Job Type';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make()->schema([
                    Forms\Components\TextInput::make('name')
                        ->required()
                        ->unique(ignoreRecord: true)
                        // Tự động tạo slug nếu database của bạn có dùng slug
                        ->reactive()
                        ->afterStateUpdated(fn($state, callable $set) => $set('slug', Str::slug($state)))
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
                // Sửa số thứ tự nhanh ngay tại table
                Tables\Columns\TextInputColumn::make('ord')
                    ->label('Order')
                    ->rules(['numeric'])
                    ->sortable(),

                Tables\Columns\TextColumn::make('name')
                    ->label('Type Name')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\ToggleColumn::make('active')
                    ->label('Active'),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created At')
                    ->dateTime('Y-m-d H:i')
                    ->sortable(),
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
            'index' => Pages\ListTypeJobs::route('/'),
            'create' => Pages\CreateTypeJob::route('/create'),
            'edit' => Pages\EditTypeJob::route('/{record}/edit'),
        ];
    }
}
