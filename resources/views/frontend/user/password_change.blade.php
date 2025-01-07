@extends('frontend.layouts.app')
@section ('title', ('Change-Password'))
@section('after-styles')
<link type="text/css" rel="stylesheet" href="{{ asset(mix('css/login.css')) }}" media="all">
@endsection 
@section('content')
<div class="login-page password dashboard-page register-page">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="panel panel-default1">
                    <div class="panel-heading"><span class="black-text">Change</span> Password</div>
                    <div class="">
                        {{ html()->form('POST', route('frontend.password.change', ))->class('form-horizontal')->open() }}
                        <!--{{ html()->label(trans('validation.attributes.frontend.old_password'), 'old_password')->class('col-md-4 control-label') }}-->
                        <div class="form-group">
                            <div class="col-md-12">
                                {{ html()->password('old_password')->class('form-control')->attribute('required', 'required')->attribute('autofocus', 'autofocus')->attribute('placeholder', trans('validation.attributes.frontend.old_password')) }}
                            </div>
                        </div>

                        <div class="form-group">
                            <!--{{ html()->label(trans('validation.attributes.frontend.new_password'), 'password')->class('col-md-4 control-label') }}-->
                            <div class="col-md-12">
                                {{ html()->password('password')->class('form-control')->attribute('required', 'required')->attribute('placeholder', trans('validation.attributes.frontend.new_password')) }}
                            </div>
                        </div>
                        <div class="form-group">
                            <!--{{ html()->label(trans('validation.attributes.frontend.new_password_confirmation'), 'password_confirmation')->class('col-md-4 control-label') }}-->
                            <div class="col-md-12">
                                {{ html()->password('password_confirmation')->class('form-control')->attribute('required', 'required')->attribute('placeholder', trans('validation.attributes.frontend.new_password_confirmation')) }}
                            </div>
                        </div>
                        <div class="form-group text-center btns-green-blue">
                            <div class="col-md-12">
                                {{ html()->submit(trans('labels.general.buttons.update'))->class('log-in-button')->id('change-password') }}
                            </div>
                        </div>
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

$(document).ready(function () {
    $('form').validate({
        rules: {
            password: {
                required: true,
                minlength: 6
            },
            password_confirmation: {
                required: true,
                minlength: 6,
                equalTo: "#password"
            }
        },
        messages: {
            old_password: {
                required: "Please fill in your old password"
            },
            password: {
                required: "Please fill in the password",
                minlength: "Password must be atleast 6 characters long"
            },
            password_confirmation: {
                required: "Please fill password again",
                minlength: "Password must be atleast 6 characters long",
                equalTo: "Please enter the same password as above"
            }
        }
    });
});

</script>
@endsection