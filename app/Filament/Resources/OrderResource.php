<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Filament\Resources\OrderResource\RelationManagers;
use App\Models\Order;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag'; // Иконка для навигации
    protected static ?string $navigationGroup = 'Заказы'; // Группа навигации
    protected static ?string $modelLabel = 'Заказ'; // Единичное название
    protected static ?string $pluralModelLabel = 'Заказы'; // Множественное название

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('customer_name')
                    ->label('Имя клиента')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('customer_email')
                    ->label('Email клиента')
                    ->email()
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('customer_phone')
                    ->label('Телефон клиента')
                    ->tel()
                    ->nullable()
                    ->maxLength(255),
                Forms\Components\Textarea::make('shipping_address')
                    ->label('Адрес доставки')
                    ->nullable()
                    ->rows(3)
                    ->columnSpanFull(),
                Forms\Components\TextInput::make('total_amount')
                    ->label('Общая сумма')
                    ->numeric()
                    ->required()
                    ->prefix('₽')
                    ->readOnly(), // Сумма будет рассчитываться автоматически
                Forms\Components\Select::make('status')
                    ->label('Статус заказа')
                    ->options([
                        'pending' => 'В ожидании',
                        'completed' => 'Выполнен',
                        'cancelled' => 'Отменен',
                        'processing' => 'В обработке', // Добавляем новый статус
                    ])
                    ->required()
                    ->default('pending'),
            ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('customer_name')
                    ->label('Клиент')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('customer_email')
                    ->label('Email')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('customer_phone')
                    ->label('Телефон')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('total_amount')
                    ->label('Сумма')
                    ->money('RUB')
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('Статус')
                    ->badge() // Отображаем как бейдж
                    ->colors([
                        'warning' => 'pending',
                        'success' => 'completed',
                        'danger' => 'cancelled',
                        'info' => 'processing',
                    ])
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Дата заказа')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->label('Фильтр по статусу')
                    ->options([
                        'pending' => 'В ожидании',
                        'completed' => 'Выполнен',
                        'cancelled' => 'Отменен',
                        'processing' => 'В обработке',
                    ]),
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
            RelationManagers\OrderItemsRelationManager::class, // Добавляем менеджер отношений для элементов заказа
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}

