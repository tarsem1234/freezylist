@extends('frontend.layouts.app')
@section('title', app_name() . ' | Reset Password')
@section('after-styles')
<link type="text/css" rel="stylesheet" href="{{ asset(mix('css/login.css')) }}" media="all">
@endsection
@section('content')
<div class="login-page reset-pswd">
    <div class="content-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-md-6 col-md-offset-3">
                    @if (session('status'))
                    <div class="alert alert-success">
                        {{ session('status') }}
                    </div>
                    @endif
                    <div class="panel panel-default1">
                        <div class="panel-heading"><span class="black-text"> Reset </span> Password</div> 
                        <div class="">
                            {{ html()->form('POST', route('frontend.auth.password.reset'))->class('form-horizontal')->open() }}
                            <input type="hidden" name="token" value="{{ $token }}">
                            <div class="form-group">
                                <div class="col-md-12">
                                    <h4>E-MAIL ADDRESS</h4>
                                    <p class="form-control-static form-control">{{ $email }}</p>
                                    {{ html()->hidden('email', $email)->class('form-control')->attribute('placeholder', trans('validation.attributes.frontend.email')) }}
                                </div><!--col-md-6-->
                            </div><!--form-group-->

                            <div class="form-group">                         
                                <div class="col-md-12">
                                    <h4>PASSWORD</h4>
                                    {{ html()->password('password')->class('form-control')->attribute('required', 'required')->attribute('autofocus', 'autofocus')->attribute('placeholder', trans('validation.attributes.frontend.password')) }}
                                </div><!--col-md-6-->
                            </div><!--form-group-->

                            <div class="form-group">
                                <div class="col-md-12">
                                    <h4>PASSWORD CONFIRMATION</h4>
                                    {{ html()->password('password_confirmation')->class('form-control')->attribute('required', 'required')->attribute('placeholder', trans('validation.attributes.frontend.password_confirmation')) }}
                                </div><!--col-md-6-->
                            </div><!--form-group-->
                            <div class="form-group">
                                <div class="col-md-12 mr-top">
                                    {{ html()->submit(trans('labels.frontend.passwords.reset_password_button'))->class('btn btn-primary log-in-button') }}
                                </div><!--col-md-6-->
                            </div><!--form-group-->
                            {{ html()->form()->close() }}

                        </div><!-- panel body -->
                    </div><!-- panel -->
                </div><!-- col-md-8 -->
            </div><!-- row -->
        </div>
    </div>
</div>
@endsection
<script type="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
@section('after-scripts')
<script>
$(document).ready(function () {
    $('form').validate({
        rules: {
            password: {
                required: true,
                minLength: 6
            },
            password_confirmation: {
                required: true,
                minLength: 6,
                equalTo: "#password_confirmation"
            }
        },
        messages: {
            password: {
                required: "Please fill in the password",
                minLength: "Your password must be atleast 6 characters long"
            },
            password_confirmation: {
                required: "Please fill in the password again",
                minLength: "Your password must be atleast 6 characters long",
                equalTo: "Please enter the same password as above"
            }
        }
    });
});
</script>
@endsection
