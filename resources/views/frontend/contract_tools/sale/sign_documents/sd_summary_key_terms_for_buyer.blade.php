@extends ('frontend.layouts.app')
@section ('title', ('Sd Summary Key Terms For Buyer'))
@section('after-styles')
<link type="text/css" rel="stylesheet" href="{{ asset(mix('css/dashboard.css')) }}" media="all">
@endsection
@section('content')
<div class="offers-page summary">
    <div class="container">
        <div class="col-lg-12">
             <?php 
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
            <div> <h4>Summary of Terms</h4></div>
            <div id="mymessagesviewreply-box">
                <div>
                    <table>
                        <tbody>
                            <tr>
                                <td> <p><strong>Price  :</strong> <span class="money">{{$offer->sale_counter_offers->count()? round($offer->sale_counter_offers[0]->counter_offer_price):round($offer->tentative_offer_price)}} </span></p></td>
                            </tr>
                            <tr>
                                <td><p><strong>Listing Type :</strong> <span>{{config('constant.property_type.'.$offer->property->property_type)}}</span></p></td>
                            </tr>
                            <?php
                            if (isset($offer->sellerQuestionnaire) && $offer->sellerQuestionnaire->joint_cowners == config('constant.joint_coowner.Yes')) {
                                $sellerPartners = explode(',', $offer->sellerQuestionnaire->partners);
                            }
                            if (isset($offer->buyerQuestionnaire) && $offer->buyerQuestionnaire->joint_cowners == config('constant.joint_coowner.Yes')) {
                                $buyerPartners = explode(',', $offer->buyerQuestionnaire->partners);
                            }
                            ?>
                            
                            <tr>
                                <td><p><strong>Seller Full Name(s) :</strong>
                                        @if(!empty($allsellers))
                                        @php 
                                        $sellers = explode(',', $allsellers);
                                        if(!empty($sellers)){
                                             foreach($sellers as $seller){
                                              echo "<span class=''>$seller</span>";
                                             }
                                        }
                                        @endphp
                                       
                                        @else
                                            <span>{{getFullName($offer->seller)}}</span>
                                            @if(isset($sellerPartners))
                                            @foreach($sellerPartners as $key=>$partner)
                                            <span class="">{{getPartnersName($partner)}}</span>
                                            @endforeach
                                        @endif
                                        @endif
                                   
                                    </p>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <p><strong>Buyer Full Name(s) :</strong>
                                        @if(!empty($allbuyers))
                                        @php 
                                        $buyers = explode(',', $allbuyers);
                                        if(!empty($buyers)){
                                             foreach($buyers as $buyer){
                                              echo "<span class=''>$buyer</span>";
                                             }
                                        }
                                        @endphp
                                        @else
                                        <span>{{getFullName($offer->buyer)}} </span>
                                        @if(isset($buyerPartners))
                                        @foreach($buyerPartners as $key=>$partner)
                                        <span class=""> {{getPartnersName($partner)}}</span>
                                        @endforeach
                                        @endif
                                        @endif
                                    </p>
                                </td>
                            </tr>
                            
                           @if(!empty($signature))
                            <tr>
                                <td><p><strong>Property Information  :</strong> {{$offer->propertyConditional->architechture->describe_your_home??"NA"}} </p></td>
                            </tr> 
                            <tr>
                                <td><p><strong>Street Address :</strong><span> {{$offer->propertyConditional->street_address??"NA"}}</span></p></td>
                            </tr>
                            <tr>
                                <td><p><strong>City, State, Zip:</strong> <span>{{getCityName($offer->propertyConditional->city_id)}}, {{findState($offer->propertyConditional->state_id)}}, {{findZipCode($offer->propertyConditional->zip_code_id)}}</span></p></td>
                            </tr>
                            @else
                                 <tr>
                                <td><p><strong>Property Information  :</strong> {{$offer->property->architechture->describe_your_home??"NA"}} </p></td>
                            </tr> 
                            <tr>
                                <td><p><strong>Street Address :</strong><span> {{$offer->property->street_address??"NA"}}</span></p></td>
                            </tr>
                            <tr>
                                <td><p><strong>City, State, Zip:</strong> <span>{{getCityName($offer->property->city_id)}}, {{findState($offer->property->state_id)}}, {{findZipCode($offer->property->zip_code_id)}}</span></p></td>
                            </tr>
                            
                            @endif
                            <tr>
                                <td><p><strong>Earnest Money Required :</strong> @if(!empty($offer->sellerQuestionnaire->amount_for_earnest_money))<span class="money">{{round($offer->sellerQuestionnaire->amount_for_earnest_money)}}</span>@else <span>{{'NA'}}</span>@endif</p></td>
                            </tr>
                            <tr>
                                <td><p><strong>Special Stipulations  :</strong> <span>NA</span></p></td>
                            </tr>
                            <tr>
                                <td><p><strong>Stipulations(A) :</strong><span> {{$offer->percentage_of_price?trans('strings.frontend.property.sale.stipulationPercentageA',['value'=>$offer->percentage_of_price]):($offer->fixed_amount?trans('strings.frontend.property.sale.stipulationFixedA',['value'=>$offer->fixed_amount]):"NA")}}</span></p></td>
                            </tr>
                            <tr>
                                <td><p><strong>Stipulations(B) :</strong> {!! $offer->sellerQuestionnaire->property_vacant_date?trans('strings.frontend.property.sale.stipulationB',['value'=>$offer->sellerQuestionnaire->property_vacant_date]):"<span>NA</span>" !!}</p></td>
                            </tr>
                            <tr>
                                <td><p><strong>Stipulations(C) :</strong><span> {{$offer->contingencies_explain??"NA"}}</span></p></td>
                            </tr>
                            <tr>
                                <td><p><strong>Real Estate Commisions :</strong></p></td>
                            </tr>
                            <tr>
                                <td  class="child_spacing na_prop"><p><strong>Seller's Realtor :</strong><span> {{$offer->sellerQuestionnaire->agent_name??"NA"}}</span></p></td>
                            </tr>
                            <tr class="parent_last_child">
                                <td class="child_spacing na_prop"><p><strong>Commision Due (To be paid by the seller) :</strong><span> {{$offer->sellerQuestionnaire->commission??"NA"}}% </span></p></td>
                            </tr>
                            <tr> 
                                <td><p><strong>Estimated Closing Date:</strong><span> {{$offer->sellerQuestionnaire->offer_expiration??date("d F Y", strtotime($offer->created_at->addMonth()))}}</span></p></td>
                            </tr>
                        </tbody>
                    </table>                    
                    <div class="form-group">
                        <div class="checkbox"> 
                            <p class="align-left"><strong>I have reviewed the above (summary) terms and agree this information is correct to the best of my knowledge. Further, I understand that Freezyist.com is not providing legal guidance and recommends I consult with an attorney regarding these and other relevant legal matters.</p> 
                            <input type="checkbox" class="styled-checkbox i_agree" data-rule-required="true" data-msg-required="You must select option" name="agree" id="agree" value="Y" aria-required="true">
                            <label for="agree" id="i_agree-label"><b>I Understand and Agree</b></label>
                            <span class="error" id="i_agree-error">Please check this to proceed</span>
                        </div>                                   
                    </div>
                    <div class="lager-content-button">
                        <div class="bottom_btns pull-right btns-green-blue">
                            <a href="{{route('frontend.sdAdvisoryToBuyersAndSellers')}}" class="btn btn-blue" id="proceed-sign"> Proceed To Sign Documents</a>
                        </div>
                    </div>                   
                </div>
            </div> 
        </div><!--</row>-->
    </div><!--</container>-->
</div><!--</offers-page>-->
@endsection
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
@section('after-scripts')
<script>
$(document).ready(function () {
    $('form').validate({
        errorPlacement: function (error, element)
        {
            if (element.is(":radio") || element.is(":checkbox"))
            {
                error.appendTo(element.parents('.form-group'));
            } else
            {
                error.insertAfter(element);
            }
        }
    });
    $("#proceed-sign").click(function (e) {
        if ($('.i_agree').is(":checked")) {
            $('#i_agree-error').hide();
        } else {
            $('#i_agree-error').css("display", "block");
            e.preventDefault();
        }
    });

    $('#i_agree-label').mouseup(function () {
        if ($('.i_agree').prop("checked") == true) {
            $('#i_agree-error').css("display", "block");
        } else if ($('.i_agree').prop("checked") == false) {
            $('#i_agree-error').hide();
        }
    });
});
</script>
@endsection
