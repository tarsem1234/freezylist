<?php

namespace App\Models\Backend;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CategorySessionQuestion extends Model
{
    public function session(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Backend\CategorySession::class);
    }

    public function options(): HasMany
    {
        return $this->hasMany(\App\Models\Backend\CategorySessionQuestionOption::class);
    }
}
