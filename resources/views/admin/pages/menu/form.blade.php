@extends('admin.main')
@php
use App\Helpers\Form as FormTemplate;
use App\Helpers\Template;

$formInputAttr = config('zvn.template.form_input');
$formLabelAttr = config('zvn.template.form_label');

$statusValue = ['active' => config('zvn.template.status.active.name'), 'inactive' => config('zvn.template.status.inactive.name')];
$orderingValue = config('zvn.template.ordering');
$typeValue = [ 'link' =>config('zvn.template.display_menu.link.name'), 'sub_list_menu' =>config('zvn.template.display_menu.sub_list_menu.name')];
$inputHiddenID = Form::hidden('id', @$item['id']);
$elements = [
    [
        'label' => Form::label('name', 'Name', $formLabelAttr),
        'element' => Form::text('name', @$item['name'], $formInputAttr),
    ],
    [
        'label' => Form::label('link', 'Link', $formLabelAttr),
        'element' => Form::text('link', @$item['link'], $formInputAttr),
    ],
    [
        'label' => Form::label('in_table', 'Dữ liệu thuộc về(danh mục? e.x: category)', $formLabelAttr),
        'element' => Form::text('in_table', @$item['in_table'], $formInputAttr),
    ],
    [
        'label' => Form::label('type', 'Type Display', $formLabelAttr),
        'element' => Form::select('type', $typeValue, @$item['type'], $formInputAttr),
    ],
    [
        'label' => Form::label('status', 'Status', $formLabelAttr),
        'element' => Form::select('status', $statusValue, @$item['status'], $formInputAttr),
    ],
    [
        'label' => Form::label('ordering', 'Ordering', $formLabelAttr),
        'element' => Form::select('ordering', $orderingValue, @$item['ordering'], $formInputAttr),
    ],
    [
        'element' => $inputHiddenID . Form::submit('Save', ['class' => 'btn btn-success']),
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
