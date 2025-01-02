@extends ('frontend.layouts.app')
@section ('title', ('Question Set For Tenant'))
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
                  <h2>Step 1 of 5: Notice to Tenant</h2>
               </div>
               <div class="para-text">
                  <p class="first-child">Congratulations on a finding a home! </p>
                  <p>In the next few steps, you will review the lease agreement and disclosures, which are based on the terms you defined in the accepted offer.</p>
                  <p>Before you begin, it is important that you confirm [& Update, if needed]:</p>  
                  <ul>
                     <li> Your Legal Name </li>
                     <li> Your Current Mailing Address  </li>
                     <li> Other Contact Information.  </li>
                     <li class="img-hand">To update - Navigate to "My Account"-> "Edit Profile" -> "Full (Legal) Name"</li>
                  </ul> 
               </div>
               <div class="btns-green-blue">
                  <a href="{{route('frontend.addSignersContractRentTenant')}}" class="btn btn-blue">next</a>
               </div><!--</btns-green-blue>-->
            </div>
         </div>
      </div><!--</col>-->
   </div><!--</row>-->
</div><!--</contract-tools-seller-common>-->
@endsection
