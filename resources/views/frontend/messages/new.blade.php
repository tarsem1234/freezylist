@extends('frontend.layouts.app')
@section('title', app_name() . ' | Learning Center')
@section('after-styles')
<link type="text/css" rel="stylesheet" href="{{ asset(mix('css/dashboard.css')) }}" media="all">  
<style>
    #messages{ font-weight: bold;color: #000;}
    .select2-container {
        margin-bottom: 20px;
    }
</style>
@endsection 
@section('content')
<div class="dashboard-page associates para-text">     
    <div class="container">
        <div class="row content">
            @include('frontend.includes.sidebar')
            <div class="col-md-9 col-sm-8">
                <div class="right-dashboard-div"> 
                    <div class="profile right-dashboard-div-text para-text"> 
                        <h4 class="pull-left">Compose Message</h4> 
                        <div class="row">
                            @if(count($allAssociates)<=0)
                            <div class="message-box text-center">
                                <h3 class="text-danger">You don't have any associates yet.</h3>
                            </div>
                            @else
                            <div class="message-box">
                                {{ html()->form('POST', route('frontend.messages.new'))->open() }}
                                <div class="form-group col-md-12">
                                    {{ html()->select('id', $allAssociates)->class('form-control') }}
                                </div>
                                <div class="form-group col-md-12">
                                    {{ html()->textarea('message')->class('form-control text-height')->attribute('row', '2')->placeholder('Type A Message') }}
                                </div>
                                <div class="form-group col-md-12 btns-green-blue pull-right">
                                    <input type="submit" class="button btn btn-blue" name="submit" id="inputbutton" value="Send">
                                </div>
                                {{ html()->form()->close() }} 
                            </div>
                            @endif
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
<script>
    $(document).ready(function () {
        $('select').select2();
    });
</script>
@endif
@endsection