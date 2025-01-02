<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Models\PropertyConditionalData;
use App\Models\QuestionSellerPostClosing;
use App\Models\RentOffer;
use App\Models\RentSignature;
use App\Models\SaleOffer;
use App\Models\SellerQuestionnaire;
use App\Models\Signature;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

/*
 * updated : Remove where condition as per requirement i.e  after contact tool(document creation it should show in listing)
 *
 *  */
class MyDocumentsController extends Controller
{
    public function receivedDocuments(): View
    {
        $saleOffers = SaleOffer::where('sender_id', Auth::id())->whereHas('property', function ($type) {
            $type->where('property_type', config('constant.inverse_property_type.Sale'));
            $type->withTrashed();
        })->latest()->whereHas('saleAgreement')
//                        ->where('buyer_signature', 1)->where('seller_signature', 1)
            ->with(['property' => function ($query) {
                $query->withTrashed();
            },
                'property_owner_user' => function ($sellerQuery) {
                    $sellerQuery->with('user_profile', 'business_profile');
                    $sellerQuery->withTrashed();
                },
                'sale_counter_offers' => function ($query) {
                    $query->latest();
                }])
            ->get();

        $rentOffers = RentOffer::where('buyer_id', Auth::id())->whereHas('property', function ($type) {
            $type->where('property_type', config('constant.inverse_property_type.Rent'));
            $type->withTrashed();
        })->latest()->whereHas('rentAgreement')
//                        ->where('landlord_signature', 1)->where('tenant_signature', 1)
            ->with(['property' => function ($query) {
                $query->withTrashed();
            },
                'property_owner_user' => function ($sellerQuery) {
                    $sellerQuery->with('user_profile', 'business_profile');
                    $sellerQuery->withTrashed();
                },
                'rent_counter_offers' => function ($query) {
                    $query->latest();
                }])
            ->get();

        return view('frontend.my_documents.my-received-document', compact('saleOffers', 'rentOffers'));
    }

    public function sentDocuments(): View
    {
        $saleOffers = SaleOffer::where('owner_id', Auth::id())->whereHas('property', function ($type) {
            $type->where('property_type', config('constant.inverse_property_type.Sale'));
            $type->withTrashed();
        })->latest()->whereHas('saleAgreement')
//                        ->where('buyer_signature', 1)->where('seller_signature', 1)
            ->with(['property' => function ($query) {
                $query->withTrashed();
            },
                'property_sender_user' => function ($sellerQuery) {
                    $sellerQuery->with('user_profile', 'business_profile');
                    $sellerQuery->withTrashed();
                },
                'sale_counter_offers' => function ($query) {
                    $query->latest();
                }])
            ->get();
        $rentOffers = RentOffer::where(function ($query) {
            $query->where('owner_id', Auth::id());
        })->latest()->whereHas('rentAgreement')->whereHas('property', function ($type) {
            $type->where('property_type', config('constant.inverse_property_type.Rent'));
            $type->withTrashed();
        })
            ->with(['property' => function ($query) {
                $query->withTrashed();
            },
                'sent_offer_user' => function ($query) {
                    $query->with('user_profile', 'business_profile');
                    $query->withTrashed();
                },
                'property.architechture', 'rent_counter_offers' => function ($query) {
                    $query->latest();
                }])
            ->get();

        return view('frontend.my_documents.my-send-document', compact('saleOffers', 'rentOffers'));
    }

    public function sentDocumentDetailsSale(Request $request)
    {
        $page = 'sent';
        if ($request->type && $request->offer_id &&
                SaleOffer::where('id', $request->offer_id)->where('owner_id', Auth::id())->whereHas('property', function ($type) use ($request) {
                    $type->where('property_type', $request->type);
                })->exists()) {
            $sentDocuments = $this->_getSaleDocuments($request);
            $this->_setSession($sentDocuments);

            return view('frontend.my_documents.sent-documents-for-review-update', compact('sentDocuments', 'page'));
        }
        $offer = SaleOffer::where('id', $request->offer_id)->whereHas('property', function ($type) use ($request) {
            $type->where('property_type', $request->type);
        })->with('sellerQuestionnaire')->first();

        if ($offer->sellerQuestionnaire->partners) {
            $partners = explode(',', $offer->sellerQuestionnaire->partners);
            if (in_array(Auth::id(), $partners)) {
                $sentDocuments = SaleOffer::where('id', $request->offer_id)
                    ->whereHas('property', function ($type) use ($request) {
                        $type->where('property_type', $request->type);
                        $type->withTrashed();
                    })->with(['signatures' => function ($saleSignatures) {
                        $saleSignatures->where('user_id', Auth::id());
                    }, 'property' => function ($query) {
                        $query->withTrashed();
                    }])->first();
                $this->_setSession($sentDocuments);

                return view('frontend.my_documents.sent-documents-for-review-update', compact('sentDocuments', 'page'));
            }
        }

        return redirect()->back();
        //        dd($sentDocuments->toArray());
        //        return view('frontend.my_documents.documents-for-download-by-owner', compact('sentDocuments'));
    }

    public function receivedDocumentDetailsSale(Request $request)
    {
        $page = 'received';
        if ($request->type && $request->offer_id &&
                SaleOffer::where('id', $request->offer_id)->where('sender_id', Auth::id())->whereHas('property', function ($type) use ($request) {
                    $type->where('property_type', $request->type);
                    $type->withTrashed();
                })->exists()) {
            $sentDocuments = $this->_getSaleDocuments($request);
            //dd($sentDocuments);die;
            $this->_setSession($sentDocuments);

            //            dd($sentDocuments);
            return view('frontend.my_documents.sent-documents-for-review-update', compact('sentDocuments', 'page'));
        }

        $offer = SaleOffer::where('id', $request->offer_id)->whereHas('property', function ($type) use ($request) {
            $type->where('property_type', $request->type);
            $type->withTrashed();
        })->with('buyerQuestionnaire')->first();

        if ($offer->buyerQuestionnaire->partners) {
            $partners = explode(',', $offer->buyerQuestionnaire->partners);
            if (in_array(Auth::id(), $partners)) {
                $sentDocuments = SaleOffer::where('id', $request->offer_id)
                    ->whereHas('property', function ($type) use ($request) {
                        $type->where('property_type', $request->type);
                        $type->withTrashed();
                    })->with(['signatures' => function ($saleSignatures) {
                        $saleSignatures->where('user_id', Auth::id());
                    }, 'property' => function ($query) {
                        $query->withTrashed();
                    }])->first();

                return view('frontend.my_documents.sent-documents-for-review-update', compact('sentDocuments', 'page'));
            }
        }

        return redirect()->back();
    }

    public function sentDocumentDetailsRent(Request $request)
    {
        $page = 'sent';
        if ($request->type && $request->offer_id &&
                RentOffer::where('id', $request->offer_id)->where('owner_id', Auth::id())->whereHas('property', function ($type) use ($request) {
                    $type->where('property_type', $request->type);
                    $type->withTrashed();
                })->exists()) {
            $sentDocuments = $this->_getRentDocuments($request);
            $this->_setSession($sentDocuments);
            $rent = true;

            return view('frontend.my_documents.documents-for-review-update-rent', compact('sentDocuments', 'rent', 'page'));
        }
        $offer = RentOffer::where('id', $request->offer_id)->whereHas('property', function ($type) use ($request) {
            $type->where('property_type', $request->type);
        })->with('landlordQuestionnaire')->first();

        if ($offer->landlordQuestionnaire->partners) {
            $partners = explode(',', $offer->landlordQuestionnaire->partners);
            if (in_array(Auth::id(), $partners)) {
                $sentDocuments = RentOffer::where('id', $request->offer_id)
                    ->whereHas('property', function ($type) use ($request) {
                        $type->where('property_type', $request->type);
                        $type->withTrashed();
                    })->with(['rentSignatures' => function ($rentSignatures) {
                        $rentSignatures->where('user_id', Auth::id());
                    }, 'property' => function ($query) {
                        $query->withTrashed();
                    }])->first();
                $rent = true;
                $this->_setSession($sentDocuments);

                return view('frontend.my_documents.documents-for-review-update-rent', compact('sentDocuments', 'rent', 'page'));
            }
        }

        return redirect()->back();
    }

    private function _setSession($sentDocuments)
    {
        $offerArray = [
            'offer_id' => $sentDocuments->id,
            'type' => $sentDocuments->property->property_type,
        ];
        Session::put('OFFER', $offerArray);
        Session::put('PROPERTY', $sentDocuments->property_id);
    }

    public function receivedDocumentDetailsRent(Request $request)
    {
        $page = 'received';
        if ($request->type && $request->offer_id &&
                RentOffer::where('id', $request->offer_id)->where('buyer_id', Auth::id())->whereHas('property', function ($type) use ($request) {
                    $type->where('property_type', $request->type);
                    $type->withTrashed();
                })->exists()) {
            $sentDocuments = $this->_getRentDocuments($request);
            $this->_setSession($sentDocuments);
            $rent = true;

            return view('frontend.my_documents.documents-for-review-update-rent', compact('sentDocuments', 'rent', 'page'));
        }

        $offer = RentOffer::where('id', $request->offer_id)->whereHas('property', function ($type) use ($request) {
            $type->where('property_type', $request->type);
            $type->withTrashed();
        })->with('tenantQuestionnaire', 'landlordQuestionnaire')->first();

        if ($offer->tenantQuestionnaire->partners) {
            $partners = explode(',', $offer->tenantQuestionnaire->partners);
            if (in_array(Auth::id(), $partners)) {
                $sentDocuments = RentOffer::where('id', $request->offer_id)
                    ->whereHas('property', function ($type) use ($request) {
                        $type->where('property_type', $request->type);
                        $type->withTrashed();
                    })->with(['rentSignatures' => function ($rentSignatures) {
                        $rentSignatures->where('user_id', Auth::id());
                    }, 'property' => function ($query) {
                        $query->withTrashed();
                    }])->first();
                $rent = true;

                return view('frontend.my_documents.documents-for-review-update-rent', compact('sentDocuments', 'rent', 'page'));
            }
        }
        if ($offer->landlordQuestionnaire->partners) {
            $partners = explode(',', $offer->landlordQuestionnaire->partners);
            if (in_array(Auth::id(), $partners)) {
                $sentDocuments = RentOffer::where('id', $request->offer_id)
                    ->whereHas('property', function ($type) use ($request) {
                        $type->where('property_type', $request->type);
                        $type->withTrashed();
                    })->with(['rentSignatures' => function ($rentSignatures) {
                        $rentSignatures->where('user_id', Auth::id());
                    }, 'property' => function ($query) {
                        $query->withTrashed();
                    }])->first();
                $rent = true;

                return view('frontend.my_documents.documents-for-review-update-rent', compact('sentDocuments', 'rent'));
            }
        }

        return redirect()->back();
    }

    public function sentDocumentDetails(Request $request)
    {
        if ($request->type && $request->offer_id &&
                SaleOffer::where('id', $request->offer_id)->where('owner_id', Auth::id())->whereHas('property', function ($type) use ($request) {
                    $type->where('property_type', $request->type);
                    $type->withTrashed();
                })->exists()) {
            $sentDocuments = $this->_getSaleDocuments($request);

            return view('frontend.my_documents.documents-for-download-by-owner', compact('sentDocuments'));
        }

        return redirect()->back();
    }

    public function downloadDocumentsSale(Request $request)
    {
        if ($request->type && $request->offer_id &&
                SaleOffer::where('id', $request->offer_id)->where(function ($query) {
                    $query->orWhere('sender_id', Auth::id())->orWhere('owner_id', Auth::id());
                })->whereHas('property', function ($type) use ($request) {
                    $type->where('property_type', $request->type);
                    $type->withTrashed();
                })->exists()) {
            $sentDocuments = $this->_getSaleDocuments($request);

            return view('frontend.my_documents.documents-for-review-update-by-owner', compact('sentDocuments'));
        }

        $offer = SaleOffer::where('id', $request->offer_id)->whereHas('property', function ($type) use ($request) {
            $type->where('property_type', $request->type);
            $type->withTrashed();
        })->with('buyerQuestionnaire', 'sellerQuestionnaire')->first();

        if ($offer->sellerQuestionnaire->partners) {
            $partners = explode(',', $offer->sellerQuestionnaire->partners);
            if (in_array(Auth::id(), $partners)) {
                $sentDocuments = SaleOffer::where('id', $request->offer_id)
                    ->whereHas('property', function ($type) use ($request) {
                        $type->where('property_type', $request->type);
                        $type->withTrashed();
                    })->with(['signatures' => function ($saleSignatures) {
                        $saleSignatures->where('user_id', Auth::id());
                    }, 'property' => function ($query) {
                        $query->withTrashed();
                    }])->first();

                return view('frontend.my_documents.documents-for-review-update-by-owner', compact('sentDocuments'));
            }
        }
        if ($offer->buyerQuestionnaire->partners) {
            $partners = explode(',', $offer->buyerQuestionnaire->partners);
            if (in_array(Auth::id(), $partners)) {
                $sentDocuments = SaleOffer::where('id', $request->offer_id)
                    ->whereHas('property', function ($type) use ($request) {
                        $type->where('property_type', $request->type);
                        $type->withTrashed();
                    })->with(['signatures' => function ($saleSignatures) {
                        $saleSignatures->where('user_id', Auth::id());
                    }, 'property' => function ($query) {
                        $query->withTrashed();
                    }])->first();

                return view('frontend.my_documents.documents-for-review-update-by-owner', compact('sentDocuments'));
            }
        }

        return redirect()->back();
    }

    public function downloadDocumentsRent(Request $request)
    {
        //        if ($request->type && $request->offer_id &&
        //            RentOffer::where('id', $request->offer_id)->whereHas('property', function($type) use($request) {
        //                $type->where('property_type', $request->type);
        //            })->exists()) {
        //            $sentDocuments = $this->_getRentDocuments($request);
        //            $rent          = true;
        //
        //            return view('frontend.my_documents.c', compact('sentDocuments', 'rent'));
        //        }
        //        return redirect()->back();

        if ($request->type && $request->offer_id &&
                RentOffer::where('id', $request->offer_id)->where(function ($query) {
                    $query->orWhere('buyer_id', Auth::id())->orWhere('owner_id', Auth::id());
                })->whereHas('property', function ($type) use ($request) {
                    $type->where('property_type', $request->type);
                    $type->withTrashed();
                })->exists()) {
            $sentDocuments = $this->_getRentDocuments($request);
            $rent = true;

            return view('frontend.my_documents.documents-for-review-update-by-owner', compact('sentDocuments', 'rent'));
        }

        $offer = RentOffer::where('id', $request->offer_id)->whereHas('property', function ($type) use ($request) {
            $type->where('property_type', $request->type);
            $type->withTrashed();
        })->with('tenantQuestionnaire', 'landlordQuestionnaire')->first();

        if ($offer->landlordQuestionnaire->partners) {
            $partners = explode(',', $offer->landlordQuestionnaire->partners);
            if (in_array(Auth::id(), $partners)) {
                $sentDocuments = RentOffer::where('id', $request->offer_id)
                    ->whereHas('property', function ($type) use ($request) {
                        $type->where('property_type', $request->type);
                        $type->withTrashed();
                    })->with(['rentSignatures' => function ($rentSignatures) {
                        $rentSignatures->where('user_id', Auth::id());
                    }, 'property' => function ($query) {
                        $query->withTrashed();
                    }])->first();
                $rent = true;

                return view('frontend.my_documents.documents-for-review-update-by-owner', compact('sentDocuments', 'rent'));
            }
        }
        if ($offer->tenantQuestionnaire->partners) {
            $partners = explode(',', $offer->tenantQuestionnaire->partners);
            if (in_array(Auth::id(), $partners)) {
                $sentDocuments = RentOffer::where('id', $request->offer_id)
                    ->whereHas('property', function ($type) use ($request) {
                        $type->where('property_type', $request->type);
                        $type->withTrashed();
                    })->with(['rentSignatures' => function ($rentSignatures) {
                        $rentSignatures->where('user_id', Auth::id());
                    }, 'property' => function ($query) {
                        $query->withTrashed();
                    }])->first();
                $rent = true;

                return view('frontend.my_documents.documents-for-review-update-by-owner', compact('sentDocuments', 'rent'));
            }
        }

        return redirect()->back();
    }

    public function myDocuments(): View
    {
        return view('frontend.my_documents.documents-for-review-update-by-owner');
    }

    private function _getSaleDocuments($request)
    {
        $sentDocuments = SaleOffer::where('id', $request->offer_id)->where(function ($query) {
            $query->orWhere('sender_id', Auth::id())->orWhere('owner_id', Auth::id());
        })->whereHas('property', function ($type) use ($request) {
            $type->where('property_type', $request->type);
            $type->withTrashed();
        })->with(['signatures' => function ($saleSignatures) {
            $saleSignatures->where('user_id', Auth::id());
        }, 'property' => function ($query) {
            $query->withTrashed();
        }, 'property.architechture', 'property.disclosure', 'buyerQuestionnaire', 'postClosing'])->first();

        return $sentDocuments;
    }

    private function _getRentDocuments($request)
    {
        $sentDocuments = RentOffer::where('id', $request->offer_id)->whereHas('property', function ($type) use ($request) {
            $type->where('property_type', $request->type);
            $type->withTrashed();
        })->with(['rentSignatures' => function ($rentSignatures) {
            $rentSignatures->where('user_id', Auth::id());
        }, 'property' => function ($query) {
            $query->withTrashed();
        }, 'property.architechture'])->first();

        return $sentDocuments;
    }

    public function documentLeadBasedPaintHazards(): View
    {
        $offerData = Session::get('OFFER');
        $offer = SaleOffer::where('id', $offerData['offer_id'])
            ->with(['property' => function ($query) {
                $query->select('id', 'lead_based', 'lead_based_report', 'user_id');
                $query->withTrashed();
            }, 'signatures' => function ($query) use ($offerData) {
                $query->where('offer_id', $offerData['offer_id']);
                //                                ->where('signature_type', config('constant.inverse_signature_type.lead based'));
            }])->first();

        return view('frontend.contract_tools.document.document_lead_based_paint_hazards', compact('offer'));
    }

    public function documentSaleAgreement()
    {
        Session::forget('leadBased');
        $offerArray = Session::get('OFFER');

        if ($offerArray['type'] == config('constant.inverse_property_type.Sale')) {
            $offer = SaleOffer::where('id', $offerArray['offer_id'])
                ->with(['propertyConditional.disclosure' => function ($propertyCondDis) {
                    $propertyCondDis->select('best_knowledge_explain', 'partb_details', 'partc_details');
                }, 'sellerQuestionnaire', 'buyerQuestionnaire',
                    'seller' => function ($sellerQuery) {
                        $sellerQuery->with('user_profile', 'business_profile')->withTrashed();
                    },
                    'buyer' => function ($buyerQuery) {
                        $buyerQuery->with('user_profile', 'business_profile')->withTrashed();
                    },
                    'sale_counter_offers' => function ($query) {
                        $query->latest();
                    },
                    'signatures' => function ($query) use ($offerArray) {
                        $query->where('offer_id', $offerArray['offer_id']);
                    },
                    'saleAgreement'])->first();

            return view('frontend.contract_tools.document.document_update_sale_agreement_by_buyer', compact('offer'));
        }

        return redirect()->back();
    }

    public function documentLeadBasedPaintHazardsRent(): View
    {
        $offerData = Session::get('OFFER');
        $offer = RentOffer::where('id', $offerData['offer_id'])
            ->with(['property' => function ($subquery) {
                $subquery->withTrashed();
            }, 'propertyConditional' => function ($query) {
                $query->select('id', 'lead_based', 'lead_based_report', 'user_id');
            }, 'rentSignatures' => function ($query) use ($offerData) {
                $query->where('offer_id', $offerData['offer_id']);
                //                                ->where('signature_type', config('constant.inverse_signature_type.lead based'));
            }])->first();

        return view('frontend.contract_tools.document.document_lead_based_paint_hazards', compact('offer'));
    }

    public function documentDisclosure()
    {
        $propertyData = Session::get('PROPERTY');
        $offerArray = Session::get('OFFER');
        //echo'<pre>';print_R($propertyData);die;
        if (empty($propertyData)) {
            return redirect()->back();
        }

        if (\App\Models\Signature::where('offer_id', $offerArray['offer_id'])->where('affix_status', 1)->exists()) {

            $property = PropertyConditionalData::where('offer_id', $offerArray['offer_id'])->where('property_id', $propertyData)->with('architechture', 'disclosure')->first();
        } else {
            $property = Property::where('id', $propertyData)->with('architechture', 'disclosure')->withTrashed()->first();
        }
        $diffInYears = null;
        if (isset($property)) {
            $now = Carbon::now()->year;
            $from = $property->architechture->year_built;
            $diffInYears = $now - $from;

            return view('frontend.contract_tools.document.document_disclosure_by_seller_buyer_update', compact('diffInYears', 'property'));
        }

        return redirect()->back();
    }

    public function documentAdvisoryToBuyersAndSellers(): View
    {
        $offerArray = Session::get('OFFER');

        if ($offerArray['type'] == config('constant.inverse_property_type.Sale')) {
            $offer = SaleOffer::where('id', $offerArray['offer_id'])
                ->with(
                    [
                        'seller' => function ($sellerQuery) {
                            $sellerQuery->with('user_profile', 'business_profile')->withTrashed();
                        },
                        'buyer' => function ($buyerQuery) {
                            $buyerQuery->with('user_profile', 'business_profile')->withTrashed();
                        },
                        'signatures' => function ($query) use ($offerArray) {
                            $query->where('offer_id', $offerArray['offer_id']);
                        },
                        'propertyConditional'])->first();
        }

        return view('frontend.contract_tools.document.document_advisory_to_buyers_and_sellers', compact('offer'));
    }

    public function documentVaFhaloanAddendumByBuyer(): View
    {
        $offerArray = Session::get('OFFER');

        if ($offerArray['type'] == config('constant.inverse_property_type.Sale')) {
            $offer = SaleOffer::where('id', $offerArray['offer_id'])
                ->with([
                    'buyerQuestionnaire',
                    'propertyConditional', 'sale_counter_offers' => function ($query) {
                        $query->latest();
                    },
                    'seller' => function ($sellerQuery) {
                        $sellerQuery->with('user_profile', 'business_profile');
                        $sellerQuery->withTrashed();
                    },
                    'buyer' => function ($buyerQuery) {
                        $buyerQuery->with('user_profile', 'business_profile');
                        $buyerQuery->withTrashed();
                    },

                    'signatures' => function ($query) use ($offerArray) {
                        $query->where('offer_id', $offerArray['offer_id']);
                        //                                    ->where('signature_type', config('constant.inverse_signature_type.VA FHA loan addendum'));
                    }])->first();
        }

        return view('frontend.contract_tools.document.document_VA_FHA_loan_addendum_by_seller_buyer', compact('offer'));
    }

    public function documentPostClosing(): View
    {
        $offerData = Session::get('OFFER');
        $savedQuestionSellerPostClosing = QuestionSellerPostClosing::where('offer_id', $offerData['offer_id'])
            ->with('saleOffer')->first();
        $sellerQuestionnaire = SellerQuestionnaire::where('offer_id', $offerData['offer_id'])
            ->with([
                'saleOffer.buyer' => function ($query) {
                    $query->with('user_profile', 'business_profile');
                    $query->withTrashed();
                },
                'saleOffer.seller' => function ($query) {
                    $query->with('user_profile', 'business_profile');
                    $query->withTrashed();
                },

                'saleOffer.propertyConditional'])->first();

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

        return view('frontend.contract_tools.document.document_post_closing_occupancy_agreement_by_seller_buyer', compact('savedQuestionSellerPostClosing', 'sellerQuestionnaire', 'days', 'currentMortgage'));
    }

    public function documentRentAgreement(): View
    {
        $offerArray = Session::get('OFFER');
        if ($offerArray['type'] == config('constant.inverse_property_type.Rent')) {
            $signature = RentSignature::where('offer_id', $offerArray['offer_id'])->where('affix_status', 1)->first();
            $type = config('constant.inverse_signature_type_rent.rent agreement');
            if (! empty($signature)) {
                $offer = RentOffer::where('id', $offerArray['offer_id'])
                    ->with(['property' => function ($subquery) {
                        $subquery->withTrashed();
                    }, 'propertyConditional.disclosure' => function ($propertyCondDis) {
                        $propertyCondDis->select('best_knowledge_explain', 'partb_details',
                            'partc_details');
                    }, 'landlordQuestionnaire', 'rent_counter_offers' => function ($query) {
                        $query->latest();
                    },
                        'landlord' => function ($query) {
                            $query->with('user_profile', 'business_profile');
                            $query->withTrashed();
                        },
                        'rentAgreement', 'rentSignatures' => function ($query) {
                            $query->groupBy('user_id');

                        }])->first();
            } else {
                $offer = RentOffer::where('id', $offerArray['offer_id'])
                    ->with(['property' => function ($query) {
                        $query->withTrashed();
                    }, 'property.disclosure' => function ($propertyCondDis) {
                        $propertyCondDis->select('best_knowledge_explain', 'partb_details', 'partc_details');
                    }, 'landlordQuestionnaire', 'landlord' => function ($sellerQuery) {
                        $sellerQuery->with('user_profile', 'business_profile');
                    },
                        'tenant' => function ($buyerQuery) {
                            $buyerQuery->with('user_profile', 'business_profile');
                            $buyerQuery->withTrashed();
                        },
                        'landlord' => function ($query) {
                            $query->with('user_profile', 'business_profile');
                            $query->withTrashed();
                        },
                        'rent_counter_offers' => function ($query) {
                            $query->latest();
                        }, 'rentAgreement'])->first();
            }

            //            dd($offer);
            return view('frontend.contract_tools.document.document_rent_agreement', compact('offer', 'signature'));
        }

        return view('frontend.contract_tools.document.document_rent_agreement');
    }
}
