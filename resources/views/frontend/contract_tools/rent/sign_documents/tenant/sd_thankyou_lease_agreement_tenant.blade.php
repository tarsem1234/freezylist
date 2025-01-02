@extends ('frontend.layouts.app')
@section ('title', ('Sd Thankyou Lease Agreement Tenant'))
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
                  <h2>Congratulation</h2>
               </div>
               <div class="para-text">
                  <p class="first-child"><b>Congratulations on reviewing & signing your contracts!</b></p>
                  <p>Next Steps:</p>
                  <ol>
                      <li>The Landlord will receive an automated email, informing them that the contracts are ready for them to sign - You may want to reach out as well to keep communication open.</li>
                      <li> The Landlord(s) will electronically sign the documents</li>
                      <li>You will receive a link to download the contracts & you're done with the legalese!</li>
                  </ol>
                  <p>As always, be sure to keep communication open and we hope you enjoyed this process as much as we enjoyed creating it!</p>
               </div>
                <div class="form-group btns-green-blue">
                     <div class="col-sm-12">
                        <div class="btns-green-blue">
			    @php
			    if(!empty(Session::get('user_type')))
			    $path = route('frontend.signDocumentsTenant');
			    else
				$path = route('frontend.sent.offers');
			    @endphp
                            <a href="{{$path}}" type="submit" class="button btn btn-blue">Return to Your Account</a>
                        </div>
                     </div>
                  </div> 
            </div>
         </div>
      </div><!--</col>-->
   </div><!--</row>-->
</div><!--</contract-tools-seller-common>-->
@endsection


