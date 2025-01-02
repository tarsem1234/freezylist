@extends ('frontend.layouts.app')
@section ('title', ('Sd Thankyou Purchase Agreement By Buyer'))
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
                    <div class="heading-text">
                        <h2>Congratulations</h2>
                    </div>
                    <div class="para-text">
                        <h5 class="first-child">Congratulations on purchasing your home and thank you for allowing us the opportunity to assist you in preparing your paperwork!</h5>
                        <p>At present, an email has been sent to the seller with instructions on how to proceed further. In addition to the automated email, it may be beneficial to send an update to your seller to keep in contact through this process - Communication will help enure this is a smooth process.</p>
                        <h5>Next Steps:</h5>
                        <ol>
                            <li>Now that you have signed the documents, please alert your Co-Signer(s) to proceed with signing (If Applicable).</li>
                            <li>After all the Buyers have signed, the Seller will receive email confirmation that the documents are ready to sign.</li>
                            <li> Once all signatures are applied, a) The Seller will purchase the signed contracts, b) You will receive a download link, c) and proceed with the Due Diligence Process!</li>                   
                        </ol>
                        <h5>The process is simple, just keep good communication channels open throughout the process.</h5>
                    </div>
                    <div class="btns-green-blue">
                        <a href="{{route('frontend.sent.offers','#Sale')}}" class="btn btn-blue">Return to Your Account</a>
                    </div><!--</btns-green-blue>-->
                </div>
            </div>
        </div><!--</col>-->
    </div><!--</row>-->
</div><!--</contract-tools-seller-common>-->
@endsection
