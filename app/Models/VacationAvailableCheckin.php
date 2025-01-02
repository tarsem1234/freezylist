<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class VacationAvailableCheckin extends Model
{
    use SoftDeletes;

    protected $table = 'vacation_available_checkin';

    public function vacationProperty(): BelongsTo
    {
        return $this->belongsTo(\App\Models\VacationProperty::class);
    }
}
