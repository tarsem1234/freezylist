@extends('frontend.layouts.app')
@section ('title', ('Blog'))
@section('after-styles')
<link type="text/css" rel="stylesheet" href="{{ asset(mix('css/blog.css')) }}" media="all">
@endsection  
@section('content')
<div class="contact-page blog-page blog-bg blog-main">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="contact-banner">
                        <div class="text">Freezylist Blog</div>
                    </div><!--content-banner-->
                </div>
            </div><!--coi-12-->
        </div><!--row-->
    </div><!--content-wrapper-->
    <div class="blog-pics">
        <div class="container">
            <div class="row" id="blog-data-append">
                <div class="col-lg-12">
                    <?php
                    if ($blogs) {
                        ?>
                        @foreach($blogs as $blog)
                        <div class="col-md-6 col-sm-6">
                            <div class="blog-box">
                                <a href="{{ route('frontend.blogs.show',$blog->slug) }}">
                                    <div class="blog-pic">
                                        <div class="blog-pic-1"><img src="{{asset('storage'.'/'. $blog->image )}}" style="height: 309px;" alt="blog-pic"/></div>
                                    </div><!--blog-pic-->
                                    <div class="blog-text">
                                        <h4>{{date("d F Y", strtotime($blog->created_at))}}</h4>
                                        <h5>{{$blog->title}}</h5>
                                        <p>{{strip_tags(substr($blog->content, 0, 150))}}..</p>
                                        @if(strlen($blog->content) > 150)
                                        <h6>Read more <span><i class="fa fa-long-arrow-right"></i></span></h6>
                                        @endif
                                    </div><!--blog-text-->
                                </a>
                            </div><!--blog-box-->
                        </div><!--col-6-->
                        @endforeach
                    <?php } else { ?>
                        <h2> We are drafting some new ideas. Check back in shortly. </h2>
                    <?php } ?>
                    <div class="col-md-12" id="blog-pagination">
                        {{ $blogs->links() }}
                    </div>
                </div>
            </div><!--row-->
        </div><!--container-->
    </div><!--blog-pics-->
</div>
@endsection

@section('after-scripts')
@endsection