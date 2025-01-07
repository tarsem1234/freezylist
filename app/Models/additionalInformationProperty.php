<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class additionalInformationProperty extends Model
{
    use SoftDeletes;

    protected $table = 'additional_information_property';

    public function property(): BelongsToMany
    {
        return $this->belongsToMany(\App\Models\Property::class)->withPivot('property_id');
    }
}
