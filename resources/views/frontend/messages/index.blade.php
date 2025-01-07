@extends('frontend.layouts.app')
@section('title', app_name() . ' | Learning Center')
@section('after-styles')
<link type="text/css" rel="stylesheet" href="{{ asset(mix('css/dashboard.css')) }}" media="all">  
<style>#messages{ font-weight: bold;color: #000;}</style>
@endsection 
@section('content')
<div class="forum-page signer-page dashboard-page associates">    
    <div class="container">
        <div class="row content">
            @include('frontend.includes.sidebar')
            <div class="col-md-9 col-sm-8">
                <div class="right-dashboard-div">
                    <div class="profile right-dashboard-div-text">
                        <div class="row">  
                            <div class="col-md-12"> 
                                <div class="col-sm-7 p-zero">
                                    <h4 class="pull-left">My Messages</h4>
                                </div>
                            </div>
                            <div class="col-md-12">
                                @if($messages->count() > 0)
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                            <th>Message From</th>
                                            <th>Last Message Date</th>
                                            <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($messages as $index => $message)
                                            <tr class="{{ ($message->status == 0 && $message->toUserId == Auth::id()) ? 'shadow-tr-unreadmsg' :  "" }}">
                                                <td style="{{ ($message->status == 0 && $message->toUserId == Auth::id()) ? 'font-style: italic;font-style: italic;' :  "" }}"> @if($message->status == 0 && $message->toUserId == Auth::id())  <i class='fa fa-bell' style="color:#ef8080;float: left;margin-top: 5px;"></i> @else  @endif {{getFullName($message->otherUser)}}</td>
                                                <td>{{$message->created_at}}</td>
                                                <td>
                                                    @if(!empty($message->otherUser->id))
                                                    <a href="{{route('frontend.messages.conversation', encrypt($message->otherUser->id))}}" class="btn btn-info btn-lg icon-btn"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                                    @endif
                                                    <span type="button" class="btn btn-info btn-lg icon-btn  delete-icon" data-toggle="modal" data-target="#myModal" title="Delete"><i class="fa fa-trash-o"></i> </span>
                                                    <!-- Modal -->
                                                    <div id="myModal" class="modal fade" role="dialog">
                                                        <div class="modal-dialog">

                                                            <!-- Modal content-->
                                                            <div class="modal-content">
                                                                <div class="modal-body">
                                                                    <p>Are you sure you want to delete this message?</p>
                                                                </div>
                                                                <div class="text-center btns-green-blue small-buttons">
                                                                @if(!empty($message->otherUser->id))
                                                                    <a href="{{route('frontend.messages.delete', encrypt($message->otherUser->id))}}" type="button" class="btn btn-green">Confirm</a>
                                                                @endif    
                                                                    <button type="button" class="button btn btn-blue" data-dismiss="modal">Cancel</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div><!-- table-responsive -->
                                @else
                                <h4 class="no-data">There are no messages for you.</h4>
                                @endif
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
{!! NoCaptcha::renderJs('recaptcha_callback') !!}
@endif
@endsection