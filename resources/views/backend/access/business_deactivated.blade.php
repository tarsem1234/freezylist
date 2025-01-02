@extends ('backend.layouts.app')

@section ('title', trans('labels.backend.access.users.business_management') . ' | ' . trans('labels.backend.access.users.business_deactivated'))

@section('after-styles')
<link type="text/css" rel="stylesheet" href="{{ asset("https://cdn.datatables.net/v/bs/dt-1.10.15/datatables.min.css") }}" media="all">
@endsection

@section('page-header')
<h1>
    {{ trans('labels.backend.access.users.business_management') }}
</h1>
@endsection

@section('content')
<div class="box box-success">
    <div class="box-header with-border">
        <h3 class="box-title">{{ trans('labels.backend.access.users.business_deactivated') }}</h3>

        <div class="box-tools pull-right">
            @include('backend.access.includes.partials.user-header-buttons')
        </div><!--box-tools pull-right-->
    </div><!-- /.box-header -->

    <div class="box-body">
        <div class="table-responsive">
            <table id="users-table" class="table table-condensed table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Company Name</th>
                        <th>{{ trans('labels.backend.access.users.table.email') }}</th>
                        <th>{{ trans('labels.backend.access.users.table.confirmed') }}</th>
                        <th>{{ trans('labels.backend.access.users.table.roles') }}</th>
                        <th>{{ trans('labels.backend.access.users.table.created') }}</th>
                        <th>{{ trans('labels.backend.access.users.table.last_updated') }}</th>
                        <th>{{ trans('labels.general.actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($businessUsers as $index=>$user)
                    <tr>
                        <td>{{ $index+1 }}</td>
                        <td>{{ getFullName($user) }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{!! $user->confirmed_label !!}</td>
                        <td>{{$user->roles->count() ?
                        implode('<br/>', $user->roles->pluck('name')->toArray())
                            :
                        trans('labels.general.none')}}</td>
                        <td>{{ $user->created_at }}</td>
                        <td>{{ $user->updated_at }}</td>
                        <td>{!!$user->action_buttons!!}</td>
                        <!--  -->
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div><!--table-responsive-->
    </div><!-- /.box-body -->
</div><!--box-->
@endsection

@section('after-scripts')
<script src="{{ asset("https://cdn.datatables.net/v/bs/dt-1.10.15/datatables.min.js") }}"></script>
<script src="{{ asset("js/backend/plugin/datatables/dataTables-extend.js") }}"></script>

<script>
    $(function () {
        var businessDeact = $('#users-table').DataTable({
        dom: 'lfrtip',
                processing: false,
                serverSide: false,
                autoWidth: false,
//                 ajax: {
//                 url: '{{ route("admin.access.user.get") }}',
//                         type: 'post',
//                         data: {status: 0, trashed: false, role: 2},
//                         error: function (xhr, err) {
//                         if (err === 'parsererror'){
// //                            location.reload();
//                         }
//                         }
//                 },
//                 columns: [
//                 {"defaultContent": ''},
//                 {data: 'company_name', name: 'company_name'},
//                 {data: 'email', name: '{{config('access.users_table')}}.email'}
//                 ,
//                 {data: 'confirmed', name: '{{config('access.users_table')}}.confirmed'}
//                 ,
//                 {data: 'roles', name: '{{config('access.roles_table')}}.name', sortable: false}
//                 ,
//                 {data: 'created_at', name: '{{config('access.users_table')}}.created_at'}
//                 ,
//                 {data: 'updated_at', name: '{{config('access.users_table')}}.updated_at'}
//                 ,
//                 {data: 'actions', name: 'actions', searchable: false, sortable: false
//                 }
//                 ],
        order: [[0, "asc"]],
                searchDelay: 500
    });

    
    }
    );
</script>
@endsection
