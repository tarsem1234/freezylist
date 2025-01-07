@extends('frontend.layouts.app')

@section('content')

@include('frontend.landing-page.landing_home')

@endsection

@section('after-scripts')
    <script>
        $(document).ready(function () {
            $(':input[type=number]').on('mousewheel', function (e) {
                $(this).blur();
            });
        });
    </script>
@endsection