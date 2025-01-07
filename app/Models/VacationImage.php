<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class VacationImage extends Model
{
    use SoftDeletes;

    public function vacation_property(): BelongsTo
    {
        return $this->belongsTo(\App\Models\VacationProperty::class);
    }
}
