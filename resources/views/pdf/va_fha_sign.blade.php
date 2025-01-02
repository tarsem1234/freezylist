<!DOCTYPE html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">   
    <title>VA-FHA Loan Addendum</title>
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
    <div class="container purchase-sale-agreement-review contract-tools-seller-common">
        <div class="row">
            <div class="col-sm-12">
                <div class="col-md-9 col-sm-8">
                    <div class="nested-div register-page">
                         <?php
                    $buyersArray = [];
                    $sellersArray = [];
                    foreach ($offer->signatures as $sign) {
                        if (in_array($sign['type'], [1, 3])) {
                            $buyersArray[] = $sign['fullname'];
                        } else {
                            $sellersArray[] = $sign['fullname'];
                        }
                    }
                    $allbuyers = implode(' , ', array_unique($buyersArray));
                    $allsellers = implode(' , ', array_unique($sellersArray));
                    ?>
                        <div class="heading-text">
                            <h2>VA-FHA Loan Addendum</h2>
                        </div>
                        <div class="para-text row mar-top">
                            <div class="form-group">
                                <div class="col-md-12">
                                    <h4 class="first-child">PROPERTY ADDRESS:</h4>
                                        <div class="form-group">
                                            <label>Street Address </label>
                                            <input type="text" class="form-control"  value="{{($offer->propertyConditional->street_address??"") . ($offer->propertyConditional->townhouse_apt? ' , Apt# '.$offer->propertyConditional->townhouse_apt :"") }}" readonly="readonly">
                                        </div>
                                        <div class="form-group">
                                            <label>City: </label>
                                            <input id="city" class="form-control" value="{{ getCityName($offer->propertyConditional->city_id) }}" readonly="readonly">
                                        </div>

                                        <div class="form-group">
                                            <label>state: </label>
                                            <input id="state" class="form-control" value="{{ findState($offer->propertyConditional->state_id) }}" readonly="readonly">
                                        </div>
                                        <div class="form-group">
                                            <label>Zip code: </label>
                                            <input id="postal_code" class="form-control" min="0" value="{{ findZipCode($offer->propertyConditional->zip_code_id) }}"  readonly="readonly">
                                        </div>
                                        <label>Buyer(s):  </label>
                                        <input type="text" class="form-control" readonly="readonly" value="{{!empty($allbuyers) ? $allbuyers:''}}">
                                        <label>Seller(s):  </label>
                                        <input type="text" class="form-control" value="{{!empty($allsellers) ? $allsellers:''}}" readonly="readonly">
                                        <h5>This VA / FHA Loan Addendum is made a part of the Purchase and Sale Agreement for the Property identified above. Should any terms of this Addendum conflict with the terms of the Purchase and Sale Agreement, the terms of this agreement will take precedence.</h5>
                                </div><!--col-md-12-->
                            </div>
                             <?php
                            if (isset($offer->sale_counter_offers) && count($offer->sale_counter_offers) > 0) {
                                $purchasePrice = $offer->sale_counter_offers->first()->counter_offer_price;
                            }
                            ?>
                            <div class="form-group">
                                <div class="col-md-12">
                                    <h4> AMENDATORY CLAUSE:</h4> <p> "An amendatory clause must be included in the sales contract when the borrower has not been informed of the appraised value… The amendatory clause must contain the following language:" "It is expressly agreed that notwithstanding any other provisions of this contract, the purchaser shall not be obligated to complete the purchase of the property described herein or to incur any penalty by forfeiture of earnest money deposits or otherwise unless the purchaser has been given in accordance with HUD/FHA or VA requirements a written statement by the Federal Housing Commissioner, Department of Veterans Affairs, or a Direct Endorsement lender setting forth the appraised value of the property of not less than $
                                        <input type="text" class="readonly" id="text-form-input" name="appraised_value" value="{{ isset($purchasePrice)?$purchasePrice:$offer->tentative_offer_price }}" readonly="readonly">
                                        [sales price as stated in the contract]. The purchaser shall have the privilege and option of proceeding with consummation of the contract without regard to the amount of the appraised valuation. The appraised valuation is arrived at to determine the maximum mortgage the Department of Housing and Urban Development will insure. HUD does not warrant the value or the condition of the property. The purchaser should satisfy himself/herself that the price and condition of the property are acceptable." (HUD Handbook 4155.1 Chapter 3-4)</p>
                                </div><!--col-md-12-->
                            </div>
                            <div class="form-group">
                                <div class="col-md-12">
                                    <h4>INSPECTIONS, REPAIRS, AND CONDITION OF PROPERTY:</h4><p> VA and FHA do not guarantee the value or condition of a home, or that it is free of defects. VA and FHA appraisals are not intended to be "home inspections." VA and FHA appraisals, seller's property condition disclosures, and Home Protection Plans are not substitutes for a professional home inspection. Well, septic, wood destroying insect and other inspections or certifications may be required. The lender may also require that certain repairs or treatments be completed, or that the property be connected to public water or sewer if available and feasible. The costs of any such inspections, certifications, treatments, connections or repairs should be negotiated in the Purchase and Sale Agreement.</p>
                                </div><!--col-md-12-->
                            </div>
                            <div class="form-group" style="page-break-before:always;">
                                <div class="col-md-12">
                                    <h4> CLOSING COSTS AND NON-ALLOWABLE SETTLEMENT CHARGES:</h4> <p> Government guidelines do not allow certain charges to be paid by the buyer. These "non-allowable" charges must be paid by the seller or the lender. Any seller contributions to the buyer's closing costs (including the VA Funding Fee) must be addressed in the Purchase and Sale Agreement, and any non-allowable charges will be included in the total amount of any seller contributions negotiated.</p>
                                </div><!--col-md-12-->
                            </div>
                            <div class="form-group">
                                <div class="col-md-12">
                                    <h4> REAL ESTATE CERTIFICATION:</h4><p> The buyer and seller certify that the terms and conditions of the sales contract are true to the best of their knowledge and belief and that any other agreement entered into by any of the parties in connection with the real estate transaction is part of, or attached to, the sales agreement." (HUD Handbook 4155.1, 3-3).</p>
                                </div><!--col-md-12-->
                            </div>

                        </div>
                        @include('pdf.signature_common')
                    </div>
                    <!--sdSaleAgreementReviewBySeller-->
                </div>
            </div><!--</col>-->
        </div><!--</row>-->
    </div><!--</contract-tools-seller-common>-->
</body>
</html>