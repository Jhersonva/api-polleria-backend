<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Drink extends Model
{
    protected $fillable = ['name', 'price'];

    protected $hidden = ['created_at', 'updated_at'];

    public function saleDetails()
    {
        return $this->hasMany(SaleDetail::class);
    }

    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }
}
