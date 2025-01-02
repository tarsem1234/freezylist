@extends ('frontend.layouts.app')
@section ('title', ('Disclosure By Seller Update'))
@section('after-styles')
<link type="text/css" rel="stylesheet" href="{{ asset(mix('css/contract_tools.css')) }}" media="all">
@endsection
@section('content')
<div class="container purchase-sale-agreement-review contract-tools-seller-common dis-que">
    <div class="row">
        <div class="">
            <div class="sidebar">
                @include('frontend.includes.sidebar')
            </div>
            <div class="col-md-9 col-sm-8">
                <div class="nested-div">
                    <div class="heading-text">
                        <h2>{{!empty($page) && $page=="sale_list"?' Property Condition Disclosure':'Step 5 of 6: Property Condition Disclosure'}}</h2>
                    </div>
                    <div class="para-text row mar-top">
                        <?php if (isset($property)) { ?>
                            {{ html()->form('POST', route('frontend.saveSellerPropertyConditionDisclosure', [$property->id]))->attribute('role', 'form')->open() }}
                            <input type="hidden" name="property_id" value="{{$property->id}}">
                        <?php } else { ?>
                            {{ html()->form('POST', route('frontend.saveSellerPropertyConditionDisclosure'))->attribute('role', 'form')->open() }}
                        <?php } ?>
                            <input type="hidden" name="previous_url" value="{{ url()->previous()}}">
                        <div class="col-sm-12">
                            <h4 class="first-child">INSTRUCTIONS TO THE SELLER</h4>
                            <p class="offer-text">Complete this form yourself and answer each question to the best of your knowledge. If an answer is an estimate, clearly label it as such. Explain any YES answers and describe the  AWARE ture and extent of any defects or repairs. If more space is needed, attach additional sheets. You may also attach any documents pertaining to repairs or corrections. The Seller hereby authorizes any real estate licensee involved in this transaction to provide a copy of this statement to any person or entity in connection with any actual or anticipated sale of the subject property.</p>
                        </div>
                        <div class="lowercase">
                            <h5 for="" class="col-sm-12 control-label"> 1. Property age <span>(In Years):</span></h5>
                            <div class="col-sm-12">
                                <input type="number" class="form-control" min="0" name="propertyage" required="true" data-msg-required="Please enter the age of property" value="{{(isset($diffInYears) && $diffInYears >=1) ? $diffInYears : ''}}">
                                @if(count($errors->get('propertyage')) > 0)
                                <span class="text text-danger">{{implode('<br>', $errors->get('propertyage'))}}</span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <h5>2. Date seller acquired the property: </h5>
                                <input type="text" id="datetimepicker" class="form-control" maxlength="16" required="true" placeholder="" name="date_of_occupancy" data-msg-required="Please enter the date" value="{{$property->disclosure->date_added??""}}">
                                @if(count($errors->get('date_of_occupancy')) > 0)
                                <span class="text text-danger">{{implode('<br>', $errors->get('date_of_occupancy'))}}</span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group btn-radio">
                            <div class="col-md-12">
                                <h5>3. Does seller currently occupy the property?Any Contingencies?</h5>
                                <input type="radio" name="occupy" id="occupies" <?php
                                if (isset($property->disclosure->occupy)) {
                                    if ($property->disclosure->occupy == config('constant.inverse_property_disclaimer_occupy.Seller occupies property')) {
                                        ?>
                                               checked="checked"
                                               <?php
                                           }
                                       }
                                       ?> value="{{config('constant.inverse_property_disclaimer_occupy.Seller occupies property')}}" required="true" >
                                <label for="occupies">Seller occupies property</label>
                                <input type="radio" name="occupy" <?php
                                if (isset($property->disclosure->occupy)) {
                                    if ($property->disclosure->occupy == config('constant.inverse_property_disclaimer_occupy.Seller does not occupy property')) {
                                        ?>
                                               checked="checked"
                                               <?php
                                           }
                                       }
                                       ?> id="notoccupies" value="{{config('constant.inverse_property_disclaimer_occupy.Seller does not occupy property')}}" required="true" >
                                <label for="notoccupies">Seller does not occupy property</label>
                                @if(count($errors->get('occupy')) > 0)
                                <span class="text text-danger">{{implode('<br>', $errors->get('occupy'))}}</span>
                                @endif
                            </div><!--col-md-12-->
                        </div>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <h5>4. If not currently seller-occupied, how long has it been since the seller did occupy the property, if ever?</h5>
                                <input type="text" class="form-control" name="howlong" value="{{$property->disclosure->how_long??""}}" placeholder="eg: 10 months or 2 years etc.">
                                @if(count($errors->get('howlong')) > 0)
                                <span class="text text-danger">{{implode('<br>', $errors->get('howlong'))}}</span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group btn-radio">
                            <div class="col-md-12">
                                <h5>5. The property is a</h5>
                                <input type="radio" name="propertyis" <?php
                                if (isset($property->disclosure)) {
                                    if ($property->disclosure->property_is == config('constant.inverse_property_disclaimer_propertyis.Site-built Home')) {
                                        ?>
                                               checked="checked"
                                               <?php
                                           }
                                       }
                                       ?> id="site-built" value="{{config('constant.inverse_property_disclaimer_propertyis.Site-built Home')}}" required="true" >
                                <label for="site-built">site-built home</label>
                                <input type="radio" name="propertyis" <?php
                                if (isset($property->disclosure->property_is)) {
                                    if ($property->disclosure->property_is == config('constant.inverse_property_disclaimer_propertyis.Non-site-built Home')) {
                                        ?>
                                               checked="checked"
                                               <?php
                                           }
                                       }
                                       ?>  id="non-site-built" value="{{config('constant.inverse_property_disclaimer_propertyis.Non-site-built Home')}}" required="true" >
                                <label for="non-site-built">non-site-built home<span class="offer-text">(e.g. - modular, manufactured, mobile) </span></label>
                                @if(count($errors->get('propertyis')) > 0)
                                <span class="text text-danger">{{implode('<br>', $errors->get('propertyis'))}}</span>
                                @endif
                            </div><!--col-md-12-->
                        </div>
                        <div class="form-group">
                            <div class="col-md-12">
                                <h5>6. Roof type</h5>
                                <input type="text" class="form-control" required="true" data-msg-required="Please enter the type of roof" name="rooftype" placeholder="composition asphalt shingle, wood, metal, tile" value="{{$property->disclosure->roof_type??""}}">
                                @if(count($errors->get('rooftype')) > 0)
                                <span class="text text-danger">{{implode('<br>', $errors->get('rooftype'))}}</span>
                                @endif
                                <input type="number" class="form-control" required="true" data-msg-required="Please enter the approx age of roof" min="0" name="roofage" placeholder="Approx. age of roof" value="{{$property->disclosure->roof_age??""}}">
                                @if(count($errors->get('roofage')) > 0)
                                <span class="text text-danger">{{implode('<br>', $errors->get('roofage'))}}</span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group btn-radio">
                            <div class="col-md-12">
                                <h5>7. Is there a Homeowners Association (HOA) which has any authority over the subject property?</h5>

                                <input type="radio" id="chkYes" <?php
                                if (isset($property->disclosure)) {
                                    if ($property->disclosure->house_owners_associations == config('constant.inverse_common_yes_no.Yes')) {
                                        ?>
                                               checked="checked"
                                               <?php
                                           }
                                       }
                                       ?>  name="houseowners_associations" value="{{config('constant.inverse_common_yes_no.Yes')}}" required="true" >
                                <label for="chkYes">Yes</label>

                                <input type="radio" id="chkNo" <?php
                                       if (isset($property->disclosure)) {
                                           if ($property->disclosure->house_owners_associations == config('constant.inverse_common_yes_no.No')) {
                                               ?>
                                               checked="checked"
                                        <?php
                                    }
                                }
                                ?>  name="houseowners_associations" value="{{config('constant.inverse_common_yes_no.No')}}" required="true" >
                                <label for="chkNo">No</label>
                                @if(count($errors->get('houseowners_associations')) > 0)
                                <span class="text text-danger">{{implode('<br>', $errors->get('houseowners_associations'))}}</span>
                                @endif
                            </div><!--col-md-12-->
                        </div>
                        <div id="house" style="display: none">
                            <div class="form-group">
                                <div class="col-md-12">
                                    <p>Name &amp; address of HOA:</p>
                                    <input type="text" class="form-control" id="" required="true" name="name_address" value="{{$property->disclosure->name_address??""}}">
                                    @if(count($errors->get('name_address')) > 0)
                                    <span class="text text-danger">{{implode('<br>', $errors->get('name_address'))}}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-6">
                                    <p>Monthly Dues:</p>
                                    <input type="number" class="form-control" min="0" required="true" name="monthly_dues" value="{{$property->disclosure->monthly_dues??""}}">
                                    @if(count($errors->get('monthly_dues')) > 0)
                                    <span class="text text-danger">{{implode('<br>', $errors->get('monthly_dues'))}}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-md-6">
                                    <p>Transfer Fees:</p>
                                    <input type="number" class="form-control" min="0" required="true" name="transfer_fees" value="{{$property->disclosure->transfer_fees??""}}">
                                    @if(count($errors->get('transfer_fees')) > 0)
                                    <span class="text text-danger">{{implode('<br>', $errors->get('transfer_fees'))}}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-12">
                                    <p>Special Assessments:</p>
                                    <input type="text" class="form-control" id="" required="true" name="special_assessments" value="{{$property->disclosure->special_assessments??""}}">
                                    @if(count($errors->get('special_assessments')) > 0)
                                    <span class="text text-danger">{{implode('<br>', $errors->get('special_assessments'))}}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
<?php
if (isset($property->disclosure)) {
    $propertyIncludes = explode(',', $property->disclosure->property_includes);
}
?>
                        <div class="property-checkbox">
                            <div class="form-group">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <h5>A. The property includes the items checked below: </h5>
                                </div><!--col-md-12-->
                            </div>
                            <div class="form-group">
                                <div class="col-md-6 col-sm-12 col-xs-12">
                                    <div class="checkbox">
                                        <input type="checkbox" class="styled-checkbox prop_inc_check" <?php
                        if (isset($property->disclosure)) {
                            foreach ($propertyIncludes as $propertyInclude) {
                                if ($propertyInclude == "Range") {
            ?>
                                                           checked="checked"
                                                    <?php
                                                }
                                            }
                                        }
                                        ?> name="property_includes[]" id="Range" value="Range">
                                        <label for="Range">Range </label>

                                    </div>
                                </div><!--col-md-12-->
                            </div>
                            <div class="form-group">
                                <div class="col-md-6 col-sm-12 col-xs-12">
                                    <div class="checkbox">
                                        <input type="checkbox" class="styled-checkbox prop_inc_check" <?php
                                               if (isset($property->disclosure)) {
                                                   foreach ($propertyIncludes as $propertyInclude) {
                                                       if ($propertyInclude == "Spa/Whirlpool Tub") {
                                                    ?>
                                                           checked="checked"
                                                    <?php
                                                }
                                            }
                                        }
                                        ?> name="property_includes[]" id="Spa" value="Spa/Whirlpool Tub">
                                        <label for="Spa">Spa/Whirlpool Tub  </label>
                                    </div>
                                </div><!--col-md-12-->
                            </div>
                            <div class="form-group">
                                <div class="col-md-6 col-sm-12 col-xs-12">
                                    <div class="checkbox">
                                        <input type="checkbox" class="styled-checkbox prop_inc_check" <?php
                                               if (isset($property->disclosure)) {
                                                   foreach ($propertyIncludes as $propertyInclude) {
                                                       if ($propertyInclude == "Access to Public Streets") {
                                                    ?>
                                                           checked="checked"
                                                    <?php
                                                }
                                            }
                                        }
                                        ?>  name="property_includes[]" id="Streets" value="Access to Public Streets">
                                        <label for="Streets">Access to Public Streets </label>
                                    </div>
                                </div><!--col-md-12-->
                            </div>
                            <div class="form-group">
                                <div class="col-md-6 col-sm-12 col-xs-12">
                                    <div class="checkbox">
                                        <input type="checkbox" class="styled-checkbox prop_inc_check" <?php
                                               if (isset($property->disclosure)) {
                                                   foreach ($propertyIncludes as $propertyInclude) {
                                                       if ($propertyInclude == "Microwave") {
                                                    ?>
                                                           checked="checked"
                                                    <?php
                                                }
                                            }
                                        }
                                        ?>  name="property_includes[]" id="Microwave" value="Microwave">
                                        <label for="Microwave">Microwave</label>
                                    </div>
                                </div><!--col-md-12-->
                            </div>
                            <div class="form-group">
                                <div class="col-md-6 col-sm-12 col-xs-12">
                                    <div class="checkbox">
                                        <input type="checkbox" class="styled-checkbox prop_inc_check" <?php
                                               if (isset($property->disclosure)) {
                                                   foreach ($propertyIncludes as $propertyInclude) {
                                                       if ($propertyInclude == "Hot Tub") {
                                                    ?>
                                                           checked="checked"
                                                    <?php
                                                }
                                            }
                                        }
                                        ?>  name="property_includes[]" id="Tub" value="Hot Tub">
                                        <label for="Tub"> Hot Tub </label>
                                    </div>
                                </div><!--col-md-12-->
                            </div>
                            <div class="form-group">
                                <div class="col-md-6 col-sm-12 col-xs-12">
                                    <div class="checkbox">
                                        <input type="checkbox" class="styled-checkbox prop_inc_check" <?php
                                               if (isset($property->disclosure)) {
                                                   foreach ($propertyIncludes as $propertyInclude) {
                                                       if ($propertyInclude == "Current Termite Contract") {
                                                    ?>
                                                           checked="checked"
                                                    <?php
                                                }
                                            }
                                        }
                                        ?>  name="property_includes[]" id="Termite" value="Current Termite Contract">
                                        <label for="Termite"> Current Termite Contract </label>
                                    </div>
                                </div><!--col-md-12-->
                            </div>
                            <div class="form-group">
                                <div class="col-md-6 col-sm-12 col-xs-12">
                                    <div class="checkbox">
                                        <input type="checkbox" class="styled-checkbox prop_inc_check" <?php
                                               if (isset($property->disclosure)) {
                                                   foreach ($propertyIncludes as $propertyInclude) {
                                                       if ($propertyInclude == "Garbage Disposal") {
                                                    ?>
                                                           checked="checked"
                                                    <?php
                                                }
                                            }
                                        }
                                        ?>  name="property_includes[]" id="Disposal" value="Garbage Disposal">
                                        <label for="Disposal"> Garbage Disposal  </label>
                                    </div>
                                </div><!--col-md-12-->
                            </div>
                            <div class="form-group">
                                <div class="col-md-6 col-sm-12 col-xs-12">
                                    <div class="checkbox">
                                        <input type="checkbox" class="styled-checkbox prop_inc_check" id="Sauna" <?php
                                               if (isset($property->disclosure)) {
                                                   foreach ($propertyIncludes as $propertyInclude) {
                                                       if ($propertyInclude == "Sauna") {
                                                    ?>
                                                           checked="checked"
                                                    <?php
                                                }
                                            }
                                        }
                                        ?>  name="property_includes[]" value="Sauna">
                                        <label for="Sauna"> Sauna </label>
                                    </div>
                                </div><!--col-md-12-->
                            </div>
                            <div class="form-group">
                                <div class="col-md-6 col-sm-12 col-xs-12">
                                    <div class="checkbox">
                                        <input type="checkbox" class="styled-checkbox prop_inc_check" <?php
                                               if (isset($property->disclosure)) {
                                                   foreach ($propertyIncludes as $propertyInclude) {
                                                       if ($propertyInclude == "Trash Compactor") {
                                                    ?>
                                                           checked="checked"
                                                    <?php
                                                }
                                            }
                                        }
                                        ?>  name="property_includes[]" id="Compactor" value="Trash Compactor">
                                        <label for="Compactor"> Trash Compactor</label>
                                    </div>
                                </div><!--col-md-12-->
                            </div>
                            <div class="form-group">
                                <div class="col-md-6 col-sm-12 col-xs-12">
                                    <div class="checkbox">
                                        <input type="checkbox" class="styled-checkbox prop_inc_check" <?php
                                               if (isset($property->disclosure)) {
                                                   foreach ($propertyIncludes as $propertyInclude) {
                                                       if ($propertyInclude == "Water Softener") {
                                                    ?>
                                                           checked="checked"
                                                    <?php
                                                }
                                            }
                                        }
                                        ?>  name="property_includes[]" id="Water" value="Water Softener">
                                        <label for="Water"> Water Softener</label>
                                    </div>
                                </div><!--col-md-12-->
                            </div>
                            <div class="form-group">
                                <div class="col-md-6 col-sm-12 col-xs-12">
                                    <div class="checkbox">
                                        <input type="checkbox" class="styled-checkbox prop_inc_check" <?php
                                               if (isset($property->disclosure)) {
                                                   foreach ($propertyIncludes as $propertyInclude) {
                                                       if ($propertyInclude == "220 Volt Wiring") {
                                                    ?>
                                                           checked="checked"
                                                    <?php
                                                }
                                            }
                                        }
                                        ?>  name="property_includes[]" id="Wiring" value="220 Volt Wiring">
                                        <label for="Wiring"> 220 Volt Wiring </label>
                                    </div>
                                </div><!--col-md-12-->
                            </div>
                            <div class="form-group">
                                <div class="col-md-6 col-sm-12 col-xs-12">
                                    <div class="checkbox">
                                        <input type="checkbox" class="styled-checkbox prop_inc_check" <?php
                                               if (isset($property->disclosure)) {
                                                   foreach ($propertyIncludes as $propertyInclude) {
                                                       if ($propertyInclude == "Washer/Dryer Hookups") {
                                                    ?>
                                                           checked="checked"
                                                    <?php
                                                }
                                            }
                                        }
                                        ?>  name="property_includes[]" id="Hookups" value="Washer/Dryer Hookups">
                                        <label for="Hookups"> Washer/Dryer Hookups</label>
                                    </div>
                                </div><!--col-md-12-->
                            </div>
                            <div class="form-group">
                                <div class="col-md-6 col-sm-12 col-xs-12">
                                    <div class="checkbox">
                                        <input type="checkbox" class="styled-checkbox prop_inc_check" <?php
                                               if (isset($property->disclosure)) {
                                                   foreach ($propertyIncludes as $propertyInclude) {
                                                       if ($propertyInclude == "Window Screens") {
                                                    ?>
                                                           checked="checked"
                                                    <?php
                                                }
                                            }
                                        }
                                        ?> name="property_includes[]" id="Window" value="Window Screens">
                                        <label for="Window"> Window Screens</label>
                                    </div>
                                </div><!--col-md-12-->
                            </div>
                            <div class="form-group">
                                <div class="col-md-6 col-sm-12 col-xs-12">
                                    <div class="checkbox">
                                        <input type="checkbox" class="styled-checkbox prop_inc_check" <?php
                                               if (isset($property->disclosure)) {
                                                   foreach ($propertyIncludes as $propertyInclude) {
                                                       if ($propertyInclude == "Fireplace") {
                                                    ?>
                                                           checked="checked"
                                                    <?php
                                                }
                                            }
                                        }
                                        ?>   name="property_includes[]" id="Fireplace" value="Fireplace">
                                        <label for="Fireplace"> Fireplace  <span id='main-fireplace' style="display: none">
                                                (How many? <input type="number" min="0" class="readonly" id="text-form-input" name="howmany" value="{{$property->disclosure->how_many??""}}">
                                                )</span>
                                        </label>
                                    </div>
                                </div><!--col-md-12-->
                            </div>
                            <div class="form-group">
                                <div class="col-md-6 col-sm-12 col-xs-12">
                                    <div class="checkbox">
                                        <input type="checkbox" class="styled-checkbox prop_inc_check" <?php
                                               if (isset($property->disclosure)) {
                                                   foreach ($propertyIncludes as $propertyInclude) {
                                                       if ($propertyInclude == "Gas Starter for Fireplace") {
                                                    ?>
                                                           checked="checked"
                                                    <?php
                                                }
                                            }
                                        }
                                        ?>   name="property_includes[]" id="Starter-Fireplace" value="Gas Starter for Fireplace">
                                        <label for="Starter-Fireplace"> Gas Starter for Fireplace</label>
                                    </div>
                                </div><!--col-md-12-->
                            </div>
                            <div class="form-group">
                                <div class="col-md-6 col-sm-12 col-xs-12">
                                    <div class="checkbox">
                                        <input type="checkbox" class="styled-checkbox prop_inc_check" <?php
                                               if (isset($property->disclosure)) {
                                                   foreach ($propertyIncludes as $propertyInclude) {
                                                       if ($propertyInclude == "Gas Fireplace Logs") {
                                                    ?>
                                                           checked="checked"
                                                    <?php
                                                }
                                            }
                                        }
                                        ?>  name="property_includes[]" id="Logs" value="Gas Fireplace Logs">
                                        <label for="Logs"> Gas Fireplace Logs</label>
                                    </div>
                                </div><!--col-md-12-->
                            </div>
                            <div class="form-group">
                                <div class="col-md-6 col-sm-12 col-xs-12">
                                    <div class="checkbox">
                                        <input type="checkbox" class="styled-checkbox prop_inc_check" <?php
                                               if (isset($property->disclosure)) {
                                                   foreach ($propertyIncludes as $propertyInclude) {
                                                       if ($propertyInclude == "Patio/Decking/Gazebo") {
                                                    ?>
                                                           checked="checked"
                                                    <?php
                                                }
                                            }
                                        }
                                        ?>  name="property_includes[]" id="Decking" value="Patio/Decking/Gazebo">
                                        <label for="Decking"> Patio/Decking/Gazebo </label>
                                    </div>
                                </div><!--col-md-12-->
                            </div>
                            <div class="form-group">
                                <div class="col-md-6 col-sm-12 col-xs-12">
                                    <div class="checkbox">
                                        <input type="checkbox" class="styled-checkbox prop_inc_check" <?php
                                               if (isset($property->disclosure)) {
                                                   foreach ($propertyIncludes as $propertyInclude) {
                                                       if ($propertyInclude == "Irrigation System") {
                                                    ?>
                                                           checked="checked"
                                                    <?php
                                                }
                                            }
                                        }
                                        ?>  name="property_includes[]" id="Irrigation" value="Irrigation System">
                                        <label for="Irrigation"> Irrigation System </label>
                                    </div>
                                </div><!--col-md-12-->
                            </div>
                            <div class="form-group">
                                <div class="col-md-6 col-sm-12 col-xs-12">
                                    <div class="checkbox">
                                        <input type="checkbox" class="styled-checkbox prop_inc_check" <?php
                                               if (isset($property->disclosure)) {
                                                   foreach ($propertyIncludes as $propertyInclude) {
                                                       if ($propertyInclude == "Installed Outdoor Cooking Grill") {
                                                    ?>
                                                           checked="checked"
                                                    <?php
                                                }
                                            }
                                        }
                                        ?>  name="property_includes[]" id="Cooking" value="Installed Outdoor Cooking Grill">
                                        <label for="Cooking"> Installed Outdoor Cooking Grill  </label>
                                    </div>
                                </div><!--col-md-12-->
                            </div>
                            <div class="form-group">
                                <div class="col-md-6 col-sm-12 col-xs-12">
                                    <div class="checkbox">
                                        <input type="checkbox" class="styled-checkbox prop_inc_check" <?php
                                               if (isset($property->disclosure)) {
                                                   foreach ($propertyIncludes as $propertyInclude) {
                                                       if ($propertyInclude == "Intercom") {
                                                    ?>
                                                           checked="checked"
                                                    <?php
                                                }
                                            }
                                        }
                                        ?>  name="property_includes[]" id="Intercom" value="Intercom">
                                        <label for="Intercom"> Intercom </label>
                                    </div>
                                </div><!--col-md-12-->
                            </div>
                            <div class="form-group">
                                <div class="col-md-6 col-sm-12 col-xs-12">
                                    <div class="checkbox">
                                        <input type="checkbox" class="styled-checkbox prop_inc_check" <?php
                                               if (isset($property->disclosure)) {
                                                   foreach ($propertyIncludes as $propertyInclude) {
                                                       if ($propertyInclude == "Rain Gutters") {
                                                    ?>
                                                           checked="checked"
                                                    <?php
                                                }
                                            }
                                        }
                                        ?>  name="property_includes[]" id="Rain" value="Rain Gutters">
                                        <label for="Rain">  Rain Gutters  </label>
                                    </div>
                                </div><!--col-md-12-->
                            </div>
                            <div class="form-group">
                                <div class="col-md-6 col-sm-12 col-xs-12">
                                    <div class="checkbox">
                                        <input type="checkbox" class="styled-checkbox prop_inc_check" <?php
                                               if (isset($property->disclosure)) {
                                                   foreach ($propertyIncludes as $propertyInclude) {
                                                       if ($propertyInclude == "Sump Pump") {
                                                    ?>
                                                           checked="checked"
                                                    <?php
                                                }
                                            }
                                        }
                                        ?> name="property_includes[]" id="Sump" value="Sump Pump">
                                        <label for="Sump"> Sump Pump </label>
                                    </div>
                                </div><!--col-md-12-->
                            </div>
                            <div class="form-group">
                                <div class="col-md-6 col-sm-12 col-xs-12">
                                    <div class="checkbox">
                                        <input type="checkbox" class="styled-checkbox prop_inc_check" <?php
                                               if (isset($property->disclosure)) {
                                                   foreach ($propertyIncludes as $propertyInclude) {
                                                       if ($propertyInclude == "A key to all exterior doors") {
                                                    ?>
                                                           checked="checked"
                                                    <?php
                                                }
                                            }
                                        }
                                        ?> name="property_includes[]" id="key" value="A key to all exterior doors">
                                        <label for="key">A key to all exterior doors  </label>
                                    </div>
                                </div><!--col-md-12-->
                            </div>
                            <div class="form-group">
                                <div class="col-md-6 col-sm-12 col-xs-12">
                                    <div class="checkbox">
                                        <input type="checkbox" class="styled-checkbox prop_inc_check" <?php
                                               if (isset($property->disclosure)) {
                                                   foreach ($propertyIncludes as $propertyInclude) {
                                                       if ($propertyInclude == "Carport") {
                                                    ?>
                                                           checked="checked"
                                                    <?php
                                                }
                                            }
                                        }
                                        ?>   name="property_includes[]" id="Carport" value="Carport">
                                        <label for="Carport">Carport </label>
                                    </div>
                                </div><!--col-md-12-->
                            </div>
                            <div class="form-group">
                                <div class="col-md-6 col-sm-12 col-xs-12">
                                    <div class="checkbox">
                                        <input type="checkbox" class="styled-checkbox prop_inc_check" <?php
                                               if (isset($property->disclosure)) {
                                                   foreach ($propertyIncludes as $propertyInclude) {
                                                       if ($propertyInclude == "Smoke Detector") {
                                                    ?>
                                                           checked="checked"
                                                    <?php
                                                }
                                            }
                                        }
                                        ?>  name="property_includes[]" id="Smoke" value="Smoke Detector">
                                        <label for="Smoke">Smoke Detector/Fire Alarm </label>
                                    </div>
                                </div><!--col-md-12-->
                            </div>
                            <div class="form-group">
                                <div class="col-md-6 col-sm-12 col-xs-12">
                                    <div class="checkbox">
                                        <input type="checkbox" class="styled-checkbox prop_inc_check" <?php
                                               if (isset($property->disclosure)) {
                                                   foreach ($propertyIncludes as $propertyInclude) {
                                                       if ($propertyInclude == "Wall/Window Air Conditioning") {
                                                    ?>
                                                           checked="checked"
                                                    <?php
                                                }
                                            }
                                        }
                                        ?>  name="property_includes[]" id="Wall/Window" value="Wall/Window Air Conditioning">
                                        <label for="Wall/Window">Wall/Window Air Conditioning</label>
                                    </div>
                                </div><!--col-md-12-->
                            </div>
                            <div class="form-group">
                                <div class="col-md-6 col-sm-12 col-xs-12">
                                    <div class="checkbox">
                                        <input type="checkbox" class="styled-checkbox prop_inc_check"  <?php
                                               if (isset($property->disclosure)) {
                                                   foreach ($propertyIncludes as $propertyInclude) {
                                                       if ($propertyInclude == "Central Heating") {
                                                    ?>
                                                           checked="checked"
                                                    <?php
                                                }
                                            }
                                        }
                                        ?> name="property_includes[]" id="Central-Heating" value="Central Heating">
                                        <label for="Central-Heating"> Central Heating</label>
                                    </div>
                                </div><!--col-md-12-->
                            </div>
                            <div class="form-group">
                                <div class="col-md-6 col-sm-12 col-xs-12">
                                    <div class="checkbox">
                                        <input type="checkbox" class="styled-checkbox prop_inc_check" <?php
                                               if (isset($property->disclosure)) {
                                                   foreach ($propertyIncludes as $propertyInclude) {
                                                       if ($propertyInclude == "All Landscaping and Outdoor Lighting") {
                                                    ?>
                                                           checked="checked"
                                                    <?php
                                                }
                                            }
                                        }
                                        ?>  name="property_includes[]" id="Landscaping" value="All Landscaping and Outdoor Lighting">
                                        <label for="Landscaping"> All Landscaping and Outdoor Lighting</label>
                                    </div>
                                </div><!--col-md-12-->
                            </div>
                            <div class="form-group">
                                <div class="col-md-6 col-sm-12 col-xs-12">
                                    <div class="checkbox">
                                        <input type="checkbox" class="styled-checkbox prop_inc_check" <?php
                                               if (isset($property->disclosure)) {
                                                   foreach ($propertyIncludes as $propertyInclude) {
                                                       if ($propertyInclude == "Pool") {
                                                    ?>
                                                           checked="checked"
                                                    <?php
                                                }
                                            }
                                        }
                                        ?>  name="property_includes[]" id="Pool" value="Pool">
                                        <label for="Pool">Pool </label>
                                    </div>
                                    <div id="Pool-option" style="display: none" class="col-md-12 col-sm-12 col-xs-12 btn-radio">
                                        <input type="radio" name="pool" id="In-ground" <?php
                                               if (isset($property->disclosure)) {
                                                   if ($property->disclosure->pool_type == config('constant.inverse_property_disclaimer_pool.In-ground')) {
                                                       ?>
                                                       checked="checked"
                                                <?php
                                            }
                                        }
                                        ?> value="{{config('constant.inverse_property_disclaimer_pool.In-ground')}}">
                                        <label for="In-ground">In-ground</label>
                                        <input type="radio" name="pool" id="Above-ground" <?php
                                               if (isset($property->disclosure)) {
                                                   if ($property->disclosure->pool_type == config('constant.inverse_property_disclaimer_pool.Above-ground')) {
                                                       ?>
                                                       checked="checked"
                                                <?php
                                            }
                                        }
                                        ?>  value="{{config('constant.inverse_property_disclaimer_pool.Above-ground')}}">
                                        <label for="Above-ground">Above-ground</label>
                                    </div>
                                </div><!--col-md-12-->
                            </div>
                            <div class="form-group">
                                <div class="col-md-6 col-sm-12 col-xs-12">
                                    <div class="checkbox">
                                        <input type="checkbox" class="styled-checkbox prop_inc_check"  <?php
                                        if (isset($property->disclosure)) {
                                            foreach ($propertyIncludes as $propertyInclude) {
                                                if ($propertyInclude == "Garage") {
                                                    ?>
                                                           checked="checked"
                                                    <?php
                                                }
                                            }
                                        }
                                        ?>  name="property_includes[]" id="Garage" value="Garage">
                                        <label for="Garage">Garage</label>
                                    </div>
                                    <div id="Garage-option" style="display: none" class="col-md-12 col-sm-12 col-xs-12 btn-radio">
                                        <input type="radio" name="garage" id="Attached" <?php
                                               if (isset($property->disclosure)) {
                                                   if ($property->disclosure->garage_type == config('constant.inverse_property_disclaimer_garage.Attached')) {
                                                       ?>
                                                       checked="checked"
                                                <?php
                                            }
                                        }
                                        ?> value="{{config('constant.inverse_property_disclaimer_garage.Attached')}}">
                                        <label for="Attached">Attached</label>

                                        <input type="radio" name="garage" id="Not-Attached" <?php
                                               if (isset($property->disclosure)) {
                                                   if ($property->disclosure->garage_type == config('constant.inverse_property_disclaimer_garage.Not Attached')) {
                                                       ?>
                                                       checked="checked"
        <?php
    }
}
?> value="{{config('constant.inverse_property_disclaimer_garage.Not Attached')}}">
                                        <label for="Not-Attached"> Not Attached </label>
                                    </div>
                                </div>
                            </div><!--col-md-12-->
                            <div class="form-group">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="checkbox">
                                        <input type="checkbox" class="styled-checkbox prop_inc_check"  <?php
                                        if (isset($property->disclosure)) {
                                            foreach ($propertyIncludes as $propertyInclude) {
                                                if ($propertyInclude == "Garage Door Opener") {
                                                    ?>
                                                           checked="checked"
            <?php
        }
    }
}
?>  name="property_includes[]" id="Opener" value="Garage Door Opener">
                                        <label for="Opener"> Garage Door Opener(s) and remotes.  <span id='remotes' style="display: none">
                                                (How many remotes?<input type="number" min="0" class="readonly" id="text-form-input" name="how_many_remotes"  value="{{$property->disclosure->how_many_remotes??""}}">
                                                )</span></label>
                                    </div>
                                </div><!--col-md-12-->
                            </div>
                            <div class="form-group">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="checkbox">
                                        <input type="checkbox" class="styled-checkbox prop_inc_check"  <?php
                                        if (isset($property->disclosure)) {
                                            foreach ($propertyIncludes as $propertyInclude) {
                                                if ($propertyInclude == "Burglar Alarm/Security System") {
                                                    ?>
                                                           checked="checked"
            <?php
        }
    }
}
?> name="property_includes[]" id="Alarm" value="Burglar Alarm/Security System">
                                        <label for="Alarm">Burglar Alarm/Security System including components and controls </label>
                                    </div>
                                </div><!--col-md-12-->
                            </div>
                            <div class="form-group">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="checkbox">
                                        <input type="checkbox" class="styled-checkbox prop_inc_check" <?php
                                        if (isset($property->disclosure)) {
                                            foreach ($propertyIncludes as $propertyInclude) {
                                                if ($propertyInclude == "TV Antenna/Satellite Dish") {
                                                    ?>
                                                           checked="checked"
            <?php
        }
    }
}
?>  name="property_includes[]" id="Antenna" value="TV Antenna/Satellite Dish">
                                        <label for="Antenna"> TV Antenna/Satellite Dish excluding components  </label>
                                    </div>
                                </div><!--col-md-12-->
                            </div>
                            <div class="form-group">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="checkbox">
                                        <input type="checkbox" class="styled-checkbox prop_inc_check" <?php
                                        if (isset($property->disclosure)) {
                                            foreach ($propertyIncludes as $propertyInclude) {
                                                if ($propertyInclude == "Central Vacuum System and attachments") {
                                                    ?>
                                                           checked="checked"
            <?php
        }
    }
}
?>  name="property_includes[]" id="Vacuum" value="Central Vacuum System and attachments">
                                        <label for="Vacuum"> Central Vacuum System and attachments </label>
                                    </div>
                                </div><!--col-md-12-->
                            </div>
                            <div class="form-group">
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <div class="checkbox">
                                        <input type="checkbox" class="styled-checkbox prop_inc_check" <?php
                                        if (isset($property->disclosure)) {
                                            foreach ($propertyIncludes as $propertyInclude) {
                                                if ($propertyInclude == "Heat Pump") {
                                                    ?>
                                                           checked="checked"
            <?php
        }
    }
}
?>  name="property_includes[]" id="Heat-Pump" value="Heat Pump">
                                        <label for="Heat-Pump">Heat Pump <span id='Heat-Pump-many' style="display: none"> (Approx. age:
                                                <input type="number" class="readonly" min="0"  name="heat_pump_age" value="{{$property->disclosure->heat_pump_age??""}}">)</span></label>
                                    </div>
                                </div><!--col-md-12-->
                            </div>
                                               <?php
                                               if (isset($property->disclosure)) {
                                                   if ($property->disclosure->central_heating_type) {
                                                       $waterHeaterTypes = explode(',', $property->disclosure->central_heating_type);
                                                   }
                                               }
                                               ?>
                            <div class="col-lg-12">
                                <div class="form-group row">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <div class="checkbox">
                                            <input type="checkbox" class="styled-checkbox prop_inc_check" <?php
                            if (isset($propertyIncludes)) {
                                foreach ($propertyIncludes as $propertyInclude) {
                                    if ($propertyInclude == "Central Heating") {
                                        ?>
                                                               checked="checked"
            <?php
        }
    }
}
?>  name="property_includes[]" id="CH" value="Central Heating">
                                            <label for="CH">Central Heating <span id='CH-many' style="display: none">(Age:
                                                    <input type="number" min="0" class="readonly" id="text-form-input"  name="central_heating_age" value="{{$property->disclosure->central_heating_age??""}}">)
                                                    <span class="pull-right-div margin-left">
                                                        <input type="checkbox" class="styled-checkbox" id="Electric" <?php
                                                   if (isset($waterHeaterTypes)) {
                                                       if (isset($waterHeaterTypes)) {
                                                           foreach ($waterHeaterTypes as $waterHeaterType) {
                                                               if ($waterHeaterType == "CHElectric") {
                                                                   ?>
                                                                               checked="checked"
                <?php
            }
        }
    }
}
?> name="central_heating_type[]" value="CHElectric">
                                                        <label for="Electric">Electric</label>
                                                        <input type="checkbox" class="styled-checkbox" id="Gas" <?php
                                                        if (isset($waterHeaterTypes)) {
                                                            if (isset($waterHeaterTypes)) {
                                                                foreach ($waterHeaterTypes as $waterHeaterType) {
                                                                    if ($waterHeaterType == "CHGas") {
                ?>
                                                                               checked="checked"
                                                                               <?php
                                                                           }
                                                                       }
                                                                   }
                                                               }
                                                               ?>  name="central_heating_type[]" value="CHGas">
                                                        <label for="Gas">Gas</label>
                                                        <input type="checkbox" class="styled-checkbox" id="Other" <?php
                                                        if (isset($waterHeaterTypes)) {
                                                            if (isset($waterHeaterTypes)) {
                                                                foreach ($waterHeaterTypes as $waterHeaterType) {
                                                                    if ($waterHeaterType == "CHOther") {
                                                                        ?>
                                                                               checked="checked"
                                                                               <?php
                                                                           }
                                                                       }
                                                                   }
                                                               }
                                                               ?> name="central_heating_type[]" value="CHOther">
                                                        <label for="Other">Other:</label>
                                                    </span>
                                                </span></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                                                               <?php
                                                               if (isset($property->disclosure)) {
                                                                   if ($property->disclosure->central_air_conditioning_type) {
                                                                       $centralAirConditioningTypes = explode(',', $property->disclosure->central_air_conditioning_type);
                                                                   }
                                                               }
                                                               ?>
                            <div class="col-lg-12">
                                <div class="form-group row">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <div class="checkbox">
                                            <input type="checkbox" class="styled-checkbox prop_inc_check" <?php
                            if (isset($propertyIncludes)) {
                                foreach ($propertyIncludes as $propertyInclude) {
                                    if ($propertyInclude == "Central Air Conditioning") {
                                        ?>
                                                               checked="checked"
                                        <?php
                                    }
                                }
                            }
                            ?>  name="property_includes[]" id="CA" value="Central Air Conditioning">
                                            <label for="CA">Central Air Conditioning <span id='CA-many' style="display: none">(Age:
                                                    <input type="number" class="readonly" min="0" id="text-form-input" name="central_air_conditioning_age" value="{{$property->disclosure->heat_pump_age??""}}">)
                                                    <span class="pull-right-div margin-left">
                                                        <input type="checkbox" class="styled-checkbox" id="AirElectric"  <?php
                                            if (isset($centralAirConditioningTypes)) {
                                                if (isset($centralAirConditioningTypes)) {
                                                    foreach ($centralAirConditioningTypes as $centralAirConditioningType) {
                                                        if ($centralAirConditioningType == "CACElectric") {
                                                            ?>
                                                                               checked="checked"
                                                                   <?php
                                                               }
                                                           }
                                                       }
                                                   }
                                                   ?> name="central_air_conditioning_type[]" value="CACElectric">
                                                        <label for="AirElectric">Electric</label>
                                                        <input type="checkbox" class="styled-checkbox" id="AirGas" <?php
                                                        if (isset($centralAirConditioningTypes)) {
                                                            if (isset($centralAirConditioningTypes)) {
                                                                foreach ($centralAirConditioningTypes as $centralAirConditioningType) {
                                                                    if ($centralAirConditioningType == "CACGas") {
                                                                        ?>
                                                                               checked="checked"
                                                                               <?php
                                                                           }
                                                                       }
                                                                   }
                                                               }
                                                               ?> name="central_air_conditioning_type[]" value="CACGas">
                                                        <label for="AirGas">Gas</label>
                                                        <input type="checkbox" class="styled-checkbox" id="AirOther" <?php
                                                        if (isset($centralAirConditioningTypes)) {
                                                            if (isset($centralAirConditioningTypes)) {
                                                                foreach ($centralAirConditioningTypes as $centralAirConditioningType) {
                                                                    if ($centralAirConditioningType == "CACOther") {
                                                                        ?>
                                                                               checked="checked"
                                                                               <?php
                                                                           }
                                                                       }
                                                                   }
                                                               }
                                                               ?> name="central_air_conditioning_type[]" value="CACOther">
                                                        <label for="AirOther">Other:</label>
                                                    </span>
                                                </span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                                                               <?php
                                                               if (isset($property->disclosure)) {
                                                                   if ($property->disclosure->water_heater_type) {
                                                                       $waterHeaterTypes = explode(',', $property->disclosure->water_heater_type);
                                                                   }
                                                               }
                                                               ?>
                            <div class="col-lg-12">
                                <div class="form-group row">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <div class="checkbox">
                                            <input type="checkbox" class="styled-checkbox prop_inc_check"  <?php
                                                               if (isset($propertyIncludes)) {
                                                                   foreach ($propertyIncludes as $propertyInclude) {
                                                                       if ($propertyInclude == "Water Heater") {
                                                                           ?>
                                                               checked="checked"
                                        <?php
                                    }
                                }
                            }
                            ?> name="property_includes[]" id="WH" value="Water Heater">
                                            <label for="WH"> Water Heater<span id='WH-many' style="display: none">  (Age:
                                                    <input type="number" min="0" class="readonly" id="text-form-input" name="water_heater_age" value="{{$property->disclosure->water_heater_age??""}}">)
                                                    <span class="pull-right-div margin-left">
                                                        <input type="checkbox" class="styled-checkbox" id="WHElectric"  <?php
                            if (isset($waterHeaterTypes)) {
                                if (isset($waterHeaterTypes)) {
                                    foreach ($waterHeaterTypes as $waterHeaterType) {
                                        if ($waterHeaterType == "WHElectric") {
                                            ?>
                                                                               checked="checked"
                                                                   <?php
                                                               }
                                                           }
                                                       }
                                                   }
                                                   ?> name="water_heater_type[]" value="WHElectric">
                                                        <label for="WHElectric">Electric</label>
                                                        <input type="checkbox" class="styled-checkbox" id="WHGas" <?php
                                                   if (isset($waterHeaterTypes)) {
                                                       if (isset($waterHeaterTypes)) {
                                                           foreach ($waterHeaterTypes as $waterHeaterType) {
                                                               if ($waterHeaterType == "WHGas") {
                                                                   ?>
                                                                               checked="checked"
                                                                        <?php
                                                                    }
                                                                }
                                                            }
                                                        }
                                                        ?> name="water_heater_type[]" value="WHGas">
                                                        <label for="WHGas">Gas</label>
                                                        <input type="checkbox" class="styled-checkbox" id="WHOther" <?php
                                                               if (isset($waterHeaterTypes)) {
                                                                   if (isset($waterHeaterTypes)) {
                                                                       foreach ($waterHeaterTypes as $waterHeaterType) {
                                                                           if ($waterHeaterType == "WHOther") {
                                                                               ?>
                                                                               checked="checked"
                                                                        <?php
                                                                    }
                                                                }
                                                            }
                                                        }
                                                        ?> name="water_heater_type[]" value="WHOther">
                                                        <label for="WHOther">Other:(solar, tankless, etc): </label>
                                                    </span>
                                                </span></label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                                                        <?php
                                                        if (isset($property->disclosure)) {
                                                            if ($property->disclosure->water_supply_type) {
                                                                $waterSupplyTypes = explode(',', $property->disclosure->water_supply_type);
                                                            }
                                                        }
                                                        ?>
                            <div class="col-lg-12">
                                <div class="form-group row">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <div class="checkbox">
                                            <input type="checkbox" class="styled-checkbox prop_inc_check"  <?php
                                                               if (isset($propertyIncludes)) {
                                                                   foreach ($propertyIncludes as $propertyInclude) {
                                                                       if ($propertyInclude == "Water Supply") {
                                                                           ?>
                                                               checked="checked"
            <?php
        }
    }
}
?> name="property_includes[]" id="WSupply" value="Water Supply">
                                            <label for="WSupply">Water Supply<span id='WSupply-many' style="display: none">
                                                    <div class="margin-left">
                                                        <input type="checkbox" class="styled-checkbox" id="City-Water" <?php
                            if (isset($waterSupplyTypes)) {
                                foreach ($waterSupplyTypes as $waterSupplyType) {
                                    if ($waterSupplyType == "City Water") {
                                        ?>
                                                                           checked="checked"
            <?php
        }
    }
}
?> name="water_supply_type[]" value="City Water">
                                                        <label for="City-Water">City Water </label>
                                                        <input type="checkbox" class="styled-checkbox" id="Privatew"<?php
                                                   if (isset($waterSupplyTypes)) {
                                                       foreach ($waterSupplyTypes as $waterSupplyType) {
                                                           if ($waterSupplyType == "Private Well") {
                                                               ?>
                                                                           checked="checked"
            <?php
        }
    }
}
?>  name="water_supply_type[]" value="Private Well">
                                                        <label for="Privatew"> Private Well</label>
                                                        <input type="checkbox" class="styled-checkbox" id="Shared"<?php
                                                        if (isset($waterSupplyTypes)) {
                                                            foreach ($waterSupplyTypes as $waterSupplyType) {
                                                                if ($waterSupplyType == "Shared Well") {
                                                                    ?>
                                                                           checked="checked"
                                                                           <?php
                                                                       }
                                                                   }
                                                               }
                                                               ?>  name="water_supply_type[]" value="Shared Well">
                                                        <label for="Shared">Shared Well</label>
                                                        <input type="checkbox" class="styled-checkbox" id="oWater" <?php
                                                        if (isset($waterSupplyTypes)) {
                                                            foreach ($waterSupplyTypes as $waterSupplyType) {
                                                                if ($waterSupplyType == "WSOther") {
                                                                    ?>
                                                                           checked="checked"
                                                                           <?php
                                                                       }
                                                                   }
                                                               }
                                                               ?> name="water_supply_type[]" value="WSOther">
                                                        <label for="oWater">Other:  </label>
                                                    </div>
                                                </span> </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                                                               <?php
                                                               if (isset($property->disclosure)) {
                                                                   if ($property->disclosure->water_supply_type) {
                                                                       $sewageDisposalTypes = explode(',', $property->disclosure->sewage_disposal_type);
                                                                   }
                                                               }
                                                               ?>
                            <div class="col-lg-12">
                                <div class="form-group row">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <div class="checkbox">
                                            <input type="checkbox" class="styled-checkbox prop_inc_check" <?php
                                                               if (isset($propertyIncludes)) {
                                                                   foreach ($propertyIncludes as $propertyInclude) {
                                                                       if ($propertyInclude == "Sewage Disposal") {
                                                                           ?>
                                                               checked="checked"
            <?php
        }
    }
}
?>  name="property_includes[]" id="Sewer-Disposal"  name="property_includes[]"  value="Sewage Disposal">
                                            <label for="Sewer-Disposal">Sewage Disposal<span id='Sewer-Disposal-option' style="display: none">
                                                    <span>
                                                        <div class="margin-left">
                                                            <input type="checkbox" class="styled-checkbox" id="Sewer" <?php
                            if (isset($sewageDisposalTypes)) {
                                foreach ($sewageDisposalTypes as $sewageDisposalType) {
                                    if ($sewageDisposalType == "City Sewer") {
                                        ?>
                                                                               checked="checked"
                                        <?php
                                    }
                                }
                            }
                            ?> name="sewage_disposal_type[]" value="City Sewer">
                                                            <label for="Sewer">City Sewer</label>
                                                            <input type="checkbox" class="styled-checkbox" id="Septic" <?php
                                            if (isset($sewageDisposalTypes)) {
                                                foreach ($sewageDisposalTypes as $sewageDisposalType) {
                                                    if ($sewageDisposalType == "Septic Tank") {
                                                        ?>
                                                                               checked="checked"
                                                               <?php
                                                           }
                                                       }
                                                   }
                                                   ?> name="sewage_disposal_type[]" value="Septic Tank">
                                                            <label for="Septic">Septic Tank</label>
                                                            <input type="checkbox" class="styled-checkbox" id="STEP" <?php
                                                   if (isset($sewageDisposalTypes)) {
                                                       foreach ($sewageDisposalTypes as $sewageDisposalType) {
                                                           if ($sewageDisposalType == "STEP System") {
                                                               ?>
                                                                               checked="checked"
                                                                        <?php
                                                                    }
                                                                }
                                                            }
                                                            ?> name="sewage_disposal_type[]" value="STEP System">
                                                            <label for="STEP">STEP System  </label>
                                                            <input type="checkbox" class="styled-checkbox" id="SDOther" <?php
                                                                   if (isset($sewageDisposalTypes)) {
                                                                       foreach ($sewageDisposalTypes as $sewageDisposalType) {
                                                                           if ($sewageDisposalType == "SDOther") {
                                                                        ?>
                                                                               checked="checked"
                                                                        <?php
                                                                    }
                                                                }
                                                            }
                                                            ?> name="sewage_disposal_type[]" value="SDOther">
                                                            <label for="SDOther">Other</label>
                                                        </div>
                                                    </span>
                                                </span>

                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                                                                   <?php
                                                                   if (isset($property->disclosure)) {
                                                                       if ($property->disclosure->water_supply_type) {
                                                                           $gasSupplyTypes = explode(',', $property->disclosure->gas_supply_type);
                                                                       }
                                                                   }
                                                                   ?>
                            <div class="col-lg-12">
                                <div class="form-group row">
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <div class="checkbox">
                                            <input type="checkbox" class="styled-checkbox prop_inc_check"  <?php
                                                            if (isset($propertyIncludes)) {
                                                                foreach ($propertyIncludes as $propertyInclude) {
                                                                    if ($propertyInclude == "Gas Supply") {
                                                                        ?>
                                                               checked="checked"
                                                                               <?php
                                                                           }
                                                                       }
                                                                   }
                                                                   ?> name="property_includes[]" id="Gas-Supply"  value="Gas Supply">
                                            <label for="Gas-Supply">Gas Supply<span id='Gas-Supply-many' style="display: none">
                                                    <div class="margin-left">
                                                        <input type="checkbox" class="styled-checkbox" id="Utility" <?php
                                                                   if (isset($gasSupplyTypes)) {
                                                                       foreach ($gasSupplyTypes as $gasSupplyType) {
                                                                           if ($gasSupplyType == "Utility") {
                                                                               ?>
                                                                           checked="checked"
                                        <?php
                                    }
                                }
                            }
                            ?> name="gas_supply_type[]" value="Utility">
                                                        <label for="Utility">Utility</label>
                                                        <input type="checkbox" class="styled-checkbox" id="Propane-Tank" <?php
                            if (isset($gasSupplyTypes)) {
                                foreach ($gasSupplyTypes as $gasSupplyType) {
                                    if ($gasSupplyType == "Propane Tank") {
                                        ?>
                                                                           checked="checked"
                                                        <?php
                                                    }
                                                }
                                            }
                                            ?>name="gas_supply_type[]" value="Propane Tank">
                                                        <label for="Propane-Tank"> Propane Tank</label>
                                                        <input type="checkbox" class="styled-checkbox" id="GSOther" <?php
                                                   if (isset($gasSupplyTypes)) {
                                                       foreach ($gasSupplyTypes as $gasSupplyType) {
                                                           if ($gasSupplyType == "GSOther") {
                                                               ?>
                                                                           checked="checked"
                                                                    <?php
                                                                }
                                                            }
                                                        }
                                                        ?> name="gas_supply_type[]" value="GSOther">
                                                        <label for="GSOther">Other:</label>
                                                    </div>
                                                </span>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="prop_chkbox_error error">
                                Please select atleast one of these.
                            </div>
                            @if(count($errors->get('property_includes[]')) > 0)
                            <span class="text text-danger">{{implode('<br>', $errors->get('property_includes[]'))}}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <h5 class="col-sm-12">Other items included:</h5>
                            <div class="col-sm-12">
                                <textarea type="text" rows="4" id="optional_message" class="form-control text-height" id="text-form-input" name="other_items_included" value="">{{$property->disclosure->other_items_included??""}}</textarea>
                            </div>
                        </div>
                        <div class="form-group btn-radio">
                            <div class="col-md-12">
                                <h5>To the best of seller's knowledge, are any in Part A above NOT in operating condition:</h5>
                                <input type="radio" class="makeofferradio" id="selleryes" name="bsknowledge" <?php
                                                        if (isset($property->disclosure)) {
                                                            if ($property->disclosure->best_knowledge == config('constant.inverse_common_yes_no.Yes')) {
                                                                ?>
                                               checked="checked"
                                                                       <?php
                                                                   }
                                                               }
                                                               ?>  value="{{config('constant.inverse_common_yes_no.Yes')}}" required="true">
                                <label for="selleryes">Yes</label>
                                <input type="radio" class="makeofferradio" id="sellerNo" name="bsknowledge" <?php
                                                               if (isset($property->disclosure)) {
                                                                   if ($property->disclosure->best_knowledge == config('constant.inverse_common_yes_no.No')) {
                                                                       ?>
                                               checked="checked"
        <?php
    }
}
?>  value="{{config('constant.inverse_common_yes_no.No')}}" required="true">
                                <label for="sellerNo">No</label>
                                @if(count($errors->get('bsknowledge')) > 0)
                                <span class="text text-danger">{{implode('<br>', $errors->get('bsknowledge'))}}</span>
                                @endif
                            </div><!--col-md-12-->
                        </div>
                        <div id="seller" style="display: none">
                            <div class="form-group">
                                <h5 class="col-sm-12">If Yes, Please Explain:</h5>
                                <div class="col-sm-12">
                                    <textarea type="text" rows="2" id="seller" class="form-control" required="true" name="bsknowledge_explain">{{$property->disclosure->best_knowledge_explain??""}}</textarea>
                                    @if(count($errors->get('bsknowledge_explain')) > 0)
                                    <span class="text text-danger">{{implode('<br>', $errors->get('bsknowledge_explain'))}}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="form-group"> 
                            <div class="col-md-12">
                                <h5>B. Is Seller AWARE of any defects or malfunctions in any of the following?</h5>
                            </div><!--col-md-12-->
                        </div>
                        <div class="form-group btn-radio">
                            <div class="col-sm-12">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="Seller-checkbox-table">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th style="width:50px;">Yes</th>
                                                <th style="width:50px;">No</th>
                                                <th style="width:50px;">N/A</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>Interior Walls</td>
                                                <td>
                                                    <input type="radio" name="interior_walls" id="interior_wallsyes" <?php
if (isset($property->disclosure)) {
    if ($property->disclosure->interior_walls == config('constant.inverse_property_condition_disclaimer.Yes')) {
        ?>
                                                                   checked="checked"
        <?php
    }
}
?> value="{{config('constant.inverse_property_condition_disclaimer.Yes')}}">
                                                    <label for="interior_wallsyes"></label>
                                                </td>
                                                <td><label class="">
                                                        <input type="radio" name="interior_walls" id="interior_wallsNo" <?php
if (isset($property->disclosure)) {
    if ($property->disclosure->interior_walls == config('constant.inverse_property_condition_disclaimer.No')) {
        ?>
                                                                       checked="checked"
        <?php
    }
}
?> value="{{config('constant.inverse_property_condition_disclaimer.No')}}">
                                                        <label for="interior_wallsNo"></label>
                                                    </label>
                                                </td>
                                                <td><label class="">
                                                        <input type="radio" class="radio-btn-active" name="interior_walls" <?php
if (isset($property->disclosure)) {
    if ($property->disclosure->interior_walls == config('constant.inverse_property_condition_disclaimer.NA')) {
        ?>
                                                                       checked="checked"
        <?php
    }
}
?> id="interior_wallsNA" value="{{config('constant.inverse_property_condition_disclaimer.NA')}}">
                                                        <label for="interior_wallsNA"></label>
                                                    </label>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Ceilings</td>
                                                <td>
                                                    <input type="radio" name="ceilings" id="Ceilingsyes"<?php
                                                           if (isset($property->disclosure)) {
                                                               if ($property->disclosure->ceilings == config('constant.inverse_property_condition_disclaimer.Yes')) {
                                                                   ?>
                                                                   checked="checked"
                                                                <?php
                                                            }
                                                        }
                                                        ?>  value="{{config('constant.inverse_property_condition_disclaimer.Yes')}}">
                                                    <label for="Ceilingsyes"></label>
                                                </td>
                                                <td><label class="">
                                                        <input type="radio" name="ceilings" id="CeilingsNo" <?php
                                                               if (isset($property->disclosure)) {
                                                                   if ($property->disclosure->ceilings == config('constant.inverse_property_condition_disclaimer.No')) {
                                                                       ?>
                                                                       checked="checked"
        <?php
    }
}
?> value="{{config('constant.inverse_property_condition_disclaimer.No')}}">
                                                        <label for="CeilingsNo"></label>
                                                    </label>
                                                </td>
                                                <td><label class="">
                                                        <input type="radio" class="radio-btn-active" name="ceilings" id="CeilingsNA" <?php
                                                               if (isset($property->disclosure)) {
                                                                   if ($property->disclosure->ceilings == config('constant.inverse_property_condition_disclaimer.NA')) {
                                                                       ?>
                                                                       checked="checked"
        <?php
    }
}
?>value="{{config('constant.inverse_property_condition_disclaimer.NA')}}">
                                                        <label for="CeilingsNA"></label>
                                                    </label>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Floors</td>
                                                <td>
                                                    <input type="radio" name="floors" id="Floorsyes"<?php
                                                           if (isset($property->disclosure)) {
                                                               if ($property->disclosure->floors == config('constant.inverse_property_condition_disclaimer.Yes')) {
                                                                   ?>
                                                                   checked="checked"
        <?php
    }
}
?>  value="{{config('constant.inverse_property_condition_disclaimer.Yes')}}">
                                                    <label for="Floorsyes"></label>
                                                </td>
                                                <td><label class="">
                                                        <input type="radio" name="floors" id="FloorsNo" class="radio-btn-active" <?php
if (isset($property->disclosure)) {
    if ($property->disclosure->floors == config('constant.inverse_property_condition_disclaimer.No')) {
        ?>
                                                                       checked="checked"
                                                                       <?php
                                                                   }
                                                               }
                                                               ?> value="{{config('constant.inverse_property_condition_disclaimer.No')}}">
                                                        <label for="FloorsNo"></label>
                                                    </label>
                                                </td>
                                                <td><label class="">
                                                        <input type="radio" class="radio-btn-active"  name="floors" id="FloorsNA" <?php
                                                        if (isset($property->disclosure)) {
                                                            if ($property->disclosure->floors == config('constant.inverse_property_condition_disclaimer.NA')) {
                                                                ?>
                                                                       checked="checked"
                                                                       <?php
                                                                   }
                                                               }
                                                               ?>value="{{config('constant.inverse_property_condition_disclaimer.NA')}}">
                                                        <label for="FloorsNA"></label>
                                                    </label>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Windows</td>
                                                <td>
                                                    <input type="radio" name="windows" id="Windowsyes"<?php
                                                    if (isset($property->disclosure)) {
                                                        if ($property->disclosure->windows == config('constant.inverse_property_condition_disclaimer.Yes')) {
                                                            ?>
                                                                   checked="checked"
                                                                   <?php
                                                               }
                                                           }
                                                           ?>  value="{{config('constant.inverse_property_condition_disclaimer.Yes')}}">
                                                    <label for="Windowsyes"></label>
                                                </td>
                                                <td><label class="">
                                                        <input type="radio" name="windows" id="WindowsNo" <?php
                                                        if (isset($property->disclosure)) {
                                                            if ($property->disclosure->windows == config('constant.inverse_property_condition_disclaimer.No')) {
                                                                ?>
                                                                       checked="checked"
                                                                       <?php
                                                                   }
                                                               }
                                                               ?> value="{{config('constant.inverse_property_condition_disclaimer.No')}}">
                                                        <label for="WindowsNo"></label>
                                                    </label>
                                                </td>
                                                <td><label class="">
                                                        <input type="radio" class="radio-btn-active"  name="windows" id="WindowsNA" <?php
                                                        if (isset($property->disclosure)) {
                                                            if ($property->disclosure->windows == config('constant.inverse_property_condition_disclaimer.NA')) {
                                                                ?>
                                                                       checked="checked"
                                                                       <?php
                                                                   }
                                                               }
                                                               ?>value="{{config('constant.inverse_property_condition_disclaimer.NA')}}">
                                                        <label for="WindowsNA"></label>
                                                    </label>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Doors</td>
                                                <td>
                                                    <input type="radio" name="doors" id="Doorsyes" <?php
                                                               if (isset($property->disclosure)) {
                                                                   if ($property->disclosure->doors == config('constant.inverse_property_condition_disclaimer.Yes')) {
                                                                       ?>
                                                                   checked="checked"
                                                            <?php
                                                        }
                                                    }
                                                    ?> value="{{config('constant.inverse_property_condition_disclaimer.Yes')}}">
                                                    <label for="Doorsyes"></label>
                                                </td>

                                                <td><label class="">
                                                        <input type="radio" name="doors" id="DoorsNo" <?php
                                                           if (isset($property->disclosure)) {
                                                               if ($property->disclosure->doors == config('constant.inverse_property_condition_disclaimer.No')) {
                                                            ?>
                                                                       checked="checked"
                                                                <?php
                                                            }
                                                        }
                                                        ?> value="{{config('constant.inverse_property_condition_disclaimer.No')}}">
                                                        <label for="DoorsNo"></label>
                                                    </label>
                                                </td>
                                                <td><label class="">
                                                        <input type="radio" class="radio-btn-active" name="doors" id="DoorsNA" <?php
                                                               if (isset($property->disclosure)) {
                                                                   if ($property->disclosure->doors == config('constant.inverse_property_condition_disclaimer.NA')) {
                                                                ?>
                                                                       checked="checked"
                                                                <?php
                                                            }
                                                        }
                                                        ?> value="{{config('constant.inverse_property_condition_disclaimer.NA')}}">
                                                        <label for="DoorsNA"></label>
                                                    </label>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Insulation</td>
                                                <td>
                                                    <input type="radio" name="insulation" id="Insulationyes" <?php
                                                               if (isset($property->disclosure)) {
                                                                   if ($property->disclosure->insulation == config('constant.inverse_property_condition_disclaimer.Yes')) {
                                                                       ?>
                                                                   checked="checked"
                                                            <?php
                                                        }
                                                    }
                                                    ?> value="{{config('constant.inverse_property_condition_disclaimer.Yes')}}">
                                                    <label for="Insulationyes"></label>
                                                </td>
                                                <td><label class="">
                                                        <input type="radio" name="insulation" id="InsulationNo" <?php
                                                    if (isset($property->disclosure)) {
                                                        if ($property->disclosure->insulation == config('constant.inverse_property_condition_disclaimer.No')) {
                                                            ?>
                                                                       checked="checked"
                                                                <?php
                                                            }
                                                        }
                                                        ?> value="{{config('constant.inverse_property_condition_disclaimer.No')}}">
                                                        <label for="InsulationNo"></label>
                                                    </label>
                                                </td>
                                                <td><label class="">
                                                        <input type="radio" class="radio-btn-active" name="insulation" <?php
                                                               if (isset($property->disclosure)) {
                                                                   if ($property->disclosure->insulation == config('constant.inverse_property_condition_disclaimer.NA')) {
                                                                       ?>
                                                                       checked="checked"
        <?php
    }
}
?> id="InsulationNA" value="{{config('constant.inverse_property_condition_disclaimer.NA')}}">
                                                        <label for="InsulationNA"></label>
                                                    </label>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Plumbing</td>
                                                <td>
                                                    <input type="radio" name="plumbing" id="Plumbingyes" <?php
                                                        if (isset($property->disclosure)) {
                                                            if ($property->disclosure->plumbing == config('constant.inverse_property_condition_disclaimer.Yes')) {
                                                                ?>
                                                                   checked="checked"
        <?php
    }
}
?> value="{{config('constant.inverse_property_condition_disclaimer.Yes')}}">
                                                    <label for="Plumbingyes"></label>
                                                </td>
                                                <td><label class="">
                                                        <input type="radio" name="plumbing" id="PlumbingNo" <?php
                                                           if (isset($property->disclosure)) {
                                                               if ($property->disclosure->plumbing == config('constant.inverse_property_condition_disclaimer.No')) {
                                                                   ?>
                                                                       checked="checked"
        <?php
    }
}
?> value="{{config('constant.inverse_property_condition_disclaimer.No')}}">
                                                        <label for="PlumbingNo"></label>
                                                    </label>
                                                </td>
                                                <td><label class="">
                                                        <input type="radio" class="radio-btn-active" <?php
                                                               if (isset($property->disclosure)) {
                                                                   if ($property->disclosure->plumbing == config('constant.inverse_property_condition_disclaimer.NA')) {
                                                                       ?>
                                                                       checked="checked"
        <?php
    }
}
?> name="plumbing" id="PlumbingNA" value="{{config('constant.inverse_property_condition_disclaimer.NA')}}">
                                                        <label for="PlumbingNA"></label>
                                                    </label>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Sewer/Septic</td>
                                                <td>
                                                    <input type="radio" name="sewer" id="SewerSepticyes" <?php
                                                               if (isset($property->disclosure)) {
                                                                   if ($property->disclosure->sewer == config('constant.inverse_property_condition_disclaimer.Yes')) {
                                                                       ?>
                                                                   checked="checked"
        <?php
    }
}
?> value="{{config('constant.inverse_property_condition_disclaimer.Yes')}}">
                                                    <label for="SewerSepticyes"></label>
                                                </td>

                                                <td><label class="">
                                                        <input type="radio" name="sewer" id="SewerSepticNo" <?php
                                                    if (isset($property->disclosure)) {
                                                        if ($property->disclosure->sewer == config('constant.inverse_property_condition_disclaimer.No')) {
                                                            ?>
                                                                       checked="checked"
                                                                   <?php
                                                               }
                                                           }
                                                           ?> value="{{config('constant.inverse_property_condition_disclaimer.No')}}">
                                                        <label for="SewerSepticNo"></label>
                                                    </label>
                                                </td>
                                                <td><label class="">
                                                        <input type="radio" class="radio-btn-active" name="sewer" <?php
                                                        if (isset($property->disclosure)) {
                                                            if ($property->disclosure->sewer == config('constant.inverse_property_condition_disclaimer.NA')) {
                                                                ?>
                                                                       checked="checked"
                                                                       <?php
                                                                   }
                                                               }
                                                               ?> id="SewerSepticNA" value="{{config('constant.inverse_property_condition_disclaimer.NA')}}">
                                                        <label for="SewerSepticNA"></label>
                                                    </label>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Electrical System</td>
                                                <td>
                                                    <input type="radio" name="electrical_system" id="Electricalyes" <?php
                                                               if (isset($property->disclosure)) {
                                                                   if ($property->disclosure->electrical_system == config('constant.inverse_property_condition_disclaimer.Yes')) {
                                                                       ?>
                                                                   checked="checked"
        <?php
    }
}
?> value="{{config('constant.inverse_property_condition_disclaimer.Yes')}}">
                                                    <label for="Electricalyes"></label>
                                                </td>
                                                <td><label class="">
                                                        <input type="radio" name="electrical_system" id="ElectricalNo" <?php
                                                    if (isset($property->disclosure)) {
                                                        if ($property->disclosure->electrical_system == config('constant.inverse_property_condition_disclaimer.No')) {
                                                            ?>
                                                                       checked="checked"
                                                                   <?php
                                                               }
                                                           }
                                                           ?> value="{{config('constant.inverse_property_condition_disclaimer.No')}}">
                                                        <label for="ElectricalNo"></label>
                                                    </label>
                                                </td>
                                                <td><label class="">
                                                        <input type="radio" class="radio-btn-active" name="electrical_system" <?php
                                                           if (isset($property->disclosure)) {
                                                               if ($property->disclosure->electrical_system == config('constant.inverse_property_condition_disclaimer.NA')) {
                                                                   ?>
                                                                       checked="checked"
                                                                <?php
                                                            }
                                                        }
                                                        ?> id="ElectricalNA" value="{{config('constant.inverse_property_condition_disclaimer.NA')}}">
                                                        <label for="ElectricalNA"></label>
                                                    </label>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Exterior Walls</td>
                                                <td>
                                                    <input type="radio" name="exterior_walls" id="Exterioryes" <?php
                                                        if (isset($property->disclosure)) {
                                                            if ($property->disclosure->exterior_walls == config('constant.inverse_property_condition_disclaimer.Yes')) {
                                                                ?>
                                                                   checked="checked"
                                                                       <?php
                                                                   }
                                                               }
                                                               ?> value="{{config('constant.inverse_property_condition_disclaimer.Yes')}}">
                                                    <label for="Exterioryes"></label>
                                                </td>
                                                <td><label class="">
                                                        <input type="radio" name="exterior_walls" id="ExteriorNo" <?php
                                                               if (isset($property->disclosure)) {
                                                                   if ($property->disclosure->exterior_walls == config('constant.inverse_property_condition_disclaimer.No')) {
                                                                       ?>
                                                                       checked="checked"
                                                            <?php
                                                        }
                                                    }
                                                    ?> value="{{config('constant.inverse_property_condition_disclaimer.No')}}">
                                                        <label for="ExteriorNo"></label>
                                                    </label>
                                                </td>
                                                <td><label class="">
                                                        <input type="radio" class="radio-btn-active" name="exterior_walls" <?php
                                                    if (isset($property->disclosure)) {
                                                        if ($property->disclosure->exterior_walls == config('constant.inverse_property_condition_disclaimer.NA')) {
                                                            ?>
                                                                       checked="checked"
                                                                <?php
                                                            }
                                                        }
                                                        ?> id="ExteriorNA" value="{{config('constant.inverse_property_condition_disclaimer.NA')}}">
                                                        <label for="ExteriorNA"></label>
                                                    </label>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Roof</td>
                                                <td>
                                                    <input type="radio" name="roof" id="Roofyes" <?php
                                                        if (isset($property->disclosure)) {
                                                            if ($property->disclosure->roof == config('constant.inverse_property_condition_disclaimer.Yes')) {
                                                                ?>
                                                                   checked="checked"
                                                                <?php
                                                            }
                                                        }
                                                        ?> value="{{config('constant.inverse_property_condition_disclaimer.Yes')}}">
                                                    <label for="Roofyes"></label>
                                                </td>
                                                <td><label class="">
                                                        <input type="radio" name="roof" id="RoofNo" <?php
                                                               if (isset($property->disclosure)) {
                                                                   if ($property->disclosure->roof == config('constant.inverse_property_condition_disclaimer.No')) {
                                                                       ?>
                                                                       checked="checked"
        <?php
    }
}
?> value="{{config('constant.inverse_property_condition_disclaimer.No')}}">
                                                        <label for="RoofNo"></label>
                                                    </label>
                                                </td>
                                                <td><label class="">
                                                        <input type="radio" class="radio-btn-active" name="roof" <?php
                                                           if (isset($property->disclosure)) {
                                                               if ($property->disclosure->roof == config('constant.inverse_property_condition_disclaimer.NA')) {
                                                                   ?>
                                                                       checked="checked"
        <?php
    }
}
?> id="RoofNA" value="{{config('constant.inverse_property_condition_disclaimer.NA')}}">
                                                        <label for="RoofNA"></label>
                                                    </label>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Basement</td>
                                                <td>
                                                    <input type="radio" name="basement" id="Basementyes"<?php
                                                        if (isset($property->disclosure)) {
                                                            if ($property->disclosure->basement == config('constant.inverse_property_condition_disclaimer.Yes')) {
                                                                ?>
                                                                   checked="checked"
                                                                <?php
                                                            }
                                                        }
                                                        ?>  value="{{config('constant.inverse_property_condition_disclaimer.Yes')}}">
                                                    <label for="Basementyes"></label>
                                                </td>
                                                <td><label class="">
                                                        <input type="radio" name="basement" id="BasementNo" <?php
                                                               if (isset($property->disclosure)) {
                                                                   if ($property->disclosure->basement == config('constant.inverse_property_condition_disclaimer.No')) {
                                                                       ?>
                                                                       checked="checked"
        <?php
    }
}
?> value="{{config('constant.inverse_property_condition_disclaimer.No')}}">
                                                        <label for="BasementNo"></label>
                                                    </label>
                                                </td>
                                                <td><label class="">
                                                        <input type="radio" class="radio-btn-active" name="basement" <?php
                                                    if (isset($property->disclosure)) {
                                                        if ($property->disclosure->basement == config('constant.inverse_property_condition_disclaimer.NA')) {
                                                            ?>
                                                                       checked="checked"
                                                                   <?php
                                                               }
                                                           }
                                                           ?> id="BasementNA" value="{{config('constant.inverse_property_condition_disclaimer.NA')}}">
                                                        <label for="BasementNA"></label>
                                                    </label>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Foundation</td>
                                                <td>
                                                    <input type="radio" name="foundation" id="Foundationyes" <?php
                                                               if (isset($property->disclosure)) {
                                                                   if ($property->disclosure->foundation == config('constant.inverse_property_condition_disclaimer.Yes')) {
                                                                       ?>
                                                                   checked="checked"
        <?php
    }
}
?> value="{{config('constant.inverse_property_condition_disclaimer.Yes')}}">
                                                    <label for="Foundationyes"></label>
                                                </td>
                                                <td><label class="">
                                                        <input type="radio" name="foundation" id="FoundationNo" <?php
if (isset($property->disclosure)) {
    if ($property->disclosure->foundation == config('constant.inverse_property_condition_disclaimer.No')) {
        ?>
                                                                       checked="checked"
                                                                       <?php
                                                                   }
                                                               }
                                                               ?> value="{{config('constant.inverse_property_condition_disclaimer.No')}}">
                                                        <label for="FoundationNo"></label>
                                                    </label>
                                                </td>
                                                <td><label class="">
                                                        <input type="radio" class="radio-btn-active" name="foundation" <?php
                                                    if (isset($property->disclosure)) {
                                                        if ($property->disclosure->foundation == config('constant.inverse_property_condition_disclaimer.NA')) {
                                                            ?>
                                                                       checked="checked"
                                                                   <?php
                                                               }
                                                           }
                                                           ?> id="FoundationNA" value="{{config('constant.inverse_property_condition_disclaimer.NA')}}">
                                                        <label for="FoundationNA"></label>
                                                    </label>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Slab</td>
                                                <td>
                                                    <input type="radio" name="slab" id="Slabyes" <?php
                                                        if (isset($property->disclosure)) {
                                                            if ($property->disclosure->slab == config('constant.inverse_property_condition_disclaimer.Yes')) {
                                                                ?>
                                                                   checked="checked"
                                                                       <?php
                                                                   }
                                                               }
                                                               ?> value="{{config('constant.inverse_property_condition_disclaimer.Yes')}}">
                                                    <label for="Slabyes"></label>
                                                </td>
                                                <td><label class="">
                                                        <input type="radio" name="slab" id="SlabNo" <?php
                                                        if (isset($property->disclosure)) {
                                                            if ($property->disclosure->slab == config('constant.inverse_property_condition_disclaimer.No')) {
                                                                ?>
                                                                       checked="checked"
                                                                       <?php
                                                                   }
                                                               }
                                                               ?> value="{{config('constant.inverse_property_condition_disclaimer.No')}}">
                                                        <label for="SlabNo"></label>
                                                    </label>
                                                </td>
                                                <td><label class="">
                                                        <input type="radio" class="radio-btn-active" name="slab" <?php
                                                               if (isset($property->disclosure)) {
                                                                   if ($property->disclosure->slab == config('constant.inverse_property_condition_disclaimer.NA')) {
                                                                       ?>
                                                                       checked="checked"
                                                            <?php
                                                        }
                                                    }
                                                    ?>id="SlabNA" value="{{config('constant.inverse_property_condition_disclaimer.NA')}}">
                                                        <label for="SlabNA"></label>
                                                    </label>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Driveway</td>
                                                <td>
                                                    <input type="radio" name="driveway" id="Drivewayyes" <?php
                                                        if (isset($property->disclosure)) {
                                                            if ($property->disclosure->drive_way == config('constant.inverse_property_condition_disclaimer.Yes')) {
                                                                ?>
                                                                   checked="checked"
                                                                       <?php
                                                                   }
                                                               }
                                                               ?> value="{{config('constant.inverse_property_condition_disclaimer.Yes')}}">
                                                    <label for="Drivewayyes"></label>
                                                </td>
                                                <td><label class="">
                                                        <input type="radio" name="driveway" id="DrivewayNo" <?php
                                                               if (isset($property->disclosure)) {
                                                                   if ($property->disclosure->drive_way == config('constant.inverse_property_condition_disclaimer.No')) {
                                                                       ?>
                                                                       checked="checked"
                                                                <?php
                                                            }
                                                        }
                                                        ?> value="{{config('constant.inverse_property_condition_disclaimer.No')}}">
                                                        <label for="DrivewayNo"></label>
                                                    </label>
                                                </td>
                                                <td><label class="">
                                                        <input type="radio" class="radio-btn-active" name="driveway" <?php
                                                               if (isset($property->disclosure)) {
                                                                   if ($property->disclosure->drive_way == config('constant.inverse_property_condition_disclaimer.NA')) {
                                                                       ?>
                                                                       checked="checked"
        <?php
    }
}
?> id="DrivewayNA" value="{{config('constant.inverse_property_condition_disclaimer.NA')}}">
                                                        <label for="DrivewayNA"></label>
                                                    </label>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Sidewalks</td>
                                                <td>
                                                    <input type="radio" name="sidewalks" id="Sidewalksyes"<?php
                                                    if (isset($property->disclosure)) {
                                                        if ($property->disclosure->side_walks == config('constant.inverse_property_condition_disclaimer.Yes')) {
                                                            ?>
                                                                   checked="checked"
                                                                <?php
                                                            }
                                                        }
                                                        ?>  value="{{config('constant.inverse_property_condition_disclaimer.Yes')}}">
                                                    <label for="Sidewalksyes"></label>
                                                </td>
                                                <td><label class="">
                                                        <input type="radio" name="sidewalks" id="SidewalksNo" <?php
                                                        if (isset($property->disclosure)) {
                                                            if ($property->disclosure->side_walks == config('constant.inverse_property_condition_disclaimer.No')) {
                                                                ?>
                                                                       checked="checked"
                                                                <?php
                                                            }
                                                        }
                                                        ?> value="{{config('constant.inverse_property_condition_disclaimer.No')}}">
                                                        <label for="SidewalksNo"></label>
                                                    </label>
                                                </td>
                                                <td><label class="">
                                                        <input type="radio" class="radio-btn-active" name="sidewalks" id="SidewalksNA" <?php
                                                               if (isset($property->disclosure)) {
                                                                   if ($property->disclosure->side_walks == config('constant.inverse_property_condition_disclaimer.NA')) {
                                                                       ?>
                                                                       checked="checked"
        <?php
    }
}
?> value="{{config('constant.inverse_property_condition_disclaimer.NA')}}">
                                                        <label for="SidewalksNA"></label>
                                                    </label>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Central Heating</td>
                                                <td>
                                                    <input type="radio" name="central_heating" id="Heatingyes" <?php
                                                           if (isset($property->disclosure)) {
                                                               if ($property->disclosure->central_heating == config('constant.inverse_property_condition_disclaimer.Yes')) {
                                                                   ?>
                                                                   checked="checked"
        <?php
    }
}
?> value="{{config('constant.inverse_property_condition_disclaimer.Yes')}}">
                                                    <label for="Heatingyes"></label>
                                                </td>
                                                <td><label class="">
                                                        <input type="radio" name="central_heating" id="HeatingNo" <?php
                                                               if (isset($property->disclosure)) {
                                                                   if ($property->disclosure->central_heating == config('constant.inverse_property_condition_disclaimer.No')) {
                                                                       ?>
                                                                       checked="checked"
        <?php
    }
}
?> value="{{config('constant.inverse_property_condition_disclaimer.No')}}">
                                                        <label for="HeatingNo"></label>
                                                    </label>
                                                </td>
                                                <td><label class="">
                                                        <input type="radio" class="radio-btn-active" name="central_heating" id="HeatingNA" <?php
                                                               if (isset($property->disclosure)) {
                                                                   if ($property->disclosure->central_heating == config('constant.inverse_property_condition_disclaimer.NA')) {
                                                                       ?>
                                                                       checked="checked"
        <?php
    }
}
?> value="{{config('constant.inverse_property_condition_disclaimer.NA')}}">
                                                        <label for="HeatingNA"></label>
                                                    </label>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Heat Pump</td>
                                                <td>
                                                    <input type="radio" name="heat_pump" id="Pumpyes" <?php
if (isset($property->disclosure)) {
    if ($property->disclosure->heat_pump == config('constant.inverse_property_condition_disclaimer.Yes')) {
        ?>
                                                                   checked="checked"
                                                                   <?php
                                                               }
                                                           }
                                                           ?> value="{{config('constant.inverse_property_condition_disclaimer.Yes')}}">
                                                    <label for="Pumpyes"></label>
                                                </td>
                                                <td><label class="">
                                                        <input type="radio" name="heat_pump" id="PumpNo" <?php
                                                        if (isset($property->disclosure)) {
                                                            if ($property->disclosure->heat_pump == config('constant.inverse_property_condition_disclaimer.No')) {
                                                                ?>
                                                                       checked="checked"
                                                                       <?php
                                                                   }
                                                               }
                                                               ?> value="{{config('constant.inverse_property_condition_disclaimer.No')}}">
                                                        <label for="PumpNo"></label>
                                                    </label>
                                                </td>
                                                <td><label class="">
                                                        <input type="radio" class="radio-btn-active" name="heat_pump" id="PumpNA" <?php
                                                        if (isset($property->disclosure)) {
                                                            if ($property->disclosure->heat_pump == config('constant.inverse_property_condition_disclaimer.NA')) {
                                                                ?>
                                                                       checked="checked"
                                                                       <?php
                                                                   }
                                                               }
                                                               ?> value="{{config('constant.inverse_property_condition_disclaimer.NA')}}">
                                                        <label for="PumpNA"></label>
                                                    </label>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>Central Air Conditioning</td>
                                                <td>
                                                    <input type="radio" name="central_air_conditioning" <?php
                                                    if (isset($property->disclosure)) {
                                                        if ($property->disclosure->central_air == config('constant.inverse_property_condition_disclaimer.Yes')) {
                                                            ?>
                                                                   checked="checked"
                                                                   <?php
                                                               }
                                                           }
                                                           ?> id="Airyes" value="{{config('constant.inverse_property_condition_disclaimer.Yes')}}">
                                                    <label for="Airyes"></label>
                                                </td>
                                                <td><label class="">
                                                        <input type="radio" name="central_air_conditioning" id="AirNo" <?php
                                                        if (isset($property->disclosure)) {
                                                            if ($property->disclosure->central_air == config('constant.inverse_property_condition_disclaimer.No')) {
                                                                ?>
                                                                       checked="checked"
                                                                       <?php
                                                                   }
                                                               }
                                                               ?> value="{{config('constant.inverse_property_condition_disclaimer.No')}}">
                                                        <label for="AirNo"></label>
                                                    </label>
                                                </td>
                                                <td><label class="">
                                                        <input type="radio" class="radio-btn-active" name="central_air_conditioning" <?php
                                                               if (isset($property->disclosure)) {
                                                                   if ($property->disclosure->central_air == config('constant.inverse_property_condition_disclaimer.NA')) {
                                                                       ?>
                                                                       checked="checked"
                                                                <?php
                                                            }
                                                        }
                                                        ?> id="AirNA" value="{{config('constant.inverse_property_condition_disclaimer.NA')}}">
                                                        <label for="AirNA"></label>
                                                    </label>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <h5 for="" class="col-sm-12 control-label">If any of the above in Part B are marked YES, please explain:</h5>
                            <div class="col-sm-12">
                                <textarea rows="2" type="text" class="form-control text-height" id="" name="partb_details">{{$property->disclosure->partb_details??""}}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <h5 for="" class="col-sm-12 control-label">Please describe any repairs made by you or any previous owners of which you are aware (attach separate sheets if necessary)?</h5>
                            <div class="col-sm-12">
                                <textarea rows="2" type="text" class="form-control text-height" id="" name="any_repairs">{{$property->disclosure->any_repairs??""}}</textarea>
                                @if(count($errors->get('any_repairs')) > 0)
                                <span class="text text-danger">{{implode('<br>', $errors->get('any_repairs'))}}</span>
                                @endif
                            </div>
                        </div>
                        <div class="form-group">
                            <h5 for="" class="col-sm-12 control-label">C. Is Seller AWARE of any of the following?</h5>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="Seller-checkbox-table">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th style="width:50px;">Yes</th>
                                                <th style="width:50px;">No</th>
                                                <th style="width:50px;">N/A</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>1.Substances, materials or products which may be environmental hazards such as, but not limited to: asbestos,
                                                    radon gas, lead-based paint, fuel or chemical storage tanks, methamphetamine, contaminated soil or water,
                                                    and/or known existing or past mold presence on the subject property?
                                                </td>
                                                <td>
                                                    <input type="radio" name="substances" id="substancesyes"<?php
                                                               if (isset($property->disclosure)) {
                                                                   if ($property->disclosure->substances == config('constant.inverse_property_condition_disclaimer.Yes')) {
                                                                       ?>
                                                                   checked="checked"
        <?php
    }
}
?> value="{{config('constant.inverse_property_condition_disclaimer.Yes')}}">
                                                    <label for="substancesyes"></label>
                                                </td>
                                                <td><label class="">
                                                        <input type="radio" name="substances" id="substancesNo"<?php
                                                           if (isset($property->disclosure)) {
                                                               if ($property->disclosure->substances == config('constant.inverse_property_condition_disclaimer.No')) {
                                                                   ?>
                                                                       checked="checked"
        <?php
    }
}
?> value="{{config('constant.inverse_property_condition_disclaimer.No')}}">
                                                        <label for="substancesNo"></label>
                                                    </label>
                                                </td>
                                                <td><label class="">
                                                        <input type="radio" class="radio-btn-active" name="substances"<?php
                                                               if (isset($property->disclosure)) {
                                                                   if ($property->disclosure->substances == config('constant.inverse_property_condition_disclaimer.NA')) {
                                                                       ?>
                                                                       checked="checked"
        <?php
    }
}
?> id="substancesNA" value="{{config('constant.inverse_property_condition_disclaimer.NA')}}">
                                                        <label for="substancesNA"></label>
                                                    </label>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>2. Features shared in common with adjoining land owners with joint rights and obligations for use and maintenance
                                                    (e.g. - driveways, private roads, walls, fences, wells, septic systems, etc)? </td>
                                                <td>
                                                    <input type="radio" name="features_shared" id="features_sharedyes" <?php
                                                               if (isset($property->disclosure)) {
                                                                   if ($property->disclosure->features_shared == config('constant.inverse_property_condition_disclaimer.Yes')) {
                                                                       ?>
                                                                   checked="checked"
        <?php
    }
}
?>value="{{config('constant.inverse_property_condition_disclaimer.Yes')}}">
                                                    <label for="features_sharedyes"></label>
                                                </td>
                                                <td><label class="">
                                                        <input type="radio" name="features_shared" id="features_sharedNo"<?php
if (isset($property->disclosure)) {
    if ($property->disclosure->features_shared == config('constant.inverse_property_condition_disclaimer.No')) {
        ?>
                                                                       checked="checked"
        <?php
    }
}
?> value="{{config('constant.inverse_property_condition_disclaimer.No')}}">
                                                        <label for="features_sharedNo"></label>
                                                    </label>
                                                </td>

                                                <td><label class="">
                                                        <input type="radio" class="radio-btn-active" name="features_shared" <?php
if (isset($property->disclosure)) {
    if ($property->disclosure->features_shared == config('constant.inverse_property_condition_disclaimer.NA')) {
        ?>
                                                                       checked="checked"
        <?php
    }
}
?>id="features_sharedNA" value="{{config('constant.inverse_property_condition_disclaimer.NA')}}">
                                                        <label for="features_sharedNA"></label>
                                                    </label>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>3. Any authorized changes in roads, drainage or utilities affecting the property, or contiguous to the property?</td>
                                                <td>
                                                    <input type="radio" name="any_authorized_changes" id="any_authorized_changesyes"<?php
if (isset($property->disclosure)) {
    if ($property->disclosure->any_authorized_changes == config('constant.inverse_property_condition_disclaimer.Yes')) {
        ?>
                                                                   checked="checked"
        <?php
    }
}
?> value="{{config('constant.inverse_property_condition_disclaimer.Yes')}}">
                                                    <label for="any_authorized_changesyes"></label>
                                                </td>

                                                <td><label class="">
                                                        <input type="radio" name="any_authorized_changes" id="any_authorized_changesNo"<?php
                                                           if (isset($property->disclosure)) {
                                                               if ($property->disclosure->any_authorized_changes == config('constant.inverse_property_condition_disclaimer.No')) {
                                                                   ?>
                                                                       checked="checked"
        <?php
    }
}
?> value="{{config('constant.inverse_property_condition_disclaimer.No')}}">
                                                        <label for="any_authorized_changesNo"></label>
                                                    </label>
                                                </td>
                                                <td><label class="">
                                                        <input type="radio" class="radio-btn-active" name="any_authorized_changes" <?php
                                                               if (isset($property->disclosure)) {
                                                                   if ($property->disclosure->any_authorized_changes == config('constant.inverse_property_condition_disclaimer.NA')) {
                                                                       ?>
                                                                       checked="checked"
        <?php
    }
}
?>id="any_authorized_changesNA" value="{{config('constant.inverse_property_condition_disclaimer.NA')}}">
                                                        <label for="any_authorized_changesNA"></label>
                                                    </label>
                                                </td>
                                            </tr>
                                            <tr>
                                            <tr>
                                                <td>4. Any changes since the most recent survey of the property was done? (Most recent survey of property:
                                                    <input type="text" class="readonly" id="text-form-input"  name="most_recent_survey" value="{{$property->disclosure->most_recent_survey??""}}">
                                                    )</td>
                                                <td>
                                                    <input type="radio" name="any_change_since_latest_survey" id="surveyyes" <?php
                                                        if (isset($property->disclosure)) {
                                                            if ($property->disclosure->any_change_since_latest_survey == config('constant.inverse_property_condition_disclaimer.Yes')) {
                                                                ?>
                                                                   checked="checked"
        <?php
    }
}
?>value="{{config('constant.inverse_property_condition_disclaimer.Yes')}}">
                                                    <label for="surveyyes"></label>
                                                </td>
                                                <td><label class="">
                                                        <input type="radio" name="any_change_since_latest_survey" id="surveyNo" <?php
                                                           if (isset($property->disclosure)) {
                                                               if ($property->disclosure->any_change_since_latest_survey == config('constant.inverse_property_condition_disclaimer.No')) {
                                                                   ?>
                                                                       checked="checked"
        <?php
    }
}
?>value="{{config('constant.inverse_property_condition_disclaimer.No')}}">
                                                        <label for="surveyNo"></label>
                                                    </label>
                                                </td>
                                                <td><label class="">
                                                        <input type="radio" class="radio-btn-active" name="any_change_since_latest_survey"<?php
                                                               if (isset($property->disclosure)) {
                                                                   if ($property->disclosure->any_change_since_latest_survey == config('constant.inverse_property_condition_disclaimer.NA')) {
                                                                       ?>
                                                                       checked="checked"
        <?php
    }
}
?> id="surveyNA" value="{{config('constant.inverse_property_condition_disclaimer.NA')}}">
                                                        <label for="surveyNA"></label>
                                                    </label>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>5. Any encroachments, easements, or similar items that may affect your ownership interest in the property?</td>
                                                <td>
                                                    <input type="radio" name="any_encroachments" id="any_encroachmentsyes" <?php
                                                               if (isset($property->disclosure)) {
                                                                   if ($property->disclosure->any_encroachments == config('constant.inverse_property_condition_disclaimer.Yes')) {
                                                                       ?>
                                                                   checked="checked"
        <?php
    }
}
?>value="{{config('constant.inverse_property_condition_disclaimer.Yes')}}">
                                                    <label for="any_encroachmentsyes"></label>
                                                </td>
                                                <td><label class="">
                                                        <input type="radio" name="any_encroachments" id="any_encroachmentsNo" <?php
                                                    if (isset($property->disclosure)) {
                                                        if ($property->disclosure->any_encroachments == config('constant.inverse_property_condition_disclaimer.No')) {
                                                            ?>
                                                                       checked="checked"
                                                                   <?php
                                                               }
                                                           }
                                                           ?>value="{{config('constant.inverse_property_condition_disclaimer.No')}}">
                                                        <label for="any_encroachmentsNo"></label>
                                                    </label>
                                                </td>
                                                <td><label class="">
                                                        <input type="radio" class="radio-btn-active" name="any_encroachments" <?php
                                                        if (isset($property->disclosure)) {
                                                            if ($property->disclosure->any_encroachments == config('constant.inverse_property_condition_disclaimer.NA')) {
                                                                ?>
                                                                       checked="checked"
                                                                       <?php
                                                                   }
                                                               }
                                                               ?>id="any_encroachmentsNA" value="{{config('constant.inverse_property_condition_disclaimer.NA')}}">
                                                        <label for="any_encroachmentsNA"></label>
                                                    </label>
                                                </td>
                                            </tr>
                                        <td>6. Room additions, structural modifications or other alterations or repairs made without necessary permits?</td>
                                        <td>
                                            <input type="radio" name="repairs" id="repairsyes" <?php
                                                        if (isset($property->disclosure)) {
                                                            if ($property->disclosure->repairs == config('constant.inverse_property_condition_disclaimer.Yes')) {
                                                                ?>
                                                           checked="checked"
                                                                       <?php
                                                                   }
                                                               }
                                                               ?>value="{{config('constant.inverse_property_condition_disclaimer.Yes')}}">
                                            <label for="repairsyes"></label>
                                        </td>
                                        <td><label class="">
                                                <input type="radio" name="repairs" id="repairsNo" <?php
                                                               if (isset($property->disclosure)) {
                                                                   if ($property->disclosure->repairs == config('constant.inverse_property_condition_disclaimer.No')) {
                                                                       ?>
                                                               checked="checked"
        <?php
    }
}
?>value="{{config('constant.inverse_property_condition_disclaimer.No')}}">
                                                <label for="repairsNo"></label>
                                            </label>
                                        </td>
                                        <td><label class="">
                                                <input type="radio" class="radio-btn-active" name="repairs" <?php
                                                           if (isset($property->disclosure)) {
                                                               if ($property->disclosure->repairs == config('constant.inverse_property_condition_disclaimer.NA')) {
                                                                   ?>
                                                               checked="checked"
        <?php
    }
}
?>id="repairsNA" value="{{config('constant.inverse_property_condition_disclaimer.NA')}}">
                                                <label for="repairsNA"></label>
                                            </label>
                                        </td>
                                        </tr>
                                        <tr>
                                            <td>7. Room additions, structural modifications, other alterations or repairs not in compliance with building codes?</td>
                                            <td>
                                                <input type="radio" name="repairs_with_building_codes" <?php
                                                        if (isset($property->disclosure)) {
                                                            if ($property->disclosure->repairs_with_building_codes == config('constant.inverse_property_condition_disclaimer.Yes')) {
                                                                ?>
                                                               checked="checked"
                                                                <?php
                                                            }
                                                        }
                                                        ?>id="buildingyes" value="{{config('constant.inverse_property_condition_disclaimer.Yes')}}">
                                                <label for="buildingyes"></label>
                                            </td>
                                            <td><label class="">
                                                    <input type="radio" name="repairs_with_building_codes" <?php
                                                               if (isset($property->disclosure)) {
                                                                   if ($property->disclosure->repairs_with_building_codes == config('constant.inverse_property_condition_disclaimer.No')) {
                                                                       ?>
                                                                   checked="checked"
        <?php
    }
}
?>id="buildingNo" value="{{config('constant.inverse_property_condition_disclaimer.No')}}">
                                                    <label for="buildingNo"></label>
                                                </label>
                                            </td>
                                            <td><label class="">
                                                    <input type="radio" class="radio-btn-active" <?php
if (isset($property->disclosure)) {
    if ($property->disclosure->repairs_with_building_codes == config('constant.inverse_property_condition_disclaimer.NA')) {
        ?>
                                                                   checked="checked"
                                                                   <?php
                                                               }
                                                           }
                                                           ?>name="repairs_with_building_codes" id="buildingNA" value="{{config('constant.inverse_property_condition_disclaimer.NA')}}">
                                                    <label for="buildingNA"></label>
                                                </label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>8. Landfill (compacted or otherwise) on the property or any portion thereof?</td>
                                            <td>
                                                <input type="radio" name="landfill" id="landfillyes" <?php
                                                               if (isset($property->disclosure)) {
                                                                   if ($property->disclosure->land_fill == config('constant.inverse_property_condition_disclaimer.Yes')) {
                                                                       ?>
                                                               checked="checked"
        <?php
    }
}
?>value="{{config('constant.inverse_property_condition_disclaimer.Yes')}}">
                                                <label for="landfillyes"></label>
                                            </td>
                                            <td><label class="">
                                                    <input type="radio" name="landfill" id="landfillNo" <?php
                                                               if (isset($property->disclosure)) {
                                                                   if ($property->disclosure->land_fill == config('constant.inverse_property_condition_disclaimer.No')) {
                                                                       ?>
                                                                   checked="checked"
        <?php
    }
}
?>value="{{config('constant.inverse_property_condition_disclaimer.No')}}">
                                                    <label for="landfillNo"></label>
                                                </label>
                                            </td>
                                            <td><label class="">
                                                    <input type="radio" class="radio-btn-active" name="landfill" <?php
                                            if (isset($property->disclosure)) {
                                                if ($property->disclosure->land_fill == config('constant.inverse_property_condition_disclaimer.NA')) {
                                                    ?>
                                                                   checked="checked"
                                                           <?php
                                                       }
                                                   }
                                                   ?>id="landfillNA" value="{{config('constant.inverse_property_condition_disclaimer.NA')}}">
                                                    <label for="landfillNA"></label>
                                                </label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>9. Any settling from any cause, or slippage, sliding or other soil problems?</td>
                                            <td>
                                                <input type="radio" name="any_settling" id="settlingyes" <?php
                                                       if (isset($property->disclosure)) {
                                                           if ($property->disclosure->any_settling == config('constant.inverse_property_condition_disclaimer.Yes')) {
                                                               ?>
                                                               checked="checked"
        <?php
    }
}
?>value="{{config('constant.inverse_property_condition_disclaimer.Yes')}}">
                                                <label for="settlingyes"></label>
                                            </td>
                                            <td><label class="">
                                                    <input type="radio" name="any_settling" id="settlingNo" <?php
                                                if (isset($property->disclosure)) {
                                                    if ($property->disclosure->any_settling == config('constant.inverse_property_condition_disclaimer.No')) {
                                                        ?>
                                                                   checked="checked"
                                                               <?php
                                                           }
                                                       }
                                                       ?>value="{{config('constant.inverse_property_condition_disclaimer.No')}}">
                                                    <label for="settlingNo"></label>
                                                </label>
                                            </td>
                                            <td><label class="">
                                                    <input type="radio" class="radio-btn-active" name="any_settling" <?php
                                                       if (isset($property->disclosure)) {
                                                           if ($property->disclosure->any_settling == config('constant.inverse_property_condition_disclaimer.NA')) {
                                                               ?>
                                                                   checked="checked"
                                                        <?php
                                                    }
                                                }
                                                ?>id="settlingNA" value="{{config('constant.inverse_property_condition_disclaimer.NA')}}">
                                                    <label for="settlingNA"></label>
                                                </label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>10. Flooding, drainage or grading problems?</td>
                                            <td>
                                                <input type="radio" name="problems" id="problemsyes" <?php
                                                    if (isset($property->disclosure)) {
                                                        if ($property->disclosure->problems == config('constant.inverse_property_condition_disclaimer.Yes')) {
                                                            ?>
                                                               checked="checked"
                                                                   <?php
                                                               }
                                                           }
                                                           ?>value="{{config('constant.inverse_property_condition_disclaimer.Yes')}}">
                                                <label for="problemsyes"></label>
                                            </td>
                                            <td><label class="">
                                                    <input type="radio" name="problems" id="problemsNo" <?php
                                                    if (isset($property->disclosure)) {
                                                        if ($property->disclosure->problems == config('constant.inverse_property_condition_disclaimer.No')) {
                                                            ?>
                                                                   checked="checked"
                                                                   <?php
                                                               }
                                                           }
                                                           ?>value="{{config('constant.inverse_property_condition_disclaimer.No')}}">
                                                    <label for="problemsNo"></label>
                                                </label>
                                            </td>
                                            <td><label class="">
                                                    <input type="radio" class="radio-btn-active" <?php
                                                           if (isset($property->disclosure)) {
                                                               if ($property->disclosure->problems == config('constant.inverse_property_condition_disclaimer.NA')) {
                                                                   ?>
                                                                   checked="checked"
                                                        <?php
                                                    }
                                                }
                                                ?>name="problems" id="problemsNA" value="{{config('constant.inverse_property_condition_disclaimer.NA')}}">
                                                    <label for="problemsNA"></label>
                                                </label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>11. Any requirement that flood insurance be maintained on the property?</td>
                                            <td>
                                                <input type="radio" name="requirement" id="requirementyes" <?php
                                                if (isset($property->disclosure)) {
                                                    if ($property->disclosure->requirement == config('constant.inverse_property_condition_disclaimer.Yes')) {
                                                        ?>
                                                               checked="checked"
                                                            <?php
                                                        }
                                                    }
                                                    ?>value="{{config('constant.inverse_property_condition_disclaimer.Yes')}}">
                                                <label for="requirementyes"></label>
                                            </td>
                                            <td><label class="">
                                                    <input type="radio" name="requirement" id="requirementNo" <?php
                                                           if (isset($property->disclosure)) {
                                                               if ($property->disclosure->requirement == config('constant.inverse_property_condition_disclaimer.No')) {
                                                                   ?>
                                                                   checked="checked"
                                                            <?php
                                                        }
                                                    }
                                                    ?>value="{{config('constant.inverse_property_condition_disclaimer.No')}}">
                                                    <label for="requirementNo"></label>
                                                </label>
                                            </td>
                                            <td><label class="">
                                                    <input type="radio" class="radio-btn-active" name="requirement" <?php
                                                    if (isset($property->disclosure)) {
                                                        if ($property->disclosure->requirement == config('constant.inverse_property_condition_disclaimer.NA')) {
                                                            ?>
                                                                   checked="checked"
        <?php
    }
}
?>id="requirementNA" value="{{config('constant.inverse_property_condition_disclaimer.NA')}}">
                                                    <label for="requirementNA"></label>
                                                </label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>12. Any of the property located in a designated flood hazard area?</td>
                                            <td>
                                                <input type="radio" name="location" id="locationyes"<?php
                                                if (isset($property->disclosure)) {
                                                    if ($property->disclosure->location == config('constant.inverse_property_condition_disclaimer.Yes')) {
                                                        ?>
                                                               checked="checked"
                                                            <?php
                                                        }
                                                    }
                                                    ?> value="{{config('constant.inverse_property_condition_disclaimer.Yes')}}">
                                                <label for="locationyes"></label>
                                            </td>
                                            <td><label class="">
                                                    <input type="radio" name="location" id="locationNo"<?php
                                                           if (isset($property->disclosure)) {
                                                               if ($property->disclosure->location == config('constant.inverse_property_condition_disclaimer.No')) {
                                                                   ?>
                                                                   checked="checked"
        <?php
    }
}
?> value="{{config('constant.inverse_property_condition_disclaimer.No')}}">
                                                    <label for="locationNo"></label>
                                                </label>
                                            </td>
                                            <td><label class="">
                                                    <input type="radio" class="radio-btn-active" name="location"<?php
                                                           if (isset($property->disclosure)) {
                                                               if ($property->disclosure->location == config('constant.inverse_property_condition_disclaimer.NA')) {
                                                                   ?>
                                                                   checked="checked"
        <?php
    }
}
?> id="locationNA" value="{{config('constant.inverse_property_condition_disclaimer.NA')}}">
                                                    <label for="locationNA"></label>
                                                </label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>13. Any past or present interior water intrusions(s), standing water within foundation and/or basement?</td>
                                            <td>
                                                <input type="radio" name="interior" id="interioryes" <?php
                                                       if (isset($property->disclosure)) {
                                                           if ($property->disclosure->interior == config('constant.inverse_property_condition_disclaimer.Yes')) {
                                                               ?>
                                                               checked="checked"
        <?php
    }
}
?> value="{{config('constant.inverse_property_condition_disclaimer.Yes')}}">
                                                <label for="interioryes"></label>
                                            </td>
                                            <td><label class="">
                                                    <input type="radio" name="interior" id="interiorNo" <?php
                                                           if (isset($property->disclosure)) {
                                                               if ($property->disclosure->interior == config('constant.inverse_property_condition_disclaimer.No')) {
                                                                   ?>
                                                                   checked="checked"
        <?php
    }
}
?>value="{{config('constant.inverse_property_condition_disclaimer.No')}}">
                                                    <label for="interiorNo"></label>
                                                </label>
                                            </td>
                                            <td><label class="">
                                                    <input type="radio" class="radio-btn-active" name="interior" <?php
if (isset($property->disclosure)) {
    if ($property->disclosure->interior == config('constant.inverse_property_condition_disclaimer.NA')) {
        ?>
                                                                   checked="checked"
                                                                   <?php
                                                               }
                                                           }
                                                           ?>id="interiorNA" value="{{config('constant.inverse_property_condition_disclaimer.NA')}}">
                                                    <label for="interiorNA"></label>
                                                </label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>14. Property or structural damage from fire, earthquake, floods, landslides, tremors, wind, storm, or wood
                                                destroying organisms (such as termites, mold, etc.)?</td>
                                            <td>
                                                <input type="radio" name="structural_damage" id="structural_damageyes" <?php
                                                           if (isset($property->disclosure)) {
                                                               if ($property->disclosure->structural_damage == config('constant.inverse_property_condition_disclaimer.Yes')) {
                                                                   ?>
                                                               checked="checked"
                                                               <?php
                                                           }
                                                       }
                                                       ?>value="{{config('constant.inverse_property_condition_disclaimer.Yes')}}">
                                                <label for="structural_damageyes"></label>
                                            </td>
                                            <td><label class="">
                                                    <input type="radio" name="structural_damage" id="structural_damageNo"<?php
                                                    if (isset($property->disclosure)) {
                                                        if ($property->disclosure->structural_damage == config('constant.inverse_property_condition_disclaimer.No')) {
                                                            ?>
                                                                   checked="checked"
                                                                   <?php
                                                               }
                                                           }
                                                           ?> value="{{config('constant.inverse_property_condition_disclaimer.No')}}">
                                                    <label for="structural_damageNo"></label>
                                                </label>
                                            </td>
                                            <td><label class="">
                                                    <input type="radio" class="radio-btn-active" name="structural_damage" <?php
                                                    if (isset($property->disclosure)) {
                                                        if ($property->disclosure->structural_damage == config('constant.inverse_property_condition_disclaimer.NA')) {
                                                            ?>
                                                                   checked="checked"
                                                                   <?php
                                                               }
                                                           }
                                                           ?>id="structural_damageNA" value="{{config('constant.inverse_property_condition_disclaimer.NA')}}">
                                                    <label for="structural_damageNA"></label>
                                                </label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>15. Any zoning violations, nonconforming uses and/or violations of "setback" requirements?</td>
                                            <td>
                                                <input type="radio" name="any_zoning_violations" id="any_zoning_violationsyes" <?php
                                                if (isset($property->disclosure)) {
                                                    if ($property->disclosure->any_zoning_violations == config('constant.inverse_property_condition_disclaimer.Yes')) {
                                                        ?>
                                                               checked="checked"
                                                               <?php
                                                           }
                                                       }
                                                       ?>value="{{config('constant.inverse_property_condition_disclaimer.Yes')}}">
                                                <label for="any_zoning_violationsyes"></label>
                                            </td>
                                            <td><label class="">
                                                    <input type="radio" name="any_zoning_violations" id="any_zoning_violationsNo" <?php
                                                    if (isset($property->disclosure)) {
                                                        if ($property->disclosure->any_zoning_violations == config('constant.inverse_property_condition_disclaimer.No')) {
                                                            ?>
                                                                   checked="checked"
                                                                   <?php
                                                               }
                                                           }
                                                           ?>value="{{config('constant.inverse_property_condition_disclaimer.No')}}">
                                                    <label for="any_zoning_violationsNo"></label>
                                                </label>
                                            </td>
                                            <td><label class="">
                                                    <input type="radio" class="radio-btn-active" name="any_zoning_violations" <?php
                                                           if (isset($property->disclosure)) {
                                                               if ($property->disclosure->any_zoning_violations == config('constant.inverse_property_condition_disclaimer.NA')) {
                                                                   ?>
                                                                   checked="checked"
                                                            <?php
                                                        }
                                                    }
                                                    ?>id="any_zoning_violationsNA" value="{{config('constant.inverse_property_condition_disclaimer.NA')}}">
                                                    <label for="any_zoning_violationsNA"></label>
                                                </label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>16. Neighborhood noise problems or other nuisances?</td>
                                            <td>
                                                <input type="radio" name="neighborhood_noise" id="neighborhood_noiseyes" <?php
                                                           if (isset($property->disclosure)) {
                                                               if ($property->disclosure->neighborhood_noise == config('constant.inverse_property_condition_disclaimer.Yes')) {
                                                            ?>
                                                               checked="checked"
                                                        <?php
                                                    }
                                                }
                                                ?>value="{{config('constant.inverse_property_condition_disclaimer.Yes')}}">
                                                <label for="neighborhood_noiseyes"></label>
                                            </td>
                                            <td><label class="">
                                                    <input type="radio" name="neighborhood_noise" id="neighborhood_noiseNo" <?php
                                                       if (isset($property->disclosure)) {
                                                           if ($property->disclosure->neighborhood_noise == config('constant.inverse_property_condition_disclaimer.No')) {
                                                               ?>
                                                                   checked="checked"
                                                            <?php
                                                        }
                                                    }
                                                    ?>value="{{config('constant.inverse_property_condition_disclaimer.No')}}">
                                                    <label for="neighborhood_noiseNo"></label>
                                                </label>
                                            </td>
                                            <td><label class="">
                                                    <input type="radio" class="radio-btn-active" name="neighborhood_noise"<?php
                                                    if (isset($property->disclosure)) {
                                                        if ($property->disclosure->neighborhood_noise == config('constant.inverse_property_condition_disclaimer.NA')) {
                                                            ?>
                                                                   checked="checked"
                                                            <?php
                                                        }
                                                    }
                                                    ?> id="neighborhood_noiseNA" value="{{config('constant.inverse_property_condition_disclaimer.NA')}}">
                                                    <label for="neighborhood_noiseNA"></label>
                                                </label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>17. Subdivision and/or deed restrictions or obligations?</td>
                                            <td>
                                                <input type="radio" name="restrictions" id="restrictionsyes" <?php
                                                    if (isset($property->disclosure)) {
                                                        if ($property->disclosure->restrictions == config('constant.inverse_property_condition_disclaimer.Yes')) {
                                                            ?>
                                                               checked="checked"
        <?php
    }
}
?>value="{{config('constant.inverse_property_condition_disclaimer.Yes')}}">
                                                <label for="restrictionsyes"></label>
                                            </td>
                                            <td><label class="">
                                                    <input type="radio" name="restrictions" id="restrictionsNo" <?php
                                                       if (isset($property->disclosure)) {
                                                           if ($property->disclosure->restrictions == config('constant.inverse_property_condition_disclaimer.No')) {
                                                               ?>
                                                                   checked="checked"
        <?php
    }
}
?>value="{{config('constant.inverse_property_condition_disclaimer.No')}}">
                                                    <label for="restrictionsNo"></label>
                                                </label>
                                            </td>

                                            <td><label class="">
                                                    <input type="radio" class="radio-btn-active" name="restrictions" <?php
                                                           if (isset($property->disclosure)) {
                                                               if ($property->disclosure->restrictions == config('constant.inverse_property_condition_disclaimer.NA')) {
                                                                   ?>
                                                                   checked="checked"
        <?php
    }
}
?>id="restrictionsNA" value="{{config('constant.inverse_property_condition_disclaimer.NA')}}">
                                                    <label for="restrictionsNA"></label>
                                                </label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>18. Any "common area" (pools, tennis courts, walkways, etc), co-owned in undivided interest with others?</td>
                                            <td>
                                                <input type="radio" name="any_common_area" id="any_common_areayes" <?php
                                                    if (isset($property->disclosure)) {
                                                        if ($property->disclosure->any_common_area == config('constant.inverse_property_condition_disclaimer.Yes')) {
                                                            ?>
                                                               checked="checked"
        <?php
    }
}
?>value="{{config('constant.inverse_property_condition_disclaimer.Yes')}}">
                                                <label for="any_common_areayes"></label>
                                            </td>
                                            <td><label class="">
                                                    <input type="radio" name="any_common_area" id="any_common_areaNo" <?php
if (isset($property->disclosure)) {
    if ($property->disclosure->any_common_area == config('constant.inverse_property_condition_disclaimer.No')) {
        ?>
                                                                   checked="checked"
                                                               <?php
                                                           }
                                                       }
                                                       ?>value="{{config('constant.inverse_property_condition_disclaimer.No')}}">
                                                    <label for="any_common_areaNo"></label>
                                                </label>
                                            </td>
                                            <td><label class="">
                                                    <input type="radio" class="radio-btn-active" name="any_common_area"<?php
                                                       if (isset($property->disclosure)) {
                                                           if ($property->disclosure->any_common_area == config('constant.inverse_property_condition_disclaimer.NA')) {
                                                               ?>
                                                                   checked="checked"
                                                                   <?php
                                                               }
                                                           }
                                                           ?> id="any_common_areaNA" value="{{config('constant.inverse_property_condition_disclaimer.NA')}}">
                                                    <label for="any_common_areaNA"></label>
                                                </label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>19. Any notices of abatement or citations against the property?</td>
                                            <td>
                                                <input type="radio" name="any_notices" id="any_noticesyes" <?php
                                                           if (isset($property->disclosure)) {
                                                               if ($property->disclosure->any_notices == config('constant.inverse_property_condition_disclaimer.Yes')) {
                                                                   ?>
                                                               checked="checked"
        <?php
    }
}
?>value="{{config('constant.inverse_property_condition_disclaimer.Yes')}}">
                                                <label for="any_noticesyes"></label>
                                            </td>
                                            <td><label class="">
                                                    <input type="radio" name="any_notices" id="any_noticesNo" <?php
                                                if (isset($property->disclosure)) {
                                                    if ($property->disclosure->any_notices == config('constant.inverse_property_condition_disclaimer.No')) {
                                                        ?>
                                                                   checked="checked"
                                                               <?php
                                                           }
                                                       }
                                                       ?>value="{{config('constant.inverse_property_condition_disclaimer.No')}}">
                                                    <label for="any_noticesNo"></label>
                                                </label>
                                            </td>
                                            <td><label class="">
                                                    <input type="radio" class="radio-btn-active" name="any_notices" <?php
                                                    if (isset($property->disclosure)) {
                                                        if ($property->disclosure->any_notices == config('constant.inverse_property_condition_disclaimer.NA')) {
                                                            ?>
                                                                   checked="checked"
                                                                   <?php
                                                               }
                                                           }
                                                           ?>id="any_noticesNA" value="{{config('constant.inverse_property_condition_disclaimer.NA')}}">
                                                    <label for="any_noticesNA"></label>
                                                </label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>20. Any lawsuit(s) or proposed lawsuit(s) by or against the seller which affects or will affect the property?</td>
                                            <td>
                                                <input type="radio" name="any_lawsuit" id="any_lawsuityes" <?php
                                                    if (isset($property->disclosure)) {
                                                        if ($property->disclosure->any_lawsuit == config('constant.inverse_property_condition_disclaimer.Yes')) {
                                                            ?>
                                                               checked="checked"
                                                                   <?php
                                                               }
                                                           }
                                                           ?>value="{{config('constant.inverse_property_condition_disclaimer.Yes')}}">
                                                <label for="any_lawsuityes"></label>
                                            </td>
                                            <td><label class="">
                                                    <input type="radio" name="any_lawsuit" id="any_lawsuitNo" <?php
                                                           if (isset($property->disclosure)) {
                                                               if ($property->disclosure->any_lawsuit == config('constant.inverse_property_condition_disclaimer.No')) {
                                                                   ?>
                                                                   checked="checked"
                                                        <?php
                                                    }
                                                }
                                                ?>value="{{config('constant.inverse_property_condition_disclaimer.No')}}">
                                                    <label for="any_lawsuitNo"></label>
                                                </label>
                                            </td>
                                            <td><label class="">
                                                    <input type="radio" class="radio-btn-active" name="any_lawsuit" <?php
                                                       if (isset($property->disclosure)) {
                                                           if ($property->disclosure->any_lawsuit == config('constant.inverse_property_condition_disclaimer.NA')) {
                                                        ?>
                                                                   checked="checked"
                                                            <?php
                                                        }
                                                    }
                                                    ?>id="any_lawsuitNA" value="{{config('constant.inverse_property_condition_disclaimer.NA')}}">
                                                    <label for="any_lawsuitNA"></label>
                                                </label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>21. Any system, equipment or part of the property that is being leased? (e.g. security system, water softener,
                                                satellite dish, etc.) Lease payoffs or assumptions should be addressed in the purchase contract.</td>
                                            <td>
                                                <input type="radio" name="any_system" id="any_systemyes" <?php
                                                    if (isset($property->disclosure)) {
                                                        if ($property->disclosure->any_system == config('constant.inverse_property_condition_disclaimer.Yes')) {
                                                            ?>
                                                               checked="checked"
                                                                   <?php
                                                               }
                                                           }
                                                           ?>value="{{config('constant.inverse_property_condition_disclaimer.Yes')}}">
                                                <label for="any_systemyes"></label>
                                            </td>
                                            <td><label class="">
                                                    <input type="radio" name="any_system" id="any_systemNo" <?php
                                                           if (isset($property->disclosure)) {
                                                               if ($property->disclosure->any_system == config('constant.inverse_property_condition_disclaimer.No')) {
                                                                   ?>
                                                                   checked="checked"
                                                        <?php
                                                    }
                                                }
                                                ?>value="{{config('constant.inverse_property_condition_disclaimer.No')}}">
                                                    <label for="any_systemNo"></label>
                                                </label>
                                            </td>
                                            <td><label class="">
                                                    <input type="radio" class="radio-btn-active" name="any_system" <?php
                                                       if (isset($property->disclosure)) {
                                                           if ($property->disclosure->any_system == config('constant.inverse_property_condition_disclaimer.NA')) {
                                                               ?>
                                                                   checked="checked"
                                                            <?php
                                                        }
                                                    }
                                                    ?>id="any_systemNA" value="{{config('constant.inverse_property_condition_disclaimer.NA')}}">
                                                    <label for="any_systemNA"></label>
                                                </label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>22. Any exterior wall covered with exterior insulation and finish systems (EIFS, or synthetic stucco)?
                                                If yes, has there been a recent inspection to determine whether the structure has excessive moisture
                                                accumulation and/or moisture related damage?  [explain below]</td>
                                            <td>
                                                <input type="radio" name="any_exterior" id="any_exterioryes" <?php
                                                    if (isset($property->disclosure)) {
                                                        if ($property->disclosure->any_exterior == config('constant.inverse_property_condition_disclaimer.Yes')) {
                                                            ?>
                                                               checked="checked"
                                                            <?php
                                                        }
                                                    }
                                                    ?>value="{{config('constant.inverse_property_condition_disclaimer.Yes')}}">
                                                <label for="any_exterioryes"></label>
                                            </td>
                                            <td><label class="">
                                                    <input type="radio" name="any_exterior" id="any_exteriorNo" <?php
                                                           if (isset($property->disclosure)) {
                                                               if ($property->disclosure->any_exterior == config('constant.inverse_property_condition_disclaimer.No')) {
                                                                   ?>
                                                                   checked="checked"
        <?php
    }
}
?>value="{{config('constant.inverse_property_condition_disclaimer.No')}}">
                                                    <label for="any_exteriorNo"></label>
                                                </label>
                                            </td>
                                            <td><label class="">
                                                    <input type="radio" class="radio-btn-active" name="any_exterior" <?php
                                                       if (isset($property->disclosure)) {
                                                           if ($property->disclosure->any_exterior == config('constant.inverse_property_condition_disclaimer.NA')) {
                                                               ?>
                                                                   checked="checked"
        <?php
    }
}
?>id="any_exteriorNA" value="{{config('constant.inverse_property_condition_disclaimer.NA')}}">
                                                    <label for="any_exteriorNA"></label>
                                                </label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>23. Any finished rooms that are not supplied with heating and air conditioning?</td>
                                            <td>
                                                <input type="radio" name="any_finished_rooms" id="any_finished_roomsyes" <?php
                                                    if (isset($property->disclosure)) {
                                                        if ($property->disclosure->any_finished_rooms == config('constant.inverse_property_condition_disclaimer.Yes')) {
                                                            ?>
                                                               checked="checked"
                                                            <?php
                                                        }
                                                    }
                                                    ?>value="{{config('constant.inverse_property_condition_disclaimer.Yes')}}">
                                                <label for="any_finished_roomsyes"></label>
                                            </td>
                                            <td><label class="">
                                                    <input type="radio" name="any_finished_rooms" id="any_finished_roomsNo" <?php
                                                           if (isset($property->disclosure)) {
                                                               if ($property->disclosure->any_finished_rooms == config('constant.inverse_property_condition_disclaimer.No')) {
                                                                   ?>
                                                                   checked="checked"
        <?php
    }
}
?>value="{{config('constant.inverse_property_condition_disclaimer.No')}}">
                                                    <label for="any_finished_roomsNo"></label>
                                                </label>
                                            </td>
                                            <td><label class="">
                                                    <input type="radio" class="radio-btn-active" name="any_finished_rooms" <?php
if (isset($property->disclosure)) {
    if ($property->disclosure->any_finished_rooms == config('constant.inverse_property_condition_disclaimer.NA')) {
        ?>
                                                                   checked="checked"
                                                               <?php
                                                           }
                                                       }
                                                       ?>id="any_finished_roomsNA" value="{{config('constant.inverse_property_condition_disclaimer.NA')}}">
                                                    <label for="any_finished_roomsNA"></label>
                                                </label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>24. Any septic tank or other private disposal system that does not have adequate capacity and approved design
                                                to comply with present stateand local requirements for the actual land area and number of bedrooms?
                                                If residence is on a septic system, the septic system is legally permitted for
                                                <input type="number" class="readonly" id="text-form-input" min="0" name="septic_tank_for_bedrooms" value="{{$property->disclosure->septic_tank_for_bedrooms??""}}">
                                                number of bedrooms.</td>
                                            <td>
                                                <input type="radio" name="any_septic_tank" id="any_septic_tankyes" <?php
                                                       if (isset($property->disclosure)) {
                                                           if ($property->disclosure->any_septic_tank == config('constant.inverse_property_condition_disclaimer.Yes')) {
                                                               ?>
                                                               checked="checked"
                                                            <?php
                                                        }
                                                    }
                                                    ?>value="{{config('constant.inverse_property_condition_disclaimer.Yes')}}">
                                                <label for="any_septic_tankyes"></label>
                                            </td>
                                            <td><label class="">
                                                    <input type="radio" name="any_septic_tank" id="any_septic_tankNo" <?php
                                                    if (isset($property->disclosure)) {
                                                        if ($property->disclosure->any_septic_tank == config('constant.inverse_property_condition_disclaimer.No')) {
                                                            ?>
                                                                   checked="checked"
        <?php
    }
}
?>value="{{config('constant.inverse_property_condition_disclaimer.No')}}">
                                                    <label for="any_septic_tankNo"></label>
                                                </label>
                                            </td>
                                            <td><label class="">
                                                    <input type="radio" class="radio-btn-active" name="any_septic_tank" <?php
if (isset($property->disclosure)) {
    if ($property->disclosure->any_septic_tank == config('constant.inverse_property_condition_disclaimer.NA')) {
        ?>
                                                                   checked="checked"
                                                               <?php
                                                           }
                                                       }
                                                       ?>id="any_septic_tankNA" value="{{config('constant.inverse_property_condition_disclaimer.NA')}}">
                                                    <label for="any_septic_tankNA"></label>
                                                </label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>25. The property is affected by covenants, conditions, restrictions (CCR's), or Home Owner Association by-laws requiring approval for changes, use, or alterations to the property?</td>
                                            <td>
                                                <input type="radio" name="affected" id="affectedyes" <?php
                                                           if (isset($property->disclosure)) {
                                                               if ($property->disclosure->affected == config('constant.inverse_property_condition_disclaimer.Yes')) {
                                                                   ?>
                                                               checked="checked"
        <?php
    }
}
?>value="{{config('constant.inverse_property_condition_disclaimer.Yes')}}">
                                                <label for="affectedyes"></label>
                                            </td>
                                            <td><label class="">
                                                    <input type="radio" name="affected" id="affectedNo" <?php
                                                           if (isset($property->disclosure)) {
                                                               if ($property->disclosure->affected == config('constant.inverse_property_condition_disclaimer.No')) {
                                                                   ?>
                                                                   checked="checked"
        <?php
    }
}
?>value="{{config('constant.inverse_property_condition_disclaimer.No')}}">
                                                    <label for="affectedNo"></label>
                                                </label>
                                            </td>
                                            <td><label class="">
                                                    <input type="radio" class="radio-btn-active" name="affected" id="affectedNA" <?php
if (isset($property->disclosure)) {
    if ($property->disclosure->affected == config('constant.inverse_property_condition_disclaimer.NA')) {
        ?>
                                                                   checked="checked"
                                                        <?php
                                                    }
                                                }
                                                ?>value="{{config('constant.inverse_property_condition_disclaimer.NA')}}">
                                                    <label for="affectedNA"></label>
                                                </label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>26. The property is in an historical district or has been declared historical bya governmental authority and
                                                permission must be obtained before certain improvements or aesthetic changes to the property are made?</td>
                                            <td>
                                                <input type="radio" name="in_an_historical_district"  id="in_an_historical_districtyes" <?php
                                                    if (isset($property->disclosure)) {
                                                        if ($property->disclosure->in_an_historical_district == config('constant.inverse_property_condition_disclaimer.Yes')) {
                                                            ?>
                                                               checked="checked"
                                                                   <?php
                                                               }
                                                           }
                                                           ?>value="{{config('constant.inverse_property_condition_disclaimer.Yes')}}">
                                                <label for="in_an_historical_districtyes"></label>
                                            </td>

                                            <td><label class="">
                                                    <input type="radio" name="in_an_historical_district" id="in_an_historical_districtNo" <?php
                                                    if (isset($property->disclosure)) {
                                                        if ($property->disclosure->in_an_historical_district == config('constant.inverse_property_condition_disclaimer.No')) {
                                                            ?>
                                                                   checked="checked"
                                                                   <?php
                                                               }
                                                           }
                                                           ?>value="{{config('constant.inverse_property_condition_disclaimer.No')}}">
                                                    <label for="in_an_historical_districtNo"></label>
                                                </label>
                                            </td>
                                            <td><label class="">
                                                    <input type="radio" class="radio-btn-active" name="in_an_historical_district" <?php
                                                           if (isset($property->disclosure)) {
                                                               if ($property->disclosure->in_an_historical_district == config('constant.inverse_property_condition_disclaimer.NA')) {
                                                                   ?>
                                                                   checked="checked"
                                                        <?php
                                                    }
                                                }
                                                ?>id="in_an_historical_districtNA" value="{{config('constant.inverse_property_condition_disclaimer.NA')}}">
                                                    <label for="in_an_historical_districtNA"></label>
                                                </label>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <h5 for="inputPassword3" class="col-sm-12 control-label">If any of the above in Part C are marked YES, please explain:</h5>
                            <div class="col-sm-12">
                                <textarea rows="2" type="text" class="form-control text-height" name="partc_details">{{$property->disclosure->partc_details??""}}</textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <p class="offer-text">Seller certifies that this information is true and correct to the best of seller's knowledge as of the date signed.</p>
                                <p class="offer-text"> Buyer understands that this Disclosure is not intended as a substitute for any inspection, and that buyer has a responsibility
                                    to pay diligent attention to and inquire about defects which are evident by careful observation. Buyer acknowledges receipt
                                    of a copy of this Disclosure. </p>
                            </div>
                        </div>
                        <div class="btns-green-blue btns-text-align-right">
                            <div class="col-sm-12">
                                @if(isset($property->disclosure))
                                <input type="submit" class="btn button btn-blue" name="submit" value="Update">
                                @else
                                <input type="submit" class="btn button btn-blue" name="submit" value="Submit">
                                @endif
                            </div>
                        </div>
                        {{ html()->form()->close() }}
                    </div>
                </div>
            </div>
        </div><!--</col>-->
    </div><!--</row>-->
</div><!--</contract-tools-seller-common>-->
@endsection
@section('after-scripts')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.4/jquery.datetimepicker.min.css" />

<!-- Here by using Id selector the datetime picker will load on this input element -->
<script src="https://code.jquery.com/jquery-2.2.4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-datetimepicker/2.5.4/build/jquery.datetimepicker.full.min.js"></script>
<script src="http://cdn.craig.is/js/rainbow-custom.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js"></script>
<script>
$(document).ready(function () {
    $('form').validate({
        rules: {
            "property_includes[]": {
                required: true,
                minlength: 1
            },
            propertyage: {
                maxlength: 4
            }
        },
        messages: {
            occupy: "Please select anyone option",
            propertyis: "Please select anyone option",
            houseowners_associations: "Please select anyone option",
            bsknowledge: "Please select anyone option"
        },
        errorPlacement: function (error, element) {
            if (element.is(":radio"))
            {
                error.appendTo(element.parents('.btn-radio'));
                error.css("padding-left", "15px");
            } else
            {
                error.insertAfter(element);
            }
        }
    });

    $("form").submit(function (e) {
        if ($('.i_agree').is(":checked")) {
            $('#i_agree-error').hide();
        } else {
            $('#i_agree-error').css("display", "block");
        }

        //    property includes item error code on form submit
        if ($('.prop_inc_check').is(":checked")) {
            $('.prop_chkbox_error').hide();
        } else if ($('.prop_inc_check').is(":not(:checked)")) {
            $('.prop_chkbox_error').show();
        }

    });

    //    property includes item error code
    $('.prop_inc_check').click(function () {
        if ($('.prop_inc_check').is(":checked")) {
            $('.prop_chkbox_error').hide();
        } else if ($('.prop_inc_check').is(":not(:checked)")) {
            $('.prop_chkbox_error').show();
        }
    });

    if ($("#chkYes").is(":checked")) {
        $("#house").show();
    } else {
        $("#house").hide();
    }
    if ($("#Fireplace").is(":checked")) {
        $("#main-fireplace").show();
    } else {
        $("#main-fireplace").hide();
    }
    if ($("#Pool").is(":checked")) {
        $("#Pool-option").show();
    } else {
        $("#Pool-option").hide();
    }
    if ($("#Garage").is(":checked")) {
        $("#Garage-option").show();
    } else {
        $("#Garage-option").hide();
    }
    if ($("#Opener").is(":checked")) {
        $("#remotes").show();
    } else {
        $("#remotes").hide();
    }
    if ($("#Heat-Pump").is(":checked")) {
        $("#Heat-Pump-many").show();
    }
    if ($("#CH").is(":checked")) {
        $("#CH-many").show();
    }
    if ($("#CA").is(":checked")) {
        $("#CA-many").show();
    }
    if ($("#WH").is(":checked")) {
        $("#WH-many").show();
    }
    if ($("#WSupply").is(":checked")) {
        $("#WSupply-many").show();
    }
    if ($("#Gas-Supply").is(":checked")) {
        $("#Gas-Supply-many").show();
    }
    if ($("#selleryes").is(":checked")) {
        $("#seller").show();
    }

    $("#Garage").click(function () {
        $("#Garage-option").toggle();
    });
    $("#Pool").click(function () {
        $("#Pool-option").toggle();
    });
    $("input[name='houseowners_associations']").click(function () {
        if ($("#chkYes").is(":checked")) {
            $("#house").show();
        } else {
            $("#house").hide();
        }
    });

    $("input[name='bsknowledge']").click(function () {
        if ($("#selleryes").is(":checked")) {
            $("#seller").show();
        } else {
            $("#seller").hide();
        }
    });
//    $.datetimepicker.setLocale('pt-BR');
    $('#datetimepicker').datetimepicker({
        format: 'Y-m-d',
        timepicker: false,
    });


    $("#Fireplace").click(function () {
        $("#main-fireplace").toggle();
    });

    $("#Opener").click(function () {
        $("#remotes").toggle();
    });
    $("#Heat-Pump").click(function () {
        $("#Heat-Pump-many").toggle();
    });
    $("#CH").click(function () {
        $("#CH-many").toggle();
    });
    $("#CA").click(function () {
        $("#CA-many").toggle();
    });
    $("#WH").click(function () {
        $("#WH-many").toggle();
    });
    $("#WSupply").click(function () {
        $("#WSupply-many").toggle();
    });
    $("#Sewer-Disposal").click(function () {
        $("#Sewer-Disposal-option").toggle();
    });
    $("#Gas-Supply").click(function () {
        $("#Gas-Supply-many").toggle();
    });
<?php if (!isset($property->disclosure)) { ?>
        $('.radio-btn-active').attr('checked', true);
<?php } ?>
});
</script> 
@endsection
