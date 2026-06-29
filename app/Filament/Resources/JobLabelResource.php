<?php

namespace App\Filament\Resources;

use App\Filament\Resources\JobLabelResource\Pages;
use App\Models\JobLabel;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Support\Str;

class JobLabelResource extends Resource
{
    protected static ?string $model = JobLabel::class;

    protected static ?string $navigationGroup = 'Attributes';

    // Sử dụng icon bookmark cho "Nhãn công việc"
    protected static ?string $navigationIcon = 'heroicon-o-bookmark';

    protected static ?int $navigationSort = 7;

    protected static ?string $navigationLabel = 'Job Labels';
    protected static ?string $pluralModelLabel = 'Job Labels';
    protected static ?string $modelLabel = 'Job Label';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make()->schema([
                    Forms\Components\Grid::make(2)->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->reactive()
                            ->afterStateUpdated(fn($state, callable $set) => $set('slug', Str::slug($state)))
                            ->maxLength(255),

                        Forms\Components\TextInput::make('slug')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->disabled()
                            ->dehydrated(), // Đảm bảo slug vẫn được gửi lên khi lưu dù bị disabled
                    ]),

                    Forms\Components\Grid::make(2)->schema([
                        Forms\Components\TextInput::make('ord')
                            ->numeric()
                            ->default(0)
                            ->label('Sort Order'),

                        Forms\Components\Toggle::make('active')
                            ->default(true)
                            ->label('Status (Active)')
                            ->inline(false), // Để toggle thẳng hàng cho đẹp
                    ]),
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                // Cho phép Admin thay đổi thứ tự ưu tiên nhãn ngay tại danh sách
                Tables\Columns\TextInputColumn::make('ord')
                    ->label('Order')
                    ->rules(['numeric'])
                    ->sortable(),

                Tables\Columns\TextColumn::make('name')
                    ->label('Label Name')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('slug')
                    ->label('Slug')
                    ->fontFamily('mono')
                    ->color('gray'),

                // Toggle nhanh trạng thái hiển thị của nhãn
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
            'index' => Pages\ListJobLabels::route('/'),
            'create' => Pages\CreateJobLabel::route('/create'),
            'edit' => Pages\EditJobLabel::route('/{record}/edit'),
        ];
    }
}
