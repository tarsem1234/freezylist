<option value="">Country Selection</option>
@foreach($countries as $key=>$country)
<option <?php
if (!empty($country_id)) {
    if ($country->id == $country_id) {
        ?>
            selected="selected"
            <?php
        }
    }
    ?> value="{{$country->id}}">{{$country->country}}</option>
@endforeach