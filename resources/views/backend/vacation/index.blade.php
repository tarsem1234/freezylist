@extends ('backend.layouts.app')
@section ('title', ('Vacation List'))
@section('after-styles')
<link type="text/css" rel="stylesheet" href="{{ asset("https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css") }}" media="all">
@endsection

@section('page-header')
<h1>Vacation List Management</h1>
@endsection

@section('content')
<div id="del-success-msg" class="alert alert-success"></div>
<div class="box box-success">
    <div class="box-header with-border"> 
        <h3 class="box-title">All Vacation List</h3>
        <div class="box-tools pull-right">

        </div> 
    </div>
    <div class="box-body">
        <div class="table-responsive">
            <table id="vacational-list-table" class="table table-condensed table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Resort Name</th>
                        <th>Ownership Type</th>
                        <th>Variable</th>
                        <th>Price</th>
                        <th>Available Weeks</th>
                        <th class="actions">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($vacations as $index=>$vacation)
                    <tr>
                        <td>{{ $index+1 }}</td>
                        <td>{{ $vacation->property_name??"" }}</td>
                        <td>{{ isset($vacation->ownership_type) ? config('constant.ownership_type.'.$vacation->ownership_type) : "NA"}}</td>
                        <td>{{ isset($vacation->variable) ? config('constant.variable.'.$vacation->variable) : "NA" }}</td>
                        <td>$<span class="money">{{round($vacation->price)??""}}</span></td>
                        @if(!empty($vacation->availableWeeks))
                        <?php
                        $availableWeeks = [];
                        foreach ($vacation->availableWeeks as $weak) {
                            $availableWeeks[] = $weak->available_week;
                        }

                        $weeks = implode(", ", $availableWeeks);
                        ?>
                        <td>{{ $weeks }}</td>
                        @else
                        <td></td>
                        @endif
                        <td>
                            <a href="{{ route('admin.vacationDetail',$vacation->id) }}" class="btn btn-primary bg-blue btn-xs view-icon-btn">
                                <i class="fa fa-eye" data-toggle="tooltip" data-placement="top" data-original-title="View"></i>
                            </a>
                            <a data-id='{{ $vacation->id }}' class="btn btn-danger btn-xs delete-icon-btn">
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
<script src="{{ asset("https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js") }}"></script>
<!--<script src="{{ asset("js/backend/plugin/datatables/dataTables-extend.js") }}"></script>-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.10/jquery.mask.js"></script>
<script>
    $('.money').mask('000,000,000,000,000', {reverse: true});
    $(function () {
        var vacationTable = $('#vacational-list-table').DataTable({
            dom: 'lfrtip',
//            autoWidth: false,
//            language: {
//                search: "",
//                searchPlaceholder: "Search"
//            },
        });

        $(".actions").removeClass("sorting");

        $(document).on('click', '.delete-icon-btn', function () {
            var vacationalListId = $(this).attr("data-id");
            deleteVacationalList(vacationalListId, $(this));
        });
        function  deleteVacationalList(vacationalListId, $this) {
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
                    type: 'GET',
                    dataType: 'json',
                    data: {
                        _method: 'DELETE'
                    },
                    url: "{{ url('/admin/vacation/delete' ) }}" + "/" + vacationalListId,
                    success: function (data) {
                        var msg = '<span>' + data.message + '</span>';
                        $('#del-success-msg').html(msg);
                        $("#del-success-msg").show();
                        vacationTable.row($this.parents('tr')).remove().draw();
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
