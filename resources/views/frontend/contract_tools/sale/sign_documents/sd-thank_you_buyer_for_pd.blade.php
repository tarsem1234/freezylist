@extends ('frontend.layouts.app')
@section ('title', ('Sd Thank You Buyer For Pd'))
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
            <div class="col-sm-9">
                <div class="nested-div">

                    <?php if($property->architechture['year_built'] < config('constant.year_built')) { ?>
                    <div class="heading-text">
                        <h2>Signatures Step 3 of 6: Lead-Based Paint Disclosure</h2>
                    </div>
                    <div class="para-text">
                        <p class="first-child">You are well on your way!  </p>
                        <p>The following document [Lead-Based Paint Disclosure] is a required document for homes built prior to 1978. </p>
                        <ul>
                            <li>  Please review and complete the form to the best of your knowledge.</li>
                        </ul>
                    </div>
                    <div class="btns-green-blue">
                         <a href="{{route('frontend.sdLeadBasedPaintHazardsUpdateByBuyer')}}" class="btn btn-blue">Next</a>
                    </div><!--</btns-green-blue>-->
                    <?php } else { ?>
                    <div class="heading-text">
                        <h2>Signatures Step 6 of 6: Purchase and Sale Agreement</h2>
                    </div>
                    <div class="para-text">
                        <p class="first-child">Congratulation, this is your last step! </p>
                        <p>You may have also noticed that you skipped a few steps- Don't worry, we customized your documents to your unique needs based on the information provided by both parties.</p>
                        <p>Please review your Purchase and Sale Agreement.</p>
                        <p>Before applying your signature on this form, it is critical that you confirm [& Update, if needed]:</p>                  <ul>
                            <li> Buyer Name(s)</li>
                            <li class="img-hand">To update - Navigate to "My Account"-> "Edit Profile" -> "Full (Legal) Name"</li>
                            <li>Earnest Money Escrow Agent (Third Party Attorney, Broker, Title Company, etc.)</li>
                            <li class="img-hand"><b> Never send money directly to the seller! </b>If the seller has requested earnest money, send the money directly to the agent, with a copy of the purchase and sale agreement!</li>
                            <li>Real Estate Commissions (If Applicable)</li>
                            <li> Any designated closing dates and/or offer expiration you requested.</li>
                            <li> Your understanding of the terms of the contract.</li>
                        </ul>
                    </div>
                    <div class="btns-green-blue">
                         <a href="{{route('frontend.sdUpdateSaleAgreementBuyer')}}" class="btn btn-blue">Next</a>
                    </div><!--</btns-green-blue>-->
                    <?php } ?>
                </div>
            </div>
        </div><!--</col>-->
    </div><!--</row>-->
</div><!--</contract-tools-seller-common>-->
@endsection
