@extends('frontend.layouts.app')
@section('title', app_name() . ' | Business User')
@section('after-styles')
<link type="text/css" rel="stylesheet" href="{{ asset(mix('css/profile-edit.css')) }}" media="all">
@endsection 
@section('content')
@if (count($errors->get('user_type')) > 0)
<div class="alert alert-danger">
    {{implode('<br>', $errors->get('user_type'))}}
</div>
@endif
<div class="register-page contact-page user login-page">   
    <!--<div class="content-wrapper">
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="login-banner">
                        <div class="text">Business</div>
                    </div>
                </div>
            </div>
        </div>
    </div>-->
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <!--<div class="panel panel-default">
                <div class="panel-heading">Business User</div>-->
            <div class="panel panel-default1">
                <div class="panel-heading"><span class="black-text">Register Your Business</span></div>    
                <div class="">
                    {{ html()->form('POST', route('frontend.userStore'))->class('form-horizontal')->open() }}
                    {{ html()->hidden('user_type', config('constant.user_type.2')) }}
                    <div class="form-group">
                        <div class="col-md-12">
                            {{ html()->text('company_name')->class('form-control')->autofocus('autofocus')->placeholder('Company Name')->required() }}
                            @if(count($errors->get('company_name')) > 0)
                            <span class="text text-danger">{{implode('<br>', $errors->get('company_name'))}}</span>
                            @endif
                        </div><!--col-md-6-->
                    </div><!--form-group-->
                    <div class="form-group">
                        <div class="col-md-12">

                            <?php if (isset($business)) { ?>
                                <input type="hidden" name="savedTime" value="{{ $business->created_at }}">
                                <input type="hidden" name="code" value="{{ $business->confirmation_code }}">
                                {{ html()->email('email', $business->email)->class('form-control')->attribute('readonly', )->attribute('placeholder', trans('validation.attributes.frontend.email'))->attribute('required', true) }}
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
                            {{ html()->password('password')->class('form-control')->id('business_password')->attribute('placeholder', 'Password')->attribute('required', true) }}
                            @if(count($errors->get('password')) > 0)
                            <span class="text text-danger">{{implode('<br>', $errors->get('password'))}}</span>
                            @endif
                        </div><!--col-md-6-->
                    </div><!--form-group-->
                    <div class="form-group">
                        <div class="col-md-12">
                            {{ html()->password('password_confirmation')->class('form-control')->attribute('placeholder', 'Verify Password')->attribute('required', true) }}
                            @if(count($errors->get('password_confirmation')) > 0)
                            <span class="text text-danger">{{implode('<br>', $errors->get('password_confirmation'))}}</span>
                            @endif
                        </div><!--col-md-6-->
                    </div><!--form-group-->
                     <div class="form-group">
                        <div class="col-md-12">
                            {{ html()->text('', '')->id('postal_code')->class('form-control')->placeholder('Select Address') }}
                          
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
                                <input type="hidden" id="custom_county" value="{{ !empty($user->county) ? $user->county : (old('county') ?? '') }}">
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
                    <div class="form-group">
                        <div class="col-md-12">
                            {{ html()->textarea('company_address')->id('address')->class('form-control text-height')->placeholder('Company Address')->rows(2)->required() }}
                            @if(count($errors->get('company_address')) > 0)
                            <span class="text text-danger">{{implode('<br>', $errors->get('company_address'))}}</span>
                            @endif
                        </div><!--col-md-6--> 
                    </div><!--form-group-->
                    <div class="form-group">
                        <div class="col-md-12">
                            {{ html()->number('phone_no', '')->class('form-control')->attribute('placeholder', 'Phone No')->attribute('required', true) }}
                            @if(count($errors->get('phone_no')) > 0)
                            <span class="text text-danger">{{implode('<br>', $errors->get('phone_no'))}}</span>
                            @endif
                        </div><!--col-md-6-->
                    </div><!--form-group-->
                    <div class="form-group">
                        <div class="col-md-12">
                            {{ html()->text('company_website')->class('form-control website-url')->placeholder('COMPANY WEBSITE e.g: www.freezylist.com')->required() }}
                            @if(count($errors->get('company_website')) > 0)
                            <span class="text text-danger">{{implode('<br>', $errors->get('company_website'))}}</span>
                            @endif
                        </div><!--col-md-6-->
                    </div><!--form-group-->
                    <div class="form-group industry-selection">
                        <div class="col-md-12">
                            <div class="select formField">
                                <select class="form-control industry-select" data-rule-required="true" name="industry" id="industry" aria-required="true">
                                    <option value="">Select Industry</option>
                                    @foreach($industries as $industry)
                                    <option value="{{ $industry->id }}">{{ $industry->industry }}</option>
                                    @endforeach
                                </select>
                                @if(count($errors->get('industry')) > 0)
                                <span class="text text-danger">{{implode('<br>', $errors->get('industry'))}}</span>
                                @endif
                            </div>    
                            <div class="select__arrow"></div>
                        </div><!--col-md-6-->
                    </div><!--form-group-->
                    <div class="form-group">
                        <div class="col-md-12">
                            <div class="select formField">
                                <select class="form-control" name="services[]" multiple="multiple" id="services" required="true" style="padding:8px">
                                    <option value="">Select Service</option>
                                </select>
                                @if(count($errors->get('services')) > 0)
                                <span class="text text-danger">{{implode('<br>', $errors->get('services'))}}</span>
                                @endif
                            </div>
                            <div class="select__arrow"></div>
                        </div><!--col-md-6-->
                    </div><!--col-md-6-->
                    <div class="form-group">
                        <div class="col-md-12">
                            <div class="select formField">
                                <select class="form-control miles-select" data-rule-required="true" name="area_of_service" id="area-of-service" aria-required="true">
                                    <option value="">Miles of zip</option>
                                    @foreach(config('constant.area_of_service') as $area)
                                    <option value="{{ $area }}">{{ $area }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="select__arrow"></div>
                        </div><!--col-md-6-->
                    </div><!--form-group-->
                    <input type="hidden" name="latitude" id="latitude" value="">
                    <input type="hidden" name="longitude" id="longitude" value="">
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
                            <input type="submit" class="btn btn-default button btn-blue  mr-top" name="submit" id="inputbutton" value="Sign Up">
                        </div>
                    </div>
                    {{ html()->form()->close() }}
                </div><!-- panel body -->
            </div><!-- panel -->
        </div><!-- col-md-12 -->
    </div>
</div><!-- row -->
@endsection
<script type="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=<?= config('settings.google_map_api_key') ?>&libraries=places" type="text/javascript"></script>
@section('after-scripts')
<script>
//var getIndustryService = "{{ route('frontend.businessCreate') }}";
$(document).ready(function () {

    $("#industry").change(function (e) {
        e.preventDefault();
        var $this = $(this);
        $.ajax({
            type: "get",
            url: "{{ route('frontend.businessServices') }}",
            data: {
                industry_id: parseInt($this.val()),
            },
            success: function (response) {
                $('#services').children('option').remove();
                $.each(response.services, function (i, item) {
                    $('#services').append($('<option>', {
                        value: i,
                        text: item
                    }));
                });
                $('#services').select2({
                    placeholder: "Select Services"
                });
            },
            error: function (error) {
            }
        });
    });

    $('select').select2();

    $('.industry-select').select2({
        placeholder: "Select Industry"
    });

    $('.miles-select').select2({
        placeholder: "Area of Service"
    });
    $('#county').select2({
        placeholder: "Select County",
    });
    $('#services').select2({
        placeholder: "Select Services",
    });

    // jquery validation
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
                equalTo: "#business_password"
            },
            phone_no: {
                minlength: 10,
                maxlength: 10
            },
            "services[]": "required",
        },
        messages: {
            company_name: "Please enter company name",
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
            zip_code: "Please enter postal code",
            company_address: "Please enter your company address",
            phone_no: {
                required: "Please provide your phone number",
                minlength: "Please enter valid phone number",
                maxlength: "Please enter valid phone number"
            },
            company_website: {
                required: "Please enter company website",
                url: "Please enter valid address e.g: www.freezylist.com"
            },
            industry: "Please select industry",
            "services[]": "Please select Services",
            area_of_service: "Please select miles"
        },
        errorPlacement: function (error, element) {
            if (element.is("select.form-control"))
            {
                error.appendTo(element.parents('.formField'));
            } else
            { // This is the default behavior 
                error.insertAfter(element);
            }
        }

    });

    $('#industry').change(function () {
        $('#industry-error').hide();
    });
    $('#area-of-service').change(function () {
        $('#area-of-service-error').hide();
    });

    $('form').on('submit', function (e) {
        if (grecaptcha.getResponse() == "") {
            e.preventDefault();
            $('#captchaError').html('<label class="error">Please prove you are not a Robot</label>');
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

var recaptchaCallback = function () {
//    console.log('recaptcha is ready'); // showing
    grecaptcha.render("recaptcha", {
        sitekey: '6Ldn9GgUAAAAABCm-PeXaauq8WqXpvaH0RRRkJw_',
        callback: function () {
//            console.log('recaptcha callback');
        }
    });
};
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
                    document.getElementById('address').value = street_address +" "+ route_address;
                }
                else if(street_address!=''){
                    document.getElementById('address').value = street_address;
                }
                else if(route_address!=''){
                    document.getElementById('address').value = route_address;
                }
            });
        });

        // if county empty then remove class disable code
        if ($("#county").val() === "") {
            $("#county").removeClass("not-allow");
        } else if ($("#county").val() !== "") {
            $("#county").addClass("not-allow");
        }
        
            if($('#zip_code').val()===""){
                  $(".custom_zipcode").show();
                  $('.old_zipcode').hide();
            }
            else{
                $(".custom_zipcode").hide();
                $('.old_zipcode').show();
            }
            
             
            if($('#city').val()===""){
                  $(".custom_city").show();
                  $('.old_city').hide();
            }
            else{
                $(".custom_city").hide();
                $('.old_city').show();
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
                $('#county').prop('disabled',false);
                $('#county').children('option').remove();
                $('#county').append($('<option value>Select County</option>'));
                $.each(response.counties, function (i, item) {
                    $('#county').append($('<option>', {
                        value: i,
                        text : i
                    }));
                });
            }
        });
        if($('#zip_code').val()===""){
           var getZipcode = $('#custom_zipcode').attr('data-get_counties');
            $.ajax({
                type: "get",
                url: getZipcode,
                data: {
                    state: stateName,
                },
                success: function success(response) {
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
        }
          if($('#city').val()===""){
                var getCity = $('#custom_city').attr('data-get_counties');
            $.ajax({
                type: "get",
                url: getCity,
                data: {
                    state: stateName,
                },
                success: function success(response) {
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