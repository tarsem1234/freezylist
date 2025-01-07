<?php

namespace App\Models\History\Traits\Relationship;

use App\Models\Access\User\User;
use App\Models\History\HistoryType;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Class HistoryRelationship.
 */
trait HistoryRelationship
{
    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function type(): HasOne
    {
        return $this->hasOne(HistoryType::class, 'id', 'type_id');
    }
}
