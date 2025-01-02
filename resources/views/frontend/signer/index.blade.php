@extends ('frontend.layouts.app')
@section ('title', ('Signer'))
@section('after-styles')
<link type="text/css" rel="stylesheet" href="{{ asset(mix('css/dashboard.css')) }}" media="all">
<style>#mysigner{ font-weight: bold;color: #000;}</style>
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
                            <div class="col-md-12">
                                <h4 class="pull-left">My Signer</h4>                          
                                <a href="{{ route('frontend.signer.create') }}"><button id="addlisting-btn"> Add New Signers </button></a>
                            </div>
                        </div>
                        <div class="">
                                        <?php if ($signers && count($signers)>0) { ?>
                            <div class="table-responsive">
                                <table class="table table-striped ">
                                    <thead>
                                        <tr>
                                            <th>Signer Name</th>
                                            <th>Signer Email</th>
                                            <th>Profile Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                            @foreach ($signers as $key => $sign)
                                                <tr data-id="{{$sign->invited_users['id']}}">
                                                    <td>{{ getFullName($sign->invited_users) }}</td>
                                                    <td class="blue-text">{{$sign->invited_users->email??"NA"}}</td>
                                                    <td class="active">{{(isset($sign->invited_users) && $sign->invited_users->status == config('constant.inverse_signer_status.Active')) ? 'Active' : 'Inactive'}}</td>
                                                    <td>
                                                        @if(isset($sign->invited_users->status) && $sign->invited_users->status == config('constant.inverse_signer_status.Active'))
                                                        <a href="{{route('frontend.signer.view',$sign->invited_users->id)}}" type="button" class="btn btn-info btn-lg icon-btn" title="View"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                                        @else
                                                        <span type="button" class="btn btn-info btn-lg icon-btn" data-toggle="modal" data-target="#myModal-{{$sign->invited_users['id']}}" title="Re-send confirmation mail"><i class="fa fa-paper-plane"></i></span>
                                                        @endif
                                                        <span type="button" class="btn btn-info btn-lg icon-btn  delete-icon" data-toggle="modal" data-target="#confirm-delete-{{$sign->invited_users['id']}}" title="Delete"><i class="fa fa-trash-o"></i> </span>
                                                        <!-- Modal -->
                                                        <div class="modal fade" id="myModal-{{$sign->invited_users['id']}}" role="dialog">
                                                            <div class="modal-dialog">
                                                                <!-- Modal content-->
                                                                <div class="modal-content">
                                                                    <div class="modal-body">
                                                                        <p>Are you sure you want to re-send the activation email to signer?</p>
                                                                    </div>
                                                                    <div class="text-center btns-green-blue small-buttons">
                                                                        <a href="{{ route('frontend.resend.activation',$sign->invited_users['id']) }}" type="button" class="btn btn-green">Confirm</a>
                                                                        <button type="button" class="button btn btn-blue" data-dismiss="modal">Cancel</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal fade" id="confirm-delete-{{$sign->invited_users['id']}}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog">
                                                                <div class="modal-content">
                                                                    <div class="modal-body">
                                                                        <div class="row">
                                                                            <div class="err" id="add_err"></div>
                                                                            <div class="col-md-12 col-sm-12" id="favdiv">
                                                                                <div id="usersignip-form">
                                                                                    <div class="form-group">
                                                                                        <div class="text-center btns-green-blue">
                                                                                            <p>Are you sure you want to delete this partner from your list?</p>
                                                                                            <a href="{{ route('frontend.delete.signer',$sign->id) }}" class="btn btn-green">Confirm</a>
                                                                                            <a href="" class="btn btn-blue" data-dismiss="modal">Cancel</a>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                           @endforeach
                                        
                                    </tbody>
                                </table><!--table-->
                            </div><!-- table-responsive -->
                            <?php } else { ?>
                            <h3>No record found.</h3>
                                        <?php } ?>
                        </div>
                                           {{ $signers->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection