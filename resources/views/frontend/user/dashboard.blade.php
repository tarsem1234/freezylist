@extends('frontend.layouts.app')
@section ('title', ('Dashboard'))
@section('after-styles')
<link type="text/css" rel="stylesheet" href="{{ asset(mix('css/dashboard.css')) }}" media="all">
@endsection 
@section('content')
<div class="dashboard-page">    
    <div class="container">
        <div class="row content">          
            @include('frontend.includes.sidebar')          
            <div class="col-md-9 col-sm-8">
                <div class="right-dashboard-div">
                    <div class="right-dashboard-div-text">
                        <div class="right-content-div">
                            <h4>My Dashboard</h4>
                            <h6>Hello, {{ getFullName($user) }}</h6>
                            <h5 class="m-zero">From your My Account Dashboard you have the ability to view a snapshot of your recent account activity and update your account information. Select a link below to view or edit information.</h5>
                        </div>
                    </div>
                    <div class="">
                        <div class="col-md-8 col-lg-8 col-sm-12 col-xs-12 mar-top">
                            <div class="row">
                                <div class="right-dashboard-div-text image_info_div">
                                    @if(isset($user->business_profile) && $user->business_profile)
                                    <div class="">
                                        <div class="average-rating text-center pull-right" id="account_info_overall_rating">
                                            <p>Overall Rating</p>
                                            <div id="overall-rating"></div>
                                        </div>
                                    </div>
                                    @endif
                                    <h4>Account Information</h4>
                                    <div class="pro-pic">
                                        @if($user->image)
                                        <img src="{{ asset('storage/profile_images/'.$user->id.'/'. $user->image )}}" style="height: 100%; width: 100%" class='img-responsive'alt="profile photo" class="preview">
                                        @else
                                        <img src="{{ asset('storage/site-images/no_profile_image.png') }}" style="height: 100%; width: 100%" class='img-responsive' alt="profile photo" class="preview">
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if(in_array(config('constant.inverse_user_type.User'), array_column($user->roles->toArray(), 'id')))
                        <div class="col-md-8 col-lg-8 col-sm-12 col-xs-12">
                            <div class="row">
                                <div class="table-responsive">
                                    <div class="right-dashboard-div-table">
                                        <table width="100%">
                                            <tbody>
                                                <tr>
                                                    <th width="30%"><span><i class="fa fa-user-circle" aria-hidden="true"></i></span>Name</th>
                                                    <td width="50%">{{ getFullName($user) }}</td>
                                                </tr>
                                                <tr>
                                                    <th width="30%"><span><i class="fa fa-envelope-o" aria-hidden="true"></i></span>Email</th>
                                                    @if($logged_in_user->email)
                                                    <td width="50%">{{ $logged_in_user->email }}</td>
                                                    @else
                                                    <td width="50%">NA</td>
                                                    @endif
                                                </tr>
                                                <tr>
                                                    <th width="30%"><span><i class="fa fa-phone" aria-hidden="true"></i></span>Phone</th>
                                                    @if($logged_in_user->phone_no)
                                                    <td width="50%">{{ $logged_in_user->phone_no }}</td>
                                                    @else
                                                    <td width="50%">NA</td>
                                                    @endif
                                                </tr>
                                                <tr>
                                                    <th width="30%"><span><i class="fa fa-paper-plane-o" aria-hidden="true"></i>Address</th>
                                                    @if(isset($user->user_profile) && $user->user_profile)
                                                    <td width="50%">{{ $user->user_profile->address }}</td>
                                                    @else
                                                    <td width="50%">NA</td>
                                                    @endif
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                        <div class="col-md-4 col-lg-4 col-sm-12 col-xs-12 button-div <?= (in_array(config('constant.inverse_user_type.User'), array_column($user->roles->toArray(), 'id'))) ? 'user_related_class' : ''; ?>">
                            @if(in_array(config('constant.inverse_user_type.Business'), array_column($user->roles->toArray(), 'id')))
                                <a class="edit-button" href="{{ route("frontend.userReviews", $user->id) }}" id="read_user_review">Read User Review</a>
                            @endif
                            <a class="change-button" href="{{ route('frontend.password.edit') }}">Change Password</a>
                            <a class="edit-button" href="{{ route('frontend.profile.edit',$user->id) }}">Edit Information</a>
                        </div>
                        @if(in_array(config('constant.inverse_user_type.Business'), array_column($user->roles->toArray(), 'id')))
                        <div class="info-wraper">
                            <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12 account-info">
                                <div class="row account-info-left">
                                <div class="table-responsive">
                                    <div class="right-dashboard-div-table">
                                        <table width="100%">
                                            <tbody>
                                                <tr>
                                                    <th width="30%"><span><i class="fa fa-user-circle" aria-hidden="true"></i></span>Name</th>
                                                    <td width="50%">{{ getFullName($user) }}</td>
                                                </tr>
                                                <tr>
                                                    <th width="30%"><span><i class="fa fa-envelope-o" aria-hidden="true"></i></span>Email</th>
                                                    @if($logged_in_user->email)
                                                    <td width="50%">{{ $logged_in_user->email }}</td>
                                                    @else
                                                    <td width="50%">NA</td>
                                                    @endif
                                                </tr>
                                                <tr>
                                                    <th width="30%"><span><i class="fa fa-phone" aria-hidden="true"></i></span>Phone</th>
                                                    @if($logged_in_user->phone_no)
                                                    <td width="50%">{{ $logged_in_user->phone_no }}</td>
                                                    @else
                                                    <td width="50%">NA</td>
                                                    @endif
                                                </tr>
                                                <tr>
                                                    <th width="30%"><span><i class="fa fa-paper-plane-o" aria-hidden="true"></i>Address</th>
                                                    @if(isset($user->business_profile) && $user->business_profile)
                                                    <td width="50%">{{ $user->business_profile->company_address }}</td>
                                                    @else
                                                    <td width="50%">NA</td>
                                                    @endif
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12 account-info">
                                <div class="row account-info-right">
                                <div class="table-responsive">
                                    <div class="right-dashboard-div-table">
                                        <table width="100%">
                                            <tbody>
                                                <tr>
                                                    <th width="30%"><span><i class="fa fa-globe" aria-hidden="true"></i></span>Website</th>
                                                    <td width="50%">{{ $user->business_profile->company_website??"NA" }}</td>
                                                </tr>
                                                <tr>
                                                    <th width="30%"><span><i class="fa fa-industry" aria-hidden="true"></i></span>Industry</th>
                                                    <td width="50%">{{ $user->business_profile->industry->industry??"NA" }}</td>
                                                </tr>
                                                <tr>
                                                    <th width="30%"><span><i class="fa fa-cogs" aria-hidden="true"></i></span>Service Offered</th>
                                                    @if(count($user->subscribeServices) >0)
                                                    <?php foreach($user->subscribeServices as $service){ $serviceArr[] = getSubscribedServices($service->service_id); } ?>
                                                    <td width="50%"> <?php  echo implode(', ',$serviceArr); ?> </td>
                                                    @else
                                                    <td width="50%">NA</td>
                                                    @endif
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('after-scripts')
<script src="{{ asset('js/starr.min.js') }}"></script>
<script>
    $(function(){
        $('#overall-rating').starrr({rating: '{{$user->rating}}', readOnly: true});
    });
</script>
@endsection