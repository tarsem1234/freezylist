<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Signature extends Model
{
    use SoftDeletes;

    //    public function signer_user()
    //    {
    //        return $this->belongsTo('App\Models\Access\User\User','from_user_id');
    //    }
}
