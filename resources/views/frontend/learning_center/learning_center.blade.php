@extends('frontend.layouts.app')
@section('title', app_name() . ' | Learning Center') 
@section('after-styles')
<link type="text/css" rel="stylesheet" href="{{ asset(mix('css/dashboard.css')) }}" media="all">  
<style>
    #learning_center{ font-weight: bold;color: #000;}
    .learning-center{
        .l-topic-btns{
            a {
                max-width: 258px;
                min-width: 258px;
            }
            /*a:nth-of-type(3n) {
                margin-right: 0  ! important;
            }*/
        }
    }
    .tooltip{
        font-size: 16px;
    }
    .tooltip-inner {
        padding: 3px 8px;
        text-align: center;
        border-radius: 2px;
      }
</style> 
@endsection 
@section('content')
<div class="forum-page signer-page dashboard-page associates profile-view learning-center">     
    <div class="container">
        <div class="row content">
            @include('frontend.includes.sidebar')
            <div class="col-md-9 col-sm-8">
                <div class="right-dashboard-div">
                    <div class="profile right-dashboard-div-text">
                        <div class="row">  
                            <div class="col-md-12"> 
                                <div class="col-sm-12 col-lg-7  col-md-7 p-zero">
                                    <h5 class="pull-left welcome-learning-center">Welcome to your personal Learning Center</h5>
                                </div>
                                <div class="col-sm-12 col-lg-5 col-md-5 level-img p-zero">
                                    <div class="level-img-points pull-right">
                                        <div id="learning-points">
                                            <span class="current-std"><b><i> Current Standing: </i>{{$level['points']}} Pts </b></span> <br>
                                            <span class="next-level"><i>[Next Level: {{$level['next_level_points']}} Pts!]</i></span>
                                        </div>
                                        <div id="learning-level">
                                            <img src="{{$level['level_image']}}" class="img-responsive">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr class="lc_hr" />
                        <div class="description">
                            <ul>
                                <li>
                                    Our learning sessions are brief and easy to follow. 
                                    Join the weekly bonus sessions & enjoy the brief training modules of your choice. 
                                    You also earn points for each module which add to your account ranking.
                                </li>
                            </ul>
                            
                        </div>
                    </div>
                    <!-- <div class="weekly-bonus-session">
                        @if(!empty($bonusSession))
                        <a href="{{route('frontend.learning.bonus_session', $bonusSession->category_session_id)}}" >
                            Weekly Bonus Session (Click Here!)
                        </a>
                        @else
                        <a href="#" >
                            Weekly Bonus Session (Click Here!)
                        </a>
                        @endif
                    </div> -->
                    <div class="learning-topics">
                        <div class="col-lg-12 col-sm-12 col-xs-12">
                            <div class="row"> 
                                <div class="right-dashboard-div-text">
                                    <div class="col-lg-6">
                                        <h4 class="m-bottom">Learning Topics <span class="like_to_learn">(What Interests You?)</span></h4>
                                    </div>
                                    <div class="col-lg-6">
                                        <h4 class="m-bottom1">*Our weekly bonus session offers bonus points!*</h4>
                                    </div>
                                    
                                    <hr class="lc_hr" /> 
                                    <div class="l-topic-btns text-center">
                                        @php $x = 0 @endphp
                                        <div class="col-sm-12 l-topic-btns btns-green-blue all-buttons clearfix">
                                            <div class="row">
                                                @foreach ($categories as $category)
                                                @if ($x != 0 && $x % 4 == 0)
                                                @endif
                                                <a data-toggle="tooltip" title="{{ $category->category }}" class="btn btn-blue button" href="{{ route('frontend.learning.topic',$category->id) }}">
                                                    <span class="heading_text">
                                                        <?php
                                                        $string = $category->category;
                                                        if (strlen($category->category) > 25) {
                                                            $stringCut = substr($string, 0, 25);
                                                            $endPoint  = strrpos($stringCut, ' ');
                                                            $string = $endPoint ? substr($stringCut, 0, $endPoint) : substr($stringCut, 0);
                                                            $string .= '...';
                                                            echo $string;
                                                        } else {
                                                            echo $category->category;
                                                        }
                                                        ?></span>
                                                    <!--<span class="heading_text"> {{ $category->category }}</span>-->
                                                </a>                                          
                                                @php ++$x @endphp
                                                @endforeach
                                                @if(!empty($bonusSession))
                                                <a data-toggle="tooltip" title="Weekly Bonus" class="btn btn-blue button weekly_bonus_button" href="{{route('frontend.learning.bonus_session', $bonusSession->category_session_id)}}">Weekly Bonus
                                                </a>
                                                @endif
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
</div>
@endsection

@section('after-scripts')
@if (config('access.captcha.registration'))
{!! NoCaptcha::renderJs('recaptchaCallback') !!}
@endif
<script>
    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();
      });
</script>
@endsection

