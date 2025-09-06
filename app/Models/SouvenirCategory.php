<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SouvenirCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function souvenirs()
    {
        return $this->hasMany(Souvenir::class);
    }
}

