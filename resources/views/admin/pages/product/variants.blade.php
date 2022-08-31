@php
$i = 1;
@endphp
@if ($listVar)
    @foreach ($listVar as $key => $variant)
        <div class="form-group attr-variant" style="margin-top: 25px">
            {{ Form::label('add_attribute', 'Variant / Price ' . $i++, ['class' => 'control-label col-md-3 col-sm-3 col-xs-12']) }}
            <input class="btn btn-default" type="text" value="{{ $variant['name'] }}" readonly data-id="">
            <input type="text" name="price" class="btn btn-default" style="width:100px" id="currency-field" pattern="[0-9][0-9,]*[0-9]" data-type = "currency" value="{{ $variant['price'] }}">
            <input type="hidden" name="id_combination" value="{{ $variant['attribute_value_id'] }}">
        </div>
    @endforeach
@endif
