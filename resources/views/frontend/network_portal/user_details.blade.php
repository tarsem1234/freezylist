@extends('frontend.layouts.app')
@section('title', app_name() . ' | User Details')
@section('after-styles')
<link type="text/css" rel="stylesheet" href="{{ asset(mix('css/dashboard.css')) }}" media="all">
@endsection 
@section('content')
<div class="dashboard-page profile-view">
    <div class="container">
        <div class="row content">
            @include('frontend.includes.sidebar')
            <div class="col-md-9 col-sm-8">
                <div class="right-dashboard-div">
                    <div class="profile right-dashboard-div-text">
                        <div class="profile-sidebar">
                            <?php // dd($user->toArray()); ?>                                                        
                            @if($user->user_profile)
                            <h4>Member Profile</h4>
                            @endif
                            @if($user->business_profile)
                            <h4>Pro Services Profile</h4>
                            @endif
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
                            <!-- SIDEBAR USERPIC -->
                            <div class="profile-userpic">
                          
                                @if(!empty($user->image))
                                <img src="{{ asset('storage/profile_images/'.$user->id.'/'. $user->image) }}" style="height: 100%;" class='img-responsive'alt="profile photo" class="preview">
                                @else
                                <img src="{{ asset('storage/site-images/no_image_available.jpg' )}}" style="height: 100%;" class='img-responsive' alt="profile photo" class="preview">
                                @endif
                            </div>                                                       
                            @if(isset($user->business_profile))
                            <div class="user_rating text-center row" id="user_rating" v-cloak>
                                <div class="col-md-12">                                     
                                    <div class="btns-green-blue mr-top">
                                        <button class="btn button btn-green" @click="showRatingBox=true">{{$userRating ? "Edit Review" : "Rate business"}}</button>
                                        <a class="btn button btn-blue" href="{{route("frontend.userReviews", $user->id)}}">Reviews</a>
                                    </div>
                                    <div class="rating-box" v-show="showRatingBox">
                                        <h5 class="profile-usertitle-name"><b>Your Rating</b></h5>   
                                        <div id="rating"></div> 
                                        <div class="btns-green-blue mr-top">
                                            <textarea class="form-control text-height" v-model="rating.review" placeholder="wrtie review"></textarea>
                                            <div class="text text-danger" v-if="reviewTextInvalid">Review is required</div>
                                            <button class="btn button btn-green" @click='submitReview()'>Submit</button>
                                            <button class="btn button btn-blue" @click="resetToDefault()">cancel</button>
                                        </div>
                                    </div> 
                                </div> 
                            </div>


                            <div class="row"> 
                                <div class="rating-div">
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12"> 
                                        <div class="average-rating text-center">
                                            <div id="your-rating"></div>
                                            <p>Your Rating</p> 
                                        </div>
                                    </div>

                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12  text-center recommendations">
                                        @if(!$recommended)
                                        <a class="btn btn-like" data-recommendation_route="{{route('frontend.recommendBusiness', $user->id)}}"><i class="fa fa-thumbs-up fa-lg"></i> Recommend </a>
                                        <p> {{$recommendations}} Recommendations</p>
                                        @else
                                        You and {{$recommendations-1}} other recommended this
                                        @endif
                                    </div>

                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12"> 
                                        <div class="average-rating text-center"> 
                                            <div id="overall-rating"></div>
                                            <p>Overall Rating</p>
                                        </div>
                                    </div>                  
                                </div>                                
                            </div>
                            @endif
                            <div class="profile-usermenu">
                                <ul class="nav">
                                    <li>
                                        <p><span class="heading-head">Name: </span>
                                            @if($user->user_profile)
                                            {{$user->user_profile->full_name}}
                                            @elseif($user->business_profile)
                                            {{$user->business_profile->company_name}}
                                            @endif
                                        </p>
                                    </li>

                                    <?php if (isset($user->business_profile)) { ?>
                                        <li>
                                            <p> <span class="heading-head">City: </span>@if($user->city){{ $user->city }} @else NA @endif</p>
                                        </li>
                                        <li>
                                            <p> <span class="heading-head">State: </span><?php echo findState($user->state_id); ?></p>
                                        </li>
                                        <li>
                                            <p> <span class="heading-head">Zip Code: </span>@if($user->zip_code){{ $user->zip_code }} @else NA @endif</p>
                                        </li>
                                        <?php
                                        $industry = findIndustryWIthServices($user->business_profile->industry_id);

                                        foreach ($industry->services as $service) {
                                            $arrServices[] = $service->service;
                                        }
                                        $exploadedServices = implode(', ',
                                            $arrServices);
                                        ?>
                                        <li>
                                            <p> <span class="heading-head">Industry: </span>@if($user->business_profile->industry_id) {{ $industry->industry }} @else NA @endif</p>
                                        </li>
                                        <li>
                                            <p> <span class="heading-head">Services: </span>@if($exploadedServices) {{ $exploadedServices }} @else NA @endif</p>
                                        </li>
                                        <li>
                                            <p> <span class="heading-head">Company Website: </span>@if($user->business_profile->company_website) {{ $user->business_profile->company_website }} @else NA @endif</p>
                                        </li>
                                    <?php } ?>

                                    @if($user->user_profile)
                                    <li>
                                        <p> <span class="heading-head">Interests:</span>
                                            <?php if ($user->user_profile->user_interests->count()) { ?>
                                                @foreach($user->user_profile->user_interests as $interest)
                                                <span class="alert alert-info interest-buttons">{{ config('constant.interests.'.$interest->interest_type) }}</span>
                                                @endforeach
                                            <?php } else { ?>
                                                NA
                                            <?php } ?>
                                        </p>
                                    </li>
                                    <li>
                                        <p><span class="heading-head">City, State:</span> {{$user->city}}, <?php echo findState($user->state_id); ?></p>
                                    </li>
                                    <li>
                                        <?php
                                        $points = 0;
                                        if (isset($user->lerning_points)) {
                                            foreach ($user->lerning_points as $point) {
                                                $points = $point->points + $points;
                                            }
                                        }
                                        ?>
                                        <p><span class="heading-head">Account Ranking:</span>  {{$points}} Points</p>
                                    </li>
                                    <li>
                                        <p><span class="heading-head">Total Connections:</span> Total Connections: 0</p>
                                    </li>
                                    @endif

                                </ul>
                            </div>
                            <!-- END MENU -->
                            <div class="btns-green-blue text-center">
                                <?php if ($network) {
                                    if ($network->status != config('constant.inverse_network_request.pending')) {
                                        ?>
                                        <a type="button"class="button btn btn-blue">Associated</a>
                                        <a href="{{ route('frontend.messages.conversation',encrypt($user->id)) }}" type="button" class="button btn btn-green m-left">Contact User</a>
                                    <?php } elseif($network->to_user_id == Auth::id() && $network->status == config('constant.inverse_network_request.pending')){ ?>
                                        <a href="{{ route('frontend.accept.request',$user->id) }}" type="button" class="button btn btn-blue m-left">Accept Request</a>
                                        <a href="{{ route('frontend.reject.request',$user->id) }}" type="button" class="button btn btn-green m-left">Reject Request</a>
                                    <?php } elseif($network->from_user_id == Auth::id() && $network->status == config('constant.inverse_network_request.pending')) { ?>
                                        <a type="button" disabled="disabled" class="button btn btn-green">Request Sent</a>
                                    <?php } ?>
                                <?php } else { ?>
                                    <a href="{{route('frontend.request.sent',$user->id)}}" type="button"class="button btn btn-green m-left">Add to My Network</a>
                                <?php } ?>
                                <a href="{{ URL::previous() }}" type="button" class="button btn btn-blue">Back</a>

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
<script src="{{ asset('js/starr.min.js') }}"></script>
@if(isset($user->business_profile))
<script>
    new Vue({
        el: "#user_rating",
        data: {
            showRatingBox: false,
            rating: {review: '{{$userRating->review ?? ""}}', rating: '{{$userRating->rating ?? 0}}'},
            overAllRating: "{{$user->rating}}",
            reviewTextInvalid: false,
            userRating: @json($userRating ?? [], JSON_FORCE_OBJECT),
        },
        methods: {
            resetToDefault() {
                this.showRatingBox = false;
            },
            submitReview() {
                if (this.rating.review == '') {
                    this.reviewTextInvalid = true;
                } else {
                    this.reviewTextInvalid = false;
                    this.rating.user_id = "{{$user->id}}";
                    var vr = this;
                    axios.post("{{route('frontend.rateUser')}}", this.rating).then(function (response) {
                        vr.overAllRating = response.data.rating;
                        vr.renderOverAllRating();
                        window.location.reload();
                    });
                }
            },
            renderOverAllRating() {
                var r = this.overAllRating;
                $('#overall-rating').starrr({rating: r, readOnly: true});
            }
        },
        mounted() {
            this.renderOverAllRating();
            var vr = this;
            $('#rating').starrr({
                rating: vr.rating.rating,
                change(e, v) {
                    vr.rating.rating = v;
                }
            });
            $('#your-rating').starrr({rating: vr.rating.rating, readOnly: true});
        }
    });

    $(".btn-like").click(function (e) {
        e.preventDefault();
        $('.btn-like').prop('disabled', true);
        url = $(this).attr('data-recommendation_route');
        $.ajax({
            type: 'get',
            dataType: 'json',
            url: url,
            success: function (data) {
                $('.btn-like').remove();
                var totalRe = data.recommendations - 1;
                $('.recommendations').html('You and ' + totalRe + ' other recommended this');
            },
            error: function (data) {
                $('.btn-like').prop('disabled', false);
            }
        });

    });

</script>
@endif
@endsection