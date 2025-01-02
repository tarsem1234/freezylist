@extends ('frontend.layouts.app')
@section ('title', ('Update Sale Agreement Byseller Contract'))
@section('after-styles')
<link type="text/css" rel="stylesheet" href="{{ asset(mix('css/contract-tools-buyer.css')) }}" media="all"> 
@endsection
@section('content')
<div class="container purchase-sale-agreement-review contract-tools-seller-common">
    <div class="row">
        <div class=""> 
            <div class="sidebar">
                @include('frontend.includes.sidebar')
            </div>
            <div class="col-md-9 col-sm-8">
                <div class="nested-div register-page"> 
                    <div class="heading-text">
                        <h2>PURCHASE AND SALE AGREEMENT</h2>
                    </div>
                    <div class="para-text row">
                        <form>
                            @if($offer->propertyConditional)
                            <div class="form-group">
                                <div class="col-md-12"> 
                                    <!--combine buyer,cobuyer and seller,coselller--> 
                                    <?php
                                    $buyersArray = [];
                                    $sellersArray = [];
                                    if (!empty($offer->signatures)) {
//                                        echo'<pre>';print_R(array_unique($offer->signatures));die;
                                        foreach ($offer->signatures as $signature) {
//                                    echo'<pre>';print_r((array_unique($signature->toArray())));
                                            if (in_array($signature['type'], [1, 3])) {
                                                $buyersArray[] = $signature['fullname'];
                                            } else {
                                                $sellersArray[] = $signature['fullname'];
                                            }
//                                           
                                        }
                                    }

                                    $buyerDetails = implode(' , ', array_unique($buyersArray));
                                    $sellerDetails = implode(' , ', array_unique($sellersArray));
//                                    
                                    ?>                                    
                                    <h5  class="first-child">(a) BUYER NAME(s):  </h5>
                                    <!--{{$offer->signatures}}-->

                                    <!--{{$offer->signatures}}-->
                                    <input type="text" class="form-control custom_bs_name" value="{{$buyerDetails}}" readonly="readonly">
                                    <h5>(b) SELLER NAME(s):  </h5>
                                    <input type="text" class="form-control custom_bs_name" value="{{$sellerDetails}}" readonly="readonly">

                                    <h5>(c) PROPERTY ADDRESS and/or DESCRIPTION:</h5>
                                    <p>Buyer agrees to purchase and Seller agrees to sell the real property identified as:</p>
                                    <div class="form-group">
                                        <label>Address & City: </label>
                                        <input type="text" class="form-control" value="{{($offer->propertyConditional->street_address??"") . ($offer->propertyConditional->townhouse_apt? ', Apt# '.$offer->propertyConditional->townhouse_apt :"") . ", " . getCityName($offer->propertyConditional->city_id) }}" readonly="readonly">
                                    </div>
                                    <div class="form-group">
                                        <label>state: </label>
                                        <input id="state" class="form-control" value="<?php echo findState($offer->propertyConditional->state_id); ?>" readonly="readonly">
                                    </div>
                                    <div class="form-group"> 
                                        <label>Zip code: </label> 
                                        <input id="postal_code" class="form-control" value="<?php echo findZipCode($offer->propertyConditional->zip_code_id); ?>" readonly="readonly">
                                    </div>
                                </div><!--col-md-12-->
                            </div>
                            @else
                            <div class="form-group">
                                <div class="col-md-12">                                      
                                    <h5  class="first-child">(a) BUYER NAME(s):  </h5>
                                    <input type="text" class="form-control custom_bs_name" value="{{getFullName($offer->buyer)}} {{ (isset($offer->buyerQuestionnaire->partners) && $offer->buyerQuestionnaire->partners) ? ', ' . getPartnersName($offer->buyerQuestionnaire->partners) :" " }}" readonly="readonly">
                                    <h5>(b) SELLER NAME(s):  </h5>
                                    <input type="text" class="form-control custom_bs_name" value="{{getFullName($offer->seller)}} {{ (isset($offer->sellerQuestionnaire->partners) && $offer->sellerQuestionnaire->partners) ? ', ' . getPartnersName($offer->sellerQuestionnaire->partners) :" " }}" readonly="readonly">

                                    <h5>(c) PROPERTY ADDRESS and/or DESCRIPTION:</h5>
                                    <p>Buyer agrees to purchase and Seller agrees to sell the real property identified as:</p>
                                    <div class="form-group">
                                        <label>Address & City: </label>
                                        <input type="text" class="form-control" value="{{($offer->property->street_address??"") . ", " . getCityName($offer->property->city_id) . ($offer->property->townhouse_apt? ', Apt# '.$offer->property->townhouse_apt :"") }}" readonly="readonly">
                                    </div>
                                    <div class="form-group">
                                        <label>state: </label>
                                        <input id="state" class="form-control" value="<?php echo findState($offer->property->state_id); ?>" readonly="readonly">
                                    </div>
                                    <div class="form-group"> 
                                        <label>Zip code: </label> 
                                        <input id="postal_code" class="form-control" value="<?php echo findZipCode($offer->property->zip_code_id); ?>" readonly="readonly">
                                    </div>
                                </div><!--col-md-12-->
                            </div>
                            @endif
                            <div class="include-text">
                                @include('frontend.contract_tools.include_files.update_sale_agreement_by_buyer_common_text')
                            </div>
                            @include('frontend.contract_tools.include_files.signature_common')
                            <div class="btns-green-blue col-lg-12">
                                <a href="{{route('frontend.sdThankyouPurchaseAgreementByBuyer')}}" id="ad_buyer_update" class="btn btn-blue">Submit</a>
                            </div><!--</btns-green-blue>-->
                        </form>
                    </div>
                </div>
            </div> 
        </div><!--</col>-->
    </div><!--</row>-->
</div><!--</contract-tools-seller-common>-->
@endsection
@section('after-scripts')
<script src="{{ asset(asset('js/moment.min.js')) }}"></script>
<script>

    $(document).ready(function () {
        $("#ad_buyer_update").click(function (e) {
           if($(".signature-button").parent().parent().find('.buyer-frst-sign').val() === ""){
                    e.preventDefault();
                    $(".signature-button").parent().parent().find('.buyer-sign-error').show();
                    $('html, body').animate({
                        scrollTop: $(".signature-button").parent().parent().find('.buyer-sign-error').offset().top
                    });
                }
            else {
                $('.buyer-sign-error').hide();
            }
        });
    });

    function addSignature(id) {
        $.ajax({
            type: "post",
            url: "{{ route('frontend.saleAgreementSignature') }}",
            data: {
                id: id,
            },
            success: function (response) {
                if (response.signature) {
                    var date = moment(response.signature.created_at).format('YYYY-MM-DD');
                    var time = moment(response.signature.created_at).format('hh:mm a');
                    $('#sd-buyer-ip-' + (id + 7)).val(response.signature.ip);
                    $('#sd-buyer-time-' + (id + 7)).val(time);
                    $('#sd-buyer-date-' + (id + 7)).val(date);
                }
                $('#sd-buyer-signature-' + (id + 7)).val(response.signature.signature).css('color', '#ff0000');
                $(".signature .signature-button").parent().parent().find('.buyer-sign-error').remove();
                $('.buyer-sign-error').remove();
                $('.signature .signature-button').remove();
//                $('.signature').remove();
            },
            error: function (error) {
            }
        });
    }
</script>
@endsection