<option value>Select ZipCode</option>
@foreach($zipCodes as $zipCode)
<option <?php
if (isset($zip_id) && $zip_id) {
    if ($zipCode->id == $zip_id) {
        ?>
            selected="selected"
            <?php
        }
    }
    ?> value="{{$zipCode->id}}">{{$zipCode->zipcode}}</option>
@endforeach