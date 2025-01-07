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
                  <h2>Questionnaire Results</h2>
               </div>
               @if(isset($houseownersAssociations) && $houseownersAssociations)
               <div class="para-text">
                  <p class="first-child">Thank you for completing your questionnaire!</p>

                  <p>
                     Based on the answers you provided, your property is not occupied by a tenant (Leased),
                     nor will you require additional time for closing..... So we are routing you past a few steps!
                  </p>
                  <p>In the next few steps, you will need to complete three forms:</p>
                  <ul>
                    @if(isset($lead) && $lead)
                     <li>Lead-Based Paint Disclosure.</li>
                     @endif
                     <li>Property Condition Disclosure.</li>
                     <li>Purchase and Sale Agreement.</li>
                  </ul>
                  <div class="btns-green-blue">
                    @if(isset($lead) && $lead)
                     <a href="{{route('frontend.thankYouLeadBased')}}" class="btn btn-green">Next</a>
                     @else
                     <a href="{{route('frontend.sellerPropertyConditionDisclosure')}}" class="btn btn-green">Next</a>
                     @endif
                  </div>
               </div>
               @else
               <div class="para-text">
                  <p>
                     Based on the answers you provided, your property is currently occupied by a tenant (Leased),
                     or you may require additional time after the expected close date to vacate the property- We
                     have included this as a stipulation [See Stipulation B] in the Purchase and Sale Agreement.
                  </p>
                  <p>To help us take you to the appropriate next step, please answer the following question:</p>
                  <h4>
                     Is this property currently occupied by a tenant/ subject to a lease?
                  </h4>
               </div>
               <div class="btns-green-blue">
                   @if(isset($lead) && $lead)
                     <a href="{{route('frontend.thankYouLeadBased',1)}}" class="btn btn-green">Yes</a>
                   @else
                  <a href="{{route('frontend.sellerPropertyConditionDisclosure')}}" class="btn btn-green">Yes</a>
                   @endif
                  <a href="{{route('frontend.questionsToSellerProperty',2)}}" class="btn btn-blue">No</a>
               </div>
               <div class="para-text">
                  <p>If your property is subject to a lease, you may need to present a copy of the lease to the buyer.</p>
                  <p class="last-child">
                     If your property is not subject to a lease- Our contract tools will assist you in preparing a (draft)
                     post-closing occupancy agreement; however, we recommend you consult your attorney regarding this legal document,
                     as your real estate transaction will involve additional complexity.
                  </p>
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

