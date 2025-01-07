@extends('frontend.layouts.app')
@section('title', app_name() . ' | Favorites')
@section('after-styles')
<link type="text/css" rel="stylesheet" href="{{ asset(mix('css/dashboard.css')) }}" media="all">
<style>#myfavorites{ font-weight: bold;color: #000;}</style> 
@endsection 
@section('content')
<div class="dashboard-page associates profile-view listing">    
    <div class="container">
        <div class="row content">
            @include('frontend.includes.sidebar')
            <div class="col-md-9 col-sm-8">
                <div class="right-dashboard-div">
                    <div class="right-dashboard-div-text">
                        <div class="">
                            <div class="row">
                                <div class="col-md-12 col-sm-12">
                                    <h4>My Favorites</h4>
                                </div>
                                <?php if ($favorites->count()) { ?>
                                    @foreach($favorites as $favorite)
                                    <div class="col-md-12 col-sm-12 main-listing-div">
                                        <div class="listing-box"> 
                                            <div class=""> 
                                                <!-- Modal -->
                                                <div class="modal fade" id="myModal-{{$favorite->id}}" role="dialog">
                                                    <div class="modal-dialog">
                                                        <!-- Modal content-->
                                                        <div class="modal-content text-center">
                                                            <div class="modal-body btns-green-blue">
                                                                <p>Are you sure you want to remove this user from your favorite list?</p>
                                                            </div>
                                                            <div class="text-center text-center btns-green-blue">
                                                                <a href="{{route('frontend.favorite.delete',$favorite->id)}}" class="btn btn-green">Confirm</a>
                                                                <button type="button" class="button btn btn-blue" data-dismiss="modal">Cancel</button>
                                                            </div>
                                                        </div> 
                                                    </div> 
                                                </div>
                                                <!-- SIDEBAR USERPIC -->
                                                <div class="col-md-6 col-sm-12 no-padding">
                                                    <div class="listing-div-img">
                                                        <?php
                                                        if (isset($favorite->property) && $favorite->property->images->count()) {
                                                            ?>
                                                            <img src="{{asset("storage/property_images/".$favorite->property->id .'/'.$favorite->property->images->first()->image)}}"  class="img-responsive" alt="profile photo">
                                                            <?php
                                                        } else {
                                                            ?>
                                                            <img src="{{asset("storage/site-images/no_image_available.jpg")}}"  class="img-responsive" alt="profile photo">
                                                        <?php } ?>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 col-sm-12">
                                                    <div class="cross-div"><span type="button" class="cross" data-toggle="modal" data-target="#myModal-{{$favorite->id}}"><i class="fa fa-times-circle"></i></span></div>
                                                    <div class="listing-div">
                                                        <h4>{{$favorite->property->street_address??"NA"}}</h4>
                                                        <p>State : {{ isset($favorite->property) ? findState($favorite->property->state_id) :"NA" }}</p>
                                                        <p>Home Type : {{ isset($favorite->property->architechture->home_type)? config('constant.home_type.'.$favorite->property->architechture->home_type) :"NA" }}</p>
                                                        <p>Built Year : {{$favorite->property->architechture->year_built??"NA"}}</p>
                                                    </div>
                                                    <div class="listing-div-icons">
                                                        <span class="icon-listing-div">
                                                            <p><i class="fa fa-bed color-green" aria-hidden="true"></i>{{$favorite->property->architechture->beds ?? 'NA'}}</p>
                                                        </span>
                                                        <span class="icon-listing-div">
                                                            <p><i class="fa fa-square color-black" aria-hidden="true"></i>{{$favorite->property->architechture->plot_size ?? 'NA'}}</p>
                                                        </span>

                                                        <span class="icon-listing-div">
                                                            <p><i class="fa fa-bath color-black" aria-hidden="true"></i>{{$favorite->property->architechture->baths ?? 'NA'}}</p>
                                                        </span>
                                                        <span class="icon-listing-div">
                                                            <p><i class="fa fa-usd color-green" aria-hidden="true"></i>{{$favorite->property->price ?? 'NA' }}</p>
                                                        </span>
                                                    </div>
                                                    <table>
                                                        <tbody>
                                                            <tr>
                                                            <td class="green">
                                                                List Price : {{$favorite->property->price??"NA"}}
                                                            </td>
                                                            <td class="black">
                                                                <a href="{{ route('frontend.propertyDetails',$favorite->property->id)  }}">More Info</a>
                                                            </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div><!--profile-sidebar-->
                                        </div>
                                    </div>
                                    @endforeach
                                <?php } else { ?>
                                    <div class="col-md-12 col-sm-12 main-listing-div">
                                        <div class="col-md-12 col-sm-12">
                                            <h4 class="no-data">Currently you don't have any favorite property.</h4>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                            {{ $favorites->links() }}
                        </div>
                    </div>
                </div>
            </div<!--right-dashboard-div-->           
        </div><!--col-9-->
    </div><!--row-->
</div><!--container-->
</div><!--dashboard-->
@endsection
