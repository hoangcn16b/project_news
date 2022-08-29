@extends('admin.main')
@php
use App\Helpers\Form as FormTemplate;
use App\Helpers\Template;
use Illuminate\Support\Facades\DB;
use App\Models\ProductModel;
use App\Models\ProductAttributeModel;
$itemsCategory = ProductModel::listCategory(null, ['task' => 'get-category'], false, false);

echo '<pre>';
print_r ($itemId);
echo '</pre>';
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

$inputHiddenThumb = null;

$elements = [
    [
        'label' => Form::label('name', 'Name', $formLabelAttr),
        'element' => Form::text('name', '', $formInputAttr),
    ],
    [
        'label' => Form::label('price', 'Price(Vnd)', $formLabelAttr),
        'element' => Form::text('price', '', $attrPriceForm),
    ],
    [
        'label' => Form::label('sale_off', 'Sale Off(%)', $formLabelAttr),
        'element' => Form::number('sale_off', '0', $formInputAttr),
    ],
    [
        'label' => Form::label('product_category_id', 'Category', $formLabelAttr),
        'element' => Form::select('product_category_id', $itemsCategory, '', $select2),
    ],
    [
        'label' => Form::label('description', 'Description', $formLabelAttr),
        'element' => Form::textArea('description', '', $formInputAttr),
    ],
    [
        'label' => Form::label('content', 'Content', $formLabelAttr),
        'element' => Form::textArea('content', '', $formCkeditor),
    ],
    [
        'label' => Form::label('ordering', 'Ordering', $formLabelAttr),
        'element' => Form::number('ordering', '10', $formInputAttr),
    ],
    [
        'label' => Form::label('status', 'Status', $formLabelAttr),
        'element' => Form::select('status', $statusValue, 'active', $formInputAttr),
    ],
    [
        'label' => Form::label('special', 'Special', $formLabelAttr),
        'element' => Form::select('special', $itemsSpecial, '0', $formInputAttr),
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

                    <div class="form-group">
                        {{ Form::label('thumb', 'Thumb', ['class' => 'control-label col-md-3 col-sm-3 col-xs-6']) }}
                        <div class="input-group hdtuto control-group lst increment col-md-3 col-sm-3 col-xs-6">
                            <div class="list-input-hidden-upload">
                                <input type="file" name="filenames[]" id="file_upload" class="myfrm form-control hidden">
                            </div>
                            <div class="input-group-btn col-md-3 col-sm-3 col-xs-12'">
                                <button class="btn btn-primary btn-add-attr" type="button"><i
                                        class="fldemo glyphicon glyphicon-plus"></i> Add image</button>
                            </div>
                        </div>
                        <div class="list-images col-md-offset-3 col-md-6 col-xs-12">
                        </div>
                    </div>

                    <div>
                        {{-- <form action="{{ route('product/addAttribute') }}" class="this-form-add-attr"
                            id="this-form-add-attr" method="GET">
                            @csrf --}}
                        <div class="x_title" style="margin-top: 50px">
                            <h2>Add product attribute</h2>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content add-all-attr" style="margin-top: 50px">
                            <div class="form-group">
                                {{ Form::label('add_attribute', 'Add attribute', ['class' => 'control-label col-md-3 col-sm-3 col-xs-6']) }}
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <button class="btn btn-info add-attr" type="button">+Add attribute</button>
                                    <button class="btn btn-success save-attr" type="button"
                                        data-url-add-attr="{{ route('product/addAttribute') }}">Save Attribute</button>
                                </div>

                            </div>
                            <div class="form-group">
                                <label for="new_attribute"
                                    class="control-label col-md-3 col-sm-3 col-xs-6">Name/Value</label>
                                <input name="attribute_name[]" type="text" value="color" class="btn btn-default"
                                    style="width:200px">
                                <input name="attribute_value[]" type="text" value="red"
                                    class="my-tagify btn btn-default" style="width:200px">
                                <button class="btn btn-danger btn-del-attr" type="button"> Delete</button>
                            </div>
                        </div>
                        <div class="x_content add-all-variant" style="margin-top: 50px">
                            <div class="form-group">
                                {{ Form::label('variant', 'Variants', ['class' => 'control-label col-md-3 col-sm-3 col-xs-6']) }}
                            </div>
                        </div>
                        <input name="id" type="hidden" value="{{ $itemId }}">
                        {{-- </form> --}}
                    </div>
                    <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                            <div class="ln_solid"></div>
                            {!! $inputHiddenThumb !!}
                            <input class="btn btn-success" type="submit" value="Save">
                        </div>
                    </div>
                    {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
@endsection
