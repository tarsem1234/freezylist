@extends ('backend.layouts.app')

@section ('title', ('Xml Feed Users'))

@section('after-styles')
<link type="text/css" rel="stylesheet" href="{{ asset("https://cdn.datatables.net/v/bs/dt-1.10.15/datatables.min.css") }}" media="all">
@endsection

@section('page-header')
<h1>Xml Feed Users</h1>
@endsection

@section('content')
<div id="del-success-msg" class="alert alert-success"></div>
<div class="box box-success">
    <div class="box-header with-border">
        <h3 class="box-title">All Xml Feed Users</h3>

        <div class="box-tools pull-right">
            <a href="{{route('admin.xmlFeedCreate')}}" class="btn btn-primary btn-xs">Add Xml Feed User</a>
        </div>
    </div>
    <div class="box-body">
        <div class="table-responsive">
            @if(isset($xmlUsers) && count($xmlUsers)>0)
            <table id="xmlFeedUser-table" class="table table-condensed table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Username</th>
                        <th class="actions">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($xmlUsers as $index=>$xmlUser)
                    <tr>
                        <td>{{ $index+1 }}</td>
                        <td>{{ $xmlUser->username }}</td>
                        <td>
                            <a href= "{{route('admin.xmlFeedEdit', encrypt($xmlUser->id)) }}" class="btn btn-xs btn-info edit-icon-btn">
                                <i class="fa fa-pencil-square-o" data-toggle="tooltip" data-placement="top" data-original-title="Edit"></i>
                            </a>
                            <a href="{{ route('admin.xmlUserActivation',encrypt($xmlUser->id)) }}" class="btn btn-xs {{$xmlUser->status?"btn-success":"btn-warning"}} delete-icon-btn" title="{{$xmlUser->status?"InActive":"Active"}}">
                            <?php if($xmlUser->status) { ?>
                                <i class="fa fa-toggle-on"></i>
                            <?php } else { ?>
                                <i class="fa fa-toggle-off"></i>
                            <?php } ?>
                            </a>
                                <a href='{{ route('admin.xmlFeedDelete',$xmlUser->id) }}' class="btn btn-xs btn-danger delete-icon-btn">
                                <i class="fa fa-trash-o" data-toggle="tooltip" data-placement="top" data-original-title="Delete"></i>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            @else
            <h4>No Xml Feed User found.</h4>
            @endif
        </div>
    </div>
</div>

@endsection

@section('after-scripts')
<script src="{{ asset("https://cdn.datatables.net/v/bs/dt-1.10.15/datatables.min.js") }}"></script>
<script src="{{ asset("https://cdnjs.cloudflare.com/ajax/libs/ckeditor/4.9.2/adapters/jquery.js") }}"></script>
<script src="{{ asset("js/backend/plugin/datatables/dataTables-extend.js") }}"></script>

<script>
    $(function () {
        var xmlFeedTable = $('#xmlFeedUser-table').DataTable({
//        $('#xmlFeedUser-table').DataTable({
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

//        $(document).on('click', '.delete-icon-btn', function () {
//            var xmlFeedUserId = $(this).attr("data-id");
//            deleteIndustry(xmlFeedUserId, $(this));
//        });
//        function  deleteIndustry(xmlFeedUserId, $this) {
//            swal({
//                title: '',
//                text: "Are you sure that you want to delete this?",
//                type: "warning",
//                closeModal: true,
//                showLoaderOnConfirm: false,
//                className: "btn-danger",
//                confirmButtonText: "Yes, delete it!",
//                showCancelButton: true,
//                confirmButtonColor: "#ec6c62"
//            }, function () {
//                $.ajax({
//                    type: 'POST',
//                    dataType: 'json',
//                    data: {
//                        _method: 'DELETE'
//                    },
//                    url: "{{ url('/admin/xmlfeed/delete/' ) }}" + "/" + xmlFeedUserId,
//                    success: function (data) {
//                        var msg = '<span>' + data.message + '</span>';
//                        $('#del-success-msg').html(msg);
//                        $("#del-success-msg").show();
//                        industryTable.row($this.parents('tr')).remove().draw();
//                        window.location.reload();
//                    },
//                    error: function (data) {
//                        swal("Oops", "We couldn't connect to the server!", "error");
//                    }
//                });
//                setTimeout(function () {
//                    $('.alert-success').fadeOut('fast');
//                }, 3000);
//            });
//        }
    });


</script>
@endsection

