@extends('frontend.layouts.app')
@section('title', app_name() . ' | Login')
@section('after-styles')
<link type="text/css" rel="stylesheet" href="{{ asset(mix('css/login.css')) }}" media="all">
@endsection 
@section('content')
<div class="login-page">
    <!--<div class="content-wrapper">
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="login-banner">
                        <div class="text">Login</div>
                    </div>
                </div>
            </div>
        </div> 
    </div>-->
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="panel panel-default1">
                    <div class="panel-heading"><span class="black-text"> Welcome to</span> Freezylist</div> 
                    <div class="">
                        {{ html()->form('POST', route('frontend.auth.login.post'))->class('form-horizontal')->open() }}
                        <div class="form-group">
                            <span class="col-md-12 text text-danger">{{implode('<br>', $errors->get('email'))}}</span>
                            <div class="col-md-12">
                                <span class="input-icon"><i class="fa fa-user" aria-hidden="true"></i></span>
                                {{ html()->email('email')->class('form-control icon-padding')->attribute('maxlength', '191')->attribute('required', 'required')->attribute('autofocus', 'autofocus')->attribute('placeholder', trans('validation.attributes.frontend.email')) }}
                                @if(count($errors->get('email')) > 0)
                                
                                @endif
                            </div><!--col-md-12-->
                        </div><!--form-group-->
                        <div class="form-group">
                            <div class="col-md-12">
                                <span class="input-icon"><i class="fa fa-lock"></i></span>
                                {{ html()->password('password')->class('form-control icon-padding')->attribute('required', 'required')->attribute('placeholder', trans('validation.attributes.frontend.password')) }}
                                @if(count($errors->get('password')) > 0)
                                <span class="text text-danger">{{implode('<br>', $errors->get('password'))}}</span>
                                @endif
                            </div><!--col-md-12-->
                        </div><!--form-group-->
                        <div class="form-group">
                            <div class="col-md-12">
                                <div class="forget">
                                    {{ html()->a(route('frontend.auth.password.reset'), trans('labels.frontend.passwords.forgot_password')) }}
                                </div>
                            </div><!--col-md-12-->
                        </div><!--form-group-->
                        <div class="form-group">
                            <div class="col-md-12">
                                {{ html()->submit('Sign In')->class('log-in-button')->style('') }}
                            </div><!--col-md-12-->
                        </div><!--form-group-->
                        <div class="form-group">
                            <div class="col-md-12">
                                <a class="signup-text pull-left" href="{{ route('frontend.userCreate') }}">Create User Account</a>
                                <a class="signup-text pull-right" href="{{ route('frontend.businessCreate') }}">Register My Business</a>
                            </div><!--col-md-12-->
                        </div><!--form-group-->
                        {{ html()->form()->close() }}
                        <div class="row text-center">
                            {!! $socialite_links !!}
                        </div>
                    </div><!-- panel body -->
                </div><!-- panel -->
            </div> 
        </div> <!-- row -->
    </div><!-- container -->
</div><!-- login -->
@endsection
@section('after-scripts')
<script>
    $(document).ready(function () {
        $('form').validate({
            rules: {
                email: true
            },
            messages: {
                email: {
                    required: "Please enter your email address",
                    email: "Please enter valid email address"
                },
                password: "Please enter your password"
            }
        });
    });
</script>
@endsection