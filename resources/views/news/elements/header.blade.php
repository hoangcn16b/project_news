@php
use App\Models\MenuModel as MenuModel;
use App\Helpers\URL;
use App\Models\CategoryModel as CategoryModel;
$menuModel = new MenuModel();
$categoryModel = new CategoryModel();
$itemsMenu = $menuModel->listItems(null, ['task' => 'news-list-items']);

$xhtmlMenu = '';
$xhtmlMenuMobile = '';
if (count($itemsMenu) > 0) {
    $xhtmlMenu = '<nav class="main_nav"><ul class="main_nav_list d-flex flex-row align-items-center justify-content-start">';
    $xhtmlMenuMobile = '<nav class="menu_nav"><ul class="menu_mm">';
    $menuIdCurrent = Route::input('menu_name');
    // dd($itemsMenu);
    foreach ($itemsMenu as $item) {
        $linkMenu = $item['link'];
        if ($item['type'] == 'link') {
            // $linkMenu = URL::linkMenu($item['id'], $item['name']);
            $classActive = '';
            $xhtmlMenu .= sprintf('<li class="%s"><a target = "%s" href="%s">%s</a></li>', $classActive, $item['type_open'], $linkMenu, $item['name']);
            $xhtmlMenuMobile .= sprintf('<li class="menu_mm"><a target = "%s" href="%s">%s</a></li>', $item['type_open'], $linkMenu, $item['name']);
        } elseif ($item['type'] == 'list_category') {
            $result = DB::table('categories')
                ->select('id', 'name')
                ->where('status', '=', 'active')
                ->get()
                ->toArray();

            $ulList = '<ul class="child">';
            $categoryIdCurrent = Route::input('category_id');

            foreach ($result as $key => $value) {
                $classActiveSubList = $categoryIdCurrent == $value->id ? 'active' : '';
                $linkSubList = URL::linkCategory($value->id, $value->name);

                $ulList .= sprintf('<li class="parent %s"><a target = "%s" href="%s">%s</a></li>', $classActiveSubList, $item['type_open'], $linkSubList, $value->name);
            }
            $ulList .= '</ul>';
            $xhtmlMenu .= sprintf('<li class="parent" %s><a> %s </a> %s </li>', $classActiveSubList, $item['name'], $ulList);
            $xhtmlMenuMobile .= sprintf('<li class="menu_mm"><a href="%s">%s</a></li>', $linkMenu, $item['name']);
        } elseif ($item['type'] == 'list_article') {
            $result = DB::table('articles')
                ->select('id', 'name')
                ->where('status', '=', 'active')
                ->get()
                ->toArray();

            $ulList = '<ul class="child">';
            $categoryIdCurrent = Route::input('category_id');
            $categoryIdCurrent = '';

            foreach ($result as $key => $value) {
                $classActiveSubList = $categoryIdCurrent == $value->id ? 'active' : '';
                $linkSubList = URL::linkCategory($value->id, $value->name);

                $ulList .= sprintf('<li class="parent %s"><a target = "%s" href="%s">%s</a></li>', $classActiveSubList, $item['type_open'], $linkSubList, $value->name);
            }
            $ulList .= '</ul>';
            $xhtmlMenu .= sprintf('<li class="parent" %s><a> %s </a> %s </li>', $classActiveSubList, $item['name'], $ulList);
            $xhtmlMenuMobile .= sprintf('<li class="menu_mm"><a href="%s">%s</a></li>', $linkMenu, $item['name']);
        }
    }
    if (session('userInfo')) {
        $xhtmlMenuUser = sprintf('<li><a href="%s">%s</a></li>', route('auth/logout'), 'Logout');
    } else {
        $xhtmlMenuUser = sprintf('<li><a href="%s">%s</a></li>', route('auth/login'), 'Login');
    }

    // $category = CategoryModel::find(1);
    // $categories = $category->descendants()->pluck('id');

    // $categories[] = $category->getKey();
    // $goods = CategoryModel::whereIn('id', $categories)->get();
    $categories = CategoryModel::withDepth()
        ->with('ancestors')
        ->get()
        ->toTree();
    // $categories = $categories[0];
    // dd($categories);

    $xhtmlMenu .= $xhtmlMenuUser . '</ul></nav>';
    $xhtmlMenuMobile .= $xhtmlMenuUser . '</ul></nav>';
}
// $categoryModel = new CategoryModel();
// $itemsCategory = $categoryModel->listItems(null, ['task' => 'news-list-items']);

// $xhtmlMenu = '';
// $xhtmlMenuMobile = '';

// if (count($itemsCategory) > 0) {

//     $xhtmlMenu = '<nav class="main_nav"><ul class="main_nav_list d-flex flex-row align-items-center justify-content-start">';
//     $xhtmlMenuMobile = '<nav class="menu_nav"><ul class="menu_mm">';
//     $categoryIdCurrent = Route::input('category_id');

//     foreach ($itemsCategory as $item) {

//         $link       =  URL::linkCategory($item['id'], $item['name']);
//         $classActive = ($categoryIdCurrent == $item['id']) ? 'class="active"' : '';

//         $xhtmlMenu .= sprintf('<li %s><a href="%s">%s</a></li>', $classActive, $link, $item['name']);
//         $xhtmlMenuMobile .= sprintf('<li class="menu_mm"><a href="%s">%s</a></li>', $link, $item['name']);
//     }

//     $xhtmlMenu .= sprintf('<li><a href="%s">Tin tức tổng hợp</a></li>', route('rss/index'));
//     $xhtmlMenuMobile .= sprintf('<li class="menu_mm"><a href="%s">Tin tức tổng hợp</a></li>', route('rss/index'));

//     if (session('userInfo')) {
//         $xhtmlMenuUser = sprintf('<li><a href="%s">%s</a></li>', route('auth/logout'), 'Logout');
//     }else {
//         $xhtmlMenuUser = sprintf('<li><a href="%s">%s</a></li>', route('auth/login'), 'Login');
//     }

//     $xhtmlMenu .= $xhtmlMenuUser . '</ul></nav>';
//     $xhtmlMenuMobile .= $xhtmlMenuUser . '</ul></nav>';
// }
@endphp

<header class="header">
    <table class="table">
        <thead class=>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Children</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($categories as $key => $category)
                <tr>
                    <td>
                        {{-- @dd($category) --}}
                        {{ $key + 1 }}
                    </td>
                    <td>
                        {{ $category->name }}
                    </td>
                    <td>
                        @foreach ($category->children as $item)
                            {{ $item->name }},
                        @endforeach

                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    {{-- @foreach ($category[0] as $child) --}}
    {{-- <div style="margin-left: 30px;"> </div> --}}
    {{-- <x-category-item :category="$child"> --}}
    {{-- @endforeach --}}
    <!-- Header Content -->
    <div class="header_content_container">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="header_content d-flex flex-row align-items-center justfy-content-start">
                        <div class="logo_container">
                            <a href="{!! route('home') !!}">
                                <div class="logo"><span>ZEND</span>VN</div>
                            </a>
                        </div>
                        <div class="header_extra ml-auto d-flex flex-row align-items-center justify-content-start">
                            <a href="#">
                                <div class="background_image"
                                    style="background-image:url({{ asset('news/images/zendvn-online.png') }});background-size: contain">
                                </div>

                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Header Navigation & Search -->
    <div class="header_nav_container" id="header">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="header_nav_content d-flex flex-row align-items-center justify-content-start">

                        <!-- Logo -->
                        <div class="logo_container">
                            <a href="#">
                                <div class="logo"><span>ZEND</span>VN</div>
                            </a>
                        </div>

                        <!-- Navigation -->
                        {!! $xhtmlMenu !!}

                        <!-- Hamburger -->
                        <div class="hamburger ml-auto menu_mm"><i class="fa fa-bars  trans_200 menu_mm"
                                aria-hidden="true"></i></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

<div class="menu d-flex flex-column align-items-end justify-content-start text-right menu_mm trans_400">
    <div class="menu_close_container">
        <div class="menu_close">
            <div></div>
            <div></div>
        </div>
    </div>

    {!! $xhtmlMenuMobile !!}


</div>
