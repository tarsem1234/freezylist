{{ html()->modelForm($logged_in_user, 'PATCH', route('frontend.user.profile.update'))->class('form-horizontal')->open() }}

    <div class="form-group">
        {{ html()->label(trans('validation.attributes.frontend.first_name'), 'first_name')->class('col-md-4 control-label') }}
        <div class="col-md-6">
            {{ html()->text('first_name')->class('form-control')->required()->autofocus('autofocus')->maxlength('191')->placeholder(trans('validation.attributes.frontend.first_name')) }}
        </div>
    </div>
    <div class="form-group">
        {{ html()->label(trans('validation.attributes.frontend.last_name'), 'last_name')->class('col-md-4 control-label') }}
        <div class="col-md-6">
            {{ html()->text('last_name')->class('form-control')->required()->maxlength('191')->placeholder(trans('validation.attributes.frontend.last_name')) }}
        </div>
    </div>

    @if ($logged_in_user->canChangeEmail())
        <div class="form-group">
            {{ html()->label(trans('validation.attributes.frontend.email'), 'email')->class('col-md-4 control-label') }}
            <div class="col-md-6">
                <div class="alert alert-info">
                    <i class="fa fa-info-circle"></i> {{  trans('strings.frontend.user.change_email_notice') }}
                </div>

                {{ html()->email('email')->class('form-control')->attribute('required', 'required')->attribute('maxlength', '191')->attribute('placeholder', trans('validation.attributes.frontend.email')) }}
            </div>
        </div>
    @endif

    <div class="form-group">
        <div class="col-md-6 col-md-offset-4">
            {{ html()->submit(trans('labels.general.buttons.update'))->class('btn btn-primary')->id('update-profile') }}
        </div>
    </div>

{{ html()->closeModelForm() }}