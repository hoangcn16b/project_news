@php
use App\Models\CategoryModel as CategoryModel;
use App\Helpers\URL;
$categoryModel = new CategoryModel();
$getAncestor = '';

$ancestors = CategoryModel::ancestorsOf($item['id']);
foreach ($ancestors as $key => $ancestor) {

    if ($ancestor->id == 1) {
        $getAncestor .= '<li><a href="'.route('home').'">Trang chủ</a></li>';
        $linkSubList = route('home');
        continue;
    }else {
        $linkSubList = URL::linkCategory($ancestor->id, $ancestor->name);

    }
    $getAncestor .= ' <li> <a href=" '.$linkSubList.' "> ' . $ancestor->name . '</a></li>';
}

// dd($node);

@endphp

<div class="home">
    <div class="parallax_background parallax-window" data-parallax="scroll" data-image-src="{!! asset('news/images/footer.jpg') !!}"
        data-speed="0.8"></div>
    <div class="home_content_container">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="home_content">
                        <div class="home_title">{!! $item['name'] !!}</div>
                        <div class="breadcrumbs">
                            <ul class="d-flex flex-row align-items-start justify-content-start">
                                {{-- <li><a href="{!! route('home') !!}">Trang chủ</a></li> --}}
                                {!! $getAncestor !!}
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
