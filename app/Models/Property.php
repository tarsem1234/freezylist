<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Property extends Model
{
    use SoftDeletes;

    public function architechture(): HasOne
    {
        return $this->hasOne(\App\Models\PropertyArchitecture::class, 'property_id');
    }

    public function images(): HasMany
    {
        return $this->hasMany(\App\Models\PropertyImage::class, 'property_id');
    }

    public function latestImage(): HasOne
    {
        return $this->hasOne(\App\Models\PropertyImage::class, 'property_id')->latest();
    }

    public function additional_information(): BelongsToMany
    {
        return $this->belongsToMany(\App\Models\AdditionalInformation::class)->withPivot('property_id', 'additional_information_id');
    }

    public function additional_property(): BelongsToMany
    {
        return $this->belongsToMany(\App\Models\additionalInformationProperty::class)->withPivot('property_id', 'additional_information_id');
    }

    public function city(): HasOne
    {
        return $this->hasOne(\App\Models\City::class);
    }

    public function offers(): HasMany
    {
        return $this->hasMany('App\Models\Offer');
    }

    public function rentOffer(): HasMany
    {
        return $this->hasMany(\App\Models\RentOffer::class);
    }

    public function saleOffer(): HasMany
    {
        return $this->hasMany(\App\Models\SaleOffer::class);
    }

    public function favorites(): HasMany
    {
        return $this->hasMany(\App\Models\Favorite::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Access\User\User::class);
    }

    public function disclosure(): HasOne
    {
        return $this->hasOne(\App\Models\PropertyConditionDisclaimer::class);
    }

    public function leadBasedPaintHazards(): HasOne
    {
        return $this->hasOne(\App\Models\LeadBasedPaintHazards::class);
    }

    public function propertyConditionDisclaimer(): HasOne
    {
        return $this->hasOne(\App\Models\PropertyConditionDisclaimer::class, 'property_id');
    }

    public function availability(): HasMany
    {
        return $this->hasMany(PropertyAvailability::class);
    }
}
