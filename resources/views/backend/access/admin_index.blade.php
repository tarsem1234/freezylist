@extends ('backend.layouts.app')

@section ('title',('Admin Management'))

@section('after-styles')
<link type="text/css" rel="stylesheet" href="{{ asset("https://cdn.datatables.net/v/bs/dt-1.10.15/datatables.min.css") }}" media="all">
@endsection

@section('page-header')
<h1>
    Admin Management
</h1>
@endsection

@section('content')
<div class="box box-success">
    <div class="box-header with-border">
        <h3 class="box-title">Active Admin</h3>

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
                        <th>Created</th>
                        <th>Last Updated</th>
                        <th>actions</th>
                    </tr>
                </thead>
                @if( isset( $adminUsers) )
                <tbody>
                    @foreach( $adminUsers as $index=>$adminUser)
                    <tr>
                        @if($adminUser->user_profile)
                        <td>{{ $index+1 }}</td>
                        <td>{{ $adminUser->user_profile->full_name??"NA" }}</td>
                        @elseif($adminUser->business_profile)
                        <td>{{ $index+1 }}</td>
                        <td>{{ $adminUser->business_profile->company_name??"NA" }}</td>
                        @else
                        <td>{{ $index+1 }}</td>
                        <td>{{$adminUser->first_name . ' '.$adminUser->last_name??"NA"}}</td>
                        @endif
                        <td>{{ $adminUser->email??"NA" }}</td>
                        <td>{{ ($adminUser->confirmed==1)?"Yes":"No" }}</td>
                        <td>{{ $adminUser->created_at??"NA" }}</td>
                        <td>{{ $adminUser->updated_at??"NA" }}</td>
                        <td>
                            {!!$adminUser->action_buttons!!}
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
        $('#users-table').DataTable({
            dom: 'lfrtip',
            autoWidth: false,
            language: {
                search: "",
                searchPlaceholder: "Search"
            }
        });
        $.ajax({
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
    });
</script>
@endsection  

