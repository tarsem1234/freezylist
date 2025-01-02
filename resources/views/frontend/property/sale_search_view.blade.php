@extends ('frontend.layouts.app')

@section ('title', ('Sale Search Map-List View'))

@section('after-styles')
<link type="text/css" rel="stylesheet" href="{{ asset(mix('css/sale-rent-search.css')) }}" media="all">
<link type="text/css" rel="stylesheet" href="{{ asset(mix('css/vacation-search.css')) }}" media="all">
@endsection
@section('content')

<div class="sale-listings">
    {{ html()->form('GET', route('frontend.searchedSale'))->class('form-horizontal')->id('searchAction')->open() }}
    <div class="search-property-row">
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
                    <img src="{{asset('/storage/site-images/filter.jpg')}}" alt="filter img" class="img-responsive filter-image">
                </div>

                <input type="hidden" value="Sale" name="type">
                <div class="col-sm-12 form-search-property">
                    <div class="col-sm-12 col-xs-12 nested-div">
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6 formItem">
                            <div class="formField">
                                <label>1. Select Your State</label>
                                <select class="form-control" name="state" id="state" required="true" data-msg-required="Select State">
                                    <option value="" selected ="selected">Select State</option>
				    <?php foreach ($states as $state) { ?>
    				    <option value="{{$state->id}}" data-state="{{$state->state}}" <?php if (isset($data['state']) && $state->id == $data['state']) {
					echo "selected ='selected'";
				    } ?>>
    					{{$state->state}}
    				    </option>
<?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-xs-12 nested-div">
                        <label>2. Choose Search Criteria <span class="search-diff-color">(Only Select One Of The Below Options)</span></label>
                    </div>
                    <div class="col-sm-12 col-xs-12 nested-div">
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6 formItem">
                            <div class="formField input_container parent_vertical_bar">
				<span class="vertical-bar"></span>
				<select class="form-control search_criteria_select" name="zip" value="{{$data['zip']??''}}" id="zip-code" disabled>
                                    <option value="" selected="selected">Search By Zip Code</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6 formItem">
                            <div class="formField parent_vertical_bar">
				<span class="vertical-bar"></span>
                                <select class="form-control search_criteria_select" name="city" id="city" disabled>
                                    <option value="" selected ="selected">Search By City</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6 formItem">
                            <div class="formField parent_vertical_bar">
				<span class="vertical-bar"></span>
				<select class="form-control search_criteria_select" name="military_location" disabled id="military_location">
                                    <option value="" selected ="selected">Search By Military Locations</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6 formItem">
                            <div class="formField">
                                <select class="form-control search_criteria_select" name="county" id="county" disabled>
                                    <option value="" selected ="selected">Search By County</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-xs-12 nested-div">
                        <label>3. Interested In Extending Your Search Area? <span class="search-diff-color">(Not Available When Searching By County)</span></label>
                    </div>
                    <div class="col-sm-12 col-xs-12 nested-div">
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6 formItem">
                            <div class="formField">
                                <select class="form-control" name="radius" id="radius">
                                    <option value>Miles of zip</option>
                                    <option value="10">10 Miles</option>
                                    <option value="25">25 Miles</option>
                                    <option value="50">50 Miles</option>
                                    <option value="100">100 Miles</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-xs-12 nested-div formItem less-filter">
                        <label>Advanced Filters (Optional)</label>
                    </div>
                    <div class="col-sm-12 col-xs-12 nested-div">
                        <div class="col-lg-2 col-md-3 col-sm-4 formItem less-filter">
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
                                    <option value="10">10</option>
                                    <option value="11">10+</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-3 col-sm-4 formItem less-filter">
                            <div class="formField">
                                <select class="form-control" name="baths" id="baths">
                                    <option value selected ="selected">Baths</option>
                                    @foreach(config('constant.baths') as $key=>$bath)
                                    <option value="{{$key}}">{{$bath}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-3 col-sm-4 formItem less-filter">
                            <div class="form-content">
                                <select name="proptype" id="proptype" class="form-control">
                                    <option value selected ="selected">Property Type</option>
                                    @foreach(config('constant.home_type') as $key=>$home)
                                    <option value="{{$key}}">{{$home}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-4 formItem less-filter">
                            <div class="form-content">
                                <select id="home_size" name="home_size" class="form-control">
                                    <option value selected ="selected">Size of Home (Sq Ft)</option>
                                    @foreach(config('constant.home_size') as $key=>$plot)
                                    <option value="{{$key}}">{{$plot}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-4 formItem less-filter">
                            <div class="form-content">
                                <input type="text" name="street_address" id="street_address" class="form-control" placeholder="Search By Street Address">
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 nested-div less-filter">
                        <div class="col-lg-4 col-md-5 col-sm-6 formItem less-filter">
                            <div class="col-sm-12">
                                <div class="row">
                                    <label class="search-diff-color">Price Range</label>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 formItem less-filter">
                                <div class="formField range-padd-set">
                                    <select name="pricefrom" id="pricefrom" class="form-control">
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
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 formItem less-filter">
                                <div class="formField">
                                    <select name="priceto" id="priceto" class="form-control">
                                        <option value selected ="selected">Max Price</option>
                                        <option value="10000">$10000</option>
                                        <option value="20000">$20000</option>
                                        <option value="30000">$30000</option>
                                        <option value="40000">$40000</option>
                                        <option value="50000">$50000</option>
                                        <option value="60000">$60000</option>
                                        <option value="70000">$70000</option>
                                        <option value="80000">$80000</option>
                                        <option value="90000">$90000+</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-5 col-sm-6 formItem less-filter">
                            <div class="col-sm-12">
                                <div class="row">
                                    <label class="search-diff-color">Lot Size Range (Acres)</label>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 formItem less-filter">
                                <div class="formField">
                                    <select name="acreagefrom" id="acreagefrom" class="form-control">
                                        <option value selected ="selected">Min Acreage</option>
                                        <option value="0">0</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="5">5</option>
                                        <option value="10">10</option>
                                        <option value="20">20</option>
                                        <option value="30">30</option>
                                        <option value="40">40</option>
                                        <option value="50">50</option>
                                        <option value="75">75</option>
                                        <option value="100">100</option>
                                        <option value="150">150</option>
                                        <option value="200">200</option>
                                        <option value="300">300</option>
                                        <option value="400">400</option>
                                        <option value="500">500</option>
                                        <option value="600">600</option>
                                        <option value="700">700</option>
                                        <option value="800">800</option>
                                        <option value="900">900</option>
                                        <option value="1000">1000</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 formItem less-filter">
                                <div class="formField">
                                    <select name="acreageto" id="acreageto" class="form-control">
                                        <option value selected ="selected">Max Acreage</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="5">5</option>
                                        <option value="10">10</option>
                                        <option value="20">20</option>
                                        <option value="30">30</option>
                                        <option value="40">40</option>
                                        <option value="50">50</option>
                                        <option value="75">75</option>
                                        <option value="100">100</option>
                                        <option value="150">150</option>
                                        <option value="200">200</option>
                                        <option value="300">300</option>
                                        <option value="400">400</option>
                                        <option value="500">500</option>
                                        <option value="600">600</option>
                                        <option value="700">700</option>
                                        <option value="800">800</option>
                                        <option value="900">900</option>
                                        <option value="1000">1000</option>
                                    </select>
                                </div>
                            </div>
			</div>

			<div class="col-lg-4 col-md-5 col-sm-6 formItem less-filter">
			    <div class="col-sm-12">
				<div class="row">
				    <label class="search-diff-color">Property Age</label>
				</div>
			    </div>
			    <div class="formItem less-filter">
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 formItem less-filter built-year-from">
				    <div class="form-content formField">
					<input type="text" pattern="\d*" maxlength="4" class="form-control" id="builtYear" name="builtYear" value="{{$data['builtYear']??""}}" placeholder="Year Built (From)">
				    </div>
				</div>
				<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 formItem less-filter">
				    <div class="form-content formField">
					<input type="text" pattern="\d*" maxlength="4" class="form-control" name="builtmax" id="builtmax" value="{{$data['builtmax']??""}}" placeholder="Year Built (To)">
				    </div>
				</div>
			    </div>
			</div>





                    </div>

                    <div class="col-sm-12 col-md-12 btn-search">
                        <button type="submit" class="btn" id="search_loc">Search</button>
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
                            <select class="form-control" name="limit" id="sele-limit">
                                <option value="10" selected>10</option>
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
@if(isset($search))
<div class="container">
    <div class="row map-view">
	<div class="col-sm-6 img-map">
	    <div id="map"></div>
	</div> 
	<div class="col-sm-6 house-images-row">
	    <div class="col-sm-12 properties-for-sale-heading">
		<img src="{{asset('/storage/site-images/home_icon.png')}}" alt="home_icon img" class="img-responsive">
                <h2>Properties For&nbsp;{{ config('constant.property_type.2') }}</h2>
		<h4>Search your House</h4>
	    </div>
	    <div class="col-sm-12 nested-divs first-img-row">
<?php if (count($search) > 0) { ?>
    		@foreach($search as $srch)
    		<div class="col-lg-6 col-md-12 col-sm-12 images">  
    		    <!--<div class="image">-->
			<?php if ($srch->images->count()) { ?>
	                    <img src="{{asset("storage/property_images/".$srch->id .'/'.$srch->images->first()->image)}}" class="img-responsive">
			<?php } else { ?>
	                    <img src="{{ asset("storage/site-images/no_image_available.jpg") }}" class="img-responsive">
    <?php } ?>
    		    <div class="price">
    			<p><span class="money">{{ round($srch->price)??"NA" }}</span></p> 
    		    </div>
    		    <div class="more-info">
    			<a href="{{ route('frontend.propertyDetails',$srch->id)  }}"><i class="fa fa-arrow-circle-right" aria-hidden="true"></i>more info</a>
    		    </div>
    		    <div class="col-sm-12 col-xs-12 adress-home-type">
    			<ul>
    			    <div class="left-text">
    				<li class="address">{{ $srch->street_address??"NA" }}</li>
    				@if(isset($srch->townhouse_apt) && $srch->townhouse_apt)
    				<li class="townhouse">{{ (isset($srch->townhouse_apt) && $srch->townhouse_apt) ? "Apt# ".$srch->townhouse_apt : "" }}</li>
    				@endif
    			    </div>
    			    <div class="right-text">
    				<li class="home-type">{{ isset($srch->architechture->home_type) ? config('constant.home_type.'.$srch->architechture->home_type):"NA" }}</li>
    			    </div>
    			</ul>
    		    </div>
    		    <div class="col-sm-12 img-bottom-div">
    			<table>
    			    <tbody>
    				<tr>
    				    <td class="nested-all-divs bg-green plot-size">
    					<p><i class="fa fa-calendar color-black" aria-hidden="true"></i>Year&nbsp;{{$srch->architechture->year_built??"0"}}</p>
    				    </td>
    				    <td class="nested-all-divs bg-black beds">
    					<p><i class="fa fa-bed color-green" aria-hidden="true"></i>{{$srch->architechture->beds??"NA"}}</p>
    				    </td>
    				    <td class="nested-all-divs bg-green baths">
    					<p>{{config('constant.baths.'.$srch->architechture->baths)??"NA"}}</p>
    				    </td>
    				</tr>
    			    </tbody>
    			</table>
    		    </div>
    		</div>
    		<!--</div>-->
    		@endforeach
    		{{ $search->appends($data)->links() }}
		<?php } else { ?>
    		<h4 class="noprop">No Property found matching your search.</h4>
<?php } ?>
	    </div>
	</div>
    </div>
</div>
@endif
<?php if (isset($search)) { ?>
    <div class="list-view" style="display:none">
        <div class="row properties-for-rent-row">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12  properties-for-rent-div">
                        <div class="col-sm-12 properties-for-rent-text">
                            <img src="{{asset('/storage/site-images/home_icon.png')}}" alt="home_icon img" class="img-responsive">
    			<h2>Properties For&nbsp;{{ config('constant.property_type.2') }}</h2>
                            <h4>Search your House</h4>
                        </div>
                        <div class="col-sm-9 col-xs-12 left-div">
    <?php if (count($search) > 0) { ?>
	                        @foreach($search as $srch)
	                        <div class="col-sm-12 col-xs-12 left-div-row">
	                            <div class="col-sm-7 col-xs-12 image-div images">
					<?php if ($srch->images->count()) { ?>
	    				<img src="{{asset("storage/property_images/".$srch->id .'/'.$srch->images->first()->image)}}" class="img-responsive">
					<?php } else { ?>
	    				<img src="{{ asset("storage/site-images/no_image_available.jpg") }}" class="img-responsive">
	<?php } ?>
	                                <div class="more-info">
	                                    <a href="{{ route('frontend.propertyDetails',$srch->id)  }}"><i class="fa fa-arrow-circle-right" aria-hidden="true"></i>more info</a>
	                                </div>
	                            </div>
	                            <div class="col-sm-5 col-xs-12 text-div">
	                                <div class="address-townhouse">
	                                    <h3 class="street-address">{{ $srch->street_address??"NA" }}</h3>
	                                    <h3 class="townhouse">{{ (isset($srch->townhouse_apt) && !empty($srch->townhouse_apt)) ?'Apt# '.$srch->townhouse_apt:"" }}</h3>
	                                </div>
	                                <div class="state-plot-home">
	                                    <p>State :&nbsp;<span><?php echo findState($srch->state_id); ?></span></p>
	                                    <p>Lot Size :&nbsp;<span>{{ $srch->architechture->plot_size??"NA"}} </span></p>
	                                    <p>Home Type :&nbsp;<span>{{ isset($srch->architechture->home_type) ? config('constant.home_type.'.$srch->architechture->home_type) :"NA" }}</span></p>
	                                </div>
	                                <div class="beds-baths-row">
	                                    <table>
	                                        <tbody>
	                                            <tr>
	                                                <td>
	                                                    <p><i class="fa fa-bed color-green" aria-hidden="true"></i>{{$srch->architechture->beds??"NA"}}</p>
	                                                </td>
	                                                <td>
	                                                    <p><i class="fa fa-bath color-black" aria-hidden="true"></i>{{config('constant.baths.'.$srch->architechture->baths)??"NA"}}</p>
	                                                </td>
	                                                <td>
	                                                    <p><i class="fa fa-square color-black" aria-hidden="true"></i>{{$srch->architechture->home_size??"NA"}}&nbsp;SqFt</p>
	                                                </td>
	                                            </tr>
	                                        </tbody>
	                                    </table>
	                                </div>
	                                <div class="col-sm-12 col-xs-12  rent-list-price">
	                                    <div class="col-lg-6 col-md-12 col-sm-12 col-xs-6 rent">
	                                        <p>For Sale</p>
	                                    </div>
	                                    <div class="col-lg-6 col-md-12 col-sm-12 col-xs-6 list-price">
	                                        <p>&nbsp;<span class="money">{{$srch->price??"NA"}}</span></p>
	                                    </div>
	                                </div>
	                            </div>
	                        </div> 
	                        @endforeach
	                        {{ $search->appends($data)->links() }}
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
                                <img src="{{asset('/storage/site-images/banner-1.png')}}" alt="banner-1 img" class="img-responsive image">
                                <div class="buyers-div">
                                    <h2>Buyers</h2>
                                    <p>Find your dream home with us</p>
                                    <div class="btn-more-info">
                                        <a href="#" class="btn">More Info</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-12 col-xs-12 nested-div">
                                <img src="{{asset('/storage/site-images/banner-2.png')}}" alt="banner-2 img" class="img-responsive image">
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
<script src="https://maps.googleapis.com/maps/api/js?key=<?= config('settings.google_map_api_key') ?>" type="text/javascript"></script>
<!--<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCeWkFkWq9GPY7zfmiozWCnNTYMZ0isyWs"></script>-->
<!--<script src='http://maps.googleapis.com/maps/api/js?key=AIzaSyC11rgDxrNC5An9e2ez7Exq1v93PMjRSH0&libraries=places&sensor=false&amp;libraries=places&key=xxx'></script>-->
<!--<script src="https://cdn.rawgit.com/googlemaps/v3-utility-library/master/infobox/src/infobox.js" type="text/javascript"></script>-->
<!--<script src="https://googlemaps.github.io/js-marker-clusterer/examples/data.json"></script>-->
<!--<script src="{{ asset('js/infobox.js') }}"></script>-->
<script src="https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js"></script>
<!--<script src="https://googlemaps.github.io/js-marker-clusterer/src/markerclusterer.js"></script>-->
<script>
$(document).ready(function () {
    $('.money').mask('000,000,000,000,000', {reverse: true});
<?php if (isset($search)) { ?>
        var map = new google.maps.Map(document.getElementById("map"), {
            center: new google.maps.LatLng(<?php echo!empty($latitude) ? $latitude : '42.73' ?>, <?php echo!empty($longitude) ? $longitude : '-70.34' ?>),
            zoom: 7,
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            streetViewControl: false,
        });
<?php } ?>

    $('#beds').val("{{$_GET['beds']??''}}");
    $('#baths').val("{{$_GET['baths']??''}}");
    $('#proptype').val("{{$_GET['proptype']??''}}");
    $('#home_size').val("{{$_GET['home_size']??''}}");
    $('#limit').val("{{$_GET['limit']??''}}");
    $('#pricefrom').val("{{$_GET['pricefrom']??''}}");
    $('#priceto').val("{{$_GET['priceto']??''}}");
    $('#acreagefrom').val("{{$_GET['acreagefrom']??''}}");
    $('#acreageto').val("{{$_GET['acreageto']??''}}");
    $('#radius').val("{{$_GET['radius']??''}}");
    $('#street_address').val("{{$_GET['street_address']??''}}");
    $('#radius').prop('disabled', true);

    if ("{{$_GET['state']??''}}") {
        $.ajax({
            type: "get",
            url: "{{ route('frontend.stateRelatedDataSearch') }}",
            data: {
                state_id: parseInt($('#state option').filter(':selected').val())
            },
            success: function (response) {
                $('#city').prop('disabled', false);
                $('#zip-code').prop('disabled', false);
                $('#military_location').prop('disabled', false);
                $('#county').prop('disabled', false);

                $('#city').children('option').remove();
                $('#city').append($('<option value>Search By City</option>'));
                $.each(response.cities, function (i, item) {
                    $('#city').append($('<option>', {
                        value: item,
                        text: i
                    }));
                });
                $('#city').val("{{$_GET['city']??''}}");
                $('#zip-code').children('option').remove();
                $('#zip-code').append($('<option value>Search By Zip Code</option>'));
                $.each(response.zipCodes, function (i, item) {
                    $('#zip-code').append($('<option>', {
                        value: i,
                        text: item
                    }));
                });
                $('#zip-code').val("{{$_GET['zip']??''}}");
//                $('#military_location').append($('<option value>Search By Military Locations</option>'));
                $.each(response.militarylocations, function (i, item) {
                    $('#military_location').append($('<option>', {
                        value: item,
                        text: i
                    }));
                });
                $('#military_location').val("{{$_GET['military_location']??''}}");
//                $('#county').append($('<option value>Search By County</option>'));
                $.each(response.counties, function (i, item) {
                    $('#county').append($('<option>', {
                        value: item,
                        text: i
                    }));
                });
                $('#county').val("{{$_GET['county']??''}}");
            },
            error: function (error) {
            }
        });
    }
    if ("{{$_GET['city']??''}}" || "{{$_GET['zip']??''}}" || "{{$_GET['military_location']??''}}") {
        $('#radius').prop('disabled', false);
    } else {
        $('#radius').prop('disabled', true);
    }
    $('properties-for-rent-row').hide();
    $('select').select2();
    $('form').validate({
        errorPlacement: function (error, element) {
            if (element.is("select.form-control"))
            {
                error.appendTo(element.parents('.formField'));
            } else
            {
                error.insertAfter(element);
            }
        }
    });

    $("#state").change(function () {
        if ($(this).val() !== "") {
            $('#state-error').hide();
        } else {
            $("#state-error").show();
        }
    });

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

//        var infobox = new google.maps.InfoWindow({
//            disableAutoPan: false,
//            maxWidth: 202,
//            pixelOffset: new google.maps.Size(-101, -285),
//            zIndex: null,
//            boxStyle: {
//                opacity: 1,
//                width: "202px",
//                height: "245px"
//            },
//            closeBoxMargin: "28px 26px 0px 0px",
//            closeBoxURL: "",
//            infoBoxClearance: new google.maps.Size(1, 1),
//            pane: "floatPane",
//            enableEventPropagation: false
//        });
        var infobox = new google.maps.InfoWindow({
//           // content: infoBoxes
//	               disableAutoPan: false,
            maxWidth: 250,
//            pixelOffset: new google.maps.Size(-101, -285),
//            zIndex: null,
            boxStyle: {
                opacity: 1,
                width: "202px",
                height: "245px"
            },
//            closeBoxMargin: "28px 26px 0px 0px",
//            closeBoxURL: "",
//            infoBoxClearance: new google.maps.Size(1, 1),
//            pane: "floatPane",
            enableEventPropagation: false
        });

        var markerArray = [];
        var infoBoxes = [];

<?php if (isset($search)) {
    foreach ($search as $srch): ?>
	        var infoboxContent = '<div class="infoW" id="infobox-{{$srch->id}}">' +
	                '<div class="propImg">' +
	<?php if ($srch->images->count()) { ?>
	            '<img src="{{asset("storage/property_images/".$srch->id.'/'.$srch->images->first()->image)}}">' +
	<?php } else { ?>
	            '<img src="{{ asset("storage/site-images/no_image_available.jpg") }}">' +
	<?php } ?>
	        '<div class="propBg">' +
	                '<div class="propPrice"><span class="money custom_price1">{{number_format(round($srch->price))??"NA"}}</span></div>' +
	                '<div class="propType">{{isset($srch->architechture->home_type) ? config('constant.home_type.'.$srch->architechture->home_type):"NA"}}</div>' +
	        '</div>' +
	                '</div>' +
	                '<div class="paWrapper">' +
	                '<div class="propTitle">{{$srch->street_address??"NA"}}</div>' +
	                '<div class="propAddress">{{$srch->townhouse_apt??""}}</div>' +
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
//	                '<a class="btn btn-sm closeInfo btn-blue" onclick="hideInfoBox({{$srch->id}})">Close</a>' +
	                '<a href="{{ route('frontend.propertyDetails',$srch->id)  }}" class="btn btn-sm btn-green viewInfo">View</a>' +
	        '</div>' +
	                '</div>';

	        infoBoxes.push(infoboxContent);
    <?php endforeach;
} ?>
        for (var i = 0, length = latLongArr.length; i < length; i++) {
            var data = latLongArr[i],
                    latLng = new google.maps.LatLng(data.lat, data.lng);
            marker = new google.maps.Marker({
                position: latLng,
                map: map,
                icon: normalIcon()
            });

            google.maps.event.addListener(marker, 'click', (function (marker, infoboxContent, infoBoxes, i) {
                return function () {
                    $('.infoBox').show();
                    infobox.setContent(infoBoxes[i]);
                    infobox.open(map, marker);
                }
            })(marker, infoboxContent, infoBoxes, i));
            markerArray.push(marker);
        }

        markerClusterer = new MarkerClusterer(map, markerArray, {
            maxZoom: 6,
            imagePath: 'https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/m'
        });

        $('.images').hover(
                function () {
                    var index = $('.images').index(this);
                    markerArray[index].setIcon(highlightedIcon());
                    var newLat = markerArray[index].getPosition().lat();
                    var newLng = markerArray[index].getPosition().lng();
                    markerArray[index].setZIndex(9999);
                    var newCenter = new google.maps.LatLng(newLat, newLng);
                    map.panTo(newCenter);
//                map.setZoom(12);
                },
                function () {
                    var index = $('.images').index(this);
                    markerArray[index].setIcon(normalIcon());
                    markerArray[index].setZIndex(8);
//                var oldCenter = new google.maps.LatLng(42.73, -70.34);
//                map.panTo(oldCenter);
//                map.setZoom(6);
                }
        );
    }

    function normalIcon() {
        return {
            url: 'https://maps.gstatic.com/mapfiles/api-3/images/spotlight-poi2.png'
        };
    }
    function highlightedIcon() {
        return {
            url: 'http://1.bp.blogspot.com/_GZzKwf6g1o8/S6xwK6CSghI/AAAAAAAAA98/_iA3r4Ehclk/s1600/marker-green.png'
        };
    }

    var searchArray = <?php
if (isset($search) && count($search) > 0) {
    echo json_encode($search->items());
} else {
    echo "null";
}
?>;
    if (searchArray != null) {
        initMap(searchArray);
    }

    //    google.maps.event.addDomListener(window, 'load', initMap);
    $('.btn-clear-less-more-filetrs .btns-less-more').on('click', function () {
        var $this = $(this);
        $('.' + $this.attr('data-show')).hide().siblings().show();
    });
<?php if (isset($search)) { ?>
        // $('.btn-more-filters').hide();
        // $('.btn-less-filters, .less-filter').show();
<?php } ?>
    $('.btn-clear-filters').click(function () {
        $('.form-search-property input').val('');
        $(".form-search-property select").prop('selectedIndex', 0);
        $('select').select2();
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
        $(".map-view").show();
        $(".btn-search").click(function (e) {
            e.preventDefault();
            $(".map-view, .list-view").show();
        });
        $('.filter-image').show();
        $('.filter-image').click(function () {
            $('.form-search-property,.btn-clear-less-more-filetrs').toggle();
            $(".btn-clear-less-more-filetrs").removeClass("margin-bottom");
            $(".map-view").addClass("margin-top");
            $(".list-view").addClass("margin-top");
        });

<?php } ?>

    $("#city, #zip-code, #military_location").change(function (e) {
        $('#radius').prop('disabled', false);
    });
    $(".search_criteria_select").change(function (e) {
        selected = $(this).val();
        $('.search_criteria_select').val('').select2();
        $(this).val(selected).select2();
        if ($(this)[0].selectedIndex <= 0) {
            $('#radius').prop('disabled', true);
        } else
            $('#radius').prop('disabled', false);
    });


    $("#county").change(function (e) {
        $('#radius').prop('disabled', true);
    });
    $("#state").change(function (e) {
        e.preventDefault();
        $.ajax({
            type: "get",
            url: "{{ route('frontend.stateRelatedDataSearch') }}",
            data: {
                state_id: parseInt($('#state option').filter(':selected').val())
            },
            success: function (response) {
                $('#city').prop('disabled', false);
                $('#zip-code').prop('disabled', false);
                $('#military_location').prop('disabled', false);
                $('#county').prop('disabled', false);

                $('#city').children('option').remove();
                $('#city').append($('<option value>Search By City</option>'));
                $.each(response.cities, function (i, item) {
                    $('#city').append($('<option>', {
                        value: item,
                        text: i
                    }));
                });
                $('#zip-code').children('option').remove();
                $('#zip-code').append($('<option value>Search By Zip Code</option>'));
                $.each(response.zipCodes, function (i, item) {
                    $('#zip-code').append($('<option>', {
                        value: i,
                        text: item
                    }));
                });
//                $('#military_location').append($('<option value>Search By Military Locations</option>'));
                $.each(response.militarylocations, function (i, item) {
                    $('#military_location').append($('<option>', {
                        value: item,
                        text: i
                    }));
                });
//                $('#county').append($('<option value>Search By County</option>'));
                $.each(response.counties, function (i, item) {
                    $('#county').append($('<option>', {
                        value: item,
                        text: i
                    }));
                });
            },
            error: function (error) {
            }
        });
    });

//    function getLatLngByZipcode(zipcode){
//        var geocoder = new google.maps.Geocoder();
//        var address = zipcode;
//        geocoder.geocode({ 'address': address }, function (results, status) {
//            if (status == google.maps.GeocoderStatus.OK) {
//                var latitude = results[0].geometry.location.lat();
//                var longitude = results[0].geometry.location.lng();
//                $('#latitude').val(latitude);
//                $('#longitude').val(longitude);
//            } 
//        });
//        return [latitude, longitude];
//    }
//    function getLatLngByCity(city, state){
//        var geocoder = new google.maps.Geocoder();
//        var address = city;
//        geocoder.geocode({ 'address': address + ',' + state}, function (results, status) {
//            if (status == google.maps.GeocoderStatus.OK) {
//                var latitude = results[0].geometry.location.lat();
//                var longitude = results[0].geometry.location.lng();
//                $('#latitude').val(latitude);
//                $('#longitude').val(longitude);
//            }
//        });
//        return [latitude, longitude];
//    }
//    $('#zip-code').on('select2:select', function (e) {
//        getLatLngByZipcode($('#zip-code option:selected').text());
//    });
//    $('#city').on('select2:select', function (e) {
//        getLatLngByCity($('#city option:selected').text(), $('#state option:selected').text());
//    });

});

function hideInfoBox(id) {
    $('#infobox-' + id).hide();
    $('#infobox-' + id).parent('.gm-style-iw .gm-style-iw-c').hide();
}
$('#pricefrom').change(function(){
var value = $(this).val();
    $("#priceto option").each(function (index,val) {
            if (this.value <= value) {
                this.disabled = true;
            }
      })
})

</script>
@endsection