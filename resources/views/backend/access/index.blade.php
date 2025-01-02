@extends ('backend.layouts.app')

@section ('title', trans('labels.backend.access.users.management'))

@section('after-styles')
<link type="text/css" rel="stylesheet" href="{{ asset("https://cdn.datatables.net/v/bs/dt-1.10.15/datatables.min.css") }}" media="all">
@endsection
@section('page-header')
<h1>
    {{ trans('labels.backend.access.users.management') }}
</h1>
@endsection
@section('content')
<div class="box box-success">
    <div class="box-header with-border">
        <h3 class="box-title">{{ trans('labels.backend.access.users.active') }}</h3>

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
                        <th>Full Name</th>
                        <th>Email</th>
                        <th>Confirmed</th>
                        <th>City</th>
                        <th>Phone</th>
                        <th>Created</th>
                        <th>Last Updated</th>
                        <th>{{ trans('labels.general.actions') }}</th>
                    </tr>
                </thead>
                @if( isset($users) )
                <tbody>
                    @foreach($users as $index=>$user)
                    <tr>
                        <td>{{ $index+1 }}</td>
                        <td>{{ getFullName($user) }}</td>
                        <td>{{ $user->email??"NA" }}</td>
                        <td>{{ ($user->confirmed==1)?"Yes":"No" }}</td>
                        <td>{{ $user->city??"NA" }}</td>
                        <td>{{ $user->phone_no??"NA" }}</td>   
                        <td>{{ $user->created_at??"NA" }}</td>
                        <td>{{ $user->updated_at??"NA" }}</td>
                        <td>
                            {!!$user->action_buttons!!}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                @endif
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
        var usersTable = $('#users-table').DataTable({
            dom: 'lfrtip',
            autoWidth: false,
            language: {
                search: "",
                searchPlaceholder: "Search"
            }
        });
        
        setTimeout(function () {
            $('.alert-success').fadeOut('fast');
        }, 3000);
        $(".actions").removeClass("sorting");
        
        $.ajax ({
            url: '{{ route("admin.access.user.get") }}',
            type: 'post',
            data: {status: 1, trashed: false},
            error: function (xhr, err) {
                if (err === 'parsererror')
                    location.reload();
            }
        });
        columns: [
            {data: 'actions', name: 'actions', searchable: false, sortable: false}
        ]
//        order: [[0, "asc"]],
//        searchDelay: 500
    });
</script>
@endsection  
