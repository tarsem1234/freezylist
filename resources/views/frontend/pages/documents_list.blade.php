@extends ('frontend.layouts.app')
@section ('title', ('Document Portal'))
@section('after-styles')
<link type="text/css" rel="stylesheet" href="{{ asset(mix('css/forum.css')) }}" media="all">
<style>
    .back-button {
        position: absolute;
        right: 2%;
        bottom: -13%;
    }
    .back-button-blank {
        position: absolute;
        right: 2%;
        bottom: 18%;
    }
    .mb-5 {
        margin-bottom: 5%;
    }
    @media only screen and (max-width: 900px) {
        .back-button {
            position: relative;
            right: 2%;
            bottom: -13%;
            float: right;
        }
        .back-button-blank {
            position: relative;
            right: 2%;
            bottom: 18%;
            float: right;
        }
    }

</style>
@endsection
@section('content') 
<div class="contact-page forum-page"> 
    <div class="content-wrapper"> 
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="contact-banner">
                        <div class="text">Document Portal</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--     @include('frontend.common-home-icon.common_home_icon')-->
    <div class="content-wrapper">
        <div class="container">
            <div id="form_text_main"  class="row">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="head-img">
                        </div>
                    </div>
                    <h2>Instructions, Contracts and Disclosures</h2>
                    <div class="col-md-12">
                        <?php if (count($documents) > 0) { ?>
                            <div class="table-responsive"> 
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Document</th>
                                            <th>Download</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($documents as $index=>$document)
                                        <tr>
                                            <td>{{$index+1}}</td>
                                            <td class="blue-text">
                                                <a href="{{url('/storage/documents/'.$document->document)}}" target="blank">
                                                    <h4>{{$document->document}}</h4>
                                                </a>
                                            </td>
                                            <td>
                                                <a href="{{url('/storage/documents/'.$document->document)}}" download>
                                                    <h4>Download</h4>
                                                </a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table><!--table-->
                            </div>
                            <div class="back-button">
                                <a href="{{route('frontend.documentPortal')}}" class="btn btn-primary input-btn">Back</a>
                            </div>
                        <?php } else { ?>
                            <div class="text-center mb-5">
                                <h3>No Document Found.</h3>
                            </div>
                            <div class="back-button-blank">
                                <a href="{{route('frontend.documentPortal')}}" class="btn btn-primary input-btn">Back</a>
                            </div>
                        <?php } ?>

                    </div>
                </div>
                <div class="text-center" id="forum-pagination">
                    {{ $documents->links() }}<!--pagination-->
                </div>
            </div>
        </div>
    </div>
</div>
@endsection