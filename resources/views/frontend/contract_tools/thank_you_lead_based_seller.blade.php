@extends ('frontend.layouts.app')

@section ('title', ('Thank-You-Lead-Based'))
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
                  <h2>Step 4 of 6: Lead-Based Paint Disclosure</h2>
               </div>
               <div class="para-text">
                  <p class="first-child">The Lead-Based Paint disclosure is a required document for homes built prior to 1978.</p>
                  <p>The EPA provides an informative brochure on the potential effects of Lead-Based Paint exposure- Please read the attached brochure on the following document.</p>
                  <ul>
                     <li>Please review the seller's remarks and complete the form to the best of your knowledge.</li>
                  </ul>
               </div>
               <div class="btns-green-blue">
                  <a href="{{route('frontend.leadBasedPaintHazards')}}" class="btn btn-blue">Next</a>
               </div>
            </div>
         </div>
      </div> 
   </div>
</div>
@endsection