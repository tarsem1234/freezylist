<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class AdditionalInformation extends Model
{
    use SoftDeletes;

    protected $table = 'additional_information';

    //    public function parent()
    //    {
    //        return $this->belongsTo('App\Models\AdditionalInformation', 'parent_id');
    //    }

    public function children(): HasMany
    {
        return $this->hasMany(\App\Models\AdditionalInformation::class, 'parent_id'); //get all subs. NOT RECURSIVE
    }

    public function parent(): BelongsTo
    {
        return $this->belongsTo(\App\Models\AdditionalInformation::class, 'parent_id'); //get all subs. NOT RECURSIVE
    }

    public function property(): BelongsToMany
    {
        return $this->belongsToMany(\App\Models\Property::class)->withPivot('property_id');
    }
}
