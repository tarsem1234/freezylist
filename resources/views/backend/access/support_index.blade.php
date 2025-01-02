@extends ('backend.layouts.app')

@section ('title',('Support Management'))

@section('after-styles')
<link type="text/css" rel="stylesheet" href="{{ asset("https://cdn.datatables.net/v/bs/dt-1.10.15/datatables.min.css") }}" media="all">
@endsection

@section('page-header')
<h1>
   Support Management
</h1>
@endsection

@section('content')
<style>
    .hover_none:hover { background-color: transparent !important; }
</style>
<div class="box box-success">
   <div class="box-header with-border">
      <h3 class="box-title">Active Support</h3>

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
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>Confirmed</th>
                    <th>Created</th>
                    <th>Last Updated</th>
                    <th>actions</th>
               </tr>
            </thead>
            <?php if( isset( $supportUsers) && count($supportUsers)>0) {?>
            <tbody>
               @foreach( $supportUsers as $index=>$supportUser)
               <tr>
                  <td>{{ $index+1 }}</td>
                  <td><?= getFullName($supportUser); ?></td>
                  <td>{{ $supportUser->email??"NA" }}</td>
                  <td>{{ ($supportUser->confirmed==1)?"Yes":"No" }}</td>
                  <td>{{ $supportUser->created_at??"NA" }}</td>
                  <td>{{ $supportUser->updated_at??"NA" }}</td>
                  <td>
                     {!!$supportUser->action_buttons!!}
                  </td>
               </tr>
               @endforeach
            </tbody>
            <?php } else { ?>
            <tbody>
                <tr class="hover_none">
                    <td>
                        <h4>No record found.</h4>
                    </td>
                </tr>
            </tbody>
            <?php } ?>
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
        $('#users-table').DataTable({
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
               if (err === 'parsererror')
                  location.reload();
            }
        });
        columns: [
            <?php if( isset( $supportUsers) && count($supportUsers)>0) {?>
                       {data: 'actions', name: 'actions', searchable: false, sortable: false}
            <?php } ?>
        ]
    });
</script>
@endsection  

