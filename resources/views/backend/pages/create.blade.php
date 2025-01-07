@extends('backend.layouts.app')

@section ('title', ('Edit Page'))

@section('after-styles')
<link type="text/css" rel="stylesheet" href="{{ asset("https://cdn.datatables.net/v/bs/dt-1.10.15/datatables.min.css") }}" media="all">
@endsection

@section('page-header')
<h1>Page Management</h1>    
@endsection

@section('content')
<div class="box box-success" id="edit-add-pages">
   <div class="box-header with-border"> 
      <h3 class="box-title">Edit Page</h3>    
      <div class="box-tools pull-right">

      </div>  
   </div>
   <div class="box-body">
      <div class="container">
         {{ html()->form('PUT', route('admin.pages.update', $page['id']))->class('form-horizontal')->acceptsFiles()->open() }}
         <div class="row form-group">
            <div class="col-sm-2">
               {{ html()->label('Title:', 'title') }}
            </div>
            <div class="col-sm-8">
               {{ html()->text('title', $page['title'])->class('form-control title-input')->required()->maxlength('191')->autofocus('autofocus') }}
               @if(count($errors->get('title')) > 0)
               <span class="backend-errors alert-danger">{{ $errors->first('title') }}</span>
               @endif
            </div>
         </div>   
         <div class="row form-group">  
            <div class="col-sm-2">
               {{ html()->label('Content:', 'content') }}
            </div>
            <div class="col-sm-8">
               {{ html()->textarea('content', $page['content'])->class('form-control edit-blog-content ')->required()->id('ckeditor') }}
               @if(count($errors->get('content')) > 0)
               <span class="backend-errors alert-danger">{{ $errors->first('content') }}</span>
               @endif
            </div>
         </div>
      </div>
   </div>    
</div>

<div class="box box-info  create-edit-cancel-btn">
   {{ html()->submit('Update')->class('btn btn-primary edit-create-btn') }} 
   <a href="{{route("admin.pages.index")}}" class="btn btn-primary cancel-btn">Cancel</a>
</div>
{{ html()->form()->close() }}    

@endsection

@section('after-scripts')
<script src="{{ asset("ckeditor/ckeditor.js") }}"></script>

<script>
   $(function () {
     CKEDITOR.editorConfig = function (config) {
            config.toolbar = [
                {name: 'document', items: ['Source', '-', 'Save', 'NewPage', 'Preview', 'Print', '-', 'Templates']},
                {name: 'clipboard', items: ['Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo']},
                {name: 'editing', items: ['Find', 'Replace', '-', 'SelectAll', '-', 'Scayt']},
                {name: 'forms', items: ['Form', 'Checkbox', 'Radio', 'TextField', 'Textarea', 'Select', 'Button', 'ImageButton', 'HiddenField']},
                '/',
                {name: 'basicstyles', items: ['Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'CopyFormatting', 'RemoveFormat']},
                {name: 'paragraph', items: ['NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl', 'Language']},
                {name: 'links', items: ['Link', 'Unlink', 'Anchor']},
                {name: 'insert', items: ['Image', 'Flash', 'Table', 'HorizontalRule', 'Smiley', 'SpecialChar', 'PageBreak', 'Iframe']},
                '/',
                {name: 'styles', items: ['Styles', 'Format', 'Font', 'FontSize']},
                {name: 'colors', items: ['TextColor', 'BGColor']},
                {name: 'tools', items: ['Maximize', 'ShowBlocks']},
                {name: 'about', items: ['About']}
            ];
        };
        CKEDITOR.replace('ckeditor');
   });
</script>
@endsection


