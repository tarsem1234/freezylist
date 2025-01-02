<?php

namespace App\Http\Controllers\Frontend\ContractTools;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\BuyerQuestionnaireRequest;
use App\Http\Requests\Frontend\ContractTools\SaveLeadBasedPaintHazardsBuyerContractToolBuyerRequest;
use App\Mail\Frontend\SaleAgreementLandlordMailing;
use App\Models\Access\User\User;
use App\Models\BuyerQuestionnaire;
use App\Models\Property;
use App\Models\PropertyConditionalData;
use App\Models\QuestionSellerPostClosing;
use App\Models\SaleOffer;
use App\Models\SellerQuestionnaire;
use App\Models\Signature;
use App\Models\Signer;
use App\Models\UpdateSaleAgreementBysellerContract;
use App\Services\EmailLogService;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class ContractToolBuyerController extends Controller
{
    public function questionSetForBuyer(): View
    {
        $signers = Signer::where('from_user_id', Auth::id())->whereHas('invited_users')->with('invited_users')->get();

        $offerSession = Session::get('OFFER');

        $buyerQuestionnaire = BuyerQuestionnaire::where('offer_id', $offerSession['offer_id'])
            ->where('user_id', Auth::id())->first();

        return view('frontend.contract_tools.sale.buyer.question_set_for_buyer', compact('signers', 'buyerQuestionnaire'));
    }

    public function storeQuestionSetForBuyer(BuyerQuestionnaireRequest $request, $id = null)
    {
        $offerArray = Session::get('OFFER');
        $data = $request->all();
        $buyerQuestion = BuyerQuestionnaire::where('offer_id', $offerArray['offer_id'])
            ->where('user_id', Auth::id())->first();

        if (! empty($buyerQuestion)) {
            return $this->_updateQuestionSetForBuyer($data, $buyerQuestion->id);
        } elseif (empty($buyerQuestion) && $id != null) {
            return redirect()->back()->withFlashDanger('Invalid Offer.');
        }

        $buyerQuestionnaire = new BuyerQuestionnaire;

        $buyerQuestionnaire->offer_id = $offerArray['offer_id'];
        $buyerQuestionnaire->user_id = Auth::id();
        $buyerQuestionnaire->using_VA_or_FHA = $data['using_VA_or_FHA'];
        $buyerQuestionnaire->set_specific_date = $data['set_specific_date'];
        $buyerQuestionnaire->addendum = $data['addendum'];
        $buyerQuestionnaire->joint_cowners = $data['add_signer'];

        if ($data['addendum'] == config('constant.inverse_common_yes_no.Yes')) {
            $formattedDate = str_replace('/', '-', $data['close_date']);

            $buyerQuestionnaire->close_date = date('Y-m-d', strtotime($formattedDate));
        }
        if ($data['set_specific_date'] == config('constant.inverse_common_yes_no.Yes')) {
            $formattedDate = str_replace('/', '-', $data['date_of_expiry']);

            $buyerQuestionnaire->date_of_expiry = date('Y-m-d', strtotime($formattedDate));
        }

        if ($data['add_signer'] == config('constant.inverse_common_yes_no.Yes')) {
            if (isset($data['select-email']) && count($data['select-email']) > 1) {
                $emailIds = implode(',', $data['select-email']);
                $buyerQuestionnaire->partners = $emailIds;
            } else {
                $buyerQuestionnaire->partners = $data['select-email'][0];
            }
        } else {
            $buyerQuestionnaire->partners = null;
        }
        if ($buyerQuestionnaire->save()) {
            return redirect()->route('frontend.thankYouToBuyerForAnswer');
        }

        return redirect()->back()->withFlashDanger('Failed to update your answers. Please try again.');
    }

    private function _updateQuestionSetForBuyer($data, $id)
    {
        $buyerQuestionnaire['using_VA_or_FHA'] = $data['using_VA_or_FHA'];
        $buyerQuestionnaire['set_specific_date'] = $data['set_specific_date'];
        $buyerQuestionnaire['addendum'] = $data['addendum'];
        $buyerQuestionnaire['joint_cowners'] = $data['add_signer'];
        $buyerQuestionnaire['partners'] = null;
        if ($data['addendum'] == config('constant.inverse_common_yes_no.Yes')) {
            $buyerQuestionnaire['close_date'] = $data['close_date'];
        }
        if ($data['set_specific_date'] == config('constant.inverse_common_yes_no.Yes')) {
            $buyerQuestionnaire['date_of_expiry'] = $data['date_of_expiry'];
        }
        if ($data['add_signer'] == config('constant.inverse_common_yes_no.Yes')) {
            if (isset($data['select-email']) && count($data['select-email']) > 1) {
                $emailIds = implode(',', $data['select-email']);
                $buyerQuestionnaire['partners'] = $emailIds;
            } else {
                $buyerQuestionnaire['partners'] = $data['select-email'][0];
            }
        }

        if (BuyerQuestionnaire::where('id', $id)->update($buyerQuestionnaire)) {

            return redirect()->route('frontend.thankYouToBuyerForAnswer');
        }

        return redirect()->back()->withFlashDanger('Failed to update your answers. Please try again.');
    }

    public function thankYouToBuyerForAnswer(): View
    {
        return view('frontend.contract_tools.sale.buyer.thank_you_to_buyer_for_answer');
    }

    public function summaryKeyTermsForBuyer(): View
    {
        $offerArray = Session::get('OFFER');

        if ($offerArray['type'] == config('constant.inverse_property_type.Sale')) {
            $offer = SaleOffer::where('id', $offerArray['offer_id'])
                ->with(['property.architechture', 'property.propertyConditionDisclaimer' => function ($propertyCondDis) {
                    $propertyCondDis->select('best_knowledge_explain', 'partb_details', 'partc_details');
                }, 'sellerQuestionnaire', 'buyerQuestionnaire', 'seller' => function ($sellerQuery) {
                    $sellerQuery->with('user_profile', 'business_profile');
                }, 'buyer' => function ($buyerQuery) {
                    $buyerQuery->with('user_profile', 'business_profile');
                }, 'sale_counter_offers' => function ($query) {
                    $query->latest();
                }, 'saleAgreement'])->first();
        }

        return view('frontend.contract_tools.sale.buyer.summary_key_terms_for_buyer', compact('offer'));
    }

    public function advisoryToBuyersAndSellers(): View
    {
        $offerArray = Session::get('OFFER');
        if ($offerArray['type'] == config('constant.inverse_property_type.Sale')) {
            $offer = SaleOffer::where('id', $offerArray['offer_id'])
                ->with(['buyer.user_profile', 'buyer.business_profile', 'seller.user_profile',
                    'seller.business_profile', 'property' => function ($query) {
                        $query->withTrashed();
                    }])->first();
        }

        //        if ($offer->property->architechture->year_built < config('constant.year_built')) {
        //            return view('frontend.contract_tools.lead_based_paint_hazards');
        //        }
        return view('frontend.contract_tools.sale.buyer.advisory_to_buyers_and_sellers', compact('offer'));
    }

    public function advisoryToBuyersAndSellersThankYouBuyer(): View
    {
        return view('frontend.contract_tools.sale.buyer.advisory_to_buyers_and_sellers_thank_you_buyer');
    }

    public function vaThankYouForBuyer(): RedirectResponse
    {
        $propertyId = Session::get('PROPERTY');
        $property = Property::where('id', $propertyId)->with('architechture')->withTrashed()->first();
        if ($property->architechture['year_built'] < config('constant.year_built')) {
            return redirect()->route('frontend.thankYouLeadBasedBuyer');
        }

        return redirect()->route('frontend.checkVaFhaBuyer');
    }

    public function checkVaFhaBuyer()
    {
        $offerData = Session::get('OFFER');
        $buyerQues = BuyerQuestionnaire::where('offer_id', $offerData['offer_id'])->first();
        if ($buyerQues->using_VA_or_FHA == 1) {
            return view('frontend.contract_tools.sale.buyer.thankyou_pd_buyer');
        }

        return redirect()->route('frontend.checkPostClosing');
    }

    public function thankYouLeadBasedBuyer(): View
    {
        return view('frontend.contract_tools.thank_you_lead_based_buyer');
    }

    public function checkPostClosing(): View
    {
        $offerData = Session::get('OFFER');
        $postClosingQuestion = QuestionSellerPostClosing::where('offer_id', $offerData['offer_id'])->first();
        //        dd($postClosingQuestion);
        if (! empty($postClosingQuestion->show_post_closing) && $postClosingQuestion->show_post_closing == config('constant.show_post_closing_form.No')) {
            return view('frontend.contract_tools.sale.buyer.va_fha_thank_you_for_buyer');
        }

        return view('frontend.contract_tools.sale.buyer.va_thank_you_for_buyer');
    }

    public function leadBasedPaintHazardsBuyer($id = null)
    {
        $offerData = Session::get('OFFER');
        if ($id && Property::where('id', $id)->where('user_id', Auth::id())->where('property_type', 1)->withTrashed()) {
            $property = true;
            $offer = Property::where('id', $id)
                ->select('id', 'lead_based', 'lead_based_report', 'user_id')
                ->withTrashed()
                ->first();

            return view('frontend.contract_tools.lead_based_paint_hazards_buyer', compact('offer', 'property'));
        } elseif (Session::get('PROPERTY') && Property::where('id', Session::get('PROPERTY'))
            ->where('user_id', Auth::id())
            ->where('property_type', 2)->withTrashed()) {
            $offer = SaleOffer::where('id', $offerData['offer_id'])
                ->with(['property' => function ($query) {
                    $query->select('id', 'lead_based', 'lead_based_report', 'user_id');
                    $query->withTrashed();
                }])->first();

            return view('frontend.contract_tools.lead_based_paint_hazards_buyer', compact('offer'));
        }

        return redirect()->back()->with(['flash_danger' => 'Something went wrong']);
    }

    public function saveLeadBasedPaintHazardsBuyer(SaveLeadBasedPaintHazardsBuyerContractToolBuyerRequest $request): RedirectResponse
    {
        $epa = [1, 2];

        $data = $request->all();
        if (isset($data['epa']) && $data['epa']) {
            $input['epa'] = implode(',', $data['epa']);
        } else {
            $input['epa'] = null;
        }
        $input['opportunity'] = $data['opportunity'];
        if (SaleOffer::where('id', Session::get('OFFER.offer_id'))->where('sender_id', Auth::id())->update($input)) {
            Session::put('leadBased', true);

            return redirect()->route('frontend.thankyouPdBuyer');
        }

        return redirect()->back();
    }

    public function postClosingOccupancyAgreementByBuyer(): View
    {
        $offerData = Session::get('OFFER');
        $savedQuestionSellerPostClosing = QuestionSellerPostClosing::where('offer_id', $offerData['offer_id'])
            ->with('saleOffer')->first();

        $sellerQuestionnaire = SellerQuestionnaire::where('offer_id', $offerData['offer_id'])
            ->with(['saleOffer.seller.user_profile', 'saleOffer.seller.business_profile',
                'saleOffer.buyer.user_profile', 'saleOffer.buyer.business_profile',
                'saleOffer.property'])->first();
        $currentDate = date('Y-m-d');
        $days = null;
        $currentMortgage = null;
        if ($sellerQuestionnaire) {
            $days = (strtotime($sellerQuestionnaire->property_vacant_date) - strtotime($currentDate)) / (60 * 60 * 24);
            $days = $days - 30;
        }
        if ($savedQuestionSellerPostClosing) {
            $currentMortgage = $savedQuestionSellerPostClosing->current_mortgage / 30;
        }

        return view('frontend.contract_tools.sale.buyer.post_closing_occupancy_agreement_by_buyer', compact('savedQuestionSellerPostClosing', 'sellerQuestionnaire', 'days', 'currentMortgage'));
    }

    public function postClosingThankyouByBuyer(): View
    {
        return view('frontend.contract_tools.sale.buyer.post_closing_thankyou_by_buyer');
    }

    public function updateSaleAgreementBybuyer()
    {
        Session::forget('leadBased');
        $offerArray = Session::get('OFFER');

        if ($offerArray['type'] == config('constant.inverse_property_type.Sale')) {
            $offer = SaleOffer::where('id', $offerArray['offer_id'])
                ->with(['property.propertyConditionDisclaimer' => function ($propertyCondDis) {
                    $propertyCondDis->select('best_knowledge_explain', 'partb_details', 'partc_details');
                }, 'sellerQuestionnaire', 'buyerQuestionnaire', 'seller' => function ($sellerQuery) {
                    $sellerQuery->with('user_profile', 'business_profile');
                }, 'buyer' => function ($buyerQuery) {
                    $buyerQuery->with('user_profile', 'business_profile');
                }, 'sale_counter_offers' => function ($query) {
                    $query->latest();
                }, 'saleAgreement'])->first();

            return view('frontend.contract_tools.sale.buyer.update_sale_agreement_by_buyer', compact('offer'));
        }

        return redirect()->back();
    }

    public function purchaseAgreementByBuyer(): View
    {
        return view('frontend.contract_tools.sale.buyer.va_thank_you_for_buyer');
    }

    public function thankyouPurchaseAgreementByBuyer(): View
    {
        $input['buyer_contract_tool_status'] = 1;
        UpdateSaleAgreementBysellerContract::where('offer_id', Session::get('OFFER.offer_id'))->update($input);

        $offerArray = Session::get('OFFER');
        $offer = SaleOffer::where('id', $offerArray['offer_id'])->first();
        $signature = Signature::where('user_id', Auth::id())
            ->where('offer_id', $offerArray['offer_id'])
            ->where('affix_status', 1)
            ->first();
        if (! empty($signature)) {
            $UserProfile = getOfferPartnerProfile($offer->seller, $offerArray['offer_id']);
            $userName = $UserProfile->signature['fullname'];

            $senderProfile = getOfferPartnerProfile($offer->buyer, $offerArray['offer_id']);
            $sender = $senderProfile->signature['fullname'];
        } else {
            $userName = getFullName($offer->seller);
            $sender = getFullName($offer->buyer);
        }

        $to = $offer->seller->email;
        $emailSubject = 'Freezylist : Submitted the Sale Agreement by buyer';

        $emailBody = 'Hello'.$userName.', '.$sender.' submitted the sale agreement. Contracts are completed and ready to sign.';
        $view = 'frontend.offer.buyer_sale_agreement_mail';
        $emailLinks = $this->_generateEmailLink($offer);

        Mail::send(new SaleAgreementLandlordMailing($to, $userName, $sender, $emailSubject, $emailBody, $emailLinks['viewOfferLink'], $emailLinks['propertyLink'], $view));

        $saveLog = new EmailLogService;
        $saveLog->saveLog($offer->property->id, $offer->sender_id, $offer->owner_id, $emailSubject, $emailBody, config('constant.property_type.'.$offer->property->property_type), url()->previous());

        return view('frontend.contract_tools.sale.buyer.thankyou_purchase_agreement_by_buyer');
    }

    private function _generateEmailLink($offer)
    {
        $viewOfferLink = route('frontend.sent.view.offer', ['offer_id' => $offer->id,
            'type' => $offer->property->property_type,
            'property_id' => $offer->property->id,
            'owner_id' => $offer->owner_id]);
        $propertyLink = route('frontend.propertyDetails', $offer->property->id);

        return ['propertyLink' => $propertyLink, 'viewOfferLink' => $viewOfferLink];
    }

    public function disclosureByBuyerUpdate($id = null)
    {
        $propertyData = Session::get('PROPERTY');

        if (! $propertyData && ! $id) {
            return redirect()->route('frontend.sent.offers');
        }
        if (isset($propertyData) && $propertyData) {
            $property = Property::where('id', $propertyData)
                ->with('architechture', 'disclosure')->withTrashed()->first();
        }

        if ($id) {
            $property = Property::where('id', $id)
                ->where('user_id', Auth::id())
                ->with('architechture', 'disclosure')->withTrashed()->first();
        }
        $diffInYears = null;
        if (isset($property)) {
            $now = Carbon::now()->year;
            $from = $property->architechture->year_built;
            $diffInYears = $now - $from;

            return view('frontend.contract_tools.sale.buyer.disclosure_by_buyer_update', compact('diffInYears', 'property'));
        }

        return view('frontend.contract_tools.sale.buyer.disclosure_by_buyer_update');
    }

    public function thankyouPdBuyer(): View
    {
        $offerData = Session::get('OFFER');
        $buyerQuestionnaire = BuyerQuestionnaire::where('offer_id', $offerData['offer_id'])->first();
        $postClosingQuestion = QuestionSellerPostClosing::where('offer_id', $offerData['offer_id'])->first();

        if ($buyerQuestionnaire->using_VA_or_FHA == 1) {
            return view('frontend.contract_tools.sale.buyer.thankyou_pd_buyer');
        }
        if (! empty($postClosingQuestion->show_post_closing) && $postClosingQuestion->show_post_closing == config('constant.show_post_closing_form.No')) {
            return view('frontend.contract_tools.sale.buyer.va_fha_thank_you_for_buyer');
        }

        return view('frontend.contract_tools.sale.buyer.va_thank_you_for_buyer');
    }

    public function vaFhaloanAddendumByBuyer(): View
    {
        $offerArray = Session::get('OFFER');

        if ($offerArray['type'] == config('constant.inverse_property_type.Sale')) {
            $offer = SaleOffer::where('id', $offerArray['offer_id'])
                ->with(['buyer', 'seller', 'buyerQuestionnaire',
                    'property' => function ($query) {
                        $query->withTrashed();
                    }, 'signatures' => function ($query) use ($offerArray) {
                        $query->where('offer_id', $offerArray['offer_id'])
                            ->where('signature_type', config('constant.inverse_signature_type.VA FHA loan addendum'));
                    }])->first();
        }

        return view('frontend.contract_tools.sale.buyer.VA_FHA_loan_addendum_by_buyer', compact('offer'));
    }

    public function sdThankYouBuyerNecessaryForms()
    {
        $offerData = Session::get('OFFER');
        $buyerQues = BuyerQuestionnaire::where('offer_id', $offerData['offer_id'])->first();
        if ($buyerQues->using_VA_or_FHA == 1) {
            return view('frontend.contract_tools.sale.sign_documents.sd_thank_you_buyer_necessary_forms');
        }

        return redirect()->route('frontend.sdCheckSignaturePostClosingBuyer');
    }

    public function sdCheckSignaturePostClosingBuyer(): View
    {
        Session::forget('lead');
        $offerData = Session::get('OFFER');
        $postClosingQuestion = QuestionSellerPostClosing::where('offer_id', $offerData['offer_id'])->first();
        if ($postClosingQuestion) {
            return view('frontend.contract_tools.sale.sign_documents.sd_va_fha_thank_you_for_buyer');
        }

        return view('frontend.contract_tools.sale.sign_documents.sd_post_closing_thankyou_by_buyer');
    }

    public function sdVaFhaloanAddendumByBuyer()
    {
        $offerArray = Session::get('OFFER');
        $signature = Signature::where('user_id', Auth::id())
            ->where('offer_id', $offerArray['offer_id'])
            ->where('signature_type', config('constant.inverse_signature_type.VA FHA loan addendum'))
            ->first();
        $type = config('constant.inverse_signature_type.VA FHA loan addendum');
        if ($offerArray['type'] == config('constant.inverse_property_type.Sale')) {
            $offer = SaleOffer::where('id', $offerArray['offer_id'])
                ->with(['buyerQuestionnaire', 'propertyConditional' => function ($query) {
                    //                                $query->select('id', 'lead_based', 'lead_based_report', 'user_id');
                }, 'signatures' => function ($query) use ($offerArray) {
                    $query->where('offer_id', $offerArray['offer_id']);
                    //                                ->where('signature_type', config('constant.inverse_signature_type.lead based'));
                }])->first();
        }
        if ($offer->buyerQuestionnaire->using_VA_or_FHA == 1) {
            return view('frontend.contract_tools.sale.sign_documents.sd_VA_FHA_loan_addendum_by_buyer', compact('offer', 'type', 'signature'));
        }

        return redirect()->route('frontend.sdPostClosingThankyouBySeller');
    }

    public function thankYouBuyerNecessaryForms(): View
    {
        return view('frontend.contract_tools.sale.buyer.thank_you_buyer_necessary_forms');
    }

    public function sdThankyouPdBuyer(): View
    {
        $offerData = Session::get('OFFER');
        $buyerQuestionnaire = BuyerQuestionnaire::where('offer_id', $offerData['offer_id'])->first();
        if ($buyerQuestionnaire->using_VA_or_FHA == 1) {
            return view('frontend.contract_tools.sale.buyer.thankyou_pd_buyer');
        }
        if (QuestionSellerPostClosing::where('offer_id', $offerData['offer_id'])->exists()) {
            return view('frontend.contract_tools.sale.sign_documents.sd_va_fha_thank_you_for_buyer');
        }

        return view('frontend.contract_tools.sale.sign_documents.sd_va_thank_you_for_buyer');
    }

    public function thankYouAcceptOffer(): View
    {
        return view('frontend.contract_tools.sale.buyer.thank_you_accept_offer');
    }

    // Sign Documents
    public function sdSaleAgreementReviewByBuyer(): View
    {
        $offerData = Session::get('OFFER');
        $postClosingQuestion = QuestionSellerPostClosing::where('offer_id', $offerData['offer_id'])->first();
        if (! empty($postClosingQuestion->show_post_closing) && $postClosingQuestion->show_post_closing == config('constant.show_post_closing_form.No')) {
            return view('frontend.contract_tools.sale.sign_documents.sd_va_fha_thank_you_for_buyer');
        }

        return view('frontend.contract_tools.sale.sign_documents.sd_va_thank_you_for_buyer');
    }

    public function sdThankYouBuyerForPd()
    {
        $offerData = Session::get('OFFER');
        $property = Property::where('id', Session::get('PROPERTY'))->with('architechture')->withTrashed()->first();
        if ($property->architechture['year_built'] < config('constant.year_built')) {
            return view('frontend.contract_tools.sale.sign_documents.sd-thank_you_buyer_for_pd', compact('property'));
        }

        return redirect()->route('frontend.sdCheckVaFha');

        //            return view('frontend.contract_tools.sale.sign_documents.sd-thank_you_buyer_for_pd', compact('property'));
    }

    public function sdCheckVaFha()
    {
        $offerData = Session::get('OFFER');
        $buyerQues = BuyerQuestionnaire::where('offer_id', $offerData['offer_id'])->first();
        if ($buyerQues->using_VA_or_FHA == 1) {
            return view('frontend.contract_tools.sale.sign_documents.sd_thank_you_buyer_necessary_forms');
        }

        return redirect()->route('frontend.sdCheckSignaturePostClosingBuyer');
    }

    public function sdPostClosingOccupancyAgreementByBuyer(): View
    {
        $offerData = Session::get('OFFER');
        $signature = Signature::where('user_id', Auth::id())
            ->where('offer_id', $offerData['offer_id'])
            ->where('signature_type', config('constant.inverse_signature_type.post closing occupancy agreement'))
            ->first();
        $offer = SaleOffer::where('id', $offerData['offer_id'])
            ->with(['property' => function ($query) {
                $query->select('id', 'lead_based', 'lead_based_report', 'user_id');
                $query->withTrashed();
            }, 'signatures' => function ($query) use ($offerData) {
                $query->where('offer_id', $offerData['offer_id']);
                //                                ->where('signature_type', config('constant.inverse_signature_type.post closing occupancy agreement'));
            },
            ])->first();
        $savedQuestionSellerPostClosing = QuestionSellerPostClosing::where('offer_id', $offerData['offer_id'])
            ->with('saleOffer')->first();
        $sellerQuestionnaire = SellerQuestionnaire::where('offer_id', $offerData['offer_id'])
            ->with(['saleOffer.seller.user_profile', 'saleOffer.seller.business_profile',
                'saleOffer.buyer.user_profile', 'saleOffer.buyer.business_profile',
                'saleOffer.property'])->first();
        $currentDate = date('Y-m-d');
        $days = $currentMortgage = null;
        if ($sellerQuestionnaire) {
            $days = (strtotime($sellerQuestionnaire->property_vacant_date) - strtotime($currentDate)) / (60 * 60 * 24);
            $days = $days - 30;
        }
        if ($savedQuestionSellerPostClosing) {
            $currentMortgage = $savedQuestionSellerPostClosing->current_mortgage / 30;
        }

        return view('frontend.contract_tools.sale.sign_documents.sd_post_closing_occupancy_agreement_by_buyer', compact('savedQuestionSellerPostClosing', 'sellerQuestionnaire', 'days', 'currentMortgage', 'offer', 'signature'));
    }

    public function sdLeadBasedPaintHazardsUpdateByBuyer(): View
    {
        $offerData = Session::get('OFFER');
        $signature = Signature::where('user_id', Auth::id())
            ->where('offer_id', $offerData['offer_id'])
            ->where('signature_type', config('constant.inverse_signature_type.lead based'))
            ->first();
        $type = config('constant.inverse_signature_type.lead based');
        //            if(!empty($signature)){
        //                  $offer = SaleOffer::where('id', $offerData['offer_id'])
        //                        ->with(['propertyConditional' => function($query) {
        //                                $query->select('id', 'lead_based', 'lead_based_report', 'user_id');
        //                            }, 'signatures' => function($query) use($offerData) {
        //                                $query->where('offer_id', $offerData['offer_id'])
        //                                ->where('signature_type', config('constant.inverse_signature_type.lead based'));
        //                            }])->first();
        //            }
        //            else
        //            {
        $offer = SaleOffer::where('id', $offerData['offer_id'])
            ->with(['propertyConditional' => function ($query) {
                //                                $query->select('id', 'lead_based', 'lead_based_report', 'user_id');
            }, 'signatures' => function ($query) use ($offerData) {
                $query->where('offer_id', $offerData['offer_id']);
                //                                ->where('signature_type', config('constant.inverse_signature_type.lead based'));
            }])->first();

        //            }
        return view('frontend.contract_tools.sale.sign_documents.sd_lead_based_paint_hazards_update_by_buyer', compact('offer', 'signature', 'type'));
    }

    public function sdPostClosingThankyouByBuyer(): View
    {
        return view('frontend.contract_tools.sale.sign_documents.sd_post_closing_thankyou_by_buyer');
    }

    public function sdThankyouPurchaseAgreementByBuyer(): View
    {
        $offerData = Session::get('OFFER');

        //        check any user has done the signature , then pick the fullname from signature table

        $signature = Signature::where('user_id', Auth::id())
            ->where('offer_id', $offerData['offer_id'])
            ->where('affix_status', 1)
            ->first();

        $offer = SaleOffer::where('id', $offerData['offer_id'])->with(['property' => function ($query) {
            $query->withTrashed();
        },
            'sellerQuestionnaire', 'buyerQuestionnaire', 'seller', 'buyer', 'signatures'])->first();
        //        echo'<pre>';print_R($offer->toArray());die;
        if (! empty($signature)) {
            $senderProfile = getOfferPartnerProfile(Auth::id(), $offerData['offer_id']);
            //             dd($senderProfile);
            $sender = $senderProfile->signature['fullname'];
        } else {
            $sender = getFullName(Auth::user());
        }

        if (! empty($offer->buyerQuestionnaire->partners)) {
            //            $completed   = $incompleted = 0;
            $partners = explode(',', $offer->buyerQuestionnaire->partners);

            $count = 0;
            foreach ($partners as $partner) {
                if ($signature) {
                    $partnerProfile = getOfferPartnerProfile($partner, $offerData['offer_id']);
                } else {
                    $partnerProfile = getPartnerProfile($partner);
                }

                //                $incomplete     = false;
                $signed = false;
                foreach ($offer->signatures as $signature) {
                    if ($signature->user_id == $partner &&
                            $signature->signature_type == config('constant.inverse_signature_type.sale agreement')) {
                        $count++;
                        $signed = true;
                    }
                }
                if (($partnerProfile->user_profile || $partnerProfile->business_profile) && ! $signed) {
                    $to = $partnerProfile->email;
                    $userName = ! empty($partnerProfile->signature['fullname']) ? $partnerProfile->signature['fullname'] : getFullName($partnerProfile);
                    $emailSubject = 'Freezylist : Buyer completed the sign document process';
                    $emailBody = 'Hello '.$userName.', '.$sender.' has signed property sale agreement. Please view and sign the documents. Thank You';
                    $view = 'frontend.offer.partner_contract_tool_sale_agreement_mail';
                    $emailLinks = $this->_generatePartnersEmailLink($offer);
                    Mail::send(new SaleAgreementLandlordMailing($to, $userName, $sender, $emailSubject, $emailBody, $emailLinks['viewOfferLink'], $emailLinks['propertyLink'], $view));
                } else {
                    if ($partnerProfile->roles->first()->name == config('constant.user_type.3')) {
                        $signupLink = route('frontend.userCreate').'?code='.$partnerProfile->confirmation_code.'&time='.$partnerProfile->created_at;
                    } else {
                        $signupLink = route('frontend.businessCreate').'?code='.$partnerProfile->confirmation_code.'&time='.$partnerProfile->created_at;
                    }
                    $to = $partnerProfile->email;
                    $userName = ! empty($partnerProfile->signature['fullname']) ? $partnerProfile->signature['fullname'] : getFullName($partnerProfile);
                    $emailSubject = 'Freezylist : Buyer completed the sign document process';
                    $emailBody = 'Hello '.$userName.', '.$sender.' has signed property sale agreement. Please complete your signup process and proceed with sign document process. Thank You';
                    $view = 'frontend.offer.partner_contract_tool_sale_agreement_mail';
                    $emailLinks = $this->_generatePartnersEmailLink($offer);
                    Mail::send(new SaleAgreementLandlordMailing($to, $userName, $sender, $emailSubject, $emailBody, $emailLinks['viewOfferLink'], $emailLinks['propertyLink'], $view, $signupLink));
                }

                $saveLog = new EmailLogService;
                $saveLog->saveLog($offer->property->id, $offer->sender_id, $offer->owner_id, $emailSubject, $emailBody, config('constant.property_type.'.$offer->property->property_type), url()->previous());

                if ($count == count($partners)) {
                    //mail send to landlord.
                    $userName = $partnerProfile->signature['fullname'];
                    $emailSubject = "Freezylist : Buyer's completed the sign document process";
                    $emailBody = 'Hello '.$userName.', '.$sender.' and their partner signed property sale agreement. Thank You';
                    $view = 'frontend.offer.buyer_completed_sale_agreement';
                    $emailLinks = $this->_generatePartnersEmailLink($offer);

                    $viewOfferLink = route('frontend.recieved.view.offer', ['offer_id' => $offer->id,
                        'type' => config('constant.property_type.'.$offer->property->property_type),
                        'property_id' => $offer->property->id,
                        'owner_id' => $offer->owner_id]);
                    $emailLinks['viewOfferLink'] = $viewOfferLink;
                    $partner = true;
                    Mail::send(new SaleAgreementLandlordMailing($to, $userName, $sender, $emailSubject, $emailBody, $emailLinks['viewOfferLink'], $emailLinks['propertyLink'], $view, $partner));

                    $saveLog = new EmailLogService;
                    $saveLog->saveLog($offer->property->id, $offer->sender_id, $offer->owner_id, $emailSubject, $emailBody, config('constant.property_type.'.$offer->property->property_type), url()->previous());
                }
            }

            return view('frontend.contract_tools.sale.sign_documents.sd-thankyou_purchase_agreement_by_buyer');
        } else {
            // mail to tenant for sign
            $to = $offer->seller->email;
            $userName = ! empty($partnerProfile->signature['fullname']) ? $partnerProfile->signature['fullname'] : getFullName($offer->seller);

            //            $userName = getFullName($offer->seller);
            $emailSubject = 'Freezylist : Buyer completed the sign document process';
            $emailBody = 'Hello '.$userName.', '.$sender.' has signed property sale agreement. Thank You';
            $view = 'frontend.offer.buyer_completed_sale_agreement';
            $emailLinks = $this->_generateEmailLink($offer);

            Mail::send(new SaleAgreementLandlordMailing($to, $userName, $sender, $emailSubject, $emailBody, $emailLinks['viewOfferLink'], $emailLinks['propertyLink'], $view));

            $saveLog = new EmailLogService;
            $saveLog->saveLog($offer->property->id, $offer->sender_id, $offer->owner_id, $emailSubject, $emailBody, config('constant.property_type.'.$offer->property->property_type), url()->previous());
        }
        //        }

        return view('frontend.contract_tools.sale.sign_documents.sd-thankyou_purchase_agreement_by_buyer');
    }

    private function _generatePartnersEmailLink($offer)
    {
        $viewOfferLink = route('frontend.sent.view.offer', ['offer_id' => $offer->id,
            'type' => $offer->property->property_type,
            'property_id' => $offer->property->id,
            'owner_id' => $offer->owner_id]);
        $propertyLink = route('frontend.propertyDetails', $offer->property->id);

        return ['propertyLink' => $propertyLink, 'viewOfferLink' => $viewOfferLink];
    }

    public function sdUpdateSaleAgreementBuyer(): View
    {

        $offerArray = Session::get('OFFER');
        $offer = null;
        $type = config('constant.inverse_signature_type.sale agreement');
        if ($offerArray['type'] == config('constant.inverse_property_type.Sale')) {
            $signature = Signature::where('user_id', Auth::id())
                ->where('offer_id', $offerArray['offer_id'])
                ->where('signature_type', config('constant.inverse_signature_type.sale agreement'))
                ->first();
            $offer = SaleOffer::where('id', $offerArray['offer_id'])
                ->with([
                    'propertyConditional.disclosure' => function ($propertyCondDis) {
                        $propertyCondDis->select('best_knowledge_explain', 'partb_details', 'partc_details');
                    }, 'sellerQuestionnaire',
                    'buyerQuestionnaire', 'sale_counter_offers' => function ($query) {
                        $query->latest();
                    }, 'saleAgreement',
                    'signatures' => function ($query) use ($offerArray) {
                        $query->where('offer_id', $offerArray['offer_id']);
                    },
                ])->first();
        }

        return view('frontend.contract_tools.sale.sign_documents.sd-update_sale_agreement_by_buyer', compact('offer', 'signature', 'type'));
    }

    public function sdAdvisoryToBuyersAndSellers()
    {
        $offerArray = Session::get('OFFER');
        Session::forget('lead');

        if ($offerArray['type'] == config('constant.inverse_property_type.Sale')) {
            $type = config('constant.inverse_signature_type.advisory to buyers and sellers');
            //check signature exist corresponding to type ,then pick the data form backup tables.
            $signature = Signature::where('user_id', Auth::id())
                ->where('offer_id', $offerArray['offer_id'])
                ->where('signature_type', config('constant.inverse_signature_type.advisory to buyers and sellers'))
                ->first();
            //            dd($signature);
            if (! empty($signature)) {
                $offer = SaleOffer::where('id', $offerArray['offer_id'])
                    ->with(['propertyConditional',
                        'signatures' => function ($query) use ($offerArray) {
                            $query->where('offer_id', $offerArray['offer_id']);
                            //                                    $query->groupBy('type');
                        }])->first();
            } else {
                $offer = SaleOffer::where('id', $offerArray['offer_id'])
                    ->with(['buyer.user_profile', 'buyer.business_profile', 'seller.user_profile',
                        'seller.business_profile', 'property' => function ($query) {
                            $query->withTrashed();
                        }, 'signatures' => function ($query) use ($offerArray) {
                            $query->where('offer_id', $offerArray['offer_id']);
                            //                                              ->where('user_id', Auth::id());
                            //                                            >where('signature_type', config('constant.inverse_signature_type.advisory to buyers and sellers'));
                        }])->first();
                //              dd($offer);
            }

            if (! empty($offer)) {
                return view('frontend.contract_tools.sale.sign_documents.sd_advisory_to_buyers_and_sellers', compact('offer', 'signature', 'type'));
            }
        }

        return redirect()->back()->withFlashDanger('Invalid Offer.');
    }

    public function sdVaFhaThankYouForBuyer(): View
    {

        return view('frontend.contract_tools.sale.sign_documents.sd_va_fha_thank_you_for_buyer');
    }

    public function sdAdvisoryToBuyersAndSellersThankYouBuyer()
    {
        $propertyData = Session::get('PROPERTY');
        $property = Property::where('id', $propertyData)
            ->where('user_id', Auth::id())
            ->with('architechture')
            ->withTrashed()
            ->first();

        //            dd($property->architechture->year_built);
        //        if ($property->architechture->year_built < config('constant.year_built')) {
        //            return redirect()->route('frontend.thankYouLeadBased');
        //        }
        return view('frontend.contract_tools.sale.sign_documents.sd_advisory_to_buyers_and_sellers_thank_you_buyer');
    }

    public function sdDisclosureByBuyerUpdate($id = null)
    {
        if (Session::get('PROPERTY') && Session::get('OFFER')) {

            $propertyData = Session::get('PROPERTY');
            $offerArray = Session::get('OFFER');

            $signature = Signature::where('user_id', Auth::id())
                ->where('offer_id', $offerArray['offer_id'])
                ->first();
            //	    dd($signature);
            $type = config('constant.inverse_signature_type.property disclaimer');

            //          get the data from backup tables
            $property = PropertyConditionalData::where('offer_id', $offerArray['offer_id'])->where('property_id', $propertyData)
                ->with('architechture', 'disclosure')->first();
            //                dd($property);
            //            }
            $diffInYears = null;
            if (isset($property)) {
                $now = Carbon::now()->year;
                $from = $property->architechture->year_built;
                $diffInYears = $now - $from;

                $offer = null;
                if (! empty($offerArray)) {
                    $offer = SaleOffer::where('id', $offerArray['offer_id'])
                        ->with(['buyer.user_profile', 'buyer.business_profile',
                            'seller.user_profile',
                            'seller.business_profile', 'propertyConditional', 'signatures' => function ($query) use ($offerArray) {
                                $query->where('offer_id', $offerArray['offer_id']);
                                //                                            ->where('signature_type', config('constant.inverse_signature_type.property disclaimer'));
                            }])->first();
                    //                                        dd($offer);
                }

                return view('frontend.contract_tools.sale.sign_documents.sd_disclosure_by_buyer_update', compact('diffInYears', 'property', 'offer', 'signature', 'type'));
            }

            return view('frontend.contract_tools.sale.sign_documents.sd_disclosure_by_buyer_update');
        }

        return redirect()->route('frontend.sent.offers');
    }

    /*
     * first check if signature is done on any document then need to show the data from backup table otherwise flow is same
     *
     */

    public function sdSummaryKeyTermsForBuyer(): View
    {
        $offerArray = Session::get('OFFER');
        $signature = Signature::where('user_id', Auth::id())
            ->where('offer_id', $offerArray['offer_id'])
            ->where('affix_status', 1)
            ->first();
        if ($offerArray['type'] == config('constant.inverse_property_type.Sale')) {
            if (! empty($signature)) {
                $offer = SaleOffer::where('id', $offerArray['offer_id'])
                    ->with(['propertyConditional.architechture', 'propertyConditional.disclosure' => function ($propertyCondDis) {
                        $propertyCondDis->select('best_knowledge_explain', 'partb_details', 'partc_details');
                    }, 'sellerQuestionnaire', 'signatures' => function ($query) use ($offerArray) {
                        $query->where('offer_id', $offerArray['offer_id']);
                    }, 'sale_counter_offers' => function ($query) {
                        $query->latest();
                    }, 'saleAgreement'])->first();
            } else {
                $offer = SaleOffer::where('id', $offerArray['offer_id'])
                    ->with(['property.architechture', 'property.propertyConditionDisclaimer' => function ($propertyCondDis) {
                        $propertyCondDis->select('best_knowledge_explain', 'partb_details', 'partc_details');
                    }, 'sellerQuestionnaire', 'seller' => function ($sellerQuery) {
                        $sellerQuery->with('user_profile', 'business_profile');
                    }, 'buyer' => function ($buyerQuery) {
                        $buyerQuery->with('user_profile', 'business_profile');
                    }, 'sale_counter_offers' => function ($query) {
                        $query->latest();
                    }, 'saleAgreement'])->first();
            }
        }

        return view('frontend.contract_tools.sale.sign_documents.sd_summary_key_terms_for_buyer', compact('offer', 'signature'));
    }

    public function signOffersSaleBuyerPartner($id)
    {
        $buyerDetails = BuyerQuestionnaire::where('id', $id)->whereHas('saleOffer')->with(['saleOffer' => function ($query) {
            $query->with(['property' => function ($query) {
                $query->withTrashed();
            }, 'saleAgreement', 'property_owner_user' => function ($subquery) {
                $subquery->with(['business_profile', 'user_profile']);
            }, 'sale_counter_offers' => function ($query) {
                $query->latest();
            }, 'signatures' => function ($signQuery) {
                $signQuery->where('signature_type', config('constant.inverse_signature_type.sale agreement'));
            }, 'seller' => function ($sellerQuery) {
                $sellerQuery->select('id', 'email')
                    ->with(['user_profile', 'business_profile']);
            }]);
        }])->first();

        if (empty($buyerDetails)) {
            return redirect()->back()->withFlashDanger('Invalid Offer.');
        }
        $partners = explode(',', $buyerDetails->partners);
        $partners = array_filter($partners);
        if (! in_array(Auth::id(), $partners) && $buyerDetails->saleOffer->sender_id != Auth::id() && $buyerDetails->offer_id != $id) {
            return redirect()->back()->withFlashDanger('You are not authorized to perform this action.');
        }

        $signButton = false;
        $message = null;
        $downloadBtn = false;
        //if main buyer has signed
        if ($buyerDetails->saleOffer->signatures->contains('user_id', $buyerDetails->user_id)) {
            //if current logged in user has signed
            if ($buyerDetails->saleOffer->signatures->contains('user_id', Auth::id())) {
                //if contract documents are ready
                if ($buyerDetails->saleOffer->buyer_signature == config('constant.offer_signature.true') && $buyerDetails->saleOffer->seller_signature == config('constant.offer_signature.true')) {
                    $downloadBtn = true;
                } elseif ($buyerDetails->saleOffer->buyer_signature == config('constant.offer_signature.true') && $buyerDetails->saleOffer->seller_signature == config('constant.offer_signature.false')) {
                    //if all buyers have signed but not seller or his partner
                    $message = "Please wait for property owner's to sign the documents. ";
                } elseif ($buyerDetails->saleOffer->buyer_signature == config('constant.offer_signature.false')) {
                    //if current user has signed but not other co-partner of property
                    $message = "Please wait for your co-singer's to sign the documents. ";
                }
            } else {
                //if main buyer  signed but not  current user who is a co-buyer.
                $signButton = true;
            }
        } else {
            $message = 'Please wait untill your partner to sign the documents.';
        }

        $offerArray = [
            'offer_id' => $buyerDetails->saleOffer->id,
            'type' => $buyerDetails->saleOffer->property->property_type,
        ];

        $this->_forgetPropertyOffer();
        $this->_setPropertyOffer($offerArray, $buyerDetails->saleOffer->property_id);

        return view('frontend.contract_tools.sale.sign_documents.sign_offers_sale_buyer_partner', compact('signButton', 'message', 'downloadBtn'))->with(['offer' => $buyerDetails->saleOffer]);
    }

    public function saleAgreementSignatureSeller(Request $request): Response
    {
        $offerArray = Session::get('OFFER');
        $ip = \Request::ip();
        $signature = Signature::where('user_id', Auth::id())
            ->where('offer_id', $offerArray['offer_id'])
            ->where('signature_type', config('constant.inverse_signature_type.sale agreement'))
            ->first();
        if ($signature) {
            return response(['success' => true, 'signature' => $signature]);
        }
        $type = config('constant.inverse_signature_type.sale agreement');

        //get data corresponding to type
        $getData = Signature::where('user_id', Auth::id())
            ->where('offer_id', $offerArray['offer_id'])
            ->first();

        //save data in signature table
        $signatureNew = new Signature;
        $signatureNew->offer_id = $offerArray['offer_id'];
        $signatureNew->user_id = Auth::id();
        $signatureNew->signature_type = $type;
        $signatureNew->fullname = $getData['fullname'];
        $signatureNew->affix_status = '1';
        $signatureNew->type = $getData['type'];
        $signatureNew->ip = $ip;
        $signatureNew->signature = $getData['signature'];

        if ($signatureNew->save()) {
            $offer = SaleOffer::where('id', $offerArray['offer_id'])
                ->where('seller_signature', config('constant.offer_signature.false'))
                ->whereHas('property', function ($query) {
                    $query->where('property_type', config('constant.inverse_property_type.Sale'));
                    $query->withTrashed();
                })->with(['sellerQuestionnaire' => function ($sellerQuestionnaireQuery) {
                    $sellerQuestionnaireQuery->select('id', 'offer_id', 'joint_cowners', 'partners');
                }, 'signatures' => function ($signQuery) {
                    //                               $signQuery->where('affix_status',1);
                    //                            $signQuery->groupBy('type');
                    //                            $signQuery->where('signature_type', config('constant.inverse_signature_type.sale agreement'));
                }])->first(['id', 'property_id', 'sender_id', 'owner_id', 'seller_signature']);
            //
            //                        dump($offer->signatures->groupBy('signature_type')->count());
            //                        dd($offer->toArray());
            if (! empty($offer)) {
                $totalBuyers = 1;
                $totalSellers = 1;
                if ($offer->sellerQuestionnaire->joint_cowners == config('constant.joint_coowner.No')) {
                    $this->_updateAgrementStatusSeller($offer->id);
                } else {
                    if ($offer->sellerQuestionnaire->joint_cowners == config('constant.joint_coowner.Yes') && ! empty($offer->sellerQuestionnaire->partners)) {
                        $partners = explode(',', $offer->sellerQuestionnaire->partners);
                        $partners = array_filter($partners);
                        $totalSellers = count($partners) + $totalSellers;
                    }
                    if ($offer->buyerQuestionnaire->joint_cowners == config('constant.joint_coowner.Yes') && ! empty($offer->buyerQuestionnaire->partners)) {
                        $buyerPartners = explode(',', $offer->buyerQuestionnaire->partners);
                        $buyerPartners = array_filter($buyerPartners);
                        $totalBuyers = count($buyerPartners) + $totalBuyers;
                    }
                    //                    dump($totalSellers + $totalBuyers);
                    //                    dump($offer->signatures->groupBy('signature_type')->count());
                    //                    dump($offer->signatures->count());
                    //                    dd('teest');
                    if (($totalSellers + $totalBuyers) * ($offer->signatures->groupBy('signature_type')->count()) == $offer->signatures->count()) {
                        $this->_updateAgrementStatusSeller($offer->id);
                    }
                }
            }

            return response(['success' => true, 'signature' => $signatureNew]);
        }

        return response(['success' => false], 500);
    }

    private function _updateAgrementStatusSeller($offerId)
    {
        SaleOffer::where('id', $offerId)->update(['seller_signature' => config('constant.offer_signature.true'), 'closed' => config('constant.offer_open_close.close')]);

        $getPropertyId = SaleOffer::select('property_id')->where('id', $offerId)->first();

        Property::where('id', $getPropertyId->property_id)->update(['status' => config('constant.inverse_property_status.Sold')]);

        return true;
    }

    private function _forgetPropertyOffer()
    {
        SESSION::forget('PROPERTY');
        SESSION::forget('OFFER');
    }

    private function _setPropertyOffer($offerArray, $propertyId = null)
    {
        Session::put('OFFER', $offerArray);
        Session::put('PROPERTY', $propertyId);
    }

    /*
     * Function Name:-_savesignature
     * Desc:- save the signatures
     * Updation:- locks the data once the first signature is discovered.
     * Updated By:- Charu Anand 20-6-2019
     *  */

    private function _savesignature($request, $offerArray, $ip, $signature, $type1, $agrementSigned = false)
    {
        $customArray1 = [];
        $cosellerArray = [];
        $cobuyerArray = [];
        $coseller = [];
        $cobuyer = [];
        $customArray2 = [];

        $offer = SaleOffer::where('id', $offerArray['offer_id'])
            ->whereHas('property', function ($query) {
                $query->where('property_type', config('constant.inverse_property_type.Sale'));
                $query->withTrashed();
            })->with(['property' => function ($subquery) {
                $subquery->withTrashed();
            }, 'sellerQuestionnaire', 'buyerQuestionnaire',
            ])->first();
        //                        dd($offer);
        $existSignature = Signature::where('offer_id', '=', $offerArray['offer_id'])->where('user_id', '=', Auth::id())->first();
        //        dd($existSignature);
        $buyersellerArray = [$offer->sender_id, $offer->owner_id];
        //       create array for buyer and seller
        foreach ($buyersellerArray as $val) {
            if ($val == $offer->owner_id) {
                $type = '2';
                $affix_status = '0';
                $signature_type = 7;
            } elseif ($val == $offer->sender_id) {
                $type = '1';
                $affix_status = '1';
                $signature_type = $type1;
            }
            if (! empty($existSignature)) {
                $fullName = $existSignature->fullname;
                $getsignature = $existSignature->signature;
            } else {
                $user = User::where('id', $val)
                    ->with('user_profile')->first();
                $fullName = getFullName($user);
                $getsignature = $user->user_profile['electronic_signature'];
            }

            $customArray1[] = ['id' => (int) $val, 'signature' => $getsignature, 'full_name' => $fullName, 'type' => $type, 'affix_status' => $affix_status, 'signature_type' => $signature_type];
        }

        if ($offer->sellerQuestionnaire->joint_cowners == config('constant.joint_coowner.Yes') && ! empty($offer->sellerQuestionnaire->partners)) {
            $coseller = explode(',', $offer->sellerQuestionnaire->partners);
        }
        if ($offer->buyerQuestionnaire->joint_cowners == config('constant.joint_coowner.Yes') && ! empty($offer->buyerQuestionnaire->partners)) {

            $cobuyer = explode(',', $offer->buyerQuestionnaire->partners);
        }
        // create array for cobuyer and coseller
        $cobuyerseller = array_merge($coseller, $cobuyer);

        if (! empty($cobuyerseller)) {
            foreach ($cobuyerseller as $seller) {
                if (in_array($seller, $coseller)) {
                    $type = '4';
                    $affix_status = '0';
                    $signature_type = 7; //not exist in any type
                } elseif (in_array($seller, $cobuyer)) {
                    $type = '3';
                    $affix_status = '0';
                    $signature_type = 7;
                }
                if (! empty($existSignature)) {
                    $fullName = $existSignature->fullname;
                    $getsignature = $existSignature->signature;
                } else {
                    $user = User::where('id', $seller)
                        ->with('user_profile')->first();
                    $fullName = getFullName($user);
                    $getsignature = $user->user_profile['electronic_signature'];
                }
                $customArray2[] = ['id' => (int) $seller, 'signature' => $getsignature, 'full_name' => $fullName, 'type' => $type, 'affix_status' => $affix_status, 'signature_type' => $signature_type];
            }
        }
        //combine buyer,seller,cobuyer,coseller for saving in users conditional table
        $customSignatureArray = array_merge($customArray1, $customArray2);

        //        dd($customSignatureArray);
        //get architecture data and images using property id for taking the backup
        $getPropertyData = Property::with(['disclosure', 'architechture' => function ($query) {
            $query->select('property_id', 'school_district_id', 'school_id', 'home_type', 'beds', 'baths', 'plot_size', 'home_size', 'describe_your_home', 'year_built', 'HOA_dues', 'total_rooms', 'stories', 'garage_capacity', 'additional_features', 'basement');
        }, 'images' => function ($query) {
            $query->select('property_id', 'image');
        }, 'additional_information', 'saleOffer',
        ])->where(['id' => $offer->property->id])->withTrashed()->first();

        if (! empty($existSignature)) {
            //            dd($existSignature);
            if ($existSignature->signature_type == 7) {

                $result = Signature::where('offer_id', '=', $offerArray['offer_id'])->where('user_id', '=', $existSignature->user_id)->where('signature_type', 7)->update(['affix_status' => 1, 'signature_type' => $type1]);
            } else {
                $customsignature = new Signature;
                $customsignature->offer_id = $existSignature->offer_id;
                $customsignature->user_id = Auth::id();
                $customsignature->type = $existSignature->type;
                $customsignature->fullname = $existSignature->fullname;
                $customsignature->signature = $existSignature->signature;
                $customsignature->signature_type = $type1;
                $customsignature->affix_status = 1;
                $customsignature->ip = $ip;
                $result = $customsignature->save();
            }
        } else {
            foreach ($customSignatureArray as $signatureArray) {
                $customsignature = new Signature;
                $customsignature->offer_id = $offerArray['offer_id'];
                $customsignature->user_id = $signatureArray['id'];
                $customsignature->type = $signatureArray['type'];
                $customsignature->fullname = $signatureArray['full_name'];
                $customsignature->signature = $signatureArray['signature'];
                $customsignature->signature_type = $signatureArray['signature_type'];
                $customsignature->affix_status = $signatureArray['affix_status'];
                $customsignature->ip = $ip;
                $result = $customsignature->save();
            }
        }
        //    dd($result);

        if ($result) {
            //        dd($SignatureExist);
            // check if property id already exist in backup tables then no need to take backups.
            if (empty(PropertyConditionalData::where('offer_id', '=', $offerArray['offer_id'])->where(['property_id' => $offer->property->id])->exists())) {
                //                 save data in property conditional data table for backup purpose
                $propertyData = new \App\Models\PropertyConditionalData;
                $propertyData->user_id = $offer->property->user_id;
                $propertyData->offer_id = $offerArray['offer_id'];
                $propertyData->property_id = $offer->property->id;
                $propertyData->state_id = $offer->property->state_id;
                $propertyData->property_name = $offer->property->property_name;
                $propertyData->property_type = $offer->property->property_type;
                $propertyData->street_address = $offer->property->street_address;
                $propertyData->city_id = $offer->property->city_id;
                $propertyData->county_id = $offer->property->county_id;
                $propertyData->zip_code_id = $offer->property->zip_code_id;
                $propertyData->townhouse_apt = $offer->property->townhouse_apt;
                $propertyData->latitude = $offer->property->latitude;
                $propertyData->longitude = $offer->property->longitude;
                $propertyData->price = $offer->property->price;
                $propertyData->virtual_tour_url = $offer->property->virtual_tour_url;
                $propertyData->pets = $offer->property->pets;
                $propertyData->lease_term = $offer->property->lease_term;
                $propertyData->display_phone = $offer->property->display_phone;
                $propertyData->agree = $offer->property->agree;
                $propertyData->status = $offer->property->status;
                $propertyData->lead_based = $offer->property->lead_based;
                $propertyData->lead_based_report = $offer->property->lead_based_report;
                $propertyData->back_to_market_date = $offer->property->back_to_market_date;
                if ($propertyData->save()) {
                    $getArchitectureData = $getPropertyData->architechture;
                    //            dd($getArchitectureData['school_district_id']);
                    $getImagesData = $getPropertyData->images;
                    $getAdditionalData = $getPropertyData->additional_information;
                    $disclosureData = $getPropertyData->disclosure;
                    // save data in property architecture and property images conditional data table for backup purpose
                    $propertyArchitecture = new \App\Models\PropertyArchitectureConditionalData;
                    $propertyArchitecture->property_conditional_id = $propertyData->id;
                    $propertyArchitecture->school_district_id = $getArchitectureData['school_district_id'];
                    $propertyArchitecture->school_id = $getArchitectureData['school_id'];
                    $propertyArchitecture->home_type = $getArchitectureData['home_type'];
                    $propertyArchitecture->beds = $getArchitectureData['beds'];
                    $propertyArchitecture->baths = $getArchitectureData['baths'];
                    $propertyArchitecture->plot_size = $getArchitectureData['plot_size'];
                    $propertyArchitecture->home_size = $getArchitectureData['home_size'];
                    $propertyArchitecture->describe_your_home = $getArchitectureData['describe_your_home'];
                    $propertyArchitecture->year_built = $getArchitectureData['year_built'];
                    $propertyArchitecture->year_updated = $getArchitectureData['year_updated'];
                    $propertyArchitecture->HOA_dues = $getArchitectureData['HOA_dues'];
                    $propertyArchitecture->total_rooms = $getArchitectureData['total_rooms'];
                    $propertyArchitecture->stories = $getArchitectureData['stories'];
                    $propertyArchitecture->basement = $getArchitectureData['basement'];
                    $propertyArchitecture->garage_capacity = $getArchitectureData['garage_capacity'];
                    $propertyArchitecture->additional_features = $getArchitectureData['additional_features'];
                    if ($propertyArchitecture->save()) {
                        $propertyConditionDisclaimer = new \App\Models\PropertyDisclaimerConditionalData;

                        $propertyConditionDisclaimer->property_conditional_id = $propertyData->id;
                        $propertyConditionDisclaimer->user_id = Auth::id();
                        $propertyConditionDisclaimer->property_age = $disclosureData['property_age'];
                        $propertyConditionDisclaimer->date_added = $disclosureData['date_added'];
                        $propertyConditionDisclaimer->occupy = $disclosureData['occupy'];
                        $propertyConditionDisclaimer->how_long = $disclosureData['how_long'];
                        $propertyConditionDisclaimer->property_is = $disclosureData['property_is'];
                        $propertyConditionDisclaimer->roof_type = $disclosureData['roof_type'];
                        $propertyConditionDisclaimer->roof_age = $disclosureData['roof_age'];
                        $propertyConditionDisclaimer->house_owners_associations = $disclosureData['house_owners_associations'];
                        $propertyConditionDisclaimer->name_address = $disclosureData['name_address'];
                        $propertyConditionDisclaimer->monthly_dues = $disclosureData['monthly_dues'];
                        $propertyConditionDisclaimer->transfer_fees = $disclosureData['transfer_fees'];
                        $propertyConditionDisclaimer->special_assessments = $disclosureData['special_assessments'];
                        $propertyConditionDisclaimer->how_many = $disclosureData['how_many'];
                        $propertyConditionDisclaimer->how_many_remotes = $disclosureData['how_many_remotes'];
                        $propertyConditionDisclaimer->heat_pump_age = $disclosureData['heat_pump_age'];
                        $propertyConditionDisclaimer->central_heating_age = $disclosureData['central_heating_age'];
                        $propertyConditionDisclaimer->central_air_conditioning_age = $disclosureData['central_air_conditioning_age'];
                        $propertyConditionDisclaimer->water_heater_age = $disclosureData['water_heater_age'];
                        $propertyConditionDisclaimer->property_includes = $disclosureData['property_includes'];
                        $propertyConditionDisclaimer->pool_type = $disclosureData['pool_type'];
                        $propertyConditionDisclaimer->garage_type = $disclosureData['garage_type'];
                        $propertyConditionDisclaimer->central_heating_type = $disclosureData['central_heating_type'];
                        $propertyConditionDisclaimer->central_air_conditioning_type = $disclosureData['central_air_conditioning_type'];
                        $propertyConditionDisclaimer->water_heater_type = $disclosureData['water_heater_type'];
                        $propertyConditionDisclaimer->water_supply_type = $disclosureData['water_supply_type'];
                        $propertyConditionDisclaimer->sewage_disposal_type = $disclosureData['sewage_disposal_type'];
                        $propertyConditionDisclaimer->gas_supply_type = $disclosureData['gas_supply_type'];
                        $propertyConditionDisclaimer->other_items_included = $disclosureData['other_items_included'];
                        $propertyConditionDisclaimer->best_knowledge = $disclosureData['best_knowledge'];
                        $propertyConditionDisclaimer->best_knowledge_explain = $disclosureData['best_knowledge_explain'];
                        $propertyConditionDisclaimer->interior_walls = $disclosureData['interior_walls'];
                        $propertyConditionDisclaimer->ceilings = $disclosureData['ceilings'];
                        $propertyConditionDisclaimer->floors = $disclosureData['floors'];
                        $propertyConditionDisclaimer->windows = $disclosureData['windows'];
                        $propertyConditionDisclaimer->doors = $disclosureData['doors'];
                        $propertyConditionDisclaimer->insulation = $disclosureData['insulation'];
                        $propertyConditionDisclaimer->plumbing = $disclosureData['plumbing'];
                        $propertyConditionDisclaimer->sewer = $disclosureData['sewer'];
                        $propertyConditionDisclaimer->electrical_system = $disclosureData['electrical_system'];
                        $propertyConditionDisclaimer->exterior_walls = $disclosureData['exterior_walls'];
                        $propertyConditionDisclaimer->roof = $disclosureData['roof'];
                        $propertyConditionDisclaimer->basement = $disclosureData['basement'];
                        $propertyConditionDisclaimer->foundation = $disclosureData['foundation'];
                        $propertyConditionDisclaimer->slab = $disclosureData['slab'];
                        $propertyConditionDisclaimer->drive_way = $disclosureData['drive_way'];
                        $propertyConditionDisclaimer->side_walks = $disclosureData['side_walks'];
                        $propertyConditionDisclaimer->central_heating = $disclosureData['central_heating'];
                        $propertyConditionDisclaimer->heat_pump = $disclosureData['heat_pump'];
                        $propertyConditionDisclaimer->central_air = $disclosureData['central_air'];
                        $propertyConditionDisclaimer->partb_details = $disclosureData['partb_details'];
                        $propertyConditionDisclaimer->any_repairs = $disclosureData['any_repairs'];
                        $propertyConditionDisclaimer->substances = $disclosureData['substances'];
                        $propertyConditionDisclaimer->features_shared = $disclosureData['features_shared'];
                        $propertyConditionDisclaimer->any_authorized_changes = $disclosureData['any_authorized_changes'];
                        $propertyConditionDisclaimer->most_recent_survey = $disclosureData['most_recent_survey'];
                        $propertyConditionDisclaimer->any_change_since_latest_survey = $disclosureData['any_change_since_latest_survey'];
                        $propertyConditionDisclaimer->any_encroachments = $disclosureData['any_encroachments'];
                        $propertyConditionDisclaimer->repairs = $disclosureData['repairs'];
                        $propertyConditionDisclaimer->repairs_with_building_codes = $disclosureData['repairs_with_building_codes'];
                        $propertyConditionDisclaimer->land_fill = $disclosureData['land_fill'];
                        $propertyConditionDisclaimer->any_settling = $disclosureData['any_settling'];
                        $propertyConditionDisclaimer->problems = $disclosureData['problems'];
                        $propertyConditionDisclaimer->requirement = $disclosureData['requirement'];
                        $propertyConditionDisclaimer->location = $disclosureData['location'];
                        $propertyConditionDisclaimer->interior = $disclosureData['interior'];
                        $propertyConditionDisclaimer->structural_damage = $disclosureData['structural_damage'];
                        $propertyConditionDisclaimer->any_zoning_violations = $disclosureData['any_zoning_violations'];
                        $propertyConditionDisclaimer->neighborhood_noise = $disclosureData['neighborhood_noise'];
                        $propertyConditionDisclaimer->restrictions = $disclosureData['restrictions'];
                        $propertyConditionDisclaimer->any_common_area = $disclosureData['any_common_area'];
                        $propertyConditionDisclaimer->any_notices = $disclosureData['any_notices'];
                        $propertyConditionDisclaimer->any_lawsuit = $disclosureData['any_lawsuit'];
                        $propertyConditionDisclaimer->any_system = $disclosureData['any_system'];
                        $propertyConditionDisclaimer->any_exterior = $disclosureData['any_exterior'];
                        $propertyConditionDisclaimer->any_finished_rooms = $disclosureData['any_finished_rooms'];
                        $propertyConditionDisclaimer->septic_tank_for_bedrooms = $disclosureData['septic_tank_for_bedrooms'];
                        $propertyConditionDisclaimer->any_septic_tank = $disclosureData['any_septic_tank'];
                        $propertyConditionDisclaimer->affected = $disclosureData['affected'];
                        $propertyConditionDisclaimer->in_an_historical_district = $disclosureData['in_an_historical_district'];
                        $propertyConditionDisclaimer->partc_details = $disclosureData['partc_details'];

                        if ($propertyConditionDisclaimer->save()) {
                            if (isset($getAdditionalData)) {
                                foreach ($getAdditionalData as $information) {
                                    //Save additional information into property additional conditional table for backup
                                    $additionalInfo = new \App\Models\PropertyAdditionalConditionalData;
                                    $additionalInfo->additional_information_id = $information['pivot']['additional_information_id'];
                                    $additionalInfo->property_id = $propertyData->id;
                                    $additionalInfo->save();
                                }
                            }
                        }
                    }
                }
            }
            if ($agrementSigned == true) {
                $offer = SaleOffer::where('id', $offerArray['offer_id'])
                    ->where('buyer_signature', config('constant.offer_signature.false'))
                    ->whereHas('property', function ($query) {
                        $query->where('property_type', config('constant.inverse_property_type.Sale'));
                        $query->withTrashed();
                    })->with(['buyerQuestionnaire' => function ($buyerQuestionnaireQuery) {
                        $buyerQuestionnaireQuery->select('id', 'offer_id', 'joint_cowners', 'partners');
                    }, 'signatures' => function ($signQuery) {
                        $signQuery->where('signature_type', config('constant.inverse_signature_type.sale agreement'));
                    }])->first(['id', 'property_id', 'sender_id', 'owner_id', 'buyer_signature']);
                //dd($offer);
                if (! empty($offer)) {
                    if ($offer->buyerQuestionnaire->joint_cowners == config('constant.joint_coowner.No')) {
                        $this->_updateAgrementStatus($offer->id);
                    } elseif ($offer->buyerQuestionnaire->joint_cowners == config('constant.joint_coowner.Yes') && ! empty($offer->buyerQuestionnaire->partners)) {

                        $partners = explode(',', $offer->buyerQuestionnaire->partners);
                        $partners = array_filter($partners);
                        $total = count($partners) + 1;

                        if ($total == $offer->signatures->count()) {
                            $this->_updateAgrementStatus($offer->id);
                        }
                    }
                }
            }
            //            get signature data corresponding
            $getSignatureData = Signature::where('offer_id', '=', $offerArray['offer_id'])->where('user_id', '=', Auth::id())->where('signature_type', '=', $type1)->first();

            //            dd($getSignatureData);
            return response(['success' => true, 'signature' => $getSignatureData]);
        } else {
            return response(['success' => false], 500);
        }
    }

    private function _updateAgrementStatus($offerId)
    {
        return SaleOffer::where('id', $offerId)->update(['buyer_signature' => config('constant.offer_signature.true')]);
    }

    public function advisorySignature(Request $request)
    {
        $offerArray = Session::get('OFFER');
        $ip = \Request::ip();
        $signature = Signature::where('user_id', Auth::id())
            ->where('offer_id', $offerArray['offer_id'])
//                ->where('user_id', Auth::id())
            ->where('signature_type', config('constant.inverse_signature_type.advisory to buyers and sellers'))
            ->first();

        if ($signature) {
            return response(['success' => true, 'signature' => $signature]);
        }
        $type = config('constant.inverse_signature_type.advisory to buyers and sellers');

        return $this->_savesignature($request, $offerArray, $ip, Auth::user()->user_profile->electronic_signature, $type);
    }

    public function disclaimerSignature(Request $request)
    {
        $offerArray = Session::get('OFFER');
        $ip = \Request::ip();
        $signature = Signature::where('user_id', Auth::id())
            ->where('offer_id', $offerArray['offer_id'])
            ->where('signature_type', config('constant.inverse_signature_type.property disclaimer'))
            ->first();
        if ($signature) {
            return response(['success' => true, 'signature' => $signature]);
        }
        $type = config('constant.inverse_signature_type.property disclaimer');

        return $this->_savesignature($request, $offerArray, $ip, Auth::user()->user_profile->electronic_signature, $type);
    }

    public function saleAgreementSignature(Request $request)
    {
        $offerArray = Session::get('OFFER');
        $ip = \Request::ip();
        $signature = Signature::where('user_id', Auth::id())
            ->where('offer_id', $offerArray['offer_id'])
            ->where('signature_type', config('constant.inverse_signature_type.sale agreement'))
            ->first();
        if ($signature) {
            return response(['success' => true, 'signature' => $signature]);
        }
        $type = config('constant.inverse_signature_type.sale agreement');

        return $this->_savesignature($request, $offerArray, $ip, Auth::user()->user_profile->electronic_signature, $type, true);
    }

    public function leadBasedSignature(Request $request)
    {
        $offerArray = Session::get('OFFER');
        $ip = \Request::ip();
        $signature = Signature::where('user_id', Auth::id())
            ->where('offer_id', $offerArray['offer_id'])
//                ->where('affix_status', '1')
            ->where('signature_type', config('constant.inverse_signature_type.lead based'))
            ->first();
        if ($signature) {
            return response(['success' => true, 'signature' => $signature]);
        }
        $type = config('constant.inverse_signature_type.lead based');

        return $this->_savesignature($request, $offerArray, $ip, Auth::user()->user_profile->electronic_signature, $type);
    }

    public function vaFhaSignature(Request $request)
    {
        $offerArray = Session::get('OFFER');
        $ip = \Request::ip();
        $signature = Signature::where('user_id', Auth::id())
            ->where('offer_id', $offerArray['offer_id'])
//                ->where('affix_status', '1')
            ->where('signature_type', config('constant.inverse_signature_type.VA FHA loan addendum'))
            ->first();
        if ($signature) {
            return response(['success' => true, 'signature' => $signature]);
        }
        $type = config('constant.inverse_signature_type.VA FHA loan addendum');

        return $this->_savesignature($request, $offerArray, $ip, Auth::user()->user_profile->electronic_signature, $type);
    }

    public function postClosingSignature(Request $request)
    {
        $offerArray = Session::get('OFFER');
        $ip = \Request::ip();
        $signature = Signature::where('user_id', Auth::id())
            ->where('offer_id', $offerArray['offer_id'])
            ->where('signature_type', config('constant.inverse_signature_type.post closing occupancy agreement'))
            ->first();
        if ($signature) {
            return response(['success' => true, 'signature' => $signature]);
        }
        $type = config('constant.inverse_signature_type.post closing occupancy agreement');

        return $this->_savesignature($request, $offerArray, $ip, Auth::user()->user_profile->electronic_signature, $type);
    }
}
