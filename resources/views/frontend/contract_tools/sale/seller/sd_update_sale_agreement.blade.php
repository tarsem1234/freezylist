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
                    <?php
                    $buyersArray = [];
                    $sellersArray = [];
                    foreach ($offer->signatures as $sign) {
                        if (in_array($sign['type'], [1, 3])) {
                            $buyersArray[] = $sign['fullname'];
                        } else {
                            $sellersArray[] = $sign['fullname'];
                        }
                    }
                    $allbuyers = implode(' , ', array_unique($buyersArray));
                    $allsellers = implode(' , ', array_unique($sellersArray));
                    ?>
                    <div class="para-text row">  
                        <form>
                            @if($offer->signatures->isNotEmpty())
                            <div class="form-group">
                                <div class="col-md-12">
                                    <h5  class="first-child">(a) BUYER NAME(s):  </h5>
                                    @if(isset($offer) && $offer->buyer->user_profile)
                                    <input type="text" class="form-control custom_bs_name" value="{{!empty($allbuyers) ? $allbuyers:''}}" readonly="readonly">
                                    @elseif(isset($offer) && $offer->buyer->business_profile)
                                    <input type="text" class="form-control custom_bs_name" value="{{ $offer->buyer->business_profile->company_name }}" readonly="readonly">
                                    @endif
                                    <h5>(b) SELLER NAME(s):  </h5>
                                    @if(isset($offer) && $offer->seller->user_profile)
                                    <input type="text" class="form-control custom_bs_name" value="{{!empty($allsellers) ? $allsellers:''}}" readonly="readonly">
                                    @elseif(isset($offer) && $offer->buyer->business_profile)
                                    <input type="text" class="form-control custom_bs_name" value="{{ $offer->seller->business_profile->company_name }}" readonly="readonly">
                                    @endif
                                    <h5>(c) PROPERTY ADDRESS and/or DESCRIPTION:</h5>
                                    <p>Buyer agrees to purchase and Seller agrees to sell the real property identified as:</p>
                                    <div class="form-group">
                                        <input type="text" class="form-control" value="{{($offer->propertyConditional->street_address??"") . ", " . getCityName($offer->property->city_id) . ($offer->property->townhouse_apt? ', Apt# '.$offer->property->townhouse_apt :"") }}" readonly="readonly">
                                    </div>
                                    <div class="form-group">                                         
                                        <input id="state" class="form-control" value="<?php echo findState($offer->propertyConditional->state_id); ?>" type="text" readonly="readonly">
                                    </div>
                                    <div class="form-group">               
                                        <input id="postal_code" class="form-control" min="0" value="<?php echo findZipCode($offer->propertyConditional->zip_code_id); ?>" type="number" readonly="readonly">
                                    </div>
                                </div><!--col-md-12-->
                            </div>
                            @else
                            <div class="form-group">
                                <div class="col-md-12">
                                    <h5  class="first-child">(a) BUYER NAME(s):  </h5>
                                    @if(isset($offer) && $offer->buyer->user_profile)
                                    <input type="text" class="form-control" value="{{getFullName($offer->buyer)}} {{ (isset($offer->buyerQuestionnaire->partners) && $offer->buyerQuestionnaire->partners) ? ', ' . getPartnersName($offer->buyerQuestionnaire->partners) :" " }}" readonly="readonly">
                                    @elseif(isset($offer) && $offer->buyer->business_profile)
                                    <input type="text" class="form-control" value="{{ $offer->buyer->business_profile->company_name }}" readonly="readonly">
                                    @endif
                                    <h5>(b) SELLER NAME(s):  </h5>
                                    @if(isset($offer) && $offer->seller->user_profile)
                                    <input type="text" class="form-control" value="{{getFullName($offer->seller)}} {{ (isset($offer->sellerQuestionnaire->partners) && $offer->sellerQuestionnaire->partners) ? ', ' . getPartnersName($offer->sellerQuestionnaire->partners) :" " }}" readonly="readonly">
                                    @elseif(isset($offer) && $offer->buyer->business_profile)
                                    <input type="text" class="form-control" value="{{ $offer->seller->business_profile->company_name }}" readonly="readonly">
                                    @endif
                                    <h5>(c) PROPERTY ADDRESS and/or DESCRIPTION:</h5>
                                    <p>Buyer agrees to purchase and Seller agrees to sell the real property identified as:</p>
                                    <div class="form-group">
                                        <input type="text" class="form-control" value="{{($offer->property->street_address??"") . ", " . getCityName($offer->property->city_id) . ($offer->property->townhouse_apt? ', Apt# '.$offer->property->townhouse_apt :"") }}" readonly="readonly">
                                    </div>
                                    <div class="form-group">                                         
                                        <input id="state" class="form-control" value="<?php echo findState($offer->property->state_id); ?>" type="text" readonly="readonly">
                                    </div>
                                    <div class="form-group">               
                                        <input id="postal_code" class="form-control" min="0" value="<?php echo findZipCode($offer->property->zip_code_id); ?>" type="number" readonly="readonly">
                                    </div>
                                </div><!--col-md-12-->
                            </div>
                            @endif
                                <div class="include-text">
                                    @include('frontend.contract_tools.include_files.update_sale_agreement_by_buyer_common_text',['offer'=>$offer])
                                </div>
                                @include('frontend.contract_tools.include_files.signature_common',['offer'=>$offer])
                                <div class="btns-green-blue col-lg-12">
                                    <a href="{{route('frontend.sdThankyouPurchaseAgreement')}}" id="ad_seller_update" onclick="saleAgreementBtn()" class="btn btn-blue">Submit</a>
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
        $("#ad_seller_update").click(function (e) {
             if($(".signature-button").parent().parent().find('.seller-frst-sign').val() === ''){
                    e.preventDefault();
                    $(".signature-button").parent().parent().find('.seller-sign-error').show();
                    $('html, body').animate({
                        scrollTop: $(".signature-button").parent().parent().find('.seller-sign-error').offset().top
                    });
                }   
            else {
                $('.seller-sign-error').hide();
            }
        });

    });

    function addSignature(id) {
        $.ajax({
            type: "post",
            url: "{{ route('frontend.saleAgreementSignatureSeller') }}",
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
                $(".signature .signature-button").parent().parent().find('.seller-sign-error').remove();
                $('.seller-sign-error').hide();
                $('.signature-button').remove();
            },
            error: function (error) {
            }
        });
    }
//    for showing the format
    $('.money').mask('000,000,000,000,000', {reverse: true});
</script>
@endsection