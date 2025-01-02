<?php

namespace App\Http\Controllers\Frontend\ContractTools;

use App\Http\Controllers\Controller;
use App\Models\BuyerQuestionnaire;
use App\Models\LandlordQuestionnaire;
use App\Models\SellerQuestionnaire;
use App\Models\TenantQuestionnaire;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class SignDocumentsController extends Controller
{
    public function partnersSignDocuments(): View
    {
        return view('frontend.partners_sign_documents.choose_role');
    }

    public function signDocumentsBuyer(): View
    {
        $authId = Auth::id();
        $questions = BuyerQuestionnaire::whereHas('saleOffer', function ($buyer) {
            $buyer->where('closed', 0);
        })
            ->whereHas('user')
            ->with(['saleOffer', 'saleOffer.property' => function ($query) {
                $query->withTrashed();
            },
                'saleOffer.seller' => function ($query) {
                    $query->with('user_profile', 'business_profile');
                    $query->withTrashed();
                },
                'saleOffer.property_owner_user' => function ($sellerQuery) {
                    $sellerQuery->with('user_profile', 'business_profile');
                    $sellerQuery->withTrashed();
                },

            ])
            ->get();
        $buyers = [];
        foreach ($questions as $question) {
            $exploded = explode(',', $question->partners);
            if (in_array($authId, $exploded)) {
                $buyers[] = $question;
            }
            if ($question->saleOffer->sender_id == Auth::id()) {
                $buyers[] = $question;
            }
        }

        return view('frontend.partners_sign_documents.sign_documents_buyer', compact('buyers'));
    }

    public function signDocumentsSeller(): View
    {
        $questions = SellerQuestionnaire::whereHas('saleOffer', function ($buyer) {
            $buyer->where('closed', 0);
        })
            ->whereHas('user')
            ->with(['saleOffer', 'saleOffer.property' => function ($query) {
                $query->withTrashed();
            },
                'saleOffer.buyer' => function ($query) {
                    $query->with('user_profile', 'business_profile');
                    $query->withTrashed();
                },
                'saleOffer.property_owner_user' => function ($sellerQuery) {
                    $sellerQuery->with('user_profile', 'business_profile');
                    $sellerQuery->withTrashed();
                },
            ])
            ->get();
        $sellers = [];
        foreach ($questions as $question) {
            $exploded = explode(',', $question->partners);
            if (in_array(Auth::id(), $exploded)) {
                $sellers[] = $question;
            }
            if ($question->saleOffer->owner_id == Auth::id()) {
                $sellers[] = $question;
            }
        }

        return view('frontend.partners_sign_documents.sign_documents_seller', compact('sellers'));
    }

    public function signDocumentsLandlord(): View
    {
        $questions = LandlordQuestionnaire::whereHas('rentOffer', function ($query) {
            $query->where('closed', 0);
        })->latest()->whereHas('user')->with(['rentOffer', 'rentOffer.property' => function ($query) {
            $query->withTrashed();
        },
            'rentOffer.tenant' => function ($query) {
                $query->with('user_profile', 'business_profile');
                $query->withTrashed();
            },
            'rentOffer.property_owner_user' => function ($sellerQuery) {
                $sellerQuery->with('user_profile', 'business_profile');
                $sellerQuery->withTrashed();
            },

        ])->get();
        $authId = Auth::id();
        $landlords = [];
        foreach ($questions as $question) {
            $exploded = explode(',', $question->partners);
            if (in_array($authId, $exploded)) {
                $landlords[] = $question;
            }
            if ($question->rentOffer->owner_id == Auth::id()) {
                $landlords[] = $question;
            }
        }

        return view('frontend.partners_sign_documents.sign_documents_landlord', compact('landlords'));
    }

    public function signDocumentsTenant(): View
    {
        $questions = TenantQuestionnaire::whereHas('rentOffer', function ($query) {
            $query->where('closed', 0);
        })->latest()->whereHas('user')->with(['rentOffer', 'rentOffer.property' => function ($query) {
            $query->withTrashed();
        },
            'rentOffer.landlord' => function ($query) {
                $query->with('user_profile', 'business_profile');
                $query->withTrashed();
            },
            'rentOffer.property_owner_user' => function ($sellerQuery) {
                $sellerQuery->with('user_profile', 'business_profile');
                $sellerQuery->withTrashed();
            },

        ])->get();
        $authId = Auth::id();
        $tenants = [];
        foreach ($questions as $question) {
            $exploded = explode(',', $question->partners);
            if (in_array($authId, $exploded)) {
                $tenants[] = $question;
            }
            if ($question->rentOffer->buyer_id == Auth::id()) {
                $tenants[] = $question;
            }
        }

        return view('frontend.partners_sign_documents.sign_documents_tenant', compact('tenants'));
    }
}
