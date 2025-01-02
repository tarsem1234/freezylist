<?php

namespace App\Http\Controllers\Frontend\ContractTools;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\ContractTools\SaveLeadBasedPaintHazardsContractToolSellerRequest;
use App\Http\Requests\Frontend\PropertyConditionDisclaimerRequest;
use App\Http\Requests\Frontend\QuestionsSellerPostClosingRequest;
use App\Http\Requests\Frontend\SellerQuestionnaireRequest;
use App\Jobs\SendEmailJob;
use App\Mail\Frontend\SaleAgreementLandlordMailing;
use App\Models\BuyerQuestionnaire;
use App\Models\Property;
use App\Models\PropertyConditionalData;
use App\Models\PropertyConditionDisclaimer;
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
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class ContractToolSellerController extends Controller
{
    public function contractTools(): View
    {
        return view('frontend.contract_tools.contract_tools');
    }

    public function questionsSetForSeller(): View
    {
        $offerSession = Session::get('OFFER');
        $signers = Signer::where('from_user_id', Auth::id())->whereHas('invited_users')->with('invited_users')->get();
        $sellerQuestionnaire = SellerQuestionnaire::where('offer_id', $offerSession['offer_id'])
            ->where('user_id', Auth::id())->first();
        // Used while sending the property id in email for new user.
        $getProperty = SaleOffer::select('property_id')->where('id', $offerSession['offer_id'])
            ->first();

        return view('frontend.contract_tools.questions_set_for_seller', compact('signers', 'sellerQuestionnaire', 'getProperty'));
    }

    public function thankYouToSellerForAnswer(): View
    {
        $propertyData = Session::get('PROPERTY');
        $offerData = Session::get('OFFER');
        $offer = SaleOffer::where('id', $offerData['offer_id'])
            ->with(['sellerQuestionnaire'])
            ->first();
        $property = Property::where('id', $propertyData)
            ->where('user_id', Auth::id())
            ->with('architechture')
            ->withTrashed()
            ->first();
        $houseownersAssociations = false;
        $lead = false;
        if ($property->architechture->year_built < config('constant.year_built')) {
            $lead = true;
        }
        if ($offer->sellerQuestionnaire->houseowners_associations == 2) {
            $houseownersAssociations = true;

            return view('frontend.contract_tools.thank_you_to_seller_for_answer', compact('houseownersAssociations', 'property', 'lead'));
        }

        return view('frontend.contract_tools.thank_you_to_seller_for_answer', compact('lead'));
    }

    public function sellerPropertyConditionDisclosure()
    {
        //        if (!Session::get('PROPERTY') || !Session::get('OFFER')) {
        //            return redirect()->route('frontend.recieved.offers');
        //        }
        return view('frontend.contract_tools.seller_property_condition_disclosure');
    }

    public function disclosureBySellerUpdate($id = null, $page = null)
    {
        $propertyData = Session::get('PROPERTY');

        if (isset($propertyData) && $propertyData) {
            $property = Property::where('id', $propertyData)
                ->where('user_id', Auth::id())
                ->with('architechture', 'disclosure')->withTrashed()->first();
        }

        if ($id) {
            $property = Property::where('id', $id)
                ->where('user_id', Auth::id())
                ->with('architechture', 'disclosure')->withTrashed()->first();
        }
        $diffInYears = null;
        //        dump($property->toArray());
        if (isset($property)) {
            $now = Carbon::now()->year;
            $from = $property->architechture->year_built;
            $diffInYears = $now - $from;

            return view('frontend.contract_tools.disclosure_by_seller_update', compact('diffInYears', 'property', 'page'));
        }
        if (! empty($page) && $page == 'sale_list') {
            return redirect()->back();
        } else {
            return view('frontend.contract_tools.disclosure_by_seller_update');
        }
    }

    public function thankyouPd(): View
    {

        return view('frontend.contract_tools.thankyou_pd');
    }

    public function questionsToSellerProperty($value = ''): View
    {
        $offerData = Session::get('OFFER');
        $questionSellerPostClosing = QuestionSellerPostClosing::where('offer_id', $offerData['offer_id'])
            ->where('user_id', Auth::id())->first();
        if ($questionSellerPostClosing && ! empty($value)) {
            QuestionSellerPostClosing::where('offer_id', $offerData['offer_id'])
                ->where('user_id', Auth::id())
                ->update(['show_post_closing' => $value]);
        }

        return view('frontend.contract_tools.questions_to_seller_property', compact('questionSellerPostClosing'));
    }

    public function postClosingOccupancyAgreement()
    {
        $offerData = Session::get('OFFER');
        if ($offerData['type'] == config('constant.inverse_property_type.Sale')) {

            $savedQuestionSellerPostClosing = QuestionSellerPostClosing::where('user_id', Auth::id())
                ->where('offer_id', $offerData['offer_id'])
                ->with('saleOffer')->first();

            $sellerQuestionnaire = SellerQuestionnaire::where('user_id', Auth::id())
                ->where('offer_id', $offerData['offer_id'])
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

            return view('frontend.contract_tools.post_closing_occupancy_agreement', compact('savedQuestionSellerPostClosing', 'sellerQuestionnaire', 'days', 'currentMortgage'));
        }

        return redirect()->back();
    }

    public function postClosingQuestionsThankyou(): View
    {

        return view('frontend.contract_tools.post_closing_questions_thankyou');
    }

    public function updateSaleAgreementBysellerContract()
    {
        $offerArray = Session::get('OFFER');

        if ($offerArray['type'] == config('constant.inverse_property_type.Sale')) {
            $offer = SaleOffer::where('id', $offerArray['offer_id'])
                ->with(['property.propertyConditionDisclaimer' => function ($propertyCondDis) {
                    $propertyCondDis->select('property_id', 'best_knowledge_explain', 'partb_details', 'partc_details');
                }, 'sellerQuestionnaire', 'buyerQuestionnaire', 'seller' => function ($sellerQuery) {
                    $sellerQuery->with('user_profile', 'business_profile');
                }, 'buyer' => function ($buyerQuery) {
                    $buyerQuery->with('user_profile', 'business_profile');
                }, 'sale_counter_offers' => function ($query) {
                    $query->latest();
                }, 'saleAgreement'])->first();

            return view('frontend.contract_tools.update_sale_agreement_byseller_contract', compact('offer'));
        }

        return redirect()->back();
    }

    public function thankyouPurchaseAgreement(): View
    {
        $offerArray = Session::get('OFFER');
        $offer = SaleOffer::where('id', $offerArray['offer_id'])->first();

        $to = $offer->buyer->email;
        $emailSubject = 'Freezylist : Submitted the Sale Agreement';
        //        $userName     = getFullName(getPartnerProfile($offer->sender_id));
        $userName = getFullName($offer->buyer);
        $sender = getFullName($offer->seller);
        $emailBody = 'Hello'.$userName.', '.$sender.' submitted the sale agreement for the property which you have offered, Kindly review and Submit your details.';
        $view = 'frontend.offer.seller_sale_agreement_mail';
        $emailLinks = $this->_generateEmailLink($offer);

        Mail::send(new SaleAgreementLandlordMailing($to, $userName, $sender, $emailSubject, $emailBody, $emailLinks['viewOfferLink'], $emailLinks['propertyLink'], $view));

        $saveLog = new EmailLogService;
        $saveLog->saveLog($offer->property->id, $offer->sender_id, $offer->owner_id, $emailSubject, $emailBody, config('constant.property_type.'.$offer->property->property_type), url()->previous());

        Session::forget('OFFER');
        Session::forget('PROPERTY');

        return view('frontend.contract_tools.thankyou_purchase_agreement');
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

    public function saveSellerQuestionnaire(SellerQuestionnaireRequest $request, $id = null): RedirectResponse
    {
        $data = $request->all();
        $offerArray = Session::get('OFFER');

        $sellerQuestionnaire = SellerQuestionnaire::where('offer_id', $offerArray['offer_id'])
            ->where('user_id', Auth::id())->first();

        if (! empty($sellerQuestionnaire)) {
            if ($this->_prepareSellerQuestionarieData($sellerQuestionnaire, $data, $offerArray)) {

                return redirect()->route('frontend.thankYouToSellerForAnswer');
            }

            return redirect()->back()->with(['flash_warning' => 'Questions for seller did not save.']);
        } elseif (empty($sellerQuestionnaire) && $id != null) {
            return redirect()->back()->withFlashDanger('Invalid Offer.');
        } else {

            $sellerQuestionnaire = new SellerQuestionnaire;

            $sellerQuestionnaire->user_id = Auth::id();
            if ($this->_prepareSellerQuestionarieData($sellerQuestionnaire, $data, $offerArray)) {

                return redirect()->route('frontend.thankYouToSellerForAnswer');
            }

            return redirect()->back()->with(['flash_warning' => 'Questions for seller did not save.']);
        }
    }

    private function _prepareSellerQuestionarieData($sellerQuestionnaire, $data, $offerArray)
    {
        $sellerQuestionnaire->offer_id = $offerArray['offer_id'];
        $sellerQuestionnaire->household_items = $data['household_items'];
        $sellerQuestionnaire->amount_for_earnest_money = $data['amount_for_earnest_money'];
        $sellerQuestionnaire->where_funds_deposited = $data['where_funds_deposited'];
        $sellerQuestionnaire->legal_firm_address = $data['legal_firm_address'];
        $sellerQuestionnaire->real_estate_firm_name = $data['real_estate_firm_name'];
        $sellerQuestionnaire->commission = $data['commission'];
        $sellerQuestionnaire->agent_name = $data['name'];
        $sellerQuestionnaire->agent_phone = $data['phone'];
        $sellerQuestionnaire->property_vacant_date = $data['property_vacant_date'];

        if ($data['add_signer'] == config('constant.inverse_common_yes_no.Yes')) {
            if (isset($data['select-email']) && count($data['select-email']) > 1) {
                $emailIds = implode(',', $data['select-email']);
                $sellerQuestionnaire->partners = $emailIds;
            } else {
                $sellerQuestionnaire->partners = $data['select-email'][0];
            }
        } else {
            $sellerQuestionnaire->partners = null;
        }

        $sellerQuestionnaire->earnest_money = $data['earnest_money'];
        $sellerQuestionnaire->real_estate_agent = $data['real_estate_agent'];
        $sellerQuestionnaire->houseowners_associations = $data['houseowners_associations'];
        $sellerQuestionnaire->joint_cowners = $data['add_signer'];
        if ($sellerQuestionnaire->save()) {

            return true;
        }

        return false;
    }

    public function saveQuestionSellerPostClosing(QuestionsSellerPostClosingRequest $request)
    {
        if (! Session::get('PROPERTY') && ! Session::get('OFFER')) {
            return redirect()->route('frontend.recieved.offers');
        }
        $data = $request->all();
        $offerData = Session::get('OFFER');

        $property = Property::where('id', Session::get('PROPERTY'))->with('architechture')->withTrashed()->first();

        if (QuestionSellerPostClosing::where('user_id', Auth::id())->where('offer_id', $offerData['offer_id'])->exists()) {
            return $this->_updateQuestionSellerPostClosing($data, $offerData);
        }
        $postClosing = new QuestionSellerPostClosing;

        $postClosing->user_id = Auth::id();
        $postClosing->offer_id = $offerData['offer_id'];

        $postClosing->current_mortgage = $data['current_mortgage'];
        if ($data['additional_charge'] == config('constant.inverse_common_yes_no.Yes')) {
            $postClosing->additional_charge = $data['additional_charge'];
        }

        if ($data['refundable_security'] == config('constant.inverse_common_yes_no.Yes')) {
            $postClosing->refundable_security = $data['refundable_security'];
        }
        if ($data['unearned_rents'] == config('constant.inverse_common_yes_no.Yes')) {
            $postClosing->unearned_rents = $data['unearned_rents'];
        }
        if ($data['utilities'] == config('constant.inverse_common_yes_no.Yes')) {
            $postClosing->utilities = $data['utilities'];
        }
        if ($data['renter_policy'] == config('constant.inverse_common_yes_no.Yes')) {
            $postClosing->renter_policy = $data['renter_policy'];
        }
        if ($data['liability_insurance'] == config('constant.inverse_common_yes_no.Yes')) {
            $postClosing->liability_insurance = $data['liability_insurance'];
        }
        if ($postClosing->save()) {

            return redirect()->route('frontend.postClosingQuestionsThankyou');
        }

        return redirect()->back();
    }

    public function saveQuestionSellerPostAdditionalClosing(Request $request): RedirectResponse
    {
        if (! Session::get('PROPERTY') && ! Session::get('OFFER')) {
            return redirect()->route('frontend.recieved.offers');
        }
        $data = $request->all();
        $offerData = Session::get('OFFER');

        $property = Property::where('id', Session::get('PROPERTY'))->with('architechture')->withTrashed()->first();
        if (QuestionSellerPostClosing::where('offer_id', $offerData['offer_id'])
            ->where('user_id', Auth::id())
            ->update(['additional_provisions' => ! empty($data['additional_provisions']) ? $data['additional_provisions'] : ''])) {
            if ($property->architechture['year_built'] < config('constant.year_built')) {
                return redirect()->route('frontend.thankYouLeadBased');
            }

            return redirect()->route('frontend.sellerPropertyConditionDisclosure');
        }

        return redirect()->back();
    }

    private function _updateQuestionSellerPostClosing($data, $offerData)
    {
        $input['current_mortgage'] = ! empty($data['current_mortgage']) ? $data['current_mortgage'] : '';
        if ($data['additional_charge'] == config('constant.inverse_common_yes_no.Yes')) {
            $input['additional_charge'] = ! empty($data['additional_charge']) ? $data['additional_charge'] : '';
        }

        if ($data['refundable_security'] == config('constant.inverse_common_yes_no.Yes')) {
            $input['refundable_security'] = ! empty($data['refundable_security']) ? $data['refundable_security'] : '';
        }
        if ($data['unearned_rents'] == config('constant.inverse_common_yes_no.Yes')) {
            $input['unearned_rents'] = ! empty($data['unearned_rents']) ? $data['unearned_rents'] : '';
        }
        if ($data['utilities'] == config('constant.inverse_common_yes_no.Yes')) {
            $input['utilities'] = ! empty($data['utilities']) ? $data['utilities'] : '';
        }
        if ($data['renter_policy'] == config('constant.inverse_common_yes_no.Yes')) {
            $input['renter_policy'] = ! empty($data['renter_policy']) ? $data['utilities'] : '';
        }
        if ($data['liability_insurance'] == config('constant.inverse_common_yes_no.Yes')) {
            $input['liability_insurance'] = ! empty($data['liability_insurance']) ? $data['liability_insurance'] : '';
        }

        if (QuestionSellerPostClosing::where('offer_id', $offerData['offer_id'])->update($input)) {
            return redirect()->route('frontend.postClosingQuestionsThankyou');
        }

        return redirect()->back();
    }

    public function saveSellerPropertyConditionDisclosure(PropertyConditionDisclaimerRequest $request)
    {
        $data = $request->all();

        $centralHeatingType = null;
        $propertyIncludes = null;
        $centralAirConditioningType = null;
        $waterHeaterType = null;
        $waterSupplyType = null;
        $sewageDisposalType = null;
        $gasSupplyType = null;

        if (isset($data['property_includes']) && count($data['property_includes']) > 0) {
            $propertyIncludes = implode(',', $data['property_includes']);
        }
        if (isset($data['central_heating_type'])) {
            $centralHeatingType = implode(',', $data['central_heating_type']);
        }
        if (isset($data['central_air_conditioning_type'])) {
            $centralAirConditioningType = implode(',', $data['central_air_conditioning_type']);
        }
        if (isset($data['water_heater_type'])) {
            $waterHeaterType = implode(',', $data['water_heater_type']);
        }
        if (isset($data['water_supply_type'])) {
            $waterSupplyType = implode(',', $data['water_supply_type']);
        }
        if (isset($data['sewage_disposal_type'])) {
            $sewageDisposalType = implode(',', $data['sewage_disposal_type']);
        }
        if (isset($data['gas_supply_type'])) {
            $gasSupplyType = implode(',', $data['gas_supply_type']);
        }

        if (isset($data['property_id']) && $data['property_id']) {
            $propertyId = $data['property_id'];
        } else {
            $propertyId = Session::get('PROPERTY');
        }
        //update disclosure
        if ($request->submit == 'Update') {

            return $this->_updateSellerPropertyConditionDisclosure($request, $data, $propertyIncludes, $centralHeatingType, $centralAirConditioningType, $waterHeaterType, $waterSupplyType, $sewageDisposalType, $gasSupplyType, $propertyId);
        } else {

            $propertyConditionDisclaimer = new PropertyConditionDisclaimer;

            $propertyConditionDisclaimer->property_id = $propertyId;
            $propertyConditionDisclaimer->user_id = Auth::id();
            $propertyConditionDisclaimer->property_age = $data['propertyage'];
            $propertyConditionDisclaimer->date_added = $data['date_of_occupancy'];
            $propertyConditionDisclaimer->occupy = $data['occupy'];
            $propertyConditionDisclaimer->how_long = $data['howlong'];
            $propertyConditionDisclaimer->property_is = $data['propertyis'];
            $propertyConditionDisclaimer->roof_type = $data['rooftype'];
            $propertyConditionDisclaimer->roof_age = $data['roofage'];
            $propertyConditionDisclaimer->house_owners_associations = $data['houseowners_associations'];
            $propertyConditionDisclaimer->name_address = $data['name_address'];
            $propertyConditionDisclaimer->monthly_dues = $data['monthly_dues'];
            $propertyConditionDisclaimer->transfer_fees = $data['transfer_fees'];
            $propertyConditionDisclaimer->special_assessments = $data['special_assessments'];
            $propertyConditionDisclaimer->how_many = $data['howmany'];
            $propertyConditionDisclaimer->how_many_remotes = $data['how_many_remotes'];
            $propertyConditionDisclaimer->heat_pump_age = $data['heat_pump_age'];
            $propertyConditionDisclaimer->central_heating_age = $data['central_heating_age'];
            $propertyConditionDisclaimer->central_air_conditioning_age = $data['central_air_conditioning_age'];
            $propertyConditionDisclaimer->water_heater_age = $data['water_heater_age'];
            if (! empty($propertyIncludes)) {
                $propertyConditionDisclaimer->property_includes = $propertyIncludes;
            }
            if (isset($data['pool'])) {
                $propertyConditionDisclaimer->pool_type = $data['pool'];
            }
            if (isset($data['garage'])) {
                $propertyConditionDisclaimer->garage_type = $data['garage'];
            }
            if (isset($centralHeatingType)) {
                $propertyConditionDisclaimer->central_heating_type = $centralHeatingType;
            }
            if (isset($centralAirConditioningType)) {
                $propertyConditionDisclaimer->central_air_conditioning_type = $centralAirConditioningType;
            }
            if (isset($waterHeaterType)) {
                $propertyConditionDisclaimer->water_heater_type = $waterHeaterType;
            }
            if (isset($waterSupplyType)) {
                $propertyConditionDisclaimer->water_supply_type = $waterSupplyType;
            }
            if (isset($sewageDisposalType)) {
                $propertyConditionDisclaimer->sewage_disposal_type = $sewageDisposalType;
            }
            if (isset($gasSupplyType)) {
                $propertyConditionDisclaimer->gas_supply_type = $gasSupplyType;
            }
            $propertyConditionDisclaimer->other_items_included = $data['other_items_included'];
            $propertyConditionDisclaimer->best_knowledge = $data['bsknowledge'];
            $propertyConditionDisclaimer->best_knowledge_explain = $data['bsknowledge_explain'];
            $propertyConditionDisclaimer->interior_walls = $data['interior_walls'];
            $propertyConditionDisclaimer->ceilings = $data['ceilings'];
            $propertyConditionDisclaimer->floors = $data['floors'];
            $propertyConditionDisclaimer->windows = $data['windows'];
            $propertyConditionDisclaimer->doors = $data['doors'];
            $propertyConditionDisclaimer->insulation = $data['insulation'];
            $propertyConditionDisclaimer->plumbing = $data['plumbing'];
            $propertyConditionDisclaimer->sewer = $data['sewer'];
            $propertyConditionDisclaimer->electrical_system = $data['electrical_system'];
            $propertyConditionDisclaimer->exterior_walls = $data['exterior_walls'];
            $propertyConditionDisclaimer->roof = $data['roof'];
            $propertyConditionDisclaimer->basement = $data['basement'];
            $propertyConditionDisclaimer->foundation = $data['foundation'];
            $propertyConditionDisclaimer->slab = $data['slab'];
            $propertyConditionDisclaimer->drive_way = $data['driveway'];
            $propertyConditionDisclaimer->side_walks = $data['sidewalks'];
            $propertyConditionDisclaimer->central_heating = $data['central_heating'];
            $propertyConditionDisclaimer->heat_pump = $data['heat_pump'];
            $propertyConditionDisclaimer->central_air = $data['central_air_conditioning'];
            $propertyConditionDisclaimer->partb_details = $data['partb_details'];
            $propertyConditionDisclaimer->any_repairs = $data['any_repairs'];
            $propertyConditionDisclaimer->substances = $data['substances'];
            $propertyConditionDisclaimer->features_shared = $data['features_shared'];
            $propertyConditionDisclaimer->any_authorized_changes = $data['any_authorized_changes'];
            $propertyConditionDisclaimer->most_recent_survey = $data['most_recent_survey'];
            $propertyConditionDisclaimer->any_change_since_latest_survey = $data['any_change_since_latest_survey'];
            $propertyConditionDisclaimer->any_encroachments = $data['any_encroachments'];
            $propertyConditionDisclaimer->repairs = $data['repairs'];
            $propertyConditionDisclaimer->repairs_with_building_codes = $data['repairs_with_building_codes'];
            $propertyConditionDisclaimer->land_fill = $data['landfill'];
            $propertyConditionDisclaimer->any_settling = $data['any_settling'];
            $propertyConditionDisclaimer->problems = $data['problems'];
            $propertyConditionDisclaimer->requirement = $data['requirement'];
            $propertyConditionDisclaimer->location = $data['location'];
            $propertyConditionDisclaimer->interior = $data['interior'];
            $propertyConditionDisclaimer->structural_damage = $data['structural_damage'];
            $propertyConditionDisclaimer->any_zoning_violations = $data['any_zoning_violations'];
            $propertyConditionDisclaimer->neighborhood_noise = $data['neighborhood_noise'];
            $propertyConditionDisclaimer->restrictions = $data['restrictions'];
            $propertyConditionDisclaimer->any_common_area = $data['any_common_area'];
            $propertyConditionDisclaimer->any_notices = $data['any_notices'];
            $propertyConditionDisclaimer->any_lawsuit = $data['any_lawsuit'];
            $propertyConditionDisclaimer->any_system = $data['any_system'];
            $propertyConditionDisclaimer->any_exterior = $data['any_exterior'];
            $propertyConditionDisclaimer->any_finished_rooms = $data['any_finished_rooms'];
            $propertyConditionDisclaimer->septic_tank_for_bedrooms = $data['septic_tank_for_bedrooms'];
            $propertyConditionDisclaimer->any_septic_tank = $data['any_septic_tank'];
            $propertyConditionDisclaimer->affected = $data['affected'];
            $propertyConditionDisclaimer->in_an_historical_district = $data['in_an_historical_district'];
            $propertyConditionDisclaimer->partc_details = $data['partc_details'];

            if ($propertyConditionDisclaimer->save()) {
                if ($request->property_id && (strpos($request->previous_url, 'rents-list') == true)) {

                    return redirect()->route('frontend.property.rentsList')->withFlashSuccess('Property Disclosure added successfully.');
                } elseif ($request->property_id && (strpos($request->previous_url, 'sales-list') == true)) {

                    return redirect()->route('frontend.property.salesList')->withFlashSuccess('Property Disclosure added successfully.');
                } else {

                    $offerData = Session::get('OFFER');

                    if ($offerData['type'] == config('constant.inverse_property_type.Rent')) {
                        return redirect()->route('frontend.thankyouDiscloserTool');
                    } else {
                        return redirect()->route('frontend.thankyouPd');
                    }
                }
            }
        }

        return redirect()->back()->withFlashDanger('Oops!! Something went wrong.');
    }

    private function _updateSellerPropertyConditionDisclosure($request, $data, $propertyIncludes, $centralHeatingType, $centralAirConditioningType, $waterHeaterType, $waterSupplyType, $sewageDisposalType, $gasSupplyType, $propertyId)
    {

        $input['property_id'] = $propertyId;
        $input['user_id'] = Auth::id();
        $input['property_age'] = $data['propertyage'];
        $input['date_added'] = $data['date_of_occupancy'];
        $input['occupy'] = $data['occupy'];
        $input['how_long'] = $data['howlong'];
        $input['property_is'] = $data['propertyis'];
        $input['roof_type'] = $data['rooftype'];
        $input['roof_age'] = $data['roofage'];
        $input['house_owners_associations'] = $data['houseowners_associations'];
        $input['name_address'] = $data['name_address'];
        $input['monthly_dues'] = $data['monthly_dues'];
        $input['transfer_fees'] = $data['transfer_fees'];
        $input['special_assessments'] = $data['special_assessments'];
        $input['how_many'] = $data['howmany'];
        $input['how_many_remotes'] = $data['how_many_remotes'];
        $input['heat_pump_age'] = $data['heat_pump_age'];
        $input['central_heating_age'] = $data['central_heating_age'];
        $input['central_air_conditioning_age'] = $data['central_air_conditioning_age'];
        $input['water_heater_age'] = $data['water_heater_age'];

        if (! empty($propertyIncludes)) {
            $input['property_includes'] = $propertyIncludes;
        }
        if (isset($data['pool'])) {
            $input['pool_type'] = $data['pool'];
        }
        if (isset($data['garage'])) {
            $input['garage_type'] = $data['garage'];
        }
        if (isset($centralHeatingType)) {
            $input['central_heating_type'] = $centralHeatingType;
        }
        if (isset($centralAirConditioningType)) {
            $input['central_air_conditioning_type'] = $centralAirConditioningType;
        }
        if (isset($waterHeaterType)) {
            $input['water_heater_type'] = $waterHeaterType;
        }
        if (isset($waterSupplyType)) {
            $input['water_supply_type'] = $waterSupplyType;
        }
        if (isset($sewageDisposalType)) {
            $input['sewage_disposal_type'] = $sewageDisposalType;
        }
        if (isset($gasSupplyType)) {
            $input['gas_supply_type'] = $gasSupplyType;
        }

        $input['other_items_included'] = $data['other_items_included'];
        $input['best_knowledge'] = $data['bsknowledge'];
        $input['best_knowledge_explain'] = $data['bsknowledge_explain'];
        $input['interior_walls'] = $data['interior_walls'];
        $input['ceilings'] = $data['ceilings'];
        $input['floors'] = $data['floors'];
        $input['windows'] = $data['windows'];
        $input['doors'] = $data['doors'];
        $input['insulation'] = $data['insulation'];
        $input['plumbing'] = $data['plumbing'];
        $input['sewer'] = $data['sewer'];
        $input['electrical_system'] = $data['electrical_system'];
        $input['exterior_walls'] = $data['exterior_walls'];
        $input['roof'] = $data['roof'];
        $input['basement'] = $data['basement'];
        $input['foundation'] = $data['foundation'];
        $input['slab'] = $data['slab'];
        $input['drive_way'] = $data['driveway'];
        $input['side_walks'] = $data['sidewalks'];
        $input['central_heating'] = $data['central_heating'];
        $input['heat_pump'] = $data['heat_pump'];
        $input['central_air'] = $data['central_air_conditioning'];
        $input['partb_details'] = $data['partb_details'];
        $input['any_repairs'] = $data['any_repairs'];
        $input['substances'] = $data['substances'];
        $input['features_shared'] = $data['features_shared'];
        $input['any_authorized_changes'] = $data['any_authorized_changes'];
        $input['most_recent_survey'] = $data['most_recent_survey'];
        $input['any_change_since_latest_survey'] = $data['any_change_since_latest_survey'];
        $input['any_encroachments'] = $data['any_encroachments'];
        $input['repairs'] = $data['repairs'];
        $input['repairs_with_building_codes'] = $data['repairs_with_building_codes'];
        $input['land_fill'] = $data['landfill'];
        $input['any_settling'] = $data['any_settling'];
        $input['problems'] = $data['problems'];
        $input['requirement'] = $data['requirement'];
        $input['location'] = $data['location'];
        $input['interior'] = $data['interior'];
        $input['structural_damage'] = $data['structural_damage'];
        $input['any_zoning_violations'] = $data['any_zoning_violations'];
        $input['neighborhood_noise'] = $data['neighborhood_noise'];
        $input['restrictions'] = $data['restrictions'];
        $input['any_common_area'] = $data['any_common_area'];
        $input['any_notices'] = $data['any_notices'];
        $input['any_lawsuit'] = $data['any_lawsuit'];
        $input['any_system'] = $data['any_system'];
        $input['any_exterior'] = $data['any_exterior'];
        $input['affected'] = $data['affected'];
        $input['any_finished_rooms'] = $data['any_finished_rooms'];
        $input['septic_tank_for_bedrooms'] = $data['septic_tank_for_bedrooms'];
        $input['any_septic_tank'] = $data['any_septic_tank'];
        $input['in_an_historical_district'] = $data['in_an_historical_district'];
        $input['partc_details'] = $data['partc_details'];

        if (PropertyConditionDisclaimer::where('property_id', $propertyId)
            ->where('user_id', Auth::id())->update($input)) {

            if ($request->property_id && (strpos($request->previous_url, 'rents-list') == true)) {
                return redirect()->route('frontend.property.rentsList')->withFlashSuccess('Property Disclosure updated successfully.');
            } elseif ($request->property_id && (strpos($request->previous_url, 'sales-list') == true)) {
                return redirect()->route('frontend.property.salesList')->withFlashSuccess('Property Disclosure updated successfully.');
            } else {
                $offerData = Session::get('OFFER');

                if ($offerData['type'] == config('constant.inverse_property_type.Rent')) {
                    return redirect()->route('frontend.thankyouDiscloserTool');
                } else {
                    return redirect()->route('frontend.thankyouPd');
                }
            }
        }

        return redirect()->back()->withFlashDanger('Oops!! Something went wrong.');
    }

    //    update as client want when click on yes button form will not show on buyer end
    public function thankYouLeadBased($value = ''): View
    {
        $offerData = Session::get('OFFER');
        $postClosingQuestion = QuestionSellerPostClosing::where('offer_id', $offerData['offer_id'])->first();
        if ($postClosingQuestion && ! empty($value)) {
            QuestionSellerPostClosing::where('offer_id', $offerData['offer_id'])
                ->where('user_id', Auth::id())
                ->update(['show_post_closing' => $value]);
        }

        return view('frontend.contract_tools.thank_you_lead_based_seller');
    }

    public function thankYouLeadBasedOld(): View
    {
        //        return view('frontend.contract_tools.thank_you_lead_based');

        return view('frontend.contract_tools.thank_you_lead_based_seller');
    }

    public function leadBasedPaintHazards($id = null)
    {
        $offerData = Session::get('OFFER');
        if ($id && Property::where('id', $id)->where('user_id', Auth::id())->where('property_type', 1)) {
            $property = true;
            $offer = Property::where('id', $id)
                ->select('id', 'lead_based', 'lead_based_report', 'user_id')
                ->first();

            return view('frontend.contract_tools.lead_based_paint_hazards_seller', compact('offer', 'property'));
        } elseif (Session::get('PROPERTY') && Property::where('id', Session::get('PROPERTY'))
            ->where('user_id', Auth::id())
            ->where('property_type', 2)->withTrashed()) {
            $offer = SaleOffer::where('id', $offerData['offer_id'])
                ->with(['property' => function ($query) {
                    $query->select('id', 'lead_based', 'lead_based_report', 'user_id');
                    $query->withTrashed();
                }])->first();

            return view('frontend.contract_tools.lead_based_paint_hazards_seller', compact('offer'));
        }

        return redirect()->back()->with(['flash_danger' => 'Something went wrong']);
    }

    public function saveLeadBasedPaintHazards(SaveLeadBasedPaintHazardsContractToolSellerRequest $request): RedirectResponse
    {

        $data = $request->all();
        if (isset($request->id) && $request->id) {
            $propertyId = $request->id;
        } else {
            $propertyId = Session::get('PROPERTY');
        }
        $input['lead_based'] = $data['lead_based'];
        $input['lead_based_report'] = $data['lead_based_report'];

        if (Property::where('id', $propertyId)->where('user_id', Auth::id())->update($input)) {
            if ($request->id) {

                return redirect()->route('frontend.property.salesList');
            }

            return redirect()->route('frontend.sellerPropertyConditionDisclosure');
        }

        return redirect()->back();
    }

    public function saveUpdateSaleAgreementBysellerContract(Request $request)
    {
        //        die('saveUpdateSaleAgreementBysellerContract');
        $data = $request->all();
        $offerData = Session::get('OFFER');
        if (UpdateSaleAgreementBysellerContract::where('offer_id', $offerData['offer_id'])->exists()) {
            return $this->_updateSaleAgreement($data, $offerData);
        }
        $updateSaleAgreementBysellerContract = new UpdateSaleAgreementBysellerContract;

        $updateSaleAgreementBysellerContract->offer_id = $offerData['offer_id'];
        if (isset($data['addenda'])) {
            $updateSaleAgreementBysellerContract->addenda = implode(',', $data['addenda']);
        }
        $updateSaleAgreementBysellerContract->not_included_insale = $data['not_included_insale'];
        $updateSaleAgreementBysellerContract->leased_items = $data['leased_items'];
        $updateSaleAgreementBysellerContract->other = $data['other'];
        $updateSaleAgreementBysellerContract->offer_expiration = $data['offer_expiration'];
        $updateSaleAgreementBysellerContract->seller_contract_tool_status = 1;
        if ($updateSaleAgreementBysellerContract->save()) {

            return redirect()->route('frontend.thankyouPurchaseAgreement');
        }

        return redirect()->back();
    }

    private function _updateSaleAgreement($data, $offerData)
    {
        if (isset($data['addenda'])) {
            $updateSaleAgreementBysellerContract['addenda'] = implode(',', $data['addenda']);
        }
        $updateSaleAgreementBysellerContract['not_included_insale'] = $data['not_included_insale'];
        $updateSaleAgreementBysellerContract['leased_items'] = $data['leased_items'];
        $updateSaleAgreementBysellerContract['other'] = $data['other'];
        $updateSaleAgreementBysellerContract['offer_expiration'] = $data['offer_expiration'];
        if (UpdateSaleAgreementBysellerContract::where('offer_id', $offerData['offer_id'])->update($updateSaleAgreementBysellerContract)) {
            return redirect()->route('frontend.thankyouPurchaseAgreement');
        }

        return redirect()->back();
    }

    public function sdSummaryKeyTermsForSeller(): View
    {
        $offerArray = Session::get('OFFER');

        if ($offerArray['type'] == config('constant.inverse_property_type.Sale')) {
            $offer = SaleOffer::where('id', $offerArray['offer_id'])
                ->with(['propertyConditional.architechture', 'propertyConditional.disclosure' => function ($propertyCondDis) {
                    $propertyCondDis->select('best_knowledge_explain', 'partb_details', 'partc_details');
                }, 'sellerQuestionnaire', 'seller' => function ($sellerQuery) {
                    $sellerQuery->with('user_profile', 'business_profile');
                }, 'signatures' => function ($query) use ($offerArray) {
                    $query->where('offer_id', $offerArray['offer_id']);
                }, 'sale_counter_offers' => function ($query) {
                    $query->latest();
                }, 'saleAgreement'])->first();
        }

        return view('frontend.contract_tools.sale.seller.sd_summary_key_terms_for_seller', compact('offer'));
    }

    public function sdAdvisoryToBuyersAndSellersSellers(): View
    {
        $offerArray = Session::get('OFFER');
        $offer = null;
        $type = config('constant.inverse_signature_type.advisory to buyers and sellers');
        if ($offerArray['type'] == config('constant.inverse_property_type.Sale')) {
            $signature = Signature::where('user_id', Auth::id())
                ->where('offer_id', $offerArray['offer_id'])
                ->where('signature_type', config('constant.inverse_signature_type.sale agreement'))
                ->first();
            //getting the signatures direct form signature table
            $offer = SaleOffer::where('id', $offerArray['offer_id'])
                ->with(['propertyConditional',
                    'signatures' => function ($query) use ($offerArray) {
                        $query->where('offer_id', $offerArray['offer_id']);
                        //                                            >where('signature_type', config('constant.inverse_signature_type.advisory to buyers and sellers'));
                    }])->first();
            //                                dd($offer->propertyConditional);
        }

        return view('frontend.contract_tools.sale.seller.sd_advisory_to_buyers_and_sellers_sellers', compact('offer', 'type', 'signature'));
    }

    public function sdAdvisoryToBuyersAndSellersThankYou(): View
    {
        return view('frontend.contract_tools.sale.seller.sd_advisory_to_buyers_and_sellers_thank_you');
    }

    public function sdDisclosureBySellerUpdate($id = null): View
    {
        $propertyData = Session::get('PROPERTY');
        $offerArray = Session::get('OFFER');
        $type = config('constant.inverse_signature_type.property disclaimer');
        $signature = Signature::where('user_id', Auth::id())
            ->where('offer_id', $offerArray['offer_id'])
            ->where('signature_type', config('constant.inverse_signature_type.property disclaimer'))
            ->first();
        //  check is signature exist then get the data from backup tables
        $property = PropertyConditionalData::where('offer_id', $offerArray['offer_id'])->where('property_id', $propertyData)
            ->with('architechture', 'disclosure')->first();
        $diffInYears = null;
        //        dump($property->toArray());
        if (isset($property)) {
            $now = Carbon::now()->year;
            $from = $property->architechture->year_built;
            $diffInYears = $now - $from;

            $offer = null;
            if (! empty($offerArray)) {
                $offer = SaleOffer::where('id', $offerArray['offer_id'])
                    ->with(['propertyConditional', 'signatures' => function ($query) use ($offerArray) {
                        $query->where('offer_id', $offerArray['offer_id']);
                    }])->first();
            }

            return view('frontend.contract_tools.sale.seller.sd_disclosure_by_seller_update', compact('diffInYears', 'property', 'offer', 'type', 'signature'));
        }

        return view('frontend.contract_tools.sale.seller.sd_disclosure_by_seller_update');
    }

    public function sdThankYouSellerForPd()
    {
        $property = Property::where('id', Session::get('PROPERTY'))->with('architechture')->withTrashed()->first();
        if ($property->architechture['year_built'] < config('constant.year_built')) {
            return view('frontend.contract_tools.sale.seller.sd_thank_you_seller_for_pd', compact('property'));
        }

        return redirect()->route('frontend.sdCheckVaFhaSeller');
    }

    public function sdCheckVaFhaSeller()
    {
        $offerData = Session::get('OFFER');
        $buyerQues = BuyerQuestionnaire::where('offer_id', $offerData['offer_id'])->first();
        if ($buyerQues->using_VA_or_FHA == 1) {
            return view('frontend.contract_tools.sale.sign_documents.sd_thank_you_seller_necessary_forms');
        }

        return redirect()->route('frontend.sdCheckSignaturePostClosingSeller');
    }

    public function sdLeadBasedPaintHazardsUpdateBySeller(): View
    {
        $offerData = Session::get('OFFER');
        $type = config('constant.inverse_signature_type.lead based');
        $offer = SaleOffer::where('id', $offerData['offer_id'])
            ->with(['property' => function ($query) {
                $query->select('id', 'lead_based', 'lead_based_report', 'user_id');
                $query->withTrashed();

            }, 'signatures' => function ($query) use ($offerData) {
                $query->where('offer_id', $offerData['offer_id'])
                    ->where('signature_type', config('constant.inverse_signature_type.lead based'));
            }])->first();

        return view('frontend.contract_tools.sale.sign_documents.sd_lead_based_paint_hazards_update_by_seller', compact('offer', 'type'));
    }

    public function sdThankYouSellerNecessaryForms()
    {
        $offerData = Session::get('OFFER');
        $buyerQues = BuyerQuestionnaire::where('offer_id', $offerData['offer_id'])->first();
        if ($buyerQues->using_VA_or_FHA == 1) {
            return view('frontend.contract_tools.sale.sign_documents.sd_thank_you_seller_necessary_forms');
        }

        return redirect()->route('frontend.sdCheckSignaturePostClosingSeller');
    }

    public function sdVaFhaThankYouForSeller(): View
    {
        $offerData = Session::get('OFFER');
        $postClosingQuestion = QuestionSellerPostClosing::where('offer_id', $offerData['offer_id'])->first();
        //        $sellerQues = SellerQuestionnaire::where('offer_id', $offerData['offer_id'])->first();
        //        dd($postClosingQuestion);
        if (! empty($postClosingQuestion->show_post_closing) && $postClosingQuestion->show_post_closing == config('constant.show_post_closing_form.No')) {
            return view('frontend.contract_tools.sale.seller.sd_va_fha_thank_you_for_seller');
        }

        return view('frontend.contract_tools.sale.seller.sd_post_closing_thankyou_by_seller');
    }

    public function sdCheckSignaturePostClosingSeller(): View
    {
        $offerData = Session::get('OFFER');
        $postClosingQuestion = QuestionSellerPostClosing::where('offer_id', $offerData['offer_id'])->first();
        if ($postClosingQuestion) {
            return view('frontend.contract_tools.sale.seller.sd_va_fha_thank_you_for_seller');
        }

        return view('frontend.contract_tools.sale.seller.sd_post_closing_thankyou_by_seller');
    }

    public function sdPostClosingOccupancyAgreementBySeller(): View
    {
        $offerData = Session::get('OFFER');
        //        type pass in signature common file
        $type = config('constant.inverse_signature_type.post closing occupancy agreement');

        $signature = Signature::where('user_id', Auth::id())
            ->where('offer_id', $offerData['offer_id'])
            ->where('signature_type', config('constant.inverse_signature_type.post closing occupancy agreement'))
            ->first();

        $offer = SaleOffer::where('id', $offerData['offer_id'])
            ->with(['propertyConditional' => function ($query) {
                //                                $query->select('id', 'lead_based', 'lead_based_report', 'user_id');
            }, 'signatures' => function ($query) use ($offerData) {
                $query->where('offer_id', $offerData['offer_id']);
                //                                ->where('signature_type', config('constant.inverse_signature_type.post closing occupancy agreement'));
            }])->first();
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

        return view('frontend.contract_tools.sale.seller.sd_post_closing_occupancy_agreement_by_seller', compact('savedQuestionSellerPostClosing', 'sellerQuestionnaire', 'days', 'currentMortgage', 'offer', 'type', 'signature'));
    }

    public function sdVaFhaloanAddendumBySeller()
    {
        $offerArray = Session::get('OFFER');
        $type = config('constant.inverse_signature_type.VA FHA loan addendum');
        $signature = Signature::where('user_id', Auth::id())
            ->where('offer_id', $offerArray['offer_id'])
            ->where('signature_type', config('constant.inverse_signature_type.lead based'))
            ->first();
        if ($offerArray['type'] == config('constant.inverse_property_type.Sale')) {
            $offer = SaleOffer::where('id', $offerArray['offer_id'])
                ->with(['buyerQuestionnaire', 'propertyConditional' => function ($query) {}, 'signatures' => function ($query) use ($offerArray) {
                    $query->where('offer_id', $offerArray['offer_id']);
                }])->first();
        }
        if ($offer->buyerQuestionnaire->using_VA_or_FHA == 1) {
            return view('frontend.contract_tools.sale.sign_documents.sd_VA_FHA_loan_addendum_by_seller', compact('offer', 'type', 'signature'));
        }

        return redirect()->route('frontend.checkSignaturePostClosingBuyer');
    }

    public function sdPostClosingThankyouBySeller(): View
    {
        return view('frontend.contract_tools.sale.seller.sd_post_closing_thankyou_by_seller');
    }

    public function sdSaleAgreementReviewBySeller(): View
    {
        return view('frontend.contract_tools.sale.sign_documents.sd_sale_agreement_review');
    }

    public function sdUpdateSaleAgreement(): View
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

        return view('frontend.contract_tools.sale.seller.sd_update_sale_agreement', compact('offer', 'signature', 'type'));
    }

    public function sdThankyouPurchaseAgreement(): View
    {
        $offerData = Session::get('OFFER');

        $offer = SaleOffer::where('id', $offerData['offer_id'])->with(['property' => function ($query) {
            $query->withTrashed();
        },
            'sellerQuestionnaire', 'buyerQuestionnaire', 'seller', 'buyer', 'signatures'])->first();
        //        dd($offerData);
        //        $allUsers[getFullName($offer->seller)] = $offer->seller->email;
        //        $allUsers[getFullName($offer->buyer)] = $offer->buyer->email;
        //        dd(getOfferPartnerProfile($offer->seller->id,$offerData['offer_id']));

        $allUsers[getOfferPartnerProfile($offer->seller->id, $offer->id, 'getname')] = $offer->seller->email;
        $allUsers[getOfferPartnerProfile($offer->buyer->id, $offer->id, 'getname')] = $offer->buyer->email;
        //dd($allUsers);
        if (! empty($offer->sellerQuestionnaire->partners)) {
            $sellerPartners = explode(',', $offer->sellerQuestionnaire->partners);
            foreach ($sellerPartners as $sellerPartner) {
                $sellerPartnerProfile = getOfferPartnerProfile($sellerPartner, $offer->id);
                //                dd($sellerPartnerProfile);
                $allUsers[getOfferPartnerProfile($offer->buyer->id, $offer->id, 'getname')] = $sellerPartnerProfile->email;
            }
        }
        if (! empty($offer->buyerQuestionnaire->partners)) {
            $buyerPartners = explode(',', $offer->buyerQuestionnaire->partners);
            foreach ($buyerPartners as $buyerPartner) {
                $buyerPartnerProfile = getOfferPartnerProfile($buyerPartner, $offer->id);
                $allUsers[getOfferPartnerProfile($buyerPartner, $offer->id, 'getname')] = $buyerPartnerProfile->email;
            }
        }

        $signupLink = null;
        $sender = getFullName(Auth::user());
        if (! empty($offer->sellerQuestionnaire->partners)) {
            $partners = explode(',', $offer->sellerQuestionnaire->partners);

            $count = 0;
            foreach ($partners as $partner) {
                $partnerProfile = getOfferPartnerProfile($partner, $offer->id);
                $signed = false;
                foreach ($offer->signatures as $signature) {
                    if ($signature->user_id == $partner &&
                            $signature->signature_type == config('constant.inverse_signature_type.sale agreement')) {
                        $count++;
                    }
                }
                if (count($partners) == $count) {
                    $signed = true;
                }

                if (($partnerProfile->user_profile || $partnerProfile->business_profile) && ! $signed) {
                    $to = $partnerProfile->email;
                    $userName = ! empty($partnerProfile->signature['fullname']) ? $partnerProfile->signature['fullname'] : getFullName($partnerProfile);
                    $emailSubject = 'Freezylist : Seller completed the sign document process';
                    $emailBody = 'Hello '.$userName.', '.$sender.' has signed property sale agreement. Please view and sign the documents. Thank You';
                    $view = 'frontend.offer.partner_contract_tool_sale_agreement_mail';
                    //                    $emailLinks = $this->_generatePartnersEmailLink($offer);
                    $viewOfferLink = route('frontend.signOffersSaleSellerPartner', $offer->sellerQuestionnaire->id);
                    $propertyLink = route('frontend.propertyDetails', $offer->property->id);
                    Mail::send(new SaleAgreementLandlordMailing($to, $userName, $sender, $emailSubject, $emailBody, $viewOfferLink, $propertyLink, $view));
                    //                } elseif(!$partnerProfile->user_profile || !$partnerProfile->business_profile){
                } elseif (! $partnerProfile->user_profile) {
                    if ($partnerProfile->roles->first()->name == config('constant.user_type.3')) {
                        $signupLink = route('frontend.userCreate').'?code='.$partnerProfile->confirmation_code.'&time='.$partnerProfile->created_at;
                    } else {
                        $signupLink = route('frontend.businessCreate').'?code='.$partnerProfile->confirmation_code.'&time='.$partnerProfile->created_at;
                    }
                    $to = $partnerProfile->email;
                    $userName = ! empty($partnerProfile->signature['fullname']) ? $partnerProfile->signature['fullname'] : getFullName($partnerProfile);
                    $emailSubject = 'Freezylist : Seller completed the sign document process';
                    $emailBody = 'Hello '.$userName.', '.$sender.' has signed property sale agreement. Please complete your signup process and proceed with sign document process. Thank You';
                    $view = 'frontend.offer.partner_contract_tool_sale_agreement_mail';
                    $viewOfferLink = route('frontend.signOffersSaleSellerPartner', $offer->sellerQuestionnaire->id);
                    $propertyLink = route('frontend.propertyDetails', $offer->property->id);
                    //                    $emailLinks = $this->_generatePartnersEmailLink($offer);
                    Mail::send(new SaleAgreementLandlordMailing($to, $userName, $sender, $emailSubject, $emailBody, $viewOfferLink, $propertyLink, $view, $signupLink));
                } else {
                    $viewOfferLink = route('frontend.recieved.view.offer', ['offer_id' => $offer->id,
                        'type' => config('constant.property_type.'.$offer->property->property_type),
                        'property_id' => $offer->property->id,
                        'owner_id' => $offer->owner_id]);
                    $emailLinks['viewOfferLink'] = $viewOfferLink;
                    $view = 'frontend.offer.seller_completed_sale_agreement';
                    $emailLinks = $this->_generatePartnersEmailLink($offer);
                    $emailSubject = 'Freezylist : Signature Process completed.';

                    SendEmailJob::dispatch($allUsers, $sender, $emailSubject, $emailLinks['viewOfferLink'], $emailLinks['propertyLink'], $view, $offer)->onQueue('high');
                }
            }

            return view('frontend.contract_tools.sale.seller.sd_thankyou_purchase_agreement');
        } else {

            $viewOfferLink = route('frontend.recieved.view.offer', ['offer_id' => $offer->id,
                'type' => config('constant.property_type.'.$offer->property->property_type),
                'property_id' => $offer->property->id,
                'owner_id' => $offer->owner_id]);

            $propertyLink = route('frontend.propertyDetails', $offer->property->id);

            foreach ($allUsers as $userName => $userEmail) {
                // mail to tenant for sign
                $emailSubject = 'Freezylist : Signature Process completed.';
                $emailBody = 'Hello '.$userName.'Signature Process completed for sale agreement property and ready to download the documents. Thank You';
                $view = 'frontend.offer.seller_completed_sale_agreement';

                Mail::send(new SaleAgreementLandlordMailing($userEmail, $userName, $sender, $emailSubject, $emailBody, $viewOfferLink, $propertyLink, $view));

                $saveLog = new EmailLogService;
                $saveLog->saveLog($offer->property->id, $offer->sender_id, $offer->owner_id, $emailSubject, $emailBody, config('constant.property_type.'.$offer->property->property_type), url()->previous());
            }
        }

        return view('frontend.contract_tools.sale.seller.sd_thankyou_purchase_agreement');
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

    public function BusinessContractTools(): View
    {
        $sellerDetails = null;
        if (Session::has('buyerDetails')) {
            $sellerDetails = Session::get('buyerDetails');
        }

        return view('frontend.contract_tools.business_contract_tools', compact('buyerDetails'));
    }

    public function signOffersSaleSellerPartner($id)
    {
        $sellerDetails = SellerQuestionnaire::where('id', $id)->whereHas('saleOffer')->with(['saleOffer' => function ($query) {
            $query->with(['property' => function ($query) {
                $query->withTrashed();
            }, 'saleAgreement', 'property_owner_user' => function ($subquery) {
                $subquery->with(['business_profile', 'user_profile']);
            }, 'sale_counter_offers' => function ($query) {
                $query->latest();
            }, 'signatures' => function ($signQuery) {
                $signQuery->where('signature_type', config('constant.inverse_signature_type.sale agreement'));
            }, 'buyer' => function ($sellerQuery) {
                $sellerQuery->select('id', 'email')
                    ->with(['user_profile', 'business_profile']);
            }]);
        }])->first();
        if (empty($sellerDetails)) {
            return redirect()->back()->withFlashDanger('Invalid Offer.');
        }
        $partners = explode(',', $sellerDetails->partners);
        $partners = array_filter($partners);
        if (! in_array(Auth::id(), $partners) && $sellerDetails->saleOffer->owner_id != Auth::id() && $sellerDetails->offer_id != $id) {
            return redirect()->back()->withFlashDanger('You are not authorized to perform this action.');
        }

        $signButton = false;
        $message = null;
        $downloadBtn = false;
        //if main seller has signed
        if ($sellerDetails->saleOffer->signatures->contains('user_id', $sellerDetails->user_id)) {
            //if current logged in user has signed
            if ($sellerDetails->saleOffer->signatures->contains('user_id', Auth::id())) {
                //if contract documents are ready
                if ($sellerDetails->saleOffer->buyer_signature == config('constant.offer_signature.true') && $sellerDetails->saleOffer->seller_signature == config('constant.offer_signature.true')) {
                    $downloadBtn = true;
                } elseif ($sellerDetails->saleOffer->buyer_signature == config('constant.offer_signature.true') && $sellerDetails->saleOffer->seller_signature == config('constant.offer_signature.false')) {
                    //if all buyers have signed but not seller or his partner
                    $message = "Please wait for your co-singer's to sign the documents. ";
                }
            } else {
                //if main seller  has signed but not  current user who is a co-seller.
                $signButton = true;
            }
        } else {
            if ($sellerDetails->saleOffer->buyer_signature == config('constant.offer_signature.false')) {
                //if current user has signed but not other co-partner of property

                $message = 'Please wait for buyers to sign the documents. ';
            } else {
                $message = 'Please wait for property owner to sign the documents. ';
            }
        }

        $offerArray = [
            'offer_id' => $sellerDetails->saleOffer->id,
            'type' => $sellerDetails->saleOffer->property->property_type,
        ];

        SESSION::forget('PROPERTY');
        SESSION::forget('OFFER');
        Session::put('OFFER', $offerArray);
        Session::put('PROPERTY', $sellerDetails->saleOffer->property_id);

        return view('frontend.contract_tools.sale.sign_documents.sign_offers_sale_seller_partner', compact('signButton', 'message', 'downloadBtn'))->with(['offer' => $sellerDetails->saleOffer]);
    }
}
