<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;

class Signer extends Model
{
    use Notifiable, SoftDeletes;

    public function signer_user(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Access\User\User::class, 'from_user_id');
    }

    public function invited_users(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Access\User\User::class, 'invited_user_id');
    }
}
