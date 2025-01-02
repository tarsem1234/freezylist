@extends ('frontend.layouts.app')
@section ('title', ('Thankyou Purchase Agreement By Buyer'))
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
                    <div class="heading-text">
                  <h2>Step 2 of 6: Property Condition Disclaimer</h2>
               </div>
               <div class="para-text">
                  <p class="first-child">The Property Condition Disclaimer form is a required disclosure.</p>
                  <ul>
                     <li>Please review the form in detail for known defects/issues in the property provided by the Seller.</li>
                     <li> Known Defects on the property should be clearly disclosed.</li>
                     <li> Consult with your closing attorney to discover if any other disclosures should be provided by the Seller.</li>
                  </ul>
                  <h5>* FREEZYLIST is not responsible for inadequate disclosures. State disclosure requirements are not standardized and may vary; please consult your closing attorney with any questions.*</h5>
               </div>
                    <div class="btns-green-blue">
                        <a href="{{route('frontend.disclosureByBuyerUpdate')}}" class="btn btn-blue">Next</a>
                    </div><!--</btns-green-blue>-->
                </div>
            </div>
        </div><!--</col>-->
    </div><!--</row>-->
</div><!--</contract-tools-seller-common>-->
@endsection
