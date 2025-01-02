@extends ('frontend.layouts.app')
@section ('title', ('Sent Offers'))
@section('after-styles')
<link type="text/css" rel="stylesheet" href="{{ asset(mix('css/dashboard.css')) }}" media="all"> 
@endsection
@section('content')
<div class="container">
    <div class="row offers-page">
        <div class="col-lg-12">
            <div class=""> <h4>RECEIVED FROM :: {{ isset($offer->buyer->business_profile->company_name) ? $offer->buyer->business_profile->company_name : (isset($offer->buyer->user_profile->full_name) ? $offer->buyer->user_profile->full_name:"N.A.") }}</h4></div>
            <div class="" id="mymessagesviewreply-box">
                <table class="summary">
                    <tbody>
                        <tr>
                            <td><p><strong>Offer Price :</strong> <span class="money">{{$offer->sale_counter_offers->count()?round($offer->sale_counter_offers[0]->counter_offer_price):round($offer->tentative_offer_price)}}</span></p></td>
                        </tr>
                        <tr>
                            <td><p><strong>Listing Type :</strong> <span> {{ config('constant.property_type.'. $offer->property->property_type)??"NA" }} </span> </p>
                            </td>
                        </tr>
                        <tr>
                            <td><p><strong>Any Closing Cost Assistance Requested? :</strong> <span> @if( $offer->closing_cost_requested) {{ config('constant.closing_cost_requested.'. $offer->closing_cost_requested) }} @else NA @endif</span> </p></td>
                        </tr>
                        <tr>
                            <td class="child_spacing {{ (isset($offer->percentage_of_price) && $offer->percentage_of_price) ? '' : 'na_prop' }}"><p><strong>Percentage of Price :</strong> <span> {{$offer->percentage_of_price??"NA" }}</span></p></td>
                        </tr>
                        <tr class="parent_last_child">
                            <td class="child_spacing {{ (isset($offer->fixed_amount) && $offer->fixed_amount) ? '' : 'na_prop' }}"><p><strong>Fixed $ Amount :</strong> <span> @if( $offer->fixed_amount) {{  $offer->fixed_amount }} @else NA @endif </span></p></td>
                        </tr>
                        <tr>
                            <td><p><strong>Any Contingencies :</strong> <span> @if( $offer->any_contingencies) {{ config('constant.any_contingencies.'. $offer->any_contingencies) }} @else NA @endif</span> </p></td>
                        </tr>
                        <tr class="parent_last_child ">
                            <td class="child_spacing {{ (isset($offer->contingencies_explain) && $offer->contingencies_explain) ? '' : 'na_prop' }}" colspan="2"><p><strong>Details :</strong> <span> {{ $offer->contingencies_explain??"NA" }}</span></p></td>
                        </tr>
                        <tr>
                            <td colspan="2"><p><strong>Loan Status :</strong><span> {{ config('constant.qualification_documents.'. $offer->qualification_document)??"NA" }}</span></p></td>
                        </tr>
                        <tr class="parent_last_child">
                            <td colspan="2" class="child_spacing {{ (isset($offer->source_of_cash) && $offer->source_of_cash) ? '' : 'na_prop' }}"><p><strong>Source of cash :</strong>  <span>@if( $offer->source_of_cash) {{  $offer->source_of_cash }} @else NA @endif</span> </p></td>
                        </tr>
                        <tr>
                            <td colspan="2"><p><strong>Optional Message to Seller:</strong> <span> @if( $offer->optional_message) {{  $offer->optional_message }} @else NA @endif</span> </p></td>
                        </tr>
                        <tr>
                            <td><p><strong>Status :</strong>  <span> @if( $offer->status == config('constant.offer_status.pending'))  Pending @else Approved @endif</span> </p></td>
                        </tr>
                        <tr>
                            <td><p><strong>Offer Date :</strong> <span>{{date("d F Y", strtotime($offer->created_at))}}</span></p></td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <p><strong>Attached Qualification Document :</strong>&nbsp;
                                    @if( $offer->doc_path)
                                    <a href="{{ URL::to( '/storage/' . $offer->doc_path)  }}" class="download_btn">Download</a>
                                    @else
                                    <span>NA</span>
                                    @endif
                                </p>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="bottom_btns pull-right">
                    @if($signButton == TRUE)
                    <a href="{{route('frontend.sdSummaryKeyTermsForSeller')}}"> <button type="button" class="btn btn-default related_listing mar-left">Sign Documents</button></a>
                    @endif
                    @if(!empty($message))
                    <p class="pull-left text-danger offer-wait-msg">{{$message}}</p>
                    @endif
                    @if($downloadBtn == TRUE)
                    <a href="{{route('frontend.sentDocumentDetailsSale',['offer_id'=> $offer->id,'type'=> $offer->property->property_type])}}"> <button type="button" class="btn btn-default related_listing mar-left">Download Document</button></a>
                    @endif
                    <a href="{{route('frontend.sent.offers')}}"> <button type="button" class="btn btn-default submit mar-left">Back</button></a>
                    <a  href="{{route('frontend.propertyDetails',$offer->property->id)}}"> <button type="button" class="btn btn-default related_listing mar-left">Related Listing</button></a>

                </div>
            </div>
        </div>
    </div>
</div>
<script>
     $('.money').mask('000,000,000,000,000', {reverse: true});
</script>
@endsection