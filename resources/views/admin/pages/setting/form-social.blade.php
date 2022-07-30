@php
use App\Helpers\Form as FormTemplate;
use App\Helpers\Template;

$formInputAttr = config('zvn.template.form_input');
$formLabelAttr = config('zvn.template.form_label');

$inputTaskEmailAccount = Form::hidden('task_social_setting', 'social-setting');
$inputTaskEmailBcc = Form::hidden('task_social', 'social');

$elementsSocial = [
    [
        'label' => Form::label('facebook', 'Facebook', $formLabelAttr),
        'element' => Form::text('facebook', @$itemEmailAccount['facebook'], ['class' => 'some_class_name', 'width'=>'100']),
    ],
    [
        'label' => Form::label('youtube', 'Youtube', $formLabelAttr),
        'element' => Form::text('youtube', @$itemEmailAccount['youtube'], $formInputAttr),
    ],
    [
        'element' => $inputTaskEmailAccount . Form::submit('Save', ['class' => 'btn btn-success']),
        'type' => 'btn-submit',
    ],
];

@endphp


<div class="x_content">
    {{ Form::open([
        'method' => 'POST',
        'url' => route("$controllerName/save"),
        'accept-charset' => 'UTF-8',
        'enctype' => 'multipart/form-data',
        'class' => 'form-horizontal form-label-left',
        'id' => 'main-form-social-setting',
    ]) }}
    {!! FormTemplate::show($elementsSocial) !!}
    {{ Form::close() }}
    <div class="ln_solid"></div>

</div>
