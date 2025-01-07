@extends ('frontend.layouts.app')
@section ('title', ('Lead-Based Paint Hazards'))
@section('after-styles')
<link type="text/css" rel="stylesheet" href="{{ asset(mix('css/contract-tools-buyer.css')) }}" media="all">
@endsection
@section('content')
<div class="container purchase-sale-agreement-review contract-tools-seller-common register-page ">
   <div class="row">
      <div class="">
         <div class="sidebar">
            @include('frontend.includes.sidebar')
         </div>
         <div class="col-md-9 col-sm-8">
            <div class="nested-div register-page">
               <div class="heading-text">
                  <h2>STEP 3 OF 6: Lead-Based Paint Hazards</h2>
               </div>
               <div class="para-text row">
                  <div class="form-group">
                     <div class="col-md-12">
                        <h4 class="first-child">1. Lead Warning Statement</h4><p>Every purchaser of any interest in residential real property on which a residential dwelling was built prior to 1978 is notified that such property may present exposure to lead from lead-based paint that may place young children at risk of developing lead poisoning. Lead poisoning in young children may produce permanent neurological damage, including learning disabilities, reduced intelligence quotient, behavioral problems, and impaired memory. Lead poisoning also poses a particular risk to pregnant women. The seller of any interest in residential real property is required to provide the buyer with any information on lead-based paint hazards from risk assessments or inspections in the seller's possession and notify the buyer of any known lead-based paint hazards. A risk assessment or inspection for possible lead-based paint hazards is recommended prior to purchase.<br>
                           <i><b>Please note seller's disclosure obligations under 42 U.S.C. 4852d.</b></i></p>
                     </div><!--col-md-12-->
                  </div>
                  <div class="form-group para-text">
                      @if(isset($property) && $property)
                     <div class="col-md-12">
                        <h5>2.Seller's/Lessor's Disclosure </h5>
                        <h5>a. Presence of lead-based paint and/or lead-based paint hazards below:</h5>
                        <input type="radio" name="lead_based" id="lead_based" <?php if (isset($offer->lead_based) && ($offer->lead_based) == config('constant.inverse_common_yes_no.Yes')) { ?>
                               checked="checked"
                               <?php } ?> <?php if(isset($offer) && $offer->sender_id == Auth::id()) {  ?> disabled="disabled" <?php } ?>  value="{{config('constant.inverse_common_yes_no.Yes')}}">
                        <label for="lead_based">Known lead-based paint and/or lead-based paint hazards are present in the housing.</label>
                        <input type="radio" name="lead_based" id="lead_based-no" <?php if (isset($offer->lead_based) && ($offer->lead_based) == config('constant.inverse_common_yes_no.No')) { ?>
                                  checked="checked"
                               <?php } ?> <?php if(isset($offer) && $offer->sender_id == Auth::id()) {  ?> disabled="disabled" <?php } ?>  value="{{config('constant.inverse_common_yes_no.No')}}">
                        <label for="lead_based-no">Seller has no knowledge of lead-based paint and/or lead-based paint hazards in the housing.</label>
                        <h5>b. Records and reports available to the seller below:</h5>
                        <input type="radio" name="lead_based_report" id="lead_based_report" <?php if (isset($offer->lead_based_report) && ($offer->lead_based_report) == config('constant.inverse_common_yes_no.Yes')) { ?>
                                  checked="checked"
                               <?php } ?>  <?php if(isset($offer) && $offer->sender_id == Auth::id()) {  ?> disabled="disabled" <?php } ?>  value="{{config('constant.inverse_common_yes_no.Yes')}}">
                        <label for="lead_based_report">Seller has provided the purchaser with all available records and reports pertaining to lead-based paint and/or lead-based paint hazards in the housing (list documents below).Known lead-based paint and/or lead-based paint hazards are present in the housing.</label>
                        <input type="radio" name="lead_based_report" id="lead_based_report-no" <?php if (isset($offer->lead_based_report) && ($offer->lead_based_report) == config('constant.inverse_common_yes_no.No')) { ?>
                                  checked="checked"
                               <?php } ?> <?php if(isset($offer) && $offer->sender_id == Auth::id()) {  ?> disabled="disabled" <?php } ?>  value="{{config('constant.inverse_common_yes_no.No')}}">
                        <label for="lead_based_report-no">Seller has no reports or records pertaining to lead-based paint and/or lead-based paint hazards in the housing.</label>
                     </div>
                      @else
                     <div class="col-md-12">
                        <h5>2.Seller's/Lessor's Disclosure </h5>
                        <h5>a. Presence of lead-based paint and/or lead-based paint hazards below:</h5>
                        <input type="radio" name="lead_based" id="lead_based" <?php if (isset($offer->property->lead_based) && ($offer->property->lead_based) == config('constant.inverse_common_yes_no.Yes')) { ?>
                               checked="checked"
                               <?php } ?> <?php if(isset($offer) && $offer->sender_id == Auth::id()) {  ?> disabled="disabled" <?php } ?>  value="{{config('constant.inverse_common_yes_no.Yes')}}">
                        <label for="lead_based">Known lead-based paint and/or lead-based paint hazards are present in the housing.</label>
                        <input type="radio" name="lead_based" id="lead_based-no" <?php if (isset($offer->property->lead_based) && ($offer->property->lead_based) == config('constant.inverse_common_yes_no.No')) { ?>
                                  checked="checked"
                               <?php } ?> <?php if(isset($offer) && $offer->sender_id == Auth::id()) {  ?> disabled="disabled" <?php } ?>  value="{{config('constant.inverse_common_yes_no.No')}}">
                        <label for="lead_based-no">Seller has no knowledge of lead-based paint and/or lead-based paint hazards in the housing.</label>
                        <h5>b. Records and reports available to the seller below:</h5>
                        <input type="radio" name="lead_based_report" id="lead_based_report" <?php if (isset($offer->property->lead_based_report) && ($offer->property->lead_based_report) == config('constant.inverse_common_yes_no.Yes')) { ?>
                                  checked="checked"
                               <?php } ?>  <?php if(isset($offer) && $offer->sender_id == Auth::id()) {  ?> disabled="disabled" <?php } ?>  value="{{config('constant.inverse_common_yes_no.Yes')}}">
                        <label for="lead_based_report">Seller has provided the purchaser with all available records and reports pertaining to lead-based paint and/or lead-based paint hazards in the housing (list documents below).Known lead-based paint and/or lead-based paint hazards are present in the housing.</label>
                        <input type="radio" name="lead_based_report" id="lead_based_report-no" <?php if (isset($offer->property->lead_based_report) && ($offer->property->lead_based_report) == config('constant.inverse_common_yes_no.No')) { ?>
                                  checked="checked"
                               <?php } ?> <?php if(isset($offer) && $offer->sender_id == Auth::id()) {  ?> disabled="disabled" <?php } ?>  value="{{config('constant.inverse_common_yes_no.No')}}">
                        <label for="lead_based_report-no">Seller has no reports or records pertaining to lead-based paint and/or lead-based paint hazards in the housing.</label>
                     </div>
                      @endif
                  </div><!--col-md-12-->
             @if(isset($offer) && $offer->sender_id == Auth::id())
            {{ html()->form('POST', route('frontend.saveLeadBasedPaintHazardsBuyer'))->attribute('role', 'form')->open() }}
            @endif
            <div class="form-group" style="width: 100%;float: left">
                     <div class="col-md-12">
                        <h5>3.Purchaser's/Lessee's Acknowledgment (initial) </h5>
                        <h5>c. Seller/Lessor hereby provides the Buyer/Lessee with the EPA's Lead Based Paint Pamphlet Here:<a href="{{asset('storage/pdf/Lead_Based_Paint_Disclosure.pdf')}}" target="_blank"> "Lead Based Paint Disclosure Pamphlet".</a> </h5>
                        <p class="mar-zero"> Adobe Reader may be required to view this form- you may download a free version here:<a href="https://get.adobe.com/reader/otherversions/"> "Download Adobe Reader".</a> </p>
                     </div><!--col-md-12--> 
                     <div class="error_checkbox_message">
                     <div class="col-md-12 clearfix">
                        <div class="checkbox">
                            <?php if(isset($offer->epa) && $offer->epa) { $epas = explode(',',$offer->epa); } ?>
                           <input type="checkbox" class="styled-checkbox" name="epa[]" id="read-epa" <?php
                           if(isset($offer->epa) && $offer->epa){
                               foreach($epas as $epa){
                           if($epa == config('constant.inverse_epa.readepa')){ ?>
                                  checked="checked"
                               <?php }
                           } }
                           ?> value="{{config('constant.inverse_epa.readepa')}}" <?php if(isset($offer) && $offer->sender_id != Auth::id()) {  ?> disabled="disabled" <?php } ?> >
                           <label for="read-epa">I have read the EPA's "Lead Based Paint Disclosure Pamphlet" </label>
                        </div>
                     </div><!--col-md-12-->
                     <div class="col-md-12">
                        <div class="checkbox clearfix">
                            <input type="checkbox" class="styled-checkbox" name="epa[]" id="received-copies" <?php
                           if(isset($offer->epa) && $offer->epa){
                               foreach($epas as $epa){
                           if($epa == config('constant.inverse_epa.receivedcopies')){ ?>
                                  checked="checked"
                               <?php }
                           } }
                           ?> value="{{config('constant.inverse_epa.receivedcopies')}}" <?php if(isset($offer) && $offer->sender_id != Auth::id()) {  ?> disabled="disabled" <?php } ?> >
                           <label for="received-copies">Purchaser has received copies of all information from the seller/lessor listed above. </label>
                        </div>
                     </div><!--col-md-12-->
                     </div>
                  </div>
                  <div class="form-group clearfix custom_checkbox_message" style="width: 100%;float: left">
                     <div class="col-md-12">
                        <h5 class="first-child">d. Purchaser has check below:</h5>
                        <input type="radio" name="opportunity" id="opportunityDay" <?php
                           if(isset($offer->opportunity) && $offer->opportunity && $offer->opportunity == config('constant.inverse_lead_opportunity.10-day opportunity')){ ?>
                                  checked="checked"
                               <?php
                           }
                           ?> value="{{config('constant.inverse_lead_opportunity.10-day opportunity')}}" <?php if(isset($offer) && $offer->sender_id != Auth::id()) {  ?> disabled="disabled" <?php } ?> >
                        <label for="opportunityDay">Received a 10-day opportunity (or mutually agreed upon period) to conduct a risk assess-ment or inspection for the presence of lead-based paint and/or lead-based paint hazards; or</label>
                        <input type="radio" name="opportunity" id="opportunityWaived" <?php
                           if(isset($offer->opportunity) && $offer->opportunity && $offer->opportunity == config('constant.inverse_lead_opportunity.Waived the opportunity')){ ?>
                                  checked="checked"
                               <?php
                           }
                           ?> value="{{config('constant.inverse_lead_opportunity.Waived the opportunity')}}" <?php if(isset($offer) && $offer->sender_id != Auth::id()) {  ?> disabled="disabled" <?php } ?> >
                        <label for="opportunityWaived">Waived the opportunity to conduct a risk assessment or inspection for the presence of lead-based paint and/or lead-based paint hazards.</label>
                     </div><!--col-md-12-->
                  </div>

                  <div class="form-group">
                     <div class="col-md-12">
                        <h5>4. Certification of Accuracy</h5><p>The following parties have reviewed the information above and certify, to the best of their knowledge, that the information they have provided is true and accurate.</p>
                     </div><!--col-md-12-->
                  </div>
                  <div class="btns-green-blue col-lg-12">
                     <button type="submit" class="button btn btn-green">Submit</button>
                     <a id="lead-based-reset-btn" class="button btn btn-blue">Reset</a>
                  </div><!--</btns-green-blue>-->
               </div>
            </div>
            @if(isset($offer) && $offer->sender_id == Auth::id())
            {{ html()->form()->close() }}
            @endif
         </div><!--</col>-->
      </div><!--</col>-->
   </div><!--</row>-->
</div><!--</contract-tools-seller-common>-->
@endsection
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
@section('after-scripts')
<script>
$(document).ready(function () {
     $('form').validate({
        rules: {
            "opportunity": {
                required: true,
            },
            "epa[]": {
                  required: true,
            }
        },
        messages: {
            "opportunity": "Please select anyone option",
            "epa[]": "Please select anyone option"
        },
        errorPlacement: function (error, element) {
            
            if (element.is(":radio"))
            {
                error.appendTo(element.parents('.custom_checkbox_message'));
                error.css("padding-left", "15px");
            } 
            else if (element.is(":checkbox")) {
                error.appendTo(element.parents('.error_checkbox_message'));
                error.css("padding-left", "15px");
            } 
            else
            {
                error.insertAfter(element);
            }
        }
    });
       $('#lead-based-reset-btn').on('click',function(e){
        e.preventDefault();
        $('form')[0].reset();
	$('input:checkbox').removeAttr('checked');
	$('input:radio').removeAttr('checked');
    });
});
</script>
@endsection