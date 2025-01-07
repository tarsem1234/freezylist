@extends ('frontend.layouts.app')
@section ('title', ('Disclosures By Buyer'))
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
                        <h2 class="first-child">STEP 2 OF 6: Property Condition Disclaimer</h2>
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
                            <div class="col-sm-12">
                                <div class="btns-green-blue btns-text-align-right">
                                    <a href="{{route('frontend.vaThankYouForBuyer')}}" class="btn btn-blue">Next</a>
                                </div>
                            </div> 
                        </form>
                    </div>
                </div>
            </div>
        </div><!--</col>-->
    </div><!--</row>-->
</div><!--</contract-tools-seller-common>-->
@endsection
@section('after-scripts')
<script>
    $(document).ready(function () {
        if ($("#chkYes").is(":checked")) {
            $("#house").show();
        } else {
            $("#house").hide();
        }
        if ($("#Fireplace").is(":checked")) {
            $("#main-fireplace").show();
        } else {
            $("#main-fireplace").hide();
        }
        if ($("#Pool").is(":checked")) {
            $("#Pool-option").show();
        } else {
            $("#Pool-option").hide();
        }
        if ($("#Garage").is(":checked")) {
            $("#Garage-option").show();
        } else {
            $("#Garage-option").hide();
        }
        if ($("#Opener").is(":checked")) {
            $("#remotes").show();
        } else {
            $("#remotes").hide();
        }
        if ($("#Heat-Pump").is(":checked")) {
            $("#Heat-Pump-many").show();
        }
        if ($("#CH").is(":checked")) {
            $("#CH-many").show();
        }
        if ($("#CA").is(":checked")) {
            $("#CA-many").show();
        }
        if ($("#WH").is(":checked")) {
            $("#WH-many").show();
        }
        if ($("#WSupply").is(":checked")) {
            $("#WSupply-many").show();
        }
        if ($("#Gas-Supply").is(":checked")) {
            $("#Gas-Supply-many").show();
        }
        if ($("#selleryes").is(":checked")) {
            $("#seller").show();
        }
    });
</script>
@endsection

