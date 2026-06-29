<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VisaResource\Pages;
use App\Models\Visa;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;

class VisaResource extends Resource
{
    protected static ?string $model = Visa::class;

    protected static ?string $navigationGroup = 'Attributes';
    protected static ?string $navigationIcon = 'heroicon-o-identification';
    protected static ?int $navigationSort = 5;

    // Thay đổi label hiển thị ở menu và tiêu đề trang
    protected static ?string $navigationLabel = 'Visas';
    protected static ?string $pluralModelLabel = 'Visas';
    protected static ?string $modelLabel = 'Visa';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make()->schema([
                    Forms\Components\TextInput::make('name')
                        ->required()
                        ->unique(ignoreRecord: true) // Tránh trùng tên Visa
                        ->maxLength(255),

                    Forms\Components\TextInput::make('ord')
                        ->numeric()
                        ->default(0)
                        ->label('Sort Order'),

                    Forms\Components\Toggle::make('active')
                        ->default(true)
                        ->label('Status (Active)'),
                ])->columns(1) // Để các field xếp dọc cho gọn trong Card
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // Sử dụng TextInputColumn để Admin sửa số thứ tự ngay tại danh sách
                Tables\Columns\TextInputColumn::make('ord')
                    ->label('Order')
                    ->rules(['numeric'])
                    ->sortable(),

                Tables\Columns\TextColumn::make('name')
                    ->label('Visa Name')
                    ->searchable()
                    ->sortable(),

                // Sử dụng ToggleColumn để bật/tắt Active nhanh bằng 1 click
                Tables\Columns\ToggleColumn::make('active')
                    ->label('Active'),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Created At')
                    ->dateTime('Y-m-d H:i')
                    ->sortable(),
            ])
            ->defaultSort('ord', 'asc') // Ưu tiên sắp xếp theo ord
            ->filters([
                // Có thể thêm filter Active tại đây nếu cần
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
            'index' => Pages\ListVisas::route('/'),
            'create' => Pages\CreateVisa::route('/create'),
            'edit' => Pages\EditVisa::route('/{record}/edit'),
        ];
    }
}
