@extends ('frontend.layouts.app')
@section ('title', ('Sent Offers'))
@section('after-styles')
<link type="text/css" rel="stylesheet" href="{{ asset(mix('css/dashboard.css')) }}" media="all">
<style>
    .child_spacing {
        padding-left: 28px !important;
    }
    td.na_prop p span {
        background-color: #b0c7ce;
    }
    td.na_prop p {
        color: #b0c7ce;
    }
    tr.parent_last_child {
        margin-bottom: 20px;
    }
</style>
@endsection 
@section('content')
<div class="container"> 
    <div class="offers-page">
         <div class="row">
        <div class="col-lg-12">

            <div> <h4>Offer To : {{ isset($offer->landlord->business_profile->company_name) ? $offer->landlord->business_profile->company_name : (isset($offer->landlord->user_profile->full_name) ? $offer->landlord->user_profile->full_name:"N.A.")  }}</h4></div>
            <div class="" id="mymessagesviewreply-box">
                <table class="summary">
                    <tbody>
                        <tr>
                            <?php if (count($offer->rent_counter_offers) > 0) { ?>
                            <td><p><strong>Tentative Rent/Month Price Offer :</strong> <span class="money">{{round($offer->rent_counter_offers->first()->counter_offer_price)}}</span></p></td>
                            <?php } else { ?>
                            <td><p><strong>Tentative Rent/Month Price Offer :</strong> <span class="money">{{round($offer->rent_price)??"NA"}} </span></p></td>
                            <?php } ?>
                        </tr>
                        <tr>
                            <td><p><strong>Listing Type :</strong> <span> {{ config('constant.property_type.'. $offer->property->property_type)??"NA" }} </span> </p>
                            </td>
                        </tr>
                        <tr>
                            <td><p><strong>Name :</strong><span class="mail-text"> {{ $offer->name??"NA" }}</span> </p></td>
                        </tr>
                        <tr>
                            <td><p><strong>Email :</strong><span class="mail-text"> {{ $offer->email??"NA" }}</span> </p></td>
                        </tr>
                        <tr>
                            <td><p><strong>Phone :</strong> <span>{{  $offer->landlord->phone_no??"NA" }}</span></p></td>
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
                            <td class="child_spacing {{ (isset($offer->pets_type)) ? '' : 'na_prop' }}" colspan="2"><p><strong>Pet Type(s) :</strong><?php
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
                                    ?></p></td>
                        </tr>
                        <tr class="parent_last_child">
                            <td class="child_spacing {{ (isset($offer->pet_other_explanation)) ? '' : 'na_prop' }}" colspan="2"><p><strong>Other Details :</strong> <span>{{  $offer->pet_other_explanation??"NA" }}</span></p></td>
                        </tr>
                        <tr>
                            <td> <p><strong>Status :</strong> <span>{{ucwords(str_replace('_',' ',config('constant.offer_status.'.$offer->status)))  }}</span></p></td>
                        </tr>
                        <tr>
                            <td><p><strong>Offer Date :</strong> <span>{{date("d F Y", strtotime($offer->created_at))}}</span></p></td>
                        </tr>
                    </tbody>
                </table>
                <div class="bottom_btns pull-right">
                    @if($signButton == TRUE && $offer->status!=config('constant.inverse_rent_offer_status.user_deleted'))
                    <a href="{{route('frontend.sdSummaryKeyTermsForTenant')}}"> <button type="button" class="btn btn-default related_listing mar-left">Sign Documents</button></a>
                    @endif

                    @if(!empty($message) && $offer->status!=config('constant.inverse_rent_offer_status.user_deleted'))
                    <p class="pull-left text-danger offer-wait-msg">{{$message}}</p>
                    @endif
                    @if($showContractToolsButton == TRUE && $offer->status!=config('constant.inverse_rent_offer_status.user_deleted'))
                    <a href="{{route('frontend.questionSetForTenant')}}"> <button type="button" class="btn btn-default related_listing mar-left">Contract Tools</button></a>
                    @endif

                    @if($downloadButton == TRUE)
                    <a href="{{route('frontend.receivedDocumentDetailsRent',['offer_id'=> $offer->id,'type'=> $offer->property->property_type])}}"> <button type="button" class="btn btn-default related_listing mar-left">Download Document</button></a>
                    @endif

                    @if($offer->status==config('constant.inverse_rent_offer_status.user_deleted'))
                    <p class="pull-left text-danger offer-wait-msg">You can't continue the offer , As one of the party in this offer has deleted/deactivated their account.</p>
                    @endif

                    <a href="{{route('frontend.sent.offers')}}" type="button" class="btn btn-default mar-left">Back</a>
                    <a href="{{route('frontend.propertyDetails',$offer->property->id)}}" type="button" class="btn btn-default related_listing mar-left">Related Listing</a>

                </div>
                @if (isset($offer->rent_counter_offers) && count($offer->rent_counter_offers) > 0)
                <div class="" id="mymessagesviewreply-box date-box">

                    <table>
                        <tbody>
                            <?php
                            foreach ($offer->rent_counter_offers as $key => $off) {
                                ?>
                                <tr>
                                    <td>
                                        <p><strong>COUNTER OFFER PRICE :</strong><span class="money">{{round($off->counter_offer_price)??""}}</span>
                                            <span class="date">
                                             {{date("d F Y", strtotime($off->created_at))}}
                                            </span>
                                            @if($off->user_id == Auth::id())
                                            <span class="pull-right">
                                                Sent by you
                                            </span>
                                            @endif

                                            <span > {{config('constant.counter_offer_status')[$off->status] }}</span>
                                        </p>
                                        @if($showNegotiationButton == TRUE && $key == 0)
                                        <div  class="bottom_btns" style="text-align: right;">
                                            <a href="{{route('frontend.accept.counterOffer',[$offer->id,$offer->property->property_type])}}"> <button type="button" class="btn btn-default">Accept</button></a>
                                            <a href="{{route('frontend.reject.counterOffer',[$offer->id,$offer->property->property_type])}}"> <button type="button" class="btn btn-default related_listing">Reject</button></a>
                                            <button type="button" id="buyer_decline_counter" class="btn btn-default related_listing">Decline & Counter</button>
                                        </div>

                                        <div id="buyer_counter-offer" style="display:none">
                                            {{ html()->form('POST', route('frontend.counter.offer'))->id("make-an-offer-form")->class('form-horizontal')->attribute('role', 'form')->open() }}
                                            <input type="hidden" class="form-control" name="property_type" value="{{ $offer->property->property_type??"" }}">
                                            <input type="hidden" class="form-control" name="offer_id" value="{{ $offer->id??"" }}">
                                            <div class="form-group">
                                                
                                                <div class="col-md-12">
                                                    <label for="" class="control-label">Counter Offer Price</label>
                                                    <input type="number" id="offer_price" class="form-control" name="offer_price" data-rule-required="true" data-rule-number="true" data-msg-number="Please enter valid price" value="" placeholder="Enter your counter offer price" aria-required="true">
                                                    <div class="bottom_btns col-md-12">
                                                        <div class="form-group">
                                                            <div class="pull-right">
                                                                <input type="submit" class="btn btn-default" name="submit" id="inputbutton" value="counter">
                                                                <button type="button" id="toggleclose" class="btn btn-default">Cancel</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            </form>
                                        </div>
                                        @endif
                                    </td>
                                </tr>
                            <?php }
                            ?>
<!--                            <tr>
                                <td>
                                    <p><strong>COUNTER OFFER PRICE  :</strong><?php !empty($offer->tentative_offer_price) ?'<span class="money">{{round($offer->tentative_offer_price)}}</span>':''?>
                                        <span class="date">
                                            {{date("d F Y", strtotime($offer->created_at))}}
                                        </span>
                                        @if($offer->sender_id == Auth::id())
                                        <span class="pull-right">
                                            Sent by you
                                        </span>
                                        @endif

                                        <span > Counter</span>
                                    </p>
                                </td>
                            </tr>-->

                        </tbody>
                    </table>
                </div>
                @endif
            </div>
        </div>
      
    </div>
</div>
</div>

@endsection

@section('after-scripts')

<script>
    $(document).ready(function () {
        $('#buyer_decline_counter').click(function () {
            $('#buyer_counter-offer').toggle();
        });
    });
    $('.money').mask('000,000,000,000,000', {reverse: true});
    $('#toggleclose').click(function () {
        $('#offer_price').val('');
        $('#buyer_counter-offer').hide();
        });
</script>
@endsection