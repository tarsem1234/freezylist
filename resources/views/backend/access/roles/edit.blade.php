@extends ('backend.layouts.app')

@section ('title', trans('labels.backend.access.roles.management') . ' | ' . trans('labels.backend.access.roles.edit'))

@section('page-header')
    <h1>
        {{ trans('labels.backend.access.roles.management') }}
    </h1>
@endsection

@section('content')
    {{ html()->modelForm($role, 'PATCH', route('admin.access.role.update', [$role]))->class('form-horizontal')->attribute('role', 'form')->id('edit-role')->open() }}

        <div class="box box-success">
            <div class="box-header with-border">
                <h3 class="box-title">{{ trans('labels.backend.access.roles.edit') }}</h3>

                <div class="box-tools pull-right">
                    @include('backend.access.includes.partials.role-header-buttons')
                </div><!--box-tools pull-right-->
            </div><!-- /.box-header -->

            <div class="box-body">
                <div class="form-group">
                    {{ html()->label(trans('validation.attributes.backend.access.roles.name'), 'name')->class('col-lg-2 control-label') }}

                    <div class="col-lg-10">
                        {{ html()->text('name')->class('form-control')->maxlength('191')->required()->autofocus('autofocus')->placeholder(trans('validation.attributes.backend.access.roles.name')) }}
                    </div><!--col-lg-10-->
                </div><!--form control-->

                <div class="form-group">
                    {{ html()->label(trans('validation.attributes.backend.access.roles.associated_permissions'), 'associated-permissions')->class('col-lg-2 control-label') }}

                    <div class="col-lg-10">
                        @if ($role->id != 1)
                            {{-- Administrator has to be set to all --}}
                            {{ html()->select('associated-permissions', ['all' => 'All', 'custom' => 'Custom'], $role->all ? 'all' : 'custom')->class('form-control') }}
                        @else
                            <span class="label label-success">{{ trans('labels.general.all') }}</span>
                        @endif

                        <div id="available-permissions" class="hidden mt-20">
                            <div class="row">
                                <div class="col-xs-12">
                                    @if ($permissions->count())
                                        @foreach ($permissions as $perm)
                                            <input type="checkbox" name="permissions[{{ $perm->id }}]" value="{{ $perm->id }}" id="perm_{{ $perm->id }}" {{ is_array(old('permissions')) ? (in_array($perm->id, old('permissions')) ? 'checked' : '') : (in_array($perm->id, $role_permissions) ? 'checked' : '') }} /> <label for="perm_{{ $perm->id }}">{{ $perm->display_name }}</label><br/>
                                        @endforeach
                                    @else
                                        <p>There are no available permissions.</p>
                                    @endif
                                </div><!--col-lg-6-->
                            </div><!--row-->
                        </div><!--available permissions-->
                    </div><!--col-lg-3-->
                </div><!--form control-->

                <div class="form-group">
                    {{ html()->label(trans('validation.attributes.backend.access.roles.sort'), 'sort')->class('col-lg-2 control-label') }}

                    <div class="col-lg-10">
                        {{ html()->text('sort')->class('form-control')->placeholder(trans('validation.attributes.backend.access.roles.sort')) }}
                    </div><!--col-lg-10-->
                </div><!--form control-->
            </div><!-- /.box-body -->
        </div><!--box-->

        <div class="box box-success">
            <div class="box-body">
                <div class="pull-left">
                    <a href="{{ URL::previous() }}" class="btn btn-danger btn-xs">Cancel</a>
                </div><!--pull-left-->

                <div class="pull-right">
                    <button type="submit" class="button btn btn-success btn-xs">Update</button>
                </div><!--pull-right-->

                <div class="clearfix"></div>
            </div><!-- /.box-body -->
        </div><!--box-->

    {{ html()->closeModelForm() }}
@endsection

@section('after-scripts')
    <script src="{{ asset('js/backend/access/roles/script.js') }}"></script>
@endsection