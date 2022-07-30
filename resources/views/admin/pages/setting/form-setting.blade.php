@php
use App\Helpers\Form as FormTemplate;
use App\Helpers\Template;

$formInputAttr = config('zvn.template.form_input');
$formLabelAttr = config('zvn.template.form_label');
$formCkeditor = config('zvn.template.form_ckeditor');

$statusValue = ['default' => 'Select status', 'active' => config('zvn.template.status.active.name'), 'inactive' => config('zvn.template.status.inactive.name')];
$levelValue = ['default' => 'Select level', 'admin' => config('zvn.template.level.admin.name'), 'member' => config('zvn.template.level.member.name')];

// $inputHiddenID = Form::hidden('id', @$item['id']);
$inputHiddenAvatar = Form::hidden('avatar_current', @$item['logo']);
$inputHiddenTask = Form::hidden('task_general_setting', 'general-setting');

$elementsGeneralSetting = [
    [
        'label' => Form::label('logo', 'Logo', $formLabelAttr),
        'element' => Form::file('logo', $formInputAttr),
        'avatar' => !empty(@$item['logo']) ? Template::showItemThumb($controllerName, @$item['logo'], @$item['logo']) : null,
        'type' => 'avatar',
    ],
    [
        'label' => Form::label('hotline', 'Hotline', $formLabelAttr),
        'element' => Form::text('hotline', @$item['hotline'], $formInputAttr),
    ],
    [
        'label' => Form::label('timezone', 'Thời gian làm việc', $formLabelAttr),
        'element' => Form::text('timezone', @$item['timezone'], $formInputAttr),
    ],
    [
        'label' => Form::label('copyright', 'Copyright', $formLabelAttr),
        'element' => Form::text('copyright', @$item['copyright'], $formInputAttr),
    ],
    [
        'label' => Form::label('address', 'Địa chỉ', $formLabelAttr),
        'element' => Form::text('address', @$item['address'], $formInputAttr),
    ],
    [
        'label' => Form::label('introduction', 'Giới thiệu', $formLabelAttr),
        'element' => Form::textArea('introduction', @$item['introduction'], $formCkeditor),
    ],
    // [
    //     'label' => Form::label('introduction', 'Giới thiệu', $formLabelAttr),
    //     'element' => Form::text('introduction', @$item['introduction'], $formInputAttr),
    // ],
    [
        'element' => $inputHiddenAvatar . $inputHiddenTask . Form::submit('Save', ['class' => 'btn btn-success']),
        'type' => 'btn-submit',
    ],
];
@endphp

@include ('admin.templates.error')


<div class="x_content">
    <ul class="nav nav-tabs bar_tab" id="myTab" role="tablist">
        <li class="nav-item" id="home-tab-wrapper">
            <a class="nav-link " id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home"
                aria-selected="false">Cấu hình chung</a>
        </li>
        <li class="nav-item" id="profile-tab-wrapper">
            <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab"
                aria-controls="profile" aria-selected="false">Email</a>
        </li>
        <li class="nav-item" id="contact-tab-wrapper">
            <a class="nav-link " id="contact-tab" data-toggle="tab" href="#contact" role="tab"
                aria-controls="contact" aria-selected="true">Social</a>
        </li>
    </ul>
    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade" id="home" role="tabpanel" aria-labelledby="home-tab">
            {{-- <div class="x_content"> --}}
            {{ Form::open([
                'method' => 'POST',
                'url' => route("$controllerName/save"),
                'accept-charset' => 'UTF-8',
                'enctype' => 'multipart/form-data',
                'class' => 'form-horizontal form-label-left',
                'id' => 'main-form-general-setting',
            ]) }}
            {!! FormTemplate::show($elementsGeneralSetting) !!}
            {{ Form::close() }}
            {{-- </div> --}}
        </div>
        <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
            Food truck fixie locavore, accusamus mcsweeney's marfa nulla single-origin coffee squid.
            Exercitation +1 labore velit, blog sartorial PBR leggings next level wes anderson artisan four loko
            farm-to-table craft beer twee. Qui photo
            booth letterpress, commodo enim craft beer mlkshk aliquip
        </div>
        <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
            xxFood truck fixie locavore, accusamus mcsweeney's marfa nulla single-origin coffee squid.
            Exercitation +1 labore velit, blog sartorial PBR leggings next level wes anderson artisan four loko
            farm-to-table craft beer twee. Qui photo
            booth letterpress, commodo enim craft beer mlkshk
        </div>
    </div>
</div>
