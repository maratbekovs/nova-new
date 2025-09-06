<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TourTypeResource\Pages;
use App\Filament\Resources\TourTypeResource\RelationManagers;
use App\Models\TourType;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class TourTypeResource extends Resource
{
    protected static ?string $model = TourType::class;

    protected static ?string $navigationIcon = 'heroicon-o-tag'; // Иконка для навигации
    protected static ?string $navigationGroup = 'Туры'; // Группа навигации
    protected static ?string $modelLabel = 'Тип тура'; // Единичное название
    protected static ?string $pluralModelLabel = 'Типы туров'; // Множественное название

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Название типа тура') // Лейбл поля
                    ->required() // Обязательное поле
                    ->maxLength(255) // Максимальная длина
                    ->unique(ignoreRecord: true), // Уникальное значение (игнорировать текущую запись при редактировании)
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Название типа тура')
                    ->searchable() // Добавить поиск по этому полю
                    ->sortable(), // Добавить сортировку по этому полю
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Дата создания')
                    ->dateTime() // Форматировать как дата/время
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true), // Скрыть по умолчанию
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Дата обновления')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true), // Скрыть по умолчанию
            ])
            ->filters([
                // Здесь можно добавить фильтры, если нужно
            ])
            ->actions([
                Tables\Actions\EditAction::make(), // Кнопка редактирования
                Tables\Actions\DeleteAction::make(), // Кнопка удаления
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(), // Массовое удаление
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            // Здесь можно добавить менеджеры отношений (например, список туров для типа тура)
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTourTypes::route('/'),
            'create' => Pages\CreateTourType::route('/create'),
            'edit' => Pages\EditTourType::route('/{record}/edit'),
        ];
    }
}

