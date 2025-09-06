<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ContactRequestResource\Pages;
use App\Filament\Resources\ContactRequestResource\RelationManagers;
use App\Models\ContactRequest;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ContactRequestResource extends Resource
{
    protected static ?string $model = ContactRequest::class;

    protected static ?string $navigationIcon = 'heroicon-o-envelope'; // Иконка для навигации
    protected static ?string $navigationGroup = 'Запросы'; // Группа навигации
    protected static ?string $modelLabel = 'Запрос на контакт'; // Единичное название
    protected static ?string $pluralModelLabel = 'Запросы на контакты'; // Множественное название

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Имя отправителя')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->label('Email отправителя')
                    ->email()
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('phone')
                    ->label('Телефон отправителя')
                    ->tel()
                    ->nullable()
                    ->maxLength(255),
                Forms\Components\Textarea::make('message')
                    ->label('Сообщение')
                    ->nullable()
                    ->rows(5)
                    ->columnSpanFull(),
                Forms\Components\Select::make('type')
                    ->label('Тип запроса')
                    ->options([
                        'tour_inquiry' => 'Запрос по туру',
                        'newsletter' => 'Подписка на рассылку',
                        'contact_form' => 'Общий вопрос',
                    ])
                    ->nullable(),
                Forms\Components\Toggle::make('is_read')
                    ->label('Прочитан')
                    ->default(false),
            ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Имя')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('phone')
                    ->label('Телефон')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('type')
                    ->label('Тип запроса')
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_read')
                    ->label('Прочитан')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Дата создания')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                    ->label('Тип запроса')
                    ->options([
                        'tour_inquiry' => 'Запрос по туру',
                        'newsletter' => 'Подписка на рассылку',
                        'contact_form' => 'Общий вопрос',
                    ]),
                Tables\Filters\TernaryFilter::make('is_read')
                    ->label('Прочитанные')
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
            'index' => Pages\ListContactRequests::route('/'),
            'create' => Pages\CreateContactRequest::route('/create'),
            'edit' => Pages\EditContactRequest::route('/{record}/edit'),
        ];
    }
}

