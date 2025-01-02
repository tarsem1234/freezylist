@extends ('frontend.layouts.app')
@section ('title', ('Property Details'))
<?php list($width, $height) = getimagesize(public_path("storage/property_images/" . $property->id . '/' . $property->images->first()->image)); ?>
<?php $fbAppId = config('settings.fb_app_id');
$fbAppVersion = config('settings.fb_app_version');
?>
<meta property="og:url" content="{{ route('frontend.propertyDetails',$property->id) }}" />
<meta property="og:type" content="website" />
<meta property="og:title" content="Freezylist" />
<meta property="og:description" content="@if($property->architechture->describe_your_home){{ $property->architechture->describe_your_home }} @else {{ $notAvailable }}  @endif" />
<meta property="og:image" content="<?php if (isset($property->images[0]->image)) { ?> {{asset("storage/property_images/".$property->id .'/'.$property->images->first()->image)}}" <?php } ?> />
<meta property="og:image:width" content="<?php echo $width; ?>">
<meta property="og:image:height" content="<?php echo $height; ?>">
<meta property="fb:app_id" content="{{ $fbAppId }}" />
@section('after-styles')
<link type="text/css" rel="stylesheet" href="{{ asset("https://cdn.datatables.net/v/bs/dt-1.10.15/datatables.min.css") }}" media="all">
<link type="text/css" rel="stylesheet" href="{{ asset(mix('css/sale-rent-search.css')) }}" media="all">
@endsection
@section('content')

<div id="fb-root"></div>
<script>
    (function (d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id))
            return;
        js = d.createElement(s);
        js.id = id;
        js.src = '//connect.facebook.net/en_GB/sdk.js#xfbml=1&version=<?php echo $fbAppVersion ?>&appId=<?php echo $fbAppId ?>';
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
</script>
<div class="detail-page-width">  
    <div class="row img-slider-row bg-white-border">
<?php $notAvailable = "NA" ?>
        <!--<div class="row">-->
        <div class="col-sm-4 col-xs-12 left-div-img">
            <div id="owl-carousel" class="owl-carousel owl-theme owl-loaded owl-drag" >
<?php if ($property->images) { ?>
                    @foreach($property->images as $image)
                    <div class="item">
                        <img src="{{asset("storage/property_images/".$property->id .'/'.$image->image)}}" alt="" class="img-responsive" data-image_width="" data-image_height="">
                    </div>
                    @endforeach
                <?php } else { ?>
                    <p>NA</p>
<?php } ?>
            </div>
        </div>
        <div class="col-sm-8 col-xs-12 right-div-data">
            <div class="col-sm-12 additional-features-row">
                <p><b>Property ID : {{$property->property_name??"NA"}}</b></p>
                <h3>Days on Market :<span> <?php echo $property->created_at->diffInDays(\Carbon\Carbon::now()); ?> days</span> </h3>
            </div>
            <div class="col-md-6 col-sm-12 left-div table-responsive">
                <table class="table">
                    <tbody>
                        <tr class="bg-grey">
                            <th class="table-heading">Baths</th>
                            <td>{{ config('constant.baths.'.$property->architechture->baths)??"NA" }} </td>
                        </tr>
                        <tr>
                            <th class="table-heading">Year Built</th>
                            <td>{{ $property->architechture->year_built??"NA" }}</td>
                        </tr>
                        <tr class="bg-grey">
                            <th class="table-heading">City</th>
                            <td>@if($city){{ $city->city }} @else {{ $notAvailable }} @endif</td>
                        </tr>
                        <tr>
                            <th class="table-heading">County</th>
                            <td class="get_country">@if($county){{ $county->county }} @else {{ $notAvailable }} @endif</td>
                        </tr>
                        <tr class="bg-grey">
                            <th class="table-heading">Beds</th>
                            <td>@if($property->architechture->beds){{ config('constant.beds.'.$property->architechture->beds) }} @else {{ $notAvailable }} @endif</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-md-6 col-sm-12 right-div table-responsive">
                <table class="table">
                    <tbody>
                        <tr>
                            <th class="table-heading">Lot Size(Acres)</th>
                            <td>@if($property->architechture->plot_size){{ $property->architechture->plot_size }} @else {{ $notAvailable }} @endif</td>
                        </tr>
                        <tr class="bg-grey">
                            <th class="table-heading">State</th>
                            <td>@if($state->state){{ $state->state }} @else {{ $notAvailable }} @endif</td>
                        </tr>
                        <tr>
                            <th class="table-heading">Zip Code</th>
                            <td class="get_zip">@if($zipCode){{ $zipCode->zipcode }} @else {{ $notAvailable }} @endif</td>
                        </tr>
                        <tr>
                            <th class="table-heading">Street Address</th>
                            <td class="get_zip">{{ $property->street_address??"" }}</td>
                        </tr>
                        <tr class="bg-grey">
                            <th class="table-heading">Townhouse/APT#</th>
                            <td class="get_house">@if($property->townhouse_apt){{ $property->townhouse_apt }} @else {{ $notAvailable }} @endif</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-sm-12 col-xs-12 all-buttons">
            <!--        <div class="col-xs-12 text-left">
                        <p>@if($property->architechture->additional_features){{ $property->architechture->additional_features }} @endif</p>
                    </div>-->
            <div class="col-md-2 col-sm-4 col-xs-6 back-to-listings particular-btn">
                <a href="{{ URL::previous() }}" class="btn">Back to Listings</a>
            </div>
            <div class="col-md-2 col-sm-4 col-xs-6 get-directions particular-btn">
                <a class="btn" id="direction-btn">Get Directions</a>
            </div>
            <?php
            if (isset($property) && ($property->status == config('constant.inverse_property_status.Unavailable')) || $property->status == config('constant.inverse_property_status.In Progress')  && Auth::check() && $property->user_id == Auth::id()) {
                ?>
                <div class="col-md-2 col-sm-4 col-xs-6 schedule-a-viewing particular-btn">
                    <a href="{{route('frontend.backToMarket',$property->id)}}" class="btn" id="">Activate Listing</a>
                </div>
            <?php } ?>
             <?php if (isset($property) && ($property->status != config('constant.inverse_property_status.Unavailable') &&  $property->status != config('constant.inverse_property_status.In Progress') && Auth::check() && $property->user_id == Auth::id())) { ?>
               <div class="col-md-2 col-sm-4 col-xs-6 schedule-a-viewing particular-btn">  
               <a href="{{route('frontend.changePropertyStatus',$property->id)}}" class="btn btn-default custom-danger link-button1">Suspend Listing</a>
               </div>           
 <?php }
            ?>
            @if(!Auth::check() || (Auth::check() && Auth::user()->id != $property->user_id))
            <div class="col-md-2 col-sm-4 col-xs-6 schedule-a-viewing particular-btn">
                @guest
                <a href="{{route('frontend.auth.login')}}" class="btn">Schedule a Viewing</a>
                @else
                <a id="view_availabilites" class="btn">Schedule a Viewing</a>
                @endguest
            </div>

            @guest
            <div class="col-md-2 col-sm-4 col-xs-6 get-directions particular-btn">
                <a href="{{route('frontend.auth.login')}}" class="btn btn-primary btn-blue">Make an Offer</a>
            </div>
            @else
            <?php if ($property->property_type == config('constant.inverse_property_type.Rent') && $property->status == config('constant.inverse_property_status.Available')) { ?>
                <div class="col-md-2 col-sm-4 col-xs-6 get-directions particular-btn">
                    <a href="{{route('frontend.rent.offer',$property->id)}}" id="" class="btn btn-primary btn-blue">Make an Offer</a>
                    <?php
//                        $rentOfferExists = false;
//                        if(isset($property->rentOffer) && count($property->rentOffer)>0){
//                            foreach($property->rentOffer as $rentOffer){
//                                if($rentOffer->buyer_id == Auth::id()) $rentOfferExists = true;
//                            }
//                        }
//                        if($rentOfferExists) {
                    ?>
                    <!--<a class="btn" id="direction-btn">Make an Offer</a>-->
                    <?php // } else {    ?>
                    <!--<a href="{{route('frontend.rent.offer',$property->id)}}" id="direction-btn" class="btn">Make an Offer</a>-->
                <?php // }    ?>
                </div>
<?php } else if ($property->property_type == config('constant.inverse_property_type.Sale') && $property->status == config('constant.inverse_property_status.Available')) { ?>
                @if(!in_array(Auth::id(), array_column($property->saleOffer->toArray(), 'buyer_id')))
                <div class="col-md-2 col-sm-4 col-xs-6 get-directions particular-btn">
                    <a href="{{route('frontend.sale.offer',$property->id)}}" id="" class="btn btn-primary btn-blue">Make an Offer</a>
                    <?php
//                        $saleOfferExists = false;
//                        if(isset($property->saleOffer) && count($property->saleOffer)>0){
//                            foreach($property->saleOffer as $saleOffer){
//                                if($saleOffer->sender_id == Auth::id()) $saleOfferExists = true;
//                            }
//                        }
//                        if($saleOfferExists) {
                    ?>
                    <!--<a class="btn" id="direction-btn" data-toggle="modal" data-target="#existedSaleOffer">Make an Offer</a>-->
                    <?php // } else {   ?>
                    <!--<a href="{{route('frontend.sale.offer',$property->id)}}" id="direction-btn" class="btn">Make an Offer</a>-->
    <?php // }    ?>
                </div>
                @endif
<?php } ?>
            @endif
            @endif
            <div class="modal fade" id="existedSaleOffer" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                        </div>
                        <div class="modal-body">
                            <p>You have already sent the offer for this property and currently it is in process. </p>
                            <p>For more details kindly check My sent offers section.</p>
                            <p>Thank you.</p>
                        </div>
                        <div class="modal-footer">
                            <div class="pull-left btns-green-blue">
                                <button  data-dismiss="modal" class="btn btn-primary btn-blue">Close</button>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            
            <!--
            @if($property->display_phone == 1 && !empty($property->user->phone_no))
            <div class="col-md-2 col-sm-4 col-xs-6 last-div phone particular-btn">
                <a class="btn phone_us">Phone: {{$property->user->phone_no??""}}</a>
            </div>
            @endif
            -->
            
            <div class= "col-md-2 col-sm-4 col-xs-6 back-to-listings particular-btn" data-href="{{route('frontend.propertyDetails',$property->id)}}" data-layout="button_count" data-size="small" data-mobile-iframe="true">
                <a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u={{urlencode(route('frontend.propertyDetails',$property->id))}}%2F&amp;src=sdkpreparse" class="btn">Share On Facebook</a>
            </div>
        </div>
    </div>
    <div class="row map-view sale-rent-detail">
        <div class="col-sm-12 img-map">
            <!--<div id="map"></div>-->
            <iframe width="100%" height="100%" frameborder="0" style="border:0"
                    src="https://www.google.com/maps/embed/v1/place?key=<?= config('settings.google_map_api_key') ?>&q={{$property->street_address . ', ' .getCityName($property->city_id).', '.findState($property->state_id)}}" allowfullscreen>
            </iframe>
        </div>
    </div>
    <div class="row all-details-div bg-white-border">
        <div class="price-property-info-tabs">
            <div class="col-sm-12 price-heading">
                <h4 class="bld">Price : &nbsp;<span class="money">{{round($property->price)??$notAvailable }} </span></h4>

                <div class="btns-price-row">
                    
                    @if($property->display_phone == 1 && !empty($property->user->phone_no))
                    <a class="btn phone_us">{Ph: {{$property->user->phone_no??""}}}</a>
                    @endif
                
                    @if(Auth::id() == $property->user->id)
                    <a href="#" class="btn btn-your-own-property">Your Own Property</a>
                    @else
                    @auth
                    <a id="view_seller_modal" class="btn btn-contact-seller">Contact Seller</a>
                    @else
                    <a href="{{ route('frontend.auth.login') }}" class="btn btn-contact-seller">Contact Seller</a>
                    @endauth
                    @endif
                </div>
            </div>
            <div class="col-sm-12 property-info-tabs">
                <ul id="ere-features-tabs" class="nav nav-tabs ">
                    <li><a href="" class="overview btn" data-show="overview-details" data-toggle="tab" aria-expanded="true">Overview</a>
                    </li>
                    <li><a href="" class="schools btn" data-show="schools-details" data-toggle="tab" aria-expanded="false">Schools</a>
                    </li>
                    <li><a href="" class="photos btn" data-show="photos-details" data-toggle="tab" aria-expanded="false">Photos</a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="overview-schools-photos">
            <div class="col-sm-12" id="overview-details">
                <div class="all-headings-values">
                    <h2>Property Details</h2>
                    <p>@if($property->architechture->describe_your_home){{ $property->architechture->describe_your_home }} @else {{ $notAvailable }}  @endif</p>
                </div>
                <div class="row general-information all-headings-values bg-grey">
                    <div class="col-sm-12">
                        <h2>General Information</h2>
                    </div>
                </div>
                <div class="row general-information-li">
                    <div class="col-sm-12">
                        <div class="col-lg-6 col-md-12 left-div table-responsive">
                            <div id="ere-overview" class="tab-pane fade in active">
                                <table class="table" id="detail-inner-table" style="width:100%; float:left;">
                                    <tbody>
                                        <tr class="bg-grey">
                                            <th class="table-heading">Beds</th>
                                            <td>@if($property->architechture->beds){{ config('constant.beds.'.$property->architechture->beds) }} @else {{ $notAvailable }}  @endif</td>
                                        </tr>
                                        <tr>
                                            <th class="table-heading">Baths</th>
                                            <td>@if($property->architechture->baths){{ config('constant.baths.'.$property->architechture->baths) }} @else {{ $notAvailable }}  @endif</td>
                                        </tr>
                                        <tr class="bg-grey">
                                           
                                            <th class="table-heading">Size of Home (Sq Ft)</th>
                                            <td>@if($property->architechture->home_size){{ config('constant.home_size')[$property->architechture->home_size] }} @else {{ $notAvailable }}  @endif</td>
                                        </tr>
                                        <tr>
                                            <th class="table-heading">Cooling Type</th>
                                            <?php
                                            if (isset($additional_information['Cooling Type'])) {
                                                $rooms = [];
                                                foreach ($additional_information['Cooling Type'] as $information) {
                                                    $rooms[] = $information->name;
                                                }
                                                $allRooms = implode(", ", $rooms);
                                                ?>
                                                <td>{{ $allRooms }}</td>
                                            <?php } else { ?>
                                                <td>{{ $notAvailable }}</td>
<?php } ?>
                                        </tr>
                                        <tr class="bg-grey">
                                            <th class="table-heading">Heating Type</th>
                                            <?php
                                            if (isset($additional_information['Heating Type'])) {
                                                $heatingType = [];
                                                foreach ($additional_information['Heating Type'] as $information) {
                                                    $heatingType[] = $information->name;
                                                }
                                                $type = implode(", ", $heatingType);
                                                ?>
                                                <td>{{ $type }}</td>
                                            <?php } else { ?>
                                                <td>{{ $notAvailable }}</td>
<?php } ?>
                                        </tr>
                                        <tr>
                                            <th class="table-heading">Total Rooms</th>
                                            <td>@if($property->architechture->total_rooms){{ $property->architechture->total_rooms }} @else {{ $notAvailable }}  @endif</td>
                                        </tr>
                                        <tr class="bg-grey">
                                            <th class="table-heading">Outdoor Amenities</th>
                                            <?php
                                            if (isset($additional_information['Outdoor Amenities'])) {
                                                $outdoor = [];
                                                foreach ($additional_information['Outdoor Amenities'] as $information) {
                                                    $outdoor[] = $information->name;
                                                }
                                                $outdoorAme = implode(", ", $outdoor);
                                                ?>
                                                <td>{{ $outdoorAme }}</td>
                                            <?php } else { ?>
                                                <td>{{ $notAvailable }}</td>
<?php } ?>
                                        </tr>
                                        <tr>
                                            <th class="table-heading">Capacity of Garage</th>
                                            <td>@if($property->architechture->garage_capacity){{ $property->architechture->garage_capacity }} @else {{ $notAvailable }}  @endif</td>
                                        </tr>
                                        <tr class="bg-grey">
                                            <th class="table-heading">View</th>
                                            <?php
                                            if (isset($additional_information['View'])) {
                                                $view = [];
                                                foreach ($additional_information['View'] as $information) {
                                                    $view[] = $information->name;
                                                }
                                                $viewAll = implode(", ", $view);
                                                ?>
                                                <td>{{ $viewAll }}</td>
                                            <?php } else { ?>
                                                <td>{{ $notAvailable }}</td>
<?php } ?>
                                        </tr>
                                        <tr>
                                            <th class="table-heading">Rooms</th>
                                            <?php
                                            if (isset($additional_information['Rooms'])) {
                                                $rooms = [];
                                                foreach ($additional_information['Rooms'] as $information) {
                                                    $rooms[] = $information->name;
                                                }
                                                $allRooms = implode(", ", $rooms);
                                                ?>
                                                <td>{{ $allRooms }}</td>
                                            <?php } else { ?>
                                                <td>{{ $notAvailable }}</td>
<?php } ?>
                                        </tr>
                                        <tr class="bg-grey">
                                            <th class="table-heading">Virtual Tour</th>
                                            @if($property->virtual_tour_url)
                                            <td><a href="{{ 'http://'.$property->virtual_tour_url}}" target="_blank">{{ $property->virtual_tour_url }}</a></td>
                                            @else
                                            <td>{{ $notAvailable }}</td>
                                            @endif
                                        </tr>
                                        <!-- only for rent-->
                                        @if($property->property_type == config('constant.inverse_property_type.Rent'))
                                        <tr>
                                            <th class="table-heading">Are Pets Welcome? </th>
                                            <td> {{(config('constant.inverse_pets_welcome.Yes') == $property->pets) ? "Yes" : "No"}} </td>
                                        </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-12 right-div table-responsive">
                            <div id="ere-overview" class="tab-pane fade in active">
                                <table class="table" id="detail-inner-table" style="width:100%; float:left;">
                                    <tbody>
                                        <tr>
                                            <th class="table-heading">Home Type</th>
                                            <td>@if($property->architechture->home_type){{ config('constant.home_type.' . $property->architechture->home_type) }} @endif</td>
                                        </tr>
                                        <tr class="bg-grey">
                                            <th class="table-heading">Updated Year</th>
                                            <td>@if($property->architechture->year_updated){{ $property->architechture->year_updated }} @else {{ $notAvailable }} @endif</td>
                                        </tr>
                                        <tr>
                                            <th class="table-heading">HOA dues/mo ($)</th>
                                            <td>@if($property->architechture->HOA_dues){{ $property->architechture->HOA_dues }} @else {{ $notAvailable }} @endif</td>
                                        </tr>
                                        <tr class="bg-grey">
                                            <th class="table-heading">Floor Covering</th>
                                            <?php
                                            if (isset($additional_information['Floor Covering'])) {
                                                $floor = [];
                                                foreach ($additional_information['Floor Covering'] as $information) {
                                                    $floor[] = $information->name;
                                                }
                                                $floorCovering = implode(", ", $floor);
                                                ?>
                                                <td>{{ $floorCovering }}</td>
                                            <?php } else { ?>
                                                <td>{{ $notAvailable }}</td>
<?php } ?>
                                        </tr>
                                        <tr>
                                            <th class="table-heading">Heating Fuel</th>
                                            <?php
                                            if (isset($additional_information['Heating Fuel'])) {
                                                $heatingF = [];
                                                foreach ($additional_information['Heating Fuel'] as $information) {
                                                    $heatingF[] = $information->name;
                                                }
                                                $heatingFuel = implode(", ", $heatingF);
                                                ?>
                                                <td>{{ $heatingFuel }}</td>
                                            <?php } else { ?>
                                                <td>{{ $notAvailable }}</td>
<?php } ?>
                                        </tr>
                                        <tr class="bg-grey">
                                            <th class="table-heading">Building/Development Amenities</th>
                                            <?php
                                            if (isset($additional_information['Building/Development Amenities'])) {
                                                $building = [];
                                                foreach ($additional_information['Building/Development Amenities'] as $information) {
                                                    $building[] = $information->name;
                                                }
                                                $buildingAme = implode(", ", $building);
                                                ?>
                                                <td>{{ $buildingAme }}</td>
                                            <?php } else { ?>
                                                <td>{{ $notAvailable }}</td>
<?php } ?>
                                        </tr>
                                        <tr>
                                            <th class="table-heading">Architectural Style</th>
                                            <?php
                                            if (isset($additional_information['Architectural Style'])) {
                                                $architectural = [];
                                                foreach ($additional_information['Architectural Style'] as $information) {
                                                    $architectural[] = $information->name;
                                                }
                                                $architecturalStyle = implode(", ", $architectural);
                                                ?>
                                                <td>{{ $architecturalStyle }}</td>
                                            <?php } else { ?>
                                                <td>{{ $notAvailable }}</td>
<?php } ?>
                                        </tr>
                                        <tr class="bg-grey">
                                            <th class="table-heading">Number of Stories</th>
                                            <td>@if($property->architechture->stories){{ $property->architechture->stories }} @endif</td>
                                        </tr>
                                        <tr>
                                            <th class="table-heading">Basement</th>
                                            <td>@if($property->architechture->basement){{ config('constant.basement.'.$property->architechture->basement) }} @else {{ $notAvailable }} @endif</td>
                                        </tr>
                                        <tr class="bg-grey">
                                            <th class="table-heading">Roof Type</th>
                                            <?php
                                            if (isset($additional_information['Roof Type'])) {
                                                $roof = [];
                                                foreach ($additional_information['Roof Type'] as $information) {
                                                    $roof[] = $information->name;
                                                }
                                                $roofType = implode(", ", $roof);
                                                ?>
                                                <td>{{ $roofType }}</td>
                                            <?php } else { ?>
                                                <td>{{ $notAvailable }}</td>
<?php } ?>
                                        </tr>
                                        <!-- only for rent-->
                                        @if($property->property_type == config('constant.inverse_property_type.Rent'))
                                        <tr>
                                            <th class="table-heading">Lease Terms Available </th>
                                            <td> {{ $property->lease_term??"NA"}} </td>
                                        </tr>
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row interior-features all-headings-values bg-grey">
                    <div class="col-sm-12">
                        <h2>Interior Features</h2>
                        <span>
                            <?php
                            if (isset($additional_information['Indoor Features'])) {
                                $interior = [];
                                foreach ($additional_information['Indoor Features'] as $information) {
                                    $interior[] = $information->name;
                                }
                                $interiorFeatures = implode(", ", $interior);
                                ?>
                                <p>{{ $interiorFeatures }}</p>
                            <?php } else { ?>
                                <p>{{ $notAvailable }}</p>
<?php } ?>
                        </span>
                    </div>
                </div>

                <div class="row exterior-features all-headings-values">
                    <div class="col-sm-12">
                        <h2>Exterior</h2>
                        <span>
                            <?php
                            if (isset($additional_information['Exterior'])) {
                                $exterior = [];
                                foreach ($additional_information['Exterior'] as $information) {
                                    $exterior[] = $information->name;
                                }
                                $exteriorFea = implode(", ", $exterior);
                                ?>
                                <p>{{ $exteriorFea }}</p>
                            <?php } else { ?>
                                <p>{{ $notAvailable }}</p>
<?php } ?>
                        </span>
                    </div>
                </div>
                <div class="row appliances all-headings-values bg-grey">
                    <div class="col-sm-12">
                        <h2>Appliances</h2>
                        <span>
                            <?php
                            if (isset($additional_information['Appliances'])) {
                                $appliances = [];
                                foreach ($additional_information['Appliances'] as $information) {
                                    $appliances[] = $information->name;
                                }
                                $appliancesAll = implode(", ", $appliances);
                                ?>
                                <p>{{ $appliancesAll }}</p>
                            <?php } else { ?>
                                <p>{{ $notAvailable }}</p>
<?php } ?>
                        </span>
                    </div>
                </div>
                <div class="row parkings all-headings-values">
                    <div class="col-sm-12">
                        <h2>Parkings</h2>
                        <span>
                            <?php
                            if (isset($additional_information['Parking'])) {
                                $parkings = [];
                                foreach ($additional_information['Parking'] as $information) {
                                    $parkings[] = $information->name;
                                }
                                $parkingsAvail = implode(", ", $parkings);
                                ?>
                                <p>{{ $parkingsAvail }}</p>
                            <?php } else { ?>
                                <p>{{ $notAvailable }}</p>
<?php } ?>
                        </span>
                    </div>
                </div>
                <div class="row additional-features all-headings-values bg-grey">
                    <div class="col-sm-12">
                        <h2>Additional Features</h2>
                        <p>@if($property->architechture->additional_features){{ $property->architechture->additional_features }} @endif</p>
                    </div>
                </div>
                <!--<div class="row">-->
<?php if ($property->favorites->count() == 0 && Auth::id() != $property->user->id) { ?>
                    <div class="btn-favorite">
                        <a href="{{ route("frontend.favorite.store",$property->id) }}" class="btn">Add To Favorites</a>
                    </div>
                <?php } ?>
<?php if ($property->architechture->year_built <= 1978) { ?>
                    <div class="btn-favorite">
                        <a href="{{ route("frontend.leadBasedPaintHazardsPdf",$property->id) }}" target="_blank" class="btn">View Lead Based Paint Disclosure</a>
                    </div>
<?php } ?>
                  <?php  if(!empty($property->propertyConditionDisclaimer)) { ?>
                <div class="btn-favorite">
                    <a href="{{ route("frontend.propertyDisclaimerPdf",$property->id) }}" target="_blank" class="btn">View Property Condition Disclosure </a>
                </div>
                  <?php }?>
            </div>
            <div id="schools-details">
                <div class="col-sm-12 all-headings-values">
                    <h2>Nearby Schools</h2>
                    <p>School District :- <a>{{ $schoolDistrict->district??"NA" }}</a></p>
                    <p>
                        School Name :-
                        <?php
                        if (count($schools) > 0) {
                            echo "<a>", implode('</a>, <a>', $schools->pluck('name')->toArray()), "</a>";
                            ?>
                        <?php } else { ?>
                            {{ $notAvailable }}
<?php } ?>
                    </p>
                </div>
            </div>
            <div id="photos-details">
                <div class="col-sm-12 all-headings-values p-right-0">
                    <h2>Photo Gallery</h2>
<?php if ($property->images) { ?>
                        @foreach($property->images as $image)
                        <div class="col-sm-4 img-photo-gallery">
                            <img src="{{asset("storage/property_images/".$property->id .'/'.$image->image)}}" alt="" class="img-responsive">
                        </div>
                        @endforeach
                    <?php } else { ?>
                        <p>NA</p>
<?php } ?>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-12 btn-back">
        <a href="{{ URL::previous() }}" class="btn">Back</a>
    </div>

    <!--contact seller modal popup-->
    <div class="modal fade" role="dialog" id="contact_seller_modal">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="col-sm-12">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Contact Seller</h4>
                    </div>
                </div>
                <div class="modal-body">
                    <form action="{{route('frontend.contactMessage')}}" method="POST" class="form-horizontal list-seller-form">
                        @csrf
                        <input type="hidden" name="user_id" value="{{ encrypt($property->user_id) }}">
                        <input type="hidden" name="property_id" value="{{ encrypt($property->id) }}">
                        <div class="row form-group">
                            <div class="col-sm-12">
                                <div class="col-sm-3"><label for="seller-message">Message</label></div>
                                <div class="col-sm-9">
                                    <textarea name="message" class="message-seller"></textarea>
                                </div>
                            </div>
                            <div class="col-sm-offset-3 col-sm-9 btns-green-blue">
                                <button type="submit" name="submit" class="btn btn-primary btn-blue">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" role="dialog" id="availablity_modal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Schedule Meeting</h4>
                </div>
                <div class="modal-body">
                    @if(!$property->availability->isEmpty())
                    <p class="text tex-info">
                        Property owner added following selected availability dates.
                        You need to click on marked date and confirm the schedule.
                        You can schedule only one date.
                    </p>
                    <div id="calendar"></div>
                    @else
                    <div class="alert alert-info">
                        Property owner not available for any date.
                    </div>
                    @endif
                </div>
                <div class="modal fade" role="dialog" id="time-modal">
                    <div class="modal-dialog modal-md">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Meeting Time</h4>
                            </div>
                            <div class="modal-body" id="vue-el">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Date</th>
                                            <th>Time</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="event,i in events">
                                            <td>@{{i+1}}</td>
                                            <td>@{{event.date}}</td>
                                            <td>@{{formatTime(event.start_time) +" - "+formatTime(event.end_time)}}</td>
                                            <td class="btns-green-blue"><a class="btn btn-blue" @click="confirmModel(event.id)">Confirm</a></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" role="dialog" id="confirm-modal">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-body btns-green-blue text-center">
                    <i class="fa fa-warning fa-2x text-success"></i>
                    <p>Are you sure you want to confirm this date and time?</p>
                    <a class="btn btn-blue" href="#" id="confirm_link">Yes</a>
                    <button class="btn btn-default"data-dismiss="modal">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</div> 
@endsection

@section('after-scripts')
<script src="{{ asset("https://cdn.datatables.net/v/bs/dt-1.10.15/datatables.min.js") }}"></script>
<script src="{{ asset("js/backend/plugin/datatables/dataTables-extend.js") }}"></script>
<script src="{{ asset("js/jquery.mask.js") }}"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=<?= config('settings.google_map_api_key') ?>"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.min.css" rel="stylesheet" type="text/css"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.15.1/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.min.js"></script>
<script>
//    $('.fb-share-button').onclick = function() {
//        FB.ui({
//            method: 'share',
//            display: 'popup',
//            href: 'https://developers.facebook.com/docs/',
//        }, function(response){});
//    }
    var events = <?= $property->availability ?>;
    var eventGroups = <?= $property->availability->groupBy('date') ?>;
    var selectedEvent = [];
    function adjustContainer() {
        $('.detail-page-width').removeClass('container container-fluid');
        $(window).width() > 1286 ? $('.detail-page-width').addClass('container') : $('.detail-page-width').addClass('');
    }
    $(document).ready(function () {

//        if($(window).width() = ){
//
//        }

        $('.item img').attr("data-image_width", $('.item img').width());
        $('.item img').attr("data-image_height", $('.item img').width());

        adjustContainer();
        $(window).on('resize', function () {
            adjustContainer();
        });
        $('#direction-btn').click(function () {
            $('.map-view').toggle();
        });
        $('#ere-features-tabs a').on('click', function () {
            var $this = $(this);
            $('#' + $this.attr('data-show')).show().siblings().hide();
        });
        $("#owl-carousel").owlCarousel({
            responsive: {
                0: {
                    items: 1
                },
                480: {
                    items: 1
                },
                767: {
                    items: 1
                },
                991: {
                    items: 1
                }
            }
        });

        /*Schedule Meeting Code starts here*/
        var vueEl = new Vue({
            el: '#vue-el',
            data: {events: []},
            methods: {
                formatTime(tm) {
                    return moment("2018-01-01 " + tm).format("hh:mm a");
                },
                confirmModel(id) {
                    $('#confirm_link').attr('href', "{{url('property/confirm_availability')}}/" + id);
                    $('#confirm-modal').modal('show');
                }
            }
        });
        $('#view_availabilites').click(function () {
            $('#availablity_modal').modal('show');
        });
        $("#view_seller_modal").click(function () {
            $("#contact_seller_modal").modal('show');
        });
        $('#calendar').fullCalendar({
            header: {
                left: 'title',
                right: 'prev,next today'
            },
            selectable: false,
            eventAfterAllRender() {
                updateSelectedEvents();
            }
        });
        function updateSelectedEvents() {
            $.each(events, function (i, event) {
                $('[data-date=' + event.date + ']').addClass('selectedEvent');
            });
        }
        $('.selectedEvent').on('click', function () {
            $('#time-modal').modal('show');
            selectedEvent = eventGroups[$(this).data('date')];
            vueEl.$data.events = selectedEvent;
        });
        /*Schedule Meeting Code ends here*/

        $('.phone_us').mask('(000) 000-0000');
        $('.money').mask('000,000,000,000,000', {reverse: true});
    });
</script>
@endsection
