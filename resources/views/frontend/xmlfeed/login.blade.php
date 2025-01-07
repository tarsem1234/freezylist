@extends('frontend.layouts.app')
@section('title', app_name() . ' | Login')
@section('after-styles')
<link type="text/css" rel="stylesheet" href="{{ asset(mix('css/login.css')) }}" media="all">
@endsection 
@section('content')
<div class="login-page">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="login-banner">
                        <div class="text">XmlFeed Login</div>
                    </div>
                </div>
            </div>
        </div> 
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="panel panel-default1">
                    @if(isset($error))
                    <div class="alert alert-danger">
                        <strong>Failed:</strong> {{$error}}
                    </div>
                    @endif
                    <div class="panel-heading"><span class="black-text">Sign In</span></div>
                    <div class="">
                        {{ html()->form('POST', route('frontend.xmlfeed'))->class('form-horizontal')->open() }}
                        <div class="form-group">
                            <div class="col-md-12">
                                <span class="input-icon"><i class="fa fa-lock"></i></span>
                                {{ html()->text('username')->class('form-control icon-padding')->attribute('max-length', '191')->required()->placeholder(trans('validation.attributes.frontend.username')) }}
                            </div><!--col-md-12-->
                        </div><!--form-group-->
                        <div class="form-group">
                            <div class="col-md-12">
                                <span class="input-icon"><i class="fa fa-lock"></i></span>
                                {{ html()->password('password')->class('form-control icon-padding')->attribute('max-length', '191')->attribute('required', 'required')->attribute('placeholder', trans('validation.attributes.frontend.password')) }}
                            </div><!--col-md-12-->
                        </div><!--form-group-->
                        <div class="form-group">
                            <div class="col-md-12">
                                {{ html()->submit('Sign In')->class('log-in-button')->style('') }}
                            </div><!--col-md-12-->
                        </div><!--form-group-->
                        {{ html()->form()->close() }}
                    </div><!-- panel body -->
                </div><!-- panel -->
            </div> 
        </div> <!-- row -->
    </div><!-- container -->
</div><!-- login -->
@endsection