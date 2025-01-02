@extends ('frontend.layouts.app')

@section ('title', ('Thank You To Landlord For Answer'))

@section('after-styles')
<link type="text/css" rel="stylesheet" href="{{ asset(mix('css/contract_tools.css')) }}" media="all">
@endsection

@section('content')
<div class="container seller-property-condition-disclosure contract-tools-seller-common">
   <div class="row ">
      <div class="">  
         <div class="sidebar">
            @include('frontend.includes.sidebar')
         </div>
         <div class="col-md-9 col-sm-8">
            <div class="nested-div">
                @if(isset($lead) && $lead)
               <div class="heading-text">
                  <h2>Step 3 of 5: Lead-Based Paint Disclosure</h2>
               </div>
               <div class="para-text">
                <p class="first-child">You are well on your way!</p>
                <ul>
                   <li>We have customized your documents based on the information you submitted on your listing.</li>
                </ul>
                <p>The following document [Lead-Based Paint Disclosure] is a required document for homes built prior to 1978.</p>
                <p class="last-child">Please review and complete the form to the best of your knowledge.</p>

                <div class="btns-green-blue">
                   <a href="{{route('frontend.leadBasedPaintHazardsRent')}}" class="btn btn-blue">Next</a>
                </div>
                @else
               <div class="heading-text">
                  <h2>Step 4 of 5: Property Condition Disclosure</h2>
               </div>
               <div class="para-text">
                  <p class="first-child">Keep going- You're almost there!</p>
                  <h5>The Property Condition Disclaimer form is a required disclosure.</h5>
                  <ul>
                     <li>Please complete the form to the best of your knowledge.</li>
                     <li> Known Defects on the property should be clearly disclosed.</li>
                     <li>Consult with your closing attorney to discover if any other disclosures should be provided to the Buyer.</li>
                  </ul>
                  <p class="last-child">
                     * <span>freezylist</span> is not responsible for inadequate disclosures. State disclosure requirements are not
                     standardized and may vary; please consult your closing attorney to ensure you are in compliance with 
                     all required and recommended disclosure requirements.* 
                  </p>
               </div>
               <div class="btns-green-blue">
                  <a href="{{route('frontend.disclosuresRentContractTool')}}" class="btn btn-blue">Next</a>
               </div>
                @endif
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
