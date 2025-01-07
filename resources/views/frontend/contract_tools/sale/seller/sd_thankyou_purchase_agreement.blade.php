@extends ('frontend.layouts.app')
@section ('title', ('Thankyou Purchase Agreement By Buyer'))
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
                        <h2>Congratulation</h2>
                    </div>
                    <div class="para-text">                     
                        <p class="first-child">You have successfully completed your part of the document preparation and signing. If all the parties to the contract have completed the signing process, please proceed to purchase your signed contracts.</p>                       
                        <ul>
                            <li>To purchase the agreements you must be the primary seller on the listing.</li>
                            <li class="img-hand"> Login --> My Account --> My Offers --> Received --> </li>
                            <li>Select the Appropriate Offer. If all signatures are applied, you should see a link to Purchase Signed Documents.</li>
                        </ul>                                                                    
                        <div class="btns-green-blue">
                        <a href="{{route('frontend.recieved.offers','#Sale')}}" class="btn btn-blue">Click Here</a> 
                    </div><!--</btns-green-blue>-->
                    </div>
                </div>
            </div>
        </div><!--</col>-->
    </div><!--</row>-->
</div><!--</contract-tools-seller-common>-->
@endsection


