@extends ('frontend.layouts.app')
@section ('title', ('Advisory To Buyers and Sellers'))
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
                        <h2>Advisory to Buyers and Sellers</h2>
                    </div>
                    <div class="para-text row">
                         <?php 
//                             echo'<pre>';print_r($type);die;
                            $buyersArray = [];
                            $sellersArray = [];
                            foreach ($offer->signatures as $sign) {
                                if(in_array($sign['type'],[1,3])){
                                    $buyersArray[] = $sign['fullname'];
                                }
                                else{
                                       $sellersArray[] = $sign['fullname'];
                                }
                                
                            }
                            $allbuyers = implode(' , ', array_unique($buyersArray));
                            $allsellers = implode(' , ', array_unique($sellersArray));
//                           dd($offer->propertyConditional)
                            ?>
                        <form>
                            @if($offer->propertyConditional)
                             <div class="col-md-12">
                                <h4 class="first-child">PROPERTY ADDRESS:</h4>
                                    <div class="form-group">
                                        <label>Street Address</label>
                                        <input type="text" class="form-control" id="inputPassword3" value="{{($offer->propertyConditional->street_address??"") . ($offer->propertyConditional->townhouse_apt? ' , Apt# '.$offer->propertyConditional->townhouse_apt :"") }}" readonly="readonly">
                                    </div>
                                    <div class="form-group">
                                        <label>City</label>
                                    <input id="city" class="form-control" value="{{ getCityName($offer->propertyConditional->city_id) }}" type="text" readonly="readonly">
                                    </div>
                                        <label>State</label>
                                    <div class="form-group">
                                           <input id="state" class="form-control" value="{{ findState($offer->propertyConditional->state_id) }}" readonly="readonly">
                                    </div>
                                        <label>Zip Code</label>
                                    <div class="form-group">
                                        <input id="postal_code" class="form-control" min="0" value="{{ findZipCode($offer->propertyConditional->zip_code_id) }}" readonly="readonly">
                                    </div>
                                        <label>Buyer Name</label>
                                    <input type="text" class="form-control" value="{{!empty($allbuyers) ? $allbuyers:''}}" readonly="readonly" placeholder="freezylist buyer name">
                                        <label>Seller Name</label>
                                    <input type="text" class="form-control" value="{{!empty($allsellers) ? $allsellers:''}}" readonly="readonly" placeholder="freezylist seller name">
                                    <h5>**It is strongly recommended that Buyers and Sellers include appropriate contingency or other clauses in all Purchase and Sale Agreement offers with respect to these or any other items of concern, and that all such contingencies should include enough time to get a professional evaluation of these items.**</h5>
                            </div>
                            @else
                            <div class="col-md-12">
                                <h4 class="first-child">PROPERTY ADDRESS:</h4>
                                    <div class="form-group">
                                        <label>Street Address</label>
                                        <input type="text" class="form-control" id="inputPassword3" value="{{($offer->property->street_address??"") . ($offer->property->townhouse_apt? ' , Apt# '.$offer->property->townhouse_apt :"") }}" readonly="readonly">
                                    </div>
                                    <div class="form-group">
                                        <label>City</label>
                                    <input id="city" class="form-control" value="{{ getCityName($offer->property->city_id) }}" type="text" readonly="readonly">
                                    </div>
                                        <label>State</label>
                                    <div class="form-group">
                                           <input id="state" class="form-control" value="{{ findState($offer->property->state_id) }}" readonly="readonly">
                                    </div>
                                        <label>Zip Code</label>
                                    <div class="form-group">
                                        <input id="postal_code" class="form-control" min="0" value="{{ findZipCode($offer->property->zip_code_id) }}" readonly="readonly">
                                    </div>
                                        <label>Buyer Name</label>
                                    <input type="text" class="form-control" value="{{getFullName($offer->buyer)}} {{ (isset($offer->buyerQuestionnaire->partners) && $offer->buyerQuestionnaire->partners) ? ', ' . getPartnersName($offer->buyerQuestionnaire->partners) :" " }}" readonly="readonly" placeholder="freezylist buyer name">
                                        <label>Seller Name</label>
                                    <input type="text" class="form-control" value="{{getFullName($offer->seller)}} {{ (isset($offer->sellerQuestionnaire->partners) && $offer->sellerQuestionnaire->partners) ? ', ' . getPartnersName($offer->sellerQuestionnaire->partners) :" " }}" readonly="readonly" placeholder="freezylist seller name">
                                    <h5>**It is strongly recommended that Buyers and Sellers include appropriate contingency or other clauses in all Purchase and Sale Agreement offers with respect to these or any other items of concern, and that all such contingencies should include enough time to get a professional evaluation of these items.**</h5>
                            </div><!--col-md-12-->
                            @endif
                            <!--col-md-12-->
                            <div class="include-text">
                                @include('frontend.contract_tools.include_files.advisory_to_buyers_and_sellers_common_text')
                            </div>
                            @include('frontend.contract_tools.include_files.signature_common')
                            <div class="btns-green-blue col-lg-12">
                                <a href="{{route('frontend.sdAdvisoryToBuyersAndSellersThankYou')}}" id="ad_seller_submit" class="btn btn-blue">Submit</a> 
                            </div>
                        </form> 
                    </div><!--</para-text>--> 
                </div><!--</nested-div>-->
            </div><!--</col-9>-->
        </div><!--</col-12>-->
    </div><!--</row>-->
</div><!--</contract-tools-seller-common>-->
@endsection
@section('after-scripts')
<script src="{{ asset(asset('js/moment.min.js')) }}"></script>
<script>
    
    $(document).ready(function(){
        $("#ad_seller_submit").click(function(e){
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
    
    function addSignature(id){
        $.ajax({
            type: "post",
            url: "{{ route('frontend.advisorySignature') }}",
            data: {
                id: id,
            },
            success: function (response) {
                if (response.signature) {
                    var date = moment(response.signature.created_at).format('YYYY-MM-DD');
                    var time = moment(response.signature.created_at).format('hh:mm a');
                    $('#sd-buyer-ip-'+(id+7)).val(response.signature.ip);
                    $('#sd-buyer-time-'+(id+7)).val(time);
                    $('#sd-buyer-date-'+(id+7)).val(date);
                }
                $('#sd-buyer-signature-'+(id+7)).val(response.signature.signature).css('color', '#ff0000');
                $(".signature .signature-button").parent().parent().find('.seller-sign-error').remove();
                $('.seller-sign-error').hide();
                $('.signature-button').remove();
            },
            error: function (error) {
            }
        });
    }
</script>
@endsection