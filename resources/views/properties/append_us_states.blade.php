<option value="">Select Your Destination</option>
@foreach($states as $state)
<option <?php
if (!empty($state_id)) {
    if ($state->id == $state_id) {
        ?>
            selected="selected"
            <?php
        }
    }
    ?> value="{{$state->id}}">{{$state->state}}</option>
@endforeach