@extends('backend.layouts.app')

@if( isset($service) )
@section ('title', ('Edit Service'))
@else
@section ('title', ('Create Service'))
@endif

@section('page-header')
<h1>Service Management</h1>    
@endsection

@section('content')
<div class="box box-success" id="edit-add-pages">
   <div class="box-header with-border"> 
      @if( isset($service) )
      <h3 class="box-title">Edit Service</h3>
      @else
      <h3 class="box-title">Create Service</h3>
      @endif
      <div class="box-tools pull-right">

      </div>  
   </div>
   <div class="box-body">     
      <div class="container">
         @if( isset($service) )
         {{ html()->form('PUT', route('admin.services.update', $service['id']))->class('form-horizontal')->acceptsFiles()->open() }}
         @else
         {{ html()->form('POST', route('admin.services.store'))->class('form-horizontal')->acceptsFiles()->open() }}
         @endif

         <div class="row form-group">
            <div class="col-sm-2">
               @if( isset($service) )
               {{ html()->label('Title:', 'service') }}
               @else
               {{ html()->label('Service Name:', 'service') }}
               @endif
            </div> 
            <div class="col-sm-5">
               {{ html()->text('service', isset($service) ? $service['service'] : null)->class('form-control title-input')->required()->maxlength('191')->placeholder('Service Name') }}
               @if(count($errors->get('service')) > 0)
               <span class="backend-errors alert-danger">{{ $errors->first('service') }}</span>
               @endif
            </div>
         </div>     
         <div class="row form-group">                                   
            <div class="col-sm-2">
               {{ html()->label('Industry:', 'industry') }}
            </div>
            <div class="col-sm-5">
               <select name="industry" id="select_industry" class="form-control title-input" required>
                  @if( isset($service) )
                  <option value="{{ $service->industry->id }}" disabled selected hidden>{{ $service->industry->industry }}</option>
                  @foreach($industries as $industry)
                  <option value="{{ $industry->id }}">{{ $industry->industry }}</option>
                  @endforeach 
                  @else

                  @if( isset($industries) )
                  <option value="" disabled selected hidden>Select Industry</option>
                  @foreach($industries as $industry)
                  <option value="{{ $industry->id }}">{{ $industry->industry }}</option>
                  @endforeach 
                  @endif
                  @endif
               </select>
               @if(count($errors->get('industry')) > 0)
               <span class="backend-errors alert-danger">{{ $errors->first('industry') }}</span>
               @endif
            </div>
         </div>
      </div>                                                   
   </div>
</div>    

<div class="box box-info  create-edit-cancel-btn">
   @if( isset($service) )
   {{ html()->submit('Update')->class('btn btn-primary edit-create-btn') }}
   @else
   {{ html()->submit('Create')->class('btn btn-primary edit-create-btn') }}
   @endif
   <a href="{{route("admin.services.index")}}" class="btn btn-primary cancel-btn">Cancel</a>
</div>
{{ html()->form()->close() }}    

@endsection

@section('after-scripts')

<script>

</script>
@endsection


