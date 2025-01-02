@extends ('backend.layouts.app')

@section ('title', ('Comments'))

@section('after-styles')
<link type="text/css" rel="stylesheet" href="{{ asset("https://cdn.datatables.net/v/bs/dt-1.10.15/datatables.min.css") }}" media="all">
@endsection

@section('page-header')
<h1>Comment Management</h1>
@endsection

@section('content')
<div id="del-success-msg" class="alert alert-success"></div>
<div class="box box-success" id="blog-index">
    <div class="box-header with-border">
        <h3 class="box-title">All Comments</h3>
        <div class="box-tools pull-right">
            <a href="{{ route('admin.blogs.index') }}" class="btn btn-primary btn-xs">Back</a>
        </div>
    </div>
    <div class="box-body">
        <div class="table-responsive">
            <table id="blog-table" class="table table-condensed table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Blog Tile</th>
                        <th>Comments on Blog	</th>
                        <th>User / Email</th>
                        <th>Status</th>
                        <th class="actions">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($blog->comments as $index=>$comment)
                    <tr>
                        <td>{{ $index+1 }}</td>
                        <td>{{ $blog->title }}</td>
                        <td>{{ $comment->comment }}</td>
                        <td>{{  Auth::user()->first_name }} / {{  Auth::user()->email }}</td>
                        <td>@if($comment->status == 1) Approved @else Unapproved @endif</td>
                        <td>
                            @if($comment->status == 1)
                            <a href="{{route('admin.approval.comment',$comment->id) }}" class="btn btn-xs btn-info edit-icon-btn button-approved">
                                <i class=" fa fa-unlock-alt" data-toggle="tooltip" data-placement="top" data-original-title="Approved"></i>
                            </a>
                            @else
                            <a href="{{route('admin.approval.comment',$comment->id) }}" class="btn btn-xs btn-info edit-icon-btn button-unapproved">
                                <i class=" fa fa-lock" data-toggle="tooltip" data-placement="top" data-original-title="Unpproved"></i>
                            </a>
                            @endif
                            <a data-id='{{ $comment->id }}' class="btn btn-xs btn-danger delete-icon-btn">
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
        $('#blog-table').DataTable({
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
            var commentId = $(this).attr("data-id");
            deleteBlog(commentId, $(this));

        });

        function  deleteBlog(commentId, $this) {
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
                            type: 'post',
                            dataType: 'json',
                            data: {
                                _method: 'DELETE'
                            },
                            url: "{{url('/admin/blog/comment/delete')}}" + "/" + commentId,
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
