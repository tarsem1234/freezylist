@extends('frontend.layouts.app')
@if($user->user_profile)
@section ('title', ('User-Profile'))
@endif
<?php
$isUser = false;
$isBusiness = false;
if (in_array(config('constant.inverse_user_type.Business'), array_column($user->roles->toArray(), 'id'))) {
    $isBusiness = true;
} elseif (in_array(config('constant.inverse_user_type.User'), array_column($user->roles->toArray(), 'id'))) {
    $isUser = true;
}
?>
@if(in_array(config('constant.inverse_user_type.Business'), array_column($user->roles->toArray(), 'id')))
@section ('title', ('Business-Profile'))
@endif
@section('after-styles')
<link type="text/css" rel="stylesheet" href="{{ asset(mix('css/dashboard.css')) }}" media="all">
<link type="text/css" rel="stylesheet" href="{{ asset(mix('css/profile-edit.css')) }}" media="all">
<style>
    #editprofile{ font-weight: bold;color: #000; }

    /*        #profile_image {font-size: 11px;padding: 12px 0 0 41px;}
        @-moz-document url-prefix() {
            #profile_image {padding: 0 0 0 34px;}
        }*/
</style>
@endsection 
@section('content')
<div class="dashboard-page profile-view edit-rofile-page">
    <div class="container">
        <div class="row content">
            @include('frontend.includes.sidebar')
            <div class="col-md-9 col-sm-8">
                <div class="right-dashboard-div">
                    <div class="profile right-dashboard-div-text register-page">
                        <h4>Edit Profile</h4>
                        <div class="col-lg-12">
                            <div id="profile-pic-box">              <!-- Open Display Profile Image -->
                                <div class="row">    
                                    <div id="preview" class="change-pic"> 
                                        @if($user->image)
                                        <img src="{{ asset('storage/profile_images/'. Auth::id() . '/' . $user->image )}}" class='img-responsive'alt="profile photo" class="preview">
                                        @else
                                        <img src="{{ asset('storage/site-images/no_profile_image.png') }}" class='img-responsive' alt="profile photo" class="preview">
                                        @endif
                                        <div class="change-pic-button">
                                            @if($user->image)
                                            <button id="previewButton"  class="pic-button" type="submit" class="text-center"> <span><i class="fa fas fa-pencil" aria-hidden="true"></i></span></button><br>
                                            @else
                                            <button id="previewButton" class="pic-button"  type="submit" class="text-center" ><span><i class="fa fas fa-pencil" aria-hidden="true"></i></span></button><br>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div id="target" style="display:none;" class="row mr-top">
                                    <form id="imageform" method="post" files="true" enctype="multipart/form-data" action="{{ route('frontend.profile.image') }}">
                                        <div class="form-group upload-img-area">
                                            <div class="image-holder-col">
                                                <div class="new-img-area file-upload">
                                                    <input class="form-control more-option files" id="profile_image" type="file" name="profile_image" aria-required="true" />
                                                    <div class="file-upload__input">Browse</div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div> 
                                <div class="hidden" id="image-response"></div>
                            </div>
                            {{ html()->form('POST', route('frontend.profileUpdateSave', ))->class('form-horizontal update-form')->attribute('role', 'form')->open() }}
                            @if(isset($isUser) && $isUser)
                            {{ html()->hidden('user_type', config('constant.user_type.3')) }}
                            @endif
                            @if(isset($isBusiness) && $isBusiness)
                            {{ html()->hidden('user_type', config('constant.user_type.2')) }} 
                            @endif
                            <input type="hidden" name="latitude" id="latitude" value="">
                            <input type="hidden" name="longitude" id="longitude" value="">
                            @if(isset($isUser) && $isUser)
                            <div class="form-group">
                                <h4 class="control-label">Name</h4>
                                <div class="">
                                    <input type="text" class="form-control" data-rule-required="true" data-msg-required="Please enter the name" minlength="1" maxlength="50" id="name" name="name" value="{{ $user->user_profile->full_name??"" }}" aria-required="true">
                                </div>
                            </div>
                            @endif
                            @if($isBusiness)
                            <div class="form-group">
                                <h4 class="control-label">Company Name</h4>
                                <div class="">
                                    <input type="text" class="form-control" data-rule-required="true" id="bcompany" name="company_name" value="{{ $user->business_profile->company_name??"" }}" aria-required="true">
                                </div>
                            </div>
                            @endif
                            <div class="form-group">
                                <h4 class="control-label">Email</h4>
                                <div class="">
                                    <input type="text" class="form-control" id="email" data-rule-required="true" data-rule-email="true" data-msg-required="Please enter email" name="email" value="{{ $user->email??"" }}" readonly="readonly" aria-required="true">
                                </div>
                            </div>
                            <div class="form-group">
                                <h4 class="control-label">New Password (optional)</h4>
                                <div class="">
                                    <input type="password" class="form-control" id="npassword" data-rule-minlength="5" data-rule-maxlength="20" data-msg-required="Please enter password" name="password" value="">
                                </div>
                            </div>
                            <div class="form-group">
                                <h4 class="control-label">Confirm Password</h4>
                                <div class="">
                                    <input type="password" class="form-control" id="ncpassword" data-rule-minlength="5" data-rule-maxlength="20" data-rule-equalto="#npassword" data-msg-equalto="Please enter the same password as above" data-msg-required="Please confirm password" name="password_confirmation" value="">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="">
                                    {{ html()->text('', '')->id('postal_code')->class('form-control')->placeholder('Search Address') }}

                                </div><!--col-md-6-->
                            </div>
                            <div class="form-group old_zipcode">
                                <div class="">

                                    {{ html()->text('zip_code', $user->zip_code ?? "")->id('zip_code')->class('form-control')->placeholder('Zip Code')->required()->isReadonly() }}
                                    @if(count($errors->get('zip_code')) > 0)
                                    <span class="text text-danger">{{implode('<br>', $errors->get('zip_code'))}}</span>
                                    @endif
                                </div><!--col-md-6-->
                            </div><!--form-group-->
                            <div class="form-group custom_zipcode" style="display: none">
                                <div class="">

                                    <select id="custom_zipcode" class="form-control" name="zip_code" data-get_counties="{{route('frontend.getZipCodes')}}" required="true" disabled>
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
                                <div class="">
                                    {{ html()->text('state', $state->state ?? "")->id('state_disabled')->class('form-control not-allow')->placeholder('State')->required() }}
                                    @if(count($errors->get('state')) > 0)
                                    <span class="text text-danger">{{implode('<br>', $errors->get('state'))}}</span>
                                    @endif
                                </div><!--col-md-6-->
                            </div><!--form-group-->
                            <div class="form-group">
                                <div class="select-error">
                                    <select id="county" class="form-control not-allow" name="county" aria-required="true" data-get_counties="{{route('frontend.getCounties')}}" required>
                                        <option value="" >Select County</option>
                                        <?php if (isset($counties) && count($counties) > 0) {
                                            foreach ($counties as $count) {
                                                ?>
                                                <option value="{{$count->county}}" <?= (isset($user->county) and $user->county == $count->county) ? "selected='selected'" : "" ?>>{{$count->county}}</option>
    <?php }
} ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group old_city">
                                <div class="">
                                    {{ html()->text('city', $user->city ?? "")->id('city')->class('form-control not-allow')->placeholder('City')->required() }}
                                    @if(count($errors->get('city')) > 0)
                                    <span class="text text-danger">{{implode('<br>', $errors->get('city'))}}</span>
                                    @endif
                                </div><!--col-md-6-->
                            </div>
                            <div class="form-group custom_city" style="display: none">
                                <div class="">
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
                            @if(isset($isUser) && $isUser)
                            <div class="form-group">
                                <h4 class=" control-label">Address</h4>
                                <div class="">
                                    {{ html()->textarea('address', $user->user_profile->address ?? "")->id('formatted_address')->data('msg-required', "Please enter your address")->cols('10')->style('width: 100%')->class('form-control text-height')->attribute('aria-invalid', "false")->required() }}
                                </div>
                            </div>
                            @endif
                            @if(isset($isBusiness) && $isBusiness)
                            <div class="form-group">
                                <h4 class="control-label">Company Address</h4>
                                <div class="">
                                    <input type="text" class="form-control" data-rule-required="true" data-msg-required="Please enter your company address" id="company_address" name="company_address" value="{{ $user->business_profile->company_address??"" }}" aria-required="true">
                                    @if(count($errors->get('company_address')) > 0)
                                    <span class="text text-danger">{{implode('<br>', $errors->get('company_address'))}}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <h4  class="control-label">Company Website</h4>
                                <div class="">
                                    <input type="text" class="form-control" id="burl" required name="company_website" value="{{ $user->business_profile->company_website??"" }}">
                                    @if(count($errors->get('company_website')) > 0)
                                    <span class="text text-danger">{{implode('<br>', $errors->get('company_website'))}}</span>
                                    @endif
                                </div>
                            </div>
                            @endif
                            <div class="form-group">
                                <h4 class="control-label">Phone</h4>
                                <div class="">
                                    <input type="number" class="form-control" id="phone" required data-rule-required="true" data-rule-number="true" data-rule-minlength="10" data-rule-maxlength="10" data-msg-minlength="Keep typing, minimum 10 digits required" data-msg-required="Please enter phone number" name="phone_no" value="{{ $user->phone_no }}" aria-required="true">
                                    @if(count($errors->get('phone_no')) > 0)
                                    <span class="text text-danger">{{implode('<br>', $errors->get('phone_no'))}}</span>
                                    @endif
                                </div>
                            </div>
                            @if(isset($isBusiness) && $isBusiness)
                            <div class="form-group industry-selection">
                                <h4 class="control-label">Industry:</h4>
                                <div class="select formField">
                                    <select class="form-control industry-select" data-rule-required="true" name="industry" id="industry" aria-required="true" required>
                                        <option value="">Select Industry</option>
                                        @foreach($allIndustries as $key => $ind)
                                        <option value="{{ $ind->id }}" <?= (isset($user->business_profile) && $user->business_profile && $user->business_profile->industry_id == $ind->id) ? "selected='selected'" : ""; ?>>{{ $ind->industry }}</option>
                                        @endforeach
                                    </select>
                                    @if(count($errors->get('industry')) > 0)
                                    <span class="text text-danger">{{implode('<br>', $errors->get('industry'))}}</span>
                                    @endif
                                </div>
                                <div class="select__arrow"></div>
                            </div><!--form-group-->
                            <div class="form-group">
                                <h4 class="control-label">Services:</h4>
                                <div class="" id="businesssignup-checkbox">
                                    <div id="afererror">
                                        <div id="services-checkboxes" class="">
                                            <select class="form-control" name="services[]" multiple="multiple" id="services" required placeholder="Please select any option" style="padding:8px" required>
                                                <option value="">Select Service</option>
                                                @if(isset($industry) && !empty($industry))
                                                @foreach($industry->services as $service)
                                                <option value="{{ $service->id }}" <?php
                                                        if (count($user->subscribeServices) > 0) {
                                                            foreach ($user->subscribeServices as $subscribeService) {
                                                                if ($subscribeService->service_id == $service->id) {
                                                                    echo "selected='selected'";
                                                                }
                                                            }
                                                        }
                                                        ?> >{{ $service->service }}</option>
                                                @endforeach
                                                @endif
                                            </select>
                                            @if(count($errors->get('services')) > 0)
                                            <span class="text text-danger">{{implode('<br>', $errors->get('services'))}}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group select formField">
                                <h4 class="control-label">Area of service:</h4>
                                <select class="form-control valid" id="areaOfService" name="area_of_service" required data-msg-required="Please select Miles">
                                    <option value="">Select Area of service</option>
                                    @foreach(config('constant.area_of_service') as $key=>$area)
                                    <option value="{{ $key }}" <?= (isset($user->business_profile) && $user->business_profile && $user->business_profile->area_of_service == $key) ? "selected='selected'" : ""; ?>>{{ $area }}</option>
                                    @endforeach
                                </select>
                                @if(count($errors->get('area_of_service')) > 0)
                                <span class="text text-danger">{{implode('<br>', $errors->get('area_of_service'))}}</span>
                                @endif
                            </div>
                            @endif

                            @if(isset($isUser) && $isUser)
                            <div class="form-group">
                                <div class="">
                                    <div class="checkbox">
                                        <h4>Interests</h4>
                                        @foreach(config('constant.interests') as $key=>$interest)
                                        <input class="styled-checkbox" name="interest[]" id="styled-checkbox{{$key+1}}" type="checkbox"
                                               <?php
                                               if (isset($user->user_profile) && $user->user_profile) {
                                                   foreach ($user->user_profile->user_interests as $savedInterest) {
                                                       if ($key == $savedInterest->interest_type) {
                                                           ?> checked="checked" <?php
                                                       }
                                                   }
                                               }
                                               ?>value="{{$interest}}">
                                        <label for="styled-checkbox{{$key+1}}">{{$interest}}</label>
                                        @endforeach
                                    </div>
                                </div><!--col-md-12-->
                            </div><!--form-group-->
                            <div class="form-group">
                                <div class="">
                                    <h4>Share Profile </h4>
                                    @foreach(config('constant.share_profile') as $key=>$share)
                                    <input type="radio" id="share{{$key+1}}" name="share_profile" <?php
                                               if (isset($user->user_profile) && $user->user_profile && $key == $user->user_profile->share_profile) {
                                                   ?> checked="checked" <?php } ?> value="{{$share}}">
                                    <label for="share{{$key+1}}">{{$share}}</label>
                                    @endforeach
                                </div><!--col-md-12-->
                            </div>

                            <div class="form-group">
                                <div class="">
                                    <h4>Loan Status </h4>
                                    @foreach(config('constant.loan_status') as $key=>$status)
                                    <input type="radio" id="status{{$key+1}}" name="loan_status" <?php
                                               if (isset($user->user_profile) && $user->user_profile && $key == $user->user_profile->loan_status) {
                                                   ?> checked="checked" <?php } ?>   value="{{$status}}">
                                    <label for="status{{$key+1}}">{{$status}}</label>
                                    @endforeach
                                </div><!--col-md-12-->
                            </div>

                            <div class="form-group">
                                <div class="">
                                    <p class="no-padding">(Please enter your full name as it appears on your drivers license - will be used in Official Contracts)</p>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-12 col-xs-12">  
                                    <div class="row"> 
                                        <h4 for="inputEmail3" class="control-label"><span class="left-text">Full (Legal) Name:</span></h4>
                                    </div>
                                </div>
                                <div class="row"> 
                                    <div class="col-sm-4 col-xs-12">
                                        <input type="text" class="form-control" id="fname" maxlength="50" minlength="1" data-rule-required="true" data-msg-required="Enter first name" name="first_name" value="{{ $user->user_profile->first_name??"" }}"  aria-required="true">
                                    </div>
                                    <div class="col-sm-4 col-xs-12">
                                        <input type="text" class="form-control" id="mname"  maxlength="50" minlength="1" name="middle_name" data-msg-required="Enter middle name" value="{{ $user->user_profile->middle_name??"" }}" >
                                    </div>
                                    <div class="col-sm-4 col-xs-12">
                                        <input type="text" class="form-control" id="lname" name="last_name" data-rule-required="true"  maxlength="50" minlength="1" data-msg-required="Enter last name" value="{{ $user->user_profile->last_name??"" }}" aria-required="true">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <h4 for="inputEmail3" class="control-label">Signature:</h4>
                                <div class="">
                                    <input type="text" class="form-control valid" name="electronic_signature" id="signature" readonly="readonly" value="{{ $user->user_profile->electronic_signature??""}}" aria-invalid="false">
                                </div>
                            </div>
                            @endif
                            <div class="form-group btns-green-blue">
                                <div class="text-center">
                                    <input type="submit" class="button btn btn-green" name="submit" id="inputbutton" value="Update">
                                    <a href="{{ route('frontend.user.dashboard') }}" class="btn btn-blue">Cancel</a>
                                </div>
                            </div>
                            {{ html()->form()->close() }}                            
                        </div> 
                    </div>
                </div>
            </div<!--right-dashboard-div-->
        </div><!--col-9-->
    </div><!--row-->
</div><!--container-->
</div><!--dashboard-->

<script src="https://maps.googleapis.com/maps/api/js?v=3&sensor=true&key=<?= config('settings.google_map_api_key') ?>&libraries=places" type="text/javascript"></script>
@endsection
@section('after-scripts')
<script>

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
        company_website: {
            url: true
        },
        phone_no: {
            minlength: 10,
            maxlength: 10
        },
        "services[]": "required"
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
        address: "Please enter your address",
        company_address: "Please enter your company address",
        phone_no: {
            required: "Please provide your phone number",
            minlength: "Please enter valid phone number",
            maxlength: "Please enter valid phone number"
        },
        company_website: {
            required: "Please enter company website",
            url: "Please enter valid address e.g: http://xyz.com"
        },
        industry: "Please select industry",
        "services[]": "Please select Services",
        area_of_service: "Please select miles"
    },
    errorPlacement: function (error, element) {
        if (element.is(":radio"))
        {
            error.appendTo(element.parents('.rent-radio'));
        } else if (element.is("select.form-control"))
        {
            error.appendTo(element.parents('.select-error'));
        } else
        {
            error.insertAfter(element);
        }
    }
});
$(document).ready(function () {
    $('.update-form').validate();
    $('#previewButton').on('click', function () {
        $('#target').show();
    });

    // for detecting chrome browser of mac nd firefox on windows
    if (navigator.userAgent.indexOf('Mac OS X') != -1) {
        if (/chrome/.test(navigator.userAgent.toLowerCase())) {
            $('body').addClass('mac-chrome');
        }
    } else if (navigator.appVersion.indexOf("Win") != -1) {
        console.log('windows');
        if (navigator.userAgent.toLowerCase().indexOf('firefox') > -1) {
            $('body').addClass('win-mozilla');
        }
    } else {
        $("body").addClass("pc");
    }

    $('#profile_image').on('change', function (e) {
//        var image = $('#profile_image').val();
        if (!$('#profile_image').val()) {

        } else {
            e.preventDefault();
//            $("#preview").html('<i class="fa fa-spin fa-spinner fa-4x"></i>');
            var url = $("#imageform").attr('action');
            $("#image-response").removeClass().addClass('hidden');
            $.ajax({
                type: "POST",
                url: url,
                data: new FormData($('#imageform')[0]),
                processData: false,
                contentType: false,
                success: function (response) {
                    $('.alert-success').fadeIn('fast');
                    $("#preview").html("<img class='img-responsive' src='{{ asset('storage/profile_images')}}/" + "{{Auth::id()}}/" + response.imageName + "'/>"
                            + "<div class='change-pic-button'>\n\
                    <button id='previewButton' class='pic-button' type='submit'> \n\
                    <span><i class='fa fas fa-pencil' aria-hidden='true'></i></span></button><br></div>");
                    $("#profile_image", ".file-upload__input").css('display', 'none');
                    $("#image-response").text("Image updated successfully!!").addClass('alert alert-success').removeClass('hidden');
                    setTimeout(function () {
                        $('.alert-success').fadeOut('fast');
                    }, 4000);
                },
                error: function (error) {
                    $('.alert-danger').fadeIn('fast');
                    $("#image-response").text(error.responseJSON.profile_image.join("<br>")).addClass('alert alert-danger').removeClass('hidden');
                    setTimeout(function () {
                        $('.alert-danger').fadeOut('fast');
                    }, 4000);
                }
            });
        }
    });
    $('#signature').val($("#fname").val() + ' ' + $("#mname").val() + ' ' + $("#lname").val());

    $(document).on("change", "#fname, #mname, #lname", function () {
        var fname = $("#fname").val();
        var mname = $("#mname").val();
        var lname = $("#lname").val();
        $('#signature').val(fname + ' ' + mname + ' ' + lname);
    });

    $('#postal_code').keyup(function () {
        $('#county').val('').trigger('change');
        $('#state').val('');
        $('#city').val('');
        $('#county').find('option').not(':first').remove();
    });

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
    $("#postal_code").change(function () {
        $("#formatted_address").val('');
    });
    $('select').select2();
    $('#county').val("{{$user->county??''}}");
//    $('#areaOfService').val("{{ $user->business_profile->area_of_service??''}}");
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
                @if(isset($isBusiness) && $isBusiness)  
                if(route_address!='' && street_address!=''){
                    document.getElementById('company_address').value = street_address +" "+ route_address;
                }
                else if(street_address!=''){
                    document.getElementById('company_address').value = street_address;
                }
                else if(route_address!=''){
                    document.getElementById('company_address').value = route_address;
                }
                @endif
                @if(isset($isUser) && $isUser)
                if(route_address!='' && street_address!=''){
                    document.getElementById('formatted_address').value = street_address +" "+ route_address;
                }
                else if(street_address!=''){
                    document.getElementById('formatted_address').value = street_address;
                }
                else if(route_address!=''){
                    document.getElementById('formatted_address').value = route_address;
                }
                @endif
               
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
                            value: i,
                            text: i
                        }));
                    });
                }
            });
        }

    });
    $('select').select2();
//    var custom_county = $('#custom_county').val();
//$('#select2-county-container').prop('title', custom_county);
//$('#select2-county-container').html(custom_county);
});
$(document).on('click', '.file-upload__input', function () {
    $(this).prev('.files').trigger('click');
});
</script>
@endsection