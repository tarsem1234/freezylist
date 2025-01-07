@extends('frontend.layouts.app')

@section ('title', ('Dashboard'))
@section('after-styles')
{{ Html::style(mix('css/dashboard.css')) }}
@endsection 
@section('content')
<div class="dashboard-page">    
    <div class="container">
        <div class="row content">          
            @include('frontend.includes.sidebar')          
            <div class="col-md-9 col-sm-8">

                <form class="form-horizontal" name="lead-based-paint-hazards" method="post" role="form" id="lease-agreement-form" enctype="multipart/form-data" action="http://www.freezylist.com/disclosure_by_seller_update.php?type=sale&amp;listingid=185&amp;offerid=176&amp;ownerid=243&amp;last_insert_id=62">

                    <p><span>INSTRUCTIONS TO THE SELLER</span><br>

                    Complete this form yourself and answer each question to the best of your knowledge. If an answer is an estimate, clearly label it 

                    as such. Explain any YES answers and describe the nature and extent of any defects or repairs. If more space is needed, attach 

                    additional sheets. You may also attach any documents pertaining to repairs or corrections. The Seller  hereby authorizes any real 

                    estate licensee involved in this transaction to provide a copy of this statement to any person or entity in connection with any actual 

                    or anticipated sale of the subject property. </p>

                    <div class="form-group">
                        <label for="" class="col-sm-4 control-label">1. Property age: </label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" id="inputPassword3" name="propertyage" value="30">
                        </div>

                    </div>

                    <div class="form-group">
                        <label for="inputPassword3" class="col-sm-4 control-label">2. Date seller acquired the property: </label>
                        <div class="col-sm-6">
                            <input type="text" class="form-control" placeholder="Date added" name="date_added" id="acquireddatetimepicker" value="2018/06/25 11:20">
                        </div>

                    </div>

                    <div class="form-group">
                        <label for="inputPassword3" class="col-sm-4 control-label">3. Does seller currently occupy the property? </label>
                        <div class="col-sm-8">
                            <label class="radio-inline">
                                <input type="radio" name="occupy" id="inlineRadio1" value="Seller occupies property" checked="">
                                Seller occupies property </label>
                            <label class="radio-inline">
                                <input type="radio" name="occupy" id="inlineRadio2" value="Seller does not occupy property">
                                Seller does not occupy property </label>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="" class="col-sm-9 control-label">4. If not currently seller-occupied, how long has it been since the seller did occupy the property, if ever?</label>
                        <input type="text" class="" id="text-form-input" style="width: 100px;" name="howlong" value="">
                    </div>

                    <div class="form-group">
                        <label for="inputPassword3" class="col-sm-3 control-label">5. The property is a</label>
                        <div class="col-sm-9">
                            <label class="radio-inline">
                                <input type="radio" name="propertyis" id="inlineRadio1" value="site-built home">site-built home </label>
                            <label class="radio-inline" style="margin-left: 0px;">
                                <input type="radio" name="propertyis" id="inlineRadio2" value="non-site-built home" checked="">non-site-built home (e.g. - modular, manufactured, mobile) </label>
                        </div>
                    </div>

                    <p>6. Roof type (e.g. - composition asphalt shingle, wood, metal, tile):
                        <input type="text" class="text-form-input" id="text-form-input" style="width: 250px;" name="rooftype" value="">
                        (Approx. age of roof:
                        <input type="text" class="" id="text-form-input" style="width: 250px;" name="roofage" value="">
                        ) </p>

                    <div class="form-group">
                        <label for="inputPassword3" class="col-sm-8 control-label">7. Is there a Homeowners Association (HOA) which has any authority over the subject property?</label>
                        <div class="col-sm-4">
                            <label class="radio-inline">
                                <input type="radio" name="houseowners_associations" id="inlineRadio1" value="Yes">
                                Yes </label>
                            <label class="radio-inline">
                                <input type="radio" name="houseowners_associations" id="inlineRadio2" value="No" checked="">
                                No </label>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="" class="col-sm-3 control-label">Name &amp; address of HOA:</label>
                        <div class="col-sm-4">
                            <input type="text" class="text-form-input" id="text-form-input" style="width: 280px;" name="name_address" value="">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="" class="col-sm-3 control-label">Monthly Dues:</label>
                        <div class="col-sm-4">
                            <input type="text" class="text-form-input" id="text-form-input" style="width: 280px;" name="monthly_dues" value="">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="" class="col-sm-3 control-label">Transfer Fees:</label>
                        <div class="col-sm-4">
                            <input type="text" class="text-form-input" id="text-form-input" style="width: 280px;" name="transfer_fees" value="">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="" class="col-sm-3 control-label">Special Assessments:</label>
                        <div class="col-sm-4">
                            <input type="text" class="text-form-input" id="text-form-input" style="width: 280px;" name="special_assessments" value="">
                        </div>
                    </div>

                    <p><span>A. The property includes the items checked below:</span></p>

                    <div class="row">
                        <div class="col-md-4">
                            <label class="checkbox-inline">
                                <input type="checkbox" name="property_includes[]" id="inlineRadio1" value="Range">
                                Range </label>
                        </div>

                        <div class="col-md-4">
                            <label class="checkbox-inline">
                                <input type="checkbox" name="property_includes[]" id="inlineRadio1" value="Spa/Whirlpool Tub">
                                Spa/Whirlpool Tub </label>

                        </div>

                        <div class="col-md-4">
                            <label class="checkbox-inline">
                                <input type="checkbox" name="property_includes[]" id="inlineRadio1" value="Access to Public Streets">
                                Access to Public Streets </label>
                        </div>

                        <div class="col-md-4">
                            <label class="checkbox-inline">
                                <input type="checkbox" name="property_includes[]" id="inlineRadio1" value="Microwave">
                                Microwave </label>
                        </div>

                        <div class="col-md-4">
                            <label class="checkbox-inline">
                               <input type="checkbox" name="property_includes[]" id="inlineRadio1" value="Hot Tub">
                                Hot Tub </label>
                        </div>

                        <div class="col-md-4">
                           <label class="checkbox-inline">
                                <input type="checkbox" name="property_includes[]" id="inlineRadio1" value="Current Termite Contract">
                                Current Termite Contract </label>
                        </div>

                        <div class="col-md-4">
                            <label class="checkbox-inline">
                                <input type="checkbox" name="property_includes[]" id="inlineRadio1" value="Garbage Disposal">
                                Garbage Disposal </label>
                        </div>

                        <div class="col-md-4">
                            <label class="checkbox-inline">
                                <input type="checkbox" name="property_includes[]" id="inlineRadio1" value="Sauna">
                                Sauna </label>
                        </div>

                        <div class="col-md-4">
                            <label class="checkbox-inline">
                                <input type="checkbox" name="property_includes[]" id="inlineRadio1" value="TV Antenna/Satellite Dish">
                                TV Antenna/Satellite Dish 
                                - excluding components </label>
                        </div>

                        <div class="col-md-4">
                            <label class="checkbox-inline">
                               <input type="checkbox" name="property_includes[]" id="inlineRadio1" value="Trash Compactor">
                                Trash Compactor </label>
                        </div>

                        <div class="col-md-4">

                            <label class="checkbox-inline">
                                <input type="checkbox" name="property_includes[]" id="inlineRadio1" value="Water Softener">

                                Water Softener </label>

                        </div>

                        <div class="col-md-4">

                            <label class="checkbox-inline">

                                <input type="checkbox" name="property_includes[]" id="inlineRadio1" value="220 Volt Wiring">

                                220 Volt Wiring </label>

                        </div>

                        <div class="col-md-4">

                            <label class="checkbox-inline">

                                <input type="checkbox" name="property_includes[]" id="inlineRadio1" value="Washer/Dryer Hookups">

                                Washer/Dryer Hookups </label>

                        </div>

                        <div class="col-md-4">

                            <label class="checkbox-inline">

                                <input type="checkbox" name="property_includes[]" id="inlineRadio1" value="Window Screens">

                                Window Screens </label>

                        </div>

                        <div class="col-md-4">

                            <label class="checkbox-inline">

                                <input type="checkbox" name="property_includes[]" id="inlineRadio1" value="Fireplace">

                                Fireplace (How many? </label>

                            <input type="text" class="" id="text-form-input" name="howmany" style="width: 30px;" value="">

                            ) </div>

                        <div class="col-md-4">

                            <label class="checkbox-inline">

                                <input type="checkbox" name="property_includes[]" id="inlineRadio1" value="Gas Starter for Fireplace">

                                Gas Starter for Fireplace </label>

                        </div>

                        <div class="col-md-4">

                            <label class="checkbox-inline">

                                <input type="checkbox" name="property_includes[]" id="inlineRadio1" value="Gas Fireplace Logs">

                                Gas Fireplace Logs </label>

                        </div>

                        <div class="col-md-4">

                            <label class="checkbox-inline">

                                <input type="checkbox" name="property_includes[]" id="inlineRadio1" value="All Landscaping and Outdoor Lighting">

                                All Landscaping and Outdoor Lighting </label>

                        </div>

                        <div class="col-md-4">

                            <label class="checkbox-inline">

                                <input type="checkbox" name="property_includes[]" id="inlineRadio1" value="Patio/Decking/Gazebo">

                                Patio/Decking/Gazebo </label>

                        </div>

                        <div class="col-md-4">

                            <label class="checkbox-inline">

                                <input type="checkbox" name="property_includes[]" id="inlineRadio1" value="Irrigation System">

                                Irrigation System </label>

                        </div>

                        <div class="col-md-4">

                            <label class="checkbox-inline">

                                <input type="checkbox" name="property_includes[]" id="inlineRadio1" value="Installed Outdoor Cooking Grill">

                                Installed Outdoor Cooking Grill </label>

                        </div>

                        <div class="col-md-4">

                            <label class="checkbox-inline">

                                <input type="checkbox" name="property_includes[]" id="inlineRadio1" value="Intercom">

                                Intercom </label>

                        </div>

                        <div class="col-md-4">

                            <label class="checkbox-inline">

                                <input type="checkbox" name="property_includes[]" id="inlineRadio1" value="Rain Gutters">

                                Rain Gutters </label>

                        </div>

                        <div class="col-md-4">

                            <label class="checkbox-inline">

                                <input type="checkbox" name="property_includes[]" id="inlineRadio1" value="Sump Pump">

                                Sump Pump </label>

                        </div>

                        <div class="col-md-4">

                            <label class="checkbox-inline">

                                <input type="checkbox" name="property_includes[]" id="inlineRadio1" value="Central Vacuum System and attachments">

                                Central Vacuum System and attachments </label>

                        </div>

                        <div class="col-md-4">

                            <label class="checkbox-inline">

                                <input type="checkbox" name="property_includes[]" id="inlineRadio1" value="A key to all exterior doors">

                                A key to all exterior doors </label>

                        </div>

                        <div class="col-md-4">

                            <label class="checkbox-inline">

                                <input type="checkbox" name="property_includes[]" id="inlineRadio1" value="Pool" checked="checked">

                                Pool <br>

                                <label class="radio-inline" style="font-size: 14px;">

                                    <input type="radio" name="pool" id="inlineRadio1" value="In-ground">

                                    In-ground </label>

                                <label class="radio-inline" style="font-size: 14px;">

                                    <input type="radio" name="pool" id="inlineRadio2" value="Above-ground" checked="">

                                    Above-ground </label>

                            </label>

                        </div>

                        <div class="col-md-4">

                            <label class="checkbox-inline">

                                <input type="checkbox" name="property_includes[]" id="inlineRadio1" value="Carport">

                                Carport </label>

                        </div>

                        <div class="col-md-4">

                            <label class="checkbox-inline">

                                <input type="checkbox" name="property_includes[]" id="inlineRadio1" value="Smoke Detector">

                                Smoke Detector/Fire Alarm </label>

                        </div>

                        <div class="col-md-4">

                            <label class="checkbox-inline">

                                <input type="checkbox" name="property_includes[]" id="inlineRadio1" value="Garage" checked="checked">

                                Garage <br>

                                <label class="radio-inline" style="font-size: 14px;">

                                    <input type="radio" name="garage" id="inlineRadio1" value="Attached">

                                    Attached </label>

                                <label class="radio-inline" style="font-size: 14px;">

                                    <input type="radio" name="garage" id="inlineRadio2" value="Not Attached" checked="">

                                    Not Attached </label>

                            </label>

                        </div>

                        <div class="col-md-4">

                            <label class="checkbox-inline">

                                <input type="checkbox" name="property_includes[]" id="inlineRadio1" value="Garage Door Opener" checked="checked">

                                Garage Door Opener(s) and remotes. 

                                How many remotes?</label>

                            <input type="text" class="" id="text-form-input" style="width: 30px;" name="how_many_remotes" value="">



                        </div>

                        <div class="col-md-4">

                            <label class="checkbox-inline">

                                <input type="checkbox" name="property_includes[]" id="inlineRadio1" value="Burglar Alarm/Security System">

                                Burglar Alarm/Security System 

                                - including components and controls </label>

                        </div>

                        <div class="col-md-4">

                            <label class="checkbox-inline">

                                <input type="checkbox" name="property_includes[]" id="inlineRadio1" value="Wall/Window Air Conditioning">

                                Wall/Window Air Conditioning </label>

                        </div>

                        <div class="col-md-4">

                            <label class="checkbox-inline">

                                <input type="checkbox" name="property_includes[]" id="inlineRadio1" value="Heat Pump" checked="checked">

                                Heat Pump (Approx. age: </label>

                            <input type="text" class="" id="text-form-input" style="width: 20px;" name="heat_pump_age" value="">

                            ) </div>

                    </div>

                    <br>

                    <br>

                    <div class="row">

                        <div class="col-md-4">

                            <label class="checkbox-inline">

                                <input type="checkbox" name="property_includes[]" id="inlineRadio1" value="Central Heating" checked="checked">

                                Central Heating </label>

                        </div>

                        <div class="col-md-2">

                            <div class="form-group">

                                <label for="inputEmail3" class="col-sm-2 control-label">Age:</label>

                                <div class="col-sm-8">

                                    <input type="text" class="text-form-input" id="text-form-input" style="width: 50px;" name="central_heating_age" value="">

                                </div>

                            </div>

                        </div>

                        <div class="col-md-6">

                            <label class="checkbox-inline">

                                <input type="checkbox" id="inlineCheckbox1" name="property_includes[]" value="CHElectric">

                                Electric </label>

                            <label class="checkbox-inline">

                                <input type="checkbox" id="inlineCheckbox2" name="property_includes[]" value="CHGas" checked="checked">

                                Gas </label>

                            <label class="checkbox-inline">

                                <input type="checkbox" id="inlineCheckbox3" name="property_includes[]" value="CHOther">

                                Other: </label>

                        </div>

                    </div>

                    <div class="row">

                        <div class="col-md-4">

                            <label class="checkbox-inline">

                                <input type="checkbox" name="property_includes[]" id="inlineRadio1" value="Central Air Conditioning">

                                Central Air Conditioning </label>

                        </div>

                        <div class="col-md-2">

                            <div class="form-group">

                                <label for="inputEmail3" class="col-sm-2 control-label">Age:</label>

                                <div class="col-sm-8">

                                    <input type="text" class="text-form-input" id="text-form-input" style="width: 50px;" name="central_air_conditioning_age" value="">

                                </div>

                            </div>

                        </div>

                        <div class="col-md-6">

                            <label class="checkbox-inline">

                                <input type="checkbox" id="inlineCheckbox1" name="property_includes[]" value="CACElectric">

                                Electric </label>

                            <label class="checkbox-inline">

                                <input type="checkbox" id="inlineCheckbox2" name="property_includes[]" value="CACGas">

                                Gas </label>

                            <label class="checkbox-inline">

                                <input type="checkbox" id="inlineCheckbox3" name="property_includes[]" value="CACOther">

                                Other: </label>

                        </div>

                    </div>

                    <div class="row">

                        <div class="col-md-4">

                            <label class="checkbox-inline">

                                <input type="checkbox" name="property_includes[]" id="inlineRadio1" value="Water Heater">

                                Water Heater </label>

                        </div>

                        <div class="col-md-2">

                            <div class="form-group">

                                <label for="inputEmail3" class="col-sm-2 control-label">Age:</label>

                                <div class="col-sm-8">

                                    <input type="text" class="text-form-input" id="text-form-input" style="width: 50px;" name="water_heater_age" value="">

                                </div>

                            </div>

                        </div>

                        <div class="col-md-6">

                            <label class="checkbox-inline">

                                <input type="checkbox" id="inlineCheckbox1" name="property_includes[]" value="WHElectric">

                                Electric </label>

                            <label class="checkbox-inline">

                                <input type="checkbox" id="inlineCheckbox2" name="property_includes[]" value="WHGas">

                                Gas </label>

                            <label class="checkbox-inline">

                                <input type="checkbox" id="inlineCheckbox3" name="property_includes[]" value="WHOther">

                                Other:(solar, geothermal, tankless, etc): </label>

                        </div>

                    </div>

                    <div class="row">

                        <div class="col-md-4">

                            <label class="checkbox-inline">

                                <input type="checkbox" name="property_includes[]" id="inlineRadio1" value="Water Supply">

                                Water Supply </label>

                        </div>

                        <div class="col-md-8">

                            <label class="checkbox-inline">

                                <input type="checkbox" id="inlineCheckbox1" name="property_includes[]" value="City Water">

                                City Water </label>

                            <label class="checkbox-inline">

                                <input type="checkbox" id="inlineCheckbox2" name="property_includes[]" value="Private Well">

                                Private Well </label>

                            <label class="checkbox-inline">

                                <input type="checkbox" id="inlineCheckbox3" name="property_includes[]" value="Shared Well">

                                Shared Well </label>

                            <label class="checkbox-inline">

                                <input type="checkbox" id="inlineCheckbox3" name="property_includes[]" value="WSOther">

                                Other: </label>

                        </div>

                    </div>

                    <div class="row">

                        <div class="col-md-4">

                            <label class="checkbox-inline">

                                <input type="checkbox" name="property_includes[]" id="inlineRadio1" value="Sewage Disposal">

                                Sewage Disposal </label>

                        </div>

                        <div class="col-md-8">

                            <label class="checkbox-inline">

                                <input type="checkbox" id="inlineCheckbox1" name="property_includes[]" value="City Sewer">

                                City Sewer </label>

                            <label class="checkbox-inline">

                                <input type="checkbox" id="inlineCheckbox2" name="property_includes[]" value="Septic Tank">

                                Septic Tank </label>

                            <label class="checkbox-inline">

                                <input type="checkbox" id="inlineCheckbox3" name="property_includes[]" value="STEP System">

                                STEP System </label>

                            <label class="checkbox-inline">

                                <input type="checkbox" id="inlineCheckbox3" name="property_includes[]" value="SDOther">

                                Other: </label>

                        </div>

                    </div>

                    <div class="row">

                        <div class="col-md-4">

                            <label class="checkbox-inline">

                                <input type="checkbox" name="property_includes[]" id="inlineRadio1" value="Gas Supply">

                                Gas Supply </label>

                        </div>

                        <div class="col-md-8">

                            <label class="checkbox-inline">

                                <input type="checkbox" id="inlineCheckbox1" name="property_includes[]" value="Utility">

                                Utility </label>

                            <label class="checkbox-inline">

                                <input type="checkbox" id="inlineCheckbox2" name="property_includes[]" value="Propane Tank">

                                Propane Tank </label>

                            <label class="checkbox-inline">

                                <input type="checkbox" id="inlineCheckbox3" name="property_includes[]" value="GSOther">

                                Other: </label>

                        </div>

                    </div>

                    <div class="row">

                        <div class="form-group" style="margin-left: 0px;">

                            <label for="inputEmail3" class="col-sm-4 control-label">Other items included:</label>

                            <div class="col-sm-6">

                                <input type="text" class="text-form-input" id="text-form-input" style="width: 100%;" name="other_items_included" value="">

                            </div>

                        </div>

                    </div>

                    <br>

                    <br>

                    <div class="form-group">

                        <label for="inputPassword3" class="col-sm-8 control-label">To the best of seller's knowledge, are any in Part A above NOT in operating condition:</label>

                        <div class="col-sm-4">

                            <label class="radio-inline">

                                <input type="radio" name="bsknowledge" id="inlineRadio1" value="Yes">

                                Yes </label>

                            <label class="radio-inline">

                                <input type="radio" name="bsknowledge" id="inlineRadio2" value="No" checked="">

                                No </label>

                        </div>

                    </div>

                    <div class="form-group">

                        <div class="col-sm-12">

                            <textarea rows="4" type="text" class="form-control" id="inputEmail3" name="bsknowledgedetails"></textarea>

                        </div>

                    </div>

                    <p><span>B. Is Seller AWARE of any defects or malfunctions in any of the following?</span></p>

                    <div class="form-group">

                        <div class="col-sm-6">

                            <table class="table table-bordered" id="Seller-checkbox-table">

                                <thead>

                                    <tr>

                                    <th></th>

                                    <th>Yes</th>

                                    <th>No</th>

                                    <th>N/A</th>

                                    </tr>

                                </thead>

                                <tbody>

                                    <tr>

                                    <td>Interior Walls</td>

                                    <td><label class="radio-inline">

                                        <input type="radio" name="interior_walls" id="inlineRadio2" value="Yes">

                                    </label>

                                    </td>

                                    <td><label class="radio-inline">

                                        <input type="radio" name="interior_walls" id="inlineRadio2" value="No">

                                    </label>

                                    </td>

                                    <td><label class="radio-inline">

                                        <input type="radio" name="interior_walls" id="inlineRadio2" value="N/A">

                                    </label>

                                    </td>

                                    </tr>

                                    <tr>

                                    <td>Ceilings</td>

                                    <td><label class="radio-inline">

                                        <input type="radio" name="ceilings" id="inlineRadio2" value="Yes">

                                    </label>

                                    </td>

                                    <td><label class="radio-inline">

                                        <input type="radio" name="ceilings" id="inlineRadio2" value="No">

                                    </label>

                                    </td>

                                    <td><label class="radio-inline">

                                        <input type="radio" name="ceilings" id="inlineRadio2" value="N/A">

                                    </label>

                                    </td>

                                    </tr>

                                    <tr>

                                    <td>Floors</td>

                                    <td><label class="radio-inline">

                                        <input type="radio" name="floors" id="inlineRadio2" value="Yes">

                                    </label>

                                    </td>

                                    <td><label class="radio-inline">

                                        <input type="radio" name="floors" id="inlineRadio2" value="No">

                                    </label>

                                    </td>

                                    <td><label class="radio-inline">

                                        <input type="radio" name="floors" id="inlineRadio2" value="N/A">

                                    </label>

                                    </td>

                                    </tr>

                                    <tr>

                                    <td>Windows</td>

                                    <td><label class="radio-inline">

                                        <input type="radio" name="windows" id="inlineRadio2" value="Yes">

                                    </label>

                                    </td>

                                    <td><label class="radio-inline">

                                        <input type="radio" name="windows" id="inlineRadio2" value="No">

                                    </label>

                                    </td>

                                    <td><label class="radio-inline">

                                        <input type="radio" name="windows" id="inlineRadio2" value="N/A">

                                    </label>

                                    </td>

                                    </tr>

                                    <tr>

                                    <td>Doors</td>

                                    <td><label class="radio-inline">

                                        <input type="radio" name="doors" id="inlineRadio2" value="Yes">

                                    </label>

                                    </td>

                                    <td><label class="radio-inline">

                                        <input type="radio" name="doors" id="inlineRadio2" value="No">

                                    </label>

                                    </td>

                                    <td><label class="radio-inline">

                                        <input type="radio" name="doors" id="inlineRadio2" value="N/A">

                                    </label>

                                    </td>

                                    </tr>

                                    <tr>

                                    <td>Insulation</td>

                                    <td><label class="radio-inline">

                                        <input type="radio" name="insulation" id="inlineRadio2" value="Yes">

                                    </label>

                                    </td>

                                    <td><label class="radio-inline">

                                        <input type="radio" name="insulation" id="inlineRadio2" value="No">

                                    </label>

                                    </td>

                                    <td><label class="radio-inline">

                                        <input type="radio" name="insulation" id="inlineRadio2" value="N/A">

                                    </label>

                                    </td>

                                    </tr>

                                    <tr>

                                    <td>Plumbing</td>

                                    <td><label class="radio-inline">

                                        <input type="radio" name="plumbing" id="inlineRadio2" value="Yes">

                                    </label>

                                    </td>

                                    <td><label class="radio-inline">

                                        <input type="radio" name="plumbing" id="inlineRadio2" value="No" checked="">

                                    </label>

                                    </td>

                                    <td><label class="radio-inline">

                                        <input type="radio" name="plumbing" id="inlineRadio2" value="N/A">

                                    </label>

                                    </td>

                                    </tr>

                                    <tr>

                                    <td>Sewer/Septic</td>

                                    <td><label class="radio-inline">

                                        <input type="radio" name="sewer" id="inlineRadio2" value="Yes">

                                    </label>

                                    </td>

                                    <td><label class="radio-inline">

                                        <input type="radio" name="sewer" id="inlineRadio2" value="No">

                                    </label>

                                    </td>

                                    <td><label class="radio-inline">

                                        <input type="radio" name="sewer" id="inlineRadio2" value="N/A">

                                    </label>

                                    </td>

                                    </tr>

                                    <tr>

                                    <td>Electrical System</td>

                                    <td><label class="radio-inline">

                                        <input type="radio" name="electrical_system" id="inlineRadio2" value="Yes">

                                    </label>

                                    </td>

                                    <td><label class="radio-inline">

                                        <input type="radio" name="electrical_system" id="inlineRadio2" value="No">

                                    </label>

                                    </td>

                                    <td><label class="radio-inline">

                                        <input type="radio" name="electrical_system" id="inlineRadio2" value="N/A">

                                    </label>

                                    </td>

                                    </tr>

                                    <tr>

                                    <td>Exterior Walls</td>

                                    <td><label class="radio-inline">

                                        <input type="radio" name="exterior_walls" id="inlineRadio2" value="Yes">

                                    </label>

                                    </td>

                                    <td><label class="radio-inline">

                                        <input type="radio" name="exterior_walls" id="inlineRadio2" value="No">

                                    </label>

                                    </td>

                                    <td><label class="radio-inline">

                                        <input type="radio" name="exterior_walls" id="inlineRadio2" value="N/A">

                                    </label>

                                    </td>

                                    </tr>

                                </tbody>

                            </table>

                        </div>

                        <div class="col-sm-6">

                            <table class="table table-bordered" id="Seller-checkbox-table">

                                <thead>

                                    <tr>

                                    <th></th>

                                    <th>Yes</th>

                                    <th>No</th>

                                    <th>N/A</th>

                                    </tr>

                                </thead>

                                <tbody>

                                    <tr>

                                    <td>Roof</td>

                                    <td><label class="radio-inline">

                                        <input type="radio" name="roof" id="inlineRadio2" value="Yes">

                                    </label>

                                    </td>

                                    <td><label class="radio-inline">

                                        <input type="radio" name="roof" id="inlineRadio2" value="No">

                                    </label>

                                    </td>

                                    <td><label class="radio-inline">

                                        <input type="radio" name="roof" id="inlineRadio2" value="N/A">

                                    </label>

                                    </td>

                                    </tr>

                                    <tr>

                                    <td>Basement</td>

                                    <td><label class="radio-inline">

                                        <input type="radio" name="basement" id="inlineRadio2" value="Yes">

                                    </label>

                                    </td>

                                    <td><label class="radio-inline">

                                        <input type="radio" name="basement" id="inlineRadio2" value="No">

                                    </label>

                                    </td>

                                    <td><label class="radio-inline">

                                        <input type="radio" name="basement" id="inlineRadio2" value="N/A">

                                    </label>

                                    </td>

                                    </tr>

                                    <tr>

                                    <td>Foundation</td>

                                    <td><label class="radio-inline">

                                        <input type="radio" name="foundation" id="inlineRadio2" value="Yes">

                                    </label>

                                    </td>

                                    <td><label class="radio-inline">

                                        <input type="radio" name="foundation" id="inlineRadio2" value="No">

                                    </label>

                                    </td>

                                    <td><label class="radio-inline">

                                        <input type="radio" name="foundation" id="inlineRadio2" value="N/A">

                                    </label>

                                    </td>

                                    </tr>

                                    <tr>

                                    <td>Slab</td>

                                    <td><label class="radio-inline">

                                        <input type="radio" name="slab" id="inlineRadio2" value="Yes">

                                    </label>

                                    </td>

                                    <td><label class="radio-inline">

                                        <input type="radio" name="slab" id="inlineRadio2" value="No">

                                    </label>

                                    </td>

                                    <td><label class="radio-inline">

                                        <input type="radio" name="slab" id="inlineRadio2" value="N/A">

                                    </label>

                                    </td>

                                    </tr>

                                    <tr>

                                    <td>Driveway</td>

                                    <td><label class="radio-inline">

                                        <input type="radio" name="driveway" id="inlineRadio2" value="Yes">

                                    </label>

                                    </td>

                                    <td><label class="radio-inline">

                                        <input type="radio" name="driveway" id="inlineRadio2" value="No">

                                    </label>

                                    </td>

                                    <td><label class="radio-inline">

                                        <input type="radio" name="driveway" id="inlineRadio2" value="N/A">

                                    </label>

                                    </td>

                                    </tr>

                                    <tr>

                                    <td>Sidewalks</td>

                                    <td><label class="radio-inline">

                                        <input type="radio" name="sidewalks" id="inlineRadio2" value="Yes">

                                    </label>

                                    </td>

                                    <td><label class="radio-inline">

                                        <input type="radio" name="sidewalks" id="inlineRadio2" value="No">

                                    </label>

                                    </td>

                                    <td><label class="radio-inline">

                                        <input type="radio" name="sidewalks" id="inlineRadio2" value="N/A">

                                    </label>

                                    </td>

                                    </tr>

                                    <tr>

                                    <td>Central Heating</td>

                                    <td><label class="radio-inline">

                                        <input type="radio" name="central_heating" id="inlineRadio2" value="Yes">

                                    </label>

                                    </td>

                                    <td><label class="radio-inline">

                                        <input type="radio" name="central_heating" id="inlineRadio2" value="No">

                                    </label>

                                    </td>

                                    <td><label class="radio-inline">

                                        <input type="radio" name="central_heating" id="inlineRadio2" value="N/A">

                                    </label>

                                    </td>

                                    </tr>

                                    <tr>

                                    <td>Heat Pump</td>

                                    <td><label class="radio-inline">

                                        <input type="radio" name="heat_pump" id="inlineRadio2" value="Yes">

                                    </label>

                                    </td>

                                    <td><label class="radio-inline">

                                        <input type="radio" name="heat_pump" id="inlineRadio2" value="No">

                                    </label>

                                    </td>

                                    <td><label class="radio-inline">

                                        <input type="radio" name="heat_pump" id="inlineRadio2" value="N/A">

                                    </label>

                                    </td>

                                    </tr>

                                    <tr>

                                    <td>Central Air Conditioning</td>

                                    <td><label class="radio-inline">

                                        <input type="radio" name="central_air" id="inlineRadio2" value="Yes">

                                    </label>

                                    </td>

                                    <td><label class="radio-inline">

                                        <input type="radio" name="central_air" id="inlineRadio2" value="No">

                                    </label>

                                    </td>

                                    <td><label class="radio-inline">

                                        <input type="radio" name="central_air" id="inlineRadio2" value="N/A">

                                    </label>

                                    </td>

                                    </tr>

                                </tbody>

                            </table>

                        </div>

                    </div>

                    <p style="text-align: left;">If any of the above in Part B are marked YES, please explain:

                        <input type="text" class="text-form-input" id="text-form-input" style="width: 100%;" name="partb_details" value="">

                    </p>

                    <div class="form-group">

                        <label for="inputPassword3" class="col-sm-12 control-label">Please describe any repairs made by you or any previous owners of which you are aware (attach separate sheets if necessary):</label>

                        <div class="col-sm-12">

                            <textarea rows="4" type="text" class="form-control" id="inputEmail3" name="any_repairs"></textarea>

                        </div>

                    </div>

                    <p><span>C. Is Seller AWARE of any of the following:</span></p>

                    <div class="form-group">

                        <div class="col-sm-12">

                            <table class="table table-bordered" id="Seller-checkbox-table">

                                <thead>

                                    <tr>

                                    <th></th>

                                    <th>Yes</th>

                                    <th>No</th>

                                    <th>N/A</th>

                                    </tr>

                                </thead>

                                <tbody>

                                    <tr>

                                    <td>1.Substances, materials or products which may be environmental hazards such as, but not limited to: asbestos,                         

                                        radon gas, lead-based paint, fuel or chemical storage tanks, methamphetamine, contaminated soil or water,  

                                        and/or known existing or past mold presence on the subject property? </td>

                                    <td><label class="radio-inline">

                                        <input type="radio" name="substances" id="inlineRadio2" value="Yes">

                                    </label>

                                    </td>

                                    <td><label class="radio-inline">

                                        <input type="radio" name="substances" id="inlineRadio2" value="No">

                                    </label>

                                    </td>

                                    <td><label class="radio-inline">

                                        <input type="radio" name="substances" id="inlineRadio2" value="N/A" checked="">

                                    </label>

                                    </td>

                                    </tr>

                                    <tr>

                                    <td>2. Features shared in common with adjoining land owners with joint rights and obligations for use and maintenance   

                                        (e.g. - driveways, private roads, walls, fences, wells, septic systems, etc)? </td>

                                    <td><label class="radio-inline">

                                        <input type="radio" name="features_shared" id="inlineRadio2" value="Yes">

                                    </label>

                                    </td>

                                    <td><label class="radio-inline">

                                        <input type="radio" name="features_shared" id="inlineRadio2" value="No">

                                    </label>

                                    </td>

                                    <td><label class="radio-inline">

                                        <input type="radio" name="features_shared" id="inlineRadio2" value="N/A">

                                    </label>

                                    </td>

                                    </tr>

                                    <tr>

                                    <td>3. Any authorized changes in roads, drainage or utilities affecting the property, or contiguous to the property?</td>

                                    <td><label class="radio-inline">

                                        <input type="radio" name="any_authorized_changes" id="inlineRadio2" value="Yes">

                                    </label>

                                    </td>

                                    <td><label class="radio-inline">

                                        <input type="radio" name="any_authorized_changes" id="inlineRadio2" value="No">

                                    </label>

                                    </td>

                                    <td><label class="radio-inline">

                                        <input type="radio" name="any_authorized_changes" id="inlineRadio2" value="N/A">

                                    </label>

                                    </td>

                                    </tr>

                                    <tr>

                                    <td>4. Any changes since the most recent survey of the property was done? (Most recent survey of property:

                                        <input type="text" class="" id="text-form-input" style="width: 30px;" name="most_recent_survey" value="">

                                        )</td>

                                    <td><label class="radio-inline">

                                        <input type="radio" name="any_change_since_latest_survey" id="inlineRadio2" value="Yes">

                                    </label>

                                    </td>

                                    <td><label class="radio-inline">

                                        <input type="radio" name="any_change_since_latest_survey" id="inlineRadio2" value="No">

                                    </label>

                                    </td>

                                    <td><label class="radio-inline">

                                        <input type="radio" name="any_change_since_latest_survey" id="inlineRadio2" value="N/A">

                                    </label>

                                    </td>

                                    </tr>

                                    <tr>

                                    <td>5. Any encroachments, easements, or similar items that may affect your ownership interest in the property?</td>

                                    <td><label class="radio-inline">

                                        <input type="radio" name="any_encroachments" id="inlineRadio2" value="Yes">

                                    </label>

                                    </td>

                                    <td><label class="radio-inline">

                                        <input type="radio" name="any_encroachments" id="inlineRadio2" value="No">

                                    </label>

                                    </td>

                                    <td><label class="radio-inline">

                                        <input type="radio" name="any_encroachments" id="inlineRadio2" value="N/A">

                                    </label>

                                    </td>

                                    </tr>

                                    <tr>

                                    <td>6. Room additions, structural modifications or other alterations or repairs made without necessary permits?</td>

                                    <td><label class="radio-inline">

                                        <input type="radio" name="repairs" id="inlineRadio2" value="Yes">

                                    </label>

                                    </td>

                                    <td><label class="radio-inline">

                                        <input type="radio" name="repairs" id="inlineRadio2" value="No">

                                    </label>

                                    </td>

                                    <td><label class="radio-inline">

                                        <input type="radio" name="repairs" id="inlineRadio2" value="N/A">

                                    </label>

                                    </td>

                                    </tr>

                                    <tr>

                                    <td>7. Room additions, structural modifications, other alterations or repairs not in compliance with building codes?</td>

                                    <td><label class="radio-inline">

                                        <input type="radio" name="repairs_with_building_codes" id="inlineRadio2" value="Yes">

                                    </label>

                                    </td>

                                    <td><label class="radio-inline">

                                        <input type="radio" name="repairs_with_building_codes" id="inlineRadio2" value="No">

                                    </label>

                                    </td>

                                    <td><label class="radio-inline">

                                        <input type="radio" name="repairs_with_building_codes" id="inlineRadio2" value="N/A">

                                    </label>

                                    </td>

                                    </tr>

                                    <tr>

                                    <td>8. Landfill (compacted or otherwise) on the property or any portion thereof?</td>

                                    <td><label class="radio-inline">

                                        <input type="radio" name="landfill" id="inlineRadio2" value="Yes">

                                    </label>

                                    </td>

                                    <td><label class="radio-inline">

                                        <input type="radio" name="landfill" id="inlineRadio2" value="No">

                                    </label>

                                    </td>

                                    <td><label class="radio-inline">

                                        <input type="radio" name="landfill" id="inlineRadio2" value="N/A">

                                    </label>

                                    </td>

                                    </tr>

                                    <tr>

                                    <td>9. Any settling from any cause, or slippage, sliding or other soil problems?</td>

                                    <td><label class="radio-inline">

                                        <input type="radio" name="any_settling" id="inlineRadio2" value="Yes">

                                    </label>

                                    </td>

                                    <td><label class="radio-inline">

                                        <input type="radio" name="any_settling" id="inlineRadio2" value="No">

                                    </label>

                                    </td>

                                    <td><label class="radio-inline">

                                        <input type="radio" name="any_settling" id="inlineRadio2" value="N/A">

                                    </label>

                                    </td>

                                    </tr>

                                    <tr>

                                    <td>10. Flooding, drainage or grading problems?</td>

                                    <td><label class="radio-inline">

                                        <input type="radio" name="problems" id="inlineRadio2" value="Yes">

                                    </label>

                                    </td>

                                    <td><label class="radio-inline">

                                        <input type="radio" name="problems" id="inlineRadio2" value="No">

                                    </label>

                                    </td>

                                    <td><label class="radio-inline">

                                        <input type="radio" name="problems" id="inlineRadio2" value="N/A">

                                    </label>

                                    </td>

                                    </tr>

                                    <tr>

                                    <td>11. Any requirement that flood insurance be maintained on the property?</td>

                                    <td><label class="radio-inline">

                                        <input type="radio" name="requirement" id="inlineRadio2" value="Yes">

                                    </label>

                                    </td>

                                    <td><label class="radio-inline">

                                        <input type="radio" name="requirement" id="inlineRadio2" value="No">

                                    </label>

                                    </td>

                                    <td><label class="radio-inline">

                                        <input type="radio" name="requirement" id="inlineRadio2" value="N/A">

                                    </label>

                                    </td>

                                    </tr>

                                    <tr>

                                    <td>12. Any of the property located in a designated flood hazard area?</td>

                                    <td><label class="radio-inline">

                                        <input type="radio" name="location" id="inlineRadio2" value="Yes">

                                    </label>

                                    </td>

                                    <td><label class="radio-inline">

                                        <input type="radio" name="location" id="inlineRadio2" value="No">

                                    </label>

                                    </td>

                                    <td><label class="radio-inline">

                                        <input type="radio" name="location" id="inlineRadio2" value="N/A">

                                    </label>

                                    </td>

                                    </tr>

                                    <tr>

                                    <td>13. Any past or present interior water intrusions(s), standing water within foundation and/or basement?</td>

                                    <td><label class="radio-inline">

                                        <input type="radio" name="interior" id="inlineRadio2" value="Yes">

                                    </label>

                                    </td>

                                    <td><label class="radio-inline">

                                        <input type="radio" name="interior" id="inlineRadio2" value="No">

                                    </label>

                                    </td>

                                    <td><label class="radio-inline">

                                        <input type="radio" name="interior" id="inlineRadio2" value="N/A">

                                    </label>

                                    </td>

                                    </tr>

                                    <tr>

                                    <td>14. Property or structural damage from fire, earthquake, floods, landslides, tremors, wind, storm, or wood                     

                                        destroying organisms (such as termites, mold, etc.)?</td>

                                    <td><label class="radio-inline">

                                        <input type="radio" name="structural_damage" id="inlineRadio2" value="Yes">

                                    </label>

                                    </td>

                                    <td><label class="radio-inline">

                                        <input type="radio" name="structural_damage" id="inlineRadio2" value="No">

                                    </label>

                                    </td>

                                    <td><label class="radio-inline">

                                        <input type="radio" name="structural_damage" id="inlineRadio2" value="N/A">

                                    </label>

                                    </td>

                                    </tr>

                                    <tr>

                                    <td>15. Any zoning violations, nonconforming uses and/or violations of "setback" requirements?</td>

                                    <td><label class="radio-inline">

                                        <input type="radio" name="any_zoning_violations" id="inlineRadio2" value="Yes">

                                    </label>

                                    </td>

                                    <td><label class="radio-inline">

                                        <input type="radio" name="any_zoning_violations" id="inlineRadio2" value="No">

                                    </label>

                                    </td>

                                    <td><label class="radio-inline">

                                        <input type="radio" name="any_zoning_violations" id="inlineRadio2" value="N/A">

                                    </label>

                                    </td>

                                    </tr>

                                    <tr>

                                    <td>16. Neighborhood noise problems or other nuisances?</td>

                                    <td><label class="radio-inline">

                                        <input type="radio" name="neighborhood_noise" id="inlineRadio2" value="Yes">

                                    </label>

                                    </td>

                                    <td><label class="radio-inline">

                                        <input type="radio" name="neighborhood_noise" id="inlineRadio2" value="No">

                                    </label>

                                    </td>

                                    <td><label class="radio-inline">

                                        <input type="radio" name="neighborhood_noise" id="inlineRadio2" value="N/A">

                                    </label>

                                    </td>

                                    </tr>

                                    <tr>

                                    <td>17. Subdivision and/or deed restrictions or obligations?</td>

                                    <td><label class="radio-inline">

                                        <input type="radio" name="restrictions" id="inlineRadio2" value="Yes">

                                    </label>

                                    </td>

                                    <td><label class="radio-inline">

                                        <input type="radio" name="restrictions" id="inlineRadio2" value="No">

                                    </label>

                                    </td>

                                    <td><label class="radio-inline">

                                        <input type="radio" name="restrictions" id="inlineRadio2" value="N/A">

                                    </label>

                                    </td>

                                    </tr>

                                    <tr>

                                    <td>18. Any "common area" (pools, tennis courts, walkways, etc), co-owned in undivided interest with others?</td>

                                    <td><label class="radio-inline">

                                        <input type="radio" name="any_common_area" id="inlineRadio2" value="Yes">

                                    </label>

                                    </td>

                                    <td><label class="radio-inline">

                                        <input type="radio" name="any_common_area" id="inlineRadio2" value="No">

                                    </label>

                                    </td>

                                    <td><label class="radio-inline">

                                        <input type="radio" name="any_common_area" id="inlineRadio2" value="N/A">

                                    </label>

                                    </td>

                                    </tr>

                                    <tr>

                                    <td>19. Any notices of abatement or citations against the property?</td>

                                    <td><label class="radio-inline">

                                        <input type="radio" name="any_notices" id="inlineRadio2" value="Yes">

                                    </label>

                                    </td>

                                    <td><label class="radio-inline">

                                        <input type="radio" name="any_notices" id="inlineRadio2" value="No">

                                    </label>

                                    </td>

                                    <td><label class="radio-inline">

                                        <input type="radio" name="any_notices" id="inlineRadio2" value="N/A">

                                    </label>

                                    </td>

                                    </tr>

                                    <tr>

                                    <td>20. Any lawsuit(s) or proposed lawsuit(s) by or against the seller which affects or will affect the property?</td>

                                    <td><label class="radio-inline">

                                        <input type="radio" name="any_lawsuit" id="inlineRadio2" value="Yes">

                                    </label>

                                    </td>

                                    <td><label class="radio-inline">

                                        <input type="radio" name="any_lawsuit" id="inlineRadio2" value="No">

                                    </label>

                                    </td>

                                    <td><label class="radio-inline">

                                        <input type="radio" name="any_lawsuit" id="inlineRadio2" value="N/A">

                                    </label>

                                    </td>

                                    </tr>

                                    <tr>

                                    <td>21. Any system, equipment or part of the property that is being leased? (e.g. security system, water softener,                 

                                        satellite dish, etc.) Lease payoffs or assumptions should be addressed in the purchase contract.</td>

                                    <td><label class="radio-inline">

                                        <input type="radio" name="any_system" id="inlineRadio2" value="Yes">

                                    </label>

                                    </td>

                                    <td><label class="radio-inline">

                                        <input type="radio" name="any_system" id="inlineRadio2" value="No">

                                    </label>

                                    </td>

                                    <td><label class="radio-inline">

                                        <input type="radio" name="any_system" id="inlineRadio2" value="N/A">

                                    </label>

                                    </td>

                                    </tr>

                                    <tr>

                                    <td>22. Any exterior wall covered with exterior insulation and finish systems (EIFS, or synthetic stucco)?

                                        If yes, has there been a recent inspection to determine whether the structure has excessive moisture     

                                        accumulation and/or moisture related damage?  [explain below]</td>

                                    <td><label class="radio-inline">

                                        <input type="radio" name="any_exterior" id="inlineRadio2" value="Yes">

                                    </label>

                                    </td>

                                    <td><label class="radio-inline">

                                        <input type="radio" name="any_exterior" id="inlineRadio2" value="No">

                                    </label>

                                    </td>

                                    <td><label class="radio-inline">

                                        <input type="radio" name="any_exterior" id="inlineRadio2" value="N/A">

                                    </label>

                                    </td>

                                    </tr>

                                    <tr>

                                    <td>23. Any finished rooms that are not supplied with heating and air conditioning?</td>

                                    <td><label class="radio-inline">

                                        <input type="radio" name="any_finished_rooms" id="inlineRadio2" value="Yes">

                                    </label>

                                    </td>

                                    <td><label class="radio-inline">

                                        <input type="radio" name="any_finished_rooms" id="inlineRadio2" value="No">

                                    </label>

                                    </td>

                                    <td><label class="radio-inline">

                                        <input type="radio" name="any_finished_rooms" id="inlineRadio2" value="N/A">

                                    </label>

                                    </td>

                                    </tr>

                                    <tr>

                                    <td>24. Any septic tank or other private disposal system that does not have adequate capacity and approved design                 

                                        to comply with present stateand local requirements for the actual land area and number of bedrooms?  

                                        If residence is on a septic system, the septic system is legally permitted for

                                        <input type="text" class="" id="text-form-input" style="width: 30px;" name="legally_permitted_for" value="">

                                        number of bedrooms.</td>

                                    <td><label class="radio-inline">

                                        <input type="radio" name="any_septic_tank" id="inlineRadio2" value="Yes">

                                    </label>

                                    </td>

                                    <td><label class="radio-inline">

                                        <input type="radio" name="any_septic_tank" id="inlineRadio2" value="No">

                                    </label>

                                    </td>

                                    <td><label class="radio-inline">

                                        <input type="radio" name="any_septic_tank" id="inlineRadio2" value="N/A">

                                    </label>

                                    </td>

                                    </tr>

                                    <tr>

                                    <td>25. The property is affected by covenants, conditions, restrictions (CCR's), or Home Owner Association by-laws requiring approval for changes, use, or alterations to the property?</td>

                                    <td><label class="radio-inline">

                                        <input type="radio" name="affected" id="inlineRadio2" value="Yes">

                                    </label>

                                    </td>

                                    <td><label class="radio-inline">

                                        <input type="radio" name="affected" id="inlineRadio2" value="No">

                                    </label>

                                    </td>

                                    <td><label class="radio-inline">

                                        <input type="radio" name="affected" id="inlineRadio2" value="N/A">

                                    </label>

                                    </td>

                                    </tr>

                                    <tr>

                                    <td>26. The property is in an historical district or has been declared historical bya governmental authority and                     

                                        permission must be obtained before certain improvements or aesthetic changes to the property are made?</td>

                                    <td><label class="radio-inline">

                                        <input type="radio" name="in_an_historical_district" id="inlineRadio2" value="Yes">

                                    </label>

                                    </td>

                                    <td><label class="radio-inline">

                                        <input type="radio" name="in_an_historical_district" id="inlineRadio2" value="No">

                                    </label>

                                    </td>

                                    <td><label class="radio-inline">

                                        <input type="radio" name="in_an_historical_district" id="inlineRadio2" value="N/A">

                                    </label>

                                    </td>

                                    </tr>

                                </tbody>

                            </table>

                        </div>

                    </div>

                    <div class="form-group">

                        <label for="inputPassword3" class="col-sm-12 control-label">If any of the above in Part C are marked YES, please explain:</label>

                        <div class="col-sm-12">

                            <textarea rows="4" type="text" class="form-control" id="inputEmail3" name="partc_details"></textarea>

                        </div>

                    </div>

                    <div class="form-group">
                        <label class="col-sm-12 control-label">Seller certifies that this information is true and correct to the best of seller's knowledge as of the date signed.</label>
                    </div>



                    <div class="form-group">
                        <label class="col-sm-12 control-label"> Buyer understands that this Disclosure is not intended as a substitute for any inspection, and that buyer has a responsibility 
                            to pay diligent attention to and inquire about defects which are evident by careful observation. Buyer acknowledges receipt 
                            of a copy of this Disclosure. </label>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-12">
                            <input type="submit" class="btn btn-default" name="submit" id="inputbutton" value="Update">
                        </div>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>
<style>


</style>
@endsection
