@extends ('backend.layouts.app')

@section ('title', ('Support Management') . ' | ' . ('Support Create'))

@section('page-header')
<h1>
   Support Management
</h1>
@endsection

@section('content')
{{ html()->form('POST', route('admin.access.user.store'))->class('form-horizontal')->attribute('role', 'form')->open() }}
<div class="box box-success">
   <div class="box-header with-border">
      <h3 class="box-title">Create Support User</h3>

      <div class="box-tools pull-right">
         @include('backend.access.includes.partials.user-header-buttons')
      </div><!--box-tools pull-right-->
   </div><!-- /.box-header -->
   <div class="box-body">
      <div class="form-group">
         {{ html()->label(trans('validation.attributes.backend.access.users.first_name'), 'first_name')->class('col-lg-2 control-label') }}

         <div class="col-lg-10">
            {{ html()->text('first_name')->class('form-control')->maxlength('191')->autofocus('autofocus')->placeholder(trans('validation.attributes.backend.access.users.first_name')) }}
            @if(count($errors->get('first_name')) > 0)
            <span class="backend-errors alert-danger">{{ $errors->first('first_name') }}</span>
            @endif
         </div><!--col-lg-10-->
      </div><!--form control-->
      <div class="form-group">
         {{ html()->label(trans('validation.attributes.backend.access.users.last_name'), 'last_name')->class('col-lg-2 control-label') }}
         <div class="col-lg-10">
            {{ html()->text('last_name')->class('form-control')->maxlength('191')->required()->placeholder(trans('validation.attributes.backend.access.users.last_name')) }}
            @if(count($errors->get('last_name')) > 0)
            <span class="backend-errors alert-danger">{{ $errors->first('last_name') }}</span>
            @endif
         </div><!--col-lg-10-->
      </div><!--form control-->
      <div class="form-group">
         {{ html()->label(trans('validation.attributes.backend.access.users.email'), 'email')->class('col-lg-2 control-label') }}
         <div class="col-lg-10">
            {{ html()->email('email')->class('form-control')->attribute('maxlength', '191')->attribute('required', 'required')->attribute('placeholder', trans('validation.attributes.backend.access.users.email')) }}
            @if(count($errors->get('email')) > 0)
            <span class="backend-errors alert-danger">{{ $errors->first('email') }}</span>
            @endif
         </div><!--col-lg-10-->
      </div><!--form control-->
      <div class="form-group">
         {{ html()->label(trans('validation.attributes.backend.access.users.password'), 'password')->class('col-lg-2 control-label') }}
         <div class="col-lg-10">
            {{ html()->password('password')->class('form-control')->attribute('required', 'required')->attribute('placeholder', trans('validation.attributes.backend.access.users.password')) }}
            @if(count($errors->get('password')) > 0)
            <span class="backend-errors alert-danger">{{ $errors->first('password') }}</span>
            @endif
         </div><!--col-lg-10-->
      </div><!--form control-->
      <div class="form-group">
         {{ html()->label(trans('validation.attributes.backend.access.users.password_confirmation'), 'password_confirmation')->class('col-lg-2 control-label') }}
         <div class="col-lg-10">
            {{ html()->password('password_confirmation')->class('form-control')->attribute('required', 'required')->attribute('placeholder', trans('validation.attributes.backend.access.users.password_confirmation')) }}
            @if(count($errors->get('password_confirmation')) > 0)
            <span class="backend-errors alert-danger">{{ $errors->first('password_confirmation') }}</span>
            @endif
         </div><!--col-lg-10-->
      </div><!--form control-->
      <div class="form-group">
         {{ html()->label(trans('validation.attributes.backend.access.users.active'), 'status')->class('col-lg-2 control-label') }}
         <div class="col-lg-1">
            {{ html()->checkbox('status', true, '1') }}
         </div><!--col-lg-1-->
      </div><!--form control-->
      <div class="form-group">
         {{ html()->label(trans('validation.attributes.backend.access.users.associated_roles'), 'associated_roles')->class('col-lg-2 control-label') }}
         <div class="col-lg-3">
            @if (count($roles) > 0)
            @foreach($roles as $role)
            @if($role->id == config('constant.inverse_user_type.Support'))
            <input type="hidden"  value="{{ $role->id }}" checked="checked" name="assignees_roles[{{ $role->id }}]" id="role-{{ $role->id }}" {{ is_array(old('assignees_roles')) && in_array($role->id, old('assignees_roles')) ? 'checked' : '' }} /> <label for="role-{{ $role->id }}">{{ $role->name }}</label>
            <a href="#" data-role="role_{{ $role->id }}" class="show-permissions small">
               (
               <span class="show-text">{{ trans('labels.general.show') }}</span>
               <span class="hide-text hidden">{{ trans('labels.general.hide') }}</span>
               {{ trans('labels.backend.access.users.permissions') }}
               )
            </a>
            <br/>
            <div class="permission-list hidden" data-role="role_{{ $role->id }}">
               @if ($role->all)
               {{ trans('labels.backend.access.users.all_permissions') }}<br/><br/>
               @else
               @if (count($role->permissions) > 0)
               <blockquote class="small">{{--
                                        --}}@foreach ($role->permissions as $perm){{--
                                            --}}{{$perm->display_name}}<br/>
                  @endforeach
               </blockquote>
               @else
               {{ trans('labels.backend.access.users.no_permissions') }}<br/><br/>
               @endif
               @endif
            </div><!--permission list-->
            @endif
            @endforeach
            @else
            {{ trans('labels.backend.access.users.no_roles') }}
            @endif
         </div><!--col-lg-3-->
      </div><!--form control-->
   </div><!-- /.box-body -->
</div><!--box-->

<div class="box box-info">
   <div class="box-body">
      <div class="pull-left">
          <a href="{{ URL::previous() }}" class="btn btn-danger btn-xs">Cancel</a>
      </div><!--pull-left-->

      <div class="pull-right">
          <button type="submit" name="submit" class="btn btn-success btn-xs" value="Support">{{trans('buttons.general.crud.create')}}</button>
      </div><!--pull-right-->

      <div class="clearfix"></div>
   </div><!-- /.box-body -->
</div><!--box-->

{{ html()->form()->close() }}
@endsection

@section('after-scripts')
<script src="{{ asset('js/backend/access/users/script.js') }}"></script>
@endsection
