@extends ('frontend.layouts.app')
@section ('title', ('Documents For download By Owner'))   
@section('after-styles')
<link type="text/css" rel="stylesheet" href="{{ asset(mix('css/dashboard.css')) }}" media="all">
<style>#submenu-Documents{ font-weight: bold;color: #000;}</style>
@endsection  
@section('content')
<div class="forum-page signer-page dashboard-page left-content-table">     
    <div class="container">
        <div class="row content">
            @include('frontend.includes.sidebar')
            <div class="col-md-9 col-sm-8">
                <div class="right-dashboard-div">
                    <div class="profile right-dashboard-div-text">
                        <div class="row">  
                            <div class="col-md-12">
                                <h4 class="pull-left">My Sent Documents</h4>                          
                            </div>
                        </div>
                        <div id="tabs" class="col-md-12">
                            <div class="" id="sale-rent">
                                <div class="table-responsive">
                                    <table class="table table-striped ">
                                        <thead>
                                            <tr>
                                                <th class="text-left">Title</th>
                                                <th class="text-left">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $saleAgreement      = false;
                                            $leadBased          = false;
                                            $propertydisclaimer = false;
                                            if (isset($sentDocuments->signatures) && count($sentDocuments->signatures) > 0) {
                                                foreach ($sentDocuments->signatures as $document) {
                                                    if ($document->signature_type == config('constant.inverse_signature_type.sale agreement')) {
                                                        $saleAgreement = true;
                                                    }
                                                    if ($document->signature_type == config('constant.inverse_signature_type.property disclaimer')) {
                                                        $propertydisclaimer = true;
                                                    }
                                                    if ($document->signature_type == config('constant.inverse_signature_type.lead based')) {
                                                        $leadBased = true;
                                                    }
                                                }
                                            }
                                            ?>
                                            <tr>
                                                <td>Sale Agreement :</td>
                                                <td>
                                                    <?php if ($saleAgreement) { ?>
                                                        <a href="{{route('frontend.saleAgreementSignPdf',['property_id'=>$sentDocuments->property_id,'offer_id'=>$sentDocuments->id])}}" target="_blank"> Download / Print</a>
                                                    <?php } else { ?>
                                                        <p> Not Available</p>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Property Condition Disclaimer :</td>
                                                <td>
                                                    <?php if ($propertydisclaimer) { ?>
                                                        <a href="{{route('frontend.propertyDisclaimerSignPdf',['property_id'=>$sentDocuments->property_id,'offer_id'=>$sentDocuments->id])}}" target="_blank"> Download / Print</a>
                                                    <?php } else { ?>
                                                        <p> Not Available</p>
                                                    <?php } ?>
                                                </td>
                                                <!--<td> <a href="{{route('frontend.propertyDisclaimerSignPdf','37')}}" target="_blank"> Download / Print</a></td>-->
                                            </tr>
                                            <tr>
                                                <td>Lead-Based Paint Disclosure :</td>
                                                <td>
                                                    <?php if ($leadBased) { ?>
                                                        <a href="{{route('frontend.leadBasedSignPdf',['property_id'=>$sentDocuments->property_id,'offer_id'=>$sentDocuments->id])}}" target="_blank"> Download / Print</a>
                                                    <?php } else { ?>
                                                        <p> Not Available</p>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table><!--table-->
                                </div>

                                <div class="btns-green-blue btns-text-align-right text-right mr-top">
                                    <div class="">
                                        <a class="btn button btn-blue" href="{{ URL::previous() }}">Back</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection