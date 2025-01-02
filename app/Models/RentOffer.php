<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class RentOffer extends Model
{
    use SoftDeletes;

    public function property(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Property::class);
    }

    public function property_owner_user(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Access\User\User::class, 'owner_id');
    }

    public function propertyConditional(): HasOne
    {
        return $this->hasOne(\App\Models\PropertyConditionalData::class, 'offer_id', 'id');
    }

    public function sent_offer_user(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Access\User\User::class, 'buyer_id');
    }

    public function landlord(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Access\User\User::class, 'owner_id');
    }

    public function tenant(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Access\User\User::class, 'buyer_id');
    }

    public function rent_counter_offers(): HasMany
    {
        return $this->hasMany(\App\Models\CounterRentOffer::class, 'rent_offer_id');
    }

    public function landlordQuestionnaire(): HasOne
    {
        return $this->hasOne(\App\Models\LandlordQuestionnaire::class, 'offer_id');
    }

    public function tenantQuestionnaire(): HasOne
    {
        return $this->hasOne(\App\Models\TenantQuestionnaire::class, 'rent_offer_id');
    }

    public function rentAgreement(): HasOne
    {
        return $this->hasOne(\App\Models\RentAgreement::class, 'rent_offer_id');
    }

    public function rentSignatures(): HasMany
    {
        return $this->hasMany(\App\Models\RentSignature::class, 'offer_id');
    }
}
