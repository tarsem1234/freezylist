<?php

namespace App\Http\Controllers\Frontend\ContractTools;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\ContractTools\SaveLeadBasedPaintHazardsLandlordContractToolLandlordRequest;
use App\Http\Requests\Frontend\ContractTools\SdThankyouForReviewSummaryKeyTermsLandlordContractToolLandlordRequest;
use App\Http\Requests\Frontend\LandlordQuestionnaireRequest;
use App\Mail\Frontend\SaleAgreementLandlordMailing;
use App\Models\Access\User\User;
use App\Models\LandlordQuestionnaire;
use App\Models\Property;
use App\Models\PropertyConditionalData;
use App\Models\RentAgreement;
use App\Models\RentOffer;
use App\Models\RentSignature;
use App\Models\Signature;
use App\Models\Signer;
use App\Services\AgreementAddressService;
use App\Services\EmailLogService;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class ContractToolLandlordController extends Controller
{
    private function _forgetPropertyOffer()
    {
        SESSION::forget('PROPERTY');
        SESSION::forget('OFFER');
    }

    public function contractToolsRent(): View
    {
        return view('frontend.contract_tools.rent.contract_tools_rent');
    }

    public function questionsToLandlord(): View
    {
        $signers = Signer::where('from_user_id', Auth::id())->whereHas('invited_users')->with('invited_users')->get();
        $offerSession = Session::get('OFFER');

        $landlordQuestionnaire = LandlordQuestionnaire::where('user_id',
            Auth::id())
            ->where('offer_id', $offerSession['offer_id'])->first();

        // Used while sending the property id in email for adding new signer.
        $getProperty = RentOffer::select('property_id')->where('id', $offerSession['offer_id'])
            ->first();

        return view('frontend.contract_tools.rent.questions_to_landlord',
            compact('signers', 'landlordQuestionnaire', 'getProperty'));
    }

    public function addSignersContractRentLandlord(): View
    {
        return view('frontend.contract_tools.rent.add-signers-contract-rent-landlord');
    }

    public function thankYouToLandlordForAnswer(): View
    {
        $propertyData = Session::get('PROPERTY');
        $property = Property::where('id', $propertyData)
            ->where('user_id', Auth::id())->withTrashed()
            ->first();
        $lead = false;
        if (! empty($property->architechture->year_built) && $property->architechture->year_built < config('constant.year_built')) {
            $lead = true;

            return view('frontend.contract_tools.rent.thank_you_to_landlord_for_answer',
                compact('lead'));
        }

        return view('frontend.contract_tools.rent.thank_you_to_landlord_for_answer');
    }

    public function disclosuresRentContractTool($id = null): View
    {
        //        dd(Session::all());
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
        if (isset($property)) {
            $now = Carbon::now()->year;
            $from = $property->architechture->year_built;
            $diffInYears = $now - $from;

            return view('frontend.contract_tools.rent.disclosures_rent_contract_tool',
                compact('diffInYears', 'property'));
        }

        return view('frontend.contract_tools.rent.disclosures_rent_contract_tool');
    }

    public function thankyouDiscloserTool(): View
    {
        return view('frontend.contract_tools.rent.thankyou_discloser_tool');
    }

    public function leaseAgreement(): View
    {
        $offerArray = Session::get('OFFER');

        if ($offerArray['type'] == config('constant.inverse_property_type.Rent')) {
            $offer = RentOffer::where('id', $offerArray['offer_id'])
                ->with(['property' => function ($query) {
                    $query->withTrashed();
                }, 'property.propertyConditionDisclaimer' => function ($propertyCondDis) {
                    $propertyCondDis->select('best_knowledge_explain', 'partb_details',
                        'partc_details');
                }, 'landlordQuestionnaire', 'landlord' => function ($sellerQuery) {
                    $sellerQuery->with('user_profile',
                        'business_profile');
                }, 'tenant' => function ($buyerQuery) {
                    $buyerQuery->with('user_profile', 'business_profile');
                }, 'rent_counter_offers' => function ($query) {
                    $query->latest();
                }, 'rentAgreement'])->first();

            return view('frontend.contract_tools.rent.lease_agreement',
                compact('offer'));
        }

        return view('frontend.contract_tools.rent.lease_agreement');
    }

    public function saveLeaseAgreement(): RedirectResponse
    {
        $offerArray = Session::get('OFFER');
        $sender = getFullName(Auth::user());

        $existedRentAgreement = RentAgreement::where('rent_offer_id', $offerArray['offer_id'])
            ->with(['offer.landlord', 'offer.tenant', 'offer.landlordQuestionnaire', 'offer.property' => function ($query) {
                $query->withTrashed();
            }])->first();
        if ($existedRentAgreement) {
            $userName = getFullName($existedRentAgreement->offer->tenant);
            $emailBody = 'Hello '.$userName.', Property owner updated the rent agreement for the property which you have offered. Thank You';
            $emailSubject = 'Freezylist : Landlord Updated the Rent Agreement';
            $emailLinks = $this->_generateEmailLink($existedRentAgreement);
            $view = 'frontend.offer.landlord_rent_agreement_mail';
            Mail::send(new SaleAgreementLandlordMailing($existedRentAgreement->offer->tenant->email, $userName, $sender, $emailSubject, $emailBody, $emailLinks['viewOfferLink'], $emailLinks['propertyLink'], $view));

            $saveLog = new EmailLogService;

            $saveLog->saveLog($existedRentAgreement->offer->property->id, $existedRentAgreement->offer->buyer_id, $existedRentAgreement->offer->owner_id,
                $emailSubject, $emailBody,
                config('constant.property_type.'.$existedRentAgreement->offer->property->property_type),
                url()->previous());

            return redirect()->route('frontend.thankyouLeaseAgreementLandlord');
        }
        $rentAgreement = new RentAgreement;
        $rentAgreement->rent_offer_id = $offerArray['offer_id'];
        $rentAgreement->landlord_contract_tool_status = 1;

        if ($rentAgreement->save()) {
            $agreementAddress = new AgreementAddressService;
            $rentAgreement = $rentAgreement->where('rent_offer_id', $rentAgreement->rent_offer_id)
                ->with(['offer.landlord', 'offer.tenant', 'offer.landlordQuestionnaire', 'offer.property' => function ($query) {
                    $query->withTrashed();
                }])->first();

            $agreementAddress->saveAgreementAddress($rentAgreement, $type = 'landlord');

            $to = $rentAgreement->offer->tenant->email;
            $userName = getFullName($rentAgreement->offer->tenant);
            $emailBody = 'Hello '.$userName.', Property owner submitted the rent agreement for the property which you have offered. Thank You';
            $emailSubject = 'Freezylist : Landlord Submitted the Rent Agreement';
            $view = 'frontend.offer.landlord_rent_agreement_mail';
            $emailLinks = $this->_generateEmailLink($rentAgreement);
            $signupLink = null;
            Mail::send(new SaleAgreementLandlordMailing($to, $userName, $sender, $emailSubject, $emailBody, $emailLinks['viewOfferLink'], $emailLinks['propertyLink'], $view, $signupLink));

            $saveLog = new EmailLogService;
            $saveLog->saveLog($rentAgreement->offer->property->id, $rentAgreement->offer->buyer_id, $rentAgreement->offer->owner_id,
                $emailSubject, $emailBody,
                config('constant.property_type.'.$rentAgreement->offer->property->property_type),
                url()->previous());                                                             //Save auto email logs.

            return redirect()->route('frontend.thankyouLeaseAgreementLandlord');
        }

        return redirect()->back();
    }

    private function _generateEmailLink($rentAgreement)
    {
        $viewOfferLink = route('frontend.sent.view.offer',
            ['offer_id' => $rentAgreement->rent_offer_id,
                'type' => $rentAgreement->offer->property->property_type,
                'property_id' => $rentAgreement->offer->property->id,
                'owner_id' => $rentAgreement->offer->owner_id]);
        $propertyLink = route('frontend.propertyDetails',
            $rentAgreement->offer->property->id);

        return ['propertyLink' => $propertyLink, 'viewOfferLink' => $viewOfferLink];
    }

    public function thankyouLeaseAgreementLandlord(): View
    {
        $offerArray = Session::get('OFFER');
        $sender = getFullName(Auth::user());
        $existedRentAgreement = RentAgreement::where('rent_offer_id',
            $offerArray['offer_id'])
            ->with(['propertyContractUserAddresses' => function ($query) {
                $query->where('user_id', Auth::id());
            }, 'offer.landlord', 'offer.tenant', 'offer.landlordQuestionnaire', 'offer.tenantQuestionnaire'])->first();

        if (count($existedRentAgreement->propertyContractUserAddresses) > 0) {
            //            $this->_forgetPropertyOffer();
            return view('frontend.contract_tools.rent.thankyou_lease_agreement_landlord');
        }

        $agreement = new RentAgreement;
        $agreement->rent_offer_id = $offerArray['offer_id'];
        $agreement->landlord_contract_tool_status = 1;
        $agreement->save();

        $agreementAddress = new AgreementAddressService;
        $agreementAddress->saveAgreementAddress($existedRentAgreement,
            $type = 'tenant');

        $to = $existedRentAgreement->offer->tenant->email;
        $emailSubject = 'Freezylist : Landlord Reviewd the Rent Agreement';
        $userName = getFullName($existedRentAgreement->offer->tenant);
        $emailBody = 'Hello'.$userName.', '.$sender.' has reviewed property rent agreement. Thank You';
        $view = 'frontend.offer.tenant_rent_agreement_mail';
        $emailLinks = $this->_generateEmailLink($existedRentAgreement);

        Mail::send(new SaleAgreementLandlordMailing($to, $userName, $sender,
            $emailSubject, $emailBody, $emailLinks['viewOfferLink'],
            $emailLinks['propertyLink'], $view));

        $saveLog = new EmailLogService;
        $saveLog->saveLog($existedRentAgreement->offer->property->id,
            $existedRentAgreement->offer->buyer_id,
            $existedRentAgreement->offer->owner_id, $emailSubject, $emailBody,
            config('constant.property_type.'.$existedRentAgreement->offer->property->property_type),
            url()->previous());                                                             //Save auto email logs.

        //        $this->_forgetPropertyOffer();
        return view('frontend.contract_tools.rent.thankyou_lease_agreement_landlord');
    }

    public function saveQuestionsToLandlord(LandlordQuestionnaireRequest $request): RedirectResponse
    {
        $data = $request->all();
        //	dd($data);
        $offerArray = Session::get('OFFER');
        if ($request->id && LandlordQuestionnaire::where('id', $request->id)->where('user_id',
            Auth::id())->where('offer_id', $offerArray['offer_id'])->exists()) {
            $landlordQuestionnaire = LandlordQuestionnaire::find($request->id);
            if ($this->_prepareLandlordQuestionarieData($landlordQuestionnaire,
                $data, $offerArray)) {
                return redirect()->route('frontend.thankYouToLandlordForAnswer');
            }

            return redirect()->back()->with(['flash_warning' => 'Questions for landlord did not save.']);
        }

        $landlordQuestionnaire = new LandlordQuestionnaire;
        if ($this->_prepareLandlordQuestionarieData($landlordQuestionnaire,
            $data, $offerArray)) {
            return redirect()->route('frontend.thankYouToLandlordForAnswer');
        }

        return redirect()->back()->with(['flash_warning' => 'Questions for landlord did not save.']);
    }

    private function _prepareLandlordQuestionarieData($landlordQuestionnaire, $data, $offerArray)
    {
        //	dd(count($data['select-email']));
        if (! empty($data['effective_start_date'])) {
            $effectiveData = $data['effective_start_date'];
        } elseif ($data['effective']) {
            $effectiveData = $data['effective'];
        } else {
            $effectiveData = date('Y-m-d');
        }
        $landlordQuestionnaire->user_id = Auth::id();
        $landlordQuestionnaire->offer_id = $offerArray['offer_id'];
        $landlordQuestionnaire->security_deposit = $data['security_deposit'];
        $landlordQuestionnaire->pets_welcome = $data['pets_welcome'];
        $landlordQuestionnaire->effective_start_date = $effectiveData;
        $landlordQuestionnaire->furnishings = $data['furnishings'];
        $landlordQuestionnaire->utilities = $data['utilities'];
        $landlordQuestionnaire->joint_cowners = $data['joint_cowners'];
        $landlordQuestionnaire->require_cosigner = $data['require_cosigner'];

        if (isset($data['non_refundable_pet_deposit'])) {
            $landlordQuestionnaire->non_refundable_pet_deposit = $data['non_refundable_pet_deposit'];
        }
        if (isset($data['select-email']) && count($data['select-email']) > 0) {
            $landlordQuestionnaire->partners = implode(',', $data['select-email']);
        } else {
            $landlordQuestionnaire->partners = null;
        }
        //		dd($landlordQuestionnaire->partners);
        if ($landlordQuestionnaire->save()) {
            return true;
        }

        return false;
    }

    public function leadBasedPaintHazardsRent($id = null)
    {
        $offerData = Session::get('OFFER');
        if ($id && Property::where('id', $id)->where('user_id', Auth::id())->where('property_type',
            1)->withTrashed()) {
            $property = true;
            $offer = Property::where('id', $id)
                ->select('id', 'lead_based', 'lead_based_report', 'user_id')
                ->first();

            return view('frontend.contract_tools.rent.lead_based_paint_hazards_rent',
                compact('offer', 'property'));
        } elseif (Session::get('PROPERTY') && Property::where('id',
            Session::get('PROPERTY'))
            ->where('user_id', Auth::id())
            ->where('property_type', 1)->withTrashed()) {
            $offer = RentOffer::where('id', $offerData['offer_id'])
                ->with(['property' => function ($query) {
                    $query->select('id', 'lead_based',
                        'lead_based_report', 'user_id');
                    $query->withTrashed();
                }])->first();

            return view('frontend.contract_tools.rent.lead_based_paint_hazards_rent',
                compact('offer'));
        }

        return redirect()->back()->with(['flash_danger' => 'Something went wrong']);
    }

    public function saveLeadBasedPaintHazardsLandlord(SaveLeadBasedPaintHazardsLandlordContractToolLandlordRequest $request): RedirectResponse
    {

        $data = $request->all();
        if (isset($request->id) && $request->id) {
            $propertyId = $request->id;
        } else {
            $propertyId = Session::get('PROPERTY');
        }
        //        dump($propertyId);
        //        dd($data);
        $input['lead_based'] = $data['lead_based'];
        $input['lead_based_report'] = $data['lead_based_report'];

        if (Property::where('id', $propertyId)->where('user_id', Auth::id())->withTrashed()->update($input)) {
            if ($request->id) {

                return redirect()->route('frontend.property.rentsList');
            }

            return redirect()->route('frontend.disclosuresRentContractTool');
        }

        return redirect()->back();
    }

    //sign documents landlord

    public function sdSummaryKeyTermsForLandlord(Request $request): View
    {
        $offerSession = Session::get('OFFER');
        $offer = RentOffer::where('id', $offerSession['offer_id'])
            ->with(['property' => function ($subquery) {
                $subquery->withTrashed();
            }, 'property.propertyConditionDisclaimer' => function ($propertyCondDis) {
                $propertyCondDis->select('best_knowledge_explain', 'partb_details',
                    'partc_details');
            }, 'tenantQuestionnaire', 'landlordQuestionnaire',
                'landlord' => function ($sellerQuery) {
                    $sellerQuery->with('user_profile', 'business_profile');
                }, 'tenant' => function ($buyerQuery) {
                    $buyerQuery->with('user_profile', 'business_profile');
                }, 'rent_counter_offers' => function ($query) {
                    $query->latest();
                }, 'rentAgreement'])->first();

        return view('frontend.contract_tools.rent.sign_documents.landlord.sd_summary_key_terms_for_landlord',
            compact('offer'));
    }

    public function sdThankyouForReviewSummaryKeyTermsLandlord(SdThankyouForReviewSummaryKeyTermsLandlordContractToolLandlordRequest $request): View
    {
        $lead = false;
        $property = Property::where('id', Session::get('PROPERTY'))->with('architechture')->withTrashed()->first();
        if ($property->architechture->year_built < config('constant.year_built')) {
            $lead = true;

            return view('frontend.contract_tools.rent.sign_documents.landlord.sd_thank_you_for_review_summary_key_terms_Landlord',
                compact('lead'));
        }

        return view('frontend.contract_tools.rent.sign_documents.landlord.sd_thank_you_for_review_summary_key_terms_Landlord');
    }

    public function sdLeadBasedPaintHazardsDisclosureForRentByTenant(): View
    {
        $offerData = Session::get('OFFER');
        $offer = RentOffer::where('id', $offerData['offer_id'])
            ->with(['property' => function ($query) {
                $query->select('id', 'lead_based',
                    'lead_based_report', 'user_id');
                $query->withTrashed();
            }, 'rentSignatures' => function ($query) {
                $query->where('signature_type',
                    config('constant.inverse_signature_type_rent.lead based'));
            }])->first();

        return view('frontend.contract_tools.rent.sign_documents.landlord.sd_lead_based_paint_hazards_update_by_tenant', compact('offer'));
    }

    public function sdLeadBasedPaintHazardsDisclosureForRentByLandlord(): View
    {

        $offerData = Session::get('OFFER');
        $signature = RentSignature::where('offer_id', $offerData['offer_id'])->where('affix_status', 1)->first();
        $type = config('constant.inverse_signature_type_rent.lead based');
        if (! empty($signature)) {
            $offer = RentOffer::where('id', $offerData['offer_id'])
                ->with(['property' => function ($subquery) {
                    $subquery->withTrashed();
                }, 'propertyConditional' => function ($query) {
                    $query->select('id', 'lead_based',
                        'lead_based_report', 'user_id');
                }, 'rentSignatures'])->first();
        } else {
            $offer = RentOffer::where('id', $offerData['offer_id'])
                ->with(['property' => function ($query) {
                    $query->select('id', 'lead_based',
                        'lead_based_report', 'user_id');
                    $query->withTrashed();
                }, 'rentSignatures' => function ($query) {
                    $query->where('signature_type',
                        config('constant.inverse_signature_type_rent.lead based'));
                }])->first();
        }

        return view('frontend.contract_tools.rent.sign_documents.landlord.sd_lead_based_paint_hazards_update_by_landlord', compact('offer', 'signature', 'type'));
    }

    public function sdThankYouLandlordNecessaryForms(): View
    {
        return view('frontend.contract_tools.rent.sign_documents.landlord.sd_thank_you_landlord_for_necessary_forms');
    }

    public function sdDisclosuresRentLandlord($id = null)
    {
        $type = config('constant.inverse_signature_type_rent.property disclaimer');
        if (empty(Session::get('PROPERTY')) || empty(Session::get('OFFER'))) {
            return redirect()->route('frontend.sent.offers');
        }

        $propertyData = Session::get('PROPERTY');
        $offerArray = Session::get('OFFER');

        //check rent signature table having any entry corresponding to that offer.
        $signature = RentSignature::where('user_id', Auth::id())
            ->where('offer_id', $offerArray['offer_id'])
//                ->where('signature_type', config('constant.inverse_signature_type.property disclaimer'))
            ->first();
        $type = config('constant.inverse_signature_type_rent.property disclaimer');

        if (empty($signature)) {
            if (isset($propertyData) && $propertyData) {
                $property = Property::where('id', $propertyData)
                    ->with('architechture', 'disclosure')->withTrashed()->first();
            }

            $diffInYears = null;
            if (isset($property)) {
                $now = Carbon::now()->year;
                $from = $property->architechture->year_built;
                $diffInYears = $now - $from;

                $offer = RentOffer::where('id', $offerArray['offer_id'])
                    ->with(['tenant.user_profile', 'tenant.business_profile', 'landlord.user_profile',
                        'landlord.business_profile', 'property' => function ($query) {
                            $query->withTrashed();
                        }, 'rentSignatures' => function ($query) {
                            $query->where('signature_type', config('constant.inverse_signature_type_rent.property disclaimer'));
                        }])->first();

                return view('frontend.contract_tools.rent.sign_documents.tenant.sd_disclosures_rent_tenant', compact('diffInYears', 'property', 'offer', 'signature', 'type'));

            }
        }

        //signature exist then take the data form backups table 6-7-2019

        else {
            $property = PropertyConditionalData::where('offer_id', $offerArray['offer_id'])->where('property_id', $propertyData)
                ->with('architechture', 'disclosure')->first();
            $diffInYears = null;
            if (isset($property)) {
                $now = Carbon::now()->year;
                $from = $property->architechture->year_built;
                $diffInYears = $now - $from;

                $offer = null;
                if (! empty($offerArray)) {
                    $offer = RentOffer::where('id', $offerArray['offer_id'])
                        ->with(['tenant.user_profile', 'tenant.business_profile', 'landlord.user_profile',
                            'landlord.business_profile', 'propertyConditional', 'rentSignatures',
                        ])->first();
                    //                                        dd($offer);
                }
                $disclosureExtraData = true;

                return view('frontend.contract_tools.rent.sign_documents.landlord.sd_disclosures_rent_landlord',
                    compact('diffInYears', 'property', 'offer', 'disclosureExtraData', 'type'));
            }
        }

        return view('frontend.contract_tools.rent.sign_documents.landlord.sd_disclosures_rent_landlord');
    }

    public function sdThankYouLandlordForPd(): View
    {

        return view('frontend.contract_tools.rent.sign_documents.landlord.sd_thank_you_landlord_for_pd');
    }

    public function sdLeaseAgreementByLandlord(): View
    {
        $offerArray = Session::get('OFFER');
        $signature = '';
        if ($offerArray['type'] == config('constant.inverse_property_type.Rent')) {
            $signature = RentSignature::where('offer_id', $offerArray['offer_id'])->where('affix_status', 1)->first();
            $type = config('constant.inverse_signature_type_rent.rent agreement');
            if (! empty($signature)) {
                $offer = RentOffer::where('id', $offerArray['offer_id'])
                    ->with(['property' => function ($query) {
                        $query->withTrashed();
                    }, 'propertyConditional.disclosure' => function ($propertyCondDis) {
                        $propertyCondDis->select('best_knowledge_explain', 'partb_details',
                            'partc_details');
                    }, 'landlordQuestionnaire', 'rent_counter_offers' => function ($query) {
                        $query->latest();
                    }, 'rentAgreement', 'rentSignatures' => function ($query) {
                        //                            $query->groupBy('user_id');
                    }])->first();
            } else {
                $offer = RentOffer::where('id', $offerArray['offer_id'])
                    ->with(['property' => function ($query) {
                        $query->withTrashed();
                    }, 'property.propertyConditionDisclaimer' => function ($propertyCondDis) {
                        $propertyCondDis->select('best_knowledge_explain', 'partb_details',
                            'partc_details');
                    }, 'tenantQuestionnaire', 'landlordQuestionnaire', 'landlord' => function ($sellerQuery) {
                        $sellerQuery->with('user_profile',
                            'business_profile');
                    }, 'tenant' => function ($buyerQuery) {
                        $buyerQuery->with('user_profile', 'business_profile');
                    }, 'rent_counter_offers' => function ($query) {
                        $query->latest();
                    }, 'rentAgreement', 'rentSignatures' => function ($query) {
                        $query->where('signature_type',
                            config('constant.inverse_signature_type_rent.rent agreement'));
                    }])->first();

            }

            //        dd($offer);
            return view('frontend.contract_tools.rent.sign_documents.landlord.sd_lease_agreement_by_landlord',
                compact('offer', 'type', 'signature'));
        }

        return view('frontend.contract_tools.rent.sign_documents.landlord.sd_lease_agreement_by_landlord');
    }

    public function sdThankyouLeaseAgreementLandlord(): View
    {
        $offerData = Session::get('OFFER');

        $offer = RentOffer::where('id', $offerData['offer_id'])->with(['property' => function ($query) {
            $query->withTrashed();
        },
            'tenantQuestionnaire', 'landlordQuestionnaire', 'landlord', 'rentSignatures'])->first();

        $sender = getFullName(Auth::user());
        if (! empty($offer->landlordQuestionnaire->partners)) {
            //            $completed   = $incompleted = 0;
            $partners = explode(',', $offer->landlordQuestionnaire->partners);
            $count = 0;
            foreach ($partners as $partner) {
                $partnerProfile = getPartnerProfile($partner);
                //                $incomplete     = false;
                $signed = false;
                foreach ($offer->rentSignatures as $signature) {
                    if ($signature->user_id == $partner &&
                        $signature->signature_type == config('constant.inverse_signature_type_rent.rent agreement')) {
                        $count++;
                        $signed = true;
                    }
                }

                if ((! empty($partnerProfile->user_profile) && $partnerProfile->user_profile || ! empty($partnerProfile->business_profile) && $partnerProfile->business_profile)
                    && ! $signed) {
                    $to = $partnerProfile->email;
                    $userName = getFullName($partnerProfile);
                    $emailSubject = 'Freezylist : Landlord completed the sign document process';
                    $emailBody = 'Hello '.$userName.', '.$sender.' has signed property rent agreement. Please view and sign the documents. Thank You';
                    $view = 'frontend.offer.partner_contract_tool_rent_agreement_mail';
                    $emailLinks = $this->_generatePartnersEmailLink($offer);
                    Mail::send(new SaleAgreementLandlordMailing($to, $userName,
                        $sender, $emailSubject, $emailBody,
                        $emailLinks['viewOfferLink'],
                        $emailLinks['propertyLink'], $view));
                } else {
                    if ($partnerProfile->roles->first()->name == config('constant.user_type.3')) {
                        $signupLink = route('frontend.userCreate').'?code='.$partnerProfile->confirmation_code.'&time='.$partnerProfile->created_at;
                    } else {
                        $signupLink = route('frontend.businessCreate').'?code='.$partnerProfile->confirmation_code.'&time='.$partnerProfile->created_at;
                    }
                    $to = $partnerProfile->email;
                    $userName = getFullName($partnerProfile);
                    $emailSubject = 'Freezylist : Landlord completed the sign document process';
                    $emailBody = 'Hello '.$userName.', '.$sender.' has signed property rent agreement. Please complete your signup process and proceed with sign document process. Thank You';
                    $view = 'frontend.offer.partner_contract_tool_rent_agreement_mail';
                    $emailLinks = $this->_generatePartnersEmailLink($offer);
                    Mail::send(new SaleAgreementLandlordMailing($to, $userName,
                        $sender, $emailSubject, $emailBody,
                        $emailLinks['viewOfferLink'],
                        $emailLinks['propertyLink'], $view, $signupLink));
                }

                $saveLog = new EmailLogService;
                $saveLog->saveLog($offer->property->id, $offer->buyer_id,
                    $offer->owner_id, $emailSubject, $emailBody,
                    config('constant.property_type.'.$offer->property->property_type),
                    url()->previous());

                if ($count == count($partners)) {
                    RentOffer::where('id', $offer->id)->update(['landlord_signature' => '1']);
                    //mail send to landlord.
                    $to = $offer->tenant->email;
                    $userName = getFullName($offer->tenant);
                    $emailSubject = 'Freezylist : Landlord completed the sign document process';
                    $emailBody = 'Hello '.$userName.', '.$sender.' and their partner signed property rent agreement. Thank You';
                    $view = 'frontend.offer.tenant_completed_rent_agreement';
                    $emailLinks = $this->_generatePartnersEmailLink($offer);

                    $viewOfferLink = route('frontend.recieved.view.offer',
                        ['offer_id' => $offer->id,
                            'type' => config('constant.property_type.'.$offer->property->property_type),
                            'property_id' => $offer->property->id,
                            'owner_id' => $offer->owner_id]);
                    $emailLinks['viewOfferLink'] = $viewOfferLink;

                    Mail::send(new SaleAgreementLandlordMailing($to, $userName,
                        $sender, $emailSubject, $emailBody,
                        $emailLinks['viewOfferLink'],
                        $emailLinks['propertyLink'], $view));

                    $saveLog = new EmailLogService;
                    $saveLog->saveLog($offer->property->id, $offer->buyer_id,
                        $offer->owner_id, $emailSubject, $emailBody,
                        config('constant.property_type.'.$offer->property->property_type),
                        url()->previous());
                }
            }

            return view('frontend.contract_tools.rent.sign_documents.landlord.sd_thankyou_lease_agreement_landlord');
        } else {
            RentOffer::where('id', $offer->id)->update(['landlord_signature' => '1']);
            // mail to tenant for sign
            $to = $offer->tenant->email;
            $userName = getFullName($offer->tenant);
            $emailSubject = 'Freezylist : Landlord completed the sign document process';
            $emailBody = 'Hello '.$userName.', '.$sender.' has signed property rent agreement. Thank You';
            $view = 'frontend.offer.tenant_completed_rent_agreement';
            $emailLinks = $this->_generatePartnersEmailLink($offer);

            $viewOfferLink = route('frontend.recieved.view.offer',
                ['offer_id' => $offer->id,
                    'type' => config('constant.property_type.'.$offer->property->property_type),
                    'property_id' => $offer->property->id,
                    'owner_id' => $offer->owner_id]);
            $emailLinks['viewOfferLink'] = $viewOfferLink;

            Mail::send(new SaleAgreementLandlordMailing($to, $userName,
                $sender, $emailSubject, $emailBody,
                $emailLinks['viewOfferLink'],
                $emailLinks['propertyLink'], $view));

            $saveLog = new EmailLogService;
            $saveLog->saveLog($offer->property->id, $offer->buyer_id,
                $offer->owner_id, $emailSubject, $emailBody,
                config('constant.property_type.'.$offer->property->property_type),
                url()->previous());

        }

        //        $this->_forgetPropertyOffer();
        return view('frontend.contract_tools.rent.sign_documents.landlord.sd_thankyou_lease_agreement_landlord');
    }

    private function _generatePartnersEmailLink($offer)
    {
        $viewOfferLink = route('frontend.recieved.view.offer',
            ['offer_id' => $offer->id,
                'type' => config('constant.property_type.'.$offer->property->property_type),
                'property_id' => $offer->property->id,
                'owner_id' => $offer->owner_id]);
        $propertyLink = route('frontend.propertyDetails', $offer->property->id);

        return ['propertyLink' => $propertyLink, 'viewOfferLink' => $viewOfferLink];
    }

    public function signOffersRentLandlordPartner($id)
    {
        $landlordDetails = LandlordQuestionnaire::where('id', $id)->whereHas('rentOffer')->with(['rentOffer' => function ($query) {
            $query->with(['property' => function ($query) {
                $query->withTrashed();
            }, 'rentAgreement', 'property_owner_user' => function ($subquery) {
                $subquery->with(['business_profile', 'user_profile']);
            }, 'rent_counter_offers' => function ($query) {
                $query->latest();
            }, 'rentSignatures' => function ($signQuery) {
                $signQuery->where('signature_type', config('constant.inverse_signature_type_rent.rent agreement'));
            }, 'landlord' => function ($landlordQuery) {
                $landlordQuery->select('id', 'email')
                    ->with(['user_profile', 'business_profile']);
            }]);
        }])->first();
        if (empty($landlordDetails)) {
            return redirect()->back()->withFlashDanger('Invalid Offer.');
        }
        $partners = explode(',', $landlordDetails->partners);
        $partners = array_filter($partners);
        if (! in_array(Auth::id(), $partners) && $landlordDetails->rentOffer->owner_id != Auth::id() && $landlordDetails->offer_id != $id) {
            return redirect()->back()->withFlashDanger('You are not authorized to perform this action.');
        }

        $signButton = false;
        $message = null;
        $downloadBtn = false;
        //if main seller has signed
        if ($landlordDetails->rentOffer->rentSignatures->contains('user_id', $landlordDetails->user_id)) {
            //if current logged in user has signed
            if ($landlordDetails->rentOffer->rentSignatures->contains('user_id', Auth::id())) {
                //if contract documents are ready
                if ($landlordDetails->rentOffer->tenant_signature == config('constant.offer_signature.true') && $landlordDetails->rentOffer->landlord_signature == config('constant.offer_signature.true')) {
                    $downloadBtn = true;
                } elseif ($landlordDetails->rentOffer->tenant_signature == config('constant.offer_signature.true') && $landlordDetails->rentOffer->landlord_signature == config('constant.offer_signature.false')) {
                    //if all buyers have signed but not seller or his partner
                    $message = "Please wait for your co-singer's to sign the documents. ";
                }
            } else {
                //if main seller  has signed but not  current user who is a co-seller.
                $signButton = true;
            }
        } else {
            if ($landlordDetails->rentOffer->tenant_signature == config('constant.offer_signature.false')) {
                //if current user has signed but not other co-partner of property

                $message = 'Please wait for tenants to sign the documents. ';
            } else {
                $message = 'Please wait for property owner to sign the documents. ';
            }
        }

        $offerArray = [
            'offer_id' => $landlordDetails->rentOffer->id,
            'type' => $landlordDetails->rentOffer->property->property_type,
        ];

        SESSION::forget('PROPERTY');
        SESSION::forget('OFFER');
        Session::put('OFFER', $offerArray);
        Session::put('PROPERTY', $landlordDetails->rentOffer->property_id);
        Session::put('user_type', 'colandlord');

        return view('frontend.contract_tools.rent.sign_documents.landlord.sign_offers_rent_landlord_partner', compact('signButton', 'message', 'downloadBtn'))->with(['offer' => $landlordDetails->rentOffer]);
    }
}
