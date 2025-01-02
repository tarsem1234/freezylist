<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class CounterSaleOffer extends Model
{
    use SoftDeletes;

    public function offer(): BelongsTo
    {
        return $this->belongsTo('App\Models\Offer');
    }

    public function property(): BelongsTo
    {
        return $this->belongsTo('App\Models\Offer');
    }

    public function owner(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Access\User\User::class);
    }

    public function buyer(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Access\User\User::class);
    }
}
