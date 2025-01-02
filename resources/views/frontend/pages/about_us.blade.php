@extends ('frontend.layouts.app')
@section ('title', ('About Us'))
@section('after-styles')
<link type="text/css" rel="stylesheet" href="{{ asset(mix('css/about-us.css')) }}" media="all">
@endsection 
@section('content') 
<div class="contact-page about-style"> 
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="contact-banner">
                        <div class="text">About Us</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="text-center">
        @include('frontend.common-home-icon.common_home_icon')
    </div>  
    <div class="about-freezylist-div">
        <div class="container">
            <div class="col-sm-12">
                <h2>About Freezylist</h2>
                <h4>At FREEZYLIST, our passion is creating solutions that promote our values beyond our
                    organization!
                </h4>
                <div class="about-freezylist-para-div container">
                    <div class="col-sm-12 subdiv-freezylist-para">
                        <p>Our value proposition is derived from the foundation of <span>“FREE” (Free-zylist)</span>, which is 
                            commonly interpreted in a financial sense; however, the most significant distinction
                            is the <span>freedom of choice and the ability to control one’s own path</span>.
                        </p>
                        <p>In alignment to this ideology, we provide our members solutions for <span>Sale,
                                Rent, Vacation </span>and Timeshare property transactions.
                        </p>
                    </div>
                </div>
            </div>
        </div> 
    </div>
    <div class="our-vision-div">
        <div class="col-sm-12 col-xs-12 our-vision-bg-img">
            <div class="col-lg-7 col-sm-12 col-xs-12 our-vision-text">
                <div class="col-sm-12 col-xs-12 padding">
                    <img src="{{ asset('/storage/site-images/home_icon.png') }}" class="img-responsive">
                    <h2>Our vision </h2>
                    <h4>Create an economic shift in how real property is exchanged.</h4>
                    <p>We envision a reality in which property <span>owners are free to choose 
                            true alternatives to hiring a Realtor.</span>
                    </p>
                    <p>We devise an existence where real property <span>transactions are demystied </span>by embracing 
                        information sharing and <span>integrated technology.</span>
                    </p>
                    <p>We <span>imagine an economy</span> where individuals are able to influence <span>healthy market competition.</span></p>
                    <p>We crave a future where a household is able to sell their <span>“at risk” 
                            (Marginal Equity/Underwater)</span> property without retaining their <span>mortgage </span>to pay a <span>commission.</span></p>
                </div>
            </div>
      <!--      <img src="{{ asset('storage/site-images/about_banner.png') }}" class="img-responsive visibility-hidden"/>-->
        </div>
    </div>
    <div class="support-collaboration-row">
        <div class="container">
            <div class="subdiv-support-collaboration">
                <div class="col-md-6 col-md-push-6 support-right-img">
                    <h2>Support & Collaboration</h2>
                    <img src="{{ asset('/storage/site-images/network_portal.png') }}" class="img-responsive">
                </div>
                <div class="col-md-6 col-md-pull-6 support-left-para">
                    <p>
                        The function of a Realtor is to deliver a <span>"Ready and Willing Buyer."</span>
                        As agents are specialists in marketing real property, they must rely on
                        the support of their network to facilitate the closing process.
                    </p>   
                    <p>
                        <span>Our services re-create the Realtor Network model, with Home Owners at the center.</span>
                        We provide a marketing interface, a service provider framework, a network of peers
                        and neighbors, scheduling tools, communication channels, and an integrated solution
                        that can prepare your contracts and facilitate the signing process.
                    </p>

                    <p>
                        Further, <span>Exclusive Listing Agreements allow simultaneously listing "By Owner"
                            and with a broker.</span> We challenge Home Owners to leverage this opportunity to strengthen
                        agent performance and potentially avoid a large commission.
                    </p>

                </div>
            </div> 
        </div>
    </div> 
    <div class="signup-join-div signup-join-banner text-center">
        <div class="container">              
            <div class="col-md-12"> 
                <div class="col-md-12 col-sm-12 col-xs-12"> 
                    <div class="">
                        <h2>Our services allow you to be the expert and we invite you to join the <span>movement!</span></h2>
                        <div class="btn-sign-up">
                            <a href="{{route('frontend.userCreate')}}" class="btn btn-user">Signup For User </a>
                            <a href="{{ route('frontend.businessCreate') }}" class="btn btn-business">Signup For Business</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @endsection