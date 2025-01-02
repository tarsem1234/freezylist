@extends ('frontend.layouts.app')
@section ('title', ('Vacation Rental'))
@section('after-styles')
<link type="text/css" rel="stylesheet" href="{{ asset(mix('css/vacation-search.css')) }}" media="all">
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-glyphicons.css" />
@endsection
@section('content')
<div class="vacation-rental">
    {{ html()->form('GET', route('frontend.vacationSearching'))->class('form-horizontal')->id('vacSearch')->open() }}
    <div class="search-property-row">
        <div class="container nested-div">
            <div class="row bg-white">
                <div class="col-sm-12 bg-black">
                    <div class=" search-property-text">
                        <h4>Search Property</h4>
                    </div>
                    <div class="btn-list-map-view">
                        <a class="btn btn-list-view" data-show="list-view">List View</a>
                        <a class="btn btn-map-view" data-show="map-view">Map View</a> 
                    </div>
                </div>    
                <div class="col-sm-12 img-filter">
                    <img src="{{asset('/storage/site-images/filter.jpg')}}" alt="filter img" class="img-responsive filter-image">
                </div>
                <div class="col-sm-12 form-search-property">
                    <div class="col-sm-12 col-xs-12 nested-div"> 
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 formItem" id="property-options">
                            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12 formItem" id="property-options">
                                <div class="select formField">
                                    <label>
                                        1. Select The Property Type
                                    </label>
                                    <select class="form-control" name="category" id="cate" required="required">
                                        <option value="">Property Options</option>
                                        <option value="All">All</option>
                                        <option value="Timeshare">Timeshare</option>
                                        <option value="Owner Property">Owner Property</option>
                                    </select>
                                </div>
                                <div class="select__arrow"></div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                        <div class="row">
                            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6 formItem">
                                <div class="select formField">
                                    <label>
                                        2. Choose A Continent
                                    </label>
                                    <select class="form-control" id="region" data-msg-required="Please select region" data-rule-required="true" name="region" aria-required="true">
                                        <option value="">Global Continents</option>
                                        <?php foreach ($regions as $key => $region) { ?>
                                            <option value="{{ $region->id }}">{{ $region->region }}</option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6 formItem">
                                <div class="select formField">
                                    <label>
                                        3. Focus Your Search Area
                                    </label>
                                    <select class="select form-control" id="subregion" data-msg-required="Continental Regions" data-rule-required="true" name="subregion" aria-required="true">
                                        <option value="">Continental Regions</option>
                                        <?php foreach ($subRegions as $key => $sRegion) { ?>
                                            <option value="{{ $sRegion->id }}">{{ $sRegion->subregion }}</option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6 formItem" id="region-country">
                                <div class="select formField">
                                    <label>
                                        4. Select A Country In Your Region
                                    </label>
                                    <select class="form-control" id="country" data-msg-required="Please select country" data-rule-required="true" name="country" aria-required="true">
                                        <option>Country Selection</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-3 col-sm-4 col-xs-6 formItem" id="international-search">
                                <div class="select formField">
                                    <label>
                                        (Optional). Narrow Your International Search
                                    </label>
                                    <select disabled="disabled" class="form-control" name="city" id="non-us-city">
                                        <option value="City">International Destination City</option>
                                    </select>
                                </div>
                            </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 formItem">
                                    <div class="select formField">
                                        <label>
                                            5. Travelling Within the USA? <span class="search-diff-color">(Choose a State)</span>
                                        </label>
                                        <select class="form-control" id="state" data-msg-required="Please select state" data-rule-required="true" name="state" aria-required="true">
                                            <option value="">Select Your Destination</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 formItem">
                                    <div class="select formField">
                                        <label>
                                            (Optional). Narrow Your US Vacation Search Results
                                        </label>
                                        <select disabled="disabled" class="form-control" name="city" id="us-city">
                                            <option value="US Cities">Select Your Destination City</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        
                        
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="row">
                                <div class="col-sm-12 less-filter">
                                    <label>Advanced Filters (Optional)</label>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 formItem less-filter">
                                    <div class="select formField">
                                        <select class="form-control" name="beds" id="beds">
                                            <option value selected ="selected">Bedrooms</option>
                                            @foreach(config('constant.beds') as $key=>$bed)
                                            <option value="{{$key}}">{{$bed}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 formItem less-filter">
                                    <div class="select formField">
                                        <select class="form-control" name="baths" id="baths">
                                            <option value selected ="selected">Bathrooms</option>
                                            @foreach(config('constant.baths') as $key=>$bath)
                                            <option value="{{$key}}">{{$bath}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 formItem less-filter">
                                    <div class="select formField">
                                        <select class="form-control" name="locks" id="locks">
                                            <option value selected ="selected">Lock-Out Unit?</option>
                                            <option value="1">Yes</option>
                                            <option value="0">No</option>
                                        </select>
                                    </div>
                                </div>

                                
                                
                            </div>
                        </div>

                        <div class="col-lg-2 col-md-2 col-sm-4 col-xs-12">
                            <div class="row">
                                <div class="col-sm-12 less-filter">
                                    <label class="search-diff-color">Availability</label>
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 formItem less-filter booking-date">
                                    <div class="select formField">
                                        <input type="text" class="form-control" name="book" id="booking-datepicker" value="" placeholder="Beginning Travel Date">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-4 col-md-4 col-sm-8 col-xs-12">
                            <div class="row">
                        <div class="col-sm-12 less-filter">
                            <label class="search-diff-color">
                                Price Range
                            </label>
                        </div>
                        <div class="col-sm-12">
                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 formItem less-filter">
                                    <div class="select formField">
                                        <select class="form-control" name="pricefrom" id="pricefrom">
                                            <option value selected ="selected">Min Price</option>
                                            <option value="10000">$10000</option>
                                            <option value="20000">$20000</option>
                                            <option value="30000">$30000</option>
                                            <option value="40000">$40000</option>
                                            <option value="50000">$50000</option>
                                            <option value="60000">$60000</option>
                                            <option value="70000">$70000</option>
                                            <option value="80000">$80000</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 formItem less-filter">
                                    <div class="select formField">
                                        <select class="form-control" name="priceto" id="priceto">
                                            <option value selected ="selected">Max Price</option>
                                            <option value="10000">$10000</option>
                                            <option value="20000">$20000</option>
                                            <option value="30000">$30000</option>
                                            <option value="40000">$40000</option>
                                            <option value="50000">$50000</option>
                                            <option value="60000">$60000</option>
                                            <option value="70000">$70000</option>
                                            <option value="80000">$80000</option>
                                            <option value="90000">$90000</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </div>
                        </div>
                        
                        
                    </div>
                    <div class="col-sm-12 col-xs-12 btn-search">
                        <button type="submit" class="btn">Search</button>
                    </div> 
                    <div class="col-lg-12 col--md-12 col-sm-12 col-xs-12 explore_other_search_options">
                         <label>(Optional): Explore Other Search Options</label>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 btn-clear-less-more-filetrs margin-bottom">
                <div class="col-md-3 col-sm-4 col-xs-12 formItem" id="search-per-page">
                    <div>
                        <div id="search-limit" style="float: right">
                            <select class="form-control" name="limit" id="limit">
                                <option value="10" selected="selected">10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select>
                        </div>
                        <label class="search-diff-color" style="float: left">Results Per Page</label>
                    </div>
                </div>
                <div class="col-md-4 col-sm-5 col-xs-12 formItem pull-right" id="less-more">
                    <a class="btn btn-less-filters btns-less-more pull-right" data-show="btn-less-filters">LESS FILTERS</a>
                    <a class="btn btn-more-filters btns-less-more pull-right" data-show="btn-more-filters">ADVANCED FILTERS</a>
                    <a class="btn btn-clear-filters pull-right">START OVER</a>
                </div>
            </div>
        </div>
    </div>
    {{ html()->form()->close() }}
</div>
<?php if(isset($search)){ ?>
<div class="container">
<div class="row map-view">
    <div class="col-sm-6 img-map">
        <div id="map"></div>
    </div>
    <div class="col-sm-6 house-images-row">
        <div class="col-sm-12 properties-for-sale-heading">
            <img src="{{asset('/storage/site-images/home_icon.png')}}" alt="home_icon img" class="img-responsive">
            <h2>Available Vacation Properties</h2>
        </div>
        <div class="col-sm-12 nested-divs first-img-row">
            <?php if(count($search) > 0 ) { ?>
            @foreach($search as $srch)
            <div class="col-lg-6 col-md-12 col-sm-12 images">
                <?php if ($srch->images->count()) { ?>
                    <img src="{{asset("storage/property_images/".$srch->id .'/'.$srch->images->first()->image)}}" class="img-responsive">
                <?php } else { ?>
                    <img src="{{ asset("storage/site-images/no_image_available.jpg") }}" class="img-responsive">
                <?php } ?>
<!--                <div class="available-weeks">
                    <p><i class="fa fa-calendar" aria-hidden="true"></i>{{!$srch->availableWeeks->isEmpty() ? config('constant.available_weeks.'.$srch->availableWeeks[0]->checkin_day):"NA"}}</p>
                </div>-->
                <div class="more-info">
                    <a href="{{ route('frontend.vacationDetails',$srch->id)  }}"><i class="fa fa-arrow-circle-right" aria-hidden="true"></i>more info</a>
                </div>
                <div class="col-sm-12 col-xs-12 adress-home-type">
                    <ul>
                        <div class="left-text">
                            <li class="address"><span class="money">{{ $srch->price??"NA" }}</span></li>
                            <li class="address">{{ $srch->property_name??"NA" }}</li>
                            <li class="address"><?php echo findCountry($srch->country_id); ?></li>
                        </div>
                        <div style="float:right;" class="right-text">
                            <li class="home-type">{{ config('constant.vacation_property_type.'.$srch->property_type)??"" }}</li><br>
                            <li class="city">
                                <?php if(isset($srch->state_id) && $srch->state_id && $srch->city) {
                                    echo getCityName($srch->city);
                                } elseif($srch->city) {
                                        echo getNonUsCity($srch->city);
                                    } else { ?>
                                    
                                <?php } ?>
                            </li>
                        </div>
                    </ul>
                </div>
                <div class="col-sm-12 img-bottom-div">
                    <table>
                        <tbody>
                            <tr>
                                <td class="nested-all-divs bg-green plot-size">
                                    <p>{{!$srch->availableWeeks->isEmpty() ? config('constant.available_weeks.'.$srch->availableWeeks[0]->checkin_day):"NA"}}</p>
                                </td>
                                <td class="nested-all-divs bg-black beds">
                                    <p><i class="fa fa-bed color-green" aria-hidden="true"></i>{{ config('constant.beds.'.$srch->bedrooms)??"NA" }}</p>
                                </td>
                                <td class="nested-all-divs bg-green baths">
                                    <p>{{ config('constant.baths.'.$srch->bathrooms)??"NA" }}</p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            @endforeach
            {{ $search->appends($request->all())->links() }}
            <?php } else { ?>
                <h4 class="noprop">No Property found matching your search.</h4>
            <?php } ?>
        </div>
    </div>
</div>
</div>
<?php } ?>
<?php if( isset($search) ) { ?>
<div class="list-view">
    <div class="row properties-for-rent-row">
        <div class="container">
            <div class="row">
                <div class="col-sm-12  properties-for-rent-div">
                    <div class="col-sm-12 properties-for-rent-text">
                        <img src="{{asset('/storage/site-images/home_icon.png')}}" alt="home_icon img" class="img-responsive">
                        <h2>Properties For Vacational Rental</h2>
                    </div>
                    <div class="col-sm-9 col-xs-12 left-div">
                        <?php if(count($search)>0) { ?>
                        @foreach($search as $srch)
                        <div class="col-sm-12 col-xs-12 left-div-row">
                            <div class="col-sm-7 col-xs-12 image-div images">
                                <?php if ($srch->images->count()) { ?>
                                    <img src="{{asset("storage/property_images/".$srch->id .'/'.$srch->images->first()->image)}}" class="img-responsive">
                                <?php } else { ?>
                                    <img src="{{ asset("storage/site-images/no_image_available.jpg") }}" class="img-responsive">
                                <?php } ?>
                                <div class="more-info">
                                    <a href="{{ route('frontend.vacationDetails',$srch->id)  }}"><i class="fa fa-arrow-circle-right" aria-hidden="true"></i>more info</a>
                                </div>
                            </div>
                            <div class="col-sm-5 col-xs-12 text-div">
                                <div class="address-townhouse">
                                    <h3 class="townhouse">{{ $srch->property_name??"NA" }}</h3>
                                    <p>
                                        <?php if(isset($srch->state_id) && $srch->state_id && $srch->city) {
                                                echo getCityName($srch->city).', ';
                                            } elseif($srch->city) {
                                                echo getNonUsCity($srch->city) . ', ';
                                            } echo findCountry($srch->country_id); ?>,<?php echo ' '. findRegion($srch->region_id); ?></p>
                                </div>
                                <div class="state-plot-home">
<!--                                    <p>Is this a lock-out unit ? : &nbsp;<span>{{config('constant.lock_out_unit.'.$srch->lock_out_unit)??""}}</span></p>
                                    <p>Points Based Timeshare ? : &nbsp;<span>{{config('constant.point_based_timeshare.'.$srch->point_based_timeshare)??""}}</span></p>-->
                                    <p>	Available Week(S)  : &nbsp;<span>{{ !$srch->availableWeeks->isEmpty()? config('constant.available_weeks.'.$srch->availableWeeks->first()->available_week):"NA" }}</span></p>
                                    <p>Home Type  : &nbsp;<span>{{ config('constant.vacation_property_type.'.$srch->property_type)??"" }}</span></p>
                                    <!--<p>Willing to exchange  : &nbsp;<span>{{config('constant.exchange_timeshare.'.$srch->exchange_timeshare)??""}}</span></p>-->
                                    <p>	Ownership Type  : &nbsp;<span>{{config('constant.ownership_type.'.$srch->ownership_type)??""}}</span></p>
                                </div>
                                <div class="beds-baths-row">
                                    <table>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <p><i class="fa fa-bed color-green" aria-hidden="true"></i>{{$srch->bedrooms??"NA"}}</p>
                                                </td>
                                                <td>
                                                    <p><i class="fa fa-bath color-black" aria-hidden="true"></i>{{$srch->bathrooms??"NA"}}</p>
                                                </td>
                                                <td>
                                                    <p><i class="fa fa-square color-black" aria-hidden="true"></i>{{$srch->sleeps??"NA"}}</p>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-sm-12 col-xs-12 rent-list-price">
                                    <div class="col-lg-6 col-md-12 col-sm-12 col-xs-6 rent">
                                        <p>For Rent</p>
                                    </div>
                                    <div class="col-lg-6 col-md-12 col-sm-12 col-xs-6 list-price">
                                        <p><span class="money">${{$srch->price??"NA"}}</span></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        {{ $search->appends($request->all())->links() }}
                        <?php } else { ?>
                          <h4 class="noprop">No Property found matching your search.</h4>
                        <?php } ?>
                    </div>
                    <div class="col-sm-3 col-xs-12 right-div">
                        <div class="col-sm-12 col-xs-12 nested-div">
                            <div class="explore-products">
                                <div class="col-sm-12 col-xs-12 bg-black">
                                    <h2>Explore other &nbsp;<span>Products</span></h2>
                                </div>
                                <div class="col-sm-12 col-xs-12 bg-white">
                                    <div class="text">
                                        <p><i class="fa fa-key" aria-hidden="true"></i>
                                            For Sale Products</p>
                                    </div>
                                    <div class="text m-bottom">
                                        <p><i class="fa fa-key" aria-hidden="true"></i>
                                            Timeshares / VRBO</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-xs-12 nested-div">
                            <img src="{{asset('/storage/site-images/banner-1.png')}}" alt="banner-1 img" class="img-responsive">
                            <div class="buyers-div">
                                <h2>Buyers</h2>
                                <p>Find your dream home with us</p>
                                <div class="btn-more-info">
                                    <a href="#" class="btn">More Info</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-xs-12 nested-div p-bottom-0">
                            <img src="{{asset('/storage/site-images/banner-2.png')}}" alt="banner-2 img" class="img-responsive">
                            <div class="sellers-div">
                                <h2>Sellers</h2>
                                <div class="btn-more-info">
                                    <a href="#" class="btn">More Info</a>
                                </div>
                            </div>
                            <div class="bg-blue">
                                <p>It's Free & Easy To List Your&nbsp;<span>Properties</span></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row how-it-works-row">
        <div class="col-sm-12 col-xs-12 nested-div">
            @include('frontend.common-home-icon.common_home_icon')
            <h2>How it works</h2>
            <h4>Simple Solution - Amazing Results!</h4>
            <div class="img-work-div">
                <img src="{{asset('/storage/site-images/work.jpg')}}" alt="work img" class="img-responsive img-work">
            </div>
        </div>
    </div>
</div>
<?php } ?>

@endsection
@section('after-scripts')
<script src="https://maps.googleapis.com/maps/api/js?key=<?= config('settings.google_map_api_key') ?>"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.15.1/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.js"></script>
<!--<script src="https://cdn.rawgit.com/googlemaps/v3-utility-library/master/infobox/src/infobox.js" type="text/javascript"></script>-->
<!--<script src="https://googlemaps.github.io/js-marker-clusterer/examples/data.json"></script>-->
<script src="https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js"></script>
<!--<script src="https://googlemaps.github.io/js-marker-clusterer/src/markerclusterer.js"></script>-->
<script>
$(document).ready(function () {
    <?php if(isset($search)) { ?>
        $('#beds').val("{{$_GET['beds']??''}}");
        $('#baths').val("{{$_GET['baths']??''}}");
        $('#cate').val("{{$_GET['category']??''}}");
        $('#region').val("{{$_GET['region']??''}}");
        $('#subregion').val("{{$_GET['subregion']??''}}");
        $('#country').val("{{$_GET['country']??''}}");
        $('#state').val("{{$_GET['state']??''}}");
        <?php if($request->state) { ?>
            $('#us-city').val("{{$_GET['city']??''}}");
        <?php } else { ?>
            $('#non-us-city').val("{{$_GET['city']??''}}");
        <?php } ?>
        $('#limit').val("{{$_GET['limit']??''}}");
        $('#locks').val("{{$request->locks??''}}");
        $('#booking-datepicker').val("{{$_GET['book']??''}}");
        $('#pricefrom').val("{{$_GET['pricefrom']??''}}");
        $('#priceto').val("{{$_GET['priceto']??''}}");
        var map = new google.maps.Map(document.getElementById("map"), {
                        center: new google.maps.LatLng(<?php echo !empty($search[0]->latitude)?$search[0]->latitude: '42.73' ?>, <?php echo !empty($search[0]->longitude)?$search[0]->longitude: '-70.34'?>),
//                        center: new google.maps.LatLng(42.73, -70.34),
                        zoom: 7,
                        mapTypeId: google.maps.MapTypeId.ROADMAP,
                        streetViewControl: false, 
                    });
    <?php } ?>

    $('.btn-search button').click(function () {
        $('#vacSearch').submit();
    });

    

    function initMap(searchArray) {
        var latLongArr = [];
        $.each(searchArray, function (i, val) {
            latLongArr.push({
                lat: val.latitude,
                lng: val.longitude
            });
        });
        
        var infobox = new google.maps.InfoWindow({
            maxWidth: 250,
            boxStyle: {
                opacity: 1,
                width: "202px",
                height: "245px"
            },
            enableEventPropagation: false
        });

        var markerArray = [];
        var infoBoxes = [];
        
        <?php if(isset($search)){ foreach($search as $srch): ?>
        var infoboxContent = '<div class="infoW" id="infobox-{{$srch->id}}">' +
                        '<div class="propImg">' +
                        <?php if ($srch->images->count()) { ?>
                            '<img src="{{asset("storage/property_images/".$srch->id .'/'.$srch->images->first()->image)}}">' +
                        <?php } else { ?>
                            '<img src="{{ asset("storage/site-images/no_image_available.jpg") }}">' +
                        <?php } ?>
                        '<div class="propBg">' +
                         '<div class="propPrice"> $ {{number_format(round($srch->price))??"NA"}}</div>' +
                       
                        '<div class="propType">{{isset($srch->architechture->home_type) ? config('constant.home_type.'.$srch->architechture->home_type):"NA"}}</div>'+
                        '</div>' +
                        '</div>' +
                        '<div class="paWrapper">' +
                        '<div class="propTitle">{{$srch->street_address??"NA"}}</div>' +
                        '<div class="propAddress">{{ isset($srch->townhouse_apt) && $srch->townhouse_apt ? "Apt# ".$srch->townhouse_apt : "" }}</div>' +
                        '</div>' +
                        '<div class="propRating">' +
                        '</div>' +
                        '<ul class="propFeat">' +
                        '<li><span class="fa fa-moon-o"></span><small> {{$srch->architechture->beds??"NA"}} </small></li>' +
                        '<li><span class="icon-drop"></span><small> {{$srch->architechture->baths??"NA"}} </small></li>' +
                        '<li><span class="icon-frame"></span><small> {{$srch->architechture->plot_size??"NA"}} Sqft</small></li>' +
                        '</ul>' +
                        '<div class="clearfix"></div>' +
                        '<div class="infoButtons btns-green-blue">' +
                        // '<a class="btn btn-sm closeInfo btn-blue" onclick="hideInfoBox({{$srch->id}})">Close</a>' +
                        '<a href="{{ route('frontend.propertyDetails',$srch->id)  }}" class="btn btn-sm btn-green viewInfo">View</a>' +
                        '</div>' +
                        '</div>';
                infoBoxes.push(infoboxContent);
        <?php endforeach; } ?>

        for (var i = 0, length = latLongArr.length; i < length; i++) {
            var data = latLongArr[i],
            latLng = new google.maps.LatLng(data.lat, data.lng);
            marker = new google.maps.Marker({
                position: latLng,
                map: map,
                icon: normalIcon()
            });
            
            google.maps.event.addListener(marker,'click', (function(marker,infoboxContent,infoBoxes,i){
                return function(){
                    $('.infoBox').show();
                    infobox.setContent(infoBoxes[i]);
                    infobox.open(map, marker);
                }
            })(marker,infoboxContent,infoBoxes,i));
            markerArray.push(marker);
        }
        
        markerClusterer = new MarkerClusterer(map, markerArray, {
            maxZoom: 7,
            imagePath: 'https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m'
        });
        
        $('.images').hover(
            function(){
                var index = $('.images').index(this);
                markerArray[index].setIcon(highlightedIcon());
                var newLat = markerArray[index].getPosition().lat();
                var newLng = markerArray[index].getPosition().lng();
                markerArray[index].setZIndex(9999);
                var newCenter = new google.maps.LatLng(newLat, newLng);
                map.panTo(newCenter);
            },
            function(){
                var index = $('.images').index(this);
                markerArray[index].setIcon(normalIcon());
                markerArray[index].setZIndex(8);
            }
        );
    }
    
    function normalIcon() {
        return {
            url: 'https://maps.gstatic.com/mapfiles/api-3/images/spotlight-poi2.png'
        };
    }
    
    function highlightedIcon(){
        return {
            url: 'http://1.bp.blogspot.com/_GZzKwf6g1o8/S6xwK6CSghI/AAAAAAAAA98/_iA3r4Ehclk/s1600/marker-green.png'
        };
    }
    
    var searchArray = <?php
                                if (isset($search) && count($search)>0) {
                                    echo json_encode($search->items());
                                } else {
                                    echo "null";
                                }
                                ?>;
    if (searchArray != null) {
        initMap(searchArray);
    }
    <?php if(isset($search)){ ?>
      $('.btn-more-filters').hide();
       $('.btn-less-filters, .less-filter').show();
    <?php } ?>

    $('.btn-clear-less-more-filetrs .btns-less-more').on('click', function () {
        var $this = $(this);
        $('.' + $this.attr('data-show')).hide().siblings().show();
    });

    $(".btn-less-filters").click(function () {
        $(".less-filter").hide();
    });
    $(".btn-more-filters").click(function () {
        $(".less-filter").show();
    });

    $(document).on('click', '.btn-list-view', function () {
        $(".list-view").show();
        $(".map-view").hide();
    });
    $(document).on('click', '.btn-map-view', function () {
        $(".map-view").show();
        $(".list-view").hide();
    });


<?php if (isset($search)) { ?>
        $(".map-view,list-view").show();
        $(".btn-search").click(function (e) {
            e.preventDefault();
            $(".map-view,list-view").show();
        });
        $('.filter-image').show();
        $('.filter-image').click(function () {
            $('.form-search-property,.btn-clear-less-more-filetrs').toggle();
            $(".map-view").addClass("margin-top");
            $(".btn-clear-less-more-filetrs").removeClass("margin-bottom");
            $(".map-view,.list-view").addClass("margin-top");

        });
<?php } ?>


});
$(document).ready(function () {
//    removing select errors here
    $('#region').change(function () {
        $('#region-error').hide();
    });
    $('#checkin_day').change(function () {
        $('#checkin_day-error').hide();
    });
    $('#bathrooms').change(function () {
        $('#bathrooms-error').hide();
    });
    $('#bedrooms').change(function () {
        $('#bedrooms-error').hide();
    });
    $('#sleeps').change(function () {
        $('#sleeps-error').hide();
    });
    $('#ownership_type').change(function () {
        $('#ownership_type-error').hide();
    });
    $('#city').change(function () {
        $('#city-error').hide();
    });

    $('#subregion').prop('disabled', true);
    $('#country').prop('disabled', true);
    $('#state').prop('disabled', true);
    $('#non-us-city').prop('disabled', true);
    $('#us-city').prop('disabled', true);

    
    <?php if(isset($request) && $request->state){ ?>
            var state = "{{$request->state}}";
            var country = "{{$request->country}}";
        $.ajax({
            type: "get",
            url: "{{ route('frontend.citySearch') }}",
            data: {
                state_id: parseInt(state),
                country_id: parseInt(country),
            },
            success: function (response) {
                if (response.usCities) {
                    $('#us-city').prop('disabled', false);
                    $('#us-city').children('option').remove();
                    $('#us-city').append(response.usCities);
                    $('#us-city').val("{{$_GET['city']??''}}");
                }
            },
            error: function (error) {
            }
        });
    <?php } ?>
    $("#state").change(function (e) {
        e.preventDefault();
        $.ajax({
            type: "get",
            url: "{{ route('frontend.citySearch') }}",
            data: {
                state_id: parseInt($('#state option').filter(':selected').val()),
                country_id: parseInt($('#country option').filter(':selected').val()),
            },
            success: function (response) {
                if (response.usCities) {
                    $('#us-city').prop('disabled', false);
                    $('#us-city').children('option').remove();
                    $('#us-city').append(response.usCities);
                }
                if (!empty(response.nonUsCities)) {
                    $('#non-us-city').prop('disabled', false);
                    $('#non-us-city').children('option').remove();
                    $('#non-us-city').append(response.nonUsCities);
                }
            },
            error: function (error) {
            }
        });
    });
    <?php if(isset($request) && $request->region){ ?>
            var $this = "{{$request->region}}";
            $.ajax({
            type: "get",
            url: "{{ route('frontend.countrySearch') }}",
            data: {
                region_id: parseInt($this),
            },
            success: function (response) {
                $('#subregion').prop('disabled', false);
                $('#subregion').children('option').remove();
                $('#subregion').append(response.subregions);
                $('#subregion').val("{{$_GET['subregion']??''}}");
            },
            error: function (error) {
            }
        });
    <?php } ?>
    $("#region").change(function (e) {
        $('#country').prop('disabled', true);
        $('#state').prop('disabled', true);
        $('#us-city').prop('disabled', true);
        $('#non-us-city').prop('disabled', true);
        e.preventDefault();
        var $this = $(this);
        $.ajax({
            type: "get",
            url: "{{ route('frontend.countrySearch') }}",
            data: {
                region_id: parseInt($this.val()),
            },
            success: function (response) {
                $('#subregion').prop('disabled', false);
                $('#subregion').children('option').remove();
                $('#subregion').append(response.subregions);
                $('#non-us-city').find('option').not(':first').remove();
                $('#us-city').find('option').not(':first').remove();
                $('#state').find('option').not(':first').remove();
                $('#country').find('option').not(':first').remove();
            },
            error: function (error) {
            }
        });
    });
    <?php if(isset($request) && $request->subregion){ ?>
            var $this = "{{$request->subregion}}";
            $.ajax({
                type: "get",
                url: "{{ route('frontend.countrySearch') }}",
                data: {
                    subregion_id: parseInt($this),
                },
                success: function (response) {
                    $('#country').children('option').remove();
                    $('#country').prop('disabled', false);
    //                $('#region').prop('selectedIndex',0);
                    $('#country').append(response.countries);
                    $('#country').val("{{$_GET['country']??''}}");
                },
                error: function (error) {
                }
            });
    <?php } ?>

    $("#subregion").change(function (e) {
        e.preventDefault();
        var $this = $(this);
        $.ajax({
            type: "get",
            url: "{{ route('frontend.countrySearch') }}",
            data: {
                subregion_id: parseInt($this.val()),
            },
            success: function (response) {
                $('#country').children('option').remove();
//                $('#region').prop('selectedIndex',0);
                $('#country').prop('disabled', false);
                $('#country').append(response.countries);
                $('#non-us-city').find('option').not(':first').remove();
                $('#us-city').find('option').not(':first').remove();
                $('#state').find('option').not(':first').remove();
            },
            error: function (error) {
            }
        });
    });
    <?php if(isset($request) && $request->country){ ?>
        var getAdd = $('#country').find(":selected").text();
        var geocoder = new google.maps.Geocoder();
        geocoder.geocode({'address': getAdd}, function (results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                $('#latitude').val(results[0].geometry.location.lat());
                $('#longitude').val(results[0].geometry.location.lng());
            } else {
                console.log('Something got wrong');
            }
        });

        var usCountryExists = "{{$request->country}}";
        if (usCountryExists == 227) {
//            alert('ff');
//        $('#non-us-city').val();
            $.ajax({
                type: "get",
                url: "{{ route('frontend.stateSearch') }}",
                data: {
                    state_id: parseInt(usCountryExists),
                },
                success: function (response) {
                    $('#state').prop('disabled', false);
                    $('#state').children('option').remove();
                    $('#state').append(response.states);
                    $('#state').val("{{$_GET['state']??''}}");
                    $('#non-us-city').find('option').not(':first').remove();
                    $('#non-us-city').prop('disabled',true);
                },
                error: function (error) {
                }
            });
        } else {
//            $('#us-city').val();
            var nonUs = "{{$request->country}}";
            $.ajax({
                type: "get",
                url: "{{ route('frontend.citySearch') }}",
                data: {
                    country_id: parseInt(nonUs),
                },
                success: function (response) {
                    $('#non-us-city').prop('disabled', false);
                    $('#non-us-city').children('option').remove();
                    $('#non-us-city').append(response.cities);
                    $('#non-us-city').val("{{$_GET['city']??''}}");
                    $('#us-city').find('option').not(':first').remove();
                    $('#state').find('option').not(':first').remove();
                    $('#us-city').prop('disabled',true);
                    $('#state').prop('disabled',true);
                },
                error: function (error) {
                }
            });
        }
    <?php } ?>

    $("#country").change(function (e) {
        e.preventDefault();

        var getAdd = $(this).find(":selected").text();
        var geocoder = new google.maps.Geocoder();
        geocoder.geocode({'address': getAdd}, function (results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                $('#latitude').val(results[0].geometry.location.lat());
                $('#longitude').val(results[0].geometry.location.lng());
            } else {
                console.log('Something got wrong');
            }
        });

        var usCountryExists = $('#country option').filter(':selected').val();
        if (usCountryExists == 227) {
//            $('#non-us-city').val();
            $.ajax({
                type: "get",
                url: "{{ route('frontend.stateSearch') }}",
                data: {
                    state_id: parseInt(usCountryExists),
                },
                success: function (response) {
                    $('#state').prop('disabled', false);
                    $('#state').children('option').remove();
                    $('#state').append(response.states);
                    $('#non-us-city').find('option').not(':first').remove();
                    $('#non-us-city').prop('disabled',true);
                },
                error: function (error) {
                }
            });
        } else {
            $.ajax({
                type: "get",
                url: "{{ route('frontend.citySearch') }}",
                data: {
                    country_id: parseInt($('#country option').filter(':selected').val()),
                },
                success: function (response) {
                    $('#non-us-city').prop('disabled', false);
                    $('#non-us-city').children('option').remove();
                    $('#non-us-city').append(response.cities);
                    $('#us-city').find('option').not(':first').remove();
                    $('#state').find('option').not(':first').remove();
                    $('#us-city').prop('disabled',true);
                    $('#state').prop('disabled',true);
                },
                error: function (error) {
                }
            });
        }
    });
    $('select').select2();
    $("#booking-datepicker").datepicker({
        format: 'yyyy-mm-dd',
         autoclose: true,
        startDate: new Date()
    });
    $('.btn-clear-filters').click(function () {
        $('.form-search-property input').val('');
        $(".form-search-property select").prop('selectedIndex', 0);
        $('select').select2();
    });
});

function hideInfoBox(id){
    $('#infobox-'+id).hide();
    $('#infobox-'+id).parent('.infoBox').hide();
}
 $('.money').mask('000,000,000,000,000', {reverse: true});

</script>

@endsection   
