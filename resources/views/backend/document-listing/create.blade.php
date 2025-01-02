@extends('backend.layouts.app')

@if( isset($document) )
@section ('title', ('Edit Document'))
@else
@section ('title', ('Create Document'))
@endif

@section('page-header')
<h1>Document List Management</h1>    
@endsection

@section('content')
<div class="box box-success" id="edit-add-pages">
    <div class="box-header with-border"> 
        @if( isset($document) )
        <h3 class="box-title">Edit Document</h3>
        @else
        <h3 class="box-title">Create Document</h3>
        @endif
        <div class="box-tools pull-right">

        </div>  
    </div>
    <div class="box-body">
        <div class="container">
            @if( isset($document) )
            {{ html()->form('PUT', route('admin.document-listing.update', $document['id']))->class('form-horizontal update_document')->acceptsFiles()->open() }}
            @else
            {{ html()->form('POST', route('admin.document-listing.store'))->class('form-horizontal document_create')->acceptsFiles()->open() }}
            @endif
            <div class="row form-group">
                <div class="col-sm-2">
                    {{ html()->label('State:', 'state') }}
                </div>
                <div class="col-sm-5">
                    <select name="state" id="state" class="form-control title-input" required>
                        <option value="{{ config('constant.instructions') }}">Instructions</option>
                        @if( isset($document) )
                        <option value="{{ $document->state->id }}">{{ $document->state->state }}</option>

                        @foreach($states as $state)
                        <option value="{{ $state->id }}">{{ $state->state }}</option>
                        @endforeach 
                        @else
                        @if( isset($states) )
                        <option value="" disabled selected hidden>Select State</option>
                        @foreach($states as $state)
                        <option value="{{ $state->id }}">{{ $state->state }}</option>
                        @endforeach 
                        @endif
                        @endif
                    </select>     
                    @if(count($errors->get('state')) > 0)
                    <span class="backend-errors alert-danger">{{ $errors->first('state') }}</span>
                    @endif
                </div>
            </div>      
            <div class="row form-group">
                <div class="col-sm-2">
                    {{ html()->label('Document:', 'document') }}
                </div>        
                <div class="col-sm-5">
                    @if( isset($document) )
                    <div class="form-control title-input">
                        {{ $document->document }}
                    </div>
                    {{ html()->file('document')->required() }}
                    @else
                    {{ html()->file('document')->required() }}
                    @endif
                    @if(count($errors->get('document')) > 0)
                    <span class="backend-errors alert-danger">{{ $errors->first('document') }}</span>
                    @endif
                </div>
            </div>
            <div class="row form-group" id="timeshareCalender" style="display:none;">
                <div class="col-sm-2">
                    {{ html()->label('Timeshare Calender:', 'timeshare calender') }}
                </div>
                <div class="col-sm-5">
                    {{ html()->checkbox('timeshare_calender', false, 1)->id('timeshare_calender') }}
                </div>
            </div>
        </div>
    </div>
</div>    
<div class="box box-info  create-edit-cancel-btn">
    @if( isset($document) )
    {{ html()->submit('Update')->class('btn btn-primary edit-create-btn') }}
    @else
    {{ html()->submit('Create')->class('btn btn-primary edit-create-btn') }}
    @endif
    <a href="{{route("admin.document-listing.index")}}" class="btn btn-primary cancel-btn">Cancel</a>
</div>
{{ html()->form()->close() }}

@endsection

@section('after-scripts')

<script>
    $(document).ready(function () {
                $('#timeshare_calender').prop('checked', false);
        $("#state").change(function(e) {
                $('#timeshareCalender').hide();
                $('#timeshare_calender').prop('checked', false);
            if($('#state option:selected').val() == "{{config('constant.instructions')}}"){
                $('#timeshareCalender').show();
            } else {
                $('#timeshareCalender').hide();
            }
        });
        $('form').validate({
           rules: {
               document: {
                   extension: "pdf"
               }
           },
           messages: {
               state: {
                   required: "Please select state"
               },
               document: {
                   extension: "Please select only pdf files"
               }
           }
        });
        
        jQuery.validator.addMethod("extension", function (value, element, param) {
            param = typeof param === "string" ? param.replace(/,/g, '|') : "png|jpe?g|gif";
            return this.optional(element) || value.match(new RegExp(".(" + param + ")$", "i"));
        }, jQuery.validator.format("Please enter a value with a valid extension."));
    });
</script>
@endsection



