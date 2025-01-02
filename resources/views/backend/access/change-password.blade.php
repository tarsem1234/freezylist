@extends ('backend.layouts.app')

@section ('title', trans('labels.backend.access.users.management') . ' | ' . trans('labels.backend.access.users.change_password'))

@section('page-header')
<h1>
    @if (count($user->roles) > 0)
    @if(in_array(config('constant.inverse_user_type.Business'), array_column($user->roles->toArray(), 'id')))
    {{ trans('labels.backend.access.users.business_management') }}
    @elseif(in_array(config('constant.inverse_user_type.User'), array_column($user->roles->toArray(), 'id')))
    {{ trans('labels.backend.access.users.user_management') }}
    @elseif(in_array(config('constant.inverse_user_type.Administrator'), array_column($user->roles->toArray(), 'id')))
    {{ trans('labels.backend.access.users.admin_management') }}
    @elseif(in_array(config('constant.inverse_user_type.Support'), array_column($user->roles->toArray(), 'id')))
    Support Management
    @endif
    @endif
</h1>
@endsection

@section('content')
{{ html()->form('PATCH', route('admin.access.user.change-password.post', [$user]))->class('form-horizontal')->attribute('role', 'form')->open() }}

<div class="box box-success">
   <div class="box-header with-border">
      <h3 class="box-title">{{ trans('labels.backend.access.users.change_password_for', ['user' => getFullName($user)]) }}</h3>

      <div class="box-tools pull-right">
         @include('backend.access.includes.partials.user-header-buttons')
      </div><!--box-tools pull-right-->
   </div><!-- /.box-header -->

   <div class="box-body">
      <div class="form-group">
         {{ html()->label(trans('validation.attributes.backend.access.users.password'), 'password')->class('col-lg-2 control-label')->attribute('placeholder', trans('validation.attributes.backend.access.users.password')) }}
         <div class="col-lg-10">
            {{ html()->password('password')->class('form-control')->attribute('required', 'required')->attribute('autofocus', 'autofocus') }}
            @if(count($errors->get('password')) > 0)
            <span class="backend-errors alert-danger">{{ $errors->first('password') }}</span>
            @endif
         </div><!--col-lg-10-->
      </div><!--form control-->

      <div class="form-group">
         {{ html()->label(trans('validation.attributes.backend.access.users.password_confirmation'), 'password_confirmation')->class('col-lg-2 control-label')->attribute('placeholder', trans('validation.attributes.backend.access.users.password_confirmation')) }}
         <div class="col-lg-10">
            {{ html()->password('password_confirmation')->class('form-control')->attribute('required', 'required') }}
            @if(count($errors->get('password_confirmation')) > 0)
            <span class="backend-errors alert-danger">{{ $errors->first('password_confirmation') }}</span>
            @endif
         </div><!--col-lg-10-->
      </div><!--form control-->
   </div><!-- /.box-body -->
</div><!--box-->

<div class="box box-info">
   <div class="box-body">
      <div class="pull-left">
         <a href="{{ URL::previous() }}" class="btn btn-danger btn-xs">Cancel</a>
      </div><!--pull-left-->

      <div class="pull-right">
         {{ html()->submit(trans('buttons.general.crud.update'))->class('btn btn-success btn-xs') }}
      </div><!--pull-right-->

      <div class="clearfix"></div>
   </div><!-- /.box-body -->
</div><!--box-->

{{ html()->form()->close() }}
@endsection
