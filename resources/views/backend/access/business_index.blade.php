@extends ('backend.layouts.app')

@section ('title', ('Business Management'))

@section('after-styles')
<link type="text/css" rel="stylesheet" href="{{ asset("https://cdn.datatables.net/v/bs/dt-1.10.15/datatables.min.css") }}" media="all">
@endsection
@section('page-header')
<h1>
    Business Management  
</h1>
@endsection

@section('content')
<div class="box box-success business">
    <div class="box-header with-border">
        <h3 class="box-title">Active Business</h3>

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
                        <th width="15%">Company Name</th>
                        <th>Email</th>
                        <th>Confirmed</th>
                        <th>City</th>
                        <th>Industry</th>
                        <th>Created</th>
                        <th>Last Updated</th>
                        <th class="actions">Actions</th>
                    </tr>
                </thead>
                @if( isset($businessUsers) )
                <tbody>
                    @foreach($businessUsers as $index=>$businessUser)
                    <tr>
                        <td>{{ $index+1 }}</td>
                        <td>{{ $businessUser->business_profile->company_name??"NA" }}</td>
                        <td>{{ $businessUser->email??"NA" }}</td>
                        <td>{{ ($businessUser->confirmed==1)?"Yes":"No" }}</td>
                        <td>{{  $businessUser->city??"NA" }}</td>
                        <td>{{ $businessUser->business_profile ? getIndustryName($businessUser->business_profile['industry_id']):"NA" }}</td>
                        <td>{{ $businessUser->created_at??"NA" }}</td>
                        <td>{{ $businessUser->updated_at??"NA" }}</td>
                        <td class="actions">
                            {!!$businessUser->action_buttons!!}
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
        var businessUser = $('#users-table').DataTable({
            dom: 'lfrtip',
            autoWidth: false,
            language: {
                search: "",
                searchPlaceholder: "Search"
            }
        });
        $.ajax ({
            url: '{{ route("admin.access.user.get") }}',
            type: 'post',
            data: {status: 1, trashed: false},
            error: function (xhr, err) {
                if (err === 'parsererror') {

//                  location.reload();
                }
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

