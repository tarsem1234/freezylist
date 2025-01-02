@extends ('frontend.layouts.app')
@section ('title', ('VA-FHA Loan Addendum'))
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
                <div class="nested-div register-page">
                    <div class="heading-text">
                        <h2>SIGNATURES Step 6 of 6: Purchase and Sale Agreement</h2>
                    </div>
                    <div class="para-text">
                        <p class="first-child">Your final and most important document is the Purchase and Sale Agreement.</p>
                        <p>In this form, it is critical that you confirm:</p>
                        <ul>
                            <li>  Buyer Name(s)</li>
                            <li>  Earnest Money Escrow Agent (Third Party Attorney, Broker, Title Company, etc.)</li>
                            <li>  Any Special Contingencies.</li>
                            <li>     Responsive image	Your understanding of the terms of the contract.</li>
                        </ul>
                    </div>
                    <div class="btns-green-blue col-lg-12">
                        <a href="{{ route('frontend.sdUpdateSaleAgreement') }}" class="button btn btn-green">next</a>
                    </div>
                </div>
            </div>
        </div><!--</col>-->
    </div><!--</row>-->
</div><!--</contract-tools-seller-common>-->
@endsection
