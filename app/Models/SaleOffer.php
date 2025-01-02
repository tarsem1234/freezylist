<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class SaleOffer extends Model
{
    use SoftDeletes;

    public function property(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Property::class);
    }

    public function propertyConditional(): HasOne
    {
        return $this->hasOne(\App\Models\PropertyConditionalData::class, 'offer_id', 'id');
    }

    public function property_owner_user(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Access\User\User::class, 'owner_id');
    }

    public function seller(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Access\User\User::class, 'owner_id');
    }

    public function property_sender_user(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Access\User\User::class, 'sender_id');
    }

    public function buyer(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Access\User\User::class, 'sender_id');
    }

    public function sale_counter_offers(): HasMany
    {
        return $this->hasMany(\App\Models\CounterSaleOffer::class);
    }

    public function sellerQuestionnaire(): HasOne
    {
        return $this->hasOne(\App\Models\SellerQuestionnaire::class, 'offer_id');
    }

    public function buyerQuestionnaire(): HasOne
    {
        return $this->hasOne(\App\Models\BuyerQuestionnaire::class, 'offer_id');
    }

    public function saleAgreement(): HasOne
    {
        return $this->hasOne(\App\Models\UpdateSaleAgreementBysellerContract::class, 'offer_id');
    }

    //    public function signature()
    //    {
    //        return $this->hasOne('App\Models\Signature','offer_id');
    //    }
    public function signatures(): HasMany
    {
        return $this->hasMany(\App\Models\Signature::class, 'offer_id');
    }

    public function postClosing(): HasOne
    {
        return $this->hasOne(\App\Models\QuestionSellerPostClosing::class, 'offer_id');
    }

    public function Userdata(): HasMany
    {
        return $this->hasMany(\App\Models\Signature::class, 'offer_id');
    }

    public function userConditionalData(): HasMany
    {
        return $this->hasMany(\App\Models\UsersConditionalData::class, 'offer_id');
    }

    public function userbuyerConditionalData(): HasMany
    {
        return $this->hasMany(\App\Models\UsersConditionalData::class, 'user_id', 'sender_id');
    }

    public function usersenderConditionalData(): HasMany
    {
        return $this->hasMany(\App\Models\UsersConditionalData::class, 'user_id', 'owner_id');
    }
}
