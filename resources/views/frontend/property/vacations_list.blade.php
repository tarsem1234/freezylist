@extends('frontend.layouts.app')
@section('title', app_name() . ' | Vacations List')
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
                                <h4>My Vacational Rentals</h4>
                            </div>
                            <div class="col-md-6 col-sm-6 col-xs-12 col-lg-6 no-padding">
                                <a href="{{route('frontend.vacationCreate')}}"><button class="btn btn-primary btn-lg" id="addlisting-btn"> Add New Listing </button></a>
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
                                                        <p>Are you sure you want to remove this list?</p>
                                                    </div>
                                                    <div class=" btns-green-blue text-center">
                                                        <a href="{{route('frontend.vacation.vacationPropertyDelete',$property->id)}}" class="btn btn-green">Confirm</a>
                                                        <button type="button" class="btn btn-blue button" data-dismiss="modal">Cancel</button>
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
                                                        <img src="{{asset('storage/site-images/no_image_available.jpg')}}" class="img-responsive" alt="photo">
                                                    <?php } ?>
                                                </div>
                                            </div>
                                            <div class="col-md-6 col-sm-12">
                                                <div class="cross-div"><span type="button" class="cross" data-toggle="modal" data-target="#myModal-{{$property->id}}"><i class="fa fa-times-circle"></i></span></div>
                                                <div class="listing-div">
                                                    <h4>{{$property->property_name??'NA'}}</h4>
                                                    <p>Points Based Timeshare? :  {{config('constant.point_based_timeshare.'.$property->point_based_timeshare)??'NA'}}</p>

                                                    @if(!empty($property->availableWeeks))
                                                    <?php
                                                    $availableWeeks = [];
                                                    foreach ($property->availableWeeks as $weak) {
                                                        $availableWeeks[] = $weak->available_week;
                                                    }

                                                    $weeks = implode(", ", $availableWeeks);
                                                    ?>
                                                    <p>Available Week(s) : {{ $weeks }}</p>
                                                    @else
                                                    <p>Available Week(s) : NA</p>
                                                    @endif
                                                    <p>Ownership Type : {{config('constant.ownership_type.'.$property->ownership_type)??'NA'}}</p>
                                                    <p>Willing to exchange : {{config('constant.exchange_timeshare.'.$property->exchange_timeshare)??'NA'}}</p>
                                                </div>
                                                <div class="listing-div-icons">
                                                    <span class="icon-listing-div">
                                                        <p><i class="fa fa-bed color-green" aria-hidden="true"></i>{{ config('constant.beds.'.$property->bedrooms)??'NA'}}</p>
                                                    </span>

                                                    <span class="icon-listing-div">
                                                        <p><i class="fa fa-bath color-black" aria-hidden="true"></i>{{config('constant.baths.'.$property->bathrooms)??'NA'}}</p>
                                                    </span>
                                                    <span class="icon-listing-div">
                                                        <p><i class="fa fa-usd color-green" aria-hidden="true"></i><span class="money">{{round($property->price)??'NA'}}</span></p>
                                                    </span>
                                                </div>
                                                <table>
                                                    <tbody>
                                                        <tr>
                                                        <td class="green">
                                                            List Price : <span class="money">{{round($property->price)??'NA'}}</span>
                                                        </td>
                                                        <td class="black">
                                                            <a href="{{ route('frontend.vacationDetails',$property->id) }}">PREVIEW LISTING</a>
                                                        </td> 
                                                        </tr>
                                                    </tbody>
                                                </table> 
                                            </div>
                                            <div class="col-md-12 col-sm-12 no-padding">
                                                <div class="text-center">
                                                    <a href="{{route('frontend.vacationEdit',$property->id)}}" class="btn btn-default link-button5">EDIT</a>
                                                    <a href="{{route('frontend.manageVacationAvailabilty', $property->id)}}" class="btn btn-default link-button1">MANAGE AVAILABILITY</a>
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
 $('.money').mask('000,000,000,000,000', {reverse: true});
</script>
@endsection




