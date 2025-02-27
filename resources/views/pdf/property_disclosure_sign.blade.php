<!DOCTYPE html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">   
    <title>Property Condition Disclaimer</title>
    <style>  
        body {
            font-family: 'Poppins', sans-serif;
            color: #222222;
            margin: 2cm;
        } 
        input[type=number]::-webkit-inner-spin-button, 
        input[type=number]::-webkit-outer-spin-button { 
            -webkit-appearance: none  ! important; 
            -moz-appearance: none  ! important; 
            appearance: none  ! important; 
        } 
        .pull-right-div > input[type=checkbox] + label{
            display: inline-block; 
        }

        /** Define the radio rules **/ 
        [type="radio"]:checked,
        [type="radio"]:not(:checked) {
            position: absolute;  
            left: -9999px;
        }
        [type="radio"]:checked + label,
        [type="radio"]:not(:checked) + label
        {
            position: relative;
            padding-left: 28px;
            cursor: pointer;
            line-height: 20px;
            display: inline-block;
            color: #666;
            margin-bottom: 12px; 
        }
        [type="radio"]:checked + label:before,
        [type="radio"]:not(:checked) + label:before { 
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            width: 18px;
            height: 18px;
            border: 1px solid #ccc;
            border-radius: 100%;
            background: #fff;
        }
        [type="radio"]:checked + label:after,
        [type="radio"]:not(:checked) + label:after {
            content: '';
            width: 12px;
            height: 12px;
            background: #25bbe2;
            position: absolute;
            top: 4px;
            left: 4px;
            border-radius: 100%;
            -webkit-transition: all 0.2s ease;
            transition: all 0.2s ease;
        }
        [type="radio"]:not(:checked) + label:after {
            opacity: 0;
            -webkit-transform: scale(0);
            transform: scale(0);
        }
        [type="radio"]:checked + label:after {
            opacity: 1;
            -webkit-transform: scale(1);
            transform: scale(1);
        } 
        input[type=checkbox] + label {
            display: block;
            margin: 0.2em;
            cursor: pointer;
            padding: 0.2em;
        }
        /** Define the checkbox rules **/ 
        .checkbox{ 
            margin-top: 10px;  
            clear: both; 
        }
        .checkbox label{ 
            padding-top: 5px;
        }

        input[type=checkbox] {
            display: none;  
        } 
        input[type=checkbox] + label:before {
            content: "\2714";
            border: 0.1em solid #ccc;
            border-radius: 0.2em;
            display: inline-block;
            width: 1em;
            height: 1em;
            padding-left: 0.2em;
            padding-bottom: 0.3em;
            vertical-align: bottom;
            color: transparent;
            transition: .2s;
            margin-right:10px;   
            margin-top: 0px;  
        }

        input[type=checkbox] + label:active:before {
            transform: scale(0);
        }

        input[type=checkbox]:checked + label:before {
            background-color: #25bbe2;
            border-color: #cccccc;
            color: #fff;
        }

        input[type=checkbox]:disabled + label:before {
            transform: scale(1);
            border-color: #cccccc;
        }

        input[type=checkbox]:checked:disabled + label:before {
            transform: scale(1);
            background-color: #bfb;
            border-color: #cccccc;
        }
        input[type=checkbox]:checked + label:before {
            background: #25bbe2 ! important; 
        }
        .heading-text {                               
            margin-top: 30px;       
            text-transform: uppercase;
            border-bottom: 1px solid #cccccc;
        }
        h2{ 
            font-size: 18px; 
            font-weight: 700;
            line-height: 28px; 
            margin-top: 20px; 
        } 
        p, h5, h4, a, label{
            line-height: 25px;  
            font-size: 15px;
            font-weight: 400;
        }
        a{
            color:#25bbe2; 
        }
        h5,h4 { 
            font-weight: 600;
            margin-bottom: 10px;
            color:#222222;
            text-align: left;
        }
        tr {
            clear: both; 
        }
        table{   
            border-collapse: collapse;  
            margin: 0px;
            padding: 0px;  
        }
        .table-bordered {
            border: 1px solid #cccccc;
            width: 100%;
        }
        .table-bordered td { 
            border: 1px solid #cccccc;
            text-align: left;
            font-size: 15px;
            color: #222222;  
            font-weight: 400;
            padding: 12px; 
            margin: 0px;
            background: #fff;
            z-index: 9999;
        }
        .table-bordered th{
            padding: 10px;
            z-index: -99;
            margin:0; 
        } 
        .form-control {
            border: 1px solid #000;
            border-left: 1px solid #ccc !important;
            border-top: 1px solid #ccc !important;
            border-style: solid !important;
            outline: none;
            border-radius: 20px; 
            text-transform: uppercase;
            box-shadow: none !important; 
            font-weight: 700;
            font-size: 12px;
            padding: 15px 1%;
            color: #000;  
            width: 98%;  
            height: 15px; 
        } 
        .readonly {
            border-radius: 5px;
            border: 1px solid #ccc;
            border-left: 1px solid #ccc !important;
            border-top: 1px solid #ccc !important;
            margin: 0 10px;
            min-width: 120px; 
            max-height: 22px;
        }   
        .mr-top{
            margin-top: 20px; 
        }    
        .margin-left, .styled-checkbox{ 
            margin-right: 20px;     
        } 
        .margin-right{ 
            margin-left: 20px; 
        }   
        .table input[type="radio"] {
            margin: 0px auto; 
            width: 100% ! important; 
            margin-bottom: 10px; 
        } 
        .text-height{   
            min-height: 80px ! important;
        }   
        table { page-break-inside:auto; } 
        tr, th, td{ page-break-inside:avoid; page-break-after:auto } 
        thead { display:table-header-group } 
        tfoot { display:table-footer-group }
        .heading-text-buyer, .heading-text-seller {
            margin-bottom: 20px;
            text-align: center;
            color: #222222; 
            font-weight: 600;
        }
        .buyer-details-div {
            padding-bottom: 20px;
            /*            border-bottom: 1px solid #F2F4F4;*/
            display: inline-block; 
            width: 100%;
            margin-bottom: 20px;
        }
        #signature {
            color: #ff0000;
            font-size: 18px;
            font-family: Segoe Script ! important;
        }
        .signature {
            margin-bottom: 20px;
        }
        .signature-button{
            background: #92c800;
            border:1px solid #92c800;
            color: #FFF;
            padding: 6px 15px;
            border-radius: 5px;
            font-size: 15px;
        }
        .signature-model{
            padding: 25px;
        }
        .buyer-main {
            margin-top: 35px;
        }
        .buyer-details label, .seller-details label {
            margin-bottom: 10px;
        }
        .buyer-details input, .seller-details input {
            margin-bottom: 20px;
        }
        .margin-top {
            margin-top:20px
        }
        /*        .heading-text-buyer {
                    margin-top: 50%;
                }*/
        .heading-text-seller {
            margin-top: 15%;
        }
        .part-group-b {
            page-break-before:always;
            /*margin-top: 50px;*/
        }
        .part-group-c {
            page-break-before:always;
            margin-top: 80px;
        }
        .margin-bottom {
            margin-bottom:5mm;
        }
    </style>     
</head> 
<body> 
    <!--  content pdf-->
    <main>
        <div class="heading-text">
            <h2> Property Condition Disclaimer</h2>
        </div>
        <div class="form-group"> 
            <h5 class=""> 1. Property age: </h5>
            <div class="">
                <input type="text" class="form-control" disabled="disabled" value="{{(isset($diffInYears) && $diffInYears >=1) ? $diffInYears : ''}}">
            </div>
        </div>

        <div class="form-group">                                    
            <div class="">
                <h5>2. Date seller acquired the property: </h5>
                <input type="text" class="form-control" value="{{$property->disclosure->date_added??''}}" disabled="disabled">
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-12" style="width:100%;"> 
                <h5>3. Does seller currently occupy the property?Any Contingencies?</h5> 
                <span class="margin-left" style="width:200px; float: left;">
                    <input type="radio"  disabled="disabled"  <?php
                    if (isset($property->disclosure->occupy)) {
                        if ($property->disclosure->occupy == config('constant.inverse_property_disclaimer_occupy.Seller occupies property')) {
                            ?>
                                   checked="checked"
                                   <?php
                               }
                           }
                           ?> id="occupies">
                    <label>Seller occupies property</label> 
                </span>
                <span class="margin-left" style="min-width:200px;">  
                    <input type="radio"  disabled="disabled" <?php
                    if (isset($property->disclosure->occupy)) {
                        if ($property->disclosure->occupy == config('constant.inverse_property_disclaimer_occupy.Seller does not occupy property')) {
                            ?>
                                   checked="checked"
                                   <?php
                               }
                           }
                           ?> id="notoccupies">
                    <label style="width:700px;">Seller does not occupies property</label>
                </span>
            </div><!--col-md-12-->
        </div>
        <div style="clear:both;"></div>   
        <div class="form-group">
            <div class="">
                <h5>4. If not currently seller-occupied, how long has it been since the seller did occupy the property, if ever?</h5>
                <input type="text" class="form-control" disabled="disabled" value="{{$property->disclosure->how_long??""}}">
            </div>
        </div>
        <div style="clear:both;"></div>  
        <div class="form-group"  style="width:100%;">
            <div class="col-md-12">
                <h5>5. The property is a</h5>
                <span class="margin-left"  style="width:200px; float: left;"> 
                    <input type="radio"  disabled="disabled" <?php
                    if (isset($property->disclosure)) {
                        if ($property->disclosure->property_is == config('constant.inverse_property_disclaimer_propertyis.Site-built Home')) {
                            ?>
                                   checked="checked"
                                   <?php
                               }
                           }
                           ?>  id="site-built">
                    <label style="width:170px;">site-built home</label>
                </span>
                <span class="margin-left" style="min-width:200px; display: block">
                    <input type="radio"  disabled="disabled" <?php
                    if (isset($property->disclosure->property_is)) {
                        if ($property->disclosure->property_is == config('constant.inverse_property_disclaimer_propertyis.Non-site-built Home')) {
                            ?>
                                   checked="checked"
                                   <?php
                               }
                           }
                           ?>   id="non-site-built">
                    <label  style="width:700px;">non-site-built home<span class="offer-text">(e.g. - modular, manufactured, mobile)</label>
                </span> 
            </div><!--col-md-12-->
        </div>
        <div style="clear:both;"></div>   
        <div class="form-group">
            <div class="col-md-12">
                <h5>6. Roof type</h5>
                <label>Types of Roof (e.g. - composition asphalt shingle, wood, metal, tile)</label>
                <div style="height:10px;"></div> 
                <input type="text" class="form-control" value="{{$property->disclosure->roof_type??""}}" disabled="disabled" >  
                <div style="height:10px;"></div>
            </div>
        </div>  
        <div class="form-group">
            <div class="col-md-12">
                <label>Approx. age of roof:</label>
                <input type="text" class="form-control mr-top"  min="0" value="{{$property->disclosure->roof_age??""}}" disabled="disabled" >

            </div>
        </div>
        <div class="form-group">
            <div class="col-md-12">
                <h5>7. Is there a Homeowners Association (HOA) which has any authority over the subject property?</h5>

                <span class="margin-left">
                    <input type="radio"  disabled="disabled"  id="chkYes" <?php
                    if (isset($property->disclosure)) {
                        if ($property->disclosure->house_owners_associations == config('constant.inverse_common_yes_no.Yes')) {
                            ?>
                                   checked="checked"
                                   <?php
                               }
                           }
                           ?> >  
                    <label for="chkYes" class="">Yes</label>  
                </span>
                <span class="">
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
                </span>  
            </div><!--col-md-12-->
        </div>                       
        <div id="house"> 
            <div class="form-group">
                <div class="col-md-12">
                    <p>Name &amp; address of HOA:</p>
                    <input type="text" class="form-control" disabled="disabled" value="{{$property->disclosure->name_address??""}}">
                </div>
            </div>

            <div class="form-group">
                <div class="col-md-12">  
                    <p>Monthly Dues:</p>
                    <input type="text" class="form-control" disabled="disabled" min="0" value="{{$property->disclosure->monthly_dues??""}}">
                </div> 
            </div>

            <div class="form-group" style="page-break-before:always;"> 
                <div class="col-md-12">
                    <p>Transfer Fees:</p>
                    <input type="text" class="form-control" disabled="disabled" min="0" value="{{$property->disclosure->transfer_fees??""}}">
                </div>
            </div>

            <div class="form-group">
                <div class="">
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
            <div class="col-md-12  col-xs-12">
                <h5>A. The property includes the items checked below: </h5>
            </div><!--col-md-12-->
        </div>

        <div class="form-group">
            <div class="col-md-6  col-xs-12">
                <div class="checkbox">
                    <input type="checkbox"  disabled="disabled"  class="styled-checkbox margin-left" disabled="disabled"  <?php
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
            <div class="col-md-6  col-xs-12">
                <div class="checkbox">
                    <input type="checkbox" class="margin-left" class="margin-left"disabled="disabled"  class="styled-checkbox margin-left"   disabled="disabled" <?php
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
            <div class="col-md-6  col-xs-12">
                <div class="checkbox">
                    <input type="checkbox" class="margin-left" class="margin-left"disabled="disabled"  class="styled-checkbox margin-left"   disabled="disabled" <?php
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
            <div class="col-md-6  col-xs-12">
                <div class="checkbox">
                    <input type="checkbox" class="margin-left" class="margin-left"disabled="disabled"  class="styled-checkbox margin-left"   disabled="disabled" <?php
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
            <div class="col-md-6  col-xs-12">
                <div class="checkbox">
                    <input type="checkbox" class="margin-left" class="margin-left"disabled="disabled"  class="styled-checkbox margin-left" disabled="disabled" <?php
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
            <div class="col-md-6  col-xs-12">
                <div class="checkbox">
                    <input type="checkbox" class="margin-left" class="margin-left"disabled="disabled"  class="styled-checkbox margin-left"   disabled="disabled"<?php
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
            <div class="col-md-6  col-xs-12">
                <div class="checkbox">
                    <input type="checkbox" class="margin-left" class="margin-left"disabled="disabled"  class="styled-checkbox margin-left"   disabled="disabled"  <?php
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
            <div class="col-md-6  col-xs-12">
                <div class="checkbox">
                    <input type="checkbox" class="margin-left" class="margin-left"disabled="disabled"  class="styled-checkbox margin-left"   disabled="disabled" id="Sauna" <?php
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
            <div class="col-md-6  col-xs-12">
                <div class="checkbox">
                    <input type="checkbox" class="margin-left" class="margin-left"disabled="disabled"  class="styled-checkbox margin-left"   disabled="disabled" <?php
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
            <div class="col-md-6  col-xs-12">
                <div class="checkbox">
                    <input type="checkbox" class="margin-left" class="margin-left"disabled="disabled"  class="styled-checkbox margin-left"   disabled="disabled" <?php
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
            <div class="col-md-6  col-xs-12">
                <div class="checkbox">
                    <input type="checkbox" class="margin-left" class="margin-left"disabled="disabled"  class="styled-checkbox margin-left"   disabled="disabled" <?php
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
            <div class="col-md-6  col-xs-12">
                <div class="checkbox">
                    <input type="checkbox" class="margin-left" class="margin-left"disabled="disabled"  class="styled-checkbox margin-left"   disabled="disabled" <?php
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
            <div class="col-md-6  col-xs-12">
                <div class="checkbox">
                    <input type="checkbox" class="margin-left" class="margin-left"disabled="disabled"  class="styled-checkbox margin-left"   disabled="disabled"  <?php
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
            <div class="col-md-6  col-xs-12">
                <div class="checkbox">
                    <input type="checkbox" class="margin-left" class="margin-left"disabled="disabled"  class="styled-checkbox margin-left"   disabled="disabled"  <?php
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
                    <label for="Fireplace"> Fireplace  <span id='main-fireplace'> 
                            (How many? <input type="text" min="0" class="readonly" disabled="disabled" id="text-form-input" value="{{$property->disclosure->how_many??""}}">
                            )</span></label> 
                </div>
            </div><!--col-md-12-->
        </div>
        <div class="form-group">
            <div class="col-md-6  col-xs-12">
                <div class="checkbox">
                    <input type="checkbox" class="margin-left" class="margin-left"disabled="disabled"  class="styled-checkbox margin-left"   disabled="disabled"   <?php
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
            <div class="col-md-6  col-xs-12">
                <div class="checkbox">
                    <input type="checkbox" class="margin-left" class="margin-left"disabled="disabled"  class="styled-checkbox margin-left"   disabled="disabled" <?php
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
            <div class="col-md-6  col-xs-12">
                <div class="checkbox">
                    <input type="checkbox" class="margin-left" class="margin-left"disabled="disabled"  class="styled-checkbox margin-left"   disabled="disabled" <?php
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
            <div class="col-md-6  col-xs-12">
                <div class="checkbox">
                    <input type="checkbox" class="margin-left" class="margin-left"disabled="disabled"  class="styled-checkbox margin-left"   disabled="disabled"  <?php
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
            <div class="col-md-6  col-xs-12">
                <div class="checkbox">
                    <input type="checkbox" class="margin-left" class="margin-left"disabled="disabled"  class="styled-checkbox margin-left"   disabled="disabled" <?php
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
            <div class="col-md-6  col-xs-12">
                <div class="checkbox">
                    <input type="checkbox" class="margin-left" class="margin-left"disabled="disabled"  class="styled-checkbox margin-left"   disabled="disabled" <?php
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
            <div class="col-md-6  col-xs-12">
                <div class="checkbox">
                    <input type="checkbox" class="margin-left" class="margin-left"disabled="disabled"  class="styled-checkbox margin-left"   disabled="disabled" <?php
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
            <div class="col-md-6  col-xs-12">
                <div class="checkbox">
                    <input type="checkbox" class="margin-left" class="margin-left"disabled="disabled"  class="styled-checkbox margin-left"   disabled="disabled" <?php
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
            <div class="col-md-6  col-xs-12">
                <div class="checkbox">
                    <input type="checkbox" class="margin-left" class="margin-left"disabled="disabled"  class="styled-checkbox margin-left"   disabled="disabled" <?php
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
            <div class="col-md-6  col-xs-12">
                <div class="checkbox">
                    <input type="checkbox" class="margin-left" class="margin-left"disabled="disabled"  class="styled-checkbox margin-left"   disabled="disabled"  <?php
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
            <div class="col-md-6  col-xs-12">
                <div class="checkbox">
                    <input type="checkbox" class="margin-left" class="margin-left"disabled="disabled"  class="styled-checkbox margin-left"   disabled="disabled"  <?php
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
            <div class="col-md-6  col-xs-12">
                <div class="checkbox">
                    <input type="checkbox" class="margin-left" class="margin-left"disabled="disabled"  class="styled-checkbox margin-left"   disabled="disabled" <?php
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
            <div class="col-md-6  col-xs-12">
                <div class="checkbox">
                    <input type="checkbox" class="margin-left" class="margin-left"disabled="disabled"  class="styled-checkbox margin-left"   disabled="disabled" <?php
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
            <div class="col-md-6  col-xs-12">
                <div class="checkbox">
                    <input type="checkbox" class="margin-left" class="margin-left"disabled="disabled"  class="styled-checkbox margin-left"   disabled="disabled" <?php
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
        <div class="form-group"  style="width:100%;">
            <div>
                <span class="checkbox" style="width:100px; float: left;"> 
                    <input type="checkbox" class="margin-left" class="margin-left"disabled="disabled"  class="styled-checkbox margin-left"   disabled="disabled"  <?php
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
                </span>
                <div id="Pool-option"  style="width:700px; float: left; margin-top:10px;">   
                    <input type="radio"  disabled="disabled"  <?php
                    if (isset($property->disclosure)) {
                        if ($property->disclosure->pool_type == config('constant.inverse_property_disclaimer_pool.In-ground')) {
                            ?>
                                   checked="checked"
                                   <?php
                               }
                           }
                           ?> id="In-ground" >
                    <label for="In-ground"  style="color:#6d6a69;">In-ground </label>
                    <span style="margin-left: 15px;"> 
                        <input type="radio"  disabled="disabled"  <?php
                        if (isset($property->disclosure)) {
                            if ($property->disclosure->pool_type == config('constant.inverse_property_disclaimer_pool.Above-ground')) {
                                ?>
                                       checked="checked"
                                       <?php
                                   }
                               }
                               ?> id="Above-ground">
                        <label for="Above-ground"  tyle="color:#6d6a69;">Above-ground </label>
                    </span> 
                </div> 
            </div><!--col-md-12-->
        </div>
        <div style="clear:both"></div> 
        <div class="form-group"  style="width:100%;"> 
            <div>
                <span class="checkbox"  style="width:150px; float: left;">
                    <input type="checkbox" class="margin-left" class="margin-left"disabled="disabled"  class="styled-checkbox margin-left"   disabled="disabled"  <?php
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
                </span>  
                <span id="Garage-option"  style="width:900px; float: left;  margin-top: 10px;">   
                    <input type="radio"  disabled="disabled"  <?php
                    if (isset($property->disclosure)) {
                        if ($property->disclosure->garage_type == config('constant.inverse_property_disclaimer_garage.Attached')) {
                            ?>
                                   checked="checked"
                                   <?php
                               }
                           }
                           ?> id="Attached">
                    <label for="Attached"style="color:#6d6a69;">Attached </label>
                    <span style="margin-left: 15px;"> 
                        <input type="radio"  disabled="disabled"  <?php
                        if (isset($property->disclosure)) {
                            if ($property->disclosure->garage_type == config('constant.inverse_property_disclaimer_garage.Not Attached')) {
                                ?>
                                       checked="checked"
                                       <?php
                                   }
                               }
                               ?>  id="Not-Attached">
                        <label for="Not-Attached" style="color:#6d6a69;"> Not Attached</label> 
                    </span>
                </span> 
            </div>
        </div><!--col-md-12-->
        <div style="clear:both"></div> 
        <div class="form-group">
            <div class="col-md-12  col-xs-12">
                <div class="checkbox">
                    <input type="checkbox" class="margin-left" class="margin-left"disabled="disabled"  class="styled-checkbox margin-left"   disabled="disabled"  <?php
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
                    <label for="Opener"> Garage Door Opener(s) and remotes.  <span id='remotes'>
                            (How many remotes?<input type="text" class="readonly" disabled="disabled" id="text-form-input" value="{{$property->disclosure->how_many_remotes??""}}">
                            )</span></label>
                </div>
            </div><!--col-md-12-->
        </div>
        <div style="clear:both"></div> 
        <div class="form-group">
            <div class="col-md-12  col-xs-12">
                <div class="checkbox">
                    <input type="checkbox" class="margin-left" class="margin-left"disabled="disabled"  class="styled-checkbox margin-left"   disabled="disabled"  <?php
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
        <div style="clear:both"></div> 
        <div class="form-group">
            <div class="col-md-12  col-xs-12">
                <div class="checkbox">
                    <input type="checkbox" class="margin-left" class="margin-left"disabled="disabled"  class="styled-checkbox margin-left"   disabled="disabled" <?php
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
        <div style="clear:both"></div> 

        <div class="form-group">
            <div class="">
                <div class="checkbox">
                    <input type="checkbox" disabled="disabled"  class="styled-checkbox margin-left"   disabled="disabled" <?php
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
        <div style="clear:both"></div> 
        <div class="form-group">
            <div class="col-md-12  col-xs-12">
                <div class="checkbox">
                    <input type="checkbox" class="margin-left" class="margin-left"disabled="disabled"  class="styled-checkbox margin-left"   disabled="disabled" <?php
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
                    <label for="Heat-Pump">Heat Pump <span id='Heat-Pump-many'> (Approx. age:
                            <input type="text" class="readonly" disabled="disabled"  value="{{$property->disclosure->heat_pump_age??""}}">)</span></label>
                </div>
            </div><!--col-md-12-->
        </div>
        <div style="clear:both"></div>    
        <?php
        if (isset($property->disclosure)) {
            if ($property->disclosure->water_heater_type) {
                $waterHeaterTypes = explode(',', $property->disclosure->water_heater_type);
            }
        }
        ?>
        <div style="clear:both"></div> 
        <div class="col-lg-12">
            <div class="form-group row">
                <div class="col-md-12  col-xs-12">
                    <div class="checkbox">
                        <input type="checkbox" disabled="disabled"  class="styled-checkbox margin-left"   disabled="disabled" <?php
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
                        <label for="CH">Central Heating <span id='CH-many'>(Age:
                                <input type="text" class="readonly" disabled="disabled" id="text-form-input" value="{{$property->disclosure->central_heating_age??""}}">)
                                <span class="pull-right-div">
                                    <input type="checkbox" class="margin-left" class="margin-left"disabled="disabled"  class="styled-checkbox margin-left"   disabled="disabled" <?php
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
                                    <label for="Electric" style="color:#6d6a69;">Electric</label> 
                                    <input type="checkbox" class="margin-left" class="margin-left"disabled="disabled"  class="styled-checkbox margin-left"   disabled="disabled" <?php
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
                                    <label for="Gas"  style="color:#6d6a69;">Gas</label>
                                    <input type="checkbox" class="margin-left" class="margin-left"disabled="disabled"  class="styled-checkbox margin-left"   disabled="disabled" <?php
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
                                    <label for="Other"  style="color:#6d6a69;">Other:</label>
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
                $centralAirConditioningTypes = explode(',', $property->disclosure->central_air_conditioning_type);
            }
        }
        ?>
        <div style="clear:both"></div>   
        <div class="col-lg-12">                              
            <div class="form-group row">
                <div class="col-md-12  col-xs-12">
                    <div class="checkbox">
                        <input type="checkbox" class="margin-left" class="margin-left"disabled="disabled"  class="styled-checkbox margin-left"   disabled="disabled" <<?php
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
                               <label for="CA">Central Air Conditioning <span id='CA-many'>(Age:
                                <input type="text" class="readonly" disabled="disabled" id="text-form-input"  value="{{$property->disclosure->heat_pump_age??""}}">)
                                <span class="pull-right-div">
                                    <input type="checkbox" class="margin-left" class="margin-left"disabled="disabled"  class="styled-checkbox margin-left" disabled="disabled" id="AirElectric" <?php
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
                                    <label for="AirElectric"  style="color:#6d6a69;">Electric</label>
                                    <input type="checkbox" class="margin-left" class="margin-left"disabled="disabled"  class="styled-checkbox margin-left"   disabled="disabled" id="AirGas" <?php
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
                                    <label for="AirGas"  style="color:#6d6a69;">Gas</label>
                                    <input type="checkbox" class="margin-left" class="margin-left"disabled="disabled"  class="styled-checkbox margin-left"   disabled="disabled" id="AirOther" <?php
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
                                    <label for="AirOther"  style="color:#6d6a69;">Other:</label>
                                </span>
                            </span>
                        </label>
                    </div>
                </div>
            </div>
        </div>
        <div style="clear:both"></div> 
        <?php
        if (isset($property->disclosure)) {
            if ($property->disclosure->water_heater_type) {
                $waterHeaterTypes = explode(',', $property->disclosure->water_heater_type);
            }
        }
        ?>
        <div class="col-lg-12">                       
            <div class="form-group row">
                <div class="col-md-12  col-xs-12">
                    <div class="checkbox">
                        <input type="checkbox" disabled="disabled"  class="styled-checkbox margin-left" disabled="disabled" <?php
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
                        <label for="WH"> Water Heater<span id='WH-many'>  (Age:
                                <input type="text"  class="readonly" disabled="disabled" id="text-form-input" value="{{$property->disclosure->water_heater_age??""}}">)

                                <span class="pull-right-div">
                                    <input type="checkbox" disabled="disabled"  class="styled-checkbox margin-left"   disabled="disabled" id="WHElectric" <?php
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
                                    <label for="WHElectric"  style="color:#6d6a69;">Electric</label>
                                    <input type="checkbox" disabled="disabled"  class="styled-checkbox margin-left"   disabled="disabled" id="WHGas" <?php
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
                                    <label for="WHGas"  style="color:#6d6a69;">Gas</label>
                                    <input type="checkbox" class="margin-left" class="margin-left"disabled="disabled"  class="styled-checkbox margin-left"   disabled="disabled" id="WHOther" <?php
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
                                    <label for="WHOther"  style="color:#6d6a69;">Other:(solar, tankless, etc): </label>
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
                <div class="col-md-12  col-xs-12">
                    <div class="checkbox">
                        <input type="checkbox" class="margin-left" class="margin-left"disabled="disabled"  class="styled-checkbox margin-left"  <?php
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
                        <label for="WSupply">Water Supply<span id='WSupply-many'>
                                <span class="margin-left pull-right-div">
                                    <input type="checkbox" class="margin-left" class="margin-left"disabled="disabled"  class="styled-checkbox margin-left" id="City-Water" <?php
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
                                    <label for="City-Water"  style="color:#6d6a69;">City Water </label>
                                    <input type="checkbox" class="margin-left" class="margin-left"disabled="disabled"  class="styled-checkbox margin-left" id="Privatew"<?php
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
                                    <label for="Privatew"  style="color:#6d6a69;"> Private Well</label>
                                    <input type="checkbox" class="margin-left" class="margin-left"disabled="disabled"  class="styled-checkbox margin-left" id="Shared"<?php
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
                                    <label for="Shared"  style="color:#6d6a69;">Shared Well</label>
                                    <input type="checkbox" class="margin-left" class="margin-left"disabled="disabled"  class="styled-checkbox margin-left" id="oWater" <?php
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
                                    <label for="oWater"  style="color:#6d6a69;">Other:  </label>
                                </span>
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
                <div class="col-md-12  col-xs-12">
                    <div class="checkbox">
                        <input type="checkbox" disabled="disabled"  class="styled-checkbox margin-left" <?php
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
                        <label for="Sewer-Disposal">Sewage Disposal<span id='Sewer-Disposal-option'>  
                                <span class="margin-left pull-right-div">
                                    <input type="checkbox" class="margin-left" class="margin-left"disabled="disabled"  class="styled-checkbox margin-left" id="Sewer" <?php
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
                                    <label for="Sewer"  style="color:#6d6a69;">CitySewer</label>  
                                    <input type="checkbox" class="margin-left" class="margin-left"disabled="disabled"  class="styled-checkbox margin-left" id="Septic" <?php
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
                                    <label for="Septic"  style="color:#6d6a69;">Septic Tank</label>
                                    <input type="checkbox" class="margin-left" class="margin-left"disabled="disabled"  class="styled-checkbox margin-left" id="STEP" <?php
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
                                    <label for="STEP"  style="color:#6d6a69;">STEP System  </label>
                                    <input type="checkbox" class="margin-left" class="margin-left"disabled="disabled"  class="styled-checkbox margin-left" id="SDOther" <?php
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
                                    <label for="SDOther" style="color:#6d6a69;">Other</label>
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
        <div class="col-lg-12 pull-right-div">
            <div class="form-group row">
                <div class="col-md-12  col-xs-12">
                    <div class="checkbox">
                        <input type="checkbox" class="margin-left" class="margin-left"disabled="disabled"  class="styled-checkbox margin-left"  <?php
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
                        <label for="Gas-Supply"  style="margin-top:5px; margin-right: 20px;">Gas Supply<span id='Gas-Supply-many'>  
                                <span class="margin-left pull-right-div">
                                    <input type="checkbox" class="margin-left" class="margin-left"disabled="disabled"  class="styled-checkbox margin-left" id="Utility" <?php
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
                                    <label for="Utility" style="color:#6d6a69;">Utility</label>
                                    <input type="checkbox" class="margin-left" class="margin-left"disabled="disabled"  class="styled-checkbox margin-left" id="Propane-Tank" <?php
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
                                    <label for="Propane-Tank" style="color:#6d6a69;"> Propane Tank</label>
                                    <input type="checkbox" class="margin-left" class="margin-left"disabled="disabled"  class="styled-checkbox margin-left" id="GSOther" <?php
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
                                    <label for="GSOther" style="color:#6d6a69;">Other:</label>
                                </span>
                            </span>
                        </label>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group">
            <h5 class="">Other items included:</h5>
            <div class="">
                <textarea type="text" rows="2" id="optional_message" disabled="disabled" class="form-control text-height" id="text-form-input">{{$property->disclosure->other_items_included??""}}</textarea>
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-12">
                <h5>To the best of seller's knowledge, are any in Part A above NOT in operating condition:</h5>
                <span class="margin-left">
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
                </span>
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
        <div id="seller" style="page-break-before:always;">
            <div class="form-group">
                <h5 class="">If Yes, Please Explain:</h5>  
                <div>
                    <p class="form-control text-height" style="margin-bottom:20px;" disabled="disabled">{{$property->disclosure->best_knowledge_explain??""}} </p>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="col-md-12">
                <h5>B. Is Seller AWARE of any defects or malfunctions in any of the following?</h5>
            </div><!--col-md-12-->
        </div>    
        <div class="form-group">
            <div class="">
                <div class="table-responsive">
                    <table class="table table-bordered" id="Seller-checkbox-table">
                        <thead>
                            <tr>
                                <th></th>
                                <th style="width:30px;">Yes</th> 
                                <th style="width:30px;">No</th>
                                <th style="width:30px;">N/A</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Interior Walls</td>
                                <td>
                                    <input type="radio" id="interior_wallsyes" <?php
                                    if (isset($property->disclosure)) {
                                        if ($property->disclosure->interior_walls == config('constant.inverse_property_condition_disclaimer.Yes')) {
                                            ?>
                                                   checked="checked"
                                                   <?php
                                               }
                                           }
                                           ?> disabled="disabled">
                                    <label for="interior_wallsyes"></label>
                                </td>
                                <td>
                                    <label class="">
                                        <input type="radio" id="interior_wallsNo" <?php
                                        if (isset($property->disclosure)) {
                                            if ($property->disclosure->interior_walls == config('constant.inverse_property_condition_disclaimer.No')) {
                                                ?>
                                                       checked="checked"
                                                       <?php
                                                   }
                                               }
                                               ?> disabled="disabled">
                                        <label for="interior_wallsNo"></label>
                                    </label>
                                </td>
                                <td><label class="">
                                        <input type="radio" disabled="disabled" class="radio-btn-active" <?php
                                        if (isset($property->disclosure)) {
                                            if ($property->disclosure->interior_walls == config('constant.inverse_property_condition_disclaimer.NA')) {
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
                                    <input type="radio" id="Ceilingsyes"<?php
                                    if (isset($property->disclosure)) {
                                        if ($property->disclosure->ceilings == config('constant.inverse_property_condition_disclaimer.Yes')) {
                                            ?>
                                                   checked="checked"
                                                   <?php
                                               }
                                           }
                                           ?>  disabled="disabled">
                                    <label for="Ceilingsyes"></label>
                                </td>
                                <td><label class="">
                                        <input type="radio" id="CeilingsNo" <?php
                                        if (isset($property->disclosure)) {
                                            if ($property->disclosure->ceilings == config('constant.inverse_property_condition_disclaimer.No')) {
                                                ?>
                                                       checked="checked"
                                                       <?php
                                                   }
                                               }
                                               ?> disabled="disabled">
                                        <label for="CeilingsNo"></label>
                                    </label>
                                </td>
                                <td><label class="">
                                        <input type="radio" class="radio-btn-active" id="CeilingsNA" <?php
                                        if (isset($property->disclosure)) {
                                            if ($property->disclosure->ceilings == config('constant.inverse_property_condition_disclaimer.NA')) {
                                                ?>
                                                       checked="checked"
                                                       <?php
                                                   }
                                               }
                                               ?> disabled="disabled">
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
                                        if ($property->disclosure->insulation == config('constant.inverse_property_condition_disclaimer.Yes')) {
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
                                            if ($property->disclosure->insulation == config('constant.inverse_property_condition_disclaimer.NA')) {
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
                                            if ($property->disclosure->electrical_system == config('constant.inverse_property_condition_disclaimer.No')) {
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
                                            if ($property->disclosure->electrical_system == config('constant.inverse_property_condition_disclaimer.NA')) {
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
                                        if ($property->disclosure->foundation == config('constant.inverse_property_condition_disclaimer.Yes')) {
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
                                            if ($property->disclosure->foundation == config('constant.inverse_property_condition_disclaimer.NA')) {
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
                                        if ($property->disclosure->side_walks == config('constant.inverse_property_condition_disclaimer.Yes')) {
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
                                            if ($property->disclosure->side_walks == config('constant.inverse_property_condition_disclaimer.NA')) {
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
                                            if ($property->disclosure->central_heating == config('constant.inverse_property_condition_disclaimer.No')) {
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
                                            if ($property->disclosure->central_heating == config('constant.inverse_property_condition_disclaimer.NA')) {
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

        <div class="form-group part-group-b">
            <h5 class="">If any of the above in Part B are marked YES, please explain:</h5>
            <div class="">
                <p  class="form-control text-height"  disabled="disabled">{{$property->disclosure->partb_details??""}}</p>
            </div>
        </div>
        <div class="form-group">
            <h5 for="" class=" control-label">Please describe any repairs made by you or any previous owners of which you are aware (attach separate sheets if necessary):</h5>
            <div class="">
                <p class="form-control text-height"  disabled="disabled">{{$property->disclosure->any_repairs??""}}</p>
            </div>
        </div>
        <div class="form-group">
            <h5 for="" class=" control-label">C. Is Seller AWARE of any of the following:</h5>
        </div>   

        <div class="form-group">
            <div class="">
                <div class="table-responsive">
                    <table class="table table-bordered" id="Seller-checkbox-table2">
                        <thead>
                            <tr>
                                <th></th>
                                <th style="width:30px;">Yes</th>
                                <th style="width:30px;">No</th> 
                                <th style="width:30px;">N/A</th>
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
                                        if ($property->disclosure->substances == config('constant.inverse_property_condition_disclaimer.Yes')) {
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
                                            if ($property->disclosure->substances == config('constant.inverse_property_condition_disclaimer.NA')) {
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
                                        if ($property->disclosure->features_shared == config('constant.inverse_property_condition_disclaimer.Yes')) {
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
                                            if ($property->disclosure->features_shared == config('constant.inverse_property_condition_disclaimer.No')) {
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
                                            if ($property->disclosure->features_shared == config('constant.inverse_property_condition_disclaimer.NA')) {
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
                                        if ($property->disclosure->any_authorized_changes == config('constant.inverse_property_condition_disclaimer.Yes')) {
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
                                            if ($property->disclosure->any_authorized_changes == config('constant.inverse_property_condition_disclaimer.No')) {
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
                                            if ($property->disclosure->any_authorized_changes == config('constant.inverse_property_condition_disclaimer.NA')) {
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
                                <td>4. Any changes since the most recent survey of the property was done? (Most recent survey of property: <span class="form-control">{{$property->disclosure->most_recent_survey??"NA"}}</span>
                                    ).
                                </td> 
                                <td>
                                    <input type="radio"  disabled="disabled" id="surveyyes" <?php
                                    if (isset($property->disclosure)) {
                                        if ($property->disclosure->any_change_since_latest_survey == config('constant.inverse_property_condition_disclaimer.Yes')) {
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
                                            if ($property->disclosure->any_change_since_latest_survey == config('constant.inverse_property_condition_disclaimer.No')) {
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
                                            if ($property->disclosure->any_change_since_latest_survey == config('constant.inverse_property_condition_disclaimer.NA')) {
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
                                        if ($property->disclosure->any_encroachments == config('constant.inverse_property_condition_disclaimer.Yes')) {
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
                                            if ($property->disclosure->any_encroachments == config('constant.inverse_property_condition_disclaimer.No')) {
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
                                            if ($property->disclosure->any_encroachments == config('constant.inverse_property_condition_disclaimer.NA')) {
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
                            <tr>
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
                                        if ($property->disclosure->repairs_with_building_codes == config('constant.inverse_property_condition_disclaimer.Yes')) {
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
                                            if ($property->disclosure->repairs_with_building_codes == config('constant.inverse_property_condition_disclaimer.No')) {
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
                                            if ($property->disclosure->repairs_with_building_codes == config('constant.inverse_property_condition_disclaimer.NA')) {
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
                                        if ($property->disclosure->structural_damage == config('constant.inverse_property_condition_disclaimer.Yes')) {
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
                                            if ($property->disclosure->any_zoning_violations == config('constant.inverse_property_condition_disclaimer.No')) {
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
                                            if ($property->disclosure->any_zoning_violations == config('constant.inverse_property_condition_disclaimer.NA')) {
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
                                            if ($property->disclosure->neighborhood_noise == config('constant.inverse_property_condition_disclaimer.No')) {
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
                            <tr style="page-break-before:always">
                                <td>17. S  ubdivision and/or deed restrictions or obligations?</td>
                                <td>
                                    <input type="radio"  disabled="
                                           disabled" id="restrictionsyes" <?php
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
                            <!--<div style="clear:both"></div>--> 
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
                        <div style="clear:both"></div> 
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
                        <div style="clear:both"></div> 
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
                        <div style="clear:both"></div>                             
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
                                <input type="text" class="readonly" id="text-form-input"  value="{{$property->disclosure->septic_tank_for_bedrooms??""}}">
                                number of bedrooms.</td> 
                            <td>
                                <input type="radio"  disabled="disabled" id="any_septic_tankyes" <?php
                                if (isset($property->disclosure)) {
                                    if ($property->disclosure->any_septic_tank == config('constant.inverse_property_condition_disclaimer.Yes')) {
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
                                        if ($property->disclosure->any_septic_tank == config('constant.inverse_property_condition_disclaimer.NA')) {
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
                                    if ($property->disclosure->in_an_historical_district == config('constant.inverse_property_condition_disclaimer.Yes')) {
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
                                        if ($property->disclosure->in_an_historical_district == config('constant.inverse_property_condition_disclaimer.No')) {
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
                                        if ($property->disclosure->in_an_historical_district == config('constant.inverse_property_condition_disclaimer.NA')) {
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

        <div class="form-group part-group-c">
            <h5 class=" control-label">If any of the above in Part C are marked YES, please explain:</h5>
            <div class="">
                <p class="form-control text-height"  disabled="disabled"  >{{$property->disclosure->partc_details??""}}</p>
            </div>
        </div> 

        <div class="form-group">
            <div class="">
                <p class="offer-text">Seller certifies that this information is true and correct to the best of seller's knowledge as of the date signed.</p>
                <p class="offer-text">Buyer understands that this Disclosure is not intended as a substitute for any inspection, and that buyer has a responsibility to pay diligent attention to and inquire about defects which are evident by careful observation. Buyer acknowledges receipt of a copy of this Disclosure. </p>
            </div>
        </div>
         @include('pdf.signature_common')
    </main>
</body>
</html>        