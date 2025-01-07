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
                                @if(isset($offer->rent_counter_offers) && count($offer->rent_counter_offers) > 0)
                                <td> <p><strong>Rent/Month :</strong> <span class="money">{{round($offer->rent_counter_offers->first()->counter_offer_price)}} </span></p></td>
                                @else
                                <td> <p><strong>Rent/Month :</strong> <span class="money">{{round($offer->rent_price)??"NA"}} </span></p></td>
                                @endif
                            </tr>
                           @php
			    if (isset($offer->landlordQuestionnaire) && $offer->landlordQuestionnaire->joint_cowners == config('constant.inverse_common_yes_no.Yes')) {
                                $landlordSigners = explode(',', $offer->landlordQuestionnaire->partners);
                            }
			    
			    if(!empty($offer->landlord->user_profile->full_name))
			    $fullname = getFullName($offer->landlord);
			    
			    else
			    $fullname = $offer->landlord->business_profile->company_name??"";
			    
			    @endphp
                            <tr>
                                <td>
                                    <p>
                                        <strong>Landlord Full Name(s) :</strong><span class=""> {{$fullname}}</span>

                                            @if(isset($landlordSigners))
                                            @foreach($landlordSigners as $key=>$sign)
                                            <span class="">{{getPartnersName($sign)?? $sign->business_profile->company_name??""}}</span>
                                            @endforeach
                                            @endif

                                    </p>
                                </td>
                            </tr>
			    @php
                            if(isset($offer->tenantQuestionnaire) && $offer->tenantQuestionnaire->joint_cowners == config('constant.inverse_common_yes_no.Yes'))
                             $tenantSigners =  explode(',',$offer->tenantQuestionnaire->partners);
			    if(!empty($offer->tenant->user_profile->full_name))
			    $tenantFullName = getFullName($offer->tenant)??'';
			    
			    else
			    $tenantFullName = $offer->tenant->business_profile->company_name??"";
                            @endphp
                            <tr>
                                <td>
                                    <p>
                                        <strong>Tenant Full Name(s) :</strong><span class=""> {{$tenantFullName}}</span>

                                            @if(isset($tenantSigners))
                                            @foreach($tenantSigners as $key=>$sign)
                                            <span class="">{{getPartnersName($sign) ?? $sign->business_profile->company_name??""}}</span>
                                            @endforeach
                                            @endif

                                    </p>
                                </td>
                            </tr>
                            <tr>
                                <td><p><strong>Property Information :<span> {{$offer->property->architechture->describe_your_home??"NA"}}</span></strong></p></td>
                            </tr>
                            <tr>
                                <td><p><strong>Street Address :</strong><span> {{$offer->property->street_address??"NA"}}</span></p></td>
                            </tr>
                            <tr>
                                <td><p><strong>City, State, Zip :</strong> <span>{{getCityName($offer->property->city_id)}}, {{findState($offer->property->state_id)}}, {{findZipCode($offer->property->zip_code_id)}}</span></p></td>
                            </tr>
                            <tr>
                                <td><p><strong>Security Deposit Required :</strong> <span>{{$offer->landlordQuestionnaire->security_deposit??"NA"}}</span></p></td>
                            </tr>
                            <tr>
                                <td><p><strong>Lease Term</strong><span>{{ $offer->lease_term??"NA"}}</span></p></td>
                            </tr>
                            <?php
                            if(isset($offer->landlordQuestionnaire) && $offer->landlordQuestionnaire ){
                            $mothCount = $offer->month_count-1;
                            $effectiveDate = date('Y-m-d', strtotime("+$mothCount months", strtotime($offer->landlordQuestionnaire->effective_start_date)));
                            $d = new DateTime($effectiveDate);
                            }
                            ?>
                            <tr>
                                <td><p><strong>Begin Date :</strong><span> {{$offer->landlordQuestionnaire->effective_start_date??"NA"}}</span></p></td>
                            </tr>
                            <tr>
                                <td><p><strong>End Date :</strong><span> {{$effectiveDate??"NA"}}</span></p></td>
                            </tr>
                            <tr>
                                <td><p><strong>Contingency  :</strong><span> {{(isset($offer->landlordQuestionnaire->require_cosigner) && $offer->landlordQuestionnaire->require_cosigner == config('constant.inverse_common_yes_no.Yes')) ? "A Co-signer is required on the lease, and is not effective until a Co-Signer is secured to the Lease Agreement" : "NA"}}</span></p></td>
                            </tr>
                            <tr>
                                <td><p><strong>Furnishings :</strong><span> {{$offer->landlordQuestionnaire->furnishings??""}}</span></p></td>
                            </tr>
                            <tr>
                                <td><p class="para-text"><strong>Pet Policy : </strong>A reasonable number of pets or animals are allowed to be kept in or about the Premises. If this privilege is abused, the Landlord may revoke this privilege upon thirty (30) days notice. The animals that may be permitted are as follows: Dog/Cat- Non-refundable Pet fee of $500. Any other pets must be given written consent by the landlord before being kept on the premises.</p></td>
                            </tr>
                            <tr>
                                <td><p><strong>Landlord Provided Services/Utilities :</strong><span> {{$offer->landlordQuestionnaire->utilities??""}}</span></p></td>
                            </tr>

                        </tbody>
                    </table>
                    {{ html()->form('POST', route('frontend.sdThankyouForReviewSummaryKeyTermsLandlord'))->class('')->attribute('role', 'form')->open() }}
                    <div class="form-group">
                        <div class="checkbox">
                            <p class="align-left"><strong>I have reviewed the above (summary) terms and agree this information is correct to the best of my knowledge. Further, I understand that Freezyist.com is not providing legal guidance and recommends I consult with an attorney regarding these and other relevant legal matters.</strong>
                            </p>
                            <input type="checkbox" class="styled-checkbox for-agree" data-rule-required="true" name="agree" id="agree" value="Y" required="required" aria-required="true">
                            <label for="agree" id="agree_label"><b>I Understand and Agree</b></label>
                            <label class="error" id="agree-error"  style="display: none">Please check this to proceed</label>
                        </div>
                    </div>
                    <div class="lager-content-button">
                        <div class="bottom_btns pull-right btns-green-blue">
                            <button type="submit" id="proceed-review" class="button btn btn-blue">Proceed To Review Documents</button>
                        </div>
                    </div>
                    {{ html()->form()->close() }}
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
                $('#agree-error').css("display", "block");
            } else if ($('.for-agree').prop("checked") === false) {
                $('#agree-error').hide();
            }
        });
    });
</script>
@endsection