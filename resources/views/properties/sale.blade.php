@extends('frontend.layouts.app')
@section ('title', ('Sale'))
@section('after-styles')
<link type="text/css" rel="stylesheet" href="{{ asset(mix('css/property.css')) }}" media="all">
@section('content')
<div class="register-page rent-page add-property">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="register-banner">
                        <div class="text">@if(isset($property)) Edit @else Add @endif Property for Sale</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="">
                <div class="panel panel-default">
                    <div class="panel-body">
                        @if(isset($property))
                        {{ html()->form('POST', route('frontend.propertyUpdate'))->class('form-horizontal')->acceptsFiles()->open() }}
                        {{ html()->hidden('property_submit', 'Update') }}
                        {{ html()->hidden('property_table_id', $property->id) }}
                        {{ html()->hidden('property_architecture_table_id', $property->architechture->id) }}
                        @else
                        {{ html()->form('POST', route('frontend.saleStore'))->class('form-horizontal')->acceptsFiles()->open() }}
                        @endif
                        {{ html()->hidden('property_type', config('constant.property_type.2')) }}
                        <div class="">
			    <div class="col-md-12">
				<div class="row">
				    <input type="hidden" class="form-control" data-rule-required="true" data-rule-minlength="1" data-msg-required="Please enter property name or ID" id="property_id" name="property_id" readonly="readonly" value="{{$property->property_name??'127238'}}" aria-required="true">
<!--				                                <div class="col-md-3 col-lg-3 col-sm-12 col-xs-12">
								    <div class="formField form-group">
									<h4 for="property_id">Property ID </h4>
									<input type="text" class="form-control" data-rule-required="true" data-rule-minlength="1" data-msg-required="Please enter property name or ID" id="property_id" name="property_id" readonly="readonly" value="{{$property->property_name??'127238'}}" aria-required="true">
									@if(count($errors->get('property_id')) > 0)
									<span class="text text-danger">{{implode('<br>', $errors->get('property_id'))}}</span>
									@endif
								    </div>
								</div>-->
				    <div class="col-md-4 col-lg-4 col-sm-12 col-xs-12">
					<div class="formField form-group">
					    <h4 for="postal_code">Search Address</h4>
					    <input type="text" id="postal_code" class="form-control">
					</div>                  
				    </div>
				    <div class="col-md-4 col-lg-4 col-sm-12 col-xs-12 custom_zipcode" style="display:none">
					<div class="formField form-group">
					    <h4>Zipcode <span style="color: Red;"> * </span></h4>
					    <select id="custom_zip" class="form-control not-allow" name="zip" aria-required="true" data-get_counties="{{route('frontend.getZipCodes')}}" required>
						<option value="" >Select Zipcode</option>
						<?php
						if (isset($zipcodes) && count($zipcodes) > 0) {
						    foreach ($zipcodes as $zip) {
							?>
	                                                <option value="{{$zip->zipcode}}" <?= (isset($zip->zipcode) and $zip->zipcode == $count->id) ? "selected='selected'" : "" ?>>{{$zip->zipcode}}</option>
						    <?php
						    }
						}
						?>
					    </select>
					    @if(count($errors->get('county')) > 0)
					    <span class="text text-danger">{{implode('<br>', $errors->get('zip'))}}</span>
					    @endif
					</div>
				    </div>
				    <div class="col-md-4 col-lg-4 col-sm-12 col-xs-12 old_zipcode">
					<div class="formField form-group">
					    <h4 for="postal_code">Zip Code <span style="color: Red;"> * </span></h4>
					    <input type="number"  readonly="readonly" id="zip_code" class="form-control" value="{{ isset($property)?findZipCode($property->zip_code_id):"" }}" data-msg-required="Please fill zip code" data-rule-required="true" name="zip" aria-required="true" required="true">
					    <!--                                    @if(count($errors->get('zip')) > 0)
										<span class="text text-danger">{{implode('<br>', $errors->get('zip'))}}</span>
										@endif-->
					</div>                  
				    </div>
				    <div class="col-md-4 col-lg-4 col-sm-12 col-xs-12">
					<div class="formField form-group">
					    <h4>State <span style="color: Red;"> * </span></h4>
					    <input type="text" id="state" value="{{ isset($property)?findState($property->state_id):"" }}" class="form-control not-allow" data-msg-required="Please fill state" data-rule-required="true" name="state" aria-required="true" readonly="readonly">
					    <input type="hidden" id="district-route-name" data-district_route_name="{{ route('frontend.schoolDistrict') }}" value="">
					    @if(count($errors->get('state')) > 0)
					    <span class="text text-danger">{{implode('<br>', $errors->get('state'))}}</span>
					    @endif
					</div>
				    </div>
				</div>
			    </div>

			    <div class="col-md-4 col-lg-4 col-sm-12 col-xs-12 custom_city" style="display:none">
                                <div class="formField form-group">
                                    <h4>City <span style="color: Red;"> * </span></h4>
                                    <select id="custom_city" class="form-control not-allow" name="city" aria-required="true" data-get_counties="{{route('frontend.getCities')}}" required>
                                        <option value="" >Select City</option>
					<?php
					if (isset($cities) && count($cities) > 0) {
					    foreach ($cities as $city) {
						?>
						<option value="{{$city->id}}" <?= (isset($city->county_id) and $city->county_id == $count->id) ? "selected='selected'" : "" ?>>{{$city->city}}</option>
					    <?php
					    }
					}
					?>
                                    </select>
                                    @if(count($errors->get('county')) > 0)
                                    <span class="text text-danger">{{implode('<br>', $errors->get('zip'))}}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-4 col-lg-4 col-sm-12 col-xs-12 old_city">
                                <div class="formField form-group">
                                    <h4>City <span style="color: Red;"> * </span></h4>
                                    <input type="text" id="city" readonly="readonly" class="form-control not-allow" value="{{ isset($property)?getCityName($property->city_id):"" }}" name="city" aria-required="true" required="true" data-msg-required="Please enter city">
                                    @if(count($errors->get('city')) > 0)
                                    <span class="text text-danger">{{implode('<br>', $errors->get('city'))}}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-4 col-lg-4 col-sm-12 col-xs-12">
                                <div class="formField form-group">
                                    <h4>County <span style="color: Red;"> * </span></h4>
                                    <select id="county" class="form-control not-allow"name="county" aria-required="true" data-get_counties="{{route('frontend.getCounties')}}" required>
                                        <option value="" >Select County</option>
					<?php
					if (isset($counties) && count($counties) > 0) {
					    foreach ($counties as $count) {
						?>
						<option value="{{$count->id}}" <?= (isset($property->county_id) and $property->county_id == $count->id) ? "selected='selected'" : "" ?>>{{$count->county}}</option>
					    <?php
					    }
					}
					?>
                                    </select>
                                    @if(count($errors->get('county')) > 0)
                                    <span class="text text-danger">{{implode('<br>', $errors->get('county'))}}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-4 col-lg-4 col-sm-12 col-xs-12">
                                <div class="formField form-group">
                                    <h4 for="townhouse">Townhouse/Apt #</h4>
                                    <input type="text" class="form-control" id="townhouse" name="townhouse" placeholder="Ex: 23-B" value="{{$property->townhouse_apt??""}}">
                                </div>
                            </div>
                            <div class="col-md-12 clear-both">
				<div class="row">
				    <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12">
					<div class="formField form-group">
					    <h4 for="street_address">Street Address <span style="color: Red;"> * </span></h4>
					    <input type="text" class="form-control" id="street_address" value="{{$property->street_address??""}}" name="street_address" aria-required="true" required>
					    @if(count($errors->get('street_address')) > 0)
					    <span class="text text-danger">{{implode('<br>', $errors->get('street_address'))}}</span>
					    @endif
					</div>
				    </div>

				    <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12">
					<h4>Sale Price <span style="color: Red;"> * </span></h4> 
					<div class="formField form-group">
					    <input type="number" value="{{ $property->price ??'' }}" maxlength="9" class="form-control" data-rule-required="true" data-rule-number="true" data-msg-required="Please enter price" data-msg-number="Please enter number only." id="price" name="price" value="" required="true" aria-required="true">
					    @if(count($errors->get('price')) > 0)
					    <span class="text text-danger">{{implode('<br>', $errors->get('price'))}}</span>
					    @endif
					</div>
				    </div>

				    <input type="hidden" name="latitude" id="latitude" value="{{$property['latitude']??""}}">
				    <input type="hidden" name="longitude" id="longitude" value="{{$property['longitude']??""}}">
				</div>
			    </div>
                        </div>



                        <div class="">
                            <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                                <div class="formField form-group">
                                    <h4 class="heading">Photos &amp; Media :</h4>
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

                                    <!--------------------------------->
                                    <div class="row">
                                        <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                                            <div class="formField form-group upload-img-area">
                                                @if(isset($property) && !empty($property->images))
                                                <h6>Upload Photo :It's always a good idea to upload photos</h6>
                                                <h6 class="image_info_text"> For best results, we recommend your images to follow the 4:3 ratio and apply an appropriate resolution {960x720} / {1440x1080} / {2048x1536}.</h6>
                                                <div class="image-holder-col">
                                                    <div class="new-img-area file-upload">
                                                        <input class="form-control more-option files" id="upload_photo0" name="images[0]" data-value="0" type="file" <?php if (isset($property) && !$property) { ?> data-rule-required="true" data-msg-required="Please select the file for upload" <?php } ?> aria-required="true" />
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
                                                        <input class="form-control more-option files" id="upload_photo0" name="images[0]" data-value="0" type="file" <?php if (isset($property) && !$property) { ?> data-rule-required="true" data-msg-required="Please select the file for upload" <?php } ?> aria-required="true" />
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

                                    @if(@$property->image)
                                    <div class="row" id="showImage">
                                        <img src="{{asset("storage/property_images/".$property->id .'/'.$image->image)}}" class='img-responsive' alt="uploaded-photo" class="showUpload">
                                    </div>
                                    @endif
                                    <!--------------------------------->
                                    <div class="more-button"><label><a href="javascript:void(0);" class="add" id="saleAdd">Add More</a></label></div>
                                    <div  class="contents"></div>
                                    <div class="height10"></div>
                                </div>
                                @if(count($errors->get('images')) > 0)
                                <span class="backend-errors alert-danger">{{ $errors->first('images') }}</span>
                                @endif
                            </div>
                        </div>

                        <!--------------------------------->
                        <div class="">
                            <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                                <div class="formField form-group">
                                    <h4 for="vturl">Virtual Tour URL :  </h4>
                                    <input type="text" class="form-control" id="vturl" name="vturl" value="{{ $property->virtual_tour_url ??'' }}" placeholder="ex: abc.com">
                                </div>
                            </div>
                        </div>
                        <!--------------------------------->

                        <div class="">
                            <div class="col-sm-12 col-xs-12">
                                <h4 class="heading">Home Facts</h4>
                            </div>
                            <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12">
                                <div class="select formField form-group">
                                    <label for="home_type">Home Type <span style="color: Red;"> * </span>  </label>
                                    <select class="form-control" name="home_type" data-rule-required="true" data-msg-required="Please select home type" id="home_type" aria-required="true">
                                        <option value="">Select</option>
                                        @foreach(config('constant.home_type') as $key=>$home)
                                        <option  <?php
					    if (isset($property)) {
						if ($key == $property->architechture->home_type) {
						    ?> selected="selected" <?php
					}
				    }
					    ?>  value="{{ $home }}">{{ $home }}</option>
                                        @endforeach
                                    </select>
                                    @if(count($errors->get('home_type')) > 0)
                                    <span class="text text-danger">{{implode('<br>', $errors->get('home_type'))}}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12">
                                <div class="select formField form-group">
                                    <label for="beds">Beds <span style="color: Red;"> * </span>  </label>
                                    <select class="form-control" name="beds" data-rule-required="true" data-msg-required="Please select beds" id="beds" aria-required="true">
                                        <option value="">Select</option>
					<?php
					$i;
					for ($i = 1; $i <= 10; $i++) {
					    ?>
    					<option <?php
						if (isset($property)) {
						    if ($i == $property->architechture->beds) {
							?> selected="selected" <?php
						    }
						}
						?> value="<?php echo $i; ?>"> {{$i}}</option>
					<?php } ?>
                                        <option <?php
					    if (isset($property)) {
						if ($property->architechture->beds == 11) {
						    ?> selected="selected" <?php
					}
				    }
					    ?>value = "11"> 10+</option>
                                    </select>
                                    @if(count($errors->get('beds')) > 0)
                                    <span class="text text-danger">{{implode('<br>', $errors->get('beds'))}}</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!--------------------------------->

                        <div class="">
                            <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12">
                                <div class="select formField form-group">
                                    <label for="baths">Baths <span style="color: Red;"> * </span>  </label>
                                    <select class="form-control" name="baths" data-rule-required="true" data-msg-required="Please select baths" id="baths" aria-required="true">
                                        @foreach(config('constant.baths') as $key=>$bath)
                                        <option <?php
					    if (isset($property)) {
						if ($key == $property->architechture->baths) {
						    ?> selected="selected" <?php
					}
				    }
					    ?> value="{{$key}}">{{$bath}}</option>
                                        @endforeach
                                    </select>
                                    @if(count($errors->get('baths')) > 0)
                                    <span class="text text-danger">{{implode('<br>', $errors->get('baths'))}}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6 col-lg-6 col-sm-12 col-xs-12">
                                <div class="select formField form-group">
                                    <label for="lotsize">Size of Home  (Sq Ft) <span style="color: Red;"> * </span>  </label>
                                    <select class="form-control" name="home_size" data-rule-required="true" data-msg-required="Please select size of home" id="lotsize" aria-required="true">
                                        @foreach(config('constant.home_size') as $key=>$homeSize)
                                        <option <?php
					    if (isset($property)) {
						if ($key == $property->architechture->home_size) {
						    ?> selected="selected" <?php
					}
				    }
					    ?> value="{{$key}}">{{$homeSize}}</option>
                                        @endforeach
                                    </select>
                                    @if(count($errors->get('plotsize')) > 0)
                                    <span class="text text-danger">{{implode('<br>', $errors->get('plotsize'))}}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <!--------------------------------->
                        <div class="">
                            <div class="formField form-group col-lg-12 col-md-12">
                                <label for="description">Describe your home <span style="color: Red;"> * </span>  </label>
                                <textarea rows="4" type="text" class="form-control text-height" id="description" required="true" data-rule-required="true" data-msg-required="Please enter description" name="description" aria-required="true">{{ $property->architechture->describe_your_home ??'' }}</textarea>
                                @if(count($errors->get('description')) > 0)
                                <span class="text text-danger">{{implode('<br>', $errors->get('description'))}}</span>
                                @endif
                            </div>
                        </div>

                        <!--------------------------------->

                        <div class="">
                            <div class="col-md-4 col-lg-4 col-sm-12 col-xs-12">
                                <div class="formField form-group">
                                    <label for="builtyear">Year Built <span style="color: Red;"> * </span>  </label>
                                    <input type="number" value="{{ $property->architechture->year_built ??'' }}"  class="form-control" id="builtyear" required="true" data-rule-required="true" data-rule-number="true" data-rule-maxlength="4" data-rule-minlength="4" data-msg-required="Please enter built year" data-msg-number="Please enter appropriate year" data-msg-maxlength="Not enter more than 4 digit" data-msg-minlength="Year required 4 digit." value="" name="builtyear" aria-required="true">
                                    @if(count($errors->get('builtyear')) > 0)
                                    <span class="text text-danger">{{implode('<br>', $errors->get('builtyear'))}}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-4 col-lg-4 col-sm-12 col-xs-12">
                                <div class="formField form-group">
                                    <label for="updatedyear">Year Updated (If Any) :  </label>
                                    <input type="number" value="{{ $property->architechture->year_updated ??'' }}" class="form-control" id="updatedyear" data-rule-number="true" data-rule-maxlength="4" data-rule-minlength="4" data-msg-number="Please enter appropriate year" data-msg-maxlength="Not enter more than 4 digit" data-msg-minlength="Year required 4 digit." value="" name="updatedyear">
                                </div>
                            </div>
                            <div class="col-md-4 col-lg-4 col-sm-12 col-xs-12">
                                <div class="formField form-group">
                                    <label for="lotsizeacre">Lot Size (Acres) :  <span style="color: Red;"> * </span>  </label>
                                    <input type="number" value="{{$property->architechture->plot_size??""}}" class="form-control" id="lotsizeacre" data-rule-number="true" name="lotsizeacre" required="true">
                                </div>
                            </div>
                            <div class="col-md-12 clear-both">
                                <div class="row">
                            <div class="col-md-4 col-lg-4 col-sm-12 col-xs-12">
                                <div class="formField form-group">
                                    <label for="hoadues">HOA dues/mo ($) :  </label>
                                    <input type="number" value="{{ $property->architechture->HOA_dues ??'' }}"  class="form-control" id="hoadues" data-rule-number="true" data-msg-number="Please enter appropriate price." value="" name="hoadues">
                                </div>
                            </div>
                                </div>
                            </div>
                                </div>
                            </div>
                        </div>
                        <!--------------------------------->

                        <!-- additional information -->
                        <div class="">
                            <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                                <h4 class="heading">Additional Information</h4>
                                <div class="form-group rent-radio">
                                    <h4>Basement</h4>
                                    @foreach(config('constant.basement') as $key=>$base)
                                    <input type="radio" <?php
					   if (isset($property)) {

					       if ($key == $property->architechture->basement) {
						   ?> checked="checked" <?php
					       }
					   } else {
					       if ($key == 4) {
						   ?> checked="checked" <?php
				       }
				   }
					   ?> value="{{$base}}" id="basement-{{$base}}" name="basement">
                                    <label for="basement-{{$base}}">{{$base}}</label>
                                    @endforeach
                                </div>
                            </div>

                            @if($AdditionalInformation)
                            @foreach($AdditionalInformation as $information)

                            @if($information->name != 'Basement' && $information->name != 'Lease Terms Available')

                            <div><h4 style="padding-left: 15px;">{{ $information->name }}</h4></div>
                            @foreach($information->children as $key=>$cat)
                            <div class="col-md-3 col-lg-3 col-sm-6 col-xs-6">
                                <div class="">
                                    <div class="checkbox">
                                        <input class="styled-checkbox" <?php
					       if (isset($property)) {
						   foreach ($property->additional_information as $savedInterest) {
						       if ($savedInterest->name == $cat->name && $savedInterest->parent_name == $information->name) {
							   ?> checked="checked" <?php
						       }
						   }
					       }
					       ?>  id="styled-{{ $information->name }}-{{$cat->name}}{{$key+1}}" type="checkbox" name="additional_information[]" value="{{ $cat->id }}">
                                        <label for="styled-{{ $information->name }}-{{$cat->name}}{{$key+1}}">
                                            {{ $cat->name }}
                                        </label>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            @endif
                            @endforeach
                            @endif
                        </div>
                        <!--------------------------------->
                        <div class="col-lg-12">
                            <div class="formField form-group">
                                <h4>Total rooms (Kitchen, Bathrooms, Living Areas, and Bedrooms)?</h4>
                                <input type="number" value="{{ $property->architechture->total_rooms ??'' }}"  name="total_rooms" id="total_rooms" class="form-control" maxlength="3">
                                @if(count($errors->get('total_rooms')) > 0)
                                <span class="text text-danger">{{implode('<br>', $errors->get('total_rooms'))}}</span>
                                @endif
                            </div>
                        </div>
                        <!--------------------------------->
                        <div class="">
                            <div class="col-lg-12">
                                <div class="formField form-group">
                                    <h4>Number of Stories (Basement, 1st Floor, 2nd Floor, 3rd Floor, etc.)?</h4>
                                    <input type="number" id="text-form-input" value="{{ $property->architechture->stories ??'' }}" name="no_of_stories" class="form-control" maxlength="3">
                                </div>
                            </div>
                        </div>
                        <!--------------------------------->
                        <div class="">
                            <div class="col-lg-12">
                                <div class="formField form-group">
                                    <h4>Capacity of Garage (Enter number of cars it can accommodate)?</h4>
                                    <input type="number" id="capacity_of_garage" value="{{ $property->architechture->garage_capacity ??'' }}" name="capacity_of_garage" maxlength="2" class="form-control" >
                                </div>
                            </div>
                        </div>
                        <!--------------------------------->
                        <div class="">
                            <div class="col-lg-12">
                                <div class="formField form-group">
                                    <h4>Additional Features : </h4>
                                    <textarea id="inputEmail3" name="additional_features" class="form-control text-height" type="text" rows="4">{{ $property->architechture->additional_features ??'' }}</textarea>
                                </div>

                            </div>
                        </div>
                        <!--------------------------------->
                        <div class="">
                            <div class="col-lg-12">
                                <div class="select formField form-group">
                                    <h4>School District </h4>
                                    <select class="select form-control" name="school_district" id="school_district">
                                        <option value="">Select School District</option>
                                    </select>

                                    @if(count($errors->get('school_district')) > 0)
                                    <span class="text text-danger">{{implode('<br>', $errors->get('school_district'))}}</span>
                                    @endif
                                </div>

                            </div>
                            <div class="col-lg-12">
                                <div class="select formField form-group">
                                    <h4>School </h4>
                                    <div class="multiselect">
                                        <div class="selectBox">
                                            <select class="form-control text-height" name="school[]" multiple="multiple" data-district_id="{{-- (isset($property->architechture->school_id) && $property->architechture->school_id) ? explode(',',$property->architechture->school_id) : '' --}}"  id="school-select" style="padding:8px">
                                                <option value="">Select School</option>
                                            </select>

                                            <div class="overSelect"></div>
                                            @if(count($errors->get('school[]')) > 0)
                                            <span class="text text-danger">{{implode('<br>', $errors->get('school[]'))}}</span>
                                            @endif
                                        </div>
                                        <!--<div id="checkboxes" style="padding: 8px; display: block;">
                                            <label for="one"><input type="checkbox" id="one" name="service"/> First checkbox</label>
                                            <label for="two"><input type="checkbox" id="two" name="service"/> Second checkbox </label>
                                            <label for="three"><input type="checkbox" id="three" name="service"/> Third checkbox</label>
                                        </div>-->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--------------------------------->
                        <div  class="col-lg-12 info-box-rent form-group">
                            <label><b>Contact Information</b> Potential Buyers/Lessees will contact you via the "My Messages" portal in your "My Account". However, you may also provide your phone number for potential buyers/lessees as well. By checking the below box, we will display the number you provided in your account on the listing.</label>

                            <div class="checkbox">
                                <input class="styled-checkbox for_phone" name="display_phone" id="display_phone" type="checkbox"
				<?php
				if (isset($property)) {
				    if ($property->display_phone == 1) {
					?>
					       checked="checked" <?php
				   }
			       }
				?> value="Yes">
                                <label for="display_phone" id="phone_label">Please display the phone number in <span class="blue-text">My Account"</span> on my listing. </label></label>
                                <input class="styled-checkbox for_agree" id="agree" type="checkbox" <?php if (isset($property)) { ?>  checked="checked" <?php } ?> value="Yes" name="agree">
                                <label for="agree" id="agree_label">I agree to the following: (i) <span class="blue-text">I am (or I have authority to act on behalf of) the owner of this home;</span>
                                    (ii)<span class="blue-text"> I will provide correct information, to the best of my knowledge; </span>
                                    (iii)<span class="blue-text"> I will not post illegal discriminatory preferences on my listing; and </span>
                                    (iv) <span class="blue-text">I will comply with the FreezylistTerms of Use. </span>
                                </label>
                                <span class="error" id="agree-error">Please check this to proceed</span>
                            </div>
                            <div>
                                <div class="submit-listing form-group text-center">
                                    <div class="btns-green-blue">
                                        <input class="btn button btn-blue" type="submit" value="Submit Listing" id="inputbutton" name="submit" class="btn btn-default">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--------------------------------->
                        {{ html()->form()->close() }}
                    </div><!-- panel body -->
                </div><!-- panel -->
            </div><!-- col-md-12 -->
        </div><!-- row -->
    </div><!-- container-->
</div><!-- register-page-->
@endsection
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
<script type="javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
@section('after-scripts')
<script src="https://maps.googleapis.com/maps/api/js?key=<?= config('settings.google_map_api_key') ?>&libraries=places" type="text/javascript"></script>
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
    $(document).ready(function () {
        $("#total_rooms").keypress(function (e) {
            //if the letter is not digit then display error and don't type anything
            if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                $(this).val($(this).val().replace(/[^\d].+/, ""));
                $('.total_message').remove();
                return false;
            }

        });
        $('form').validate({
            rules: {

            },
            messages: {
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

        // validate image size on form submit
        $("form").submit(function (e) {
            var total_rooms = $("#total_rooms").val();
            var editImgError = $("#stored-photos img").length;
            var length = $('.tmpImage').length;
            if (!$.isNumeric(total_rooms) && total_rooms != '') {
                $('.total_message').remove();
                $("#total_rooms").after('<span class="text text-danger total_message">The total rooms must be a number.</span>');
                return false;
            }
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
//                var tmpImg = $('#upload_photo' + j).siblings(".testtmp");
//                if (tmpImg.height() > 1024 || tmpImg.width() > 1024 || tmpImg.height() < 315 || tmpImg.width() < 600) {
//                    $('#upload_photo' + j).siblings(".dimension_error").show();
//                    imageErrors++;
//                } else {
//                    $('#upload_photo' + j).siblings(".dimension_error").hide();
//                }
//            }
            if (imageErrors > 0)
                return false;
            else
                return true;
        });

        // validate image size on change
        var _URL = window.URL || window.webkitURL;
        $(document).on('change', '.files', function () {
            var changeSelector = $(this);
            var checkSize = $(this)[0].files[0].size;
            if (checkSize < 2000000) {
                changeSelector.siblings(".file_error").hide();
            } else if (checkSize > 2000000) {
                setTimeout(function () {
                    changeSelector.siblings('.file_error').show();
                }, 1000);
            }

            var file, img;
//            if (file = this.files[0]) {
//                img = new Image();
//                img.onload = function () {
//                    if(this.width < 1024 && this.height < 1024 && this.width > 600 && this.height > 315) {
//                        changeSelector.siblings('.dimension_error').hide();
//                    } else if(this.width > 1024 || this.height > 1024 || this.width < 600 || this.height < 315) {
//                        setTimeout(function(){
//                            changeSelector.siblings('.dimension_error').show();
//                        }, 1000);
//                    }
//                };
//                img.src = _URL.createObjectURL(file);
//            }
        });

        //find and get stored districts.
        var districtId = "{{isset($property)?$property->architechture->school_district_id:''}}";
        $.ajax({
            type: "get",
            url: "{{ route('frontend.schoolDistrict') }}",
            data: {
                state: $('#state').val(),
                districtId: districtId,
            },
            success: function (response) {
                $('#school_district').children('option').remove();
                $('#school_district').append(response.schoolDistrict);
//                $('#school-select').children('option').remove();
            }
        });
        var schools = "{{isset($property)?$property->architechture->school_id:''}}";
        var schoolsIds = schools.split(',');

//        var isSelected = $('#school_district option').filter(':selected').val();
        $.ajax({
            type: "get",
            url: "{{ route('frontend.schoolSearch') }}",
            data: {
                district_id: districtId,
                school_id: schoolsIds,
            },
            success: function (response) {
                console.log(response);
                $('#school-select').children('option').remove();
                $('#school-select').append(response.schools);
            },
            error: function (error) {
            }
        });
        $("#school_district").change(function (e) {
            e.preventDefault();

            var $this = $(this);
            $.ajax({
                type: "get",
                url: "{{ route('frontend.schoolSearch') }}",
                data: {
                    district_id: parseInt($this.val()),
                },
                success: function (response) {
                    $('#school-select').prop("disabled", false);
                    $('#school-select').children('option').remove();
                    $('#school-select').append(response.schools);
                },
                error: function (error) {
                }
            });
        });
    });


</script>
@endsection
