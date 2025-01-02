@extends('frontend.layouts.app')

@section('title', app_name() . ' | Sale Listings')
@section('after-styles')
<link type="text/css" rel="stylesheet" href="{{ asset(mix('css/dashboard.css')) }}" media="all"> 
<style>#rent-pages{ font-weight: bold;color: #000;}</style>   
@endsection 
@section('content')
<div class="dashboard-page associates profile-view listing signer-page">    
    <div class="container">
        <div class="row content">
            @include('frontend.includes.sidebar')
            <div class="col-md-9 col-sm-8">
                <div class="right-dashboard-div">
                    <div class="right-dashboard-div-text">
                        <div class=""> 
                            <div class="col-md-6 col-xs-12 col-sm-6 col-lg-6 no-padding">
                                <h4>My Sale Listings </h4>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12 col-lg-6 no-padding">
                                <a href="{{route('frontend.saleCreate')}}"><button class="btn btn-primary btn-lg" id="addlisting-btn"> Add New Listing </button></a>
                            </div>
                        </div>
                        <?php
                        if ($properties->count()) {
                            foreach ($properties as $property) {
                                ?>
                                <div class="row">
                                    <div class="col-md-12 col-sm-12 main-listing-div">
                                        <!-- Modal -->
                                        <div class="modal fade" id="myModal-{{$property->id}}" role="dialog">
                                            <div class="modal-dialog">
                                                <!-- Modal content-->
                                                <div class="modal-content text-center">
                                                    <div class="modal-body">
                                                        <p>Are you sure you want to delete this property?</p> 
                                                        <div class="text-center btns-green-blue text-center">
                                                            <a href="{{route('frontend.propertyDelete',$property->id)}}" class="btn btn-green">Confirm</a>
                                                            <button type="button" class="button btn btn-blue" data-dismiss="modal">Cancel</button>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        <!-- SIDEBAR USERPIC -->
                                        <div class="listing-box">
                                            <div class="col-md-6 col-sm-12 no-padding">
                                                <div class="listing-div-img">
                                                    <?php if ($property->images->count()) { ?>
                                                        <img src="{{asset("storage/property_images/".$property->id .'/'.$property->images->first()->image)}}" class="img-responsive" alt="Property Image">
                                                    <?php } else { ?>
                                                        <img src="{{asset('/storage/site-images/image1.png')}}" class="img-responsive" alt="photo">
                                                    <?php } ?>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-12">
                                                <div class="cross-div"><span type="button" class="cross" data-toggle="modal" data-target="#myModal-{{$property->id}}"><i class="fa fa-times-circle"></i></span></div>
                                                <div class="listing-div">
                                                    <h4>{{$property->street_address??'NA'}}</h4>
                                                    <p>{{(isset($property->townhouse_apt) && !empty($property->townhouse_apt)) ? 'Apt# '. $property->townhouse_apt:''}}</p>
                                                    <p>State : <?php echo findState($property->state_id); ?></p>
                                                    <p>Home Type : {{ config('constant.home_type.'.$property->architechture['home_type'])??'NA' }}</p>
                                                    <p>Built Year : {{ $property->architechture->year_built??'NA' }}</p>
                                                </div>
                                                <div class="listing-div-icons">
                                                    <span class="icon-listing-div">
                                                        <p><i class="fa fa-bed color-green" aria-hidden="true"></i>{{ config('constant.beds.'.$property->architechture->beds)??'NA'}}</p>
                                                    </span>
                                                    <span class="icon-listing-div">
                                                        <p><i class="fa fa-square color-black" aria-hidden="true"></i>{{$property->architechture->plot_size??'NA'}}</p>
                                                    </span>

                                                    <span class="icon-listing-div">
                                                        <p><i class="fa fa-bath color-black" aria-hidden="true"></i>{{ config('constant.baths.'.$property->architechture->baths)??'NA'}}</p>
                                                    </span>
                                                    <span class="icon-listing-div">
                                                        <p><i class="fa fa-usd color-green" aria-hidden="true"></i><span class="money1">{{round($property->price)??'NA'}}</p>
                                                    </span>
                                                </div>
                                                <div>
                                                    <div>
                                                        <div>
                                                            <div class="green">
                                                                List Price : <span class="money">{{round($property->price)??'NA'}}</span>
                                                            </div>
                                                            <div class="black">
                                                                <a href="{{route('frontend.propertyDetails',$property->id)}}">PREVIEW LISTING</a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12 col-sm-12 no-padding">
                                                <div class="text-center">                                                   
                                                    <a href="{{route('frontend.saleEdit',$property->id)}}" class="btn btn-default link-button5">EDIT</a>
                                                    <a href="{{route('frontend.manageAvailablity',$property->id)}}" class="btn btn-default link-button1">MANAGE AVAILABILITY</a>
                                                    <?php if (isset($property) && ($property->status != config('constant.inverse_property_status.Unavailable') && $property->status != config('constant.inverse_property_status.In Progress') && Auth::check() && $property->user_id == Auth::id())) { ?>
                                                        <a href="{{route('frontend.changePropertyStatus',$property->id)}}" class="btn btn-default link-button1">Suspend Listing</a>
                                                        <?php
                                                    }
//                                                                   echo $property->id;die;
                                                    if (isset($property) && ($property->status == config('constant.inverse_property_status.Unavailable') || $property->status == config('constant.inverse_property_status.In Progress') ) && Auth::check() && $property->user_id == Auth::id()) {
                                                        ?>
                                                        <a href="{{route('frontend.backToMarket',$property->id)}}" class="btn btn-default custom-danger link-button5" id="">Activate Listing</a>
                                                    <?php }
                                                    ?>
                                                    <?php if (!empty($property->propertyConditionDisclaimer)) {
                                                        ?>
                                                        <a href ="{{route('frontend.disclosureBySellerUpdate',['id'=>$property->id,'page'=>'sale_list'])}}" class="btn btn-default link-button5">EDIT DISCLOSURE</a>
                                                    <?php } else {
                                                        ?>
                                                        <a href="{{route('frontend.disclosureBySellerUpdate',['id'=>$property->id,'page'=>'sale_list'])}}" class="btn btn-default link-button5">ADD DISCLOSURE</a>
                                                    <?php } ?>


                                                    <?php
                                                    if ($property->architechture->year_built != null && $property->architechture->year_built <= 1978) {

                                                        if ($property->status != config('constant.property_status.inverse_property_status.Sold') && $property->lead_based == null && $property->lead_based_report == null && count($property->saleOffer) == 0) {
                                                            ?>
                                                            <a href="{{route('frontend.leadBasedPaintHazards',$property->id)}}" class="btn btn-default link-button1">ADD LEAD-BASED PAINT HAZARDS</a>
                                                        <?php } elseif ($property->status != config('constant.property_status.inverse_property_status.Sold') && $property->lead_based != null && $property->lead_based_report != null && count($property->saleOffer) == 0) { ?>
                                                            <a href="{{route('frontend.leadBasedPaintHazards',$property->id)}}" class="btn btn-default link-button1">EDIT LEAD-BASED PAINT HAZARDS</a>
                                                        <?php } elseif (count($property->saleOffer) == 0 && $property->status == config('constant.property_status.inverse_property_status.Sold') && $property->lead_based != null && $property->lead_based_report != null) { ?>
                                                            <!-- no button shown -->
                                                        <?php } ?>

        <?php } ?>
                                                </div>
                                            </div>
                                        </div><!--profile-sidebar-->
                                    </div>
                                </div>
                                <?php
                            }
                        } else {
                            ?>
                            <div class="row">
                                <div class="col-md-12 col-sm-12 main-listing-div">
                                    <div class="">
                                        <h2 class="no-data">No Listing Found.</h2>
                                    </div><!--profile-sidebar-->
                                </div>
                            </div>

<?php } ?>
                        {{ $properties->links() }}
                    </div>
                </div>
            </div<!--right-dashboard-div-->           
        </div><!--col-9-->
    </div><!--row-->
</div><!--container-->
</div><!--dashboard-->
@endsection
@section('after-scripts')
</script>
<script>
    $('.money1').mask('000,000,000,000,000', {reverse: true});
</script>
@endsection
