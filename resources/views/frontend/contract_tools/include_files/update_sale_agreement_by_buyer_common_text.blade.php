<?php
if (isset($offer->sale_counter_offers) && count($offer->sale_counter_offers)>0) {
    $purchasePrice = $offer->sale_counter_offers->first()->counter_offer_price;
}
?>
<div class="form-group">
    <div class="col-md-12">
        <h5>(d) PURCHASE PRICE:</h5> <p><span class="text-readonly money"><input type="text" class="readonly" id="text-form-input" value="{{isset($purchasePrice)?round($purchasePrice):round($offer->tentative_offer_price)}}" readonly="readonly"></span>
            Dollars, to be paid in cash or equivalent good funds at closing.</p>
    </div><!--col-md-12-->
</div>
<?php
if ($offer->sellerQuestionnaire->earnest_money == config('constant.inverse_common_yes_no.No')) {
    $noEarnestMoney = "";
}
if ($offer->sellerQuestionnaire->real_estate_agent == config('constant.inverse_common_yes_no.No')) {
    $norealEstateAgent = "";
}
?>
<div class="form-group">
    <div class="col-md-12">
        <h5>(e) EARNEST MONEY:</h5><p><span class="text-readonly span_with_values money">{{ !empty($offer->sellerQuestionnaire->amount_for_earnest_money)?$offer->sellerQuestionnaire->amount_for_earnest_money :'NA' }}</span>
            valid check or money order payable to Escrow Agent:  <span class="text-readonly span_with_values">{{ !empty($offer->sellerQuestionnaire->where_funds_deposited )? $offer->sellerQuestionnaire->where_funds_deposited:"NA" }}</span>
            whose address is:<span class="text-readonly span_with_values">{{ !empty($offer->sellerQuestionnaire->legal_firm_address)?$offer->sellerQuestionnaire->legal_firm_address:'NA' }}</span>
            will be promptly delivered to Escrow Agent <b>no later than 5:00 PM, three (3) calendar days after the Acceptance Date</b></p>
    </div><!--col-md-12-->
</div>
<div class="form-group">
    <div class="col-md-12">
        <h5>(f) CLOSING, EXPIRATION, & POSSESSION DATE: </h5><p>  <span class="text-readonly span_with_values">{{$offer->created_at->addMonth()}}</span>
            This is the date that the sale will be closed, or this Agreement will expire on this date at 11:59 PM. If this is not a business day, this date will be extended to the next business day. Any other change in this date must be agreed to in writing by all parties. Possession of the entire property will be given to the Buyer at the time of closing, unless a different time of possession is agreed to in a separate Occupancy Agreement.</p>
    </div><!--col-md-12-->
</div>
<div class="form-group">
    <div class="col-md-12">
        <h5> (g) ITEMS INCLUDED OR EXCLUDED:: </h5><p>Included, if present, as part of the property sale: all real estate, buildings, improvements, appurtenances (rights and privileges), and <b>fixtures</b>. Fixtures include all things which are attached to the structure(s) by nails, screws, or other permanent fasteners, including, but not limited to all of the following, if present: attached light fixtures and bulbs, ceiling fans, attached mirrors; heating and cooling equipment and thermostats; plumbing fixtures and equipment; all doors and storm doors; all windows, screens, and storm windows; all window treatments (draperies, curtains, blinds, shades, etc.) and hardware; all wall-to-wall carpet; all built-in kitchen appliances and stove; all bathroom fixtures; gas logs, fireplace doors and attached screens; all security system components and controls; garage door openers and all remote controls; swimming pool and its equipment; awnings; permanently installed outdoor cooking grills; all fencing, landscaping and outdoor lighting; and mail boxes. Other items included in the sale:</p>                                        
        <textarea type="text" id="optional_message" class="form-control text-height" readonly="readonly">{{$offer->sellerQuestionnaire->household_items??""}}</textarea>
        <h5>Items that are not included in the sale: </h5>
        <input class="form-control" type="text" value="{{$offer->saleAgreement->not_included_insale??""}}" readonly="readonly">
        <h5>Leased items: </h5>
        <input class="form-control" type="text" value="{{$offer->saleAgreement->leased_items??""}}" readonly="readonly">
    </div><!--col-md-12-->
</div>              
<div class="form-group">
    <div class="col-md-12">
        <h5>(h) CLOSING COSTS:</h5><p> Unless otherwise stated in Special Stipulations or Addenda, closing costs are to be paid as follows: 
            <b>Seller must pay </b>all Seller’s existing loans, liens and related costs affecting the sale of the property, Seller's settlement fees, real estate commissions, the balance on any leased items that remain with the property, and a <b>title insurance policy</b> with Buyer to receive benefit of simultaneous issue. Any existing rental or lease deposits must be transferred to Buyer at closing. 
            <b>Buyer must pay </b>transfer taxes, deed and deed of trust recording fees, association transfer fees, hazard and any other required insurance, Buyer's settlement fees, and<b> all Buyer’s loan related or lender required expenses.</b></p>
    </div><!--col-md-12-->
</div>
<div class="form-group">
    <div class="col-md-12">
        <h5>(i) PRORATIONS, TAXES & ASSESSMENTS:</h5><p>  The current year’s property taxes, any existing tenant leases or rents, association or maintenance fees, (and if applicable, any remaining fuel), will be prorated as of the date of closing. Taxes for prior years and any special assessments approved before date of closing must be paid by Seller at or before closing. If applicable, roll back taxes or any tax or assessment that cannot be determined by closing date should be addressed in Special Stipulations or Addenda and will survive the closing</p>
    </div><!--col-md-12-->
</div>
<div class="form-group">
    <div class="col-md-12">
        <h5>(j) HOME PROTECTION PLANS:</h5><p> Home Protection plans available for purchase are<b> waived, unless</b> addressed in Special Stipulations. Buyer and Seller understand that an administrative fee may be paid to the Real Estate Company if plan is purchased.</p>
    </div><!--col-md-12-->
</div>
<div class="form-group">
    <div class="col-md-12">
        <h5>(k) SPECIAL STIPULATIONS:</h5><p>  The following special stipulations, if in conflict with any language contained within the pages of this Purchase and Sale Agreement, will control:</p>
        <p>Stipulation (A)</p>
        <textarea type="text" rows="4" id="optional_message" class="form-control text-height" readonly="readonly">{{$offer->percentage_of_price?trans('strings.frontend.property.sale.stipulationPercentageA',['value'=>$offer->percentage_of_price]):($offer->fixed_amount?trans('strings.frontend.property.sale.stipulationFixedA',['value'=>$offer->fixed_amount]):"")}}</textarea>
        <p>Stipulation (B)</p>
        <textarea type="text" rows="4" id="optional_message" class="form-control text-height" readonly="readonly">{{$offer->sellerQuestionnaire->property_vacant_date?trans('strings.frontend.property.sale.stipulationB',['value'=>$offer->sellerQuestionnaire->property_vacant_date]):""}}</textarea>
        <p>Stipulation (C)</p>
        <textarea type="text" rows="4" id="optional_message" class="form-control text-height" readonly="readonly">{{$offer->contingencies_explain??""}}</textarea>
    </div><!--col-md-12-->
</div>
<div class="form-group">
    <div class="col-md-12">
        <h5>(l) TIME IS OF THE ESSENCE: </h5><p>The failure to meet specified time limits will be grounds for canceling this Agreement.</p>
    </div><!--col-md-12-->
</div>
<div class="form-group">
    <div class="col-md-12">
        <h5>(m) FAIR HOUSING AND EQUAL OPPORTUNITY:  </h5><p> This Property is being sold without regard to race, color, sex, religion, disability, marital status, family status, sexual orientation, age, ancestry, or national origin.</p>
    </div><!--col-md-12-->
</div>
<div class="form-group">
    <div class="col-md-12">
        <h5>(n)  FINANCIAL AND APPRAISAL CONTINGENCIES:   </h5><p>This Agreement is contingent on Buyer obtaining loan(s) of Buyer’s choice. Buyer must deliver to Seller<b> no later than 5:00 PM, ten (10) calendar days</b> after the Acceptance Date either documented <b>proof of available</b> funds adequate to close, or a lender's conditional <b>commitment letter </b> proving that: full loan application has been made; the appraisal has been ordered; Buyer’s new loan(s) is not contingent on the sale of any other property (unless otherwise stated in this Agreement); Buyer has necessary cash reserves; and providing reasonable assurance of Buyer's ability to obtain financing with rates, terms, payments and conditions acceptable to Buyer. Failure to timely provide proof of available funds or commitment letter will be grounds for Seller to cancel this Agreement by delivering written Notice to Buyer, and all Earnest Money must be refunded to Buyer.<b> VA/FHA Loan Addendum </b>must be attached if Buyer is seeking VA or FHA financing</p>
        <p><b>Appraisal Contingency -</b> this Agreement is also contingent on the appraisal value equaling or exceeding the purchase price. <b>If any repairs are required by the lender,</b> Buyer must deliver to Seller a written list of lender required repairs. Seller must deliver to Buyer, no later than 5:00 PM, three (3) calendar days after receiving the repair list, a written Notice stating whether or not Seller will complete the repairs before closing at Seller’s expense. If Seller does not agree to perform such repairs, or does not reply within the time limit, this Agreement will cancel and all Earnest Money must be refunded to Buyer <b>see exception in (p)]. If, at anytime,the financial or appraisal contingency is not satisfied,</b> Buyer may cancel this Agreement by delivering to Seller a written Notice of Cancellation, along with supporting documentation, and all Earnest Money must be refunded to Buyer.</p>
    </div><!--col-md-12-->
</div>
<div class="form-group">
    <div class="col-md-12">
        <h5>(o) INSPECTION CONTINGENCY AND DUE DILIGENCE PERIOD:</h5><p> This Agreement is contingent on Buyer's satisfaction with all property inspections and investigations. Buyer may use any inspectors of Buyer's choice, at Buyer's expense. Seller must permit Buyer, and Buyer’s representatives and inspectors, reasonable access for inspections,<b> with all utilities in service at Seller's expense.</b> Buyer assumes all liability for any damage or loss caused by Buyer’s or Buyer representatives’ inspections or investigations of the property. </p>
        <p> <b>Due Diligence Period: All inspections and investigations must be completed with response to Seller no later than 5:00 PM, ten (10) calendar days after the Acceptance Date. </b>During this due diligence period Buyer is strongly advised to: </p>
        <p>(A) have a<b> professional home inspection </b>conducted by a licensed home inspector (at Buyer’s expense), AND </p>
        <p>(B) have a <b>wood destroying insect inspection </b>conducted by a licensed pest inspector (at Buyer’s expense), AND </p>
        <p>(C) investigate all matters itemized in the<b> Advisory to Buyers and Sellers</b> (which is an Addendum to this Agreement), AND </p>
        <p>(D) perform any additional inspections and investigations desired, and verify any other matters of concern to the Buyer</p>
        <p><b>Inspection Contingency Resolution: </b>If Buyer is satisfied with all inspections and investigations, Buyer may deliver to Seller a<b> Notice of Release</b> of inspection contingency. If for <b>any</b> reason Buyer is<b> not </b>satisfied with the results of <b>any</b> inspection or investigation, the Buyer must, within the <b>Due Diligence Period </b>[described in (o) above], deliver to Seller<b> either: </b></p>
        <p>(1) a written<b> Notice of Cancellation,</b> canceling this Agreement, and all Earnest Money must be refunded to Buyer, OR </p>
        <p>(2) a written <b>Inspection Contingency Removal Proposal.</b> If Seller rejects Buyer’s <b>Proposal</b> (or Counterproposal) by delivering</p> 
        <p><i>a<b> Notice of Rejection</b> to Buyer, <b>or</b> if any Counterproposal is rejected by either party, <b>or </b>if a time limit for a written response to such is exceeded, this Agreement will cancel and all Earnest Money must be refunded to Buyer<b> [see exception in (p)].</b></i> </p>                             
        <p> Any Proposal, Counterproposal, Notice of Rejection, or Notice of Release of inspection contingency must be in writing.</p>
        <p> Any Proposal or Counterproposal must contain a time limit for responding (that is, an expiration date & time). </p> 
        <p>If it is discovered during the Due Diligence Period that any permanent structure on the property has an active wood destroying insect infestation, the Seller, upon Buyer’s request, must <b>professionally treat infestation before closing at Seller’s expense.</b> Repair of any damage from wood destroying insects must be negotiated in the Inspection Contingency Removal Proposal.<p>
        <p><b>CAUTION TO BUYER:</b> Failure to deliver to the Seller either a written<b> Notice of Release or Notice of Cancellation,</b> or a written<b> Inspection Contingency Removal Proposal within the Due Diligence Period </b>[described in (o) above] will be considered to be an acceptance of the property “as is,” and the Inspection Contingency will be satisfied and no longer a part of this Agreement.</p>
    </div><!--col-md-12-->
</div>
<div class="form-group">
    <div class="col-md-12">
        <h5>(p) BUYER’S RIGHT TO REINSTATE:  </h5><p> If Seller refuses to complete the lender required repairs [see(n) above], or cancels this Agreement by rejecting an Inspection Contingency Removal Proposal [see(o) above], Buyer has the right to reinstate the Agreement by delivering to Seller a Notice stating that the Buyer will accept the property in its present "as is" condition. Buyer’s Notice must be delivered to Seller no later than 5:00 PM, three (3) calendar days after the delivery of Seller's Notice of rejection, or if Seller has failed to respond<b>  no later than 5:00 PM, three (3) calendar days after the Seller’s </b> deadline to reply.</p>
    </div><!--col-md-12-->
</div>
<div class="form-group">
    <div class="col-md-12">
        <h5>(q) FINAL INSPECTION & RISK OF LOSS:  </h5><p> Buyer has the right and responsibility to perform a final inspection before closing to determine that the property is in the same condition, other than ordinary wear, as when the Agreement was accepted (with Seller having responsibility to remedy), and to see that any repairs agreed to be performed by Seller have been completed. Buyer may utilize inspectors.<b> All utilities must be in service at Seller's expense.</b> Closing of sale demonstrates acceptance of these items by Buyer. The risk of hazard or casualty loss or damage to the property will be the responsibility of Seller until closing.</p>
    </div><!--col-md-12-->
</div>
<div class="form-group">
    <div class="col-md-12">
        <h5>(r) DISBURSEMENT OF EARNEST MONEY, AND ADEQUATE CONSIDERATION:  </h5><p>  The Earnest Money will be applied towards the purchase price at closing. If any contingencies or conditions of this Agreement are not met and the Agreement is cancelled, all Earnest Money must be refunded to Buyer. If Seller fails to perform any obligation under this Agreement, all Earnest Money must be refunded to Buyer. If required, the Escrow Agent may file an interpleader action in a court of law, and recover expenses and reasonable attorney’s fees, and will have no further liability as Escrow Agent. All parties acknowledge that the consideration given, including the promises exchanged, the time limitations imposed, and the notifications required, is sufficient and adequate in exchange for the Buyer's right to legally, properly, and in good faith cancel, reinstate or extend this Agreement in accordance with the other terms of this Agreement.</p>
    </div><!--col-md-12-->
</div>
<div class="form-group">
    <div class="col-md-12">
        <h5>(s) TITLE, DEED, & SELLER REPRESENTATIONS:   </h5><p>Seller will convey to Buyer good and marketable title to the property by a valid general warranty deed. Seller, at Seller’s expense, agrees to furnish Buyer at closing a title insurance policy. Title policy will be issued by company acceptable to Buyer and Buyer’s lender. Buyer will receive benefit of simultaneous issue. <b> Seller represents </b> to the best of Seller’s knowledge, unless otherwise disclosed, that:<b>  property is not in a Special Flood Hazard Area or floodplain;</b>  there are no violations of building, zoning or fire codes; there are no encroachments or violations of setback lines, easements or property boundary lines; and there are no boundary line disputes. If at anytime the title examination, mortgage loan inspection, survey, or other information discloses any such defects, or if the Buyer discovers that any representation in this Agreement is in fact untrue, Buyer may, by delivering written Notice to Seller, either (1) accept the Property with the defects, OR (2) cancel this Agreement and all Earnest Money must be refunded to Buyer, OR (3) Buyer may extend the closing date by up to 3 calendar days to perform additional due diligence, retaining the right to exercise option (1) or (2) above.</p>
    </div><!--col-md-12-->
</div>
<div class="form-group">
    <div class="col-md-12">
        <h5>(t) DEFAULT OR BREACH:   </h5><p> If either party fails to perform any obligation under this Agreement, the other party may do any or all of the following: (1) cancel the Agreement (2) sue for specific performance, (3) sue for actual and compensatory damages. Legal counsel is strongly recommended in such circumstances.</p>
    </div><!--col-md-12-->
</div>
<div class="form-group">
    <div class="col-md-12">
        <h5>(u) REAL ESTATE COMMISSIONS:    </h5><p> REAL ESTATE COMMISSIONS: Seller authorizes closing company to debit Seller and pay commissions as follows at closing: Real Estate Firm Name: 
            <span class="text-readonly span_with_values">{{$offer->sellerQuestionnaire->real_estate_firm_name??""}}</span>
            will receive <span class="text-readonly span_with_values">{{$offer->sellerQuestionnaire->commission??""}}</span>
            % of the purchase price. Licensee’s Name and Contact Information:
            <span class="text-readonly span_with_values">{{($offer->sellerQuestionnaire->agent_name. " " . $offer->sellerQuestionnaire->agent_phone)?:""}}</span>
            . Other Real Estate Firm Name (if any):<span class="text-readonly"><input type="text" class="readonly" id="text-form-input" name="agentaddress" value="" readonly="readonly"></span>
            will receive  <span class="text-readonly"><input type="text" class="readonly" id="text-form-input" name="agentaddress" value="" readonly="readonly"></span>
            % of the purchase price. Other Licensee’s Name (if any) and Contact Information: <span class="text-readonly"><input type="text" class="readonly" id="text-form-input" name="agentaddress" value="" readonly="readonly"></span>
            .</p>
    </div><!--col-md-12-->
</div>
<?php
if (isset($offer->saleAgreement)) {
    $addendas = explode(',', $offer->saleAgreement->addenda);
}




?>
<div class="form-group addenda_attach">
    <div class="col-md-12">
        <h4>(v)   ADDENDA, ATTACHMENTS, EXHIBITS, DISCLAIMERS, AND DISCLOSURES:   </h4>
    </div><!--col-md-12-->
    <div class="col-md-12">
        <div class="checkbox">
            <input type="checkbox" class="styled-checkbox add_attach" disabled="disabled" <?php
            if (isset($addendas) && $addendas['0'] != '') {
                foreach ($addendas as $addenda) {
                    if ($addenda == config('constant.inverse_update_sale_agreement_by_seller.Lead-Based Paint Disclosure')) {
                        ?>
                               checked="checked"
                               <?php
                           }
                       }
                   } elseif (isset($offer->property) && $offer->property->architechture->year_built <= 1978) {
                       ?>
                       checked="checked"
<?php } ?> value="{{config('constant.inverse_update_sale_agreement_by_seller.Lead-Based Paint Disclosure')}}" name="addenda[]" id="addenda">
            <label for="addenda">Lead-Based Paint Disclosure<b> (required for housing constructed before 1978)</b> </label>
        </div>
    </div><!--col-md-12-->
    <div class="col-md-12">
        <div class="checkbox">
            <input type="checkbox" class="styled-checkbox add_attach" disabled="disabled" <?php
            if (isset($addendas) && $addendas['0'] != '') {
                foreach ($addendas as $addenda) {
                    if ($addenda == config('constant.inverse_update_sale_agreement_by_seller.Occupancy Agreement')) {
                        ?>
                               checked="checked"
                               <?php
                           }
                       }
                   } elseif(isset($offer->postClosing) && $offer->postClosing) {
                       ?>
                       checked="checked"
<?php } ?> value="{{config('constant.inverse_update_sale_agreement_by_seller.Occupancy Agreement')}}" name="addenda[]" id="Occupancy">
            <label for="Occupancy">Post-Closing Occupancy Agreement /or Existing Lease Agreement<b> (See Stipulation B above)</b> </label>
        </div>
    </div><!--col-md-12-->

    <div class="col-md-12 clearfix">
        <div class="checkbox">
            <input type="checkbox" class="styled-checkbox add_attach" disabled="disabled" <?php
            if (isset($addendas) && $addendas['0'] != '') {
                foreach ($addendas as $addenda) {
                    if ($addenda == config('constant.inverse_update_sale_agreement_by_seller.VA/FHA Loan Addendum')) {
                        ?>
                               checked="checked"
                               <?php
                           }
                       }
                   } elseif (isset($offer->buyerQuestionnaire) && $offer->buyerQuestionnaire->using_VA_or_FHA == 1) {
                       ?>
                       checked="checked"
<?php } ?> value="{{config('constant.inverse_update_sale_agreement_by_seller.VA/FHA Loan Addendum')}}" name="addenda[]" id="Addendum">
            <label for="Addendum">VA/FHA Loan Addendum<b> (required if sale involves VA or FHA financing)</b> </label>
        </div>
    </div><!--col-md-12-->
    <div class="col-md-12 clearfix">
        <div class="checkbox">
            <input type="checkbox" class="styled-checkbox add_attach" disabled="disabled" checked="checked" value="{{config('constant.inverse_update_sale_agreement_by_seller.Advisory to Buyers and Sellers')}}" name="addenda[]" id="Advisory">
            <label for="Advisory">Advisory to Buyers and Sellers </label>
        </div>
    </div><!--col-md-12-->
    <div class="col-md-12 clearfix">
        <div class="checkbox">
            <input type="checkbox" class="styled-checkbox add_attach" disabled="disabled" <?php
            if (isset($addendas) && $addendas['0'] != '') {
                foreach ($addendas as $addenda) {
                    if ($addenda == config('constant.inverse_update_sale_agreement_by_seller.Addendum')) {
                        ?>
                               checked="checked"
                               <?php
                           }
                       }
                   } elseif (isset($offer->postClosing) && $offer->postClosing) {
                       ?>
                       checked="checked"
<?php } ?> value="{{config('constant.inverse_update_sale_agreement_by_seller.Addendum')}}" name="addenda[]" id="Stipulations">
            <label for="Stipulations">Addendum (extra page for additional Special Stipulations, if needed) </label>
        </div>
    </div><!--col-md-12-->
    <div class="col-md-12 clearfix">
        <div class="checkbox">
            <input type="checkbox" class="styled-checkbox add_attach" <?php
            if (isset($addendas) && $addendas['0'] != '') {
                foreach ($addendas as $addenda) {
                    if ($addenda == config('constant.inverse_update_sale_agreement_by_seller.Other')) {
                        ?>
                               checked="checked"
                               <?php
                           }
                       }
                   }
                   ?> value="{{config('constant.inverse_update_sale_agreement_by_seller.Other')}}" name="addenda[]" id="other">
            <label for="other">Other</label>
        </div>
    </div><!--col-md-12-->
    <div class="col-md-12 clearfix">
        <div class="checkbox">
            <input type="text" class="form-control add_attach_other" id="text-form-input" data-msg-required="Please fill other" name="other" value="{{$offer->saleAgreement->other??""}}">
        </div>
    </div><!--col-md-12-->
    <div class="col-md-12 clearfix">
        <div class="checkbox">
            <p>And the following is integral to the residential Purchase and Sale Agreements:</p>
        </div>
    </div><!--col-md-12-->
    <div class="col-md-12 clearfix">
        <div class="checkbox">
            <input type="checkbox" class="styled-checkbox add_attach" name="addenda[]" id="Range" disabled="disabled" checked="checked" value="{{config('constant.inverse_update_sale_agreement_by_seller.Tennessee Residential Property Condition Disclosure')}}">
            <label for="Range">Residential Property Condition Disclosure </label>
        </div>
    </div><!--col-md-12-->
    <div class="addenda_attach_error error">Please select anyone of above</div>
</div>
<div class="form-group">
    <div class="col-md-12 clearfix">
        <h4 class="first-child">(w) METHOD OF EXECUTION AND DELIVERY:</h5><p>Signatures and 23initials transmitted by fax, photocopy, or digital signature methods will be acceptable and treated as originals. This Agreement constitutes the sole and entire agreement between the parties. No verbal agreements, representations, promises, or modifications of this Agreement will be binding unless agreed to in writing by all parties.<b> Delivery </b> will be considered to have been completed as of the date and time a document is either (1) delivered in person, OR (2) transmitted by fax, OR (3) transmitted by email. Delivery of documents to the real estate Licensee assisting a party as that party's agent or facilitator (or to that Licensee’s Broker) will be considered to be Delivery to that party.</p>
    </div><!--col-md-12-->
</div>
<div class="form-group">
    <div class="col-md-12">
        <h5>(x) ACCEPTANCE DATE AND BINDING CONTRACT:  </h5><p> The <b>Acceptance Date </b>will be the date of full execution (signing) of this Agreement by all parties, that is, the date one party accepts all the terms of the other party’s written and signed Offer or Counteroffer, evidenced by the accepting party’s signature and date on the Offer or Counteroffer. The Acceptance must be promptly communicated (by any reasonable and usual mode) to the other party, thereby making this Agreement a legally <b>Binding Contract.</b> Communications to the real estate Licensee assisting a party as that party's agent or facilitator (or to that Licensee’s Broker) will be considered to be communication to that party. Copies of the Contract must be promptly delivered to all parties.</p>
    </div><!--col-md-12-->
</div>
<div class="form-group">
    <div class="col-md-12">
        <h5>(y) OFFER EXPIRATION DATE & TIME:  </h5><p><span class="text-readonly">
                <input type="text" class="readonly" id="text-form-input" name="offerexpiration" value="{{$offer->buyerQuestionnaire->date_of_expiry??""}}" readonly="readonly"></span>
            .If not Accepted by this date & time (or if blank, at 5:00pm, three (3) calendar days past the offer submission), this Offer will expire. However, at any time before the other party’s communication of Acceptance, the party making the Offer may <b> withdraw </b> the Offer by communicating the withdrawal to the other party, and confirm the withdrawal by the prompt delivery of a written Notice of <b>Withdrawal.</b></p>
    </div><!--col-md-12-->
</div>  


