<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VacationPropertyAvailability extends Model
{
    protected $fillable = ['start_date'];

    public function property(): BelongsTo
    {
        return $this->belongsTo(VacationProperty::class);
    }
}
