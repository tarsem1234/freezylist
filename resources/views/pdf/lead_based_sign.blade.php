<!DOCTYPE html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">   
    <title>Lead-Based Paint Hazards</title>
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
            border: 1px solid #ddd;
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
            border: 0.1em solid #000;
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
            border-color: #25bbe2;
            color: #fff;
        }

        input[type=checkbox]:disabled + label:before {
            transform: scale(1);
            border-color: #aaa;
        }

        input[type=checkbox]:checked:disabled + label:before {
            transform: scale(1);
            background-color: #bfb;
            border-color: #bfb;
        }
        input[type=checkbox]:checked + label:before {
            background: #25bbe2 ! important; 
        }
        .heading-text {                               
            margin-top: 30px;       
            text-transform: uppercase;
            border-bottom: 1px solid #dcdcd4;
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
            border: 1px solid #f6f6f6;
            width: 100%;
        }
        .table-bordered td { 
            border: 1px solid #f6f6f6;
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
            border: 1px solid #f0f0f0;
            border-radius: 20px; 
            text-transform: uppercase;
            box-shadow: none; 
            font-weight: 700;
            font-size: 12px;
            padding: 15px 1%;
            color: #000;  
            width: 98%;  
            height: 15px; 
        } 
        .readonly {
            border-radius: 5px;
            border: 1px solid #999;
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
            border-bottom: 1px solid #F2F4F4;
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
        .heading-text-buyer {
            margin-top: 50%;
        }
        .heading-text-seller {
            margin-top: 15%;
        }
        .margin-bottom {
            margin-bottom:5mm;
        }
    </style>     
</head> 
<body>
    <div class="container purchase-sale-agreement-review contract-tools-seller-common register-page ">
        <div class="row">
            <div class="">
                <div class="sidebar">
                </div>
                <div class="col-md-9 col-sm-8">
                    <div class="nested-div register-page">
                        <div class="heading-text">
                            <h2>Lead-Based Paint Hazards</h2>
                        </div>
                        <div class="para-text row">
                            <div class="form-group">
                                <div class="col-md-12">
                                    <h4 class="first-child">1. Lead Warning Statement</h4><p>Every purchaser of any interest in residential real property on which a residential dwelling was built prior to 1978 is notified that such property may present exposure to lead from lead-based paint that may place young children at risk of developing lead poisoning. Lead poisoning in young children may produce permanent neurological damage, including learning disabilities, reduced intelligence quotient, behavioral problems, and impaired memory. Lead poisoning also poses a particular risk to pregnant women. The seller of any interest in residential real property is required to provide the buyer with any information on lead-based paint hazards from risk assessments or inspections in the seller's possession and notify the buyer of any known lead-based paint hazards. A risk assessment or inspection for possible lead-based paint hazards is recommended prior to purchase.<br>
                                        <i><b>Please note seller's disclosure obligations under 42 U.S.C. 4852d.</b></i></p>
                                </div><!--col-md-12-->
                            </div>
                            <div class="form-group para-text">
                                <div class="col-md-12">
                                    <h4>2.Seller's/Lessor's Disclosure </h4>
                                    <h5>a. Presence of lead-based paint and/or lead-based paint hazards below:</h5>
                                    <input type="radio" name="lead_based" id="lead_based" <?php
                                    if (isset($offer->property->lead_based) && ($offer->property->lead_based) == config('constant.inverse_common_yes_no.Yes')) {
                                        ?>
                                               checked="checked"
                                           <?php } ?> disabled="disabled" value="{{config('constant.inverse_common_yes_no.Yes')}}">
                                    <label for="lead_based">Known lead-based paint and/or lead-based paint hazards are present in the housing.</label>
                                    <input type="radio" name="lead_based" id="lead_based-no" <?php
                                    if (isset($offer->property->lead_based) && ($offer->property->lead_based) == config('constant.inverse_common_yes_no.No')) {
                                        ?>
                                               checked="checked"
                                           <?php } ?> disabled="disabled" value="{{config('constant.inverse_common_yes_no.No')}}">
                                    <label for="lead_based-no">Seller has no knowledge of lead-based paint and/or lead-based paint hazards in the housing.</label>
                                    <h5>b. Records and reports available to the seller below:</h5>
                                    <input type="radio" name="lead_based_report" id="lead_based_report" <?php
                                    if (isset($offer->property->lead_based_report) && ($offer->property->lead_based_report) == config('constant.inverse_common_yes_no.Yes')) {
                                        ?>
                                               checked="checked"
                                           <?php } ?> disabled="disabled" value="{{config('constant.inverse_common_yes_no.Yes')}}">
                                    <label for="lead_based_report">Seller has provided the purchaser with all available records and reports pertaining to lead-based paint and/or lead-based paint hazards in the housing (list documents below).Known lead-based paint and/or lead-based paint hazards are present in the housing.</label>
                                    <input type="radio" name="lead_based_report" id="lead_based_report-no" <?php
                                    if (isset($offer->property->lead_based_report) && ($offer->property->lead_based_report) == config('constant.inverse_common_yes_no.No')) {
                                        ?>
                                               checked="checked"
                                           <?php } ?> disabled="disabled" value="{{config('constant.inverse_common_yes_no.No')}}">
                                    <label for="lead_based_report-no">Seller has no reports or records pertaining to lead-based paint and/or lead-based paint hazards in the housing.</label>
                                </div>
                            </div><!--col-md-12-->
                            <div class="form-group">
                                <div class="col-md-12">
                                    <h4>3.Purchaser's/Lessee's Acknowledgment (initial) </h4>
                                    <h5>c. Seller/Lessor hereby provides the Buyer/Lessee with the EPA's Lead Based Paint Pamphlet Here:<a href="{{asset('storage/pdf/Lead_Based_Paint_Disclosure.pdf')}}" target="_blank"> "Lead Based Paint Disclosure Pamphlet".</a> </h5>
                                    <p> Adobe Reader may be required to view this form- you may download a free version here:<a href="https://get.adobe.com/reader/otherversions/"> "Download Adobe Reader".</a> </p>
                                </div><!--col-md-12-->
                                <div class="col-md-12 clearfix">
                                    <div class="checkbox">
                                        <?php
                                        if (isset($offer->epa) && $offer->epa) {
                                            $epas = explode(',', $offer->epa);
                                        }
                                        ?>
                                        <input type="checkbox" class="styled-checkbox" name="epa[]" id="read-epa" <?php
                                        if (isset($offer->epa) && $offer->epa) {
                                            foreach ($epas as $epa) {
                                                if ($epa == config('constant.inverse_epa.readepa')) {
                                                    ?>
                                                           checked="checked"
                                                           <?php
                                                       }
                                                   }
                                               }
                                               ?> value="{{config('constant.inverse_epa.readepa')}}" disabled="disabled" >
                                        <label for="read-epa">I have read the EPA's "Lead Based Paint Disclosure Pamphlet" </label>
                                    </div>
                                </div><!--col-md-12-->
                                <div class="col-md-12">
                                    <div class="checkbox clearfix">
                                        <input type="checkbox" class="styled-checkbox" name="epa[]" id="received-copies" <?php
                                        if (isset($offer->epa) && $offer->epa) {
                                            foreach ($epas as $epa) {
                                                if ($epa == config('constant.inverse_epa.receivedcopies')) {
                                                    ?>
                                                           checked="checked"
                                                           <?php
                                                       }
                                                   }
                                               }
                                               ?> value="{{config('constant.inverse_epa.receivedcopies')}}" disabled="disabled" >
                                        <label for="received-copies">Purchaser has received copies of all information from the seller/lessor listed above. </label>
                                    </div>
                                </div><!--col-md-12-->
                            </div>
                            <div class="form-group clearfix">
                                <div class="col-md-12">
                                    <h5 class="first-child">d. Purchaser has check below:</h5>
                                    <input type="radio" name="opportunity" id="opportunityDay" <?php
                                    if (isset($offer->opportunity) && $offer->opportunity && $offer->opportunity == config('constant.inverse_lead_opportunity.10-day opportunity')) {
                                        ?>
                                               checked="checked"
                                               <?php
                                           }
                                           ?> value="{{config('constant.inverse_lead_opportunity.10-day opportunity')}}" disabled="disabled">
                                    <label for="opportunityDay">Received a 10-day opportunity (or mutually agreed upon period) to conduct a risk assess-ment or inspection for the presence of lead-based paint and/or lead-based paint hazards; or</label>
                                    <input type="radio" name="opportunity" id="opportunityWaived" <?php
                                    if (isset($offer->opportunity) && $offer->opportunity && $offer->opportunity == config('constant.inverse_lead_opportunity.Waived the opportunity')) {
                                        ?>
                                               checked="checked"
                                               <?php
                                           }
                                           ?> value="{{config('constant.inverse_lead_opportunity.Waived the opportunity')}}" disabled="disabled">
                                    <label for="opportunityWaived">Waived the opportunity to conduct a risk assessment or inspection for the presence of lead-based paint and/or lead-based paint hazards.</label>
                                </div><!--col-md-12-->
                            </div>

                            <div class="form-group">
                                <div class="col-md-12">
                                    <h4>4. Certification of Accuracy</h4><p>The following parties have reviewed the information above and certify, to the best of their knowledge, that the information they have provided is true and accurate.</p>
                                </div><!--col-md-12-->
                            </div>

                            @include('pdf.signature_common')
                        </div>
                    </div>
                </div><!--</col>-->
            </div><!--</col>-->
        </div><!--</row>-->
    </div><!--</contract-tools-seller-common>-->
</body>
</html>