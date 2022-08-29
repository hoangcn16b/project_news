@php
// echo $id;
// echo '<pre>';
// print_r($resultVal);
// echo '</pre>';
echo '<pre>';
print_r($resultName);
echo '</pre>';

@endphp

<div class="form-group add-variant">
    <label for="variant" class="control-label col-md-3 col-sm-3 col-xs-6">1</label>
    <input class="btn btn-default" type="text" value="variant color x size" style="width:200px" readonly
        data-id="{{ $id }}">
    <input type="text" name="variant[]" id="" class="btn btn-default" style="width:200px" placeholder="price"
        data-id="{{ $id }}">
</div>
