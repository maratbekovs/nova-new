<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia; // Импортируем HasMedia
use Spatie\MediaLibrary\InteractsWithMedia; // Импортируем InteractsWithMedia

class SiteSetting extends Model implements HasMedia // Реализуем интерфейс HasMedia
{
    use HasFactory, InteractsWithMedia; // Используем трейт InteractsWithMedia

    protected $fillable = [
        'key',
        'value', // Поле 'value' будет использоваться для хранения имени файла/URL
        'description',
        'type',
    ];

    // Spatie Media Library автоматически управляет файлами,
    // используя поле 'value' как имя коллекции по умолчанию.
    // Нет необходимости в дополнительных методах здесь, если 'value' это просто имя файла.
}

