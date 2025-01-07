@extends('frontend.layouts.app')
@section('title', app_name() . ' | Learning Center')
@section('after-styles')
<link type="text/css" rel="stylesheet" href="{{ asset(mix('css/dashboard.css')) }}" media="all">  
<style>#learning_center{ font-weight: bold;color: #000;}</style>
@endsection 
@section('content')
<div class="forum-page signer-page dashboard-page associates profile-view learning-center learning_topic_single">    
    <div class="container">
        <div class="row content">
            @include('frontend.includes.sidebar')
            <div class="col-md-9 col-sm-8">
                <div class="right-dashboard-div">
                    <!-- <div class="profile right-dashboard-div-text">
                        <div class="row">  
                            <div class="col-md-12">
                                <h4 class="pull-left m-bottom">{{$category->category}}</h4>    
                            </div>
                        </div>
                        <hr class="lc_hr" />
                        <div class="description">
                            <div class="l-descr">{!! $category->description !!}</div>
                        </div>
                    </div> -->
                    
                    <div class="table-buy-home">
                            <div class="col-lg-12 col-sm-12 col-xs-12 mar-top">
                                <div class="row"> 
                                    <div class="right-dashboard-div-text">
                                        <p style="text-align: left;margin-top: 0px;margin-bottom: 30px;color: #262626;">Please Select your training session below by clicking the blue session description.</p>
                                        <h4 class="m-bottom">{{$category->category}} : Sessions</h4>
                                        <hr class="lc_hr" />
                                        <div class="table-responsive">
                                            <table class="table m-zero">
                                                <thead>
                                                    <tr>
                                                    <th>Session</th>
                                                    <th>Description</th>
                                                    <th>Points/Status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @forelse($sessions as $session)
                                                    <tr>
                                                    <td class="list-heading">{{ $session->name }}</td>
                                                    <td class="list-heading detail-max"> 
                                                        <a href="{{ route('frontend.learning.session',$session->id) }}" class="">
                                                            {{ strip_tags(substr($session->description,0,35)) }}
                                                        </a>
                                                    </td>
                                                    @if(auth()->user()->lerning_points()->where('category_session_id', $session->id)->get()->count() == 0)
                                                    <td class="list-heading">+{{ $session->points }}/New</td>
                                                    @else 
                                                    <td class="list-heading">+{{ config('lc_config.next_attempt_points') }}/Completed</td>
                                                    @endif
                                                    </tr>
                                                    @empty
                                                    <tr><td colspan="3">Check Back Soon - We Are Drafting This Content</td></tr>
                                                    @endforelse
                                                </tbody>
                                            </table> 
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    <div class="learning-topics clearfix">
                        <div class="col-lg-12 col-sm-12 col-xs-12 mar-top">
                            <div class="row"> 
                                <div class="right-dashboard-div-text  padding-right">
                                    <h4 class="m-bottom">Other Learning Topics</h4>
                                    <hr class="lc_hr" />

                                    <div class="l-topic-btns clearfix">
                                        @php $x=0 @endphp 
                                        <div class="btns-green-blue all-buttons clearfix">  
                                            @foreach ($categories as $cat) 
                                            @if ($x != 0 && $x % 4 == 0)                                  
                                            @endif
                                            <a class="btn btn-blue button" data-spy="scroll" data-value="{{$cat->id}}"  href="{{ route('frontend.learning.topic',$cat->id) }}">
                                                <span class="heading_text">{{ $cat->category }}</span>
                                            </a>                                        
                                            @php ++$x @endphp 
                                            @endforeach
                                        </div>                                   
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('after-scripts')
@if (config('access.captcha.registration'))
{!! NoCaptcha::renderJs('recaptchaCallback') !!}
@endif
<script>
    $(document).ready(function () {
        var url = window.location.pathname;
        var result = url.split('/');
        $('.right-dashboard-div-text').find('[data-value="' + result[3] + '"]').addClass('active-btns');
    });
</script>
@endsection

