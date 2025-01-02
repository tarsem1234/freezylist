@extends ('backend.layouts.app')
@section ('title', ('Auto Email Logs'))
@section('page-header')
<h1>Auto Email Logs </h1> 
@endsection 
@section('content')
<div id="del-success-msg" class="alert alert-success"></div>
<div class="box box-success">
    <div class="box-body" class="top"> 
        {{ html()->form('POST', route('admin.exportAutoLogs'))->open() }}
        <div class="form-group">
            <div class="col-sm-4">
                <h5> Date Range: </h5> 
                <input type="text" class="form-control" id="datetimepicker" name="start_date" class="form-control" placeholder="Pick Date" required=""> 
            </div> 
            <div class="col-sm-4">
                <h5> To: </h5>
                <input type="text" class="form-control" id="todate" name="end_date" class="form-control" placeholder="Pick Date"  required="">                               
            </div>
            <div class="col-sm-4">  
                <h5> Download: </h5> 
                <button class="btn btn-success" id="range_download" type="submit">Download By Range</button>
            </div>
        </div>        
        {{ html()->form()->close() }}
        <div class="col-sm-12">                        
            <div class="button"> 
                <a href="{{route('admin.exportAutoLogs', 'all')}}" class="btn btn-info download_bttns">Download All Logs</a>
            </div>                                 
        </div>     
    </div> 
</div>
@endsection

@section('after-scripts') 
<link type="text/css" rel="stylesheet" href="{{ asset("https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/css/bootstrap-datepicker.min.css") }}" media="all">  
<script src="{{ asset("https://cdn.jsdelivr.net/momentjs/latest/moment.min.js") }}"></script>
<script src="{{ asset("https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.8.0/js/bootstrap-datepicker.min.js") }}"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $('#datetimepicker').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
        }).on('changeDate', function (selected) {
            var minDate = new Date(selected.date.valueOf());
            $('#todate').datepicker('setStartDate', minDate);
        });
        $("#todate").datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
        }).on('changeDate', function (selected) {
            var maxDate = new Date(selected.date.valueOf());
            $('#datetimepicker').datepicker('setEndDate', maxDate);
        });
    });
</script> 
@endsection


