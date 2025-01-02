@extends ('backend.layouts.app')

@section ('title', ('Industry'))

@section('after-styles')   
<link type="text/css" rel="stylesheet" href="{{ asset("https://cdn.datatables.net/v/bs/dt-1.10.15/datatables.min.css") }}" media="all">
@endsection

@section('page-header')
<h1>Industry Management</h1> 
@endsection

@section('content')
<div id="del-success-msg" class="alert alert-success"></div>
<div class="box box-success">
    <div class="box-header with-border"> 
        <h3 class="box-title">All Industries</h3>

        <div class="box-tools pull-right">
            <a href="industries/create" class="btn btn-primary btn-xs">Add Industry</a>
        </div>  
    </div>
    <div class="box-body">
        <div class="table-responsive">
            <table id="industry-table" class="table table-condensed table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Industry</th>
                        <th class="actions">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($industries as $index=>$industry)
                    <tr>
                        <td>{{ $index+1 }}</td>
                        <td>{{ $industry->industry }}</td>
                        <td>
                            <a href= "{{route('admin.industries.edit',$industry->id) }}" class="btn btn-xs btn-info edit-icon-btn">
                                <i class="fa fa-pencil-square-o" data-toggle="tooltip" data-placement="top" data-original-title="Edit"></i>
                            </a>
                            <a data-id='{{ $industry->id }}' class="btn btn-xs btn-danger delete-icon-btn">
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
<script src="{{ asset("https://cdnjs.cloudflare.com/ajax/libs/ckeditor/4.9.2/adapters/jquery.js") }}"></script>
<script src="{{ asset("js/backend/plugin/datatables/dataTables-extend.js") }}"></script>

<script>
    $(function () {
        var industryTable = $('#industry-table').DataTable({
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
            var industryId = $(this).attr("data-id");
            deleteIndustry(industryId, $(this));
        });
        function  deleteIndustry(industryId, $this) {
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
                    url: "{{ url('/admin/industries/' ) }}" + "/" + industryId,
                    success: function (data) {
                        var msg = '<span>' + data.message + '</span>';
                        $('#del-success-msg').html(msg);
                        $("#del-success-msg").show();
                        industryTable.row($this.parents('tr')).remove().draw();
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

