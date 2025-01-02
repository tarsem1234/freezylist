<option value="">Continental Regions</option>
@foreach($subregions as $subregion)
<option <?php
if (!empty($subregion_id)) {
    if ($subregion->id == $subregion_id) {
        ?>
            selected="selected"
            <?php
        }
    }
    ?> value="{{$subregion->id}}">{{$subregion->subregion}}</option>
@endforeach