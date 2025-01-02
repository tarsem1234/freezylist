<div class="lease-agreement-inner-box">
    <div class="col-md-12 col-xs-12 col-sm-12 col-lg-12">
        <div class="heading-text-tenant">
            <h3>TENANT DETAILS:</h3>
        </div>
          <?php
                    $signatureArray = [];
                    $sellersArray = [];
                    if(!empty($offer->rentSignatures)){
                    foreach ($offer->rentSignatures as $sign) {
                        $signatureArray[$sign['type']][] = $sign['fullname'];
                        $signatureArray['signature'][$sign['type']] = $sign['signature'];
                    }
                    }
//		    echo'<pre>';print_r($signatureArray);die;
                    ?>
    </div>
     <div class="col-md-12">
        <div class="tenant-details">
            <div class="tenant-details-div">
          @if($offer->rentSignatures->isNotEmpty())  
                <div class="form-group">
                    <label>TENANT NAME:</label>
                    <input id="main-tenant-name" class="form-control" value="{{!empty($signatureArray[1][0])?$signatureArray[1][0]:''}}" readonly="readonly">
                    <label>TENANT SIGNATURE :</label>
                    <input class="form-control intro buyer-frst-sign" id="sd-tenant-signature-{{$offer->buyer_id+7}}" readonly="readonly" value="<?php
                        if (isset($offer->rentSignatures) && count($offer->rentSignatures) > 0) {
                            foreach($offer->rentSignatures as $buyerSignature) {
                                if($buyerSignature->user_id == $offer->buyer_id && isset($buyerSignature->signature_type) && $buyerSignature->signature_type== $type) {
                                    echo $buyerSignature->signature;
                                    $matchedTenantSignature = $buyerSignature;
                                }
                            }
                        }
                        ?>" style="color:#ff0000;">
                    <span class="error buyer-sign-error">Please fill this field</span>
                    <!-- signature-modal -->
                     @if(Auth::id() == $offer->tenant->id && empty($matchedTenantSignature))
                    <div class="signature">
                        <button type="button" class="btn btn-info btn-lg signature-button" data-toggle="modal" data-target="#myModal-{{ $offer->buyer_id+7 }}">Affix Signature</button>
                        <!-- Modal -->
                        <div id="myModal-{{$offer->buyer_id+7}}" class="modal fade dashboard-page" role="dialog">
                            <div class="modal-dialog">
                                <!-- Modal content-->
                                <div class="modal-content signature-model">
                                    <h4 class="modal-title">freezylist.lusites.xyz says</h4>
                                    <p class="m-zero">By affixing your digital signature, you are signing this document. Please confirm your signature</p>
                                    <div class="btns-green-blue text-center small-buttons">
                                        <button type="button" id="sd-tenant-signature-ok-{{$offer->buyer_id+7}}" class="button btn btn-green" data-dismiss="modal" onclick="addSignature({{$offer->buyer_id}})">Ok</button>
                                        <button type="button" class="button btn btn-blue" data-dismiss="modal">Cancel</button>
                                    </div>
                                </div>
                            </div><!-- modal-dialog -->
                        </div><!-- myModal -->
                    </div>
                     @endif
                   <label>Date:</label>
                    <input class="form-control" id="sd-tenant-date-{{ $offer->buyer_id+7 }}" readonly="readonly" value="{{ !empty($matchedTenantSignature)?date_format($matchedTenantSignature->created_at,'Y-m-d'):"" }}">
                    <label>Time:</label>
                    <input class="form-control" id="sd-tenant-time-{{ $offer->buyer_id+7 }}" readonly="readonly" value="{{ !empty($matchedTenantSignature)?date_format($matchedTenantSignature->created_at,'H:i a'):"" }}">
                    <label>IP ADDRESS:</label>
                    <input class="form-control" id="sd-tenant-ip-{{ $offer->buyer_id+7 }}" readonly="readonly" value="{{ $matchedTenantSignature->ip??"" }}">
                </div>
                    @else
                    <div class="form-group">
                        <label>TENANT NAME:</label>
                        @if(!empty($signatureArray[1][0]))
                        <input id="main-buyer-name" class="form-control" value="{{$signatureArray[1][0]}}" readonly="readonly">
                        @else
                         <input id="main-buyer-name" class="form-control" value="<?php
                        if (isset($offer->tenant->user_profile) && $offer->tenant->user_profile) {
                            echo $offer->tenant->user_profile->first_name . " " . $offer->tenant->user_profile->middle_name . " " . $offer->tenant->user_profile->last_name;
                        } else {
                            echo getFullName($offer->tenant);
                        }
                        ?>" readonly="readonly">
                        @endif
                    <label>TENANT SIGNATURE :</label>
                    <input class="form-control intro buyer-frst-sign" id="sd-tenant-signature-{{ $offer->buyer_id+7 }}" readonly="readonly" value="<?php if(isset($offer->rentSignatures) && count($offer->rentSignatures)>0){
                        foreach($offer->rentSignatures as $tenantSignature) {
                            if($tenantSignature->user_id == $offer->buyer_id) {
                                echo $tenantSignature->signature;
                                $matchedTenantSignature = $tenantSignature;
                                    }
                                }
                                } ?>" style="color:#ff0000;">
                    <span class="error buyer-sign-error">Please fill this field</span>
                    <!-- signature-modal -->
                    @if(Auth::id() == $offer->tenant->id && !in_array(Auth::id(), array_column($offer->rentSignatures->toArray(), 'user_id')))
                    <div class="signature">
                        <button type="button" class="btn btn-info btn-lg signature-button" data-toggle="modal" data-target="#myModal-{{ $offer->buyer_id+7 }}">Affix Signature</button>
                        <!-- Modal -->
                        <div id="myModal-{{$offer->buyer_id+7}}" class="modal fade dashboard-page" role="dialog">
                            <div class="modal-dialog">
                                <!-- Modal content-->
                                <div class="modal-content signature-model">
                                    <h4 class="modal-title">freezylist.lusites.xyz says</h4>
                                    <p class="m-zero">By affixing your digital signature, you are signing this document. Please confirm your signature</p>
                                    <div class="btns-green-blue text-center small-buttons">
                                        <button type="button" id="sd-tenant-signature-ok-{{$offer->buyer_id+7}}" class="button btn btn-green" data-dismiss="modal" onclick="addSignature({{$offer->buyer_id}})">Ok</button>
                                        <button type="button" class="button btn btn-blue" data-dismiss="modal">Cancel</button>
                                    </div>
                                </div>
                            </div><!-- modal-dialog -->
                        </div><!-- myModal -->
                    </div>
                    @endif
                    <label>Date:</label>
                    <input class="form-control" id="sd-tenant-date-{{ $offer->buyer_id+7 }}" readonly="readonly" value="{{ !empty($matchedTenantSignature)?date_format($matchedTenantSignature->created_at,'Y-m-d'):"" }}">
                    <label>Time:</label>
                    <input class="form-control" id="sd-tenant-time-{{ $offer->buyer_id+7 }}" readonly="readonly" value="{{ !empty($matchedTenantSignature)?date_format($matchedTenantSignature->created_at,'H:i a'):"" }}">
                    <label>IP ADDRESS:</label>
                    <input class="form-control" id="sd-tenant-ip-{{ $offer->buyer_id+7 }}" readonly="readonly" value="{{ $matchedTenantSignature->ip??"" }}">
                </div>
               @endif
                <?php if(!empty($offer->tenantQuestionnaire->partners)) {
                    $allPartners = explode(',',$offer->tenantQuestionnaire->partners);
                    foreach($allPartners as $partner){
                        $partnerProfile = getOfferPartnerProfile($partner,$offer->id);
                    ?>
               <hr>
                <div class="col-md-12 form-group" style="padding-top: 15px;" id="partners-signature-{{$partnerProfile->id+7}}">
                        <label>TENANT NAME:</label>
                        <input id="sd-tenant-name-<?= $partnerProfile->id + 7; ?>" class="form-control" value="<?php
                        if (isset($partnerProfile->rentSignature->fullname)){
                            echo $partnerProfile->rentSignature->fullname;
                        } else {
                            echo getFullName($partnerProfile);
                        }
                        ?> " readonly="readonly">
                        <label>TENANT SIGNATURE:</label>
                        <input id="sd-tenant-signature-<?= $partnerProfile->id + 7; ?>" class="form-control intro buyer-frst-sign" readonly="readonly" value="<?php
                        if(isset($offer->rentSignatures) && count($offer->rentSignatures) > 0) {
                            $matchedPartnerSignature='';
			    foreach($offer->rentSignatures as $partnerSigns){
//                        dump($partnerSigns);
                          if ($partnerProfile->id == $partnerSigns->user_id && $partnerSigns->signature_type == $type) {
                                    echo $partnerSigns->signature;
                                    $matchedPartnerSignature = $partnerSigns;
                                }
                            }
                        }
                        ?>"  style="color:#ff0000;">
                        <span class="error buyer-sign-error">Please fill this field</span>
			
                        <!-- signature-modal -->
                          @if(empty($matchedPartnerSignature) && Auth::id()==$partner)   
                        <div class="signature">
                            <button type="button" class="btn btn-info btn-lg signature-button" data-toggle="modal" data-target="#myModal-<?= $partnerProfile->id + 7 ?>">Affix Signature</button>
                            <!-- Modal -->
                            <div id="myModal-<?= $partnerProfile->id + 7 ?>" class="modal fade dashboard-page" role="dialog">
                                <div class="modal-dialog">
                                    <!-- Modal content-->
                                    <div class="modal-content signature-model">
                                        <h4 class="modal-title">freezylist.lusites.xyz says</h4>
                                        <p class="m-zero">By affixing your digital signature, you are signing this document. Please confirm your signature</p>
                                        <div class="btns-green-blue text-center small-buttons">
                                            <button type="button" class="button btn btn-green" id="sd-tenant-signature-ok-<?= $partnerProfile->id + 7 ?>" onclick="addSignature({{$partnerProfile->id}})" data-dismiss="modal">Ok</button>
                                            <button type="button" class="button btn btn-blue" data-dismiss="modal">Cancel</button>
                                        </div>
                                    </div>
                                </div><!-- modal-dialog -->
                            </div><!-- myModal -->
                        </div>
                        @endif
                        <label>Date:</label>
                        <input class="form-control" id="sd-tenant-date-<?= $partnerProfile->id + 7 ?>" readonly="readonly" value="{{ (isset($matchedPartnerSignature) && $matchedPartnerSignature) ? date_format($matchedPartnerSignature->created_at,'Y-m-d'):"" }}">
                        <label>Time:</label>
                        <input class="form-control" id="sd-tenant-time-<?= $partnerProfile->id + 7 ?>" readonly="readonly" value="{{ (isset($matchedPartnerSignature) && $matchedPartnerSignature) ? date_format($matchedPartnerSignature->created_at,'H:i a'):"" }}">
                        <label>IP ADDRESS:</label>
                        <input class="form-control" id="sd-tenant-ip-<?= $partnerProfile->id + 7 ?>" readonly="readonly" value="{{ (isset($matchedPartnerSignature) && $matchedPartnerSignature) ? $matchedPartnerSignature->ip:"" }}">
                    </div>
                <?php } }?>
            </div>
        </div>
    </div>
    @if(isset($disclosureExtraData))
        <p>Tenant understands that this Disclosure is not intended as a substitute for any inspection, and that tenant has a responsibility to pay diligent attention to and inquire about defects which are evident by careful observation. Buyer acknowledges receipt of a copy of this Disclosure.</p>
    @endif
    <div class="col-md-12 col-xs-12 col-sm-12 col-lg-12">
        <div class="heading-text-landlord">
            <h3>LANDLORD DETAILS:</h3>
        </div>
        <div class="landlord-details">
            <div class="landlord-details-div">
                <div class="form-group">
                    <label>LANDLORD NAME :</label>
                    @if(!empty($signatureArray[2][0]))
                    <input class="form-control" id="main-seller-name" value="{{$signatureArray[2][0]}}" readonly="readonly">
                    @else
                    <input class="form-control" id="main-landlord-name" value="<?php
                    if(isset($offer->landlord->user_profile) && $offer->landlord->user_profile) {
                        $firstName  = $offer->landlord->user_profile->first_name;
                        $middleName = $offer->landlord->user_profile->middle_name??"";
                        $lastName   = $offer->landlord->user_profile->last_name;
                        echo $firstName." ".$middleName." ".$lastName;
                    } else {
                        echo getFullName($offer->landlord);
                    }
                    ?>" readonly="readonly">
                    @endif
                    <label>LANDLORD SIGNATURE:</label>
                    <input class="form-control intro seller-frst-sign" id="sd-tenant-signature-{{$offer->owner_id+7 }}" readonly="readonly" value="<?php if(isset($offer->rentSignatures) && count($offer->rentSignatures)>0){
                        foreach($offer->rentSignatures as $landlordSignature) {
                            if($landlordSignature->user_id == $offer->owner_id && $landlordSignature->signature_type == $type) {
                                echo $landlordSignature->signature;
                                $matchedLandlordSignature = $landlordSignature;
                                    }
                                }
                            } ?>"  style="color:#ff0000;">
                    <span class="error seller-sign-error">Please fill this field</span>
                           @if(empty($matchedLandlordSignature) && Auth::id() == $offer->owner_id)
                    <div class="signature">
                        <button type="button" class="btn btn-info btn-lg signature-button" data-toggle="modal" data-target="#myModal-{{ $offer->owner_id+7 }}">Affix Signature</button>
                        <!-- Modal -->
                        <div id="myModal-{{ $offer->owner_id+7 }}" class="modal fade dashboard-page" role="dialog">
                            <div class="modal-dialog">
                                <!-- Modal content-->
                                <div class="modal-content signature-model">
                                    <h4 class="modal-title">freezylist.lusites.xyz says</h4>
                                    <p class="m-zero">By affixing your digital signature, you are signing this document. Please confirm your signature</p>
                                    <div class="btns-green-blue text-center small-buttons">
                                        <button type="button" id="sd-tenant-signature-ok-<?= $offer->owner_id + 7 ?>" class="button btn btn-green" data-dismiss="modal" onclick="addSignature({{$offer->owner_id}})">Ok</button>
                                        <button type="button" class="button btn btn-blue" data-dismiss="modal">Cancel</button>
                                    </div>
                                </div>
                            </div><!-- modal-dialog -->
                        </div><!-- myModal -->
                    </div>
                    @endif
                    <label>Date:</label>
                    <input class="form-control" id="sd-tenant-date-{{$offer->owner_id+7}}" readonly="readonly" value="{{ (isset($matchedLandlordSignature) && $matchedLandlordSignature) ? date_format($matchedLandlordSignature->created_at,'Y-m-d'):"" }}">
                    <label>Time:</label>
                    <input class="form-control" id="sd-tenant-time-{{$offer->owner_id+7}}" readonly="readonly" value="{{ (isset($matchedLandlordSignature) && $matchedLandlordSignature) ? date_format($matchedLandlordSignature->created_at,'H:i a'):"" }}">
                    <label>IP ADDRESS:</label>
                    <input class="form-control" id="sd-tenant-ip-{{$offer->owner_id+7}}" readonly="readonly" value="{{ (isset($matchedLandlordSignature) && $matchedLandlordSignature) ? $matchedLandlordSignature->ip:"" }}">
                </div>
            </div>
        </div>
    </div>
    <?php if(!empty($offer->landlordQuestionnaire->partners)) {
        $allLandLoardPartners = explode(',',$offer->landlordQuestionnaire->partners);
        foreach($allLandLoardPartners as $landlordpartner){
            $landlordPartnerProfile = getOfferPartnerProfile($landlordpartner,$offer->id);
        ?>
    <div class="col-md-12 col-xs-12 col-sm-12 col-lg-12">
        <div class="form-group">
            <hr>
                <label>LANDLORD NAME:</label>
                <input id="sd-landlord-name-<?= $landlordPartnerProfile->id + 7; ?>" class="form-control" value="<?php
                if (isset($landlordPartnerProfile->rentSignature->fullname)) {
                     echo $landlordPartnerProfile->rentSignature->fullname;
                } else {
                    echo getFullName($landlordPartnerProfile);
                }
                ?> " readonly="readonly">
                <label>LANDLORD SIGNATURE:</label>
                <input id="sd-tenant-signature-<?= $landlordPartnerProfile->id + 7;?>" class="form-control intro seller-frst-sign" readonly="readonly" value="<?php
                        if(isset($offer->rentSignatures) && count($offer->rentSignatures) > 0) {
                            $matchedLandlordPartnerSignature='';
                            foreach($offer->rentSignatures as $landlordPartnerSigns){
//                        dump($partnerSigns);
                                if($landlordPartnerProfile->id == $landlordPartnerSigns->user_id && $landlordPartnerSigns->signature_type == $type){
                                    echo $landlordPartnerSigns->signature;
                                    $matchedLandlordPartnerSignature = $landlordPartnerSigns;
                                }
                            }
                        }
                        ?>"  style="color:#ff0000;">
                <span class="error seller-sign-error">Please fill this field</span>
                <!-- signature-modal -->
                @if(empty($matchedLandlordPartnerSignature) && Auth::id()== $landlordpartner)
                <div class="signature">
                    <button type="button" class="btn btn-info btn-lg signature-button" data-toggle="modal" data-target="#myModal-<?= $landlordPartnerProfile->id + 7; ?>">Affix Signature</button>
                    <!-- Modal -->
                    <div id="myModal-<?= $landlordPartnerProfile->id + 7; ?>" class="modal fade dashboard-page" role="dialog">
                        <div class="modal-dialog">
                            <!-- Modal content-->
                            <div class="modal-content signature-model">
                                <h4 class="modal-title">freezylist.lusites.xyz says</h4>
                                <p class="m-zero">By affixing your digital signature, you are signing this document. Please confirm your signature</p>
                                <div class="btns-green-blue text-center small-buttons">
                                    <button type="button" class="button btn btn-green" id="sd-tenant-signature-ok-<?= $landlordPartnerProfile->id + 7; ?>" data-dismiss="modal" onclick="addSignature({{$landlordPartnerProfile->id}})">Ok</button>
                                    <button type="button" class="button btn btn-blue" data-dismiss="modal">Cancel</button>
                                </div>
                            </div>
                        </div><!-- modal-dialog -->
                    </div><!-- myModal -->
                </div>
                @endif
                <label>Date:</label>
                <input class="form-control" id="sd-tenant-date-<?= $landlordPartnerProfile->id + 7; ?>" readonly="readonly" value="{{ (isset($matchedLandlordPartnerSignature) && $matchedLandlordPartnerSignature) ? date_format($matchedLandlordPartnerSignature->created_at,'Y-m-d'):"" }}">
                <label>Time:</label>
                <input class="form-control" id="sd-tenant-time-<?= $landlordPartnerProfile->id + 7; ?>" readonly="readonly" value="{{ (isset($matchedLandlordPartnerSignature) && $matchedLandlordPartnerSignature) ? date_format($matchedLandlordPartnerSignature->created_at,'H:i a'):"" }}">
                <label>IP ADDRESS:</label>
                <input class="form-control" id="sd-tenant-ip-<?= $landlordPartnerProfile->id + 7; ?>" readonly="readonly" value="{{ (isset($matchedLandlordPartnerSignature) && $matchedLandlordPartnerSignature) ? $matchedLandlordPartnerSignature->ip:"" }}">
            </div>
        </div>
    <?php } } ?>
</div>