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
<div class="lease-agreement-inner-box" style="page-break-before:always;">
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
                    <input id="main-buyer-name" class="form-control" value="{{!empty($signatureArray[1][0])?$signatureArray[1][0]:''}}" readonly="readonly">
                    <label>BUYER SIGNATURE:</label>
                    <input class="form-control intro" id="sd-buyer-signature-{{ $offer->sender_id+7 }}" readonly="readonly" value="<?php
                    if (isset($offer->signatures) && count($offer->signatures) > 0 && empty($type)) {
                        $matchedBuyerSignature='';
                         $have = [];
                        foreach ($offer->signatures as $buyerSignature) {
                            if ($buyerSignature->user_id == $offer->sender_id) {
                                $test = $buyerSignature->user_id;
                                if(!in_array( $test, $have) ){
                                echo $buyerSignature->signature;
                                $matchedBuyerSignature = $buyerSignature;
                                 $have[] = $test; 
                                    
                                }
                            }
                        }
                    }
                    ?>" style="color:#ff0000;">
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
                    foreach ($allPartners as $index => $partner) {
                          $partnerProfile = getOfferPartnerProfile($partner,$offer->id);
                        ?>
                        <?php if ($index % 2 != 0 && $index !== 0) {
                            ?>
                            <hr style="margin-top:30px;margin-bottom:30px;page-break-after:always;">
                            <?php
                        } else {
                            ?>
                            <hr style="margin-top:30px;margin-bottom:30px;">
                            <?php
                        }
                       
                        ?>
                        <div class="form-group" style=" padding-top: 15px;" id="partners-signature-{{$partnerProfile->id+7}}">
                            <label>BUYER NAME:</label>
                            <input id="sd-buyer-name-<?= $partnerProfile->id + 7; ?>" class="form-control" value="<?php
                                if (!empty($partnerProfile->signature['fullname'])) {
                                   echo $partnerProfile->signature['fullname'];
                                } else {
                                    echo getFullName($partnerProfile);
                                }
                                ?> 
                            " readonly="readonly">


                            <label>BUYER SIGNATURE:</label>
                            <input id="sd-buyer-signature-<?= $partnerProfile->id + 7; ?>" class="form-control intro" readonly="readonly" value=" <?php
                            if (isset($offer->signatures) && count($offer->signatures) > 0 && empty($type)) {
                                 $matchedPartnerSignature ='';
                                  $have = [];
                                foreach ($offer->signatures as $partnerSigns) {
                                     
                                    //                        dump($partnerSigns);
                                    if ($partnerProfile->id == $partnerSigns->user_id) {
                                        $test = $buyerSignature->user_id;
                                         if(!in_array( $test, $have) ){
                                        echo $partnerSigns->signature;
                                        $matchedPartnerSignature = $partnerSigns;
                                        $have[]=$test;
                                         }
                                    }
                                }
                            }
                            ?>"  style="color:#ff0000;">
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
    <div class="col-md-12 col-xs-12 col-sm-12 col-lg-12" style="page-break-before:always;">
        <div class="heading-text-seller">
            <h3>SELLER DETAILS:</h3>
        </div>
        <div class="seller-details">
            <div class="seller-details-div">
                <div class="form-group">
                    <label>SELLER NAME:</label>
                    <input class="form-control" id="main-seller-name" value="{{ $signatureArray[2][0]}}" readonly="readonly">
                    <label>SELLER SIGNATURE:</label>
                    <input class="form-control intro" id="sd-buyer-signature-{{ $offer->owner_id+7 }}" readonly="readonly" value="<?php
                    if (isset($offer->signatures) && count($offer->signatures) > 0 && empty($type)) {
                        $matchedSellerSignature='';
                        $have = [];
                        foreach ($offer->signatures as $sellerSignature) {
                            if ($sellerSignature->user_id == $offer->owner_id) {
                                $test = $sellerSignature->user_id;
                                if(!in_array( $test, $have) ){
                                echo $sellerSignature->signature;
                                $matchedSellerSignature = $sellerSignature;
                                $have[] = $test; 
                                }
                            }
                        }
                    }
                    ?>"  style="color:#ff0000;">
        
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
        foreach ($allPartners as $index => $partner) {
           $sellerPartnerProfile = getOfferPartnerProfile($partner,$offer->id);
            ?>
            <?php if ($index % 2 != 0 && $index !== 0) {
                ?>
                <hr style="margin-top:30px;margin-bottom:30px;page-break-after:always;">
                <?php
            } else {
                ?>
                <hr style="margin-top:30px;margin-bottom:30px;">
                <?php
            }
            
            ?>
            <div class="col-md-12 form-group">
                <label>SELLER NAME:</label>
                <input id="sd-seller-name-<?= $sellerPartnerProfile->id + 7; ?>" class="form-control margin-bottom" value="<?php
                if (isset($sellerPartnerProfile->user_profile) && $sellerPartnerProfile->user_profile) {
                    echo $sellerPartnerProfile->user_profile->electronic_signature;
                } else {
                    echo getFullName($sellerPartnerProfile);
                }
                ?> " readonly="readonly">
                <label>SELLER SIGNATURE:</label>
                <input id="sd-buyer-signature-<?= $sellerPartnerProfile->id + 7; ?>" class="form-control intro margin-bottom" readonly="readonly" value="{{ (isset($sellerPartnerProfile->signature) && $sellerPartnerProfile->signature && empty($type)) ? $sellerPartnerProfile->signature->signature:"" }}"  style="color:#ff0000;">
                <label>Date:</label>
                <input class="form-control margin-bottom"id="-<?= $sellerPartnerProfile->id + 7; ?>" readonly="readonly" value="{{ (isset($sellerPartnerProfile->signature) && $sellerPartnerProfile->signature && empty($type)) ? date_format($sellerPartnerProfile->signature->created_at,'Y-m-d'):"" }}">
                <label>Time:</label>
                <input class="form-control margin-bottom" id="-<?= $sellerPartnerProfile->id + 7; ?>" readonly="readonly" value="{{ (isset($sellerPartnerProfile->signature) && $sellerPartnerProfile->signature && empty($type)) ? date_format($sellerPartnerProfile->signature->created_at,'H:i a'):"" }}">
                <label>IP ADDRESS:</label>
                <input class="form-control margin-bottom" id="-<?= $sellerPartnerProfile->id + 7; ?>" readonly="readonly" value="{{ (isset($sellerPartnerProfile->signature) && $sellerPartnerProfile->signature && empty($type)) ? $sellerPartnerProfile->signature->ip:"" }}">
            </div>
            <?php
        }
    }
    ?>
</div>