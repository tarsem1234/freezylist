@extends ('frontend.layouts.app')
@section ('title', ('Questions To Seller Property'))
@section('after-styles')
<link type="text/css" rel="stylesheet" href="{{ asset(mix('css/contract_tools.css')) }}" media="all"> 
@endsection
@section('content')
<div class="container purchase-sale-agreement-review contract-tools-seller-common register-page">
   <div class="row">
      <div class=""> 
         <div class="sidebar">
            @include('frontend.includes.sidebar')
         </div>
         <div class="col-md-9 col-sm-8">
            <div class="nested-div">
               <div class="heading-text">
                  <h2>Step 3(a) of 6 : Post-Closing Occupancy Questionnaire</h2>
               </div>
               {{ html()->form('POST', route('frontend.saveQuestionSellerPostClosing'))->attribute('role', 'form')->open() }}
               <div class="form-group para-text">
                  <h5 class="first-child">1. What is your current Mortgage Payment per month on this property?</h5>
                  <input type="number" class="form-control" value="{{$questionSellerPostClosing->current_mortgage??""}}" id="text-form-input" data-rule-required="true" data-rule-digits="true" data-msg-required="Please enter the current mortgage" name="current_mortgage" aria-required="true">
                  @if(count($errors->get('current_mortgage')) > 0)
                  <span class="text text-danger">{{implode('<br>', $errors->get('current_mortgage'))}}</span>
                  @endif
                  <p>(Our calculation will take your current Mortgage Payment and divide by 30 days to reach a $ Rent per Day. [Please refer to the amount populated in Item "7" in the post-closing occupancy agreement])</p>
               </div>
               <div class="form-group para-text btn-radio">
                  <h5>2.  Do you agree to be charged an additional 25% per day for each day you hold the property above the specified time period?</h5 >
                  <input type="radio" id="additional_charge" <?php if(isset($questionSellerPostClosing) && $questionSellerPostClosing->additional_charge == config('constant.inverse_common_yes_no.Yes')){ ?>
                         checked="checked"
                  <?php } ?> value="{{ config('constant.inverse_common_yes_no.Yes' )}}" name="additional_charge" data-rule-required="true" data-msg-required="Please select the option" aria-required="true">
                  <label for="additional_charge"><p class="m-zero">Yes</p></label>
                  <input type="radio" id="charge_no" <?php if(isset($questionSellerPostClosing) && $questionSellerPostClosing->additional_charge == config('constant.inverse_common_yes_no.No' )){ ?>
                         checked="checked"
                  <?php } ?> value="{{ config('constant.inverse_common_yes_no.No' )}}" name="additional_charge" data-rule-required="true" data-msg-required="Please select anyone option" aria-required="true">
                  <label for="charge_no"><p class="m-zero">No</p></label>
                  @if(count($errors->get('additional_charge')) > 0)
                  <span class="text text-danger">{{implode('<br>', $errors->get('additional_charge'))}}</span>
                  @endif
                  <p>(Our calculation will apply an additional 0% or 25% to the daily rate, dependent upon your answer. [Please refer to the amount populated in Item "8" in the post-closing occupancy agreement])</p>
               </div>

               <div class="form-group para-text btn-radio">
                  <h5>3. Do you agree to place a refundable security deposit of 1.5 x the monthly rent amount?</h5>
                  <input type="radio" name="refundable_security" <?php if(isset($questionSellerPostClosing) && $questionSellerPostClosing->refundable_security == config('constant.inverse_common_yes_no.Yes' )){ ?>
                         checked="checked"
                  <?php } ?> id="refundable_security" data-rule-required="true" data-msg-required="Please select anyone option" value="{{ config('constant.inverse_common_yes_no.Yes' )}}" aria-required="true">
                  <label for="refundable_security"><p class="m-zero">Yes</p></label>
                  <input type="radio" name="refundable_security" <?php if(isset($questionSellerPostClosing) && $questionSellerPostClosing->refundable_security == config('constant.inverse_common_yes_no.No' )){ ?>
                         checked="checked"
                  <?php } ?> id="refundable_security_no" data-rule-required="true" data-msg-required="Please select anyone option" value="{{ config('constant.inverse_common_yes_no.No' )}}" aria-required="true">
                  <label for="refundable_security_no"><p class="m-zero">No</p></label>
                  @if(count($errors->get('refundable_security')) > 0)
                  <span class="text text-danger">{{implode('<br>', $errors->get('refundable_security'))}}</span>
                  @endif
                  <p>(Our calculation will apply an additional 0% or 25% to the daily rate, dependent upon your answer. [Please refer to the amount populated in Item "8" in the post-closing occupancy agreement])(The Buyer will require a refundable security deposit to cover damages to the property during your (The Seller) post occupancy period. Our calculation will multiply your current mortgage payment by 100% or 150%, dependent upon your answer. [Please refer to the amount populated in Item "12" in the post-closing occupancy agreement])</p>
               </div>

               <div class="form-group para-text btn-radio">
                  <h5>4. If you vacate the property prior to the date specified in the contract, may the Buyer retain the unearned rents?</h5>
                  <input type="radio" name="unearned_rents" id="unearned_rents" <?php if(isset($questionSellerPostClosing) && $questionSellerPostClosing->unearned_rents == config('constant.inverse_common_yes_no.Yes' )){ ?>
                         checked="checked"
                  <?php } ?> data-rule-required="true" data-msg-required="Please select anyone option" value="{{ config('constant.inverse_common_yes_no.Yes' )}}" aria-required="true">
                  <label for="unearned_rents"><p class="m-zero">Yes</p></label>
                  <input type="radio" name="unearned_rents" id="unearned_rents_no" <?php if(isset($questionSellerPostClosing) && $questionSellerPostClosing->unearned_rents == config('constant.inverse_common_yes_no.No' )){ ?>
                         checked="checked"
                  <?php } ?> data-rule-required="true" data-msg-required="Please select anyone option" value="{{ config('constant.inverse_common_yes_no.No' )}}" aria-required="true">
                  <label for="unearned_rents_no"><p class="m-zero">No</p></label>
                  @if(count($errors->get('unearned_rents')) > 0)
                  <span class="text text-danger">{{implode('<br>', $errors->get('unearned_rents'))}}</span>
                  @endif
               </div>

               <div class="form-group para-text btn-radio">
                  <h5>5. Do you consent to pay the utilities during your period of post-occupancy (Water/Sewer/Electric/Gas)?</h5 >
                  <input type="radio" name="utilities" id="utilities" data-rule-required="true" <?php if(isset($questionSellerPostClosing) && $questionSellerPostClosing->utilities == config('constant.inverse_common_yes_no.Yes' )){ ?>
                         checked="checked"
                  <?php } ?> data-msg-required="Please select anyone option" value="{{ config('constant.inverse_common_yes_no.Yes' )}}" aria-required="true">
                  <label for="utilities">
                      <p class="m-zero">Yes</p>
                  </label>
                  <input type="radio" name="utilities" id="utilities_no" data-rule-required="true" <?php if(isset($questionSellerPostClosing) && $questionSellerPostClosing->utilities == config('constant.inverse_common_yes_no.No' )){ ?>
                         checked="checked"
                  <?php } ?> data-msg-required="Please select anyone option" value="{{ config('constant.inverse_common_yes_no.No' )}}" aria-required="true">
                  <label for="utilities_no">
                      <p class="m-zero">No</p>
                  </label>
                  @if(count($errors->get('utilities')) > 0)
                  <span class="text text-danger">{{implode('<br>', $errors->get('utilities'))}}</span>
                  @endif
               </div>

               <div class="form-group para-text btn-radio">
                  <h5 >6. Will you (The Seller) purchase a renter's policy to cover your personal property?</h5 >
                  <input type="radio" name="renter_policy" id="renter_policy" data-rule-required="true" <?php if(isset($questionSellerPostClosing) && $questionSellerPostClosing->renter_policy == config('constant.inverse_common_yes_no.Yes' )){ ?>
                         checked="checked"
                  <?php } ?> data-msg-required="Please select anyone option" value="{{ config('constant.inverse_common_yes_no.Yes' )}}" aria-required="true">
                  <label for="renter_policy">
                      <p class="m-zero">Yes</p>
                  </label>
                  <input type="radio" name="renter_policy" id="renter_policy_no" <?php if(isset($questionSellerPostClosing) && $questionSellerPostClosing->renter_policy == config('constant.inverse_common_yes_no.No' )){ ?>
                         checked="checked"
                  <?php } ?> data-rule-required="true" data-msg-required="Please select anyone option" value="{{ config('constant.inverse_common_yes_no.No' )}}" aria-required="true">
                  <label for="renter_policy_no">
                      <p class="m-zero">No</p>
                  </label>
                  @if(count($errors->get('renter_policy')) > 0)
                  <span class="text text-danger">{{implode('<br>', $errors->get('renter_policy'))}}</span>
                  @endif
                  <p>(Your personal property will not be protected under the Buyer's Home-Owners Insurance policy- Not required)</p>
               </div>
               <div class="form-group para-text btn-radio">
                  <h5>7. Will you (The Seller) purchase a liability insurance policy to cover damage to the property during your period of post-occupancy? </h5>
                  <input type="radio" name="liability_insurance" id="liability_insurance" <?php if(isset($questionSellerPostClosing) && $questionSellerPostClosing->liability_insurance == config('constant.inverse_common_yes_no.Yes' )){ ?>
                         checked="checked"
                  <?php } ?> data-rule-required="true" data-msg-required="Please select anyone option" value="{{ config('constant.inverse_common_yes_no.Yes' )}}" aria-required="true">
                  <label for="liability_insurance"><p class="m-zero">Yes</p></label>
                  <input type="radio" name="liability_insurance" id="liability_insurance_no" <?php if(isset($questionSellerPostClosing) && $questionSellerPostClosing->liability_insurance == config('constant.inverse_common_yes_no.No' )){ ?>
                         checked="checked"
                  <?php } ?> data-rule-required="true" data-msg-required="Please select anyone option" value="{{ config('constant.inverse_common_yes_no.No' )}}" aria-required="true">
                  <label for="liability_insurance_no"><p class="m-zero">No</p></label>
                  @if(count($errors->get('liability_insurance')) > 0)
                  <span class="text text-danger">{{implode('<br>', $errors->get('liability_insurance'))}}</span>
                  @endif
                  <p>(This protects both yourself and the seller against damage to the property, which you (The Seller) will be personally liable for- Not required)</p>
               </div>
               <div class="form-group btns-green-blue btns-text-align-right">
                  <input type="submit" class="btn button btn-blue" name="submit" value="Next">
               </div>
               {{ html()->form()->close() }}
            </div>
         </div>
      </div><!--</col>-->
   </div><!--</row>-->
</div><!--</contract-tools-seller-common>-->
@endsection
@section('after-scripts')
<script>
   $(document).ready(function () {
      $('form').validate({
         errorPlacement: function (error, element) {
            if (element.is(":radio"))
            {
               error.appendTo(element.parents('.btn-radio'));
            } else
            {
               error.insertAfter(element);
            }
         }
      });
   });
</script>
@endsection