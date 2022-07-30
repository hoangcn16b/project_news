@extends('admin.main')
@php
    use App\Helpers\Template as Template;
@endphp

@section('content')
    
    {{-- @include ('admin.templates.page_header', ['pageIndex' => true]) --}}
    @include ('admin.templates.zvn_notify')

    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                @include('admin.templates.x_title', ['title' => ' Thay đổi cấu hình website'])
                @include('admin.pages.setting.form')
            </div>
        </div>
    </div>
    
@endsection
