<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appetizer extends Model
{
    protected $table = 'appetizers';

    protected $fillable = ['name'];

    protected $hidden = ['created_at', 'updated_at'];

    public function saleDetails()
    {
        return $this->hasMany(SaleDetail::class);
    }
}
