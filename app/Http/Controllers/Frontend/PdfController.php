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
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PDF;

class PdfController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function leadBasedPaintHazardsPdf($id = null)
    {
        if ($id) {
            $property = Property::where('id', $id)
                ->select('lead_based', 'lead_based_report')->withTrashed()->first();
        }
        $headerHtml = view()->make('pdf.header', compact('property'))->render();
        $footerHtml = view()->make('pdf.footer')->render();

        $pdf = PDF::loadView('pdf.lead_based_paint_hazards', compact('property'))
            ->setPaper('A4', 'landscape')
            ->setOption('margin-top', '40mm')
            ->setOption('margin-bottom', '20mm')
            ->setOption('header-html', $headerHtml)
            ->setOption('footer-html', $footerHtml)
            ->setOption('footer-right', 'Page [page] of [topage]')
            ->setOption('user-style-sheet', 'resources/assets/sass/frontend/common.scss');

        return $pdf->stream('lead_based_paint_hazards.pdf');
    }

    public function propertyDisclaimerPdf($id = null)
    {
        if ($id && Property::where('id', $id)->exists()) {
            //	    $signature = RentSignature::where('offer_id',$request->offer_id)->where('affix_status',1)->first();
            //	    check signature exist then get the data from backup tables
            //	    if(!empty($signature)){
            //		 $property = Property::where('property_id', $id)
            //                    ->with('architechture', 'disclosure')->first();
            //	    }
            //	    else{
            $property = Property::where('id', $id)
                ->with('architechture', 'disclosure')->withTrashed()->first();
            //	    }
        } else {
            return redirect()->back();
        }
        //	echo'<pre>';	print_r($property);die;
        $now = Carbon::now()->year;
        $from = $property->architechture->year_built;
        $diffInYears = $now - $from;
        $headerHtml = view()->make('pdf.header', compact('property', 'diffInYears'))->render();

        // dd($headerHtml);
        $footerHtml = view()->make('pdf.footer')->render();

        $pdf = PDF::loadView('pdf.property_disclosure', compact('property', 'diffInYears'))
            ->setOption('margin-top', '40mm')
            ->setOption('margin-bottom', '20mm', 'margin-top', '20mm')
            ->setPaper('A4', 'landscape')
            ->setOption('header-html', $headerHtml)
            ->setOption('footer-html', $footerHtml)
            ->setOption('footer-right', 'Page [page] of [topage]')
            ->setOption('user-style-sheet', 'resources/assets/sass/frontend/common.scss');

        // dd($pdf->stream('property_disclosure.pdf'));
        return $pdf->stream('property_disclosure.pdf');
    }

    // Signature Pdf
    public function propertyDisclaimerSignPdf(Request $request)
    {
        if ($request->property_id && $request->offer_id &&
            Property::where('id', $request->property_id)->withTrashed()->exists() &&
            SaleOffer::where('id', $request->offer_id)->where('property_id', $request->property_id)->exists()) {

            $property = PropertyConditionalData::where('property_id', $request->property_id)
                ->with('architechture', 'disclosure')->withTrashed()->first();
            //            dd($property);
            $now = Carbon::now()->year;
            $from = $property->architechture->year_built;
            $diffInYears = $now - $from;

            $offer = SaleOffer::where('id', $request->offer_id)->with(['signatures' => function ($query) use ($request) {
                $query->where('offer_id', $request->offer_id);
                $query->groupBy('type');
                //                            ->where('signature_type', config('constant.inverse_signature_type.property disclaimer'));
            }])->first();

            $headerHtml = view()->make('pdf.header', compact('property'))->render();
            $footerHtml = view()->make('pdf.footer')->render();

            $pdf = PDF::loadView('pdf.property_disclosure_sign', compact('property', 'diffInYears', 'offer'))
                ->setOption('margin-top', '40mm')
                ->setOption('margin-bottom', '20mm', 'margin-top', '20mm')
                ->setPaper('A4', 'portrait')
                ->setOption('footer-right', 'Page [page] of [topage]')
                ->setOption('header-html', $headerHtml)
                ->setOption('footer-html', $footerHtml)
                ->setOption('footer-right', 'Page [page] of [topage]')
                ->setOption('user-style-sheet', 'resources/assets/sass/frontend/common.scss');

            return $pdf->stream('property_disclosure_signatures.pdf');
        }

        return redirect()->back();
    }

    public function leadBasedSignPdf(Request $request)
    {
        if ($request->property_id && $request->offer_id &&
            Property::where('id', $request->property_id)->withTrashed()->exists() &&
            SaleOffer::where('id', $request->offer_id)->where('property_id', $request->property_id)->exists()) {

            $property = PropertyConditionalData::where('property_id', $request->property_id)->where('offer_id', $request->offer_id)
                ->select('lead_based', 'lead_based_report')->withTrashed()->first();

            $offer = SaleOffer::where('id', $request->offer_id)->with(['signatures' => function ($query) use ($request) {
                $query->where('offer_id', $request->offer_id);
                $query->groupBy('type');
            }])->first();

            $headerHtml = view()->make('pdf.header', compact('property'))->render();
            $footerHtml = view()->make('pdf.footer')->render();

            $pdf = PDF::loadView('pdf.lead_based_sign', compact('property', 'offer'))
                ->setOption('margin-top', '40mm')
                ->setOption('margin-bottom', '20mm', 'margin-top', '20mm')
                ->setPaper('A4', 'portrait')
                ->setOption('header-html', $headerHtml)
                ->setOption('footer-html', $footerHtml)
                ->setOption('footer-right', 'Page [page] of [topage]')
                ->setOption('user-style-sheet', 'resources/assets/sass/frontend/common.scss');

            return $pdf->stream('lead_based_signatures.pdf');
        }

        return redirect()->back();
    }

    public function advisorySignPdf(Request $request)
    {
        if ($request->property_id && $request->offer_id &&
            Property::where('id', $request->property_id)->withTrashed()->exists() &&
            SaleOffer::where('id', $request->offer_id)->where('property_id', $request->property_id)->exists()) {

            $property = PropertyConditionalData::where('property_id', $request->property_id)->where('offer_id', $request->offer_id)
                ->with('architechture', 'disclosure')->withTrashed()->first();
            $offer = SaleOffer::where('id', $request->offer_id)->with(['signatures' => function ($query) use ($request) {
                $query->where('offer_id', $request->offer_id);
                //$query->groupBy('type');
            }])->first();
            //dd($offer);
            $headerHtml = view()->make('pdf.header', compact('property'))->render();
            $footerHtml = view()->make('pdf.footer')->render();
            $pdf = PDF::loadView('pdf.advisory_sign', compact('property', 'offer'))
                ->setOption('margin-top', '40mm')
                ->setOption('margin-bottom', '20mm', 'margin-top', '20mm')
                ->setPaper('A4', 'portrait')
                ->setOption('header-html', $headerHtml)
                ->setOption('footer-html', $footerHtml)
                ->setOption('footer-right', 'Page [page] of [topage]')
                ->setOption('user-style-sheet', 'resources/assets/sass/frontend/common.scss');

            return $pdf->stream('advisory_signatures.pdf');
        }

        return redirect()->back();
    }

    public function postClosingSignPdf(Request $request)
    {
        if ($request->property_id && $request->offer_id &&
            Property::where('id', $request->property_id)->withTrashed()->exists() &&
            SaleOffer::where('id', $request->offer_id)->where('property_id', $request->property_id)->exists()) {
            //
            //            $signature = \App\Models\Signature::where('user_id', Auth::id())
            //                ->where('offer_id', $request->offer_id)
            //                ->where('signature_type', config('constant.inverse_signature_type.post closing occupancy agreement'))
            //                ->first();
            ////            dd($signature);
            $type = 'post_closing';
            $property = PropertyConditionalData::where('property_id', $request->property_id)->where('offer_id', $request->offer_id)
                ->with('architechture', 'disclosure')->withTrashed()->first();
            $offer = SaleOffer::where('id', $request->offer_id)
                ->with(['property' => function ($query) {
                    $query->select('id', 'lead_based', 'lead_based_report', 'user_id');
                    $query->withTrashed();
                }, 'signatures' => function ($query) use ($request) {
                    $query->where('offer_id', $request->offer_id);
                    //                            ->where('signature_type', config('constant.inverse_signature_type.post closing occupancy agreement'));
                }])->first();
            $savedQuestionSellerPostClosing = QuestionSellerPostClosing::where('offer_id', $request->offer_id)
                ->with('saleOffer')->first();
            $sellerQuestionnaire = SellerQuestionnaire::where('offer_id', $request->offer_id)
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

            $headerHtml = view()->make('pdf.header', compact('property'))->render();
            $footerHtml = view()->make('pdf.footer')->render();

            $pdf = PDF::loadView('pdf.post_closing_sign', compact('property', 'offer', 'savedQuestionSellerPostClosing', 'sellerQuestionnaire', 'days', 'currentMortgage', 'type'))
                ->setOption('margin-top', '40mm')
                ->setOption('margin-bottom', '20mm', 'margin-top', '20mm')
                ->setPaper('A4', 'portrait')
                ->setOption('header-html', $headerHtml)
                ->setOption('footer-html', $footerHtml)
                ->setOption('footer-right', 'Page [page] of [topage]')
                ->setOption('user-style-sheet', 'resources/assets/sass/frontend/common.scss');

            return $pdf->stream('post_closing_signatures.pdf');
        }

        return redirect()->back();
    }

    public function VaFhsSignPdf(Request $request)
    {
        if ($request->property_id && $request->offer_id &&
            Property::where('id', $request->property_id)->withTrashed()->exists() &&
            SaleOffer::where('id', $request->offer_id)->where('property_id', $request->property_id)->exists()) {
            $property = PropertyConditionalData::where('property_id', $request->property_id)->where('offer_id', $request->offer_id)
                ->with('architechture', 'disclosure')->withTrashed()->first();
            $offer = SaleOffer::where('id', $request->offer_id)->with(['signatures' => function ($query) use ($request) {
                $query->where('offer_id', $request->offer_id);
                $query->groupBy('type');
                //                            ->where('signature_type', config('constant.inverse_signature_type.VA FHA loan addendum'));
            },
                'signatures' => function ($query) use ($request) {
                    $query->where('offer_id', $request->offer_id);
                },
                'sale_counter_offers', 'property' => function ($query) {
                    $query->withTrashed();
                }])->first();

            $headerHtml = view()->make('pdf.header', compact('property'))->render();
            $footerHtml = view()->make('pdf.footer')->render();

            $pdf = PDF::loadView('pdf.va_fha_sign', compact('property', 'offer'))
                ->setOption('margin-top', '40mm')
                ->setOption('margin-bottom', '20mm', 'margin-top', '20mm')
                ->setPaper('A4', 'portrait')
                ->setOption('header-html', $headerHtml)
                ->setOption('footer-html', $footerHtml)
                ->setOption('footer-right', 'Page [page] of [topage]')
                ->setOption('user-style-sheet', 'resources/assets/sass/frontend/common.scss');

            return $pdf->stream('va_fha_signatures.pdf');
        }

        return redirect()->back();
    }

    public function saleAgreementSignPdf(Request $request)
    {
        if ($request->property_id && $request->offer_id &&
            Property::where('id', $request->property_id)->withTrashed()->exists() &&
            SaleOffer::where('id', $request->offer_id)->where('property_id', $request->property_id)->exists()) {

            $property = PropertyConditionalData::where('property_id', $request->property_id)->where('offer_id', $request->offer_id)
                ->with('architechture', 'disclosure')->withTrashed()->first();
            $offer = SaleOffer::where('id', $request->offer_id)->with(['signatures' => function ($query) use ($request) {
                $query->where('offer_id', $request->offer_id);
                $query->groupBy('type');
                //                            ->where('user_id', Auth::id());
                //                            ->where('signature_type', config('constant.inverse_signature_type.sale agreement'));
            }, 'sale_counter_offers', 'property' => function ($query) {
                $query->withTrashed();
            },
                'seller' => function ($sellerQuery) {
                    $sellerQuery->with('user_profile', 'business_profile');
                    $sellerQuery->withTrashed();
                },
                'buyer' => function ($buyerQuery) {
                    $buyerQuery->with('user_profile', 'business_profile');
                    $buyerQuery->withTrashed();
                },
                'signatures' => function ($query) use ($request) {
                    $query->where('offer_id', $request->offer_id);

                },
            ])->first();
            $headerHtml = view()->make('pdf.header', compact('property'))->render();
            $footerHtml = view()->make('pdf.footer')->render();

            $pdf = PDF::loadView('pdf.sale_agreement_sign', compact('property', 'offer'))
                ->setOption('margin-top', '40mm')
                ->setOption('margin-bottom', '20mm', 'margin-top', '20mm')
                ->setPaper('A4', 'portrait')
                ->setOption('header-html', $headerHtml)
                ->setOption('footer-html', $footerHtml)
                ->setOption('footer-right', 'Page [page] of [topage]')
                ->setOption('user-style-sheet', 'resources/assets/sass/frontend/common.scss');

            return $pdf->stream('sale_agreement_signatures.pdf');
        }

        return redirect()->back();
    }

    public function rentAgreementSignPdf(Request $request)
    {
        if ($request->property_id && $request->offer_id &&
            Property::where('id', $request->property_id)->withTrashed()->exists() &&
            RentOffer::where('id', $request->offer_id)->where('property_id', $request->property_id)->exists()) {
            $signature = RentSignature::where('offer_id', $request->offer_id)->where('affix_status', 1)->first();
            $type = config('constant.inverse_signature_type_rent.rent agreement');
            $property = PropertyConditionalData::where('property_id', $request->property_id)->where('offer_id', $request->offer_id)
                ->with('architechture', 'disclosure')->withTrashed()->first();
            $offer = RentOffer::where('id', $request->offer_id)
                ->with(['property' => function ($query) {
                    $query->withTrashed();
                }, 'propertyConditional.disclosure' => function ($propertyCondDis) {
                    $propertyCondDis->select('best_knowledge_explain', 'partb_details',
                        'partc_details');
                }, 'landlordQuestionnaire', 'rent_counter_offers' => function ($query) {
                    $query->latest();
                },
                    'tenant' => function ($buyerQuery) {
                        $buyerQuery->with('user_profile', 'business_profile');
                        $buyerQuery->withTrashed();
                    },
                    'landlord' => function ($query) {
                        $query->with('user_profile', 'business_profile');
                        $query->withTrashed();
                    },
                    'rentAgreement', 'rentSignatures' => function ($query) {
                        //                            $query->groupBy('user_id');
                    }])->first();
            //			dd($property);
            $headerHtml = view()->make('pdf.header', compact('property'))->render();
            $footerHtml = view()->make('pdf.footer')->render();
            $pdf = PDF::loadView('pdf.rent_agreement_sign', compact('property', 'offer', 'type', 'signature'))
                ->setOption('margin-top', '40mm')
                ->setOption('margin-bottom', '20mm', 'margin-top', '20mm')
                ->setPaper('A4', 'portrait')
                ->setOption('header-html', $headerHtml)
                ->setOption('footer-html', $footerHtml)
                ->setOption('footer-right', 'Page [page] of [topage]')
                ->setOption('user-style-sheet', 'resources/assets/sass/frontend/common.scss');

            return $pdf->stream('rent_agreement_signatures.pdf');
        }

        return redirect()->back();
    }

    public function propertyDisclaimerRentSignPdf(Request $request)
    {
        if ($request->property_id && $request->offer_id &&
            Property::where('id', $request->property_id)->withTrashed()->exists() &&
            RentOffer::where('id', $request->offer_id)->where('property_id', $request->property_id)->exists()) {
            $type = config('constant.inverse_signature_type.property disclaimer');
            $signature = RentSignature::where('offer_id', $request->offer_id)->where('affix_status', 1)->first();
            $property = PropertyConditionalData::where('property_id', $request->property_id)->where('offer_id', $request->offer_id)
                ->with('architechture', 'disclosure')->withTrashed()->first();
            $now = Carbon::now()->year;
            $from = $property->architechture->year_built;
            $diffInYears = $now - $from;

            $offer = RentOffer::where('id', $request->offer_id)->with(['rentSignatures' => function ($query) use ($request) {
                $query->where('offer_id', $request->offer_id);
                //                            ->where('signature_type', config('constant.inverse_signature_type.property disclaimer'));
            },
                'tenant' => function ($buyerQuery) {
                    $buyerQuery->with('user_profile', 'business_profile');
                    $buyerQuery->withTrashed();
                },
                'landlord' => function ($query) {
                    $query->with('user_profile', 'business_profile');
                    $query->withTrashed();
                },
                'property' => function ($query) {
                    $query->withTrashed();
                }])->first();

            $headerHtml = view()->make('pdf.header', compact('property'))->render();
            $footerHtml = view()->make('pdf.footer')->render();

            $pdf = PDF::loadView('pdf.property_disclosure_rent_sign', compact('property', 'diffInYears', 'offer', 'type'))
                ->setOption('margin-top', '40mm')
                ->setOption('margin-bottom', '20mm', 'margin-top', '20mm')
                ->setPaper('A4', 'portrait')
                ->setOption('footer-right', 'Page [page] of [topage]')
                ->setOption('header-html', $headerHtml)
                ->setOption('footer-html', $footerHtml)
                ->setOption('footer-right', 'Page [page] of [topage]')
                ->setOption('user-style-sheet', 'resources/assets/sass/frontend/common.scss');

            return $pdf->stream('property_disclosure_signatures.pdf');
        }

        return redirect()->back();
    }

    public function leadBasedRentSignPdf(Request $request)
    {
        if ($request->property_id && $request->offer_id &&
            Property::where('id', $request->property_id)->withTrashed()->exists() &&
            RentOffer::where('id', $request->offer_id)->where('property_id', $request->property_id)->exists()) {
            $type = config('constant.inverse_signature_type.lead based');
            $property = PropertyConditionalData::where('property_id', $request->property_id)->where('offer_id', $request->offer_id)
                ->select('lead_based', 'lead_based_report')->withTrashed()->first();

            $offer = RentOffer::where('id', $request->offer_id)->with(['rentSignatures' => function ($query) use ($request) {
                $query->where('offer_id', $request->offer_id);
                //                            ->where('signature_type', config('constant.inverse_signature_type.lead based'));
            }, 'property' => function ($query) {
                $query->withTrashed();
            },
                'tenant' => function ($buyerQuery) {
                    $buyerQuery->with('user_profile', 'business_profile');
                    $buyerQuery->withTrashed();
                },
                'landlord' => function ($query) {
                    $query->with('user_profile', 'business_profile');
                    $query->withTrashed();
                },
            ])->first();

            $headerHtml = view()->make('pdf.header', compact('property'))->render();
            $footerHtml = view()->make('pdf.footer')->render();

            $pdf = PDF::loadView('pdf.lead_based_rent_sign', compact('property', 'offer', 'signature', 'type'))
                ->setOption('margin-top', '40mm')
                ->setOption('margin-bottom', '20mm', 'margin-top', '20mm')
                ->setPaper('A4', 'portrait')
                ->setOption('header-html', $headerHtml)
                ->setOption('footer-html', $footerHtml)
                ->setOption('footer-right', 'Page [page] of [topage]')
                ->setOption('user-style-sheet', 'resources/assets/sass/frontend/common.scss');

            return $pdf->stream('lead_based_signatures.pdf');
        }

        return redirect()->back();
    }
}
