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
                            <ul  class="nav nav-pills">
                                <li class="active">
                                    <a  href="#Rent" data-toggle="tab">Rent</a>
                                </li>
                                <li><a href="#Sale" data-toggle="tab">Sale</a>
                                </li>
                            </ul>
                            <div class="tab-content clearfix">
                                <div class="tab-pane active" id="Rent">
                                    <?php
                                    if (isset($rentOffers) && count($rentOffers) > 0) {
                                        ?>
                                        <div class="table-responsive">
                                            <table class="table table-striped ">
                                                <thead>
                                                    <tr>
                                                        <th>Sr. No.</th>
                                                        <th>Offer Price</th>
                                                        <th>Documents Sent To</th>
                                                        <th>Property ID</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php 
                                                    foreach ($rentOffers as $key => $rentOffer) { ?>
                                                        <tr>
                                                            <td>{{ $key + 1}}</td>
                                                            <?php if(!empty($rentOffer->rent_counter_offers) && count($rentOffer->rent_counter_offers) > 0) { ?>
                                                            <td><span class="money">{{round($rentOffer->rent_counter_offers->first()->counter_offer_price)}}</td>
                                                            <?php } else { ?>
                                                            <td><span class="money">{{round($rentOffer->rent_price)??"NA" }}</span></td>
                                                            <?php } ?>
                                                            <td>{{ getFullName($rentOffer->sent_offer_user) }}</td>
                                                            <td>{{$rentOffer->property->id}}</td>
                                                            <td><a href="{{ route('frontend.sentDocumentDetailsRent',['offer_id'=> $rentOffer->id,'type'=> $rentOffer->property->property_type])}}">Document Details</a></td>
                                                        </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table><!--table-->
                                        </div>
                                    <?php } else { ?>
                                        <h4 class="no-data">No Document Sent.</h4>
                                    <?php } ?>
<!--                                    <div class="btns-green-blue btns-text-align-right text-right">
                                        <div class="col-sm-12">
                                            <a class="btn button btn-blue" href="{{ route('frontend.sentDocumentDetails') }}">Back</a>
                                        </div>
                                    </div>-->
                                </div>
                                <div class="tab-pane" id="Sale">
                                    <?php
                                    if (isset($saleOffers) && count($saleOffers) > 0) {
                                        ?>
                                        <div class="table-responsive">
                                            <table class="table table-striped ">
                                                <thead>
                                                    <tr>
                                                        <th>Sr. No.</th>
                                                        <th>Offer Price</th>
                                                        <th>Documents Sent To</th>
                                                        <th>Property ID</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($saleOffers as $key => $saleOffer) { ?>
                                                        <tr>
                                                            <td>{{ $key + 1}}</td>
                                                            <?php if(count($saleOffer->sale_counter_offers) > 0) { ?>
                                                            <td><span class="money">{{round($saleOffer->sale_counter_offers->first()->counter_offer_price)}}</span></td>
                                                            <?php } else { ?>
                                                            <td><span class="money">{{round($saleOffer->tentative_offer_price)??"NA" }}</span></td>
                                                            <?php } ?>
                                                            <td>{{ getFullName($saleOffer->property_sender_user) }}</td>
                                                            <td>{{$saleOffer->property->id}}</td>
                                                            <td><a href="{{ route('frontend.sentDocumentDetailsSale',['offer_id'=> $saleOffer->id,'type'=> $saleOffer->property->property_type])}}">Document Details</a></td>
                                                        </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table><!--table-->
                                        </div>
                                    <?php } else { ?>
                                        <h4 class="no-data">No Document Sent.</h4>
                                    <?php } ?>
<!--                                    <div class="btns-green-blue btns-text-align-right text-right">
                                        <div class="col-sm-12">
                                            <a class="btn button btn-blue" href="{{ route('frontend.sentDocumentDetails') }}">Back</a>
                                        </div>
                                    </div>-->
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