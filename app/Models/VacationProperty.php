<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class VacationProperty extends Model
{
    use SoftDeletes;

    public function images(): HasMany
    {
        return $this->hasMany(\App\Models\VacationImage::class);
    }

    public function availableWeeks(): HasMany
    {
        return $this->hasMany(\App\Models\VacationAvailableCheckin::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Access\User\User::class);
    }

    public function availabilities(): HasMany
    {
        return $this->hasMany(VacationPropertyAvailability::class);
    }
}
