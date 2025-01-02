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
                            {{ html()->form('POST', route('frontend.auth.password.email.post'))->class('form-horizontal')->open() }}
                            <div class="form-group">
                                <div class="col-md-12">
                                    <h4>E-MAIL ADDRESS</h4>
                                    {{ html()->email('email')->class('form-control')->attribute('maxlength', '191')->attribute('required', 'required')->attribute('autofocus', 'autofocus')->attribute('placeholder', trans('validation.attributes.frontend.email')) }}
                                    @if(count($errors->get('email')) > 0)
                                    <span class="text text-danger">{{implode('<br>', $errors->get('email'))}}</span>
                                    @endif
                                </div><!--col-md-6-->
                            </div><!--form-group-->
                            <div class="form-group">
                                <div class="col-md-12 mr-top">
                                    {{ html()->submit(trans('labels.frontend.passwords.send_password_reset_link_button'))->class('btn btn-primary log-in-button') }}
                                </div><!--col-md-6-->
                            </div><!--form-group-->
                            {{ html()->form()->close() }}
                        </div><!-- panel body -->
                    </div><!-- panel -->
                </div><!-- col-md-8 -->
            </div><!-- row -->
        </div>
    </div> <!-- wrapper -->
</div> <!-- login -->
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
                }
            }
        });
    });
</script>
@endsection