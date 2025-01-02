@extends ('frontend.layouts.app')
@section ('title', ('Thankyou Lease Agreement Tenant'))
@section('after-styles')
<link type="text/css" rel="stylesheet" href="{{ asset(mix('css/contract-tools-buyer.css')) }}" media="all"> 
@endsection
@section('content')
<style>
   .select2-container {
    width: 100% !important;

}
select[multiple], select[size] {
    height: auto;
    width: 100%;
}
</style>
<div class="container purchase-sale-agreement-review contract-tools-seller-common register-page">
   <div class="row">
      <div class=""> 
         <div class="sidebar">
            @include('frontend.includes.sidebar')
         </div>
         <div class="col-md-9 col-sm-8">
            <div class="nested-div">
                @if(isset($tenantQuestionnaire))
                    {{ html()->form('POST', route('frontend.saveAddSignersContractRentTenant', [$tenantQuestionnaire->id]))->id('question-signer-action')->attribute('role', 'form')->open() }}
                    @else
                    {{ html()->form('POST', route('frontend.saveAddSignersContractRentTenant'))->id('question-signer-action')->class('')->attribute('role', 'form')->open() }}
                    @endif
               <div class="heading-text">
                  <h2>Other Property Tenants / Roommates</h2>
               </div>
               <div class="para-text  add_Signer_tenant">
                  <div class="form-group custom_checkbox_message">
                     <h4 class="first-child">Tenant Signers:</h4>
                     <h5 id="attorney-div">Will there be any other Tenants on this lease agreement (Accepted/Required with the Tentative Offer?) [Optional] </h5>
                     
                     <div class="radio-btns">
                                    <input type="radio" name='joint_cowners' <?php
                                    if (isset($tenantQuestionnaire) && $tenantQuestionnaire->joint_cowners == config('constant.inverse_common_yes_no.Yes')) {
                                        ?>
                                               checked="checked" <?php
                                           }
                                           ?>  value="{{config('constant.inverse_common_yes_no.Yes')}}" id ='joint_cowners_yes' required>
                                    <label for="joint_cowners_yes" class='label-yes'>Yes</label>
                                    <input type="radio" name='joint_cowners' <?php
                                    if (isset($tenantQuestionnaire) && $tenantQuestionnaire->joint_cowners == config('constant.inverse_common_yes_no.No')) {
                                        ?>
                                               checked="checked" <?php
                                           }
                                           ?> value="{{config('constant.inverse_common_yes_no.No')}}" id='joint_cowners_no' required>
                                    <label for="joint_cowners_no" class='label-yes'>No</label>
                                    <div class="error-validations form-group">
                                        <label class="error" id="joint_cowners-error" for="joint_cowners"></label>
                                    </div>
                                    @if ($errors->has('joint_cowners_no'))
                                    <div class="alert alert-danger">{{ $errors->first('joint_cowners_no') }}</div>
                                    @endif
                                </div>
                                <div class="show-yes-radio-btn" style="display:none">
                                    <h4 class="last-child">If Yes, Please add your spouse or co-owner as a signer to the contract:</h4>
                                    <ul>
                                        <li>Please click "Add Signer(s)" below.</li>
                                        <li>Enter the co-signer's Name. </li>
                                        <li>Enter the co-signer's Email (Please verify the email is correct!)</li>
                                        <li>Co-Signer check their email for an activation link! </li>
                                    </ul>
                                    <h4>Hold ctrl key to select multiple options:</h4>
                                </div>
                            </div>
                            <?php
                            if (isset($tenantQuestionnaire) && $tenantQuestionnaire->partners) {
                                $selectedEmails = explode(',', $tenantQuestionnaire->partners);
                            }
                            ?>
                            <div class="select-box-div show-yes-radio-btn" style="display:none">
                                <select name="select-email[]" id="select-email" multiple="multiple" required>
                                    @if( isset($signers))
                                    @foreach($signers as $signer)
                                    <option value="{{ $signer->invited_users->id }}" <?php
                                    if (isset($selectedEmails)) {
                                        foreach ($selectedEmails as $email) {
                                            if ($email == $signer->invited_users->id) {
                                                ?>
                                                        selected="selected"
                                                        <?php
                                                    }
                                                }
                                            }
                                            ?> >{{ $signer->invited_users->email }}</option>
                                    @endforeach
                                    @elseif( isset($selectedEmails) )
                                    @foreach($selectedEmails as $selectedEmail)
                                    <option value="{{ $selectedEmail }}" selected="selected"><?php echo findSigner($selectedEmail); ?></option>
                                    @endforeach
                                    @endif
                                </select>
                          
                            </div>
                            <div class="btns-green-blue">                                    
                                <button id="question-signer-landlord-submit" class="btn btn-blue button btn-nxt-submit">Submit</button>
                            </div>
                     {{ html()->form()->close() }}
                
                     <div class="btns-green-blue add-submit-signers" style="display:none;">
                                    <a class="btn btn-green btn-add-signer button">Add Signer(s)</a>                                   
                                </div>
                     <div class="add-signers">
                        <div class="add-signers-form" style="display:none;">
                            <div class="panel panel-default panel-body">
                                <div class="panel-heading"><span class="black-text">Add </span>New Signers</div>
                                <div class="custom_errors"></div>
                                <span>Be advised, it is recommended that the 'Co-signers confirm their account & information as soon as possible, to prevent inaccurate contract information.</span>
                                {{ html()->form('POST', route('frontend.signer.store'))->id('addSigner')->class('form-horizontal')->open() }}
                                <div id="usersignup-form">

                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label for="inputEmail3" class="control-label">Name</label>
                                            <input type="text" class="form-control" data-rule-required="true" placeholder="Please enter the name" data-rule-minlength="2" id="signer_name" aria-required="true" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label for="inputEmail3" class="control-label">Email</label>
                                            <input type="text" class="form-control" placeholder="Please enter email" id="email" name="email" aria-required="true" required>
                                            <div id="emailInfo" align="left"></div>
                                        </div>
                                    </div>
                                    <div class="form-group"> 
                                        <div class="col-sm-12 col-xs-12">
                                            <label class="control-label">Full (Legal) Name:</label>
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
                                            <label class="control-label">Search Address</label>
                                            <input id="postal_code" class="form-control" placeholder="Search Address" name="" type="text" value="" autocomplete="off">
                                        </div><!--col-md-6-->
                                    </div>
                                    <div class="form-group old_zipcode">
                                        <div class="col-md-12">
                                            <label class="control-label">Enter Zipcode:</label>
                                            <input id="zip_code" class="form-control" placeholder="Zip Code" required="" readonly="" name="zip_code" type="text" value="">
                                        </div><!--col-md-6-->
                                    </div>

                                    <div class="form-group custom_zipcode" style="display: none">
                                        <div class="col-md-12">
                                            <label class="control-label">Select Zipcode:</label>
                                        </div>
                                        <div class="col-md-12">
                                            <select id="custom_zipcode" class="form-control select2-hidden-accessible select_custom" name="zip_code" data-get_counties="{{route('frontend.getZipCodes')}}" required="true" disabled="" data-select2-id="custom_zipcode" tabindex="-1" aria-hidden="true">
                                                <option value="" data-select2-id="2">Select zip</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <label class="control-label">Enter State:</label>
                                            <input id="state_disabled" class="form-control not-allow" placeholder="State" required="" disabled="" name="state_disabled" type="text" value="">
                                            <input type="hidden" name="state" value="" id="state">
                                        </div><!--col-md-6-->
                                    </div>

                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <label class="control-label">Select County:</label>
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
                                            <label class="control-label">Enter City</label>
                                            <input id="city_disabled" class="form-control not-allow" placeholder="City" required="" disabled="" name="city_disabled" type="text" value="">
                                            <input type="hidden" name="city" id="city" value="">
                                        </div><!--col-md-6-->
                                    </div>
                                    <div class="form-group custom_city" style="display: none">
                                        <div class="col-md-12">
                                            <label class="control-label">Select City:</label>
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
                                        <label class="control-label">Enter Address:</label>
                                        <textarea id="formatted_address" class="form-control text-height" rows="2" placeholder="Address" required="" name="address" cols="50"></textarea>
                                    </div><!--col-md-6-->
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <label class="control-label">Enter Phone No:</label>
                                        <input class="form-control" id="phone_no" placeholder="Phone No" required="" name="phone_no" type="number" value="">
                                    </div><!--col-md-6-->
                                </div>


                                <div class="signer-buttons btns-green-blue">
                                    <input type="button" class="btn btn-blue button" id="newSigner" value="Submit">
                                    <input type="reset" class="btn btn-green button btn-reset" id="" value="Reset">
                                    <a class="btn btn-blue btn-cancel button">Cancel</a>
                                </div>
                            </div>
                            {{ html()->form()->close() }}
                        </div>
                    </div>
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
        $('#postal_code').keyup(function () {
        $('#county').val('').trigger('change');
        $('#state_disabled').val('');
        $('#city_disabled').val('');
        $('#state').val('');
        $('#city').val('');
        $('#county').find('option').not(':first').remove();
    });
    $('.select_custom').select2();
  
   $(".btn-add-signer").click(function () {
      $(".add-signers-form").toggle();
   });
    $(".btn-cancel").click(function () {        
        $('.add-submit-signers').hide();
            $('.add-signers-form').hide();
    });
     /*add_signers_contract_sale_buyer*/

     if ($('#joint_cowners_no').is(":checked")) {
        $(".show-yes-radio-btn").hide();
        $('#select-email').val('');
        $('#name').val('');
        $('#email').val('');
    }

    // $("#question-signer-landlord-submit").click(function () {
 
    // });

    $(document).on('click', '.btn-nxt-submit', function (e) {
        e.preventDefault();
        $('.add-signers-form').hide();
        form = $('#question-signer-action select');
        $('form').validate().resetForm();
        $('form').validate();

        if (form.valid() === true) {
            //$("#add-signer-step2").show();
            if ($('#joint_cowners_yes').is(":checked")) {
                $(".show-yes-radio-btn").show();
                $('.add-submit-signers').show();
            }
            $("#question-signer-action").submit();
        } 
        else
        {
            return false;
        }
    });

    if ($("#joint_cowners_yes").is(":checked")) {
            $(".show-yes-radio-btn").show();
            $('.add-submit-signers').show();
        } 
    $("input[name='joint_cowners']").click(function () {
        if ($("#joint_cowners_yes").is(":checked")) {
            $(".show-yes-radio-btn").show();
            $('.add-submit-signers').show();
        } else {
            $(".show-yes-radio-btn").hide();
            $('.add-submit-signers').hide();
            $('.add-signers-form').hide();
        }
    });
    // $("#joint_cowners_no").click(function () {
    //     $('#select-email').val('');
    //     $('#name').val('');
    //     $('#email').val('');
    // });

    //$(".error-validations").hide();
    // $("#btn-next").click(function () {
    //     $(".error-validations").show();
    // });
   $( document ).ready(function() {
    //  google.maps.event.addDomListener(window, 'load', function () {
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
        //$('.select_custom').select2();
        var custom_county = $('#custom_county').val();
        $('#select2-county-container').prop('title', custom_county);
        $('#select2-county-container').html(custom_county);

    });
   
     $("#newSigner").click(function (e) {
        e.preventDefault();
        $('#newSigner').prop('disabled', true);
        var name = $('#signer_name').val();
        var email = $('#email').val();
        var firstname = $('#fname').val();
        var middlename = $('#mname').val();
        var lastname = $('#lname').val();
        var state = $('#state').val();
        var phone_no = $('#phone_no').val();
        var address = $('#formatted_address').val();
        var county = $('#select2-county-container').text();
        if ($('#select2-custom_zipcode-container').text() != '' && $('#select2-custom_zipcode-container').text()!='Select zip')
        {
            var zipcode = $('#select2-custom_zipcode-container').text();
        } else
        {
            var zipcode = $('#zip_code').val();
        }
//        alert($('#select2-custom_city-container').text());
        if ($('#select2-custom_city-container').text()!= '' && $('#select2-custom_city-container').text()!='Select City') {
            var city = $('#select2-custom_city-container').text();
        } else {
            var city = $('#city').val();
        }

        $.ajax({
            type: 'POST',
            dataType: 'json',
            data: {
                name: name,
                email: email,
                first_name: firstname,
                middle_name: middlename,
                last_name: lastname,
                county: county,
                zip_code: zipcode,
                phone_no: phone_no,
                city: city,
                state: state,
                address: address,
                type:'rent',
                property_id:<?php echo $getProperty->property_id ?>
            },
            url: "{{route('frontend.contractToolSigner')}}",
            success: function (data) {
                swal("Success", 'Signer added successfully!', "success");
                $('#newSigner').prop('disabled', false);
                var option = '';
                $.each(data.signers, function (i, invited) {
                    option += '<option value="' + invited.invited_users.id + '">' + invited.invited_users.email + '</option>';
                });
                $('#select-email').html(option);
                $('#addSigner')[0].reset();
                $('.custom_zipcode').hide();
                $('.custom_city').hide();
                $('.old_zipcode').show();
                $('.old_city').show();
                $('#select2-custom_zipcode-container').text('');
                $('#select2-custom_city-container').text('');
                $('#county').append($('<option value>Select County</option>'));
                $('input[type="text"],texatrea, select').val('');
            },
            error: function (data) {
                var errors = data.responseJSON; //this will get the errors response data.
                errorsHtml = '<div class="custom_alert"><ul>';

                $.each(errors, function (key, value) {
                    errorsHtml += '<li>' + value[0] + '</li>'; //showing only the first error.
                });
                errorsHtml += '</ul></div>';
                $('#newSigner').prop('disabled', false);

                if (data.responseJSON.message) {
                    swal("Oops", data.responseJSON.message, "error");
                } else {
                       swal({
                        html: true,
                        type: 'error',
                        title: 'Oops...',
                        text: errorsHtml,
                    });
                }
            }
        });

    });
    });
</script> 
@endsection