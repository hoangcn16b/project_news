@php

$xhtmlListAttr = '';
if (!empty($dataAttrId)) {
    foreach ($dataAttrId as $key => $value) {
        // $valTagInput = trim($value->value_taginput, '"');

        $xhtmlListAttr .=
            '
        <div class="form-group child-attr" style="margin-top: 50px">
            ' .
            Form::label('add_attribute', 'Name/Value', ['class' => 'control-label col-md-3 col-sm-3 col-xs-12']) .
            '
            <input name="attribute_names[]" type="text" value="'.$dataAttrName[$key].'" class="btn btn-default attr-name"
                style="width:100px" data-url-update-name="'.route('product/updateAttributeName').'">
            <input name="attribute_values[]" type="text" class="my-tagify btn btn-default attr-value"   data-url-update-value="'.route('product/updateAttributeValue').'" 
            value =' .
            $dataAttrVal[$key] .
            ' >
            <input class="input-id-hidden" data-id="'.$value.'" type="hidden" name="attribute_ids[]" value="'.$value.'">

            <button class="btn btn-danger btn-del-attr" type="button" data-url-delete="'.route('product/deleteAttribute').'"> Delete</button>
        </div>

        ';
    }
}

@endphp
{!! $xhtmlListAttr !!}

<script type="text/javascript">
    let myTagify = document.querySelectorAll('.my-tagify');
    myTagify.forEach(ele => {
        new Tagify(ele);
    });
</script>
