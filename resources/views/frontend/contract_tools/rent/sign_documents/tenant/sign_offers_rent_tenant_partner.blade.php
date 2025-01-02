@extends ('frontend.layouts.app')
@section ('title', ('Sent Offers'))
@section('after-styles')
<link type="text/css" rel="stylesheet" href="{{ asset(mix('css/dashboard.css')) }}" media="all"> 
@endsection
@section('content')
<div class="container">
    <div class="row offers-page">
        <div class="col-lg-12">
            <div class=""> <h4>Offer To : {{ isset($offer->landlord->business_profile->company_name) ? $offer->landlord->business_profile->company_name : (isset($offer->landlord->user_profile->full_name) ? $offer->landlord->user_profile->full_name:"NA") }}</h4></div>
            <div class="" id="mymessagesviewreply-box">
                <table class="summary">
                        <tbody>
                            <tr>
                                <?php if (count($offer->rent_counter_offers) > 0) { ?>
                                    <td><p><strong>Tentative Rent/Month Price Offer : :</strong> <span class="money">{{round($offer->rent_counter_offers->first()->counter_offer_price)}}</span></p></td>
                                <?php } else { ?>
                                    <td><p><strong>Tentative Rent/Month Price Offer : :</strong> <span class="money">{{round($offer->rent_price)??"NA"}} </span></p></td>
                                <?php } ?>

                            </tr>
                            <tr>
                                <td><p><strong>Listing Type :</strong> <span>{{  config('constant.property_type.'. $offer->property->property_type)??"NA" }}</span></p></td>
                            </tr>

                            <tr>
                                <td><p><strong>Name :</strong><span class="mail-text"> {{ $offer->name??"NA" }}</span> </p></td>
                            </tr>
                            <tr>
                                <td><p><strong>Email :</strong><span class="mail-text"> {{ $offer->email??"NA" }}</span> </p></td>
                            </tr>
                            <tr>
                                <td><p><strong>Phone :</strong> <span>{{  $offer->phone??"NA" }}</span></p></td>
                            </tr>
                            <tr>
                                <td><p><strong>Lease Term: </strong>
                                        <?php
                                        if (isset($offer) && $offer->lease_term) {
                                            $leaseTerms = explode(',', $offer->lease_term);
                                            foreach ($leaseTerms as $leaseTerm) {
                                                ?>
                                                <span>{{ $leaseTerm }}</span>
                                                <?php
                                            }
                                        } else {
                                            echo "<span>NA</span>";
                                        }
                                        ?>
                                    </p>
                                </td>
                            </tr>
                            <tr>
                                <td><p><strong>Desired Date of Occupancy:</strong> <span>{{  $offer->date_of_occupancy??"NA" }}</span></p></td>
                            </tr>
                            <tr>
                                <td><p><strong>Total months to lease the property :</strong> <span>{{  isset($offer->month_count)?(($offer->month_count == 12) ? '12 +':$offer->month_count ):"NA" }}</span></p></td>
                            </tr>
                            <tr>
                                <td><p><strong>Have Pet(s)? :</strong> <span>{{  config('constant.pets_welcome.'. $offer->pets_welcome)??"NA" }}</span></p></td>
                            </tr>
                            <tr>
                                <td class="child_spacing {{ (isset($offer->pets_type)) ? '' : 'na_prop' }}" colspan="2">
                                    <p><strong>Pet Type(s) :</strong>
                                        <?php
                                        if (isset($offer) && $offer->pets_type) {
                                            $pets = explode(',', $offer->pets_type);
                                            foreach ($pets as $pet) {
                                                ?>
                                                <span>{{ $pet }}</span>
                                                <?php
                                            }
                                        } else {
                                            echo "<span>NA</span>";
                                        }
                                        ?>
                                    </p>
                                </td>
                            </tr>
                            <tr class="parent_last_child">
                                <td class="child_spacing {{ (isset($offer->pet_other_explanation)) ? '' : 'na_prop' }}" colspan="2"><p><strong>Other Details :</strong> <span>{{  $offer->pet_other_explanation??"NA" }}</span></p></td>
                            </tr>
                            <tr>
                                <td> <p><strong>Status :</strong> <span>{{  config('constant.offer_status.'. $offer->status)??"NA" }}</span></p></td>
                            </tr>
                            <tr>
                                <td><p><strong>Offer Date :</strong> <span>{{date("d F Y", strtotime($offer->created_at))}}</span></p></td>
                            </tr>
                        </tbody>
                    </table>
                <div class="bottom_btns pull-right">
                    @if($signButton == TRUE)
                    <a href="{{route('frontend.sdSummaryKeyTermsForTenant')}}"> <button type="button" class="btn btn-default related_listing mar-left">Sign Documents</button></a>
                    @endif
                    @if(!empty($message))
                    <p class="pull-left text-danger offer-wait-msg">{{$message}}</p>
                    @endif
                    @if($downloadBtn == TRUE)
                    <a href="{{route('frontend.receivedDocumentDetailsRent',['offer_id'=> $offer->id,'type'=> $offer->property->property_type])}}"> <button type="button" class="btn btn-default related_listing mar-left">Download Document</button></a>
                    @endif
                    <a href="{{URL::previous()}}"> <button type="button" class="btn btn-default submit mar-left">Back</button></a>
                    <a  href="{{route('frontend.propertyDetails',$offer->property->id)}}"> <button type="button" class="btn btn-default related_listing mar-left">Related Listing</button></a>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection