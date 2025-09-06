<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SouvenirCategoryResource\Pages;
use App\Filament\Resources\SouvenirCategoryResource\RelationManagers;
use App\Models\SouvenirCategory;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SouvenirCategoryResource extends Resource
{
    protected static ?string $model = SouvenirCategory::class;

    protected static ?string $navigationIcon = 'heroicon-o-folder-open'; // Иконка для навигации
    protected static ?string $navigationGroup = 'Сувениры'; // Группа навигации
    protected static ?string $modelLabel = 'Категория сувениров'; // Единичное название
    protected static ?string $pluralModelLabel = 'Категории сувениров'; // Множественное название

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Название категории')
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Название категории')
                    ->searchable()
                    ->sortable(),
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
                //
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
            'index' => Pages\ListSouvenirCategories::route('/'),
            'create' => Pages\CreateSouvenirCategory::route('/create'),
            'edit' => Pages\EditSouvenirCategory::route('/{record}/edit'),
        ];
    }
}

