@extends ('frontend.layouts.app')
@section ('title', ('Thankyou Purchase Agreement By Buyer'))
@section('after-styles')
<link type="text/css" rel="stylesheet" href="{{ asset(mix('css/contract-tools-buyer.css')) }}" media="all"> 
@endsection
@section('content')
<div class="container purchase-sale-agreement-review contract-tools-seller-common dis-que">
    <div class="row">
        <div class=""> 
            <div class="sidebar">
                @include('frontend.includes.sidebar')
            </div>
            <div class="col-md-9 col-sm-8">
                <div class="nested-div register-page">
                    <div class="heading-text">
                        <h2> Step 1 of 6: Advisory to Buyers and Sellers</h2>
                    </div>
                    <div class="para-text">
                        <p class="first-child">Congratulations on your accepted offer!</p>
                        <p>We know this is an exciting for you; however, there are some items you may want to consider throughout this process. </p>
                        <p>Please review the following document for information to consider in your transaction; albeit, you do not need to be an expert and understand all the aspects of this document. </p>
                        <ol>
                            <li>We encourage buyers to request a home inspection by a qualified home inspector, who will inspect the home and provide a reasonable level of assurance that you are buying a quality property.</li>
                            <li>We encourage the use of licensed Attorneys in your state, who can provide legal advice on your transaction.</li>
                            <li>We encourage obtaining the services of a Title Company and the accompanying Title Insurance, which helps ensure clean title transfer.</li>
                           </ol>
                        <p>If you have any other questions, your property network [Network Portal] can connect you with specialists in all the areas of consideration.</p>
                        <h5>* FREEZYLIST's recommendations are provided as information only. *</h5>
                    </div>
                    <div class="btns-green-blue">
                        <a href="{{route('frontend.advisoryToBuyersAndSellers')}}" class="btn btn-blue">Next</a> 
                    </div><!--</btns-green-blue>-->
                </div> 
            </div>
        </div><!--</col>-->
    </div><!--</row>-->
</div><!--</contract-tools-seller-common>-->
@endsection


