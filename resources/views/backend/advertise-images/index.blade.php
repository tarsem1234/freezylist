@extends ('backend.layouts.app')
@section ('title', ('Advertise Images'))
@section('after-styles')   
<link type="text/css" rel="stylesheet" href="{{ asset("https://cdn.datatables.net/v/bs/dt-1.10.15/datatables.min.css") }}" media="all">
@endsection

@section('page-header')
<h1>Image Management</h1> 
@endsection

@section('content')
<div id="del-success-msg" class="alert alert-success"></div>
<div class="box box-success">
    <div class="box-header with-border"> 
        <h3 class="box-title">All Images</h3>

        <div class="box-tools pull-right">
            <a href="advertise-images/create" class="btn btn-primary btn-xs">Add Images</a>
        </div>  
    </div>
    <div class="box-body">
        <div class="table-responsive">  
            <table id="advertise-image-table" class="table table-condensed table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Image</th>
                        <th>Page Link</th>
                        <th class="actions">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($advertiseImages as $index=>$advertiseImage)
                    <tr>           
                        <td>{{ $index+1 }}</td>
                        <td><img src="{{ asset('storage'.'/'. $advertiseImage->image )}}" class="img-responsive"></td>
                        <td>{{ $advertiseImage->page_link }}</td>
                        <td>
                            <a data-id='{{ $advertiseImage->id }}' class="btn btn-xs btn-danger delete-icon-btn">
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
        var advertiseTable= $('#advertise-image-table').DataTable({
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
            var advertiseImageId = $(this).attr("data-id");
            deleteAdvertiseImage(advertiseImageId, $(this));

        });

        function  deleteAdvertiseImage(advertiseImageId, $this) {
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
                    url: "{{url('/admin/advertise-images/')}}" + "/" + advertiseImageId,
                    success: function (data) {
                        var msg = '<span>' + data.message + '</span>';
                        $('#del-success-msg').html(msg);
                        $("#del-success-msg").show();
                        advertiseTable.row($this.parents('tr')).remove().draw();
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
