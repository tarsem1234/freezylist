<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;

    public function sessions(): HasMany
    {
        return $this->hasMany(\App\Models\Backend\CategorySession::class);
    }
}
