@section('content')
@extends ('frontend.layouts.app')
@section ('title', ('Sign Documents Seller')) 
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
                                        <th>Primary Seller</th>
                                        <th>Offer From</th>
                                        <th>Listing Type</th>
                                        <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if(isset($sellers) && count($sellers)>0) {
                                            foreach($sellers as $seller) {
                                            ?>
                                        <tr>
                                            <td>{{getFirstLastName($seller->saleOffer->buyer)}}</td>
                                            <td>{{getFirstLastName($seller->saleOffer->seller)}}</td>
                                            <td>Sale</td>
                                            @if($seller->saleOffer->owner_id == Auth::id())
                                                {{ html()->form('GET', route('frontend.recieved.view.offer'))->class('form-horizontal')->id('contractToolPageForm')->open() }}
                                                <input type="hidden" name="offer_id" value="{{ $seller->saleOffer->id }}">
                                                <input type="hidden" name="type" value="{{ config('constant.property_type.'.$seller->saleOffer->property->property_type) }}">
                                                <input type="hidden" name="property_id" value="{{ $seller->saleOffer->property->id }}">
                                                <input type="hidden" name="owner_id" value="{{ $seller->saleOffer->property_owner_user->id??'NA' }}">
                                                <td class="blue-text"><a style="cursor:pointer;" class="" type="submit" onclick="signDocumentPage()">View &amp; Sign Documents</a></td>
                                                {{ html()->form()->close() }}
                                            @else
                                                <td class="blue-text"><a href="{{route('frontend.signOffersSaleSellerPartner',$seller->id)}}">View &amp; Sign Documents</a></td>
                                            @endif
                                        </tr>
                                        <?php } } else { ?>
                                        <tr>
                                            <td>No Document Found.</td>
                                        </tr>
                                        <?php }  ?>
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
