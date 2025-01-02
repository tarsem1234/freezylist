@extends('frontend.layouts.app')
@section ('title', ('Replies'))
@section('after-styles')
<link type="text/css" rel="stylesheet" href="{{ asset(mix('css/forum.css')) }}" media="all">
@section('content')
<div class="register-page comment-page contract-tools-seller-common nested-div">
    <div class="container"> 
        <div class="row">
            <div class="col-lg-12 panel panel-default">
                <div class=""> 
                    <div class="user-div"style="text-align: left;">
                        <h1>{{$forum->topic}}</h1>
                        <p><?php echo $forum->detail; ?></p>
                        @if($forum->user->user_profile)
                        <h5>By: {{$forum->user->user_profile->full_name}}</h5>

                        @elseif($forum->user->business_profile)
                        <h5>By: {{$forum->user->business_profile->company_name}}</h5>
                        @else
                        <h5>By: {{$forum->user->full_name}}</h5> 
                        @endif
                        <time class="comment_time">{{date("d F Y", strtotime($forum->created_at))}}</time>

                    </div>
                    <?php if ($forum->replies->count()) { ?>
                        <div class="reply-text">Total Reply : {{$forum->replies->count()}}</div>
                        @foreach($forum->replies as $reply)
                        <div class="depth-1 comment">
                            <div class="comment_content">
                                <div class="comment_info">
                                    @if($reply->user->user_profile)
                                    <h4>{{$reply->user->user_profile->full_name}}</h4>
                                    @endif
                                    @if($reply->user->business_profile)
                                    <h4>{{$reply->user->business_profile->company_name}}</h4>
                                    @endif
                                    <div class="comment_meta">
                                        <time class="comment_time">{{date("d F Y", strtotime($reply->created_at))}}</time>
                                    </div>
                                </div>

                                <div class="comment_text">
                                    <p>{{$reply->reply}}</p>
                                </div>
                            </div>
                        </div> <!-- end comment level 1 -->
                        @endforeach
                    <?php } else { ?> 
                        <div class="reply">
                            <h2 class="reply-text">No Replies.</h2> 
                        </div>
                    <?php } ?>
                    @auth
                    <div class="panel-heading border-text"><span class="black-text">Leave</span> Reply</div>
                    <div class="">

                        <div id="form_text_main">
                            <div class="col-md-12">
                                {{ html()->form('POST', route('frontend.saveForumReply', ))->class('form-horizontal')->attribute('role', 'form')->open() }}
                                <div class="form-group">
                                    <label for="" class=" control-label">Your Answer</label>
                                    <div class="">
                                        <textarea name="forum_reply" id="reply-comment-area" class="form-control textarea-height" required="true" ></textarea>
                                        <input type="hidden" name="forum_id" value="{{$forum->id}}">
                                    </div>
                                </div>                                                   
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <div class="btns-green-blue text-center">
                                            <button type="submit" class="btn-green button" data-dismiss="modal">submit</button>
                                            <button type="button" id="reset-comment" class="btn-blue button" data-dismiss="modal">Reset</button>
                                        </div>
                                    </div><!--col-md-12-->
                                </div><!--form-group-->
                                {{ html()->form()->close() }}
                            </div><!-- panel body -->
                        </div><!-- panel -->
                    </div><!-- col-md-12 -->
                    @endauth
                </div><!-- con-md-12 -->
            </div><!-- row -->
        </div>
    </div>      
</div>
@endsection

@section('after-scripts')
<script>
    $(document).ready(function () {
        $("#reset-comment").click(function () {
            $("#reply-comment-area").val("");
        });

        $('form').validate({
            messages: {
                forum_reply: "Please leave your message"
            }
        });
    });
</script>
@endsection 