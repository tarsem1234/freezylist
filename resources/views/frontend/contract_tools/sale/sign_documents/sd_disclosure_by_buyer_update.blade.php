@extends ('frontend.layouts.app')
@section ('title', ('Sd Disclosures Rent Contract Tool Review Tenant'))
@section('after-styles')
<link type="text/css" rel="stylesheet" href="{{ asset(mix('css/contract-tools-buyer.css')) }}" media="all"> 
@endsection
@section('content')
<div class="container purchase-sale-agreement-review contract-tools-seller-common dis-que">
    <div class="row">
        <div class=""> 
            <div class="sidebar">
                @include('frontend.includes.sidebar')
            </div>
            <div class="col-md-9 col-sm-8">
                <div class="nested-div register-page"> 
                    <div class="heading-text">
                        <h2 class="first-child">Property Condition Disclaimer</h2>
                    </div>
                    <div class="para-text row mar-top">                         
                        <form>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <h4 class="first-child">INSTRUCTIONS TO THE SELLER</h4> 
                                    <p class="offer-text">Complete this form yourself and answer each question to the best of your knowledge. If an answer is an estimate, clearly label it as such. Explain any YES answers and describe the nature and extent of any defects or repairs. If more space is needed, attach additional sheets. You may also attach any documents pertaining to repairs or corrections. The Seller hereby authorizes any real estate licensee involved in this transaction to provide a copy of this statement to any person or entity in connection with any actual or anticipated sale of the subject property.</p>
                                </div>
                            </div> 
                            <div class="include-text">
                                @include('frontend.contract_tools.include_files.disclosure_by_buyer_update_common_text')
                            </div> 
                            @include('frontend.contract_tools.include_files.signature_common')
                            <div class="btns-green-blue col-lg-12">
                                  <a href="{{route('frontend.sdThankYouBuyerForPd')}}" id="ad_buyer_update" class="btn btn-blue">Update</a>
                            </div><!--</btns-green-blue>-->
                        </form>
                    </div>
                </div>
            </div>
        </div><!--</col>-->
    </div><!--</row>-->
</div><!--</contract-tools-seller-common>-->
@endsection
@section('after-scripts')
<script src="{{ asset(asset('js/moment.min.js')) }}"></script>
<script>
    
    $(document).ready(function(){
         $("#ad_buyer_update").click(function(e){
         if($(".signature-button").parent().parent().find('.buyer-frst-sign').val() === ""){
                    e.preventDefault();
                    $(".signature-button").parent().parent().find('.buyer-sign-error').show();
                    $('html, body').animate({
                        scrollTop: $(".signature-button").parent().parent().find('.buyer-sign-error').offset().top
                    });
                }
            else {
                $('.buyer-sign-error').hide();
            }
        });
    });
    
    function addSignature(id){
        $.ajax({
            type: "post",
            url: "{{ route('frontend.disclaimerSignature') }}",
            data: {
                id: id,
            },
            success: function (response) {
                if (response.signature) {
                    var date = moment(response.signature.created_at).format('YYYY-MM-DD');
                    var time = moment(response.signature.created_at).format('hh:mm a');
                    $('#sd-buyer-ip-'+(id+7)).val(response.signature.ip);
                    $('#sd-buyer-time-'+(id+7)).val(time);
                    $('#sd-buyer-date-'+(id+7)).val(date);
                }
                $('#sd-buyer-signature-'+(id+7)).val(response.signature.signature).css('color', '#ff0000');
                $('.buyer-sign-error').hide();
                $(".signature .signature-button").parent().parent().find('.buyer-sign-error').remove();
                $('.buyer-sign-error').remove();
                $('.signature .signature-button').remove();
            },
            error: function (error) {
            }
        });
    }
</script>
@endsection