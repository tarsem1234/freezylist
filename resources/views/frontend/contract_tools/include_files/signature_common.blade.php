<div class="lease-agreement-inner-box">
    <div class="buyer-main">
        <div class="col-md-12 col-xs-12 col-sm-12 col-lg-12">
            <div class="heading-text-buyer">
                <h3>BUYER DETAILS:</h3>
            </div>
        </div>
        <div class="col-md-12">
            <div class="buyer-details">
                <div class="buyer-details-div">
                     <?php
                    $signatureArray = [];
                    $sellersArray = [];
                    if(!empty($offer->signatures)){
                    foreach ($offer->signatures as $sign) {
                        $signatureArray[$sign['type']][] = $sign['fullname'];
                        $signatureArray['signature'][$sign['type']] = $sign['signature'];
                    }
                    }
//                    echo'<pre>';print_R($signatureArray);die;
                    ?>
                    @if($offer->signatures->isNotEmpty())
                
                    <div class="form-group">
                        <label>BUYER NAME:</label>
                        <input id="main-buyer-name" class="form-control" value="{{!empty($signatureArray[1][0])?$signatureArray[1][0]:''}}" readonly="readonly">
                        <label>BUYER SIGNATURE:</label>
                        <input class="form-control intro buyer-frst-sign" id="sd-buyer-signature-{{ $offer->sender_id+7 }}" readonly="readonly" value="<?php
                        if (isset($offer->signatures) && count($offer->signatures) > 0) {
                            foreach ($offer->signatures as $buyerSignature) {
                                if ($buyerSignature->user_id == $offer->sender_id && isset($buyerSignature->signature_type) && $buyerSignature->signature_type== $type) {
                                    echo $buyerSignature->signature;
                                    $matchedBuyerSignature = $buyerSignature;
                                }
                            }
                        }
                        ?>" style="color:#ff0000;">
                        <span class="error buyer-sign-error">Please fill this field</span>
                        <!-- signature-modal -->
                 
                          @if(Auth::id() == $offer->buyer->id && empty($matchedBuyerSignature))
                        
                        <div class="signature">
                            <button type="button" class="btn btn-info btn-lg signature-button" data-toggle="modal" data-target="#myModal-{{ $offer->sender_id+7 }}">Affix Signature</button>
                            <!-- Modal -->
                            <div id="myModal-{{ $offer->sender_id+7 }}" class="modal fade dashboard-page" role="dialog">
                                <div class="modal-dialog">
                                    <!-- Modal content-->
                                    <div class="modal-content signature-model">
                                        <h4 class="modal-title">freezylist.lusites.xyz says</h4>
                                        <p class="m-zero">By affixing your digital signature, you are signing this document. Please confirm your signature</p>
                                        <div class="btns-green-blue text-center small-buttons">
                                            <button type="button" id="sd-buyer-signature-ok-{{$offer->sender_id+7}}" class="button btn btn-green" data-dismiss="modal" onclick="addSignature({{$offer->sender_id}})">Ok</button>
                                            <button type="button" class="button btn btn-blue" data-dismiss="modal">Cancel</button>
                                        </div>
                                    </div>
                                </div><!-- modal-dialog -->
                            </div><!-- myModal -->
                        </div>
                        @endif
                        <label>Date:</label>
                        <input class="form-control" id="sd-buyer-date-{{ $offer->sender_id+7 }}" readonly="readonly" value="{{ isset($matchedBuyerSignature)?date_format($matchedBuyerSignature->created_at,'Y-m-d'):"" }}">
                        <label>Time:</label>
                        <input class="form-control" id="sd-buyer-time-{{ $offer->sender_id+7 }}" readonly="readonly" value="{{ isset($matchedBuyerSignature)?date_format($matchedBuyerSignature->created_at,'H:i a'):"" }}">
                        <label>IP ADDRESS:</label>
                        <input class="form-control" id="sd-buyer-ip-{{ $offer->sender_id+7 }}" readonly="readonly" value="{{ $matchedBuyerSignature->ip??"" }}">
                    </div>
                    @else
                    <div class="form-group">
                        <label>BUYER NAME:</label>
                        @if(!empty($signatureArray[1][0]))
                        <input id="main-buyer-name" class="form-control" value="{{$signatureArray[1][0]}}" readonly="readonly">
                        @else
                         <input id="main-buyer-name" class="form-control" value="<?php
                        if (isset($offer->buyer->user_profile) && $offer->buyer->user_profile) {
                            echo $offer->buyer->user_profile->first_name . " " . $offer->buyer->user_profile->middle_name . " " . $offer->buyer->user_profile->last_name;
                        } else {
                            echo getFullName($offer->buyer);
                        }
                        ?>" readonly="readonly">
                        @endif
                        
                        <label>BUYER SIGNATURE:</label>
                        <input class="form-control intro buyer-frst-sign" id="sd-buyer-signature-{{ $offer->sender_id+7 }}" readonly="readonly" value="<?php
                        if (isset($offer->signatures) && count($offer->signatures) > 0) {
//                            $getSignature = [];
                            foreach ($offer->signatures as $buyerSignature) {
                                if ($buyerSignature->user_id == $offer->sender_id && $buyerSignature->signature_type==$type) {
                                    echo $buyerSignature->signature;
                                    $matchedBuyerSignature = $buyerSignature;
                                }
                            }
                        }
                        ?>" style="color:#ff0000;">
                        <span class="error buyer-sign-error">Please fill this field</span>
                        <!-- signature-modal -->
                         @if(Auth::id() == $offer->buyer->id && empty($matchedBuyerSignature))
                        <div class="signature">
                            <button type="button" class="btn btn-info btn-lg signature-button" data-toggle="modal" data-target="#myModal-{{ $offer->sender_id+7 }}">Affix Signature</button>
                            <!-- Modal -->
                            <div id="myModal-{{ $offer->sender_id+7 }}" class="modal fade dashboard-page" role="dialog">
                                <div class="modal-dialog">
                                    <!-- Modal content-->
                                    <div class="modal-content signature-model">
                                        <h4 class="modal-title">freezylist.lusites.xyz says</h4>
                                        <p class="m-zero">By affixing your digital signature, you are signing this document. Please confirm your signature</p>
                                        <div class="btns-green-blue text-center small-buttons">
                                            <button type="button" id="sd-buyer-signature-ok-{{$offer->sender_id+7}}" class="button btn btn-green" data-dismiss="modal" onclick="addSignature({{$offer->sender_id}})">Ok</button>
                                            <button type="button" class="button btn btn-blue" data-dismiss="modal">Cancel</button>
                                        </div>
                                    </div>
                                </div><!-- modal-dialog -->
                            </div><!-- myModal -->
                        </div>
                        @endif
                        <label>Date:</label>
                        <input class="form-control" id="sd-buyer-date-{{ $offer->sender_id+7 }}" readonly="readonly" value="{{ isset($matchedBuyerSignature)?date_format($matchedBuyerSignature->created_at,'Y-m-d'):"" }}">
                        <label>Time:</label>
                        <input class="form-control" id="sd-buyer-time-{{ $offer->sender_id+7 }}" readonly="readonly" value="{{ isset($matchedBuyerSignature)?date_format($matchedBuyerSignature->created_at,'H:i a'):"" }}">
                        <label>IP ADDRESS:</label>
                        <input class="form-control" id="sd-buyer-ip-{{ $offer->sender_id+7 }}" readonly="readonly" value="{{ $matchedBuyerSignature->ip??"" }}">
                    </div>
                    @endif
                    <?php
                     //dd($offer->buyerQuestionnaire);
                    if (!empty($offer->buyerQuestionnaire->partners)) {
                        $allPartners = explode(',', $offer->buyerQuestionnaire->partners);
                        foreach ($allPartners as $partner) {
                            $partnerProfile = getOfferPartnerProfile($partner,$offer->id);
//                            echo'<pre>';
//                            dump($partnerProfile->signatures);die;
                            
                            
                            ?>
                            <div class="form-group" style="padding-top: 15px;" id="partners-signature-{{$partnerProfile->id+7}}">
                                <label>BUYER NAME:</label>
                                <input id="sd-buyer-name-<?= $partnerProfile->id + 7; ?>" class="form-control" value="<?php
                                if (!empty($partnerProfile->signature['fullname'])) {
                                   echo $partnerProfile->signature['fullname'];
                                } else {
                                    echo getFullName($partnerProfile);
                                }
                                ?> " readonly="readonly">
                                <label>BUYER SIGNATURE:</label>
                                <input id="sd-buyer-signature-<?= $partnerProfile->id + 7; ?>" class="form-control intro buyer-frst-sign" readonly="readonly" value="<?php
                                $matchedPartnerSignature='';
                                if (!empty($offer->signatures) && count($offer->signatures) > 0) {
                                    $matchedPartnerSignature='';
                                    foreach ($offer->signatures as $partnerSigns) {
                                        if ($partnerProfile->id == $partnerSigns->user_id && $partnerSigns->signature_type == $type) {
                                            echo $partnerSigns->signature;
                                            $matchedPartnerSignature = $partnerSigns;
                                        }
                                    }
                                }
//                                echo $matchedPartnerSignature;
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
                                                    <button type="button" class="button btn btn-green" id="sd-buyer-signature-ok-<?= $partnerProfile->id + 7 ?>" onclick="addSignature({{$partnerProfile->id}})" data-dismiss="modal">Ok</button>
                                                    <button type="button" class="button btn btn-blue" data-dismiss="modal">Cancel</button>
                                                </div>
                                            </div>
                                        </div><!-- modal-dialog -->
                                    </div><!-- myModal -->
                                </div>
                                @endif
                                <label>Date:</label>
                                <?php //die('dd');?>
                                <input class="form-control" id="sd-buyer-date-<?= $partnerProfile->id + 7 ?>" readonly="readonly" value="{{ (!empty($matchedPartnerSignature) && $matchedPartnerSignature->created_at) ? date_format($matchedPartnerSignature->created_at,'Y-m-d'):"" }}">
                                <label>Time:</label>
                                <input class="form-control" id="sd-buyer-time-<?= $partnerProfile->id + 7 ?>" readonly="readonly" value="{{ (!empty($matchedPartnerSignature) && $matchedPartnerSignature->created_at) ? date_format($matchedPartnerSignature->created_at,'H:i a'):"" }}">
                                <label>IP ADDRESS:</label>
                                <input class="form-control" id="sd-buyer-ip-<?= $partnerProfile->id + 7 ?>" readonly="readonly" value="{{ (!empty($matchedPartnerSignature) && $matchedPartnerSignature->ip) ? $matchedPartnerSignature->ip:"" }}">
                            </div>
                            <?php
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12 col-xs-12 col-sm-12 col-lg-12">
        <div class="heading-text-seller">
            <h3>SELLER DETAILS:</h3>
        </div>
        <div class="seller-details">
            <div class="seller-details-div">
                <div class="form-group">
                    <label>SELLER NAME:</label>
                    @if(!empty($signatureArray[2][0]))
                    <input class="form-control" id="main-seller-name" value="{{ $signatureArray[2][0]}}" readonly="readonly">
                    @else
                    <input class="form-control" id="main-seller-name" value="<?php
                    if (isset($offer->seller->user_profile) && $offer->seller->user_profile) {
                        echo $offer->seller->user_profile->first_name . " " . $offer->seller->user_profile->middle_name. " " . $offer->seller->user_profile->last_name;
                    } else {
                        echo getFullName($offer->seller);
                    }
                    ?>" readonly="readonly">
                    @endif
                    <label>SELLER SIGNATURE:</label>
                    <input class="form-control intro seller-frst-sign" id="sd-buyer-signature-{{ $offer->owner_id+7 }}" readonly="readonly" value="<?php
                    if (isset($offer->signatures) && count($offer->signatures) > 0) {
                        $matchedSellerSignature='';
                        foreach ($offer->signatures as $sellerSignature) {
//                            echo'<pre>';print_R($offer->signatures);die;
                            if ($sellerSignature->user_id == $offer->owner_id &&  $sellerSignature->signature_type == $type) {
                                echo $sellerSignature->signature;
                                $matchedSellerSignature = $sellerSignature;
                            }
                        }
                    }
                    ?>"  style="color:#ff0000;">
                    <span class="error seller-sign-error">Please fill this field</span>
                    @if(empty($matchedSellerSignature) && Auth::id() == $offer->owner_id)
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
                                        <button type="button" id="sd-buyer-signature-ok-{{$offer->owner_id+7}}" class="button btn btn-green" data-dismiss="modal" onclick="addSignature({{$offer->owner_id}})">Ok</button>
                                        <button type="button" class="button btn btn-blue" data-dismiss="modal">Cancel</button>
                                    </div>
                                </div>
                            </div><!-- modal-dialog -->
                        </div><!-- myModal -->
                    </div>
                    @endif
                    <label>Date:</label>
                    <input class="form-control" id="sd-buyer-date-{{$offer->owner_id+7}}" readonly="readonly" value="{{ (!empty($matchedSellerSignature) && $matchedSellerSignature->created_at) ? date_format($matchedSellerSignature->created_at,'Y-m-d'):"" }}">
                    <label>Time:</label>
                    <input class="form-control" id="sd-buyer-time-{{$offer->owner_id+7}}" readonly="readonly" value="{{ (!empty($matchedSellerSignature) && $matchedSellerSignature->created_at) ? date_format($matchedSellerSignature->created_at,'H:i a'):"" }}">
                    <label>IP ADDRESS:</label>
                    <input class="form-control" id="sd-buyer-ip-{{$offer->owner_id+7}}" readonly="readonly" value="{{ (!empty($matchedSellerSignature) && $matchedSellerSignature->ip) ? $matchedSellerSignature->ip:"" }}">
                </div>
            </div>
        </div>
    </div>


    <?php
    if (!empty($offer->sellerQuestionnaire->partners)) {
        $allPartners = explode(',', $offer->sellerQuestionnaire->partners);
        foreach ($allPartners as $sellerPartner) {
            $sellerPartnerProfile = getOfferPartnerProfile($sellerPartner,$offer->id);
//            dd($sellerPartnerProfile);
//                   {{dd($sellerPartnerProfile->signature)}}
            ?>
            <div class="col-md-12 form-group">
                <hr>
                <label>SELLER NAME:</label>
                <input id="sd-seller-name-<?= $sellerPartnerProfile->id + 7; ?>" class="form-control" value="<?php
                if (!empty($sellerPartnerProfile->signature['fullname'])) {
                    echo $sellerPartnerProfile->signature['fullname'];
                } else {
                    echo getFullName($sellerPartnerProfile); 
                }
                ?> " readonly="readonly">
                <label>SELLER SIGNATURE:</label>
                <input id="sd-buyer-signature-<?= $sellerPartnerProfile->id + 7; ?>" class="form-control intro seller-frst-sign" readonly="readonly" value="<?php
                if (isset($offer->signatures) && count($offer->signatures) > 0) {
                   $matchedSellerPartnerSignature='';
		    foreach ($offer->signatures as $sellerPartnerSigns) {
                        if ($sellerPartnerProfile->id == $sellerPartnerSigns->user_id && $sellerPartnerSigns->signature_type == $type) {
                            echo $sellerPartnerSigns->signature;
                            $matchedSellerPartnerSignature = $sellerPartnerSigns;
                        }
                    }
                }
                ?>" style="color:#ff0000;">
                <span class="error seller-sign-error">Please fill this field</span>
                <!-- signature-modal -->
                @if(empty($matchedSellerPartnerSignature) && Auth::id()== $sellerPartner)
                <div class="signature">
                    <button type="button" class="btn btn-info btn-lg signature-button" data-toggle="modal" data-target="#myModal-<?= $sellerPartnerProfile->id + 7; ?>">Affix Signature</button>
                    <!-- Modal -->
                    <div id="myModal-<?= $sellerPartnerProfile->id + 7; ?>" class="modal fade dashboard-page" role="dialog">
                        <div class="modal-dialog">
                            <!-- Modal content-->
                            <div class="modal-content signature-model">
                                <h4 class="modal-title">freezylist.lusites.xyz says</h4>
                                <p class="m-zero">By affixing your digital signature, you are signing this document. Please confirm your signature</p>
                                <div class="btns-green-blue text-center small-buttons">
                                    <button type="button" class="button btn btn-green" id="sd-buyer-signature-ok-<?= $sellerPartnerProfile->id + 7; ?>" data-dismiss="modal" onclick="addSignature({{$sellerPartnerProfile->id}})">Ok</button>
                                    <button type="button" class="button btn btn-blue" data-dismiss="modal">Cancel</button>
                                </div>
                            </div>
                        </div><!-- modal-dialog -->
                    </div><!-- myModal -->
                </div>
                @endif
                <label>Date:</label>
                <input class="form-control" id="sd-buyer-date-<?= $sellerPartnerProfile->id + 7; ?>" readonly="readonly" value="{{ (!empty($matchedSellerPartnerSignature) && $matchedSellerPartnerSignature->signature) ? date_format($matchedSellerPartnerSignature->created_at,'Y-m-d'):"" }}">
                <label>Time:</label>
                <input class="form-control" id="sd-buyer-time-<?= $sellerPartnerProfile->id + 7; ?>" readonly="readonly" value="{{ (!empty($matchedSellerPartnerSignature) && $matchedSellerPartnerSignature->signature) ? date_format($matchedSellerPartnerSignature->created_at,'H:i a'):"" }}">
                <label>IP ADDRESS:</label>
                <input class="form-control" id="sd-buyer-ip-<?= $sellerPartnerProfile->id + 7; ?>" readonly="readonly" value="{{ (!empty($matchedSellerPartnerSignature) && $matchedSellerPartnerSignature->signature) ? $matchedSellerPartnerSignature->ip:"" }}">
            </div>
            <?php
        }
    }
    ?>
</div>