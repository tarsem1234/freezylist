<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\OfferRequest;
use App\Models\Access\User\User;
use App\Models\CounterRentOffer;
use App\Models\CounterSaleOffer;
use App\Models\Message;
use App\Models\Property;
use App\Models\RentOffer;
use App\Models\SaleOffer;
use App\Models\Signature;
use App\Notifications\Frontend\Auth\OfferShowsAcceptance;
use App\Services\EmailLogService;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class OfferController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        //        $categories = Category::latest()->get();
        //
        //        return view('frontend.learning_center.learning_center',
        //            ['categories' => $categories]);
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

    public function makeSaleOffer($id)
    {
        //        dd('here');
        if (Property::where('id', $id)->where('status', '=', config('constant.inverse_property_status.Unavailable'))->exists()) {
            return redirect()->route('frontend.sales-home')->withFlashDanger('Property is Deleted or Inactive by Seller.');
        }
        if (Property::where('id', $id)->get()->first() == null) {
            // dd('id');
            return redirect()->route('frontend.sales-home')->withFlashDanger('Property is Deleted by Seller.');
        }

        return view('frontend.offer.make_sale_offer', compact('id'));
    }

    public function makeRentOffer($id)
    {
        if (Property::where('id', $id)->where('status', '=', config('constant.inverse_property_status.Unavailable'))->exists()) {
            return redirect()->route('frontend.rents-home')->withFlashDanger('Property is Deleted or Inactived by Landlord.');
        }
        if (Property::where('id', $id)->get()->first() == null) {
            // dd('id');
            return redirect()->route('frontend.rents-home')->withFlashDanger('Property is Deleted by Seller.');
        }

        return view('frontend.offer.make_rent_offer', compact('id'));
    }

    public function saveOffer(OfferRequest $request): RedirectResponse
    {
        $data = $request->all();
        //        dd($data);
        if ($data['property_id']) {
            if (Property::where('id', $data['property_id'])->where('status', '=', config('constant.inverse_property_status.Unavailable'))->exists()) {
                return redirect()->route('frontend.index')->withFlashDanger('Property is deleted or Inactived by Seller.');
            }
            $notOwnProperty = Property::where('id', $data['property_id'])->where('user_id', Auth::id())->first();
            $existigProperty = Property::where('id', $data['property_id'])->with('rentOffer', 'saleOffer')->first();

            $senderData = User::where('id', Auth::id())->with(['user_profile',
                'business_profile'])->first();				      //find property sender data
            $ownerData = User::where('id', $existigProperty->user_id)->with([
                'user_profile', 'business_profile'])->first();		       //find property owner data
            // Check property owner
            if ($notOwnProperty && $notOwnProperty->id == $data['property_id']) {
                return redirect()->back()->with(['flash_warning' => 'Something went wrong, please try again.']);
            }

            if ($data['type'] == config('constant.property_type.2') && Auth::id() != $existigProperty->user_id) {
                if (SaleOffer::where('property_id', $existigProperty->id)
                    ->where('sender_id', Auth::id())
                    ->where(function ($saleQuery) {
                        $saleQuery->orWhere('status', config('constant.inverse_offer_status.pending'))
                            ->orWhere('status', config('constant.inverse_offer_status.accepted'));
                    })
                    ->exists()) {
                    return redirect()->back()->with(['flash_danger' => 'Offer already sent.']);
                }
                $this->_saveSaleOffer($data, $existigProperty, $senderData, $ownerData);		     // Save Sale Offer.

                return redirect()->route('frontend.sent.offers', '#Sale')->with(['flash_success' => 'Offer sent successfully.']);
            } elseif ($data['type'] == config('constant.property_type.1') && Auth::id() != $existigProperty->user_id) {
                if (RentOffer::where('property_id', $existigProperty->id)
                    ->where('buyer_id', Auth::id())
                    ->where(function ($saleQuery) {
                        $saleQuery->orWhere('status', config('constant.inverse_rent_offer_status.pending'))
                            ->orWhere('status', config('constant.inverse_rent_offer_status.accepted'));
                    })
                    ->exists()) {

                    return redirect()->back()->with(['flash_danger' => 'Offer already sent.']);
                }
                $pets_type = null;
                if (isset($data['pets_type']) && $data['pets_type'] != config('constant.pets_type.3')) {
                    $pets_type = implode(',', $data['pets_type']);
                }
                $offer = $this->_saveRentOffer($data, $existigProperty, $pets_type);		     // Save Rent Offer.
            }
            $sender = getFullName($senderData);
            $ownerName = getFullName($ownerData);
            $owner_id = $existigProperty->user_id;
            //                    $sender        = Auth::id();
            //                $to            = $data['email'];
            $profile = getPartnerProfile($existigProperty->user_id);
            $to = $profile->email;
            $viewOfferLink = route('frontend.recieved.view.offer.rent', ['offer_id' => $offer->id,
                'type' => config('constant.property_type.'.$existigProperty->property_type),
                'property_id' => $existigProperty->id,
                'owner_id' => $owner_id]);
            $propertyLink = route('frontend.propertyDetails', $existigProperty->id);

            $emailBody = 'You have recieved rent offer from'.$sender.'on your'.$propertyLink.' property. Please take appropriate action. To view offer click here.'.$viewOfferLink;
            $emailSubject = 'Freezylist : Offer Email For Your Property';
            try {
                Mail::send('frontend.offer.rent_offer_mail', ['viewOfferLink' => $viewOfferLink,
                    'propertyLink' => $propertyLink,
                    'ownerName' => $ownerName,
                    'sender' => $sender], function ($mg) use ($to, $emailSubject) {
                        $mg->to($to)
                            ->subject($emailSubject);
                    });
            } catch (Exception $e) {
                Log::error('failed to send email on offer id having error message'.$e->getMessage());
            }
            $saveLog = new EmailLogService;

            $saveLog->saveLog($existigProperty->id, $owner_id, Auth::id(), $emailSubject, $emailBody, config('constant.property_type.'.$existigProperty->property_type), url()->previous());						 //Save auto email logs.
            Message::logToDB($owner_id, $emailSubject);

            return redirect()->route('frontend.sent.offers', '#Rent')->with([
                'flash_success' => 'Offer sent successfully.']);
        }

        return redirect()->back()->with(['flash_danger' => 'Offer not sent.']);
    }

    private function _saveSaleOffer($data, $existigProperty, $senderData, $ownerData)
    {
        $offer = new SaleOffer;

        $offer->tentative_offer_price = $data['tentative_offer_price'];
        $offer->property_id = $data['property_id'];
        $offer->sender_id = Auth::id();
        $offer->owner_id = $existigProperty->user_id;
        $offer->agree = 1;
        $offer->percentage_of_price = $data['percentage_of_price'];
        $offer->fixed_amount = $data['fixed_amount'];
        $offer->contingencies_explain = $data['contingencies_explain'];
        $offer->source_of_cash = $data['source_of_cash'];
        $offer->optional_message = $data['optional_message'];

        if (isset($data['any_contingencies']) && in_array($data['any_contingencies'], config('constant.inverse_any_contingencies'))) {
            $offer->any_contingencies = config('constant.inverse_any_contingencies.'.$data['any_contingencies']);
        }

        if (isset($data['closing_cost_requested'])) {
            $offer->closing_cost_requested = config('constant.inverse_closing_cost_requested.'.$data['closing_cost_requested']);
        }
        if (isset($data['qualification_documents'])) {
            $offer->qualification_document = config('constant.inverse_qualification_documents.'.$data['qualification_documents']);
        }
        if ($data['qualification_documents'] == 'Pre Qualified' || $data['qualification_documents'] == 'Pre Approved') {
            if (! empty($data['userfile1'])) {
                $docPath = document_store($data['userfile1']);
                $offer->doc_path = $docPath;
            }
        }
        if ($offer->save()) {

            $sender = getFullName($senderData);
            $ownerName = getFullName($ownerData);
            $owner_id = $existigProperty->user_id;
            $profile = getPartnerProfile($existigProperty->user_id);
            $to = $profile->email;
            $viewOfferLink = route('frontend.recieved.view.offer', ['offer_id' => $offer->id,
                'type' => config('constant.property_type.'.$existigProperty->property_type),
                'property_id' => $existigProperty->id,
                'owner_id' => $owner_id]);
            $propertyLink = route('frontend.propertyDetails', $existigProperty->id);

            $emailBody = 'Congratulations '.$ownerName.'!You have recieved an offer on your sale property from'.$sender.'on your'.$propertyLink.' property. Time to take the next steps -> View your Offer Details and Negotiate. To view offer click here.'.$viewOfferLink;
            $emailSubject = 'Freezylist : Email Offer For Your Property';
            try {
                Mail::send('frontend.offer.sale_offer_mail', ['viewOfferLink' => $viewOfferLink,
                    'propertyLink' => $propertyLink,
                    'ownerName' => $ownerName,
                    'sender' => $sender], function ($mg) use ($to, $emailSubject) {
                        $mg->to($to)
                            ->subject($emailSubject);
                    });
            } catch (Exception $e) {
                Log::error('failed yto send email on offer id having error message'.$e->getMessage());
            }
            $saveLog = new EmailLogService;

            $saveLog->saveLog($existigProperty->id, $owner_id, Auth::id(), $emailSubject, $emailBody, config('constant.property_type.'.$existigProperty->property_type), url()->previous());
            Message::logToDB($ownerData->id, $emailSubject);

            return true;
        }

        return false;
    }

    private function _saveRentOffer($data, $existigProperty, $pets_type)
    {
        $offer = new RentOffer;
        $offer->rent_price = $data['rent_price'];
        $offer->property_id = $data['property_id'];
        $offer->buyer_id = Auth::id();
        $offer->owner_id = $existigProperty->user_id;
        $offer->name = $data['name'];
        $offer->email = $data['email'];
        $offer->phone = $data['phone'];
        $offer->lease_term = ! empty($data['lease_term']) ? implode(',', $data['lease_term']) : '';
        $offer->date_of_occupancy = $data['date_of_occupancy'];
        $offer->month_count = $data['month_count'];
        $offer->pets_welcome = config('constant.inverse_pets_welcome.'.$data['pets_welcome']);
        if (isset($pets_type)) {
            $offer->pets_type = $pets_type;
        }
        $offer->pet_other_explanation = $data['pet_other_explanation'];
        $offer->agree = 1;
        $offer->status = config('constant.inverse_offer_status.pending');
        $offer->save();

        return $offer;
    }

    public function sentOffers(): View
    {
        SESSION::forget('PROPERTY');
        SESSION::forget('OFFER');
        $saleOffers = SaleOffer::where('sender_id', Auth::id())
            ->with(['property' => function ($query) {
                $query->withTrashed();
            },
                'sale_counter_offers' => function ($query) {
                    $query->latest();
                }, 'property_sender_user' => function ($query) {
                    $query->with('user_profile')->with('business_profile');
                    $query->withTrashed();
                }, 'property_owner_user' => function ($subquery) {
                    $subquery->withTrashed();
                }])->latest()->paginate(config('constant.common_pagination'));
        $rentOffers = RentOffer::where('buyer_id', Auth::id())
            ->with(['property' => function ($query) {
                $query->withTrashed();
            }, 'rent_counter_offers' => function ($query) {
                $query->latest();
            }, 'sent_offer_user' => function ($query) {
                $query->with('user_profile', 'business_profile');
                $query->withTrashed();
            }, 'property_owner_user' => function ($subquery) {
                $subquery->withTrashed();
            }])->latest()->paginate(config('constant.common_pagination'));

        return view('frontend.offer.offer_send_details', ['rentOffers' => $rentOffers, 'saleOffers' => $saleOffers]);
    }

    public function recievedOffers(): View
    {
        SESSION::forget('PROPERTY');
        SESSION::forget('OFFER');
        $saleOffers = SaleOffer::where('owner_id', Auth::id())
            ->whereHas('property', function ($query) {
                $query->withTrashed();
            })
            ->with(['property' => function ($query) {
                $query->withTrashed();
            }, 'sale_counter_offers' => function ($query) {
                $query->latest();
            }, 'property_sender_user' => function ($query) {
                $query->with('user_profile')->with('business_profile');
                $query->withTrashed();
            }])->latest()->paginate(config('constant.common_pagination'));
        $rentOffers = RentOffer::where('owner_id', Auth::id())
            ->whereHas('property', function ($query) {
                $query->withTrashed();
            })
            ->with(['property' => function ($query) {
                $query->withTrashed();
            }, 'rent_counter_offers' => function ($query) {
                $query->latest();
            }, 'sent_offer_user' => function ($query) {
                $query->with('user_profile')->with('business_profile');
                $query->withTrashed();
            }])->latest()->paginate(config('constant.common_pagination'));

        return view('frontend.offer.offer_recieved_details', ['rentOffers' => $rentOffers, 'saleOffers' => $saleOffers]);
    }

    public function viewSentOfferRent(Request $request)
    {

        $message = null;
        $downloadButton = false;
        $signButton = false;
        $showContractToolsButton = false;
        $showNegotiationButton = false;
        $offer = RentOffer::where('id', $request->offer_id)
            ->whereHas('property', function ($query) {
                $query->where('property_type', config('constant.inverse_property_type.Rent'));
                $query->withTrashed();
            })->with(['property' => function ($query) {
                $query->withTrashed();
            }, 'tenantQuestionnaire', 'rentAgreement', 'rent_counter_offers' => function ($query) {
                $query->latest();
            },
                'rentSignatures' => function ($signQuery) {
                    $signQuery->where('user_id', Auth::id())
                        ->where('signature_type', config('constant.inverse_signature_type_rent.rent agreement'));
                },
                'property_owner_user' => function ($sellerQuery) {
                    $sellerQuery->with('user_profile', 'business_profile');
                    $sellerQuery->withTrashed();
                },
                'landlord' => function ($landlordQuery) {
                    $landlordQuery->select('id', 'email', 'phone_no', 'deleted_at', 'status')->withTrashed()
                        ->with(['user_profile', 'business_profile']);
                }])->first();
        if (empty($offer)) {
            return redirect()->back()->withFlashDanger('Invalid Offer.');
        } elseif ($offer->buyer_id != Auth::id() && $offer->owner_id != Auth::id()) {
            return redirect()->route('frontend.sent.offers')->withFlashDanger('You are not authorized to perform this action.');
        }

        if ($offer->status == config('constant.inverse_rent_offer_status.rejected_by_landlord')) {
            $message = 'Offer Rejected by Landlord';
        } elseif ($offer->status == config('constant.inverse_rent_offer_status.rejected_by_tenant')) {
            if ($offer->owner_id == Auth::id()) {
                $message = 'Offer Rejected by You';
            } else {
                $message = 'Offer Rejected by Tenant';
            }
        } elseif ($offer->status == config('constant.inverse_rent_offer_status.accepted')) {
            //if offer is accepted by any of parties
            if ($offer->landlord->hasRole(config('constant.inverse_user_type.Business'))) {
                $message = 'Your offer is accepted. Landlord will contact you for further process.';
            } elseif ($offer->tenant_signature == config('constant.offer_signature.true') && $offer->landlord_signature == config('constant.offer_signature.true')) {
                //if both parties have signed the documents show download button
                $downloadButton = true;
            } elseif ($offer->tenant_signature == config('constant.offer_signature.true') && $offer->landlord_signature == config('constant.offer_signature.false')) {
                //if all tenant has signed documnets but not all landlord parties
                $message = "Please wait for landlord's to sign the contract documents.";
            } elseif ($offer->tenant_signature == config('constant.offer_signature.false') && ! empty($offer->rentAgreement)) {
                //if sale agrement exists and all buyers has not signed the documents
                if ($offer->rentSignatures->isNotEmpty()) {
                    //if logged in buyer has signed the document but not his parties
                    $message = "Please wait for your co-singer's to sign the documents.";
                } elseif ($offer->rentSignatures->isEmpty()) {

                    if ($offer->buyer_id != Auth::id()) {
                        // if logged in user have not signed and is a cosigner
                        if (\App\Models\RentSignature::where('offer_id', $offer->id)->where('user_id', $offer->buyer_id)->where('signature_type', config('constant.inverse_signature_type_rent.rent agreement'))->exists()) {
                            //if main seller has signed document show sign button to co-signer
                            $signButton = true;
                        } else {

                            // if main buyer has not signed the document yet
                            $message = 'Please wait until property contract documents are prepared';
                        }
                    } elseif ($offer->buyer_id == Auth::id()) {
                        //                         if logged in user have not signed and is main buyer
                        if ($offer->rentAgreement->landlord_contract_tool_status == config('constant.contract_tool_status_inverse.True') && $offer->rentAgreement->tenant_contract_tool_status == config('constant.contract_tool_status_inverse.True')) {
                            $signature = \App\Models\RentSignature::where('offer_id', $offer->id)->where('user_id', $offer->buyer_id)->first();
                            //                            dd($signature);
                            if (! empty($signature)) {
                                $showContractToolsButton = false;
                            } else {
                                $showContractToolsButton = true;
                            }
                            $signButton = true;
                        } elseif ($offer->rentAgreement->landlord_contract_tool_status == config('constant.contract_tool_status_inverse.True') && $offer->rentAgreement->tenant_contract_tool_status == config('constant.contract_tool_status_inverse.False')) {
                            $showContractToolsButton = true;
                        }
                    }
                }
            } else {

                $message = 'Please wait until rent agreement documents are prepared';
            }
        } else {
            if ($offer->buyer_id == Auth::id() && $offer->status == config('constant.inverse_rent_offer_status.pending')) {
                if ($offer->rent_counter_offers->isEmpty()) {
                    $message = 'Please wait for landlord to take appropraite action on your offer.';
                } elseif ($offer->rent_counter_offers->isNotEmpty() && $offer->rent_counter_offers->first()->user_id != Auth::id()) {

                    //shoW offer accept reject negotiation
                    $showNegotiationButton = true;
                }
            } else {
                $message = 'Please wait until rent agreement documents are prepared';
            }
        }

        $offerArray = [
            'offer_id' => $offer->id,
            'type' => $offer->property->property_type,
        ];

        $this->_forgetPropertyOffer();
        $this->_setPropertyOffer($offerArray, $offer->property_id);

        return view('frontend.offer.sent_offer_rent_view', compact('offer', 'message', 'downloadButton', 'signButton', 'showContractToolsButton', 'showNegotiationButton'));
    }

    public function viewSentOffer(Request $request)
    {
        //$partners = [];
        //	if (Property::where('id', $request->property_id)->where('status', '=', config('constant.inverse_property_status.Unavailable'))->exists()) {
        //	    return redirect()->back()->withFlashDanger('Property is deleted or inactive by seller .');
        //	}
        $message = null;
        $downloadButton = false;
        $signButton = false;
        $showContractToolsButton = false;
        $showNegotiationButton = false;
        $offer = SaleOffer::where('id', $request->offer_id)
            ->whereHas('property', function ($query) {
                $query->where('property_type', config('constant.inverse_property_type.Sale'));
            })->with(['property', 'saleAgreement', 'sale_counter_offers' => function ($query) {
                $query->latest();
            }, 'signatures' => function ($signQuery) {
                $signQuery->where('user_id', Auth::id())
                    ->where('signature_type', config('constant.inverse_signature_type.sale agreement'));
            },
                'property_owner_user' => function ($sellerQuery) {
                    $sellerQuery->with('user_profile', 'business_profile');
                    $sellerQuery->withTrashed();
                },
                'seller' => function ($sellerQuery) {
                    $sellerQuery->select('id', 'email')
                        ->with(['user_profile', 'business_profile']);
                }])->first();
        //		    dd(Auth::id());
        if (empty($offer)) {
            return redirect()->back()->withFlashDanger('Invalid Offer.');
        } elseif ($offer->owner_id != Auth::id() && $offer->sender_id != Auth::id()) {
            return redirect()->route('frontend.sent.offers')->withFlashDanger('You are not authorized to perform this action.');
        }
        if ($offer->status == config('constant.inverse_offer_status.rejected_by_seller')) {
            $message = 'Offer Rejected by Seller';
        } elseif ($offer->status == config('constant.inverse_offer_status.rejected_by_buyer')) {
            if ($offer->sender_id == Auth::id()) {
                $message = 'Offer Rejected by You';
            } else {
                $message = 'Offer Rejected by Buyer';
            }
        } elseif ($offer->status == config('constant.inverse_offer_status.accepted')) {
            //if offer is accepted by any of parties
            if ($offer->property_owner_user->hasRole(config('constant.inverse_user_type.Business'))) {
                $message = 'Your offer is accepted. Property owner will contact you for further process.';
            } elseif ($offer->buyer_signature == config('constant.offer_signature.true') && $offer->seller_signature == config('constant.offer_signature.true')) {
                //if both parties have signed the documents show download button
                $downloadButton = true;
            } elseif ($offer->buyer_signature == config('constant.offer_signature.true') && $offer->seller_signature == config('constant.offer_signature.false')) {
                //if buyer has signed documnets but not all seller parties
                $message = "Please wait for seller's to sign the contract documents.";
            } elseif ($offer->buyer_signature == config('constant.offer_signature.false') && ! empty($offer->saleAgreement)) {
                //if sale agrement exists and all buyers has not signed the documents
                if ($offer->signatures->isNotEmpty()) {
                    //if logged in buyer has signed the document but not his parties
                    $message = "Please wait for your co-singer's to sign the documents.";
                } elseif ($offer->signatures->isEmpty()) {

                    if ($offer->sender_id != Auth::id()) {
                        // if logged in user have not signed and is a cosigner

                        if (Signature::where('offer_id', $offer->id)->where('user_id', $offer->sender_id)->where('signature_type', config('constant.inverse_signature_type.sale agreement'))->exists()) {
                            //if main seller has signed document show sign button to co-signer
                            $signButton = true;
                        } else {

                            // if main buyer has not signed the document yet
                            $message = 'Please wait until property contract documents are prepared';
                        }
                    } elseif ($offer->sender_id == Auth::id()) {
                        //                         if logged in user have not signed and is main buyer
                        if ($offer->saleAgreement->seller_contract_tool_status == config('constant.contract_tool_status_inverse.True') && $offer->saleAgreement->buyer_contract_tool_status == config('constant.contract_tool_status_inverse.True')) {
                            $signature = Signature::where('offer_id', $offer->id)->where('user_id', $offer->sender_id)->first();
                            //                            dd($signature);
                            if (! empty($signature)) {
                                $showContractToolsButton = false;
                            } else {
                                $showContractToolsButton = true;
                            }
                            $signButton = true;
                        } elseif ($offer->saleAgreement->seller_contract_tool_status == config('constant.contract_tool_status_inverse.True') && $offer->saleAgreement->buyer_contract_tool_status == config('constant.contract_tool_status_inverse.False')) {
                            $showContractToolsButton = true;
                        }
                    }
                }
            } else {
                //           $showContractToolsButton = TRUE;
                $message = 'Please wait until property contract documents are prepared';
            }
        } else {
            if ($offer->sender_id == Auth::id() && $offer->status == config('constant.inverse_offer_status.pending')) {
                if ($offer->sale_counter_offers->isEmpty()) {
                    $message = 'Please wait for property owner to take appropraite action on your offer.';
                } elseif ($offer->sale_counter_offers->isNotEmpty() && $offer->sale_counter_offers->first()->user_id != Auth::id()) {

                    //shoW offer accept reject negotiation
                    $showNegotiationButton = true;
                }
            } else {
                $message = 'Please wait until property contract documents are prepared';
            }
        }
        $offerArray = [
            'offer_id' => $offer->id,
            'type' => $offer->property->property_type,
        ];

        $this->_forgetPropertyOffer();
        $this->_setPropertyOffer($offerArray, $offer->property_id);

        return view('frontend.offer.sent_offer_sale_view', compact('offer', 'message', 'downloadButton', 'signButton', 'showContractToolsButton', 'showNegotiationButton'));
    }

    /**
     * seller side sale offer
     */
    public function viewRecievedOffer(Request $request): type
    {
        $offer_id = $request->offer_id;
        $message = null;
        $downloadButton = false;
        $signButton = false;
        $showContractToolsButton = false;
        $showNegotiationButton = false;
        $showOfferAceeptRejectButton = false;
        $buisnessuserPage = false;
        $offer = SaleOffer::where('id', $request->offer_id)
            ->whereHas('property', function ($query) {
                $query->where('property_type', config('constant.inverse_property_type.Sale'));
                $query->withTrashed();
            })->with(['property' => function ($query) {
                $query->withTrashed();
            }, 'buyerQuestionnaire', 'saleAgreement', 'sale_counter_offers' => function ($query) {
                $query->latest();
            },
                'signatures' => function ($signQuery) use ($offer_id) {
                    $signQuery->where('user_id', Auth::id())
                        ->where('offer_id', $offer_id);
                    //                                ->where('affix_status', 1);
                },
                'property_owner_user' => function ($sellerQuery) {
                    $sellerQuery->with('user_profile', 'business_profile');
                    $sellerQuery->withTrashed();
                },
                'buyer' => function ($buyerQuery) use ($offer_id) {
                    $buyerQuery->select('id', 'email', 'phone_no', 'deleted_at')->withTrashed()
                        ->with(['user_profile', 'business_profile'])
                        ->withCount(['signatures' => function ($buyserSignQuery) use ($offer_id) {
                            $buyserSignQuery->where('offer_id', $offer_id)->where('affix_status', 1);
                        }]);
                },
            ])->first();
        //		dd($offer);
        if (empty($offer)) {
            return redirect()->back()->withFlashDanger('Invalid Offer.');
        } elseif ($offer->owner_id != Auth::id() && $offer->sender_id != Auth::id()) {
            return redirect()->back()->withFlashDanger('You are not authorized to perform this action.');
        }

        if ($offer->status == config('constant.inverse_offer_status.rejected_by_seller')) {
            $message = 'Offer Rejected by Seller';
        } elseif ($offer->status == config('constant.inverse_offer_status.rejected_by_buyer')) {
            $message = 'Offer Rejected by Buyer';
        } elseif ($offer->status == config('constant.inverse_offer_status.accepted')) {
            //if offer is accepted by any of parties
            if ($offer->property_owner_user->hasRole(config('constant.inverse_user_type.Business')) && $offer->owner_id == Auth::id()) {
                $buisnessuserPage = true;
                $message = 'Please contact to Buyer for further process.';
            } elseif ($offer->buyer_signature == config('constant.offer_signature.true') && $offer->seller_signature == config('constant.offer_signature.true')) {
                //if both parties have signed the documents show download button
                $downloadButton = true;
            }

            //            If all buyers has signed the document but no one seller signed yet
            elseif ($offer->buyer_signature == config('constant.offer_signature.true') && $offer->seller_signature == config('constant.offer_signature.false')) {
                //if buyer has signed documnets but not all seller parties

                if ($offer->signatures->isNotEmpty()) {

                    if (count($offer->signatures) != $offer->buyer->signatures_count) {
                        $signButton = true;
                    } else {
                        $message = "Please wait for your co-signer's to sign the documents.";
                    }
                } else {
                    //                    if logged in user have not signed
                    if ($offer->signatures->isEmpty() && $offer->owner_id != Auth::id()) {
                        //                        if logged in user have not signed and is a cosigner
                        $message = 'Please wait until property contract documents are prepared';
                    } else {
                        //show signature to seller if he has not signed all the documnets
                        $signButton = true;
                    }
                }
            }
            //if sale agrement exists and all buyers has not signed the documents
            elseif ($offer->buyer_signature == config('constant.offer_signature.false') && ! empty($offer->saleAgreement) && $offer->saleAgreement->seller_contract_tool_status == config('constant.contract_tool_status_inverse.True')) {

                //           check is signature done on any of document corresponding to offer id ,then hide the contract button
                $checkSignature = Signature::where('offer_id', $offer_id)->where('affix_status', 1)->first();
                if (! empty($checkSignature)) {
                    $message = "Please wait for buyer's to sign the contract documents.";
                } else {
                    $showContractToolsButton = true;
                }
            } elseif ($offer->owner_id == Auth::id() && (empty($offer->saleAgreement) || (! empty($offer->saleAgreement) && $offer->saleAgreement->seller_contract_tool_status == config('constant.contract_tool_status_inverse.False')))) {
                //show contrat Tools button to seller
                $showContractToolsButton = true;
            }
        } else {

            if ($offer->owner_id == Auth::id() && $offer->status == config('constant.inverse_offer_status.pending') && $offer->sale_counter_offers->isEmpty()) {
                //shoW offer accept reject negotiation
                $showOfferAceeptRejectButton = true;
            } elseif ($offer->owner_id == Auth::id() && $offer->status == config('constant.inverse_offer_status.pending') && $offer->sale_counter_offers->isNotEmpty() && $offer->sale_counter_offers->first()->user_id != Auth::id()) {
                $showNegotiationButton = true;
            }
        }

        $offerArray = [
            'offer_id' => $offer->id,
            'type' => $offer->property->property_type,
        ];
        $this->_forgetPropertyOffer();			      //destroy previous session
        $this->_setPropertyOffer($offerArray, $offer->property_id);  //set session

        return view('frontend.offer.recieved_offer_view_sale', compact('offer', 'message', 'downloadButton', 'signButton', 'showContractToolsButton', 'showNegotiationButton', 'showOfferAceeptRejectButton', 'buisnessuserPage'));
    }

    //view landlord side offers for rent
    public function viewRecievedOfferRent(Request $request)
    {
        $message = null;
        $downloadButton = false;
        $signButton = false;
        $showContractToolsButton = false;
        $showNegotiationButton = false;
        $showOfferAceeptRejectButton = false;
        $buisnessuserPage = false;
        $offer_id = $request->offer_id;
        $offer = RentOffer::where('id', $request->offer_id)
            ->whereHas('property', function ($query) {
                $query->where('property_type', config('constant.inverse_property_type.Rent'));
                $query->withTrashed();
            })->with(['property' => function ($query) {
                $query->withTrashed();
            }, 'tenantQuestionnaire', 'rentAgreement', 'rent_counter_offers' => function ($query) {
                $query->latest();
            }, 'rentSignatures' => function ($signQuery) use ($offer_id) {
                $signQuery->where('user_id', Auth::id())
                    ->where('offer_id', $offer_id);
            },
                'property_owner_user' => function ($sellerQuery) {
                    $sellerQuery->with('user_profile', 'business_profile');
                    $sellerQuery->withTrashed();
                },
                'tenant' => function ($buyerQuery) use ($offer_id) {
                    $buyerQuery->select('id', 'email', 'phone_no', 'deleted_at')->withTrashed()
                        ->with(['user_profile', 'business_profile'])
                        ->withCount(['RentSignature' => function ($buyserSignQuery) use ($offer_id) {
                            $buyserSignQuery->where('offer_id', $offer_id)->where('affix_status', 1);
                        }]);
                },
            ])->first();
        //        $ifTenantPartnerExists = false;
        //        $ifLandlordPartnerExists = false;
        //        $tenantPartners = explode(',',$offer->tenantQuestionnaire->partners);
        //        $landlordPartners = explode(',',$offer->landlordQuestionnaire->partners);
        //        foreach($tenantPartners as $partner){
        //            if($partner == Auth::id()){
        //                $ifTenantPartnerExists = true;
        //            }
        //        }
        //        foreach($landlordPartners as $lPartner){
        //            if($lPartner == Auth::id()){
        //                $ifLandlordPartnerExists = true;
        //            }
        //        }
        //
        //        if (empty($offer)) {
        //            return redirect()->back()->withFlashDanger('Invalid Offer.');
        //        } elseif ($offer->owner_id != Auth::id()) {
        //            if(!$ifTenantPartnerExists && !$ifLandlordPartnerExists){
        //                return redirect()->back()->withFlashDanger('Unauthorized.');
        //            }
        //        }

        if (empty($offer)) {
            return redirect()->back()->withFlashDanger('Invalid Offer.');
        } elseif ($offer->owner_id != Auth::id() && $offer->buyer_id != Auth::id()) {
            return redirect()->back()->withFlashDanger('You are not authorized to perform this action.');
        }

        if ($offer->status == config('constant.inverse_rent_offer_status.rejected_by_landlord')) {
            if ($offer->owner_id == Auth::id()) {
                $message = 'Offer Rejected by You';
            } else {
                $message = 'Offer Rejected by Landlord';
            }
        } elseif ($offer->status == config('constant.inverse_rent_offer_status.rejected_by_tenant')) {
            $message = 'Offer Rejected by Buyer';
        } elseif ($offer->status == config('constant.inverse_rent_offer_status.accepted')) {
            //if offer is accepted by any of parties
            if ($offer->landlord->hasRole(config('constant.inverse_user_type.Business')) && $offer->owner_id == Auth::id()) {
                $buisnessuserPage = true;
                $message = 'Please contact to tenant for further process.';
            } elseif ($offer->tenant_signature == config('constant.offer_signature.true') && $offer->landlord_signature == config('constant.offer_signature.true')) {
                //if both parties have signed the documents show download button
                $downloadButton = true;
            } elseif ($offer->tenant_signature == config('constant.offer_signature.true') && $offer->landlord_signature == config('constant.offer_signature.false')) {
                //if tenant has signed documnets but not all seller parties

                if ($offer->rentSignatures->isNotEmpty()) {
                    //if logged in seller has signed the document but not his parties
                    if (count($offer->rentSignatures) != $offer->tenant->rent_signature_count) {
                        $signButton = true;
                    } else {
                        $message = "Please wait for your co-singer's to sign the documents.";
                    }
                } else {
                    //          if logged in user have not signed
                    if ($offer->rentSignatures->isEmpty() && ($offer->owner_id != Auth::id())) {
                        //                        if logged in user have not signed and is a cosigner
                        $message = 'Please wait until rent agreement documents are prepared';
                    } else {
                        //show signature to lanlord if he has not signed all the documnets
                        $signButton = true;
                    }
                }
            } elseif ($offer->tenant_signature == config('constant.offer_signature.false') && ! empty($offer->rentAgreement) && $offer->rentAgreement->landlord_contract_tool_status == config('constant.contract_tool_status_inverse.True')) {
                //if rent agrement exists and all buyers has not signed the documents
                $checkSignature = \App\Models\RentSignature::where('offer_id', $offer_id)->where('affix_status', 1)->first();
                if (! empty($checkSignature)) {
                    $message = "Please wait for tenant's to sign the contract documents.";
                } else {
                    $showContractToolsButton = true;
                }
                //                $showContractToolsButton = TRUE;
                //                $message = "Please wait for Tenant's to review & sign the contract documents.";
            } elseif ($offer->owner_id == Auth::id() && (empty($offer->rentAgreement) || (! empty($offer->rentAgreement) && $offer->rentAgreement->landlord_contract_tool_status == config('constant.contract_tool_status_inverse.False')) || (! empty($offer->rentAgreement) && $offer->rentAgreement->landlord_contract_tool_status == config('constant.contract_tool_status_inverse.True') && $offer->rentAgreement->landlord_contract_tool_status == config('constant.contract_tool_status_inverse.False') && empty($offer->tenantQuestionnaire)))) {
                //agrement does not exist show contrat Tools button to seller
                $showContractToolsButton = true;
            }
        } else {
            if ($offer->owner_id == Auth::id() && $offer->status == config('constant.inverse_rent_offer_status.pending') && $offer->rent_counter_offers->isEmpty()) {
                //shoW offer accept reject negotiation
                $showOfferAceeptRejectButton = true;
            } elseif ($offer->owner_id == Auth::id() && $offer->status == config('constant.inverse_rent_offer_status.pending') && $offer->rent_counter_offers->isNotEmpty() && $offer->rent_counter_offers->first()->user_id != Auth::id()) {
                $showNegotiationButton = true;
            }
        }

        $offerArray = [
            'offer_id' => $offer->id,
            'type' => $offer->property->property_type,
        ];
        $this->_forgetPropertyOffer();			      //destroy session
        $this->_setPropertyOffer($offerArray, $offer->property_id);  //set session

        return view('frontend.offer.recieved_offer_view_rent', compact('offer', 'message', 'downloadButton', 'signButton', 'showContractToolsButton', 'showNegotiationButton', 'showOfferAceeptRejectButton', 'buisnessuserPage'));
    }

    public function viewOffers(Request $request): View
    {
        $owner = User::where('id', $request->owner_id)->with('user_profile')->with('business_profile')->first();
        $offer = SaleOffer::where('id', $request->offer_id)->with('sale_counter_offers')->first();

        return view('frontend.offer.offer_view', ['offer' => $offer, 'owner' => $owner]);
    }

    public function acceptOffer($id, $propertyType): RedirectResponse
    {
        if (! empty($id) && ! empty($propertyType)) {
            if ($propertyType == config('constant.inverse_property_type.Rent')) {
                $rentOffer = $this->_getRentOffer($id);

                if (! empty($rentOffer)) {
                    if (RentOffer::where('id', $id)->update(['status' => config('constant.inverse_offer_status.accepted')])) {
                        //                        $rentOffer->landlord->notify(new OfferShowsAcceptance($rentOffer->tenant));

                        $tenantName = getFullName($rentOffer->tenant);
                        $to = $rentOffer->tenant->email;
                        $viewOfferLink = route('frontend.sent.view.offer', ['offer_id' => $rentOffer->id,
                            'type' => config('constant.property_type.'.$rentOffer->property->property_type),
                            'property_id' => $rentOffer->property->id,
                            'owner_id' => $rentOffer->owner_id]);
                        $propertyLink = route('frontend.propertyDetails', $rentOffer->property->id);

                        $emailBody = 'Your offer has been accepted. Please wait for the Landlord to make Contract Tool. To view offer click here.'.$viewOfferLink;
                        $emailSubject = 'Freezylist : Reply For Your Sent Offer';
                        try {
                            Mail::send('frontend.offer.accept_rent_offer_mail', ['viewOfferLink' => $viewOfferLink,
                                'propertyLink' => $propertyLink,
                                'tenantName' => $tenantName], function ($mg) use ($to, $emailSubject) {
                                    $mg->to($to)->subject($emailSubject);
                                });
                        } catch (Exception $e) {
                            Log::error('failed to send email on offer acceptance having error message'.$e->getMessage());
                        }

                        $saveLog = new EmailLogService;
                        $saveLog->saveLog($rentOffer->property->id, $rentOffer->owner_id, Auth::id(), $emailSubject, $emailBody, config('constant.property_type.'.$rentOffer->property->property_type), url()->previous());

                        Message::logToDB($rentOffer->tenant->id, $emailSubject);
                        //update status after the acceptance
                        Property::where('id', $rentOffer->property->id)->update(['status' => config('constant.inverse_property_status.In Progress')]);

                        if ($rentOffer->property_owner_user->hasRole(config('constant.inverse_user_type.Business'))) {

                            if (Auth::id() == $rentOffer->owner_id) {
                                return redirect()->route('frontend.BusinessContractTools')->with(['buyerDetails' => $rentOffer->sent_offer_user])->withFlashMessage('Offer has been accepted.');
                            } elseif (Auth::id() == $rentOffer->buyer_id) {
                                return redirect()->back()->withFlashMessage('Offer has been accepted.');
                            }
                        }

                        return redirect()->route('frontend.contractToolsRent')->withFlashMessage('Offer has been accepted.');
                    }

                    return redirect()->back()->withFlashDanger('Failed to accept offer.');
                }
            }

            if ($propertyType == config('constant.inverse_property_type.Sale')) {
                $saleOffer = $this->_getSaleOffer($id);

                if (! empty($saleOffer)) {
                    if (SaleOffer::where('id', $id)->update(['status' => config('constant.inverse_offer_status.accepted')])) {

                        //                        $saleOffer->buyer->notify(new OfferShowsAcceptance($saleOffer));
                        $buyerName = getFullName($saleOffer->buyer);
                        $to = $saleOffer->buyer->email;
                        $viewOfferLink = route('frontend.sent.view.offer', ['offer_id' => $saleOffer->id,
                            'type' => config('constant.property_type.'.$saleOffer->property->property_type),
                            'property_id' => $saleOffer->property->id,
                            'owner_id' => $saleOffer->owner_id]);
                        $propertyLink = route('frontend.propertyDetails', $saleOffer->property->id);

                        $emailBody = 'Your offer has been accepted. Please wait for the Seller to make Contract Tool. To view offer click here.'.$viewOfferLink;
                        $emailSubject = 'Freezylist : Reply For Your Sent Offer';
                        try {
                            Mail::send('frontend.offer.accept_sale_offer_mail', ['viewOfferLink' => $viewOfferLink,
                                'propertyLink' => $propertyLink,
                                'buyerName' => $buyerName], function ($mg) use ($to, $emailSubject) {
                                    $mg->to($to)->subject($emailSubject);
                                });
                        } catch (Exception $e) {
                            Log::error('failed to send email on offer acceptance having error message'.$e->getMessage());
                        }
                        //Save auto email logs.
                        $saveLog = new EmailLogService;
                        $saveLog->saveLog($saleOffer->property->id, $saleOffer->owner_id, Auth::id(), $emailSubject, $emailBody, config('constant.property_type.'.$saleOffer->property->property_type), url()->previous());

                        Message::logToDB($saleOffer->buyer->id, $emailSubject);
                        //update status after the acceptance
                        Property::where('id', $saleOffer->property->id)->update(['status' => config('constant.inverse_property_status.In Progress')]);

                        return redirect()->route('frontend.contractTools')->withFlashMessage('Offer has been accepted.');
                    }

                    return redirect()->back()->withFlashDanger('Failed to accept offer.');
                }
            }
        }

        return redirect()->back()->withFlashMessage('Invalid Offer.');
    }

    private function _getSaleOffer($id)
    {
        return SaleOffer::where('id', $id)
            ->where(function ($query) {
                $query->where('owner_id', Auth::id())->orWhere('sender_id', Auth::id());
            })
            ->whereHas('property', function ($query) {
                $query->where('property_type', config('constant.inverse_property_type.Sale'));
                $query->withTrashed();
            })
            ->with(['property' => function ($query) {
                $query->withTrashed();
            }, 'buyer', 'seller'])
            ->first();
    }

    private function _getRentOffer($id)
    {
        return RentOffer::where('id', $id)
            ->where(function ($query) {
                $query->where('owner_id', Auth::id())->orWhere('buyer_id', Auth::id());
            })
            ->whereHas('property', function ($query) {
                $query->where('property_type', config('constant.inverse_property_type.Rent'));
                $query->withTrashed();
            })
            ->with(['landlord', 'tenant', 'property' => function ($query) {
                $query->withTrashed();
            }])
            ->first();
    }

    public function rejectOffer($id, $propertyType): RedirectResponse
    {
        if (! empty($id) && ! empty($propertyType)) {

            if ($propertyType == config('constant.inverse_property_type.Rent')) {
                $rentOffer = $this->_getRentOffer($id);

                if (! empty($rentOffer)) {
                    $status = config('constant.inverse_rent_offer_status.rejected_by_tenant');
                    if ($rentOffer->owner_id == Auth::id()) {
                        $status = config('constant.inverse_rent_offer_status.rejected_by_landlord');
                    }
                    if (RentOffer::where('id', $id)->update(['status' => $status])) {

                        $viewOfferLink = route('frontend.sent.view.offer', ['offer_id' => $rentOffer->id,
                            'type' => config('constant.property_type.'.$rentOffer->property->property_type),
                            'property_id' => $rentOffer->property->id,
                            'owner_id' => $rentOffer->owner_id]);
                        $propertyLink = route('frontend.propertyDetails', $rentOffer->property->id);
                        $emailBody = 'Your offer has been rejected. To view offer click here.'.$viewOfferLink;
                        $emailSubject = 'Freezylist : Reply For Your Offer Rejection';

                        $name = getFullName($rentOffer->tenant);
                        $to = $rentOffer->tenant->email;
                        try {
                            Mail::send('frontend.offer.reject_rent_offer_mail', ['viewOfferLink' => $viewOfferLink,
                                'propertyLink' => $propertyLink,
                                'tenantName' => $name], function ($mg) use ($to, $emailSubject) {
                                    $mg->to($to)->subject($emailSubject);
                                });
                        } catch (Exception $e) {
                            Log::error('failed to send email on offer acceptance having error message'.$e->getMessage());
                        }

                        $saveLog = new EmailLogService;
                        $saveLog->saveLog($rentOffer->property->id, $rentOffer->owner_id, Auth::id(), $emailSubject, $emailBody, config('constant.property_type.'.$rentOffer->property->property_type), url()->previous());
                        Message::logToDB($rentOffer->tenant->id, $emailSubject);
                        //update status after rejection
                        Property::where('id', $rentOffer->property->id)->update(['status' => config('constant.inverse_property_status.Available')]);

                        return redirect()->route('frontend.recieved.offers')->withFlashMessage('Offer rejected successfully.');
                    }

                    return redirect()->back()->withFlashDanger('Failed to reject offer. Please try again.');
                }
            }

            if ($propertyType == config('constant.inverse_property_type.Sale')) {
                $saleOffer = $this->_getSaleOffer($id);

                if (! empty($saleOffer)) {

                    $status = config('constant.inverse_offer_status.rejected_by_buyer');
                    if ($saleOffer->owner_id == Auth::id()) {
                        $status = config('constant.inverse_offer_status.rejected_by_seller');
                    }

                    if (SaleOffer::where('id', $id)->update(['status' => $status])) {

                        $propertyLink = route('frontend.propertyDetails', $saleOffer->property->id);

                        $viewOfferLink = route('frontend.sent.view.offer', ['offer_id' => $saleOffer->id,
                            'type' => config('constant.property_type.'.$saleOffer->property->property_type),
                            'property_id' => $saleOffer->property->id,
                            'owner_id' => $saleOffer->owner_id]);
                        $emailBody = 'Your offer has been rejected. To view offer click here.'.$viewOfferLink;
                        $emailSubject = 'Freezylist : Reply For Your Offer Rejection';
                        $name = getFullName($saleOffer->buyer);
                        $to = $saleOffer->buyer->email;
                        try {
                            Mail::send('frontend.offer.accept_sale_offer_mail', ['viewOfferLink' => $viewOfferLink,
                                'propertyLink' => $propertyLink,
                                'buyerName' => $name], function ($mg) use ($to, $emailSubject) {
                                    $mg->to($to)->subject($emailSubject);
                                });
                        } catch (Exception $e) {
                            Log::error('failed to send email on offer acceptance having error message'.$e->getMessage());
                        }
                        $saveLog = new EmailLogService;
                        $saveLog->saveLog($saleOffer->property->id, $saleOffer->owner_id, Auth::id(), $emailSubject, $emailBody, config('constant.property_type.'.$saleOffer->property->property_type), url()->previous());
                        Message::logToDB($saleOffer->buyer->id, $emailSubject);
                        //update status after rejection
                        Property::where('id', $saleOffer->property->id)->update(['status' => config('constant.inverse_property_status.Available')]);

                        return redirect()->route('frontend.recieved.offers')->withFlashMessage('Offer rejected successfully.');
                    }

                    return redirect()->back()->withFlashDanger('Failed to reject offer. Please try again.');
                }
            }
        }

        return redirect()->back()->withFlashDanger('Invalid Offer.');
    }

    public function counterOffer(Request $request)
    {
        if ($request->property_type == config('constant.inverse_property_type.Rent')) {
            $offer = RentOffer::where('id', $request->offer_id)->whereHas('property', function ($query) {
                $query->withTrashed();
            })->first();
            if ($offer) {
                $counterOffer = new CounterRentOffer;
                $counterOffer->rent_offer_id = $request->offer_id;

                return $this->_counterOfferData($counterOffer, $request, $offer->property_id);
            }
        }
        if ($request->property_type == config('constant.inverse_property_type.Sale')) {

            $offer = SaleOffer::where('id', $request->offer_id)->whereHas('property', function ($query) {
                $query->withTrashed();
            })->first();
            if ($offer) {

                $counterOffer = new CounterSaleOffer;
                $counterOffer->sale_offer_id = $request->offer_id;

                return $this->_counterOfferData($counterOffer, $request, $offer->property_id);
            }
        }
    }

    private function _counterOfferData($counterOffer, $request, $propertyId)
    {
        //        dd($request->all());
        $this->validate($request, [
            'offer_price' => 'required',
        ]);
        $counterOffer->property_id = $propertyId;
        $counterOffer->counter_offer_price = $request->offer_price;
        $counterOffer->user_id = Auth::id();
        $counterOffer->status = config('constant.inverse_counter_offer_status.counter');
        if ($counterOffer->save()) {
            $propertyType = config('constant.inverse_property_type.Sale');
            $saleOffer = $this->_findSaleCounterOffer($request->offer_id);
            if (! empty($saleOffer)) {
                //                dd($saleOffer);
                if ($saleOffer->owner_id == $saleOffer->sale_counter_offers->first()->user_id) {
                    $type = 'sent';

                    $profile = getPartnerProfile($saleOffer->sender_id);
                } else {
                    $type = 'recieved';
                    $profile = getPartnerProfile($saleOffer->owner_id);
                }
                //                dd($profile);
                $this->_offerCounterEmail($saleOffer, $profile, $propertyType, $counterOffer->counter_offer_price, $type);
            }

            return redirect()->back()->withFlashMessage('Your offer has been sent.');
        }

        return redirect()->back()->withFlashMessage('Failed to send your offer.');
    }

    public function acceptCounterOffer($id, $propertyType): RedirectResponse
    {
        if (! empty($id) && ! empty($propertyType)) {
            if ($propertyType == config('constant.inverse_property_type.Rent')) {
                $rentOffer = $this->_findRentCounterOffer($id);

                if (! empty($rentOffer)) {
                    if (RentOffer::where('id', $id)->update(['status' => config('constant.inverse_rent_offer_status.accepted')]) &&
                            CounterRentOffer::where('id', $rentOffer->rent_counter_offers[0]->id)
                                ->update(['status' => config('constant.inverse_counter_offer_status.accepted')])) {

                        if ($rentOffer->owner_id == $rentOffer->rent_counter_offers->first()->user_id) {
                            $profile = getPartnerProfile($rentOffer->owner_id);
                        } else {
                            $profile = getPartnerProfile($rentOffer->buyer_id);
                        }
                        $this->_offerAcceptedEmail($rentOffer, $profile, $propertyType);
                        Property::where('id', $rentOffer->property->id)->update(['status' => config('constant.inverse_property_status.In Progress')]);
                        if ($rentOffer->buyer_id == Auth::id()) {
                            return redirect()->back()->withFlashMessage('Offer accepted successfully.');
                        }

                        return redirect()->route('frontend.contractToolsRent')->withFlashMessage('Offer accepted successfully.');
                    }

                    return redirect()->back()->withFlashDanger('Failed to accept offer.');
                }
            }
            if ($propertyType == config('constant.inverse_property_type.Sale')) {
                $saleOffer = $this->_findSaleCounterOffer($id);

                if (! empty($saleOffer)) {
                    if (SaleOffer::where('id', $id)->update(['status' => config('constant.inverse_offer_status.accepted')]) &&
                            CounterSaleOffer::where('id', $saleOffer->sale_counter_offers[0]->id)
                                ->update(['status' => config('constant.inverse_counter_offer_status.accepted')])) {

                        if ($saleOffer->owner_id == $saleOffer->sale_counter_offers->first()->user_id) {
                            $profile = getPartnerProfile($saleOffer->owner_id);
                        } else {
                            $profile = getPartnerProfile($saleOffer->sender_id);
                        }
                        Property::where('id', $saleOffer->property->id)->update(['status' => config('constant.inverse_property_status.In Progress')]);
                        $this->_offerAcceptedEmail($saleOffer, $profile, $propertyType);
                        if ($saleOffer->owner_id == Auth::id()) {
                            return redirect()->route('frontend.contractTools')->withFlashMessage('Offer accepted successfully.');
                        }

                        return redirect()->route('frontend.sent.offers')->withFlashMessage('Offer accepted successfully.');
                    }
                }
            }
        }

        return redirect()->back()->withFlashDanger('Invalid Offer.');
    }

    private function _offerAcceptedEmail($offer, $profile, $propertyType)
    {
        $sender = getFullName(Auth::user());
        $to = $profile->email;
        $ownerName = getFullName($profile);
        $viewOfferLink = route('frontend.recieved.view.offer', ['offer_id' => $offer->id,
            'type' => $propertyType,
            'property_id' => $offer->property_id,
            'owner_id' => $offer->owner_id]);
        $propertyLink = route('frontend.propertyDetails', $offer->property_id);

        $emailBody = 'Hello '.$ownerName.'! Your Counter offer has accepted on sale property by'.$sender.'on your'.$propertyLink.' To view offer click here.'.$viewOfferLink;
        $emailSubject = 'Freezylist : Counter Offer Acceptance.';

        try {
            Mail::send('frontend.offer.counter_offer_acceptance_mail', ['viewOfferLink' => $viewOfferLink,
                'propertyLink' => $propertyLink,
                'ownerName' => $ownerName,
                'sender' => $sender], function ($mg) use ($to, $emailSubject) {
                    $mg->to($to)->subject($emailSubject);
                });
        } catch (Exception $e) {
            Log::error('Failed to send email on offer id '.$offer->id.' having error message'.$e->getMessage());
        }
        $saveLog = new EmailLogService;

        $saveLog->saveLog($offer->property_id, $offer->owner_id, Auth::id(), $emailSubject, $emailBody, $propertyType, url()->previous());
        Message::logToDB($profile->id, $emailSubject);

        return true;
    }

    private function _offerRejectEmail($offer, $profile, $propertyType)
    {
        $sender = getFullName(Auth::user());
        $to = $profile->email;
        $ownerName = getFullName($profile);
        if ($propertyType == 'Rent') {
            $viewOfferLink = route('frontend.recieved.view.offer.rent', ['offer_id' => $offer->id,
                'type' => $propertyType,
                'property_id' => $offer->property_id,
                'owner_id' => $offer->owner_id]);
            $propertyLink = route('frontend.propertyDetails', $offer->property_id);
        } else {
            $viewOfferLink = route('frontend.recieved.view.offer', ['offer_id' => $offer->id,
                'type' => $propertyType,
                'property_id' => $offer->property_id,
                'owner_id' => $offer->owner_id]);
            $propertyLink = route('frontend.propertyDetails', $offer->property_id);
        }

        $emailBody = 'Hello '.$ownerName.'! Your Counter offer has accepted on sale property by'.$sender.'on your'.$propertyLink.' To view offer click here.'.$viewOfferLink;
        $emailSubject = 'Freezylist : Counter Offer Rejected.';

        try {
            Mail::send('frontend.offer.counter_offer_decline_mail', ['viewOfferLink' => $viewOfferLink,
                'propertyLink' => $propertyLink,
                'ownerName' => $ownerName,
                'sender' => $sender], function ($mg) use ($to, $emailSubject) {
                    $mg->to($to)->subject($emailSubject);
                });
        } catch (Exception $e) {
            Log::error('Failed to send email on offer id '.$offer->id.' having error message'.$e->getMessage());
        }
        $saveLog = new EmailLogService;

        $saveLog->saveLog($offer->property_id, $offer->owner_id, Auth::id(), $emailSubject, $emailBody, $propertyType, url()->previous());
        Message::logToDB($profile->id, $emailSubject);

        return true;
    }

    public function rejectCounterOffer($id, $propertyType): RedirectResponse
    {
        if (! empty($id) && ! empty($propertyType)) {
            if ($propertyType == config('constant.inverse_property_type.Rent')) {
                $rentOffer = $this->_findRentCounterOffer($id);
                if (! empty($rentOffer)) {
                    $status = config('constant.inverse_rent_offer_status.rejected_by_tenant');
                    if ($rentOffer->owner_id == Auth::id()) {
                        $status = config('constant.inverse_rent_offer_status.rejected_by_landlord');
                    }
                    if (RentOffer::where('id', $id)->update(['status' => $status]) &&
                            CounterRentOffer::where('id', $rentOffer->rent_counter_offers[0]->id)
                                ->update(['status' => config('constant.inverse_counter_offer_status.declined')])) {
                        if ($rentOffer->owner_id == $rentOffer->rent_counter_offers->first()->user_id) {
                            $profile = getPartnerProfile($rentOffer->owner_id);
                        } else {
                            $profile = getPartnerProfile($rentOffer->buyer_id);
                        }
                        $propertyType = 'Rent';
                        $this->_offerRejectEmail($rentOffer, $profile, $propertyType);

                        return redirect()->route('frontend.recieved.offers')->withFlashMessage('Offer has been rejected.');
                    }

                    return redirect()->back()->withFlashDanger('Failed to reject counter offer. Please try again.');
                }
            } elseif ($propertyType == config('constant.inverse_property_type.Sale')) {
                $saleOffer = $this->_findSaleCounterOffer($id);
                if (! empty($saleOffer)) {
                    $status = config('constant.inverse_offer_status.rejected_by_buyer');
                    if ($saleOffer->owner_id == Auth::id()) {
                        $status = config('constant.inverse_offer_status.rejected_by_seller');
                    }
                    if (SaleOffer::where('id', $id)->update(['status' => $status]) &&
                            CounterSaleOffer::where('id', $saleOffer->sale_counter_offers[0]->id)
                                ->update(['status' => config('constant.inverse_counter_offer_status.declined')])) {

                        if ($saleOffer->owner_id == $saleOffer->sale_counter_offers->first()->user_id) {
                            $profile = getPartnerProfile($saleOffer->owner_id);
                        } else {
                            $profile = getPartnerProfile($saleOffer->sender_id);
                        }
                        $propertyType = 'Sale';
                        $this->_offerRejectEmail($saleOffer, $profile, $propertyType);

                        return redirect()->route('frontend.recieved.offers')->withFlashMessage('Offer has been rejected.');
                    }
                }

                return redirect()->back()->withFlashDanger('Failed to reject counter offer. Please try again.');
            }
        }

        return redirect()->back()->withFlashDanger('Invalid Offer.');
    }

    private function _findRentCounterOffer($id)
    {
        return RentOffer::where('id', $id)
            ->whereHas('property', function ($query) {
                $query->where('property_type', config('constant.inverse_property_type.Rent'));
                $query->withTrashed();
            })
            ->whereHas('rent_counter_offers')
            ->with(['rent_counter_offers' => function ($query) {
                $query->orderByDesc('created_at')->first();
            }])
            ->first();
    }

    private function _findSaleCounterOffer($id)
    {
        return SaleOffer::where('id', $id)
            ->whereHas('property', function ($query) {
                $query->where('property_type', config('constant.inverse_property_type.Sale'));
                $query->withTrashed();
            })->whereHas('sale_counter_offers')
            ->with(['sale_counter_offers' => function ($query) {
                $query->orderByDesc('created_at')->first();
            }])
            ->first();
    }

    private function _offerCounterEmail($offer, $profile, $propertyType, $counterPrice, $type)
    {
        //        dd($offer);
        $sender = getFullName(Auth::user());
        $to = $profile->email;
        $ownerName = getFullName($profile);
        $viewOfferLink = route('frontend.'.$type.'.view.offer', ['offer_id' => $offer->id,
            'type' => $propertyType,
            'property_id' => $offer->property_id,
            'owner_id' => $offer->owner_id]);
        $propertyLink = route('frontend.propertyDetails', $offer->property_id);

        $emailBody = 'Hello '.$ownerName.','.$sender."! has counter the offer price $$counterPrice on sale property ".$propertyLink.' To view offer click here.'.$viewOfferLink;

        $emailSubject = 'Freezylist : Send Counter Offer';

        try {
            Mail::send('frontend.offer.send_counter_offer_mail', ['viewOfferLink' => $viewOfferLink,
                'propertyLink' => $propertyLink,
                'ownerName' => $ownerName,
                'counterPrice' => $counterPrice,
                'sender' => $sender], function ($mg) use ($to, $emailSubject) {
                    $mg->to($to)->subject($emailSubject);
                });
        } catch (Exception $e) {
            Log::error('Failed to send email on offer id '.$offer->id.' having error message'.$e->getMessage());
        }
        $saveLog = new EmailLogService;

        $saveLog->saveLog($offer->property_id, $offer->owner_id, Auth::id(), $emailSubject, $emailBody, $propertyType, url()->previous());
        Message::logToDB($profile->id, $emailSubject);

        return true;
    }
}
