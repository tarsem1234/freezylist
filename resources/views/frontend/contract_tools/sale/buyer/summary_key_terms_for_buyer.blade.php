@extends ('frontend.layouts.app')
@section ('title', ('Summary Key Terms For Buyer'))
@section('after-styles')
<link type="text/css" rel="stylesheet" href="{{ asset(mix('css/dashboard.css')) }}" media="all">
@endsection
@section('content')
<div class="offers-page summary">
    <div class="container">
        <div class="col-lg-12">
            <div> <h4>Summary of Terms</h4></div>
            <div id="mymessagesviewreply-box"> 
                <div>
                    <table>
                        <tbody>
                            <tr>
                                <td> <p><strong>Price  :</strong> <span class="money">{{$offer->sale_counter_offers->count()?round($offer->sale_counter_offers[0]->counter_offer_price):round($offer->tentative_offer_price)}} </span></p></td>
                            </tr>
                            <tr>
                                <td><p><strong>Listing Type :</strong> <span> {{config('constant.property_type.'.$offer->property->property_type)}}</span></p></td>
                            </tr>
                            <?php
                            if (isset($offer->sellerQuestionnaire) && $offer->sellerQuestionnaire->joint_cowners == config('constant.joint_coowner.Yes')) {
                                $sellerPartners = explode(',', $offer->sellerQuestionnaire->partners);
                            }
                            if (isset($offer->buyerQuestionnaire) && $offer->buyerQuestionnaire->joint_cowners == config('constant.joint_coowner.Yes')) {
                                $partners = explode(',', $offer->buyerQuestionnaire->partners);
                            }
                            ?>
                            <tr>
                                <td><p><strong>Seller Full Name(s) :</strong>
                                        <span>  {{getFullName($offer->seller)}}</span>
                                            @if(isset($sellerPartners))
                                            @foreach($sellerPartners as $key=>$partner)
                                            <span class="">  {{getPartnersName($partner)}}</span>
                                            @endforeach
                                            @endif
                                        
                                    </p></td>
                            </tr>
                            <tr>
                                <td>
                                    <p><strong>Buyer Full Name(s) :</strong>
                                        <span>{{getFullName($offer->buyer)}} </span>
                                        @if(isset($partners))
                                        @foreach($partners as $key=>$partner)
                                        <span class=""> {{getPartnersName($partner)}}</span>
                                        @endforeach
                                        @endif
                                    </p>
                                </td>
                            </tr>
                            <tr>
                                <td><p><strong>Property Information :</strong> {{$offer->property->architechture->describe_your_home??"NA"}}</p></td>
                            </tr> 
                            <tr>
                                <td><p><strong>Street Address :</strong><span> {{$offer->property->street_address??"NA"}}</span></p></td>
                            </tr>
                            <tr>
                                <td><p><strong>City, State, Zip :</strong> <span>{{getCityName($offer->property->city_id)}}, {{findState($offer->property->state_id)}}, {{findZipCode($offer->property->zip_code_id)}}</span></p></td>
                            </tr>
                            <tr>
                                <td><p><strong>Earnest Money Required :</strong> @if(!empty($offer->sellerQuestionnaire->amount_for_earnest_money))<span class="money">{{round($offer->sellerQuestionnaire->amount_for_earnest_money)}}</span>@else <span>{{'NA'}}</span>@endif</p></td>
                            </tr>
                            <tr>
                                <td><p><strong>Special Stipulations  :</strong> <span>NA</span></p></td>
                            </tr>
                            <tr>
                                <!--<td><p><strong>Stipulations(A) :</strong><span> {{--$offer->property->propertyConditionDisclaimer->best_knowledge_explain??"NA"--}}</span></p></td>-->
                                <td><p><strong>Stipulations(A) :</strong><span> {{$offer->percentage_of_price?trans('strings.frontend.property.sale.stipulationPercentageA',['value'=>$offer->percentage_of_price]):($offer->fixed_amount?trans('strings.frontend.property.sale.stipulationFixedA',['value'=>$offer->fixed_amount]):"NA")}}</span></p></td>
                            </tr>
                            <tr>
                                @if(isset($offer->sellerQuestionnaire) && $offer->sellerQuestionnaire->property_vacant_date)
                                <!--<td><p><strong>Stipulations(B) :</strong><span> {{--$offer->property->propertyConditionDisclaimer->partb_details??"NA"--}}</span></p></td>-->
                                <td><p><strong>Stipulations(B) :</strong> {!! $offer->sellerQuestionnaire->property_vacant_date?trans('strings.frontend.property.sale.stipulationB',['value'=>$offer->sellerQuestionnaire->property_vacant_date]):"<span>NA</span>" !!}</p></td>
                                @else
                                <td><p><strong>Stipulations(B) :</strong> <span>NA</span></p></td>
                                @endif
                            </tr>
                            <tr>
                                <!--<td><p><strong>Stipulations(C) :</strong><span> {{--$offer->property->propertyConditionDisclaimer->partc_details??"NA"--}}</span></p></td>-->
                                <td><p><strong>Stipulations(C) :</strong><span> {{$offer->contingencies_explain??"NA"}}</span></p></td>
                            </tr>
                            <tr>
                                <td><p><strong>Real Estate Commisions:</strong></p></td>
                            </tr>
                            <tr>
                                <td class="child_spacing na_prop"><p><strong>Seller's Realtor :</strong><span> {{$offer->sellerQuestionnaire->agent_name??"NA"}}</span></p></td>
                            </tr>
                            <tr class="parent_last_child">
                                <td class="child_spacing na_prop"><p><strong>Commision Due (To be paid by the seller) :</strong><span> {{$offer->sellerQuestionnaire->commission??"0"}}% </span></p></td>
                            </tr>
                            <tr> 
                                <td><p><strong>Estimated Closing Date:</strong><span> {{$offer->sellerQuestionnaire->offer_expiration??date("d F Y", strtotime($offer->created_at->addMonth()))}}</span></p></td>
                            </tr>
                        </tbody>
                    </table>                    
                    <div class="form-group">
                        <div class="checkbox"> 
                            <p class="align-left"><strong>I HAVE REVIEWED THE ABOVE (SUMMARY) TERMS AND AGREE THIS INFORMATION IS CORRECT TO THE BEST OF MY KNOWLEDGE. FURTHER, I UNDERSTAND THAT FREEZYIST.COM IS NOT PROVIDING LEGAL GUIDANCE AND RECOMMENDS I CONSULT WITH AN ATTORNEY REGARDING THESE AND OTHER RELEVANT LEGAL MATTERS.</strong>
                            </p>
                            <input type="checkbox" class="styled-checkbox for-agree" data-rule-required="true" name="agree" id="agree" value="Y" required="required" aria-required="true">
                            <label for="agree" id="agree_label"><b>I Understand and Agree</b></label>
                            <label class="error" id="agree-error">Please check this to proceed</label>
                        </div>                                    
                    </div>
                    <div class="lager-content-button">
                        <div class="bottom_btns pull-right btns-green-blue">
                            <!--<a href="{{route('frontend.sdAdvisoryToBuyersAndSellers')}}" id="proceed-review" class="btn btn-blue">Proceed To Review Documents</a>-->
                            <a href="{{route('frontend.thankYouAcceptOffer')}}" id="proceed-review" class="btn btn-blue">Proceed To Review Documents</a>
                        </div>
                    </div>
                </div>
            </div> 
        </div><!--</row>-->
    </div><!--</container>-->
</div><!--</offers-page>-->
@endsection
@section('after-scripts')
<script>
    $(document).ready(function () {
        $("#proceed-review").click(function (e) {
            if ($('.for-agree').is(':checked')) {
                $('#agree-error').hide();
            } else {
                $('#agree-error').css("display", "block");
                return false;
            }
        });

        $('#agree_label').mouseup(function () {
            if ($('.for-agree').prop("checked") === true) {
                console.log("hi");
                $('#agree-error').css("display", "block");
            } else if ($('.for-agree').prop("checked") === false) {
                console.log("hiiiii");
                $('#agree-error').hide();
            }
        });
    });
 $('.money').mask('000,000,000,000,000', {reverse: true});
</script>
@endsection
