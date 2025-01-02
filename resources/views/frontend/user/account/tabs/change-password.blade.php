{{ html()->form('PATCH', route('frontend.auth.password.change', ))->class('form-horizontal')->open() }}

    <div class="form-group">
        {{ html()->label(trans('validation.attributes.frontend.old_password'), 'old_password')->class('col-md-4 control-label') }}
        <div class="col-md-6">
            {{ html()->password('old_password')->class('form-control')->attribute('required', 'required')->attribute('autofocus', 'autofocus')->attribute('placeholder', trans('validation.attributes.frontend.old_password')) }}
        </div>
    </div>

    <div class="form-group">
        {{ html()->label(trans('validation.attributes.frontend.new_password'), 'password')->class('col-md-4 control-label') }}
        <div class="col-md-6">
            {{ html()->password('password')->class('form-control')->attribute('required', 'required')->attribute('placeholder', trans('validation.attributes.frontend.new_password')) }}
        </div>
    </div>

    <div class="form-group">
        {{ html()->label(trans('validation.attributes.frontend.new_password_confirmation'), 'password_confirmation')->class('col-md-4 control-label') }}
        <div class="col-md-6">
            {{ html()->password('password_confirmation')->class('form-control')->attribute('required', 'required')->attribute('placeholder', trans('validation.attributes.frontend.new_password_confirmation')) }}
        </div>
    </div>

    <div class="form-group">
        <div class="col-md-6 col-md-offset-4">
            {{ html()->submit(trans('labels.general.buttons.update'))->class('btn btn-primary')->id('change-password') }}
        </div>
    </div>

{{ html()->form()->close() }}