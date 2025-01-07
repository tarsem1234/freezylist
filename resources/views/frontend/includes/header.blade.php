<div class="container-fluid">
    <header class="frontpanel-header">
        <div class="row top-of-nav ">
            <div class="container">
                <div class="row">
                <div class=" left-side">
                    <ul>
                        <li><a href="https://www.facebook.com/freezylist" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                        <li><a href="https://twitter.com/freezylist" target="_blank"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                        <li><a href="https://www.youtube.com/channel/UCCdkFbK7DqO7JjwwpLU8oWQ" target="_blank"><i class="fa fa-youtube-play" aria-hidden="true"></i></i></a></li>
                        <li><a href="#" target="_blank"><i class="fa fa-rss" aria-hidden="true"></i></a></li>
                        <li class="info-freezylist-com">
                            <a>
                                <i class="fa fa-envelope-o" aria-hidden="true"></i>
                                info@freezylist.com
                            </a>
                        </li>
                    </ul>
                </div> 
                <div class="right-side">
                    <?php if (Auth::check()) { ?>
                        <a href="{{ route('frontend.user.dashboard') }}" class="btn btn-sign-up">Dashboard</a>
                        <a href="{{ route('frontend.auth.logout') }}" class="btn btn-login">Logout</a>
                    <?php } else { ?>
                        <div class="sign-up-dropdown dropdown">

                            <button class="btn dropdown-toggle btn-sign-up" type="button" data-toggle="dropdown">Sign up</button>
                            <ul class="dropdown-menu">
                                <li><a href="{{ route('frontend.userCreate') }}">Create User Account</a></li>
                                <li><a href="{{ route('frontend.businessCreate') }}">Register My Business</a></li>
                            </ul>
                            <a href="{{ route('frontend.auth.login') }}" class="btn btn-login">Login</a>
                        </div>
                    <?php } ?>
                </div>
            </div>
            </div>
        </div>
        <nav role="navigation" class="row navbar navbar-default">
            <div class="container">
                <div class="row navbar-row">                    
                    <button data-target="#navbar-collapse" data-toggle="collapse" class="navbar-toggle collapsed" type="button">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <div class="left-side navbar-header">
                        <a href="{{route('frontend.index')}}">
                            <img src="{{asset('/storage/site-images/logo.png')}}" class="img-responsive" alt="logo-img" style="width:185px;height:63px;">
                        </a>
                    </div>
                    <div id="navbar-collapse" class="navbar-collapse collapse right-side">
                        <ul class="nav navbar-nav navbar-right">
                            <li class="home{{ (Request::is('Home') ? 'active' : '') }} main_li active-menu">
                                <a href="{{ url('') }}" class="common">Home</a>
                            </li>
                            <li class="dropdown-{{ (Request::is('Listings') ? 'active' : '') }} main_li">
                                <a href="{{ url('') }}" class="dropdown-toggle common" data-toggle="dropdown" role="button" aria-expanded="false">Listings<i class="fa fa-angle-down" aria-hidden="true"></i></a>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="{{route('frontend.sales-home')}}">For Sale</a></li>
                                    <li><a href="{{route('frontend.rents-home')}}">For Rent</a></li>
                                    <li class="last-li"><a href="{{route('frontend.vacations-home')}}">Timeshares/VRBO</a></li>
                                </ul>
                            </li>
                            <li class="{{ (Request::is('Blog') ? 'active' : '') }} main_li">
                                <a href="{{ route('frontend.blogs') }}" class="common">Blog</a>
                            </li>
                            <li class="{{ (Request::is('Forum') ? 'active' : '') }} main_li">
                                <a href="{{ url('/forums') }}" class="common">Forum</a>
                            </li>    
                            <li class="{{ (Request::is('Contact Us ') ? 'active' : '') }} main_li">
                                <a href="{{ route('frontend.contact') }}" class="common">Contact Us</a>
                            </li>
                            <li class="dropdown-{{ (Request::is('Network Portal') ? 'active' : '') }} main_li">
                                <a href="{{ url('') }}" class="dropdown-toggle common" data-toggle="dropdown" role="button" aria-expanded="false">Network Portal<i class="fa fa-angle-down" aria-hidden="true"></i></a>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="{{route('frontend.network.support')}}">Pro Services</a></li>
                                    <li class="last-li"><a href="{{route('frontend.network.social')}}">Social Network</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
    </header>
</div>

