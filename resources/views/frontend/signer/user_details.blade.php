@extends('frontend.layouts.app')
@section('title', app_name() . ' | Profile')
<link type="text/css" rel="stylesheet" href="{{ asset(mix('css/dashboard.css')) }}" media="all">
@section('content')
<div class="dashboard-page profile-view">    
    <div class="container">
        <div class="row content">
            @include('frontend.includes.sidebar')
            <div class="col-md-9 col-sm-8">
                <div class="right-dashboard-div">
                    <div class="profile right-dashboard-div-text">
                        <div class="profile-sidebar">
                            <!-- SIDEBAR USERPIC -->
                            <div class="profile-userpic">
                                @if($user->image)
                                <img src="{{asset('storage/profile_images/'.$user->id.'/'. $user->image)}}" style="height: 100%; width: 100%" class='img-responsive'alt="profile photo" class="preview">
                                @else
                                <img src="{{asset('storage/site-images/no_image_available.jpg')}}" style="height: 100%; width: 100%" class='img-responsive' alt="profile photo" class="preview">
                                @endif
                            </div>
                            <div class="profile-usertitle">
                                <div class="profile-usertitle-name">
                                    @if($user->user_profile)
                                    {{$user->user_profile->full_name}}
                                    @elseif($user->business_profile)
                                    {{$user->business_profile->company_name}}
                                    @else
                                    {{$user->full_name}}
                                    @endif
                                </div>
                            </div>
                            <div class="profile-usermenu">
                                <ul class="nav">
                                    <li>
                                        <p>
                                            <span><i class="fa fa-user-circle" aria-hidden="true"></i></span>
                                            @if($user->user_profile)
                                            {{$user->user_profile->full_name}}
                                            @elseif($user->business_profile)
                                            {{$user->business_profile->company_name}}
                                            @else
                                            {{$user->full_name}}
                                            @endif
                                        </p>
                                    </li>
                                    <li>
                                        <p>
                                            <span><i class="fa fa-envelope-o" aria-hidden="true"></i></span>
                                            {{$user->email}}
                                        </p>
                                    </li>

                                    <li>
                                        <p>
                                            <span><i class="fa fa-phone" aria-hidden="true"></i></span>
                                            @if($user->phone_no){{$user->phone_no}} @else NA @endif
                                        </p>
                                    </li>

                                    <li>
                                        <p>
                                            <span><i class="fa fa-paper-plane-o" aria-hidden="true"></i></span>
                                            @if($user->user_profile)
                                            <span class="fdcfg">{{$user->user_profile->address}}</span>
                                            @elseif($user->business_profile)
                                            <span class="fdcfg">{{$user->business_profile->company_address}}</span>
                                            @else
                                            NA
                                            @endif
                                        </p>
                                    </li>

                                    @if($user->user_profile)
                                    <li>
                                        <p> <span class=""><i class="fa fa-heart" aria-hidden="true"></i></span>
                                            <?php if ($user->user_profile->user_interests->count()) { ?>
                                                @foreach($user->user_profile->user_interests as $interest)
                                                <span class="alert alert-info" style="padding:4px 21px; margin:1px;">{{ config('constant.interests.'.$interest->interest_type) }}</span>
                                                @endforeach
                                            <?php } else { ?>
                                                NA
                                            <?php } ?>
                                        </p>
                                    </li>
                                    @endif

                                </ul>
                            </div>
                            <!-- END MENU -->
                            <div class="profile-userbuttons text-center">
                                <a href="{{route('frontend.signer.index')}}" type="button" class="btn btn-default">Back</a>
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
