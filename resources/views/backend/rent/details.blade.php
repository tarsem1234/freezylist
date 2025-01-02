@extends ('backend.layouts.app')
@section ('title', ('Rent Details'))
@section('after-styles')
<link type="text/css" rel="stylesheet" href="{{ asset("https://cdn.datatables.net/v/bs/dt-1.10.15/datatables.min.css") }}" media="all">
@endsection
<?php // dd($additional_information->toArray()); ?>
@section('page-header')
<h1>View Rent Listing</h1>
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

<div class="row">
    <div class="panel panel-default" class="table_main" style="padding:10px 50px 0 50px;overflow: hidden;">
        <?php $notAvailable  = "NA" ?>

        <span class="bld"><b>@if($details->townhouse_apt){{ $details->townhouse_apt }} @else {{ $notAvailable }} @endif : </b></span>
        <span>@if($details->street_address){{ $details->street_address }} @else {{ $notAvailable }} @endif</span>
        <hr>
        <!--if property field is not available-->
        <div class="row">
            <div class="col-md-6">
                <table class="table">
                    <tbody>
                        <tr>
                            <th class="table-heading">Beds</th>
                            <td>@if($details->architechture->beds){{ $details->architechture->beds }} @else {{ $notAvailable }} @endif</td>
                        </tr>
                        <tr>
                            <th class="table-heading">Baths</th>
                            <td>@if($details->architechture->baths){{ $details->architechture->baths }} @else {{ $notAvailable }} @endif</td>
                        </tr>
                        <tr>
                            <th class="table-heading">House Size</th>
                            <td>@if($details->architechture->plot_size){{ $details->architechture->plot_size }} @else {{ $notAvailable }} @endif</td>
                        </tr>
                        <tr>
                            <th class="table-heading">County</th>
                            <td>@if($county){{ $county->county }} @else {{ $notAvailable }} @endif</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-md-6">
                <table class="table">
                    <tbody>
                        <tr>
                            <th class="table-heading">Year Built</th>
                            <td>@if($details->architechture->year_built){{ $details->architechture->year_built }} @else {{ $notAvailable }} @endif</td>
                        </tr>
                        <tr>
                            <th class="table-heading">State</th>
                            <td>@if($state){{ $state->state }} @else {{ $notAvailable }} @endif</td>
                        </tr>
                        <tr>
                            <th class="table-heading">City</th>
                            <td>@if($city){{ $city->city }} @else {{ $notAvailable }} @endif</td>
                        </tr>
                        <tr>
                            <th class="table-heading">Zipcode</th>
                            <td>@if($zipCode){{ $zipCode->zipcode }} @else {{ $notAvailable }} @endif</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="bld"><b>Price : </b><span class="money">@if($details->price){{round($details->price)}} @else {{ $notAvailable }} @endif </span></h4>
                </div>
                <div class="panel-body">
                    <ul class="nav nav-pills">
                        <li class="active"><a href="#settings-pills" data-toggle="tab" aria-expanded="true">Property Overview</a>
                        </li>
                        <li class=""><a href="#home-pills" data-toggle="tab" aria-expanded="false">Nearby Schools</a>
                        </li>
                        <li class=""><a href="#profile-pills" data-toggle="tab" aria-expanded="false">Photos</a>
                        </li>
                    </ul>
                </div>
                <div class="tab-content">

                    <div class="tab-pane fade active in" style="padding-bottom: 10px;" id="settings-pills">
                        <h3>Property Details</h3>
                        <p>@if($details->architechture->describe_your_home){{ $details->architechture->describe_your_home }} @else {{ $notAvailable }}  @endif</p>
                        <hr>
                        <h3>General Information</h3>
                        <p></p>
                        <div class="row">
                            <div class="col-md-6 col-sm-6">
                                <div class="table-responsive99">
                                    <table class="table" id="detail-inner-table" style="width:100%; float:left;">
                                        <tbody>
                                            <tr>
                                                <th class="table-heading">Are Pets Welcome?</th>
                                                <td>{{(config('constant.inverse_pets_welcome.Yes') == $details->pets) ? "Yes" : "No"}}</td>
                                            </tr>
                                            <tr>
                                                <th class="table-heading">Beds</th>
                                                <td>@if($details->architechture->beds){{ $details->architechture->beds }} @else {{ $notAvailable }}  @endif</td>
                                            </tr>
                                            <tr>
                                                <th class="table-heading">Baths</th>
                                                <td>@if($details->architechture->baths){{ $details->architechture->baths }} @else {{ $notAvailable }}  @endif</td>
                                            </tr>
                                            <tr>
                                                <th class="table-heading">House Size</th>
                                                <td>@if($details->architechture->plot_size){{ $details->architechture->plot_size }} @else {{ $notAvailable }}  @endif</td>
                                            </tr>
                                            <tr>
                                                <th class="table-heading">Cooling Type</th>
                                                <?php
                                                if (isset($additional_information['Cooling Type'])) {
                                                    $rooms = [];
                                                    foreach ($additional_information['Cooling Type'] as $information) {
                                                        $rooms[] = $information->name;
                                                    }
                                                    $allRooms = implode(", ",$rooms);
                                                    ?>
                                                    <td>{{ $allRooms }}</td>
                                                <?php } else { ?>
                                                    <td>{{ $notAvailable }}</td>
                                                <?php  } ?>
                                            </tr>
                                            <tr>
                                                <th class="table-heading">Heating Type</th>
                                                <?php
                                                if (isset($additional_information['Heating Type'])) {
                                                    $heatingType = [];
                                                    foreach ($additional_information['Heating Type'] as $information) {
                                                        $heatingType[] = $information->name;
                                                    }
                                                    $type = implode(", ",$heatingType);
                                                    ?>
                                                    <td>{{ $type }}</td>
                                                <?php } else { ?>
                                                    <td>{{ $notAvailable }}</td>
                                                <?php  } ?>
                                            </tr>
                                            <tr>
                                                <th class="table-heading">Rooms</th>
                                                <?php
                                                if (isset($additional_information['Rooms'])) {
                                                    $rooms = [];
                                                    foreach ($additional_information['Rooms'] as $information) {
                                                        $rooms[] = $information->name;
                                                    }
                                                    $allRooms = implode(", ",$rooms);
                                                    ?>
                                                    <td>{{ $allRooms }}</td>
                                                <?php } else { ?>
                                                    <td>{{ $notAvailable }}</td>
                                                <?php  } ?>
                                            </tr>
                                            <tr>
                                                <th class="table-heading">Total Rooms</th>
                                                <td>@if($details->architechture->total_rooms){{ $details->architechture->total_rooms }} @else {{ $notAvailable }}  @endif</td>
                                            </tr>
                                            <tr>
                                                <th class="table-heading">Outdoor Amenities</th>
                                                <?php
                                                if (isset($additional_information['Outdoor Amenities'])) {
                                                    $outdoor = [];
                                                    foreach ($additional_information['Outdoor Amenities'] as $information) {
                                                        $outdoor[] = $information->name;
                                                    }
                                                    $outdoorAme = implode(", ",$outdoor);
                                                    ?>
                                                    <td>{{ $outdoorAme }}</td>
                                                <?php } else { ?>
                                                    <td>{{ $notAvailable }}</td>
                                                <?php  } ?>
                                            </tr>
                                            <tr>
                                                <th class="table-heading">Capacity of Garage</th>
                                                <td>@if($details->architechture->garage_capacity){{ $details->architechture->garage_capacity }} @else {{ $notAvailable }}  @endif</td>
                                            </tr>
                                            <tr>
                                                <th class="table-heading">View</th>
                                                <?php
                                                if (isset($additional_information['View'])) {
                                                    $view = [];
                                                    foreach ($additional_information['View'] as $information) {
                                                        $view[] = $information->name;
                                                    }
                                                    $viewAll = implode(", ",$view);
                                                    ?>
                                                    <td>{{ $viewAll }}</td>
                                                <?php } else { ?>
                                                    <td>{{ $notAvailable }}</td>
                                                <?php  } ?>
                                            </tr>
                                            <tr>
                                                <th class="table-heading">Virtual Tour</th>
                                                @if($details->virtual_tour_url)
                                                <td>{{ $details->virtual_tour_url }}</td>
                                                @else
                                                <td>{{ $notAvailable }}</td>
                                                @endif
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6">
                                <div class="table-responsive99">
                                    <table class="table">
                                        <tbody class="right-td">
                                            <tr>
                                                <th class="table-heading">Lease Terms Available</th>
                                                <td>{{ $details->lease_term??"NA" }} </td>
                                            </tr>
                                            <tr>
                                                <th class="table-heading">Home Type</th>
                                                <td>@if($details->architechture->home_type){{ config('constant.home_type.' . $details->architechture->home_type) }} @endif</td>
                                            </tr>
                                            <tr>
                                                <th class="table-heading">Updated Year</th>
                                                <td>@if($details->architechture->year_updated){{ $details->architechture->year_updated }} @else {{ $notAvailable }} @endif</td>
                                            </tr>
                                            <tr>
                                                <th class="table-heading">HOA dues/mo ($)</th>
                                                <td>@if($details->architechture->HOA_dues){{ $details->architechture->HOA_dues }} @else {{ $notAvailable }} @endif</td>
                                            </tr>
                                            <tr>
                                                <th class="table-heading">Floor Covering</th>
                                                <?php
                                                if (isset($additional_information['Floor Covering'])) {
                                                    $floor = [];
                                                    foreach ($additional_information['Floor Covering'] as $information) {
                                                        $floor[] = $information->name;
                                                    }
                                                    $floorCovering = implode(", ",$floor);
                                                    ?>
                                                    <td>{{ $floorCovering }}</td>
                                                <?php } else { ?>
                                                    <td>{{ $notAvailable }}</td>
                                                <?php  } ?>
                                            </tr>
                                            <tr>
                                                <th class="table-heading">Heating Fuel</th>
                                                <?php
                                                if (isset($additional_information['Heating Fuel'])) {
                                                    $heatingF = [];
                                                    foreach ($additional_information['Heating Fuel'] as $information) {
                                                        $heatingF[] = $information->name;
                                                    }
                                                    $heatingFuel = implode(", ",$heatingF);
                                                    ?>
                                                    <td>{{ $heatingFuel }}</td>
                                                <?php } else { ?>
                                                    <td>{{ $notAvailable }}</td>
                                                <?php  } ?>
                                            </tr>
                                            <tr>
                                                <th class="table-heading">Development Amenities</th>
                                                <?php
                                                if (isset($additional_information['Building/Development Amenities'])) {
                                                    $building = [];
                                                    foreach ($additional_information['Building/Development Amenities'] as $information) {
                                                        $building[] = $information->name;
                                                    }
                                                    $buildingAme = implode(", ",$building);
                                                    ?>
                                                    <td>{{ $buildingAme }}</td>
                                                <?php } else { ?>
                                                    <td>{{ $notAvailable }}</td>
                                                <?php  } ?>
                                            </tr>
                                            <tr>
                                                <th class="table-heading">Architectural Style</th>
                                                <?php
                                                if (isset($additional_information['Architectural Style'])) {
                                                    $architectural = [];
                                                    foreach ($additional_information['Architectural Style'] as $information) {
                                                        $architectural[] = $information->name;
                                                    }
                                                    $architecturalStyle = implode(", ",$architectural);
                                                    ?>
                                                    <td>{{ $architecturalStyle }}</td>
                                                <?php } else { ?>
                                                    <td>{{ $notAvailable }}</td>
                                                <?php  } ?>
                                            </tr>
                                            <tr>
                                                <th class="table-heading">Number of Stories</th>
                                                <td>@if($details->architechture->stories){{ $details->architechture->stories }} @endif</td>
                                            </tr>
                                            <tr>
                                                <th class="table-heading">Basement</th>
                                                <td>@if($details->architechture->basement){{ config('constant.basement.'.$details->architechture->basement) }} @else {{ $notAvailable }} @endif</td>
                                            </tr>
                                            <tr>
                                                <th class="table-heading">Roof Type</th>
                                                <?php
                                                if (isset($additional_information['Roof Type'])) {
                                                    $roof = [];
                                                    foreach ($additional_information['Roof Type'] as $information) {
                                                        $roof[] = $information->name;
                                                    }
                                                    $roofType = implode(", ",$roof);
                                                    ?>
                                                    <td>{{ $roofType }}</td>
                                                <?php } else { ?>
                                                    <td>{{ $notAvailable }}</td>
                                                <?php  } ?>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <h3>Interior Features</h3>
                        <?php
                        if (isset($additional_information['Indoor Features'])) {
                            $interior = [];
                            foreach ($additional_information['Indoor Features'] as $information) {
                                $interior[] = $information->name;
                            }
                            $interiorFeatures = implode(", ",$interior);
                            ?>
                            <p>{{ $interiorFeatures }}</p>
                        <?php } else { ?>
                            <p>{{ $notAvailable }}</p>
                        <?php  } ?>
                        <hr>
                        <h3>Exterior</h3>
                        <?php
                        if (isset($additional_information['Exterior'])) {
                            $exterior = [];
                            foreach ($additional_information['Exterior'] as $information) {
                                $exterior[] = $information->name;
                            }
                            $exteriorFea = implode(", ",$exterior);
                            ?>
                            <p>{{ $exteriorFea }}</p>
                        <?php } else { ?>
                            <p>{{ $notAvailable }}</p>
                        <?php  } ?>
                        <hr>
                        <h3>Appliances</h3>
                        <?php
                        if (isset($additional_information['Appliances'])) {
                            $appliances = [];
                            foreach ($additional_information['Appliances'] as $information) {
                                $appliances[] = $information->name;
                            }
                            $appliancesAll = implode(", ",$appliances);
                            ?>
                            <p>{{ $appliancesAll }}</p>
                        <?php } else { ?>
                            <p>{{ $notAvailable }}</p>
                        <?php  } ?>
                        <hr>
                        <h3>Parkings</h3>
                        <?php
                        if (isset($additional_information['Parking'])) {
                            $parkings = [];
                            foreach ($additional_information['Parking'] as $information) {
                                $parkings[] = $information->name;
                            }
                            $parkingsAvail = implode(", ",$parkings);
                            ?>
                            <p>{{ $parkingsAvail }}</p>
                        <?php } else { ?>
                            <p>{{ $notAvailable }}</p>
                        <?php  } ?>
                        <hr>
                        <h3>Additional Features</h3>
                        <p>@if($details->architechture->additional_features){{ $details->architechture->additional_features }} @endif</p>
                        <br>
                    </div>

                    <div class="tab-pane fade" id="home-pills">
                        <div class="table-responsive99">
                            <p>
                                Schools Name:-
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

                    <div class="tab-pane fade" id="profile-pills" style="overflow: hidden;">
                        <h3>Photo Gallery</h3>
                        <hr>
                        <div class="col-xs-6 col-md-4">
                            <a class="thumbnail">
                                <?php if($details->images) { ?>
                                @foreach($details->images as $image)
                                <img src="{{ asset('storage' . '/property_images/'.$details->id.'/'. $image->image) }}" alt="">
                                @endforeach
                                <?php } else {?>
                                <p>NA</p>
                                <?php } ?>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <a href="{{ route('admin.rentIndex') }}"><button type="button" class="btn btn-primary">Back</button></a><br><br>
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