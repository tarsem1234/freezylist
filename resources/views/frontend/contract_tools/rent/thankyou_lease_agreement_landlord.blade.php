@extends ('frontend.layouts.app')
@section ('title', ('Thankyou Lease Agreement Landlord'))
@section('after-styles')
<link type="text/css" rel="stylesheet" href="{{ asset(mix('css/contract_tools.css')) }}" media="all"> 
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
                  <h2>Thank You!</h2>
               </div>
               <div class="para-text">
                  <h5 class="first-child">Thank you for submitting your answers and reviewing your documents!</h5>
                  <h5>Next Steps:</h5>  
                  <ol>
                     <li> The Tenant(s) will receive a notification email for directions.</li>
                     <li> The Tenant(s) will add any additional tenants noted in the offer.</li>
                     <li>The Tenant(s)complete their document review process.</li>
                     <li> After review, the tenant(s) will electronically sign the agreements.</li>
                     <li> Once all the tenants have signed, you will proceed to electronically sign & you're done!</li>
                  </ol>
                  <h5>Currently, an email has been sent to the primary tenant to begin their process - Keep Open Communication!.</h5>
               </div>
               <div class="btns-green-blue">
                  <a href="{{route('frontend.recieved.offers')}}" class="btn btn-blue">Click Here To Return To Your Account</a>  
               </div><!--</btns-green-blue>-->
            </div>
         </div>
      </div><!--</col>-->
   </div><!--</row>-->
</div><!--</contract-tools-seller-common>-->
@endsection
