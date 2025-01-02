@extends ('frontend.layouts.app')
@section ('title', ('Sd Thankyou You For Review Summary Key Terms Landlord'))
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
                <div class="nested-div">
                    @if(isset($lead) && $lead)
                        <div class="heading-text">
                            <h2>Signatures Step 1 of 3: Lead-Based Paint Disclosure</h2>
                        </div>
                        <div class="para-text">
                            <p class="first-child">You are well on your way! </p>
                            <p>The following document [Lead-Based Paint Disclosure] is a required document for homes built prior to 1978. </p>
                            <ul>
                                <li>Please review and complete the form to the best of your knowledge.</li>
                            </ul>
                        </div>
                        <div class="btns-green-blue">
                            <a href="{{route('frontend.sdLeadBasedPaintHazardsDisclosureForRentByLandlord')}}" class="btn btn-blue">Next</a>
                        </div><!--</btns-green-blue>-->
                    @else
                        <div class="heading-text">
                            <h2>Signatures Step 2 of 3: Property Condition Disclaimer</h2>
                        </div>
                        <div class="para-text">
                            <p class="first-child">Keep going, you're nearly there!</p>
                            <p>You may have also noticed you skipped a step - don't worry, we have customized your experience to meet your specific needs.</p>
                            <p>The Property Condition Disclaimer form is a required disclosure.</p>
                            <ul>
                                <li> Please review this form carefully to understand the condition of the property as presented by the landlord(s).</li>
                                <li>Known Defects on the property should be clearly disclosed.</li>
                            </ul>
                            <p><b>*FREEZYLIST is not responsible for inadequate disclosures. State disclosure requirements are not standardized and may vary; please consult your attorney to ensure compliance with all required and recommended disclosure requirements.* </b></p>
                        </div>
                        <div class="btns-green-blue">
                            <a href="{{route('frontend.sdDisclosuresRentLandlord')}}" class="btn btn-blue">Next</a>
                        </div><!--</btns-green-blue>-->
                    @endif
                </div>
            </div> 
        </div><!--</col>-->
    </div><!--</row>-->
</div><!--</contract-tools-seller-common>-->
@endsection

