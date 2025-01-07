@extends ('frontend.layouts.app')
@section ('title', ('Sd Thankyou Lease Agreement Landlord'))
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
                  <p class="first-child">You have successfully completed your part of the document preparation and signing. If all the parties to the contract have completed the signing process, please proceed to purchase your signed contracts.</p>
                  <p><b>Please Note: </b>Only the Primary Landlord on the listing has the option to purchase the documents. </p>
                  <ul>
                     <li class="img-hand mar-left">Login --> My Account --> My Offers -->Received --> Select the Appropriate Offer. If all signatures are applied, the Primary Landlord will see a link to "Purchase Signed Documents."</li>                     
                  </ul> </div> 
		<div class="form-group btns-green-blue">
                     <div class="col-sm-12">
                        <div class="btns-green-blue">
			    @php
			    if(!empty(Session::get('user_type')))
			    $path = route('frontend.signDocumentsLandlord');
			    else
				$path = route('frontend.recieved.offers');
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


