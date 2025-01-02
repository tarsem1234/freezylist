@extends ('frontend.layouts.app')
@section ('title', ('Document Portal'))
@section('after-styles')
<link type="text/css" rel="stylesheet" href="{{ asset(mix('css/profile-edit.css')) }}" media="all">
@endsection
@section('content')
<div class="login-page"> 
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="login-banner">
                        <div class="text">Document Portal</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="document-portal">
                <div class="col-md-12">                    
                        <div class="col-md-3 col-lg-3 col-xs-6 col-sm-4">
                            <a href="{{route('frontend.documentsList',config('constant.instructions'))}}">
                            <div class="center">
                                <h2>Instructions</h2>
                                <div class="btn-search">
                                    <i class="fa fa-download" aria-hidden="true"></i><button type="submit" class="btn downloadbtn"> Instructions</button>
                                </div>
                            </div>
                            </a>
                        </div>                    
                </div>


                <div class="col-md-12">
                    @foreach($states as $state)
                    <div class="col-md-3 col-lg-3 col-xs-6 col-sm-4">                        
                        <a href="{{route('frontend.documentsList',$state->id)}}">
                            <div class="center">
                                <h2>{{$state->state}}</h2>
                                <div class="btn-search">
                                    <i class="fa fa-download" aria-hidden="true"></i><button type="submit" class="btn downloadbtn"> Download</button>
                                </div>
                            </div>
                        </a>                        
                    </div>
                  @endforeach
                </div>
            </div>
            <div class="text-center">
                {{ $states->links() }}
            </div>

        </div>
    </div>
</div>
@endsection