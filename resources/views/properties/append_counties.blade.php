<option>Select County</option>
@foreach($counties as $county)
<option <?php
if (!empty($county_id)) {
    if ($county->id == $county_id) {
        ?>
            selected="selected"
            <?php
        }
    }
    ?> value="{{$county->id}}">{{$county->county}}</option>
@endforeach