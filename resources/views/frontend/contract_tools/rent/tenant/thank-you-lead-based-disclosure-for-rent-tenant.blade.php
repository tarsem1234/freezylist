@extends ('frontend.layouts.app')
@section ('title', ('Thank You Seller For Answer'))

@section('after-styles')
<link type="text/css" rel="stylesheet" href="{{ asset(mix('css/contract_tools.css')) }}" media="all">
@endsection

@section('content')
<div class="container questionnairer-results contract-tools-seller-common">
   <div class="row ">
      <div class="">
         <div class="sidebar">
            @include('frontend.includes.sidebar')
         </div>
         <div class="col-md-9 col-sm-8">
            <div class="nested-div">
               <div class="heading-text">
                  <h2>Step 2 of 3: Property Condition Disclosure</h2>
               </div>
               <div class="para-text">
                  <p class="first-child">Keep going - You're almost there!</p>
                  <p>The Property Condition Disclaimer form is a required disclosure.</p>
                  <ul>
                     <li>Please review the form in detail for known defects/issues in the property provided by the Seller.</li>
                     <li>Known Defects on the property should be clearly disclosed.</li>
                  </ul>

               </div>
                <div class="btns-green-blue pull-right">
                   <a href="{{route('frontend.disclosuresRentContractToolReviewTenant')}}" class="btn btn-blue">Next</a>
                </div>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection
