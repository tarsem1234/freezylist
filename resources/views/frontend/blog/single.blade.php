@extends('frontend.layouts.app')
@section ('title', ('Blog-Single'))
@section('after-styles')
<link type="text/css" rel="stylesheet" href="{{ asset(mix('css/blog-single.css')) }}" media="all">
@endsection 
@section('content')
<div class="contact-page blog-page blog-single-page blog-bg"> 
    <!--<div class="content-wrapper">
        <div class="row">
            <div class="col-md-12">
                <!--<div class="row">
                    <div class="contact-banner">
                        <div class="text">Blog</div>
                    </div><!--content-banner
                </div>
            </div><!--coi-12--
        </div><!--row--
    </div><!--content-wrapper-->
    </br>
    <div class="blog-pics comment-page">
        <div class="container">
            <div class="row">                
                <div class="col-lg-12"> 
                    <div class="">                        
                        <div class="blog-pic">
                            <div class="blog-pic-1"><img src="{{asset('storage'.'/'. $blog->image )}}"/></div>
                        </div><!--blog-pic-->
                        <div class="blog-text user-div">                            
                            <!--                            <h1>{{strip_tags($blog->title)}}</h1>
                                                        <div class="time-div">
                                                            <h5><?php echo strip_tags($blog->content); ?></h5>
                                                            <time class="comment_time">{{date("d F Y", strtotime($blog->created_at))}}</time>
                                                        </div>-->

                            <h1>{{strip_tags($blog->title)}}</h1>
                            <div class="time-div">
                                <time class="comment_time">{{date("d F Y", strtotime($blog->created_at))}}</time>
                            </div>
                            <p><?php echo $blog->content; ?></p>

                            
                            <div class="blog-button-div">                                  
                                <a class="member-button">Member Comments</a>
                                <?php if ($blog->comments->count()) { ?>
                                    @foreach($blog->comments as $comment)
                                    <div class="comment-page panel-box panel-default">
                                        <div class="user-div" style="text-align: left;">
                                            <!--<h1 style="color: #25bbe2;">first topic</h1>-->
                                            <p>{{$comment->comment}}</p>
                                            @if($comment->user->user_profile)
                                            <h5>By: {{$comment->user->user_profile->full_name}}</h5>
                                            @elseif($comment->user->business_profile)
                                            <h5>By: {{$comment->user->business_profile->company_name}}</h5>
                                            @else
                                            <h5>By: {{$comment->user->full_name}}</h5>
                                            @endif
                                            <time class="comment_time">{{date("d F Y", strtotime($comment->created_at))}}</time>
                                        </div>
                                    </div>
                                    @endforeach
                                <?php } ?>
                                @guest
                                <a class="click-button" href="{{route('frontend.auth.login')}}">What's on your mind<span class="text">must be signed in to comment. <span class="blue-text">Click Here to Login/Create a Free Account.</span></span></a>
                                @endguest
                            </div>
                            @auth
                            <div id="form_text_main">                   
                                <div class="form-group">                                         
                                    <h4 class="chat-text">What's on your mind?</h4>
                                    {{ html()->form('POST', route('frontend.user.storeComment', ))->class('form-horizontal')->attribute('role', 'form')->open() }}
                                    <textarea class="form-control" required="required" placeholder="Comment" name="comment" cols="50" rows="10" data-msg-required="Please leave your comment" value="{{old('comment')}}"></textarea>
                                    <span class="text text-danger">{{$errors->first('comment')}} </span>
                                    
                                    <input type="hidden"name="blog_id" value="{{$blog->id}}">
                                    <span class="text text-danger">{{$errors->first('blog_id')}}</span>
                                    <div class="btns-green-blue text-center mar-top margin-bottom">                                       
                                        <input class="btn button btn-green" type="submit" value="Submit"/>
                                        <a class="btn button btn-blue" href="{{ route('frontend.blogs') }}">Back</a>
                                    </div>
                                    {{ html()->form()->close() }}
                                </div>                           
                            </div>
                            @endauth 
                        </div><!--blog-text-->    
                    </div><!--blog-box-->
                </div><!--col-6-->
            </div><!--row-->
        </div><!--container-->
    </div><!--blog-pics-->
</div>
@endsection

@section('after-scripts')
<script>
    $(document).ready(function () {
        $('form').validate({
            rules: {
                comment: {
                    minlength: 50
                }
            },
            messages: {
                comment: {
                    minlength: "Blog posts require a minimum of fifty characters."
                }
            }
        });
    });
</script>
@endsection
