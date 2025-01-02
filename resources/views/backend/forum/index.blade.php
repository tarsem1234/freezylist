@extends ('backend.layouts.app')
@section ('title', ('Forum'))
@section('after-styles')
<link type="text/css" rel="stylesheet" href="{{ asset("https://cdn.datatables.net/v/bs/dt-1.10.15/datatables.min.css") }}" media="all">
@endsection
@section('page-header')
<h1>Forum Management</h1>
@endsection
@section('content')
<div id="del-success-msg" class="alert alert-success"></div>
<div class="box box-success">
    <div class="box-header with-border"> 
        <h3 class="box-title">All Forums</h3>

        <div class="box-tools pull-right">

        </div> 
    </div>
    <div class="box-body">
        <div class="table-responsive">
            <table id="forum-table" class="table table-condensed table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Topic</th>
                        <th>Detail</th>
                        <th>From</th>
                        <th>Views</th>
                        <th>Replies</th>
                        <th class="actions">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($forums as $index=>$forum)
                    <tr>
                        <td>{{ $index+1 }}</td>
                        <td>{{ $forum->topic }}</td>
                        <td class="detail-max">{{ $forum->detail }}</td> 
                        <td>{{ $forum->user->first_name }} / {{ $forum->user->email }}</td>
                        <td>{{ $forum->totalViews[0]->total??0 }}</td>
                        <td><?php
                            if (!empty($forum->replies)) {
                                echo $forum->replies->count();
                            } else {
                                echo 0;
                            }
                            ?></td>
                        <td>
                            <a href="{{ route('admin.forums.show',$forum->id) }}" class="btn btn-primary bg-blue btn-xs view-icon-btn">
                                <i class="fa fa-eye" data-toggle="tooltip" data-placement="top" data-original-title="View"></i>
                            </a>
                            <a data-id='{{ $forum->id }}' class="btn btn-danger btn-xs delete-icon-btn">
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
        var forumsTable = $('#forum-table').DataTable({
            dom: 'lfrtip',
            autoWidth: false,
            language: {
                search: "",
                searchPlaceholder: "Search"
            }
        });
        console.log(forumsTable);

        setTimeout(function () {
            $('.alert-success').fadeOut('fast');
        }, 3000);
        $(".actions").removeClass("sorting");

        $(document).on('click', '.delete-icon-btn', function () {
            var forumId = $(this).attr("data-id");
            deleteForum(forumId, $(this));
        });
        function deleteForum(forumId, $this) {
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
                    url: "{{ url('/admin/forums/' ) }}" + "/" + forumId,
                    success: function (data) {
                        var msg = '<span>' + data.message + '</span>';
                        $('#del-success-msg').html(msg);
                        $("#del-success-msg").show();
                        forumsTable.row($this.parents('tr')).remove().draw(true);
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
