@section('content')
@extends ('frontend.layouts.app')
@section ('title', ('Sign Documents Tenant')) 
@section('after-styles')
<link type="text/css" rel="stylesheet" href="{{ asset(mix('css/dashboard.css')) }}" media="all">
<style>#sign-documents{ font-weight: bold;color: #000;}</style> 
@endsection 
@section('content')
<div class="forum-page signer-page dashboard-page associates profile-view">     
    <div class="container">
        <div class="row content">
            @include('frontend.includes.sidebar')
            <div class="col-md-9 col-sm-8">
                <div class="right-dashboard-div">
                    <div class="profile right-dashboard-div-text">
                        <div class="row">  
                            <div class="col-md-12">
                                <h4 class="pull-left">Sign Documents</h4>                          
                            </div>
                        </div>
                         <div class="table-responsive">
                                <table class="table table-striped ">
                                    <thead>
                                        <tr>
                                        <th>Primary Tenant</th>
                                        <th>Offer To</th>
                                        <th>Listing Type</th>
                                        <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if(isset($tenants) && count($tenants)>0){
                                           foreach($tenants as $tenant){
//                                            $exploded = explode(',',$tenant->partners);
//                                            foreach($exploded as $explode){
//                                            if($explode == Auth::id()){
                                               ?>
                                            <tr>
                                                <td>{{getFullName($tenant->rentOffer->tenant)}}</td>
                                                <td>{{getFullName($tenant->rentOffer->landlord)}}</td>
                                                <td>{{config('constant.property_type.'.$tenant->rentOffer->property->property_type)}}</td>
                                                 @if($tenant->rentOffer->buyer_id == Auth::id())
                                                <td>
                                                    {{ html()->form('GET', route('frontend.sent.view.offer.rent'))->class('form-horizontal')->id('contractToolPageForm')->open() }}
                                                    <input type="hidden" name="offer_id" value="{{ $tenant->rentOffer->id }}">
                                                    <input type="hidden" name="type" value="{{ (isset($tenant->rentOffer->property) && $tenant->rentOffer->property) ? config('constant.property_type.'.$tenant->rentOffer->property->property_type) :"" }}">
                                                    <input type="hidden" name="property_id" value="{{ $tenant->rentOffer->property->id??"" }}">
                                                    <input type="hidden" name="owner_id" value="{{ $tenant->rentOffer->property_owner_user->id }}">
                                                    <a class="" style="cursor:pointer;" type="submit" onclick="signDocumentPage()">View &amp; Sign Documents </a>
                                                    {{ html()->form()->close() }}
                                                </td>
                                                @else
                                                <td class="blue-text"><a href="{{route('frontend.signOffersRentTenantPartner',$tenant->id)}}">View &amp; Sign Documents</a></td>
                                                @endif
                                            </tr>
                                        <?php
//                                           } }
                                        } }  else { ?>
                                        <tr>
                                            <td>No Document Found.</td>
                                        </tr>
                                        <?php } ?>
                                    </tbody>
                                </table><!--table-->
                            </div><!-- table-responsive -->
                    </div><!-- right-dashboard-div-text -->
                </div><!-- right-dashboard-div -->
            </div><!-- col-md-9 -->
        </div><!-- content -->
    </div><!-- container -->
</div><!-- dashboard-page -->
@endsection
@section('after-scripts')
<script>
    function signDocumentPage(){
        $('#contractToolPageForm').submit();
    };
    $(document).ready(function () {

    });

</script>
@endsection   
