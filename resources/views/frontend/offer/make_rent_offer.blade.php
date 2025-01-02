@extends ('frontend.layouts.app')
@section ('title', ('Make Rent Offer'))
@section('after-styles')
<link type="text/css" rel="stylesheet" href="{{ asset(mix('css/contract-tools-buyer.css')) }}" media="all"> 
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
@endsection
@section('content')
<div class="purchase-sale-agreement-review contract-tools-seller-common register-page">
    <div class="">
        <div class="container">
            <div class="row content">
                @include('frontend.includes.sidebar')
                <div class="col-md-9 col-sm-8">
                    <div class="nested-div">
                        <div class="heading-text">
                            <h2>Make an Offer ( Rent)</h2>
                        </div>
                        <div class="row para-text">
                            {{ html()->form('POST', route('frontend.make.offer.save'))->class('form')->acceptsFiles()->open() }}
                            <input type="hidden" value="{{$id}}" name="property_id">
                            <input type="hidden" value="Rent" name="type">
                            <div class="form-group first-child">
                                <label for="rent_price" class="col-sm-12">Tentative Rent/Month Price Offer: ($)</label>
                                <div class="col-sm-12">
                                    <input type="number" class="form-control" min="0" data-rule-required="true" data-msg-required="Please enter the rent offer price" data-rule-number="true" data-msg-number="Please enter valid price" data-rule-digits="true" data-msg-digits="Please only enter numbers!" id="rent_price" name="rent_price" aria-required="true">
                                </div>
                            </div>

                            <div class="form-group">
                                <p class="offer-text col-sm-12">Please Enter Your Contact Information Below:</p>
                                <label for="name" class="col-sm-12 control-label">Name(s):</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control valid" id="name" name="name" data-rule-required="true" data-msg-required="Please enter name" aria-invalid="false">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="email" class="col-sm-12 control-label">Email Address(es):</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" id="email" data-rule-required="true" data-msg-required="Please enter email id" name="email">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="phone" class="col-sm-12 control-label">Phone(s):</label>
                                <div class="col-sm-12">
                                    <input type="number" class="form-control" id="phone" data-rule-required="true" data-msg-required="Please enter phone number" name="phone">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="col-sm-12 control-label">Lease Term:</label>
                                <div class="col-sm-12">
                                    <div class="row lease_doc">
                                        <div class="col-md-6 checkbox">
                                            <input type="checkbox" name="lease_term[]" id="month" class="styled-checkbox" value="Month-To-Month">
                                            <label for="month">Month-To-Month</label>
                                            <input type="checkbox" name="lease_term[]" class="styled-checkbox" id="six-month" value="< 6 Months">
                                            <label for="six-month">&lt; 6 Months </label>
                                            <input type="checkbox" name="lease_term[]" id="twelve" class="styled-checkbox" value="6 - 12 Months">
                                            <label for="twelve">6 to 12 Months </label>
                                            <input type="checkbox" name="lease_term[]" id="one" class="styled-checkbox" value="> 1 Year">
                                            <label for="one">More than 1 Year</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="col-sm-12 control-label">Desired Date of Occupancy?</label>
                                <div class="col-sm-12">
                                    <input id="datetimepicker" type="text" class="form-control" name="date_of_occupancy" data-rule-required="true" data-msg-required="Please enter date">
                                    (Please note, actual occupancy dates may differ slightly from your requested date) </div>
                            </div>
                            <div class="form-group">
                                <label for="" class="col-sm-12 control-label">How many months will you lease the property?</label>
                                <div class="col-sm-12 formField">
                                    <select class="form-control select" id="month_count" data-rule-required="true" data-msg-required="Please select value" name="month_count" aria-required="true">
                                        <option value="">Select Month's</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="6">6</option>
                                        <option value="7">7</option>
                                        <option value="8">8</option>
                                        <option value="9">9</option>
                                        <option value="10">10</option>
                                        <option value="11">11</option>
                                        <option value="12">12+</option>
                                    </select>
                                    <div class="select__arrow"></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-12">
                                    <h5 for="">DO YOU HAVE PETS?</h5>

                                    <input type="radio" class="makeofferradio" id="petYes" name="pets_welcome" id="pets_welcome" value="Yes">
                                    <label for="petYes">Yes</label>

                                    <input type="radio" id="petNo" class="makeofferradio" id="inlineRadio2" name="pets_welcome" value="No">
                                    <label for="petNo">No</label>

                                </div><!--col-md-12-->
                            </div>
                            <div id="pet" style="display: none;" class="form-group">
                                <div class="form-group">
                                    <h5 for="" class="col-sm-12 control-label">If Yes, What Type(s)?</h5>
                                    <div class="col-sm-12">
                                        <div class="row">
                                            <div class="col-md-4 checkbox">
                                                <input type="checkbox"  class="styled-checkbox"  name="pets_type[]" id="dog" value="{{config('constant.pets_type.1')}}">
                                                <label for="dog">Dog(s)</label>
                                            </div>
                                            <div class="col-md-4 checkbox">
                                                <input type="checkbox"  class="styled-checkbox"  name="pets_type[]" id="Cat" value="{{config('constant.pets_type.2')}}">
                                                <label for="Cat">Cat(s)</label>
                                            </div>
                                            <div class="col-md-4 checkbox">
                                                <input type="checkbox"  class="styled-checkbox"  id="OtherYes" class="makeofferradio" value="{{config('constant.pets_type.3')}}" name="pets_type[]">
                                                <label for="OtherYes">Other</label>
                                            </div><!--col-md-12-->
                                            <div id="other" style="display: none;" class="form-group">
                                                <label for="Other" class="col-sm-12 control-label">If Other, Please Explain</label>
                                                <div class="col-sm-12">
                                                    <input type="text" class="form-control" id="pet_other_explanation" name="pet_other_explanation">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12">
                                <h5>Curious about the Rental Process? Follow the link below to learn more!</b>
                                    <a href="Rental_Process.php" target="_blank" class="blue-text">Rental Process</a><br>
                                </h5>
                            </div>

                            <div class="form-group">
                                <div class="col-md-12">
                                    <div class="checkbox">
                                        <input type="checkbox" class="styled-checkbox i_agree" data-rule-required="true" value="1" name="agree" id="styled-checkbox1">
                                        <label for="styled-checkbox1" id="i_agree-label">I Understand &amp; Agree </label>
                                        <span class="error" id="i_agree-error">Please check this to proceed</span>
                                    </div>
                                </div><!--col-md-12-->
                            </div>
                            <div class="form-group">
                                <div class="btns-green-blue col-sm-12">
                                    <input type="submit" class="button btn btn-green" name="submit" id="inputbutton" value="Submit">
                                    <button type="reset"  class="button btn btn-blue reset">Cancel</button>
                                </div>
                            </div>
                            {{ html()->form()->close() }}
                        </div>
                    </div><!--</nested-div>-->
                </div><!--</col>-->
            </div><!--</content>-->
        </div><!--</container>-->
    </div><!--</contract-tools-seller-common>-->
</div><!--</contract-tools-seller-common>-->
@endsection
<script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
@section('after-scripts')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.4/jquery.datetimepicker.min.css" />
<!-- Here by using Id selector the datetime picker will load on this input element -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.4/build/jquery.datetimepicker.full.min.js"></script>
<script src="http://cdn.craig.is/js/rainbow-custom.min.js"></script>

<script type="text/javascript">
$(function () {
    $(document).ready(function () {
        $('select').select2();

        $('form').validate({
            rules: {
                lease_term: {
                    required: true
                },
                pets_welcome: {
                    required: true
                },
                phone: {
                    minlength: 10,
                    maxlength: 10
                }
            },
            messages: {
                lease_term: "Please select any option",
                pets_welcome: "Please select any option",
                phone: {
                    minlength: "Please enter valid phone number",
                    maxlength: "Please enter valid phone number"
                }
            },
            errorPlacement: function (error, element)
            {
                if (element.is(":radio") && element.attr("name") === "lease_term") {
                    error.insertAfter(".lease_doc");
                } else if (element.is(":radio") || element.is(":checkbox"))
                {
                    error.appendTo(element.parents('.form-group'));
                } else if (element.is("select.form-control"))
                {
                    error.appendTo(element.parents('.formField'));
                } else
                {
                    error.insertAfter(element);
                }
            }
        });

        $("form").submit(function (e) {
//            $('#inputbutton').prop('disabled',true);
            if ($('.i_agree').is(":checked")) {
                $('#i_agree-error').hide();
            } else {
                $('#i_agree-error').css("display", "block");
                e.preventDefault();
            }
        });

        $('#i_agree-label').mouseup(function () {
            if ($('.i_agree').prop("checked") == true) {
                $('#i_agree-error').css("display", "block");
            } else if ($('.i_agree').prop("checked") == false) {
                $('#i_agree-error').hide();
            }
        });

        $("#month_count").change(function () {
            $("#month_count-error").hide();
        });

    });
    $("input[name='pets_welcome']").click(function () {
        if ($("#petYes").is(":checked")) {
            $("#pet").show();
        } else {
            $("#pet").hide();
        }
    });

    $("#OtherYes").on('click', function () {
        $("#other").toggle();
    });
    $('.reset').on('click',function(e){
        e.preventDefault();
        $('form')[0].reset();
    });
    $('#datetimepicker').datetimepicker({
        minDate : 0,
        timepicker :false,
        format:'Y-m-d',
    });
});

</script> 
@endsection 