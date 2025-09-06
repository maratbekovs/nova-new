<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReviewResource\Pages;
use App\Filament\Resources\ReviewResource\RelationManagers;
use App\Models\Review;
use App\Models\Tour; // Импортируем модель Tour
use App\Models\Souvenir; // Импортируем модель Souvenir
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ReviewResource extends Resource
{
    protected static ?string $model = Review::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-right'; // Иконка для навигации
    protected static ?string $navigationGroup = 'Запросы'; // Группа навигации
    protected static ?string $modelLabel = 'Отзыв'; // Единичное название
    protected static ?string $pluralModelLabel = 'Отзывы'; // Множественное название

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('author_name')
                    ->label('Имя автора')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('text')
                    ->label('Текст отзыва')
                    ->required()
                    ->rows(5)
                    ->columnSpanFull(),
                Forms\Components\Select::make('rating')
                    ->label('Рейтинг')
                    ->options([
                        1 => '1 звезда',
                        2 => '2 звезды',
                        3 => '3 звезды',
                        4 => '4 звезды',
                        5 => '5 звезд',
                    ])
                    ->required()
                    ->default(5),
                Forms\Components\Select::make('reviewable_type')
                    ->label('Тип объекта')
                    ->options([
                        Tour::class => 'Тур',
                        Souvenir::class => 'Сувенир',
                    ])
                    ->live() // Позволяет динамически изменять следующее поле
                    ->required(),
                Forms\Components\Select::make('reviewable_id')
                    ->label('Объект')
                    ->options(function (Forms\Get $get) {
                        $type = $get('reviewable_type');
                        if (!$type) {
                            return [];
                        }
                        // Загружаем только активные туры/сувениры
                        return $type::where('is_active', true)->pluck('title', 'id');
                    })
                    ->required()
                    ->searchable(), // Добавляем поиск по объекту
                Forms\Components\Toggle::make('is_approved')
                    ->label('Одобрен')
                    ->default(false),
            ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('author_name')
                    ->label('Автор')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('text')
                    ->label('Текст отзыва')
                    ->limit(50) // Ограничиваем текст для отображения в таблице
                    ->tooltip(fn (Review $record): string => $record->text) // Полный текст при наведении
                    ->searchable(),
                Tables\Columns\TextColumn::make('rating')
                    ->label('Рейтинг')
                    ->badge() // Отображаем как бейдж
                    ->colors([
                        'danger' => fn (int $state): bool => $state < 3,
                        'warning' => fn (int $state): bool => $state === 3,
                        'success' => fn (int $state): bool => $state > 3,
                    ])
                    ->sortable(),
                Tables\Columns\TextColumn::make('reviewable_type')
                    ->label('Тип объекта')
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        Tour::class => 'Тур',
                        Souvenir::class => 'Сувенир',
                        default => $state,
                    })
                    ->sortable(),
                Tables\Columns\TextColumn::make('reviewable.title') // Отображаем название связанного объекта
                    ->label('Объект')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_approved')
                    ->label('Одобрен')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Дата создания')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('reviewable_type')
                    ->label('Фильтр по типу объекта')
                    ->options([
                        Tour::class => 'Туры',
                        Souvenir::class => 'Сувениры',
                    ]),
                Tables\Filters\TernaryFilter::make('is_approved')
                    ->label('Одобренные отзывы')
                    ->boolean(),
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
            'index' => Pages\ListReviews::route('/'),
            'create' => Pages\CreateReview::route('/create'),
            'edit' => Pages\EditReview::route('/{record}/edit'),
        ];
    }
}

