@extends('frontend.layouts.app')
@section ('title', ('Vacation'))
@section('after-styles') 
<link type="text/css" rel="stylesheet" href="{{ asset(mix('css/property.css')) }}" media="all">
@section('content')
<div class="register-page rent-page add-property">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="register-banner">
                        <div class="text">{{ isset($property)?"Edit Property for Timeshare":"Add Property for Timeshare"}}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <!--<div class="panel-heading"></div>-->
                        @if(isset($property))
                        {{ html()->form('POST', route('frontend.vacationUpdate'))->class('form-horizontal')->id('vac_form')->acceptsFiles()->open() }}
                        {{ html()->hidden('property_id', $property->id) }}
                        {{ html()->hidden('property_submit', 'Update') }}
                        {{ html()->hidden('property_table_id', $property->id) }}
                        @else
                        {{ html()->form('POST', route('frontend.vacationStore'))->class('form-horizontal')->acceptsFiles()->open() }}
                        @endif
                        {{ html()->hidden('property_type', config('constant.property_type.3')) }}
                        

                        <div class="row">
                            <div class="col-md-4 col-lg-4 col-sm-12 col-xs-12">
                                <div class="formField form-group">
                                    <h4 for="property_name">Property Name : <span style="color: Red;"> * </span></h4>
                                    <input type="text" value="{{isset($property) ? $property->property_name??'':''}}" class="form-control" id="property_name" data-msg-required="Please enter the property name" data-rule-required="true" data-rule-minlength="1" name="resort_name" aria-required="true">
                                    @if(count($errors->get('resort_name')) > 0)
                                    <span class="text text-danger">{{implode('<br>', $errors->get('resort_name'))}}</span>
                                    @endif
                                </div>
                            </div> 
                            <div class="col-lg-8 col-md-8 col-sm-12 col-xs-12">

                                <div class="row">
                                    <div class="formField form-group rent-radio">
                                        <div class="col-md-12">
                                            <h4>Property Type : <span style="color: Red;"> * </span></h4>
                                        </div>
                                        <div class="col-md-12">
                                            <input type="radio" name="vacation_property_type" <?php
                                            if (isset($property)) {
                                                if (config('constant.inverse_vacation_property_type.Timeshare') == $property->property_type) {
                                                    ?> checked="checked" <?php
                                                       }
                                                   }
                                                   ?> id="timeshare-vacation_property_type" value="Timeshare">
                                            <label for="timeshare-vacation_property_type">Timeshare</label>

                                            <input type="radio" name="vacation_property_type" <?php
                                            if (isset($property)) {
                                                if (config('constant.inverse_vacation_property_type.Owner Property') == $property->property_type) {
                                                    ?> checked="checked" <?php
                                                       }
                                                   }
                                                   ?> id="owner-vacation_property_type" value="Owner Property">
                                            <label for="owner-vacation_property_type">Owner Property</label>
                                            @if(count($errors->get('vacation_property_type')) > 0)
                                            <span class="text text-danger">{{implode('<br>', $errors->get('vacation_property_type'))}}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                <div class="select formField form-group">
                                    <h4 for="region">Region <span style="color: Red;"> * </span></h4>
                                    <select class="form-control" id="region" data-msg-required="Please select region" data-rule-required="true" name="region" aria-required="true">
                                        <option value="">Choose a Region</option>
                                        <?php foreach ($regions as $key => $region) { ?>
                                            <option  <?php
                                            if (isset($property)) {
                                                if ($region->id == $property->region_id) {
                                                    ?> selected="selected" <?php
                                                    }
                                                }
                                                ?>value="{{ $region->id }}">{{ $region->region }}</option>
                                            <?php }
                                            ?>
                                    </select>
                                    @if(count($errors->get('region')) > 0)
                                    <span class="text text-danger">{{implode('<br>', $errors->get('region'))}}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                <div class="formField form-group">
                                    <h4 for="subregion">Subregion : <span style="color: Red;"> * </span></h4>
                                    <select class="select form-control" id="subregion" data-msg-required="Please select SubRegion" data-rule-required="true" name="subregion" aria-required="true">
                                        <option value="">Choose an item</option>
                                        <?php foreach ($subRegions as $key => $sRegion) { ?>
                                            <option  <?php
                                            if (isset($property)) {
                                                if ($sRegion->id == $property->subregion_id) {
                                                    ?> selected="selected" <?php
                                                    }
                                                }
                                                ?> value="{{ $sRegion->id }}">{{ $sRegion->subregion }}</option>
                                            <?php }
                                            ?>
                                    </select>
                                    @if(count($errors->get('subregion')) > 0)
                                    <span class="text text-danger">{{implode('<br>', $errors->get('subregion'))}}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                <div class="select formField form-group">
                                    <h4 for="country">Country : <span style="color: Red;"> * </span></h4>
                                    <select class="form-control" data-country_id="{{$property->country_id??""}}" id="country" data-msg-required="Please select country" data-rule-required="true" name="country" required="true" aria-required="true">
                                        <option value="">Choose a country</option>
                                    </select>
                                    @if(count($errors->get('country')) > 0)
                                    <span class="text text-danger">{{implode('<br>', $errors->get('country'))}}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                <div class="select formField form-group">
                                    <h4 for="state">USA State : </h4>
                                    <select class="form-control" data-country_id="{{$property->country_id??""}}" data-state_id="{{$property->state_id??""}}" id="state" data-msg-required="Please select state" data-rule-required="true" name="state" aria-required="true">
                                        <option value="">Choose a state</option>
                                        <?php
                                        if (isset($property)) {
                                            foreach ($states as $key => $state) {
                                                ?>
                                                <option  <?php
                                                if ($state->id == $property->state_id) {
                                                    ?> selected="selected" <?php
                                                    }
                                                }
                                                ?>value="{{ $state->id }}">{{ $state->state }}</option>
                                            <?php }
                                            ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                                <div class="select formField form-group">
                                    <h4 for="city">City </h4>
                                    <select class="form-control" data-country_id="{{$property->country_id??""}}" data-city_id="{{$property->city??""}}" id="city" name="city">
                                        <option value="">Choose a city</option>
                                    </select>
                                    @if(count($errors->get('city')) > 0)
                                    <span class="text text-danger">{{implode('<br>', $errors->get('city'))}}</span>
                                    @endif
                                </div>
                            </div>
                            <input type="hidden" name="latitude" id="latitude" value="">
                            <input type="hidden" name="longitude" id="longitude" value="">
                            <div class="col-sm-12 col-xs-12 col-md-4 col-lg-4 hidden_item" id="vacation-list-zip">
                                <div class="formField form-group">
                                    <h4 for="owner_zip">Zip : <span style="color: Red;"> * </span></h4>
                                    <input type="text" class="form-control" name="owner_zip" value="{{$property->zip_code??""}}" id="owner_zip">
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-12 col-lg-12 col-xs-12 hidden_item" id="vacation-list-address">
                                <h4 for="owner_zip">Address : <span style="color: Red;"> * </span></h4>
                                <textarea class="form-control" type="text" id="owner_address" name="owner_address">{{$property->address??""}}</textarea>
                            </div>
                        </div>
                        <div class="hidden_item timeshare-info-div">
                            <div class="row">
                                <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                                    <h4 class="heading">For Timeshare Information</h4>
                                    <h4>Points Based Vacation Rentals? <span style="color: Red;"> * </span></h4> 
                                    <div class="formField form-group rent-radio">
                                        <div id="afererror">
                                            <input type="radio" value="{{ config('constant.point_based_timeshare.1') }}" <?php
                                            if (isset($property)) {
                                                if (config('constant.inverse_point_based_timeshare.Yes') == $property->point_based_timeshare) {
                                                    ?> checked="checked" <?php
                                                       }
                                                   }
                                                   ?> id="timeshare-yes" class="deselect-radio" name="point_based_timeshare">
                                            <label for="timeshare-yes">Yes</label>
                                            <input type="radio" value="{{ config('constant.point_based_timeshare.0') }}" <?php
                                            if (isset($property)) {
                                                if (config('constant.inverse_point_based_timeshare.No') == $property->point_based_timeshare) {
                                                    ?> checked="checked" <?php
                                                       }
                                                   }
                                                   ?>  id="timeshare-no" class="deselect-radio" name="point_based_timeshare">
                                            <label for="timeshare-no">No</label>
                                        </div>
                                    </div>
                                    <div class="formField form-group hidden_item" id="points_yes">
                                        <label for="points">If Yes, enter # of Points:(ex: 1025)</label>
                                        <input type="text" value="{{ $property->points??"" }}" data-msg-required="Please enter the points" data-msg-number="Please enter the valid number" data-rule-required="true" data-rule-number="true" class="form-control empty-timeshare-value" id="points" name="points" aria-required="true">
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <h4>Is this a lock-out unit? <span style="color: Red;"> * </span></h4>
                                    <div class="">
                                        <div class="formField form-group rent-radio">
                                            <div id="afererrorlock">
                                                <input type="radio" value="Yes" id="lockout-yes" class="deselect-radio" <?php
                                                if (isset($property)) {
                                                    if (config('constant.inverse_lock_out_unit.Yes') == $property->lock_out_unit) {
                                                        ?> checked="checked" <?php
                                                           }
                                                       }
                                                       ?> name="lock_out_unit">
                                                <label for="lockout-yes">Yes</label>
                                                <input type="radio" value="No" id="lockout-no" class="deselect-radio" <?php
                                                if (isset($property)) {
                                                    if (config('constant.inverse_lock_out_unit.No') == $property->lock_out_unit) {
                                                        ?> checked="checked" <?php
                                                           }
                                                       }
                                                       ?> name="lock_out_unit">
                                                <label for="lockout-no">No</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <p>(Lockout units are two separate condos, which share a common exterior security door)</p>
                                    <h4>Variable Weeks?(Please be as specific as possible with availability.) <span style="color: Red;"> * </span></h4>
                                    <div class="formField form-group rent-radio">
                                        <div id="afererrorvariable">
                                            <input type="radio" <?php
                                            if (isset($property)) {
                                                if (config('constant.inverse_variable.Yes') == $property->variable) {
                                                    ?> checked="checked" <?php
                                                       }
                                                   }
                                                   ?> value="Yes" id="variable-yes" class="deselect-radio" name="variable">
                                            <label for="variable-yes">Yes</label>
                                            <input type="radio" <?php
                                            if (isset($property)) {
                                                if (config('constant.inverse_variable.No') == $property->variable) {
                                                    ?> checked="checked" <?php
                                                       }
                                                   }
                                                   ?> value="No" id="variable-no" class="deselect-radio" name="variable">
                                            <label for="variable-no">No</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                                    <div class="formField form-group">
                                        @if(!empty($property->availableWeeks))
                                        <?php
                                        $availableWeeks = [];
                                        foreach ($property->availableWeeks as $weak) {
                                            $availableWeeks[] = $weak->available_week;
                                        }
                                        $weeks = implode(", ", $availableWeeks);
                                        ?>
                                        @endif
                                        <h4 for="available_weeks">Available Timeshare Week(s) : <span style="color: Red;"> * </span></h4>
                                        <a href="{{asset('storage/documents/Timeshare Calendar.pdf')}}" target="_blank">Refer to Timeshare Calendar</a>
                                        <textarea rows="1" type="text" class="form-control empty-timeshare-value" data-msg-required="Please enter available weeks" data-rule-required="true" id="available_weeks" name="available_weeks" placeholder="Format Ex: {1,3,5,7,12} [Enter Week Number(s) Only - See Calendar Above]" required="true" aria-required="true"><?php
                                            if (isset($weeks)) {
                                                echo $weeks;
                                            } else {
                                                
                                            }
                                            ?></textarea>
                                        @if(count($errors->get('available_weeks')) > 0)
                                        <span class="text text-danger">{{implode('<br>', $errors->get('available_weeks'))}}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                                    <div class="select formField form-group">
                                        <h4 for="checkin_day">Check-In Day : <span style="color: Red;"> * </span></h4>
                                        <select class="form-control" id="checkin_day" data-msg-required="Please select checkin day" data-rule-required="true" name="checkin_day" aria-required="true">
                                            <option value="">Choose a day</option>
                                            
                                            @foreach(config('constant.available_weeks') as $key=>$week)
                                            <option  <?php
                                            if (isset($property) && !empty($property->availableWeeks)) {
                                                if (!empty($property->availableWeeks[0]->checkin_day) && $key == $property->availableWeeks[0]->checkin_day) {
                                                    ?> selected="selected" <?php
                                                    }
                                                }
                                                ?>  value="{{ $key }}">{{ $week }}</option>
                                            @endforeach
                                        </select>
                                        @if(count($errors->get('checkin_day')) > 0)
                                        <span class="text text-danger">{{implode('<br>', $errors->get('checkin_day'))}}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <h4>Willing to exchange this vacation rentals with other owners: </h4>
                                    <div class="formField form-group rent-radio">

                                        <input type="radio" value="Yes" <?php
                                        if (isset($property)) {
                                            if (config('constant.inverse_exchange_timeshare.Yes') == $property->exchange_timeshare) {
                                                ?> checked="checked" <?php
                                                   }
                                               }
                                               ?>  id="exchange_timeshare-yes" class="deselect-radio" name="exchange_timeshare">
                                        <label for="exchange_timeshare-yes">Yes</label>
                                        <input type="radio" value="No" <?php
                                        if (isset($property)) {
                                            if (config('constant.inverse_exchange_timeshare.No') == $property->exchange_timeshare) {
                                                ?> checked="checked" <?php
                                                   }
                                               }
                                               ?> id="exchange_timeshare-no" class="deselect-radio" name="exchange_timeshare">
                                        <label for="exchange_timeshare-no">No</label>
                                    </div>
                                </div>
                            </div>
                            <div class="row hidden_item" id="exchange-div">
                                <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                                    <div class="formField form-group">
                                        <h4 for="locations">If Yes, what locations would you want to go to?  </h4>
                                        <textarea type="text" rows="4" class="form-control text-height empty-timeshare-value" id="locations" name="locations">{{$property->locations??""}}</textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                                    <h4>Available for sale? <span style="color: Red;"> * </span></h4>
                                    <div class="formField form-group rent-radio">
                                        <input type="radio" value="Yes" <?php
                                        if (isset($property)) {
                                            if (config('constant.inverse_is_available_for_sale.Yes') == $property->is_available_for_sale) {
                                                ?> checked="checked" <?php
                                                   }
                                               }
                                               ?>  name="is_available_for_sale" id="is_available_for_sale-yes" class="deselect-radio">
                                        <label for="is_available_for_sale-yes">Yes</label>
                                        <input type="radio" value="No" <?php
                                        if (isset($property)) {
                                            if (config('constant.inverse_is_available_for_sale.No') == $property->is_available_for_sale) {
                                                ?> checked="checked" <?php
                                                   }
                                               }
                                               ?>  id="is_available_for_sale-no" name="is_available_for_sale" class="deselect-radio">
                                        <label for="is_available_for_sale-no">No</label>
                                    </div>
                                </div>
                            </div>
                            <div class="hidden_item avail_sale-yes">
                                <div class="row ">
                                    <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12">
                                        <div class="formField form-group">
                                            <h4 for="sale_price">For Sale Price: $ </h4>
                                            <input type="number" value="{{$property->sale_price??""}}" class="form-control empty-timeshare-value empty-timeshare-sale-value" id="sale_price" name="sale_price" data-msg-required="Please enter sale price">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12"> 
                                        <div class="select formField form-group">
                                            <h4 for="ownership_type">Ownership Type: </h4>
                                            <select class="form-control" id="ownership_type" name="ownership_type" required="true">
                                                <option value="">Choose an item</option>
                                                @foreach(config('constant.ownership_type') as $key=>$sleep)
                                                <option <?php
                                                if (isset($property)) {
                                                    if ($key == $property->ownership_type) {
                                                        ?> selected="selected" <?php
                                                        }
                                                    }
                                                    ?> value="{{$key}}">{{$sleep}}</option>
                                                @endforeach
                                            </select>
                                            @if(count($errors->get('ownership_type')) > 0)
                                            <span class="text text-danger">{{implode('<br>', $errors->get('ownership_type'))}}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12 hidden_item ownership_child" id="lease_price">
                                        <div class="formField form-group">
                                            <h4 for="lease_expire_year">If Leased, enter the year lease will expire (ex: 2018) <span style="color: Red;"> * </span></h4>
                                            <input type="number" value="{{$property->lease_expire_year??""}}" class="form-control empty-timeshare-value empty-timeshare-sale-value" id="lease_expire_year" name="lease_expire_year">
                                            @if(count($errors->get('lease_expire_year')) > 0)
                                            <span class="text text-danger">{{$errors->first('lease_expire_year')}}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12 hidden_item ownership_child" id="points_price">
                                        <div class="formField form-group">
                                            <h4 for="how_many_points">If Points, How many points  (ex: 1025) : <span style="color: Red;"> * </span></h4>
                                            <input type="number" value="{{$property->how_many_points??""}}" class="form-control empty-timeshare-value empty-timeshare-sale-value" id="how_many_points" name="how_many_points" data-msg-required="Please enter points">
                                            @if(count($errors->get('how_many_points')) > 0)
                                            <span class="text text-danger">{{ $errors->first('how_many_points')}}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12">
                                        <div class="formField form-group"> 
                                            <h4 for="annual_maintenance_fees">Annual Maintenance Fees: $ </h4>
                                            <input type="number" value="{{$property->annual_maintenance_fees??""}}" class="form-control empty-timeshare-value empty-timeshare-sale-value" id="annual_maintenance_fees" name="annual_maintenance_fees" >
                                            @if(count($errors->get('resort_name')) > 0)
                                            <span class="text text-danger">{{ $errors->first('annual_maintenance_fees')}}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>



                        <div class="row">
                            <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 m-t-md">
                                <div class="form-group">
                                    <h4 class="heading">Photos &amp; Media : <span style="color: Red;"> * </span></h4>
                                    <span class="error errorEdit">You have to select atleast one photo</span>
                                    @if(isset($property))
                                    <p>
                                        Existing property photos, If you want to delete photos of this property then click on X button of specific image
                                    </p>
                                    @foreach($property->images as $key=>$image)
                                    <div class="col-xs-6 col-md-3 photo_holder" id="stored-photos" align="center">
                                        <a class="">
                                            <img src="{{asset("storage/property_images/".$property->id .'/'.$image->image)}}" data-image_id="{{$image->id}}" alt="">
                                        </a>
                                        <button type="button" id="stored-photos-btn" class="btn btn-default photo-store-btn" data-image-id="{{$image->id}}">
                                            <i class="fa fa-times" aria-hidden="true"></i>
                                        </button>
                                    </div>
                                    @endforeach
                                    <input type="hidden" name="image_ids" class="property-hidden">
                                    @endif

                                    <div class="row">
                                        <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                                            <div class="formField form-group upload-img-area">
                                                @if(isset($property) && !empty($property->images))
                                                <h6>Upload Photo :It's always a good idea to upload photos</h6>
                                                <h6 class="image_info_text"> For best results, we recommend your images to follow the 4:3 ratio and apply an appropriate resolution {960x720} / {1440x1080} / {2048x1536}.</h6>
                                                <div class="image-holder-col">
                                                    <div class="new-img-area file-upload">
                                                        <input class="files form-control more-option" id="upload_photo0" name="images[0]" data-value="0" type="file" aria-required="true">
                                                        <div class="file-upload__input">Browse</div>
                                                        <span class="file_error error">File size is greater than 2 MB</span>
                                                        <!--<span class="dimension_error error">Height must be in between 315 and 1024 & Width must be in between 600 and 1024</span>-->
                                                    </div>
                                                </div>
                                                @else

                                                <h6>Upload Photo :It's always a good idea to upload photos <span style="color: Red;"> * </span> </h6>
                                                <h6 class="image_info_text"> For best results, we recommend your images to follow the 4:3 ratio and apply an appropriate resolution {960x720} / {1440x1080} / {2048x1536}.</h6>
                                                <div class="image-holder-col">
                                                    <div class="new-img-area file-upload">
                                                        <input class="files form-control more-option" id="upload_photo0" name="images[0]" data-value="0" type="file" data-rule-required="true" data-msg-required="Please select the file for upload" aria-required="true">
                                                        <div class="file-upload__input">Browse</div>  
                                                        <span class="file_error error">File size is greater than 2 MB</span>
                                                        <!--<span class="dimension_error error">Height must be in between 315 and 1024 & Width must be in between 600 and 1024</span>-->
                                                    </div>
                                                </div>
                                                @endif
                                            </div>
                                            @if(count($errors->get('images[0]')) > 0)
                                            <span class="text text-danger">{{implode('<br>', $errors->get('images[0]'))}}</span>
                                            @endif     
                                        </div>
                                    </div>
                                    <div class="more-button"><label><a href="javascript:void(0);" class="add" id="addMore">Add More</a></label></div>
                                    <div  class="contents"></div>
                                    <div class="height10"></div>
                                </div>

                                <div class="formField form-group">
                                    <h4 for="propWebLink">Resort/Property Website :  </h4>
                                    <input type="text" class="form-control" id="weblink" name="propWebLink" value="" placeholder="ex: abc.com">
                                </div>

                                <div class="row m-t">
                                    <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12">
                                        <div class="select formField form-group">
                                            <h4 for="bathrooms">Bathrooms: <span style="color: Red;"> * </span></h4>
                                            <select class="form-control" name="bathrooms" data-msg-required="Please select the Bathrooms" data-rule-required="true" id="bathrooms" aria-required="true">
                                                <option value="">Choose an item</option>
                                                @foreach(config('constant.baths') as $key=>$bath)
                                                <option <?php
                                                if (isset($property)) {
                                                    if ($key == $property->bathrooms) {
                                                        ?> selected="selected" <?php
                                                        }
                                                    }
                                                    ?> value="{{$key}}">{{$bath}}</option>
                                                @endforeach
                                            </select>
                                            @if(count($errors->get('bathrooms')) > 0)
                                            <span class="text text-danger">{{implode('<br>', $errors->get('bathrooms'))}}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12">
                                        <div class="select formField form-group">
                                            <h4 for="bedrooms">Bedrooms: <span style="color: Red;"> * </span></h4>
                                            <select class="form-control" name="bedrooms" data-msg-required="Please select the Bedrooms" data-rule-required="true" id="bedrooms" aria-required="true">
                                                <option value="">Choose an item</option>
                                                @foreach(config('constant.beds') as $key=>$bed)
                                                <option <?php
                                                if (isset($property)) {
                                                    if ($key == $property->bedrooms) {
                                                        ?> selected="selected" <?php
                                                        }
                                                    }
                                                    ?> value="{{$key}}">{{$bed}}</option>
                                                @endforeach
                                            </select>
                                            @if(count($errors->get('bedrooms')) > 0)
                                            <span class="text text-danger">{{implode('<br>', $errors->get('bedrooms'))}}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12">
                                        <div class="select formField form-group">
                                            <h4 for="sleeps">Sleeps : <span style="color: Red;"> * </span></h4>
                                            <select class="form-control" id="sleeps" data-msg-required="Please select the Sleeps" data-rule-required="true" name="sleeps" aria-required="true">
                                                <option value="">Choose an item</option>
                                                @foreach(config('constant.sleeps') as $key=>$sleep)
                                                <option <?php
                                                if (isset($property)) {
                                                    if ($key == $property->sleeps) {
                                                        ?> selected="selected" <?php
                                                        }
                                                    }
                                                    ?> value="{{$key}}">{{$sleep}}</option>
                                                @endforeach
                                            </select>
                                            @if(count($errors->get('sleeps')) > 0)
                                            <span class="text text-danger">{{implode('<br>', $errors->get('sleeps'))}}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12">
                                        <div class="formField form-group">
                                            <h4 for="price">Rental Price: $ <span style="color: Red;"> * </span></h4>
                                            <input type="text" value="{{$property->price??""}}" class="form-control" id="price" name="price" required="true" data-msg-required="Please enter rental price">
                                            @if(count($errors->get('price')) > 0)
                                            <span class="text text-danger">{{implode('<br>', $errors->get('price'))}}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <h4>Rental Price Negotiable? <span style="color: Red;"> * </span></h4>
                                        <div class="formField form-group rent-radio">
                                            <input type="radio" value="Yes" <?php
                                            if (isset($property)) {
                                                if (config('constant.inverse_rental_price_negotiable.Yes') == $property->rental_price_negotiable) {
                                                    ?> checked="checked" <?php
                                                       }
                                                   }
                                                   ?>  id="rental_price_negotiable-yes" name="rental_price_negotiable">
                                            <label for="rental_price_negotiable-yes">Yes</label>
                                            <input type="radio" value="No" <?php
                                            if (isset($property)) {
                                                if (config('constant.inverse_rental_price_negotiable.No') == $property->rental_price_negotiable) {
                                                    ?> checked="checked" <?php
                                                       }
                                                   }
                                                   ?>  id="rental_price_negotiable-no" name="rental_price_negotiable">
                                            <label for="rental_price_negotiable-no">No</label>
                                        </div>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                                        <div class="formField form-group">
                                            <h4 for="property_description">Property Description : </h4>
                                            <textarea type="text" rows="4"  class="form-control text-height" id="property_description" name="property_description" data-msg-required="Please enter property details">{{$property->property_description??""}}</textarea>
                                            @if(count($errors->get('property_description')) > 0)
                                            <span class="text text-danger">{{implode('<br>', $errors->get('property_description'))}}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                                        <div class="submit-listing form-group text-center">
                                            <div class="btns-green-blue">
                                                <input class="btn button btn-blue" type="submit" value="Submit Listing" id="inputbutton" name="submit" class="btn btn-default">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{ html()->form()->close() }}
                        </div>
                    </div><!-- panel -->
                </div><!-- panel -->
            </div><!-- col-md-8 -->
        </div><!-- row -->
    </div><!-- container -->
</div><!-- register-page-->

@endsection
<script type="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
@section('after-scripts')
<script src="https://maps.googleapis.com/maps/api/js?key=<?= config('settings.google_map_api_key') ?>"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.9.1/underscore-min.js" type="text/javascript"></script>
<script id="more_image" type="text/html">
    <div class="new-img-area file-upload">
        <input class="files form-control more-option" id="upload_photo<%=copynum%>" name="images[<%=copynum%>]" type="file" data-value="<%=copynum%>" data-rule-required="true" data-msg-required="Please select the file for upload" aria-required="true" id="upload_photo">
        <div class="file-upload__input">Browse</div>
        <span class="delete-image">&#10005</span>
        <span class="file_error error">File size is greater than 2 MB</span>
        <!--<span class="dimension_error error">Height must be in between 315 and 1024 & Width must be in between 600 and 1024</span>-->
    </div>
</script>
<script>
var imagesLimit = parseInt("{{config('constant.image_count')}}");
</script>
<script src="{{ asset('js/property.js') }}"></script>
<script>
//var getIndustryService = "{{ route('frontend.businessCreate') }}";
    $(document).ready(function () {
        // validate image size on form submit
        $("form").submit(function (e) {

            var editImgError = $("#stored-photos img").length;
            var length = $('.tmpImage').length;

            if (editImgError < 1 && length < 1) {
                $('.errorEdit').show();
                e.preventDefault();
                $('html, body').animate({
                    scrollTop: $(".errorEdit").offset().top
                }, 2000);
            } else {
                $('.errorEdit').hide();
            }

            var imageErrors = 0;

            for (var i = 0; i < length; i++) {
                var file_size = $('#upload_photo' + i)[0].files[0].size;
                if (file_size > 2000000) {
                    imageErrors++;
                    $('#upload_photo' + i).siblings(".file_error").show();
                } else {
                    $('#upload_photo' + i).siblings(".file_error").hide();
                }
            }

            var _URL = window.URL || window.webkitURL;
//            for (var j = 0; j < length; j++) {
//                var tmpImg = $('#upload_photo' + j).siblings('.testtmp');
//                if (tmpImg.height() > 1024 || tmpImg.width() > 1024 || tmpImg.height() < 315 || tmpImg.width() < 600) {
//                    $('#upload_photo' + j).siblings('.dimension_error').show();
//                    imageErrors++;
//                } else {
//                    $('#upload_photo' + j).siblings('.dimension_error').hide();
//                }
//            }

            if (imageErrors > 0) {
                return false;
            } else {
                return true;
            }
        });

        // validate image size on change
        var _URL = window.URL || window.webkitURL;
        $(document).on('change', '.files', function () {
            var changeSelector = $(this);
            var checkSize = $(this)[0].files[0].size;
            if (checkSize < 2000000) {
                changeSelector.siblings('.file_error').hide();
            } else if (checkSize > 2000000) {
                setTimeout(function () {
                    changeSelector.siblings('.file_error').show();
                }, 1000);
            }

//            var file, img;
//            if (file = this.files[0]) {
//                img = new Image();
//                img.onload = function () {
//                    if (this.width > 600 && this.height > 315 && this.width < 1024 && this.height < 1024) {
//                        changeSelector.siblings('.dimension_error').hide();
//                    } else if (this.width < 600 || this.height < 315 || this.width > 1024 || this.height > 1024) {
//                        setTimeout(function () {
//                            changeSelector.siblings('.dimension_error').show();
//                        }, 1000);
//                    }
//                };
//                img.src = _URL.createObjectURL(file);
//            }
        });

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
        $("#ownership_type").change(function () {
            $("#how_many_points-error, #lease_expire_year-error").hide();
        });
        var isProperty = "{{$property??''}}";
        if (isProperty) {
            $('#subregion').prop('disabled', false);
            $('#country').prop('disabled', false);
            $('#state').prop('disabled', false);
            $('#city').prop('disabled', false);
        } else {
            $('#subregion').prop('disabled', true);
            $('#country').prop('disabled', true);
            $('#state').prop('disabled', true);
            $('#city').prop('disabled', true);
        }
        var regionId = $('#region option').filter(':selected').val();
        var subregionId = $('#subregion option').filter(':selected').val();
        var city_id = $('#city').attr('data-city_id');
        var state_id = $('#state').attr('data-state_id');
        var countryId = $('#country').attr('data-country_id');  //stored database values
        if (countryId) {
            var country_id = countryId;
        } else {
            var country_id = $('#country option').filter(':selected').val();
        }
        if (subregionId) {
            $.ajax({
                type: "get",
                url: "{{ route('frontend.countrySearch') }}",
                data: {
                    region_id: parseInt(regionId),
                    subregion_id: parseInt(subregionId),
                    country_id: parseInt(country_id),
                },
                success: function (response) {
                    $('#subregion').children('option').remove();
                    $('#country').children('option').remove();
                    $('#subregion').append(response.subregions);
                    $('#country').append(response.countries);
                },
                error: function (error) {
                }
            });
            // US staes AJAX
            if (country_id == 227) {
                $.ajax({
                    type: "get",
                    url: "{{ route('frontend.stateSearch') }}",
                    data: {
                        country_id: parseInt(country_id),
                        state_id: parseInt(state_id),
                        city_id: city_id,
                    },
                    success: function (response) {
                        $('#state').children('option').remove();
                        $('#state').append(response.states);
                    },
                    error: function (error) {
                    }
                });
                $.ajax({
                    type: "get",
                    url: "{{ route('frontend.citySearch') }}",
                    data: {
                        country_id: parseInt(country_id),
                        state_id: state_id,
                        city_id: city_id,
                    },
                    success: function (response) {
                        $('#city').children('option').remove();
                        $('#city').append(response.cities);
                        $("#city").val("{{$property->city??''}}");
                        $('form').validate();
                    },
                    error: function (error) {
                    }
                });
            } else {
                $('#state').prop('disabled', true);

                $.ajax({
                    type: "get",
                    url: "{{ route('frontend.citySearch') }}",
                    data: {
                        country_id: parseInt(country_id),
                        state_id: state_id,
                        city_id: city_id,
                    },
                    success: function (response) {
                        $('#city').children('option').remove();
                        $('#city').append(response.cities);
                        $("#city").val("{{$property->city??''}}");
                        $('form').validate();
                        $('#city').change(function () {
                            $('#city-error').hide();
                        });
                    },
                    error: function (error) {
                    }
                });
            }
        }

        $("#subregion").change(function (e) {
            e.preventDefault();
            $('#city').prop('disabled', true);
            $('#country').prop('disabled', false);
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
                    $('#country').append(response.countries);
                },
                error: function (error) {
                }
            });
        });
        $("#state").change(function (e) {
            e.preventDefault();
//      var stored_state_id = $('#state').attr('data-state_id');
            $('#city').prop('disabled', true);
            $.ajax({
                type: "get",
                url: "{{ route('frontend.citySearch') }}",
                data: {
                    state_id: parseInt($('#state option').filter(':selected').val()),
                    country_id: parseInt($('#country option').filter(':selected').val()),
                },
                success: function (response) {
                    $('#city').prop('disabled', false);
                    $('#city').children('option').remove();
                    $('#city').append(response.cities);
                    $('form').validate();
                    $('#city').change(function () {
                        $('#city-error').hide();
                    });
                },
                error: function (error) {
                }
            });
        });
        $("#country").change(function (e) {
            e.preventDefault();

            var getAdd = $(this).find(":selected").text();
            var geocoder = new google.maps.Geocoder();
            geocoder.geocode({'address': getAdd}, function (results, status) {
                if (status == google.maps.GeocoderStatus.OK) {
                    $('#latitude').val(results[0].geometry.location.lat());
                    $('#longitude').val(results[0].geometry.location.lng());
                } else {
                    console.log('Something got wrong with google maps');
                }
            });

            var usCountryExists = $('#country option').filter(':selected').val();
            if (usCountryExists == 227) {

                $('#city').prop('disabled', false);
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
                    },
                    error: function (error) {
                    }
                });
                $("#state-error").show();
            } else {
                $('#state').children('option').remove();
                $("#state-error").hide();
                $('#state').prop('disabled', true);
                $.ajax({
                    type: "get",
                    url: "{{ route('frontend.citySearch') }}",
                    data: {
                        country_id: parseInt($('#country option').filter(':selected').val()),
                    },
                    success: function (response) {
                        $('#city').prop('disabled', false);
                        $('#city').children('option').remove();
                        $('#city').append(response.cities);
                        $('form').validate();
                    },
                    error: function (error) {
                    }
                });
            }
        });
        $("#region").change(function (e) {
            $('#country').prop('disabled', true);
            $('#state').prop('disabled', true);
            $('#city').prop('disabled', true);
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
                },
                error: function (error) {
                }
            });
        });

        // available for sale option
        $('#is_available_for_sale-yes').click(function () {
            $(".avail_sale-yes").show();
        });
        $("#is_available_for_sale-no").click(function () {
            $(".avail_sale-yes").hide();
            $("#avail_sale-yes input").val('');
            $("#ownership_type").val(null).trigger('change');
             $(".empty-timeshare-sale-value").val("");
        });
        if ($("#is_available_for_sale-yes").is(':checked')) {
            $(".avail_sale-yes").show();
        }

        //  owner property zip and address show code
        $("#owner-vacation_property_type").click(function () {
            $("#vacation-list-zip, #vacation-list-address").show();
            $(".timeshare-info-div").hide();
            $(".deselect-radio").prop('checked',false);
            $(".empty-timeshare-value").val("");
            $(".avail_sale-yes").hide();
            $("#points_yes").hide();
            $("#checkin_day").val(null).trigger('change');
            $("#ownership_type").val(null).trigger('change');
            
        });
        
        $("#timeshare-vacation_property_type").click(function () {
            $("#vacation-list-zip, #vacation-list-address").hide();
            $("#owner_zip, #owner_address").val('');
            $(".timeshare-info-div").show();
        });
        //willing to exchnage
        $("#exchange_timeshare-yes").click(function () {
            $("#exchange-div").show();
        });
        $("#exchange_timeshare-no").click(function () {
            $("#exchange-div").hide();
            $("#locations").val('');
        });
        //  lockout unit
        $("#timeshare-yes").click(function () {
            $("#points_yes").show();
        });
        $("#timeshare-no").click(function () {
            $("#points_yes").hide();
            $("#points").val('');
        });
        
        if ($("#timeshare-yes").is(':checked')) {
            $("#points_yes").show();
        }

        // ownership type
        $("#ownership_type").change(function () {
            var own_type_val = $(this).val();
            if (own_type_val == 1) {
                $('.ownership_child').hide();
                $('.ownership_child input').val('');
            } else if (own_type_val == 2) {
                $('.ownership_child').hide();
                $('.ownership_child input').val('');
                $("#lease_price").show();
            } else if (own_type_val == 3) {
                $('.ownership_child').hide();
                $('.ownership_child input').val('');
                $("#points_price").show();
            } else {
                $("#points_price").hide();
                $("#lease_price").hide();
            }
        });
        if ($('#ownership_type').val() == 2) {
            $('#lease_price').show();
        }
        if ($('#ownership_type').val() == 3) {
            $('#points_price').show();
        }
        if ($("#owner-vacation_property_type").is(":checked")) {
            $("#vacation-list-zip, #vacation-list-address").show();
        }
        $('select').select2();
        $('form').validate({
            rules: {
                vacation_property_type: {
                    required: true
                },
                point_based_timeshare: {
                    required: true
                },
                lock_out_unit: {
                    required: true
                },
                variable: {
                    required: true
                },
//                exchange_timeshare: {
//                    required: true
//                },
                rental_price_negotiable: {
                    required: true
                },
                is_available_for_sale: {
                    required: true
                },
                owner_zip: {
                    required: function (element) {
                        if ($("#owner-vacation_property_type").is(":checked")) {
                            return true;
                        } else {
                            return false;
                        }
                    }
                },
                owner_address: {
                    required: function (element) {
                        if ($("#owner-vacation_property_type").is(":checked")) {
                            return true;
                        } else {
                            return false;
                        }
                    }
                },
//                locations: {
//                    required: function (element) {
//                        if ($('#exchange_timeshare-yes').is(":checked")) {
//                            return true;
//                        } else {
//                            return false;
//                        }
//                    }
//                },
//                annual_maintenance_fees: {
//                    required: true,
//                    maxlength: 4
//                },
                lease_expire_year: {
                    required: function (element) {
                        if ($("#ownership_type").val() == 2) {
                            return true;
                        } else {
                            return false;
                        }
                    },
                    maxlength: 4
                },
                how_many_points: {
                    required: function (element) {
                        if ($("#ownership_type").val() == 3) {
                            return true;
                        } else {
                            return false;
                        }
                    }
                },
                state: {
                    required: function (element) {
                        if ($("#country option:selected").text() == "United States") {
                            return true;
                        } else {
                            return false;
                        }
                    }
                }
            },
            messages: {
//                annual_maintenance_fees: {
//                    required: "Please enter annual maintenance fees"
//                },
                vacation_property_type: {
                    required: "Please select any option"
                },
                point_based_timeshare: {
                    required: "Please select any option"
                },
                lock_out_unit: {
                    required: "Please select any option"
                },
                variable: {
                    required: "Please select any option"
                },
//                exchange_timeshare: {
//                    required: "Please select any option"
//                },
                rental_price_negotiable: {
                    required: "Please select any option"
                },
                is_available_for_sale: {
                    required: "Please select any option"
                },
                ownership_type: {
                    required: "Please select ownership type"
                },
                lease_expire_year: {
                    required: "Please enter the year lease will expire",
                    maxlength: "Please enter not more than 4 numbers"
                },
//                locations: {
//                    required: "Please enter the locations you want to go to"
//                },
                owner_zip: {
                    required: "Please enter zip code"
                },
                owner_address: {
                    required: "Please enter your address"
                }
            },
            errorPlacement: function (error, element) {
                if (element.is(":radio"))
                {
                    error.appendTo(element.parents('.rent-radio'));
                } else if (element.is("select.form-control"))
                {
                    error.appendTo(element.parents('.formField'));
                } else
                {
                    error.insertAfter(element);
                }
            }
        });

    });

</script>
@if (config('access.captcha.registration'))
{!! NoCaptcha::renderJs('recaptchaCallback') !!}
@endif
@endsection