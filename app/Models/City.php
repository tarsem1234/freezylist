<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class City extends Model
{
    public function zips(): HasMany
    {
        return $this->hasMany(\App\Models\ZipCode::class, 'city_id');
    }
}
