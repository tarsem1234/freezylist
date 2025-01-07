<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\View\View;

class RentContractToolController extends Controller
{
    public function contractToolsRent(): View
    {

        return view('frontend.contract_tools.rent.contract_tools_rent');
    }

    public function questionsToLandlord(): View
    {

        return view('frontend.contract_tools.rent.questions_to_landlord');
    }

    public function addSignersContractRentLandlord(): View
    {
        return view('frontend.contract_tools.rent.add-signers-contract-rent-landlord');
    }

    public function thankYouToLandlordForAnswer(): View
    {
        return view('frontend.contract_tools.rent.thank_you_to_landlord_for_answer');
    }

    public function disclosuresRentContractTool(): View
    {
        return view('frontend.contract_tools.rent.disclosures_rent_contract_tool');
    }

    public function thankyouDiscloserTool(): View
    {
        return view('frontend.contract_tools.rent.thankyou_discloser_tool');
    }

    public function leaseAgreement(): View
    {
        return view('frontend.contract_tools.rent.lease_agreement');
    }

    public function thankyouLeaseAgreementLandlord(): View
    {
        return view('frontend.contract_tools.rent.thankyou_lease_agreement_landlord');
    }

    // rent buyer
    public function questionSetForTenant(): View
    {
        return view('frontend.contract_tools.rent.buyer.question_set_for_tenant');
    }

    public function addSignersContractRentTenant(): View
    {
        return view('frontend.contract_tools.rent.buyer.add_signers_contract_rent_tenant');
    }

    public function summaryKeyTermsForTenant(): View
    {
        return view('frontend.contract_tools.rent.buyer.summary_key_terms_for_tenant');
    }

    public function thankYouForReviewSummaryKeyTerms(): View
    {
        return view('frontend.contract_tools.rent.buyer.thank_you_for_review_summary_key_terms');
    }

    public function disclosuresRentContractToolReviewTenant(): View
    {
        return view('frontend.contract_tools.rent.buyer.disclosures_rent_contract_tool_review_tenant');
    }

    public function thankyouDiscloserToolTenant(): View
    {
        return view('frontend.contract_tools.rent.buyer.thankyou_discloser_tool_tenant');
    }

    public function leaseAgreementReviewTenant(): View
    {
        return view('frontend.contract_tools.rent.buyer.lease_agreement_review_tenant');
    }

    public function thankyouLeaseAgreementTenant(): View
    {
        return view('frontend.contract_tools.rent.buyer.thankyou_lease_agreement_tenant');
    }
}
