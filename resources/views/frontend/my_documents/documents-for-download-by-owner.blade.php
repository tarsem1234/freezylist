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
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="text-left">Title</th>
                                    <th class="text-left">Action</th>
                                </tr>
                            </thead>  
                            <tbody>
                                <tr>
                                    <td>Sale Agreement :</td>
                                    <?php
                                    $saleAgreement = false;
                                    $leadBased = false;
                                    $postClosing = false;
                                    $propertydisclaimer = false;
                                    $vaFha = false;
                                    if (count($sentDocuments->signatures) > 0) {
                                        foreach ($sentDocuments->signatures as $document) {
                                            if ($document->signature_type == config('constant.inverse_signature_type.sale agreement')) {
                                                $saleAgreement = true;
                                            }
                                            if ($document->signature_type == config('constant.inverse_signature_type.property disclaimer')) {
                                                $propertydisclaimer = true;
                                            }
                                            if ($document->signature_type == config('constant.inverse_signature_type.VA FHA loan addendum')) {
                                                $vaFha = true;
                                            }
                                            if ($document->signature_type == config('constant.inverse_signature_type.advisory to buyers and sellers')) {
                                                $advisory = true;
                                            }
                                            if ($document->signature_type == config('constant.inverse_signature_type.post closing occupancy agreement')) {
                                                $postClosing = true;
                                            }
                                            if ($document->signature_type == config('constant.inverse_signature_type.lead based')) {
                                                $leadBased = true;
                                            }
                                        }
                                    }
                                    ?>
                                    <td>
                                        <?php if($saleAgreement){ ?>
                                        <a href="#"> Download / Print</a>
                                        <?php  } else { ?>
                                        <p> Download / Print</p>
                                        <?php  } ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Property Condition Disclaimer :</td>
                                    <td> 
                                        <?php if($propertydisclaimer){ ?>
                                        <a href="#"> Download / Print</a>
                                        <?php  } else { ?>
                                        <p> Download / Print</p>
                                        <?php  } ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>VA/FHA Loan Addendum :</td>
                                    <td>
                                        <?php if($vaFha){ ?>
                                        <a href="#"> Download / Print</a>
                                        <?php  } else { ?>
                                        <p> Download / Print</p>
                                        <?php  } ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Advisory to Buyers and Sellers :</td>
                                    <td>
                                        <?php if($advisory){ ?>
                                        <a href="#"> Download / Print</a>
                                        <?php  } else { ?>
                                        <p> Download / Print</p>
                                        <?php  } ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Lead-Based Paint Disclosure :</td>
                                    <td>
                                        <?php if($leadBased){ ?>
                                        <a href="#"> Download / Print</a>
                                        <?php  } else { ?>
                                        <p> Download / Print</p>
                                        <?php  } ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Post Closing Occupancy Agreement :</td>
                                    <td>
                                        <?php if($postClosing){ ?>
                                        <a href="#"> Download / Print</a>
                                        <?php  } else { ?>
                                        <p> Download / Print</p>
                                        <?php  } ?>
                                    </td>
                                </tr>                                                                                                        
                            </tbody>
                        </table><!--table-->
                        <div class="btns-green-blue btns-text-align-right text-right mr-top">
                            <div class="">
                                <a class="btn button btn-blue" href="{{ route('frontend.receivedDocumentDetailsRent') }}">Back</a>
                            </div>
                        </div>                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
