<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'souvenir_id',
        'quantity',
        'price_at_purchase',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function souvenir()
    {
        return $this->belongsTo(Souvenir::class);
    }
}

