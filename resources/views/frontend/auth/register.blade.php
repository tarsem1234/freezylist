@extends('frontend.layouts.app')
@section ('title', ('Register'))

@section('after-styles')
<link type="text/css" rel="stylesheet" href="{{ asset(mix('css/register.css')) }}" media="all">
@endsection 

@section('content')

<div class="register-page">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="register-banner">
                        <div class="text">Register</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <div class="panel panel-default">
                <div class="panel-heading"><span class="black-text">User</span> Sign-Up</div>
                <div class="">
                    {{ html()->form('POST', route('frontend.auth.register.post'))->class('form-horizontal')->open() }}
                    <div class="form-group">                       
                        <div class="col-md-12">
                            {{ html()->text('first_name')->class('form-control')->maxlength('191')->required()->autofocus('autofocus')->placeholder(trans('validation.attributes.frontend.first_name')) }}
                        </div><!--col-md-12-->
                    </div><!--form-group-->

                    <div class="form-group">                    
                        <div class="col-md-12">
                            {{ html()->text('last_name')->class('form-control')->maxlength('191')->required()->placeholder(trans('validation.attributes.frontend.last_name')) }}
                        </div><!--col-md-12-->
                    </div><!--form-group-->

                    <div class="form-group">                     
                        <div class="col-md-12">
                            {{ html()->email('email')->class('form-control')->attribute('maxlength', '191')->attribute('required', 'required')->attribute('placeholder', trans('validation.attributes.frontend.email')) }}
                        </div><!--col-md-12-->
                    </div><!--form-group-->

                    <div class="form-group">                       
                        <div class="col-md-12">
                            {{ html()->password('password')->class('form-control')->attribute('required', 'required')->attribute('placeholder', trans('validation.attributes.frontend.password')) }}
                        </div><!--col-md-12-->
                    </div><!--form-group-->

                    <div class="form-group">                       
                        <div class="col-md-12">
                            {{ html()->password('password_confirmation')->class('form-control')->attribute('required', 'required')->attribute('placeholder', trans('validation.attributes.frontend.password_confirmation')) }}
                        </div><!--col-md-12-->
                    </div><!--form-group-->

                    <div class="form-group">                       
                        <div class="col-md-12">
                            <input class="form-control" type="text" placeholder="State" name="name" required>
                        </div><!--col-md-12-->
                    </div><!--form-group-->

                    <div class="form-group">                       
                        <div class="col-md-12">
                            <input class="form-control" type="text" placeholder="contry" name="name" required>
                        </div><!--col-md-12-->
                    </div><!--form-group-->

                    <div class="form-group">                       
                        <div class="col-md-12">
                            <input class="form-control" type="text" placeholder="city" name="name" required>
                        </div><!--col-md-12-->
                    </div><!--form-group-->

                    <div class="form-group">                       
                        <div class="col-md-12">
                            <input class="form-control" type="text" placeholder="zip code" name="name" required>
                        </div><!--col-md-12-->
                    </div><!--form-group-->

                    <div class="form-group">                       
                        <div class="col-md-12">
                            <input class="form-control" type="text" placeholder="address" name="name" required>
                        </div><!--col-md-12-->
                    </div><!--form-group-->

                    <div class="form-group">                       
                        <div class="col-md-12">
                            <input class="form-control" type="text" placeholder="phone number" name="name" required>
                        </div><!--col-md-12-->
                    </div><!--form-group-->

                    <div class="form-group">                       
                        
                            <div class="checkbox">
                                <h4>Interests</h4>                               
                                <input class="styled-checkbox" id="styled-checkbox-1" type="checkbox" value="value4">
                                <label for="styled-checkbox-1">Buying</label>
                                <input class="styled-checkbox" id="styled-checkbox-2" type="checkbox" value="value4">
                                <label for="styled-checkbox-2">Selling</label>
                                <input class="styled-checkbox" id="styled-checkbox-3" type="checkbox" value="value4">
                                <label for="styled-checkbox-3">Renting</label>
                                <input class="styled-checkbox" id="styled-checkbox-4" type="checkbox" value="value4">
                                <label for="styled-checkbox-4">Leasing</label>
                                <input class="styled-checkbox" id="styled-checkbox-5" type="checkbox" value="value4">
                                <label for="styled-checkbox-5">Timeshare rentals</label>
                            </div>                                                       
                       
                    </div><!--form-group-->

                    <div class="form-group">                       
                        <div class="col-md-12">
                            <h4>Share Profile </h4>                           
                                <input type="radio" id="test1" name="radio-group" checked>
                                <label for="test1">yes</label>                                                     
                                <input type="radio" id="test2" name="radio-group">
                                <label for="test2">no</label>                          
                        </div><!--col-md-12-->
                    </div>

                    <div class="form-group">                       
                        <div class="col-md-12">
                            <h4>Loan Status </h4>
                                <input type="radio" id="test3" name="radio-group" checked>
                                <label for="test3">Not approved</label>
                                <input type="radio" id="test4" name="radio-group">
                                <label for="test4">Pre-approved</label>
                                <input type="radio" id="test5" name="radio-group">
                                <label for="test5">Pre-qualified</label>
                            <p>(Please enter your full name as it appears on your drivers license - will be used in Official Contracts)</p>
                        </div><!--col-md-12-->
                    </div>

                    <div class="form-group">                       
                        <div class="col-md-4">
                            <input class="form-control" type="text" placeholder="first name" name="name" required>
                        </div><!--col-md-4-->
                        <div class="col-md-4">
                            <input class="form-control" type="text" placeholder="middle name" name="name" required>
                        </div><!--col-md-4-->
                        <div class="col-md-4">
                            <input class="form-control" type="text" placeholder="last name" name="name" required>
                        </div><!--col-md-4-->
                    </div><!--form-group-->

                    <div class="form-group">                       
                        <div class="col-md-12">
                            <h4>Electronic Signature</h4>                           
                            <input class="form-control" type="text" placeholder="" name="name" required>
                            <p>(Generated automatically)</p>
                        </div><!--col-md-12-->                      
                    </div><!--form-group-->
                    
                    @if (config('access.captcha.registration'))
                    <div class="form-group">
                        <div class="col-md-12">
                            {{ html()->captcha() }}
                            {{ html()->hidden('captcha_status', 'true') }}
                        </div><!--col-md-12-->
                    </div><!--form-group-->
                    @endif

                    <div class="form-group">
                        <div class="col-md-12">
                            <label class="space">
                                <input type="checkbox" checked="checked" name="remember" style="margin-bottom:15px"> <span class="text-bottom">“I have read and  agree with the <span class="blue-text">FREEZYLIST Term of Service”</span></span>
                            </label>
                        </div><!--col-md-12-->
                    </div><!--form-group-->

                    <div class="form-group">
                        <div class="col-md-12">
                            {{ html()->submit('create account')->class('btn btn-primary') }}
                        </div><!--col-md-12-->
                    </div><!--form-group-->

                    {{ html()->form()->close() }}
                </div><!-- panel body -->
            </div><!-- panel -->
        </div><!-- col-md-12 -->
    </div><!-- row -->
</div><!-- register-page-->
@endsection

@section('after-scripts')
@if (config('access.captcha.registration'))
{!! Captcha::script() !!}
@endif
@endsection