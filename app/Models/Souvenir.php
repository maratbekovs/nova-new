<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Souvenir extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'title',
        'description',
        'price',
        'discount_price',
        'region',
        'souvenir_category_id',
        'rating',
        'image_url', // Убедитесь, что это поле есть
        'is_active',
        'is_featured',
        'is_new',
    ];

    public function souvenirCategory()
    {
        return $this->belongsTo(SouvenirCategory::class);
    }

    public function reviews()
    {
        return $this->morphMany(Review::class, 'reviewable');
    }
}

