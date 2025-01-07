@extends ('frontend.layouts.app')
@section ('title', ('VA-FHA Loan Addendum'))
@section('after-styles')
<link type="text/css" rel="stylesheet" href="{{ asset(mix('css/contract-tools-buyer.css')) }}" media="all">
@endsection
@section('content')
<div class="container purchase-sale-agreement-review contract-tools-seller-common">
    <div class="row">
        <div class="">
            <div class="sidebar">
                @include('frontend.includes.sidebar')
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
                           
                            ?>
            </div>
            <div class="col-md-9 col-sm-8">
                <div class="nested-div register-page">
                    <div class="heading-text">
                        <h2>VA-FHA Loan Addendum</h2>
                    </div>
                    <div class="para-text row mar-top">
                        <div class="form-group">
                            <div class="col-md-12">
                                <h4 class="first-child">PROPERTY ADDRESS:</h4>
                                <div class="form-group">
                                <label>Street Address</label>
                                <?php //echo'<pre>';print_r($offer);die;?>
                                        <input type="text" class="form-control" placeholder="Address" name="street_address" value="{{($offer->propertyConditional->street_address??"") . ($offer->propertyConditional->townhouse_apt? ' , Apt# '.$offer->propertyConditional->townhouse_apt :"") }}" readonly="readonly">
                                </div>
                                <div class="form-group">
                                <label>City</label>
                                    <input id="city" class="form-control" placeholder="City" name="city" type="text" value="{{ getCityName($offer->propertyConditional->city_id) }}" readonly="readonly">
                                </div>

                                <div class="form-group">
                                    <label>State</label>
                                    <input id="state" class="form-control" placeholder="State" name="state" type="text" value="{{ findState($offer->propertyConditional->state_id) }}" readonly="readonly">
                                </div>
                                <div class="form-group">
                                    <label>Zip Code</label>
                                    <input id="postal_code" class="form-control" min="0" placeholder="Zip Code" value="{{ findZipCode($offer->propertyConditional->zip_code_id) }}" name="zip_code" type="number" readonly="readonly">
                                </div>
                                <label>Buyer Name</label>
                                    <input type="text" class="form-control" value="{{!empty($allbuyers) ? $allbuyers:''}}" readonly="readonly" placeholder="freezylist buyer name">
                                        <label>Seller Name</label>
                                    <input type="text" class="form-control" value="{{!empty($allsellers) ? $allsellers:''}}" readonly="readonly" placeholder="freezylist seller name">
                                <h5>This VA / FHA Loan Addendum is made a part of the Purchase and Sale Agreement for the Property identified above. Should any terms of this Addendum conflict with the terms of the Purchase and Sale Agreement, the terms of this agreement will take precedence.</h5>
                            </div><!--col-md-12-->
                        </div>
                        <div class="form-group">
                            <div class="col-md-12">
                                 <?php
                  if (isset($offer->sale_counter_offers) && count($offer->sale_counter_offers)>0) {
                     $purchasePrice = $offer->sale_counter_offers->first()->counter_offer_price;
                  }
                  ?>
                                <h4> AMENDATORY CLAUSE:</h4> <p> "An amendatory clause must be included in the sales contract when the borrower has not been informed of the appraised value… The amendatory clause must contain the following language:" "It is expressly agreed that notwithstanding any other provisions of this contract, the purchaser shall not be obligated to complete the purchase of the property described herein or to incur any penalty by forfeiture of earnest money deposits or otherwise unless the purchaser has been given in accordance with HUD/FHA or VA requirements a written statement by the Federal Housing Commissioner, Department of Veterans Affairs, or a Direct Endorsement lender setting forth the appraised value of the property of not less than $
                                    <input type="text" class="readonly" id="text-form-input" name="appraised_value" value="{{ isset($purchasePrice)?$purchasePrice:$offer->tentative_offer_price }}" readonly="readonly">
                                    [sales price as stated in the contract]. The purchaser shall have the privilege and option of proceeding with consummation of the contract without regard to the amount of the appraised valuation. The appraised valuation is arrived at to determine the maximum mortgage the Department of Housing and Urban Development will insure. HUD does not warrant the value or the condition of the property. The purchaser should satisfy himself/herself that the price and condition of the property are acceptable." (HUD Handbook 4155.1 Chapter 3-4)</p>
                            </div><!--col-md-12-->
                        </div>
                        <div class="form-group">
                            <div class="col-md-12">
                                <h4>INSPECTIONS, REPAIRS, AND CONDITION OF PROPERTY:</h4><p> VA and FHA do not guarantee the value or condition of a home, or that it is free of defects. VA and FHA appraisals are not intended to be "home inspections." VA and FHA appraisals, seller's property condition disclosures, and Home Protection Plans are not substitutes for a professional home inspection. Well, septic, wood destroying insect and other inspections or certifications may be required. The lender may also require that certain repairs or treatments be completed, or that the property be connected to public water or sewer if available and feasible. The costs of any such inspections, certifications, treatments, connections or repairs should be negotiated in the Purchase and Sale Agreement.</p>
                            </div><!--col-md-12-->
                        </div>
                        <div class="form-group">
                            <div class="col-md-12">
                                <h4> CLOSING COSTS AND NON-ALLOWABLE SETTLEMENT CHARGES:</h4> <p> Government guidelines do not allow certain charges to be paid by the buyer. These "non-allowable" charges must be paid by the seller or the lender. Any seller contributions to the buyer's closing costs (including the VA Funding Fee) must be addressed in the Purchase and Sale Agreement, and any non-allowable charges will be included in the total amount of any seller contributions negotiated.</p>
                            </div><!--col-md-12-->
                        </div>
                        <div class="form-group">
                            <div class="col-md-12">
                                <h4> REAL ESTATE CERTIFICATION:</h4><p> The buyer and seller certify that the terms and conditions of the sales contract are true to the best of their knowledge and belief and that any other agreement entered into by any of the parties in connection with the real estate transaction is part of, or attached to, the sales agreement." (HUD Handbook 4155.1, 3-3).</p>
                            </div><!--col-md-12-->
                        </div>

                    </div>
                     @include('frontend.contract_tools.include_files.signature_common')
                    <div class="btns-green-blue col-lg-12">
                        <a href="{{route('frontend.sdSaleAgreementReviewByBuyer')}}" class="btn btn-blue" id="ad_loan_update">Next</a>
                    </div><!--</btns-green-blue>-->
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
        $("#ad_loan_update").click(function (e) {
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
    function addSignature(id){
            $.ajax({
                type: "post",
                url: "{{ route('frontend.vaFhaSignature') }}",
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
                    $(".signature .signature-button").parent().parent().find('.buyer-sign-error').remove();
                    $('.buyer-sign-error').remove();
                    $('.signature .signature-button').remove();
                },
                error: function (error) {
                }
            });
        }
</script>
@endsection
