<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'author_name',
        'text',
        'rating',
        'reviewable_type',
        'reviewable_id',
        'is_approved',
    ];

    public function reviewable()
    {
        return $this->morphTo();
    }
}

