@extends ('frontend.layouts.app')
@section ('title', ('Associates'))
@section('after-styles')
<link type="text/css" rel="stylesheet" href="{{ asset(mix('css/dashboard.css')) }}" media="all">

<style>
    #myassociates{ font-weight: bold;color: #000;}
    .text-center a {
        margin-right: 0;
        margin-bottom: 10px !important;
    }
</style>
@endsection 
@section('content')
<div class="dashboard-page associates profile-view signer-page">    
    <div class="container">
        <div class="row content">
            @include('frontend.includes.sidebar')
            <div class="col-md-9 col-sm-8">
                <div class="right-dashboard-div">
                    <div class="profile right-dashboard-div-text">
                        <h4>My Associates</h4>
                        <div class="row">  
                            <?php if ($allAssociates->count()) { ?>
                               @foreach($allAssociates as $associate) 
                          
                                @php
                                if(!empty($associate->request_from_user))
                                {
                                   $Checkvalue = $associate->request_from_user;
                                }   
                                elseif(!empty($associate->request_to_user))
                                {
                                   $Checkvalue = $associate->request_to_user;
                                 }
                                else
                                {
                                  $Checkvalue ='';
                                }
                                @endphp
                                <div class="col-md-6 col-sm-12">
                                    <div class="profile-sidebar">
                                        <div class="cross-div"><span type="button" class="cross" data-toggle="modal" data-target="#myModal-{{$associate->id}}"><i class="fa fa-times-circle"></i></span></div>
                                        <!-- Modal -->
                                        <div class="modal fade" id="myModal-{{$associate->id}}" role="dialog">
                                            <div class="modal-dialog">
                                                <!-- Modal content-->
                                                <div class="modal-content text-center">
                                                    <div class="modal-body">
                                                        <p>Are you sure you want to remove this user from your network?</p>
                                                    </div>
                                                    <div class="text-center btns-green-blue small-buttons">
                                                        <a href="{{ route('frontend.delete.connection',$associate->id) }}" class="btn btn-green">Confirm</a>
                                                        <a type="button" class="btn button btn-blue" data-dismiss="modal">Cancel</a> 
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- SIDEBAR USERPIC -->
                                        <div class="profile-userpic">
                                          
                                            @if(!empty($Checkvalue->image))
                                            <img src="{{asset("storage/profile_images/".$Checkvalue->id.'/'.$Checkvalue->image)}}" style="height: 100%;" class="img-responsive" alt="profile photo">
                                            @else
                                            <img src="{{asset('storage/site-images/no_image_available.jpg')}}" style="height: 100%;" class="img-responsive" alt="profile photo">
                                            @endif
                                        </div>
                                        <div class="profile-usermenu">
                                            <ul class="nav">
                                                <li>
                                                    <i class="fa fa-envelope-o pull-left" aria-hidden="true"></i>
                                                   
                                                    <p>{{getFullName($Checkvalue)}}</p>
                                                </li>

                                                <li>
                                                    <i class="fa fa-user"></i>
                                                    <p>
                                                        @if($Checkvalue->user_profile)
                                                        Member
                                                        @endif
                                                        @if($Checkvalue->business_profile)
                                                        Pro Services
                                                        @endif
                                                    </p>
                                                </li>
                                            </ul>
                                        </div>
                                        <!-- END MENU -->
                                        <div class="btns-green-blue text-center row">
                                            <a href="{{ route('frontend.messages.conversation',encrypt($Checkvalue->id)) }}" type="button" class="btn btn-green">Message</a>
                                            <a href="{{ route('frontend.network.userDetails',$Checkvalue->id) }}" type="button" class="btn btn-blue" style="margin-right: 15px;">Details</a>
                                        </div>
                                    </div><!--profile-sidebar-->

                                </div>
                                @endforeach
                            </div>

                        <?php } else { ?>
                            <h4 class="no-data">No Associates Found.</h4>
                        <?php } ?>
                            {{ $allAssociates->links() }}
                    </div>
                </div>
            </div<!--right-dashboard-div-->           
        </div><!--col-9-->
    </div><!--row-->
</div><!--container-->
</div><!--dashboard-->
@endsection