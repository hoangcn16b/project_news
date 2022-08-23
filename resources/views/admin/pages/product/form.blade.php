@extends('admin.main')
@php
use App\Helpers\Form as FormTemplate;
use App\Helpers\Template;
use Illuminate\Support\Facades\DB;
use App\Models\ProductModel;

$itemsCategory = ProductModel::listCategory(null, ['task' => 'get-category'], false, false);

$formInputAttr = config('zvn.template.form_input');
$select2 = config('zvn.template.form_select2');
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
        $thumb = $thumbDecode['image'][0] ?? '';
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
    [
        'label' => Form::label('upload', 'Upload New Images', $formLabelAttr),
        'element' => '
                    <div class="form-group">
                        <button type="button" class="btn btn-primary" id="btn-add-image">Add Image</button>
                        <div class="image-wrapper" id="sortable">
                            <div class="mb-3 d-flex p-2 bg-warning">
                                <input class="form-control col-md-3 col-sm-3 col-xs-12" type="file" name="thumb1[]" id="formFile">
                                <input class="col-md-3" type="text" name="alt[]">
                                <button type="button" class="btn btn-danger btn-delete-image">X</button>
                            </div>
                        </div>
                    </div>',
    ],
    [
        'label' => Form::label('current_image', 'Current Image', $formLabelAttr),
        'element' => null,

        'thumb' => !empty(@$item['id']) ? $imgCur ?? '' : null,
        'type' => 'thumb',
    ],

    [
        'element' => $inputHiddenID . $inputHiddenThumb . Form::submit('Save', ['class' => 'btn btn-success']),
        'type' => 'btn-submit',
    ],
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

                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
@endsection
