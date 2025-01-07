@extends ('frontend.layouts.app')
@section ('title', ('Make Sale Offer'))
@section('after-styles')
<link type="text/css" rel="stylesheet" href="{{ asset(mix('css/contract-tools-buyer.css')) }}" media="all"> 
@endsection
@section('content')
<div class="container purchase-sale-agreement-review contract-tools-seller-common register-page">   
    <div class="">
        <div class="row content">
            @include('frontend.includes.sidebar')           
            <div class="col-md-9 col-sm-8"> 
                <div class="nested-div">
                    <div class="heading-text">
                        <h2>Make an Offer (Sale)</h2>
                    </div>
                    <div class="row para-text">
                        {{ html()->form('POST', route('frontend.make.offer.save'))->class('form')->acceptsFiles()->open() }}
                        
                        <input type="hidden" value="{{$id}}" name="property_id">
                        <input type="hidden" value="Sale" name="type">
                        <div class="form-group">
                            <div class="col-sm-12">
                                <h4 class="first-child">Tentative Offer Price:</h4>                                
                                <input type="number" class="form-control" id="tentative_offer_price" data-rule-required="true" data-msg-required="Please enter the tentative offer price" data-rule-number="true" data-msg-number="Please enter valid price" data-rule-digits="true" data-msg-digits="Please only enter numbers!" class="form-control" name="tentative_offer_price">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-12">
                                <h5>Any Closing Cost Assistance Requested?</h5>

                                <input type="radio" class="makeofferradio closing_cost" id="chkYes" name="closing_cost_requested" value="{{ config('constant.closing_cost_requested.1') }}">
                                <label for="chkYes">Yes</label>

                                <input type="radio" id="chkNo" class="makeofferradio closing_cost" id="inlineRadio2" name="closing_cost_requested" value="{{ config('constant.closing_cost_requested.0') }}">
                                <label for="chkNo">No</label>
                            </div><!--col-md-12-->
                        </div>

                        <div id="cost" style="display: none">
                            <div class="form-group">
                                <p class="col-sm-12">If requesting Closing Cost Assistance, What is the amount requested?</p>
                            </div>
                            <div class="form-group">
                                <h5 class="col-sm-12">Percentage of Price</h5>
                                <div class="col-sm-12">
                                    <input style="margin-bottom: 2px;"  type="number" data-rule-notboth="input[name=&quot;fixed_amount&quot;]" data-msg-notboth="Please enter Percentage of Price or Fixed $ Amount only, do not fill out both fields" id="percentage_of_price" class="form-control span8" name="percentage_of_price">
                                </div>
                                <p class="col-sm-12 offer-text">(Usually &lt; 1%)</p>
                            </div>

                            <div class="form-group text-center">
                                <h5 class="col-sm-12">OR</h5>
                            </div>
                            <div class="form-group">
                                <h5 class="col-sm-12">Fixed $ Amount</h5>
                                <div class="col-sm-12">
                                    <input style="margin-bottom: 2px;"  type="number" id="fixed_amount" data-rule-notboth="input[name=&quot;percentage_of_price&quot;]" data-msg-notboth="Please enter Percentage of Price or Fixed $ Amount only, do not fill out both fields" class="form-control ps span8" name="fixed_amount">
                                </div>
                                <p for="fixed_amount" class="col-sm-12 offer-text">(Usually &lt; 1% of Selling Price)</p>
                            </div>    
                        </div> 
                        @if(count($errors->get('percentage_of_price')) > 0 || count($errors->get('fixed_amount')) > 0)
                        <span class="backend-errors alert-danger">{{ $errors->first('percentage_of_price') }}</span>
                        @endif
                        <div class="form-group">
                            <p class="col-sm-12 offer-text">Closing Cost Assistance may be requested by Buyers to offset the administrative fees at Closing (Upon Ownership Transfer). Helpful Hint! - Asking for Closing Cost Assistance is essentially reducing your offer
                                price.</p>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12">
                                <h5>Any Contingencies?</h5>
                                <input type="radio" class="makeofferradio any_cont" id="contingenciesyes" value="{{ config('constant.any_contingencies.1') }}" name="any_contingencies">
                                <label for="contingenciesyes">Yes</label>
                                <input type="radio" class="makeofferradio any_cont" id="contingenciesNo" value="{{ config('constant.any_contingencies.0') }}" name="any_contingencies">
                                <label for="contingenciesNo">No</label>
                            </div><!--col-md-12-->
                        </div>     
                        <div id="contingencies" style="display:none;">
                            <div class="form-group">
                                <label class="col-sm-12">If Yes, Please Explain:</label>
                                <div class="col-sm-12">
                                    <textarea type="text" rows="12" id="contingencies_explain" class="form-control text-height" name="contingencies_explain"></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-12">
                            <div class="form-group">                             
                                <p> Contingencies are special contract requirements which need to be met in order for this transaction to be completed. Helpful Hint! –If you require bank financing and are not currently pre-qualified for a loan, you should speak with a lender before entering any contracts for real estate!</p>
                            </div>
                        </div>

                        <div class="form-group">
                            <h4  class="col-sm-12">Please confirm your Loan Status:</h4>
                            <h5  class="col-sm-12 offer-text">My loan status is currently:</h5>
                        </div>
                        <div class="qualification_doc_part">
                            <div id="pre-not-approved">
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <input type="radio" id="filesYes" class="makeofferradio" value="{{ config('constant.qualification_documents.1') }}" name="qualification_documents">
                                        <label for="filesYes">Pre-Qualified </label></br>
                                        <p class="offer-text">Income and credit is verified by a lending institution!</p>
                                    </div><!--col-md-12-->
                                </div>

                                <div id="files" style="display: none;"  class="form-group">
                                    <label  class="col-sm-12 offer-text">Attach your Qualification Document received from your Loan Officer:</label>
                                    <div class="col-sm-12">
                                        <div class="form-control">
                                        <input class="files" id="userfile-doc" type="file" name="userfile1">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-12">
                                        <input type="radio" id="Pre-Approved" class="makeofferradio" value="{{ config('constant.qualification_documents.2') }}" name="qualification_documents">
                                        <label for="Pre-Approved">Pre-Approved</label></br>
                                        <p class="offer-text">Submitted verbal information to a loan officer, but income and credit is not verified.</p>
                                    </div><!--col-md-12-->
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-12">
                                    <input type="radio" id="notApproved" class="makeofferradio" value="{{ config('constant.qualification_documents.3') }}" name="qualification_documents">
                                    <label for="notApproved">Not Approved</label>
                                </div><!--col-md-12-->
                            </div>
                            <div class="form-group">
                                <div class="col-md-12">
                                    <input type="radio" id="cashYes" class="makeofferradio" value="{{ config('constant.qualification_documents.4') }}" name="qualification_documents">
                                    <label for="cashYes">Cash Buyer</label>
                                </div><!--col-md-12-->
                            </div>
                            <div id="cash" style="display: none;" class="form-group">
                                <label class="col-sm-12">Source of Cash:</label>
                                <div class="col-sm-12">
                                    <input type="text" id="document-title-input" class="form-control" name="source_of_cash">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <p class="col-sm-12 offer-text"><b>Helpful Hint! –</b>If you require bank financing and are not currently pre-qualified for a loan, you should speak with a lender before entering any contracts for real estate!</p>
                        </div>
                        <div class="form-group">
                            <h5 class="col-sm-12">Optional Message to Seller:</h5>
                            <div class="col-sm-12">
                                <textarea type="text" rows="4" id="optional_message" class="form-control text-height" name="optional_message"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <p class="col-sm-12 offer-text"><b>This tentative offer is <span>non-binding</span> and <span>unenforceable</span>. This form serves to engage a potential buyer and seller in preparation for entering into an agreement, and <span>does not constitute an official offer</span>.</b> You will have the option to enter into an official contract using our contract Tools upon agreement of terms!</p>
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
                                <button type="reset"  class="button btn btn-blue reset">Reset</button>
                            </div>
                        </div>
                        {{ html()->form()->close() }}
                        <!--</form>-->
                    </div>                   
                </div><!--</nested-div>-->
            </div><!--</col>-->
        </div><!--</content>-->
    </div><!--</container>-->
</div><!--</contract-tools-seller-common>-->
@endsection
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
@section('after-scripts')
<script>
$(document).ready(function () {

    $("#percentage_of_price, #fixed_amount").keyup(function (e) {
        var otherField = e.target.id == 'fixed_amount' ? 'percentage_of_price' : 'fixed_amount';
        if ($('#' + otherField).val() != '')
            $('#' + e.target.id).val("");
        $('form').valid();
    });
    
    $('.reset').on('click',function(e){
        e.preventDefault();
        $('form')[0].reset();
    });

    $('form').validate({
        rules: {
            closing_cost_requested: {
                required: true
            },
            agree: {
                required: true
            },
            percentage_of_price: {
                required: function (element) {
                    return $("#fixed_amount").val() == '' ? true : false;
                }
            },
            fixed_amount: {
                required: function (element) {
                    return $("#percentage_of_price").val() == '' ? true : false;
                }
            },
            any_contingencies: {
                required: true
            },
            contingencies_explain: {
                required: function (element) {
                    if ($('.any_cont').is(':checked')) {
                        return true;
                    } else {
                        return false;
                    }
                }
            },
            qualification_documents: {
                required: true
            },
            source_of_cash: {
                required: function (element) {
                    if ($('#cashYes').is(':checked')) {
                        return true;
                    } else {
                        return false;
                    }
                }
            }
        },
        messages: {
            closing_cost_requested: "Please select any one option",
            any_contingencies: "Please select any one option",
            qualification_documents: "Please select any one option",
            percentage_of_price: "Either fill this",
            fixed_amount: "Or this"
        },
        errorPlacement: function (error, element)
        {
            if (element.is(":radio") && element.attr("name") === "qualification_documents") {
                error.insertAfter(".qualification_doc_part");
                error.css("padding-left", "15px");
            } else if (element.is(":radio"))
            {
                error.appendTo(element.parents('.form-group'));
                error.css("padding-left", "15px");
            } else if (element.is(":checkbox")) {
                error.appendTo(element.parents('.form-group'));
                error.css("padding-left", "15px");
            } else
            { // This is the default behavior 
                error.insertAfter(element);
            }
        }
    });

    $("form").submit(function (e) {
        $('#inputbutton').prop('disabled');
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

    $("input[name='closing_cost_requested']").click(function () {
        if ($("#chkYes").is(":checked")) {
            $("#cost").show();
        } else {
            $("#cost").hide();
        }
    });

    $("#chkNo").click(function () {
        $("#cost input").val('');
    });

    $("#contingenciesNo").click(function () {
        $("#contingencies_explain").val('');
    });

    $("input[name='qualification_documents']").click(function () {
        if ($("#cashYes").is(":checked")) {
            $("#cash").show();
        } else {
            $("#cash").hide();
        }
    });
    $("input[name='any_contingencies']").click(function () {
        if ($("#contingenciesyes").is(":checked")) {
            $("#contingencies").show();
        } else {
            $("#contingencies").hide();
        }
    });
    $("#filesYes").click(function () {
        $("#document-title-input").val("");
        $("#files").show();
    });
    $("#Pre-Approved").click(function () {
        $("#document-title-input").val("");
        $("#files").show();
    });
    $("#notApproved").click(function () {
        $("#document-title-input").val("");
        $("#userfile-doc").val("");
        $("#files").hide();
    });
    $("#cashYes").click(function () {
        $("#userfile-doc").val("");
        $("#files").hide();
    });
    
});


</script>
@endsection