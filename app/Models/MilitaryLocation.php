<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class MilitaryLocation extends Model
{
    protected $table = 'military_bases';

    public function zipCode(): HasOne
    {
        return $this->hasOne(\App\Models\ZipCode::class, 'id', 'zipcode_id');
    }
}
