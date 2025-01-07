<option value="">Select District</option>
@foreach($schoolDistricts as $key=>$district)
<option <?php
if (isset($districtId) && $districtId) {
    if ($district->id == $districtId) {
        ?>
            selected="selected"
            <?php
        }
    }
    ?> value="{{$district->id}}">{{$district->district}}</option>
@endforeach