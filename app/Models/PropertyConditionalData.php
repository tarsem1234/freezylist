<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class PropertyConditionalData extends Model
{
    use SoftDeletes;

    protected $table = 'property_conditional_data';

    //
    public function architechture(): HasOne
    {
        return $this->hasOne(\App\Models\PropertyArchitectureConditionalData::class, 'property_conditional_id');
    }

    public function disclosure(): HasOne
    {
        return $this->hasOne(\App\Models\PropertyDisclaimerConditionalData::class, 'property_conditional_id');
    }
    //     public function propertyConditionDisclaimer() {
    //        return $this->hasOne('App\Models\PropertyDisclaimerConditionalData', 'property_id');
    //    }
}
