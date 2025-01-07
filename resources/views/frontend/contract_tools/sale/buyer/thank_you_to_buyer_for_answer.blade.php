@extends ('frontend.layouts.app')
@section ('title', ('Thank You To Buyer For Answer'))
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
                    <div class="heading-text">
                        <h2> You are already making a huge impact!</h2>
                    </div>
                    <div class="para-text">
                        <p class="first-child">The questions you just answered have been logged and<b> your documents are now completely ready!</b> Now it is important to review the documents to make sure everything is correct. </p>
                        <p>Take some care to review the following "Summary of Key Terms", noting:</p>
                        <ul>
                            <li>Buyer Name(s)</li>
                            <li> Price & Terms</li>
                            <li>Any Special Items required of the seller.</li>
                        </ul>                  
                    </div>
                    <div class="btns-green-blue">
                        <a href="{{route('frontend.summaryKeyTermsForBuyer')}}"  class="btn btn-blue">Next</a>
                    </div>
                    <div class="para-text">
                        <h5 class="first-child">
                            * We offer the following summary as a convenience to our users - please consult your closing attorney for assistance with legal documents.* 
                        </h5>
                    </div>
                </div>
            </div>
        </div> 
    </div>
</div>
@endsection