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
                        <h2>Lead-Based Paint Hazards</h2>
                    </div>
                    <div class="para-text row">
                        <div class="form-group">
                            <div class="col-md-12">
                                <h4 class="first-child">1. Lead Warning Statement</h4><p>Every purchaser of any interest in residential real property on which a residential dwelling was built prior to 1978 is notified that such property may present exposure to lead from lead-based paint that may place young children at risk of developing lead poisoning. Lead poisoning in young children may produce permanent neurological damage, including learning disabilities, reduced intelligence quotient, behavioral problems, and impaired memory. Lead poisoning also poses a particular risk to pregnant women. The seller of any interest in residential real property is required to provide the buyer with any information on lead-based paint hazards from risk assessments or inspections in the seller's possession and notify the buyer of any known lead-based paint hazards. A risk assessment or inspection for possible lead-based paint hazards is recommended prior to purchase.<br>
                                    <i><b>Please note seller's disclosure obligations under 42 U.S.C. 4852d.</b></i></p>
                            </div><!--col-md-12-->
                        </div>
                        <div class="form-group para-text">
                            <div class="col-md-12">
                                <h4>2.Seller's/Lessor's Disclosure </h4>
                                <h5>a. Presence of lead-based paint and/or lead-based paint hazards below:</h5>
                                <input type="radio" name="lead_based" id="lead_based" <?php
				if (isset($offer->property->lead_based) && ($offer->property->lead_based) == config('constant.inverse_common_yes_no.Yes')) {
				    ?>
    				       checked="checked"
				       <?php } ?> disabled="disabled" value="{{config('constant.inverse_common_yes_no.Yes')}}">
                                <label for="lead_based">Known lead-based paint and/or lead-based paint hazards are present in the housing.</label>
                                <input type="radio" name="lead_based" id="lead_based-no" <?php
				if (isset($offer->property->lead_based) && ($offer->property->lead_based) == config('constant.inverse_common_yes_no.No')) {
				    ?>
    				       checked="checked"
				       <?php } ?> disabled="disabled" value="{{config('constant.inverse_common_yes_no.No')}}">
                                <label for="lead_based-no">Seller has no knowledge of lead-based paint and/or lead-based paint hazards in the housing.</label>
                                <h5>b. Records and reports available to the seller below:</h5>
                                <input type="radio" name="lead_based_report" id="lead_based_report" <?php
				if (isset($offer->property->lead_based_report) && ($offer->property->lead_based_report) == config('constant.inverse_common_yes_no.Yes')) {
				    ?>
    				       checked="checked"
				       <?php } ?> disabled="disabled" value="{{config('constant.inverse_common_yes_no.Yes')}}">
                                <label for="lead_based_report">Seller has provided the purchaser with all available records and reports pertaining to lead-based paint and/or lead-based paint hazards in the housing (list documents below).Known lead-based paint and/or lead-based paint hazards are present in the housing.</label>
                                <input type="radio" name="lead_based_report" id="lead_based_report-no" <?php
				if (isset($offer->property->lead_based_report) && ($offer->property->lead_based_report) == config('constant.inverse_common_yes_no.No')) {
				    ?>
    				       checked="checked"
				       <?php } ?> disabled="disabled" value="{{config('constant.inverse_common_yes_no.No')}}">
                                <label for="lead_based_report-no">Seller has no reports or records pertaining to lead-based paint and/or lead-based paint hazards in the housing.</label>
                            </div>
                        </div><!--col-md-12-->
                        <div class="form-group">
                            <div class="col-md-12">
                                <h4>3.Purchaser's/Lessee's Acknowledgment (initial) </h4>
                                <h5>c. Seller/Lessor hereby provides the Buyer/Lessee with the EPA's Lead Based Paint Pamphlet Here:<a href="{{asset('storage/pdf/Lead_Based_Paint_Disclosure.pdf')}}" target="_blank"> "Lead Based Paint Disclosure Pamphlet".</a> </h5>
                                <p> Adobe Reader may be required to view this form- you may download a free version here:<a href="https://get.adobe.com/reader/otherversions/"> "Download Adobe Reader".</a> </p>
                            </div><!--col-md-12-->
                            <div class="col-md-12 clearfix">
                                <div class="checkbox">
				    <?php
				    if (isset($offer->epa) && $offer->epa) {
					$epas = explode(',', $offer->epa);
				    }
				    ?>
                                    <input type="checkbox" class="styled-checkbox" name="epa[]" id="read-epa" <?php
				    if (isset($offer->epa) && $offer->epa) {
					foreach ($epas as $epa) {
					    if ($epa == config('constant.inverse_epa.readepa')) {
						?>
	    					   checked="checked"
						       <?php
						   }
					       }
					   }
					   ?> value="{{config('constant.inverse_epa.readepa')}}" disabled="disabled" >
                                    <label for="read-epa">I have read the EPA's "Lead Based Paint Disclosure Pamphlet" </label>
                                </div>
                            </div><!--col-md-12-->
                            <div class="col-md-12">
                                <div class="checkbox clearfix">
                                    <input type="checkbox" class="styled-checkbox" name="epa[]" id="received-copies" <?php
				    if (isset($offer->epa) && $offer->epa) {
					foreach ($epas as $epa) {
					    if ($epa == config('constant.inverse_epa.receivedcopies')) {
						?>
	    					   checked="checked"
						       <?php
						   }
					       }
					   }
					   ?> value="{{config('constant.inverse_epa.receivedcopies')}}" disabled="disabled" >
                                    <label for="received-copies">Purchaser has received copies of all information from the seller/lessor listed above. </label>
                                </div>
                            </div><!--col-md-12-->
                        </div>
                        <div class="form-group clearfix">
                            <div class="col-md-12">
                                <h5 class="first-child">d. Purchaser has check below:</h5>
                                <input type="radio" name="opportunity" id="opportunityDay" <?php
				if (isset($offer->opportunity) && $offer->opportunity && $offer->opportunity == config('constant.inverse_lead_opportunity.10-day opportunity')) {
				    ?>
    				       checked="checked"
					   <?php
				       }
				       ?> value="{{config('constant.inverse_lead_opportunity.10-day opportunity')}}" disabled="disabled">
                                <label for="opportunityDay">Received a 10-day opportunity (or mutually agreed upon period) to conduct a risk assess-ment or inspection for the presence of lead-based paint and/or lead-based paint hazards; or</label>
                                <input type="radio" name="opportunity" id="opportunityWaived" <?php
				if (isset($offer->opportunity) && $offer->opportunity && $offer->opportunity == config('constant.inverse_lead_opportunity.Waived the opportunity')) {
				    ?>
    				       checked="checked"
					   <?php
				       }
				       ?> value="{{config('constant.inverse_lead_opportunity.Waived the opportunity')}}" disabled="disabled">
                                <label for="opportunityWaived">Waived the opportunity to conduct a risk assessment or inspection for the presence of lead-based paint and/or lead-based paint hazards.</label>
                            </div><!--col-md-12-->
                        </div>

                        <div class="form-group">
                            <div class="col-md-12">
                                <h4>4. Certification of Accuracy</h4><p>The following parties have reviewed the information above and certify, to the best of their knowledge, that the information they have provided is true and accurate.</p>
                            </div><!--col-md-12-->
                        </div>

                        @include('frontend.contract_tools.include_files.signature_common')

                        <div class="btns-green-blue col-lg-12">
                            <a href="{{ route('frontend.sdThankYouSellerNecessaryForms') }}" class="button btn btn-green" id='ad_seller_submit'>Submit</a>
                        </div><!--</btns-green-blue>-->
                    </div>
                </div>
            </div><!--</col>-->
        </div><!--</col>-->
    </div><!--</row>-->
</div><!--</contract-tools-seller-common>-->
@endsection
@section('after-scripts')
<script src="{{ asset(asset('js/moment.min.js')) }}"></script>
<script>
    $("#ad_seller_submit").click(function (e) {
        if ($(".signature-button").parent().parent().find('.seller-frst-sign').val() === '') {
            e.preventDefault();
            $(".signature-button").parent().parent().find('.seller-sign-error').show();
            $('html, body').animate({
                scrollTop: $(".signature-button").parent().parent().find('.seller-sign-error').offset().top
            });
        } else {
            $('.seller-sign-error').hide();
        }
    });
    function addSignature(id) {
        $.ajax({
            type: "post",
            url: "{{ route('frontend.leadBasedSignature') }}",
            data: {
                id: id,
            },
            success: function (response) {
                if (response.signature) {
                    var date = moment(response.signature.created_at).format('YYYY-MM-DD');
                    var time = moment(response.signature.created_at).format('hh:mm a');
                    $('#sd-buyer-ip-' + (id + 7)).val(response.signature.ip);
                    $('#sd-buyer-time-' + (id + 7)).val(time);
                    $('#sd-buyer-date-' + (id + 7)).val(date);
                }
                $('#sd-buyer-signature-' + (id + 7)).val(response.signature.signature).css('color', '#ff0000');
                $(".signature .signature-button").parent().parent().find('.seller-sign-error').remove();
                $('.seller-sign-error').hide();
                $('.signature-button').remove();
            },
            error: function (error) {
            }
        });
    }
</script>
@endsection