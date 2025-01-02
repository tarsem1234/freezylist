@extends ('frontend.layouts.app')
@section ('title', ('Sd Advisory To Buyers and Sellers Thank You Buyer'))
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
            <div class="col-sm-9">
                <div class="nested-div">
                    <div class="heading-text">
                  <h2>Signatures Step 5 of 6: Post-Closing Occupancy Agreement Review</h2>
               </div>
               <div class="para-text">
                  <p class="first-child">You're nearly there! </p>
                  <p>The following form serves as a short-term "Lease" effective after the purchase of your property- We have provided this information as a guide for both yourself and your seller.</p>
                  <p>Please Note:</p>
                  <ul>
                     <li> The Seller has requested additional time to retain the property after the closing date.</li>
                     <li> Effectively, the seller is asking to lease the property after the change of ownership.</li>
                     <li>Also note: You will not sign this document. As this is a separate agreement, we recommend you review this document with your closing attorney or broker.</li>
                  </ul>
               </div>
                    <div class="btns-green-blue">
                        <a href="{{route('frontend.sdPostClosingOccupancyAgreementBySeller')}}" class="button btn btn-blue">Next</a>
                    </div><!--</btns-green-blue>-->
                </div>
            </div>
        </div><!--</col>-->
    </div><!--</row>-->
</div><!--</contract-tools-seller-common>-->
@endsection