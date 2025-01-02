@extends ('frontend.layouts.app')
@section ('title', ('Business Reviews'))
@section('after-styles')
<link type="text/css" rel="stylesheet" href="{{ asset(mix('css/dashboard.css')) }}" media="all">
<style>#myassociates{ font-weight: bold;color: #000;}</style>
@endsection 
@section('content') 
<div class="forum-page signer-page dashboard-page associates profile-view">    
    <div class="container">
        <div class="row content">
            @include('frontend.includes.sidebar')
            <div class="col-md-9 col-sm-8">
                <div class="right-dashboard-div">
                    <div class="profile right-dashboard-div-text">
                        <div class="row"> 
                            <div class="col-md-12 col-xs-12 col-sm-12 col-lg-12">
                                <h4>Business Reviews</h4>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                    <th>#</th>
                                    <th>Review User</th>
                                    <th>Review</th>
                                    <th>Rating</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($ratings as $key => $rating)
                                    <tr>
                                    <td>{{$key+1}}</td>
                                    <td>
                                        @if($rating->ratedBy->user_profile)
                                        {{$rating->ratedBy->user_profile->full_name}}
                                        @elseif($rating->ratedBy->business_profile)
                                        {{$rating->ratedBy->business_profile->company_name}}
                                        @endif
                                    </td>
                                    <td><!--{{$rating->review}}-->
                                        <!-- Trigger the modal with a button -->
                                        <a type="button" class="" data-toggle="modal" data-target="#myModal{{$key}}"><i class="fa fa-eye" aria-hidden="true"></i></a>  

                                        <!-- Modal -->
                                        <div id="myModal{{$key}}" class="modal fade" role="dialog">
                                            <div class="modal-dialog">

                                                <!-- Modal content-->
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                        <h4 class="modal-title">REVIEW</h4>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>{{$rating->review}}</p> 
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </td>
                                    <td><div class="table-user-rating" data-rating='{{$rating->rating}}'></div></td>
                                    </tr>
                                    @empty
                                    <tr><td colspan="4">No reviews have been posted for this Pro Servicer</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                            {{ $ratings->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('after-scripts')
<script src="{{ asset('js/starr.min.js') }}"></script>
<script>
    $(function () {
        $('.table-user-rating').each(function () {
            rating = $(this).data('rating');
            $(this).starrr({
                rating: rating,
                readOnly: true
            });
        });
    });
</script>
@endsection