<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class State extends Model
{
    public function documents(): HasMany
    {
        return $this->hasMany(\App\Models\DocumentListing::class);
    }
}
