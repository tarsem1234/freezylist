<?php

namespace App\Http\Controllers\Frontend\ContractTools;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\ContractTools\SaveLeadBasedPaintHazardsTenantContractToolTenantRequest;
use App\Http\Requests\Frontend\ContractTools\SdThankyouForReviewSummaryKeyTermsTenantContractToolTenantRequest;
use App\Http\Requests\Frontend\ContractTools\ThankYouForReviewSummaryKeyTermsContractToolTenantRequest;
use App\Http\Requests\Frontend\TenantQuestionnaireRequest;
use App\Mail\Frontend\SaleAgreementLandlordMailing;
use App\Models\Access\User\User;
use App\Models\Property;
use App\Models\PropertyConditionalData;
use App\Models\RentAgreement;
use App\Models\RentOffer;
use App\Models\RentSignature;
use App\Models\Signer;
use App\Models\TenantQuestionnaire;
use App\Services\AgreementAddressService;
use App\Services\EmailLogService;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class ContractToolTenantController extends Controller
{
    private function _forgetPropertyOffer()
    {
        SESSION::forget('PROPERTY');
        SESSION::forget('OFFER');
    }

    public function thankyouForRentOffer(): View
    {
        return view('frontend.contract_tools.rent.tenant.thankyou_for_rent_offer');
    }

    public function questionSetForTenant(): View
    {
        return view('frontend.contract_tools.rent.buyer.question_set_for_tenant');
    }

    public function addSignersContractRentTenant(): View
    {
        $signers = Signer::where('from_user_id', Auth::id())->with(['invited_users' => function ($query) {
            $query->withTrashed();
        }])->get();
        $offerSession = Session::get('OFFER');

        $tenantQuestionnaire = TenantQuestionnaire::where('user_id', Auth::id())
            ->where('rent_offer_id', $offerSession['offer_id'])->first();

        // Used while sending the property id in email for adding new signer.
        $getProperty = RentOffer::select('property_id')->where('id', $offerSession['offer_id'])
            ->first();

        return view('frontend.contract_tools.rent.buyer.add_signers_contract_rent_tenant',
            compact('signers', 'tenantQuestionnaire', 'getProperty'));
    }

    public function saveAddSignersContractRentTenant(TenantQuestionnaireRequest $request)
    {
        $offerSession = Session::get('OFFER');
        $data = $request->all();
        $tenantQuestion = TenantQuestionnaire::where('rent_offer_id', $offerSession['offer_id'])
            ->where('user_id', Auth::id())->first();

        if (! empty($tenantQuestion)) {
            return $this->_updateTenantQue($data, $offerSession);
        }
        $tenantQuestionnaire = new TenantQuestionnaire;
        $tenantQuestionnaire->user_id = Auth::id();
        $tenantQuestionnaire->rent_offer_id = $offerSession['offer_id'];
        $tenantQuestionnaire->joint_cowners = $data['joint_cowners'];
        if ($data['joint_cowners'] && ! empty($data['select-email'])) {
            $tenantQuestionnaire->partners = implode(',', $data['select-email']);
        }
        if ($tenantQuestionnaire->save()) {

            return redirect()->route('frontend.summaryKeyTermsForTenant');
        }

        return redirect()->back();
    }

    private function _updateTenantQue($data, $offerSession)
    {
        $tenantQuestionnaire['user_id'] = Auth::id();
        $tenantQuestionnaire['rent_offer_id'] = $offerSession['offer_id'];
        $tenantQuestionnaire['joint_cowners'] = $data['joint_cowners'];
        if ($data['joint_cowners'] == config('constant.inverse_common_yes_no.Yes')
            && isset($data['select-email']) && count($data['select-email']) > 0) {
            $tenantQuestionnaire['partners'] = implode(',',
                $data['select-email']);
        } else {
            $tenantQuestionnaire['partners'] = null;
        }
        if (TenantQuestionnaire::where('rent_offer_id',
            $offerSession['offer_id'])
            ->where('user_id', Auth::id())
            ->update($tenantQuestionnaire)) {

            return redirect()->route('frontend.summaryKeyTermsForTenant');
        }

        return redirect()->back();
    }

    public function summaryKeyTermsForTenant(): View
    {
        $offerSession = Session::get('OFFER');

        $offer = RentOffer::where('id', $offerSession['offer_id'])
            ->where('buyer_id', Auth::id())
            ->with(['property' => function ($subquery) {
                $subquery->withTrashed();
            }, 'property.propertyConditionDisclaimer' => function ($propertyCondDis) {
                $propertyCondDis->select('best_knowledge_explain', 'partb_details',
                    'partc_details');
            }, 'tenantQuestionnaire' => function ($query) {
                $query->latest();
            }, 'landlordQuestionnaire',
                'landlord' => function ($sellerQuery) {
                    $sellerQuery->with('user_profile', 'business_profile');
                }, 'tenant' => function ($buyerQuery) {
                    $buyerQuery->with('user_profile', 'business_profile');
                }, 'rent_counter_offers' => function ($query) {
                    $query->latest();
                }, 'rentAgreement'])->first();

        return view('frontend.contract_tools.rent.buyer.summary_key_terms_for_tenant',
            compact('offer'));
    }

    public function thankYouForReviewSummaryKeyTerms(ThankYouForReviewSummaryKeyTermsContractToolTenantRequest $request): View
    {
        $lead = false;
        $property = Property::where('id', Session::get('PROPERTY'))->with('architechture')->withTrashed()->first();
        if ($property->architechture->year_built < config('constant.year_built')) {
            $lead = true;

            return view('frontend.contract_tools.rent.buyer.thank_you_for_review_summary_key_terms',
                compact('lead'));
        }

        return view('frontend.contract_tools.rent.buyer.thank_you_for_review_summary_key_terms');
    }

    public function disclosuresRentContractToolReviewTenant($id = null)
    {
        if (empty(Session::get('PROPERTY'))) {
            return redirect()->route('frontend.sent.offers');
        }
        $propertyData = Session::get('PROPERTY');
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

            return view('frontend.contract_tools.rent.buyer.disclosures_rent_contract_tool_review_tenant',
                compact('diffInYears', 'property'));
        }

        return view('frontend.contract_tools.rent.buyer.disclosures_rent_contract_tool_review_tenant');
    }

    public function thankyouDiscloserToolTenant(): View
    {
        return view('frontend.contract_tools.rent.buyer.thankyou_discloser_tool_tenant');
    }

    public function thankYouLeadBasedDisclosureForRentTenant(): View
    {
        return view('frontend.contract_tools.rent.tenant.thank-you-lead-based-disclosure-for-rent-tenant');
    }

    public function saveLeadBasedPaintHazardsTenant(SaveLeadBasedPaintHazardsTenantContractToolTenantRequest $request): RedirectResponse
    {
        $epa = [1, 2];
        $data = $request->all();
        if (isset($data['epa']) && $data['epa']) {
            $input['epa'] = implode(',', $data['epa']);
        } else {
            $input['epa'] = null;
        }
        $input['opportunity'] = $data['opportunity'];
        if (RentOffer::where('id', Session::get('OFFER.offer_id'))->where('buyer_id',
            Auth::id())->update($input)) {
            Session::put('leadBased', true);

            return redirect()->route('frontend.thankYouLeadBasedDisclosureForRentTenant');
        }

        return redirect()->back();
    }

    public function leaseAgreementReviewTenant(): View
    {
        $offerArray = Session::get('OFFER');

        if ($offerArray['type'] == config('constant.inverse_property_type.Rent')) {
            $offer = RentOffer::where('id', $offerArray['offer_id'])
                ->with(['property' => function ($subquery) {
                    $subquery->withTrashed();
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

            return view('frontend.contract_tools.rent.buyer.lease_agreement_review_tenant',
                compact('offer'));
        }

        return view('frontend.contract_tools.rent.buyer.lease_agreement_review_tenant');
    }

    public function thankyouLeaseAgreementTenant()
    {
        $offerArray = Session::get('OFFER');
        $sender = getFullName(Auth::user());
        $existedRentAgreement = RentAgreement::where('rent_offer_id',
            $offerArray['offer_id'])
            ->with(['propertyContractUserAddresses' => function ($query) {
                $query->where('user_id', Auth::id());
            }, 'offer.landlord', 'offer.tenant', 'offer.landlordQuestionnaire', 'offer.property' => function ($subquery) {
                $subquery->withTrashed();
            }])->first();
        if ($existedRentAgreement) {
            if (count($existedRentAgreement->propertyContractUserAddresses) > 0) {
                //            $this->_forgetPropertyOffer();
                return view('frontend.contract_tools.rent.buyer.thankyou_lease_agreement_tenant');
            }
            RentAgreement::where('rent_offer_id', $existedRentAgreement->rent_offer_id)->update(['tenant_contract_tool_status' => '1']);
            //        $agreement                              = new RentAgreement;
            //        $agreement->rent_offer_id               = $offerArray['offer_id'];
            //        $agreement->tenant_contract_tool_status = 1;
            //        $agreement->save();

            $agreementAddress = new AgreementAddressService;
            $agreementAddress->saveAgreementAddress($existedRentAgreement, $type = 'tenant');

            $to = $existedRentAgreement->offer->landlord->email;
            $emailSubject = 'Freezylist : Tenant Reviewd the Rent Agreement';
            $userName = getFullName($existedRentAgreement->offer->landlord);
            $emailBody = 'Hello'.$userName.', Tenant has reviewed property rent agreement. Thank You';
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
            return view('frontend.contract_tools.rent.buyer.thankyou_lease_agreement_tenant');
        }

        return redirect()->back()->withFlashMessage('Something went wrong, please try later.');
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

    //sign documents
    public function sdThankyouForReviewSummaryKeyTermsTenant(SdThankyouForReviewSummaryKeyTermsTenantContractToolTenantRequest $request): View
    {
        $lead = false;
        $property = Property::where('id', Session::get('PROPERTY'))->with('architechture')->withTrashed()->first();
        if ($property->architechture->year_built < config('constant.year_built')) {
            $lead = true;

            return view('frontend.contract_tools.rent.sign_documents.tenant.sd_thank_you_for_review_summary_key_terms_tenant',
                compact('lead'));
        }

        return view('frontend.contract_tools.rent.sign_documents.tenant.sd_thank_you_for_review_summary_key_terms_tenant');
    }

    public function sdSummaryKeyTermsForTenant(Request $request): View
    {
        $offerSession = Session::get('OFFER');

        $offer = RentOffer::where('id', $offerSession['offer_id'])
            ->where(function ($query) {
                $query->where('buyer_id', Auth::id())
                    ->orWhereHas('tenantQuestionnaire', function ($subQuery) {
                        $subQuery->whereIn('partners', [Auth::id()]);
                    });
            })
            ->with(['property' => function ($subquery) {
                $subquery->withTrashed();
            }, 'property.propertyConditionDisclaimer' => function ($propertyCondDis) {
                $propertyCondDis->select('best_knowledge_explain', 'partb_details',
                    'partc_details');
            }, 'tenantQuestionnaire' => function ($query) {
                $query->latest();
            }, 'landlordQuestionnaire',
                'landlord' => function ($sellerQuery) {
                    $sellerQuery->with('user_profile', 'business_profile')->withTrashed();
                }, 'tenant' => function ($buyerQuery) {
                    $buyerQuery->with('user_profile', 'business_profile')->withTrashed();
                }, 'rent_counter_offers' => function ($query) {
                    $query->latest();
                }, 'rentAgreement'])->first();

        return view('frontend.contract_tools.rent.tenant.sd_summary_key_terms_for_tenant',
            compact('offer'));

    }

    private function _setPropertyOffer($offerArray, $propertyId = null)
    {
        Session::put('OFFER', $offerArray);
        Session::put('PROPERTY', $propertyId);
    }

    public function sdLeadBasedPaintHazardsDisclosureForRentByTenant(): View
    {
        $offerData = Session::get('OFFER');
        $signature = RentSignature::where('offer_id', $offerData['offer_id'])->where('affix_status', 1)->first();
        $type = config('constant.inverse_signature_type_rent.lead based');
        if (! empty($signature)) {
            $offer = RentOffer::where('id', $offerData['offer_id'])
                ->with(['property' => function ($squery) {
                    $squery->withTrashed();
                }, 'propertyConditional' => function ($query) {
                    $query->select('id', 'lead_based',
                        'lead_based_report', 'user_id');
                }, 'rentSignatures',
                    //                                'rentSignatures' => function($query) {
                    //                            $query->where('signature_type',
                    //                                config('constant.inverse_signature_type_rent.lead based'));
                    //                        }
                ])->first();
        } else {
            $offer = RentOffer::where('id', $offerData['offer_id'])
                ->with(['property' => function ($query) {
                    $query->select('id', 'lead_based',
                        'lead_based_report', 'user_id');
                    $query->withTrashed();
                }, 'rentSignatures' => function ($query) {
                    $query->where('signature_type',
                        config('constant.inverse_signature_type_rent.lead based'));
                },
                ])->first();
        }

        return view('frontend.contract_tools.rent.sign_documents.tenant.sd_lead_based_paint_hazards_update_by_tenant', compact('offer', 'signature', 'type'));
    }

    public function sdThankYouTenantNecessaryForms(): View
    {
        return view('frontend.contract_tools.rent.sign_documents.tenant.sd_thank_you_tenant_for_necessary_forms');
    }

    public function sdDisclosuresRentTenant($id = null)
    {
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

                return view('frontend.contract_tools.rent.sign_documents.tenant.sd_disclosures_rent_tenant', compact('diffInYears', 'property', 'offer', 'signature', 'type'));
            }
        }

        return view('frontend.contract_tools.rent.sign_documents.tenant.sd_disclosures_rent_tenant');
    }

    public function sdThankYouTenantForPd(): View
    {
        return view('frontend.contract_tools.rent.sign_documents.tenant.sd_thank_you_tenant_for_pd');
    }

    public function sdLeaseAgreementByTenant(): View
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
                    }, 'landlordQuestionnaire', 'landlord' => function ($sellerQuery) {
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

            return view('frontend.contract_tools.rent.sign_documents.tenant.sd_lease_agreement_by_tenant',
                compact('offer', 'signature', 'type'));
        }

        return view('frontend.contract_tools.rent.sign_documents.tenant.sd_lease_agreement_by_tenant');
    }

    public function sdThankyouLeaseAgreementTenant(): View
    {
        $offerData = Session::get('OFFER');

        $offer = RentOffer::where('id', $offerData['offer_id'])->with(['property' => function ($query) {
            $query->withTrashed();
        },
            'tenantQuestionnaire', 'landlord', 'rentSignatures'])->first();
        $sender = getFullName(Auth::user());
        if (! empty($offer->tenantQuestionnaire->partners)) {
            $completed = $incompleted = 0;
            $partners = explode(',', $offer->tenantQuestionnaire->partners);

            $count = 0;
            foreach ($partners as $partner) {

                $partnerProfile = getPartnerProfile($partner);
                $incomplete = false;
                $signed = false;
                foreach ($offer->rentSignatures as $signature) {
                    if ($signature->user_id == $partner &&
                        $signature->signature_type == config('constant.inverse_signature_type_rent.rent agreement')) {
                        $count++;
                        $signed = true;
                    }
                }

                if (($partnerProfile->user_profile || $partnerProfile->business_profile)
                    && ! $signed) {
                    $to = $partnerProfile->email;
                    $userName = getFullName($partnerProfile);
                    $emailSubject = 'Freezylist : Tenant completed the sign document process';
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
                    $emailSubject = 'Freezylist : Tenant completed the sign document process';
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
                    RentOffer::where('id', $offer->id)->update(['tenant_signature' => '1']);
                    //mail send to landlord.
                    $to = $offer->landlord->email;
                    $userName = getFullName($offer->landlord);
                    $emailSubject = 'Freezylist : Tenant completed the sign document process';
                    $emailBody = 'Hello '.$userName.', '.$sender.'and their partners signed property rent agreement. Please view and sign the documents. Thank You';
                    $view = 'frontend.offer.tenant_completed_rent_agreement';
                    $emailLinks = $this->_generatePartnersEmailLink($offer);

                    $viewOfferLink = route('frontend.recieved.view.offer.rent',
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

            return view('frontend.contract_tools.rent.sign_documents.tenant.sd_thankyou_lease_agreement_tenant');
        } else {
            RentOffer::where('id', $offer->id)->update(['tenant_signature' => '1']);
            $to = $offer->landlord->email;
            $userName = getFullName($offer->landlord);
            $emailSubject = 'Freezylist : Tenant completed the sign document process';
            $emailBody = 'Hello '.$userName.', '.$sender.'has signed property rent agreement. Thank You';
            $view = 'frontend.offer.tenant_completed_rent_agreement';
            $emailLinks = $this->_generatePartnersEmailLink($offer);

            $viewOfferLink = route('frontend.recieved.view.offer.rent',
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
        return view('frontend.contract_tools.rent.sign_documents.tenant.sd_thankyou_lease_agreement_tenant');
    }

    private function _generatePartnersEmailLink($offer)
    {
        $viewOfferLink = route('frontend.sent.view.offer',
            ['offer_id' => $offer->id,
                'type' => $offer->property->property_type,
                'property_id' => $offer->property->id,
                'owner_id' => $offer->owner_id]);
        $propertyLink = route('frontend.propertyDetails', $offer->property->id);

        return ['propertyLink' => $propertyLink, 'viewOfferLink' => $viewOfferLink];
    }

    private function _savesignature($request, $offerArray, $type1, $ip, $signature, $type)
    {
        //      ****************************************************
        $customArray1 = [];
        $cosellerArray = [];
        $cobuyerArray = [];
        $coseller = [];
        $cobuyer = [];
        $customArray2 = [];

        $offer = RentOffer::where('id', $offerArray['offer_id'])
            ->whereHas('property', function ($query) {
                $query->where('property_type', config('constant.inverse_property_type.Rent'));
                $query->withTrashed();
            })->with(['property' => function ($query) {
                $query->withTrashed();
            }, 'landlordQuestionnaire', 'tenantQuestionnaire',
            ])->first();
        $existSignature = RentSignature::where('offer_id', '=', $offerArray['offer_id'])->where('user_id', '=', Auth::id())->first();
        //        dd($existSignature);
        $buyersellerArray = [$offer->buyer_id, $offer->owner_id];
        //       create array for buyer and seller
        foreach ($buyersellerArray as $val) {
            if ($val == $offer->owner_id) {
                $type = '2';
                $affix_status = '0';
                $signature_type = 7;
            } elseif ($val == $offer->buyer_id) {
                $type = '1';
                $affix_status = '1';
                $signature_type = $type1;
            }
            if (! empty($existSignature)) {
                $fullName = $existSignature->fullname;
                $getsignature = $existSignature->signature;
                $address = $existSignature->address;
                $state = $existSignature->state_id;
                $county = $existSignature->county;
                $city = $existSignature->city;
                $zip_code = $existSignature->zip_code;
                $phone_no = $existSignature->phone_no;
            } else {
                $user = User::where('id', $val)->with('user_profile')->first();
                $fullName = getFullName($user);
                $getsignature = $user->user_profile['electronic_signature'];
                $address = $user->user_profile['address'];
                $state = $user->state_id;
                $county = $user->county;
                $city = $user->city;
                $zip_code = $user->zip_code;
                $phone_no = $user->phone_no;
            }
            $customArray1[] = ['id' => (int) $val, 'signature' => $getsignature, 'full_name' => $fullName, 'type' => $type, 'affix_status' => $affix_status, 'signature_type' => $signature_type, 'state_id' => $state, 'county' => $county, 'city' => $city, 'zip_code' => $zip_code, 'phone_no' => $phone_no, 'address' => $address];
        }

        if ($offer->landlordQuestionnaire->joint_cowners == config('constant.joint_coowner.Yes') && ! empty($offer->landlordQuestionnaire->partners)) {
            $coseller = explode(',', $offer->landlordQuestionnaire->partners);
        }
        if ($offer->tenantQuestionnaire->joint_cowners == config('constant.joint_coowner.Yes') && ! empty($offer->tenantQuestionnaire->partners)) {

            $cobuyer = explode(',', $offer->tenantQuestionnaire->partners);
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
                    $address = $existSignature->address;
                    $state = $existSignature->state_id;
                    $county = $existSignature->county;
                    $city = $existSignature->city;
                    $zip_code = $existSignature->zip_code;
                    $phone_no = $existSignature->phone_no;
                } else {
                    $user = User::where('id', $seller)
                        ->with('user_profile')->first();
                    $fullName = getFullName($user);
                    $getsignature = $user->user_profile['electronic_signature'];
                    $address = $user->user_profile['address'];
                    $state = $user->state_id;
                    $county = $user->county;
                    $city = $user->city;
                    $zip_code = $user->zip_code;
                    $phone_no = $user->phone_no;
                }
                $customArray2[] = ['id' => (int) $seller, 'signature' => $getsignature, 'full_name' => $fullName, 'type' => $type, 'affix_status' => $affix_status, 'signature_type' => $signature_type, 'state_id' => $state, 'county' => $county, 'city' => $city, 'zip_code' => $zip_code, 'phone_no' => $phone_no, 'address' => $address];
            }
        }
        //combine buyer,seller,cobuyer,coseller for saving in users conditional table
        $customSignatureArray = array_merge($customArray1, $customArray2);
        //**************************************************************
        //get data from different table for taking the backup
        $getPropertyData = Property::with(['disclosure', 'architechture' => function ($query) {
            $query->select('property_id', 'home_type', 'beds', 'baths', 'plot_size', 'home_size', 'describe_your_home', 'year_built', 'HOA_dues', 'total_rooms', 'stories', 'garage_capacity', 'additional_features', 'basement');
        }, 'additional_information', 'rentOffer',
        ])->where(['id' => $offer->property->id])->withTrashed()->first();

        if (! empty($existSignature)) {
            //            dd($existSignature);
            if ($existSignature->signature_type == 7) {
                $result = RentSignature::where('offer_id', '=', $offerArray['offer_id'])->where('user_id', '=', $existSignature->user_id)->where('signature_type', 7)->update(['affix_status' => 1, 'signature_type' => $type1]);
            } else {
                $customsignature = new RentSignature;
                $customsignature->offer_id = $existSignature->offer_id;
                $customsignature->user_id = Auth::id();
                $customsignature->type = $existSignature->type;
                $customsignature->fullname = $existSignature->fullname;
                $customsignature->signature = $existSignature->signature;
                $customsignature->signature_type = $type1;
                $customsignature->affix_status = 1;

                $customsignature->state_id = $existSignature->state_id;
                $customsignature->county = $existSignature->county;
                $customsignature->zip_code = $existSignature->zip_code;
                $customsignature->city = $existSignature->city;
                $customsignature->phone_no = $existSignature->phone_no;
                $customsignature->address = $existSignature->address;
                $customsignature->ip = $ip;
                $result = $customsignature->save();
            }
        } else {
            foreach ($customSignatureArray as $signatureArray) {
                $customsignature = new RentSignature;
                $customsignature->offer_id = $offerArray['offer_id'];
                $customsignature->user_id = $signatureArray['id'];
                $customsignature->type = $signatureArray['type'];
                $customsignature->fullname = $signatureArray['full_name'];
                $customsignature->signature = $signatureArray['signature'];
                $customsignature->signature_type = $signatureArray['signature_type'];
                $customsignature->affix_status = $signatureArray['affix_status'];

                $customsignature->state_id = $signatureArray['state_id'];
                $customsignature->county = $signatureArray['county'];
                $customsignature->zip_code = $signatureArray['zip_code'];
                $customsignature->city = $signatureArray['city'];
                $customsignature->phone_no = $signatureArray['phone_no'];
                $customsignature->address = $signatureArray['address'];

                $customsignature->ip = $ip;
                $result = $customsignature->save();
            }
        }
        if (! empty($result)) {

            //get signature data corresponding
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
                    //
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
                        $propertyConditionDisclaimer->user_id = $disclosureData['user_id'];
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
            $getSignatureData = RentSignature::where('offer_id', '=', $offerArray['offer_id'])->where('user_id', '=', Auth::id())->where('signature_type', '=', $type1)->first();

            return response(['success' => true, 'signature' => $getSignatureData]);
        } else {
            return response(['success' => false], 500);
        }

        //        $signatureNew                 = new RentSignature;
        //        $signatureNew->offer_id       = $offerArray['offer_id'];
        //        $signatureNew->user_id        = Auth::id();
        //        $signatureNew->signature_type = $type;
        //        $signatureNew->ip             = $ip;
        //        $signatureNew->signature      = $signature->user_profile->electronic_signature;
        //
        //        if ($signatureNew->save()) {
        //
        //            return response(['success' => true, 'signature' => $signatureNew],
        //                200);
        //        }
        //
        //        return response(['success' => false], 500);
    }

    public function disclaimerSignatureRent(Request $request)
    {
        $offerArray = Session::get('OFFER');
        $ip = \Request::ip();
        $signature = RentSignature::where('user_id', Auth::id())
            ->where('offer_id', $offerArray['offer_id'])
            ->where('signature_type',
                config('constant.inverse_signature_type_rent.property disclaimer'))
            ->first();
        if ($signature) {
            return response(['success' => true, 'signature' => $signature]);
        }
        $type = config('constant.inverse_signature_type_rent.property disclaimer');
        $signature = User::where('id', Auth::id())->first();

        return $this->_savesignature($request, $offerArray, $type, $ip, $signature,
            $type);
    }

    public function saleAgreementSignatureRent(Request $request)
    {
        $offerArray = Session::get('OFFER');
        $ip = \Request::ip();
        $signature = RentSignature::where('user_id', Auth::id())
            ->where('offer_id', $offerArray['offer_id'])
            ->where('signature_type',
                config('constant.inverse_signature_type_rent.rent agreement'))
            ->first();
        if ($signature) {
            return response(['success' => true, 'signature' => $signature]);
        }
        $type = config('constant.inverse_signature_type_rent.rent agreement');
        $signature = User::where('id', Auth::id())->first();

        return $this->_savesignature($request, $offerArray, $type, $ip, $signature,
            $type);
    }

    public function leadBasedSignatureRent(Request $request)
    {
        $offerArray = Session::get('OFFER');
        $ip = \Request::ip();
        $signature = RentSignature::where('user_id', Auth::id())
            ->where('offer_id', $offerArray['offer_id'])
            ->where('signature_type',
                config('constant.inverse_signature_type_rent.lead based'))
            ->first();
        if ($signature) {
            return response(['success' => true, 'signature' => $signature]);
        }
        $type = config('constant.inverse_signature_type_rent.lead based');
        $signature = User::where('id', Auth::id())->first();

        return $this->_savesignature($request, $offerArray, $type, $ip, $signature,
            $type);
    }

    public function signOffersRentTenantPartner($id)
    {
        $tenantDetails = TenantQuestionnaire::where('id', $id)->whereHas('rentOffer')->with(['rentOffer' => function ($query) {
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

        if (empty($tenantDetails)) {
            return redirect()->back()->withFlashDanger('Invalid Offer.');
        }
        $partners = explode(',', $tenantDetails->partners);
        $partners = array_filter($partners);
        if (! in_array(Auth::id(), $partners) && $tenantDetails->rentOffer->buyer_id != Auth::id() && $tenantDetails->offer_id != $id) {
            return redirect()->back()->withFlashDanger('You are not authorized to perform this action.');
        }

        $signButton = false;
        $message = null;
        $downloadBtn = false;
        //if main buyer has signed
        if ($tenantDetails->rentOffer->rentSignatures->contains('user_id', $tenantDetails->user_id)) {
            //if current logged in user has signed
            if ($tenantDetails->rentOffer->rentSignatures->contains('user_id', Auth::id())) {
                //if contract documents are ready
                if ($tenantDetails->rentOffer->tenant_signature == config('constant.offer_signature.true') && $tenantDetails->rentOffer->landlord_signature == config('constant.offer_signature.true')) {
                    $downloadBtn = true;
                } elseif ($tenantDetails->rentOffer->tenant_signature == config('constant.offer_signature.true') && $tenantDetails->rentOffer->landlord_signature == config('constant.offer_signature.false')) {
                    //if all buyers have signed but not seller or his partner
                    $message = "Please wait for property owner's to sign the documents. ";
                } elseif ($tenantDetails->rentOffer->tenant_signature == config('constant.offer_signature.false')) {
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
            'offer_id' => $tenantDetails->rentOffer->id,
            'type' => $tenantDetails->rentOffer->property->property_type,
        ];
        Session::put('user_type', 'cotenant');
        $this->_forgetPropertyOffer();
        $this->_setPropertyOffer($offerArray, $tenantDetails->rentOffer->property_id);

        return view('frontend.contract_tools.rent.sign_documents.tenant.sign_offers_rent_tenant_partner', compact('signButton', 'message', 'downloadBtn'))->with(['offer' => $tenantDetails->rentOffer]);
    }
}
