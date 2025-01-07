@extends ('backend.layouts.app')

@section ('title', ('Document Listing'))

@section('after-styles')   
<link type="text/css" rel="stylesheet" href="{{ asset("https://cdn.datatables.net/v/bs/dt-1.10.15/datatables.min.css") }}" media="all">
@endsection

@section('page-header')
<h1>Document List Management</h1> 
@endsection

@section('content')
<div id="del-success-msg" class="alert alert-success"></div>
<div class="box box-success">
    <div class="box-header with-border"> 
        <h3 class="box-title">All Document List</h3>

        <div class="box-tools pull-right">
            <a href="document-listing/create" class="btn btn-primary btn-xs">Add Document</a>
        </div>  
    </div>
    <div class="box-body">
        <div class="table-responsive">
            <table id="document-list-table" class="table table-condensed table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Document Name</th>
                        <th>State</th>
                        <th class="actions">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($documents as $index=>$document)
                    <tr>
                        <td>{{ $index+1 }}</td>
                        <td>{{ $document->document }}</td>
                        <td>{{ $document->state->state??"Instructions" }}</td>
                        <td>
                            <a data-id='{{ $document->id }}' class="btn btn-xs btn-danger delete-icon-btn">
                                <i class="fa fa-trash" data-toggle="tooltip" data-placement="top" data-original-title="Delete"></i>
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
        var documentsTable = $('#document-list-table').DataTable({
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
            var documentListId = $(this).attr("data-id");
            deleteDocumentList(documentListId, $(this));
        });
        function  deleteDocumentList(documentListId, $this) {
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
                    url: "{{ url('/admin/document-listing/' ) }}" + "/" + documentListId,
                    success: function (data) {
                        var msg = '<span>' + data.message + '</span>';
                        $('#del-success-msg').html(msg);
                        $("#del-success-msg").show();
                        documentsTable.row($this.parents('tr')).remove().draw();
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
