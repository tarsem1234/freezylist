@extends ('backend.layouts.app')

@section ('title', trans('labels.backend.access.users.management') . ' | ' . trans('labels.backend.access.users.edit'))

@section('page-header')
<h1>
    {{ trans('labels.backend.access.users.admin_management') }}
</h1>
@endsection

@section('content')
{{ html()->modelForm($user, 'PATCH', route('admin.access.admin.update', [$user]))->class('form-horizontal')->attribute('role', 'form')->open() }}
<div class="box box-success">
    <div class="box-header with-border">
        <h3 class="box-title">{{ trans('labels.backend.access.users.edit_admin') }}</h3>
        <div class="box-tools pull-right">
            @include('backend.access.includes.partials.user-header-buttons')
        </div><!--box-tools pull-right-->
    </div><!-- /.box-header -->
    <div class="box-body">

        <div class="form-group">
            {{ html()->label('Name', 'name')->class('col-lg-2 control-label') }}
            <div class="col-lg-10">
                {{ html()->text('name', $userWithUser->user_profile->full_name)->class('form-control')->maxlength('191')->required()->autofocus('autofocus')->placeholder('Full Name') }}
                @if(count($errors->get('name')) > 0)
                <span class="backend-errors alert-danger">{{ $errors->first('name') }}</span>
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
            {{ html()->label('City', 'city')->class('col-lg-2 control-label') }}
            <!--<label for="city" class="col-lg-2 control-label">City</label>-->
            <div class="col-lg-10">
                {{ html()->text('city')->class('form-control')->maxlength('191')->required()->placeholder('City') }}
                <!--<input class="form-control" maxlength="191" placeholder="City" name="city" type="text" value="xyz" id="city">-->
                @if(count($errors->get('city')) > 0)
                <span class="backend-errors alert-danger">{{ $errors->first('city') }}</span>
                @endif
            </div><!--col-lg-10-->
        </div>

        <div class="form-group">
            {{ html()->label('Phone Number', 'phone_no')->class('col-lg-2 control-label') }}
            <!--<label for="phone" class="col-lg-2 control-label">Phone No</label>-->
            <div class="col-lg-10">
                {{ html()->text('phone_no')->class('form-control')->maxlength('191')->required()->placeholder('Phone Number') }}
                <!--<input class="form-control" maxlength="191" placeholder="Phone Number" name="phone" type="number" value="51551515189" id="phone">-->
                @if(count($errors->get('phone_no')) > 0)
                <span class="backend-errors alert-danger">{{ $errors->first('phone_no') }}</span>
                @endif
            </div><!--col-lg-10-->
        </div>
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

                @if(in_array(config('constant.inverse_user_type.Business'), array_column($user->roles->toArray(), 'id')))
                @if($role->id != config('constant.inverse_user_type.User'))
                <input type="checkbox" value="{{$role->id}}" name="assignees_roles[{{ $role->id }}]" {{ is_array(old('assignees_roles')) ? (in_array($role->id, old('assignees_roles')) ? 'checked' : '') : (in_array($role->id, $user_roles) ? 'checked' : '') }} id="role-{{$role->id}}" /> <label for="role-{{$role->id}}">{{ $role->name }}</label>

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
                @elseif(in_array(config('constant.inverse_user_type.User'), array_column($user->roles->toArray(), 'id')))
                @if($role->id != config('constant.inverse_user_type.Business'))
                <input type="checkbox" value="{{$role->id}}" name="assignees_roles[{{ $role->id }}]" {{ is_array(old('assignees_roles')) ? (in_array($role->id, old('assignees_roles')) ? 'checked' : '') : (in_array($role->id, $user_roles) ? 'checked' : '') }} id="role-{{$role->id}}" /> <label for="role-{{$role->id}}">{{ $role->name }}</label>

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
                @else
                <input type="checkbox" value="{{$role->id}}" name="assignees_roles[{{ $role->id }}]" {{ is_array(old('assignees_roles')) ? (in_array($role->id, old('assignees_roles')) ? 'checked' : '') : (in_array($role->id, $user_roles) ? 'checked' : '') }} id="role-{{$role->id}}" /> <label for="role-{{$role->id}}">{{ $role->name }}</label>


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
            {{ html()->submit(trans('buttons.general.crud.update'))->class('btn btn-success btn-xs') }}
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
