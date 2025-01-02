@extends ('frontend.layouts.app')
@section ('title', ('Thankyou Buyer For Pd'))
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
                        <h2>Signatures Step 6 of 6: Purchase and Sale Agreement</h2>
                    </div>
                    <div class="para-text">
                        <p class="first-child">Congratulation, this is your last step! </p>
                        <p>You may have also noticed that you skipped a few steps- Don't worry, we customized your documents to your unique needs based on the information provided by both parties.</p>
                        <p>Please review your Purchase and Sale Agreement.</p>
                        <p>Before applying your signature on this form, it is critical that you confirm [& Update, if needed]:</p>
                        <ul>
                            <li> Buyer Name(s)</li>
                            <li class="img-hand">To update - Navigate to "My Account"-> "Edit Profile"-> "Full (Legal) Name"</li>
                            <li>Earnest Money Escrow Agent (Third Party Attorney, Broker, Title Company, etc.)</li>
                            <li class="img-hand">Never send money directly to the seller! If the seller has requested earnest money, send the money directly to the agent, with a copy of the purchase and sale agreement!</li>
                            <li>Real Estate Commissions (If Applicable)</li>
                            <li> Any designated closing dates and/or offer expiration you requested.</li>
                            <li> Your understanding of the terms of the contract.</li>
                        </ul>
                    </div>
                    <div class="btns-green-blue">
                        <a href="{{route('frontend.sdUpdateSaleAgreement')}}" class="btn btn-blue">Next</a>
                    </div><!--</btns-green-blue>-->
                </div>
            </div>
        </div><!--</col>-->
    </div><!--</row>-->
</div><!--</contract-tools-seller-common>-->
@endsection
