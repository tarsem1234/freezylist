@extends ('backend.layouts.app')

@section ('title', trans('labels.backend.access.roles.management'))

@section('after-styles')
    <link type="text/css" rel="stylesheet" href="{{ asset("https://cdn.datatables.net/v/bs/dt-1.10.15/datatables.min.css") }}" media="all">
@endsection

@section('page-header')
    <h1>{{ trans('labels.backend.access.roles.management') }}</h1>
@endsection

@section('content')
    <div class="box box-success">
        <div class="box-header with-border">
            <h3 class="box-title">{{ trans('labels.backend.access.roles.management') }}</h3>

            <div class="box-tools pull-right">
                @include('backend.access.includes.partials.role-header-buttons')
            </div>
        </div><!-- /.box-header -->

        <div class="box-body">
            <div class="table-responsive">
                <table id="roles-table" class="table table-condensed table-hover">
                    <thead>
                        <tr>
                            <th>{{ trans('labels.backend.access.roles.table.role') }}</th>
                            <th>{{ trans('labels.backend.access.roles.table.permissions') }}</th>
                            <th>{{ trans('labels.backend.access.roles.table.number_of_users') }}</th>
                            <th>{{ trans('labels.backend.access.roles.table.sort') }}</th>
                            <th>{{ trans('labels.general.actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($roles as $index=>$role)
                    <tr>
                        <td>{{ $role->name }}</td>
                        @if ($role->all) 
                         <td><span class="label label-success">{{trans('labels.general.all')}}</span></td>
                        @else
                            @if($role->permissions->count())
                         
                                <td>{{implode('<br/>', $role->permissions->pluck('display_name')->toArray())}} </td>
                            @else

                                <td><span class="label label-danger">{{trans('labels.general.none')}}</span></td>
                            @endif
                        @endif
                        
                        <td>{{ $role->users->count() }}</td>
                        <td>{{ $role->sort }}</td>
                        <td>{!! $role->action_buttons !!}
                            <!-- <a href="{{route('admin.access.role.edit',$role->id) }}" class="btn btn-xs btn-info edit-icon-btn">
                                <i class="fa fa-pencil-square-o" data-toggle="tooltip" data-placement="top" data-original-title="Edit"></i>
                            </a>
                            <a data-id='{{ $role->id }}' class="btn btn-xs btn-danger delete-icon-btn">
                                <i class="fa fa-trash-o" data-toggle="tooltip" data-placement="top" data-original-title="Delete"></i>
                            </a> -->
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div><!--table-responsive-->
        </div><!-- /.box-body -->
    </div><!--box-->

    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title">{{ trans('history.backend.recent_history') }}</h3>
            <div class="box-tools pull-right">
                <button class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
            </div><!-- /.box tools -->
        </div><!-- /.box-header -->
        <div class="box-body">
            {!! history()->renderType('Role') !!}
        </div><!-- /.box-body -->
    </div><!--box box-success-->
@endsection

@section('after-scripts')
    <script src="{{ asset("https://cdn.datatables.net/v/bs/dt-1.10.15/datatables.min.js") }}"></script>
    <script src="{{ asset("js/backend/plugin/datatables/dataTables-extend.js") }}"></script>

    <script>
        $(function() {
            $('#roles-table').DataTable({
                dom: 'lfrtip',
                processing: false,
                serverSide: false,
                autoWidth: false,
                // ajax: {
                //     url: '{{ route("admin.access.role.get") }}',
                //     type: 'post',
                //     error: function (xhr, err) {
                //         if (err === 'parsererror')
                //             location.reload();
                //     }
                // },
                // columns: [
                //     {data: 'name', name: '{{config('access.roles_table')}}.name'},
                //     {data: 'permissions', name: '{{config('access.permissions_table')}}.display_name', sortable: false},
                //     {data: 'users', name: 'users', searchable: false},
                //     {data: 'sort', name: '{{config('access.roles_table')}}.sort'},
                //     {data: 'actions', name: 'actions', searchable: false, sortable: false}
                // ],
                order: [[3, "asc"]]
            });
        });
    </script>
@endsection
