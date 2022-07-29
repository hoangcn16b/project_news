@php
use App\Helpers\Form as FormTemplate;
use App\Helpers\Template;

$formInputAttr = config('zvn.template.form_input');
$formLabelAttr = config('zvn.template.form_label');

$inputHiddenID = Form::hidden('id', session('userInfo.id'));

$elements = [
    [
        'label' => Form::label('password', 'Old password', $formLabelAttr),
        'element' => Form::password('password', $formInputAttr),
    ],
    [
        'label' => Form::label('name', 'New password', $formLabelAttr),
        'element' => Form::password('new_password', $formInputAttr),
    ],
    [
        'label' => Form::label('name', 'Confirm new password', $formLabelAttr),
        'element' => Form::password('new_confirm_password', $formInputAttr),
    ],
    [
        'element' => $inputHiddenID . Form::submit('Save', ['class' => 'btn btn-success']),
        'type' => 'btn-submit',
    ],
];
@endphp

@include ('admin.templates.error')


<div class="x_content">
    <ul class="nav nav-tabs bar_tab" id="myTab" role="tablist">
        <li class="nav-item ">
            <a class="nav-link" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home"
                aria-selected="false">Cấu hình chung</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab"
                aria-controls="profile" aria-selected="false">Email</a>
        </li>
        <li class="nav-item">
            <a class="nav-link " id="contact-tab" data-toggle="tab" href="#contact" role="tab"
                aria-controls="contact" aria-selected="true">Social</a>
        </li>
    </ul>
    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade" id="home" role="tabpanel" aria-labelledby="home-tab">
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
        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
            Food truck fixie locavore, accusamus mcsweeney's marfa nulla single-origin coffee squid.
            Exercitation +1 labore velit, blog sartorial PBR leggings next level wes anderson artisan four loko
            farm-to-table craft beer twee. Qui photo
            booth letterpress, commodo enim craft beer mlkshk aliquip
        </div>
        <div class="tab-pane fade active show" id="contact" role="tabpanel" aria-labelledby="contact-tab">
            xxFood truck fixie locavore, accusamus mcsweeney's marfa nulla single-origin coffee squid.
            Exercitation +1 labore velit, blog sartorial PBR leggings next level wes anderson artisan four loko
            farm-to-table craft beer twee. Qui photo
            booth letterpress, commodo enim craft beer mlkshk
        </div>
    </div>
</div>
