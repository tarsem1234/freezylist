@extends ('frontend.layouts.app')
@section ('title', ('Rent Lease Agreement'))
@section('after-styles')
<link type="text/css" rel="stylesheet" href="{{ asset(mix('css/contract_tools.css')) }}" media="all">
@endsection
@section('content')
<div class="container purchase-sale-agreement-review contract-tools-seller-common">
   <div class="row">
      <div class="">
         <div class="sidebar">
            @include('frontend.includes.sidebar')
         </div>
         <div class="col-md-9 col-sm-8">
                <div class="nested-div register-page">
                    <div class="include-text">
                        @include('frontend.contract_tools.include_files.lease_agreement_review_commom_text')
                    </div>
                    <div class="form-group btns-green-blue">
                     <div class="col-sm-12">
                        <div class="btns-green-blue">
                            <a href="{{URL::previous()}}" class="button btn btn-blue">Back</a>
                        </div>
                     </div>
                  </div>
                </div>
            </div>
      </div><!--</col>-->
   </div><!--</row>-->
</div><!--</contract-tools-seller-common>-->
@endsection
	    @section('after-scripts')
	    <script>
                $(document).ready(function () {
				    //resize the width as per content
					function resizeInput() {
					if($(this).val().length>20){
						$(this).attr('size', $(this).val().length-25);
					}
				    else{
						$(this).attr('size', $(this).val().length);
					}
					}

					$('input[name="custom_state"]')
					// event handler
					.keyup(resizeInput)
					// resize on page load
					.each(resizeInput);
                });
	    </script>
	    @endsection
