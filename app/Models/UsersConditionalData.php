<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class UsersConditionalData extends Model
{
    use SoftDeletes;

    protected $table = 'users_conditional_data';

    public function user(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Access\User\User::class);
    }
}
