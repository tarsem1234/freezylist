@extends('backend.layouts.app')

@if( isset($blog) )
@section ('title', ('Edit Blog'))
@else
@section ('title', ('Create Blog'))
@endif

@section('page-header')
<h1>Blog Management</h1>    
@endsection

@section('content')
<div class="box box-success" id="edit-add-pages">
    <div class="box-header with-border"> 
        @if( isset($blog) )
        <h3 class="box-title">Edit Blog</h3>
        @else
        <h3 class="box-title">Create Blog</h3> 
        @endif
        <div class="box-tools pull-right">

        </div>  
    </div>
    <div class="box-body">
        <div class="container">
            @if( isset($blog) )
            {{ html()->form('PUT', route('admin.blogs.update', $blog['id']))->id('create-edit-blog')->class('form-horizontal')->acceptsFiles()->open() }}
            @else
            {{ html()->form('POST', route('admin.blogs.store'))->id('create-edit-blog')->class('form-horizontal')->acceptsFiles()->open() }}
            @endif
            <div class="row form-group">
                <div class="col-sm-2">
                    {{ html()->label('Title:', 'blog_title') }}
                </div> 
                <div class="col-sm-8">
                    {{ html()->text('blog_title', isset($blog) ? $blog['title'] : null)->class('form-control title-input')->maxlength('191')->placeholder('Title')->required() }}
                    @if(count($errors->get('blog_title')) > 0)
                    <span class="backend-errors alert-danger">{{ $errors->first('blog_title') }}</span>
                    @endif
                </div>
            </div>   
            <div class="row form-group">
                <div class="col-sm-2">
                    {{ html()->label('Description:', 'blog_description') }}
                </div>
                <div class="col-sm-8">
                    {{ html()->textarea('blog_description', isset($blog) ? $blog['description'] : null)->class('form-control textarea')->required()->maxlength('191')->placeholder('Description') }}
                    @if(count($errors->get('blog_description')) > 0)
                    <span class="backend-errors alert-danger">{{ $errors->first('blog_description') }}</span>
                    @endif
                </div>
            </div>
            <div class="row form-group">  
                <div class="col-sm-2">
                    {{ html()->label('Content:', 'blog_content') }}
                </div>
                <div class="col-sm-8">
                    {{ html()->textarea('blog_content', isset($blog) ? $blog['content'] : null)->class('form-control ')->id('ckeditor')->required() }}
                    @if(count($errors->get('blog_content')) > 0)
                    <span class="backend-errors alert-danger">{{ $errors->first('blog_content') }}</span>
                    @endif
                </div>
            </div>
            <div class="row form-group">
                <div class="col-sm-2">
                    {{ html()->label('Image:', 'blog_image') }}
                </div>
                <div class="col-sm-5">
                    @if( isset($blog) )
                    <div class="image-div">
                        <img src="{{ asset('storage'.'/'. $blog->image )}}" class="img-responsive">
                    </div>
                    {{ html()->file('blog_image', ['class' => 'form-control', 'required' => 'required']) }}
                    @else
                    {{ html()->file('blog_image', ['class' => 'form-control', 'required' => 'required']) }}
                    @endif
                    @if(count($errors->get('blog_image')) > 0)
                    <span class="backend-errors alert-danger">{{ $errors->first('blog_image') }}</span>
                    @endif
                </div>
            </div>
        </div>
    </div>    
</div>
<div class="box box-info  create-edit-cancel-btn">
    @if( isset($blog) )
    {{ html()->submit('Update')->class('btn btn-primary edit-create-btn') }}
    @else
    {{ html()->submit('Create')->class('btn btn-primary edit-create-btn') }}
    @endif
    <a href="{{route("admin.blogs.index")}}" class="btn btn-primary cancel-btn">Cancel</a>
</div>
{{ html()->form()->close() }}    

@endsection

@section('after-scripts')
<script src="{{ asset("ckeditor/ckeditor.js") }}"></script>

<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.17.0/jquery.validate.min.js"></script>-->
<script>
    $(document).ready(function () {
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

//      alert('test');
//      $(document).on('click', '.edit-create-btn', function () {
//       form = $('#question-signer-rent-action input, textarea,select');
//      form.validate();
////         $(".backend-errors").show();
//
//      });
//         e.preventDefault();
//      $(".error").hide();
//        $(document).on('click', '.edit-create-btn', function () {
//       
//      });

    });
</script>
@endsection


