@extends ('frontend.layouts.app')
@section ('title', ('Thankyou You For Review Summary Key Terms'))
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
                  <h2>Step 1 of 3: Lead-Based Paint Disclosure</h2>
               </div>
               <div class="para-text">
                  <p class="first-child">Welcome to the document review process!</p>
                  <p>The following document [Lead-Based Paint Disclosure] is a required document for homes built prior to 1978. </p>
                  <ul>
                     <li>Please review and complete the form to the best of your knowledge.</li>
                  </ul>
               </div>
                  <div class="btns-green-blue">
                  <a href="{{route('frontend.leadBasedPaintHazardsRent')}}" class="btn btn-blue">Next</a>
                </div>
                @else
               <div class="heading-text">
                  <h2>Thank you for review the summary</h2>
               </div>
               <div class="para-text">
                  <p class="first-child">Keep going - You're almost there!</p>
                  <p>The Property Condition Disclaimer form is a required disclosure.</p>
                  <ul>
                     <li> Please review the form in detail for known defects/issues in the property provided by the Seller.</li>
                     <li>Known Defects on the property should be clearly disclosed.</li>
                  </ul>
                  <p><b>FREEZYLIST is not responsible for inadequate disclosures; State disclosure requirements are not standardized and may vary.</b></p>
               </div>
               <div class="btns-green-blue">
                  <a href="{{route('frontend.disclosuresRentContractToolReviewTenant')}}" class="btn btn-blue">Next</a>
               </div><!--</btns-green-blue>-->
                @endif
            </div>
         </div>
      </div><!--</col>-->
   </div><!--</row>-->
</div><!--</contract-tools-seller-common>-->
@endsection
