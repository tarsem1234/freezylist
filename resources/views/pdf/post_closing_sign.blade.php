<!DOCTYPE html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">   
    <title>Post Closing Occupancy Agreement</title>
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
    <?php
                    $buyersArray = [];
                    $sellersArray = [];
                    foreach ($sellerQuestionnaire->saleOffer->signatures as $sign) {
                        if (in_array($sign['type'], [1, 3])) {
                            $buyersArray[] = $sign['fullname'];
                        } else {
                            $sellersArray[] = $sign['fullname'];
                        }
                    }
                    $allbuyers = implode(' , ', array_unique($buyersArray));
                    $allsellers = implode(' , ', array_unique($sellersArray));
                    ?>
        <div class="container purchase-sale-agreement-review contract-tools-seller-common">
            <div class="row">
                <div class="col-sm-12"> 
                    
                    <div class="col-md-9 col-sm-8">
                        <div class="nested-div register-page"> 
                            <div class="heading-text">
                                <h2>Post Closing Occupancy Agreement</h2>
                            </div>
                            <div class="para-text row">                          
                                <form>
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <p class="first-child"><b>Please Note:</b> This form should be used only for short-term residential occupancy for a term less than 30 days. A residential lease shall be used for a term longer than 30 days.</p>
                                        </div><!--col-md-12-->
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <p><b>1.</b>  This Post-Closing Occupancy Agreement (Agreement) is entered into between</p>
                                            <label>Buyer Name</label>
                                    <input type="text" class="form-control" value="{{!empty($allbuyers) ? $allbuyers:""}}" readonly="readonly" placeholder="freezylist buyer name">
                                     <label>Seller Name</label>
                                    <input type="text" class="form-control" value="{{!empty($allsellers) ? $allsellers:""}}" readonly="readonly" placeholder="freezylist seller name">

                                            <p>Related to the occupancy of the following property located at:</p>
                                            <div class="form-group">
                                                <label>Address: </label>
                                               @if(isset($sellerQuestionnaire->saleOffer->property))
                                               <input id="formatted_address" class="form-control" value="{{$sellerQuestionnaire->saleOffer->property->street_address}}" readonly="readonly">
                                               @else
                                               <input id="formatted_address" class="form-control" readonly="readonly">
                                               @endif
                                            </div>
                                            <?php
                                            if (isset($sellerQuestionnaire->saleOffer->property->city_id)) {
                                               $city = city($sellerQuestionnaire->saleOffer->property->city_id);
                                            }
                                            ?>
                                            <div class="form-group">
                                                <label>City: </label>
                                               <input id="city" class="form-control" type="text" value="{{isset($city)?$city->city:""}}" readonly="readonly">
                                            </div>

                                            <div class="form-group">
                                                <label>State: </label>
                                               <input id="state" class="form-control" type="text" readonly="readonly" value="{{ isset($sellerQuestionnaire->saleOffer->property->city_id) ? findState($sellerQuestionnaire->saleOffer->property->state_id):"" }}">
                                            </div>
                                            <div class="form-group">
                                                <label>Zip Code: </label>
                                               <input id="postal_code" class="form-control" min="0"  type="number" readonly="readonly" value="{{ isset($sellerQuestionnaire->saleOffer->property->zip_code_id) ? findZipCode($sellerQuestionnaire->saleOffer->property->zip_code_id):"" }}">
                                            </div>

                                         </div><!--col-md-12-->
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <p><b>2.</b> Buyer and Seller entered into that certain Contract to Buy and Sell Real Estate dated <span class="text-readonly"><input type="text" class="readonly" id="text-form-input" name="contract" value="" readonly="readonly"></span>
                                            and any amendments (Contract). All terms of the Contract are incorporated herein by reference. In the event of any conflict between this Agreement and the Contract, this Agreement shall control, subject to subsequent amendments to the Contract or this Agreement.</p>
                                        </div><!--col-md-12-->
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <p><b>3.</b> Seller shall retain possession of the Property from date of Closing to <span class="text-readonly"><input type="text" class="readonly" id="text-form-input" value="{{round($days)??""}}" readonly="readonly"></span> days subsequent to Closing as set forth in the Contract (Term).</p>
                                        </div><!--col-md-12-->
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <p><b>4.</b>  During the Term of this Agreement, Seller shall, at Seller's sole expense, keep the improvements and any personal property on the Property and owned by Buyer in the same condition and repair, normal wear and tear excepted, as of Closing, except as set forth in § 5. Unless such services are provided by a third party (e.g., homeowner's association), Seller also shall maintain the landscaping and mow the lawn as previously maintained. Seller shall provide timely notice to Buyer of any improvement requiring maintenance or repair.</p>
                                        </div><!--col-md-12-->
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <p><b>5.</b> Buyer shall, at Buyer's sole expense, maintain and repair the heating and cooling systems including ventilation and ducts,plumbing, electrical wiring, roof and structural components of the Property and all appliances in the Property owned by Buyer, and the lawn sprinkler system, if any. Seller shall be responsible for any misuse, waste, neglect or damage to the Property or personal property on the Property caused by Seller or Seller's family or visitors.</p>
                                        </div><!--col-md-12--> 
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <p><b>6.</b> Upon reasonable prior notice to Seller, Buyer shall have access to the Property at all reasonable times and Buyer, or Buyer's designee, may enter the Property without interference or disturbing Seller's possession of the Property. Buyer shall have the right, but not the obligation, to restore the Property and any items of personal property owned by Buyer to the same condition of repair and cleanliness as existed at the date of this Agreement, or Closing, whichever shall be later, and, in such event, Seller shall pay Buyer, in addition to the rent, the costs of such repair or replacement.</p>
                                        </div><!--col-md-12-->
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <p> <b>7.</b> Rent shall be at the rate of $ <span class="text-readonly">
                                                <input type="text" class="readonly" id="text-form-input" value="<?php
                                                    if (isset($currentMortgage)) {
                                                       echo $currentMortgage;
                                                    }
                                              ?>" name="perday" readonly="readonly"></span>
                                            per day for the Term of the occupancy, payable in advance at Closing and delivery of deed. Should Seller vacate earlier, the unearned rent:<br>
                                            <input type="radio" id="will" value="" name=""<?php
                                                if (isset($savedQuestionSellerPostClosing) && $savedQuestionSellerPostClosing->unearned_rents == config('constant.inverse_common_yes_no.Yes')) {
                                                   ?>
                                             checked="checked" <?php } ?>  disabled="disabled">
                                            <label for="will">Will</label>
                                            <input type="radio" id="will-not" value="" name="" <?php
                                   if (isset($savedQuestionSellerPostClosing) && $savedQuestionSellerPostClosing->unearned_rents == config('constant.inverse_common_yes_no.No')) {
                                      ?>
                                             checked="checked" <?php } ?> >
                                            <label for="will-not">Will not be</label>
                                            Will Not  be refunded to Seller.</p>
                                        </div>
                                    </div> 
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <?php
                                            if (isset($currentMortgage) && $currentMortgage) {
                                               if (isset($savedQuestionSellerPostClosing) && $savedQuestionSellerPostClosing->additional_charge == config('constant.inverse_common_yes_no.Yes')) {
                                                  $additional_charge = $currentMortgage * 125 / 100;
                                               } else {
                                                  $additional_charge = $currentMortgage;
                                               }
                                            }
                                            ?>
                                            <p><b>8.</b> Should Seller not timely surrender possession  of the Property to Buyer, Seller shall be subject to eviction and shall be additionally liable to Buyer for payment of $  
                                            <span class="text-readonly">
                                                <input type="text" class="readonly" id="text-form-input" value="{{isset($additional_charge)?round($additional_charge):""}}" readonly="readonly">
                                            </span>
                                            per day from and after the Term, until possession is delivered to Buyer.</p>
                                        </div><!--col-md-12-->
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <p><b>9.</b> Water and sewer charges incurred during Seller's occupancy shall be paid by:<br>
                                            <input type="radio" id="incurred yes" <?php
                                   if (isset($savedQuestionSellerPostClosing) && $savedQuestionSellerPostClosing->utilities == config('constant.inverse_common_yes_no.Yes')) {
                                      ?>
                                             checked="checked" <?php } ?> disabled="disabled">
                                            <label for="incurred yes">Buyer</label>
                                            <input type="radio" id="incurred no" <?php
                                   if (isset($savedQuestionSellerPostClosing) && $savedQuestionSellerPostClosing->utilities == config('constant.inverse_common_yes_no.No')) {
                                      ?>
                                             checked="checked" <?php } ?> disabled="disabled">
                                            <label for="incurred no">Seller  </label></p>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <p><b>10.</b> Electric and gas service incurred during Seller's occupancy shall be paid by:</br>
                                                <input type="radio" id="electricpaidbyyes" <?php
                                   if (isset($savedQuestionSellerPostClosing) && $savedQuestionSellerPostClosing->utilities == config('constant.inverse_common_yes_no.Yes')) {
                                      ?>
                                             checked="checked" <?php } ?> disabled="disabled">
                                            <label for="electricpaidbyyes">Buyer</label>
                                            <input type="radio" id="electricpaidbyno" <?php
                                   if (isset($savedQuestionSellerPostClosing) && $savedQuestionSellerPostClosing->utilities == config('constant.inverse_common_yes_no.No')) {
                                      ?>
                                             checked="checked" <?php } ?> disabled="disabled">
                                            <label for="electricpaidbyno">Seller  </label>
                                            Arrangements for the final reading and payments for said utilities and services shall be made by both parties.<p>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <p><b>11. </b>
                                                <input type="radio" id="payBuyer" name=""<?php
                                                if (isset($savedQuestionSellerPostClosing) && $savedQuestionSellerPostClosing->renter_policy == config('constant.inverse_common_yes_no.Yes')) {
                                                   ?>
                                                          checked="checked" <?php } ?> disabled="disabled">
                                                <label for="payBuyer">Will</label>
                                                <input type="radio" id="paySeller" name="waterpaidby"
                                                <?php
                                                if (isset($savedQuestionSellerPostClosing) && $savedQuestionSellerPostClosing->renter_policy == config('constant.inverse_common_yes_no.No')) {
                                                   ?>
                                                          checked="checked" <?php } ?> disabled="disabled">
                                                <label for="paySeller">Will Not</label>
                                                Will Not  maintain and pay the cost of (1) a Seller's "Renters Policy" covering Seller's personal property on the Property and (2)
                                                <input type="radio" id="costBuyer" name=""  <?php
                                                if (isset($savedQuestionSellerPostClosing) && $savedQuestionSellerPostClosing->liability_insurance == config('constant.inverse_common_yes_no.Yes')) {
                                                   ?>
                                                          checked="checked" <?php } ?> value="Buyer" disabled="disabled">
                                                <label for="costBuyer">Will</label>
                                                <input type="radio" id="costSeller" name="waterpaidbyr" <?php
                                                if (isset($savedQuestionSellerPostClosing) && $savedQuestionSellerPostClosing->liability_insurance == config('constant.inverse_common_yes_no.No')) {
                                                   ?>
                                                          checked="checked" <?php } ?>  disabled="disabled">
                                                <label for="costSeller">Will Not</label>
                                                maintain and pay the cost of adequate liability insurance in favor of both Seller and Buyer and supply to Buyer evidence of such insurance. Buyer agrees to maintain and shall pay the cost of Homeowner's Property Insurance Policy (which may be endorsed as a non-owner occupant/Buyer).
                                             </p>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <p><b>12.</b> Seller agrees that a security deposit in the amount of  $  
                                                <span class="text-readonly">
                                                    <?php
                                                    if (isset($savedQuestionSellerPostClosing)) {
                                                       if ($savedQuestionSellerPostClosing->refundable_security == config('constant.inverse_common_yes_no.Yes')) {
                                                          $deposit_security = $savedQuestionSellerPostClosing->current_mortgage * 1.5;
                                                       } else {
                                                          $deposit_security = $savedQuestionSellerPostClosing->current_mortgage;
                                                       }
                                                    }
                                                    ?>
                                                    <input type="text" class="readonly" value="{{$deposit_security??0}}" readonly="readonly">
                                                </span>
                                            will be held by the Buyer from Closing until Seller vacates the Property. The security deposit shall be held and disbursed pursuant to the laws of the state. Generally, within one month after the Term of this Agreement.</p>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-12"
                                            <p><b>13.</b> Anything to the contrary here in not with standing, in the event of any arbitration or litigation relating to this Agreement, prior to or after the Term of this Agreement, the arbitrator or court shall award to the prevailing party all reasonable costs and expenses, including attorney fees, legal fees and expenses.</p>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <p> <b>14. <label>ADDITIONAL PROVISIONS:</label> </p>  
                                            <textarea rows="2" type="text" class="form-control text-height" disabled="disabled">{{$savedQuestionSellerPostClosing->additional_provisions??""}}</textarea>
                                        </div>
                                    </div>

                                    @include('pdf.signature_common')


                                </div>
                            </div>
                        </div>
                    </div>
                </div><!--</col>-->
            </div><!--</row>-->
        </div><!--</contract-tools-seller-common>-->
    </body>
</html>