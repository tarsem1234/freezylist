@extends ('backend.layouts.app')

@section ('title', ('Learning Topics'))

@section('after-styles')
<link type="text/css" rel="stylesheet" href="{{ asset("https://cdn.datatables.net/v/bs/dt-1.10.15/datatables.min.css") }}" media="all">
@endsection

@section('page-header')
<h1>Sessions </h1>
@endsection

@section('content')

<div id="del-success-msg" class="alert alert-success"></div>
<div class="box box-success">
    <div class="box-header with-border">
        @if($category)
        <h3 class="box-title">{{$category->category}} Sessions</h3>
        <div class="box-tools pull-right">
            <a href="{{route('admin.sessionCreate', $category->id)}}" class="btn btn-primary btn-xs">Add Session</a>
        </div>
        @else 
        <h3 class="box-title">All Sessions</h3>
        @endif
    </div>
    <div class="box-body">
        <div class="table-responsive">
            <table id="session-table" class="table table-condensed table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Session Name</th>
                        <th>Points</th>
                        <th class="actions">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($sessions as $index=>$sessions)
                    <tr>
                        <td>{{ $index+1 }}</td>
                        <td>{{ $sessions->name }}</td>
                        <td>{{ $sessions->points }}</td>
                        <td>
                            <a href= "{{ route('admin.sessions.edit',$sessions->id) }}" class="btn btn-xs btn-info edit-icon-btn">
                                <i class="fa fa-pencil-square-o" data-toggle="tooltip" data-placement="top" data-original-title="Edit"></i>
                            </a>
                            <a data-id='{{ $sessions->id }}' class="btn btn-xs btn-danger delete-icon-btn">
                                <i class="fa fa-trash-o" data-toggle="tooltip" data-placement="top" data-original-title="Delete"></i>
                            </a>
                            @if($sessions->status == 1)
                            <a href= "{{ route('admin.session.deactivate',$sessions->id) }}" class="btn btn-xs btn-info deactivate-icon-btn button-approved">
                                <i class="fa fa-toggle-on" data-toggle="tooltip" data-placement="top" data-original-title="deactivate"></i>
                            </a>
                            @else
                            <a href= "{{ route('admin.session.deactivate',$sessions->id) }}" class="btn btn-xs btn-info deactivate-icon-btn">
                                <i class="fa fa-toggle-off" data-toggle="tooltip" data-placement="top" data-original-title="activate"></i>
                            </a>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection

@section('after-scripts')
<script src="{{ asset("js/backend/plugin/datatables/dataTables-extend.js") }}"></script>
<script src="{{ asset("https://cdn.datatables.net/v/bs/dt-1.10.15/datatables.min.js") }}"></script>


<script>
    $(function () {
        var sessionTable = $('#session-table').DataTable({
            dom: 'lfrtip',
            processing: false,
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

        $(document).on('click', '.delete-icon-btn', function () {
            var sessionId = $(this).attr("data-id");
            deleteSession(sessionId, $(this));
        });
        function  deleteSession(sessionId, $this) {
            swal({
                title: '',
                text: "Are you sure that you want to delete this?",
                type: "warning",
                closeModal: true,
                showLoaderOnConfirm: false,
                className: "btn-danger",
                confirmButtonText: "Yes, delete it!",
                showCancelButton: true,
                confirmButtonColor: "#ec6c62"
            },
                    function () {
                        $.ajax({
                            type: 'POST',
                            dataType: 'json',
                            data: {
                                _method: 'DELETE'
                            },
                            url: "{{url('/admin/learning-center/sessions/')}}" + "/" + sessionId,
                            success: function (data) {
                                var msg = '<span>' + data.message + '</span>';
                                $('#del-success-msg').html(msg);
                                $("#del-success-msg").show();
                                sessionTable.row($this.parents('tr')).remove().draw();
                                window.location.reload();
                            },
                            error: function (data) {
                                swal("Oops", "We couldn't connect to the server!", "error");
                            }
                        });
                        setTimeout(function () {
                            $('.alert-success').fadeOut('fast');
                        }, 3000);
                    });
        }
    });


</script>
@endsection

