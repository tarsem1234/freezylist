 
@extends ('frontend.layouts.app')

@section ('title', ('Search Map-List View'))

@section('after-styles')
<link type="text/css" rel="stylesheet" href="{{ asset(mix('css/sale-rent-search.css')) }}" media="all">
@endsection

@section('content')

<style>
    .select2-container .select2-selection span.select2-selection__arrow {
        display: inline;
    }
</style>
<div class="row">
    <div class="rent-listings-bg-img">
       <!--<img src="/storage/site-images/common_banner.jpg" class="img-responsive" />-->
        <img src="{{asset('/storage/site-images/common_banner.jpg')}}" alt="common_banner img" class="img-responsive">
        <div class="rent-listings-text">
            @if(isset($search))
            <?php if ($search[0]->property_type == config('constant.inverse_property_type.Sale')) { ?>
                <h1>{{ config('constant.property_type.2') }}&nbsp;Listings</h1>
            <?php } else { ?>
                <h1>{{ config('constant.property_type.1') }}&nbsp;Listings</h1>
            <?php } ?>
            @else
            <h1>Listings</h1>
            @endif
        </div>
    </div>
</div>
<div class="row search-property-row">
    <div class="container nested-div">
        <div class="row bg-white">
            <div class="col-sm-12 bg-black">
                <div class=" search-property-text">
                    <h4>Search Property</h4>
                </div>
                <!--</div>-->
                <div class="btn-list-map-view">
                    <a class="btn btn-list-view" data-show="list-view">List View</a>
                    <a class="btn btn-map-view" data-show="map-view">Map View</a> 
                </div>
            </div>  
            <div class="col-sm-12 img-filter">
                <img src="{{asset('/storage/site-images/filter.jpg')}}" alt="filter img" class="img-responsive">
            </div>
            {{ html()->form('GET', route('frontend.propertySearch'))->class('form-horizontal')->id('searchAction')->open() }}
            <div class="col-sm-12 form-search-property">
                <div class="col-sm-12 nested-div">
                    <div class="col-sm-2 formItem">
                        <div class="formField">
                            <select class="form-control" name="type" id="type">
                                <option disabled="disabled">Please select property</option>
                                <option value="{{config('constant.property_type.1')}}" <?php
                                if (isset($search) && !empty($search)) {
                                    if ($search[0]->property_type == config('constant.inverse_property_type.Rent')) {
                                        ?>
                                                selected="selected" 
                                                <?php
                                            }
                                        }
                                        ?>>Rent</option>
                                <option value="{{config('constant.property_type.2')}}" <?php
                                if (isset($search) && !empty($search)) {
                                    if ($search[0]->property_type == config('constant.inverse_property_type.Sale')) {
                                        ?>
                                                selected="selected" 
                                                <?php
                                            }
                                        }
                                        ?>>Sale</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-2 formItem">
                        <div class="formField">
                            <select class="form-control" name="radius" id="radius">
                                <option value selected ="selected">Miles of Zip</option>
                                <option value="10">10 Miles</option>
                                <option value="25">25 Miles</option>
                                <option value="50">50 Miles</option>
                                <option value="100">100 Miles</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-2 formItem less-filter">
                        <div class="formField">
                            <select class="form-control" name="beds" id="beds">
                                <option value selected ="selected">Beds</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                                <option value="7">7</option>
                                <option value="8">8</option>
                                <option value="9">9</option>
                                <option value="10+">10+</option>
                            </select>
                        </div> 
                    </div>
                    <div class="col-sm-6 formItem">
                        <div class="formField input_container">
                            <input type="text" class="form-control" name="zip" placeholder="Address & Zip Code" value="" id="country_id">
                            <input type="hidden" class="form-control" name="zipp" id="country_idd">
                            <ul id="country_list_id"></ul>
                        </div>
                    </div>
                    <input type="hidden" name="latitude" id="latitude" value="">
                    <input type="hidden" name="longitude" id="longitude" value="">
                </div>
                <div class="col-sm-12 nested-div">
                    <div class="col-sm-2 formItem less-filter">
                        <div class="formField">
                            <select class="form-control" name="baths" id="baths">
                                <option value selected ="selected">Baths</option>
                                <option value="0.5">.5</option>
                                <option value="1">1</option>
                                <option value="1.5">1.5</option>
                                <option value="2">2</option>
                                <option value="2.5">2.5</option>
                                <option value="3">3</option>
                                <option value="3.5">3.5</option>
                                <option value="4+">4+</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-2 formItem less-filter">
                        <div class="form-content">
                            <select name="proptype" class="form-control">
                                <option value selected ="selected">Property Type</option>
                                <option value="Single Family Home">Single Family Home</option>
                                <option value="Condominium">Condominium</option>
                                <option value="Modular">Modular</option>
                                <option value="Townhouse">Townhouse</option>
                                <option value="Multi-Family">Multi-Family</option>
                                <option value="Coop Unit">Coop Unit</option>
                                <option value="Vacant Land">Vacant Land</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm-2 formItem less-filter">
                        <div class="form-content">
                            <select id="plotsize" name="plotsize" class="form-control">
                                <option value selected ="selected">Plot Size &gt;</option>
                                <option value="250">250-500</option>
                                <option value="500">500-750</option>
                                <option value="750">750-1000</option>
                                <option value="1000">1000-1250</option>
                                <option value="1250">1250-1500</option>
                                <option value="1500">1500-1750</option>
                                <option value="1750">1750-2000</option>
                            </select>

                        </div>
                    </div>
                    <div class="col-sm-2 formItem less-filter">
                        <div class="form-content">
                            <input type="text" class="form-control" name="schoolDistrict" placeholder="School District" onkeyup="autocomplet_school()" id="school_id">
                            <ul id="school_list_id">
                            </ul>
                        </div>
                    </div>
                    <div class="col-sm-2 formItem less-filter">
                        <div class="formField">
                            <select name="pricefrom" class="form-control" id="pricefrom">
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
                    <div class="col-sm-2 formItem less-filter">
                        <div class="formField">
                            <select name="priceto" class="form-control">
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
                <div class="col-sm-12 nested-div">
                    <div class="col-sm-2 formItem less-filter">
                        <div class="form-content formField">
                            <input type="text" class="form-control" name="builtYear" value="" placeholder="Built Year from">
                        </div>
                    </div>
                    <div class="col-sm-2 formItem less-filter">
                        <div class="form-content formField">
                            <input type="text" class="form-control" name="builtmax" value="" placeholder="Built Year to">
                        </div>
                    </div>
                    <div class="col-sm-2 formItem less-filter">
                        <div class="formField">
                            <select class="form-control" name="limit" id="limit">
                                <option value selected ="selected">Results per page</option>
                                <option value="10">10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select>
                        </div>
                    </div>
                    <!--<div id="rentadv">-->
                    <div class="col-sm-2 formItem less-filter">
                        <div class="formField">
                            <select class="form-control" name="pets" id="pets">
                                <option value selected ="selected">Pets Welcome</option>
                                <option value="Yes">Yes</option>
                                <option value="No">No</option>
                            </select>
                        </div>   
                    </div>
                    <div class="col-sm-2 formItem less-filter">
                        <div class="formField">
                            <select class="form-control" name="lease" id="lease">
                                <option value selected ="selected">Lease Terms</option>
                                <option value="Month To Month">Month-To-Month</option>
                                <option value="Less than 6 Months"> &lt; 6 Months  </option>
                                <option value="6 to 12 Months"> 6-12 Month</option>
                                <option value="More than 1 Year"> &gt; 1 Year  </option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-xs-12 btn-search">
                    <button type="submit" class="btn btn-search" id="search_loc">Search</button>
                </div>
            </div>
            {{ html()->form()->close() }}
        </div>
        <div class="btn-clear-less-more-filetrs">
            <a class="btn btn-clear-filters">Clear Filters</a>
            <a class="btn btn-less-filters btns-less-more" data-show="btn-less-filters">Less Filters</a>
            <a class="btn btn-more-filters btns-less-more" data-show="btn-more-filters">More Filters</a>
        </div>
    </div> 
</div>
@if(isset($search) )
<div class="container">
<div class="row map-view">
    <div class="col-sm-6 img-map">
        <div id="map"></div>
    </div>
    <div class="col-sm-6 house-images-row"> 
        <div class="col-sm-12 properties-for-sale-heading">
            <img src="{{asset('/storage/site-images/home_icon.png')}}" alt="home_icon img" class="img-responsive">
            <?php if ($search[0]->property_type == config('constant.inverse_property_type.Sale')) { ?>
                <h2>Properties For&nbsp;{{ config('constant.property_type.2') }}</h2>
            <?php } else { ?>
                <h2>Properties For&nbsp;{{ config('constant.property_type.1') }}</h2>
            <?php } ?>
            <h4>Search your House</h4>
        </div>
        <div class="col-sm-12 nested-divs first-img-row">
            @foreach($search as $srch)

            <div class="col-sm-6 images">
                <?php if ($srch->images->count()) { ?>
                    <img src="{{ asset("storage".'/'.$srch->images[0]->image) }}" class="img-responsive">
                <?php } else { ?>
                    <img src="{{ asset("storage/site-images/no_image_available.jpg") }}" class="img-responsive">
                <?php } ?>
                <div class="more-info">
                    <a href="{{ route('frontend.propertyDetails',$srch->id)  }}"><i class="fa fa-arrow-circle-right" aria-hidden="true"></i>more info</a>
                </div>
                <div class="col-sm-12 adress-home-type">
                    <ul>
                        <div class="left-text">
                            <li class="address">{{ $srch->street_address }}</li>
                            <li class="townhouse">{{ isset($srch->townhouse_apt) && $srch->townhouse_apt ? "Apt# ".$srch->townhouse_apt : "NA" }}</li>
                        </div>
                        <div class="right-text">
                            <li class="home-type">{{ config('constant.home_type.'.$srch->architechture->home_type)??"" }}</li>
                        </div>
                    </ul>
                </div>
                <div class="col-sm-12 img-bottom-div">
                    <table>
                        <tbody>
                            <tr>
                                <td class="nested-all-divs bg-green">
                                    <p><i class="fa fa-square color-black" aria-hidden="true"></i>{{$srch->architechture->plot_size}}&nbsp;SqFt</p>
                                </td>
                                <td class="nested-all-divs bg-black beds">
                                    <p><i class="fa fa-bed color-green" aria-hidden="true"></i>{{$srch->architechture->beds}}</p>
                                </td>
                                <td class="nested-all-divs bg-green baths">
                                    <p><i class="fa fa-bath color-black" aria-hidden="true"></i>{{$srch->architechture->baths}}</p>
                                </td>
                                <td class="nested-all-divs price-div">
                                    <p><i class="fa fa-usd color-green" aria-hidden="true"></i>{{$srch->price}}</p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            @endforeach    
        </div>
    </div>
</div> 
</div>
@endif
@if( isset($search) )
<div class="list-view">
    <div class="row properties-for-rent-row">
        <div class="container">
            <div class="row">
                <div class="col-sm-12  properties-for-rent-div">
                    <div class="col-sm-12 properties-for-rent-text">
                        <img src="{{asset('/storage/site-images/home_icon.png')}}" alt="home_icon img" class="img-responsive">
                        <?php if ($search[0]->property_type == config('constant.inverse_property_type.Sale')) { ?>
                            <h2>Properties For&nbsp;{{ config('constant.property_type.2') }}</h2>
                        <?php } else { ?>
                            <h2>Properties For&nbsp;{{ config('constant.property_type.1') }}</h2>
                        <?php } ?>
                        <h4>Search your House</h4>
                    </div>

                    <div class="col-sm-9 left-div">
                        @foreach($search as $srch)
                        <div class="col-sm-12 left-div-row">
                            <div class="col-sm-7 image-div">
                                <?php if ($srch->images->count()) { ?>
                                    <img src="{{ asset("storage".'/'.$srch->images[0]->image) }}" class="img-responsive">
                                <?php } else { ?>
                                    <img src="{{ asset("storage/site-images/no_image_available.jpg") }}" class="img-responsive">
                                <?php } ?>
                                <div class="more-info">
                                    <a href="{{ route('frontend.propertyDetails',$srch->id)  }}"><i class="fa fa-arrow-circle-right" aria-hidden="true"></i>more info</a>
                                </div>
                            </div>
                            <div class="col-sm-5 text-div">
                                <div class="address-townhouse">
                                    <h3 class="street-address">{{ $srch->street_address }}</h3>
                                    <h3 class="townhouse">{{ $srch->townhouse_apt }}</h3>
                                </div>
                                <div class="state-plot-home">
                                    <p>State :&nbsp;<span><?php echo findState($srch->state_id); ?></span></p>
                                    <p>Lot Size :&nbsp;<span>4 acres</span></p>
                                    <p>Home Type :&nbsp;<span>{{ config('constant.home_type.'.$srch->architechture->home_type) }}</span></p>
                                </div>
                                <div class="beds-baths-row">
                                    <table> 
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <p><i class="fa fa-bed color-green" aria-hidden="true"></i>{{$srch->architechture->beds}}</p>
                                                </td>
                                                <td>
                                                    <p><i class="fa fa-bath color-black" aria-hidden="true"></i>{{$srch->architechture->baths}}</p>
                                                </td>
                                                <td>
                                                    <p><i class="fa fa-square color-black" aria-hidden="true"></i>{{$srch->architechture->plot_size}}&nbsp;SqFt</p>
                                                </td>
                                                <td class="last-child">
                                                    <p><span>Pets :&nbsp</span>allowed</p>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-sm-12 rent-list-price">
                                    <div class="col-sm-6 rent">
                                        <p>For Rent</p>
                                    </div>
                                    <div class="col-sm-6 list-price">
                                        <p>List Price :&nbsp;<span class="money">${{round($srch->price)??"NA"}}</span></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach    
                    </div>
                    <div class="col-sm-3 right-div">
                        <div class="col-sm-12 nested-div">
                            <div class="explore-products">
                                <div class="col-sm-12 bg-black">
                                    <h2>Explore other &nbsp;<span>Products</span></h2>
                                </div>
                                <div class="col-sm-12 bg-white">
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
                        <div class="col-sm-12 nested-div">
                            <img src="{{asset('/storage/site-images/banner-1.png')}}" alt="banner-1 img" class="img-responsive">
                            <div class="buyers-div">
                                <h2>Buyers</h2>
                                <p>Find your dream home with us</p>
                                <div class="btn-more-info">
                                    <a href="#" class="btn">More Info</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 nested-div p-bottom-0">
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
        <div class="col-sm-12 nested-div">
            @include('frontend.common-home-icon.common_home_icon')
            <h2>How it works</h2>
            <h4>Simple Solution - Amazing Results!</h4>
            <img src="{{asset('/storage/site-images/work.jpg')}}" alt="work img" class="img-responsive img-work">
        </div>
    </div>
</div>
@endif
@endsection
@section('after-scripts')
<script src="https://maps.googleapis.com/maps/api/js?key=<?= config('settings.google_map_api_key') ?>"></script>
<script>
    $(document).ready(function () {

        $('select').select2();
        $('form').validate();

        $('.btn-search button').click(function () {
            $('#searchAction').submit();
        });

        function initMap(searchArray) {
            var latLongArr = [];
            $.each(searchArray, function (i, val) {
                latLongArr.push({
                    lat: val.latitude,
                    lng: val.longitude
                });
            });

            var map = new google.maps.Map(document.getElementById("map"), {
                center: new google.maps.LatLng(42.73, -70.34),
                zoom: 6,
                mapTypeId: google.maps.MapTypeId.ROADMAP,
                streetViewControl: false, 
            });

            for (var i = 0, length = latLongArr.length; i < length; i++) {
                var data = latLongArr[i],
                        latLng = new google.maps.LatLng(data.lat, data.lng);
                var marker = new google.maps.Marker({
                    position: latLng,
                    map: map
                });
            }
        }
        var searchArray = <?php if(isset($search)){echo json_encode($search);} else {echo "null";}?>;
        if(searchArray !=null){
           initMap(searchArray);
        }


//    google.maps.event.addDomListener(window, 'load', initMap);

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
        <?php } ?>

    });
 $('.money').mask('000,000,000,000,000', {reverse: true});

</script>

@endsection   
