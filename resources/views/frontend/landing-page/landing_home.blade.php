@extends ('frontend.layouts.app')
@section ('title', ('Landing Page'))

@section ('meta_description', ('Freezylist is a Free and Easy Real Estate Application for the By Owner Community. 
                                Their Software covers homeowners in buying and selling, renting and leasing, Timeshares and Vacation Rentals.'))
@section ('meta_keywords', ('Real Estate, Exchange, Timeshare, Timeshare Rental, Rental, buy, sell, rent, list, automation, contracts, template, documents, free, easy,
                            Listings, Learning, Education, Social, Support, Services, Realty, Agents, Brokers, Software, App, Google Maps, API, Signatures,
                            Closing, Settlement, Owner, Craigslist, Zillow, HotPads, Trulia, FSBO, FRBO, VRBO, Narwhal'))

@section('after-styles')
<link type="text/css" rel="stylesheet" href="{{ asset(mix('css/landing-page.css')) }}" media="all"> 
@endsection 
@section('content')


    <!--<div class="jquery-carousel">
        <div class="carousel" id="jquery-carousel">
            <div class="slides">
                <div class="slideItem"> 
                    <a href="#"><img src="{{asset('storage/home/Listings For Sale.jpg')}}" class="img-responsive"></a>
                    <div class="shadow">
                        <div class="shadowLeft"></div>
                        <div class="shadowMiddle"></div> 
                        <div class="shadowRight"></div>
                    </div>
                </div>
                <div class="slideItem">
                    <a href="#"><img src="{{asset('storage/home/Listings For Rent.jpg')}}" class="img-responsive"></a>
                    <div class="shadow">
                        <div class="shadowLeft"></div>
                        <div class="shadowMiddle"></div>
                        <div class="shadowRight"></div>
                    </div>
                </div>
                <div class="slideItem">
                    <a href="#"><img src="{{asset('storage/home/Pro Network.jpg')}}" class="img-responsive"></a>
                    <div class="shadow">
                        <div class="shadowLeft"></div>
                        <div class="shadowMiddle"></div>
                        <div class="shadowRight"></div>
                    </div>
                </div>
                <div class="slideItem">
                    <a href="#"><img src="{{asset('storage/home/Other Features.jpg')}}" class="img-responsive"></a>
                    <div class="shadow">
                        <div class="shadowLeft"></div>
                        <div class="shadowMiddle"></div>
                        <div class="shadowRight"></div>
                    </div>
                </div>
                <div class="slideItem">
                    <a href="#"><img src="{{asset('storage/home/Education Portal.jpg')}}" class="img-responsive"></a>
                    <div class="shadow">
                        <div class="shadowLeft"></div>
                        <div class="shadowMiddle"></div>
                        <div class="shadowRight"></div>
                    </div>
                </div>
                <div class="slideItem">
                    <a href="#"><img src="{{asset('storage/home/Timeshare Exchange.jpg')}}" class="img-responsive"></a>
                    <div class="shadow">
                        <div class="shadowLeft"></div>
                        <div class="shadowMiddle"></div>
                        <div class="shadowRight"></div>
                    </div>
                </div>
            </div> 
        </div>
    
    </div>
</div> -->
<div class="row welcome-freezylist-row">
    <div class="container">
        <div class="img-home-icon">
            @include('frontend.common-home-icon.common_home_icon')
        </div>
        <div class="col-sm-12 welcome-freezylist">
            <div class="col-sm-12  col-xs-12 heading-para">
                <h3>Creators of Free & Easy 'By Owner' Options</h3>
                <h4> Offering Freedom of Choice For Homeowners With Common Sense Solutions</h4>
                
                
                <!-- <div class="container bottom-para"> -->
                    <!--<p>
                        We created a 'By Owner' Suite of cloud services, featuring full listing options to <span class="para-green">Sell, Rent,</span> or <span class="para-green">Exchange</span> Residential & Vacation properties.
                    </p>
                    
                    <ul class="para-blue">
                        <li>Selling & Leasing Contract Automation</li>
                        <li>Electronic Signatures</li>
                        <li>Service Provider Networks & Consumer Reviews</li>
                        <li>Education Platform</li>
                        <li>Calendar of Availability</li>
                        <li>Scheduling Tools</li>
                        <li>Direct Messaging </li>
                        <li>Integrated Search Functions (Google Maps)</li>
                        <li>Free Contract Templates</li>
                    </ul>
                    
                    -->
                    
                    <?php if (!Auth::check()) { ?>
                        
                        <!--
                        
                        <p>
                            The results... sign-up and try it yourself
                        </p>
                        
                        -->
                        <hr style="border: 4px solid white;" />
                        
                        <div class="col-sm-12 col-xs-12 btn-sign-up">
                            <a href="{{ route('frontend.userCreate') }}" class="btn btn-user"><b>Create User Account</b></a>
                            <a href="{{ route('frontend.businessCreate') }}" class="btn btn-business"><b>Register My Business</b></a>
                        </div>
                        
                    <h4> Create your free account & gain complete access</h4>
                        
                    <?php } ?>
                    
                    
                    <!--<p>
                        <span class="para-green">Did we mention our platform is 100% free for both consumers and businesses? Why? See our blog to learn more.</span>
                    </p>-->
                    
                    <hr style="border: 4px solid white;" />

                    <h4>Welcome to our landing page! Browse our options in the Navigation Links below to learn more about what services we offer.</h4>

               <!-- </div>-->
                
                
                <img src="{{ asset('/storage/site-images/landing-page.png')}}" class="img-responsive img-landing-page" />
                
                <a href="{{ route('frontend.businessCreate') }}" style="color:#92c800"> <h4><u>Click Here to Learn More</u></h4></a>
                
                <hr style="border: 4px solid white;" />
                
                <h3>What can we do for you?</h3>
                
            </div>
        </div>   
    </div>    
</div>
<div class="wrapper listing main-support">    
    <div class="container"> 
        <div class="col-lg-12">
            <div class="img-home-icon">
                @include('frontend.common-home-icon.common_home_icon')
            </div>
            <h3 class="heading-para">Navigation Links</h3>
            <div class="bs-example bs-example-tabs" role="tabpanel" data-example-id="togglable-tabs">
                <ul id="myTab" class="nav nav-tabs nav-tabs-responsive text-center" role="tablist">       
                    <a class="btn btn-sm btn-main active" href="#home" role="presentation" id="home-tab" role="tab" data-toggle="tab" aria-controls="home" aria-expanded="true">
                        <span class="tab-text">Listings & Support</span>
                    </a>           
                    <a href="#profile" class="btn btn-sm btn-main btn-support" role="tab" id="profile-tab" data-toggle="tab" aria-controls="profile">
                        <span class="tab-text">Connect & Learn</span>
                    </a>     
                </ul>
                <div id="myTabContent" class="tab-content">
                    <div role="tabpanel" class="tab-pane fade in active" id="home" aria-labelledby="home-tab">
                        <div class="row">
                            <div class="col-md-3 col-sm-4 col-xs-12 image-div">
                                <a href="{{route('frontend.sales-home')}}" target="_blank">    
                                    <div class="listing-image-div">
                                        <img src="{{ asset('/storage/site-images/For Sale Link.jpg') }}" class="img-responsive image" alt="property_image"/>
                                        <div class="overlay">
                                            <div class="text-overlay-div">
                                                <button class="text-button">For Sale</button>
                                            </div>
                                        </div>
                                    </div>                              
                                </a>
                            </div> 
                            <div class="col-md-3 col-sm-4 col-xs-12 image-div">
                                <a href="{{route('frontend.rents-home')}}"  target="_blank">  
                                    <div class="listing-image-div">
                                        <img src="{{ asset('/storage/site-images/For Rent Link.jpg') }}" class="img-responsive image" alt="property_image"/>
                                        <div class="overlay">
                                            <div class="text-overlay-div">
                                                <button class="text-button">For Rent</button> 
                                            </div>
                                        </div>
                                    </div>                             
                                </a>
                            </div> 
                            <div class="col-md-3 col-sm-4 col-xs-12 image-div">
                                <a href="{{route('frontend.vacations-home')}}" target="_blank">  
                                    <div class="listing-image-div">
                                        <img src="{{ asset('/storage/site-images/Timeshare Exchange Link.jpg') }}" class="img-responsive image" alt="property_image"/>
                                        <div class="overlay">
                                            <div class="text-overlay-div">
                                                <button class="text-button">VRBO/ Timeshare</button>
                                            </div>
                                        </div>
                                    </div>                             
                                </a>
                            </div> 
                            <div class="col-md-3 col-sm-4 col-xs-12 image-div"  target="_blank">
                                <a href="{{route('frontend.network.support')}}"  target="_blank">   
                                    <div class="listing-image-div">
                                        <img src="{{ asset('/storage/site-images/Pro Network Link.jpg')}}" class="img-responsive image" alt="property_image"/>
                                        <div class="overlay"> 
                                            <div class="text-overlay-div">
                                                <button class="text-button">Pro Network</button>
                                            </div>
                                        </div>
                                    </div>                             
                                </a>
                            </div> 
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane fade" id="profile" aria-labelledby="profile-tab">
                        <div class="row">
                            <div class="col-md-3 col-sm-4 col-xs-12 image-div">
                                <a href="{{ route('frontend.network.social') }}" target="_blank">  
                                    <div class="listing-image-div">
                                        <img src="{{ asset('/storage/site-images/Social Network Link.jpg') }}" class="img-responsive image" alt="property_image"/>
                                        <div class="overlay">
                                            <div class="text-overlay-div">
                                                <button class="text-button">Social Network</button>
                                            </div>
                                        </div>
                                    </div>                             
                                </a>
                            </div> 
                            <div class="col-md-3 col-sm-4 col-xs-12 image-div">
                                <a href="{{ url('/forums') }}"  target="_blank">   
                                    <div class="listing-image-div">
                                        <img src="{{ asset('/storage/site-images/Member Forum Link.jpg')}}" class="img-responsive image" alt="property_image"/>
                                        <div class="overlay">
                                            <div class="text-overlay-div">
                                                <button class="text-button">Member Forum</button> 
                                            </div>
                                        </div>
                                    </div>                              
                                </a>
                            </div> 
                            <div class="col-md-3 col-sm-4 col-xs-12 image-div">
                                <a href="{{ route('frontend.blogs') }}"  target="_blank">  
                                    <div class="listing-image-div">
                                        <img src="{{ asset('/storage/site-images/Freezylist Blog Link.jpg') }}" class="img-responsive image" alt="property_image"/>
                                        <div class="overlay">
                                            <div class="text-overlay-div">
                                                <button class="text-button">Freezylist Blog</button>
                                            </div>
                                        </div>
                                    </div>                             
                                </a> 
                            </div> 
                            <div class="col-md-3 col-sm-4 col-xs-12 image-div">
                                                                <a href="{{ route('frontend.learning.center') }}" target="_blank">  
                                    <div class="listing-image-div">
                                        <img src="{{ asset('/storage/site-images/Learning Center Link.jpg') }}" class="img-responsive image" alt="property_image"/>
                                        <div class="overlay">
                                            <div class="text-overlay-div">
                                                <button class="text-button">Learning Center</button>
                                            </div>
                                        </div>
                                    </div>                             
                                </a>
                            </div> 
                            
                            <div class="col-md-3 col-sm-4 col-xs-12 image-div">
                                <a href="{{route('frontend.documentPortal')}}"  target="_blank">   
                                    <div class="listing-image-div">
                                        <img src="{{ asset('/storage/site-images/Contract Templates Link.jpg')}}" class="img-responsive image" alt="property_image"/>
                                        <div class="overlay"> 
                                            <div class="text-overlay-div">
                                                <button class="text-button">Free Contract Templates</button>
                                            </div>
                                        </div>
                                    </div>                             
                                </a>
                            </div> 

                        </div>
                    </div>
                </div>
            </div> 
        </div>
    </div>
</div> 

<div class="row need-some-assistance"> 
    <div class="container">
        <div class="col-sm-12 col-xs-12"> 
            <p>
                Need some assistance?<a href="#" class="btn btn-lg btn-contact-us">Contact us</a>
            </p>
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

        $('.form-we-help-you').on('submit', function(e) {
            if(grecaptcha.getResponse() == "") {
                e.preventDefault();
//                console.log("hi");
                $('#captchaError').html('<label class="error">Please prove you are not a Robot</label>');
            } else {
                $('#captchaError').hide();
            }
        });


        /*form-open*/
        $(".btn-contact-us").click(function (e) {
            $(".form-we-help-you").toggle();
            e.preventDefault();
        });

        /*isotope-plugin*/
        var $grid = $('.grid').isotope({
            itemSelector: '.main-support-img'
//                 layoutMode: 'fitRows'
        });
        $('.filter-button-group a').on('click', function () {
            var filterValue = $(this).attr('data-filter');
            $grid.isotope({
                filter: function () {
                    return $(this).attr('data-filter') === filterValue;
                }
            });
        });
        $('.filter-button-group a').first().trigger('click');

        /*jquery-carousel-plugin*/

        $('#jquery-carousel').carousel({
            carouselWidth: 1140,
            carouselHeight: 383,
            directionNav: true,
            buttonNav: 'bullets',
            frontWidth: 500,
            frontHeight: 380,
            responsive: true,
            shadow: false,
            reflection: false,
            autoplay: false
        });
    });

    (function ($) {

        'use strict';

        $(document).on('show.bs.tab', '.nav-tabs-responsive [data-toggle="tab"]', function (e) {
            var $target = $(e.target);
            var $tabs = $target.closest('.nav-tabs-responsive');
            var $current = $target.closest('li');
            var $parent = $current.closest('li.dropdown');
            $current = $parent.length > 0 ? $parent : $current;
            var $next = $current.next();
            var $prev = $current.prev();
            var updateDropdownMenu = function ($el, position) {
                $el
                        .find('.dropdown-menu')
                        .removeClass('pull-xs-left pull-xs-center pull-xs-right')
                        .addClass('pull-xs-' + position);
            };

            $tabs.find('>li').removeClass('next prev');
            $prev.addClass('prev');
            $next.addClass('next');

            updateDropdownMenu($prev, 'left');
            updateDropdownMenu($current, 'center');
            updateDropdownMenu($next, 'right');
        });

    })(jQuery);

    var recaptchaCallback = function () {
        console.log('recaptcha is ready'); // showing
        grecaptcha.render("recaptcha", {
            sitekey: '6Ldn9GgUAAAAABCm-PeXaauq8WqXpvaH0RRRkJw_',
            callback: function () {
                console.log('recaptcha callback');
            }
        });
    }
</script>
@if (config('access.captcha.registration'))
{!! NoCaptcha::renderJs('fr', true, 'recaptcha_callback') !!}
<script>
    function recaptcha_callback() {
        $('#captchaError').hide();
    }
</script>
@endif
@endsection 
