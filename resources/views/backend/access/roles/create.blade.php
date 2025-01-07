@extends ('backend.layouts.app')

@section ('title', trans('labels.backend.access.roles.management') . ' | ' . trans('labels.backend.access.roles.create'))

@section('page-header')
    <h1>
        {{ trans('labels.backend.access.roles.management') }}
    </h1>
@endsection

@section('content')
    {{ html()->form('POST', route('admin.access.role.store'))->class('form-horizontal')->attribute('role', 'form')->id('create-role')->open() }}

        <div class="box box-success">
            <div class="box-header with-border">
                <h3 class="box-title">{{ trans('labels.backend.access.roles.create') }}</h3>

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
                        {{ html()->select('associated-permissions', array('all' => trans('labels.general.all'), 'custom' => trans('labels.general.custom')), 'all')->class('form-control') }}

                        <div id="available-permissions" class="hidden mt-20">
                            <div class="row">
                                <div class="col-xs-12">
                                    @if ($permissions->count())
                                        @foreach ($permissions as $perm)
                                            <input type="checkbox" name="permissions[{{ $perm->id }}]" value="{{ $perm->id }}" id="perm_{{ $perm->id }}" {{ is_array(old('permissions')) && in_array($perm->id, old('permissions')) ? 'checked' : '' }} /> <label for="perm_{{ $perm->id }}">{{ $perm->display_name }}</label><br/>
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
                        {{ html()->text('sort', $role_count + 1)->class('form-control')->placeholder(trans('validation.attributes.backend.access.roles.sort')) }}
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
                    {{ html()->submit(trans('buttons.general.crud.create'))->class('btn btn-success btn-xs') }}
                </div><!--pull-right-->

                <div class="clearfix"></div>
            </div><!-- /.box-body -->
        </div><!--box-->

    {{ html()->form()->close() }}
@endsection

@section('after-scripts')
    <script src="{{ asset('js/backend/access/roles/script.js') }}"></script>
@endsection
