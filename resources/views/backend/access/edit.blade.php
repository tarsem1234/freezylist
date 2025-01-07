@extends ('backend.layouts.app')

@section ('title', trans('labels.backend.access.users.management') . ' | ' . trans('labels.backend.access.users.edit'))

@section('page-header')
<h1>
    @if (count($roles) > 0)
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
{{ html()->modelForm($user, 'PATCH', route('admin.access.user.update', [$user]))->class('form-horizontal')->attribute('role', 'form')->open() }}
<div class="box box-success">
    <div class="box-header with-border">
        @foreach($user->roles as $role)
        @if($role->name == config('constant.user_type.3') )
        <h3 class="box-title">{{ trans('labels.backend.access.users.edit') }}</h3>
        @elseif($role->name == config('constant.user_type.2') )
        <h3 class="box-title">Edit Business User</h3>
        @elseif($role->name == config('constant.user_type.4') )
        <h3 class="box-title">Edit Support User</h3>
        @else
        <h3 class="box-title">Edit Admin User</h3>
        @endif
        @endforeach
        <div class="box-tools pull-right">
            @include('backend.access.includes.partials.user-header-buttons')
        </div><!--box-tools pull-right-->
    </div><!-- /.box-header -->
    <div class="box-body">
        @foreach($user->roles as $role)
        @if($role->name == config('constant.user_type.2') )
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
         </div>
        <div class="form-group">
            {{ html()->label('Company Name', 'company_name')->class('col-lg-2 control-label') }}
            <div class="col-lg-10">
                {{ html()->text('company_name', $userWithUser->business_profile->company_name ?? "")->class('form-control')->maxlength('191')->required()->autofocus('autofocus')->placeholder('Company Name') }}
                @if(count($errors->get('company_name')) > 0)
                <span class="backend-errors alert-danger">{{ $errors->first('company_name') }}</span>
                @endif
            </div><!--col-lg-10-->
        </div><!--form control-->

        <div class="form-group">
            {{ html()->label(trans('validation.attributes.backend.access.users.email'), 'email')->class('col-lg-2 control-label') }}

            <div class="col-lg-10">
                {{ html()->email('email')->attribute('readonly', )->class('form-control')->attribute('maxlength', '191')->attribute('required', 'required')->attribute('placeholder', trans('validation.attributes.backend.access.users.email')) }}
                @if(count($errors->get('email')) > 0)
                <span class="backend-errors alert-danger">{{ $errors->first('email') }}</span>
                @endif
            </div><!--col-lg-10-->
        </div><!--form control-->

        <div class="form-group">
            {{ html()->label('Industry', 'industry')->class('col-lg-2 control-label') }}
            <!--<label for="city" class="col-lg-2 control-label">City</label>-->
            <div class="col-lg-10">
                <select name="industry" id="select_industry" class="form-control title-input">
                    @if(isset($businessIndustry) && !empty($businessIndustry))
                    <option value="{{ $businessIndustry->id }}" selected>{{ $businessIndustry->industry }}</option>
                    @foreach($industries as $industry)
                    <option value="{{ $industry->id }}">{{ $industry->industry }}</option>
                    @endforeach
                    @else
                    @if( isset($industries) )
                    <option value="" disabled selected hidden>Select Industry</option>
                    @foreach($industries as $industry)
                    <option value="{{ $industry->id }}">{{ $industry->industry }}</option>
                    @endforeach
                    @endif
                    @endif
                </select>
                @if(count($errors->get('industry')) > 0)
                <span class="backend-errors alert-danger">{{ $errors->first('industry') }}</span>
                @endif
            </div>
        </div>
        @endif
        <!--Edit Simple User-->
        @if($role->name == config('constant.user_type.1') || $role->name == config('constant.user_type.4'))
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
        @endif

        @if($role->name == config('constant.user_type.3'))

        <div class="form-group">
            {{ html()->label(trans('validation.attributes.backend.access.users.first_name'), 'first_name')->class('col-lg-2 control-label') }}

            <div class="col-lg-10">
               {{ html()->text('first_name',$userWithUser->first_name ?? "")->class('form-control')->maxlength('191')->autofocus('autofocus')->placeholder(trans('validation.attributes.backend.access.users.first_name')) }}
               @if(count($errors->get('first_name')) > 0)
               <span class="backend-errors alert-danger">{{ $errors->first('first_name') }}</span>
               @endif
            </div><!--col-lg-10-->
         </div><!--form control-->
         <div class="form-group">
            {{ html()->label(trans('validation.attributes.backend.access.users.last_name'), 'last_name')->class('col-lg-2 control-label') }}
            <div class="col-lg-10">
               {{ html()->text('last_name',$userWithUser->last_name ?? "")->class('form-control')->maxlength('191')->required()->placeholder(trans('validation.attributes.backend.access.users.last_name')) }}
               @if(count($errors->get('last_name')) > 0)
               <span class="backend-errors alert-danger">{{ $errors->first('last_name') }}</span>
               @endif
            </div><!--col-lg-10-->
         </div><!--form control-->
        
        @endif

        @if($role->name == config('constant.user_type.3') || $role->name == config('constant.user_type.1') || $role->name == config('constant.user_type.4'))
        <div class="form-group">
            {{ html()->label(trans('validation.attributes.backend.access.users.email'), 'email')->class('col-lg-2 control-label') }}
            <div class="col-lg-10">
                {{ html()->email('email')->attribute('readonly', )->class('form-control')->attribute('maxlength', '191')->attribute('required', 'required')->attribute('placeholder', trans('validation.attributes.backend.access.users.email')) }}
                @if(count($errors->get('email')) > 0)
                <span class="backend-errors alert-danger">{{ $errors->first('email') }}</span>
                @endif
            </div><!--col-lg-10-->
        </div><!--form control-->
        @endif

        @if($role->name == config('constant.user_type.3'))
        <div class="form-group">
            {{ html()->label('Phone Number', 'phone_no')->class('col-lg-2 control-label') }}
            <!--<label for="phone" class="col-lg-2 control-label">Phone No</label>-->
            <div class="col-lg-10">
                {{ html()->text('phone_no')->class('form-control')->maxlength('10')->required()->placeholder('Phone Number') }}
                <!--<input class="form-control" maxlength="191" placeholder="Phone Number" name="phone" type="number" value="51551515189" id="phone">-->
                @if(count($errors->get('phone_no')) > 0)
                <span class="backend-errors alert-danger">{{ $errors->first('phone_no') }}</span>
                @endif
            </div><!--col-lg-10-->
        </div>
        @endif
        @endforeach
        @if ($user->id != 1)

        <div class="form-group">
            {{ html()->label(trans('validation.attributes.backend.access.users.active'), 'status')->class('col-lg-2 control-label') }}

            <div class="col-lg-1">
                {{ html()->checkbox('status', $user->status == 1, '1') }}
            </div><!--col-lg-1-->
        </div><!--form control-->
        <div class="form-group">
            {{ html()->label(trans('validation.attributes.backend.access.users.associated_roles'), 'associated_roles')->class('col-lg-2 control-label') }}
            <div class="col-lg-3">
                @if (count($roles) > 0)
                @foreach($roles as $role)

                @if(in_array(config('constant.inverse_user_type.User'), array_column($user->roles->toArray(), 'id')))
                @if($role->id == config('constant.inverse_user_type.User'))
                <input type="hidden" value="{{$role->id}}" name="assignees_roles[{{ $role->id }}]" {{ is_array(old('assignees_roles')) ? (in_array($role->id, old('assignees_roles')) ? 'checked' : '') : (in_array($role->id, $user_roles) ? 'checked' : '') }} id="role-{{$role->id}}" /> <label for="role-{{$role->id}}">{{ $role->name }}</label>


                <a href="#" data-role="role_{{$role->id}}" class="show-permissions small">
                    (
                    <span class="show-text">{{ trans('labels.general.show') }}</span>
                    <span class="hide-text hidden">{{ trans('labels.general.hide') }}</span>
                    {{ trans('labels.backend.access.users.permissions') }}
                    )
                </a>
                <br/>
                <div class="permission-list hidden" data-role="role_{{$role->id}}">
                    @if ($role->all)
                    {{ trans('labels.backend.access.users.all_permissions') }}<br/><br/>
                    @else
                    @if (count($role->permissions) > 0)
                    <blockquote class="small">{{-- --}}@foreach ($role->permissions as $perm){{-- --}}{{$perm->display_name}}<br/>
                        @endforeach
                    </blockquote>
                    @else
                    {{ trans('labels.backend.access.users.no_permissions') }}<br/><br/>
                    @endif
                    @endif
                </div><!--permission list-->
                @endif
                @elseif(in_array(config('constant.inverse_user_type.Business'), array_column($user->roles->toArray(), 'id')))
                @if($role->id == config('constant.inverse_user_type.Business'))
                <input type="hidden" value="{{$role->id}}" name="assignees_roles[{{ $role->id }}]" {{ is_array(old('assignees_roles')) ? (in_array($role->id, old('assignees_roles')) ? 'checked' : '') : (in_array($role->id, $user_roles) ? 'checked' : '') }} id="role-{{$role->id}}" /> <label for="role-{{$role->id}}">{{ $role->name }}</label>


                <a href="#" data-role="role_{{$role->id}}" class="show-permissions small">
                    (
                    <span class="show-text">{{ trans('labels.general.show') }}</span>
                    <span class="hide-text hidden">{{ trans('labels.general.hide') }}</span>
                    {{ trans('labels.backend.access.users.permissions') }}
                    )
                </a>
                <br/>
                <div class="permission-list hidden" data-role="role_{{$role->id}}">
                    @if ($role->all)
                    {{ trans('labels.backend.access.users.all_permissions') }}<br/><br/>
                    @else
                    @if (count($role->permissions) > 0)
                    <blockquote class="small">{{-- --}}@foreach ($role->permissions as $perm){{-- --}}{{$perm->display_name}}<br/>
                        @endforeach
                    </blockquote>
                    @else
                    {{ trans('labels.backend.access.users.no_permissions') }}<br/><br/>
                    @endif
                    @endif
                </div><!--permission list-->
                @endif
                @elseif(in_array(config('constant.inverse_user_type.Administrator'), array_column($user->roles->toArray(), 'id')))
                @if($role->id == config('constant.inverse_user_type.Administrator'))
                
                <input type="hidden" value="{{$role->id}}" name="assignees_roles[{{ $role->id }}]" {{ is_array(old('assignees_roles')) ? (in_array($role->id, old('assignees_roles')) ? 'checked' : '') : (in_array($role->id, $user_roles) ? 'checked' : '') }} id="role-{{$role->id}}" /> <label for="role-{{$role->id}}">{{ $role->name }}</label>


                <a href="#" data-role="role_{{$role->id}}" class="show-permissions small">
                    (
                    <span class="show-text">{{ trans('labels.general.show') }}</span>
                    <span class="hide-text hidden">{{ trans('labels.general.hide') }}</span>
                    {{ trans('labels.backend.access.users.permissions') }}
                    )
                </a>
                <br/>
                <div class="permission-list hidden" data-role="role_{{$role->id}}">
                    @if ($role->all)
                    {{ trans('labels.backend.access.users.all_permissions') }}<br/><br/>
                    @else
                    @if (count($role->permissions) > 0)
                    <blockquote class="small">{{-- --}}@foreach ($role->permissions as $perm){{-- --}}{{$perm->display_name}}<br/>
                        @endforeach
                    </blockquote>
                    @else
                    {{ trans('labels.backend.access.users.no_permissions') }}<br/><br/>
                    @endif
                    @endif
                </div><!--permission list-->
                @endif
                @elseif(in_array(config('constant.inverse_user_type.Support'), array_column($user->roles->toArray(), 'id')))
                @if($role->id == config('constant.inverse_user_type.Support'))
                <input type="hidden" value="{{$role->id}}" name="assignees_roles[{{ $role->id }}]" {{ is_array(old('assignees_roles')) ? (in_array($role->id, old('assignees_roles')) ? 'checked' : '') : (in_array($role->id, $user_roles) ? 'checked' : '') }} id="role-{{$role->id}}" /> <label for="role-{{$role->id}}">{{ $role->name }}</label>


                <a href="#" data-role="role_{{$role->id}}" class="show-permissions small">
                    (
                    <span class="show-text">{{ trans('labels.general.show') }}</span>
                    <span class="hide-text hidden">{{ trans('labels.general.hide') }}</span>
                    {{ trans('labels.backend.access.users.permissions') }}
                    )
                </a>
                <br/>
                <div class="permission-list hidden" data-role="role_{{$role->id}}">
                    @if ($role->all)
                    {{ trans('labels.backend.access.users.all_permissions') }}<br/><br/>
                    @else
                    @if (count($role->permissions) > 0)
                    <blockquote class="small">{{-- --}}@foreach ($role->permissions as $perm){{-- --}}{{$perm->display_name}}<br/>
                        @endforeach
                    </blockquote>
                    @else
                    {{ trans('labels.backend.access.users.no_permissions') }}<br/><br/>
                    @endif
                    @endif
                </div><!--permission list-->
                @endif
                @endif

                @endforeach
                @else
                {{ trans('labels.backend.access.users.no_roles') }}
                @endif
            </div><!--col-lg-3-->
        </div><!--form control-->
        @endif
    </div><!-- /.box-body -->
</div><!--box-->
<div class="box box-success">
    <div class="box-body">
        <div class="pull-left">
            <a href="{{ URL::previous() }}" class="btn btn-danger btn-xs">Cancel</a>
        </div><!--pull-left-->

        <div class="pull-right">
            @foreach($user->roles as $role)
            @if($role->id == config('constant.inverse_user_type.Business') )
            <button type="submit" value="Business" name="submit" class="btn btn-success btn-xs">Update</button>
            @endif
            @if($role->id == config('constant.inverse_user_type.Administrator') )
            <button type="submit" value="Administrator" name="submit" class="btn btn-success btn-xs">Update</button>
            @endif
            @if($role->id == config('constant.inverse_user_type.Support') )
            <button type="submit" value="Support" name="submit" class="btn btn-success btn-xs">Update</button>
            @endif
            @if($role->id == config('constant.inverse_user_type.User') )
            {{ html()->submit(trans('buttons.general.crud.update'))->class('btn btn-success btn-xs') }}
            @endif
            @endforeach
        </div><!--pull-right-->
        <div class="clearfix"></div>
    </div><!-- /.box-body -->
</div><!--box-->
@if ($user->id == 1)
{{ html()->hidden('status', 1) }}
{{ html()->hidden('assignees_roles[0]', 1) }}
@endif

{{ html()->closeModelForm() }}
@endsection

@section('after-scripts')
<script src="{{ asset('js/backend/access/users/script.js') }}"></script>

<script>
    $(document).ready(function () {
        $('#role-2, #role-3').click(function () {
            $('#role-2, #role-3').not(this).prop('checked', false);
        });

        if ($('#role-2').prop("checked") == false) {
            $("#role-2").attr("disabled", true);
        }
        if ($('#role-3').prop("checked") == false) {
            $("#role-3").attr("disabled", true);
        }

    });
</script>

@endsection
