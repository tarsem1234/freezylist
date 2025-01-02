<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class BuyerQuestionnaire extends Model
{
    use SoftDeletes;

    protected $table = 'questions_buyer';

    public function saleOffer(): BelongsTo
    {
        return $this->belongsTo(\App\Models\SaleOffer::class, 'offer_id');
    }

    public function rentOffer(): BelongsTo
    {
        return $this->belongsTo(\App\Models\RentOffer::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Access\User\User::class);
    }
}
