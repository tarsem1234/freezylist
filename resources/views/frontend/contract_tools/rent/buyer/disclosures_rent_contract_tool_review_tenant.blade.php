@extends ('frontend.layouts.app')
@section ('title', ('Disclosures Rent Contract Tool Review Tenant'))
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
                    <div class="heading-text">
                        <h2 class="first-child">Property Condition Disclaimer</h2>
                    </div>
                    <div class="para-text row mar-top">
                        <div class="form-group">
                            <div class="col-sm-12">
                                <h4 class="first-child">INSTRUCTIONS TO THE SELLER</h4> 
                                <p class="offer-text">Complete this form yourself and answer each question to the best of your knowledge. If an answer is an estimate, clearly label it as such. Explain any YES answers and describe the nature and extent of any defects or repairs. If more space is needed, attach additional sheets. You may also attach any documents pertaining to repairs or corrections. The Seller hereby authorizes any real estate licensee involved in this transaction to provide a copy of this statement to any person or entity in connection with any actual or anticipated sale of the subject property.</p>
                            </div>
                        </div> 
                        <form>
                            <div class="include-text">
                                @include('frontend.contract_tools.include_files.disclosure_by_buyer_update_common_text',['property'=>$property,'diffInYears'=>$diffInYears])
                            </div>
                            <div class="btns-green-blue btns-text-align-right">
                                <div class="col-sm-12">
                                    <a href="{{route('frontend.thankyouDiscloserToolTenant')}}" class="btn btn-blue">Next</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div><!--</col>-->
        </div><!--</row>-->
    </div><!--</contract-tools-seller-common>-->
</div>
@endsection
@section('after-scripts')
@endsection

