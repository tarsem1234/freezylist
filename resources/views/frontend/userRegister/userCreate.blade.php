@extends('frontend.layouts.app')
@section('title', app_name() . ' | User')
@section('after-styles')
<link type="text/css" rel="stylesheet" href="{{ asset(mix('css/profile-edit.css')) }}" media="all">
<link type="text/css" rel="stylesheet" href="{{ asset(mix('css/login.css')) }}" media="all">
@endsection 
@section('content')
<div class="login-page">    
    <!--<div class="content-wrapper">
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="login-banner">
                        <div class="text">User</div>
                    </div>
                </div>
            </div>
        </div>
    </div>-->
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <!--<div class="panel panel-default">
                <div class="panel-heading">User</div>-->
                <div class="panel panel-default1">
                <div class="panel-heading"><span class="black-text">Create Your Account</span></div>
                <div class="">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    {{ html()->form('POST', route('frontend.userStore'))->class('form-horizontal')->id('userSignUp')->open() }}
                    {{ html()->hidden('user_type', config('constant.user_type.3')) }}
                    <?php if (isset($user)) { ?>
                        <input type="hidden" name="savedTime" value="{{ !empty($user->created_at)?$user->created_at:'' }}">
                        <input type="hidden" name="code" value="{{ !empty($user->confirmation_code)?$user->confirmation_code:'' }}">
                    <?php } ?>
                    <div class="form-group">
                        <div class="col-md-12">
                            <?php if (!empty($user->name)) { ?>
                                {{ html()->text('name', !empty($user->name) ? $user->name : '')->class('form-control')->autofocus('autofocus')->required()->placeholder(trans('validation.attributes.frontend.name')) }}
                            <?php } else { ?>
                                {{ html()->text('name')->class('form-control')->autofocus('autofocus')->required()->placeholder(trans('validation.attributes.frontend.name')) }}
                            <?php } ?>
                            @if(count($errors->get('name')) > 0)
                            <span class="text text-danger">{{implode('<br>', $errors->get('name'))}}</span>
                            @endif
                        </div><!--col-md-6-->
                    </div><!--form-group-->
                    <div class="form-group">
                        <div class="col-md-12">
                            <?php if (!empty($user->email)) { ?>
                                {{ html()->email('email', $user->email)->class('form-control')->attribute('readonly', )->attribute('placeholder', trans('validation.attributes.frontend.email'))->attribute('required', true) }}
                            <?php } else { ?>
                                {{ html()->email('email')->class('form-control')->attribute('placeholder', trans('validation.attributes.frontend.email'))->attribute('required', true) }}
                            <?php } ?>
                            @if(count($errors->get('email')) > 0)
                            <span class="text text-danger">{{implode('<br>', $errors->get('email'))}}</span>
                            @endif
                        </div><!--col-md-6-->
                    </div><!--form-group-->               
                    <div class="form-group">
                        <div class="col-md-12">
                            {{ html()->password('password')->class('form-control')->id('user_password')->attribute('autofocus', 'autofocus')->attribute('placeholder', 'Password')->attribute('required', true) }}
                            @if(count($errors->get('password')) > 0)
                            <span class="text text-danger">{{implode('<br>', $errors->get('password'))}}</span>
                            @endif
                        </div><!--col-md-6-->
                    </div><!--form-group-->               
                    <div class="form-group">
                        <div class="col-md-12">
                            {{ html()->password('password_confirmation')->class('form-control')->attribute('autofocus', 'autofocus')->attribute('placeholder', 'Verify Password')->attribute('required', true) }}
                            @if(count($errors->get('password_confirmation')) > 0)
                            <span class="text text-danger">{{implode('<br>', $errors->get('password_confirmation'))}}</span>
                            @endif
                        </div><!--col-md-6-->
                    </div><!--form-group-->  
                    <div class="form-group">
                        <div class="col-md-12">
                            {{ html()->text('', '')->id('postal_code')->class('form-control')->placeholder('Search Address') }}

                        </div><!--col-md-6-->
                    </div>
                    <div class="form-group old_zipcode">
                        <div class="col-md-12">
                            {{ html()->text('zip_code', !empty($user->zip_code) ? $user->zip_code : '')->id('zip_code')->class('form-control')->placeholder('Zip Code')->required()->isReadonly() }}
                            @if(count($errors->get('zip_code')) > 0)
                            <span class="text text-danger">{{implode('<br>', $errors->get('zip_code'))}}</span>
                            @endif
                        </div><!--col-md-6-->
                    </div><!--form-group-->
                    <div class="form-group custom_zipcode" style="display: none">
                        <div class="col-md-12">
                            <select id="custom_zipcode" class="form-control" name="zip_code" data-get_counties="{{route('frontend.getZipCodes')}}" required="true" disabled="">
                                @if(!empty(old('zip_code')))
                                <option value="{{old('zip_code')}}"></option>
                                @else
                                <option value="">Select zip</option>
                                @endif
                            </select>

                            @if(count($errors->get('zip_code')) > 0)
                            <span class="text text-danger">{{implode('<br>', $errors->get('zip_code'))}}</span>
                            @endif
                        </div><!--col-md-6-->
                    </div>
                    <div class="form-group">
                        <div class="col-md-12">
                            @php 
                            if(!empty($state))
                            $state = $state;
                            elseif(!empty(old('state')))
                            $state = old('state');
                            else
                            $state = ''; 
                            @endphp
                            {{ html()->text('state_disabled', $state)->id('state_disabled')->class('form-control not-allow')->placeholder('State')->required()->disabled() }}
                            <input type="hidden" name="state" value="{{$state}}" id="state">
                            @if(count($errors->get('state')) > 0)
                            <span class="text text-danger">{{implode('<br>', $errors->get('state'))}}</span>
                            @endif
                        </div><!--col-md-6-->
                    </div><!--form-group-->
                    <div class="form-group">
                        <div class="col-md-12">
                            <div class="select formField">
                                <input type="hidden" id="custom_county" value="{{!empty($user->county)??$user->county??old('county')??old('county')??''}}">
                                <select id="county" class="form-control" name="county" data-get_counties="{{route('frontend.getCounties')}}" required="true">

                                    @if(!empty(old('county')))
                                    <option value="{{old('county')}}"></option>
                                    @elseif(!empty($user->county))
                                    <option value="{{$user->county}}">{{$user->county}}</option>
                                    @else
                                    <option value="">Select County</option>
                                    @endif
                                </select>

                                @if(count($errors->get('county')) > 0)
                                <span class="text text-danger">{{implode('<br>', $errors->get('county'))}}</span>
                                @endif
                            </div>
                        </div><!--col-md-6-->
                    </div><!--form-group-->
                    @php 
                    if(!empty($user->city))
                    $city = $user->city;
                    elseif(!empty(old('city')))
                    $city = old('city');
                    else
                    $city = ''; 
                    @endphp
                    <div class="form-group old_city">
                        <div class="col-md-12">
                            {{ html()->text('city_disabled', $city)->id('city_disabled')->class('form-control not-allow')->placeholder('City')->required()->disabled() }}
                            <input type="hidden" name="city" id="city" value="{{$city}}">
                            @if(count($errors->get('city')) > 0)
                            <span class="text text-danger">{{implode('<br>', $errors->get('city'))}}</span>
                            @endif
                        </div><!--col-md-6-->
                    </div>
                    <div class="form-group custom_city" style="display: none">
                        <div class="col-md-12">
                            <div class="select formField">
                                <select id="custom_city" class="form-control" name="city" data-get_counties="{{route('frontend.getCities')}}" required="true" disabled="">
                                    @if(!empty(old('city')))
                                    <option value="{{old('city')}}"></option>
                                    @else
                                    <option value="" >Select City</option>
                                    @endif
                                </select>

                                @if(count($errors->get('city')) > 0)
                                <span class="text text-danger">{{implode('<br>', $errors->get('city'))}}</span>
                                @endif
                            </div>
                        </div><!--col-md-6-->
                    </div>
                    <!--form-group-->
                    <div class="form-group">
                        <div class="col-md-12">
                            {{ html()->textarea('address', !empty($user->user_profile->address) ? $user->user_profile->address : '')->id('formatted_address')->class('form-control text-height')->rows('2')->placeholder('Address')->required() }}
                            @if(count($errors->get('address')) > 0)
                            <span class="text text-danger">{{implode('<br>', $errors->get('address'))}}</span>
                            @endif
                        </div><!--col-md-6-->
                    </div><!--form-group-->
                    <div class="form-group">
                        <div class="col-md-12">
                            {{ html()->number('phone_no', !empty($user->phone_no) ? $user->phone_no : '')->class('form-control')->attribute('placeholder', 'Phone No')->attribute('required', true) }}
                            @if(count($errors->get('phone_no')) > 0)
                            <span class="text text-danger">{{implode('<br>', $errors->get('phone_no'))}}</span>
                            @endif
                        </div><!--col-md-6-->
                    </div><!--form-group-->
                    <div class="form-group">
                        <div class="col-md-12">
                            <div class="checkbox"> 
                                <h4>Interests</h4>
                                @foreach(config('constant.interests') as $key=>$interest)
                                @php 
                                $checked = (!empty(old('interest')) && in_array($interest,old('interest'))) ? 'checked':'';
                                @endphp
                                <input class="styled-checkbox" name="interest[]" id="styled-checkbox{{$key+1}}" {{$checked}} type="checkbox" value="{{$interest}}" >
                                <label for="styled-checkbox{{$key+1}}">{{$interest}}</label>
                                @endforeach
                                
                            </div>
                        </div><!--col-md-12-->
                    </div><!--form-group-->
                    <div class="form-group">
                        <div class="col-md-12">
                            <h4>Share Profile </h4>
                            @foreach(config('constant.share_profile') as $key=>$share)
                            @php 
                            $checked = (!empty(old('share_profile')) && $share==old('share_profile')) ? 'checked':'';
                            @endphp
                            <input type="radio" id="share{{$key+1}}" name="share_profile" value="{{$share}}" {{$checked}}>
                            <label for="share{{$key+1}}">{{$share}}</label>
                            @endforeach
                        </div><!--col-md-12-->
                    </div>
                    <div class="form-group">
                        <div class="col-md-12">
                            <h4>Loan Status </h4>
                            @foreach(config('constant.loan_status') as $key=>$status)
                            @php 
                            $checked = (!empty(old('loan_status')) && $status==old('loan_status')) ? 'checked':'';
                            @endphp
                            <input type="radio" id="status{{$key+1}}" name="loan_status" value="{{$status}}" {{$checked}}>
                            <label for="status{{$key+1}}">{{$status}}</label>
                            @endforeach
                        </div><!--col-md-12-->
                    </div>
                    <div class="form-group">
                        <div class="col-md-12">
                            <p style="padding-top: 0px;">(Please enter your full name as it appears on your drivers license - will be used in Official Contracts)</p                                                                                                                                      >
                        </div>
                    </div>
                    <div class="form-group">
                        <div class=""> 
                            <div class="col-sm-12 col-xs-12">
                                <h4 class="">Full (Legal) Name:</h4>
                            </div>
                            <div class="col-sm-4 col-xs-12">
                                @php 
                                if(!empty($user->user_profile->first_name))
                                {
                                $firstName = $user->user_profile->first_name;
                                }
                                else if(!empty(old('first_name'))){
                                $firstName = old('first_name'); 
                                }
                                else {
                                $firstName ='';
                                }
                                @endphp
                                <input type="text" class="form-control" id="fname" data-rule-required="true" data-msg-required="Enter first name" name="first_name" value="<?php echo $firstName; ?>"  aria-required="true" required="true" placeholder="First Name">
                                @if(count($errors->get('first_name')) > 0)
                                <span class="text text-danger">{{implode('<br>', $errors->get('first_name'))}}</span>
                                @endif
                            </div>
                            @php 
                            if(!empty($user->user_profile->middle_name))
                            {
                            $middle_name = $user->user_profile->middle_name;
                            }
                            else if(!empty(old('first_name'))){
                            $middle_name = old('middle_name'); 
                            }
                            else {
                            $middle_name ='';
                            }
                            @endphp
                            <div class="col-sm-4 col-xs-12">
                                <input type="text" class="form-control" id="mname" name="middle_name" value="<?php echo $middle_name ?>" placeholder="Middle Name" >
                                @if(count($errors->get('middle_name')) > 0)
                                <span class="text text-danger">{{implode('<br>', $errors->get('middle_name'))}}</span>
                                @endif
                            </div>
                            @php 
                            if(!empty($user->user_profile->last_name))
                            {
                            $last_name= $user->user_profile->last_name;
                            }
                            else if(!empty(old('last_name'))){
                            $last_name = old('last_name'); 
                            }
                            else {
                            $last_name ='';
                            }
                            @endphp
                            <div class="col-sm-4 col-xs-12">
                                <input type="text" class="form-control" id="lname" name="last_name" data-rule-required="true" data-msg-required="Enter last name" value="<?php echo $last_name ?>" aria-required="true" required="true" placeholder="Last Name">
                                @if(count($errors->get('last_name')) > 0)
                                <span class="text text-danger">{{implode('<br>', $errors->get('last_name'))}}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="latitude" id="latitude" value="">
                    <input type="hidden" name="longitude" id="longitude" value="">
                    <div class="form-group">
                        <h4 class="col-md-12">Signature:</h4>
                        <div class="col-md-12">
                            @php 
                            if(!empty($user->user_profile->electronic_signature))
                            {
                            $electronic_signature = $user->user_profile->electronic_signature;
                            }
                            else if(!empty(old('electronic_signature'))){
                            $electronic_signature = old('electronic_signature'); 
                            }
                            else {
                            $electronic_signature = '';
                            }
                            @endphp
                            <input type="text" class="form-control valid" name="electronic_signature" id="signature"  readonly="readonly" value="<?php echo $electronic_signature ?>" aria-invalid="false">
                        </div>
                    </div>
                    @if (config('access.captcha.registration'))
                    <div class="form-group user-captcha">
                        <div class="col-md-4 col-md-offset-0">
                            {!! NoCaptcha::display() !!}
                            {{ html()->hidden('captcha_status', 'true') }}
                        </div><!--col-md-6-->
                        <div id="captchaError"></div>
                    </div><!--form-group--> 
                    @endif
                    <div class="form-group btns-green-blue col-md-12">
                        <div class="text-center">
                            <input type="submit" class="btn btn-default button btn-blue  mr-top" name="submit" id="inputbutton" value="Create">
                        </div>
                    </div>
                    {{ html()->form()->close() }}
                </div><!-- panel body -->

            </div><!-- panel -->

        </div><!-- col-md-8 -->
    </div>
</div><!-- row -->
@endsection

@section('after-scripts')
<script src="https://maps.googleapis.com/maps/api/js?region=usa&key=<?= config('settings.google_map_api_key') ?>&libraries=places" type="text/javascript"></script>
<script>

$(document).ready(function () {

    //  numbers and special characters not allowed in first, middle and last name code
    function testInput(event) {
        var value = String.fromCharCode(event.which);
        var pattern = new RegExp(/[a-zåäö ]/i);
        return pattern.test(value);
    }
    $('#fname, #lname, #mname').bind('keypress', testInput);

    $(document).on('click', '.rc-anchor-center-container', function () {
        var attr = $(this).attr('aria-disabled');
        if (attr == false) {
        } else {

        }
    });
    $('#county').select2({
        placeholder: "Select County",
    });
    $('form').validate({
        rules: {
            email: {
                email: true
            },
            password: {
                minlength: 6
            },
            password_confirmation: {
                minlength: 6,
                equalTo: "#user_password"
            },
            share_profile: {
                required: true
            },
            loan_status: {
                required: true
            },
            phone_no: {
                minlength: 10,
                maxlength: 10
            }
        },
        messages: {
            name: "Please enter your name",
            email: "Please enter valid email address",
            city: "Please enter city",
            state: "Please enter state",
            county: "Please select county",
            password: {
                required: "Please provide a password",
                minlength: "Your password must be at least 6 characters long"
            },
            password_confirmation: {
                required: "Please provide a password",
                minlength: "Your password must be at least 6 characters long",
                equalTo: "Please enter the same password as above"
            },
            address: {
                required: "Please enter your address",
            },
            phone_no: {
                required: "Please enter your phone number",
                minlength: "Please enter valid phone number",
                maxlength: "Please enter valid phone number"
            },
            zip_code: "Please fill zip code",
            share_profile: {
                required: "Please select profile status"
            },
            loan_status: {
                required: "Please select loan status"
            }
        },
        errorPlacement: function (error, element)
        {
            if (element.is(":radio"))
            {
                error.appendTo(element.parents('.form-group'));
                error.css("padding-left", "15px");
            } else
            { // This is the default behavior 
                error.insertAfter(element);
            }
        }
    });


    $('form').on('submit', function (e) {
        if (grecaptcha.getResponse() == "") {
            e.preventDefault();
            $('#captchaError').html('<label class="error">Please prove you are not a Robot</label>');
        } else {
            $('#captchaError').hide();
        }
    });

    $('.g-recaptcha').on('keyup', function (e) {
        if (grecaptcha.getResponse() == "") {
            e.preventDefault();
            $('#captchaError').html('<label class="error">You have to check this</label>');
        } else {
            $('#captchaError').hide();
        }
    });

    $('#postal_code').keyup(function () {
        $('#county').val('').trigger('change');
        $('#state_disabled').val('');
        $('#city_disabled').val('');
        $('#state').val('');
        $('#city').val('');
        $('#county').find('option').not(':first').remove();
    });
    $('select').select2();
});

$(document).on("change", "#fname, #mname, #lname", function () {
    var fname = $("#fname").val();
    var mname = $("#mname").val();
    var lname = $("#lname").val();
    $('#signature').val(fname + ' ' + mname + ' ' + lname);
});

google.maps.event.addDomListener(window, 'load', function () {
    var place_loc = document.getElementById('postal_code');
    var options = {
        componentRestrictions: {'country': 'us'},
        'types': ['geocode']
    };
    var countyName = null;
    var stateName = null;
    var places = new google.maps.places.Autocomplete(place_loc, options, countyName, stateName);
    google.maps.event.addListener(places, 'place_changed', function () {
        $('#county').val('');
        $('#zip_code').val('');
        $('#state').val('');
        $('#city').val('');
        var street_address='';
        var route_address='';
        var place = places.getPlace();
        var address = place.formatted_address;
        var latitude = place.geometry.location.lat();
        var longitude = place.geometry.location.lng();
        $('#latitude').val(latitude);
        $('#longitude').val(longitude);
        var mesg = "Address: " + address;
//        $('#formatted_address').val(address);
        var address_components = place.address_components;
        $.each(address_components, function (index, component, e) {
            var types = component.types;
            $.each(types, function (index, type) {

                if (type == 'locality') {
                    $('#city').val(component.long_name);
                    $('#city_disabled').val(component.long_name);
                }
//                else if(type!== 'locality' && type == 'sublocality_level_1' || type == "administrative_area_level_3"){
//                    $('#city').val(component.long_name);
//                    $('#city_disabled').val(component.long_name); 
//                }
//                
                if (type == 'administrative_area_level_1') {
                    $('#state').val(component.long_name);
                    $('#state_disabled').val(component.long_name);
                    stateName = component.long_name;
                }
                if (type == 'postal_code') {
                    $('#zip_code').val(component.long_name);
                }
                if (type == 'administrative_area_level_2') {
                    countyName = component.long_name;
                }

                if (type == 'route') {
                    route_address+= component.long_name;
                }
                
                if (type == 'street_number') {
                    street_address+= component.long_name;
                }
                if(route_address!='' && street_address!=''){
                    document.getElementById('formatted_address').value = street_address +" "+ route_address;
                }
                else if(street_address!=''){
                    document.getElementById('formatted_address').value = street_address;
                }
                else if(route_address!=''){
                    document.getElementById('formatted_address').value = route_address;
                }
            });
        });

        // if county empty then remove class disable code
        if ($("#county").val() === "") {
            $("#county").removeClass("not-allow");
        } else if ($("#county").val() !== "") {
            $("#county").addClass("not-allow");
        }

        if ($('#zip_code').val() === "") {
            $(".custom_zipcode").show();
            $('.old_zipcode').hide();
            var getZipcode = $('#custom_zipcode').attr('data-get_counties');
            $.ajax({
                type: "get",
                url: getZipcode,
                data: {
                    state: stateName,
                },
                success: function success(response) {

                    $('#zip_code').prop('disabled', true);
                    $('#custom_zipcode').prop('disabled', false);
                    $('#custom_zipcode').children('option').remove();
                    $('#custom_zipcode').append($('<option value>Select Zipcode</option>'));
                    $.each(response.zipcodes, function (i, item) {
                        $('#custom_zipcode').append($('<option>', {
                            value: i,
                            text: i
                        }));
                    });
                }
            });
        } else {
            $(".custom_zipcode").hide();
            $('.old_zipcode').show();
        }


        if ($('#city').val() === "") {
            $(".custom_city").show();
            $('#custom_city').prop('disabled', false);
            $('.old_city').hide();
            $('#city').prop('disabled', true);
        } else {
            $(".custom_city").hide();
            $('#custom_city').prop('disabled', true);
            $('.old_city').show();
            $('#city').prop('disabled', false);
        }

        var getCounties = $('#county').attr('data-get_counties');
        $.ajax({
            type: "get",
            url: getCounties,
            data: {
                state: stateName,
                county: countyName
            },
            success: function (response) {
                $('#county').prop('disabled', false);
                $('#county').children('option').remove();
                $('#county').append($('<option value>Select County</option>'));
                $.each(response.counties, function (i, item) {
                    $('#county').append($('<option>', {
                        value: i,
                        text: i
                    }));
                });
            }
        });
//        if($('#zip_code').val()===""){
//           var getZipcode = $('#custom_zipcode').attr('data-get_counties');
//            $.ajax({
//                type: "get",
//                url: getZipcode,
//                data: {
//                    state: stateName,
//                },
//                success: function success(response) {
//                    
//                    $('#zip_code').prop('disabled', true);
//                    $('#custom_zipcode').prop('disabled', false);
//                    $('#custom_zipcode').children('option').remove();
//                    $('#custom_zipcode').append($('<option value>Select Zipcode</option>'));
//                    $.each(response.zipcodes, function (i, item) {
//                        $('#custom_zipcode').append($('<option>', {
//                            value: i,
//                            text: i
//                        }));
//                    });
//                }
//            });
//        }
        if ($('#city').val() === "") {
            var getCity = $('#custom_city').attr('data-get_counties');
            $.ajax({
                type: "get",
                url: getCity,
                data: {
                    state: stateName,
                },
                success: function success(response) {
                    $("#city").prop('disabled', true);
                    $('#custom_city').prop('disabled', false);
                    $('#custom_city').children('option').remove();
                    $('#custom_city').append($('<option value>Select City</option>'));
                    $.each(response.cities, function (i, item) {
                        $('#custom_city').append($('<option>', {
                            value: item,
                            text: i
                        }));
                    });
                }
            });
        }

    });
    $('select').select2();
    var custom_county = $('#custom_county').val();
    $('#select2-county-container').prop('title', custom_county);
    $('#select2-county-container').html(custom_county);
});
</script>
@if (config('access.captcha.registration'))
{!! NoCaptcha::renderJs('recaptcha_callback') !!}
<script>
    function recaptcha_callback() {
        $('#captchaError').hide();
    }
</script>
@endif
@endsection
