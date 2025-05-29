<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dish extends Model
{
    protected $table = 'dishes';
    protected $fillable = ['name', 'description', 'price', 'dish_category_id', 'status'];

    public function category()
    {
        return $this->belongsTo(DishCategory::class, 'dish_category_id');
    }
    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }
}
