<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class School extends Model
{
    public function district(): BelongsTo
    {
        return $this->belongsTo(\App\Models\SchoolDistrict::class, 'school_district');
    }
}
