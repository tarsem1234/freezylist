<div class="form-group"> 
    <h5 class="col-sm-12"> 1. Property age: </h5>
    <div class="col-sm-12">
        <input type="text" class="form-control" disabled="disabled" value="{{(isset($diffInYears) && $diffInYears >=1) ? $diffInYears : ''}}"> 
    </div>
</div>

<div class="form-group">                                    
    <div class="col-sm-12">
        <h5>2. Date seller acquired the property: </h5>
        <input type="text" class="form-control" disabled="disabled"  value="{{$property->disclosure->date_added??''}}"> 
    </div>
</div>

<div class="form-group">
    <div class="col-md-12">
        <h5>3. Does seller currently occupy the property?Any Contingencies?</h5>
        <input type="radio"  disabled="disabled" id="occupies" <?php
        if (isset($property->disclosure->occupy)) {
            if ($property->disclosure->occupy == config('constant.inverse_property_disclaimer_occupy.Seller occupies property')) {
                ?>
                       checked="checked"
                       <?php
                   }
               }
               ?> >
        <label for="occupy">Seller occupies property</label>
        <input type="radio"  disabled="disabled" <?php
        if (isset($property->disclosure->occupy)) {
            if ($property->disclosure->occupy == config('constant.inverse_property_disclaimer_occupy.Seller does not occupy property')) {
                ?>
                       checked="checked"
                       <?php
                   }
               }
               ?> id="notoccupies">
        <label for="notoccupies">Seller does not occupy property</label>
    </div><!--col-md-12-->
</div>

<div class="form-group">
    <div class="col-sm-12">
        <h5>4. If not currently seller-occupied, how long has it been since the seller did occupy the property, if ever?</h5>
        <input type="text" class="form-control" disabled="disabled" value="{{$property->disclosure->how_long??""}}">
    </div>
</div>

<div class="form-group">
    <div class="col-md-12">
        <h5>5. The property is a</h5>
        <input type="radio"  disabled="disabled" <?php
        if (isset($property->disclosure)) {
            if ($property->disclosure->property_is == config('constant.inverse_property_disclaimer_propertyis.Site-built Home')) {
                ?>
                       checked="checked"
                       <?php
                   }
               }
               ?>  id="site-built">
        <label for="site-built">site-built home</label>
        <input type="radio"  disabled="disabled" <?php
        if (isset($property->disclosure->property_is)) {
            if ($property->disclosure->property_is == config('constant.inverse_property_disclaimer_propertyis.Non-site-built Home')) {
                ?>
                       checked="checked"
                       <?php
                   }
               }
               ?>   id="non-site-built">
        <label for="non-site-built">non-site-built home<span class="offer-text">(e.g. - modular, manufactured, mobile) </span></label>
    </div><!--col-md-12-->
</div>  

<div class="form-group"> 
    <div class="col-md-12">
        <h5>6. Roof type</h5> 
        <label>Type of roofs: (e.g. - composition asphalt shingle, wood, metal, tile)</label>
        <input type="text" class="form-control"   disabled="disabled"  value="{{$property->disclosure->roof_type??""}}">
        <label>Approx. age of roof:</label>
        <input type="number" class="form-control"   disabled="disabled" min="0" value="{{$property->disclosure->roof_age??""}}">
    </div>
</div>

<div class="form-group">
    <div class="col-md-12">
        <h5>7. Is there a Homeowners Association (HOA) which has any authority over the subject property?</h5>
        <input type="radio"  disabled="disabled"  id="chkYes" <?php
        if (isset($property->disclosure)) {
            if ($property->disclosure->house_owners_associations == config('constant.inverse_common_yes_no.Yes')) {
                ?>
                       checked="checked"
                       <?php
                   }
               }
               ?> >
        <label for="chkYes">Yes</label>
        <input type="radio"  disabled="disabled"  id="chkNo" <?php
        if (isset($property->disclosure)) {
            if ($property->disclosure->house_owners_associations == config('constant.inverse_common_yes_no.No')) {
                ?>
                       checked="checked"
                       <?php
                   }
               }
               ?> >
        <label for="chkNo">No</label>
    </div><!--col-md-12-->
</div>

<div id="house" style="display: none;">
    <div class="form-group">
        <div class="col-md-12">
            <p>Name &amp; address of HOA:</p>
            <input type="text" class="form-control" disabled="disabled" value="{{$property->disclosure->name_address??""}}">
        </div>
    </div>

    <div class="form-group">
        <div class="col-md-6">
            <p>Monthly Dues:</p>
            <input type="number" class="form-control" disabled="disabled" min="0" value="{{$property->disclosure->monthly_dues??""}}">
        </div>
    </div>

    <div class="form-group">
        <div class="col-md-6">
            <p>Transfer Fees:</p>
            <input type="number" class="form-control" disabled="disabled" min="0" value="{{$property->disclosure->transfer_fees??""}}">
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-12">
            <p>Special Assessments:</p>
            <input type="text" class="form-control" disabled="disabled" value="{{$property->disclosure->special_assessments??""}}">
        </div>
    </div>
</div> 
<?php
if (isset($property->disclosure)) {
    $propertyIncludes = explode(',', $property->disclosure->property_includes);
}
?>
<div class="form-group">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <h5>A. The property includes the items checked below: </h5>
    </div><!--col-md-12-->
</div>

<div class="form-group">
    <div class="col-md-6 col-sm-12 col-xs-12">
        <div class="checkbox">
            <input type="checkbox" disabled="disabled"  class="styled-checkbox" disabled="disabled"  <?php
            if (isset($property->disclosure)) {
                foreach ($propertyIncludes as $propertyInclude) {
                    if ($propertyInclude == "Range") {
                        ?>
                               checked="checked"
                               <?php
                           }
                       }
                   }
                   ?> id="Range">
            <label for="Range">Range </label>
        </div>
    </div><!--col-md-12-->
</div>

<div class="form-group">
    <div class="col-md-6 col-sm-12 col-xs-12">
        <div class="checkbox">
            <input type="checkbox" disabled="disabled"  class="styled-checkbox"   disabled="disabled" <?php
            if (isset($property->disclosure)) {
                foreach ($propertyIncludes as $propertyInclude) {
                    if ($propertyInclude == "Spa/Whirlpool Tub") {
                        ?>
                               checked="checked"
                               <?php
                           }
                       }
                   }
                   ?>  id="Spa">
            <label for="Spa">Spa/Whirlpool Tub  </label>
        </div>
    </div><!--col-md-12-->
</div>

<div class="form-group">
    <div class="col-md-6 col-sm-12 col-xs-12">
        <div class="checkbox">
            <input type="checkbox" disabled="disabled"  class="styled-checkbox"   disabled="disabled" <?php
            if (isset($property->disclosure)) {
                foreach ($propertyIncludes as $propertyInclude) {
                    if ($propertyInclude == "Access to Public Streets") {
                        ?>
                               checked="checked"
                               <?php
                           }
                       }
                   }
                   ?>  id="Streets">
            <label for="Streets">Access to Public Streets </label>
        </div>
    </div><!--col-md-12-->
</div>

<div class="form-group">
    <div class="col-md-6 col-sm-12 col-xs-12">
        <div class="checkbox">
            <input type="checkbox" disabled="disabled"  class="styled-checkbox"   disabled="disabled" <?php
            if (isset($property->disclosure)) {
                foreach ($propertyIncludes as $propertyInclude) {
                    if ($propertyInclude == "Microwave") {
                        ?>
                               checked="checked"
                               <?php
                           }
                       }
                   }
                   ?>   id="Microwave">
            <label for="Microwave">Microwave</label>
        </div>
    </div><!--col-md-12-->
</div>

<div class="form-group">
    <div class="col-md-6 col-sm-12 col-xs-12">
        <div class="checkbox">
            <input type="checkbox" disabled="disabled"  class="styled-checkbox" disabled="disabled" <?php
            if (isset($property->disclosure)) {
                foreach ($propertyIncludes as $propertyInclude) {
                    if ($propertyInclude == "Hot Tub") {
                        ?>
                               checked="checked"
                               <?php
                           }
                       }
                   }
                   ?> id="Tub">
            <label for="Tub"> Hot Tub </label>
        </div>
    </div><!--col-md-12-->
</div>

<div class="form-group">
    <div class="col-md-6 col-sm-12 col-xs-12">
        <div class="checkbox">
            <input type="checkbox" disabled="disabled"  class="styled-checkbox"   disabled="disabled"<?php
            if (isset($property->disclosure)) {
                foreach ($propertyIncludes as $propertyInclude) {
                    if ($propertyInclude == "Current Termite Contract") {
                        ?>
                               checked="checked"
                               <?php
                           }
                       }
                   }
                   ?>  id="Termite">
            <label for="Termite"> Current Termite Contract </label>
        </div>
    </div><!--col-md-12-->
</div>

<div class="form-group">
    <div class="col-md-6 col-sm-12 col-xs-12">
        <div class="checkbox">
            <input type="checkbox" disabled="disabled"  class="styled-checkbox"   disabled="disabled"  <?php
            if (isset($property->disclosure)) {
                foreach ($propertyIncludes as $propertyInclude) {
                    if ($propertyInclude == "Garbage Disposal") {
                        ?>
                               checked="checked"
                               <?php
                           }
                       }
                   }
                   ?>  id="Disposal">
            <label for="Disposal"> Garbage Disposal  </label>
        </div>
    </div><!--col-md-12-->
</div>

<div class="form-group">
    <div class="col-md-6 col-sm-12 col-xs-12">
        <div class="checkbox">
            <input type="checkbox" disabled="disabled"  class="styled-checkbox"   disabled="disabled" id="Sauna" <?php
            if (isset($property->disclosure)) {
                foreach ($propertyIncludes as $propertyInclude) {
                    if ($propertyInclude == "Sauna") {
                        ?>
                               checked="checked"
                               <?php
                           }
                       }
                   }
                   ?> >
            <label for="Sauna"> Sauna </label>
        </div>
    </div><!--col-md-12-->
</div>


<div class="form-group">
    <div class="col-md-6 col-sm-12 col-xs-12">
        <div class="checkbox">
            <input type="checkbox" disabled="disabled"  class="styled-checkbox"   disabled="disabled" <?php
            if (isset($property->disclosure)) {
                foreach ($propertyIncludes as $propertyInclude) {
                    if ($propertyInclude == "Trash Compactor") {
                        ?>
                               checked="checked"
                               <?php
                           }
                       }
                   }
                   ?>  id="Compactor">
            <label for="Compactor"> Trash Compactor</label>
        </div>
    </div><!--col-md-12-->
</div>

<div class="form-group">
    <div class="col-md-6 col-sm-12 col-xs-12">
        <div class="checkbox">
            <input type="checkbox" disabled="disabled"  class="styled-checkbox"   disabled="disabled" <?php
            if (isset($property->disclosure)) {
                foreach ($propertyIncludes as $propertyInclude) {
                    if ($propertyInclude == "Water Softener") {
                        ?>
                               checked="checked"
                               <?php
                           }
                       }
                   }
                   ?>  id="Water">
            <label for="Water"> Water Softener</label>
        </div>
    </div><!--col-md-12-->
</div>

<div class="form-group">
    <div class="col-md-6 col-sm-12 col-xs-12">
        <div class="checkbox">
            <input type="checkbox" disabled="disabled"  class="styled-checkbox"   disabled="disabled" <?php
            if (isset($property->disclosure)) {
                foreach ($propertyIncludes as $propertyInclude) {
                    if ($propertyInclude == "220 Volt Wiring") {
                        ?>
                               checked="checked"
                               <?php
                           }
                       }
                   }
                   ?>  id="Wiring">
            <label for="Wiring"> 220 Volt Wiring </label>
        </div>
    </div><!--col-md-12-->
</div>

<div class="form-group">
    <div class="col-md-6 col-sm-12 col-xs-12">
        <div class="checkbox">
            <input type="checkbox" disabled="disabled"  class="styled-checkbox"   disabled="disabled" <?php
            if (isset($property->disclosure)) {
                foreach ($propertyIncludes as $propertyInclude) {
                    if ($propertyInclude == "Washer/Dryer Hookups") {
                        ?>
                               checked="checked"
                               <?php
                           }
                       }
                   }
                   ?>  id="Hookups">
            <label for="Hookups"> Washer/Dryer Hookups</label>
        </div>
    </div><!--col-md-12-->
</div>

<div class="form-group">
    <div class="col-md-6 col-sm-12 col-xs-12">
        <div class="checkbox">
            <input type="checkbox" disabled="disabled"  class="styled-checkbox"   disabled="disabled"  <?php
            if (isset($property->disclosure)) {
                foreach ($propertyIncludes as $propertyInclude) {
                    if ($propertyInclude == "Window Screens") {
                        ?>
                               checked="checked"
                               <?php
                           }
                       }
                   }
                   ?>   id="Window">
            <label for="Window"> Window Screens</label>
        </div>
    </div><!--col-md-12-->
</div>
<div class="form-group">
    <div class="col-md-6 col-sm-12 col-xs-12">
        <div class="checkbox">
            <input type="checkbox" disabled="disabled"  class="styled-checkbox"   disabled="disabled"  <?php
            if (isset($property->disclosure)) {
                foreach ($propertyIncludes as $propertyInclude) {
                    if ($propertyInclude == "Fireplace") {
                        ?>
                               checked="checked"
                               <?php
                           }
                       }
                   }
                   ?> id="Fireplace">
            <label for="Fireplace"> Fireplace  <span id='main-fireplace' style="display: none">
                    (How many? <input type="number" min="0" class="readonly" disabled="disabled" id="text-form-input" value="{{$property->disclosure->how_many??""}}">
                    )</span></label>
        </div>
    </div><!--col-md-12-->
</div>
<div class="form-group">
    <div class="col-md-6 col-sm-12 col-xs-12">
        <div class="checkbox">
            <input type="checkbox" disabled="disabled"  class="styled-checkbox"   disabled="disabled"   <?php
            if (isset($property->disclosure)) {
                foreach ($propertyIncludes as $propertyInclude) {
                    if ($propertyInclude == "Gas Starter for Fireplace") {
                        ?>
                               checked="checked"
                               <?php
                           }
                       }
                   }
                   ?>  id="Starter-Fireplace">
            <label for="Starter-Fireplace"> Gas Starter for Fireplace</label>
        </div>
    </div><!--col-md-12-->
</div>
<div class="form-group">
    <div class="col-md-6 col-sm-12 col-xs-12">
        <div class="checkbox">
            <input type="checkbox" disabled="disabled"  class="styled-checkbox"   disabled="disabled" <?php
            if (isset($property->disclosure)) {
                foreach ($propertyIncludes as $propertyInclude) {
                    if ($propertyInclude == "Gas Fireplace Logs") {
                        ?>
                               checked="checked"
                               <?php
                           }
                       }
                   }
                   ?> id="Logs">
            <label for="Logs"> Gas Fireplace Logs</label>
        </div>
    </div><!--col-md-12-->
</div>

<div class="form-group">
    <div class="col-md-6 col-sm-12 col-xs-12">
        <div class="checkbox">
            <input type="checkbox" disabled="disabled"  class="styled-checkbox"   disabled="disabled" <?php
            if (isset($property->disclosure)) {
                foreach ($propertyIncludes as $propertyInclude) {
                    if ($propertyInclude == "Patio/Decking/Gazebo") {
                        ?>
                               checked="checked"
                               <?php
                           }
                       }
                   }
                   ?> id="Decking">
            <label for="Decking"> Patio/Decking/Gazebo </label>
        </div>
    </div><!--col-md-12-->
</div>

<div class="form-group">
    <div class="col-md-6 col-sm-12 col-xs-12">
        <div class="checkbox">
            <input type="checkbox" disabled="disabled"  class="styled-checkbox"   disabled="disabled"  <?php
            if (isset($property->disclosure)) {
                foreach ($propertyIncludes as $propertyInclude) {
                    if ($propertyInclude == "Irrigation System") {
                        ?>
                               checked="checked"
                               <?php
                           }
                       }
                   }
                   ?> id="Irrigation" >
            <label for="Irrigation"> Irrigation System </label>
        </div>
    </div><!--col-md-12-->
</div>

<div class="form-group">
    <div class="col-md-6 col-sm-12 col-xs-12">
        <div class="checkbox">
            <input type="checkbox" disabled="disabled"  class="styled-checkbox"   disabled="disabled" <?php
            if (isset($property->disclosure)) {
                foreach ($propertyIncludes as $propertyInclude) {
                    if ($propertyInclude == "Installed Outdoor Cooking Grill") {
                        ?>
                               checked="checked"
                               <?php
                           }
                       }
                   }
                   ?>  id="Cooking">
            <label for="Cooking"> Installed Outdoor Cooking Grill  </label>
        </div>
    </div><!--col-md-12-->
</div>


<div class="form-group">
    <div class="col-md-6 col-sm-12 col-xs-12">
        <div class="checkbox">
            <input type="checkbox" disabled="disabled"  class="styled-checkbox"   disabled="disabled" <?php
            if (isset($property->disclosure)) {
                foreach ($propertyIncludes as $propertyInclude) {
                    if ($propertyInclude == "Intercom") {
                        ?>
                               checked="checked"
                               <?php
                           }
                       }
                   }
                   ?> id="Intercom">
            <label for="Intercom"> Intercom </label>
        </div>
    </div><!--col-md-12-->
</div>

<div class="form-group">
    <div class="col-md-6 col-sm-12 col-xs-12">
        <div class="checkbox">
            <input type="checkbox" disabled="disabled"  class="styled-checkbox"   disabled="disabled" <?php
            if (isset($property->disclosure)) {
                foreach ($propertyIncludes as $propertyInclude) {
                    if ($propertyInclude == "Rain Gutters") {
                        ?>
                               checked="checked"
                               <?php
                           }
                       }
                   }
                   ?> id="Rain">
            <label for="Rain">  Rain Gutters  </label>
        </div>
    </div><!--col-md-12-->
</div>

<div class="form-group">
    <div class="col-md-6 col-sm-12 col-xs-12">
        <div class="checkbox">
            <input type="checkbox" disabled="disabled"  class="styled-checkbox"   disabled="disabled" <?php
            if (isset($property->disclosure)) {
                foreach ($propertyIncludes as $propertyInclude) {
                    if ($propertyInclude == "Sump Pump") {
                        ?>
                               checked="checked"
                               <?php
                           }
                       }
                   }
                   ?> id="Sump">
            <label for="Sump"> Sump Pump </label>
        </div>
    </div><!--col-md-12-->
</div>


<div class="form-group">
    <div class="col-md-6 col-sm-12 col-xs-12">
        <div class="checkbox">
            <input type="checkbox" disabled="disabled"  class="styled-checkbox"   disabled="disabled" <?php
            if (isset($property->disclosure)) {
                foreach ($propertyIncludes as $propertyInclude) {
                    if ($propertyInclude == "A key to all exterior doors") {
                        ?>
                               checked="checked"
                               <?php
                           }
                       }
                   }
                   ?> id="key">
            <label for="key">A key to all exterior doors  </label>
        </div>
    </div><!--col-md-12-->
</div>



<div class="form-group">
    <div class="col-md-6 col-sm-12 col-xs-12">
        <div class="checkbox">
            <input type="checkbox" disabled="disabled"  class="styled-checkbox"   disabled="disabled"  <?php
            if (isset($property->disclosure)) {
                foreach ($propertyIncludes as $propertyInclude) {
                    if ($propertyInclude == "Carport") {
                        ?>
                               checked="checked"
                               <?php
                           }
                       }
                   }
                   ?> id="Carport">
            <label for="Carport">Carport </label>
        </div>
    </div><!--col-md-12-->
</div>

<div class="form-group">
    <div class="col-md-6 col-sm-12 col-xs-12">
        <div class="checkbox">
            <input type="checkbox" disabled="disabled"  class="styled-checkbox"   disabled="disabled"  <?php
            if (isset($property->disclosure)) {
                foreach ($propertyIncludes as $propertyInclude) {
                    if ($propertyInclude == "Smoke Detector") {
                        ?>
                               checked="checked"
                               <?php
                           }
                       }
                   }
                   ?>  id="Smoke">
            <label for="Smoke">Smoke Detector/Fire Alarm </label>
        </div>
    </div><!--col-md-12-->
</div>

<div class="form-group">
    <div class="col-md-6 col-sm-12 col-xs-12">
        <div class="checkbox">
            <input type="checkbox" disabled="disabled"  class="styled-checkbox"   disabled="disabled" <?php
            if (isset($property->disclosure)) {
                foreach ($propertyIncludes as $propertyInclude) {
                    if ($propertyInclude == "Wall/Window Air Conditioning") {
                        ?>
                               checked="checked"
                               <?php
                           }
                       }
                   }
                   ?> id="Wall/Window" >
            <label for="Wall/Window">Wall/Window Air Conditioning</label>
        </div>
    </div><!--col-md-12-->
</div>

<div class="form-group">
    <div class="col-md-6 col-sm-12 col-xs-12">
        <div class="checkbox">
            <input type="checkbox" disabled="disabled"  class="styled-checkbox"   disabled="disabled" <?php
            if (isset($property->disclosure)) {
                foreach ($propertyIncludes as $propertyInclude) {
                    if ($propertyInclude == "Central Heating") {
                        ?>
                               checked="checked"
                               <?php
                           }
                       }
                   }
                   ?> id="Central-Heating" >
            <label for="Central-Heating"> Central Heating</label>
        </div>
    </div><!--col-md-12-->
</div>
<div class="form-group">
    <div class="col-md-6 col-sm-12 col-xs-12">
        <div class="checkbox">
            <input type="checkbox" disabled="disabled"  class="styled-checkbox"   disabled="disabled" <?php
            if (isset($property->disclosure)) {
                foreach ($propertyIncludes as $propertyInclude) {
                    if ($propertyInclude == "All Landscaping and Outdoor Lighting") {
                        ?>
                               checked="checked"
                               <?php
                           }
                       }
                   }
                   ?> id="Landscaping" >
            <label for="Landscaping"> All Landscaping and Outdoor Lighting</label>
        </div>
    </div><!--col-md-12-->
</div>
<div class="form-group">
    <div class="col-md-6 col-sm-12 col-xs-12">
        <div class="checkbox">
            <input type="checkbox" disabled="disabled"  class="styled-checkbox"   disabled="disabled"  <?php
            if (isset($property->disclosure)) {
                foreach ($propertyIncludes as $propertyInclude) {
                    if ($propertyInclude == "Pool") {
                        ?>
                               checked="checked"
                               <?php
                           }
                       }
                   }
                   ?>  id="Pool" >
            <label for="Pool">Pool  </label>
        </div>
        <div id="Pool-option" style="display: none" class="col-md-12 col-sm-12 col-xs-12">
            <input type="radio"  disabled="disabled"  <?php
            if (isset($property->disclosure)) {
                if ($property->disclosure->pool_type == config('constant.inverse_property_disclaimer_pool.In-ground')) {
                    ?>
                           checked="checked"
                           <?php
                       }
                   }
                   ?> id="In-ground" >
            <label for="In-ground">In-ground </label>
            <input type="radio"  disabled="disabled"  <?php
            if (isset($property->disclosure)) {
                if ($property->disclosure->pool_type == config('constant.inverse_property_disclaimer_pool.Above-ground')) {
                    ?>
                           checked="checked"
                           <?php
                       }
                   }
                   ?> id="Above-ground">
            <label for="Above-ground">Above-ground </label>
        </div>
    </div><!--col-md-12-->
</div>

<div class="form-group">
    <div class="col-md-6 col-sm-12 col-xs-12">
        <div class="checkbox">
            <input type="checkbox" disabled="disabled"  class="styled-checkbox"   disabled="disabled"  <?php
            if (isset($property->disclosure)) {
                foreach ($propertyIncludes as $propertyInclude) {
                    if ($propertyInclude == "Garage") {
                        ?>
                               checked="checked"
                               <?php
                           }
                       }
                   }
                   ?> id="Garage">
            <label for="Garage">Garage</label>
        </div>
        <div id="Garage-option" style="display: none" class="col-md-12 col-sm-12 col-xs-12">
            <input type="radio"  disabled="disabled"  <?php
            if (isset($property->disclosure)) {
                if ($property->disclosure->garage_type == config('constant.inverse_property_disclaimer_garage.Attached')) {
                    ?>
                           checked="checked"
                           <?php
                       }
                   }
                   ?> id="Attached">
            <label for="Attached">Attached </label>

            <input type="radio"  disabled="disabled"  <?php
            if (isset($property->disclosure)) {
                if ($property->disclosure->garage_type == config('constant.inverse_property_disclaimer_garage.Not Attached')) {
                    ?>
                           checked="checked"
                           <?php
                       }
                   }
                   ?>  id="Not-Attached">
            <label for="Not-Attached"> Not Attached</label>
        </div>
    </div>
</div><!--col-md-12-->

<div class="form-group">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="checkbox">
            <input type="checkbox" disabled="disabled"  class="styled-checkbox"   disabled="disabled"  <?php
            if (isset($property->disclosure)) {
                foreach ($propertyIncludes as $propertyInclude) {
                    if ($propertyInclude == "Garage Door Opener") {
                        ?>
                               checked="checked"
                               <?php
                           }
                       }
                   }
                   ?>  id="Opener">
            <label for="Opener"> Garage Door Opener(s) and remotes.  <span id='remotes' style="display: none">
                    (How many remotes?<input type="number" min="0" class="readonly" disabled="disabled" id="text-form-input" value="{{$property->disclosure->how_many_remotes??""}}">
                    )</span></label>
        </div>
    </div><!--col-md-12-->
</div>
<div class="form-group">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="checkbox">
            <input type="checkbox" disabled="disabled"  class="styled-checkbox"   disabled="disabled"  <?php
            if (isset($property->disclosure)) {
                foreach ($propertyIncludes as $propertyInclude) {
                    if ($propertyInclude == "Burglar Alarm/Security System") {
                        ?>
                               checked="checked"
                               <?php
                           }
                       }
                   }
                   ?> id="Alarm">
            <label for="Alarm">Burglar Alarm/Security System including components and controls </label>
        </div>
    </div><!--col-md-12-->
</div>

<div class="form-group">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="checkbox">
            <input type="checkbox" disabled="disabled"  class="styled-checkbox"   disabled="disabled" <?php
            if (isset($property->disclosure)) {
                foreach ($propertyIncludes as $propertyInclude) {
                    if ($propertyInclude == "TV Antenna/Satellite Dish") {
                        ?>
                               checked="checked"
                               <?php
                           }
                       }
                   }
                   ?> id="Antenna" >
            <label for="Antenna"> TV Antenna/Satellite Dish excluding components  </label>
        </div>
    </div><!--col-md-12-->
</div>


<div class="form-group">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="checkbox">
            <input type="checkbox" disabled="disabled"  class="styled-checkbox"   disabled="disabled" <?php
            if (isset($property->disclosure)) {
                foreach ($propertyIncludes as $propertyInclude) {
                    if ($propertyInclude == "Central Vacuum System and attachments") {
                        ?>
                               checked="checked"
                               <?php
                           }
                       }
                   }
                   ?>  id="Vacuum">
            <label for="Vacuum"> Central Vacuum System and attachments </label>
        </div>
    </div><!--col-md-12-->
</div>

<div class="form-group">
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="checkbox">
            <input type="checkbox" disabled="disabled"  class="styled-checkbox"   disabled="disabled" <?php
            if (isset($property->disclosure)) {
                foreach ($propertyIncludes as $propertyInclude) {
                    if ($propertyInclude == "Heat Pump") {
                        ?>
                               checked="checked"
                               <?php
                           }
                       }
                   }
                   ?>  id="Heat-Pump">
            <label for="Heat-Pump">Heat Pump <span id='Heat-Pump-many' style="display: none"> (Approx. age:
                    <input type="number" class="readonly" disabled="disabled" min="0"  value="{{$property->disclosure->heat_pump_age??""}}">)</span></label>
        </div>
    </div><!--col-md-12-->
</div>
<?php
if (isset($property->disclosure)) {
    if ($property->disclosure->water_heater_type) {
        $waterHeaterTypes = explode(',',
            $property->disclosure->water_heater_type);
    }
}
?>
<div class="col-lg-12">
    <div class="form-group row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="checkbox">
                <input type="checkbox" disabled="disabled"  class="styled-checkbox"   disabled="disabled" <?php
                if (isset($propertyIncludes)) {
                    foreach ($propertyIncludes as $propertyInclude) {
                        if ($propertyInclude == "Central Heating") {
                            ?>
                                   checked="checked"
                                   <?php
                               }
                           }
                       }
                       ?> id="CH">
                <label for="CH">Central Heating <span id='CH-many' style="display: none">(Age:
                        <input type="number" min="0" class="readonly" disabled="disabled" id="text-form-input" value="{{$property->disclosure->central_heating_age??""}}">)
                        <span class="pull-right-div">
                            <input type="checkbox" disabled="disabled"  class="styled-checkbox"   disabled="disabled" <?php
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
                                   ?>  id="Electric">
                            <label for="Electric">Electric</label>
                            <input type="checkbox" disabled="disabled"  class="styled-checkbox"   disabled="disabled" <?php
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
                                   ?> id="Gas" >
                            <label for="Gas">Gas</label>
                            <input type="checkbox" disabled="disabled"  class="styled-checkbox"   disabled="disabled" <?php
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
                                   ?> id="Other">
                            <label for="Other">Other:</label>
                        </span>
                    </span>
                </label>
            </div>
        </div>
    </div>
</div> 
<?php
if (isset($property->disclosure)) {
    if ($property->disclosure->central_air_conditioning_type) {
        $centralAirConditioningTypes = explode(',',
            $property->disclosure->central_air_conditioning_type);
    }
}
?>
<div class="col-lg-12">                              
    <div class="form-group row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="checkbox">
                <input type="checkbox" disabled="disabled"  class="styled-checkbox"   disabled="disabled" <?php
                if (isset($propertyIncludes)) {
                    foreach ($propertyIncludes as $propertyInclude) {
                        if ($propertyInclude == "Central Air Conditioning") {
                            ?>
                                   checked="checked"
                                   <?php
                               }
                           }
                       }
                       ?> id="CA">
                <label for="CA">Central Air Conditioning <span id='CA-many' style="display: none">(Age:
                        <input type="number" class="readonly" disabled="disabled" min="0" id="text-form-input"  value="{{$property->disclosure->central_air_conditioning_age??""}}">)
                        <span class="pull-right-div">
                            <input type="checkbox" disabled="disabled"  class="styled-checkbox" disabled="disabled" id="AirElectric" <?php
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
                                   ?> >
                            <label for="AirElectric">Electric</label>
                            <input type="checkbox" disabled="disabled"  class="styled-checkbox"   disabled="disabled" id="AirGas" <?php
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
                                   ?> >
                            <label for="AirGas">Gas</label>
                            <input type="checkbox" disabled="disabled"  class="styled-checkbox"   disabled="disabled" id="AirOther" <?php
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
                                   ?> >
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
        $waterHeaterTypes = explode(',',
            $property->disclosure->water_heater_type);
    }
}
?>
<div class="col-lg-12">                       
    <div class="form-group row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="checkbox">
                <input type="checkbox" disabled="disabled"  class="styled-checkbox" disabled="disabled" <?php
                if (isset($propertyIncludes)) {
                    foreach ($propertyIncludes as $propertyInclude) {
                        if ($propertyInclude == "Water Heater") {
                            ?>
                                   checked="checked"
                                   <?php
                               }
                           }
                       }
                       ?> id="WH" >
                <label for="WH"> Water Heater<span id='WH-many' style="display: none">  (Age:
                        <input type="number" min="0" class="readonly" disabled="disabled" id="text-form-input" value="{{$property->disclosure->water_heater_age??""}}">)

                        <span class="pull-right-div">
                            <input type="checkbox" disabled="disabled"  class="styled-checkbox"   disabled="disabled" id="WHElectric" <?php
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
                                   ?> >
                            <label for="WHElectric">Electric</label>
                            <input type="checkbox" disabled="disabled"  class="styled-checkbox"   disabled="disabled" id="WHGas" <?php
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
                                   ?> >
                            <label for="WHGas">Gas</label>
                            <input type="checkbox" disabled="disabled"  class="styled-checkbox"   disabled="disabled" id="WHOther" <?php
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
                                   ?> >
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
        $waterSupplyTypes = explode(',',
            $property->disclosure->water_supply_type);
    }
}
?>
<div class="col-lg-12">
    <div class="form-group row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="checkbox">
                <input type="checkbox" disabled="disabled"  class="styled-checkbox"  <?php
                if (isset($propertyIncludes)) {
                    foreach ($propertyIncludes as $propertyInclude) {
                        if ($propertyInclude == "Water Supply") {
                            ?>
                                   checked="checked"
                                   <?php
                               }
                           }
                       }
                       ?> id="WSupply" >
                <label for="WSupply">Water Supply<span id='WSupply-many' style="display: none">
                        <div class="margin-left">
                            <input type="checkbox" disabled="disabled"  class="styled-checkbox" id="City-Water" <?php
                            if (isset($waterSupplyTypes)) {
                                foreach ($waterSupplyTypes as $waterSupplyType) {
                                    if ($waterSupplyType == "City Water") {
                                        ?>
                                               checked="checked"
                                               <?php
                                           }
                                       }
                                   }
                                   ?> >
                            <label for="City-Water">City Water </label>
                            <input type="checkbox" disabled="disabled"  class="styled-checkbox" id="Privatew"<?php
                            if (isset($waterSupplyTypes)) {
                                foreach ($waterSupplyTypes as $waterSupplyType) {
                                    if ($waterSupplyType == "Private Well") {
                                        ?>
                                               checked="checked"
                                               <?php
                                           }
                                       }
                                   }
                                   ?>  >
                            <label for="Privatew"> Private Well</label>
                            <input type="checkbox" disabled="disabled"  class="styled-checkbox" id="Shared"<?php
                            if (isset($waterSupplyTypes)) {
                                foreach ($waterSupplyTypes as $waterSupplyType) {
                                    if ($waterSupplyType == "Shared Well") {
                                        ?>
                                               checked="checked"
                                               <?php
                                           }
                                       }
                                   }
                                   ?>  >
                            <label for="Shared">Shared Well</label>
                            <input type="checkbox" disabled="disabled"  class="styled-checkbox" id="oWater" <?php
                            if (isset($waterSupplyTypes)) {
                                foreach ($waterSupplyTypes as $waterSupplyType) {
                                    if ($waterSupplyType == "WSOther") {
                                        ?>
                                               checked="checked"
                                               <?php
                                           }
                                       }
                                   }
                                   ?> >
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
        $sewageDisposalTypes = explode(',',
            $property->disclosure->sewage_disposal_type);
    }
}
?>
<div class="col-lg-12">
    <div class="form-group row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="checkbox">
                <input type="checkbox" disabled="disabled"  class="styled-checkbox" <?php
                if (isset($propertyIncludes)) {
                    foreach ($propertyIncludes as $propertyInclude) {
                        if ($propertyInclude == "Sewage Disposal") {
                            ?>
                                   checked="checked"
                                   <?php
                               }
                           }
                       }
                       ?>  id="Sewer-Disposal">
                <label for="Sewer-Disposal">Sewage Disposal<span id='Sewer-Disposal-option' style="display: none">
                        <span>
                            <div class="margin-left">
                                <input type="checkbox" disabled="disabled"  class="styled-checkbox" id="Sewer" <?php
                                if (isset($sewageDisposalTypes)) {
                                    foreach ($sewageDisposalTypes as $sewageDisposalType) {
                                        if ($sewageDisposalType == "City Sewer") {
                                            ?>
                                                   checked="checked"
                                                   <?php
                                               }
                                           }
                                       }
                                       ?> >
                                <label for="Sewer">City Sewer</label>
                                <input type="checkbox" disabled="disabled"  class="styled-checkbox" id="Septic" <?php
                                if (isset($sewageDisposalTypes)) {
                                    foreach ($sewageDisposalTypes as $sewageDisposalType) {
                                        if ($sewageDisposalType == "Septic Tank") {
                                            ?>
                                                   checked="checked"
                                                   <?php
                                               }
                                           }
                                       }
                                       ?> >
                                <label for="Septic">Septic Tank</label>
                                <input type="checkbox" disabled="disabled"  class="styled-checkbox" id="STEP" <?php
                                if (isset($sewageDisposalTypes)) {
                                    foreach ($sewageDisposalTypes as $sewageDisposalType) {
                                        if ($sewageDisposalType == "STEP System") {
                                            ?>
                                                   checked="checked"
                                                   <?php
                                               }
                                           }
                                       }
                                       ?> >
                                <label for="STEP">STEP System  </label>
                                <input type="checkbox" disabled="disabled"  class="styled-checkbox" id="SDOther" <?php
                                if (isset($sewageDisposalTypes)) {
                                    foreach ($sewageDisposalTypes as $sewageDisposalType) {
                                        if ($sewageDisposalType == "SDOther") {
                                            ?>
                                                   checked="checked"
                                                   <?php
                                               }
                                           }
                                       }
                                       ?> >
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
    if ($property->disclosure->gas_supply_type) {
        $gasSupplyTypes = explode(',', $property->disclosure->gas_supply_type);
    }
}
?>
<div class="col-lg-12">
    <div class="form-group row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="checkbox">
                <input type="checkbox" disabled="disabled"  class="styled-checkbox"  <?php
                if (isset($propertyIncludes)) {
                    foreach ($propertyIncludes as $propertyInclude) {
                        if ($propertyInclude == "Gas Supply") {
                            ?>
                                   checked="checked"
                                   <?php
                               }
                           }
                       }
                       ?> id="Gas-Supply">
                <label for="Gas-Supply">Gas Supply<span id='Gas-Supply-many' style="display: none">
                        <div class="margin-left">
                            <input type="checkbox" disabled="disabled"  class="styled-checkbox" id="Utility" <?php
                            if (isset($gasSupplyTypes)) {
                                foreach ($gasSupplyTypes as $gasSupplyType) {
                                    if ($gasSupplyType == "Utility") {
                                        ?>
                                               checked="checked"
                                               <?php
                                           }
                                       }
                                   }
                                   ?> >
                            <label for="Utility">Utility</label>
                            <input type="checkbox" disabled="disabled"  class="styled-checkbox" id="Propane-Tank" <?php
                            if (isset($gasSupplyTypes)) {
                                foreach ($gasSupplyTypes as $gasSupplyType) {
                                    if ($gasSupplyType == "Propane Tank") {
                                        ?>
                                               checked="checked"
                                               <?php
                                           }
                                       }
                                   }
                                   ?>>
                            <label for="Propane-Tank"> Propane Tank</label>
                            <input type="checkbox" disabled="disabled"  class="styled-checkbox" id="GSOther" <?php
                            if (isset($gasSupplyTypes)) {
                                foreach ($gasSupplyTypes as $gasSupplyType) {
                                    if ($gasSupplyType == "GSOther") {
                                        ?>
                                               checked="checked"
                                               <?php
                                           }
                                       }
                                   }
                                   ?> >
                            <label for="GSOther">Other:</label>
                        </div>
                    </span>
                </label>
            </div>
        </div>
    </div>
</div>
<div class="form-group">
    <h5 class="col-sm-12">Other items included:</h5>
    <div class="col-sm-12">
        <textarea type="text" rows="2" id="optional_message" disabled="disabled" class="form-control text-height" id="text-form-input">{{$property->disclosure->other_items_included??""}}</textarea>
    </div>
</div>
<div class="form-group">
    <div class="col-md-12">
        <h5>To the best of seller's knowledge, are any in Part A above NOT in operating condition:</h5>
        <input type="radio" disabled="disabled"  class="makeofferradio" id="selleryes" <?php
        if (isset($property->disclosure)) {
            if ($property->disclosure->best_knowledge == config('constant.inverse_common_yes_no.Yes')) {
                ?>
                       checked="checked"
                       <?php
                   }
               }
               ?>  >
        <label for="selleryes">Yes</label>
        <input type="radio" disabled="disabled"  class="makeofferradio" id="sellerNo" <?php
        if (isset($property->disclosure)) {
            if ($property->disclosure->best_knowledge == config('constant.inverse_common_yes_no.No')) {
                ?>
                       checked="checked"
                       <?php
                   }
               }
               ?>  >
        <label for="sellerNo">No</label>
    </div><!--col-md-12-->
</div>
<div id="seller" style="display: none">
    <div class="form-group">
        <h5 class="col-sm-12">If Yes, Please Explain:</h5>
        <div class="col-sm-12">
            <textarea type="text" rows="2" class="form-control text-height" disabled="disabled">{{$property->disclosure->best_knowledge_explain??""}}</textarea>
        </div>
    </div>
</div>

<div class="form-group">
    <div class="col-md-12">
        <h5>B. Is Seller AWARE of any defects or malfunctions in any of the following?</h5>
    </div><!--col-md-12-->
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
                        <td>Interior Walls</td>
                        <td>
                            <input type="radio" disabled="disabled" id="interior_wallsyes" <?php
                            if (isset($property->disclosure)) {
                                if ($property->disclosure->interior_walls == config('constant.inverse_property_condition_disclaimer.Yes')) {
                                    ?>
                                           checked="checked"
                                           <?php
                                       }
                                   }
                                   ?> >
                            <label for="interior_wallsyes"></label>
                        </td>
                        <td><label class="">
                                <input type="radio" disabled="disabled" id="interior_wallsNo" <?php
                                if (isset($property->disclosure)) {
                                    if ($property->disclosure->interior_walls == config('constant.inverse_property_condition_disclaimer.No')) {
                                        ?>
                                               checked="checked"
                                               <?php
                                           }
                                       }
                                       ?> >
                                <label for="interior_wallsNo"></label>
                            </label>
                        </td>
                        <td><label class="">
                                <input type="radio" disabled="disabled" class="radio-btn-active" <?php
                                       if (isset($property->disclosure)) {
                                           if ($property->disclosure->interior_walls
                                               == config('constant.inverse_property_condition_disclaimer.NA')) {
                                               ?>
                                               checked="checked"
                                               <?php
                                           }
                                       }
                                       ?> id="interior_wallsNA" >
                                <label for="interior_wallsNA"></label>
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <td>Ceilings</td>
                        <td>
                            <input type="radio" disabled="disabled" id="Ceilingsyes"<?php
                                       if (isset($property->disclosure)) {
                                           if ($property->disclosure->ceilings == config('constant.inverse_property_condition_disclaimer.Yes')) {
                                               ?>
                                           checked="checked"
                                           <?php
                                       }
                                   }
                                   ?>  >
                            <label for="Ceilingsyes"></label>
                        </td>
                        <td><label class="">
                                <input type="radio" disabled="disabled" id="CeilingsNo" <?php
                                   if (isset($property->disclosure)) {
                                       if ($property->disclosure->ceilings == config('constant.inverse_property_condition_disclaimer.No')) {
                                           ?>
                                               checked="checked"
                                               <?php
                                           }
                                       }
                                       ?> >
                                <label for="CeilingsNo"></label>
                            </label>
                        </td>
                        <td><label class="">
                                <input type="radio" disabled="disabled" class="radio-btn-active" id="CeilingsNA" <?php
                                       if (isset($property->disclosure)) {
                                           if ($property->disclosure->ceilings == config('constant.inverse_property_condition_disclaimer.NA')) {
                                               ?>
                                               checked="checked"
                                               <?php
                                           }
                                       }
                                       ?> >
                                <label for="CeilingsNA"></label>
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <td>Floors</td>
                        <td>
                            <input type="radio" disabled="disabled" id="Floorsyes"<?php
                                       if (isset($property->disclosure)) {
                                           if ($property->disclosure->floors == config('constant.inverse_property_condition_disclaimer.Yes')) {
                                               ?>
                                           checked="checked"
                                           <?php
                                       }
                                   }
                                   ?>  >
                            <label for="Floorsyes"></label>
                        </td>
                        <td><label class="">
                                <input type="radio" disabled="disabled" id="FloorsNo" class="radio-btn-active" <?php
                                   if (isset($property->disclosure)) {
                                       if ($property->disclosure->floors == config('constant.inverse_property_condition_disclaimer.No')) {
                                           ?>
                                               checked="checked"
                                               <?php
                                           }
                                       }
                                       ?> >
                                <label for="FloorsNo"></label>
                            </label>
                        </td>
                        <td><label class="">
                                <input type="radio" disabled="disabled" class="radio-btn-active"  id="FloorsNA" <?php
                                       if (isset($property->disclosure)) {
                                           if ($property->disclosure->floors == config('constant.inverse_property_condition_disclaimer.NA')) {
                                               ?>
                                               checked="checked"
                                               <?php
                                           }
                                       }
                                       ?>>
                                <label for="FloorsNA"></label>
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <td>Windows</td>
                        <td>
                            <input type="radio" disabled="disabled"  id="Windowsyes"<?php
                                       if (isset($property->disclosure)) {
                                           if ($property->disclosure->windows == config('constant.inverse_property_condition_disclaimer.Yes')) {
                                               ?>
                                           checked="checked"
                                           <?php
                                       }
                                   }
                                   ?>  >
                            <label for="Windowsyes"></label>
                        </td>
                        <td><label class="">
                                <input type="radio" disabled="disabled"  id="WindowsNo" <?php
                                   if (isset($property->disclosure)) {
                                       if ($property->disclosure->windows == config('constant.inverse_property_condition_disclaimer.No')) {
                                           ?>
                                               checked="checked"
                                               <?php
                                           }
                                       }
                                       ?> >
                                <label for="WindowsNo"></label>
                            </label>
                        </td>
                        <td><label class="">
                                <input type="radio" disabled="disabled" class="radio-btn-active"   id="WindowsNA" <?php
                                       if (isset($property->disclosure)) {
                                           if ($property->disclosure->windows == config('constant.inverse_property_condition_disclaimer.NA')) {
                                               ?>
                                               checked="checked"
                                               <?php
                                           }
                                       }
                                       ?>>
                                <label for="WindowsNA"></label>
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <td>Doors</td>
                        <td>
                            <input type="radio" disabled="disabled"  id="Doorsyes" <?php
                                       if (isset($property->disclosure)) {
                                           if ($property->disclosure->doors == config('constant.inverse_property_condition_disclaimer.Yes')) {
                                               ?>
                                           checked="checked"
                                           <?php
                                       }
                                   }
                                   ?> >
                            <label for="Doorsyes"></label>
                        </td>

                        <td><label class="">
                                <input type="radio" disabled="disabled"  id="DoorsNo" <?php
                                   if (isset($property->disclosure)) {
                                       if ($property->disclosure->doors == config('constant.inverse_property_condition_disclaimer.No')) {
                                           ?>
                                               checked="checked"
                                               <?php
                                           }
                                       }
                                       ?> >
                                <label for="DoorsNo"></label>
                            </label>
                        </td>
                        <td><label class="">
                                <input type="radio" disabled="disabled" class="radio-btn-active"  id="DoorsNA" <?php
                                       if (isset($property->disclosure)) {
                                           if ($property->disclosure->doors == config('constant.inverse_property_condition_disclaimer.NA')) {
                                               ?>
                                               checked="checked"
                                               <?php
                                           }
                                       }
                                       ?> >
                                <label for="DoorsNA"></label>
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <td>Insulation</td>
                        <td>
                            <input type="radio" disabled="disabled"  id="Insulationyes" <?php
                                       if (isset($property->disclosure)) {
                                           if ($property->disclosure->insulation
                                               == config('constant.inverse_property_condition_disclaimer.Yes')) {
                                               ?>
                                           checked="checked"
                                           <?php
                                       }
                                   }
                                   ?> >
                            <label for="Insulationyes"></label>
                        </td>
                        <td><label class="">
                                <input type="radio" disabled="disabled"  id="InsulationNo" <?php
                                   if (isset($property->disclosure)) {
                                       if ($property->disclosure->insulation == config('constant.inverse_property_condition_disclaimer.No')) {
                                           ?>
                                               checked="checked"
                                               <?php
                                           }
                                       }
                                       ?> >
                                <label for="InsulationNo"></label>
                            </label>
                        </td>
                        <td><label class="">
                                <input type="radio" disabled="disabled" class="radio-btn-active"  <?php
                                       if (isset($property->disclosure)) {
                                           if ($property->disclosure->insulation
                                               == config('constant.inverse_property_condition_disclaimer.NA')) {
                                               ?>
                                               checked="checked"
                                               <?php
                                           }
                                       }
                                       ?> id="InsulationNA" >
                                <label for="InsulationNA"></label>
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <td>Plumbing</td>
                        <td>
                            <input type="radio" disabled="disabled"  id="Plumbingyes" <?php
                            if (isset($property->disclosure)) {
                                if ($property->disclosure->plumbing == config('constant.inverse_property_condition_disclaimer.Yes')) {
                                    ?>
                                           checked="checked"
                                           <?php
                                       }
                                   }
                                   ?> >
                            <label for="Plumbingyes"></label>
                        </td>
                        <td><label class="">
                                <input type="radio" disabled="disabled"  id="PlumbingNo" <?php
                                if (isset($property->disclosure)) {
                                    if ($property->disclosure->plumbing == config('constant.inverse_property_condition_disclaimer.No')) {
                                        ?>
                                               checked="checked"
                                               <?php
                                           }
                                       }
                                       ?> >
                                <label for="PlumbingNo"></label>
                            </label>
                        </td>
                        <td><label class="">
                                <input type="radio" disabled="disabled" class="radio-btn-active" <?php
                                if (isset($property->disclosure)) {
                                    if ($property->disclosure->plumbing == config('constant.inverse_property_condition_disclaimer.NA')) {
                                        ?>
                                               checked="checked"
                                               <?php
                                           }
                                       }
                                       ?>  id="PlumbingNA" >
                                <label for="PlumbingNA"></label>
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <td>Sewer/Septic</td>
                        <td>
                            <input type="radio" disabled="disabled"  id="SewerSepticyes" <?php
                            if (isset($property->disclosure)) {
                                if ($property->disclosure->sewer == config('constant.inverse_property_condition_disclaimer.Yes')) {
                                    ?>
                                           checked="checked"
                                           <?php
                                       }
                                   }
                                   ?> >
                            <label for="SewerSepticyes"></label>
                        </td>

                        <td><label class="">
                                <input type="radio" disabled="disabled"  id="SewerSepticNo" <?php
                                if (isset($property->disclosure)) {
                                    if ($property->disclosure->sewer == config('constant.inverse_property_condition_disclaimer.No')) {
                                        ?>
                                               checked="checked"
                                               <?php
                                           }
                                       }
                                       ?> >
                                <label for="SewerSepticNo"></label>
                            </label>
                        </td>
                        <td><label class="">
                                <input type="radio" disabled="disabled" class="radio-btn-active"  <?php
                                if (isset($property->disclosure)) {
                                    if ($property->disclosure->sewer == config('constant.inverse_property_condition_disclaimer.NA')) {
                                        ?>
                                               checked="checked"
                                               <?php
                                           }
                                       }
                                       ?> id="SewerSepticNA" >
                                <label for="SewerSepticNA"></label>
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <td>Electrical System</td>
                        <td>
                            <input type="radio" disabled="disabled"  id="Electricalyes" <?php
                            if (isset($property->disclosure)) {
                                if ($property->disclosure->electrical_system == config('constant.inverse_property_condition_disclaimer.Yes')) {
                                    ?>
                                           checked="checked"
                                           <?php
                                       }
                                   }
                                   ?> >
                            <label for="Electricalyes"></label>
                        </td>
                        <td><label class="">
                                <input type="radio" disabled="disabled"  id="ElectricalNo" <?php
                                if (isset($property->disclosure)) {
                                    if ($property->disclosure->electrical_system
                                        == config('constant.inverse_property_condition_disclaimer.No')) {
                                        ?>
                                               checked="checked"
                                               <?php
                                           }
                                       }
                                       ?> >
                                <label for="ElectricalNo"></label>
                            </label>
                        </td>
                        <td><label class="">
                                <input type="radio" disabled="disabled" class="radio-btn-active"  <?php
                                if (isset($property->disclosure)) {
                                    if ($property->disclosure->electrical_system
                                        == config('constant.inverse_property_condition_disclaimer.NA')) {
                                        ?>
                                               checked="checked"
                                               <?php
                                           }
                                       }
                                       ?> id="ElectricalNA" >
                                <label for="ElectricalNA"></label>
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <td>Exterior Walls</td>
                        <td>
                            <input type="radio" disabled="disabled"  id="Exterioryes" <?php
                            if (isset($property->disclosure)) {
                                if ($property->disclosure->exterior_walls == config('constant.inverse_property_condition_disclaimer.Yes')) {
                                    ?>
                                           checked="checked"
                                           <?php
                                       }
                                   }
                                   ?> >
                            <label for="Exterioryes"></label>
                        </td>
                        <td><label class="">
                                <input type="radio" disabled="disabled"  id="ExteriorNo" <?php
                                if (isset($property->disclosure)) {
                                    if ($property->disclosure->exterior_walls == config('constant.inverse_property_condition_disclaimer.No')) {
                                        ?>
                                               checked="checked"
                                               <?php
                                           }
                                       }
                                       ?> >
                                <label for="ExteriorNo"></label>
                            </label>
                        </td>
                        <td><label class="">
                                <input type="radio" disabled="disabled" class="radio-btn-active"  <?php
                                if (isset($property->disclosure)) {
                                    if ($property->disclosure->exterior_walls == config('constant.inverse_property_condition_disclaimer.NA')) {
                                        ?>
                                               checked="checked"
                                               <?php
                                           }
                                       }
                                       ?> id="ExteriorNA" >
                                <label for="ExteriorNA"></label>
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <td>Roof</td>
                        <td>
                            <input type="radio" disabled="disabled"  id="Roofyes" <?php
                                       if (isset($property->disclosure)) {
                                           if ($property->disclosure->roof == config('constant.inverse_property_condition_disclaimer.Yes')) {
                                               ?>
                                           checked="checked"
                                           <?php
                                       }
                                   }
                                   ?> >
                            <label for="Roofyes"></label>
                        </td>
                        <td><label class="">
                                <input type="radio" disabled="disabled"  id="RoofNo" <?php
                                   if (isset($property->disclosure)) {
                                       if ($property->disclosure->roof == config('constant.inverse_property_condition_disclaimer.No')) {
                                           ?>
                                               checked="checked"
                                               <?php
                                           }
                                       }
                                       ?> >
                                <label for="RoofNo"></label>
                            </label>
                        </td>
                        <td><label class="">
                                <input type="radio" disabled="disabled" class="radio-btn-active"  <?php
                                       if (isset($property->disclosure)) {
                                           if ($property->disclosure->roof == config('constant.inverse_property_condition_disclaimer.NA')) {
                                               ?>
                                               checked="checked"
                                               <?php
                                           }
                                       }
                                       ?> id="RoofNA" >
                                <label for="RoofNA"></label>
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <td>Basement</td>
                        <td>
                            <input type="radio" disabled="disabled"  id="Basementyes"<?php
                                       if (isset($property->disclosure)) {
                                           if ($property->disclosure->basement == config('constant.inverse_property_condition_disclaimer.Yes')) {
                                               ?>
                                           checked="checked"
                                           <?php
                                       }
                                   }
                                   ?>  >
                            <label for="Basementyes"></label>
                        </td>
                        <td><label class="">
                                <input type="radio" disabled="disabled"  id="BasementNo" <?php
                                   if (isset($property->disclosure)) {
                                       if ($property->disclosure->basement == config('constant.inverse_property_condition_disclaimer.No')) {
                                           ?>
                                               checked="checked"
                                               <?php
                                           }
                                       }
                                       ?> >
                                <label for="BasementNo"></label>
                            </label>
                        </td>
                        <td><label class="">
                                <input type="radio" disabled="disabled" class="radio-btn-active"  <?php
                                       if (isset($property->disclosure)) {
                                           if ($property->disclosure->basement == config('constant.inverse_property_condition_disclaimer.NA')) {
                                               ?>
                                               checked="checked"
                                               <?php
                                           }
                                       }
                                       ?> id="BasementNA" >
                                <label for="BasementNA"></label>
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <td>Foundation</td>
                        <td>
                            <input type="radio" disabled="disabled"  id="Foundationyes" <?php
                                       if (isset($property->disclosure)) {
                                           if ($property->disclosure->foundation
                                               == config('constant.inverse_property_condition_disclaimer.Yes')) {
                                               ?>
                                           checked="checked"
                                           <?php
                                       }
                                   }
                                   ?> >
                            <label for="Foundationyes"></label>
                        </td>
                        <td><label class="">
                                <input type="radio" disabled="disabled"  id="FoundationNo" <?php
                                   if (isset($property->disclosure)) {
                                       if ($property->disclosure->foundation == config('constant.inverse_property_condition_disclaimer.No')) {
                                           ?>
                                               checked="checked"
                                               <?php
                                           }
                                       }
                                       ?> >
                                <label for="FoundationNo"></label>
                            </label>
                        </td>
                        <td><label class="">
                                <input type="radio" disabled="disabled" class="radio-btn-active"  <?php
                                       if (isset($property->disclosure)) {
                                           if ($property->disclosure->foundation
                                               == config('constant.inverse_property_condition_disclaimer.NA')) {
                                               ?>
                                               checked="checked"
                                               <?php
                                           }
                                       }
                                       ?> id="FoundationNA" >
                                <label for="FoundationNA"></label>
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <td>Slab</td>
                        <td>
                            <input type="radio" disabled="disabled"  id="Slabyes" <?php
                                       if (isset($property->disclosure)) {
                                           if ($property->disclosure->slab == config('constant.inverse_property_condition_disclaimer.Yes')) {
                                               ?>
                                           checked="checked"
                                           <?php
                                       }
                                   }
                                   ?> >
                            <label for="Slabyes"></label>
                        </td>
                        <td><label class="">
                                <input type="radio" disabled="disabled"  id="SlabNo" <?php
                                   if (isset($property->disclosure)) {
                                       if ($property->disclosure->slab == config('constant.inverse_property_condition_disclaimer.No')) {
                                           ?>
                                               checked="checked"
                                               <?php
                                           }
                                       }
                                       ?> >
                                <label for="SlabNo"></label>
                            </label>
                        </td>
                        <td><label class="">
                                <input type="radio" disabled="disabled" class="radio-btn-active"  <?php
                                       if (isset($property->disclosure)) {
                                           if ($property->disclosure->slab == config('constant.inverse_property_condition_disclaimer.NA')) {
                                               ?>
                                               checked="checked"
                                               <?php
                                           }
                                       }
                                       ?>id="SlabNA" >
                                <label for="SlabNA"></label>
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <td>Driveway</td>
                        <td>
                            <input type="radio" disabled="disabled"  id="Drivewayyes" <?php
                                       if (isset($property->disclosure)) {
                                           if ($property->disclosure->drive_way == config('constant.inverse_property_condition_disclaimer.Yes')) {
                                               ?>
                                           checked="checked"
                                           <?php
                                       }
                                   }
                                   ?> >
                            <label for="Drivewayyes"></label>
                        </td>
                        <td><label class="">
                                <input type="radio" disabled="disabled"  id="DrivewayNo" <?php
                                   if (isset($property->disclosure)) {
                                       if ($property->disclosure->drive_way == config('constant.inverse_property_condition_disclaimer.No')) {
                                           ?>
                                               checked="checked"
                                               <?php
                                           }
                                       }
                                       ?> >
                                <label for="DrivewayNo"></label>
                            </label>
                        </td>
                        <td><label class="">
                                <input type="radio" disabled="disabled" class="radio-btn-active"  <?php
                                       if (isset($property->disclosure)) {
                                           if ($property->disclosure->drive_way == config('constant.inverse_property_condition_disclaimer.NA')) {
                                               ?>
                                               checked="checked"
                                               <?php
                                           }
                                       }
                                       ?> id="DrivewayNA" >
                                <label for="DrivewayNA"></label>
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <td>Sidewalks</td>
                        <td>
                            <input type="radio" disabled="disabled"  id="Sidewalksyes"<?php
                                       if (isset($property->disclosure)) {
                                           if ($property->disclosure->side_walks
                                               == config('constant.inverse_property_condition_disclaimer.Yes')) {
                                               ?>
                                           checked="checked"
                                           <?php
                                       }
                                   }
                                   ?>  >
                            <label for="Sidewalksyes"></label>
                        </td>
                        <td><label class="">
                                <input type="radio" disabled="disabled"  id="SidewalksNo" <?php
                                   if (isset($property->disclosure)) {
                                       if ($property->disclosure->side_walks == config('constant.inverse_property_condition_disclaimer.No')) {
                                           ?>
                                               checked="checked"
                                               <?php
                                           }
                                       }
                                       ?> >
                                <label for="SidewalksNo"></label>
                            </label>
                        </td>
                        <td><label class="">
                                <input type="radio" disabled="disabled" class="radio-btn-active"  id="SidewalksNA" <?php
                                       if (isset($property->disclosure)) {
                                           if ($property->disclosure->side_walks
                                               == config('constant.inverse_property_condition_disclaimer.NA')) {
                                               ?>
                                               checked="checked"
                                               <?php
                                           }
                                       }
                                       ?> >
                                <label for="SidewalksNA"></label>
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <td>Central Heating</td>
                        <td>
                            <input type="radio" disabled="disabled"  id="Heatingyes" <?php
                            if (isset($property->disclosure)) {
                                if ($property->disclosure->central_heating == config('constant.inverse_property_condition_disclaimer.Yes')) {
                                    ?>
                                           checked="checked"
                                           <?php
                                       }
                                   }
                                   ?> >
                            <label for="Heatingyes"></label>
                        </td>
                        <td><label class="">
                                <input type="radio" disabled="disabled"  id="HeatingNo" <?php
                                   if (isset($property->disclosure)) {
                                       if ($property->disclosure->central_heating
                                           == config('constant.inverse_property_condition_disclaimer.No')) {
                                           ?>
                                               checked="checked"
                                               <?php
                                           }
                                       }
                                       ?> >
                                <label for="HeatingNo"></label>
                            </label>
                        </td>
                        <td><label class="">
                                <input type="radio" disabled="disabled" class="radio-btn-active"  id="HeatingNA" <?php
                                       if (isset($property->disclosure)) {
                                           if ($property->disclosure->central_heating
                                               == config('constant.inverse_property_condition_disclaimer.NA')) {
                                               ?>
                                               checked="checked"
                                               <?php
                                           }
                                       }
                                       ?> >
                                <label for="HeatingNA"></label>
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <td>Heat Pump</td>
                        <td>
                            <input type="radio" disabled="disabled"  id="Pumpyes" <?php
                            if (isset($property->disclosure)) {
                                if ($property->disclosure->heat_pump == config('constant.inverse_property_condition_disclaimer.Yes')) {
                                    ?>
                                           checked="checked"
                                           <?php
                                       }
                                   }
                                   ?> >
                            <label for="Pumpyes"></label>
                        </td>
                        <td><label class="">
                                <input type="radio" disabled="disabled"  id="PumpNo" <?php
                                if (isset($property->disclosure)) {
                                    if ($property->disclosure->heat_pump == config('constant.inverse_property_condition_disclaimer.No')) {
                                        ?>
                                               checked="checked"
                                               <?php
                                           }
                                       }
                                       ?> >
                                <label for="PumpNo"></label>
                            </label>
                        </td>
                        <td><label class="">
                                <input type="radio" disabled="disabled" class="radio-btn-active"  id="PumpNA" <?php
                                if (isset($property->disclosure)) {
                                    if ($property->disclosure->heat_pump == config('constant.inverse_property_condition_disclaimer.NA')) {
                                        ?>
                                               checked="checked"
                                               <?php
                                           }
                                       }
                                       ?> >
                                <label for="PumpNA"></label>
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <td>Central Air Conditioning</td>
                        <td>
                            <input type="radio" disabled="disabled"  <?php
                            if (isset($property->disclosure)) {
                                if ($property->disclosure->central_air == config('constant.inverse_property_condition_disclaimer.Yes')) {
                                    ?>
                                           checked="checked"
                                           <?php
                                       }
                                   }
                                   ?> id="Airyes" >
                            <label for="Airyes"></label>
                        </td>
                        <td><label class="">
                                <input type="radio" disabled="disabled"  id="AirNo" <?php
                                if (isset($property->disclosure)) {
                                    if ($property->disclosure->central_air == config('constant.inverse_property_condition_disclaimer.No')) {
                                        ?>
                                               checked="checked"
                                               <?php
                                           }
                                       }
                                       ?> >
                                <label for="AirNo"></label>
                            </label>
                        </td>
                        <td><label class="">
                                <input type="radio" disabled="disabled" class="radio-btn-active"  <?php
                                if (isset($property->disclosure)) {
                                    if ($property->disclosure->central_air == config('constant.inverse_property_condition_disclaimer.NA')) {
                                        ?>
                                               checked="checked"
                                               <?php
                                           }
                                       }
                                       ?> id="AirNA" >
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
    <h5 class="col-sm-12">If any of the above in Part B are marked YES, please explain:</h5>
    <div class="col-sm-12">
        <textarea rows="2" type="text" class="form-control text-height"  disabled="disabled">{{$property->disclosure->partb_details??""}}</textarea>
    </div>
</div>
<div class="form-group">
    <h5 for="" class="col-sm-12 control-label">Please describe any repairs made by you or any previous owners of which you are aware (attach separate sheets if necessary):</h5>
    <div class="col-sm-12">
        <textarea rows="2" type="text" class="form-control text-height"  disabled="disabled">{{$property->disclosure->any_repairs??""}}</textarea>
    </div>
</div>
<div class="form-group">
    <h5 for="" class="col-sm-12 control-label">C. Is Seller AWARE of any of the following:</h5>
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
                            <input type="radio"  id="substancesyes"<?php
                                       if (isset($property->disclosure)) {
                                           if ($property->disclosure->substances
                                               == config('constant.inverse_property_condition_disclaimer.Yes')) {
                                               ?>
                                           checked="checked"
                                           <?php
                                       }
                                   }
                                   ?> >
                            <label for="substancesyes"></label>
                        </td>
                        <td><label class="">
                                <input type="radio"  disabled="disabled" id="substancesNo"<?php
                                   if (isset($property->disclosure)) {
                                       if ($property->disclosure->substances == config('constant.inverse_property_condition_disclaimer.No')) {
                                           ?>
                                               checked="checked"
                                               <?php
                                           }
                                       }
                                       ?> >
                                <label for="substancesNo"></label>
                            </label>
                        </td>
                        <td><label class="">
                                <input type="radio"  disabled="disabled"class="radio-btn-active" <?php
                                       if (isset($property->disclosure)) {
                                           if ($property->disclosure->substances
                                               == config('constant.inverse_property_condition_disclaimer.NA')) {
                                               ?>
                                               checked="checked"
                                               <?php
                                           }
                                       }
                                       ?> id="substancesNA" >
                                <label for="substancesNA"></label>
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <td>2. Features shared in common with adjoining land owners with joint rights and obligations for use and maintenance
                            (e.g. - driveways, private roads, walls, fences, wells, septic systems, etc)? </td>
                        <td>
                            <input type="radio"  disabled="disabled" id="features_sharedyes" <?php
                                       if (isset($property->disclosure)) {
                                           if ($property->disclosure->features_shared
                                               == config('constant.inverse_property_condition_disclaimer.Yes')) {
                                               ?>
                                           checked="checked"
                                           <?php
                                       }
                                   }
                                   ?>>
                            <label for="features_sharedyes"></label>
                        </td>
                        <td><label class="">
                                <input type="radio"  disabled="disabled" id="features_sharedNo"<?php
                                   if (isset($property->disclosure)) {
                                       if ($property->disclosure->features_shared
                                           == config('constant.inverse_property_condition_disclaimer.No')) {
                                           ?>
                                               checked="checked"
                                               <?php
                                           }
                                       }
                                       ?> >
                                <label for="features_sharedNo"></label>
                            </label>
                        </td>

                        <td><label class="">
                                <input type="radio"  disabled="disabled"class="radio-btn-active"  <?php
                                       if (isset($property->disclosure)) {
                                           if ($property->disclosure->features_shared
                                               == config('constant.inverse_property_condition_disclaimer.NA')) {
                                               ?>
                                               checked="checked"
                                               <?php
                                           }
                                       }
                                       ?>id="features_sharedNA" >
                                <label for="features_sharedNA"></label>
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <td>3. Any authorized changes in roads, drainage or utilities affecting the property, or contiguous to the property?</td>
                        <td>
                            <input type="radio"  disabled="disabled" id="any_authorized_changesyes"<?php
                                       if (isset($property->disclosure)) {
                                           if ($property->disclosure->any_authorized_changes
                                               == config('constant.inverse_property_condition_disclaimer.Yes')) {
                                               ?>
                                           checked="checked"
                                           <?php
                                       }
                                   }
                                   ?> >
                            <label for="any_authorized_changesyes"></label>
                        </td>

                        <td><label class="">
                                <input type="radio"  disabled="disabled" id="any_authorized_changesNo"<?php
                                   if (isset($property->disclosure)) {
                                       if ($property->disclosure->any_authorized_changes
                                           == config('constant.inverse_property_condition_disclaimer.No')) {
                                           ?>
                                               checked="checked"
                                               <?php
                                           }
                                       }
                                       ?> >
                                <label for="any_authorized_changesNo"></label>
                            </label>
                        </td>
                        <td><label class="">
                                <input type="radio"  disabled="disabled"class="radio-btn-active"  <?php
                                       if (isset($property->disclosure)) {
                                           if ($property->disclosure->any_authorized_changes
                                               == config('constant.inverse_property_condition_disclaimer.NA')) {
                                               ?>
                                               checked="checked"
                                               <?php
                                           }
                                       }
                                       ?>id="any_authorized_changesNA" >
                                <label for="any_authorized_changesNA"></label>
                            </label>
                        </td>
                    </tr>
                    <tr>
                    <tr>
                        <td>4. Any changes since the most recent survey of the property was done? (Most recent survey of property:
                            <input type="text" class="readonly" id="text-form-input"   value="{{$property->disclosure->most_recent_survey??""}}">
                            )</td>
                        <td>
                            <input type="radio"  disabled="disabled" id="surveyyes" <?php
                                       if (isset($property->disclosure)) {
                                           if ($property->disclosure->any_change_since_latest_survey
                                               == config('constant.inverse_property_condition_disclaimer.Yes')) {
                                               ?>
                                           checked="checked"
                                           <?php
                                       }
                                   }
                                   ?> >
                            <label for="surveyyes"></label>
                        </td>
                        <td><label class="">
                                <input type="radio"  disabled="disabled" id="surveyNo" <?php
                                   if (isset($property->disclosure)) {
                                       if ($property->disclosure->any_change_since_latest_survey
                                           == config('constant.inverse_property_condition_disclaimer.No')) {
                                           ?>
                                               checked="checked"
                                               <?php
                                           }
                                       }
                                       ?>>
                                <label for="surveyNo"></label>
                            </label>
                        </td>
                        <td><label class="">
                                <input type="radio"  disabled="disabled"class="radio-btn-active" <?php
                                       if (isset($property->disclosure)) {
                                           if ($property->disclosure->any_change_since_latest_survey
                                               == config('constant.inverse_property_condition_disclaimer.NA')) {
                                               ?>
                                               checked="checked"
                                               <?php
                                           }
                                       }
                                       ?> id="surveyNA" >
                                <label for="surveyNA"></label>
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <td>5. Any encroachments, easements, or similar items that may affect your ownership interest in the property?</td>
                        <td>
                            <input type="radio"  disabled="disabled" id="any_encroachmentsyes" <?php
                                       if (isset($property->disclosure)) {
                                           if ($property->disclosure->any_encroachments
                                               == config('constant.inverse_property_condition_disclaimer.Yes')) {
                                               ?>
                                           checked="checked"
                                           <?php
                                       }
                                   }
                                   ?>>
                            <label for="any_encroachmentsyes"></label>
                        </td>
                        <td><label class="">
                                <input type="radio"  disabled="disabled" id="any_encroachmentsNo" <?php
                                   if (isset($property->disclosure)) {
                                       if ($property->disclosure->any_encroachments
                                           == config('constant.inverse_property_condition_disclaimer.No')) {
                                           ?>
                                               checked="checked"
                                               <?php
                                           }
                                       }
                                       ?>>
                                <label for="any_encroachmentsNo"></label>
                            </label>
                        </td>
                        <td><label class="">
                                <input type="radio"  disabled="disabled"class="radio-btn-active"  <?php
                                       if (isset($property->disclosure)) {
                                           if ($property->disclosure->any_encroachments
                                               == config('constant.inverse_property_condition_disclaimer.NA')) {
                                               ?>
                                               checked="checked"
                                               <?php
                                           }
                                       }
                                       ?>id="any_encroachmentsNA" >
                                <label for="any_encroachmentsNA"></label>
                            </label>
                        </td>
                    </tr>
                <td>6. Room additions, structural modifications or other alterations or repairs made without necessary permits?</td>
                <td>
                    <input type="radio"  disabled="disabled" id="repairsyes" <?php
                                       if (isset($property->disclosure)) {
                                           if ($property->disclosure->repairs == config('constant.inverse_property_condition_disclaimer.Yes')) {
                                               ?>
                                   checked="checked"
                                   <?php
                               }
                           }
                           ?>>
                    <label for="repairsyes"></label>
                </td>
                <td><label class="">
                        <input type="radio"  disabled="disabled" id="repairsNo" <?php
                           if (isset($property->disclosure)) {
                               if ($property->disclosure->repairs == config('constant.inverse_property_condition_disclaimer.No')) {
                                   ?>
                                       checked="checked"
                                       <?php
                                   }
                               }
                               ?>>
                        <label for="repairsNo"></label>
                    </label>
                </td>
                <td><label class="">
                        <input type="radio"  disabled="disabled"class="radio-btn-active"  <?php
                               if (isset($property->disclosure)) {
                                   if ($property->disclosure->repairs == config('constant.inverse_property_condition_disclaimer.NA')) {
                                       ?>
                                       checked="checked"
                                       <?php
                                   }
                               }
                               ?>id="repairsNA" >
                        <label for="repairsNA"></label>
                    </label>
                </td>
                </tr>
                <tr>
                    <td>7. Room additions, structural modifications, other alterations or repairs not in compliance with building codes?</td>
                    <td>
                        <input type="radio"  disabled="disabled" <?php
                               if (isset($property->disclosure)) {
                                   if ($property->disclosure->repairs_with_building_codes
                                       == config('constant.inverse_property_condition_disclaimer.Yes')) {
                                       ?>
                                       checked="checked"
                                       <?php
                                   }
                               }
                               ?>id="buildingyes" >
                        <label for="buildingyes"></label>
                    </td>
                    <td><label class="">
                            <input type="radio"  disabled="disabled" <?php
                               if (isset($property->disclosure)) {
                                   if ($property->disclosure->repairs_with_building_codes
                                       == config('constant.inverse_property_condition_disclaimer.No')) {
                                       ?>
                                           checked="checked"
                                           <?php
                                       }
                                   }
                                   ?>id="buildingNo" >
                            <label for="buildingNo"></label>
                        </label>
                    </td>
                    <td><label class="">
                            <input type="radio"  disabled="disabled"class="radio-btn-active" <?php
                                   if (isset($property->disclosure)) {
                                       if ($property->disclosure->repairs_with_building_codes
                                           == config('constant.inverse_property_condition_disclaimer.NA')) {
                                           ?>
                                           checked="checked"
                                           <?php
                                       }
                                   }
                                   ?> id="buildingNA" >
                            <label for="buildingNA"></label>
                        </label>
                    </td>
                </tr>
                <tr>
                    <td>8. Landfill (compacted or otherwise) on the property or any portion thereof?</td>
                    <td>
                        <input type="radio"  disabled="disabled" id="landfillyes" <?php
                                   if (isset($property->disclosure)) {
                                       if ($property->disclosure->land_fill == config('constant.inverse_property_condition_disclaimer.Yes')) {
                                           ?>
                                       checked="checked"
                                       <?php
                                   }
                               }
                               ?>>
                        <label for="landfillyes"></label>
                    </td>
                    <td><label class="">
                            <input type="radio"  disabled="disabled" id="landfillNo" <?php
                               if (isset($property->disclosure)) {
                                   if ($property->disclosure->land_fill == config('constant.inverse_property_condition_disclaimer.No')) {
                                       ?>
                                           checked="checked"
                                           <?php
                                       }
                                   }
                                   ?>>
                            <label for="landfillNo"></label>
                        </label>
                    </td>
                    <td><label class="">
                            <input type="radio"  disabled="disabled"class="radio-btn-active"  <?php
                                   if (isset($property->disclosure)) {
                                       if ($property->disclosure->land_fill == config('constant.inverse_property_condition_disclaimer.NA')) {
                                           ?>
                                           checked="checked"
                                           <?php
                                       }
                                   }
                                   ?>id="landfillNA" >
                            <label for="landfillNA"></label>
                        </label>
                    </td>
                </tr>
                <tr>
                    <td>9. Any settling from any cause, or slippage, sliding or other soil problems?</td>
                    <td>
                        <input type="radio"  disabled="disabled" id="settlingyes" <?php
                                   if (isset($property->disclosure)) {
                                       if ($property->disclosure->any_settling == config('constant.inverse_property_condition_disclaimer.Yes')) {
                                           ?>
                                       checked="checked"
                                       <?php
                                   }
                               }
                               ?>>
                        <label for="settlingyes"></label>
                    </td>
                    <td><label class="">
                            <input type="radio"  disabled="disabled" id="settlingNo" <?php
                               if (isset($property->disclosure)) {
                                   if ($property->disclosure->any_settling == config('constant.inverse_property_condition_disclaimer.No')) {
                                       ?>
                                           checked="checked"
                                           <?php
                                       }
                                   }
                                   ?>>
                            <label for="settlingNo"></label>
                        </label>
                    </td>
                    <td><label class="">
                            <input type="radio"  disabled="disabled"class="radio-btn-active"  <?php
                                   if (isset($property->disclosure)) {
                                       if ($property->disclosure->any_settling == config('constant.inverse_property_condition_disclaimer.NA')) {
                                           ?>
                                           checked="checked"
                                           <?php
                                       }
                                   }
                                   ?>id="settlingNA" >
                            <label for="settlingNA"></label>
                        </label>
                    </td>
                </tr>
                <tr>
                    <td>10. Flooding, drainage or grading problems?</td>
                    <td>
                        <input type="radio"  disabled="disabled" id="problemsyes" <?php
                                   if (isset($property->disclosure)) {
                                       if ($property->disclosure->problems == config('constant.inverse_property_condition_disclaimer.Yes')) {
                                           ?>
                                       checked="checked"
                                       <?php
                                   }
                               }
                               ?>>
                        <label for="problemsyes"></label>
                    </td>
                    <td><label class="">
                            <input type="radio"  disabled="disabled" id="problemsNo" <?php
                               if (isset($property->disclosure)) {
                                   if ($property->disclosure->problems == config('constant.inverse_property_condition_disclaimer.No')) {
                                       ?>
                                           checked="checked"
                                           <?php
                                       }
                                   }
                                   ?>>
                            <label for="problemsNo"></label>
                        </label>
                    </td>
                    <td><label class="">
                            <input type="radio"  disabled="disabled"class="radio-btn-active" <?php
                                   if (isset($property->disclosure)) {
                                       if ($property->disclosure->problems == config('constant.inverse_property_condition_disclaimer.NA')) {
                                           ?>
                                           checked="checked"
                                           <?php
                                       }
                                   }
                                   ?> id="problemsNA" >
                            <label for="problemsNA"></label>
                        </label>
                    </td>
                </tr>
                <tr>
                    <td>11. Any requirement that flood insurance be maintained on the property?</td>
                    <td>
                        <input type="radio"  disabled="disabled" id="requirementyes" <?php
                                   if (isset($property->disclosure)) {
                                       if ($property->disclosure->requirement == config('constant.inverse_property_condition_disclaimer.Yes')) {
                                           ?>
                                       checked="checked"
                                       <?php
                                   }
                               }
                               ?>>
                        <label for="requirementyes"></label>
                    </td>
                    <td><label class="">
                            <input type="radio"  disabled="disabled" id="requirementNo" <?php
                               if (isset($property->disclosure)) {
                                   if ($property->disclosure->requirement == config('constant.inverse_property_condition_disclaimer.No')) {
                                       ?>
                                           checked="checked"
                                           <?php
                                       }
                                   }
                                   ?>>
                            <label for="requirementNo"></label>
                        </label>
                    </td>
                    <td><label class="">
                            <input type="radio"  disabled="disabled"class="radio-btn-active"  <?php
                                   if (isset($property->disclosure)) {
                                       if ($property->disclosure->requirement == config('constant.inverse_property_condition_disclaimer.NA')) {
                                           ?>
                                           checked="checked"
                                           <?php
                                       }
                                   }
                                   ?>id="requirementNA" >
                            <label for="requirementNA"></label>
                        </label>
                    </td>
                </tr>
                <tr>
                    <td>12. Any of the property located in a designated flood hazard area?</td>
                    <td>
                        <input type="radio"  disabled="disabled" id="locationyes"<?php
                                   if (isset($property->disclosure)) {
                                       if ($property->disclosure->location == config('constant.inverse_property_condition_disclaimer.Yes')) {
                                           ?>
                                       checked="checked"
                                       <?php
                                   }
                               }
                               ?> >
                        <label for="locationyes"></label>
                    </td>
                    <td><label class="">
                            <input type="radio"  disabled="disabled" id="locationNo"<?php
                               if (isset($property->disclosure)) {
                                   if ($property->disclosure->location == config('constant.inverse_property_condition_disclaimer.No')) {
                                       ?>
                                           checked="checked"
                                           <?php
                                       }
                                   }
                                   ?> >
                            <label for="locationNo"></label>
                        </label>
                    </td>
                    <td><label class="">
                            <input type="radio"  disabled="disabled"class="radio-btn-active" <?php
                                   if (isset($property->disclosure)) {
                                       if ($property->disclosure->location == config('constant.inverse_property_condition_disclaimer.NA')) {
                                           ?>
                                           checked="checked"
                                           <?php
                                       }
                                   }
                                   ?> id="locationNA" >
                            <label for="locationNA"></label>
                        </label>
                    </td>
                </tr>
                <tr>
                    <td>13. Any past or present interior water intrusions(s), standing water within foundation and/or basement?</td>
                    <td>
                        <input type="radio"  disabled="disabled" id="interioryes" <?php
                                   if (isset($property->disclosure)) {
                                       if ($property->disclosure->interior == config('constant.inverse_property_condition_disclaimer.Yes')) {
                                           ?>
                                       checked="checked"
                                       <?php
                                   }
                               }
                               ?> >
                        <label for="interioryes"></label>
                    </td>
                    <td><label class="">
                            <input type="radio"  disabled="disabled" id="interiorNo" <?php
                               if (isset($property->disclosure)) {
                                   if ($property->disclosure->interior == config('constant.inverse_property_condition_disclaimer.No')) {
                                       ?>
                                           checked="checked"
                                           <?php
                                       }
                                   }
                                   ?>>
                            <label for="interiorNo"></label>
                        </label>
                    </td>
                    <td><label class="">
                            <input type="radio"  disabled="disabled"class="radio-btn-active"  <?php
                                   if (isset($property->disclosure)) {
                                       if ($property->disclosure->interior == config('constant.inverse_property_condition_disclaimer.NA')) {
                                           ?>
                                           checked="checked"
                                           <?php
                                       }
                                   }
                                   ?>id="interiorNA" >
                            <label for="interiorNA"></label>
                        </label>
                    </td>
                </tr>
                <tr>
                    <td>14. Property or structural damage from fire, earthquake, floods, landslides, tremors, wind, storm, or wood
                        destroying organisms (such as termites, mold, etc.)?</td>
                    <td>
                        <input type="radio"  disabled="disabled" id="structural_damageyes" <?php
                                   if (isset($property->disclosure)) {
                                       if ($property->disclosure->structural_damage
                                           == config('constant.inverse_property_condition_disclaimer.Yes')) {
                                           ?>
                                       checked="checked"
                                       <?php
                                   }
                               }
                               ?>>
                        <label for="structural_damageyes"></label>
                    </td>
                    <td><label class="">
                            <input type="radio"  disabled="disabled" id="structural_damageNo"<?php
                            if (isset($property->disclosure)) {
                                if ($property->disclosure->structural_damage == config('constant.inverse_property_condition_disclaimer.No')) {
                                    ?>
                                           checked="checked"
                                           <?php
                                       }
                                   }
                                   ?> >
                            <label for="structural_damageNo"></label>
                        </label>
                    </td>
                    <td><label class="">
                            <input type="radio"  disabled="disabled"class="radio-btn-active"  <?php
                            if (isset($property->disclosure)) {
                                if ($property->disclosure->structural_damage == config('constant.inverse_property_condition_disclaimer.NA')) {
                                    ?>
                                           checked="checked"
                                           <?php
                                       }
                                   }
                                   ?>id="structural_damageNA" >
                            <label for="structural_damageNA"></label>
                        </label>
                    </td>
                </tr>
                <tr>
                    <td>15. Any zoning violations, nonconforming uses and/or violations of "setback" requirements?</td>
                    <td>
                        <input type="radio"  disabled="disabled" id="any_zoning_violationsyes" <?php
                        if (isset($property->disclosure)) {
                            if ($property->disclosure->any_zoning_violations == config('constant.inverse_property_condition_disclaimer.Yes')) {
                                ?>
                                       checked="checked"
                                       <?php
                                   }
                               }
                               ?>>
                        <label for="any_zoning_violationsyes"></label>
                    </td>
                    <td><label class="">
                            <input type="radio"  disabled="disabled" id="any_zoning_violationsNo" <?php
                            if (isset($property->disclosure)) {
                                if ($property->disclosure->any_zoning_violations
                                    == config('constant.inverse_property_condition_disclaimer.No')) {
                                    ?>
                                           checked="checked"
                                           <?php
                                       }
                                   }
                                   ?>>
                            <label for="any_zoning_violationsNo"></label>
                        </label>
                    </td>
                    <td><label class="">
                            <input type="radio"  disabled="disabled"class="radio-btn-active"  <?php
                            if (isset($property->disclosure)) {
                                if ($property->disclosure->any_zoning_violations
                                    == config('constant.inverse_property_condition_disclaimer.NA')) {
                                    ?>
                                           checked="checked"
                                           <?php
                                       }
                                   }
                                   ?>id="any_zoning_violationsNA" >
                            <label for="any_zoning_violationsNA"></label>
                        </label>
                    </td>
                </tr>
                <tr>
                    <td>16. Neighborhood noise problems or other nuisances?</td>
                    <td>
                        <input type="radio"  disabled="disabled" id="neighborhood_noiseyes" <?php
                        if (isset($property->disclosure)) {
                            if ($property->disclosure->neighborhood_noise == config('constant.inverse_property_condition_disclaimer.Yes')) {
                                ?>
                                       checked="checked"
                                       <?php
                                   }
                               }
                               ?>>
                        <label for="neighborhood_noiseyes"></label>
                    </td>
                    <td><label class="">
                            <input type="radio"  disabled="disabled" id="neighborhood_noiseNo" <?php
                               if (isset($property->disclosure)) {
                                   if ($property->disclosure->neighborhood_noise
                                       == config('constant.inverse_property_condition_disclaimer.No')) {
                                       ?>
                                           checked="checked"
                                           <?php
                                       }
                                   }
                                   ?>>
                            <label for="neighborhood_noiseNo"></label>
                        </label>
                    </td>
                    <td><label class="">
                            <input type="radio"  disabled="disabled"class="radio-btn-active" <?php
                            if (isset($property->disclosure)) {
                                if ($property->disclosure->neighborhood_noise == config('constant.inverse_property_condition_disclaimer.NA')) {
                                    ?>
                                           checked="checked"
                                           <?php
                                       }
                                   }
                                   ?> id="neighborhood_noiseNA" >
                            <label for="neighborhood_noiseNA"></label>
                        </label>
                    </td>
                </tr>
                <tr>
                    <td>17. Subdivision and/or deed restrictions or obligations?</td>
                    <td>
                        <input type="radio"  disabled="disabled" id="restrictionsyes" <?php
                        if (isset($property->disclosure)) {
                            if ($property->disclosure->restrictions == config('constant.inverse_property_condition_disclaimer.Yes')) {
                                ?>
                                       checked="checked"
                                       <?php
                                   }
                               }
                               ?>>
                        <label for="restrictionsyes"></label>
                    </td>
                    <td><label class="">
                            <input type="radio"  disabled="disabled" id="restrictionsNo" <?php
                            if (isset($property->disclosure)) {
                                if ($property->disclosure->restrictions == config('constant.inverse_property_condition_disclaimer.No')) {
                                    ?>
                                           checked="checked"
                                           <?php
                                       }
                                   }
                                   ?>>
                            <label for="restrictionsNo"></label>
                        </label>
                    </td>

                    <td><label class="">
                            <input type="radio"  disabled="disabled"class="radio-btn-active"  <?php
                            if (isset($property->disclosure)) {
                                if ($property->disclosure->restrictions == config('constant.inverse_property_condition_disclaimer.NA')) {
                                    ?>
                                           checked="checked"
                                           <?php
                                       }
                                   }
                                   ?>id="restrictionsNA" >
                            <label for="restrictionsNA"></label>
                        </label>
                    </td>
                </tr>
                <tr>
                    <td>18. Any "common area" (pools, tennis courts, walkways, etc), co-owned in undivided interest with others?</td>
                    <td>
                        <input type="radio"  disabled="disabled" id="any_common_areayes" <?php
                        if (isset($property->disclosure)) {
                            if ($property->disclosure->any_common_area == config('constant.inverse_property_condition_disclaimer.Yes')) {
                                ?>
                                       checked="checked"
                                       <?php
                                   }
                               }
                               ?>>
                        <label for="any_common_areayes"></label>
                    </td>
                    <td><label class="">
                            <input type="radio"  disabled="disabled" id="any_common_areaNo" <?php
                            if (isset($property->disclosure)) {
                                if ($property->disclosure->any_common_area == config('constant.inverse_property_condition_disclaimer.No')) {
                                    ?>
                                           checked="checked"
                                           <?php
                                       }
                                   }
                                   ?>>
                            <label for="any_common_areaNo"></label>
                        </label>
                    </td>
                    <td><label class="">
                            <input type="radio"  disabled="disabled"class="radio-btn-active" <?php
                            if (isset($property->disclosure)) {
                                if ($property->disclosure->any_common_area == config('constant.inverse_property_condition_disclaimer.NA')) {
                                    ?>
                                           checked="checked"
                                           <?php
                                       }
                                   }
                                   ?> id="any_common_areaNA" >
                            <label for="any_common_areaNA"></label>
                        </label>
                    </td>
                </tr>
                <tr>
                    <td>19. Any notices of abatement or citations against the property?</td>
                    <td>
                        <input type="radio"  disabled="disabled" id="any_noticesyes" <?php
                        if (isset($property->disclosure)) {
                            if ($property->disclosure->any_notices == config('constant.inverse_property_condition_disclaimer.Yes')) {
                                ?>
                                       checked="checked"
                                       <?php
                                   }
                               }
                               ?>>
                        <label for="any_noticesyes"></label>
                    </td>
                    <td><label class="">
                            <input type="radio"  disabled="disabled" id="any_noticesNo" <?php
                            if (isset($property->disclosure)) {
                                if ($property->disclosure->any_notices == config('constant.inverse_property_condition_disclaimer.No')) {
                                    ?>
                                           checked="checked"
                                           <?php
                                       }
                                   }
                                   ?>>
                            <label for="any_noticesNo"></label>
                        </label>
                    </td>
                    <td><label class="">
                            <input type="radio"  disabled="disabled"class="radio-btn-active"  <?php
                            if (isset($property->disclosure)) {
                                if ($property->disclosure->any_notices == config('constant.inverse_property_condition_disclaimer.NA')) {
                                    ?>
                                           checked="checked"
                                           <?php
                                       }
                                   }
                                   ?>id="any_noticesNA" >
                            <label for="any_noticesNA"></label>
                        </label>
                    </td>
                </tr>
                <tr>
                    <td>20. Any lawsuit(s) or proposed lawsuit(s) by or against the seller which affects or will affect the property?</td>
                    <td>
                        <input type="radio"  disabled="disabled" id="any_lawsuityes" <?php
                        if (isset($property->disclosure)) {
                            if ($property->disclosure->any_lawsuit == config('constant.inverse_property_condition_disclaimer.Yes')) {
                                ?>
                                       checked="checked"
                                       <?php
                                   }
                               }
                               ?>>
                        <label for="any_lawsuityes"></label>
                    </td>
                    <td><label class="">
                            <input type="radio"  disabled="disabled" id="any_lawsuitNo" <?php
                            if (isset($property->disclosure)) {
                                if ($property->disclosure->any_lawsuit == config('constant.inverse_property_condition_disclaimer.No')) {
                                    ?>
                                           checked="checked"
                                           <?php
                                       }
                                   }
                                   ?>>
                            <label for="any_lawsuitNo"></label>
                        </label>
                    </td>
                    <td><label class="">
                            <input type="radio"  disabled="disabled"class="radio-btn-active"  <?php
                            if (isset($property->disclosure)) {
                                if ($property->disclosure->any_lawsuit == config('constant.inverse_property_condition_disclaimer.NA')) {
                                    ?>
                                           checked="checked"
                                           <?php
                                       }
                                   }
                                   ?>id="any_lawsuitNA" >
                            <label for="any_lawsuitNA"></label>
                        </label>
                    </td>
                </tr>
                <tr>
                    <td>21. Any system, equipment or part of the property that is being leased? (e.g. security system, water softener,
                        satellite dish, etc.) Lease payoffs or assumptions should be addressed in the purchase contract.</td>
                    <td>
                        <input type="radio"  disabled="disabled" id="any_systemyes" <?php
                        if (isset($property->disclosure)) {
                            if ($property->disclosure->any_system == config('constant.inverse_property_condition_disclaimer.Yes')) {
                                ?>
                                       checked="checked"
                                       <?php
                                   }
                               }
                               ?>>
                        <label for="any_systemyes"></label>
                    </td>
                    <td><label class="">
                            <input type="radio"  disabled="disabled" id="any_systemNo" <?php
                            if (isset($property->disclosure)) {
                                if ($property->disclosure->any_system == config('constant.inverse_property_condition_disclaimer.No')) {
                                    ?>
                                           checked="checked"
                                           <?php
                                       }
                                   }
                                   ?>>
                            <label for="any_systemNo"></label>
                        </label>
                    </td>
                    <td><label class="">
                            <input type="radio"  disabled="disabled"class="radio-btn-active"  <?php
                            if (isset($property->disclosure)) {
                                if ($property->disclosure->any_system == config('constant.inverse_property_condition_disclaimer.NA')) {
                                    ?>
                                           checked="checked"
                                           <?php
                                       }
                                   }
                                   ?>id="any_systemNA" >
                            <label for="any_systemNA"></label>
                        </label>
                    </td>
                </tr>
                <tr>
                    <td>22. Any exterior wall covered with exterior insulation and finish systems (EIFS, or synthetic stucco)?
                        If yes, has there been a recent inspection to determine whether the structure has excessive moisture
                        accumulation and/or moisture related damage?  [explain below]</td>
                    <td>
                        <input type="radio"  disabled="disabled" id="any_exterioryes" <?php
                        if (isset($property->disclosure)) {
                            if ($property->disclosure->any_exterior == config('constant.inverse_property_condition_disclaimer.Yes')) {
                                ?>
                                       checked="checked"
                                       <?php
                                   }
                               }
                               ?>>
                        <label for="any_exterioryes"></label>
                    </td>
                    <td><label class="">
                            <input type="radio"  disabled="disabled" id="any_exteriorNo" <?php
                            if (isset($property->disclosure)) {
                                if ($property->disclosure->any_exterior == config('constant.inverse_property_condition_disclaimer.No')) {
                                    ?>
                                           checked="checked"
                                           <?php
                                       }
                                   }
                                   ?>>
                            <label for="any_exteriorNo"></label>
                        </label>
                    </td>
                    <td><label class="">
                            <input type="radio"  disabled="disabled"class="radio-btn-active"  <?php
                            if (isset($property->disclosure)) {
                                if ($property->disclosure->any_exterior == config('constant.inverse_property_condition_disclaimer.NA')) {
                                    ?>
                                           checked="checked"
                                           <?php
                                       }
                                   }
                                   ?>id="any_exteriorNA" >
                            <label for="any_exteriorNA"></label>
                        </label>
                    </td>
                </tr>
                <tr>
                    <td>23. Any finished rooms that are not supplied with heating and air conditioning?</td>
                    <td>
                        <input type="radio"  disabled="disabled" id="any_finished_roomsyes" <?php
                        if (isset($property->disclosure)) {
                            if ($property->disclosure->any_finished_rooms == config('constant.inverse_property_condition_disclaimer.Yes')) {
                                ?>
                                       checked="checked"
                                       <?php
                                   }
                               }
                               ?>>
                        <label for="any_finished_roomsyes"></label>
                    </td>
                    <td><label class="">
                            <input type="radio"  disabled="disabled" id="any_finished_roomsNo" <?php
                            if (isset($property->disclosure)) {
                                if ($property->disclosure->any_finished_rooms == config('constant.inverse_property_condition_disclaimer.No')) {
                                    ?>
                                           checked="checked"
                                           <?php
                                       }
                                   }
                                   ?>>
                            <label for="any_finished_roomsNo"></label>
                        </label>
                    </td>
                    <td><label class="">
                            <input type="radio"  disabled="disabled"class="radio-btn-active"  <?php
                            if (isset($property->disclosure)) {
                                if ($property->disclosure->any_finished_rooms == config('constant.inverse_property_condition_disclaimer.NA')) {
                                    ?>
                                           checked="checked"
                                           <?php
                                       }
                                   }
                                   ?>id="any_finished_roomsNA" >
                            <label for="any_finished_roomsNA"></label>
                        </label>
                    </td>
                </tr>
                <tr>
                    <td>24. Any septic tank or other private disposal system that does not have adequate capacity and approved design
                        to comply with present stateand local requirements for the actual land area and number of bedrooms?
                        If residence is on a septic system, the septic system is legally permitted for
                        <input type="number" class="readonly" id="text-form-input" min="0"  value="{{$property->disclosure->septic_tank_for_bedrooms??""}}">
                        number of bedrooms.</td>
                    <td>
                        <input type="radio"  disabled="disabled" id="any_septic_tankyes" <?php
                                   if (isset($property->disclosure)) {
                                       if ($property->disclosure->any_septic_tank
                                           == config('constant.inverse_property_condition_disclaimer.Yes')) {
                                           ?>
                                       checked="checked"
                                       <?php
                                   }
                               }
                               ?>>
                        <label for="any_septic_tankyes"></label>
                    </td>
                    <td><label class="">
                            <input type="radio"  disabled="disabled" id="any_septic_tankNo" <?php
                               if (isset($property->disclosure)) {
                                   if ($property->disclosure->any_septic_tank == config('constant.inverse_property_condition_disclaimer.No')) {
                                       ?>
                                           checked="checked"
                                           <?php
                                       }
                                   }
                                   ?>>
                            <label for="any_septic_tankNo"></label>
                        </label>
                    </td>
                    <td><label class="">
                            <input type="radio"  disabled="disabled"class="radio-btn-active"  <?php
                                   if (isset($property->disclosure)) {
                                       if ($property->disclosure->any_septic_tank
                                           == config('constant.inverse_property_condition_disclaimer.NA')) {
                                           ?>
                                           checked="checked"
                                           <?php
                                       }
                                   }
                                   ?>id="any_septic_tankNA" >
                            <label for="any_septic_tankNA"></label>
                        </label>
                    </td>
                </tr>
                <tr>
                    <td>25. The property is affected by covenants, conditions, restrictions (CCR's), or Home Owner Association by-laws requiring approval for changes, use, or alterations to the property?</td>
                    <td>
                        <input type="radio"  disabled="disabled" id="affectedyes" <?php
                        if (isset($property->disclosure)) {
                            if ($property->disclosure->affected == config('constant.inverse_property_condition_disclaimer.Yes')) {
                                ?>
                                       checked="checked"
                                       <?php
                                   }
                               }
                               ?>>
                        <label for="affectedyes"></label>
                    </td>
                    <td><label class="">
                            <input type="radio"  disabled="disabled" id="affectedNo" <?php
                            if (isset($property->disclosure)) {
                                if ($property->disclosure->affected == config('constant.inverse_property_condition_disclaimer.No')) {
                                    ?>
                                           checked="checked"
                                           <?php
                                       }
                                   }
                                   ?>>
                            <label for="affectedNo"></label>
                        </label>
                    </td>
                    <td><label class="">
                            <input type="radio"  disabled="disabled"class="radio-btn-active"  id="affectedNA" <?php
                            if (isset($property->disclosure)) {
                                if ($property->disclosure->affected == config('constant.inverse_property_condition_disclaimer.NA')) {
                                    ?>
                                           checked="checked"
                                           <?php
                                       }
                                   }
                                   ?>>
                            <label for="affectedNA"></label>
                        </label>
                    </td>
                </tr>
                <tr>
                    <td>26. The property is in an historical district or has been declared historical bya governmental authority and
                        permission must be obtained before certain improvements or aesthetic changes to the property are made?</td>
                    <td>
                        <input type="radio"  disabled="disabled"  id="in_an_historical_districtyes" <?php
                        if (isset($property->disclosure)) {
                            if ($property->disclosure->in_an_historical_district
                                == config('constant.inverse_property_condition_disclaimer.Yes')) {
                                ?>
                                       checked="checked"
                                       <?php
                                   }
                               }
                               ?>>
                        <label for="in_an_historical_districtyes"></label>
                    </td>

                    <td><label class="">
                            <input type="radio"  disabled="disabled" id="in_an_historical_districtNo" <?php
                            if (isset($property->disclosure)) {
                                if ($property->disclosure->in_an_historical_district
                                    == config('constant.inverse_property_condition_disclaimer.No')) {
                                    ?>
                                           checked="checked"
                                           <?php
                                       }
                                   }
                                   ?>>
                            <label for="in_an_historical_districtNo"></label>
                        </label>
                    </td>
                    <td><label class="">
                            <input type="radio"  disabled="disabled"class="radio-btn-active"  <?php
                            if (isset($property->disclosure)) {
                                if ($property->disclosure->in_an_historical_district
                                    == config('constant.inverse_property_condition_disclaimer.NA')) {
                                    ?>
                                           checked="checked"
                                           <?php
                                       }
                                   }
                                   ?>id="in_an_historical_districtNA" >
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
        <textarea rows="2" type="text" class="form-control text-height"  disabled="disabled"  >{{$property->disclosure->partc_details??""}}</textarea>
    </div>
</div>
<div class="form-group">
    <div class="col-sm-12">
        <p class="offer-text">Seller certifies that this information is true and correct to the best of seller's knowledge as of the date signed.</p>
        @if(!empty($property->property_type) && $property->property_type == config('constant.inverse_property_type.Sale'))
            <p class="offer-text">Buyer understands that this Disclosure is not intended as a substitute for any inspection, and that buyer has a responsibility to pay diligent attention to and inquire about defects which are evident by careful observation. Buyer acknowledges receipt of a copy of this Disclosure. </p>
        @endif
    </div>
</div>