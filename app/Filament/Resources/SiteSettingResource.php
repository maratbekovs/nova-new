<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SiteSettingResource\Pages;
use App\Filament\Resources\SiteSettingResource\RelationManagers;
use App\Models\SiteSetting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SiteSettingResource extends Resource
{
    protected static ?string $model = SiteSetting::class;

    protected static ?string $navigationIcon = 'heroicon-o-cog';
    protected static ?string $navigationGroup = 'Настройки сайта';
    protected static ?string $modelLabel = 'Настройка сайта';
    protected static ?string $pluralModelLabel = 'Настройки сайта';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('key')
                    ->label('Ключ настройки')
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true)
                    ->helperText('Уникальный идентификатор настройки (например, about_us_text, phone_number). Не меняйте после создания.'),
                Forms\Components\TextInput::make('description')
                    ->label('Описание')
                    ->maxLength(255)
                    ->nullable()
                    ->helperText('Краткое описание назначения настройки для удобства.'),

                Forms\Components\Select::make('type')
                    ->label('Тип поля')
                    ->options([
                        'text' => 'Текст (одна строка)',
                        'textarea' => 'Текст (многострочный)',
                        'image' => 'Изображение',
                        'email' => 'Email',
                        'tel' => 'Телефон',
                        'url' => 'URL-адрес',
                    ])
                    ->required()
                    ->default('text')
                    ->live()
                    ->helperText('Выберите тип поля ввода для значения.'),

                Forms\Components\Group::make()
                    ->schema(function (Forms\Get $get) {
                        $type = $get('type');
                        switch ($type) {
                            case 'textarea':
                                return [
                                    Forms\Components\RichEditor::make('value')
                                        ->label('Значение')
                                        ->nullable()
                                        ->columnSpanFull(),
                                ];
                            case 'image':
                                return [
                                    Forms\Components\FileUpload::make('value')
                                        ->label('Значение (Файл изображения)')
                                        ->image()
                                        ->disk('public')
                                        ->directory('site-settings-images')
                                        ->nullable()
                                        ->columnSpanFull(),
                                ];
                            case 'email':
                                return [
                                    Forms\Components\TextInput::make('value')
                                        ->label('Значение (Email)')
                                        ->email()
                                        ->nullable()
                                        ->columnSpanFull(),
                                ];
                            case 'tel':
                                return [
                                    Forms\Components\TextInput::make('value')
                                        ->label('Значение (Телефон)')
                                        ->tel()
                                        ->nullable()
                                        ->columnSpanFull(),
                                ];
                            case 'url':
                                return [
                                    Forms\Components\TextInput::make('value')
                                        ->label('Значение (URL-адрес)')
                                        ->url()
                                        ->nullable()
                                        ->columnSpanFull(),
                                ];
                            default:
                                return [
                                    Forms\Components\TextInput::make('value')
                                        ->label('Значение')
                                        ->nullable()
                                        ->columnSpanFull(),
                                ];
                        }
                    })
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('key')
                    ->label('Ключ')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('description')
                    ->label('Описание')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\ImageColumn::make('value')
                    ->label('Значение (Изображение)')
                    ->disk('public')
                    ->width(50)
                    ->height(50)
                    ->circular()
                    ->visible(fn (?SiteSetting $record): bool => $record?->type === 'image') // Изменено: ?SiteSetting
                    ->toggleable(isToggledHiddenByDefault: false),
                Tables\Columns\TextColumn::make('value')
                    ->label('Значение (Текст)')
                    ->limit(50)
                    ->tooltip(fn (?SiteSetting $record): string => $record?->value ?? '') // Изменено: ?SiteSetting
                    ->searchable()
                    ->visible(fn (?SiteSetting $record): bool => $record?->type !== 'image'), // Изменено: ?SiteSetting
                Tables\Columns\TextColumn::make('type')
                    ->label('Тип поля')
                    ->badge()
                    ->colors([
                        'info' => 'text',
                        'success' => 'textarea',
                        'warning' => 'image',
                        'primary' => 'email',
                        'secondary' => 'tel',
                        'danger' => 'url',
                    ])
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
                Tables\Filters\SelectFilter::make('category')
                    ->label('Страница / Категория')
                    ->options([
                        'home' => 'Главная страница',
                        'about' => 'Страница "О нас"',
                        'contact' => 'Страница "Контакты"',
                        'tours' => 'Страница "Туры"',
                        'souvenirs' => 'Страница "Сувениры"',
                        'footer' => 'Футер',
                        'seo' => 'SEO',
                        'team_member' => 'Члены команды',
                        'why_choose_us' => 'Почему выбирают нас (Общие)',
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        if (empty($data['value'])) {
                            return $query;
                        }

                        $category = $data['value'];

                        if ($category === 'why_choose_us') {
                            return $query->where(function (Builder $q) {
                                $q->where('key', 'like', 'home_why_choose_us_%')
                                  ->orWhere('key', 'like', 'tours_why_choose_us_%')
                                  ->orWhere('key', 'like', 'souvenirs_why_choose_us_%');
                            });
                        } elseif ($category === 'team_member') {
                            return $query->where('key', 'like', 'team_member_%');
                        } else {
                            return $query->where('key', 'like', $category . '\_%');
                        }
                    }),
                Tables\Filters\SelectFilter::make('type')
                    ->label('Тип поля')
                    ->options([
                        'text' => 'Текст',
                        'textarea' => 'Многострочный текст',
                        'image' => 'Изображение',
                        'email' => 'Email',
                        'tel' => 'Телефон',
                        'url' => 'URL-адрес',
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
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSiteSettings::route('/'),
            'create' => Pages\CreateSiteSetting::route('/create'),
            'edit' => Pages\EditSiteSetting::route('/{record}/edit'),
        ];
    }
}

