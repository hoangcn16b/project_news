<div class="form-group child-attr" style="margin-top: 50px">
    <label for="name" class="control-label col-md-3 col-sm-3 col-xs-12">Name</label>

    <input name="attribute_names[]" type="text" value="" class="btn btn-default attr-name"
        style="margin-botton:10px" data-url-update-name="{{ route('product/updateAttributeName') }}">

    <button class="btn btn-warning btn-del-attr-all" type="button"
        data-url-delete-attr="{{ route('product/deleteAttribute') }}" data-id-delete-attr="{{ $newId }}">
        Delete Attribute</button>
    <button class="btn btn-primary btn-del-attr" type="button"
        data-url-add-attr="{{ route('product/addAttributeValue') }}" data-id-add-attr="{{ $newId }}"> New
        Value</button>

    {{-- <label for="name" class="control-label col-md-3 col-sm-3 col-xs-12">Value</label>
    <div class="input-group input-group-sm mb-3" style="margin-top: 10px">
        <input name="attribute_values[]" style="margin-botton:10px;margin-top:10px" type="text"
            class="btn btn-default attr-value" data-url-update-value="" data-id="">
        <button class="btn btn-warning btn-del-attr" type="button"
            data-url-delete="'.route('product/deleteAttribute').'"> Delete Value</button>
    </div> --}}
</div>
