@section('content')
@extends ('frontend.layouts.app')
@section ('title', ('Sign Choose Role')) 
@section('after-styles')
<link type="text/css" rel="stylesheet" href="{{ asset(mix('css/dashboard.css')) }}" media="all"> 
<style>#sign-documents{ font-weight: bold;color: #000;}</style> 
@endsection 
@section('content')
<div class="forum-page signer-page dashboard-page associates profile-view choose-role">       
    <div class="container">
        <div class="row content">
            @include('frontend.includes.sidebar')
            <div class="col-md-9 col-sm-8">
                <div class="right-dashboard-div">
                    <div class="profile right-dashboard-div-text">
                        <div class="row">  
                            <div class="col-md-12">
                                <h4>Choose Your Role</h4>  
                                <hr class="cr_hr lc_hr">
                                <p>To Proceed with sign document process you need to select your role by clicking on follwing appropriate button.</p>                              
                            </div>                           
                            <div class="col-xs-12  btns-green-blue all-buttons"> 
                                <a class="btn btn-blue button" href="{{ route('frontend.signDocumentsBuyer') }}">Buyer</a>
                                <a class="btn btn-blue button" href="{{ route('frontend.signDocumentsSeller') }}">Seller</a> 
                                 <a class="btn btn-blue button" href="{{ route('frontend.signDocumentsTenant') }}">Tenant</a>
                                 <a class="btn btn-blue button" href="{{ route('frontend.signDocumentsLandlord') }}">Landlord</a>  
                            </div>    
                        </div>                        
                    </div><!-- right-dashboard-div-text -->
                </div><!-- right-dashboard-div -->
            </div><!-- col-md-9 -->
        </div><!-- content -->
    </div><!-- container -->
</div><!-- dashboard-page -->
@endsection
@section('after-scripts')