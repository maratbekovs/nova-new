<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TourResource\Pages;
use App\Filament\Resources\TourResource\RelationManagers;
use App\Models\Tour;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\FileUpload; // Используем FileUpload

class TourResource extends Resource
{
    protected static ?string $model = Tour::class;

    protected static ?string $navigationIcon = 'heroicon-o-globe-alt';
    protected static ?string $navigationGroup = 'Туры';
    protected static ?string $modelLabel = 'Тур';
    protected static ?string $pluralModelLabel = 'Туры';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->label('Название тура')
                    ->required()
                    ->maxLength(255),
                Forms\Components\RichEditor::make('description')
                    ->label('Описание тура')
                    ->columnSpanFull()
                    ->nullable(),
                Forms\Components\TextInput::make('price')
                    ->label('Цена')
                    ->numeric()
                    ->required()
                    ->prefix('₽'),
                Forms\Components\TextInput::make('discount_price')
                    ->label('Цена со скидкой')
                    ->numeric()
                    ->nullable()
                    ->prefix('₽'),
                Forms\Components\TextInput::make('duration_days')
                    ->label('Дней')
                    ->numeric()
                    ->required()
                    ->minValue(1),
                Forms\Components\TextInput::make('duration_nights')
                    ->label('Ночей')
                    ->numeric()
                    ->required()
                    ->minValue(0),
                Forms\Components\TextInput::make('country')
                    ->label('Страна')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('city')
                    ->label('Город')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('tour_type_id')
                    ->label('Тип тура')
                    ->relationship('tourType', 'name')
                    ->required()
                    ->createOptionForm([
                        Forms\Components\TextInput::make('name')
                            ->label('Название типа тура')
                            ->required()
                            ->maxLength(255)
                            ->unique(),
                    ]),
                Forms\Components\TextInput::make('rating')
                    ->label('Рейтинг (от 0 до 5)')
                    ->numeric()
                    ->minValue(0)
                    ->maxValue(5)
                    ->step(0.1)
                    ->nullable(),
                FileUpload::make('image_url') // Используем FileUpload
                    ->label('Изображение тура')
                    ->image()
                    ->disk('public') // Указываем диск 'public'
                    ->directory('tour-images') // Папка внутри public/uploads
                    ->nullable()
                    ->getUploadedFileNameForStorageUsing(function (Forms\Get $get, Forms\Components\FileUpload $component): ?string {
                        // Это замыкание будет вызываться при сохранении файла
                        // Возвращаем только имя файла, так как directory уже указана
                        return $component->getUploadedFileName();
                    })
                    ->getUploadedFileUsing(function (Forms\Get $get, Forms\Components\FileUpload $component, ?string $state): ?string {
                        // Это замыкание будет вызываться при отображении существующего файла
                        // Если есть state (имя файла), формируем полный URL
                        return $state ? asset('uploads/tour-images/' . $state) : null;
                    })
                    ->dehydrateStateUsing(fn (?string $state): ?string => basename($state)) // Сохраняем только имя файла в БД
                    ->columnSpanFull(),
                Forms\Components\Toggle::make('is_active')
                    ->label('Активен')
                    ->default(true),
                Forms\Components\Toggle::make('is_featured')
                    ->label('Хит продаж')
                    ->default(false),
                Forms\Components\Toggle::make('is_discounted')
                    ->label('Со скидкой')
                    ->default(false),
            ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image_url')
                    ->label('Изображение')
                    ->disk('public') // Указываем диск 'public'
                    ->square()
                    ->size(50),
                Tables\Columns\TextColumn::make('title')
                    ->label('Название тура')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('tourType.name')
                    ->label('Тип тура')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('country')
                    ->label('Страна')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('city')
                    ->label('Город')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('price')
                    ->label('Цена')
                    ->money('RUB')
                    ->sortable(),
                Tables\Columns\TextColumn::make('discount_price')
                    ->label('Цена со скидкой')
                    ->money('RUB')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('duration_days')
                    ->label('Дней')
                    ->sortable(),
                Tables\Columns\TextColumn::make('duration_nights')
                    ->label('Ночей')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('rating')
                    ->label('Рейтинг')
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->label('Активен')
                    ->boolean(),
                Tables\Columns\IconColumn::make('is_featured')
                    ->label('Хит')
                    ->boolean(),
                Tables\Columns\IconColumn::make('is_discounted')
                    ->label('Скидка')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Дата создания')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Дата обновления')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('tour_type_id')
                    ->label('Тип тура')
                    ->relationship('tourType', 'name'),
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Активные туры')
                    ->boolean(),
                Tables\Filters\TernaryFilter::make('is_featured')
                    ->label('Хиты продаж')
                    ->boolean(),
                Tables\Filters\TernaryFilter::make('is_discounted')
                    ->label('Со скидкой')
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
            'index' => Pages\ListTours::route('/'),
            'create' => Pages\CreateTour::route('/create'),
            'edit' => Pages\EditTour::route('/{record}/edit'),
        ];
    }
}

