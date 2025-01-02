<?php
$buyerArray = [];
$sellersArray = [];
$cobuyerArray = [];
$cosellersArray = [];
if (!empty($offer->rentSignatures)) {
    foreach ($offer->rentSignatures as $sign) {
        if ($sign['type'] == 1) {
            $buyerArray = $sign;
        } elseif ($sign['type'] == 2) {
            $sellersArray = $sign;
        } elseif ($sign['type'] == 3) {
            $cobuyerArray[] = $sign;
        } else {
            $cosellersArray[] = $sign;
        }
    }
}

//$test = $offer->rentSignatures->groupBy('user_id');
//echo'<pre>';print_r($compact);die;
?>
<style>
.custom_state {
 /* display: block !important; */
 width: auto% !important;
 border-radius: 5px;
 margin-right: 4px;
 border: 1px solid #f0f0f0;
}
</style>

<div class="heading-text">
    <h2>Your Lease Agreement</h2>
</div>
<div class="para-text row">
    <div class="form-group">
        <div class="col-md-12">
            <div class="first-child">
                <h5 class="first-child">THIS LEASE (the 'Lease') dated:</h5>

                <input type="text" class="form-control" name="lease_dated" value="{{ (isset($offer->rentAgreement) && !empty($offer->rentAgreement)) ? date('Y-m-d', strtotime($offer->rentAgreement->created_at)) : date('Y-m-d') }}" readonly="readonly">
            </div>
            @if(!empty($signature))
            <h4>FOR THE PROPERTY:</h4>
            <div class="form-group">
                <label>Address:</label>
                <textarea id="formatted_address" class="form-control text-height" name="address" readonly="readonly">{{($offer->propertyConditional->street_address??"") . ($offer->propertyConditional->townhouse_apt ? ", Apt# ". $offer->propertyConditional->townhouse_apt :"") }}</textarea>
            </div>
            <div class="form-group">
                <label>City:</label>
                <input id="city" class="form-control" value="<?php echo getCityName($offer->propertyConditional->city_id); ?>" type="text" readonly="readonly">
            </div>
            <div class="form-group">
                <label>State:</label>
                <input id="state" class="form-control" value="<?php echo findState($offer->propertyConditional->state_id); ?>" type="text" readonly="readonly">
            </div>
            <div class="form-group">
                <label>Zip Code:</label>
                <input id="postal_code" class="form-control" min="0"  type="number" value="<?php echo findZipCode($offer->propertyConditional->zip_code_id); ?>" autocomplete="off" readonly="readonly">
            </div>
            @else
            <h4>FOR THE PROPERTY:</h4>
            <div class="form-group">
                <label>Address:</label>
                <textarea id="formatted_address" class="form-control text-height" name="address" readonly="readonly">{{($offer->property->street_address??"") . ($offer->property->townhouse_apt ? ", Apt# ". $offer->property->townhouse_apt :"") }}</textarea>
            </div>
            <div class="form-group">
                <label>City:</label>
                <input id="city" class="form-control" value="<?php echo getCityName($offer->property->city_id); ?>" type="text" readonly="readonly">
            </div>
            <div class="form-group">
                <label>State:</label>
                <input id="state" class="form-control" value="<?php echo findState($offer->property->state_id); ?>" type="text" readonly="readonly">
            </div>
            <div class="form-group">
                <label>Zip Code:</label>
                <input id="postal_code" class="form-control" min="0"  type="number" value="<?php echo findZipCode($offer->property->zip_code_id); ?>" autocomplete="off" readonly="readonly">
            </div>
            @endif
        </div>
    </div>
    <div class="form-group">
        @if(empty($signature))
        <div class="col-md-12">
            <h4>The ('Premises'): BETWEEN (LANDLORD) and (TENANT)</h4>
            <h5>LANDLORD</h5>
            <div class="form-group">
                <label>Name(s):</label>
                <input type="text" class="form-control" id="inputPassword3" value="{{$offer->landlord->user_profile->full_name??$offer->landlord->business_profile->company_name??""}}" readonly="readonly">
            </div>
            <div class="form-group">
                <label>Street Address:</label>
                <textarea id="formatted_address" class="form-control" placeholder="Address" readonly="readonly">{{$offer->landlord->user_profile->address??$offer->landlord->business_profile->company_address??""}}</textarea>
            </div>
            <div class="form-group">
                <label>City:</label>
                <input id="city" class="form-control" type="text" value="{{ $offer->landlord->city??"" }}" readonly="readonly">
            </div>

            <div class="form-group">
                <label>State:</label>
                <input id="state" class="form-control" value="<?php echo findState($offer->landlord->state_id); ?>" type="text" readonly="readonly">
            </div>
            <div class="form-group">
                <label>Zip Code:</label>
                <input id="postal_code" class="form-control" min="0" type="number" value="{{ $offer->landlord->zip_code??"" }}" readonly="readonly">
            </div>
            <div class="form-group">
                <label>Telephone:</label>
                <input type="text" class="form-control" id="inputEmail3" value="{{$offer->landlord->phone_no??''}}" readonly="readonly">
            </div>
            <p>(Collectively and individually the 'Landlord')</p>
        </div><!--col-md-12-->
        <?php
        if (isset($offer) && $offer->landlordQuestionnaire->partners) {
            $landlordPartners = explode(',', $offer->landlordQuestionnaire->partners);
            foreach ($landlordPartners as $landlordPartner) {
                $landlordProfile = getPartnerProfile($landlordPartner);
                ?>
                <div class="col-md-12">
                    <h5>LANDLORD</h5>
                    <div class="form-group">
                        <label>Name(s):</label>
                        <input type="text" class="form-control" value="{{getSinglePartnerName($landlordPartner)??""}}" readonly="readonly">
                    </div>
                    <div class="form-group">
                        <label>Street Address:</label>
                        <textarea class="form-control" readonly="readonly">{{$landlordProfile->user_profile->address??$landlordProfile->landlord->business_profile->company_address??""}}</textarea>
                    </div>
                    <div class="form-group">
                        <label>City:</label>
                        <input class="form-control" value="{{ $landlordProfile->city??"" }}"  readonly="readonly">
                    </div>

                    <div class="form-group">
                        <label>State:</label>
                        <input class="form-control" value="<?php echo findState($landlordProfile->state_id); ?>" readonly="readonly">
                    </div>
                    <div class="form-group">
                        <label>Zip Code:</label>
                        <input class="form-control" value="{{ $landlordProfile->zip_code??"" }}" readonly="readonly">
                    </div>
                    <div class="form-group">
                        <label>Telephone:</label>
                        <input class="form-control" value="{{$landlordProfile->phone_no??''}}" readonly="readonly">
                    </div>
                </div>
            <?php }
            ?>
            <p>(Collectively and individually the 'Landlord')</p>
        <?php }
        ?>
        @else
        <div class="col-md-12">
            <h4>The ('Premises'): BETWEEN (LANDLORD) and (TENANT)</h4>
            <h5>LANDLORD</h5>
            <div class="form-group">
                <label>Name(s):</label>
                <input type="text" class="form-control" id="inputPassword3" value="{{$sellersArray->fullname??""}}" readonly="readonly">
            </div>
            <div class="form-group">
                <label>Street Address:</label>
                <textarea id="formatted_address" class="form-control" placeholder="Address" readonly="readonly">{{$sellersArray->address??""}}</textarea>
            </div>
            <div class="form-group">
                <label>City:</label>
                <input id="city" class="form-control" type="text" value="{{$sellersArray->city??""}}" readonly="readonly">
            </div>

            <div class="form-group">
                <label>State:</label>
                <input id="state" class="form-control" value="<?php echo findState($sellersArray->state_id) ?>" type="text" readonly="readonly">
            </div>
            <div class="form-group">
                <label>Zip Code:</label>
                <input id="postal_code" class="form-control" min="0" type="number" value="{{ $sellersArray->zip_code??"" }}" readonly="readonly">
            </div>
            <div class="form-group">
                <label>Telephone:</label>
                <input type="text" class="form-control" id="inputEmail3" value="{{$sellersArray->phone_no??''}}" readonly="readonly">
            </div>
            <p>(Collectively and individually the 'Landlord')</p>
        </div>
        <?php
          $compact = [];
        foreach ($cosellersArray as $cosellers) {
                  if(!in_array($cosellers->user_id,$compact)){
                  $compact[] = $cosellers->user_id;
        
            ?>
            <div class="col-md-12">
                <h5>LANDLORD</h5>
                <div class="form-group">
                    <label>Name(s):</label>
                    <input type="text" class="form-control" value="{{$cosellers->fullname??""}}" readonly="readonly">
                </div>
                <div class="form-group">
                    <label>Street Address:</label>
                    <textarea class="form-control" readonly="readonly">{{$cosellers->address??$landlordProfile->landlord->business_profile->company_address??""}}</textarea>
                </div>
                <div class="form-group">
                    <label>City:</label>
                    <input class="form-control" value="{{ $cosellers->city??"" }}"  readonly="readonly">
                </div>

                <div class="form-group">
                    <label>State:</label>
                    <input class="form-control" value="{{findState($cosellers->state_id)}}" readonly="readonly">
                </div>
                <div class="form-group">
                    <label>Zip Code:</label>
                    <input class="form-control" value="{{$cosellers->zip_code??"" }}" readonly="readonly">
                </div>
                <div class="form-group">
                    <label>Telephone:</label>
                    <input class="form-control" value="{{$cosellers->phone_no??''}}" readonly="readonly">
                </div>
            </div>
        <?php }
        }
        ?>

        @endif
        @if(empty($signature))
        <div class="col-md-12">
            <h5>TENANT</h5>
            <div class="form-group">
                <label>Name(s):</label>
                <input type="text" class="form-control" id="tenant_name" name="tenant_name[]" value="{{$offer->tenant->user_profile->full_name??$offer->tenant->business_profile->company_name??""}}" readonly="readonly">
            </div>
            <div class="form-group">
                <label>Street Address:</label>
                <textarea id="formatted_address" class="form-control" placeholder="Address" readonly="readonly">{{$offer->tenant->user_profile->address ?? $offer->tenant->business_profile->company_address ?? ""}}</textarea>
            </div>
            <div class="form-group">
                <label>City:</label>
                <input id="city" class="form-control" placeholder="City" value="{{$offer->tenant->city??''}}" type="text" readonly="readonly">
            </div>
            <div class="form-group">
                <label>State:</label>
                <input id="state" class="form-control" placeholder="State" value="<?php echo findState($offer->tenant->state_id); ?>" type="text" readonly="readonly">
            </div>
            <div class="form-group">
                <label>Zip Code:</label>
                <input id="postal_code" class="form-control" value="{{$offer->tenant->zip_code??''}}" type="number" value="" autocomplete="off" readonly="readonly">
            </div>
            <div class="form-group">
                <label>Telephone:</label>
                <input type="text" class="form-control" value="{{$offer->tenant->phone_no??''}}" readonly="readonly">
            </div>
            <p>(Collectively and individually the 'Tenant')</p>
        </div><!--col-md-12-->
        <?php
        if (!empty($offer) && !empty($offer->tenantQuestionnaire->partners)) {
            $tenantPartners = explode(',', $offer->tenantQuestionnaire->partners);
            foreach ($tenantPartners as $tenantPartner) {
                $landlordProfile = getPartnerProfile($tenantPartner);
                ?>
                <div class="col-md-12">
                    <h5>TENANT</h5>
                    <div class="form-group">
                        <label>Name(s):</label>
                        <input type="text" class="form-control" value="{{getSinglePartnerName($tenantPartner)??""}}" readonly="readonly">
                    </div>
                    <div class="form-group">
                        <label>Street Address:</label>
                        <textarea class="form-control" readonly="readonly">{{$landlordProfile->user_profile->address ?? $landlordProfile->tenant->business_profile->company_address ?? ""}}</textarea>
                    </div>
                    <div class="form-group">
                        <label>City:</label>
                        <input class="form-control" value="{{$landlordProfile->city??''}}" readonly="readonly">
                    </div>

                    <div class="form-group">
                        <label>State:</label>
                        <input class="form-control" value="<?php echo findState($landlordProfile->state_id); ?>" readonly="readonly">
                    </div>
                    <div class="form-group">
                        <label>Zip Code:</label>
                        <input class="form-control" value="{{$landlordProfile->zip_code??''}}" readonly="readonly">
                    </div>
                    <div class="form-group">
                        <label>Telephone:</label>
                        <input class="form-control" value="{{$landlordProfile->phone_no??''}}" readonly="readonly">
                    </div>
                </div>
            <?php }
            ?>
            <p>(Collectively and individually the 'Co-Signer')</p>
            <p>IN CONSIDERATION OF the Landlord leasing certain premises to the Tenant, the Tenant leasing those premises from the Landlord and the mutual benefits and obligations provided in this Lease, the receipt and sufficiency of which consideration is hereby acknowledged, the parties to this Lease agree as follows:</p>
        <?php }
        ?>
        @else
        <div class="col-md-12">
            <h5>TENANT</h5>
            <div class="form-group">
                <label>Name(s):</label>
                <input type="text" class="form-control" id="tenant_name" name="tenant_name[]" value="{{$buyerArray->fullname??""}}" readonly="readonly">
            </div>
            <div class="form-group">
                <label>Street Address:</label>
                <textarea id="formatted_address" class="form-control" placeholder="Address" readonly="readonly">{{$buyerArray->address ??""}}</textarea>
            </div>
            <div class="form-group">
                <label>City:</label>
                <input id="city" class="form-control" placeholder="City" value="{{$buyerArray->city??''}}" type="text" readonly="readonly">
            </div>
            <div class="form-group">
                <label>State:</label>
                <input id="state" class="form-control" placeholder="State" value="<?php echo findState($buyerArray->state_id); ?>" type="text" readonly="readonly">
            </div>
            <div class="form-group">
                <label>Zip Code:</label>
                <input id="postal_code" class="form-control" value="{{$buyerArray->zip_code??''}}" type="number" value="" autocomplete="off" readonly="readonly">
            </div>
            <div class="form-group">
                <label>Telephone:</label>
                <input type="text" class="form-control" value="{{$buyerArray->phone_no??''}}" readonly="readonly">
            </div>
            <p>(Collectively and individually the 'Tenant')</p>
        </div><!--col-md-12-->
        <?php
        if (isset($cobuyerArray)) {
            
        $uniqueBuyer = [];
            foreach ($cobuyerArray as $cobuyer) {
//                echo'<pre>';print_r($cobuyer);
//                if(!in_array($cobuyer->user_id, (array)$cobuyer)){
                if(!in_array($cobuyer->user_id,$uniqueBuyer)){
                  $uniqueBuyer[] = $cobuyer->user_id;
                ?>
                <div class="col-md-12">
                    <h5>TENANT</h5>
                    <div class="form-group">
                        <label>Name(s):</label>
                        <input type="text" class="form-control" value="{{$cobuyer->fullname??""}}" readonly="readonly">
                    </div>
                    <div class="form-group">
                        <label>Street Address:</label>
                        <textarea class="form-control" readonly="readonly">{{$cobuyer->address ?? ""}}</textarea>
                    </div>
                    <div class="form-group">
                        <label>City:</label>
                        <input class="form-control" value="{{$cobuyer->city??''}}" readonly="readonly">
                    </div>

                    <div class="form-group">
                        <label>State:</label>
                        <input class="form-control" value="<?php echo findState($cobuyer->state_id); ?>" readonly="readonly">
                    </div>
                    <div class="form-group">
                        <label>Zip Code:</label>
                        <input class="form-control" value="{{$cobuyer->zip_code??''}}" readonly="readonly">
                    </div>
                    <div class="form-group">
                        <label>Telephone:</label>
                        <input class="form-control" value="{{$cobuyer->phone_no??''}}" readonly="readonly">
                    </div>
                </div>
    <?php
    }
            }
    ?>
            <p>(Collectively and individually the 'Co-Signer')</p>
            <p>IN CONSIDERATION OF the Landlord leasing certain premises to the Tenant, the Tenant leasing those premises from the Landlord and the mutual benefits and obligations provided in this Lease, the receipt and sufficiency of which consideration is hereby acknowledged, the parties to this Lease agree as follows:</p>
        <?php } ?>
        @endif
    </div>
    <div class="form-group">
        <div class="col-md-12">
            <h4>Leased Premises  </h4>
            <p> The Landlord agrees to rent to the Tenant domicile in the Home municipally described as (the 'Premises') for use as residential premises only. Neither the Premises nor any part of the Premises will be used at any time during the term of this Lease by Tenant for the purpose of carrying on any business, profession, or trade of any kind, or for the purpose other than as a private single-family residence. </p>
            <p> Subject to the provisions of this Lease, apart from the Tenant(s), no other persons will live in the Premises without the prior written permission of the Landlord. If LANDLORD, with written consent, allows for additional persons to occupy the premises, the rent shall be increased by $100 for each such person. Any person staying 14 days cumulative or longer, without the LANDLORD'S written consent, shall be considered as occupying the premises in violation of this agreement.</p>
            <p> No guests of the Tenants may occupy the Premises for longer than one week without the prior written consent of the Landlord.</p>
            <p> Subject to the provisions of this Lease, the Tenant is entitled to the exclusive use of the following parking (the 'Parking') on or about the Premises: Attached. Only properly insured motor vehicles may be parked in the Tenant's space. </p>
            <p>The Landlord agrees to supply and the Tenant agrees to use and maintain in reasonable condition, normal wear and tear expected, the following furnishings:</p>
            <textarea rows="2" type="text" class="form-control text-height" id="" name="furnishings" readonly="readonly">{{$offer->landlordQuestionnaire->furnishings??""}}</textarea>
            <p>No liquid filled furniture of any kind may be kept on the premises. If the structure was built in 1973 or later TENANT may possess a waterbed if he maintains waterbed insurance valued at $100,000 or more. TENANT must furnish LANDLORD with proof of said insurance. TENANT must use bedding that complies with the load capacity of the manufacturer. </p>
        </div><!--col-md-12-->
    </div>
    <div class="form-group">
        <div class="col-md-12">
            <h4>Terms  </h4>
            <p>The term of the Lease commences at 12:00 noon on
                <span class="text-readonly"><input type="text" class="readonly" id="text-form-input" name="" value="{{$offer->landlordQuestionnaire->effective_start_date??""}}" readonly="readonly"></span>
                and ends at 12:00 noon
<?php
if (isset($offer->landlordQuestionnaire)) {
    $mothCount = $offer->month_count - 1;
    $effectiveDate = date('Y-m-d', strtotime("+$mothCount months", strtotime($offer->landlordQuestionnaire->effective_start_date)));
    $d = new DateTime($effectiveDate);
}
?>
                <span class="text-readonly"><input type="text" class="readonly" id="text-form-input" name="" value="{{$effectiveDate??""}}" readonly="readonly"></span>
                Should the Tenant remain in possession of the Premises with the consent of the Landlord after the natural expiration of this Lease, a new tenancy from month to month will be created between the Landlord and the Tenant which will be subject to all the terms and conditions of this Lease but will be terminable upon the Landlord giving the Tenant the notice required under the Act.</p>
        </div><!--col-md-12-->
    </div>
    <?php
    if(!empty($offer->rent_counter_offers->first()->counter_offer_price)){
	$updatedPrice = $offer->rent_counter_offers->first()->counter_offer_price;
    }
    else{
	$updatedPrice = $offer->rent_price??"";
    }
    
    ?>
    <div class="form-group">
        <div class="col-md-12">
            <h4>Rent </h4>
            <p> Subject to the provisions of this Lease, the rent for the Premises is 
                <span class="text-readonly money"><input type="text" class="readonly" id="text-form-input" name="" value="{{round($updatedPrice)}}" readonly="readonly"></span>
                per month (collectively the 'Rent').The Tenant will pay the Rent on or before the 5th day of each and every month.
	    </p>
        </div><!--col-md-12-->
    </div>
    <div class="form-group">
        <div class="col-md-12">
            <h4>Security/Damage Deposit</h4>
            <p>
                The Security Deposit of
                <span class="text-readonly money"><input type="text" class="readonly" id="text-form-input" name="" value="{{$offer->landlordQuestionnaire->security_deposit??""}}" readonly="readonly"></span>
                is due at the signing of the lease, unless an express/written variance is provided from the landlord.Tenants agree to allow Lessor to deduct from the security deposit the following charges if they apply: (a) The costs of any repairs, replacements, redecorating, and or refurnishing of the premises, or any fixtures, systems or appliances, caused by other than "ordinary" wear; (b) any damages caused by smoking inside the house as smoking is not permitted; (c) a reasonable cleaning expense; and (d) any outstanding bills (e.g. cable, internet, phone, electric, fuel). THE SECURITY DEPOSIT MAY NOT BE USED FOR RENTAL PAYMENTS. -- The security deposit will be returned within 45 days (or less) of the termination of the Lease, pursuant to the laws of the State/District of
                <span class="text-readonly"><input type="text" class="custom_state" name="custom_state" id="text-form-input" value="<?php echo findState($offer->property->state_id); ?>" readonly="readonly"></span></p>
            </p>

        </div><!--col-md-12-->
    </div>
    <div class="form-group">
        <div class="col-md-12">
        <h4> Pets</h4>
        @if($offer->landlordQuestionnaire->pets_welcome==1)
		<textarea rows="12" type="text" class="form-control text-height" readonly="readonly">
        A reasonable number of pets or animals are allowed to be kept in or about the Premises. If this privilege is abused, the Landlord may revoke this privilege upon thirty (30) days notice. The animals that may be permitted are as follows: Dog/Cat- Non-refundable Pet fee of ${{!empty($offer->landlordQuestionnaire->non_refundable_pet_deposit) && $offer->landlordQuestionnaire->pets_welcome==1 ? $offer->landlordQuestionnaire->non_refundable_pet_deposit:'0'}}. Any other pets must be given written consent by the landlord before being kept on the premises sfddsfa.</textarea>
        @else
		 <textarea rows="2" type="text" class="form-control" readonly="readonly"> Pets not Allowed.</textarea>
        @endif
        </div><!--col-md-12-->
    </div>
    <div class="form-group">
        <div class="col-md-12">
            <h4> Noise and Disruptive Activities</h4>
            <p>TENANT or his/her guests and invitees shall not disturb, annoy, endanger or inconvenience other tenants of the building, neighbors, the LANDLORD or his agents, or workmen nor violate any law, nor commit or permit waste or nuisance in or about the premises.  </p>
            <p> The Landlord covenants that on paying the Rent and performing the covenants contained in this Lease, the Tenant will peacefully and quietly have, hold, and enjoy the Premises for the agreed term. </p>
            <p>  TENANT shall not do or keep anything in or about the premises that will obstruct the public spaces available to other residents. Lounging or unnecessary loitering on the front steps, public balconies or the common hallways that interferes with the convenience of other residents is prohibited.</p>
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-12">
            <h4> Inspections</h4>
            <p>TENANT or his/her guests and invitees shall not disturb, annoy, endanger or inconvenience other tenants of the building, neighbors, the LANDLORD or his agents, or workmen nor violate any law, nor commit or permit waste or nuisance in or about the premises.</p>
        </div><!--col-md-12-->
    </div>
    <div class="form-group">
        <div class="col-md-12">
            <h4> Governing Law</h4>
            <p>It is the intention of the parties to this Lease that the tenancy created by this Lease and the performance under this Lease, and all suits and special proceedings under this Lease, be construed in accordance with and governed, to the exclusion of the law of any other forum, by the laws of the State/District of
                <span class="text-readonly"><input type="text" id="text-form-input" class="custom_state" name="custom_state"  value="<?php echo findState($offer->property->state_id); ?>" readonly="readonly"></span>
                , without regard to the jurisdiction in which any action or special proceeding may be instituted.</p>
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-12">
            <h4> Severability</h4>
            <p>If there is a conflict between any provision of this Lease and the applicable legislation of the State/District (the 'Act'), the Act will prevail and such provisions of the Lease will be amended or deleted as necessary in order to comply with the Act. Further, any provisions that are required by the Act are incorporated into this Lease. </p>
            <p>If there is a conflict between any provision of this Lease and any form of lease prescribed by the Act, that prescribed form will prevail and such provisions of the lease will be amended or deleted as necessary in order to comply with that prescribed form. Further, any provisions that are required by that prescribed form are incorporated into this Lease.</p>
            <p>In the event that any of the provisions of this Lease will be held to be invalid or unenforceable in whole or in part, those provisions to the extent enforceable and all other provisions will nevertheless continue to be valid and enforceable as though the invalid or unenforceable parts had not been included in this Lease and the remaining provisions had been executed by both parties subsequent to the expungement of the invalid provision.</p>
            <p>If any provision of this agreement is held to be invalid, such invalidity shall not affect the validity or enforceability of any other provision of this agreement.</p>
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-12">
            <h4>Amendment of Lease</h4>
            <p>Any amendment or modification of this Lease or additional obligation assumed by either party in connection with this Lease will only be binding if evidenced in writing signed by each party or an authorized representative of each party.</p>
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-12">
            <h4> Co-Signer (Guarantor)</h4>
            <p>The ('Co-Signer') serves as a guarantor of the 'lease'. In the event of default by the tenant, the Co-Signer promises to either 1) assume the tenant's liability under this lease AND/OR 2) fulfill the tenant's contractual obligations as described in the 'lease'.</p>
            <label>Our Contingency:</label>
            <textarea rows="2" type="text" class="form-control text-height" id="" readonly="readonly">{{(isset($offer->landlordQuestionnaire->require_cosigner) && $offer->landlordQuestionnaire->require_cosigner == config('constant.inverse_common_yes_no.Yes')) ? "A Co-signer is required on the lease, and is not effective until a Co-Signer is secured to the Lease Agreement" : ""}}</textarea>
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-12">
            <h4> Assignment and Subletting</h4>
            <p>An assignment, subletting, concession, or license or an assignment or subletting by operation of law, will be void and will, at Landlord's option, terminate this Lease.</p>
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-12">
            <h4> Damage to Premises </h4>
            <p>If the Premises, or any part of the Premises, will be partially damaged by fire or other casualty not due to the Tenant's negligence or willful act or that of the Tenant's employee, family, agent, or visitor, the Premises will be promptly repaired by the Landlord and there will be an abatement of rent corresponding with the time during which, and the extent to which, the Premises may have been unlivable. However, if the Premises should be damaged other than by the Tenant's negligence or willful act or that of the Tenant's employee, family, agent, or visitor and the Landlord decides not to rebuild or repair the Premises, the Landlord may end this Lease by giving appropriate notice.</p>
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-12">
            <h4> Maintenance</h4>
            <p>The Tenant will, at its sole expense, keep and maintain the Premises and appurtenances in good and sanitary condition and repair during the term of this Lease and any renewal of this Lease.</p>
            <p> In particular, the Tenant will keep the fixtures in the Premises in good order and repair. The Tenant will, at Tenant's sole expense, make all required repairs to the plumbing, range, heating apparatus, and electric and gas fixtures whenever damage to such items will have resulted from the Tenant's misuse, waste, or neglect or that of the Tenant's employee, family, agent, or visitor. </p>
            <p>Major maintenance and repair of the Premises involving anticipated or actual costs in excess of $100.00 per incident not due to the Tenant's misuse, waste, or neglect or that of the Tenant's employee, family, agent, or visitor, will be the responsibility of the Landlord or the Landlord's assigns. </p>
            <p>Where the Premises has its own sidewalk, entrance, driveway or parking space which is for the exclusive use of the Tenant and its guests, the Tenant will keep the sidewalk, entrance, driveway or parking space clean, tidy and free of objectionable material including dirt, debris, snow and ice.</p>
            <p>Where the Premises has its own garden or grass area which is for the exclusive use of the Tenant and its guests, the Tenant will water, fertilize, weed, cut and otherwise maintain the garden or grass area in a reasonable condition including any trees or shrubs therein.</p>
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-12">
            <h4> Utilities</h4>
            <p><b>[Unless indicated otherwise in 'the lease']</b> Electricity, fuel, cable, Water/Sewage, telephone services, rubbish removal, and charges for snow/ice removal are NOT part of this Agreement and shall be paid by Tenant. Tenant agrees to initiate transfer of all utilities into their names one week prior to move in date.</p>
            <label>The Landlord will provide the following utilities to the tenant at the landlord's expense:</label>
            <textarea rows="2" type="text" class="form-control text-height" id="" name="expense" readonly="readonly" placeholder="expense">{{$offer->landlordQuestionnaire->utilities??""}}</textarea>
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-12">
            <h4> Care and Use of Premises</h4>
            <p> No SMOKING in the premises unless otherwise agreed upon in writing with the Lessor.</p>
            <p>No Alterations: Tenants shall not remodel, paint or make any structural changes to the premise nor remove any furnishings without the prior written consent.</p>
            <p>The Tenant will promptly notify the Landlord of any damage, or of any situation that may significantly interfere with the normal use of the Premises or to any furnishings supplied by the Landlord. </p>
            <p>Vehicles which the Landlord reasonably considers unsightly, noisy, dangerous, improperly insured, inoperable or unlicensed are not permitted in the Tenant's parking stall(s), and such vehicles may be towed away at the Tenant's expense. Parking facilities are provided at the Tenant's own risk. The Tenant is required to park in only the space allotted to them.</p>
            <p>The Tenant will not make (or allow to be made) any noise or nuisance which, in the reasonable opinion of the Landlord, disturbs the comfort or convenience of other tenants.</p>
            <p> The Tenant will keep the Premises reasonably clean. </p>
            <p>The Tenant will dispose of its trash in a timely, tidy, proper and sanitary manner. </p>
            <p> The Tenant will not engage in any illegal trade or activity on or about the Premises. </p>
            <p>The Landlord and Tenant will comply with standards of health, sanitation, fire, housing and safety as required by law. </p>
            <p>The Landlord will use reasonable efforts to maintain the Premises in such a condition as to prevent the accumulation of moisture and the growth of mold, and to promptly respond to any written notices from the Tenant in relations to accumulation of moisture and visible evidence of mold.</p>
            <p>The Tenant will use reasonable efforts to maintain the Premises in such a condition as to prevent the accumulation of moisture and the growth of mold, and to promptly notify the Landlord in writing of any moisture accumulation that occurs or of any visible evidence of mold discovered by the Tenant. </p>
            <p>The Tenant agrees that no signs will be placed or painting done on or about the Premises by the Tenant or at the Tenant's direction without the prior, express, and written consent of the Landlord. Notwithstanding the above provision, the Tenant may place election signs on the Premises during the appropriate time periods</p>
            <p>If the Tenant is absent from the Premises and the Premises are unoccupied for a period of four consecutive days or longer, the Tenant will arrange for regular inspection by a competent person. The Landlord will be notified in advance as to the name, address and phone number of this said person. </p>
            <p>The hallways, passages and stairs of the building in which the Premises are situated will be used for no purpose other than going to and from the Premises and the Tenant will not in any way encumber those areas with boxes, furniture or other material or place or leave rubbish in those areas and other areas used in common with any other tenant. </p>
            <p>Boots and rubbers which are soiled or wet should be removed at the entrance to the building in which the Premises are located and taken into the Tenant's Premises. </p>
            <p>At the expiration of the lease term, the Tenant will quit and surrender the Premises in as good a state and condition as they were at the commencement of this Lease, reasonable use and wear and damages by the elements excepted.</p>
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-12">
            <h4>Hazardous Materials</h4>
            <p>The Tenant will not keep or have on the Premises any article or thing of a dangerous, flammable, or explosive character that might unreasonably increase the danger of fire on the Premises or that might be considered hazardous by any responsible insurance company.</p>
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-12">
            <h4> Rules and Regulations</h4>
            <p>The Tenant will obey all rules and regulations posted by the Landlord regarding the use and care of the building, parking lot, laundry room and other common facilities that are provided for the use of the Tenant in and around the building containing the Premises.</p>
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-12">
            <h4>Lead Warning</h4>
            <p> Housing built before 1978 may contain lead based paint. Lead from paint, paint chips, and dust can pose health hazards if not taken care of properly. Lead exposure is especially harmful to young children and pregnant women. Before renting pre-1978 housing, leasers must disclose the presence of known lead-based paint hazards in the dwelling. Lessees must also receive a federally approved pamphlet on lead poisoning prevention</p>
        </div>
    </div>
    <div class="form-group">
        <div class="col-md-12">
            <h4>General Provisions</h4>
            <ul>
                <li>Any waiver by the Landlord of any failure by the Tenant to perform or observe the provisions of this Lease will not operate as a waiver of the Landlord's rights under this Lease in respect of any subsequent defaults, breaches or non-performance and will not defeat or affect in any way the Landlord's rights in respect of any subsequent default or breach. </li>
                <li>This Lease will extend to and be binding upon and inure to the benefit of the respective heirs, executors, administrators, successors and assigns, as the case may be, of each party to this Lease. All covenants are to be construed as conditions of this Lease. </li>
                <li>All sums payable by the Tenant to the Landlord pursuant to any provision of this Lease will be deemed to be additional rent and will be recovered by the Landlord as rental arrears </li>
                <li>Where there is more than one Tenant executing this Lease, all Tenants are jointly and severally liable for each other's acts, omissions and liabilities pursuant to this Lease. </li>
                <li> Locks may not be added or changed without the prior written agreement of both the Landlord and the Tenant, or unless the changes are made in compliance with the Act. </li>
                <li>The Tenant will be charged an additional amount of $25.00 for each N.S.F. check or check returned by the Tenant's financial institution. </li>
                <li>The Landlord may charge the Tenant or deduct the cost of having the carpets professionally steam cleaned from the security deposit, if damage beyond reasonable wear and tear is discovered upon termination of the lease. </li>
                <li>Headings are inserted for the convenience of the parties only and are not to be considered when interpreting this Lease. Words in the singular mean and include the plural and vice versa. Words in the masculine mean and include the feminine and vice versa. </li>
                <li>This Lease and the Tenant's leasehold interest under this Lease are and will be subject, subordinate, and inferior to any liens or encumbrances now or hereafter placed on the Premises by the Landlord, all advances made under any such liens or encumbrances, the interest payable on any such liens or encumbrances, and any and all renewals or extensions such liens or encumbrances. </li>
                <li>This Lease may be executed in counterparts. Facsimile/Digital signatures are binding and are considered to be original signatures. </li>
                <li>This Lease will constitute the entire agreement between the Landlord and the Tenant. Any prior understanding or representation of any kind preceding the date of this Lease will not be binding on either party except to the extent incorporated in this Lease.</li>
                <li>The Tenant will indemnify and save the Landlord, and the owner of the Premises where different from the Landlord, harmless from all liabilities, fines, suits, claims, demands and actions of any kind or nature for which the Landlord will or may become liable or suffer by reason of any breach, violation or non-performance by the Tenant or by any person for whom the Tenant is responsible, of any covenant, term, or provisions hereof or by reason of any act, neglect or default on the part of the Tenant or other person for whom the Tenant is responsible. Such indemnification in respect of any such breach, violation or non-performance, damage to property, injury or death occurring during the term of the Lease will survive the termination of the Lease, notwithstanding anything in this Lease to the contrary.</li>
                <li>The Tenant agrees that the Landlord will not be liable or responsible in any way for any personal injury or death that may be suffered or sustained by the Tenant or by any person for whom the Tenant is responsible who may be on the Premises of the Landlord or for any loss of or damage or injury to any property, including cars and contents thereof belonging to the Tenant or to any other person for whom the Tenant is responsible.</li>
                <li>The Tenant is responsible for any person or persons who are upon the or occupying the Premises or any other part of the Landlord's premises at the request of the Tenant, either express or implied, whether for the purposes of visiting the Tenant, making deliveries, repairs or attending upon the Premises for any other reason. Without limiting the generality of the foregoing, the Tenant is responsible for all members of the Tenant's family, guests, servants, tradesmen, repairmen, employees, agents, invitees or other similar persons.</li>
                <li>During the last 30 days of this Lease, the Landlord or the Landlord's agents will have the privilege of displaying the usual 'For Sale' or 'For Rent' or 'Vacancy' signs on the Premises</li>
                <li>The lease is subject to all rules, regulations and bylaws of any applicable Condominium and/or Home Owner Associations. </li>
                <li>Lessee shall have 3 days from the beginning of the Lease to inspect the premises and return the "Inspection Sheet." Lessee shall be responsible for any damages not identified on the "Inspection Sheet." Normal and/or reasonable wear and tear are expected.</li>
                <li>If the Tenant breaches the terms of this lease for any reason, the Tenant shall be responsible for any and all costs incurred by the Lessor including, but not limited to, attorney's fees, court costs, filing fees, service fees, unpaid rent, and the like.</li>
            </ul>
        </div>
    </div>
</div>
