@extends ('frontend.layouts.app')

@section ('title', ('Thankyou Discloser Tool'))

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
                  <h2>Step 5 of 5: Lease Agreement Review (Draft)</h2>
               </div>
               <div class="para-text">
                  <p class="first-child">Please review your draft Lease Agreement.  </p>
                  <h5>In this form, it is critical that you confirm [& Update, if needed]:</h5>
                  <ul>
                     <li>Landlord Name(s) and Contact Information</li>
                     <li class="img-hand">To update - Navigate to "My Account"-> "Edit Profile" -> "Full (Legal) Name"</li>
                     <li>Rental $ Price</li>

                     <li>Security and Pet Deposits (If Applicable)</li>
                     <li>Your understanding of the terms of the contract.</li>
                  </ul>
               </div>
               <div class="btns-green-blue">
                  <a href="{{route('frontend.leaseAgreement')}}" class="btn btn-blue">Next</a>
               </div>
            </div>
         </div>
      </div> 
   </div>
</div>






@endsection
@section('after-scripts')

<script>
   $(document).ready(function () {

   });

</script>


@endsection   

