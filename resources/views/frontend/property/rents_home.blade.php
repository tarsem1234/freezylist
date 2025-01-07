@extends ('frontend.layouts.app')

@section ('title', ('Rents'))

@section('after-styles')
<link type="text/css" rel="stylesheet" href="{{ asset(mix('css/home.css')) }}" media="all">
@endsection 

@section('content') 
<div class="row">
    <div id="owl-carousel" class="owl-carousel owl-theme owl-loaded owl-drag" >
        <div class="item properties-for-rent-bg-img ">
            <img src="{{ asset('/storage/site-images/rent.jpg') }}" class="img-responsive" />
            <div class="text-heading">
               <!-- <a>
                    <h1>Listings For Rent</h1>
                    <p>By Real Property Owners</p>
                </a> -->
            </div>
        </div>

       <div class="item properties-for-rent-bg-img ">
            <img src="{{ asset('/storage/site-images/rent.jpg') }}" class="img-responsive" />
            <div class="text-heading">
                <!-- <a>
                    <h1>Properties For Rent</h1>
                    <p>Listings Will Help You <span>Relax!</span></p>
                </a> -->
            </div>
        </div>
       <!-- <div class="item properties-for-rent-bg-img ">
            <img src="{{ asset('/storage/site-images/rent.jpg') }}" class="img-responsive" />
            <div class="text-heading">
                <a>
                    <h1>Properties For Rent</h1>
                    <p>Listings Will Help You <span>Relax!</span></p>
                </a>
            </div>
        </div>-->
    </div>
</div>

<div class="container explore-our-listings">
    <div class="col-md-12 btns-green-blue">   
        <a href="{{route('frontend.rentSearch')}}" class="btn btn-lg btn-green">Explore our Listings</a>
        <a href="{{route('frontend.rentCreate')}}" class="btn btn-lg btn-blue">List Your Property</a>
    </div>
</div>

<div class="our_owners_sol">
    @include('frontend.common-home-icon.common_home_icon')   
    <div class="row owner-sol-offers-row">
        <div class="container">
            <div class="col-sm-12 col-xs-12  owner-sol-offers">
                <h3>List & Relax - Our Platform is designed for homeowners & their needs</h3>
                <p>Our Owner Solutions Offer Powerful Simplicity, Confidence, and Complete Control</p>
                <div class="container bottom-para">
                    <p class="col-sm-12 col-xs-12">We give homeowners all the resources they need to sell or rent their home for money and zero out-of-pocket fees.  We give buyers and
                        renters the negotiation power they need to get the best deal on their future home. Because when a homeowner saves on commission, so do
                        potential prospects..it’s a win-win!
                    </p>
                </div>
            </div>
        </div>
    </div>
    <div class="row col-xs 12 all-icons-row">
        <div class="container">
            <div class="col-sm-12 col-xs-12 home-tools-row">
                <div class="col-sm-4 col-xs-12 img-div">
                    <img src="{{ asset('/storage/site-images/icon1.png') }}" class="img-responsive img-tools">
                    <p>Access to free premium home<br>tools</p>
                    <div class="col-sm-12 col-xs-12 btn-read-more">
                        <a href="{{route('frontend.help')}}" class="btn">Read More</a>
                    </div>
                </div>
                <div class="col-sm-4 col-xs-12 img-div">
                    <img src="{{ asset('/storage/site-images/icon2.png') }}" class="img-responsive">
                    <p>Professional home buying & renting<br>guidance.</p>
                    <div class="col-sm-12 col-xs-12 btn-read-more">
                        <a href="{{ route('frontend.learning.center') }}" class="btn">Read More</a>
                    </div>
                </div>
                <div class="col-sm-4 col-xs-12 img-div marketplace-div">
                    <img src="{{ asset('/storage/site-images/icon3.png') }}" class="img-responsive">
                    <p>Marketplace of trusted service<br>providers.</p>
                    <div class="col-sm-12 col-xs-12 btn-read-more">
                        <a href="{{route('frontend.network.support')}}" class="btn">Read More</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="recent-home-icon">
    @include('frontend.common-home-icon.common_home_icon')
</div>
<div class="row recent-listings">
    <div class="container">
        <div class=" col-sm-12 col-xs-12  heading-para">
            <h3>Recent Listings</h3>
        </div>

        <div class="bs-example bs-example-tabs" role="tabpanel" data-example-id="togglable-tabs">
            <ul id="myTab" class="nav nav-tabs nav-tabs-responsive text-center" role="tablist">       
                <a class="btn btn-sm btn-main active" href="#rent" role="presentation" id="rent-tab" role="tab" data-toggle="tab" aria-controls="rent" aria-expanded="true">
                    <span class="tab-text">Rent</span>
                </a>           
                <a href="#sale" class="btn btn-sm btn-main" role="tab" id="sale-tab" data-toggle="tab" aria-controls="sale">
                    <span class="tab-text">Sale</span>
                </a>    
                <a href="#vacation" class="btn btn-sm btn-main" role="tab" id="vacation-tab" data-toggle="tab" aria-controls="vacation">
                    <span class="tab-text">Vacation</span> 
                </a>   
            </ul>

            <div id="myTabContent" class="tab-content">
                <div role="tabpanel" class="tab-pane fade in active" id="rent" aria-labelledby="rent-tab">
                    <div class="row  mx-0">
                        <?php
                        if (isset($rentProperties) && count($rentProperties) > 0) {
                            foreach ($rentProperties as $rentProperty) {
                                ?>
                                <div class="col-md-3 col-sm-6 col-xs-12  image-div">
                                        <div class="listing-image-div">
                                            <img src="{{asset("storage/property_images/".$rentProperty->id .'/'.$rentProperty->images->first()->image)}}" class="img-responsive image" alt="property_image"/>
                                        </div>
                                    </a>
                                    <div class="col-md-3 col-sm-6 col-xs-12 caption main_single">
                                        <div class="property-details property-higlight">
                                            <h4><span class="money">{{round($rentProperty->price)}}</span></h4>
                                            <p><i class="far fa-flag"></i> {{ findState($rentProperty->state_id) }}</p>
                                            <p><i class="fa fa-square color-black" aria-hidden="true"></i> {{ $rentProperty->architechture->plot_size }}</p>
                                            <h6 class="single_fam"><i class="fa fa-home"></i> {{ config('constant.home_type.'.$rentProperty->architechture->home_type)??"" }}</h6>
                                            <a href="{{route('frontend.propertyDetails',$rentProperty->id)}}"><i class="fa fa-eye"></i>View Property</a>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                        }
                        ?>
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane fade" id="sale" aria-labelledby="sale-tab">
                    <div class="row mx-0">
                        <?php
                        if (isset($saleProperties) && count($saleProperties) > 0) {
                            foreach ($saleProperties as $saleProperty) {
                                ?>
                                <div class="col-md-3 col-sm-6 col-xs-12 image-div">
                                        <div class="listing-image-div">
                                            <img src="{{asset("storage/property_images/".$saleProperty->id .'/'.$saleProperty->images->first()->image)}}" class="img-responsive image" alt="property_image"/>
                                        </div>
                                    </a>
                                    <div class="col-md-3 col-sm-6 col-xs-12 caption main_single">
                                        <div class="property-details property-higlight">
                                            <h4><i class="fa fa-usd color-green" aria-hidden="true"></i>{{ $saleProperty->price }}</h4>
                                            <p><i class="far fa-flag"></i> {{ findState($saleProperty->state_id) }}</p>
                                            <p><i class="fa fa-square color-black" aria-hidden="true"></i> {{ $saleProperty->architechture->plot_size }}</p>
                                            <h6 class="single_fam"><i class="fa fa-home"></i> {{ config('constant.home_type.'.$saleProperty->architechture->home_type)??"" }}</h6>
                                            <a href="{{route('frontend.propertyDetails',$saleProperty->id)}}"><i class="fa fa-eye"></i>View Property</a>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                        }
                        ?>
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane fade" id="vacation" aria-labelledby="vacation-tab">
                    <div class="row  mx-0">
                        <?php
                        if (isset($vacationProperties) && count($vacationProperties) > 0) {
                            foreach ($vacationProperties as $vacationProperty) {
                                ?>
                                <div class="col-md-3 col-sm-6 col-xs-12 image-div">
                                    <div class="listing-image-div">
                                        <img src="{{asset("storage/property_images/".$vacationProperty->id .'/'.$vacationProperty->images->first()->image)}}" class="img-responsive image" alt="property_image"/>
                                    </div>
                                    </a>
                                    <div class="col-md-3 col-sm-6 col-xs-12 caption main_single">
                                        <div class="property-details property-higlight">
                                            <h4><i class="fa fa-usd color-green" aria-hidden="true"></i> {{ $vacationProperty->price }}</h4>
                                            <p><b>Resort Name:</b> {{ $vacationProperty->property_name }}</p>
                                            <h6 class="single_fam"><i class="fa fa-bed color-green" aria-hidden="true"></i> <span>{{ config('constant.sleeps.'.$vacationProperty->sleeps) }}</span></h6>
                                            <a href="{{route('frontend.vacationDetails',$vacationProperty->id)}}"><i class="fa fa-eye"></i>View Property</a>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col-sm-12 col-xs-12 contact-us btns-green-blue">
    <p>Need some assistance?<a href="{{ route('frontend.contact') }}" class="btn btn-lg btn-blue">Contact us</a></p>
</div>
<div class="row realtors-contractors-bg-img"> 
    <img src="{{ asset('/storage/site-images/contact_image2.png') }}" class="img-responsive" />
    <div class="container">
        <div class="col-sm-10 col-xs-10 realtors-contractors-text">
            <div class="heading">
                <h2>
                    We specialize in connecting realtors & other service providers to consumers
                    <span class="para-green">
                        Support our members & your bottom line by signing up today!
                    </span>
                </h2>
            </div>
            <div class="connect-with-us btns-green-blue">
                <a href="{{ route('frontend.businessCreate') }}" class="btn btn-lg btn-green">Business Sign-Up</a>
            </div>
        </div>
    </div>
</div>
@include('frontend.form-contact-us.form_contact_us')

@endsection

@section('after-scripts')

<script>
    $(function () {

        $('.form-we-help-you').validate({
            rules: {
                email: {
                    email: true
                }
            },
            messages: {
                name: "Please enter your name",
                email: {
                    required: "Please fill your email id",
                    email: "Please enter your correct email id"
                },
                phone: "Please enter your phone number",
                address: "Please enter your address",
                comment: "Plese share your views"
            }
        });

        $(".btn-contact-us").click(function (e) {
            $(".form-we-help-you").toggle();
            e.preventDefault();
        });

        $("#owl-carousel").owlCarousel({
            responsive: {
                0: {
                    items: 1
                },
                480: {
                    items: 1
                },
                767: {
                    items: 1
                },
                991: {
                    items: 1
                }
            }
        });

    });


</script>
@endsection 

