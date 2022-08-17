@extends('admin.main')
@php
use App\Helpers\Form as FormTemplate;
use App\Helpers\Template;
use Illuminate\Support\Facades\DB;
use App\Models\ProductModel;

$itemsCategory = ProductModel::getCategory(null, ['task' => 'get-category']);
$formInputAttr = config('zvn.template.form_input');
$formLabelAttr = config('zvn.template.form_label');
$formCkeditor = config('zvn.template.form_ckeditor');
$statusValue = ['active' => config('zvn.template.status.active.name'), 'inactive' => config('zvn.template.status.inactive.name')];
$itemsSpecial = ['0' => 'Không đặc biệt', '1' => 'Đặc biệt'];
// $itemsCategory = config('zvn.template.article_post');

$inputHiddenID = Form::hidden('id', @$item['id']);
$inputHiddenThumb = Form::hidden('thumb_current', @$item['thumb']);

$elements = [
    [
        'label' => Form::label('name', 'Name', $formLabelAttr),
        'element' => Form::text('name', @$item['name'], $formInputAttr),
    ],
    [
        'label' => Form::label('price', 'Price', $formLabelAttr),
        'element' => Form::number('price', @$item['price'], $formInputAttr),
    ],
    [
        'label' => Form::label('sale_off', 'Sale Off', $formLabelAttr),
        'element' => Form::number('sale_off', @$item['sale_off'] ?? '0', $formInputAttr),
    ],
    [
        'label' => Form::label('product_category_id', 'Category', $formLabelAttr),
        'element' => Form::select('product_category_id', $itemsCategory, @$item['product_category_id'], $formInputAttr),
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
    [
        'label' => Form::label('thumb', 'Thumb', $formLabelAttr),
        'element' => Form::file('thumb', $formInputAttr),
        'thumb' => !empty(@$item['id']) ? Template::showItemThumb($controllerName, @$item['thumb'], @$item['name']) : null,
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
