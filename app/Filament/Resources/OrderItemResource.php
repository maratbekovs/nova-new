<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderItemResource\Pages;
use App\Filament\Resources\OrderItemResource\RelationManagers;
use App\Models\OrderItem;
use App\Models\Order; // Импортируем модель Order
use App\Models\Souvenir; // Импортируем модель Souvenir
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OrderItemResource extends Resource
{
    protected static ?string $model = OrderItem::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list'; // Иконка для навигации
    protected static ?string $navigationGroup = 'Заказы'; // Группа навигации
    protected static ?string $modelLabel = 'Элемент заказа'; // Единичное название
    protected static ?string $pluralModelLabel = 'Элементы заказа'; // Множественное название

    // Скрываем этот ресурс из навигации, так как он будет управляться через OrderResource
    protected static bool $hidden = true;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('order_id')
                    ->label('Заказ')
                    ->relationship('order', 'customer_name') // Связь с заказом, отображаем имя клиента
                    ->required()
                    ->searchable(),
                Forms\Components\Select::make('souvenir_id')
                    ->label('Сувенир')
                    ->relationship('souvenir', 'title') // Связь с сувениром, отображаем название
                    ->required()
                    ->searchable(),
                Forms\Components\TextInput::make('quantity')
                    ->label('Количество')
                    ->numeric()
                    ->required()
                    ->minValue(1)
                    ->default(1),
                Forms\Components\TextInput::make('price_at_purchase')
                    ->label('Цена на момент покупки')
                    ->numeric()
                    ->required()
                    ->prefix('₽'),
            ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('order.customer_name')
                    ->label('Клиент')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('souvenir.title')
                    ->label('Сувенир')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('quantity')
                    ->label('Количество')
                    ->sortable(),
                Tables\Columns\TextColumn::make('price_at_purchase')
                    ->label('Цена за единицу')
                    ->money('RUB')
                    ->sortable(),
                Tables\Columns\TextColumn::make('total_item_price') // Вычисляемое поле
                    ->label('Общая стоимость')
                    ->state(fn (OrderItem $record): string => number_format($record->quantity * $record->price_at_purchase, 2) . ' ₽'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Дата добавления')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('order_id')
                    ->label('Фильтр по заказу')
                    ->relationship('order', 'customer_name'),
                Tables\Filters\SelectFilter::make('souvenir_id')
                    ->label('Фильтр по сувениру')
                    ->relationship('souvenir', 'title'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrderItems::route('/'),
            'create' => Pages\CreateOrderItem::route('/create'),
            'edit' => Pages\EditOrderItem::route('/{record}/edit'),
        ];
    }
}

