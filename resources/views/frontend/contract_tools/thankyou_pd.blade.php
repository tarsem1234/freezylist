@extends ('frontend.layouts.app')

@section ('title', ('Purchase and Sale Agreement Review (Draft)'))

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
                  <h2>Step 6 of 6: Purchase and Sale Agreement Review (Draft)</h2>
               </div>
               <div class="para-text">
                  <p class="first-child">Please review your draft Purchase and Sale Agreement. </p>
                  <h5>In this form, it is critical that you confirm [& Update, if needed]:</h5>
                  <ul>
                     <li> Seller Name(s)</li>
                     <li class="img-hand">To update - Navigate to "My Account"-> "Edit Profile" -> "Full (Legal) Name"</li>
                     <li>Earnest Money Escrow Agent (Third Party Attorney, Broker, Title Company, etc.)</li>
                     <li class="img-hand">To find an escrow agent, search using our "Network Portal" menu option!</li>
                     <li>Real Estate Commissions (If Applicable)</li>
                     <li>Responsive image	Your understanding of the terms of the contract.</li>
                  </ul>
               </div>
               <div class="btns-green-blue">
                  <a href="{{route('frontend.updateSaleAgreementBysellerContract')}}" class="btn btn-blue">Next</a>
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
