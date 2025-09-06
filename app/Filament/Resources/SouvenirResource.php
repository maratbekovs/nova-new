<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SouvenirResource\Pages;
use App\Filament\Resources\SouvenirResource\RelationManagers;
use App\Models\Souvenir;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\FileUpload; // Используем FileUpload

class SouvenirResource extends Resource
{
    protected static ?string $model = Souvenir::class;

    protected static ?string $navigationIcon = 'heroicon-o-gift';
    protected static ?string $navigationGroup = 'Сувениры';
    protected static ?string $modelLabel = 'Сувенир';
    protected static ?string $pluralModelLabel = 'Сувениры';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->label('Название сувенира')
                    ->required()
                    ->maxLength(255),
                Forms\Components\RichEditor::make('description')
                    ->label('Описание сувенира')
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
                Forms\Components\TextInput::make('region')
                    ->label('Регион')
                    ->nullable()
                    ->maxLength(255),
                Forms\Components\Select::make('souvenir_category_id')
                    ->label('Категория сувениров')
                    ->relationship('souvenirCategory', 'name')
                    ->required()
                    ->createOptionForm([
                        Forms\Components\TextInput::make('name')
                            ->label('Название категории')
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
                    ->label('Изображение сувенира')
                    ->image()
                    ->disk('public') // Указываем диск 'public'
                    ->directory('souvenir-images') // Папка внутри public/uploads
                    ->nullable()
                    ->getUploadedFileNameForStorageUsing(function (Forms\Get $get, Forms\Components\FileUpload $component): ?string {
                        return $component->getUploadedFileName();
                    })
                    ->getUploadedFileUsing(function (Forms\Get $get, Forms\Components\FileUpload $component, ?string $state): ?string {
                        return $state ? asset('uploads/souvenir-images/' . $state) : null;
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
                    ->disk('public')
                    ->square()
                    ->size(50),
                Tables\Columns\TextColumn::make('title')
                    ->label('Название сувенира')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('souvenirCategory.name')
                    ->label('Категория')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('region')
                    ->label('Регион')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('price')
                    ->label('Цена')
                    ->money('RUB')
                    ->sortable(),
                Tables\Columns\TextColumn::make('discount_price')
                    ->label('Цена со скидкой')
                    ->money('RUB')
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
                Tables\Columns\IconColumn::make('is_new')
                    ->label('Новинка')
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
                Tables\Filters\SelectFilter::make('souvenir_category_id')
                    ->label('Категория')
                    ->relationship('souvenirCategory', 'name'),
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Активные сувениры')
                    ->boolean(),
                Tables\Filters\TernaryFilter::make('is_featured')
                    ->label('Хиты продаж')
                    ->boolean(),
                Tables\Filters\TernaryFilter::make('is_new')
                    ->label('Новинки')
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
            'index' => Pages\ListSouvenirs::route('/'),
            'create' => Pages\CreateSouvenir::route('/create'),
            'edit' => Pages\EditSouvenir::route('/{record}/edit'),
        ];
    }
}

