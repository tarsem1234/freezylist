@extends ('backend.layouts.app')
@section ('title', ('Vacation Details'))

@section('after-styles')
<link type="text/css" rel="stylesheet" href="{{ asset("https://cdn.datatables.net/v/bs/dt-1.10.15/datatables.min.css") }}" media="all">
@endsection
<?php // dd($sales->toArray()); ?>
@section('page-header')
<h1>View Vacation Listing</h1>
@endsection

@section('content')
<style>
    .table-heading{
        width: 125px;
        border-left: 1px solid #ccc;
    }
    td, th{
        border-right: 1px solid #ccc;
        border-bottom: 1px solid #ccc;
        text-align: left;
        border-top: 1px solid #ddd !important;
    }
    th{
    }
    #profile-pills h3{
        padding: 0 0 0 15px;
    }
    #home-pills p{
        padding: 0 0 0 15px;
    }
    .bld {
        font-size: 22px;
    }
    hr {
        border: #999 1px solid !important;
    }
    #settings-pills,#profile-pills hr {
        margin-left: 20px;
        margin-right: 20px;
    }

</style>
<?php $notAvailable   = "NA" ?>
<div class="row">
    <div class="panel panel-default" class="table_main" style="padding:10px 50px 0 50px;overflow: hidden;">
        <p>
            <span class="bld">@if($vacationDetails->property_name){{ $vacationDetails->property_name }} @else {{ $notAvailable }} @endif</span>
        </p>
        <p>
            <span class="bld">Is this a lock-out unit? : </span>
            @if($vacationDetails->lock_out_unit == 0 || $vacationDetails->lock_out_unit ==1)
            <span>
                {{ config('constant.lock_out_unit.'.$vacationDetails->lock_out_unit) }}
            </span>
            @else
            <span>
                {{ $notAvailable }}
            </span>
            @endif
        </p>
        <hr>
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                <table class="table">
                    <tbody>
                        <tr>
                            <th class="table-heading" style="width: 255px;">Property Type</th>
                            <td>@if($vacationDetails->property_type){{ config('constant.vacation_property_type.'.$vacationDetails->property_type) }} @else {{ $notAvailable }} @endif</td>
                        </tr>

                        <tr>
                            <th class="table-heading" style="width: 255px;">Address</th>
                            <td>@if($vacationDetails->address){{ $vacationDetails->address }} @else {{ $notAvailable }} @endif</td>
                        </tr>

                        <tr>
                            <th class="table-heading" style="width: 255px;">City</th>
                            <td>@if($vacationDetails->city){{ $vacationDetails->city }} @else {{ $notAvailable }} @endif</td>
                        </tr>

                        <tr>
                            <th class="table-heading" style="width: 255px;">Beds</th>
                            <td>@if($vacationDetails->bedrooms){{ $vacationDetails->bedrooms }} @else {{ $notAvailable }} @endif</td>
                        </tr>
                        <tr>
                            <th class="table-heading">Baths</th>
                            <td>@if($vacationDetails->bathrooms){{ $vacationDetails->bathrooms }} @else {{ $notAvailable }} @endif</td>
                        </tr>
                        <tr>
                            <th class="table-heading">Sleeps</th>
                            <td>@if($vacationDetails->sleeps){{ $vacationDetails->sleeps }} @else {{ $notAvailable }} @endif</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                <table class="table">
                    <tbody>
                        <tr>
                            <th class="table-heading">State</th>
                            <td>@if($state){{ $state->state }} @else {{ $notAvailable }} @endif</td>
                        </tr>
                        <tr>
                            <th class="table-heading">County</th>
                            <td>@if($county){{ $county->county }} @else {{ $notAvailable }} @endif</td>
                        </tr>
                        <tr>
                            <th class="table-heading">Zip</th>
                            <td>@if(isset($zip)){{ $zip->zip }} @else {{ $notAvailable }} @endif</td>
                        </tr>
                        <tr>
                            <th class="table-heading">Points Based Timeshare?</th>
                            <td>
                                @if($vacationDetails->point_based_timeshare == 0 || $vacationDetails->point_based_timeshare ==1)
                                {{ config('constant.point_based_timeshare.'.$vacationDetails->point_based_timeshare) }}
                                @else
                                {{ $notAvailable }}
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th class="table-heading">Available Week(s) </th>
                            @if(!empty($vacationDetails->availableWeeks))
                            <?php
                            $availableWeeks = [];
                            foreach ($vacationDetails->availableWeeks as $weak) {
                                $availableWeeks[] = $weak->available_week;
                            }

                            $weeks       = implode(", ", $availableWeeks);
                            ?>
                            <td>{{ $weeks }}</td>
                            @else
                            <td>{{ $notAvailable }}</td>
                            @endif
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <p></p>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="panel panel-default" style="overflow: hidden;">
                    <div class="panel-heading">
                        <h4 class="bld"><b>Price : </b><span class="money">@if($vacationDetails->price){{round($vacationDetails->price)}} @else {{$notAvailable}} @endif</span></h4>
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <!-- Nav tabs -->
                        <ul class="nav nav-pills">
                            <li class="active"><a href="#settings-pills" data-toggle="tab" aria-expanded="true">Property Overview</a>
                            </li>
                            <li class=""><a href="#profile-pills" data-toggle="tab" aria-expanded="false">Photos</a>
                            </li>
                        </ul>
                        <br>
                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div class="tab-pane fade active in" id="settings-pills">
                                <p>
                                    <span class="bld">Location : </span><span>@if($vacationDetails->locations){{ $vacationDetails->locations }} @else {{ $notAvailable }} @endif</span>
                                </p>
                                <hr>
                                <h3>General Information</h3>
                                <p>
                                </p><div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                        <div class="table-responsive">
                                            <table class="table" id="detail-inner-table" style="width:100%; float:left;">
                                                <tbody>
                                                    <tr>
                                                        <th class="table-heading">Website Link</th>
                                                        <td><a href="{{ (isset($vacationDetails->property_web_link) && $vacationDetails->property_web_link) ?'http://www.'. $vacationDetails->property_web_link:"" }}" target="_blank">{{ $vacation->property_web_link??"NA" }}</a></td>
                                                    </tr>
                                                    <tr>
                                                        <th class="table-heading" style="width: 175px;">Ownership Type :</th>
                                                        <td>@if($vacationDetails->ownership_type){{config('constant.ownership_type.'.$vacationDetails->ownership_type) }} @else {{ $notAvailable }} @endif</td>
                                                    </tr>
                                                    <tr>
                                                        <th class="table-heading">Willing to exchange :</th>
                                                        <td>@if($vacationDetails->exchange_timeshare){{config('constant.exchange_timeshare.'.$vacationDetails->exchange_timeshare) }} @else {{ $notAvailable }} @endif</td>
                                                    </tr>
                                                    <tr>
                                                        <th class="table-heading">Lease will expire :</th>
                                                        <td>@if($vacationDetails->lease_expire_year){{$vacationDetails->lease_expire_year }} @else {{ $notAvailable }} @endif</td>
                                                    </tr>
                                                    <tr>
                                                        <th class="table-heading">Rental Price Negotiable?</th>
                                                        <td>@if(isset($vacationDetails->rental_price_negotiable)){{config('constant.rental_price_negotiable.'.$vacationDetails->rental_price_negotiable) }} @else {{ $notAvailable }} @endif</td>
                                                    </tr>
                                                    <tr>
                                                        <th class="table-heading">Variables :</th>
                                                        <td>@if(isset($vacationDetails->variable)){{config('constant.variable.'.$vacationDetails->variable) }} @else {{ $notAvailable }} @endif</td>
                                                    </tr>
                                                    <tr>
                                                        <th class="table-heading">Check-In Day : </th>
                                                        @if(count($vacationDetails->availableWeeks) > 0)
                                                        <td>{{ config('constant.available_weeks.'.$vacationDetails->availableWeeks->first()->checkin_day) }}</td>
                                                        @else
                                                        <td>{{ $notAvailable }}</td>
                                                        @endif
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <tbody>
                                                    <tr>
                                                        <th class="table-heading" style="width: 200px;">Annual Maintenance Fees :</th>
                                                        <td>@if($vacationDetails->annual_maintenance_fees){{$vacationDetails->annual_maintenance_fees }} @else {{ $notAvailable }} @endif</td>
                                                    </tr>
                                                    <tr>
                                                        <th class="table-heading">Sale Price ($): </th>
                                                        <td>@if($vacationDetails->sale_price){{$vacationDetails->sale_price }} @else {{ $notAvailable }} @endif</td>
                                                    </tr>
                                                    <tr>
                                                        <th class="table-heading">Is the timeshare available for sale? </th>
                                                        <td>{{(config('constant.inverse_is_available_for_sale.Yes') == $vacationDetails->is_available_for_sale) ? "Yes" : "No"}}</td>
                                                    </tr>
                                                    <tr>
                                                        <th class="table-heading">Points: </th>
                                                        <td>{{(config('constant.inverse_point_based_timeshare.Yes') == $vacationDetails->point_based_timeshare)?"Yes":"No"}}</td>
                                                    </tr>
                                                    <tr>
                                                        <th class="table-heading">How may points? </th>
                                                        <td>@if(isset($vacationDetails->how_many_points)){{$vacationDetails->how_many_points }} @else {{ $notAvailable }} @endif</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <p></p>
                                <hr>
                                <h3>Property Description</h3>
                                <p>@if($vacationDetails->property_description) {{ $vacationDetails->property_description }} @else {{ $notAvailable }} @endif </p>

                            </div>
                            <div class="tab-pane fade"  id="profile-pills">
                                <h4>Photo Gallery</h4>
                                <?php if ($vacationDetails->images->count()) { ?>
                                    @foreach($vacationDetails->images as $image)
                                    <div class="col-xs-6 col-md-4">
                                        <a class="thumbnail">
                                            <img src="{{ asset('storage' . '/property_images/'.$vacationDetails->id.'/'. $image->image) }}" alt="">
					</a>
                                    </div>
                                    @endforeach
                                <?php } else { ?>
                                    <p>NA</p>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <!-- /.panel-body -->
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-left">
                        <a href="{{ route('admin.vacationIndex') }}"><button type="button" class="btn btn-primary">Back</button> </a>   <br><br>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection

@section('after-scripts')
<script src="{{ asset("https://cdn.datatables.net/v/bs/dt-1.10.15/datatables.min.js") }}"></script>
<script src="{{ asset("js/backend/plugin/datatables/dataTables-extend.js") }}"></script>
<script>
     $('.money').mask('000,000,000,000,000', {reverse: true});
</script>
@endsection
