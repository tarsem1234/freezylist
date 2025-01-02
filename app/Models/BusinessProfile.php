<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class BusinessProfile extends Model
{
    use SoftDeletes;

    protected $fillable = ['industry_id', 'company_name', 'user_id'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Access\User\User::class);
    }

    public function industry(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Industry::class, 'industry_id');
    }
}
