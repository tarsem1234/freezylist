@extends ('backend.layouts.app')

@section ('title', ('Page'))

@section('after-styles')   
<link type="text/css" rel="stylesheet" href="{{ asset("https://cdn.datatables.net/v/bs/dt-1.10.15/datatables.min.css") }}" media="all">
@endsection

@section('page-header')
<h1>Page Management</h1> 
@endsection

@section('content')
<div class="box box-success">
   <div class="box-header with-border"> 
      <h3 class="box-title">All Pages</h3>

      <div class="box-tools pull-right">
      </div>  
   </div>
   <div class="box-body">
      <div class="table-responsive">
         <table id="page-table" class="table table-condensed table-hover">
            <thead>
               <tr>
                  <th>#</th>
                  <th>Name</th>
                  <th class="actions">Actions</th>
               </tr>
            </thead>
            <tbody>
               @foreach($pages as $index=>$page)
               <tr>
                  <td>{{ $index+1 }}</td>
                  <td>{{ $page->title }}</td>
                  <td>
                     <a href="{{ route('frontend.page.show',$page->slug) }}" data-id='{{ $page->id }}' class="btn btn-primary bg-blue btn-xs view-icon-btn">
                        <i class="fa fa-eye" data-toggle="tooltip" data-placement="top" data-original-title="View"></i>
                     </a>
                     <a href="{{route('admin.pages.edit',$page->id) }}" class="btn btn-xs btn-info edit-icon-btn">
                        <i class="fa fa-pencil-square-o" data-toggle="tooltip" data-placement="top" data-original-title="Edit"></i>
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
      $('#page-table').DataTable({
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

   });


</script>
@endsection

