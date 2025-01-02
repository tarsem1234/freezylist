{{ html()->form('POST', route('frontend.contact.send'))->class('form-horizontal form-we-help-you')->acceptsFiles()->open() }}
@include('frontend.common-home-icon.common_home_icon')
<div class="form-div"> 
   <div class="container">
      <div class="heading">
         <h2>How can we help?</h2> 
         <!--<p>Let's Talk</p>-->
      </div>
      <div class="row inputs-field-textarea">
         <div class="col-sm-12 input-text-row">
            <div class="col-sm-6 col-xs-12 input-text">
               {{ html()->text('name')->class('form-control')->maxlength('191')->required()->placeholder('Name') }}
            </div>
            <div class="col-sm-6 col-xs-12 input-text">
               {{ html()->text('email')->class('form-control ')->maxlength('191')->required()->placeholder('Email') }}
            </div>
         </div>
         <div class="col-sm-12 input-text-row">
            <div class="col-sm-6 col-xs-12 input-text">
               {{ html()->number('phone')->class('form-control ')->attribute('maxlength', '191')->attribute('required', 'required')->attribute('placeholder', 'Phone') }}
            </div>
            <div class="col-sm-6 col-xs-12 input-text">
               {{ html()->text('address')->class('form-control ')->maxlength('191')->required()->placeholder('Address') }}
            </div>
         </div>
         <div class="col-sm-12 textarea-comment">
            {{ html()->textarea('comment')->class('form-control ')->required()->placeholder('Comment') }}
         </div>
         @if (config('access.captcha.registration'))
                        <div class="form-group contact-captcha col-sm-12 textarea-comment">
                            <div class="col-md-4 col-md-offset-0">
                              {!! NoCaptcha::display() !!}
                                
                                {{ html()->hidden('captcha_status', 'true') }}
                            </div><!--col-md-6-->
                            <div id="captchaError"></div>
                        </div><!--form-group-->
         @endif

         <div class="text-center col-sm-12 textarea-comment">
         {{ html()->submit('Send')->class('btn btn-send') }}
         </div>
      </div>
   </div>
</div>
{{ html()->form()->close() }} 


