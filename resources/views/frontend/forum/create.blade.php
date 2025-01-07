@extends('frontend.layouts.app')
@section ('title', ('Topic'))
@section('after-styles')
<link type="text/css" rel="stylesheet" href="{{ asset(mix('css/login.css')) }}" media="all"> 
@section('content') 
{{-- dd($user->toArray()) --}} 
<div class="login-page create-topic">
    <div class="container">
        <div class="row"> 
            <div class="col-md-6 col-md-offset-3">
                <div class="panel"> 
                    <div class="panel-heading"><span class="black-text">Create  </span>New Topic</div>
                    <div class="panel-default1">
                        {{ html()->form('POST', route('frontend.forum.topic.store', ))->class('form-group')->attribute('role', 'form')->open() }}
                        <div class="form-group">
                            <h4 for="" class=" control-label">Topic</h4>
                            <div class="">
                                <input id="" name="forum_topic" class="form-control" type="text" required="true" >
                            </div>
                        </div>
                        <div class="form-group">
                            <h4 for="" class=" control-label">Your Details</h4>
                            <div class="">
                                <textarea name="forum_detail" class="form-control text-height" required="true" ></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                                <div class="">
                                    <div class="form-group btns-green-blue text-center margin-bottom">
                                        <button type="submit" class="btn-green button" data-dismiss="modal">submit</button>
                                        <button type="button" id="topic-reset" class="btn-blue button" data-dismiss="modal">Reset</button>
                                    </div>
                                </div><!--col-md-12-->
                            </div><!--form-group-->
                                                                     
                        {{ html()->form()->close() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('after-scripts')
<script>
    $(document).ready(function(){
       $('form').validate({
           messages: {
               forum_topic: "Please fill topic name",
               forum_detail: "Please provide some details"
           }
       });
    });
    
    $('#topic-reset').click(function(){
        $('form.form-group .form-control').val('');
    })
</script>

@if (config('access.captcha.registration'))
{!! NoCaptcha::Renderjs() !!}
@endif
@endsection