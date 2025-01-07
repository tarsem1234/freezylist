@extends ('frontend.layouts.app')
@section ('title', ('Sales'))
@section('content')
<div class="col-md-9 col-sm-9">
    @if(isset($owner->business_profile) && $owner->business_profile)
    <h4>Offer To : {{ $owner->business_profile->company_name }}</h4>
    @else(isset($owner->user_profile) && $owner->user_profile)
    <h4>Offer To : {{ $owner->user_profile->full_name }}</h4>
    @endif
    <div class="jumbotron" id="mymessagesviewreply-box">
        <table>
            <tbody>
                <tr>
                    <td><p><strong>Offer Price :</strong><span class="money"> @if($offer->tentative_offer_price) {{  round($offer->tentative_offer_price) }} @else NA @endif </span></p></td>
                    <td><p><strong>Listing Type :</strong> @if( $offer->type) {{ config('constant.property_type.'. $offer->type) }} @endif</p>
                    </td>
                </tr>
                <tr>
                    <td><p><strong>Any Closing Cost Assistance Requested? :</strong> @if( $offer->closing_cost_requested) {{ config('constant.closing_cost_requested.'. $offer->closing_cost_requested) }} @else NA @endif</p></td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td><p><strong>Percentage of Price :</strong> @if( $offer->percentage_of_price) {{  $offer->percentage_of_price }} @else NA @endif</p></td>
                    <td><p><strong>Fixed $ Amount :</strong> @if( $offer->fixed_amount) {{  $offer->fixed_amount }} @else NA @endif</p></td>
                </tr>
                <tr>
                    <td><p><strong>Any Contingencies :</strong> @if( $offer->any_contingencies) {{ config('constant.any_contingencies.'. $offer->any_contingencies) }} @else NA @endif</p></td>
                    <td>&nbsp;</td>
                </tr>
                <tr>
                    <td colspan="2"><p><strong>Details :</strong>  @if( $offer->contingencies_explain) {{ config('constant.any_contingencies.'. $offer->contingencies_explain) }} @else NA @endif</p></td>
                </tr>
                <tr>
                    <td colspan="2"><p><strong>Loan Status :</strong> Not Approved</p></td>
                </tr>
                <tr>
                    <td colspan="2"><p><strong>Source of cash :</strong> @if( $offer->source_of_cash) {{  $offer->source_of_cash }} @else NA @endif</p></td>
                </tr>
                <tr>
                    <td colspan="2"><p><strong>Optional Message to Seller/Buyer :</strong> @if( $offer->optional_message) {{  $offer->optional_message }} @else NA @endif</p></td>
                </tr>
                <tr>
                    <td> <p><strong>Status :</strong> @if( $offer->status == config('constant.offer_status.pending'))  Pending @else Approved @endif</p></td>
                    <td><p><strong>Offer Date :</strong> {{  $offer->created_at }}</p></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <p><strong>Attached Qualification Document :</strong>&nbsp;
                            @if( $offer->doc_path) 
                            <a href="{{ URL::to( '/storage/' . $offer->doc_path)  }}" target="_blank">Download</a>
                            @else
                            NA
                            @endif
                        </p>
                    </td>
                </tr>
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
            </tbody>
        </table>
        <div style="text-align: right;">
            <a href="{{ route('frontend.sent.offers') }}"> <button type="button" class="btn btn-default">Back</button></a>
            <a href="http://www.freezylist.com/salesdetails.php?listingid=182" target="_blank"> <button type="button" class="btn btn-default">Related Listing</button></a>
            @if( $offer->status == config('constant.offer_status.accepted'))
            <button type="button" data-sender_id="2" data-toggle="modal" data-target="#confirm-accept" class="btn btn-default">Accept</button>
            <button type="button" data-id="1" data-toggle="modal" data-target="#confirm-reject" class="btn btn-default">Reject</button>
            <button type="button" id="toggle" class="btn btn-default">Counter Offer</button>
            @endif
            <div id="flip" style="display:none;">
                {{ html()->form('POST', route('frontend.counter.offer'))->class('form-horizontal')->open() }}
                <div class="form-group">
                    <h4 class="col-sm-6 control-label">Counter Offer Price</h4>
                    <div class="col-sm-6">
                        <input type="text" id="offer_price" data-rule-required="true" data-msg-required="Please enter the price" data-rule-number="true" data-msg-number="Please enter valid price" class="form-control" name="offer_price" value="" placeholder="Enter your counter offer price" aria-required="true">
                    </div>
                </div>
                <div style="text-align: right;">
                    <input type="hidden" name="type" value="{{ $offer->type }}">
                    <input type="hidden" name="offer_id" value="{{ $offer->id }}">
                    <input type="hidden" name="property_id" value="{{ $offer->property_id }}">
                    <input type="submit" class="btn btn-default" name="submit" id="inputbutton" value="Send">
                    <button type="button" style="margin-top:20px;" id="toggleclose" class="btn btn-default">Cancel</button>
                </div>
                {{ html()->form()->close() }}
            </div>
            @if( $offer->status == config('constant.offer_status.pending') && isset($offer->counter_offers))
            <div class="jumbotron" id="mymessagesviewreply-box">
                <table>
                    <tbody>
                        @foreach($offer->counter_offers as $offer)
                        <tr style="border-top: 1px solid;">
                            <td><p><strong>Counter Offer Price :</strong><span class="money">{{round($offer->counter_offer_price)}}</span></p></td>
                            <td><p><strong>Date :</strong> {{ $offer->created_at }}</p></td>
                            <td><p> <strong>Sent By You </strong>
                                </p></td>
                        </tr>
                        @endforeach
                        <tr>
                            <td colspan="3">
                                <div id="fliprecount" style="display:none;">
                                    <form class="form-horizontal" role="form" name="reply" id="make-an-offer-form-re-count" method="post" enctype="multipart/form-data" action="http://www.freezylist.com/myoffersviewreply.php?touserid=236&amp;offerid=170&amp;type=sale&amp;listingid=184&amp;ownerid=237" novalidate="novalidate">
                                        <div class="form-group">
                                            <label class="col-sm-7 control-label">New Counter Offer Price</label>
                                            <div class="col-sm-5">
                                                <input type="text" id="offer_price" class="form-control" name="offer_price_re_counter" data-rule-number="true" data-rule-digits="true" data-rule-required="true" data-msg-number="Please enter valid price" data-msg-digits="Please only enter numbers!" data-msg-required="Please enter the price" value="" placeholder="Enter your counter offer price" aria-required="true">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                                <input type="submit" class="btn btn-default" name="submitrecount" id="inputbutton" value="Send">
                                                <button type="button" style="margin-top:20px;" id="toggle1close" class="btn btn-default">Cancel</button>
                                            </div></div>
                                    </form>
                                </div>
                            </td>
                            <td></td>
                            <td></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            @endif
            <!--Accept Modal start-->
            <div class="modal fade" id="confirm-accept" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header" style="text-align:left;">
                            <button type="button" class="close" data-dismiss="modal">×</button>
                            <h4 class="modal-title"><img src="img/informationarrow.png">&nbsp;Offer Acceptance Confirmation</h4>
                            <img src="img/bar.png">
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="err" id="add_err_fav_con"></div>
                                <div class="col-md-12 col-sm-12" id="favdiv">
                                    {{ html()->form('POST', route('frontend.accept.offer'))->class('form-horizontal')->open() }}
                                    <div id="usersignip-form">
                                        <div class="form-group">
                                            <div class="space">
                                                <p>Congratulations on your offer!</p>
                                                <p>Before accepting this offer, it is very important that you verify a few important items.</p>
                                                <p>In the "My Account" =&gt; "My Listings" =&gt; "For Sale" section of your menu options, please ensure the following items are correct:</p>
                                                <p></p><ul>
                                                    <li>Address</li>
                                                    <li>School Districts</li>
                                                    <li>Build Year</li>
                                                    <li>Amenities</li>
                                                    <li>Home-Owner Associations</li>
                                                    <li>Descriptions</li>
                                                </ul>
                                                <p></p>
                                                <p>In the "My Account" =&gt; "Edit Profile" section of your profile page, please also verify the following item(s):</p>
                                                <p></p><ul>
                                                    <li>Full (Legal) Name <strong>(Very Important!)</strong></li>
                                                    <li>Phone Number</li>
                                                    <li>Address</li>
                                                </ul>
                                                <p></p>
                                                <p><strong>Upon accepting this offer, you <u>WILL NOT</u> be able to modify any listing information on this property!</strong></p>
                                                <p>Would you like to accept this offer?<span style="padding-right: 130px;">&nbsp;</span>
                                                    <input type="hidden" name="id" value="{{ $offer->id }}">
                                                    <input type="submit" class="btn btn-default" name="submit" value="Confirm" style="width: 100px;">
                                                    <input type="button" class="btn btn-default" name="cancel" data-dismiss="modal" value="Cancel" style="width: 100px;">
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                    {{ html()->form()->close() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--Accept Modal end-->
            <!--reject Modal start-->
            <div class="modal fade" id="confirm-reject" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-body">
                            <div class="row">
                                <div class="err" id="add_err_fav_con"></div>
                                <div class="col-md-12 col-sm-12" id="favdiv">
                                    <form class="form-horizontal usersignup-form" role="form" name="confirmfav" id="lease-agreement-form-login-favorite-confirm" method="post">
                                        <div id="usersignip-form">
                                            <div class="form-group">
                                                <div class="space btns-green-blue">
                                                    <p>Are you sure you want to reject this offer?</p>
                                                    <input type="button" class="btn btn-greenn" name="submit" value="Confirm" onclick="rejectrecord('170', '237');">
                                                    <input type="button" class="btn btn-blue" name="cancel"  data-dismiss="modal" value="Cancel">
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('after-scripts')

<script>
    $(document).ready(function () {

        $('#toggle').on('click', function () {
            $('#flip').show();
        });

    });

  $('.money').mask('000,000,000,000,000', {reverse: true});
</script>
@endsection