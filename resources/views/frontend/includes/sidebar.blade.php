<div class="sidebar">
    <div class="col-md-3 col-sm-4 sidenav">
        <div  class="left-dashboard-div">
            <nav class="navbar navbar-default">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed navbar-toggle-dashboard" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span> 
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div>
                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse sidebar-nav" id="bs-example-navbar-collapse-1">
                    <ul>
                        <li>
                            <a id="dashboard" href="{{ route('frontend.user.dashboard') }}">
                                <span class="icons-dashboard"><i class="fa fa-address-card"></i></span><span class="">Dashboard </span>
                            </a>
                        </li>
                        @if(in_array(config('constant.inverse_user_type.User'), array_column(Auth::user()->roles->toArray(), 'sort')) ||
                        in_array(config('constant.inverse_user_type.Administrator'), array_column(Auth::user()->roles->toArray(), 'sort')))
                        <li>
                            <a id="learning_center"  href="{{ route('frontend.learning.center') }}">
                                <span class="icons-dashboard"><i class="fa fa-file-text-o" aria-hidden="true"></i></span>Learning Center
                            </a>
                        </li>
                        @endif

                        <li class="dropdown">
                            <a id="rent-pages" href="javascript:void(0);" data-target="#submenu-Listing">
                                <span class="icons-dashboard"><i class="fa fa-list-alt" aria-hidden="true"></i></span>My Listings
                                <span class="arrow-dashboard"><i class="fa fa-angle-down" aria-hidden="true"></i></span>
                            </a>
                            <ul id="submenu-Listing" class="collapse">
                                <li><a href="{{route('frontend.property.salesList')}}"><i class="fa fa-angle-double-right"></i> For Sale</a></li>
                                <li><a href="{{route('frontend.property.rentsList')}}"><i class="fa fa-angle-double-right"></i> For Rent</a></li>
                                <li><a href="{{route('frontend.property.vacationsList')}}"><i class="fa fa-angle-double-right"></i>Timeshares/VRBO</a></li>
                            </ul>
                        </li>
                        <?php if(in_array(config('constant.inverse_user_type.User'), array_column(Auth::user()->roles->toArray(), 'sort')) ||
                        in_array(config('constant.inverse_user_type.Administrator'), array_column(Auth::user()->roles->toArray(), 'sort'))) { ?>
                        <li>
                            <a id="myfavorites" href="{{ route('frontend.favorites') }}">
                                <span class="icons-dashboard"><i class="fa fa-heart"></i></span>My Favorites
                            </a>
                        </li>
                        <?php } ?>

                        <li class="dropdown">
                            <a id="myassociates" href="javascript:void(0);" data-target="#submenu-network">
                                <span class="icons-dashboard"><i class="fa fa-handshake-o" aria-hidden="true"></i></span>My Network
                                <span class="arrow-dashboard"><i class="fa fa-angle-down" aria-hidden="true"></i></span>
                                <span class="div-network">{{totalAssociatesCount() + sentRequestCount() + receivedRequestCount()}}</span>
                            </a>
                            <ul id="submenu-network" class="collapse small-div">
                                <li><a class="my_network1" id="myassociates1" href="{{route('frontend.myNetwork')}}"><i class="fa fa-angle-double-right"></i>My Associates <span class="div-listing pull-right right">{{totalAssociatesCount()}}</span></a></li>
                                <li><a class="my_network1" id="recieverequest" href="{{route('frontend.received.requests')}}"><i class="fa fa-angle-double-right"></i>Received Requests <span class="div-listing pull-right right">{{receivedRequestCount()}}</span></a></li>
                                <li><a id="sentrequest" href="{{route('frontend.sent.requests')}}"><i class="fa fa-angle-double-right"></i>Sent Requests <span class="div-listing pull-right">{{sentRequestCount()}}</span></a></li>
                            </ul>
                        </li>
                        <li class="dropdown">
                            <a id="messages" href="javascript:void(0);" data-target="#submenu-Messages">
                                <span class="icons-dashboard"><i class="fa fa-envelope-o" aria-hidden="true"></i></span>My Messages
                                <span class="arrow-dashboard"><i class="fa fa-angle-down" aria-hidden="true"></i></span>
                                <span class="div-message">{{unreadMessagesCount()}}</span>
                            </a>
                            <ul id="submenu-Messages" class="collapse" class="dropdown-content">
                                <li><a href="{{route('frontend.messages.index')}}"><i class="fa fa-angle-double-right"></i>Inbox</a></li>
                                <li><a href="{{route('frontend.messages.new')}}"><i class="fa fa-angle-double-right"></i>Compose Message</a></li>
                            </ul>
                        </li>


                        <?php $offers = offerCount(); ?>
                        <li class="dropdown">
                            <a id="Offer" href="javascript:void(0);" data-target="#submenu-Offer">
                                <span class="icons-dashboard"><i class="fa fa-cc-diners-club" aria-hidden="true"></i></span>My Offers
                                <span class="arrow-dashboard"><i class="fa fa-angle-down" aria-hidden="true"></i></span>
                                <span class="div-offer">{{$offers['total']}}</span>
                            </a>
                            <ul id="submenu-Offer" class="collapse small-div">
                                <li><a href="{{route('frontend.recieved.offers')}}"><i class="fa fa-angle-double-right"></i>Received <span class="div-listing pull-right">{{$offers['received']}}</span></a></li>
                                <li><a href="{{route('frontend.sent.offers')}}"><i class="fa fa-angle-double-right"></i>Sent Offers <span class="div-listing pull-right">{{$offers['sent']}}</span></a></li>
                            </ul>
                        </li>

                        @if(in_array(config('constant.inverse_user_type.User'), array_column(Auth::user()->roles->toArray(), 'sort')) ||
                        in_array(config('constant.inverse_user_type.Administrator'), array_column(Auth::user()->roles->toArray(), 'sort')))
                        <li>
                            <a id="mysigner" href="{{ route('frontend.signer.index') }}">
                                <span class="icons-dashboard"><i class="fa fa-venus-double" aria-hidden="true"></i></span>My Signers
                            </a>
                        </li>
                        <li>
                            <a id="sign-documents"  href="{{ route('frontend.partnersSignDocuments') }}">
                                <span class="icons-dashboard"><i class="fa fa-pencil" aria-hidden="true"></i></span>Sign Documents
                            </a>
                        </li>

                        <li class="dropdown">
                            <a id="submenu-Documents" href="javascript:void(0);" data-target="#submenu-Documents">
                                <span class="icons-dashboard"><i class="fa fa-id-card-o" aria-hidden="true"></i></span>My Documents
                                <span class="arrow-dashboard"><i class="fa fa-angle-down" aria-hidden="true"></i></span>
                            </a>
                            <ul  class="collapse">
                                <li><a href="{{route('frontend.receivedDocuments')}}"><i class="fa fa-angle-double-right"></i>Received Offers</a></li>
                                <li><a href="{{route('frontend.sentDocuments')}}"><i class="fa fa-angle-double-right"></i>Sent Offers</a></li>
                            </ul> 
                        </li>
                        @endif

                        <li>
                            <a id="logout" href="{{ route('frontend.auth.logout') }}" >
                                <span class="icons-dashboard"><i class="fa fa-sign-out" aria-hidden="true"></i></span>Logout
                            </a>
                        </li>
                    </ul>
                </div><!-- /.navbar-collapse -->
            </nav>
        </div>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.0.2/jquery.min.js"></script>
<script>
$(document).ready(function () {
    $('#myNavbar ul li a').click(function () {
        $('#myNavbar li a').removeClass("active");
        $(this).addClass("active");
    });
});
$(document).on('click', '.dropdown', function (e) {
    $(this).find('span.arrow-dashboard i.fa').removeClass('fa-angle-down');
    $(this).siblings('li.dropdown').removeClass('showing');
    $(this).siblings('li.dropdown').find('span.arrow-dashboard i.fa').addClass('fa-angle-down')
    if ($(this).hasClass('showing')) {
        $(this).find('span.arrow-dashboard i.fa').addClass('fa-angle-down');
        $(this).removeClass('showing').find('.collapse').slideUp();
    } else {
        $(this).find('span.arrow-dashboard i.fa').addClass('fa-angle-up');
        $(this).addClass('showing').find('.collapse').slideDown();
    }
});
</script>