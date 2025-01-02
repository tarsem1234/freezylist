@extends('backend.layouts.app')

@section ('title', ('Create Image'))

@section('page-header')
<h1>Image Management</h1>    
@endsection

@section('content')
<div class="box box-success" id="edit-add-pages">
   <div class="box-header with-border"> 
      <h3 class="box-title">Create Image</h3>
      <div class="box-tools pull-right">

      </div>  
   </div>
   <div class="box-body">
      <div class="container">
         {{ html()->form('POST', route('admin.advertise-images.store'))->class('form-horizontal')->acceptsFiles()->open() }}
         <div class="row form-group">
            <div class="col-sm-2">
               {{ html()->label('Page Link:', 'page_link') }}
            </div>
            <div class="col-sm-5">
               {{ html()->text('page_link')->class('form-control title-input')->required()->maxlength('191')->placeholder('Page Link') }}
               @if(count($errors->get('page_link')) > 0)
               <span class="backend-errors alert-danger">{{ $errors->first('page_link') }}</span>
               @endif
            </div>
         </div>   
         <div class="row form-group">
            <div class="col-sm-2">
               {{ html()->label('Image:', 'advertise_image') }}
            </div>
            <div class="col-sm-5">
               <div class="image-div">
                  <!--<img src="asset('storage'.'/'.  )" class="img-responsive">-->
               </div>
               {{ html()->file('advertise_image', ['class' => 'form-control', 'required' => 'required']) }}
               @if(count($errors->get('advertise_image')) > 0)
               <span class="backend-errors alert-danger">{{ $errors->first('advertise_image') }}</span>
               @endif
            </div>
         </div>
      </div>
   </div>    
</div>
<div class="box box-info  create-edit-cancel-btn">
   {{ html()->submit('Create')->class('btn btn-primary edit-create-btn') }}
   <a href="{{route("admin.advertise-images.index")}}" class="btn btn-primary cancel-btn">Cancel</a>
</div>
{{ html()->form()->close() }}    

@endsection

@section('after-scripts')


<script>

</script>
@endsection



