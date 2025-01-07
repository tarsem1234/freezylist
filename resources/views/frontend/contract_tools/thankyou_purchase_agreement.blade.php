@extends ('frontend.layouts.app')
@section ('title', ('Thankyou Purchase Agreement'))
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
                  <h2>Congratulations</h2>
               </div>
               <div class="para-text">
                  <h5 class="first-child">Congratulations on selling your home and thank you for allowing us the opportunity to assist you in preparing your paperwork!</h5>
                  <p>At present, an email has been sent to the buyer with instructions on how to proceed further. In addition to the automated email, it may be beneficial to send an update to your buyer to keep in contact through this process - Communication will help enure this is a smooth process. </p>
                  <h5>Next Steps:</h5>  
                  <ol>
                     <li>The Primary Buyer will update their side, which usually asks a few questions relating to loan types and confirmation of terms. </li>
                     <li> Upon completing the buyer side review, the Buyer(s) should digitally sign the documents.</li>
                     <li>  After all the Buyers have signed, you will receive email confirmation that your documents are ready to sign. Yourself and any Co-signers will be able to then sign the documents as well.</li>
                     <li> Once all signatures are applied, you will purchase the signed contracts and proceed with the Due Diligence Process! </li>
                  </ol>
                  <h5>The process is simple, just keep good communication channels open throughout the selling process.</h5>
               </div>
               <div class="btns-green-blue">
                  <a href="{{route('frontend.recieved.offers','#Sale')}}" class="btn btn-blue">Return to Your Account</a>
               </div><!--</btns-green-blue>-->
            </div>
         </div>
      </div><!--</col>-->
   </div><!--</row>-->
</div><!--</contract-tools-seller-common>-->
@endsection
