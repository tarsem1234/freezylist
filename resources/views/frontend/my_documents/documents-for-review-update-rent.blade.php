@extends ('frontend.layouts.app')
@section ('title', ('Documents For Review Update By Owner'))  
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
                                <h4 class="pull-left">My Received Documents</h4>                          
                            </div>
                        </div>
                        <table class="table">  
                            <thead>
                                <tr>
                                    <th class="text-left">Title</th>
                                    <th class="text-left">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $rentAgreement      = true;
                                $leadBased          = false;
                                $propertydisclaimer = true;
                                $isOwner            = false;
                                if (!empty($sentDocuments)) {
                                    if($sentDocuments->owner_id == Auth::id()){
                                        $isOwner = true;
                                    }
                                    if(!empty($sentDocuments->property->architechture->year_built) && $sentDocuments->property->architechture->year_built <= 1978){
                                    $leadBased = true;
                                   }
//                                    foreach ($sentDocuments->rentSignatures as $document) {
//                                        if ($document->signature_type == config('constant.inverse_signature_type_rent.rent agreement')) {
//                                            $rentAgreement = true;
//                                        }
//                                        if ($document->signature_type == config('constant.inverse_signature_type.property disclaimer')) {
//                                            $propertydisclaimer = true;
//                                        }
//                                        if ($document->signature_type == config('constant.inverse_signature_type.lead based')) {
//                                            $leadBased = true;
//                                        }
//                                    }
                                }
                               
                                ?>
                                <tr>
                                    <td>Rent Agreement </td>
                                    <td>
                                        <?php if ($rentAgreement) { ?>
                                            <a href="{{ route('frontend.documentRentAgreement') }}" type="button" class="btn btn-info btn-lg icon-btn" title="View"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                        <?php } else { ?>
                                            <p> Not Available</p>
                                        <?php } ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Property Condition Disclaimer </td>
                                    <td>
                                        <?php if ($propertydisclaimer) { ?>
                                            <a href="{{ route('frontend.documentDisclosure') }}" type="button" class="btn btn-info btn-lg icon-btn" title="View"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                        <?php } else { ?>
                                            <p> Not Available</p>
                                        <?php } ?>
                                    </td>
                                </tr> 
                                <tr>
                                    <td>Lead-Based Paint Disclosure </td>
                                    <td>
                                        <?php if ($leadBased) { ?>
                                            <a href="{{route('frontend.documentLeadBasedPaintHazardsRent')}}" type="button" class="btn btn-info btn-lg icon-btn" title="View"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                        <?php } else { ?>
                                            <p> Not Available</p>
                                        <?php } ?>
                                    </td>
                                </tr>
                            </tbody>
                        </table><!--table-->
                        <div class="btns-green-blue btns-text-align-right text-right mr-top">
                            <div class="col-sm-12">   
                                @if(count($sentDocuments->rentSignatures) > 0 && $sentDocuments->landlord_signature==1 && $sentDocuments->tenant_signature==1)
                                <a class="btn btn-green" href="{{ route('frontend.downloadDocumentsRent',['offer_id'=> $sentDocuments->id,'type'=> $sentDocuments->property->property_type]) }}">Download Documents</a>
                                @endif
                                @if(isset($page) && $page=='sent')
                                    <a class="btn btn-blue" href="{{ route('frontend.sentDocuments') }}">Back</a>
                                @else
                                    <a class="btn btn-blue" href="{{ route('frontend.receivedDocuments')}}">Back</a>
                                @endif
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

