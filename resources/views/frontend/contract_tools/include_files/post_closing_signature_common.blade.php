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
                    <div class="form-group">
                        <label>BUYER NAME:</label>
                        <input id="main-buyer-name" class="form-control" value="<?php
                        if (isset($offer->buyer->user_profile) && $offer->buyer->user_profile) {
                            echo $offer->buyer->user_profile->first_name . " " . $offer->buyer->user_profile->middle_name??"" . " " . $offer->buyer->user_profile->last_name;
                        } else {
                            echo getFullName($offer->buyer);
                        }
                        ?>" readonly="readonly">
                        <label>BUYER SIGNATURE:</label>
                        <input class="form-control intro buyer-frst-sign" id="sd-buyer-signature-{{ $offer->sender_id+7 }}" readonly="readonly" value="<?php
                        if (isset($offer->signatures) && count($offer->signatures) > 0 && !empty($signature)) {
                            foreach ($offer->signatures as $buyerSignature) {
                                if ($buyerSignature->user_id == $offer->sender_id) {
                                    echo $buyerSignature->signature;
                                    $matchedBuyerSignature = $buyerSignature;
                                }
                            }
                        }
                        ?>" style="color:#ff0000;">
                        <!-- signature-modal -->
                       @if(Auth::id() == $offer->buyer->id && empty($matchedBuyerSignature) && !empty($signature))
                        <div class="signature">
                            <button type="button" class="btn btn-info btn-lg signature-button" data-toggle="modal" data-target="#myModal-{{ $offer->sender_id+7 }}">Affix Signature</button>
                            <!-- Modal -->
                            <div id="myModal-{{ $offer->sender_id+7 }}" class="modal fade dashboard-page" role="dialog">
                                <div class="modal-dialog">
                                    <!-- Modal content-->
                                    <div class="modal-content signature-model">
                                        <h4 class="modal-title">freezylist.lusites.xyz says</h4>
                                        <p class="m-zero">This document is not required to be signed at this time. Due to the implications of this agreement, we recommend deferring the signing of this document until closing, with an attorney present- Please proceed to the next document.</p>
                                        <div class="btns-green-blue text-center small-buttons">
                                            <button type="button" id="sd-buyer-signature-ok-{{$offer->sender_id+7}}" class="button btn btn-green" data-dismiss="modal" onclick="">Ok</button>
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
                    <?php
                    if (!empty($offer->buyerQuestionnaire->partners)) {
                        $allPartners = explode(',', $offer->buyerQuestionnaire->partners);
                        foreach ($allPartners as $partner) {
                            $partnerProfile = getPartnerProfile($partner);
                            ?>
                            <div class="form-group" style="padding-top: 15px;" id="partners-signature-{{$partnerProfile->id+7}}">
                                <label>BUYER NAME:</label>
                                <input id="sd-buyer-name-<?= $partnerProfile->id + 7; ?>" class="form-control" value="<?php
                                if (isset($partnerProfile->user_profile) && $partnerProfile->user_profile) {
                                    echo $partnerProfile->user_profile->first_name . " " . $partnerProfile->user_profile->middle_name??"" . " " . $partnerProfile->user_profile->last_name;
                                } else {
                                    echo getFullName($partnerProfile);
                                }
                                ?> " readonly="readonly">


                                <label>BUYER SIGNATURE:</label>
                                <input id="sd-buyer-signature-<?= $partnerProfile->id + 7; ?>" class="form-control intro buyer-frst-sign" readonly="readonly" value=" <?php
                                if (isset($offer->signatures) && count($offer->signatures) > 0 && !empty($signature) ) {
                                    foreach ($offer->signatures as $partnerSigns) {
                                        if ($partnerProfile->id == $partnerSigns->user_id) {
                                            echo $partnerSigns->signature;
                                            $matchedPartnerSignature = $partnerSigns;
                                        }
                                    }
                                }
                                ?>"  style="color:#ff0000;">
                                <!-- signature-modal -->
                                @if(Auth::id() == $offer->buyer->id && empty($matchedBuyerSignature) && !empty($signature))
                                <div class="signature">
                                    <button type="button" class="btn btn-info btn-lg signature-button" data-toggle="modal" data-target="#myModal-<?= $partnerProfile->id + 7 ?>">Affix Signature</button>
                                    <!-- Modal -->
                                    <div id="myModal-<?= $partnerProfile->id + 7 ?>" class="modal fade dashboard-page" role="dialog">
                                        <div class="modal-dialog">
                                            <!-- Modal content-->
                                            <div class="modal-content signature-model">
                                                <h4 class="modal-title">freezylist.lusites.xyz says</h4>
                                                <p class="m-zero">This document is not required to be signed at this time. Due to the implications of this agreement, we recommend deferring the signing of this document until closing, with an attorney present- Please proceed to the next document.</p>
                                                <div class="btns-green-blue text-center small-buttons">
                                                    <button type="button" class="button btn btn-green" id="sd-buyer-signature-ok-<?= $partnerProfile->id + 7 ?>" onclick="" data-dismiss="modal">Ok</button>
                                                    <button type="button" class="button btn btn-blue" data-dismiss="modal">Cancel</button>
                                                </div>
                                            </div>
                                        </div><!-- modal-dialog -->
                                    </div><!-- myModal -->
                                </div>
                                @endif
                                <label>Date:</label>
                                <input class="form-control" id="sd-buyer-date-<?= $partnerProfile->id + 7 ?>" readonly="readonly" value="{{ (isset($matchedPartnerSignature) && $matchedPartnerSignature) ? date_format($matchedPartnerSignature->created_at,'Y-m-d'):"" }}">
                                <label>Time:</label>
                                <input class="form-control" id="sd-buyer-time-<?= $partnerProfile->id + 7 ?>" readonly="readonly" value="{{ (isset($matchedPartnerSignature) && $matchedPartnerSignature) ? date_format($matchedPartnerSignature->created_at,'H:i a'):"" }}">
                                <label>IP ADDRESS:</label>
                                <input class="form-control" id="sd-buyer-ip-<?= $partnerProfile->id + 7 ?>" readonly="readonly" value="{{ (isset($matchedPartnerSignature) && $matchedPartnerSignature) ? $matchedPartnerSignature->ip:"" }}">
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
                    <input class="form-control" id="main-seller-name" value="<?php
                    if (isset($offer->seller->user_profile) && $offer->seller->user_profile) {
                        echo $offer->seller->user_profile->first_name . " " . $offer->seller->user_profile->middle_name??"" . " " . $offer->seller->user_profile->last_name;
                    } else {
                        echo getFullName($offer->seller);
                    }
                    ?>" readonly="readonly">
                    <label>SELLER SIGNATURE:</label>
                    <input class="form-control intro seller-frst-sign" id="sd-buyer-signature-{{ $offer->owner_id+7 }}" readonly="readonly" value="<?php
                    if (isset($offer->signatures) && count($offer->signatures) > 0 && !empty($signature)) {
                        foreach ($offer->signatures as $sellerSignature) {
                            if ($sellerSignature->user_id == $offer->owner_id) {
                                echo $sellerSignature->signature;
                                $matchedSellerSignature = $sellerSignature;
                            }
                        }
                    }
                    ?>"  style="color:#ff0000;">
                    @if(empty($matchedSellerSignature) && Auth::id() == $offer->owner_id && !empty($signature))
                    <div class="signature">
                        <button type="button" class="btn btn-info btn-lg signature-button" data-toggle="modal" data-target="#myModal-{{ $offer->owner_id+7 }}">Affix Signature</button>
                        <!-- Modal -->
                        <div id="myModal-{{ $offer->owner_id+7 }}" class="modal fade dashboard-page" role="dialog">
                            <div class="modal-dialog">
                                <!-- Modal content-->
                                <div class="modal-content signature-model">
                                    <h4 class="modal-title">freezylist.lusites.xyz says</h4>
                                    <p class="m-zero">This document is not required to be signed at this time. Due to the implications of this agreement, we recommend deferring the signing of this document until closing, with an attorney present- Please proceed to the next document.</p>
                                    <div class="btns-green-blue text-center small-buttons">
                                        <button type="button" id="sd-buyer-signature-ok-{{$offer->owner_id+7}}" class="button btn btn-green" data-dismiss="modal" onclick="">Ok</button>
                                        <button type="button" class="button btn btn-blue" data-dismiss="modal">Cancel</button>
                                    </div>
                                </div>
                            </div><!-- modal-dialog -->
                        </div><!-- myModal -->
                    </div>
                    @endif
                    <label>Date:</label>
                    <input class="form-control" id="sd-buyer-date-{{$offer->owner_id+7}}" readonly="readonly" value="{{ (isset($matchedSellerSignature) && $matchedSellerSignature) ? date_format($matchedSellerSignature->created_at,'Y-m-d'):"" }}">
                    <label>Time:</label>
                    <input class="form-control" id="sd-buyer-time-{{$offer->owner_id+7}}" readonly="readonly" value="{{ (isset($matchedSellerSignature) && $matchedSellerSignature) ? date_format($matchedSellerSignature->created_at,'H:i a'):"" }}">
                    <label>IP ADDRESS:</label>
                    <input class="form-control" id="sd-buyer-ip-{{$offer->owner_id+7}}" readonly="readonly" value="{{ (isset($matchedSellerSignature) && $matchedSellerSignature) ? $matchedSellerSignature->ip:"" }}">
                </div>
            </div>
        </div>
    </div>

    
    <?php
    if (!empty($offer->sellerQuestionnaire->partners)) {
        $allPartners = explode(',', $offer->sellerQuestionnaire->partners);
        foreach ($allPartners as $sellerPartner) {
            $sellerPartnerProfile = getPartnerProfile($sellerPartner);
            ?>
            <div class="col-md-12 form-group">
                <hr>
                <label>SELLER NAME:</label>
                <input id="sd-seller-name-<?= $sellerPartnerProfile->id + 7; ?>" class="form-control" value="<?php
                if (isset($sellerPartnerProfile->user_profile) && $sellerPartnerProfile->user_profile) {
                    echo $sellerPartnerProfile->user_profile->first_name . " " . $sellerPartnerProfile->user_profile->middle_name??"" . " " . $sellerPartnerProfile->user_profile->last_name;
                } else {
                    echo getFullName($sellerPartnerProfile);
                }
                ?> " readonly="readonly">
                <label>SELLER SIGNATURE:</label>
                <input id="sd-buyer-signature-<?= $sellerPartnerProfile->id + 7; ?>" class="form-control intro seller-frst-sign" readonly="readonly" value=" <?php
                                if (isset($offer->signatures) && count($offer->signatures) > 0 && !empty($signature)) {
                                    foreach ($offer->signatures as $sellerPartnerSigns) {
                                        if ($sellerPartnerProfile->id == $sellerPartnerSigns->user_id) {
                                            echo $sellerPartnerSigns->signature;
                                            $matchedSellerPartnerSignature = $sellerPartnerSigns;
                                        }
                                    }
                                }
                                ?>" style="color:#ff0000;">
                <!-- signature-modal -->
                @if(empty($matchedSellerPartnerSignature) && Auth::id()== $sellerPartner && !empty($signature))
                <div class="signature">
                    <button type="button" class="btn btn-info btn-lg signature-button" data-toggle="modal" data-target="#myModal-<?= $sellerPartnerProfile->id + 7; ?>">Affix Signature</button>
                    <!-- Modal -->
                    <div id="myModal-<?= $sellerPartnerProfile->id + 7; ?>" class="modal fade dashboard-page" role="dialog">
                        <div class="modal-dialog">
                            <!-- Modal content-->
                            <div class="modal-content signature-model">
                                <h4 class="modal-title">freezylist.lusites.xyz says</h4>
                                <p class="m-zero">This document is not required to be signed at this time. Due to the implications of this agreement, we recommend deferring the signing of this document until closing, with an attorney present- Please proceed to the next document.</p>
                                <div class="btns-green-blue text-center small-buttons">
                                    <button type="button" class="button btn btn-green" id="sd-buyer-signature-ok-<?= $sellerPartnerProfile->id + 7; ?>" data-dismiss="modal" onclick="">Ok</button>
                                    <button type="button" class="button btn btn-blue" data-dismiss="modal">Cancel</button>
                                </div>
                            </div>
                        </div><!-- modal-dialog -->
                    </div><!-- myModal -->
                </div>
                @endif
                <label>Date:</label>
                <input class="form-control" id="sd-buyer-date-<?= $sellerPartnerProfile->id + 7; ?>" readonly="readonly" value="{{ (isset($matchedSellerPartnerSignature) && $matchedSellerPartnerSignature->signature) ? date_format($matchedSellerPartnerSignature->created_at,'Y-m-d'):"" }}">
                <label>Time:</label>
                <input class="form-control" id="sd-buyer-time-<?= $sellerPartnerProfile->id + 7; ?>" readonly="readonly" value="{{ (isset($matchedSellerPartnerSignature) && $matchedSellerPartnerSignature->signature) ? date_format($matchedSellerPartnerSignature->created_at,'H:i a'):"" }}">
                <label>IP ADDRESS:</label>
                <input class="form-control" id="sd-buyer-ip-<?= $sellerPartnerProfile->id + 7; ?>" readonly="readonly" value="{{ (isset($matchedSellerPartnerSignature) && $matchedSellerPartnerSignature->signature) ? $matchedSellerPartnerSignature->ip:"" }}">
            </div>
            <?php
        }
    }
    ?>
</div>