@extends ('frontend.layouts.app')
@section ('title', ('Signer Create'))
@section('after-styles')
<link type="text/css" rel="stylesheet" href="{{ asset(mix('css/dashboard.css')) }}" media="all">
@endsection 
@section('content')
<style>
    .select2-container {
	width: 100% !important;
    }
</style>
<div class="login-page password signer-page">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="panel panel-default1">
                    <div class="panel-heading"><span class="black-text">Add </span>New Signers</div>
                    <div class="">
                        {{ html()->form('POST', route('frontend.signer.store'))->class('form-horizontal')->open() }}
			<div id="usersignup-form">

			    <div class="form-group">
				<div class="col-sm-12">
				    <h4 class="control-label">Name</h4>
				    <input type="text" class="form-control" data-rule-required="true" placeholder="Please enter the name" data-rule-minlength="2" id="signer_name" name="name" aria-required="true" required>
				</div>
			    </div>
			    <div class="form-group">
				<div class="col-sm-12">
				    <h4 class="control-label">Email</h4>
				    <input type="text" class="form-control" placeholder="Please enter email" id="email" name="email" aria-required="true" required>
				    <div id="emailInfo" align="left"></div>
				</div>
			    </div>
			    <div class="form-group"> 
				<div class="col-sm-12 col-xs-12">
				     <h4 class="control-label">Full (Legal) Name:</h4>
				</div>
				<div class="col-sm-4 col-xs-12">
				    <input type="text" class="form-control" id="fname" data-rule-required="true" data-msg-required="Enter first name" name="first_name" value="" aria-required="true" required="true" placeholder="First Name">
				</div>
				<div class="col-sm-4 col-xs-12">
				    <input type="text" class="form-control" id="mname" name="middle_name" value="" placeholder="Middle Name">
				</div>
				<div class="col-sm-4 col-xs-12">
				    <input type="text" class="form-control" id="lname" name="last_name" data-rule-required="true" data-msg-required="Enter last name" value="" aria-required="true" required="true" placeholder="Last Name">
				</div>
			    </div>
			    <div class="form-group">
				<div class="col-sm-12">
				     <h4 class="control-label">Search Address:</h4>
				    <input id="postal_code" class="form-control" placeholder="Search Address" name="" type="text" value="" autocomplete="off">
				</div><!--col-md-6-->
			    </div>
			    <div class="form-group old_zipcode">
				<div class="col-md-12">
				     <h4 class="control-label"> Enter Zipcode:</h4>
				    <input id="zip_code" class="form-control" placeholder="Zip Code" required="" readonly="" name="zip_code" type="text" value="">
				</div><!--col-md-6-->
			    </div>

			    <div class="form-group custom_zipcode" style="display: none">
				<div class="col-md-12">
				     <h4 class="control-label"> Select Zipcode:</h4>
				</div>
				<div class="col-md-12">
				    <select id="custom_zipcode" class="form-control select2-hidden-accessible select_custom" name="zip_code" data-get_counties="{{route('frontend.getZipCodes')}}" required="true" disabled="" data-select2-id="custom_zipcode" tabindex="-1" aria-hidden="true">
					<option value="" data-select2-id="2"> Select zip</option>
				    </select>
				</div>
			    </div>
			    <div class="form-group">
				<div class="col-md-12">
				     <h4 class="control-label"> Enter State:</h4>
				    <input id="state_disabled" class="form-control not-allow" placeholder="State" required="" disabled="" name="state_disabled" type="text" value="">
				    <input type="hidden" name="state" value="" id="state">
				</div><!--col-md-6-->
			    </div>

			    <div class="form-group">
				<div class="col-md-12">
				     <h4 class="control-label">Select County: </h4>
				</div>
				<div class="col-md-12">
				    <!--<div class="formField">-->
				    <input type="hidden" id="custom_county" value="">
				    <select id="county" class="form-control select2-hidden-accessible select_custom" name="county" data-get_counties="{{route('frontend.getCounties')}}" required="true" data-select2-id="county" tabindex="-1" aria-hidden="true">
					<option value="">Select County</option>
				    </select>
				</div>
			    </div>
			    <!--</div>-->

			    <div class="form-group old_city">
				<div class="col-md-12">
				     <h4 class="control-label">Enter City: </h4>
				    <input id="city_disabled" class="form-control not-allow" placeholder="City" required="" disabled="" name="city_disabled" type="text" value="">
				    <input type="hidden" name="city" id="city" value="">
				</div><!--col-md-6-->
			    </div>
			    <div class="form-group custom_city" style="display: none">
				<div class="col-md-12">
				     <h4 class="control-label"> Select City:</h4>
				</div>
				<div class="col-md-12">
				    <select id="custom_city" class="form-control select2-hidden-accessible select_custom" name="city" data-get_counties="{{route('frontend.getCities')}}" required="true" disabled="" data-select2-id="custom_city" tabindex="-1" aria-hidden="true">
					<option value="" data-select2-id="6">Select City</option>
				    </select>
				</div>
			    </div>
			</div>

			<div class="form-group">
			    <div class="col-md-12">
				 <h4 class="control-label"> Enter Address:</h4>
				<textarea id="formatted_address" class="form-control text-height" rows="2" placeholder="Address" required="" name="address" cols="50"></textarea>
			    </div><!--col-md-6-->
			</div>
			<div class="form-group">
			    <div class="col-md-12">
				 <h4 class="control-label">Enter Phone No:</h4>
				<input class="form-control" id="phone_no" placeholder="Phone No" required="" name="phone_no" type="number" value="">
			    </div><!--col-md-6-->
			</div>


			<div class="small-buttons mr-top">
			    <div class="btns-green-blue text-center margin-bottom"> 
				<input type="submit" class="button btn btn-blue" name="submit" value="Submit">
				<input type="reset" class="button btn btn-green m-left" value="Reset">
				<a href="{{ route('frontend.signer.index') }}" type="button" class="btn btn-blue btn-cancel button">Cancel</a>
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
<script src="https://maps.googleapis.com/maps/api/js?region=usa&key=<?= config('settings.google_map_api_key') ?>&libraries=places" type="text/javascript"></script>
<script>
$(document).ready(function () {
    $('form').validate({
        rules: {
            email: {
                email: true
            }
        },
        messages: {
            email: {
                email: "Plese enter correct email id"
            }
        }
    });
    
    $('.reset').on('click', function (e) {
        e.preventDefault();
        $('form')[0].reset();
    });

    $(document).ready(function(){
    // google.maps.event.addDomListener(window, 'load', function () {
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
//                        $('#custom_zipcode').append($('<option value>Select Zipcode</option>'));
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
//                    $('#county').append($('<option value>Select County</option>'));
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
//                        $('#custom_city').append($('<option value>Select City</option>'));
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
        $('.select_custom').select2();
        var custom_county = $('#custom_county').val();
        $('#select2-county-container').prop('title', custom_county);
        $('#select2-county-container').html(custom_county);

    });
});
</script>
@endsection
