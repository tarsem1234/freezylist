@extends ('backend.layouts.app')

@section ('title', ('Forum'))

@section('after-styles')
<link type="text/css" rel="stylesheet" href="{{ asset("https://cdn.datatables.net/v/bs/dt-1.10.15/datatables.min.css") }}" media="all">
@endsection

@section('page-header')
<h1>View Topic Answer</h1>
@endsection

@section('content')
<div id="del-success-msg" class="alert alert-success"></div>
<div class="box box-success">
    <div class="box-header with-border">
        <h3 class="box-title">All Forum Replies</h3>
        <div>
            <p class="pull-left">
                <span class="bld">{{ $forumDetails->topic }} : </span><span>{{ strip_tags($forumDetails->detail) }}</span>
            </p>
            <a href="{{ route('admin.forums.index') }}" class="btn btn-primary btn-xs pull-right">Back</a>
        </div>
    </div>
    <div class="box-body">
        <div class="table-responsive">
            <table id="forum-table" class="table table-condensed table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>User</th>
                        <th>Reply</th>
                        <th class="actions">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($forumDetails->replies as $index=>$reply)
                    <tr>
                        <td>{{ $index+1 }}</td>
                        <td>{{ $forumDetails->user->email }}</td>
                        <td>{{ $reply->reply }}</td>
                        <td>
                            <a data-id='{{ $reply->id }}' class="btn btn-danger btn-xs delete-icon-btn">
                                <i class="fa fa-trash-o" data-toggle="tooltip" data-placement="top" data-original-title="Delete"></i>
                            </a>
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
<script src="{{ asset("https://cdn.datatables.net/v/bs/dt-1.10.15/datatables.min.js") }}"></script>
<script src="{{ asset("js/backend/plugin/datatables/dataTables-extend.js") }}"></script>

<script>
    $(function () {
        $('#forum-table').DataTable({
            dom: 'lfrtip',
            autoWidth: false,
            language: {
                search: "",
                searchPlaceholder: "Search"
            },
        });

        setTimeout(function () {
            $('.alert-success').fadeOut('fast');
        }, 3000);
        $(".actions").removeClass("sorting");

        $(document).on('click', '.delete-icon-btn', function () {
            var replyId = $(this).attr("data-id");
            deleteForum(replyId, $(this));
        });
        function deleteForum(replyId, $this) {
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
            }, function () {
                $.ajax({
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        _method: 'DELETE'
                    },
                    url: "{{ url('/admin/forums/reply/delete/' ) }}" + "/" + replyId,
                    success: function (data) {
                        var msg = '<span>' + data.message + '</span>';
                        $('#del-success-msg').html(msg);
                        $("#del-success-msg").show();
                        $this.closest('tr').remove();
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

