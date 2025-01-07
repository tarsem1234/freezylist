@extends ('frontend.layouts.app')
@section ('title', ('Thankyou Purchase Agreement By Buyer'))
@section('after-styles')
<link type="text/css" rel="stylesheet" href="{{ asset(mix('css/contract-tools-buyer.css')) }}" media="all"> 
@endsection
@section('content')
<div class="container purchase-sale-agreement-review contract-tools-seller-common dis-que">
    <div class="row">
        <div class=""> 
            <div class="sidebar">
                @include('frontend.includes.sidebar')
            </div>
            <div class="col-md-9 col-sm-8">
                <div class="nested-div register-page">
                    <div class="heading-text">
                        <h2> Step 5 of 6: Post-Closing Occupancy Agreement Review</h2>
                    </div>
                    <div class="para-text">
                        <p class="first-child">The following form serves as a short-term "Lease" effective after the purchase of your property- We have provided this information as a guide for both yourself and your seller.</p>
                        <p>Please Note:</p>
                        <ul>
                            <li> The Seller has requested additional time to retain the property after the closing date.</li>
                            <li>Effectively, the seller is asking to lease the property after the change of ownership.</li>
                        </ul>
                    </div>
                    <div class="btns-green-blue">
                        <a href="{{route('frontend.postClosingOccupancyAgreementByBuyer')}}" class="btn btn-blue">Next</a>
                    </div><!--</btns-green-blue>-->
                </div>
            </div>
        </div><!--</col>-->
    </div><!--</row>-->
</div><!--</contract-tools-seller-common>-->
@endsection
