<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Industry extends Model
{
    use SoftDeletes;

    public function services(): HasMany
    {
        return $this->hasMany(\App\Models\Service::class);
    }

    public function business_profile(): BelongsTo
    {
        return $this->belongsTo(\App\Models\BusinessProfile::class);
    }
}
