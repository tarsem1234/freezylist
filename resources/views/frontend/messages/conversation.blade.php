@extends('frontend.layouts.app')
@section('title', app_name() . ' | Conversation')
@section('after-styles')
<link type="text/css" rel="stylesheet" href="{{ asset(mix('css/dashboard.css')) }}" media="all">  
<style>#messages{ font-weight: bold;color: #000;}</style>
@endsection 
@section('content')
<div class="forum-page signer-page dashboard-page associates profile-view  conversation-page">    
    <div class="container">
        <div class="row content">
            @include('frontend.includes.sidebar')
            <div class="col-md-9 col-sm-8">
                <div class="right-dashboard-div">
                    <div class="profile right-dashboard-div-text" id="vueEl">
                        <div class="row">  
                            <div class="col-md-12">
                                    <h4>Conversation with {{getFullName($fromUser)}}</h4>
                                {{ html()->form('POST', route('frontend.messages.conversation', [encrypt($fromUser->id)]))->id('conversation_form')->open() }}
                                <div class="panel panel-default chat-widget">
                                    <!--                                    <div class="panel-heading">
                                                                            <h3 class="panel-title"><i class="fa fa-comments"></i> </h3>
                                                                        </div>-->
                                    <div class="panel-body scrollbar" id="scrollbar"> 
                                        @forelse($messages as $message)
                                        
                                        <div class="message {{$message->user_id == Auth::id() ? 'message-right' : ''}} {{$message->status==0 || $loop->last ? 'unread' : ''}}">
                                            <div class="avatar">
                                                <img class="img-circle avatar" alt="chat avatar" src="{{!empty($message->fromUser->picture)?$message->fromUser->picture:''}}">
                                            </div>
                                            <div class="message-text-wrapper"> 
                                                <div class="message-text">
                                                    {!!$message->message!!}
                                                </div>
                                            </div> 
                                            <p class="time-stamp"><i class="fa fa-check"></i>{{$message->created_at}}</p>
                                        </div>
                                        @php
                                        @endphp
                                        @empty 
                                        <div class="text text-success">Start conversation</div>
                                        @endforelse
                                    </div>
                                    @if(empty($fromUser->deleted_at) && !empty($fromUser->status) && empty($network->deleted_at))
                                    <div class="panel-footer">
                                        <div class="">
                                            <div class="text-box">
                                                <textarea class="form-control" name="message" id="message" placeholder="Type A Message" required="required"></textarea>                                           
                                                <div class="send-button"><span type="submit" class="btn btn-info btn-lg icon-btn"><i class="fa fa-send"></i> </span></div>
                                            </div>
                                        </div>
                                    </div>
                                    @elseif(!empty($fromUser->deleted_at) || empty($fromUser->status))
                                    <div class="">
                                       <h4 class="no-data">Unable to chat with user as the user is not exist. </h4>
                                     </div>
                                    </div>
                                    @elseif(!empty($network->deleted_at))
                                    <div class="">
                                       <h4 class="no-data">Unable to chat with user as the user is no longer in your friend list.</h4>
                                     </div>
                                    </div>
                                    @endif
                                </div>
                                {{ html()->form()->close() }}
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
<script>
    $(function () {
        $('.send-button').click(function () {
            $('#conversation_form').submit();
        });
        if ($('.unread').length > 0) {
            var $container = $(".chat-widget .panel-body");
            var $scrollTo = $('.chat-widget .panel-body .unread:first');
            $container.animate({scrollTop: $scrollTo.offset().top - $container.offset().top + $container.scrollTop(), scrollLeft: 0}, 0);
        }
    });
</script>
@endsection