<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Tour extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'title',
        'description',
        'price',
        'discount_price',
        'duration_days',
        'duration_nights',
        'country',
        'city',
        'tour_type_id',
        'rating',
        'image_url', // Убедитесь, что это поле есть, если вы используете его для URL изображений
        'is_active',
        'is_featured',
        'is_discounted',
    ];

    public function tourType()
    {
        return $this->belongsTo(TourType::class);
    }

    public function reviews()
    {
        return $this->morphMany(Review::class, 'reviewable');
    }
}

