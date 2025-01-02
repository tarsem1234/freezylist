<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class PropertyArchitectureConditionalData extends Model
{
    //
    use SoftDeletes;

    protected $table = 'property_architecture_conditional_data';

    public function property(): BelongsTo
    {
        return $this->belongsTo(\App\Models\PropertyConditionalData::class, 'property_id');
    }
}
