@extends ('frontend.layouts.app')
@section ('title', ('Network-Portal'))
@section('after-styles') 
<link type="text/css" rel="stylesheet" href="{{ asset(mix('css/forum.css')) }}" media="all">
@endsection 
@section('content') 
<div class="contact-page body-color search network-portal social-network-forum">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="contact-banner">
                        <div class="text">Social Network</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
        <div class="container">
            <div class="row">
            <div class="col-md-12">
                <div id="form_text_main">
                    <div class="row">
                        <div class="head-img">
                        </div>
                    </div>
                    <h2>WELCOME TO YOUR FREEZYLIST SOCIAL NETWORK</h2>
                    <p class="m-zero mr-top"> Real estate decisions often correlate lifestyle preferences with the economics of local communities and surrounding amenities.
                        Use this network to <span class="blue-text">interact</span> with local residents and <span class="blue-text">connect</span> with experienced <span class="blue-text">Freezylist members.</span> 
                    </p> 
                    <div class="container location  forum-page">
                        <div class="col-md-12">
                            <div class="col-md-4 col-sm-4">
                                <div class="">             
                                    <div class="icon-text">
                                        <div class="icon-one">
                                        </div>
                                        <h5>Search Local Residents </h5> 
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4">
                                <div class="">             
                                    <div class="icon-text">
                                        <div class="icon-two">
                                        </div>
                                        <h5>Make New Acquaintances</h5> 
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-4">
                                <div class="">             
                                    <div class="icon-text">
                                        <div class="icon-three">
                                        </div>
                                        <h5>Seek Guidance & Support</h5> 
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <hr style="border: 4px solid gray;" />
                    
                    <div class="form-list">
                        {{ html()->form('GET', route('frontend.searched.socialNetwork'))->class('form-horizontal')->open() }}
                        <div class="row">
                            
                            <div class="col-md-3 col-sm-3 col-xs-12">
                                <div class="select formField">
                                    <label>State</label>
                                    <select class="form-control orderby" name="state" id="state" required="required">
                                        <option value="">Select State</option>
                                        @foreach($states as $state)
                                        <option value="{{ $state->id }}" <?php if($request && $state->id == $request->state){ ?>
                                                selected="selected"
                                        <?php } ?>>{{ $state->state }}</option>;
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-md-3 col-sm-3 col-xs-12">
                                <div class="formField">
                                    <label>Search by Name (Optional)</label>
                                    <input type="text" class="form-control" name="name" id="name-zip" value="{{$request->name??""}}" placeholder="Name ">
                                </div>
                            </div>
                            
                            <div class="col-md-3 col-sm-3 col-xs-12">
                                <div class="formField">
                                    <label>Search by Zip Code</label>
                                    <select class="form-control" name="zip" value="" id="zip-code" >
                                        <option value="" selected="selected">Select Zip Code</option>
                                    </select>
                                </div>                                
                            </div>
                            
                            <input type="hidden" name="latitude" id="latitude" value="">
                            <input type="hidden" name="longitude" id="longitude" value="">
                            
                            <div class="col-md-3 col-sm-3 col-xs-12">
                                <div class="select formField">
                                    <label>Zip Code Search Area</label>
                                    <select id="radius" name="radius" class="form-control orderby">
                                        <option value="" >Miles from Center of Zip</option>
                                        <option value="10">10 Miles</option>
                                        <option value="25">25 Miles</option>
                                        <option value="50">50 Miles</option>
                                        <option value="100">100 Miles</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-md-3 col-sm-3 col-xs-12" id="limit">
                                <div class="select formField">
                                    <label>Results Displayed Per Page</label>
                                    <select class="form-control orderby" name="limit" id="page-limit">
                                        <option value="10">10</option>
                                        <option value="25">25</option>
                                        <option value="50">50</option>
                                        <option value="100">100</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-sm-12 col-md-12 btn-search">
                                <div class="formField btns-green-blue mr-top">
                                    <input type="submit" class="btn btn-primary button btn-blue" name="submit" id="inputbutton" value="Search">
                                </div>
                            </div>
                            
                        </div>
                        {{ html()->form()->close() }}
                    </div>

                </div><!-- col-md-12 -->
            </div><!-- row -->
        </div>
        </div>
</div>

<?php if (isset($search) && count($search)>0) { ?>
    <div class="network network-search-div">  
        <div class="container">
            <div class="">
                @foreach($search as $user)
                <div class="col-md-6 col-sm-6">
                    <div id="left-col" class="search-user-div">
                        <div class="row">
                            <div class="col-md-6 col-sm-12">
                                <div class="profile-userpics-user-div">
                                    @if($user->image)
                                    <img src="{{asset("storage/profile_images/".$user->id.'/'.$user->image)}}"  class="img-responsive" id="userimage" alt="pic">
                                    @else
                                    <img src="{{asset("storage/site-images/no_image_available.jpg")}}"  class="img-responsive" id="userimage" alt="pic">
                                    @endif                       
                                    <a href="{{ route('frontend.network.userDetails',$user->id) }}" class="more-info" >MORE INFO...</a>
                                </div>
                                <div class="bonus-pic">
                                    <img src="{{asset('storage/site-images/Novice.png')}}" width="100%" data-points="0">
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-12 text-user-div">  
                                <?php // dump($user->toArray());?>
                                @if($user->user_profile)
                                <p class="heading-text">{{ $user->user_profile->full_name }}</p>
                                @elseif($user->business_profile)
                                <p class="heading-text">{{ $user->business_profile->company_name }}</p>
                                @else
                                <p class="heading-text">NA</p>
                                @endif
                                <p class="para-text"><span class="text"><span class="info-icon"><i class="fa fa-map-marker" aria-hidden="true"></i></span>City :</span> <span class="bold">@if($user->city){{ $user->city }} @else NA @endif</span></p>
                                <p class="para-text"><span class="text"><span class="info-icon"><i class="fa fa-map-marker" aria-hidden="true"></i></span>State :</span> <span class="bold">@if($user->city)<?php echo findState($user->state_id); ?> @else NA @endif</span></p>
                                <p class="para-text"><span class="text"><span class="info-icon"><i class="fa fa-map-marker" aria-hidden="true"></i></span>Zip :</span> <span class="bold">@if($user->city){{ $user->zip_code }} @else NA @endif</span></p>
                                <p class="para-text"><span class="text"><span class="info-icon"><i class="fa fa-map-marker" aria-hidden="true"></i></span>County :</span> <span class="bold">@if($user->city){{ $user->county }} @else NA @endif</span></p>
            <!--                    <p><span class="heading-head">Account Type :</span> 
                                <?php
                                if (count($user->roles) > 1) {
                                    echo $user->roles[1]->name;
                                } else {
                                    echo $user->roles[0]->name;
                                }
                                ?></p>-->                    
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            {{ $search->appends($request->toArray())->links() }}
        </div>
    </div>
<?php } elseif(isset($search) && count($search)==0) { ?>
<div class="container no-network-search">
    <h3 class="noprop">No members are currently registered in your search area.</h3>
</div>
<?php } ?>
@endsection
@section('after-scripts')
<script src="https://maps.googleapis.com/maps/api/js?key=<?= config('settings.google_map_api_key') ?>" type="text/javascript"></script>
<script>
    $(document).ready(function () {
        $('form').validate({
            messages: {
                state: "Please enter state"
            },
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
        <?php if(isset($request) && $request) { ?>
            $('#state').val("{{$_GET['state']??''}}");
            $('#radius').val("{{$_GET['radius']??''}}");
            $('#page-limit').val("{{$_GET['limit']??''}}");
            $('#latitude').val("{{$request->latitude??''}}");
            $('#longitude').val("{{$request->longitude??''}}");
        <?php } ?>
            $('#radius').prop('disabled',true);
            if("{{$_GET['zip']??''}}"){
                $('#radius').prop('disabled',false);
            } else {
                $('#radius').prop('disabled',true);
            }
            if("{{$_GET['state']??''}}"){
                $('#zip-code').prop('disabled',false);
                $.ajax({
                    type: "get",
                    url: "{{ route('frontend.citySearch') }}",
                    data: {
                        state_id: parseInt($('#state option').filter(':selected').val())
                    },
                    success: function (response) {
                        $('#zip-code').prop('disabled',false);
                        $('#zip-code').children('option').remove();
                        $('#zip-code').append($('<option value>Select Zip code</option>'));
                        $.each(response.zipCodes, function (i, item) {
                            $('#zip-code').append($('<option>', {
                                value: item,
                                text : item
                            }));
                        });
                        $('#zip-code').val("{{$_GET['zip']??''}}");
                    },
                    error: function (error) {
                    }
                });
            } else {
                $('#zip-code').prop('disabled','true');
                $('#radius').prop('disabled','disabled');
            }
            $("#state").change(function (e) {
                e.preventDefault();
                $.ajax({
                    type: "get",
                    url: "{{ route('frontend.citySearch') }}",
                    data: {
                        state_id: parseInt($('#state option').filter(':selected').val())
                    },
                    success: function (response) {
                        $('#zip-code').prop('disabled',false);
                        $('#zip-code').children('option').remove();
                            $('#zip-code').append($('<option value>Select Zip code</option>'));
                        $.each(response.zipCodes, function (i, item) {
                            $('#zip-code').append($('<option>', {
                                value: item,
                                text : item
                            }));
                        });
                    },
                    error: function (error) {
                    }
                });
                $("#state-error").hide();
            });
            $("#zip-code").change(function(e) {
                if($('#zip-code option:selected').val() != ""){
                    $('#radius').prop('disabled',false);
                } else {
                    $('#radius').prop('disabled','disabled');
                }
            });
            function getLatLngByZipcode(zipcode){
                var geocoder = new google.maps.Geocoder();
                var address = zipcode;
                geocoder.geocode({ 'address': address }, function (results, status) {
                    if (status == google.maps.GeocoderStatus.OK) {
                        var latitude = results[0].geometry.location.lat();
                        var longitude = results[0].geometry.location.lng();
                        $('#latitude').val(latitude);
                        $('#longitude').val(longitude);
                    }
                });
                return [latitude, longitude];
            }
            $('#zip-code').on('select2:select', function (e) {
                getLatLngByZipcode($('#zip-code option:selected').text());
            });
        $('select').select2();

    });
</script>
@endsection
