@extends('frontend.layouts.app')
@section('title', app_name() . ' | Profile')
@section('after-styles')
<link type="text/css" rel="stylesheet" href="{{ asset(mix('css/dashboard.css')) }}" media="all"> 
<style>#myprofile{font-weight: bold; color: #000;}</style>
@endsection 
@section('content') 
<div class="dashboard-page profile-view">    
    <div class="container">
        <div class="row content">
            @include('frontend.includes.sidebar')
            <div class="col-md-9 col-sm-8">
                <div class="right-dashboard-div">
                    <div class="profile right-dashboard-div-text">
                        <h4>My Profile</h4>
                        <div class="profile-sidebar">
                            <!-- SIDEBAR USERPIC -->
                            <div class="profile-userpic m-bottom">
                                @if($user->image)
                                <img src="{{ asset('storage/profile_images/'.$user->id.'/'. $user->image )}}" style="height: 100%; width: 100%" class='img-responsive'alt="profile photo" class="preview">
                                @else
                                <img src="{{ asset('storage/site-images/no_profile_image.png') }}" style="height: 100%; width: 100%" class='img-responsive' alt="profile photo" class="preview">
                                @endif
                            </div>                           
                            <div class="profile-usermenu">
                                <ul class="nav">
                                    <li>
                                        <p>
                                            <span><i class="fa fa-user-circle" aria-hidden="true"></i></span>
                                            {{$user->user_profile->full_name??$user->business_profile->company_name??$user->full_name??""}}
                                        </p>
                                    </li>
                                    <li>
                                        <p>
                                            <span><i class="fa fa-envelope-o" aria-hidden="true"></i></span>
                                            {{$user->email??"NA"}}
                                        </p>
                                    </li>

                                    <li>
                                        <p>
                                            <span><i class="fa fa-phone" aria-hidden="true"></i></span>
                                            {{$user->phone_no??"NA"}}
                                        </p>
                                    </li>

                                    <li>
                                        <p>
                                            <span><i class="fa fa-paper-plane-o" aria-hidden="true"></i></span>
                                            <span class="fdcfg">{{$user->user_profile->address??"NA"}}</span>
                                        </p>
                                    </li>
                                </ul>
                            </div>
                            <!-- END MENU -->
                            <div class="btns-green-blue text-center">
                                <a href="{{route('frontend.profile.edit',Auth::id())}}" type="button" class="btn btn-blue">Edit Profile</a>
                            </div>
                        </div><!--profile-sidebar-->   
                    </div>
                </div>
            </div<!--right-dashboard-div-->
        </div><!--col-9-->
    </div><!--row-->
</div><!--container-->
</div><!--dashboard-->
@endsection
@section('after-scripts')
<script>
</script>
@endsection
