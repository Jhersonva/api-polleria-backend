<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Image extends Model
{
    protected $fillable = ['url', 'imageable_id', 'imageable_type'];

    protected $hidden = ['imageable_id', 'created_at', 'updated_at'];

    public function imageable() : MorphTo
    {
        return $this->morphTo();
    }
}
