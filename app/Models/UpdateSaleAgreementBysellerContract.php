<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UpdateSaleAgreementBysellerContract extends Model
{
    use SoftDeletes;

    protected $table = 'sale_agreement';

    //    protected $fillable = [
    //        'not_included_insale',
    //        'leased_items',
    //        'addenda',
    //        'other',
    //        'offer_expiration',
    //        'offer_id'
    //    ];
}
