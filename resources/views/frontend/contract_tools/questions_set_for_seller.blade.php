@extends ('frontend.layouts.app')
@section ('title', ('Questions Set For Seller'))
@section('after-styles')
<link type="text/css" rel="stylesheet" href="{{ asset(mix('css/contract_tools.css')) }}" media="all"> 
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.min.css" />
@endsection
@section('content')
<div class="container purchase-sale-agreement-review contract-tools-seller-common register-page dis-que">
    <div class="row">
        <div class="">
            <div class="sidebar">
                @include('frontend.includes.sidebar')
            </div>
            <div class="col-md-9 col-sm-8">
                <div class="nested-div">
                    @if(isset($sellerQuestionnaire))
                    {{ html()->form('POST', route('frontend.saveSellerQuestionnaire', [$sellerQuestionnaire->id]))->id('question-signer-action')->class('seller-que-signer-form')->attribute('role', 'form')->open() }}
                    @else
                    {{ html()->form('POST', route('frontend.saveSellerQuestionnaire'))->id('question-signer-action')->class('seller-que-signer-form')->attribute('role', 'form')->open() }}
                    @endif
                    <div id="question-seller-step1">
                        <div class="heading-text">
                            <h2>Step 1 of 6: Seller Questionnaire</h2>
                        </div>
                        <div class="form-group para-text">
                            <div>
                                <h5 class="first-child" id="attorney-div">1. Do you require any earnest money? These funds are not required, and if collected must be deposited to your attorney or a joint trust. </h5>
                                <div>
                                    <input type="radio" id="attorneyYes" name="earnest_money"<?php
                                    if ((!empty($sellerQuestionnaire) && $sellerQuestionnaire->earnest_money == config('constant.inverse_seller_questionnaire.Yes')) || ( old('earnest_money') == config('constant.inverse_seller_questionnaire.Yes'))) {
                                        ?>
                                               checked="checked"
                                           <?php } ?>  value="{{config('constant.inverse_seller_questionnaire.Yes')}}" required>

                                    <label for="attorneyYes">Yes</label>
                                    <input type="radio" id="attorneyNo" name="earnest_money" <?php
                                    if ((!empty($sellerQuestionnaire) && $sellerQuestionnaire->earnest_money == config('constant.inverse_seller_questionnaire.No')) || ( old('earnest_money') == config('constant.inverse_seller_questionnaire.No'))) {
                                        ?>
                                               checked="checked"
                                               <?php
                                           }
                                           ?> value="{{config('constant.inverse_seller_questionnaire.No')}}" required>
                                    <label for="attorneyNo">No</label>
                                    <div class="error-validations form-group">
                                        <label class="error" id="earnest_money-error" for="earnest_money"></label>
                                    </div>
                                    @if ($errors->has('earnest_money'))
                                    <div class="error">{{ $errors->first('earnest_money') }}</div>
                                    @endif
                                </div>
                            </div>
                            <div id="attorney" style="display: none">
                                <div>
                                    <p> a.) If Yes, What amount?</p>
                                    <input type="number" class="form-control amount_for_earnest_money" id="amount_for_earnest_money" required name="amount_for_earnest_money" value="{{$sellerQuestionnaire->amount_for_earnest_money??old('amount_for_earnest_money','')}}">
                                    @if(count($errors->get('amount_for_earnest_money')) > 0)
                                    <span class="text text-danger">{{implode('<br>', $errors->get('amount_for_earnest_money'))}}</span>
                                    @endif
                                    <p>(Generally $1,000 or &lt;1% of the sales price). </p>
                                    <p> b.)  If Yes, Where will the funds be deposited? <span> If not yet known, leave blank. (Must be a third party attorney, escrow, title, or brokerage)</span></p>
                                    <input type="text" class="form-control amount_for_earnest_money" id="where_funds_deposited" name="where_funds_deposited" value="{{$sellerQuestionnaire->where_funds_deposited??old('where_funds_deposited','')}}" placeholder="Where Funds Deposited">
                                    @if ($errors->has('where_funds_deposited'))
                                    <span class="text text-danger">{{ $errors->first('where_funds_deposited') }}</span>
                                    @endif

                                    <input type="text" class="form-control amount_for_earnest_money" id="legal-firm-address" name="legal_firm_address" value="{{$sellerQuestionnaire->legal_firm_address??old('legal_firm_address','')}}"  placeholder="Legal Firm Address">
                                    @if ($errors->has('legal_firm_address'))
                                    <span class="text text-danger">{{ $errors->first('legal_firm_address') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div>
                                <h5>2.  Are there any household items included in the sale (ie: Refrigerator, Furniture, Range Oven, Dish-Washer, Microwave, TV Console, Living Room Sofa, Etc. etc)?</h5>
                                <textarea rows="4" id="optional_message" class="form-control text-height" id="text-form-input" name="household_items" placeholder="Enter the household items">{{$sellerQuestionnaire->household_items??old('household_items','')}}</textarea>
                                @if(count($errors->get('household_items')) > 0)
                                <span class="text text-danger">{{implode('<br>', $errors->get('household_items'))}}</span>
                                @endif
                            </div>

                            <div>
                                <h5>3. Do you have a Real Estate Agent?</h5>
                                <input type="radio" id="AgentYes" name="real_estate_agent" <?php
                                if ((!empty($sellerQuestionnaire) && $sellerQuestionnaire->real_estate_agent == config('constant.inverse_seller_questionnaire.Yes')) || ( old('earnest_money') == config('constant.inverse_seller_questionnaire.Yes'))) {
                                    ?>
                                           checked="checked"
                                           <?php
                                       }
                                       ?> value="{{config('constant.inverse_seller_questionnaire.Yes')}}" required>
                                <label for="AgentYes">Yes</label>
                                <input type="radio" id="AgentNo" name="real_estate_agent" <?php
                                if ((!empty($sellerQuestionnaire) && $sellerQuestionnaire->real_estate_agent == config('constant.inverse_seller_questionnaire.No')) || ( old('earnest_money') == config('constant.inverse_seller_questionnaire.No'))) {
                                    ?>
                                           checked="checked"
                                           <?php
                                       }
                                       ?> value="{{config('constant.inverse_seller_questionnaire.No')}}" required>
                                <label for="AgentNo">No</label>
                                <div class="error-validations form-group">
                                    <label class="error" id="real_estate_agent-error" for="real_estate_agent"></label>
                                </div>
                                @if(count($errors->get('real_estate_agent')) > 0)
                                <span class="text text-danger">{{implode('<br>', $errors->get('real_estate_agent'))}}</span>
                                @endif
                            </div>

                            <div id="Agent" style="display: none">
                                <div>
                                    <p class="offer-text">If Yes, What is the Real Estate Firm's Name:</p>
                                    <input type="text" required class="form-control real_estate_agent_name" id="real_estate_firm_name"  name="real_estate_firm_name" value="{{$sellerQuestionnaire->real_estate_firm_name??old('real_estate_firm_name','')}}" placeholder="Real Estate Firm's Name">
                                    @if(count($errors->get('real_estate_firm_name')) > 0)
                                    <span class="text text-danger">{{implode('<br>', $errors->get('real_estate_firm_name'))}}</span>
                                    @endif
                                </div>
                                <div>
                                    <p class="offer-text">What Percentage of Sales Price/Fixed Commission is owed to the Realtor?</p>
                                    <input class="form-control real_estate_agent_name" min="0" required id="commission" placeholder="" name="commission" type="number" value="{{$sellerQuestionnaire->commission??old('commission','')}}">
                                    @if(count($errors->get('commission')) > 0)
                                    <span class="text text-danger">{{implode('<br>', $errors->get('commission'))}}</span>
                                    @endif
                                </div>
                                <div>
                                    <p class="offer-text">What is the contact information for the Realtor </p>
                                    <input class="form-control real_estate_agent_name" id="agentName" placeholder="Full Name" required name="name" type="text" value="{{$sellerQuestionnaire->agent_name??old('name','')}}">
                                    <div class="offer-text">
                                        <input class="form-control seller_phone real_estate_agent_name" required id="phone" min="0" placeholder="Phone" name="phone" type="number" value="{{$sellerQuestionnaire->agent_phone??old('phone','')}}">
                                        @if(count($errors->get('phone')) > 0)
                                        <span class="text text-danger">{{implode('<br>', $errors->get('phone'))}}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div>
                                <h5>4.  Property Occupancy/Possession Questions?</h5>
                                <p class="offer-text"> Is the property currently occupied by a tenant (Leased)? </p>
                                <p class="offer-text">OR </p>
                                <p class="offer-text">Will you (The seller) require additional time AFTER CLOSING to vacate the property?</p>
                                <input type="radio" id="OccupancyYes" name="houseowners_associations"  <?php
                                if ((!empty($sellerQuestionnaire) && $sellerQuestionnaire->houseowners_associations == config('constant.inverse_seller_questionnaire.Yes')) || ( old('earnest_money') == config('constant.inverse_seller_questionnaire.Yes'))) {
                                    ?>
                                           checked="checked"
                                           <?php
                                       }
                                       ?> value="{{config('constant.inverse_seller_questionnaire.Yes')}}" required>
                                <label for="OccupancyYes">Yes</label>
                                <input type="radio" id="OccupancyNo" name="houseowners_associations"  <?php
                                if ((!empty($sellerQuestionnaire) && $sellerQuestionnaire->houseowners_associations == config('constant.inverse_seller_questionnaire.No') ) || ( old('earnest_money') == config('constant.inverse_seller_questionnaire.No'))) {
                                    ?>
                                           checked="checked"
                                           <?php
                                       }
                                       ?> value="{{config('constant.inverse_seller_questionnaire.No')}}" required>
                                <label for="OccupancyNo">No</label>
                                <div class="error-validations form-group">
                                    <label class="error" id="houseowners_associations-error" for="houseowners_associations"></label>
                                </div>
                                @if(count($errors->get('houseowners_associations')) > 0)
                                <span class="text text-danger">{{implode('<br>', $errors->get('houseowners_associations'))}}</span>
                                @endif
                            </div>

                            <div id="Occupancy" style="display: none">
                                <div>
                                    <p> When is the Lease Expiration, or when will the property be vacant? </p>
                                    <input type="text" id="datepicker" class="form-control occupancy" placeholder="" name="property_vacant_date"  value="{{$sellerQuestionnaire->property_vacant_date??old('property_vacant_date','')}}" required>
                                    @if(count($errors->get('property_vacant_date')) > 0)
                                    <span class="text text-danger">{{implode('<br>', $errors->get('property_vacant_date'))}}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="btns-green-blue btns-text-align-right">
                                <a class="btn btn-green button btn-nxt-submit" id="btn-next">Next</a>
                                <button type="reset" class="btn btn-blue button">Reset</button>
                            </div>
                        </div>
                    </div>
                    <div id="add-signer-step2" style="display:none;" class="ownership-interest-additional-required-signers">
                        <div class="nested-div">
                            <div class="heading-text">
                                <h2>Step 2 of 6: Ownership Interest and Additional Required Signers</h2>
                            </div>
                            <div class="para-text">
                                <p class="first-child">Are you married AND/OR do you own this property jointly (Are there any Co-Owners?)</p>
                                <p><i>(Please Note: Contracts may not be considered legal without ALL owner signatures.)</i></p>
                                <div class="radio-btns">
                                    <input type="radio" autofocus="" name='add_signer' value="{{config('constant.inverse_common_yes_no.Yes')}}" id = 'yes-radio-btn'
                                    <?php
                                    if ((!empty($sellerQuestionnaire) && $sellerQuestionnaire->joint_cowners == config('constant.inverse_common_yes_no.Yes')) || ( old('earnest_money') == config('constant.inverse_seller_questionnaire.Yes'))) {
                                        ?>
                                               checked="checked" <?php
                                           }
                                           ?> required>
                                    <label for="yes-radio-btn" class='label-yes'>Yes</label>
                                    <input type="radio" name='add_signer' value="{{config('constant.inverse_common_yes_no.No')}}" id='no-radio-btn'
                                    <?php
                                    if ((!empty($sellerQuestionnaire) && $sellerQuestionnaire->joint_cowners == config('constant.inverse_common_yes_no.No')) || ( old('earnest_money') == config('constant.inverse_seller_questionnaire.No'))) {
                                        ?>
                                               checked="checked" <?php
                                           }
                                           ?> >
                                    <label for="no-radio-btn" class='label-yes'>No</label>
                                    <div class="error-validations form-group">
                                        <label class="error" id="add_signer-error" for="add_signer"></label>
                                    </div>
                                    @if(count($errors->get('add_signer')) > 0)
                                    <span class="text text-danger">{{implode('<br>', $errors->get('add_signer'))}}</span>
                                    @endif
                                </div>
                                <div class="show-yes-radio-btn">
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
                            if (isset($sellerQuestionnaire)) {
                                if ($sellerQuestionnaire->partners) {
                                    $selectedEmails = explode(',', $sellerQuestionnaire->partners);
                                }
                            }
                            ?>
                            <div class="select-box-div show-yes-radio-btn">
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
                                    <option value="{{ $selectedEmail }}" selected="selected" ><?php echo findSigner($selectedEmail); ?></option>
                                    @endforeach
                                    @endif
                                </select>
                                <div class="error-validations form-group para-text">
                                    <label class="error first-child" id="select-email-error" for="select-email"></label>
                                </div>
                                <div class="btns-green-blue add-submit-signers">
                                    <a class="btn btn-green btn-add-signer button">Add Signer(s)</a>
                                </div>
                            </div>
                            <div class="btns-green-blue">
                                <button type="button" id="question-signer-submit" class="btn btn-blue button btn-nxt-submit">Next</button>
                            </div>
                        </div>
                    </div>
                    {{ html()->form()->close() }}
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
                                            <input type="text" class="form-control" data-rule-required="true" placeholder="Please enter the name" data-rule-minlength="2" id="signer_name" name="signer_name" aria-required="true" required>
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
        </div><!--</col>-->
    </div><!--</row>-->
</div><!--</contract-tools-seller-common>-->
@endsection
@section('after-scripts')


<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.min.js"></script>
<script src="http://cdn.craig.is/js/rainbow-custom.min.js"></script>

<script>
$(document).ready(function () {
//   $('.ownership-interest-additional-required-signers-text').hide
    /*questions_set_for_seller*/

    $('#datepicker').datepicker({
        format: "yyyy-mm-dd",
        startDate: new Date()
    });
    $('form').validate({
        messages: {
            earnest_money: "Please select anyone option",
//            household_items: "Household item field is required",
            amount_for_earnest_money: "Please fill the amount",
            where_funds_deposited: "Please fill where funds will be deposited",
            real_estate_agent: "Please select anyone option",
            real_estate_firm_name: "Please fill the name of real estate firm",
            commission: "Please fill the percentage",
            name: "Please fill the name",
            phone: "Contact number is required",
            houseowners_associations: "Please select anyone option",
            property_vacant_date: "Date is required"
        }
    });

    if ($('#attorneyYes').is(":checked")) {
        $("#attorney").show();
    }

    if ($('#AgentYes').is(":checked")) {
        $("#Agent").show();
    }
    if ($('#OccupancyYes').is(":checked")) {
        $("#Occupancy").show();
    }

    $("input[name='earnest_money']").click(function () {
        if ($("#attorneyYes").is(":checked")) {
            $("#attorney").show();
        } else {
            $("#attorney").hide();
        }
    });

    $("input[name='real_estate_agent']").click(function () {
        if ($("#AgentYes").is(":checked")) {
            $("#Agent").show();
        } else {
            $("#Agent").hide();
        }
    });
    $("input[name='houseowners_associations']").click(function () {
        if ($("#OccupancyYes").is(":checked")) {
            $("#Occupancy").show();
        } else {
            $("#Occupancy").hide();
        }
    });


    $("#attorneyNo").click(function () {
        $(".amount_for_earnest_money").val('');
        $("#attorney").hide();
    });

    $("#AgentNo").click(function () {
        $("#Agent input").val('');
        $("#Agent").hide();
    });

    $("#OccupancyNo").click(function () {
        $("#Occupancy input").val('');
        $("#Occupancy").hide();
    });
    $(':input[type=number]').on('mousewheel', function (e) {
        $(this).blur();
    });
    /*end*/

    /*add_signers_contract_sale_seller*/

    $("#question-signer-submit").click(function () {
        if ($('#select-email').val() !== '') {
            $("#question-signer-action").submit();
        }
    });
    $(".show-yes-radio-btn").hide();
    $(document).on('click', '.btn-nxt-submit', function () {
        form = $('#question-signer-action input,textarea,select');
        form.validate();
        if (form.valid() === true) {
            $('#question-seller-step1').hide();
            $("#add-signer-step2").show();
            if ($('#yes-radio-btn').is(":checked")) {
                $(".show-yes-radio-btn").show();
            }
        } else {
            return false;
        }
    });
    $("input[name='add_signer']").click(function () {
        if ($("#yes-radio-btn").is(":checked")) {
            $(".show-yes-radio-btn").show();
        } else {
            $(".show-yes-radio-btn").hide();
            $('.add-signers-form').hide();
        }
    });
    if ($("#no-radio-btn").is(":checked")) {
        $('#select-email').val('');
        $('#name').val('');
        $('#email').val('');
    }
    $("#no-radio-btn").click(function () {
        $('#select-email').val('');
        $('#name').val('');
        $('#email').val('');
    });
    $(".btn-add-signer").click(function () {
        $('#addSigner')[0].reset();
        $(".add-signers-form").toggle();
    });
    $(".btn-cancel").click(function () {
        $(".add-signers-form").hide();
    });

    $("#newSigner").click(function (e) {
        e.preventDefault();
        $('#newSigner').prop('disabled', true);
        var name = $('#signer_name').val();
        var email = $('#email').val();
        var firstname = $('#fname').val();
        var middlename = $('#mname').val();
        var lastname = $('#lname').val();
        $.ajax({
            type: 'POST',
            dataType: 'json',
            data: {
                name: name,
                email: email,
                first_name: firstname,
                middle_name: middlename,
                last_name: lastname,
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
            },
            error: function (data) {
                var errors = data.responseJSON; //this will get the errors response data.
                errorsHtml = '<div class="custom_alert"><ul>';

                $.each(errors, function (key, value) {
                    errorsHtml += '<li>' + value[0] + '</li>'; //showing only the first error.
                });
                errorsHtml += '</ul></div>';
                console.log(data);  
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

    /*errorvalidations*/
    $(".error-validations").hide();
    $("#btn-next").click(function () {
        $(".error-validations").show();
    });
    /*end*/
    $('#btn-next').click(function () {
    $('html,body').animate({scrollTop: $('#question-signer-action').offset().top - 100});
});
});
</script>
@endsection
