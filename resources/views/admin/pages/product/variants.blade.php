@php
// echo $id;
// echo '<pre>';
// print_r($resultVal);
// echo '</pre>';

@endphp
<div class="form-group attr-variant" style="margin-top: 25px">
    {{ Form::label('add_attribute', 'Variant / Price', ['class' => 'control-label col-md-3 col-sm-3 col-xs-12']) }}
    <input class="btn btn-default" type="text" value="variant color x size" style="width:150px" readonly data-id="">
    <input type="text" name="price" id="" class="btn btn-default" style="width:100px" data-id="">
</div>
<div class="form-group attr-variant" style="margin-top: 25px">
    {{ Form::label('add_attribute', 'Variant/Price', ['class' => 'control-label col-md-3 col-sm-3 col-xs-12']) }}
    <input class="btn btn-default" type="text" value="variant color x size" style="width:150px" readonly
        data-id="">
    <input type="text" name="price" id="" class="btn btn-default" style="width:100px" data-id="">
</div>

