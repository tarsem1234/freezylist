<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Forum extends Model
{
    use SoftDeletes;

    public function replies(): HasMany
    {
        return $this->hasMany(\App\Models\ForumReply::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Access\User\User::class);
    }

    public function forumViews(): HasMany
    {
        return $this->hasMany(\App\Models\ForumView::class);
    }

    public function totalViews(): HasMany
    {
        return $this->hasMany(\App\Models\ForumView::class)
            ->selectRaw('SUM(views) as total,forum_id')
            ->groupBy('forum_id');
    }
}
