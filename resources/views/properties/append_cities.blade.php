@if(isset($usCities))
<option  value="">Select Your Destination City</option>
@foreach($cities as $city)
<option <?php
if (isset($city_id)&&$city_id) {
    if ($city->id == $city_id) {
        ?>
            selected="selected"
            <?php
        }
    }
    ?> value="{{$city->id}}">{{$city->city}}</option>
@endforeach
@endif

@if(isset($nonUsCities))    
<option value="">International Destination City</option>
@foreach($cities as $city)
<option <?php
if (isset($cityName)&& $cityName) {
    if ($city->city_id == $cityName) {
        ?>
            selected="selected"
            <?php
        }
    }
    ?>  value="{{$city->id}}">{{$city->city}}</option>
@endforeach
@endif