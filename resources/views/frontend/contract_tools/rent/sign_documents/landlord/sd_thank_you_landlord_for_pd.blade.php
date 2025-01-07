@extends ('frontend.layouts.app')
@section ('title', ('Sd Thank You Landlord For Pd'))  
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
                  <h2>Signatures Step 3 of 3: Lease Agreement</h2>
               </div>
               <div class="para-text">
                  <p class="first-child">Congratulation, this is your last step! </p>
                  <p>Please review your Lease Agreement. </p>
                  <p>In this form, it is critical that you confirm [& Update, if needed]:</p>  
                  <ul>
                     <li> Tenant Name(s) and Contact Information </li>
                     <li class="img-hand">To update - Navigate to "My Account"-> "Edit Profile" -> "Full (Legal) Name"</li>
                     <li> Rental $ Price </li>
                     <li> Security and Pet Deposits (If Applicable)  </li>
                     <li> Your understanding of the terms of the contract. </li>
                  </ul>
               </div>
               <div class="btns-green-blue">
                  <a href="{{route('frontend.sdLeaseAgreementByLandlord')}}" class="btn btn-blue">Next</a> 
               </div><!--</btns-green-blue>-->
            </div>
         </div>
      </div><!--</col>-->
   </div><!--</row>-->
</div><!--</contract-tools-seller-common>-->
@endsection