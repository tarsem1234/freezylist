<option value="">Select School</option>
@foreach($schools as $key=>$school)
<option <?php
if (!empty($school_ids)) {
    foreach($school_ids as $school_id){
    if ($school->id == $school_id) {
        ?>
            selected="selected"
            <?php
        }
        }
    }
    ?> value="{{$school->id}}">{{$school->name}}</option>
@endforeach