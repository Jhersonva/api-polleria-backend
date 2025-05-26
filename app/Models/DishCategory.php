<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DishCategory extends Model
{
    protected $table = 'dish_categories';
    protected $fillable = ['name'];
    public function dishes()
    {
        return $this->hasMany(Dish::class);
    }
}
