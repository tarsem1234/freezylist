@extends ('frontend.layouts.app')
@section ('title', ('Sd Rent Lease Agreement By Landlord')) 
@section('after-styles')
<link type="text/css" rel="stylesheet" href="{{ asset(mix('css/contract-tools-buyer.css')) }}" media="all">  
@endsection 
@section('content')
<div class="container purchase-sale-agreement-review contract-tools-seller-common dis-que register-page">
    <div class="row">
        <div class="">
            <div class="sidebar">
                @include('frontend.includes.sidebar')
            </div>
            <div class="col-md-9 col-sm-8">
                <div class="nested-div register-page">
                    <div class="include-text">
                        @include('frontend.contract_tools.include_files.lease_agreement_review_commom_text')
                    </div>
                    @include('frontend.contract_tools.include_files.signature_common_rent')
                    <div class="btns-green-blue btns-text-align-right">
                        <div class="col-sm-12">
                            <a href="{{route('frontend.sdThankyouLeaseAgreementLandlord')}}" id="ad_seller_update" class="btn btn-blue">Next</a>
                        </div>
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
        $("#ad_seller_update").click(function(e){
              if($(".signature-button").parent().parent().find('.seller-frst-sign').val() === ''){
                    e.preventDefault();
                    $(".signature-button").parent().parent().find('.seller-sign-error').show();
                    $('html, body').animate({
                        scrollTop: $(".signature-button").parent().parent().find('.seller-sign-error').offset().top
                    });
                }  
            else {
                $('.seller-sign-error').hide();
            }
        });
        
    function addSignature(id){
//        $(this).attr('disabled','disabled');
        $.ajax({
            type: "post",
            url: "{{ route('frontend.saleAgreementSignatureRent') }}",
            data: {
                id: id,
            },
            success: function (response) {
                if (response.signature) {
                    var date = moment(response.signature.created_at).format('YYYY-MM-DD');
                    var time = moment(response.signature.created_at).format('hh:mm a');
                    $('#sd-tenant-ip-'+(id+7)).val(response.signature.ip);
                    $('#sd-tenant-time-'+(id+7)).val(time);
                    $('#sd-tenant-date-'+(id+7)).val(date);
                }
                $('#sd-tenant-signature-'+(id+7)).val(response.signature.signature).css('color', '#ff0000');
                $('.signature-button').remove();
                $('.seller-sign-error').remove();
            },
            error: function (error) {
            }
        });
    }
</script>
@endsection