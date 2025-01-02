@extends ('frontend.layouts.app')
@section ('title', ('Property Details'))
<?php list($width, $height) = getimagesize(public_path("storage/property_images/" . $vacation->id . '/' . $vacation->images->first()->image)); ?>
<?php
$fbAppId = config('settings.fb_app_id');
$fbAppVersion = config('settings.fb_app_version');
?>
<meta property="og:url" content="{{ route('frontend.vacationDetails',$vacation->id) }}" />
<meta property="og:type" content="website" />
<meta property="og:title" content="Freezylist" />
<meta property="og:description" content="@if($vacation->property_description){{ $vacation->property_description }} @else {{ !empty($notAvailable) ? $notAvailable: ''}} @endif " />
<meta property="og:image" content="<?php if (isset($vacation->images[0]->image)) { ?> {{asset("storage/property_images/".$vacation->id .'/'.$vacation->images->first()->image)}}" <?php } ?> />
<meta property="og:image:width" content="<?php echo $width; ?>">
<meta property="og:image:height" content="<?php echo $height; ?>">
<meta property="fb:app_id" content="{{ $fbAppId }}" />
@section('after-styles')
<link type="text/css" rel="stylesheet" href="{{ asset(mix('css/vacation-search.css')) }}" media="all">
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
<?php $notAvailable = "NA" ?>
<div class="detail-page-width">
    <div class="row img-slider-row bg-white-border">
	<div class="col-sm-4 col-xs-12 left-div-img">
	    <div id="owl-carousel" class="owl-carousel owl-theme owl-loaded owl-drag" >
<?php if ($vacation->images) { ?>
                    @foreach($vacation->images as $image)
                    <img src="{{asset("storage/property_images/".$vacation->id .'/'.$image->image)}}" alt="" class="img-responsive">
                    @endforeach
		<?php } else { ?>
                    <p>NA</p>
<?php } ?>    
	    </div>
	</div>
	<div class="col-sm-8 col-xs-12 right-div-data"> 
	    @if( isset($vacation) )
	    <div class="col-sm-12 additional-features-row"> 
		<div class="prop-name-price">
		    <h3>{{$vacation->property_name}}</h3><br>
		    <h3>Rental Price :<span class="money">{{round($vacation->price)}}</span> </h3>
		</div>
		<div class="negotiable">
		    <h3>Negotiable? <span class="text-color">{{config('constant.rental_price_negotiable.'.$vacation->rental_price_negotiable)??""}}</span></h3>
		</div>
	    </div>
	    @endif
	    <div class="col-md-6 col-sm-12 left-div table-responsive">
		<table class="table">
		    <tbody>
			<tr class="bg-grey">
			    <th class="table-heading">Property Type</th>
			    <td>@if($vacation->property_type){{config('constant.vacation_property_type.'.$vacation->property_type)??""}} @else {{ $notAvailable }} @endif</td>
			</tr>
			<tr>
			    <th class="table-heading">Sub-Region</th>
			    <td>@if($vacation->subregion_id)<?php echo findSubRegion($vacation->subregion_id); ?> @else {{ $notAvailable }} @endif </td>
			</tr>
			<tr class="bg-grey">
			    <th class="table-heading">City</th>
			    <td>
				<?php if (isset($vacation->state_id) && $vacation->state_id && $vacation->city) { ?>
				    <?php echo getCityName($vacation->city); ?>
				<?php } elseif ($vacation->city) { ?>
                                    {{getNonUsCity($vacation->city)}}
				<?php } else { ?>
                                    NA
<?php } ?>
			    </td>
			</tr>
			<tr>
			    <th class="table-heading">Address</th>
			    <td>{{$vacation->address??"NA"}} </td>
			</tr>
		    </tbody>
		</table>
	    </div>
	    <div class="col-md-6 col-sm-12 right-div table-responsive no-padding">
		<table class="table">
		    <tbody>
			<tr>
			    <th class="table-heading">Region</th>
			    <td>@if($vacation->region_id)<?php echo findRegion($vacation->region_id); ?> @else {{ $notAvailable }} @endif </td>
			</tr>
			<tr class="bg-grey">
			    <th class="table-heading">Country</th>
			    <td>@if($vacation->country_id)<?php echo findCountry($vacation->country_id); ?> @else {{ $notAvailable }} @endif </td>
			</tr>
			<tr>
			    <th class="table-heading">Zip Code</th>
			    <td>@if($vacation->zip_code){{$vacation->zip_code}} @else {{ $notAvailable }} @endif</td>
			</tr>
			<tr class="bg-grey">
			    <th class="table-heading">Available Week(s)</th>
			    <td>{{$vacation->availableWeeks->first()->available_week ?? $notAvailable }}</td>
			</tr>
		    </tbody>
		</table>
	    </div>
            <div class="fb-share-button" data-href="{{route('frontend.vacationDetails', $vacation->id)}}" data-layout="button_count" data-size="small" data-mobile-iframe="true">
                <a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u={{urlencode(route('frontend.vacationDetails', $vacation->id))}}%2F&amp;src=sdkpreparse" class="fb-xfbml-parse-ignore">Share</a>
            </div>
	</div>
	<div class="col-sm-12 col-xs-12 all-buttons">
	    @if(!Auth::check() || (Auth::check() && Auth::user()->id != $vacation->user_id))
	    <div class="col-md-2 col-sm-4 col-xs-6 schedule-a-viewing particular-btn">
		@guest
		<a href="{{route('frontend.auth.login')}}" class="btn">View Availability</a>
		@else
		<a class="btn" id="view_availabilites">View Availability</a>
		@endguest
	    </div>
	    @endif
	    <div class="col-md-2 col-sm-4 col-xs-6 last-div phone particular-btn">
		<a href="{{ URL::previous() }}" class="btn">Back to Listings</a>
	    </div>
	</div>
    </div>
    <div class="row all-details-div bg-white-border">
	<div class="price-property-info-tabs">
	    <div class="col-sm-12 price-heading">
		<h4 class="bld">Price : <span class="money">@if($vacation->price){{round($vacation->price)}} @else {{ $notAvailable }} @endif </span></h4>
		<div class="btns-price-row">
		    @if(Auth::id() == $vacation->user_id)
		    <a href="#" class="btn btn-your-own-property">Your Own Property</a>
		    @else
		    <a id="view_seller_modal" class="btn btn-contact-seller">Contact Seller</a>
		    @endif
		</div>
	    </div>
	    <div class="col-sm-12 property-info-tabs">
		<ul id="ere-features-tabs" class="nav nav-tabs ">
		    <li class="active"><a href="" class="overview btn" data-show="overview-details" data-toggle="tab" aria-expanded="true">Overview</a>
		    </li>
		    <li class=""><a href="" class="photos btn" data-show="photos-details" data-toggle="tab" aria-expanded="false">Photos</a>
		    </li>
		</ul>
	    </div>
	</div>
	<div class="overview-schools-photos">
	    <div class="col-sm-12" id="overview-details" style="">
		<div class="all-headings-values">
		    <h2>Property Description</h2>
		    <p>@if($vacation->property_description){{ $vacation->property_description }} @else {{ $notAvailable }} @endif </p>
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
					<tr>
					    <th class="table-heading">Website Link</th>
					    <td><a href="{{ (isset($vacation->property_web_link) && $vacation->property_web_link) ?'http://www.'. $vacation->property_web_link:"" }}" target="_blank">{{ $vacation->property_web_link??"NA" }}</a></td>
					</tr>
					<tr class="bg-grey">
					    <th class="table-heading">Beds</th>
					    <td>{{ config('constant.beds.'.$vacation->bedrooms)??"NA" }}</td>
					</tr>
					<tr>
					    <th class="table-heading">Baths</th>
					    <td>{{ config('constant.baths.'.$vacation->bathrooms)??"NA" }}</td>
					</tr>
					<tr class="bg-grey">
					    <th class="table-heading">Sleeps</th>
					    <td>{{ config('constant.sleeps.'.$vacation->sleeps)??"NA" }}</td>
					</tr>
					<tr class="">
					    <th class="table-heading">Lock-out Unit? :</th>
					    <td>{{($vacation->lock_out_unit==1) ?"Yes":"No"}}</td>
					</tr>
					<tr class="bg-grey">
					    <th class="table-heading">Variable Booking Dates?</th>
					    <td>{{($vacation->variable==1) ?"Yes":"No"}}</td>
					</tr>
					<tr class="">
					    <th class="table-heading">Check-In Day:</th>
					    <td>{{ $vacation->availableWeeks->isNotEmpty() ? config('constant.available_weeks.'.$vacation->availableWeeks->first()->checkin_day) :"NA" }}</td>
					</tr>
				    </tbody>
				</table>
			    </div>
			</div>
			<div class="col-lg-6 col-md-12 right-div table-responsive">
			    <div id="ere-overview" class="tab-pane fade in active">                           
				<table class="table" id="detail-inner-table" style="width:100%; float:left;">
				    <tbody>
					<tr>
					    <th class="table-heading">Available for Sale?</th>
					    <td>{{(config('constant.inverse_is_available_for_sale.Yes') == $vacation->is_available_for_sale) ? "Yes" : "No"}}</td>
					</tr>
					<tr class="bg-grey">
					    <th class="table-heading">Annual Maint. Fees ($):</th>
					    <td>@if($vacation->annual_maintenance_fees){{$vacation->annual_maintenance_fees}} @else {{ $notAvailable }}  @endif</td>
					</tr>
					<tr>
					    <th class="table-heading">Ownership Type :</th>
					    <td>@if($vacation->ownership_type){{config('constant.ownership_type.'.$vacation->ownership_type)??""}} @else {{ $notAvailable }} @endif </td>
					</tr>
					<tr class="bg-grey">
					    <th class="table-heading">Sale Price ($):</th>
					    <td>{{$vacation->sale_price??"NA"}} </td>
					</tr>
					<tr>
					    <th class="table-heading">Points(#):</th>
					    <td>{{$vacation->how_many_points??"NA"}}</td>
					</tr>
					<tr class="bg-grey">
					    <th class="table-heading">Lease Expiration :</th>
					    <td>@if($vacation->lease_expire_year){{$vacation->lease_expire_year}} @else {{ $notAvailable }} @endif </td>
					</tr>
				    </tbody>
				</table>
			    </div>
			</div>
		    </div>
		</div>
		<div class="row interior-features all-headings-values bg-grey">
		    <div class="col-sm-12">
			<h2>Exchange Locations</h2>
			<div>
			    <p>Willing to exchange :
				<span>
				    @if($vacation->exchange_timeshare){{config('constant.exchange_timeshare.'.$vacation->exchange_timeshare)??""}} @else {{ $notAvailable }} @endif
				</span>
				</br>
				Noted Exchange Locations :
				<span>
				    @if($vacation->locations){{$vacation->locations}} @else {{ $notAvailable }} @endif
				</span></p>
			</div>
		    </div>
		</div>
	    </div>
	    <div id="photos-details" style="display: none;">
		<div class="col-sm-12 all-headings-values p-right-0">
		    <h2>Photo Gallery</h2>
<?php if ($vacation->images) { ?>
                        @foreach($vacation->images as $image)
                        <div class="col-sm-4 img-photo-gallery">
                            <img src="{{asset("storage/property_images/".$vacation->id .'/'.$image->image)}}" alt="" class="img-responsive">
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
		    <form action="#" class="form-horizontal list-seller-form">
			<div class="row form-group">
			    <div class="col-sm-12">
				<div class="col-sm-3"><label for="seller-message">Message</label></div>
				<div class="col-sm-9">
				    <textarea name="seller-message" class="message-seller"></textarea>
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
		<div class="modal-body">
		    <div id="calendar"></div>
		</div>
		<div class="modal-footer btns-green-blue">
		    <a type="button" class="btn btn-blue" data-dismiss="modal">Close</a>
		</div>
	    </div>
	</div>
    </div>
</div>
@endsection

@section('after-scripts')
<script src="{{ asset("https://cdn.datatables.net/v/bs/dt-1.10.15/datatables.min.js") }}"></script>
<script src="{{ asset("js/backend/plugin/datatables/dataTables-extend.js") }}"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.min.css" rel="stylesheet" type="text/css"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.15.1/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.min.js"></script>
<script>
    function adjustContainer() {
        $('.detail-page-width').removeClass('container container-fluid');
        $(window).width() > 1286 ? $('.detail-page-width').addClass('container') : $('.detail-page-width').addClass('');
    }
    $(document).ready(function () {
        adjustContainer();
        $(window).on('resize', function () {
            adjustContainer();
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
        var events = <?= $vacation->availabilities->pluck('start_date') ?>;
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
            $.each(events, function (i, v) {
                $('[data-date=' + v + ']').addClass('selectedEvent');
            });
        }
        $('#view_availabilites').click(function () {
            $('#availablity_modal').modal('show');
        });
        $("#view_seller_modal").click(function () {
            $("#contact_seller_modal").modal('show');
        });
    });
</script>
@endsection
<script>
    $('.money').mask('000,000,000,000,000', {reverse: true});
</script>
