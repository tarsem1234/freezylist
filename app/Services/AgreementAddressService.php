<?php

namespace App\Services;

use App\Models\PropertyContractUserAddresses;
use Illuminate\Support\Facades\Auth;

class AgreementAddressService
{
    /**
     * Get the currently authenticated user or null.
     */
    public function saveAgreementAddress($rentAgreement = null, $type = null)
    {
        $propertyContractUserAddresses = new PropertyContractUserAddresses;
        if ($type == 'landlord') {
            $propertyContractUserAddresses->user_id = Auth::id();
            $propertyContractUserAddresses->rent_agreement_id = $rentAgreement->id;
            $propertyContractUserAddresses->state_id = $rentAgreement->offer->landlord->state_id;
            $propertyContractUserAddresses->city = $rentAgreement->offer->landlord->city;
            $propertyContractUserAddresses->county = $rentAgreement->offer->landlord->county;
            $propertyContractUserAddresses->zip_code = $rentAgreement->offer->landlord->zip_code;
            $propertyContractUserAddresses->address = $rentAgreement->offer->landlord->user_profile->address
                    ?? $rentAgreement->offer->landlord->business_profile->company_address
                    ?? '';
        } else {
            $propertyContractUserAddresses->user_id = Auth::id();
            $propertyContractUserAddresses->rent_agreement_id = $rentAgreement->id;
            $propertyContractUserAddresses->state_id = $rentAgreement->offer->tenant->state_id;
            $propertyContractUserAddresses->city = $rentAgreement->offer->tenant->city;
            $propertyContractUserAddresses->county = $rentAgreement->offer->tenant->county;
            $propertyContractUserAddresses->zip_code = $rentAgreement->offer->tenant->zip_code;
            $propertyContractUserAddresses->address = $rentAgreement->offer->tenant->user_profile->address
                    ?? $rentAgreement->offer->landlord->business_profile->company_address
                    ?? '';
        }
        $propertyContractUserAddresses->save();

        return true;
    }
}
