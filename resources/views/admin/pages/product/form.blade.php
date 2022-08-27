@extends('admin.main')
@php
use App\Helpers\Form as FormTemplate;
use App\Helpers\Template;
use Illuminate\Support\Facades\DB;
use App\Models\ProductModel;
use App\Models\ProductAttributeModel;
$itemsCategory = ProductModel::listCategory(null, ['task' => 'get-category'], false, false);
$productAttr = ProductAttributeModel::productAttr($item ?? '') ?? [];
$listAttr = [];
$attrSelectedId = null;
$attrSelectedName = null;
$tagifyCurrent = '';
// if (!empty($productAttr)) {
//     $listAttr['select'] = 'Select Attribute';
//     foreach ($productAttr as $key => $value) {
//         $listAttr[$value['attribute']['id']] = $value['attribute']['name'];
//         if ($value['product_id'] == $item['id']) {
//             $attrSelectedId = $value['attribute']['id'];
//             $attrSelectedName = $value['attribute']['name'];
//         }
//     }
// }
// if (!empty($attrSelectedId)) {
//     $tagifyCurrent .= $attrSelectedName . ' <input class="tagify-attr my-tagify" name="attr_value['.$attrSelectedId.']" type="text"><br>';
// }
// dd($productAttr);
$configTagsInput = ['class' => 'some_class_name my-tagify', 'width' => '100', 'height' => 40];
$formInputAttr = config('zvn.template.form_input');
$select2 = config('zvn.template.form_select2');
$select2Attr = ['class' => 'form-control col-md-6 col-xs-12 select-select2 select2-attr'];
$formLabelAttr = config('zvn.template.form_label');
$formCkeditor = config('zvn.template.form_ckeditor');
$statusValue = ['active' => config('zvn.template.status.active.name'), 'inactive' => config('zvn.template.status.inactive.name')];
$itemsSpecial = ['0' => 'Không đặc biệt', '1' => 'Đặc biệt'];
$attrPriceForm = [
    'class' => 'form-control col-md-6 col-xs-12',
    'id' => 'currency-field',
    'data-type' => 'currency',
    'min' => '1',
    'pattern' => '[0-9][0-9,]*[0-9]',
];

$inputHiddenID = Form::hidden('id', @$item['id']);
$inputHiddenThumb = Form::hidden('thumb_current', @$item['thumb']);
// dd($item['thumb']);

$imgThumb = '';
$imgCur = sprintf('<div class="form-group"><div class="" id="sortable">');
if (!empty(@$item['id'])) {
    if (!empty($item['thumb'])) {
        // dd($item['thumb']);
        $thumbDecode = json_decode($item['thumb'] ?? '', true);
        // $thumb = $thumbDecode['image'][0] ?? '';
        foreach ($thumbDecode['image'] ?? [] as $key => $img) {
            // $imgThumb .= Template::showItemThumb($controllerName, @$img, @$thumbDecode['alt'][$key]);
            $imgThumb = sprintf('<img src="%s" alt="%s" class="zvn-thumb" width ="75" height = "100">', asset("images/$controllerName/$img"), $thumbDecode['alt'][$key]);
            $imgCur .= sprintf(
                '<div class="mb-3 d-flex p-2 bg-warning">
                %s
                <input class="" type="hidden" name="thumbCur[]" id="formFile" value=" %s ">
                <input class="form-control col-md-3 col-sm-3 col-xs-12" type="text" name="altCur[]" value = " %s ">
                <button type="button" class="btn btn-danger btn-delete-image">X</button>
            </div>',
                $imgThumb,
                $img,
                $thumbDecode['alt'][$key],
            );
        }
    }
    $imgCur .= sprintf('</div></div>');
}

$elements = [
    [
        'label' => Form::label('name', 'Name', $formLabelAttr),
        'element' => Form::text('name', @$item['name'], $formInputAttr),
    ],
    [
        'label' => Form::label('price', 'Price(Vnd)', $formLabelAttr),
        'element' => Form::text('price', @$item->price_product, $attrPriceForm),
    ],
    [
        'label' => Form::label('sale_off', 'Sale Off(%)', $formLabelAttr),
        'element' => Form::number('sale_off', @$item['sale_off'] ?? '0', $formInputAttr),
    ],
    [
        'label' => Form::label('product_category_id', 'Category', $formLabelAttr),
        'element' => Form::select('product_category_id', $itemsCategory, @$item['product_category_id'], $select2),
    ],
    // [
    //     'label' => Form::label('attribute', 'Attribute', $formLabelAttr),
    //     'element' =>
    //         Form::select('attribute_id', $listAttr, $attrSelectedId, $select2Attr) .
    //         '<div id="append-attr">
    //             ' .
    //         $tagifyCurrent .
    //         '
    //         </div>',
    // ],
    [
        'label' => Form::label('description', 'Description', $formLabelAttr),
        'element' => Form::textArea('description', @$item['description'], $formInputAttr),
    ],
    [
        'label' => Form::label('content', 'Content', $formLabelAttr),
        'element' => Form::textArea('content', @$item['content'], $formCkeditor),
    ],
    [
        'label' => Form::label('ordering', 'Ordering', $formLabelAttr),
        'element' => Form::number('ordering', @$item['ordering'] ?? '10', $formInputAttr),
    ],
    [
        'label' => Form::label('status', 'Status', $formLabelAttr),
        'element' => Form::select('status', $statusValue, @$item['status'], $formInputAttr),
    ],
    [
        'label' => Form::label('special', 'Special', $formLabelAttr),
        'element' => Form::select('special', $itemsSpecial, @$item['special'], $formInputAttr),
    ],
    // [
    //     'label' => Form::label('thumb', 'Thumb', $formLabelAttr),
    //     'element' => Form::file('thumb', $formInputAttr),
    //     'thumb' => !empty(@$item['id']) ? Template::showItemThumb($controllerName, @$item['thumb'], @$item['name']) : null,
    //     'type' => 'thumb',
    // ],
    // [
    //     'label' => Form::label('upload', 'Upload New Images', $formLabelAttr),
    //     'element' => '
    //                 <div class="form-group">
    //                     <button type="button" class="btn btn-primary" id="btn-add-image">Add Image</button>
    //                     <div class="image-wrapper" id="sortable">
    //                         <div class="mb-3 d-flex p-2 bg-warning">
    //                             <input class="form-control col-md-3 col-sm-3 col-xs-12" type="file" name="thumb1[]" id="formFile">
    //                             <input class="col-md-3" type="text" name="alt[]">
    //                             <button type="button" class="btn btn-danger btn-delete-image">X</button>
    //                         </div>
    //                     </div>
    //                 </div>',
    // ],
    // [
    //     'label' => Form::label('current_image', 'Current Image', $formLabelAttr),
    //     'element' => null,

    //     'thumb' => !empty(@$item['id']) ? $imgCur ?? '' : null,
    //     'type' => 'thumb',
    // ],

    // [
    //     'element' => $inputHiddenID . $inputHiddenThumb . Form::submit('Save', ['class' => 'btn btn-success']),
    //     'type' => 'btn-submit',
    // ],
];
@endphp

@section('content')
    @include ('admin.templates.page_header', ['pageIndex' => false])
    @include ('admin.templates.error')

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                @include('admin.templates.x_title', ['title' => 'Form'])
                <div class="x_content">
                    {{ Form::open([
                        'method' => 'POST',
                        'url' => route("$controllerName/save"),
                        'accept-charset' => 'UTF-8',
                        'enctype' => 'multipart/form-data',
                        'class' => 'form-horizontal form-label-left',
                        'id' => 'main-form',
                    ]) }}
                    {!! FormTemplate::show($elements) !!}

                    <div class="form-group">
                        {{ Form::label('thumb', 'Thumb', ['class' => 'control-label col-md-3 col-sm-3 col-xs-6']) }}
                        <div class="input-group hdtuto control-group lst increment col-md-3 col-sm-3 col-xs-6">
                            <div class="list-input-hidden-upload">
                                <input type="file" name="filenames[]" id="file_upload" class="myfrm form-control hidden">
                            </div>
                            <div class="input-group-btn col-md-3 col-sm-3 col-xs-12'">
                                <button class="btn btn-success btn-add-image" type="button"><i
                                        class="fldemo glyphicon glyphicon-plus"></i> Add image</button>
                            </div>
                        </div>
                        <div class="list-images col-md-offset-3 col-md-6 col-xs-12">
                            @if (isset($item['thumb']) && !empty($item['thumb']))
                                {{-- @dd(json_decode($item['thumb'])) --}}
                                {{-- @dd($thumbDecode) --}}
                                @foreach ($thumbDecode['image'] ?? [] as $key => $img)
                                    <div class="box-image" style="margin-bottom: 10px">
                                        <input type="hidden" name="images_uploaded[]" value="{{ $img }}"
                                            id="img-{{ $key }}">
                                        <img src='{{ asset("images/$controllerName/" . $img) }}' class="picture-box"
                                            width="150" height="180">
                                        <input type="text" name="alt[]" value="{{ $thumbDecode['alt'][$key] }}"
                                            id="alt-{{ $key }}">

                                        <div class="wrap-btn-delete">
                                            <button class="btn btn-danger btn-delete-image" type="button"
                                                data-id="img-{{ $key }}">
                                                <i class="fldemo glyphicon glyphicon-remove"></i> Remove</button>
                                        </div>
                                    </div>
                                @endforeach
                                <input type="hidden" name="images_uploaded_origin" value="{{ $item['thumb'] }}">
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                            {!! $inputHiddenID . $inputHiddenThumb !!}
                            <input class="btn btn-success" type="submit" value="Save">
                        </div>
                    </div>

                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
@endsection
