@extends ('frontend.layouts.app')
@section ('title', ('Post Closing Questions Thankyou'))
@section('after-styles')
<link type="text/css" rel="stylesheet" href="{{ asset(mix('css/contract_tools.css')) }}" media="all">
@endsection
@section('content')
<div class="container post-closing-occupancy-agreement-review contract-tools-seller-common">
   <div class="row ">
      <div class="">  
         <div class="sidebar">
            @include('frontend.includes.sidebar')
         </div>
         <div class="col-md-9 col-sm-8">
            <div class="nested-div">
               <div class="heading-text">
                  <h2>Step 3 (b) of 6: Post-Closing Occupancy Agreement Review</h2>
               </div>
               <div class="para-text">
                  <p class="first-child">Based on your answers, we have prepared a draft of your Post-Closing Occupancy Agreement.</p>
                  <p>This form serves as a short-term "Lease" effective after the sale of your property- We have provided this information 
                     as a guide for both yourself and your buyer. </p>
                  <p>Further, we have added a contingency to your final purchase and sale agreement; however, we recommend consulting 
                     with your attorney as your real estate transaction will involve additional complexity.</p>
                  <p class="last-child">
                     * <span>Freezylist</span> is not qualified to provide legal advice.*
                  </p>
               </div>
               <div class="btns-green-blue">
                  <a href="{{route('frontend.postClosingOccupancyAgreement')}}" class="btn btn-blue">Next</a>
               </div>
            </div>
         </div>
      </div> 
   </div>
</div>
@endsection