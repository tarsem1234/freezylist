@extends ('frontend.layouts.app')
@section ('title', ('Sd Summary Key Terms For Seller'))
@section('after-styles')
<link type="text/css" rel="stylesheet" href="{{ asset(mix('css/dashboard.css')) }}" media="all">
@endsection
@section('content')
<div class="offers-page summary">
    <div class="container">
        <div class="col-lg-12">
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
                                        @endif
                                    </p>
                                </td>
                            </tr>
                            <tr>
                                <td><p><strong>Property Information  :</strong> {{$offer->propertyConditional->architechture->describe_your_home??"NA"}}</p></td>
                            </tr> 
                            <tr>
                                <td><p><strong>Street Address :</strong><span> {{$offer->propertyConditional->street_address??"NA"}}</span></p></td>
                            </tr>
                            <tr>
                                <td><p><strong>City, State, Zip:</strong> <span>{{getCityName($offer->propertyConditional->city_id)}}, {{findState($offer->propertyConditional->state_id)}}, {{findZipCode($offer->propertyConditional->zip_code_id)}}</span></p></td>
                            </tr>
                            <tr>
                                <td><p><strong>Earnest Money Required :</strong> <span class="money">{{isset($offer->sellerQuestionnaire->amount_for_earnest_money)?(round($offer->sellerQuestionnaire->amount_for_earnest_money)):"NA"}}</span></p></td>
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
                                <td><p><strong>Real Estate Commisions </strong></p></td>
                            </tr>
                            <tr>
                                <td><p><strong>Seller's Realtor :</strong><span> {{$offer->sellerQuestionnaire->agent_name??"NA"}}</span></p></td>
                            </tr>
                            <tr>
                                <td><p><strong>Commision Due (To be paid by the seller) :</strong><span> {{$offer->sellerQuestionnaire->commission??"NA"}}% </span></p></td>
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
                            <a href="{{route('frontend.sdAdvisoryToBuyersAndSellersSellers')}}" id="proceed-review" class="btn btn-blue">Proceed To Review Documents</a> 
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
