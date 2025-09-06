<?php

namespace App\Filament\Resources\OrderResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class OrderItemsRelationManager extends RelationManager
{
    protected static string $relationship = 'orderItems'; // Название отношения в родительской модели
    protected static ?string $title = 'Элементы заказа'; // Заголовок менеджера отношений

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('souvenir_id')
                    ->label('Сувенир')
                    ->relationship('souvenir', 'title')
                    ->required()
                    ->searchable(),
                Forms\Components\TextInput::make('quantity')
                    ->label('Количество')
                    ->numeric()
                    ->required()
                    ->minValue(1)
                    ->default(1),
                Forms\Components\TextInput::make('price_at_purchase')
                    ->label('Цена за единицу')
                    ->numeric()
                    ->required()
                    ->prefix('₽'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('souvenir.title') // Используем название сувенира для заголовка записи
            ->columns([
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
                Tables\Columns\TextColumn::make('total_item_price')
                    ->label('Общая стоимость')
                    ->state(fn ($record): string => number_format($record->quantity * $record->price_at_purchase, 2) . ' ₽'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(), // Кнопка "Добавить"
            ])
            ->actions([
                Tables\Actions\EditAction::make(), // Кнопка "Редактировать"
                Tables\Actions\DeleteAction::make(), // Кнопка "Удалить"
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}

