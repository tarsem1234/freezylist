@extends ('frontend.layouts.app')
@section ('title', ('Received Requests'))
@section('after-styles')
<link type="text/css" rel="stylesheet" href="{{ asset(mix('css/dashboard.css')) }}" media="all">
<link type="text/css" rel="stylesheet" href="{{ asset(mix('css/forum.css')) }}" media="all">
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
                                <h4>My Received Requests</h4>
                            </div>
                        </div>
                        <div class="">
                            <?php if ($requests->count()) { ?>
                                <div class="table-responsive">
                                    <table class="table table-striped ">
                                        <thead>
                                            <tr>
                                                <th>Request From</th>
                                                <th>Date</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($requests as $request)
                                            <tr>
 
                                                <td>{{getFullName($request->request_from_user)}}</td>
                                                <td>{{date("d F Y", strtotime($request->created_at))}}</td>
                                                <td>@if($request->status==0) Pending @else Approved @endif</td>
                                                <td>
                                                    <a href="{{ route('frontend.accept.request',$request->from_user_id) }}" type="button" class="btn btn-info btn-lg icon-btn"  title="Accept Request"><i class="fa fa-check" aria-hidden="true"></i></a>
                                                    <a type="button" class="btn btn-info btn-lg icon-btn" data-toggle="modal" data-target="#myModal-{{$request->id}}"  title="Reject Request"><i class="fa fa-times" aria-hidden="true"></i></a>
                                                    <a href="{{ route('frontend.network.userDetails',$request->from_user_id) }}" type="button" class="btn btn-info btn-lg icon-btn" title="View"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                                    <!-- Modal -->
                                                    <div class="modal fade" id="myModal-{{$request->id}}" role="dialog">
                                                        <div class="modal-dialog">
                                                            <!-- Modal content-->
                                                            <div class="modal-content text-center">
                                                                <div class="modal-body">
                                                                    <p>Are you sure you want to reject the request?</p>
                                                                </div>
                                                                <div class="text-center text-center">
                                                                    <a href="{{ route('frontend.reject.request',$request->from_user_id) }}" class="btn btn-default">Confirm</a>
                                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table><!--table-->

                                </div><!-- col-md-12 -->
                            <?php } else { ?>
                                <h4 class="no-data">You don't have any new requests pending for approval. </h4>
                            <?php } ?>
                                {{ $requests->links() }}
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


    });
</script>
@endsection