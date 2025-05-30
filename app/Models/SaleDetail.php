<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SaleDetail extends Model
{
    protected $fillable = [
        'sale_id',
        'dish_id',
        'drink_id',
        'appetizer_id',
        'quantity',
        'unit_price',
        'subtotal',
        'notes',
    ];

    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }

    public function dish()
    {
        return $this->belongsTo(Dish::class);
    }

    public function drink()
    {
        return $this->belongsTo(Drink::class);
    }

    public function appetizer()
    {
        return $this->belongsTo(Appetizer::class);
    }
    public function getTotalAttribute()
    {
        return $this->quantity * $this->unit_price;
    }
}
