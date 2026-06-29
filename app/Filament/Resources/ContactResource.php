<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContactResource\Pages;
use App\Models\Contact;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;

class ContactResource extends Resource
{
    protected static ?string $model = Contact::class;

    protected static ?string $navigationGroup = 'Communications';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make()->schema([
                    Forms\Components\Grid::make(2)->schema([
                        Forms\Components\TextInput::make('name')
                            ->disabled() // Giữ nguyên thông tin người gửi
                            ->label('Sender Name'),

                        Forms\Components\TextInput::make('email')
                            ->disabled()
                            ->label('Email Address'),
                    ]),

                    Forms\Components\TextInput::make('subject')
                        ->disabled()
                        ->label('Subject'),

                    Forms\Components\Textarea::make('message')
                        ->disabled()
                        ->rows(5)
                        ->label('Message Content'),

                    Forms\Components\Grid::make(2)->schema([
                        Forms\Components\Toggle::make('active')
                            ->label('Status (Processed)')
                            ->helperText('Bật khi bạn đã phản hồi hoặc xử lý liên hệ này'),

                        Forms\Components\TextInput::make('ord')
                            ->numeric()
                            ->default(0)
                            ->label('Order'),
                    ]),
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->label('Sender'),

                Tables\Columns\TextColumn::make('email')
                    ->searchable(),

                Tables\Columns\TextColumn::make('subject')
                    ->limit(30),

                // Icon hiển thị trạng thái đã xử lý hay chưa
                Tables\Columns\IconColumn::make('active')
                    ->boolean()
                    ->label('Processed')
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Received At')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc') // Tin mới nhất lên đầu
            ->filters([
                Tables\Filters\TernaryFilter::make('active')
                    ->label('Processed Status')
                    ->trueLabel('Processed')
                    ->falseLabel('Pending'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(), // Admin chủ yếu là Xem (View)
                Tables\Actions\EditAction::make()->label('Process'),
                Tables\Actions\DeleteAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListContacts::route('/'),
            'create' => Pages\CreateContact::route('/create'),
            'edit' => Pages\EditContact::route('/{record}/edit'),
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }
}
