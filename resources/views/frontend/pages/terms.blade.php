@extends ('frontend.layouts.app')

@section ('title', ('Terms & Conditions'))

@section('after-styles')
<link type="text/css" rel="stylesheet" href="{{ asset(mix('css/contact.css')) }}" media="all">
@endsection 

@section('content') 
<div class="contact-page"> 
    <div class="content-wrapper">
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="contact-banner">
                        <div class="text">Terms & Conditions</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@include('frontend.common-home-icon.common_home_icon')
    <div class="container margin-bottom">
        <div class="row">
        <div class="col-lg-12">
            <?php echo $page->content; ?>
        </div>
        </div>
    </div>
</div>
<!--<div class="row narwhal-realaty-heading">
   <div class="container">
      <div class="col-sm-12">
         <h2>NARWHAL REALATY, INC.</h2>
      </div>
   </div>
</div>
<div class="row effective-as-row">
   <div class="container">
      <div class="col-sm-12 col-xs-12  effective-as-div">
         <h3>(Effective as of 15-March-2016)</h3>
         <p>Welcome to Freezylist.com (the “Service”).  
            The following Terms of Use apply when you view or use the Service via our website located 
            at <a>www.freezylist.com.</a> Please review the following terms carefully.  By accessing or
            using the Service, you signify your agreement to these Terms of Use.If you do not 
            agree to these Terms of Use, you may not access or use the Service.
         </p>
      </div>
   </div>
</div>
<div class="row effective-as-row">
   <div class="container">
      <div class="col-sm-12 col-xs-12  effective-as-div">
         <h3>(Effective as of 15-March-2016)</h3>
         <p>Welcome to Freezylist.com (the “Service”).  
            The following Terms of Use apply when you view or use the Service via our website located 
            at <a>www.freezylist.com.</a> Please review the following terms carefully.  By accessing or
            using the Service, you signify your agreement to these Terms of Use.If you do not 
            agree to these Terms of Use, you may not access or use the Service.
         </p>
      </div>
   </div>
</div>
<div class="row effective-as-row">
   <div class="container">
      <div class="col-sm-12 col-xs-12  effective-as-div">
         <h3>(Effective as of 15-March-2016)</h3>
         <p>Welcome to Freezylist.com (the “Service”).  
            The following Terms of Use apply when you view or use the Service via our website located 
            at <a>www.freezylist.com.</a> Please review the following terms carefully.  By accessing or
            using the Service, you signify your agreement to these Terms of Use.If you do not 
            agree to these Terms of Use, you may not access or use the Service.
         </p>
      </div>
   </div>
</div>
<div class="row effective-as-row">
   <div class="container">
      <div class="col-sm-12 col-xs-12  effective-as-div">
         <h3>(Effective as of 15-March-2016)</h3>
         <p>Welcome to Freezylist.com (the “Service”).  
            The following Terms of Use apply when you view or use the Service via our website located 
            at <a>www.freezylist.com.</a> Please review the following terms carefully.  By accessing or
            using the Service, you signify your agreement to these Terms of Use.If you do not 
            agree to these Terms of Use, you may not access or use the Service.
         </p>
      </div>
   </div>
</div>
<div class="row effective-as-row">
   <div class="container">
      <div class="col-sm-12 col-xs-12  effective-as-div">
         <h3>(Effective as of 15-March-2016)</h3>
         <p class="last-para">Welcome to Freezylist.com (the “Service”).  
            The following Terms of Use apply when you view or use the Service via our website located 
            at <a>www.freezylist.com.</a> Please review the following terms carefully.  By accessing or
            using the Service, you signify your agreement to these Terms of Use.If you do not 
            agree to these Terms of Use, you may not access or use the Service.
         </p>
      </div>
   </div>
</div>-->
@endsection

@section('after-scripts')

<script>
   $(function () {

   });


</script>
@endsection 
