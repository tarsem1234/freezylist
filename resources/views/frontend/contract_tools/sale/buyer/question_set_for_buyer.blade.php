@extends ('frontend.layouts.app')
@section ('title', ('Questions Set For Buyer'))
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
                <div id="myform" class="nested-div">
                    @if(isset($buyerQuestionnaire))
                    {{ html()->form('POST', route('frontend.storeQuestionSetForBuyer', [$buyerQuestionnaire->id]))->id('question-signer-action')->attribute('role', 'form')->open() }}
                    @else
                    {{ html()->form('POST', route('frontend.storeQuestionSetForBuyer'))->id('question-signer-action')->class('')->attribute('role', 'form')->open() }}
                    @endif
                    <div id="question-buyer-step1">
                        <div class="heading-text"> 
                            <h2>Questions Set For Buyer</h2>
                        </div>
                        <div class="form-group para-text reset">                                         
                            <div>
                                <div>
                                    <h5 class="first-child">1. Will you be using a VA or FHA Loan?</h5>
                                    <input type="radio" name="using_VA_or_FHA" id="loan_yes" <?php
                                    if ($buyerQuestionnaire) {
                                        if ($buyerQuestionnaire->using_VA_or_FHA
                                            == config('constant.inverse_common_yes_no.Yes')) {
                                            ?>
                                                   checked="checked"
                                                   <?php
                                               }
                                           }
                                           ?> value="{{config('constant.inverse_common_yes_no.Yes')}}" required>
                                    <label for="loan_yes">Yes</label>
                                    <input type="radio" name="using_VA_or_FHA" id="loan_no" <?php
                                    if ($buyerQuestionnaire) {
                                        if ($buyerQuestionnaire->using_VA_or_FHA
                                            == config('constant.inverse_common_yes_no.No')) {
                                            ?>
                                                   checked="checked"
                                                   <?php
                                               }
                                           }
                                           ?> value="{{config('constant.inverse_common_yes_no.No')}}" required>
                                    <label for="loan_no">No</label>
                                    <p><i>(Note: If you are not sure, Select "Yes")</i></p>
                                    <div class="error-validations form-group">
                                        <label class="error" id="add_signer-error" for="using_VA_or_FHA"></label>
                                    </div>
                                    @if(count($errors->get('using_VA_or_FHA')) > 0)
                                    <span class="text text-danger">{{implode('<br>', $errors->get('using_VA_or_FHA'))}}</span>
                                    @endif
                                </div>

                                <div>
                                    <h5>2. Do you have a specific date which you would like to close on the property? </h5>
                                    <input type="radio" name="addendum" id="specific_dateyes" <?php
                                    if ($buyerQuestionnaire) {
                                        if ($buyerQuestionnaire->addendum == config('constant.inverse_common_yes_no.Yes')) {
                                            ?>
                                                   checked="checked"
                                                   <?php
                                               }
                                           }
                                           ?> value="{{config('constant.inverse_common_yes_no.Yes')}}" required>
                                    <label for="specific_dateyes">Yes</label>

                                    <input type="radio" name="addendum" id="specific_dateno" <?php
                                    if ($buyerQuestionnaire) {
                                        if ($buyerQuestionnaire->addendum == config('constant.inverse_common_yes_no.No')) {
                                            ?>
                                                   checked="checked"
                                                   <?php
                                               }
                                           }
                                           ?> value="{{config('constant.inverse_common_yes_no.No')}}" required>
                                    <label for="specific_dateno">No</label>
                                    <div class="error-validations form-group">
                                        <label class="error" id="add_signer-error" for="addendum"></label>
                                    </div>
                                    @if(count($errors->get('addendum')) > 0)
                                    <span class="text text-danger">{{implode('<br>', $errors->get('addendum'))}}</span>
                                    @endif
                                    <div  id="specific_date" style="display: none">
                                        <div>
                                            <p>If Yes, When would you like to close?</p>
                                            <input type="text" id="datepicker1" class="form-control" placeholder="" name="close_date"  value="{{$buyerQuestionnaire->close_date??""}}" required>
                                            <p><i>(Typically 30 days - please allow a sufficient Due Diligence Period)</i></p>
                                            <div class="error-validations form-group">
                                                <label class="error" id="add_signer-error" for="datepicker1"></label>
                                            </div>
                                            @if(count($errors->get('close_date')) > 0)
                                            <span class="text text-danger">{{implode('<br>', $errors->get('close_date'))}}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div  id="specific_date_no" style="display: none">
                                        <div>
                                            <p>(If "No", the contract will state [current + 30 days] as a tentative date)</p>
                                        </div>
                                    </div>
                                </div>        
                                <div>  
                                    <h5>3. Would you like to include an offer expiration date?  </h5>
                                    <input type="radio" name="set_specific_date" id="set_specific_dateyes" <?php
                                    if ($buyerQuestionnaire) {
                                        if ($buyerQuestionnaire->set_specific_date
                                            == config('constant.inverse_common_yes_no.Yes')) {
                                            ?>
                                                   checked="checked"
                                                   <?php
                                               }
                                           }
                                           ?> value="{{config('constant.inverse_common_yes_no.Yes')}}" required>
                                    <label for="set_specific_dateyes">Yes</label>
                                    <input type="radio" name="set_specific_date" id="set_specific_dateno" <?php
                                    if ($buyerQuestionnaire) {
                                        if ($buyerQuestionnaire->set_specific_date
                                            == config('constant.inverse_common_yes_no.No')) {
                                            ?>
                                                   checked="checked"
                                                   <?php
                                               }
                                           }
                                           ?> value="{{config('constant.inverse_common_yes_no.No')}}" required>
                                    <label for="set_specific_dateno">No</label>
                                    <div class="error-validations form-group">
                                        <label class="error" id="add_signer-error" for="set_specific_date"></label>
                                    </div>
                                    @if(count($errors->get('set_specific_date')) > 0)
                                    <span class="text text-danger">{{implode('<br>', $errors->get('set_specific_date'))}}</span>
                                    @endif
                                    <div  id="set_specific_date" style="display: none">
                                        <div>
                                            <p>If Yes, Please note the date of expiry?</p>
                                            <input type="text" id="datepicker2" class="form-control" placeholder="" name="date_of_expiry"  value="{{$buyerQuestionnaire->date_of_expiry??""}}" required>
                                            <p><i>(Typically 3-5 days) </i></p>
                                            <div class="error-validations form-group">
                                                <label class="error" id="add_signer-error" for="datepicker2"></label>
                                            </div>
                                            @if(count($errors->get('date_of_expiry')) > 0)
                                            <span class="text text-danger">{{implode('<br>', $errors->get('date_of_expiry'))}}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div  id="set_specific_date_no" style="display: none">
                                        <div>
                                            <p>(If "No", the offer will expire in 3 days)</p>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <h5>Please note the following Special Item(s), requested by the seller:</h5>
                                    <ul>
                                        <li>The seller has requested an Earnest Money Deposit of $ 1000 to be deposited with a 3rd party, which will be applied toward the purchase upon closing.</li>
                                        <li>The seller has requested to occupy the property (post-closing) until 2018-09-30<i>(Please note: If the seller has requested time after closing, your closing may require a post-closing occupancy agreement or a sell-leaseback agreement.)</i></li>
                                    </ul>
                                </div>                                                
                                <div class="btns-green-blue btns-text-align-right">
                                    <a class="btn btn-blue button btn-nxt-submit" id="btn-next">Next</a>                                    
                                </div>
                            </div>                                           
                        </div>
                    </div>
                    <div id="add-signer-step2" style="display:none;" class="ownership-interest-additional-required-signers">
                        <div class="nested-div">
                            <div class="heading-text">
                                <h2>Step 2 of 6: Ownership Interest and Additional Required Signers</h2>
                            </div>
                            <div class="para-text">
                                <p class="first-child">Do you intend to own this property jointly (With Spouse/Co-Owners?) [Optional]</p>
                                <p><i>(The adage for married users is "One to Buy; Two to Sell)</i></p>
                                <div class="radio-btns">   
                                    <input type="radio" autofocus="" name='add_signer' value="{{config('constant.inverse_common_yes_no.Yes')}}" id = 'yes-radio-btn'
                                    <?php
                                    if ($buyerQuestionnaire) {
                                        if ($buyerQuestionnaire->joint_cowners == config('constant.inverse_common_yes_no.Yes')) {
                                            ?>
                                                   checked="checked" <?php
                                               }
                                           }
                                           ?> required>
                                    <label for="yes-radio-btn" class='label-yes'>Yes</label>
                                    <input type="radio" name='add_signer' value="{{config('constant.inverse_common_yes_no.No')}}" id='no-radio-btn'
                                    <?php
                                    if ($buyerQuestionnaire) {
                                        if ($buyerQuestionnaire->joint_cowners == config('constant.inverse_common_yes_no.No')) {
                                            ?>
                                                   checked="checked" <?php
                                               }
                                           }
                                           ?> >
                                    <label for="no-radio-btn" class='label-yes'>No</label>
                                    <div class="error-validations form-group">
                                        <label class="error" id="add_signer-error" for="add_signer"></label>
                                    </div>
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
                            
                                if (!empty($buyerQuestionnaire->partners)) {
                                    $selectedEmails = explode(',',
                                        $buyerQuestionnaire->partners);
                                }
                           
                            ?>
                            <div class="select-box-div show-yes-radio-btn">
                                <?php //echo'<pre>';print_r($signers);die;?>
                                <select name="select-email[]" id="select-email" multiple="multiple" required>
                                    @if( isset($signers))
                                    @foreach($signers as $signer)
                                    <option value="{{ $signer->invited_users->id }}" <?php if(isset($selectedEmails)){
                                        foreach($selectedEmails as $email) {
                                            if($email == $signer->invited_users->id){ ?>
                                            selected="selected"
                                    <?php }}} ?> >{{ $signer->invited_users->email }}</option>
                                    @endforeach
                                    @elseif( isset($selectedEmails) )
                                    @foreach($selectedEmails as $selectedEmail)
                                    <option value="{{ $selectedEmail }}" selected="selected"><?php echo findSigner($selectedEmail); ?></option>
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
                                <span>Be advised, it is recommended that the 'Co-signers confirm their account & information as soon as possible, to prevent inaccurate contract information.</span>
                                {{ html()->form('POST', route('frontend.signer.store'))->id('addSigner')->class('form-horizontal')->open() }}
                                <div id="usersignup-form">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label for="inputEmail3" class="control-label">Name</label>
                                            <input type="text" class="form-control" data-rule-required="true" placeholder="Please enter the Name" data-rule-minlength="2" id="signer_name" name="signer_name" aria-required="true" required>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js"></script>
<script>
$(document).ready(function () {
//   $('.ownership-interest-additional-required-signers-text').hide

    $('form').validate({
        messages: {
            addendum: "Please select anyone option",
            using_VA_or_FHA: "Please select anyone option",
            set_specific_date: "Please select anyone option",
            close_date: "Please enter date of closing",
            date_of_expiry: "Please enter the date of expiry",
            add_signer: "Please select anyone option"
        }
    });

    if ($('#specific_dateyes').is(":checked")) {
        $("#specific_date").show();
    }
    if ($('#set_specific_dateyes').is(":checked")) {
        $("#set_specific_date").show();
    }

    $("#specific_dateyes").click(function () {
        $('#specific_date').show();
    });
    $("#specific_dateno").click(function () {
        $('#specific_date').hide();
        $('#datepicker1').val('');
        $('#specific_date_no').show();
    });

    $("#set_specific_dateyes").click(function () {
        $('#set_specific_date').show();
    });
    $("#set_specific_dateno").click(function () {
        $('#set_specific_date').hide();
        $('#datepicker2').val('');
        $('#set_specific_date_no').show();
    });
    /*end*/

    /*add_signers_contract_sale_buyer*/

    $("#question-signer-submit").click(function () {
        $("#question-signer-action").submit();
    });
    $(".show-yes-radio-btn").hide();
    $(document).on('click', '.btn-nxt-submit', function () {
        form = $('#question-signer-action input, textarea,select');
        form.validate();
        if (form.valid() === true) {
            $('#question-buyer-step1').hide();
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
    if($("#no-radio-btn").is(':checked')) {
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
        $(".add-signers-form").toggle();
    });
    $(".btn-cancel").click(function () {
        $(".add-signers-form").hide();
    });

    $("#newSigner").click(function (e) {
        e.preventDefault();
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
                last_name: lastname
            },
            url: "{{route('frontend.contractToolSigner')}}",
            success: function (data) {
                 swal("Success", 'Signer added successfully!', "success");
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
    $("#datepicker1").datepicker({
        format: "yyyy-mm-dd",
        startDate: new Date()
    });
    $('#datepicker2').datepicker({
        format: "yyyy-mm-dd",
        startDate: new Date()
    });
});
</script>
@endsection