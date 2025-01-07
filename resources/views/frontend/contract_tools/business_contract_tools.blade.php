@extends ('frontend.layouts.app')
@section ('title', ('Lead-Based Paint Hazards'))
@section('after-styles')
<link type="text/css" rel="stylesheet" href="{{ asset(mix('css/contract-tools-buyer.css')) }}" media="all">
@endsection
@section('content')
<div class="container purchase-sale-agreement-review contract-tools-seller-common register-page congrats-contact-tool">
    <div class="row">
        <div class="">
            <div class="sidebar">
                @include('frontend.includes.sidebar')
            </div>
            <div class="col-md-9 col-sm-8"> 

                <div class="nested-div register-page">
                    <div class="heading-text">
                        <h2>Congratulations on your Offer!</h2>
                    </div>
                    <div class="para-text row">
                        <div class="form-group">
                            <div class="col-md-12 congrats-para">
                                <p>"Congratulations! You have found a buyer for your property!</p>
                                <p>So, what's next...?</p>
                                <p>Generally, in order to collect a commission on the management of real property in the United States, you must be a licensed real estate broker/agent. Due to this requirement, our proprietary services are only available to our "By Owner" users.</p>
                                <p>The great news is you have a serious offer! Please reach out to your potential tenant with instructions on how to proceed with making an official offer and launching the due diligence process!</p>
                                <div class="congo-contract">
                                    <div class="col-sm-3">Buyer's Information:</div>
                                    <div class="col-sm-9">
                                        <p>Buyer's Name - {{$buyer->user_profile->full_name??"NA" }}</p>	 
                                        <p>Buyer's Email - {{$buyer->email??"NA"}}</p>	 
                                        <p>Buyer's Phone - {{$buyer->phone??"NA"}}</p>
                                    </div>
                                </div>	 
                                <p>Thank you!"</p>
                            </div><!--col-md-12-->
                        </div>
                    </div>
                </div>

            </div><!--</col>-->
        </div><!--</col>-->
    </div><!--</row>-->
</div><!--</contract-tools-seller-common>-->
@endsection